<?php


namespace WxPayPoint\Service;


use WxPayPoint\Handle\CurlHandle;

class CancelBillService extends BaseService
{
	public $url = "https://api.mch.weixin.qq.com/v3/payscore/serviceorder/{out_order_no}/cancel";
	
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
	protected function init () : void
	{
		$this->checkParam( $this->param, $this->getDefault() );
		$this->changeUrl();
		$this->unsetParam();
	}
	
	/**
	 * change url
	 */
	public function changeUrl ()
	{
		$this->url = str_replace( '{out_order_no}', $this->param['out_order_no'], $this->url );
	}
	
	/**
	 * unset param
	 */
	public function unsetParam ()
	{
		unset( $this->param['out_order_no'] );
	}
	
	
	/**
	 * @return array|mixed
	 */
	protected function getDefault () : array
	{
		// TODO: Implement getDefault() method.
		return [
			"out_order_no", "reason"
		];
	}
	
	/**
	 * @return array
	 */
	protected function getArrayField () : array
	{
		// TODO: Implement getArrayField() method.
	}
	
	/**
	 * @return array
	 */
	protected function getObjectField () : array
	{
		// TODO: Implement getObjectField() method.
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