<?php


namespace WxPayPoint\Service;


use WxPayPoint\Handle\CurlHandle;

class OpenidPermissionService extends BaseService
{
	
	public $url = "https://api.mch.weixin.qq.com/v3/payscore/permissions/openid/{openid}";
	
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
	}
	
	/**
	 * change url
	 */
	public function changeUrl ()
	{
		$this->url = str_replace( '{openid}', $this->param['openid'], $this->url );
		$this->url .= "?appid=" . $this->param['appid'] . "&service_id=" . $this->param['service_id'];
	}
	
	
	/**
	 * @return array|mixed
	 */
	protected function getDefault () : array
	{
		// TODO: Implement getDefault() method.
		return [ "openid" ];
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