<?php

/**
 * @Author: ysqgit
 * @Date:   2019-04-20 16:20:09
 * @Last Modified by:   ysqgit
 * @Last Modified time: 2019-04-21 00:25:01
 */

class Infinity_Helloworld_IndexController extends Mage_Core_Controller_Front_Action {        
    public function indexAction() {
        //echo 'Hello World!';
        $this->loadLayout();
    	$this->renderLayout();
    }

    public function goodbyeAction() {
    	//echo 'Goodbye World!';
    	$this->loadLayout();
    	$this->renderLayout();  
	}

	public function paramsAction() {
	    echo '<dl>';            
	    foreach($this->getRequest()->getParams() as $key=>$value) {
	        echo '<dt><strong>Param: </strong>'.$key.'</dt>';
	        echo '</dl><dl><strong>Value: </strong>'.$value.'</dl>';
	    }
	    echo '';
	}

}
