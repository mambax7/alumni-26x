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

use Xoops\Core\Request;

include __DIR__ . '/header.php';

$moduleDirName = basename(__DIR__);
$main_lang = '_MA_' . strtoupper($moduleDirName);
$myts      = MyTextSanitizer::getInstance();
$xoops     = Xoops::getInstance();
$module_id = $xoopsModule->getVar('mid');

if (is_object($xoopsUser)) {
    $groups = $xoopsUser->getGroups();
} else {
    $groups = '3';
}
//$gperm_handler = $xoops->getHandler('groupperm');
if (isset($_POST['item_id'])) {
    $perm_itemid = (int)($_POST['item_id']);
} else {
    $perm_itemid = 0;
}
//If no access
if (!$gpermHandler->checkRight('' . $moduleDirName . '_view', $perm_itemid, $groups, $module_id)) {
    $xoops->redirect(XOOPS_URL . '/index.php', 3, XoopsLocale::E_NO_ACCESS_PERMISSION);
    exit();
}
if (!$gpermHandler->checkRight('' . $moduleDirName . '_premium', $perm_itemid, $groups, $module_id)) {
    $prem_perm = '0';
} else {
    $prem_perm = '1';
}
$lid = Request::getInt('lid', 0);
$xoops->header('module:alumni/alumni_item.tpl');
Xoops::getInstance()->header();

$op = Request::getCmd('op', 'list');

switch ($op) {
    case 'list':
    default:
        $listingHandler = $xoops->getModuleHandler('listing', 'alumni');

        $alumni     = Alumni::getInstance();
        $helper          = $xoops->getModuleHelper('alumni');
	$module_id       = $helper->getModule()->getVar('mid');
        $listingObj = $listingHandler->get($lid);

        $categoriesHandler = $xoops->getModuleHandler('category', 'alumni');
        $catObj                    = $categoriesHandler->get($listingObj->getVar('cid'));

        $homePath         = "<a href='" . ALUMNI_URL . "/index.php'>" . XoopsLocale::MAIN . "</a>&nbsp;:&nbsp;";
        $itemPath         = "<a href='" . ALUMNI_URL . "/categories.php?cid=" . $catObj->getVar("cid") . "'>" . $catObj->getVar("title") . "</a>";
        $path             = '';
        $myParent         = $catObj->getVar('pid');
        $catpath_criteria = new CriteriaCompo();
        $catpath_criteria->add(new Criteria('cid', $myParent, '='));
        $catpath_arr = $categoriesHandler->getAll($catpath_criteria);
        foreach (array_keys($catpath_arr) as $i) {
            $mytitle = $catpath_arr[$i]->getVar('title');
        }

        if ($myParent != 0) {
            $path = "<a href='" . ALUMNI_URL . "/categories.php?cid=" . $catpath_arr[$i]->getVar("cid") . "'>" . $catpath_arr[$i]->getVar("title") . "</a>&nbsp;:&nbsp;{$path}";
        }

        $path = "{$homePath}{$path}{$itemPath}";
        $path = str_replace("&nbsp;:&nbsp;", " <img src='" . XOOPS_URL . "/modules/alumni/images/arrow.gif" . "' style='border-width: 0px;' alt=''> ", $path);

        $xoops->tpl()->assign('category_path', $path);

	$groups          = $xoops->isUser() ? $xoops->user->getGroups() : '3';
	$alumni_ids      = $xoops->getHandlerGroupPermission()->getItemIds('alumni_view', $groups, $module_id);
        $criteria   = new CriteriaCompo();
        $criteria->add(new Criteria('lid', $lid, '='));
        $criteria->add(new Criteria('cid', '(' . implode(', ', $alumni_ids) . ')', 'IN'));
        $numrows     = $listingHandler->getCount();
        $listingArray = $listingHandler->getAll($criteria);

        foreach (array_keys($listingArray) as $i) {
            $lid        = $listingArray[$i]->getVar('lid');
            $cid        = $listingArray[$i]->getVar('cid');
            $name       = $listingArray[$i]->getVar('name');
            $mname      = $listingArray[$i]->getVar('mname');
            $lname      = $listingArray[$i]->getVar('lname');
            $school     = $listingArray[$i]->getVar('school');
            $year       = $listingArray[$i]->getVar('year');
            $studies    = $listingArray[$i]->getVar('studies');
            $activities = $listingArray[$i]->getVar('activities');
            $extrainfo  = $listingArray[$i]->getVar('extrainfo');
            $occ        = $listingArray[$i]->getVar('occ');
            $date       = $listingArray[$i]->getVar('date');
            $date       = XoopsLocale::formatTimestamp($date, 's');
            $email      = $listingArray[$i]->getVar('email');
            $submitter  = $listingArray[$i]->getVar('submitter');
            $usid       = $listingArray[$i]->getVar('usid');
            $town       = $listingArray[$i]->getVar('town');
            $valid      = $listingArray[$i]->getVar('valid');
            $photo      = $listingArray[$i]->getVar('photo');
            $photo2     = $listingArray[$i]->getVar('photo2');
            $view       = $listingArray[$i]->getVar('view');

            $recordexist = false;

            if ($lid != 0) {
                $recordexist = true;
                $listingHandler->updateCounter($lid);
            }

            $xoops->tpl()->assign('add_from', AlumniLocale::ALUMNI_LISTINGS . ' ' . $xoopsConfig['sitename']);
            $xoops->tpl()->assign('add_from_title', AlumniLocale::ALUMNI_LISTINGS);
            $xoops->tpl()->assign('add_from_sitename', $xoopsConfig['sitename']);
            $xoops->tpl()->assign('class_of', AlumniLocale::CLASSOF);
            $xoops->tpl()->assign('listing_exists', $recordexist);
            $count = 0;
            $x     = 0;
            $i     = 0;

            $printA = "<a href=\"print.php?lid=" . addslashes($lid) . "\" target=\"_blank\"><img src=\"images/print.gif\" border=0 alt=\"" . AlumniLocale::THIS_PRINT . "\" width=15 height=11></a>&nbsp;";
            $mailA  = "<a href=\"sendfriend.php?op=SendFriend&amp;lid=$lid\"><img src=\"../{$moduleDirName}/images/friend.gif\" border=\"0\" alt=\"" . AlumniLocale::FRIENDSEND . "\" width=\"15\" height=\"11\"></a>";
            if ($usid > 0) {
                $xoops->tpl()->assign('submitter', AlumniLocale::SUBMITTED_BY . "<a href='" . XOOPS_URL . "/userinfo.php?uid=" . addslashes($usid) . "'>$submitter</a>");
            } else {
                $xoops->tpl()->assign('submitter', AlumniLocale::SUBMITTED_BY . "$submitter");
            }

            $xoops->tpl()->assign('print', $printA);
            $xoops->tpl()->assign('sfriend', $mailA);
            $xoops->tpl()->assign('read', $view);

            if ($xoops->isUser()) {
                $calusern = $xoops->user->getVar('uid', 'E');
                if ($usid == $calusern) {
                    $xoops->tpl()->assign('modify', "<a href=\"listing.php?op=edit_listing&amp;lid=" . addslashes($lid) . "&amp;cid=" . addslashes($cid) . "\">" . AlumniLocale::MODIFY . "</a>  |  <a href=\"listing.php?op=delete_listing&amp;lid=" . addslashes($lid) . "\">" . XoopsLocale::A_DELETE . "</a>");
                }
                if ($xoops->user->isAdmin()) {
                    $xoops->tpl()->assign('admin', "<a href=\"admin/alumni.php?op=edit_listing&amp;lid=" . addslashes($lid) . "&amp;cid=" . addslashes($cid) . "\"><img src=\"images/modif.gif\" border=0 alt=\"" . AlumniLocale::MODADMIN . "\"></a>");
                }
            }

            $activities1 = $myts->displayTarea($activities, 1, 0, 1, 1, 0);

            $xoops->tpl()->assign('name', $name);
            $xoops->tpl()->assign('mname', $mname);
            $xoops->tpl()->assign('lname', $lname);
            $xoops->tpl()->assign('school', $school);
            $xoops->tpl()->assign('year', $year);
            $xoops->tpl()->assign('studies', $studies);
            $xoops->tpl()->assign('name_head', AlumniLocale::NAME_2);
            $xoops->tpl()->assign('class_of', AlumniLocale::CLASSOF);
            $xoops->tpl()->assign('mname_head', AlumniLocale::MNAME_2);
            $xoops->tpl()->assign('lname_head', AlumniLocale::LNAME_2);
            $xoops->tpl()->assign('school_head', AlumniLocale::SCHOOL);
            $xoops->tpl()->assign('year_head', AlumniLocale::YEAR);
            $xoops->tpl()->assign('studies_head', AlumniLocale::STUDIES_2);
            $xoops->tpl()->assign('local_town', $town);
            $xoops->tpl()->assign('local_head', AlumniLocale::TOWN_2);
            $xoops->tpl()->assign('alumni_mustlogin', AlumniLocale::MUSTLOGIN);
            $xoops->tpl()->assign('photo_head', AlumniLocale::GRAD_PHOTO);
            $xoops->tpl()->assign('photo2_head', AlumniLocale::NOW_PHOTO);
            $xoops->tpl()->assign('activities', $activities1);
            $xoops->tpl()->assign('extrainfo', $myts->displayTarea($extrainfo, 1));
            $xoops->tpl()->assign('activities_head', AlumniLocale::ACTIVITIES_2);
            $xoops->tpl()->assign('extrainfo_head', AlumniLocale::EXTRAINFO_2);

            if ($email) {
                $xoops->tpl()->assign('contact_head', AlumniLocale::CONTACT_2);
                $xoops->tpl()->assign('contact_email', "<a href=\"contact.php?lid=$lid\">" . AlumniLocale::EMAIL . "</a>");
            }
            $xoops->tpl()->assign('contact_occ_head', AlumniLocale::OCC_2);
            $xoops->tpl()->assign('contact_occ', $occ);

            $xoops->tpl()->assign('photo', '');
            $xoops->tpl()->assign('photo2', '');


            if ($photo) {
                $xoops->tpl()->assign('photo', "<img src=\"photos/grad_photo/$photo\" alt=\"\" width=\"125\"/>");
            }
            if ($photo2) {
                $xoops->tpl()->assign('photo2', "<img src=\"photos/now_photo/$photo2\" alt=\"\" width=\"125\">");
            }
            $xoops->tpl()->assign('date', AlumniLocale::LISTING_ADDED . " $date ");

            $xoops->tpl()->assign('link_main', "<a href=\"../{$moduleDirName}/\">" . XoopsLocale::MAIN . '</a>');
        }
        $xoops->tpl()->assign('no_listing', 'no listing');

        break;

    case 'new_listing':
        $xoops->header();
        $module_id = $xoopsModule->getVar('mid');
        if (is_object($xoopsUser)) {
            $groups = $xoopsUser->getGroups();
        } else {
            $groups = '3';
        }
  //      $gperm_handler = $xoops->getHandler('groupperm');
        if (isset($_POST['item_id'])) {
            $perm_itemid = (int)($_POST['item_id']);
        } else {
            $perm_itemid = 0;
        }
        //If no access
        if (!$gpermHandler->checkRight('' . $moduleDirName . '_view', $perm_itemid, $groups, $module_id)) {
            $xoops->redirect(XOOPS_URL . '/index.php', 3, _NOPERM);
            exit();
        }
        $obj    = $listingHandler->create();
        $new_id = $listingHandler->get_new_id();
        $form = $xoops->getModuleForm($obj, 'listing');
        $form->display();
        break;

    case 'save_listing':
        if (!$xoops->security()->check()) {
            $xoops->redirect('index.php', 3, implode(',', $xoops->security()->getErrors()));
        }
        if ($xoops->getModuleConfig('alumni_use_captcha') == '1' & !$xoops->user->isAdmin()) {
            $xoopsCaptcha = XoopsCaptcha::getInstance();
            if (!$xoopsCaptcha->verify()) {
                $xoops->redirect('javascript:history.go(-1)', 4, $xoopsCaptcha->getMessage());
                exit(0);
            }
        }
        $lid = Request::getInt('lid', 0);
        if (isset($lid)) {
            $obj = $listingHandler->get($lid);
            $obj->setVar('date', Request::getInt('date'));
        } else {
            $obj = $listingHandler->create();
            $obj->setVar('date', time());
            $lid = '0';
        }

        $photo_old = Request::getString('photo_old', '');
        $destination = XOOPS_ROOT_PATH . "/uploads/{$moduleDirName}/photos/grad_photo";
        $del_photo = Request::getInt('del_photo', 0);
        if (isset($del_photo)) {
            if ($del_photo == '1') {
                if (@file_exists('' . $destination . '/' . $photo_old . '')) {
                    unlink('' . $destination . '/' . $photo_old . '');
                }
                $obj->setVar('photo', '');
            }
        }
        
        $photo2_old = Request::getString('photo2_old', '');
        $destination2 = XOOPS_ROOT_PATH . "/uploads/{$moduleDirName}/photos/now_photo";
        $del_photo2 = Request::getInt('del_photo2', 0);
        if (isset($del_photo2)) {
            if ($del_photo2 == '1') {
                if (@file_exists('' . $destination2 . '/' . $photo2_old . '')) {
                    unlink('' . $destination2 . '/' . $photo2_old . '');
                }
                $obj->setVar('photo2', '');
            }
        }
        
	$cid = Request::getInt('cid', 0);
        if (isset($cid)) {
            $cat_name                  = '';
            $categoriesHandler = $xoops->getModuleHandler('category', 'alumni');
            $catObj                    = $categoriesHandler->get($cid);
            $cat_name                  = $catObj->getVar('title');
        }
        
        if (isset($lid)) {
            $obj->setVar('lid', $lid);
        }
        
        $obj->setVar('cid', Request::getInt('cid', 0));
        $obj->setVar('name', Request::getString('name'));
        $obj->setVar('mname', Request::getString('mname'));
        $obj->setVar('lname', Request::getString('lname'));
        $obj->setVar('school', $cat_name);
        $obj->setVar('year', Request::getInt('year'));
        $obj->setVar('studies', Request::getString('studies'));
        $obj->setVar('activities', Request::getString('activities'));
        $obj->setVar('extrainfo', Request::getString('extrainfo'));
        $obj->setVar('occ', Request::getString('occ'));
        $obj->setVar('email', Request::getString('email'));
        $obj->setVar('submitter', Request::getString('submitter'));
        $obj->setVar('usid', Request::getInt('usid'));
        $obj->setVar('town', Request::getString('town'));

        if ($xoops->getModuleConfig('alumni_moderated') == '1') {
            $obj->setVar('valid', '0');
        } else {
            $obj->setVar('valid', '1');
        }
        $date = time();
        if (!empty($_FILES['photo']['name'])) {
            include_once XOOPS_ROOT_PATH . '/class/uploader.php';
            $uploaddir         = XOOPS_ROOT_PATH . '/modules/alumni/photos/grad_photo';
            $photomax          = $xoops->getModuleConfig('alumni_photomax');
            $maxwide           = $xoops->getModuleConfig('alumni_maxwide');
            $maxhigh           = $xoops->getModuleConfig('alumni_maxhigh');
            $allowed_mimetypes = array('image/gif', 'image/jpg', 'image/jpeg', 'image/pjpeg', 'image/png', 'image/x-png');
            $uploader          = new XoopsMediaUploader($uploaddir, $allowed_mimetypes, $photomax, $maxwide, $maxhigh);
            if ($uploader->fetchMedia($_POST['xoops_upload_file'][0])) {
                $uploader->setTargetFileName($date . '_' . $_FILES['photo']['name']);
                $uploader->fetchMedia($_POST['xoops_upload_file'][0]);
                if (!$uploader->upload()) {
                    $errors = $uploader->getErrors();
                    $xoops->redirect('javascript:history.go(-1)', 3, $errors);
                } else {
                    $obj->setVar('photo', $uploader->getSavedFileName());
                }
            } else {
                $obj->setVar('photo', Request::getString('photo'));
            }
        }

        if (!empty($_FILES['photo2']['name'])) {
            include_once XOOPS_ROOT_PATH . '/class/uploader.php';
            $uploaddir2        = XOOPS_ROOT_PATH . '/modules/alumni/photos/now_photo';
            $photomax          = $xoops->getModuleConfig('alumni_photomax');
            $maxwide           = $xoops->getModuleConfig('alumni_maxwide');
            $maxhigh           = $xoops->getModuleConfig('alumni_maxhigh');
            $allowed_mimetypes = array('image/gif', 'image/jpg', 'image/jpeg', 'image/pjpeg', 'image/png', 'image/x-png');
            $uploader2         = new XoopsMediaUploader($uploaddir2, $allowed_mimetypes, $photomax, $maxwide, $maxhigh);
            if ($uploader2->fetchMedia($_POST['xoops_upload_file'][1])) {
                $uploader2->setTargetFileName($date . '_' . $_FILES['photo2']['name']);
                $uploader2->fetchMedia($_POST['xoops_upload_file'][1]);
                if (!$uploader2->upload()) {
                    $errors = $uploader2->getErrors();
                    $xoops->redirect('javascript:history.go(-1)', 3, $errors);
                } else {
                    $obj->setVar('photo2', $uploader2->getSavedFileName());
                }
            } else {
                $obj->setVar('photo2', Request::getString('photo2'));
            }
        }

        if ($new_id = $listingHandler->insert($obj)) {
            if ($xoops->getModuleConfig('alumni_moderated') == '1') {
                $xoops->redirect('index.php', 3, AlumniLocale::MODERATE);
            } else {
                $xoops->redirect('listing.php?lid=' .$new_id. '', 3, XoopsLocale::S_DATABASE_UPDATED);
            }
            //notifications
            if ($lid == 0 && $xoops->isActiveModule('notifications')) {
                $notification_handler = Notifications::getInstance()->getHandlerNotification();
                $tags                 = array();
                $tags['MODULE_NAME']  = 'alumni';
                $tags['ITEM_NAME']    = Request::getInt('lname', '');
                $tags['ITEM_URL']     = XOOPS_URL . '/modules/alumni/listing.php?lid=' . $new_id;
                $notification_handler->triggerEvent('global', 0, 'new_listing', $tags);
                $notification_handler->triggerEvent('category', $new_id, 'new_listing', $tags);
            }
        }

        echo $obj->getHtmlErrors();
        $form = $xoops->getModuleForm($obj, 'listing');
        $form->display();
        break;

    case 'edit_listing':
	$lid = Request::getInt('lid', 0);
	$listingHandler = $xoops->getModuleHandler('listing', 'alumni');
        $obj  = $listingHandler->get($lid);
        $form = $xoops->getModuleForm($obj, 'listing');
        $form->display();
        break;

    case 'delete_listing':
	$listingHandler = $xoops->getModuleHandler('listing', 'alumni');
        $lid = Request::getInt('lid', 0);
        $ok = Request::getInt('ok', 0);

        $obj = $listingHandler->get($lid);
        if ($ok == 1) {
            if (!$xoops->security()->check()) {
                $xoops->redirect('index.php', 3, implode(',', $xoops->security()->getErrors()));
            }
            if ($listingHandler->delete($obj)) {
                $xoops->redirect('index.php', 3, XoopsLocale::S_DATABASE_UPDATED);
            } else {
                echo $xoops->alert('error', $obj->getHtmlErrors());
            }
        } else {
            echo $xoops->confirm(array('ok' => 1, 'lid' => $lid, 'op' => 'delete_listing'), 'listing.php', XoopsLocale::Q_ARE_YOU_SURE_YOU_WANT_TO_DELETE_THIS_ITEM
                . '<br><span class="red">' . $obj->getVar('lname') . '<span>');
        }
        break;
}

Xoops::getInstance()->footer();
