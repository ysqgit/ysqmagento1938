<?php
/**
 * Magento2 WechatLogin extension for share and follow buttons.
 * @package   Silk_WechatLogin
 * @author    Silk - https://www.silksoftware.com/ - info@silksoftware.com
 * @copyright Copyright © 2018 Silk. All rights reserved.
 * @license   https://opensource.org/licenses/AFL-3.0  Academic Free License 3.0 | Open Source Initiative
 */

class Infinity_Order_Model_Observer {

    // This function is called on core_block_abstract_to_html_after event
    // We will append our block to the html
//    public function getSalesOrderViewInfo(Varien_Event_Observer $observer) {
//        $block = $observer->getBlock();
//        // layout name should be same as used in app/design/adminhtml/default/default/layout/mymodule.xml
//        if (($block->getNameInLayout() == 'order_info') && ($child = $block->getChild('order.create.order'))) {
//            $transport = $observer->getTransport();
//            if ($transport) {
//                $html = $transport->getHtml();
//                $html .= $child->toHtml();
//                $transport->setHtml($html);
//            }
//        }
//    }
}