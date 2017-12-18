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

include_once dirname(dirname(__DIR__)) . '/mainfile.php';
include_once __DIR__ . '/include/common.php';

XoopsLoad::load('system', 'system');
$system = System::getInstance();
$helper = Alumni::getInstance();
$xoops = $helper->xoops();

$categoriesHandler = $helper->getCategoryHandler();
$listingHandler  = $helper->getListingHandler();
$gpermHandler = $helper->getGrouppermHandler();

//permission
$groups = $xoops->getUserGroups();
$uid    = $helper->getUserId();

$xoops->theme()->addStylesheet($helper->url('css/styles.css'));
$xoops->theme()->addStylesheet($helper->url('css/rating.css'));


$module_id = $helper->getModule()->getVar('mid');
$interval  = 3600; //1 hour

