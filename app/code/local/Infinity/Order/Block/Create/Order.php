<?php
/**
 * Magento2 WechatLogin extension for share and follow buttons.
 * @package   Silk_WechatLogin
 * @author    Silk - https://www.silksoftware.com/ - info@silksoftware.com
 * @copyright Copyright © 2018 Silk. All rights reserved.
 * @license   https://opensource.org/licenses/AFL-3.0  Academic Free License 3.0 | Open Source Initiative
 */

class Infinity_Order_Block_Create_Order extends Mage_Core_Block_Template
{

    protected $order;
    protected function _construct()
    {
        $this->setTemplate('order/custom.phtml');
    }

    public function getOrder() {
        if (is_null($this->order)) {
            if (Mage::registry('current_order')) {
                $order = Mage::registry('current_order');
            }
            elseif (Mage::registry('order')) {
                $order = Mage::registry('order');
            }
            else {
                $order = new Varien_Object();
            }
            $this->order = $order;
        }
        return $this->order;
    }
}
