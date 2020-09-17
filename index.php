<?php

use WxPayPoint\Handle\NotifyHandle;
use WxPayPoint\Request\WxPayPointRequest;

require './vendor/autoload.php';


$config = [
	'appid'       => 'wx0f3a4b0dcafec7fd',
	'mch_id'      => '1579525861',
	'service_id'  => '00002000000000159843695577771121',
	'key'         => '009DA8BDD9A5AECFED72F358671A5B11',
	'v3key'       => '1BA00441A40AD15D1D2C54A8771E7DF2',
	'serial_no'   => '3F389F9F2D414CF22E156DF1B1FB25B658C2A2C1',
	'private_key' => dirname( __FILE__ ) . '/storage/cert/apiclient_key.pem',
	'public_key'  => dirname( __FILE__ ) . '/storage/cert/apiclient_cert.pem',
];
$app = WxPayPointRequest::getInstance( $config );
$param = [
	'out_order_no'         => '202009171036252525',
	'service_introduction' => '租借飞机服务',
	'time_range'           => [
		'start_time' => date( "YmdHis" )
	],
	'risk_fund'            => [
		'name'   => 'DEPOSIT',
		'amount' => 9900,
	],
	'notify_url'           => 'https://www.baidu.com'
];
$data = $app->syncBill($param);

return NotifyHandle::sendFailReturn("FAIL","ORDER_ERROR");

var_dump( $data );