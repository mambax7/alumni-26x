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
$xoops         = Xoops::getInstance();
$myts          = MyTextSanitizer::getInstance();
$moduleDirName = basename(__DIR__);

//if (!empty($_POST['submit'])) {
if (Request::getString('submit', '', 'POST')) {
    if ('1' == $xoops->getModuleConfig('alumni_use_captcha') && !$xoops->user->isAdmin()) {
        $xoopsCaptcha = XoopsCaptcha::getInstance();
        if (!$xoopsCaptcha->verify()) {
            $xoops->redirect(XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . '/index.php', 4, $xoopsCaptcha->getMessage());
            exit(0);
        }
    }
    //       if (!$xoops->security()->check()) {
    //           $xoops->redirect('javascript:history.go(-1)', 3, implode(',', $xoops->security()->getErrors()));
    //       }

    $yname = Request::getString('yname', '', 'POST'); //$_POST['yname'];
    $ymail = Request::getString('ymail', '', 'POST'); //$_POST['ymail'];
    $fname = Request::getString('fname', '', 'POST'); //$_POST['fname'];
    $fmail = Request::getString('fmail', '', 'POST'); //$_POST['fmail'];

    $lid = Request::getInt('lid', 0);

    $alumni   = Alumni::getInstance();
    $helper   = Xoops::getModuleHelper('alumni');
    $moduleId = $helper->getModule()->getVar('mid');

    $groups           = $xoops->isUser() ? $xoops->user->getGroups() : '3';
    $alumni_ids       = $xoops->getHandlerGroupPermission()->getItemIds('alumni_view', $groups, $moduleId);
    $listingHandler   = $xoops->getModuleHandler('listing', 'alumni');
    $listing_criteria = new CriteriaCompo();
    $listing_criteria->add(new Criteria('lid', $lid, '='));
    $listing_criteria->add(new Criteria('cid', '(' . implode(', ', $alumni_ids) . ')', 'IN'));
    $numrows = $listingHandler->getCount($listing_criteria);

    $listingArray = $listingHandler->getAll($listing_criteria);
    unset($listing_criteria);
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

        $useroffset = '';
        if ($xoopsUser) {
            $timezone = $xoopsUser->timezone();
            if (isset($timezone)) {
                $useroffset = $xoopsUser->timezone();
            } else {
                $useroffset = $xoopsConfig['default_TZ'];
            }
        }
        $date       = ($useroffset * 3600) + $date;
        $date       = XoopsLocale::formatTimestamp($date, 's');
        $name       = $myts->htmlSpecialChars($name);
        $mname      = $myts->htmlSpecialChars($mname);
        $lname      = $myts->htmlSpecialChars($lname);
        $school     = $myts->htmlSpecialChars($school);
        $year       = $myts->htmlSpecialChars($year);
        $studies    = $myts->htmlSpecialChars($studies);
        $activities = $myts->displayTarea($activities, 1, 0, 1, 1, 1);
        $occ        = $myts->htmlSpecialChars($occ);
        $submitter  = $myts->htmlSpecialChars($submitter);
        $town       = $myts->htmlSpecialChars($town);

        $tags                       = [];
        $tags['YNAME']              = $yname;
        $tags['YMAIL']              = $ymail;
        $tags['FNAME']              = $fname;
        $tags['FMAIL']              = $fmail;
        $tags['HELLO']              = AlumniLocale::HELLO;
        $tags['LID']                = $lid;
        $tags['CLASSOF']            = AlumniLocale::CLASSOF;
        $tags['NAME']               = $name;
        $tags['MNAME']              = $mname;
        $tags['LNAME']              = $lname;
        $tags['SCHOOL']             = $school;
        $tags['STUDIES']            = $studies;
        $tags['TOWN']               = $town;
        $tags['YEAR']               = $year;
        $tags['OTHER']              = '' . AlumniLocale::INTERESTED . ' ' . $xoopsConfig['sitename'] . '';
        $tags['LISTINGS']           = '' . XOOPS_URL . "/modules/{$moduleDirName}/";
        $tags['LINK_URL']           = '' . XOOPS_URL . "/modules/{$moduleDirName}/listing.php?lid=" . addslashes($lid) . '';
        $tags['THINKS_INTERESTING'] = '' . AlumniLocale::MESSAGE . '';
        $tags['YOU_CAN_VIEW_BELOW'] = '' . AlumniLocale::YOU_CAN_VIEW_BELOW . '';
        $tags['WEBMASTER']          = AlumniLocale::WEBMASTER;
        $tags['NO_REPLY']           = AlumniLocale::NO_REPLY;
        $subject                    = '' . AlumniLocale::SUBJECT . ' ' . $xoopsConfig['sitename'] . '';

        $xoopsMailer = $xoops->getMailer();
        $xoopsMailer->useMail();
        $xoopsMailer->setTemplateDir(XOOPS_ROOT_PATH . "/modules/{$moduleDirName}/language/english/mail_template/");
        $xoopsMailer->setTemplate('listing_send_friend.tpl');
        $xoopsMailer->setFromEmail($ymail);
        $xoopsMailer->setToEmails($fmail);
        $xoopsMailer->setSubject($subject);
        //    $xoopsMailer->$xoops->multimailer;
        $xoopsMailer->assign($tags);
        $xoopsMailer->send();
        echo $xoopsMailer->getErrors();

        $xoops->redirect('index.php', 3, AlumniLocale::ALUM_SEND);
        exit();
    }
} else {
    global $xoops;

    $lid = Request::getInt('lid', 0);
    $xoops->header('alumni_sendfriend.tpl');

    include_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';

    $listingHandler = $xoops->getModuleHandler('listing', $moduleDirName);
    $listing_2_send = $listingHandler->get($lid);

    $listing_2_send->getVar('name');
    $listing_2_send->getVar('mname');
    $listing_2_send->getVar('lname');

    ob_start();
    $form = new Xoops\Form\ThemeForm(AlumniLocale::SENDTO, 'sendfriend_form', 'sendfriend.php');
    $form->setExtra('enctype="multipart/form-data"');
    //    $GLOBALS['xoopsGTicket']->addTicketXoopsFormElement($form, __LINE__, 1800, 'token');
    $form->addElement(new Xoops\Form\Label(AlumniLocale::LISTING_SEND, $listing_2_send->getVar('name') . ' ' . $listing_2_send->getVar('mname') . ' ' . $listing_2_send->getVar('lname') . ''));
    if ($xoopsUser) {
        $idd  = $xoopsUser->getVar('name', 'E');
        $idde = $xoopsUser->getVar('email', 'E');
    }

    $form->addElement(new Xoops\Form\Text(XoopsLocale::C_YOUR_NAME, 'yname', 30, 50, $idd), true);
    $form->addElement(new Xoops\Form\Text(XoopsLocale::C_YOUR_EMAIL, 'ymail', 30, 60, $idde), true);
    $form->addElement(new Xoops\Form\Text(AlumniLocale::NAMEFR, 'fname', 30, 60, ''), true);
    $form->addElement(new Xoops\Form\Text(AlumniLocale::MAILFR, 'fmail', 30, 60, ''), true);

    if ('1' == $xoops->getModuleConfig('alumni_use_captcha') && !$xoops->user->isAdmin()) {
        $form->addElement(new XoopsFormCaptcha());
    }
    //   $form->addElement(new Xoops\Form\Hidden('security', $xoops->security()->createToken()));
    $form->addElement(new Xoops\Form\Hidden('lid', $lid), false);
    $form->addElement(new Xoops\Form\Button('', 'submit', XoopsLocale::A_SUBMIT, 'submit'));
    $form->display();
    $xoopsTpl->assign('sendfriend_form', ob_get_contents());

    ob_end_clean();
}
Xoops::getInstance()->footer();
