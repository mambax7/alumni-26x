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
include __DIR__ . '/admin_header.php';
$moduleDirName = basename(dirname(__DIR__));
include_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';
$myts  = MyTextSanitizer::getInstance();
$xoops = Xoops::getInstance();

$op = Request::getCmd('op', 'list');

switch ($op) {
    case 'list':
    default:
        $xoops->header('admin:alumni/alumni_admin_listing.tpl');
        $indexAdmin = new \Xoops\Module\Admin();
        $indexAdmin->displayNavigation('alumni.php');
        
        $xoTheme->addScript(ALUMNI_URL . '/media/jquery/jquery-1.8.3.min.js');
        $xoTheme->addScript(ALUMNI_URL . '/media/jquery/tablesorter-master/js/jquery.tablesorter.js');
        $xoTheme->addScript(ALUMNI_URL . '/media/jquery/tablesorter-master/addons/pager/jquery.tablesorter.pager.js');
        $xoTheme->addScript(ALUMNI_URL . '/media/jquery/tablesorter-master/js/jquery.tablesorter.widgets.js');
        $xoTheme->addScript(ALUMNI_URL . '/media/jquery/pager-custom-controls.js');
        $xoTheme->addScript(ALUMNI_URL . '/media/jquery/myAdminjs.js');
        $xoTheme->addStylesheet(ALUMNI_URL . '/media/jquery/css/theme.blue.css');
        $xoTheme->addStylesheet(ALUMNI_URL . '/media/jquery/tablesorter-master/addons/pager/jquery.tablesorter.pager.css');

        $indexAdmin->addItemButton(AlumniLocale::ADD_LISTING, 'alumni.php?op=new_listing', 'add');

        if ('1' == $xoops->getModuleConfig('alumni_moderated')) {
            $indexAdmin->addItemButton(AlumniLocale::MODERATE_LISTING, 'alumni.php?op=list_moderated', 'add');
        }

        $indexAdmin->renderButton('left', '');

        $listingCount = $listingHandler->countAlumni();
        $listingArray   = $listingHandler->getAll();

        // Assign Template variables
        $xoops->tpl()->assign('listingCount', $listingCount);
        if ($listingCount > 0) {
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
                $email      = $listingArray[$i]->getVar('email');
                $submitter  = $listingArray[$i]->getVar('submitter');
                $usid       = $listingArray[$i]->getVar('usid');
                $town       = $listingArray[$i]->getVar('town');
                $valid      = $listingArray[$i]->getVar('valid');
                $photo      = $listingArray[$i]->getVar('photo');
                $photo2     = $listingArray[$i]->getVar('photo2');
                $view       = $listingArray[$i]->getVar('view');

                $xoops->tpl()->assign('cat', $cid);

                $listing = [];
                $name    = $myts->undoHtmlSpecialChars($name);
                $mname   = $myts->undoHtmlSpecialChars($mname);
                $lname   = $myts->undoHtmlSpecialChars($lname);
                $school  = $myts->undoHtmlSpecialChars($school);
                $year    = $myts->htmlSpecialChars($year);

                $useroffset = '';
                $newcount   = $xoops->getModuleConfig('' . $moduleDirName . '_countday');
                $startdate  = (time() - (86400 * $newcount));
                if ($startdate < $date) {
                    $newitem        = "<img src=\"" . XOOPS_URL . "/modules/{$moduleDirName}/assets/images/newred.gif\">";
                    $listing['new'] = $newitem;
                }
                if ($xoops->user) {
                    $timezone = $xoops->user->timezone();
                    if (null !== $timezone) {
                        $useroffset = $xoops->user->timezone();
                    } else {
                        $useroffset = $xoopsConfig['default_TZ'];
                    }
                }
                $date = ($useroffset * 3600) + $date;
                $date = XoopsLocale::formatTimestamp($date, 's');

                $listing['lid']       = $lid;
                $listing['cid']       = $cid;
                $listing['name']      = "<a href='../listing.php?lid=$lid'><b>$name&nbsp;$mname&nbsp;$lname</b></a>";
                $listing['school']    = $school;
                $listing['year']      = $year;
                $listing['submitter'] = $submitter;
                $listing['date']      = $date;
                $listing['valid']     = $valid;
                $listing['view']      = $view;

                $cat = addslashes($cid);

                $listing['views'] = $view;
                $xoops->tpl()->append('listing', $listing);
                $xoops->tpl()->assign('valid', AlumniLocale::APPROVE);
                $xoops->tpl()->assign('school', AlumniLocale::SCHOOL);
                $xoops->tpl()->assign('class_of', AlumniLocale::CLASS_OF);
            }
            unset($listing);
            $xoops->tpl()->assign('error_message', '');
        } else {
            $xoops->tpl()->assign('error_message', AlumniLocale::E_NO_LISTING);
        }
        break;

    case 'new_listing':
        $listingHandler = $xoops->getModuleHandler('listing', 'alumni');
        $xoops->header();
        $indexAdmin = new Xoops\Module\Admin();
        $indexAdmin->displayNavigation('alumni.php');
        $indexAdmin->addItemButton(AlumniLocale::LIST_CATS, 'alumni.php');
        echo $indexAdmin->renderButton('left', '');
        $obj  = $listingHandler->create();
        $form = $xoops->getModuleForm($obj, 'listing');
        $form->display();
        break;

    case 'save_listing':
        if (!$xoops->security()->check()) {
            $xoops->redirect('alumni.php', 3, implode(',', $xoops->security()->getErrors()));
        }

        if ('1' == $xoops->getModuleConfig('alumni_use_captcha') && !$xoops->user->isAdmin()) {
            $xoopsCaptcha = XoopsCaptcha::getInstance();
            if (!$xoopsCaptcha->verify()) {
                $xoops->redirect(XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . '/addlisting.php', 6, $xoopsCaptcha->getMessage());
                exit(0);
            }
        }

        $date = time();
	$lid = Request::getInt('lid', 0);
        if (isset($lid)) {
            $obj = $listingHandler->get($lid);
            $obj->setVar('lid', $lid);
        } else {
            $obj = $listingHandler->create();
        }

        $destination = XOOPS_ROOT_PATH . "/uploads/{$moduleDirName}/photos/grad_photo";
       $del_photo = Request::getInt('del_photo', 0);
        if (isset($del_photo)) {
            if ('1' == $del_photo) {
                if (@file_exists('' . $destination . '/' . Request::getString('photo_old') . '')) {
                    unlink('' . $destination . '/' . Request::getString('photo_old') . '');
                }
                $obj->setVar('photo', '');
            }
        }
        $destination2 = XOOPS_ROOT_PATH . "/uploads/{$moduleDirName}/photos/now_photo";
        $del_photo2 = Request::getInt('del_photo', 0);
        if (isset($del_photo2)) {
            if ('1' == $del_photo2) {
                if (@file_exists('' . $destination2 . '/' . Request::getString('photo2_old') . '')) {
                    unlink('' . $destination2 . '/' . Request::getString('photo2_old') . '');
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

        $obj->setVar('cid', Request::getInt('cid', 0));
        $obj->setVar('name', Request::getString('name'));
        $obj->setVar('mname', Request::getString('mname'));
        $obj->setVar('lname', Request::getString('lname'));
        $obj->setVar('school', $cat_name);
        $obj->setVar('year', Request::getInt('year', 0));
        $obj->setVar('studies', Request::getString('studies'));
        $obj->setVar('activities', Request::getString('activities'));
        $obj->setVar('extrainfo', Request::getString('extrainfo'));
        $obj->setVar('occ', Request::getString('occ'));
        $obj->setVar('date', Request::getInt('date', 0));
        $obj->setVar('email', Request::getString('email'));
        $obj->setVar('submitter', Request::getString('submitter', ''));
        $obj->setVar('usid', Request::getInt('usid', 0));
        $obj->setVar('town', Request::getString('town'));

        if ('1' == $xoops->getModuleConfig('alumni_moderate')) {
            $obj->setVar('valid', '0');
        } else {
            $obj->setVar('valid', '1');
        }

        if (!empty($_FILES['photo']['name'])) {
            include_once XOOPS_ROOT_PATH . '/class/uploader.php';
            $uploaddir         = XOOPS_ROOT_PATH . "/uploads/{$moduleDirName}/photos/grad_photo";
            $photomax          = $xoops->getModuleConfig('alumni_photomax');
            $maxwide           = $xoops->getModuleConfig('alumni_maxwide');
            $maxhigh           = $xoops->getModuleConfig('alumni_maxhigh');
            $allowedMimetypes = ['image/gif', 'image/jpg', 'image/jpeg', 'image/pjpeg', 'image/png', 'image/x-png'];
            $uploader          = new XoopsMediaUploader($uploaddir, $allowedMimetypes, $photomax, $maxwide, $maxhigh);
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
            $uploaddir2       = XOOPS_ROOT_PATH . "/uploads/{$moduleDirName}/photos/now_photo";
            $photomax          = $xoops->getModuleConfig('alumni_photomax');
            $maxwide           = $xoops->getModuleConfig('alumni_maxwide');
            $maxhigh           = $xoops->getModuleConfig('alumni_maxhigh');
            $allowedMimetypes = ['image/gif', 'image/jpg', 'image/jpeg', 'image/pjpeg', 'image/png', 'image/x-png'];
            $uploader2         = new XoopsMediaUploader($uploaddir2, $allowedMimetypes, $photomax, $maxwide, $maxhigh);
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

        if ($listingHandler->insert($obj)) {
            $xoops->redirect('alumni.php', 3, XoopsLocale::S_DATABASE_UPDATED);

            //notifications
            if (0 == $lid  && $xoops->isActiveModule('notifications')) {
                $notification_handler = Notifications::getInstance()->getHandlerNotification();
                $tags                 = [];
                $tags['MODULE_NAME']  = 'alumni';
                $tags['ITEM_NAME']    = Request::getString('lname', '');
                $tags['ITEM_URL']     = XOOPS_URL . "/modules/{$moduleDirName}/listing.php?lid=" . $new_id;
                $notification_handler->triggerEvent('global', 0, 'newlisting', $tags);
                $notification_handler->triggerEvent('item', $new_id, 'newlisting', $tags);
            }
        }

        echo $obj->getHtmlErrors();
        $form = $xoops->getModuleForm($obj, 'listing');
        $form->display();
        break;

    case 'edit_listing':
        $xoops->header();
        $lid = Request::getInt('lid', 0);
        $indexAdmin = new Xoops\Module\Admin();
        $indexAdmin->addItemButton(AlumniLocale::ADD_LISTING, 'alumni.php?op=new_listing', 'add');
        $indexAdmin->addItemButton(AlumniLocale::LISTINGLIST, 'alumni.php', 'list');
        echo $indexAdmin->renderButton('left', '');
        $obj  = $listingHandler->get($lid);
        $form = $xoops->getModuleForm($obj, 'listing');
        $form->display();
        break;

    case 'delete_listing':
        $xoops->header();
        $lid = Request::getInt('lid', 0);
        $ok = Request::getInt('ok', 0);
        $obj = $listingHandler->get($lid);
        if (isset($ok) && 1 == $ok) {
            if (!$xoops->security()->check()) {
                $xoops->redirect('alumni.php', 3, implode(',', $xoops->security()->getErrors()));
            }
            if ($listingHandler->delete($obj)) {
                $xoops->redirect('alumni.php', 3, AlumniLocale::FORMDELOK);
            } else {
                echo $obj->getHtmlErrors();
            }
        } else {
        
            echo $xoops->confirm(
                ['ok' => 1, 'lid' => $lid, 'op' => 'delete_listing'],
                'alumni.php',
                XoopsLocale::Q_ARE_YOU_SURE_YOU_WANT_TO_DELETE_THIS_ITEM
                . '<br><span class="red">' . $obj->getVar('lname') . '<span>'
            );
         }
        break;

    case 'update_status':
        $lid = Request::getInt('lid', 0);
        if ($lid > 0) {
            $obj = $listingHandler->get($lid);
            $obj->setVar('valid', 1);
            if ($listingHandler->insert($obj)) {
                $xoops->redirect('alumni.php?op=list_moderated', 3, AlumniLocale::LISTING_VALIDATED);
            }
            echo $obj->getHtmlErrors();
        }
        break;

    case 'list_moderated':
        $xoops->header('alumni_admin_moderated.tpl');
        $indexAdmin = new Xoops\Module\Admin();
        $indexAdmin->renderNavigation('alumni.php');

        $xoTheme->addScript(ALUMNI_URL . '/media/jquery/jquery-1.8.3.min.js');
        $xoTheme->addScript(ALUMNI_URL . '/media/jquery/tablesorter-master/js/jquery.tablesorter.js');
        $xoTheme->addScript(ALUMNI_URL . '/media/jquery/tablesorter-master/addons/pager/jquery.tablesorter.pager.js');
        $xoTheme->addScript(ALUMNI_URL . '/media/jquery/tablesorter-master/js/jquery.tablesorter.widgets.js');
        $xoTheme->addScript(ALUMNI_URL . '/media/jquery/pager-custom-controls.js');
        $xoTheme->addScript(ALUMNI_URL . '/media/jquery/myAdminjs.js');
        $xoTheme->addStylesheet(ALUMNI_URL . '/media/jquery/css/theme.blue.css');
        $xoTheme->addStylesheet(ALUMNI_URL . '/media/jquery/tablesorter-master/addons/pager/jquery.tablesorter.pager.css');

        $listing_Handler   = $xoops->getModuleHandler('listing', 'alumni');
        $alumni            = Alumni::getInstance();
        $moduleId         = $xoops->module->getVar('mid');
        $groups            = $xoops->isUser() ? $xoops->user->getGroups() : '3';
        $alumniIds        = $alumni->getGrouppermHandler()->getItemIds('alumni_view', $groups, $moduleId);
        $moderateCriteria = new CriteriaCompo();
        $moderateCriteria->add(new Criteria('valid', 0, '='));
        $moderateCriteria->add(new Criteria('cid', '(' . implode(', ', $alumniIds) . ')', 'IN'));
        $listingCount = $listingHandler->getCount($moderateCriteria);
        $listingArray = $listingHandler->getAll($moderateCriteria);

        // Assign Template variables
        $xoops->tpl()->assign('listingCount', $listingCount);
        if ($listingCount > 0) {
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
                $email      = $listingArray[$i]->getVar('email');
                $submitter  = $listingArray[$i]->getVar('submitter');
                $usid       = $listingArray[$i]->getVar('usid');
                $town       = $listingArray[$i]->getVar('town');
                $valid      = $listingArray[$i]->getVar('valid');
                $photo      = $listingArray[$i]->getVar('photo');
                $photo2     = $listingArray[$i]->getVar('photo2');
                $view       = $listingArray[$i]->getVar('view');

                $xoops->tpl()->assign('cat', $cid);

                $listing = [];
                $name    = $myts->undoHtmlSpecialChars($name);
                $mname   = $myts->undoHtmlSpecialChars($mname);
                $lname   = $myts->undoHtmlSpecialChars($lname);
                $school  = $myts->undoHtmlSpecialChars($school);
                $year    = $myts->htmlSpecialChars($year);

                $useroffset = '';

                $newcount  = $xoops->getModuleConfig('' . $moduleDirName . '_countday');
                $startdate = (time() - (86400 * $newcount));
                if ($startdate < $date) {
                    $newitem        = "<img src=\"" . XOOPS_URL . "/modules/{$moduleDirName}/assets/images/newred.gif\">";
                    $listing['new'] = $newitem;
                }
                if ($xoops->user) {
                    $timezone = $xoops->user->timezone();
                    if (null !== $timezone) {
                        $useroffset = $xoops->user->timezone();
                    } else {
                        $useroffset = $xoopsConfig['default_TZ'];
                    }
                }
                $date = ($useroffset * 3600) + $date;
                $date = XoopsLocale::formatTimestamp($date, 's');

                $listing['lid']        = $lid;
                $listing['cid']        = $cid;
                $listing['name']       = "<a href='alumni.php?op=moderated_listing&amp;lid=$lid'><b>$name&nbsp;$mname&nbsp;$lname</b></a>";
                $listing['school']     = $school;
                $listing['year']       = $year;
                $listing['studies']    = $studies;
                $listing['activities'] = $activities;
                $listing['extrainfo']  = $extrainfo;
                $listing['occ']        = $occ;
                $listing['submitter']  = $submitter;
                $listing['date']       = $date;
                $listing['valid']      = $valid;
                $listing['view']       = $view;

                $cat = addslashes($cid);

                $listing['views'] = $view;
                $xoops->tpl()->append('listing', $listing);
                $xoops->tpl()->assign('valid', AlumniLocale::APPROVE);
                $xoops->tpl()->assign('school', AlumniLocale::SCHOOL);
                $xoops->tpl()->assign('class_of', AlumniLocale::CLASS_OF);
                $xoops->tpl()->assign('moderated_lang', AlumniLocale::MODERATED);
                $xoops->tpl()->assign('moderated_lang', XoopsLocale::A_EDIT);
                $xoops->tpl()->assign('studies_lang', AlumniLocale::STUDIES);
                $xoops->tpl()->assign('activities_lang', AlumniLocale::ACTIVITIES);
                $xoops->tpl()->assign('extrainfo_lang', AlumniLocale::EXTRAINFO);
                $xoops->tpl()->assign('occ_lang', AlumniLocale::OCC);
            }
            unset($listing);

        } else {
            $xoops->tpl()->assign('error_message', AlumniLocale::NO_LISTING_TO_APPROVE);
        }

        break;

}
$xoops->footer();
