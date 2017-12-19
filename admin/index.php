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

include __DIR__ . '/admin_header.php';
$xoops = Xoops::getInstance();
$xoops->header();

$listingHandler = $xoops->getModuleHandler('listing', 'alumni');

$criteria = new CriteriaCompo();
$criteria->add(new Criteria('valid', 1));
$listing_valid = $listingHandler->getCount($criteria);

$moderateCriteria = new CriteriaCompo();
$moderateCriteria->add(new Criteria('valid', 0, '='));
$moderate_count = $listingHandler->getCount($moderateCriteria);

$indexAdmin = new \Xoops\Module\Admin();
$indexAdmin->displayNavigation('index.php');
$indexAdmin->addInfoBox(AlumniLocale::LISTINGS, 'listing');
$indexAdmin->addInfoBoxLine(sprintf(AlumniLocale::TOTAL_LISTINGS, $moderate_count + $listing_valid), 'listing');
$indexAdmin->addInfoBoxLine(sprintf(AlumniLocale::TOTAL_VALID, $listing_valid), 'listing');
$indexAdmin->addInfoBoxLine(sprintf(AlumniLocale::TOTAL_NOT_VALID, $moderate_count), 'listing');

$extensions = [
    'comments'      => 'extension',
    'notifications' => 'extension',
    'xcaptcha'      => 'extension'
];
foreach ($extensions as $module => $type) {
    $indexAdmin->addConfigBoxLine([$module, 'warning'], $type);
}

$indexAdmin->displayIndex();

$xoops->footer();
