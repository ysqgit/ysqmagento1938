<?php

/**
 * @Author: ysqgit
 * @Date:   2019-04-16 22:48:29
 * @Last Modified by:   ysqgit
 * @Last Modified time: 2019-04-16 23:34:01
 */
// v2 call
//phpinfo();exit();
//
echo  $url = Mage::getBaseUrl().'api/soap/?wsdl';
$client = new SoapClient($url);
// var_dump(client);

// $client  = new SoapClient('http://local.magento1938.com/index.php/api/v2_soap/?wsdl=1');
// var_dump($client);
// die('11');

// $session = $client-­>login('soapuser', '1111111111');
// $result  = $client-­>customapimoduleProductList($session);
// $client-­>endSession($session);
// echo '<pre>';
// print_r($result);
 
 
// v1 call
// $client = new SoapClient('http://local.magento1938.com/index.php/api/soap/?wsdl=1');
// $session = $client-­>login('soapuser', 'soapuser');
// $result = $client-­>call($session, 'product.list', array(array()));
// $client-­>endSession($session);
// echo '<pre>';
// print_r($result);