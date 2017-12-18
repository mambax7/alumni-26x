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
defined('XOOPS_ROOT_PATH') || exit('XOOPS root path not defined');

include_once dirname(__DIR__) . '/include/common.php';
$alumni = Alumni::getInstance();
$xoops         = Xoops::getInstance();

$i = 0;
$adminmenu[$i]['title'] = AlumniLocale::ADMENU1;
$adminmenu[$i]['link']  = 'admin/index.php';
$adminmenu[$i]['icon']  = 'home.png';

++$i;
$adminmenu[$i]['title'] = AlumniLocale::ADMENU5;
$adminmenu[$i]['link']  = 'admin/alumni.php';
$adminmenu[$i]['icon']  = 'manage.png';

++$i;
$adminmenu[$i]['title'] = AlumniLocale::ADMENU2;
$adminmenu[$i]['link']  = 'admin/category.php';
$adminmenu[$i]['icon']  = 'category.png';

++$i;
$adminmenu[$i]['title'] = AlumniLocale::ADMENU3;
$adminmenu[$i]['link']  = 'admin/permissions.php';
$adminmenu[$i]['icon']  = 'permissions.png';

++$i;
$adminmenu[$i]['title'] = AlumniLocale::ADMENU7;
$adminmenu[$i]['link']  = 'admin/about.php';
$adminmenu[$i]['icon']  = 'about.png';
