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

defined('XOOPS_ROOT_PATH') || exit('XOOPS root path not defined');

include_once dirname(__DIR__) . '/include/common.php';

/**
 * @param $options
 * @return array
 */

function alumni_show($options) {

$block       = [];
$myts        = MyTextSanitizer::getInstance();
$blockDirName = basename(dirname(__DIR__));

$xoops           = Xoops::getInstance();
$helper          = $xoops->getModuleHelper('alumni');
$module_id       = $helper->getModule()->getVar('mid');
$listingHandler = $helper->getHandler('listing');
$groups          = $xoops->getUserGroups();
$alumni_ids      = $xoops->getHandlerGroupPermission()->getItemIds('alumni_view', $groups, $module_id);
    $all_ids = implode(', ', $alumni_ids);

	$criteria        = new CriteriaCompo();
	$criteria->add(new Criteria('valid', 1, '='));
	$criteria->add(new Criteria('cid', '('.$all_ids.')', 'IN'));
	$criteria->setLimit($options[1]);
	$criteria->setSort('date');
	$criteria->setOrder('DESC');
	$block_listings = $listingHandler->getall($criteria);

    foreach (array_keys($block_listings) as $i) {

        $name   = $block_listings[$i]->getVar('name');
        $mname  = $block_listings[$i]->getVar('mname');
        $lname  = $block_listings[$i]->getVar('lname');
        $school = $block_listings[$i]->getVar('school');
        $year   = $block_listings[$i]->getVar('year');
        $view   = $block_listings[$i]->getVar('view');
        
	$a_item = [];
        $a_item['school'] = $school;
        $a_item['link']   = '<a href="' . XOOPS_URL . "/modules/{$blockDirName}/listing.php?lid=" . addslashes($block_listings[$i]->getVar('lid')) . "\"><b>$year&nbsp;-&nbsp;$name $mname $lname</b><br></a>";

        $block['items'][] = $a_item;
    }
    $block['lang_title'] = AlumniLocale::BLOCKS_ITEM;
    $block['lang_date']  = AlumniLocale::BLOCKS_DATE;
    $block['link']       = "<a href=\"" . XOOPS_URL . "/modules/{$blockDirName}/index.php\"><b>" . AlumniLocale::BLOCKS_ALL_LISTINGS . "</b></a></div>";

    return $block;
}

/**
 * @param $options
 * @return string
 */


function alumni_edit($options) {

    $form = AlumniLocale::BLOCKS_ORDER . "&nbsp;<select name='options[]'>";
    $form .= "<option value='date'";
    if ($options[0] == 'date') {
        $form .= " selected='selected'";
    }
    $form .= '>' . AlumniLocale::BLOCKS_DATE . "</option>\n";
    $form .= "<option value='view'";
    if ($options[0] == 'view') {
        $form .= " selected='selected'";
    }
    $form .= '>' . AlumniLocale::BLOCKS_HITS . '</option>';
    $form .= "</select>\n";
    $form .= '&nbsp;' . AlumniLocale::BLOCKS_DISPLAY . "&nbsp;<input type='text' name='options[]' value='" . $options[1] . "'/>&nbsp;" . AlumniLocale::BLOCKS_LISTINGS;
    $form .= "&nbsp;<br><br>" . AlumniLocale::BLOCKS_LENGTH . "&nbsp;<input type='text' name='options[]' value='" . $options[2] . "'/>&nbsp;" . AlumniLocale::BLOCKS_CHARS . '<br><br>';

    return $form;
}
