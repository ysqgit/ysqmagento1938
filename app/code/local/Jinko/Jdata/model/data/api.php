<?php

/**
 * @Author: ysqgit
 * @Date:   2019-04-06 11:21:49
 * @Last Modified by:   ysqgit
 * @Last Modified time: 2019-04-06 11:22:19
 */

class Jinko_Jdata_Model_Data_Api extends Mage_Api_Model_Resource_Abstract
{
    public function getData()
    {
        @session_start();
        return array($_SESSION['jinko']);
    }

    public function setData($data)
    {
        @session_start();

        if($data == 'qqq') {
            $this->_fault('no_access');//对应api.xml的faults里的no_access标签
        }

        $_SESSION['jinko'] = array($data);
        return $this->getData();
    }
}