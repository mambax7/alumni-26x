<?php
/*
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit authors.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*/
/**
 * Alumni module for Xoops
 *
 * @copyright       XOOPS Project http://xoops.org/
 * @license         GPL 2.0 or later
 * @package         alumni
 * @since           2.6.x
 * @author          John Mordo (jlm69)
 */

use Xoops\Core\Database\Connection;
use Xoops\Core\Kernel\XoopsObject;
use Xoops\Core\Kernel\XoopsPersistableObjectHandler;
use Xoops\Core\Kernel\Criteria;
use Xoops\Core\Kernel\CriteriaCompo;

class AlumniCategory extends XoopsObject {

    public $alumni = null;

    /**
     * @var array
     */
    public $_categoryPath = false;

    //Constructor
    public function __construct() {
        $this->alumni = Alumni::getInstance();
        $this->initVar('cid', XOBJ_DTYPE_INT, null, false, 11);
        $this->initVar('pid', XOBJ_DTYPE_INT, null, false, 5);
        $this->initVar('title', XOBJ_DTYPE_TXTBOX, null, false, 255);
        $this->initVar('scaddress', XOBJ_DTYPE_TXTBOX, null, false, 255);
        $this->initVar('scaddress2', XOBJ_DTYPE_TXTBOX, null, false, 255);
        $this->initVar('sccity', XOBJ_DTYPE_TXTBOX, null, false, 255);
        $this->initVar('scstate', XOBJ_DTYPE_TXTBOX, null, false, 255);
        $this->initVar('sczip', XOBJ_DTYPE_TXTBOX, null, false, 255);
        $this->initVar('scphone', XOBJ_DTYPE_TXTBOX, null, false, 255);
        $this->initVar('scfax', XOBJ_DTYPE_TXTBOX, null, false, 255);
        $this->initVar('scmotto', XOBJ_DTYPE_TXTBOX, null, false, 255);
        $this->initVar('scurl', XOBJ_DTYPE_TXTBOX, null, false, 255);
        $this->initVar('img', XOBJ_DTYPE_TXTBOX, null, false, 255);
        $this->initVar('scphoto', XOBJ_DTYPE_TXTBOX, null, false, 255);
        $this->initVar('ordre', XOBJ_DTYPE_INT, null, false, 5);
    }

    public function getPathFromId($id = null, $path = '') {
        $id   = isset($id) ? (int)($id) : $this->cid;
        $myts = MyTextSanitizer::getInstance();
        $name = $myts->htmlSpecialChars($this->title);
        $path = "/{$name}{$path}";
        if ($this->pid != 0) {
            $path = $this->getPathFromId($this->pid, $path);
        }
        return $path;
    }
    
    public function getGroups_view()
    {
        return $this->alumni->getPermissionHandler()->getGrantedGroupsById('alumni_view', $this->getVar('cid'));
    }
    }


class AlumniCategoryHandler extends XoopsPersistableObjectHandler {

    public $alumni = null;

    public function __construct(Connection $db = null) {
	$this->alumni = Alumni::getInstance();
        parent::__construct($db, 'alumni_category', 'alumnicategory', 'cid', 'title');
    }

    public function getSubCatArray($by_cat, $level, $cat_array, $cat_result) {
        global $theresult;
        $spaces = '';
        for ($j = 0; $j < $level; $j++) {
            $spaces .= '--';
        }
        $theresult[$by_cat['cid']] = $spaces . $by_cat['title'];
        if (isset($cat_array[$by_cat['cid']])) {
            $level = $level + 1;
            foreach ($cat_array[$by_cat['cid']] as $cat) {
                $this->getSubCatArray($cat, $level, $cat_array, $cat_result);
            }
        }
    }

    public function getCategoriesCount($pid = 0)
    {
        $xoops = Xoops::getInstance();
        if ($pid == -1) {
            return $this->getCount();
        }
        $criteria = new CriteriaCompo();
        if (isset($pid) && ($pid != -1)) {
            $criteria->add(new criteria('pid', $pid));
            if (!$xoops->userIsAdmin) {
                $categoriesGranted = $this->alumni->getPermissionHandler()->getGrantedItems('alumni_view');
                if (count($categoriesGranted) > 0) {
                    $criteria->add(new Criteria('cid', '(' . implode(',', $categoriesGranted) . ')', 'IN'));
                } else {
                    return 0;
                }
            }
        }
        return $this->getCount($criteria);
    }

    /**
     * @return array
     */
    public function &getCategoriesForSearch() {
        global $theresult, $xoops, $alumni;
        $xoops     = Xoops::getInstance();
        $module_id = $alumni->getModule()->mid();
        $ret       = array();
        $criteria  = new CriteriaCompo();
        $criteria->setSort('cid');
        $criteria->setOrder('ASC');
        if (!$xoops->isAdmin()) {
            $gperm_handler        = $xoops->gethandler('groupperm');
            $groups               = is_object($xoops->isUser()) ? $$xoops->isUser()->getGroups() : '3';
            $allowedCategoriesIds = $gperm_handler->getItemIds('alumni_view', $groups, $module_id);
                $criteria->add(new Criteria('cid', '(' . implode(',', $allowedCategoriesIds) . ')', 'IN'));
        }
        $categories = $this->getAll($criteria, array('cid', 'pid', 'title'), false, false);
        if (count($categories) == 0) {
            return $ret;
        }
        $cat_array = array();
        foreach ($categories as $cat) {
            $cat_array[$cat['pid']][$cat['cid']] = $cat;
        }

        if (!isset($cat_array[0])) {
            return $ret;
        }
        $cat_result = array();
        foreach ($cat_array[0] as $thecat) {
            $level = 0;
            $this->getSubCatArray($thecat, $level, $cat_array, $cat_result);
        }

        return $theresult;
    }
}
