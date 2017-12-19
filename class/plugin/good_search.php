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
 * alumni module
 * Edited by John Mordo (jlm69)
 * @copyright       XOOPS Project https://xoops.org/
 * @license         GNU GPL 2 (http://www.gnu.org/licenses/old-licenses/gpl-2.0.html)
 * @since           2.6.0
 * @author          Mage Grégory (AKA Mage)
 * @version         $Id: $
 */
use Xoops\Core\Request;
use Xoops\Module\Plugin\PluginAbstract;
use Xmf\Metagen;

/**
 * Class AlumniSearchPlugin
 */
class AlumniSearchPlugin extends PluginAbstract implements SearchPluginInterface
{
    /**
     * @param string[] $queries
     * @param string   $andor
     * @param int      $limit
     * @param int      $start
     * @param \type    $userid
     * @return array
     */
    public function search($queries, $andor, $limit, $start, $userid)
    {
        $xoops     = Xoops::getInstance();
        $alumni  = Alumni::getInstance();
        $myts    = MyTextSanitizer::getInstance();
        $by_cat  = Request::getInt('by_cat', '');
        $andor = Request::getWord('andor', 'AND');
        $queries = [];
        $query   = Request::getString('query', '');
        $start   = Request::getInt('start', '0');

        $helper          = $xoops->getModuleHelper('alumni');
        $module_id       = $helper->getModule()->getVar('mid');
        $listingHandler = $helper->getHandler('listing');
        $groups          = $xoops->getUserGroups();
        $alumni_ids      = $xoops->getHandlerGroupperm()->getItemIds('alumni_view', $groups, $module_id);
        $all_ids = implode(', ', $alumni_ids);
    
        $criteria        = new CriteriaCompo();
        $criteria->add(new Criteria('valid', 1, '='));
        //  $criteria->add(new Criteria('date', time(), '<='));
        $criteria->add(new Criteria('cid', '('.$all_ids.')', 'IN'));
        if (0 != $userid) {
            $criteria->add(new Criteria('usid', $userid, '='));
        }
        if ($by_cat) {
            $criteria->add(new Criteria('cid', $by_cat, '='));
        }

        $queries = [$query];
        $queries = implode('+', $queries);

        $count = 0;
        $i     = 0;

        $criteria->add(new Criteria('name', '%' . $queries . '%', 'LIKE'), 'AND');
        $criteria->add(new Criteria('mname', '%' . $queries . '%', 'LIKE'), 'OR');
        $criteria->add(new Criteria('lname', '%' . $queries . '%', 'LIKE'), 'OR');
        $criteria->add(new Criteria('school', '%' . $queries . '%', 'LIKE'), 'OR');
        $criteria->add(new Criteria('year', '%' . $queries . '%', 'LIKE'), 'OR');

        $criteria->setLimit($limit);
        $criteria->setSort('date');
        $criteria->setOrder('DESC');
        $criteria->setStart($start);

        $numrows     = $listingHandler->getCount();
        $this_search = $listingHandler->getall($criteria);

        $ret = [];
        $k   = 0;

        foreach ($this_search as $obj) {
            $ret[$k]['image'] = 'images/cat/default.gif';
            $ret[$k]['link']  = 'listing.php?lid=' . $obj->getVar('lid') . '';
            $ret[$k]['title'] = $obj->getVar('name') . ' ' . $obj->getVar('mname') . ' ' . $obj->getVar('lname') . '   ---   ' . $obj->getVar('school') . '
		---   ' . $obj->getVar('year');
            $ret[$k]['time']  = $obj->getVar('date');
            $ret[$k]['uid']   = $obj->getVar('usid');
            $k++;
        }

        return $ret;
    }
}
