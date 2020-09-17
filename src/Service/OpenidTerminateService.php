<?php


namespace WxPayPoint\Service;


use WxPayPoint\Handle\CurlHandle;

class OpenidTerminateService extends BaseService
{
	
	public $url = "https://api.mch.weixin.qq.com/v3/payscore/permissions/openid/{openid}/terminate";
	
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
	 * @throws \Exception
	 */
	protected function init () : void
	{
		// TODO: Implement init() method.
		$this->checkParam( $this->param, $this->getDefault() );
		$this->changeUrl();
		$this->unsetParam();
	}
	
	/**
	 * change url
	 */
	public function changeUrl ()
	{
		$this->url = str_replace( '{openid}', $this->param['openid'], $this->url );
	}
	
	
	/**
	 * unset param
	 */
	public function unsetParam ()
	{
		unset( $this->param['openid']);
	}
	
	
	/**
	 * @return array|mixed
	 */
	protected function getDefault () : array
	{
		// TODO: Implement getDefault() method.
		return [ "openid", "reason" ];
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
		$curlHandle->setMethod( CurlHandle::POST );
		$curlHandle->setHeader( $header );
		$curlHandle->setQueryData( $this->param );
		$curlHandle->setInputFormat( CurlHandle::JSON );
		$curlHandle->setOutputFormat( CurlHandle::JSON );
		return $curlHandle->sendCurl();
	}
}