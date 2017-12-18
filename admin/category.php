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
use Xoops\Core\Request;

include __DIR__ . '/admin_header.php';
$xoops = Xoops::getInstance();
$xoops->header();

$op = Request::getCmd('op', 'list');
$categoriesHandler = $xoops->getModuleHandler('category', 'alumni');
switch ($op) {
    case 'list':
    default:
        $categoriesHandler = $xoops->getModuleHandler('category', 'alumni');
        $indexAdmin = new \Xoops\Module\Admin();
        echo $indexAdmin->displayNavigation('category.php');
        $indexAdmin->addItemButton(AlumniLocale::ADD_CAT, 'category.php?op=new_category', 'add');
        echo $indexAdmin->renderButton('left', '');

        $limit = Request::getInt('limit', 10);
        $start = Request::getInt('start', 0);
        $order        = $xoops->getModuleConfig('alumni_csortorder');
        $catCriteria = new CriteriaCompo();
        $catCriteria->setSort('cid');
        $catCriteria->setOrder($order);
        $catCriteria->setStart($start);
        $catCriteria->setLimit($limit);
        $numrows = $categoriesHandler->getCount();
        $categoryArray = $categoriesHandler->getall($catCriteria);

        //Function that allows display child categories
        function alumniCategoryDisplayChildren($cid = 0, $categoryArray, $prefix = '', $order = '', &$class) {
            $xoops = Xoops::getInstance();

            $moduleDirName = basename(dirname(__DIR__));
            $prefix = $prefix . '<img src=\'' . XOOPS_URL . "/modules/{$moduleDirName}/images/arrow.gif'>";
            foreach (array_keys($categoryArray) as $i) {
                $cid   = $categoryArray[$i]->getVar('cid');
                $pid   = $categoryArray[$i]->getVar('pid');
                $title = $categoryArray[$i]->getVar('title');
                $img   = $categoryArray[$i]->getVar('img');
                $order = $categoryArray[$i]->getVar('ordre');

                echo '<tr class="' . $class . '">';
                echo '<td align="left">' . $prefix . '&nbsp;' . $categoryArray[$i]->getVar('title') . '</td>';
                echo '<td align="center"><img src="' . XOOPS_URL . "/modules/{$moduleDirName}/images/cat/" . $categoryArray[$i]->getVar('img')
                     . '" height="16px" title="img" alt="img"></td>';
                echo '<td align="center">' . $categoryArray[$i]->getVar('ordre') . '</td>';
                echo "<td align='center' width='10%'>
						<a href='category.php?op=edit_category&cid=" . $categoryArray[$i]->getVar('cid')
                     . "'><img src='../images/edit.gif' alt='" . XoopsLocale::A_EDIT . "' title='" . XoopsLocale::A_EDIT . "'></a>
						<a href='category.php?op=delete_category&cid=" . $categoryArray[$i]->getVar('cid')
                     . "'><img src='../images/dele.gif' alt='" . XoopsLocale::A_DELETE . "' title='" . XoopsLocale::A_DELETE . "'></a></td></tr>";
                $class = ($class == "even") ? "odd" : "even";

                $categoriesHandler = $xoops->getModuleHandler('category', 'alumni');
                $criteria2                 = new CriteriaCompo();
                $criteria2->add(new Criteria('pid', $categoryArray[$i]->getVar('cid')));
                $criteria2->setSort('title');
                $criteria2->setOrder('ASC');
                $cat_pid = $categoriesHandler->getAll($criteria2);
                $num_pid = $categoriesHandler->getCount();
                if ($num_pid != 0) {
                    alumniCategoryDisplayChildren($cid, $cat_pid, $prefix, $order, $class);
                }
            }
        }

        if ($numrows > 0) {
            if ($numrows > 1) {
                if ($numrows > $limit) {
                    $cat_url[] = 'limit=' . $limit;
                    $cat_url[] = 'orderby=' . $order;
                if (isset($cat_url)) {
                        $args = implode('&amp;', $cat_url);
                }
                    $nav = new XoopsPageNav($numrows, $limit, $start, 'start', $args);
                    echo '' . $nav->renderNav(5, '', 'center') . '';

                }
            }

            echo "<table width='100%' cellspacing='1' class='outer'>
		<tr>
		<th align=\"center\">" . AlumniLocale::CATEGORY_TITLE . "</th>
		<th align=\"center\">" . AlumniLocale::IMGCAT . "</th>
		<th align=\"center\">" . XoopsLocale::ORDER . "</th>
		<th align='center' width='10%'>" . XoopsLocale::ACTIONS . "</th></tr>";
            $class  = "odd";
            $prefix = "<img src='" . XOOPS_URL . "/modules/{$moduleDirName}/images/arrow.gif'>";

            $categoryArray2 = $categoriesHandler->getall($catCriteria);

            foreach (array_keys($categoryArray2) as $i) {
                if ($categoryArray2[$i]->getVar('pid') == 0) {
                    $cid   = $categoryArray2[$i]->getVar('cid');
                    $img   = $categoryArray2[$i]->getVar('img');
                    $title = $categoryArray2[$i]->getVar('title');
                    $order = $categoryArray2[$i]->getVar('ordre');
                    echo "<tr class='" . $class . "'>";
                    echo "<td align=\"left\">" . $prefix . "&nbsp;" . $categoryArray2[$i]->getVar("title") . "</td>";
                    echo "<td align=\"center\"><img src=\"" . XOOPS_URL . "/modules/{$moduleDirName}/images/cat/"
                         . $categoryArray2[$i]->getVar("img")
                         . "\" height=\"16px\" title=\"img\" alt=\"img\"></td>";
                    echo "<td align=\"center\">" . $categoryArray2[$i]->getVar("ordre") . "</td>";
                    echo "<td align='center' width='10%'>
				<a href='category.php?op=edit_category&cid="
                         . $categoryArray2[$i]->getVar("cid") . "'><img src='../images/edit.gif' alt='" . XoopsLocale::A_EDIT
                         . "' title='" . XoopsLocale::A_EDIT . "'></a>
				<a href='category.php?op=delete_category&cid="
                         . $categoryArray2[$i]->getVar("cid") . "'><img src='../images/dele.gif' alt='"
                         . XoopsLocale::A_DELETE . "' title='" . XoopsLocale::A_DELETE . "'></a></td></tr>";
                    $class     = ($class == "even") ? "odd" : "even";
                    $criteria3 = new CriteriaCompo();
                    $criteria3->add(new Criteria("pid", $cid));
                    $criteria3->setSort("title");
                    $criteria3->setOrder("ASC");
                    $pid     = $categoriesHandler->getall($criteria3);
                    $num_pid = $categoriesHandler->getCount();

                    if ($pid != 0) {
                        alumniCategoryDisplayChildren($cid, $pid, $prefix, "title", $class);
                    }
                }
            }
            echo '</table><br /><br />';
        }

        break;

    case 'new_category':
        $xoops->header();
        $indexAdmin = new \Xoops\Module\Admin();
        $indexAdmin->displayNavigation('category.php');
        $indexAdmin->addItemButton(AlumniLocale::LIST_CATS, 'category.php');
        echo $indexAdmin->renderButton('left', '');
        $categoriesHandler = $xoops->getModuleHandler('category', 'alumni');
        $obj  = $categoriesHandler->create();
        $form = $xoops->getModuleForm($obj, 'category');
        $form->display();
        break;

    case 'save_category':
        if (!$xoops->security()->check()) {
            $xoops->redirect('category.php', 3, implode(',', $xoops->security()->getErrors()));
        }
         $cid = Request::getInt('cid', 0);
        $categoriesHandler = $xoops->getModuleHandler('category', 'alumni');
        if (isset($cid)) {
            $obj = $categoriesHandler->get(Request::getInt('cid'));
        } else {
            $obj = $categoriesHandler->create();
        }

        $photo_old = Request::getString('photo_old', '');
        $destination = XOOPS_ROOT_PATH . "/modules/{$moduleDirName}/photos/school_photos";
	$del_photo = Request::getInt('del_photo', 0);
        if (isset($del_photo)) {
        if ($del_photo == '1') {
            if (@file_exists('' . $destination . '/' . $photo_old) . '') {
                unlink('' . $destination . '/' . $photo_old . '');
            }
            $obj->setVar('scphoto', '');
        }
        }
        
        $obj->setVar('pid', Request::getInt('pid'));
        $obj->setVar('title', Request::getString('title'));

        include_once XOOPS_ROOT_PATH . '/class/uploader.php';
        $uploaddir         = XOOPS_ROOT_PATH . '/modules/alumni/images/cat/';
        $photomax          = $xoops->getModuleConfig('alumni_photomax');
        $maxwide           = $xoops->getModuleConfig('alumni_maxwide');
        $maxhigh           = $xoops->getModuleConfig('alumni_maxhigh');
        $allowedMimetypes = array('image/gif', 'image/jpg', 'image/jpeg', 'image/pjpeg', 'image/png', 'image/x-png');
        $uploader          = new XoopsMediaUploader($uploaddir, $allowedMimetypes, $photomax, $maxwide, $maxhigh);
        if ($uploader->fetchMedia($_POST['xoops_upload_file'][0])) {
            $uploader->setPrefix('category_img_');
           $uploader->fetchMedia($_POST['xoops_upload_file'][0]);
            if (!$uploader->upload()) {
                $errors = $uploader->getErrors();
                $xoops->redirect('javascript:history.go(-1)', 3, $errors);
            } else {
                $obj->setVar('img', $uploader->getSavedFileName());
            }
        } else {
            $obj->setVar('img', Request::getString('img'));
        }

        $obj->setVar('ordre', Request::getInt('ordre'));
        $obj->setVar('scaddress', Request::getString('scaddress'));
        $obj->setVar('scaddress2', Request::getString('scaddress2'));
        $obj->setVar('sccity', Request::getString('sccity'));
        $obj->setVar('scstate', Request::getString('scstate'));
        $obj->setVar('sczip', Request::getString('sczip'));
        $obj->setVar('scphone', Request::getString('scphone'));
        $obj->setVar('scfax', Request::getString('scfax'));
        $obj->setVar('scmotto', Request::getString('scmotto'));
        $obj->setVar('scurl', Request::getString('scurl'));

        $date = time();
        if (!empty($_FILES['scphoto']['name'])) {
            include_once XOOPS_ROOT_PATH . '/class/uploader.php';
            $uploaddir         = XOOPS_ROOT_PATH . "/modules/{$moduleDirName}/photos/school_photos";
            $photomax          = $xoops->getModuleConfig('alumni_photomax');
            $maxwide           = $xoops->getModuleConfig('alumni_maxwide');
            $maxhigh           = $xoops->getModuleConfig('alumni_maxhigh');
            $allowedMimetypes = array('image/gif', 'image/jpg', 'image/jpeg', 'image/pjpeg', 'image/png', 'image/x-png');
            $uploader          = new XoopsMediaUploader($uploaddir, $allowedMimetypes, $photomax, $maxwide, $maxhigh);
            if ($uploader->fetchMedia($_POST['xoops_upload_file'][1])) {
                $uploader->setTargetFileName($date . '_' . $_FILES['scphoto']['name']);
                $uploader->fetchMedia($_POST['xoops_upload_file'][1]);
                if (!$uploader->upload()) {
                    $errors = $uploader->getErrors();
                    $xoops->redirect('javascript:history.go(-1)', 3, $errors);
                } else {
                    $obj->setVar('scphoto', $uploader->getSavedFileName());
                }
            } else {
                $obj->setVar('scphoto', Request::getString('scphoto'));
            }
        }

        if ($categoriesHandler->insert($obj)) {
            $xoops->redirect('category.php', 3, AlumniLocale::FORMOK);
        }
        echo $obj->getHtmlErrors();
        $form = $xoops->getModuleForm($obj, 'category');
        $form->display();
        break;

    case 'edit_category':

	$cid = Request::getInt('cid', 0);
        $xoops = Xoops::getInstance();
        $xoops->header();
        $indexAdmin = new \Xoops\Module\Admin();
        $indexAdmin->displayNavigation('category.php');
        $indexAdmin->addItemButton(AlumniLocale::LIST_CATS, 'alumni.php', 'list');
        $indexAdmin->renderButton('left', '');
        $obj  = $categoriesHandler->get($cid);
        $form = $xoops->getModuleForm($obj, 'category');
        $form->display();
        break;

    case 'delete_category':
        $xoops = Xoops::getInstance();
        $xoops->header();
        $cid = Request::getInt('cid', 0);
        $ok = Request::getInt('ok', 0);
        $obj = $categoriesHandler->get($cid);
        if (isset($ok) && $ok == 1) {
            if (!$xoops->security()->check()) {
                $xoops->redirect('category.php', 3, implode(',', $xoops->security()->getErrors()));
            }
            if ($categoriesHandler->delete($obj)) {
                $xoops->redirect('category.php', 3, AlumniLocale::FORMDELOK);
            } else {
                echo $obj->getHtmlErrors();
            }
        } else {
            echo $xoops->confirm(
                array('ok' => 1, 'cid' => $cid, 'op' => 'delete_category'),
                'category.php',
                XoopsLocale::Q_ARE_YOU_SURE_YOU_WANT_TO_DELETE_THIS_ITEM
                . '<br /><span class="red">' . $obj->getvar('title') . '<span>'
            );
        }
        break;
}

$xoops->footer();
