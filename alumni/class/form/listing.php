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
 
class AlumniListingForm extends Xoops\Form\ThemeForm
{
    /**
     * @param AlumniCategory|XoopsObject $obj
     */
    public function __construct(AlumniListing &$obj)
    {
	$xoops = Xoops::getInstance();

	if ($xoops->getModuleConfig('alumni_moderated') == '1') {
        $title = $obj->isNew() ? sprintf(AlumniLocale::ADD_MOD) : sprintf(AlumniLocale::EDIT_MOD);
        } else {
	$title = $obj->isNew() ? sprintf(AlumniLocale::ADD_LISTING) : sprintf(AlumniLocale::EDIT_LISTING);
	}

	parent::__construct($title, 'form', false, 'post', true);

        $this->setExtra('enctype="multipart/form-data"');

	$member_handler = $xoops->getHandlerMember();
        $userGroups     = $member_handler->getGroupList();

	$lid = Request::getInt('lid', 0);
        if (isset($lid)) {
            $lid = $lid;
        }

        $this->addElement(new Xoops\Form\Label(AlumniLocale::SUBMITTER, $xoops->user->uname()));

        $categoryHandler = $xoops->getmodulehandler('category', 'alumni');
        $categories              = $categoryHandler->getObjects();
        $mytree                  = new XoopsObjectTree($categories, 'cid', 'pid');
	if ($obj->isNew()) {
	  $this_cid  = Request::getInt('cid', 0);
	} else {
	  $this_cid  = $obj->getVar('cid');
	}
        $categories_Handler = $xoops->getmodulehandler('category', 'alumni');
        $categories              = $categories_Handler->getObjects();
        $mytree                  = new XoopsObjectTree($categories, 'cid', 'pid');
        $category_select         = $mytree->makeSelBox('cid', 'title', '--', $this_cid, true);
        $this->addElement(new Xoops\Form\Label(AlumniLocale::SCHOOL, $category_select), true);

        $cat_name                  = '';
        $categories_Handler = $xoops->getModuleHandler('category', 'alumni');
        $catObj                    = $categories_Handler->get($obj->getVar('cid'));
        $cat_name                  = $catObj->getVar('title');
        $this->addElement(new Xoops\Form\Hidden('school', $cat_name));

        $this->addElement(new Xoops\Form\Text(AlumniLocale::NAME_2, 'name', 50, 255, $obj->getVar('name')), true);
        $this->addElement(new Xoops\Form\Text(AlumniLocale::MNAME_2, 'mname', 50, 255, $obj->getVar('mname')), false);
        $this->addElement(new Xoops\Form\Text(AlumniLocale::LNAME_2, 'lname', 50, 255, $obj->getVar('lname')), true);
        $this->addElement(new Xoops\Form\Text(AlumniLocale::CLASS_OF_2, 'year', 50, 255, $obj->getVar('year')), true);
        $this->addElement(new Xoops\Form\Text(AlumniLocale::STUDIES_2, 'studies', 50, 255, $obj->getVar('studies')), false);
        $activities               = $obj->getVar('activities', 'e') ? $obj->getVar('activities', 'e') : '';
        $editor_configs           = array();
        $editor_configs['name']   = 'activities';
        $editor_configs['value']  = ($activities);
        $editor_configs['editor'] = $xoops->getModuleConfig('alumni_form_options');
        $editor_configs['rows']   = 6;
        $editor_configs['cols']   = 8;

        $this->addElement(new Xoops\Form\Editor(AlumniLocale::ACTIVITIES, 'activities', $editor_configs), false);
        $extrainfo                = $obj->getVar('extrainfo', 'e') ? $obj->getVar('extrainfo', 'e') : '';
        $editor_configs           = array();
        $editor_configs['name']   = 'extrainfo';
        $editor_configs['value']  = $extrainfo;
        $editor_configs['editor'] = $xoops->getModuleConfig('alumni_form_options');
        $editor_configs['rows']   = 6;
        $editor_configs['cols']   = 8;

        $this->addElement(new Xoops\Form\Editor(AlumniLocale::EXTRAINFO, 'extrainfo', $editor_configs), false);
        $photo_old            = $obj->getVar('photo') ? $obj->getVar('photo') : '';
        $uploadirectory_photo = XOOPS_ROOT_PATH . "/modules/alumni/photos/grad_photo";
        $imgtray_photo        = new Xoops\Form\ElementTray(AlumniLocale::GRAD_PHOTO, '<br />');
        $imgpath_photo        = sprintf(AlumniLocale::FORMIMAGE_PATH, $uploadirectory_photo);
        $fileseltray_photo    = new Xoops\Form\ElementTray('', '<br />');
        $fileseltray_photo->addElement(new Xoops\Form\File(AlumniLocale::FORMUPLOAD, 'photo', $xoops->getModuleConfig('alumni_photomax')), false);

        if ($photo_old) {
            $fileseltray_photo->addElement(new Xoops\Form\Label(AlumniLocale::PHOTO2, '<a href="photos/grad_photo/' . $photo_old . '">' . $photo_old . '</a>', false));
            $imgtray_checkbox = new Xoops\Form\Checkbox('', 'del_photo', 0);
            $imgtray_checkbox->addOption(1, AlumniLocale::DELPICT);
            $fileseltray_photo->addElement($imgtray_checkbox);
        }
        $imgtray_photo->addElement($fileseltray_photo);
        $this->addElement($imgtray_photo);
        $this->addElement(new Xoops\Form\Hidden('photo_old', $photo_old));

        $photo2_old            = $obj->getVar('photo2') ? $obj->getVar('photo2') : '';
        $uploadirectory_photo2 = XOOPS_ROOT_PATH . "/modules/alumni/photos/now_photo";
        $imgtray_photo2        = new Xoops\Form\ElementTray(AlumniLocale::NOW_PHOTO, '<br />');
        $imgpath_photo2        = sprintf(AlumniLocale::FORMIMAGE_PATH, $uploadirectory_photo2);
        $fileseltray_photo2    = new Xoops\Form\ElementTray('', '<br />');
        $fileseltray_photo2->addElement(new Xoops\Form\File(AlumniLocale::FORMUPLOAD, 'photo2', $xoops->getModuleConfig('alumni_photomax')), false);

        if ($photo2_old) {
            $fileseltray_photo2->addElement(new Xoops\Form\Label(AlumniLocale::PHOTO2, '<a href="photos/now_photo/' . $photo2_old . '">' . $photo2_old . '</a>', false));
            $imgtray_checkbox2 = new Xoops\Form\Checkbox('', 'del_photo2', 0);
            $imgtray_checkbox2->addOption(1, AlumniLocale::DELPICT);
            $fileseltray_photo2->addElement($imgtray_checkbox2);
        }
        $imgtray_photo2->addElement($fileseltray_photo2);
        $this->addElement($imgtray_photo2);
        $this->addElement(new Xoops\Form\Hidden('photo2_old', $photo2_old));
        $this->addElement(new Xoops\Form\Text(AlumniLocale::EMAIL_2, 'email', 50, 255, $obj->getVar('email')), true);
        $this->addElement(new Xoops\Form\Text(AlumniLocale::OCC_2, 'occ', 50, 255, $obj->getVar('occ')), false);
        $this->addElement(new Xoops\Form\Text(AlumniLocale::TOWN_2, 'town', 50, 255, $obj->getVar('town')), false);

        if ($xoops->user->isAdmin()) {
	$this->addElement(new Xoops\Form\RadioYesNo(AlumniLocale::APPROVE_2, 'valid', $obj->getVar('valid'), XoopsLocale::YES, XoopsLocale::NO));
        }
        if ($xoops->getModuleConfig('alumni_use_captcha') == '1') {
            $this->addElement(new Xoops\Form\Captcha());
        }
        
        $this->addElement(new Xoops\Form\Hidden('security', $xoops->security()->createToken()));
        
        if (isset($_REQUEST['date'])) {
            $this->addElement(new Xoops\Form\Hidden('date', $_REQUEST['date']));
        } else {
            $this->addElement(new XoopsFormHidden('date', time()));
        }
        $this->addElement(new Xoops\Form\Hidden('submitter', $xoops->user->uname()));
        $this->addElement(new Xoops\Form\Hidden('usid', $xoops->user->uid()));
        $this->addElement(new Xoops\Form\Hidden('op', 'save_listing'));
        $this->addElement(new Xoops\Form\Button('', 'submit', XoopsLocale::A_SUBMIT, 'submit'));
    }
}
