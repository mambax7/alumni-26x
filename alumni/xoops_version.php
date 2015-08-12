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
$moduleDirName    = basename(__DIR__);

$modversion                = array();
$modversion['name']        = AlumniLocale::MODULE_NAME;
$modversion['description'] = AlumniLocale::MODULE_DESC;
$modversion['version']     = '3.1';
$modversion['author']      = 'John Mordo';
$modversion['nickname']    = 'jlm69';
$modversion['credits']     = 'John Mordo';
$modversion['license']     = 'GNU GPL 2.0 or later';
$modversion['license_url'] = 'http://www.gnu.org/licenses/gpl-2.0.html';
$modversion['official']    = 0;
$modversion['help']        = 'page=help';
$modversion['image']       = 'images/alumni_slogo.png';
$modversion['dirname']     = $moduleDirName;

$modversion['release_date']        = '2015/06/01';
$modversion['module_website_url']  = 'http://www.xoops.org/';
$modversion['module_website_name'] = 'XOOPS';
$modversion['module_status']       = 'ALPHA 2';
$modversion['min_php']             = '5.3.7';
$modversion['min_xoops']           = '2.6.0';
$modversion['min_db']              = array('mysql' => '5.0.7', 'mysqli' => '5.0.7');

// paypal
$modversion['paypal']                  = array();
$modversion['paypal']['business']      = 'admin@jlmzone.com';
$modversion['paypal']['item_name']     = 'Donation : ' . AlumniLocale::MODULE_DESC;
$modversion['paypal']['amount']        = 0;
$modversion['paypal']['currency_code'] = 'USD';

$modversion['system_menu'] = 1;

// Admin things
$modversion['hasAdmin']   = 1;
$modversion['adminindex'] = 'admin/index.php';
$modversion['adminmenu']  = 'admin/menu.php';

// JQuery
$modversion['jquery'] = 1;

// Menu
$modversion['hasMain'] = 1;

// Sql file (must contain sql generated by phpMyAdmin or phpPgAdmin)
$modversion['schema'] = 'sql/schema.yml';
$modversion['sqlfile']['mysql'] = 'sql/mysql.sql';

// Tables created by sql file (without prefix!)
$modversion['tables'][1] = 'alumni_listing';
$modversion['tables'][2] = 'alumni_category';
$modversion['tables'][3] = 'alumni_ip_log';

// Blocks
$modversion['blocks'][1]['file']        = 'alumni.php';
$modversion['blocks'][1]['name']        = AlumniLocale::CONF_BNAME;
$modversion['blocks'][1]['description'] = AlumniLocale::CONF_BNAME_DESC;
$modversion['blocks'][1]['show_func']   = 'alumni_show';
$modversion['blocks'][1]['edit_func']   = 'alumni_edit';
$modversion['blocks'][1]['template']    = 'alumni_block_new.tpl';
//$modversion['blocks'][1]['can_clone'] = 'true' ;
$modversion['blocks'][1]['options'] = 'date|10|25|0';

// Search
$modversion['hasSearch'] = 1;

$i = 0;

// $xoopsModuleConfig['alumni_moderated']
$modversion['config'][$i]['name']        = 'alumni_moderated';
$modversion['config'][$i]['title']       = AlumniLocale::CONF_MODERATE;
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype']    = 'yesno';
$modversion['config'][$i]['valuetype']   = 'int';
$modversion['config'][$i]['default']     = '0';
$modversion['config'][$i]['options']     = array();

// $xoopsModuleConfig['alumni_per_page']
++$i;
$modversion['config'][$i]['name']        = 'alumni_per_page';
$modversion['config'][$i]['title']       = AlumniLocale::CONF_PERPAGE;
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype']    = 'select';
$modversion['config'][$i]['valuetype']   = 'int';
$modversion['config'][$i]['default']     = '10';
$modversion['config'][$i]['options']     = array('10' => 10, '15' => 15, '20' => 20, '25' => 25, '30' => 30, '35' => 35, '40' => 40, '50' => 50);

// $xoopsModuleConfig['alumni_new_listing']
++$i;
$modversion['config'][$i]['name']        = 'alumni_new_listing';
$modversion['config'][$i]['title']       = AlumniLocale::CONF_SHOW_NEW;
$modversion['config'][$i]['description'] = AlumniLocale::CONF_ONHOME;
$modversion['config'][$i]['formtype']    = 'yesno';
$modversion['config'][$i]['valuetype']   = 'int';
$modversion['config'][$i]['default']     = '1';
$modversion['config'][$i]['options']     = array();

// $xoopsModuleConfig['alumni_newalumni']
++$i;
$modversion['config'][$i]['name']        = 'alumni_newalumni';
$modversion['config'][$i]['title']       = AlumniLocale::CONF_NUMNEW;
$modversion['config'][$i]['description'] = AlumniLocale::CONF_ONHOME;
$modversion['config'][$i]['formtype']    = 'textbox';
$modversion['config'][$i]['valuetype']   = 'int';
$modversion['config'][$i]['default']     = '10';
$modversion['config'][$i]['options']     = array();

// $xoopsModuleConfig['alumni_countday']
++$i;
$modversion['config'][$i]['name']        = 'alumni_countday';
$modversion['config'][$i]['title']       = AlumniLocale::CONF_NEWTIME;
$modversion['config'][$i]['description'] = AlumniLocale::CONF_INDAYS;
$modversion['config'][$i]['formtype']    = 'textbox';
$modversion['config'][$i]['valuetype']   = 'int';
$modversion['config'][$i]['default']     = '3';
$modversion['config'][$i]['options']     = array();

// $xoopsModuleConfig['alumni_photomax']
++$i;
$modversion['config'][$i]['name']        = 'alumni_photomax';
$modversion['config'][$i]['title']       = AlumniLocale::CONF_MAXFILESIZE;
$modversion['config'][$i]['description'] = AlumniLocale::CONF_INBYTES;
$modversion['config'][$i]['formtype']    = 'textbox';
$modversion['config'][$i]['valuetype']   = 'int';
$modversion['config'][$i]['default']     = '500000';
$modversion['config'][$i]['options']     = array();

// $xoopsModuleConfig['alumni_maxwide']
++$i;
$modversion['config'][$i]['name']        = 'alumni_maxwide';
$modversion['config'][$i]['title']       = AlumniLocale::CONF_MAXWIDE;
$modversion['config'][$i]['description'] = AlumniLocale::CONF_INPIXEL;
$modversion['config'][$i]['formtype']    = 'textbox';
$modversion['config'][$i]['valuetype']   = 'int';
$modversion['config'][$i]['default']     = '700';
$modversion['config'][$i]['options']     = array();

// $xoopsModuleConfig['alumni_maxhigh']
++$i;
$modversion['config'][$i]['name']        = 'alumni_maxhigh';
$modversion['config'][$i]['title']       = AlumniLocale::CONF_MAXHIGH;
$modversion['config'][$i]['description'] = AlumniLocale::CONF_INPIXEL;
$modversion['config'][$i]['formtype']    = 'textbox';
$modversion['config'][$i]['valuetype']   = 'int';
$modversion['config'][$i]['default']     = '1000';
$modversion['config'][$i]['options']     = array();

// $xoopsModuleConfig['alumni_showsubcat']
++$i;
$modversion['config'][$i]['name']        = 'alumni_showsubcat';
$modversion['config'][$i]['title']       = AlumniLocale::CONF_DISPLSUBCAT;
$modversion['config'][$i]['description'] = AlumniLocale::CONF_ONHOME;
$modversion['config'][$i]['formtype']    = 'yesno';
$modversion['config'][$i]['valuetype']   = 'int';
$modversion['config'][$i]['default']     = '1';
$modversion['config'][$i]['options']     = array();

// $xoopsModuleConfig['alumni_numsubcat']
++$i;
$modversion['config'][$i]['name']        = 'alumni_numsubcat';
$modversion['config'][$i]['title']       = AlumniLocale::CONF_NUMSUBCAT;
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype']    = 'textbox';
$modversion['config'][$i]['valuetype']   = 'int';
$modversion['config'][$i]['default']     = '4';
$modversion['config'][$i]['options']     = array();

// $xoopsModuleConfig['alumni_csortorder']
++$i;
$modversion['config'][$i]['name']        = 'alumni_csortorder';
$modversion['config'][$i]['title']       = AlumniLocale::CONF_CORDER;
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype']    = 'select';
$modversion['config'][$i]['valuetype']   = 'text';
$modversion['config'][$i]['default']     = 'title';
$modversion['config'][$i]['options']     = array(AlumniLocale::CONF_ORDERALPHA => 'title', AlumniLocale::CONF_ORDERPERSONAL => 'ordre');

// $xoopsModuleConfig['alumni_lsortorder']
++$i;
$modversion['config'][$i]['name']        = 'alumni_lsortorder';
$modversion['config'][$i]['title']       = AlumniLocale::CONF_LORDER;
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype']    = 'select';
$modversion['config'][$i]['valuetype']   = 'text';
$modversion['config'][$i]['default']     = 'name';
$modversion['config'][$i]['options']     = array(AlumniLocale::CONF_ORDER_DATE => 'date DESC', AlumniLocale::CONF_ORDER_NAME => 'name ASC', AlumniLocale::CONF_ORDER_POP => 'hits DESC');

// $xoopsModuleConfig['alumni_form_options'] - Use WYSIWYG Editors?
++$i;
$editors                                 = XoopsLists::getDirListAsArray(XOOPS_ROOT_PATH . '/class/xoopseditor');
$modversion['config'][$i]['name']        = 'alumni_form_options';
$modversion['config'][$i]['title']       = AlumniLocale::CONF_EDITOR;
$modversion['config'][$i]['description'] = AlumniLocale::CONF_LIST_EDITORS;
$modversion['config'][$i]['formtype']    = 'select';
$modversion['config'][$i]['valuetype']   = 'text';
$modversion['config'][$i]['default']     = 'dhtmltextarea';
$modversion['config'][$i]['options']     = $editors;

// $xoopsModuleConfig['alumni_use_captcha']
++$i;
$modversion['config'][$i]['name']        = 'alumni_use_captcha';
$modversion['config'][$i]['title']       = AlumniLocale::CONF_USE_CAPTCHA;
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype']    = 'yesno';
$modversion['config'][$i]['valuetype']   = 'int';
$modversion['config'][$i]['default']     = '1';
$modversion['config'][$i]['options']     = array();

// $xoopsModuleConfig['alumni_use_code']
++$i;
$modversion['config'][$i]['name']        = 'alumni_use_code';
$modversion['config'][$i]['title']       = AlumniLocale::CONF_USE_INDEX_CODE;
$modversion['config'][$i]['description'] = AlumniLocale::CONF_USE_INDEX_CODE_DESC;
$modversion['config'][$i]['formtype']    = 'yesno';
$modversion['config'][$i]['valuetype']   = 'int';
$modversion['config'][$i]['default']     = '1';
$modversion['config'][$i]['options']     = array();

// $xoopsModuleConfig['alumni_use_banner']
++$i;
$modversion['config'][$i]['name']        = 'alumni_use_banner';
$modversion['config'][$i]['title']       = AlumniLocale::CONF_USE_BANNER;
$modversion['config'][$i]['description'] = AlumniLocale::CONF_USE_BANNER_DESC;
$modversion['config'][$i]['formtype']    = 'yesno';
$modversion['config'][$i]['valuetype']   = 'int';
$modversion['config'][$i]['default']     = '1';
$modversion['config'][$i]['options']     = array();

// $xoopsModuleConfig['alumni_index_code']
++$i;
$modversion['config'][$i]['name']        = 'alumni_index_code';
$modversion['config'][$i]['title']       = AlumniLocale::CONF_INDEX_CODE;
$modversion['config'][$i]['description'] = AlumniLocale::CONF_INDEX_CODE_DESC;
$modversion['config'][$i]['formtype']    = 'textarea';
$modversion['config'][$i]['valuetype']   = 'text';
$modversion['config'][$i]['default']     = '';

// $xoopsModuleConfig['alumni_index_code_place']
++$i;
$modversion['config'][$i]['name']        = 'alumni_code_place';
$modversion['config'][$i]['title']       = AlumniLocale::CONF_INDEX_CODE_PLACE;
$modversion['config'][$i]['description'] = AlumniLocale::CONF_INDEX_CODE_PLACE_DESC;
$modversion['config'][$i]['formtype']    = 'textbox';
$modversion['config'][$i]['valuetype']   = 'text';
$modversion['config'][$i]['default']     = '5';

// $xoopsModuleConfig['alumni_offer_search'] - added for optional search
++$i;
$modversion['config'][$i]['name']        = 'alumni_offer_search';
$modversion['config'][$i]['title']       = AlumniLocale::CONF_OFFER_SEARCH;
$modversion['config'][$i]['description'] = AlumniLocale::CONF_OFFER_SEARCH_DESC;
$modversion['config'][$i]['formtype']    = 'yesno';
$modversion['config'][$i]['valuetype']   = 'int';
$modversion['config'][$i]['default']     = '1';
$modversion['config'][$i]['options']     = array();

$modversion['notification']    = array();
$modversion['hasNotification'] = 1;