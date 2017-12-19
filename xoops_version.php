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
$moduleDirName    = basename(__DIR__);




// ------------------- Informations ------------------- //
$modversion = [
    'name'                => AlumniLocale::MODULE_NAME,
    'description'         => AlumniLocale::MODULE_DESC,
    'official'            => 0,
    //1 indicates supported by XOOPS Dev Team, 0 means 3rd party supported
    'author'              => 'John Mordo',
    'nickname'            => 'jlm69',
    'author_mail'         => 'author-email',
    'author_website_url'  => 'http://jlmzone.com/',
    'author_website_name' => 'JLM Zone',
    'credits'             => 'XOOPS Development Team, John Mordo',
    'license'             => 'GPL 2.0 or later',
    'license_url'         => 'www.gnu.org/licenses/gpl-2.0.html/',
    'help'                => 'page=help',
    //
    'release_info'        => 'Changelog',
    'release_file'        => XOOPS_URL . '/modules/{$moduleDirName}/docs/changelog file',
    //
    'manual'              => 'link to manual file',
    'manual_file'         => XOOPS_URL . '/modules/{$moduleDirName}/docs/install.txt',
    'min_php'             => '5.4.0',
    'min_xoops'           => '2.6.0',
    'min_admin'           => '1.1',
    'min_db'              => [
        'mysql'  => '5.0.7',
        'mysqli' => '5.0.7'
    ],
    // images
    'image'               => 'assets/images/module_logo.png',
    'iconsmall'           => 'assets/images/iconsmall.png',
    'iconbig'             => 'assets/images/iconbig.png',
    'dirname'             => "{$moduleDirName}",
    //Frameworks
    'dirmoduleadmin'      => 'Frameworks/moduleclasses/moduleadmin',
    'sysicons16'          => 'Frameworks/moduleclasses/icons/16',
    'sysicons32'          => 'Frameworks/moduleclasses/icons/32',
    // Local path icons
    'modicons16'          => 'assets/images/icons/16',
    'modicons32'          => 'assets/images/icons/32',
    //About
    'version'             => 3.1,
    'module_status'       => 'Beta 1',
    'release_date'        => '2015/06/03',
    //yyyy/mm/dd
    //    'release'             => '2015-04-04',
    'demo_site_url'       => 'http://www.xoops.org',
    'demo_site_name'      => 'XOOPS Demo Site',
    'support_url'         => 'https://xoops.org/modules/newbb',
    'support_name'        => 'Support Forum',
    'module_website_url'  => 'www.xoops.org',
    'module_website_name' => 'XOOPS Project',
    // paypal
    'paypal'              => [
        'business'      => 'admin@jlmzone.com',
        'item_name'     => 'Donation : ' . AlumniLocale::MODULE_DESC,
        'amount'        => 0,
        'currency_code' => 'USD'
    ],
    // Admin system menu
    'system_menu'         => 1,
    // Admin menu
    'hasAdmin'            => 1,
    'adminindex'          => 'admin/index.php',
    'adminmenu'           => 'admin/menu.php',
    // JQuery
    'jquery'              => 1,
    // Main menu
    'hasMain'             => 1,
    //Search & Comments
    //    'hasSearch'           => 1,
    //    'search'              => array(
    //        'file'   => 'include/search.inc.php',
    //        'func'   => 'XXXX_search'),
    //    'hasComments'         => 1,
    //    'comments'              => array(
    //        'pageName'   => 'index.php',
    //        'itemName'   => 'id'),

    // Install/Update
    'onInstall'           => 'include/oninstall.php',
    'onUpdate'            => 'include/onupdate.php'//  'onUninstall'         => 'include/onuninstall.php'

];

// ------------------- Mysql ------------------- //
$modversion['schema'] = 'sql/schema.yml';

// Tables created by sql file (without prefix!)
$modversion['tables'] = [
    $moduleDirName . '_listing',
    $moduleDirName . '_categories',
    $moduleDirName . '_ip_log'
];

// ------------------- Templates ------------------- //

$modversion['templates'] = [
    ['file' => 'alumni_adlist.tpl', 'description' => ''],
    ['file' => 'alumni_category.tpl', 'description' => ''],
    ['file' => 'alumni_index.tpl', 'description' => ''],
    ['file' => 'alumni_item.tpl', 'description' => ''],
    ['file' => 'alumni_search.tpl', 'description' => ''],
    ['file' => 'alumni_sendfriend.tpl', 'description' => ''],
    ['file' => '/admin/alumni_admin_cat.tpl', 'description' => ''],
    ['file' => '/admin/alumni_admin_listing.tpl', 'description' => ''],
    ['file' => '/admin/alumni_admin_moderated.tpl', 'description' => ''],
    ['file' => '/admin/alumni_admin_permissions.tpl', 'description' => ''],
    ['file' => '/blocks/alumni_block_new.tpl', 'description' => '']
];

// ------------------- Blocks ------------------- //
//blocks should or don't have have hardcoded numbers?
/*
$modversion['blocks'][] = array(
    'file'        => 'alumni.php',
    'name'        => constant($blocksLang . '_BNAME'),
    'description' => constant($blocksLang . '_BNAME_DESC'),
    'show_func'   => 'alumni_show',
    'edit_func'   => 'alumni_edit',
    'template'    => 'alumni_block_new.tpl',
    //    'can_clone'     => true,
    'options'     => 'date|10|25|0');
*/
$modversion['blocks'][] = array(
    'file'        => 'alumni.php',
    'name'        => AlumniLocale::_BNAME'),
    'description' => AlumniLocale::_BNAME_DESC'),
    'show_func'   => 'alumni_show',
    'edit_func'   => 'alumni_edit',
    'template'    => 'alumni_block_new.tpl',
    'can_clone'   => true,
    'options'     => 'date|10|25|0');

// Search
$modversion['hasSearch'] = 1;

$i = 0;

// $xoopsModuleConfig['alumni_moderated']
$modversion['config'][] = [
    'name'        => 'alumni_moderated',
    'title'       => AlumniLocale::CONF_MODERATE,
    'description' => '',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => '0',
    'options'     => []
];

// $xoopsModuleConfig['alumni_per_page']
$modversion['config'][] = [
    'name'        => 'alumni_per_page',
    'title'       => AlumniLocale::CONF_PERPAGE,
    'description' => '',
    'formtype'    => 'select',
    'valuetype'   => 'int',
    'default'     => '10',
    'options'     => ['10' => 10, '15' => 15, '20' => 20, '25' => 25, '30' => 30, '35' => 35, '40' => 40, '50' => 50]
];

// $xoopsModuleConfig['alumni_new_listing']
$modversion['config'][] = [
    'name'        => 'alumni_new_listing',
    'title'       => AlumniLocale::CONF_SHOW_NEW,
    'description' => AlumniLocale::CONF_ONHOME,
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => '1',
    'options'     => []
];

// $xoopsModuleConfig['alumni_newalumni']
$modversion['config'][] = [
    'name'        => 'alumni_newalumni',
    'title'       => AlumniLocale::CONF_NUMNEW,
    'description' => AlumniLocale::CONF_ONHOME,
    'formtype'    => 'textbox',
    'valuetype'   => 'int',
    'default'     => '10',
    'options'     => []
];

// $xoopsModuleConfig['alumni_countday']
$modversion['config'][] = [
    'name'        => 'alumni_countday',
    'title'       => AlumniLocale::CONF_NEWTIME,
    'description' => AlumniLocale::CONF_INDAYS,
    'formtype'    => 'textbox',
    'valuetype'   => 'int',
    'default'     => '3',
    'options'     => []
];

// $xoopsModuleConfig['alumni_photomax']
$modversion['config'][] = [
    'name'        => 'alumni_photomax',
    'title'       => AlumniLocale::CONF_MAXFILESIZE,
    'description' => AlumniLocale::CONF_INBYTES,
    'formtype'    => 'textbox',
    'valuetype'   => 'int',
    'default'     => '500000',
    'options'     => []
];

// $xoopsModuleConfig['alumni_maxwide']
$modversion['config'][] = [
    'name'        => 'alumni_maxwide',
    'title'       => AlumniLocale::CONF_MAXWIDE,
    'description' => $AlumniLocale::CONF_INPIXEL,
    'formtype'    => 'textbox',
    'valuetype'   => 'int',
    'default'     => '700',
    'options'     => []
];

// $xoopsModuleConfig['alumni_maxhigh']
$modversion['config'][] = [
    'name'        => 'alumni_maxhigh',
    'title'       => AlumniLocale::CONF_MAXHIGH,
    'description' => AlumniLocale::CONF_INPIXEL,
    'formtype'    => 'textbox',
    'valuetype'   => 'int',
    'default'     => '1000',
    'options'     => []
];


// $xoopsModuleConfig['alumni_showsubcat']
$modversion['config'][] = [
    'name'        => 'alumni_showsubcat',
    'title'       => AlumniLocale::CONF_DISPLSUBCAT,
    'description' => AlumniLocale::CONF_ONHOME,
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => '1',
    'options'     => []
];

// $xoopsModuleConfig['alumni_numsubcat']
$modversion['config'][] = [
    'name'        => 'alumni_numsubcat',
    'title'       => AlumniLocale::CONF_NUMSUBCAT,
    'description' => '',
    'formtype'    => 'textbox',
    'valuetype'   => 'int',
    'default'     => '4',
    'options'     => []
];

// $xoopsModuleConfig['alumni_csortorder']
$modversion['config'][] = [
    'name'        => 'alumni_csortorder',
    'title'       => AlumniLocale::CONF_CORDER,
    'description' => '',
    'formtype'    => 'select',
    'valuetype'   => 'text',
    'default'     => 'title',
    'options'     => [AlumniLocale::CONF_ORDERALPHA => 'title', AlumniLocale::CONF_ORDERPERSONAL => 'ordre']
];

// $xoopsModuleConfig['alumni_lsortorder']
$modversion['config'][] = [
    'name'        => 'alumni_lsortorder',
    'title'       => AlumniLocale::CONF_LORDER,
    'description' => '',
    'formtype'    => 'select',
    'valuetype'   => 'text',
    'default'     => 'name',
    'options'     => [AlumniLocale::CONF_ORDER_DATE => 'date DESC', AlumniLocale::CONF_ORDER_NAME => 'name ASC', AlumniLocale::CONF_ORDER_POP => 'hits DESC']
];

// $xoopsModuleConfig['alumni_form_options'] - Use WYSIWYG Editors?

$editors                                 = XoopsLists::getDirListAsArray(XOOPS_ROOT_PATH . '/class/xoopseditor');

$modversion['config'][] = [
    'name'        => 'alumni_form_options',
    'title'       => AlumniLocale::CONF_EDITOR,
    'description' => AlumniLocale::CONF_LIST_EDITORS,
    'formtype'    => 'select',
    'valuetype'   => 'text',
    'default'     => 'dhtmltextarea',
    'options'     => $editors
];


// $xoopsModuleConfig['alumni_use_captcha']
$modversion['config'][] = [
    'name'        => 'alumni_use_captcha',
    'title'       => AlumniLocale::CONF_USE_CAPTCHA,
    'description' => '',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => '1',
    'options'     => []
];

// $xoopsModuleConfig['alumni_use_code']
$modversion['config'][] = [
    'name'        => 'alumni_use_code',
    'title'       => AlumniLocale::CONF_USE_INDEX_CODE,
    'description' => AlumniLocale::CONF_USE_INDEX_CODE_DESC,
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => '1',
    'options'     => []
];

// $xoopsModuleConfig['alumni_use_banner']
$modversion['config'][] = [
    'name'        => 'alumni_use_banner',
    'title'       => AlumniLocale::CONF_USE_BANNER,
    'description' => AlumniLocale::CONF_USE_BANNER_DESC,
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => '1',
    'options'     => []
];

// $xoopsModuleConfig['alumni_index_code']
$modversion['config'][] = [
    'name'        => 'alumni_index_code',
    'title'       => AlumniLocale::CONF_INDEX_CODE,
    'description' => AlumniLocale::CONF_INDEX_CODE_DESC,
    'formtype'    => 'textarea',
    'valuetype'   => 'text',
    'default'     => ''

];

// $xoopsModuleConfig['alumni_index_code_place']
$modversion['config'][] = [
    'name'        => 'alumni_code_place',
    'title'       => AlumniLocale::CONF_INDEX_CODE_PLACE,
    'description' => AlumniLocale::CONF_INDEX_CODE_PLACE_DESC,
    'formtype'    => 'textbox',
    'valuetype'   => 'text',
    'default'     => '5'
];

// $xoopsModuleConfig['alumni_offer_search'] - added for optional search
$modversion['config'][] = [
    'name'        => 'alumni_offer_search',
    'title'       => AlumniLocale::CONF_OFFER_SEARCH,
    'description' => AlumniLocale::CONF_OFFER_SEARCH_DESC,
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => '1',
    'options'     => []
];

$modversion['notification']    = [];
$modversion['hasNotification'] = 1;
