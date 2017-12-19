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
defined('XOOPS_ROOT_PATH') || exit('XOOPS root path not defined');

/**
 * Class Alumni
 */
class Alumni extends Xoops\Module\Helper\HelperAbstract
{
    /**
     * Init the module
     *
     * @return null|void
     */
    public function init()
    {
//        $this->setDirname('alumni');
        $moduleDirName = basename(dirname(__DIR__));
        $this->setDirname($moduleDirName);
    }

    /**
     * @return Alumni
     */
    public static function getInstance()
    {
        return parent::getInstance();
    }

    /**
     * @return AlumnilistingHandler
     */
    public function getListingHandler()
    {
        return $this->getHandler('listing');
    }

    /**
     * @return \Xoops\Core\Kernel\XoopsObjectHandler
     */
    public function getCategoryHandler()
    {
        return $this->getHandler('category');
    }

    /**
     * @return AlumniPermissionHandler
     */
    public function getPermissionHandler()
    {
        return $this->getHandler('permission');
    }

    /**
     * @return AlumniGroupPermHandler
     */
    public function getGrouppermHandler()
    {
        return $this->getHandler('groupperm');
    }

    /**
     * @return int|mixed
     */
    public function getUserId()
    {
        if ($this->xoops()->isUser()) {
            return $this->xoops()->user->getVar('uid');
        }

        return 0;
    }
}
