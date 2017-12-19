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
 * @copyright       XOOPS Project (https://xoops.org)
 * @license         GNU GPL 2 or later (http://www.gnu.org/licenses/gpl-2.0.html)
 * @author          trabis <lusopoemas@gmail.com>
 * @version         $Id$
 */

class AlumniCategoryForm extends Xoops\Form\ThemeForm
{
    /**
     * @param AlumniCategory|XoopsObject $obj
     */
    public function __construct(AlumniCategory $obj)
    {
	$xoops = Xoops::getInstance();
	$moduleDirName  = basename(dirname(__DIR__));
        $admin_lang = '_AM_' . strtoupper($moduleDirName);
    
	$title = sprintf($obj->isNew() ? AlumniLocale::ADD_CAT : AlumniLocale::EDIT_CAT);
	parent::__construct($title, 'form', false, 'post', true);

        include_once(XOOPS_ROOT_PATH . '/class/xoopsformloader.php');

       $this->setExtra('enctype="multipart/form-data"');

        include_once(XOOPS_ROOT_PATH . '/class/tree.php');
        $categoryHandler = $xoops->getModuleHandler('category', 'alumni');
        $arr                     = $categoryHandler->getAll();
        $mytree = new XoopsObjectTree($arr, 'cid', 'pid');

        $this->addElement(new Xoops\Form\Label(AlumniLocale::CATEGORY_PID, $mytree->makeSelBox('pid', 'title', '-', $obj->getVar('pid'), true)));
        $this->addElement(new Xoops\Form\Text(AlumniLocale::CATEGORY_TITLE, 'title', 50, 255, $obj->getVar('title')), true);

        if ($obj->isNew()) {
            $default_img = 'default.gif';
        } else {
            $default_img = str_replace('alumni/', '', $obj->getVar('img', 'e'));
        }
      
        
	$img = $obj->getVar('img') ? $obj->getVar('img') : 'default.gif';
	$imgtray_img = new Xoops\Form\ElementTray(AlumniLocale::IMGCAT,'<br>');
	$img_path = \XoopsBaseConfig::get('root-path') . '/modules/alumni/images/cat';
	
	$imgpath_img = sprintf(AlumniLocale::FORMIMAGE_PATH, $img_path);
	$imageselect_img = new Xoops\Form\Select(sprintf(XoopsLocale::F_FILE_EXISTS_IN, $img_path . '/'), 'img', $img);
	$image_array_img = XoopsLists::getImgListAsArray( $img_path );
	$imageselect_img->addOption("$default_img", $default_img);
	foreach( $image_array_img as $image_img ) {
	$imageselect_img->addOption("$image_img", $image_img);
	}
	
	$alumni_upload_url = \XoopsBaseConfig::get('url') . '/modules/alumni/images/cat';
	
	$imageselect_img->setExtra( "onchange='showImgSelected(\"image_img\", \"img\", \"\", \"\", \"" . $alumni_upload_url . "\")'");
	$imgtray_img->addElement($imageselect_img, false);
	$imgtray_img->addElement( new Xoops\Form\Label( '', "<br><img src='".$alumni_upload_url . '/' . $img . "' name='image_img' id='image_img' alt=''>" ) );

	$fileseltray_category_img = new Xoops\Form\ElementTray('<br>','<br>');
	$fileseltray_category_img->addElement(new Xoops\Form\File(AlumniLocale::FORMUPLOAD , 'img'), false);
	$fileseltray_category_img->addElement(new Xoops\Form\Label(''), false);
	$imgtray_img->addElement($fileseltray_category_img);
	$this->addElement($imgtray_img);

        $this->addElement(new Xoops\Form\Text(AlumniLocale::ORDER, 'ordre', 4, 4, $obj->getVar('ordre')), false);
        $this->addElement(new Xoops\Form\Label(AlumniLocale::IFSCHOOL, ''));

        $photo_old            = $obj->getVar('scphoto') ? $obj->getVar('scphoto') : '';
        $uploadirectory_photo = XOOPS_ROOT_PATH . "/uploads/{$moduleDirName}/photos/school_photos";
        $imgtray_photo        = new Xoops\Form\ElementTray(AlumniLocale::SCPHOTO, '<br>');
        $imgpath_photo        = sprintf(AlumniLocale::FORMIMAGE_PATH, $uploadirectory_photo);
        $fileseltray_photo    = new Xoops\Form\ElementTray('', '<br>');
        $fileseltray_photo->addElement(new XoopsFormFile(AlumniLocale::FORMUPLOAD, 'scphoto', $xoops->getModuleConfig('alumni_photomax')), false);
        if ($photo_old) {
            $fileseltray_photo->addElement(new Xoops\Form\Label(AlumniLocale::SELECTED_PHOTO, '<a href="../photos/school_photos/' . $photo_old . '">' . $photo_old . '</a>', false));
            $imgtray_checkbox = new Xoops\Form\Checkbox('', 'del_photo', 0);
            $imgtray_checkbox->addOption(1, AlumniLocale::DELPICT);
            $fileseltray_photo->addElement($imgtray_checkbox);
        }
        $imgtray_photo->addElement($fileseltray_photo);
        $this->addElement($imgtray_photo);
        $this->addElement(new Xoops\Form\Hidden('photo_old', $photo_old));
        $this->addElement(new Xoops\Form\Text(AlumniLocale::SCADDRESS, 'scaddress', 50, 255, $obj->getVar('scaddress')), false);
        $this->addElement(new Xoops\Form\Text(AlumniLocale::SCADDRESS2, 'scaddress2', 50, 255, $obj->getVar('scaddress2')), false);
        $this->addElement(new Xoops\Form\Text(AlumniLocale::SCCITY, 'sccity', 50, 255, $obj->getVar('sccity')), false);
        $this->addElement(new Xoops\Form\Text(AlumniLocale::SCSTATE, 'scstate', 50, 255, $obj->getVar('scstate')), false);
        $this->addElement(new Xoops\Form\Text(AlumniLocale::SCZIP, 'sczip', 50, 255, $obj->getVar('sczip')), false);
        $this->addElement(new Xoops\Form\Text(AlumniLocale::SCPHONE, 'scphone', 50, 255, $obj->getVar('scphone')), false);
        $this->addElement(new Xoops\Form\Text(AlumniLocale::SCFAX, 'scfax', 50, 255, $obj->getVar('scfax')), false);
        $this->addElement(new Xoops\Form\Text(AlumniLocale::SCMOTTO, 'scmotto', 50, 255, $obj->getVar('scmotto')), false);
        $this->addElement(new Xoops\Form\Text(AlumniLocale::SCURL, 'scurl', 50, 255, $obj->getVar('scurl')), false);
        $this->addElement(new Xoops\Form\Hidden('op', 'save_category'));
        $this->addElement(new Xoops\Form\Button('', 'submit', XoopsLocale::A_SUBMIT, 'submit'));
    }
}
