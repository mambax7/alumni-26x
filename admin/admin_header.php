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

require_once dirname(dirname(dirname(__DIR__))) . '/include/cp_header.php';
include_once dirname(dirname(dirname(__DIR__))) . '/mainfile.php';
include_once dirname(__DIR__) . '/include/common.php';
XoopsLoad::load('system', 'system');
$xoops = Xoops::getInstance();
$xoops->loadLanguage('modinfo');
$helper = Alumni::getInstance();
$xoops  = $helper->xoops();
$moduleDirName = basename(dirname(__DIR__));

$listingHandler    = $xoops->getModuleHandler('listing', 'alumni');
$categoriesHandler = $xoops->getModuleHandler('category', 'alumni');
$gpermHandler      = $helper->getGrouppermHandler();
$module_id                 = $helper->getModule()->getVar('mid');

$xoops->theme()->addStylesheet('modules/system/css/admin.css');

$xoops->theme()->addScript('media/xoops/xoops.js');
