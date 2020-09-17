<?php

namespace WxPayPoint\Request;

use WxPayPoint\Handle\AuthorizationHandle;
use WxPayPoint\Handle\CurlHandle;
use WxPayPoint\Handle\StockHandle;

class WxPayRequest
{
	CONST CERT = "https://api.mch.weixin.qq.com/v3/certificates";
	
	public $config;
	
	public $curlHandle;
	
	static public $instance;
	
	public function __construct ( $config )
	{
		$this->config = $config;
		$this->curlHandle = new CurlHandle();
	}
	
	
	/**
	 * 获取授权头部
	 *
	 * @return string
	 */
	public function getAuthorization ( $url, $method, $body )
	{
		$authHandle = new AuthorizationHandle();
		$authHandle->setHttpUrl( $url );
		$authHandle->setHttpMethod( $method );
		$authHandle->setTimestamp();
		$authHandle->setNonce( StockHandle::getNonceStr() );
		$authHandle->setSerialNo( $this->config['serial_no'] );
		$authHandle->setBody( $body );
		$authHandle->setMchPrivateKey( StockHandle::getPrivateKey( $this->config['private_key'] ) );
		$authHandle->setMerchantId( $this->config['mch_id'] );
		return $authHandle->getAuthorization();
	}
	
	
	/**
	 * 获取证书
	 * @return mixed
	 * @throws \Exception|array|mixed
	 */
	public function getCert ()
	{
		$this->curlHandle->setBaseUrl( self::CERT );
		$this->curlHandle->setMethod( CurlHandle::GET );
		$this->curlHandle->setHeader( [
			'Authorization:' . $this->getAuthorization( self::CERT, CurlHandle::GET, '' ),
			'Accept:application/json',
			'User-Agent:' . $this->config['mch_id'],
		] );
		$this->curlHandle->setInputFormat( CurlHandle::JSON );
		$this->curlHandle->setOutputFormat( CurlHandle::JSON );
		$cert = $this->curlHandle->sendCurl();
		if ( !isset( $cert['data'] ) ) {
			throw new \Exception( $cert['message'] );
		}
		return $cert['data']['0']['serial_no'];
	}
	
	/**
	 * 获取支付请求头
	 *
	 * @return array
	 */
	public function getWxPayHeader ( $url, $method, $body )
	{
		return [
			'Authorization:' . $this->getAuthorization( $url, $method, $body ),
			'Accept:application/json',
			'User-Agent:' . $this->config['mch_id'],
			'Content-Type:application/json',
			'Wechatpay-Serial:' . $this->getCert(),
		];
	}
	
	
}
