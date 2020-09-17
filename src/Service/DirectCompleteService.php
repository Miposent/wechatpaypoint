<?php


namespace WxPayPoint\Service;

use WxPayPoint\Handle\CurlHandle;

class DirectCompleteService extends BaseService
{
	
	public $url = "https://api.mch.weixin.qq.com/payscore/serviceorder/direct-complete";
	
	public $param;
	
	/**
	 * createBillService constructor.
	 * @param $param
	 * @throws \Exception
	 */
	public function __construct ( $param )
	{
		$this->param = $param;
		$this->init();
	}
	
	/**
	 *init data
	 *
	 * @throws \Exception
	 */
	protected function init ():void
	{
		$this->checkParam( $this->param, $this->getDefault() );
		$this->param = $this->changeParam( $this->param );
	}
	
	
	/**
	 * @return array|mixed
	 */
	protected function getDefault () : array
	{
		// TODO: Implement getDefault() method.
		return [
			"out_order_no", "openid", "service_id", "service_introduction",
			"post_payments", "time_range", "total_amount"
		];
	}
	
	/**
	 * @return array
	 */
	protected function getArrayField () : array
	{
		// TODO: Implement getArrayField() method.
		return [
			"post_payments", "post_discounts"
		];
	}
	
	/**
	 * @return array
	 */
	protected function getObjectField () : array
	{
		// TODO: Implement getObjectField() method.
		return [
			"time_range", "location"
		];
	}
	
	public function sendRequest ( array $header ) : array
	{
		// TODO: Implement sendRequest() method.
		$curlHandle = new CurlHandle();
		$curlHandle->setBaseUrl( $this->url );
		$curlHandle->setMethod( CurlHandle::POST );
		$curlHandle->setHeader( $header );
		$curlHandle->setQueryData( $this->param );
		$curlHandle->setInputFormat( CurlHandle::JSON );
		$curlHandle->setOutputFormat( CurlHandle::JSON );
		return $curlHandle->sendCurl();
	}
}