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
 * @copyright       XOOPS Project https://xoops.org/
 * @license         GPL 2.0 or later
 * @package         alumni
 * @since           2.6.x
 * @author          John Mordo (jlm69)
 */

use Xoops\Core\Database\Connection;
use Xoops\Core\Kernel\XoopsObject;
use Xoops\Core\Kernel\XoopsPersistableObjectHandler;

//defined('XOOPS_ROOT_PATH') or exit('XOOPS root path not defined');
$xoops = Xoops::getInstance();

/**
 * Class AlumniListing
 */
class AlumniListing extends XoopsObject
{
    /**
     * @var Alumni
     * @access public
     */
    public $alumni = null;

    /**
     * Constructor
     */
    public function __construct()
    {
        global $xoops;
        $this->db = $xoops->db();
        $this->initVar('lid', XOBJ_DTYPE_INT, null, false, 11);
        $this->initVar('cid', XOBJ_DTYPE_INT, null, false, 11);
        $this->initVar('name', XOBJ_DTYPE_TXTBOX, null, false);
        $this->initVar('mname', XOBJ_DTYPE_TXTBOX, null, false);
        $this->initVar('lname', XOBJ_DTYPE_TXTBOX, null, false);
        $this->initVar('school', XOBJ_DTYPE_TXTBOX, null, false);
        $this->initVar('year', XOBJ_DTYPE_TXTBOX, null, false);
        $this->initVar('studies', XOBJ_DTYPE_TXTBOX, null, false);
        $this->initVar('activities', XOBJ_DTYPE_TXTAREA, null, false);
        $this->initVar('extrainfo', XOBJ_DTYPE_TXTAREA, null, false);
        $this->initVar('occ', XOBJ_DTYPE_TXTBOX, null, false);
        $this->initVar('date', XOBJ_DTYPE_INT, null, false, 10);
        $this->initVar('email', XOBJ_DTYPE_TXTBOX, null, false);
        $this->initVar('submitter', XOBJ_DTYPE_TXTBOX, null, false);
        $this->initVar('usid', XOBJ_DTYPE_TXTBOX, null, false);
        $this->initVar('town', XOBJ_DTYPE_TXTBOX, null, false);
        $this->initVar('valid', XOBJ_DTYPE_INT, null, false, 3);
        $this->initVar('photo', XOBJ_DTYPE_TXTBOX, null, false);
        $this->initVar('photo2', XOBJ_DTYPE_TXTBOX, null, false);
        $this->initVar('view', XOBJ_DTYPE_TXTBOX, null, false);
    }

    /**
     * @return mixed
     */
    public function get_new_id()
    {
        $xoops  = Xoops::getInstance();
        $new_id = $xoops->db()->getInsertId();

        return $new_id;
    }

    /**
     * @return mixed
     */
    public function updateCounter()
    {
        return $this->updateCounter($this->getVar('lid'));
    }
}

/**
 * Class AlumniListingHandler
 */
class AlumniListingHandler extends XoopsPersistableObjectHandler
{
    /**
     * @param null|Connection|XoopsDatabase $db
     */
    public function __construct(Connection $db = null)
    {
        parent::__construct($db, 'alumni_listing', 'alumnilisting', 'lid', 'title');
    }

    /**
     * @param int    $start
     * @param int    $limit
     * @param string $sort
     * @param string $order
     * @return array
     */
    public function getListingPublished($start = 0, $limit = 0, $sort = 'date', $order = 'ASC')
    {
        $helper   = Alumni::getInstance();
        $xoops    = $helper->xoops();
        $moduleId = $helper->getModule()->getVar('mid');
        // get permitted id
        $groups    = $xoops->isUser() ? $xoops->user->getGroups() : '3';
        $alumniIds = $helper->getGrouppermHandler()->getItemIds('alumni_view', $groups, $moduleId);
        // criteria
        $criteria = new CriteriaCompo();
        $criteria->add(new Criteria('valid', 1, '='));
        $criteria->add(new Criteria('cid', '(' . implode(', ', $alumniIds) . ')', 'IN'));
        $criteria->setSort($sort);
        $criteria->setOrder($order);
        $criteria->setStart($start);
        $criteria->setLimit($limit);

        return parent::getAll($criteria);
    }

    /**
     * @param null $keys
     * @param null $format
     * @param null $maxDepth
     * @return mixed
     */
    public function getValues($keys = null, $format = null, $maxDepth = null)
    {
        $page             = Page::getInstance();
        $ret              = parent::getValues($keys, $format, $maxDepth);
        $ret['rating']    = number_format($this->getVar('rating'), 1);
        $ret['lid']       = $this->getVar('lid');
        $ret['name']      = $this->getVar('name');
        $ret['mname']     = $this->getVar('mname');
        $ret['lname']     = $this->getVar('lname');
        $ret['school']    = $this->getVar('school');
        $ret['year']      = $this->getVar('year');
        $ret['submitter'] = $this->getVar('submitter');
        $ret['date']      = $this->getVar('date');

        return $ret;
    }

    /**
     * @param int    $start
     * @param int    $limit
     * @param string $sort
     * @param string $order
     * @return int
     */
    public function countAlumni($start = 0, $limit = 0, $sort = 'date', $order = 'ASC')
    {
        $criteria = new CriteriaCompo();
        $criteria->setSort($sort);
        $criteria->setOrder($order);
        $criteria->setStart($start);
        $criteria->setLimit($limit);

        return parent::getCount($criteria);
    }

    /**
     * @param $lid
     * @return bool
     */
    public function updateCounter($lid)
    {
        $xoops      = Xoops::getInstance();
        $listingObj = $this->get($lid);
        if (!is_object($listingObj)) {
            return false;
        }
        $listingObj->setVar('view', $listingObj->getVar('view', 'n') + 1);
        $this->insert($listingObj, true);

        return true;
    }
}
