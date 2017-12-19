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

$moduleDirName = basename(dirname(__DIR__));

$xoops = Xoops::getInstance();
$listingHandler = $xoops->getModuleHandler('listing', 'alumni');

function alumni_ShowImg()
{
    global $moduleDirName;

    echo "<script type=\"text/javascript\">\n";
    echo "<!--\n\n";
    echo "function showimage() {\n";
    echo "if (!document.images)\n";
    echo "return\n";
    echo "document.images.avatar.src=\n";
    echo "'" . XOOPS_URL . "/modules/{$moduleDirName}/assets/images/cat/' + document.imcat.img.options[document.imcat.img.selectedIndex].value\n";
    echo "}\n\n";
    echo "//-->\n";
    echo "</script>\n";
}

function alumni_ShowImg2()
{
    global $moduleDirName;

    echo "<script type=\"text/javascript\">\n";
    echo "<!--\n\n";
    echo "function showimage2() {\n";
    echo "if (!document.images)\n";
    echo "return\n";
    echo "document.images.scphoto.src=\n";
    echo "'" . XOOPS_URL . "/modules/{$moduleDirName}/assets/images/schools/' + document.imcat.scphoto.options[document.imcat.scphoto.selectedIndex].value\n";
    echo "}\n\n";
    echo "//-->\n";
    echo "</script>\n";
}

//Reusable Link Sorting Functions
/**
 * @param $orderby
 * @return string
 */
function alumni_convertorderbyin($orderby)
{
    switch (trim($orderby)) {
        case 'nameA':
            $orderby = 'lname ASC';
            break;
        case 'schoolA':
            $orderby = 'school ASC';
            break;
        case 'studiesA':
            $orderby = 'studies ASC';
            break;
        case 'yearA':
            $orderby = 'year ASC';
            break;
        case 'dateA':
            $orderby = 'date ASC';
            break;
        case 'viewA':
            $orderby = 'view ASC';
            break;
        case 'nameD':
            $orderby = 'lname DESC';
            break;
        case 'schoolD':
            $orderby = 'school DESC';
            break;
        case 'studiesD':
            $orderby = 'studies DESC';
            break;
        case 'yearD':
            $orderby = 'year DESC';
            break;
        case 'viewD':
            $orderby = 'view DESC';
            break;
        case 'dateD':
        default:
            $orderby = 'date DESC';
            break;
    }

    return $orderby;
}

/**
 * @param $orderby
 * @return string
 */
function alumni_convertorderbytrans($orderby)
{
    global $main_lang;

    if ('view ASC' === $orderby) {
        $orderbyTrans = '' . constant($main_lang . '_POPULARITYLTOM') . '';
    }
    if ('view DESC' === $orderby) {
        $orderbyTrans = '' . constant($main_lang . '_POPULARITYMTOL') . '';
    }
    if ('lname ASC' === $orderby) {
        $orderbyTrans = '' . constant($main_lang . '_NAMEATOZ') . '';
    }
    if ('lname DESC' === $orderby) {
        $orderbyTrans = '' . constant($main_lang . '_NAMEZTOA') . '';
    }
    if ('school ASC' === $orderby) {
        $orderbyTrans = '' . constant($main_lang . '_SCHOOLATOZ') . '';
    }
    if ('school DESC' === $orderby) {
        $orderbyTrans = '' . constant($main_lang . '_SCHOOLZTOA') . '';
    }
    if ('studies ASC' === $orderby) {
        $orderbyTrans = '' . constant($main_lang . '_STUDIESATOZ') . '';
    }
    if ('studies DESC' === $orderby) {
        $orderbyTrans = '' . constant($main_lang . '_STUDIESZTOA') . '';
    }
    if ('year ASC' === $orderby) {
        $orderbyTrans = '' . constant($main_lang . '_YEAROLD') . '';
    }
    if ('year DESC' === $orderby) {
        $orderbyTrans = '' . constant($main_lang . '_YEARNEW') . '';
    }
    if ('date ASC' === $orderby) {
        $orderbyTrans = '' . constant($main_lang . '_DATEOLD') . '';
    }
    if ('date DESC' === $orderby) {
        $orderbyTrans = '' . constant($main_lang . '_DATENEW') . '';
    }

    return $orderbyTrans;
}

/**
 * @param $orderby
 * @return string
 */
function alumni_convertorderbyout($orderby)
{
    if ('lname ASC' === $orderby) {
        $orderby = 'nameA';
    }
    if ('school ASC' === $orderby) {
        $orderby = 'schoolA';
    }
    if ('studies ASC' === $orderby) {
        $orderby = 'studiesA';
    }
    if ('year ASC' === $orderby) {
        $orderby = 'yearA';
    }
    if ('date ASC' === $orderby) {
        $orderby = 'dateA';
    }
    if ('view ASC' === $orderby) {
        $orderby = 'viewA';
    }
    if ('lname DESC' === $orderby) {
        $orderby = 'nameD';
    }
    if ('school DESC' === $orderby) {
        $orderby = 'schoolD';
    }
    if ('studies DESC' === $orderby) {
        $orderby = 'studiesD';
    }
    if ('year DESC' === $orderby) {
        $orderby = 'yearD';
    }
    if ('date DESC' === $orderby) {
        $orderby = 'dateD';
    }
    if ('view DESC' === $orderby) {
        $orderby = 'viewD';
    }

    return $orderby;
}
