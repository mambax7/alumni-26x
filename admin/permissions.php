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

$system = System::getInstance();
$xoops  = Xoops::getInstance();

$op = Request::getCmd('op', 'list');
$xoops->header();

$admin_page = new \Xoops\Module\Admin();
$admin_page->displayNavigation('permissions.php');

$cats     = $categoriesHandler->getAll();
$cat_rows = $categoriesHandler->getCount();

include_once XOOPS_ROOT_PATH . "/modules/{$moduleDirName}/class/alumni_tree.php";
$cattree = new AlumniObjectTree($cats, 'cid', 'pid');

if ('0' == $cat_rows) {
    echo AlumniLocale::MUST_ADD_CAT;
} else {
    $perm_desc = '';
    switch ($op) {

        case 'alumni_view':
        default:
            $title_of_form = AlumniLocale::PERMISSIONS_VIEW;
            $perm_name     = 'alumni_view';
            $restriction   = '';
            $anonymous     = true;
            break;

        case 'alumni_submit':
            $title_of_form = AlumniLocale::PERMISSIONS_SUBMIT;
            $perm_name     = 'alumni_submit';
            $restriction   = '';
            $anonymous     = false;
            break;

        case 'alumni_premium':
            $title_of_form = AlumniLocale::PERMISSIONS_PREMIUM;
            $perm_name     = 'alumni_premium';
            $perm_desc     = '';
            $restriction   = '';
            $anonymous     = false;
            break;
    }

    $opform   = new Xoops\Form\SimpleForm('', 'opform', 'permissions.php', 'get');
    $opSelect = new Xoops\Form\Select('', 'op', $op);
    $opSelect->setExtra('onchange="document.forms.opform.submit()"');
    $opSelect->addOption('alumni_view', AlumniLocale::PERMISSIONS_VIEW);
    $opSelect->addOption('alumni_submit', AlumniLocale::PERMISSIONS_SUBMIT);
    $opSelect->addOption('alumni_premium', AlumniLocale::PERMISSIONS_PREMIUM);
    $opform->addElement($opSelect);
    $opform->display();

    $moduleId = $xoops->module->getVar('mid');
    $form     = new Xoops\Form\GroupPermissionForm($title_of_form, $moduleId, $perm_name, $perm_desc, 'admin/permissions.php', $anonymous);

    foreach (array_keys($cats) as $i) {
        $cid     = $cats[$i]->getVar('cid');
        $title   = $cats[$i]->getVar('title');
        $pid     = $cats[$i]->getVar('pid');
        $allcats = $cattree->alumni_makeArrayTree($cats[$i]->getVar('cid'));
        $form->addItem($cid, $title, $pid);
    }
    $form->display();
}
$xoops->footer();
