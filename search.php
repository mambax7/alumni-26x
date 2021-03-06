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
 * XOOPS global search
 *
 * @copyright       XOOPS Project https://xoops.org/
 * @license         GNU GPL 2 or later (http://www.gnu.org/licenses/gpl-2.0.html)
 * @package         core
 * @since           2.0.0
 * @author          Kazumi Ono (AKA onokazu)
 * @author          Taiwen Jiang <phppp@users.sourceforge.net>
 * @author          Edited by John Mordo (jlm69)
 * @version         $Id$
 */

use Xoops\Core\Request;
use Xoops\Core\Kernel\Handlers\XoopsUser;

include dirname(dirname(__DIR__)) . '/mainfile.php';
include_once __DIR__ . '/header.php';
include_once __DIR__ . '/include/common.php';
$alumni = Alumni::getInstance();
$search = Search::getInstance();
if (!$search->getConfig('enable_search')) {
    header('Location: ' . XOOPS_URL . '/index.php');
    exit();
}

$xoops = Xoops::getInstance();

$action  = Request::getCmd('action', 'search');
$query   = Request::getString('query', '');
$andor   = Request::getWord('andor', 'AND');
$mid     = Request::getInt('mid', 0);
$uid     = Request::getInt('uid', 0);
$start   = Request::getInt('start', 0);
$limit   = Request::getInt('start', 1000);
$by_cat  = Request::getInt('by_cat');
$mids    = Request::getArray('mids', []);
$xmid    = $xoops->module->getVar('mid');
$queries = [];

if ('results' === $action) {
    if ('' == $query && ('' == $by_cat)) {
        $xoops->redirect('index.php', 1, _MD_SEARCH_PLZENTER);
    }
} else {
    if ('showall' === $action) {
        if ('' == $query || empty($mid)) {
            $xoops->redirect('index.php', 1, _MD_SEARCH_PLZENTER);
        }
    } else {
        if ('showallbyuser' === $action) {
            if (empty($mid) || empty($uid)) {
                $xoops->redirect('index.php', 1, _MD_SEARCH_PLZENTER);
            }
        }
    }
}

$gperm_handler     = $xoops->getHandlerGroupPermission();
$available_modules = $gperm_handler->getItemIds('module_read', $xoops->getUserGroups());
$available_plugins = \Xoops\Module\Plugin::getPlugins('search');

if ('search' === $action) {
    $xoops->header();
    /* @var $formHandler SearchSearchForm */
    $formHandler = $alumni->getForm(null, 'search');
    $form        = $formHandler->alumni_getSearchFrom($andor, $queries, $mids, $mid, $by_cat);
    $form->display();
    $xoops->footer();
}
if ('OR' !== $andor && 'exact' !== $andor && 'AND' !== $andor) {
    $andor = 'AND';
}

$ignored_queries = []; // holds kewords that are shorter than allowed minmum length
$queries_pattern = [];
$myts            = \Xoops\Core\Text\Sanitizer::getInstance();
if ('showallbyuser' !== $action) {
    if ('exact' !== $andor) {
        $temp_queries = str_getcsv($query, ' ', '"');
        foreach ($temp_queries as $q) {
            $q = trim($q);
            if (mb_strlen($q) >= $search->getConfig('keyword_min')) {
                $queries[]         = $q;
                $queries_pattern[] = '~(' . $q . ')~sUi';
            } else {
                $ignored_queries[] = $q;
            }
        }
        if (0 == count($queries) && ('' == $by_cat)) {
            $xoops->redirect('index.php', 2, sprintf(XoopsLocale::EF_KEYWORDS_MUST_BE_GREATER_THAN, $search->getConfig('keyword_min')));
        }
    } else {
        $query = trim($query);
        if (mb_strlen($query) < $search->getConfig('keyword_min')) {
            $xoops->redirect('index.php', 2, sprintf(XoopsLocale::EF_KEYWORDS_MUST_BE_GREATER_THAN, $search->getConfig('keyword_min')));
        }
        $queries           = [$query];
        $queries_pattern[] = '~(' . $query . ')~sUi';
    }
}

switch ($action) {
    case 'results':
        $module_handler = $xoops->getHandlerModule();
        $criteria       = new CriteriaCompo();
        $criteria->add(new Criteria('dirname', "('" . implode("','", array_keys($available_plugins)) . "')", 'IN'));
        $modules = $module_handler->getObjectsArray($criteria, true);
        if (empty($mids) || !is_array($mids)) {
            unset($mids);
            $mids = array_keys($modules);
        }
        $xoops->header('module:alumni/alumni_search.tpl');
        $nomatch = true;
        $xoops->tpl()->assign('search', true);
        $xoops->tpl()->assign('queries', $queries);
        $xoops->tpl()->assign('ignored_words', sprintf(XoopsLocale::F_KEYWORDS_SHORTER_THAN_WILL_BE_IGNORED, $search->getConfig('keyword_min')));
        $xoops->tpl()->assign('ignored_queries', $ignored_queries);

        $modules_result = [];
        foreach ($mids as $mid) {
            $mid = (int)$mid;
            /* @var $module XoopsModule */
            $module = $modules[$xmid];
            /* @var $plugin SearchPluginInterface */
            $plugin      = \Xoops\Module\Plugin::getPlugin($module->getVar('dirname'), 'search');
            $all_results = $plugin->search($queries, $andor, $limit, 0, null);
            $count2      = count($all_results);
            $results     = $plugin->search($queries, $andor, 5, 0, null);
            $count       = count($results);

            $mid = $module->getVar('mid');

            $xoops->tpl()->assign('sr_showing', '');
            if ($count > 0) {
                $xoops->tpl()->assign('sr_showing', sprintf(XoopsLocale::F_SHOWING_RESULTS, $start + 1, $start + $count));
                $xoops->tpl()->assign('showing_of', AlumniLocale::OF . "$count2");
            }
            $xoops->tpl()->assign('in_category', '');
            $xoops->tpl()->assign('cat_name', '');
            if (!empty($by_cat)) {
                $cat_name                  = '';
                $alumni_categories_Handler = $xoops->getModuleHandler('category', 'alumni');
                $catObj                    = $alumni_categories_Handler->get($by_cat);
                $cat_name                  = $catObj->getVar('title');
                $xoops->tpl()->assign('in_category', AlumniLocale::INCATEGORY);
                $xoops->tpl()->assign('cat_name', "<b> :  &nbsp;&nbsp; $cat_name</b>");
            }

            $res = [];
            if (is_array($results) && $count > 0) {
                $nomatch                      = false;
                $modules_result[$mid]['name'] = $module->getVar('name');
                if (XoopsLoad::fileExists($image = $xoops->path('modules/' . $module->getVar('dirname') . '/icons/logo_large.png'))) {
                    $modules_result[$mid]['image'] = $xoops->url($image);
                } else {
                    $modules_result[$mid]['image'] = $xoops->url('images/icons/posticon2.gif');
                }
                $res = [];
                for ($i = 0; $i < $count; ++$i) {
                    if (!preg_match("/^http[s]*:\/\//i", $results[$i]['link'])) {
                        $res[$i]['link'] = $xoops->url('modules/' . $module->getVar('dirname') . '/' . $results[$i]['link']);
                    } else {
                        $res[$i]['link'] = $results[$i]['link'];
                    }
                    $res[$i]['title']          = $myts->htmlSpecialChars($results[$i]['title']);
                    $res[$i]['title_highligh'] = preg_replace($queries_pattern, "<span class='searchHighlight'>$1</span>", $myts->htmlSpecialChars($results[$i]['title']));
                    if (!empty($results[$i]['uid'])) {
                        $res[$i]['uid']   = (int)$results[$i]['uid'];
                        $res[$i]['uname'] = XoopsUser::getUnameFromId($results[$i]['uid'], true);
                    }
                    $res[$i]['time']    = !empty($results[$i]['time']) ? XoopsLocale::formatTimestamp((int)$results[$i]['time']) : '';
                    $res[$i]['content'] = empty($results[$i]['content']) ? '' : preg_replace($queries_pattern, "<span class='searchHighlight'>$1</span>", $results[$i]['content']);
                }
                if ($count >= 5) {
                    $search_url                         = XOOPS_URL . '/modules/alumni/search.php?query=' . urlencode(stripslashes(implode(' ', $queries)));
                    $search_url                         .= "&mid={$mid}&action=showall&andor={$andor}&by_cat=$by_cat";
                    $modules_result[$mid]['search_url'] = htmlspecialchars($search_url);
                }
            }
            if (count($res) > 0) {
                $modules_result[$mid]['result'] = $res;
            }
        }
        unset($results);
        unset($module);

        $xoops->tpl()->assign('modules', $modules_result);

        /* @var $formHandler SearchSearchForm */
        $formHandler = $alumni->getForm(null, 'search');
        $form        = $formHandler->alumni_getSearchFrom($andor, $queries, $mids, $mid, $by_cat);
        $form->display();
        break;

    case 'showall':
    case 'showallbyuser':
        $xoops->header('module:search/search.tpl');
        $xoops->tpl()->assign('search', true);
        $xoops->tpl()->assign('queries', $queries);
        $xoops->tpl()->assign('ignored_words', sprintf(_MA_ALUMNI_IGNOREDWORDS, $search->getConfig('keyword_min')));
        $xoops->tpl()->assign('ignored_queries', $ignored_queries);

        $module_handler = $xoops->getHandlerModule();
        $module         = $xoops->getModuleById($mid);
        /* @var $plugin SearchPluginInterface */
        $plugin   = \Xoops\Module\Plugin::getPlugin($module->getVar('dirname'), 'search');
        $results  = $plugin->search($queries, $andor, 20, $start, $uid);
        $results2 = $plugin->search($queries, $andor, '', $start, $uid);

        $modules_result[$mid]['name']  = $module->getVar('name');
        $modules_result[$mid]['image'] = $xoops->url('modules/' . $module->getVar('dirname') . '/icons/logo_large.png');

        $count  = count($results);
        $count2 = count($results2);

        $xoops->tpl()->assign('sr_showing', '');
        if (is_array($results) && $count > 0) {
            $next_results = $plugin->search($queries, $andor, 1, $start + 20, $uid);
            $next_count   = count($next_results);
            $has_next     = false;
            if (is_array($next_results) && 1 == $next_count) {
                $has_next = true;
            }
            $xoops->tpl()->assign('sr_showing', sprintf(XoopsLocale::F_SHOWING_RESULTS, $start + 1, $start + $count));
            $xoops->tpl()->assign('showing_of', constant($main_lang . '_OF') . "&nbsp;$count2");

            if (!empty($by_cat)) {
                $cat_name                  = '';
                $alumni_categories_Handler = $xoops->getModuleHandler('category', 'alumni');
                $catObj                    = $alumni_categories_Handler->get($by_cat);
                $cat_name                  = $catObj->getVar('title');
                $xoops->tpl()->assign('in_category', AlumniLocale::INCATEGORY);
                $xoops->tpl()->assign('cat_name', "<b> :  &nbsp;&nbsp; $cat_name</b>");
            }

            $res = [];
            for ($i = 0; $i < $count; ++$i) {
                if (isset($results[$i]['image']) && '' != $results[$i]['image']) {
                    $res[$i]['image'] = $xoops->url('modules/' . $module->getVar('dirname') . '/' . $results[$i]['image']);
                } else {
                    $res[$i]['image'] = $xoops->url('images/icons/posticon2.gif');
                }
                if (!preg_match("/^http[s]*:\/\//i", $results[$i]['link'])) {
                    $res[$i]['link'] = $xoops->url('modules/' . $module->getVar('dirname') . '/' . $results[$i]['link']);
                } else {
                    $res[$i]['link'] = $results[$i]['link'];
                }
                $res[$i]['title'] = $myts->htmlSpecialChars($results[$i]['title']);
                if (isset($queries_pattern)) {
                    $res[$i]['title_highligh'] = preg_replace($queries_pattern, "<span class='searchHighlight'>$1</span>", $myts->htmlSpecialChars($results[$i]['title']));
                } else {
                    $res[$i]['title_highligh'] = $myts->htmlSpecialChars($results[$i]['title']);
                }
                if (!empty($results[$i]['uid'])) {
                    $res[$i]['uid']   = @(int)$results[$i]['uid'];
                    $res[$i]['uname'] = XoopsUser::getUnameFromId($results[$i]['uid'], true);
                }
                $res[$i]['time']    = !empty($results[$i]['time']) ? ' (' . XoopsLocale::formatTimestamp((int)$results[$i]['time']) . ')' : '';
                $res[$i]['content'] = empty($results[$i]['content']) ? '' : preg_replace($queries_pattern, "<span class='searchHighlight'>$1</span>", $results[$i]['content']);
            }
            if (count($res) > 0) {
                $modules_result[$mid]['result'] = $res;
            }

            $search_url = XOOPS_URL . '/modules/alumni/search.php?query=' . urlencode(stripslashes(implode(' ', $queries)));
            $search_url .= "&mid={$mid}&action={$action}&andor={$andor}&by_cat=$by_cat";
            if ('showallbyuser' === $action) {
                $search_url .= "&uid={$uid}";
            }
            if ($start > 0) {
                $prev                         = $start - 20;
                $search_url_prev              = $search_url . "&start={$prev}";
                $modules_result[$mid]['prev'] = htmlspecialchars($search_url_prev);
            }
            if (false != $has_next) {
                $next                         = $start + 20;
                $search_url_next              = $search_url . "&start={$next}";
                $modules_result[$mid]['next'] = htmlspecialchars($search_url_next);
            }
            $xoops->tpl()->assign('modules', $modules_result);
        }

        /* @var $formHandler SearchSearchForm */
        $formHandler = $alumni->getForm(null, 'search');
        $form        = $formHandler->alumni_getSearchFrom($andor, $queries, $mids, $mid, $by_cat);
        $form->display();
        break;
}
$xoops->footer();
