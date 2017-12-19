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
use Xoops\Module\Plugin\PluginAbstract;
use Xmf\Metagen;
use Xoops\Core\Request;

class AlumniSearchPlugin extends PluginAbstract implements SearchPluginInterface
{

    public function search($queryArray, $andor, $limit, $offset, $userid)
    {
$xoops           = Xoops::getInstance();
$helper          = $xoops->getModuleHelper('alumni');
$module_id       = $helper->getModule()->getVar('mid');
$listing_Handler = $helper->getHandler('listing');
$groups          = $xoops->getUserGroups();
$alumni_ids      = $xoops->getHandlerGroupPermission()->getItemIds('alumni_view', $groups, $module_id);
$all_ids = implode(', ', $alumni_ids);
    
	$by_cat  = Request::getInt('by_cat', 0);
        $andor = strtolower($andor)=='and' ? 'and' : 'or';

        $qb = \Xoops::getInstance()->db()->createXoopsQueryBuilder();
        $eb = $qb->expr();
        $qb ->select('DISTINCT *')
            ->fromPrefix('alumni_listing')
            ->where($eb->eq('valid', '1'))
            ->orderBy('lname', 'DESC')
            ->setFirstResult($offset)
            ->setMaxResults($limit);
        if (is_array($queryArray) && !empty($queryArray)) {
            $queryParts = [];
            foreach ($queryArray as $i => $q) {
                $query = ':query' . $i;
                $qb->setParameter($query, '%' . $q . '%', \PDO::PARAM_STR);
                $queryParts[] = $eb -> orX(
                    $eb->like('name', $query),
                    $eb->like('mname', $query),
                    $eb->like('lname', $query),
                    $eb->like('school', $query),
                    $eb->like('year', $query)
                );
            }

	    $qb->andWhere($eb->in('cid', [$all_ids]));
            if ($by_cat) {
	    $qb->andWhere($eb->eq('cid', $by_cat));
            }
            if ($andor == 'and') {
                $qb->andWhere(call_user_func_array([$eb, "andX"], $queryParts));
            } else {
                $qb->andWhere(call_user_func_array([$eb, "orX"], $queryParts));
            }
        } else {
            $qb->setParameter(':uid', (int) $userid, \PDO::PARAM_INT);
            $qb->andWhere($eb->eq('usid', ':uid'));
        }

        $myts = MyTextSanitizer::getInstance();
        $items = [];
        $result = $qb->execute();
        while ($myrow = $result->fetch(\PDO::FETCH_ASSOC)) {
            $items[] = [
                'title' =>  $myrow['name']." ".$myrow['mname']." ".$myrow['lname']."   ---   ".$myrow['school']." ---   ".$myrow['year'],
                'link' => "listing.php?lid=" . $myrow["lid"],
                'time' => $myrow['date'],
                'uid' => $myrow['usid'],
                'image' => 'images/cat/default.gif',
            ];
        }
        return $items;
    }
}
