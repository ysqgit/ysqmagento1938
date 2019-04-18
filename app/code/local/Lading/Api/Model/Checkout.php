<?php
/**
 * Created by PhpStorm.
 * User: Leo
 * Date: 15/6/4
 * Time: 下午11:41
 */

class Lading_Api_Model_Checkout extends Lading_Api_Model_Abstract {

    /**
     * 获取账单
     * @return mixed
     */
    public function getQuote() {
        return Mage::getSingleton('checkout/session')->getQuote();
    }



    /**
     * 获取账单
     * @param $quote
     * @return array
     */
    public function getAddressByQuote($quote) {
        $address = array();
        $shipping_address = $quote->getShippingAddress();
        $billing_address = $quote->getBillingAddress();
        $address['shipping_address'] = array(
            'address_id' => $shipping_address->getCustomerAddressId(),
            'customer_id' =>$shipping_address->getCustomerId(),
            'address_type'=>$shipping_address->getAddressType(),
            'email'=>$shipping_address->getEmail(),
            'firstname'=>$shipping_address->getFirstname(),
            'lastname'=>$shipping_address->getLastname(),
            'company'=>$shipping_address->getCompany(),
            'street'=>$shipping_address->getStreet(),
            'city' =>$shipping_address->getCity(),
            'region' =>$shipping_address->getRegion(),
            'region_id'=>$shipping_address->getRegionId(),
            'postcode'=>$shipping_address->getPostcode(),
            'country_id'=>$shipping_address->getCountryId(),
            'telephone'=>$shipping_address->getTelephone(),
            'fax'=>$shipping_address->getFax(),
            'shipping_method'=>$shipping_address->getShippingMethod(),
            'shipping_description'=>$shipping_address->getShippingDescription(),
            'weight'=>$shipping_address->getWeight(),
            'subtotal'=>$shipping_address->getSubtotal(),
            'base_subtotal'=>$shipping_address->getBaseSubtotal(),
            'subtotal_with_discount' => $shipping_address->getSubtotalWithDiscount(),
            'base_subtotal_with_discount' => $shipping_address->getBaseSubtotalWithDiscount(),
            'tax_amount' => $shipping_address->getTaxAmount(),
            'base_tax_amount' => $shipping_address->getBaseTaxAmount(),
            'shipping_amount' =>$shipping_address->getShippingAmount(),
            'base_shipping_amount' =>$shipping_address->getBaseShippingAmount(),
            'shipping_tax_amount' =>$shipping_address->getShippingTaxAmount(),
            'base_shipping_tax_amount' =>$shipping_address->getBaseShippingTaxAmount(),
            'discount_amount' =>$shipping_address->getDiscountAmount(),
            'base_discount_amount' =>$shipping_address->getBaseDiscountAmount(),
            'grand_total' => $shipping_address->getGrandTotal(),
            'base_grand_total' =>$shipping_address->getBaseGrandTotal()
        );
        $address['billing_address'] = array(
            'address_id' => $billing_address->getCustomerAddressId(),
            'customer_id' =>$billing_address->getCustomerId(),
            'address_type'=>$billing_address->getAddressType(),
            'email'=>$billing_address->getEmail(),
            'firstname'=>$billing_address->getFirstname(),
            'lastname'=>$billing_address->getLastname(),
            'company'=>$billing_address->getCompany(),
            'street'=>$billing_address->getStreet(),
            'city' =>$billing_address->getCity(),
            'region' =>$billing_address->getRegion(),
            'region_id'=>$billing_address->getRegionId(),
            'postcode'=>$billing_address->getPostcode(),
            'country_id'=>$billing_address->getCountryId(),
            'telephone'=>$billing_address->getTelephone(),
            'fax'=>$billing_address->getFax()
        );
        return $address;
    }



    /**
     * get active payment method
     * @param $quote
     * @return array
     */
    public function getActivePaymentMethods($quote){
        if ($quote->getPayment()->getMethod()){
            $quote_payment_code = $quote->getPayment()->getMethodInstance()->getCode();
        }
        $payments = Mage::getSingleton('payment/config')->getActiveMethods();
        $methods = array();
        foreach ($payments as $paymentCode=>$paymentModel) {
            $paymentTitle = Mage::getStoreConfig('payment/'.$paymentCode.'/title');
            if($paymentCode != 'free'){
                $methods[$paymentCode] = array(
                    'title'   => $paymentTitle,
                    'code' => $paymentCode
                );
                if($paymentCode == $quote_payment_code){
                    $methods[$paymentCode]['is_selected'] = true;
                }
            }
        }
        return $methods;
    }


    /**
     * get shipping method detail by quote
     * @param $quote
     * @return array
     */
    public function getShippingMethodByQuote($quote){
        $quoteShippingAddress = $quote->getShippingAddress();
        $shippingMethod = $quoteShippingAddress->getShippingMethod();
        if (is_null($quoteShippingAddress->getId())) {
            $return_result['msg'] = 'shipping_address_is_not_set';
            $return_result['code'] = 1;
            return $return_result;
        }
        $rates = $quoteShippingAddress->getShippingRatesCollection();
        $result_rates = array();
        foreach($rates as $rate){
            if($rate->getCode() == $shippingMethod){
                $result_rates['carrier'] = $rate->getCarrier();
                $result_rates['carrier_title'] = $rate->getCarrierTitle();
                $result_rates['code'] = $rate->getCode();
                $result_rates['method'] = $rate->getMethod();
                $result_rates['method_title'] = $rate->getMethodTitle();
                $result_rates['price'] = number_format(Mage::getModel('mobile/currency')->getCurrencyPrice($rate->getPrice()),2,'.','');
                $result_rates['symbol'] = Mage::app()->getLocale()->currency(Mage::app()->getStore()->getCurrentCurrencyCode())->getSymbol();
                $result_rates['method_description'] = $rate->getMethodDescription();
            }
        }
        return $result_rates;
    }



    /**
     * get shipping method list by quote
     * @param $quote
     * @return array
     */
    public function getShippingMethodListByQuote($quote){
        $shippingMethodLists = array();
        $quoteShippingAddress = $quote->getShippingAddress();
        $shippingMethod = $quoteShippingAddress->getShippingMethod();
        $rates = $quoteShippingAddress->getShippingRatesCollection();
        foreach($rates as $rate){
            $temp_rates = array();
            $temp_rates['carrier'] = $rate->getCarrier();
            $temp_rates['carrier_title'] = $rate->getCarrierTitle();
            $temp_rates['code'] = $rate->getCode();
            $temp_rates['method'] = $rate->getMethod();
            $temp_rates['method_title'] = $rate->getMethodTitle();
            $temp_rates['price'] =  number_format(Mage::getModel('mobile/currency')->getCurrencyPrice($rate->getPrice()),2,'.','');
            $temp_rates['symbol'] = Mage::app()->getLocale()->currency(Mage::app()->getStore()->getCurrentCurrencyCode())->getSymbol();
            $temp_rates['method_description'] = $rate->getMethodDescription();
            if($rate->getCode() == $shippingMethod){
                $temp_rates['is_selected'] = true;
            }
            array_push($shippingMethodLists,$temp_rates);
        }
        $after_group = array();
        foreach ( $shippingMethodLists as $value ) {
            $after_group[$value['carrier_title']][] = $value;
        }
        return $after_group;
    }



    /**
     * get payment method by quote
     * @param $quote
     * @return array
     */
    public function getPaymentMethodByQuote($quote){
        if ($quote->getPayment()->getMethod()){
            $quote_payment_code = $quote->getPayment()->getMethodInstance()->getCode();
        }
        $payments = Mage::getSingleton('payment/config')->getActiveMethods();
        $method = array();
        foreach ($payments as $paymentCode=>$paymentModel) {
            $paymentTitle = Mage::getStoreConfig('payment/'.$paymentCode.'/title');
            if(($paymentCode != 'free') && ($paymentCode == $quote_payment_code)){
                $method['title'] = $paymentTitle;
                $method['code'] = $paymentCode;
            }
        }
        return $method;
    }


    /**
     * get payment method by quote
     * @param $quote
     * @return array
     */
    public function getCouponByQuote($quote){
        $coupon =  array();
        $coupon_code = $quote->getCouponCode();
        if($coupon_code){
            $oCoupon = Mage::getModel ( 'salesrule/coupon' )->load ( $coupon_code, 'code' );
            $oRule = Mage::getModel ( 'salesrule/rule' )->load ( $oCoupon->getRuleId ());
            $coupon['coupon_code'] = $coupon_code;
            $coupon['coupon_rule'] = array(
                'rule_id' => $oRule->getData()['rule_id'],
                'name' => $oRule->getData()['name'],
                'description'=> $oRule->getData()['description'],
                'from_date'=> $oRule->getData()['from_date'],
                'to_date'=> $oRule->getData()['to_date'],
                'uses_per_customer'=> $oRule->getData()['uses_per_customer'],
                'is_active'=> $oRule->getData()['is_active'],
                'is_advanced'=> $oRule->getData()['is_advanced'],
                'product_ids'=> $oRule->getData()['product_ids'],
                'simple_action'=> $oRule->getData()['simple_action'],
                'discount_amount'=> $oRule->getData()['discount_amount'],
                'discount_qty'=> $oRule->getData()['discount_qty'],
                'discount_step'=> $oRule->getData()['discount_step'],
                'simple_free_shipping'=> $oRule->getData()['simple_free_shipping'],
                'apply_to_shipping'=> $oRule->getData()['apply_to_shipping'],
                'times_used'=> $oRule->getData()['times_used'],
                'is_rss'=> $oRule->getData()['is_rss'],
                'coupon_type'=> $oRule->getData()['coupon_type'],
                'use_auto_generation'=> $oRule->getData()['use_auto_generation'],
                'uses_per_coupon'=> $oRule->getData()['uses_per_coupon']
            );
        }
        return (object) $coupon;
    }


    /**
     * get payment method by quote
     * @param $quote
     * @return array
     */
    public function getCouponByCode($coupon_code){
            $oCoupon = Mage::getModel ( 'salesrule/coupon' )->load ( $coupon_code, 'code' );
            $oRule = Mage::getModel ( 'salesrule/rule' )->load ( $oCoupon->getRuleId ());
            $coupon['coupon_code'] = $coupon_code;
            $coupon['coupon_rule'] = array(
                'rule_id' => $oRule->getData()['rule_id'],
                'name' => $oRule->getData()['name'],
                'description'=> $oRule->getData()['description'],
                'from_date'=> $oRule->getData()['from_date'],
                'to_date'=> $oRule->getData()['to_date'],
                'uses_per_customer'=> $oRule->getData()['uses_per_customer'],
                'is_active'=> $oRule->getData()['is_active'],
                'is_advanced'=> $oRule->getData()['is_advanced'],
                'product_ids'=> $oRule->getData()['product_ids'],
                'simple_action'=> $oRule->getData()['simple_action'],
                'discount_amount'=> $oRule->getData()['discount_amount'],
                'discount_qty'=> $oRule->getData()['discount_qty'],
                'discount_step'=> $oRule->getData()['discount_step'],
                'simple_free_shipping'=> $oRule->getData()['simple_free_shipping'],
                'apply_to_shipping'=> $oRule->getData()['apply_to_shipping'],
                'times_used'=> $oRule->getData()['times_used'],
                'is_rss'=> $oRule->getData()['is_rss'],
                'coupon_type'=> $oRule->getData()['coupon_type'],
                'use_auto_generation'=> $oRule->getData()['use_auto_generation'],
                'uses_per_coupon'=> $oRule->getData()['uses_per_coupon']
            );
        return $coupon;
    }





}