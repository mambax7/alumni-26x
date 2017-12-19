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

include __DIR__ . '/header.php';

$moduleDirName = basename(__DIR__);
$main_lang     = '_MA_' . strtoupper($moduleDirName);
$myts          = MyTextSanitizer::getInstance();
$xoops         = Xoops::getInstance();
$alumni        = Alumni::getInstance();
$helper        = Xoops::getModuleHelper('alumni');
$moduleId      = $helper->getModule()->getVar('mid');

$groups = '3';
if (is_object($xoopsUser)) {
    $groups = $xoopsUser->getGroups();
}
//$gperm_handler = $xoops->getHandler('groupperm');
$perm_itemid = 0;
if (isset($_POST['item_id'])) {
    $perm_itemid = (int)$_POST['item_id'];
}
//If no access
if (!$gpermHandler->checkRight('' . $moduleDirName . '_view', $perm_itemid, $groups, $moduleId)) {
    $xoops->redirect(XOOPS_URL . '/index.php', 3, XoopsLocale::E_NO_ACCESS_PERMISSION);
    exit();
}
$prem_perm = '1';
if (!$gpermHandler->checkRight('' . $moduleDirName . '_premium', $perm_itemid, $groups, $moduleId)) {
    $prem_perm = '0';
}

include XOOPS_ROOT_PATH . "/modules/{$moduleDirName}/include/functions.php";

$cid = (int)$_GET['cid'];

$xoops->header('module:alumni/alumni_category.tpl');
Xoops::getInstance()->header();

//$xoTheme->addScript(ALUMNI_URL . '/media/jquery/jquery-1.8.3.min.js');
$xoTheme->addBaseScriptAssets('@jquery');
$xoTheme->addScript(ALUMNI_URL . '/media/jquery/tablesorter-master/js/jquery.tablesorter.js');
$xoTheme->addScript(ALUMNI_URL . '/media/jquery/tablesorter-master/addons/pager/jquery.tablesorter.pager.js');
$xoTheme->addScript(ALUMNI_URL . '/media/jquery/tablesorter-master/js/jquery.tablesorter.widgets.js');
$xoTheme->addScript(ALUMNI_URL . '/media/jquery/pager-custom-controls.js');
$xoTheme->addScript(ALUMNI_URL . '/media/jquery/myjs.js');
$xoTheme->addStylesheet(ALUMNI_URL . '/media/jquery/css/theme.blue.css');
$xoTheme->addStylesheet(ALUMNI_URL . '/media/jquery/tablesorter-master/addons/pager/jquery.tablesorter.pager.css');
$xoTheme->addScript(ALUMNI_URL . '/media/jquery/photo.js');
$default_sort = $xoops->getModuleConfig('' . $moduleDirName . '_csortorder');
$listing_sort = $xoops->getModuleConfig('' . $moduleDirName . '_lsortorder');

$cid = ($cid > 0) ? $cid : 0;

$xoops->tpl()->assign('add_from', AlumniLocale::ALUMNI_LISTINGS . ' ' . $xoopsConfig['sitename']);
$xoops->tpl()->assign('add_from_title', AlumniLocale::ALUMNI_LISTINGS);
$xoops->tpl()->assign('add_from_sitename', $xoopsConfig['sitename']);
if ($xoops->isUser()) {
    $xoops->tpl()->assign('add_listing', "<a href='listing.php?op=new_listing&amp;cid=$cid'>" . AlumniLocale::ADD_LISTING_2 . '</a>');
}
$cat_banner = $xoops->getBanner();
$xoops->tpl()->assign('cat_banner', $cat_banner);

$cat_code_place = $xoops->getModuleConfig('' . $moduleDirName . '_code_place');
$useExtraCode   = $xoops->getModuleConfig('' . $moduleDirName . '_use_code');
$useBanner      = $xoops->getModuleConfig('' . $moduleDirName . '_useBanner');
$catExtraCode   = $xoops->getModuleConfig('' . $moduleDirName . '_index_code');
$xoops->tpl()->assign('useExtraCode', $useExtraCode);
$xoops->tpl()->assign('useBanner', $useBanner);
$xoops->tpl()->assign('catExtraCode', '<html>' . $catExtraCode . '</html>');
$xoops->tpl()->assign('cat_code_place', $cat_code_place);

$categoriesHandler = $xoops->getModuleHandler('category', 'alumni');

$alumni      = Alumni::getInstance();
$groups      = $xoops->isUser() ? $xoops->user->getGroups() : '3';
$alumniIds   = $xoops->getHandlerGroupPermission()->getItemIds('alumni_view', $groups, $moduleId);
$catCriteria = new CriteriaCompo();
$catCriteria->add(new Criteria('cid', $cid, '='));
$catCriteria->add(new Criteria('cid', '(' . implode(', ', $alumniIds) . ')', 'IN'));
$catCriteria->setOrder('' . $xoops->getModuleConfig('' . $moduleDirName . '_csortorder') . '');
$numcat        = $categoriesHandler->getCount();
$categoryArray = $categoriesHandler->getAll($catCriteria);

$catObj = $categoriesHandler->get($cid);

$homePath = "<a href='" . ALUMNI_URL . "/index.php'>" . XoopsLocale::MAIN . '</a>&nbsp;:&nbsp;';
$itemPath = $catObj->getVar('title');
$path     = '';
$myParent = $catObj->getVar('pid');

$catpathCriteria = new CriteriaCompo();
$catpathCriteria->add(new Criteria('cid', $myParent, '='));
$catpathArray = $categoriesHandler->getAll($catpathCriteria);
foreach (array_keys($catpathArray) as $i) {
    $mytitle = $catpathArray[$i]->getVar('title');
}

if (0 != $myParent) {
    $path = "<a href='" . ALUMNI_URL . '/categories.php?cid=' . $catpathArray[$i]->getVar('cid') . "'>" . $catpathArray[$i]->getVar('title') . '</a>&nbsp;:&nbsp;';
}
$path = "{$homePath}{$path}{$itemPath}";
$path = str_replace('&nbsp;:&nbsp;', " <img src='" . XOOPS_URL . "/modules/{$moduleDirName}/assets/images/arrow.gif" . "' style='border-width: 0px;' alt=''> ", $path);

$xoops->tpl()->assign('category_path', $path);

unset($catCriteria);

foreach (array_keys($categoryArray) as $i) {
    $cat_id     = $categoryArray[$i]->getVar('cid');
    $cat_pid    = $categoryArray[$i]->getVar('pid');
    $title      = $categoryArray[$i]->getVar('title', 'e');
    $scaddress  = $categoryArray[$i]->getVar('scaddress');
    $scaddress2 = $categoryArray[$i]->getVar('scaddress2');
    $sccity     = $categoryArray[$i]->getVar('sccity');
    $scstate    = $categoryArray[$i]->getVar('scstate');
    $sczip      = $categoryArray[$i]->getVar('sczip');
    $scphone    = $categoryArray[$i]->getVar('scphone');
    $scfax      = $categoryArray[$i]->getVar('scfax');
    $scmotto    = $categoryArray[$i]->getVar('scmotto');
    $scurl      = $categoryArray[$i]->getVar('scurl');
    $img        = $categoryArray[$i]->getVar('img');
    $scphoto    = $categoryArray[$i]->getVar('scphoto');
    $order      = $categoryArray[$i]->getVar('ordre');

    $xoops->tpl()->assign('moderated', '');
    if (1 == $xoops->getModuleConfig('alumni_moderated')) {
        $xoops->tpl()->assign('moderated', '1');
    }
    $xoops->tpl()->assign('lang_subcat', '');
    if (1 == $xoops->getModuleConfig('alumni_showsubcat')) {
        $subcatCriteria = new CriteriaCompo();
        $subcatCriteria->add(new Criteria('pid', $cid, '='));
        $subcatCriteria->add(new Criteria('cid', '(' . implode(', ', $alumniIds) . ')', 'IN'));
        $subcatCriteria->setOrder('' . $xoops->getModuleConfig('' . $moduleDirName . '_csortorder') . '');
        $numsubcat   = $categoriesHandler->getCount($subcatCriteria);
        $subcatArray = $categoriesHandler->getAll($subcatCriteria);
        unset($subcatCriteria);
        foreach (array_keys($subcatArray) as $j) {
            $subcat_id     = $subcatArray[$j]->getVar('cid');
            $subcat_pid    = $subcatArray[$j]->getVar('pid');
            $sub_cat_title = $subcatArray[$j]->getVar('title', 'e');

            $listingHandler  = $xoops->getModuleHandler('listing', 'alumni');
            $listingCriteria = new CriteriaCompo();
            $listingCriteria->add(new Criteria('cid', $subcat_id, '='));
            $listingCriteria->add(new Criteria('valid', 1, '='));
            $listingCriteria->add(new Criteria('cid', '(' . implode(', ', $alumniIds) . ')', 'IN'));
            $alumni_count = $listingHandler->getCount($listingCriteria);
            $xoops->tpl()->append('subcategories', ['title' => $sub_cat_title, 'id' => $subcat_id, 'totallinks' => $alumni_count, 'count' => $numsubcat]);
        }
        $xoops->tpl()->assign('showsubcat', true);
    }
    $xoops->tpl()->assign('subcats', $numsubcat);
    $school_name = $myts->htmlSpecialChars($title);
    $xoops->tpl()->assign('scaddress', $scaddress);
    $xoops->tpl()->assign('scaddress2', $scaddress2);
    $xoops->tpl()->assign('sccity', $sccity);
    $xoops->tpl()->assign('scstate', $scstate);
    $xoops->tpl()->assign('sczip', $sczip);
    $xoops->tpl()->assign('scphone', $scphone);
    $xoops->tpl()->assign('scfax', $scfax);
    $xoops->tpl()->assign('scmotto', $scmotto);
    $xoops->tpl()->assign('scurl', $scurl);
    $xoops->tpl()->assign('top_scphoto', "<img src='" . XOOPS_URL . "/uploads/{$moduleDirName}/photos/school_photos/$scphoto' align='middle' alt='$school_name'>");
    $xoops->tpl()->assign('head_scphone', AlumniLocale::SCPHONE);
    $xoops->tpl()->assign('head_scfax', AlumniLocale::SCFAX);
    $xoops->tpl()->assign('web', AlumniLocale::WEB);
    $xoops->tpl()->assign('school_name', $title);
    $xoops->tpl()->assign('title', $title);
    $xoops->tpl()->assign('module_name', $xoopsModule->getVar('name'));
    $xoops->tpl()->assign('nav_subcount', '');
    $xoops->tpl()->assign('trows', '');
    $xoops->tpl()->assign('school_listings', '');
    $xoops->tpl()->assign('sub_listings', '');
    $xoops->tpl()->assign('show_nav', false);
    $xoops->tpl()->assign('no_listings', AlumniLocale::NO_LISTINGS);

    $listingHandler  = $xoops->getModuleHandler('listing', 'alumni');
    $listingCriteria = new CriteriaCompo();
    $listingCriteria->add(new Criteria('cid', $cid, '='));
    $listingCriteria->add(new Criteria('valid', 1, '='));
    $listingCriteria->add(new Criteria('cid', '(' . implode(', ', $alumniIds) . ')', 'IN'));
    $numrows = $listingHandler->getCount($listingCriteria);

    $listingArray = $listingHandler->getAll($listingCriteria);
    unset($listingCriteria);
    foreach (array_keys($listingArray) as $j) {
        $lid        = $listingArray[$j]->getVar('lid');
        $cid        = $listingArray[$j]->getVar('cid');
        $name       = $listingArray[$j]->getVar('name');
        $mname      = $listingArray[$j]->getVar('mname');
        $lname      = $listingArray[$j]->getVar('lname');
        $school     = $listingArray[$j]->getVar('school');
        $year       = $listingArray[$j]->getVar('year');
        $studies    = $listingArray[$j]->getVar('studies');
        $activities = $listingArray[$j]->getVar('activities');
        $extrainfo  = $listingArray[$j]->getVar('extrainfo');
        $occ        = $listingArray[$j]->getVar('occ');
        $date       = $listingArray[$j]->getVar('date');
        $email      = $listingArray[$j]->getVar('email');
        $submitter  = $listingArray[$j]->getVar('submitter');
        $usid       = $listingArray[$j]->getVar('usid');
        $town       = $listingArray[$j]->getVar('town');
        $valid      = $listingArray[$j]->getVar('valid');
        $photo      = $listingArray[$j]->getVar('photo');
        $photo2     = $listingArray[$j]->getVar('photo2');
        $view       = $listingArray[$j]->getVar('view');

        $trows = $numrows;

        $cat_sort = $xoops->getModuleConfig('' . $moduleDirName . '_csortorder');

        $xoops->tpl()->assign('xoops_pagetitle', $title);
        $xoops->tpl()->assign('nav_subcount', $trows);
        $xoops->tpl()->assign('trows', $trows);
        $xoops->tpl()->assign('title', $title);
        $xoops->tpl()->assign('lang_subcat', AlumniLocale::SUBCAT_AVAIL);

        if ($trows > '0') {
            $xoops->tpl()->assign('last_head', AlumniLocale::THE . ' ' . $xoops->getModuleConfig('' . $moduleDirName . '_newalumni') . ' ' . AlumniLocale::LASTADD);
            $xoops->tpl()->assign('last_head_name', AlumniLocale::NAME_2);
            $xoops->tpl()->assign('last_head_mname', AlumniLocale::MNAME_2);
            $xoops->tpl()->assign('last_head_lname', AlumniLocale::LNAME_2);
            $xoops->tpl()->assign('last_head_school', AlumniLocale::SCHOOL_2);
            $xoops->tpl()->assign('class_of', AlumniLocale::CLASS_OF_2);
            $xoops->tpl()->assign('last_head_studies', AlumniLocale::STUDIES_2);
            $xoops->tpl()->assign('last_head_occ', AlumniLocale::OCC_2);
            $xoops->tpl()->assign('last_head_activities', AlumniLocale::ACTIVITIES_2);
            $xoops->tpl()->assign('last_head_date', XoopsLocale::DATE);
            $xoops->tpl()->assign('last_head_local', AlumniLocale::TOWN_2);
            $xoops->tpl()->assign('last_head_views', AlumniLocale::HITS);
            $xoops->tpl()->assign('last_head_photo', AlumniLocale::PHOTO);
            $xoops->tpl()->assign('last_head_photo2', AlumniLocale::PHOTO2);
            $xoops->tpl()->assign('cat', $cid);

            $a_item     = [];
            $name       = $myts->undoHtmlSpecialChars($name);
            $mname      = $myts->undoHtmlSpecialChars($mname);
            $lname      = $myts->undoHtmlSpecialChars($lname);
            $school     = $myts->undoHtmlSpecialChars($school);
            $year       = $myts->htmlSpecialChars($year);
            $studies    = $myts->htmlSpecialChars($studies);
            $activities = $myts->htmlSpecialChars($activities);
            $occ        = $myts->htmlSpecialChars($occ);
            $town       = $myts->undoHtmlSpecialChars($town);

            $useroffset    = '';
            $a_item['new'] = '';

            $newcount  = $xoops->getModuleConfig('' . $moduleDirName . '_countday');
            $startdate = (time() - (86400 * $newcount));
            if ($startdate < $date) {
                $newitem       = '<img src="' . XOOPS_URL . "/modules/{$moduleDirName}/assets/images/newred.gif\">";
                $a_item['new'] = $newitem;
            }
            if ($xoopsUser) {
                $timezone = $xoopsUser->timezone();
                if (isset($timezone)) {
                    $useroffset = $xoopsUser->timezone();
                } else {
                    $useroffset = $xoopsConfig['default_TZ'];
                }
            }
            $date = ($useroffset * 3600) + $date;
            $date = XoopsLocale::formatTimestamp($date, 's');
            if ($xoopsUser) {
                if ($xoopsUser->isAdmin()) {
                    $a_item['admin'] = "<a href='admin/alumni.php?op=edit_listing&amp;lid=$lid&amp;cid=$cid'><img src='images/modif.gif' border=0 alt=\"" . AlumniLocale::MODADMIN . '"></a>';
                }
            }

            $a_item['name']       = "<a href='listing.php?lid=$lid'><b>$name&nbsp;$mname&nbsp;$lname</b></a>";
            $a_item['school']     = $school;
            $a_item['year']       = $year;
            $a_item['studies']    = $studies;
            $a_item['occ']        = $occ;
            $a_item['activities'] = $activities;
            $a_item['date']       = $date;
            $a_item['local']      = '';
            if ($town) {
                $a_item['local'] .= $town;
            }
            $cat = addslashes($cid);
            if ($photo) {
                $a_item['photo'] = "<a href=\"javascript:CLA('display-image.php?lid=$lid')\"><img src=\"images/photo.gif\" border=\"0\" width=\"15\" height=\"11\" alt='" . AlumniLocale::PHOTO_AVAILABLE . "'></a>";
            } else {
                $a_item['photo'] = '';
            }
            $a_item['views'] = $view;
            $xoops->tpl()->append('items', $a_item);
        } else {
            $xoops->tpl()->assign('no_listings', AlumniLocale::E_NO_LISTING);
        }
    }
}

Xoops::getInstance()->footer();
