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
$alumni = Alumni::getInstance();
$xoops         = Xoops::getInstance();

$adminmenu[] = array(
    'title' => AlumniLocale::ADMENU1,
    'link'  => 'admin/index.php',
    'icon'  => 'home.png');

$adminmenu[] = array(
    'title' => AlumniLocale::_ADMENU5,
    'link'  => 'admin/alumni.php',
    'icon'  => 'manage.png');

$adminmenu[] = array(
    'title' => AlumniLocale::_ADMENU2,
    'link'  => 'admin/alumni_categories.php',
    'icon'  => 'category.png');

$adminmenu[] = array(
    'title' => AlumniLocale::_ADMENU3,
    'link'  => 'admin/permissions.php',
    'icon'  => 'permissions.png');

$adminmenu[] = array(
    'title' => AlumniLocale::_ADMENU7,
    'link'  => 'admin/about.php',
    'icon'  => 'about.png');
