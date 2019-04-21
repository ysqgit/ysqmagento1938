<?php

/**
 * @Author: ysqgit
 * @Date:   2019-04-18 22:56:26
 * @Last Modified by:   ysqgit
 * @Last Modified time: 2019-04-18 22:59:03
 */

class Inchoo_Adminblock_Adminhtml_CreateController extends Mage_Adminhtml_Controller_Action{
	
    public function indexAction(){
                $this->loadLayout()
                ->_addContent(
                $this->getLayout()
                ->createBlock('inchoo_adminblock/adminhtml_adminblock')
                ->setTemplate('inchoo/adminblock.phtml'))
                ->renderLayout();
    }
}