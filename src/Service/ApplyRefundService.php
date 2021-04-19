<?php


namespace WxPayPoint\Service;


use WxPayPoint\Handle\CurlHandle;

class ApplyRefundService extends BaseService
{
	public $url = "https://api.mch.weixin.qq.com/v3/refund/domestic/refunds";
	
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
		$this->param = $this->changeParam( $this->param );
	}
	
	/**
	 * @return array|mixed
	 */
	protected function getDefault () : array
	{
		// TODO: Implement getDefault() method.
		if ( isset( $this->param['transaction_id'] ) ) {
			return [ 'transaction_id', 'out_refund_no' ];
		} else if ( isset( $this->param['out_trade_no'] ) ) {
			return [ 'out_trade_no', 'out_refund_no' ];
		}
		return [ "transaction_id", "out_trade_no", "out_refund_no" ];
	}
	
	/**
	 * @return array
	 */
	protected function getArrayField () : array
	{
		// TODO: Implement getArrayField() method.
		return [];
	}
	
	/**
	 * @return array
	 */
	protected function getObjectField () : array
	{
		// TODO: Implement getObjectField() method.
		return [ "amount" ];
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