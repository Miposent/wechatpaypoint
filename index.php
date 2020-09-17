<?php

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
$data = $app->openidTerminate( [
//	'out_order_no'         => '202009171036252525',
//	'appid'              => 'wx0f3a4b0dcafec7fd',
//	'authorization_code' => '1234323JKHDFE1243252',
//	'notify_url'         => 'https://www.baidu.com'
	'openid' => 'odEmw4u14ldfZkzsGJ0kTd37hU_M',
	'reason' => '太初了'
//	'service_introduction' => '谋谟酒店',
//	'post_payments'        => [
//		'name'   => '租借服务',
//		'amount' => 100
//	],
//	'time_range'           => [
//		'start_time' => date( "YmdHis" )
//	],
//	'total_amount'         => 100
] );

var_dump( $data );