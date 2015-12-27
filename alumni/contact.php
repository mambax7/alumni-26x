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
 
use Xoops\Core\Request;

//

if (!empty($_POST['submit'])) {
    include __DIR__ . '/header.php';

    global $xoopsConfig, $xoopsDB, $myts, $meta;

    if ($xoops->getModuleConfig('alumni_use_captcha') == '1' && !$xoops->user->isAdmin()) {
        $xoopsCaptcha = XoopsCaptcha::getInstance();
        if (!$xoopsCaptcha->verify()) {
            $xoops->redirect('javascript:history.go(-1)', 3, $xoopsCaptcha->getMessage());
            exit(0);
        }
    }

  //      if (!$xoops->security()->check()) {
   //         $xoops->redirect('javascript:history.go(-1)', 3, implode(',', $xoops->security()->getErrors()));
   //     }
        
    $lid = Request::getInt('lid', 0);
    $lid = (int)($lid);

    $body = Request::getString('body', '');
    $sname = Request::getString('sname', '');
    $semail = Request::getString('semail', '');
    $listing = Request::getString('listing', '');

    $subject       = AlumniLocale::CONTACTALUMNI;
    $admin_subject = AlumniLocale::CONTACTADMIN;

    $helper          = $xoops->getModuleHelper('alumni');
    $module_id       = $helper->getModule()->getVar('mid');
    $groups          = $xoops->isUser() ? $xoops->user->getGroups() : '3';
    $alumni_ids      = $xoops->getHandlerGroupPermission()->getItemIds('alumni_view', $groups, $module_id);
    $listingHandler = $xoops->getModuleHandler('listing', 'alumni');
    $listing_criteria       = new CriteriaCompo();
    $listing_criteria->add(new Criteria('lid', $lid, '='));
    $listing_criteria->add(new Criteria('cid', '(' . implode(', ', $alumni_ids) . ')', 'IN'));
    $numrows     = $listingHandler->getCount($listing_criteria);
    $listing_arr = $listingHandler->getall($listing_criteria);
    foreach (array_keys($listing_arr) as $i) {

        $name      = $listing_arr[$i]->getVar('name');
        $mname     = $listing_arr[$i]->getVar('mname');
        $lname     = $listing_arr[$i]->getVar('lname');
        $submitter = $listing_arr[$i]->getVar('submitter');
        $email     = $listing_arr[$i]->getVar('email');
    }
    unset($listing_arr);

    $ipaddress = $_SERVER['REMOTE_ADDR'];

    $xoopsMailer = $xoops->getMailer();
    $xoopsMailer->reset();
    $xoopsMailer->useMail();
    $xoopsMailer->setTemplateDir(XOOPS_ROOT_PATH . "/modules/alumni/language/" . $xoops->getConfig('language') . '/mail_template/');
    $xoopsMailer->setTemplate('listing_user_contact.tpl');
    $xoopsMailer->assign('SNAME', $sname); //assign some vars for mail template
    $xoopsMailer->assign('SEMAIL', $semail);
    $xoopsMailer->assign('SUBJECT', $subject);
    $xoopsMailer->assign('BODY', $body);
    $xoopsMailer->assign('FROM', AlumniLocale::SUBMITTED_BY);
    $xoopsMailer->assign('SUBMITTER', $submitter);
    $xoopsMailer->assign('HELLO', AlumniLocale::HELLO);
    $xoopsMailer->assign('LISTING', $listing);
    $xoopsMailer->assign('REPLY_TO', AlumniLocale::CAN_REPLY);
    $xoopsMailer->assign('HAVE_REPLY', AlumniLocale::REPLY_TO);
    $xoopsMailer->assign('FROMSITE', AlumniLocale::FROMSITE);
    $xoopsMailer->assign('AT', AlumniLocale::AT);
    $xoopsMailer->assign('WEBMASTER', AlumniLocale::WEBMASTER);
    $xoopsMailer->assign('NO_REPLY', AlumniLocale::NO_REPLY);
    $xoopsMailer->setToEmails($email);
    $xoopsMailer->setFromEmail($xoops->getConfig('adminmail'));
    $xoopsMailer->setFromName($xoops->getConfig('sitename'));
    $xoopsMailer->setSubject($subject);
    $xoopsMailer->setBody($body);
    $xoopsMailer->send();
    $xoopsMailer->getErrors();

    $xoopsMailer2 = $xoops->getMailer();
    $xoopsMailer->reset();
    $xoopsMailer2->useMail();
    $xoopsMailer2->setTemplateDir(XOOPS_ROOT_PATH . "/modules/alumni/language/" . $xoops->getConfig('language') . '/mail_template/');
    $xoopsMailer2->setTemplate('listing_admin_contact.tpl');
    $xoopsMailer2->assign('SNAME', $sname); //assign some vars for mail template
    $xoopsMailer2->assign('SEMAIL', $semail);
    $xoopsMailer2->assign('SUBJECT', $subject);
    $xoopsMailer2->assign('BODY', $body);
    $xoopsMailer2->assign('IPADDRESS', $ipaddress);
    $xoopsMailer2->assign('FROM', AlumniLocale::SUBMITTED_BY);
    $xoopsMailer2->assign('SUBMITTER', $submitter);
    $xoopsMailer2->assign('HELLO', AlumniLocale::HELLO);
    $xoopsMailer2->assign('LISTING', $listing);
    $xoopsMailer2->assign('ADMIN_COPY', AlumniLocale::ADMIN_COPY);
    $xoopsMailer2->assign('REPLY_TO', AlumniLocale::CAN_REPLY);
    $xoopsMailer2->assign('HAVE_REPLY', AlumniLocale::REPLY_TO);
    $xoopsMailer2->assign('FROMSITE', AlumniLocale::FROMSITE);
    $xoopsMailer2->assign('AT', AlumniLocale::AT);
    $xoopsMailer2->assign('WEBMASTER', AlumniLocale::WEBMASTER);
    $xoopsMailer2->assign('NO_REPLY', AlumniLocale::NO_REPLY);
    $xoopsMailer2->setToEmails($xoops->getConfig('adminmail'));
    $xoopsMailer2->setFromEmail($xoops->getConfig('adminmail'));
    $xoopsMailer2->setFromName($xoops->getConfig('sitename'));
    $xoopsMailer2->setSubject($admin_subject);
    $xoopsMailer2->setBody($body);
    $xoopsMailer2->send();
    $xoopsMailer2->getErrors();

    $xoops->redirect('index.php', 3, AlumniLocale::MESSAGE_SENT);

} else {

    $lid = isset($_REQUEST['lid']) ? $_REQUEST['lid'] : '';
    include __DIR__ . '/header.php';
    $xoops = Xoops::getInstance();
    	Xoops::getInstance()->header();
    $helper          = $xoops->getModuleHelper('alumni');
    $module_id       = $helper->getModule()->getVar('mid');
    $groups          = $xoops->isUser() ? $xoops->user->getGroups() : '3';
    $alumni_ids      = $xoops->getHandlerGroupPermission()->getItemIds('alumni_view', $groups, $module_id);
    $listingHandler = $xoops->getModuleHandler('listing', 'alumni');
    $listing_criteria       = new CriteriaCompo();
    $listing_criteria->add(new Criteria('lid', $lid, '='));
    $listing_criteria->add(new Criteria('cid', '(' . implode(', ', $alumni_ids) . ')', 'IN'));
    $numrows     = $listingHandler->getCount($listing_criteria);
    $listing_arr = $listingHandler->getall($listing_criteria);
    unset($listing_criteria);
    foreach (array_keys($listing_arr) as $i) {
        $name      = $listing_arr[$i]->getVar('name');
        $mname     = $listing_arr[$i]->getVar('mname');
        $lname     = $listing_arr[$i]->getVar('lname');
        $submitter = $listing_arr[$i]->getVar('submitter');
        $email     = $listing_arr[$i]->getVar('email');
    }
    $listing = $name . ' ' . $mname . ' ' . $lname;

    if ($xoops->user) {
        $sname = $xoops->user->getVar('uname');
        $sname = ($sname == '') ? $xoops->user->getVar('name') : $sname;

        $semail = $xoops->user->getVar('email');
    }
    $sendform = new XoopsThemeForm(AlumniLocale::CONTACTAUTOR . ' ' . $listing, 'sendform', $_SERVER['PHP_SELF'] . '?lid=$lid', 'POST');
    $sendform->addElement(new XoopsFormLabel(AlumniLocale::SUBJECT, $listing));
    $sendform->addElement(new XoopsFormText(XoopsLocale::C_YOUR_NAME, 'sname', 50, 100, $sname), true);
    $sendform->addElement(new XoopsFormText(XoopsLocale::C_YOUR_EMAIL, 'semail', 50, 50, $semail), true);
    $sendform->addElement(new XoopsFormTextArea(AlumniLocale::YOURMESSAGE, 'body', '', 5, 50, ''));
    if ($xoops->getModuleConfig('alumni_use_captcha') == '1' && !$xoops->user->isAdmin()) {
        $sendform->addElement(new XoopsFormCaptcha());
    }
    $sendform->addElement(new XoopsFormLabel(AlumniLocale::YOUR_IP, "<img src=\"" . XOOPS_URL . "/modules/alumni/ip_image.php\" alt=\"\" /><br />" . AlumniLocale::IP_LOGGED . ""));
//    $sendform->addElement(new Xoops\Form\Hidden('security', $xoops->security()->createToken()));
    $sendform->addElement(new XoopsFormHidden('listing', $listing), false);
    $sendform->addElement(new XoopsFormHidden('email', $email), false);
    $sendform->addElement(new XoopsFormHidden('lid', $lid), false);
    $sendform->addElement(new XoopsFormButton('', 'submit', XoopsLocale::A_SUBMIT, 'submit'));
    $sendform->display();

    Xoops::getInstance()->footer();
}
