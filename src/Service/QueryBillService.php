<?php


namespace WxPayPoint\Service;


use WxPayPoint\Handle\CurlHandle;

class QueryBillService extends BaseService
{
	public $url = "https://api.mch.weixin.qq.com/v3/payscore/serviceorder";
	
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
		$this->checkAofParam( $this->param, $this->getDefault() );
		$this->changeUrl();
	}
	
	/**
	 * change url
	 */
	public function changeUrl ()
	{
		$this->url .= '?service_id=' . $this->param['service_id'];
		if ( isset( $this->param['out_order_no'] ) ) {
			$this->url .= '&out_order_no=' . $this->param['out_order_no'];
		} else {
			$this->url .= '&query_id=' . $this->param['query_id'];
		}
		$this->url .= '&appid=' . $this->param['appid'];
	}
	
	/**
	 * @return array|mixed
	 */
	protected function getDefault () : array
	{
		// TODO: Implement getDefault() method.
		return [ "out_order_no", "query_id" ];
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
	
	/**
	 * @param array $header
	 * @return array
	 */
	public function sendRequest ( array $header ) : array
	{
		// TODO: Implement sendRequest() method.
		$curlHandle = new CurlHandle();
		$curlHandle->setBaseUrl( $this->url );
		$curlHandle->setMethod( CurlHandle::GET );
		$curlHandle->setHeader( $header );
		$curlHandle->setInputFormat( CurlHandle::JSON );
		$curlHandle->setOutputFormat( CurlHandle::JSON );
		return $curlHandle->sendCurl();
	}
}