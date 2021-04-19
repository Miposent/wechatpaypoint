<?php

namespace WxPayPoint\Request;

use WxPayPoint\Service\ApplyRefundService;
use WxPayPoint\Service\AuthCodePermissionService;
use WxPayPoint\Service\AuthCodeTerminateService;
use WxPayPoint\Service\CancelBillService;
use WxPayPoint\Service\CompleteBillService;
use WxPayPoint\Service\CreateBillService;
use WxPayPoint\Service\DirectCompleteService;
use WxPayPoint\Service\ModifyBillService;
use WxPayPoint\Service\OpenidPermissionService;
use WxPayPoint\Service\OpenidTerminateService;
use WxPayPoint\Service\PayBillService;
use WxPayPoint\Service\PermissionService;
use WxPayPoint\Service\QueryBillService;
use WxPayPoint\Handle\CurlHandle;
use WxPayPoint\Handle\StockHandle;
use WxPayPoint\Interfacer\WxPayPointInterface;
use WxPayPoint\Service\QueryRefundService;
use WxPayPoint\Service\SyncBillService;
use WxPayPoint\Service\TerminateService;
use WxPayPoint\Service\UserServiceStateService;

class WxPayPointRequest extends WxPayRequest implements WxPayPointInterface
{
	
	/**
	 * WxPayPointRequest constructor.
	 * @param array $config
	 * @throws \Exception
	 */
	public function __construct ( array $config )
	{
		$this->init( $config );
		parent::__construct( $config );
	}
	
	/**
	 * init data
	 *
	 * @param array $config
	 * @throws \Exception
	 */
	protected function init ( array $config )
	{
		$this->checkConfig( $config );
	}
	
	
	/**
	 * get instance
	 *
	 * @param array $config
	 * @return WxPayPointRequest
	 *
	 */
	public static function getInstance ( array $config )
	{
		if ( !( self::$instance instanceof WxPayRequest ) ) {
			self::$instance = new self( $config );
		}
		return self::$instance;
	}
	
	/**
	 * check config information
	 *
	 * @param $config
	 * @return bool| \Exception
	 * @throws \Exception
	 */
	protected function checkConfig ( $config )
	{
		if ( !$config ) {
			throw new \Exception( 'config configuration information is missing' );
		}
		$defaultConfigKey = $this->getDefaulConfigKey();
		foreach ( $defaultConfigKey as $cost ){
			if ( !array_key_exists( $cost, $config ) ) {
				throw new \Exception( "config missing $cost fields" );
			}
		}
		return true;
	}
	
	/**
	 * get default config key
	 *
	 * @return array
	 */
	protected function getDefaulConfigKey ()
	{
		return [
			'appid', 'mch_id', 'service_id', 'key', 'v3key', 'serial_no', 'private_key', 'public_key'
		];
	}
	
	/**
	 * get config
	 * @return array
	 */
	protected function getConfig ()
	{
		return [
			'appid'      => $this->config['appid'],
			'service_id' => $this->config['service_id']
		];
	}
	
	
	/**
	 * 创建支付分订单
	 * @param array $param
	 * @return array
	 * @throws \Exception
	 */
	public function createBill ( array $param ) : array
	{
		$param = array_merge( $this->getConfig(), $param );
		$service = new CreateBillService( $param );
		$header = $this->getWxPayHeader( $service->url, CurlHandle::POST, json_encode( $service->param ) );
		$result = $service->sendRequest( $header );
		if ( isset( $result['code'] ) ) {
			return $result;
		}
		$response = [
			'mch_id'    => $this->config['mch_id'],
			'timestamp' => (string) ( time() ),
			'package'   => $result['package'],
			'nonce_str' => StockHandle::getNonceStr(),
			'sign_type' => 'HMAC-SHA256',
		];
		$response['sign'] = StockHandle::getSign( $response, $this->config['key'] );
		return array_merge( $result, $response );
	}
	
	/**
	 * 查询支付分订单
	 * @param array $param
	 * @return array
	 * @throws \Exception
	 */
	public function queryBill ( array $param ) : array
	{
		$param = array_merge( $this->getConfig(), $param );
		$service = new QueryBillService( $param );
		$header = $this->getWxPayHeader( $service->url, CurlHandle::GET, '' );
		return $service->sendRequest( $header );
	}
	
	/**
	 * 撤销支付分订单
	 * @param array $param
	 * @return array
	 * @throws \Exception
	 */
	public function cancelBill ( array $param ) : array
	{
		$param = array_merge( $this->getConfig(), $param );
		$service = new CancelBillService( $param );
		$header = $this->getWxPayHeader( $service->url, CurlHandle::POST, json_encode( $service->param ) );
		return $service->sendRequest( $header );
	}
	
	
	/**
	 * 修改支付分订单金额
	 * @param array $param
	 * @return array
	 * @throws \Exception
	 */
	public function modifyBill ( array $param ) : array
	{
		$param = array_merge( $this->getConfig(), $param );
		$service = new ModifyBillService( $param );
		$header = $this->getWxPayHeader( $service->url, CurlHandle::POST, json_encode( $service->param ) );
		return $service->sendRequest( $header );
	}
	
	/**
	 * 完结支付分订单
	 * @param array $param
	 * @return array
	 * @throws \Exception
	 */
	public function completeBill ( array $param ) : array
	{
		$param = array_merge( $this->getConfig(), $param );
		$service = new CompleteBillService( $param );
		$header = $this->getWxPayHeader( $service->url, CurlHandle::POST, json_encode( $service->param ) );
		return $service->sendRequest( $header );
	}
	
	/**
	 * 商户发起催收扣款
	 * @param array $param
	 * @return array
	 * @throws \Exception
	 */
	public function payBill ( array $param ) : array
	{
		// TODO: Implement payBill() method.
		$param = array_merge( $this->getConfig(), $param );
		$service = new PayBillService( $param );
		$header = $this->getWxPayHeader( $service->url, CurlHandle::POST, json_encode( $service->param ) );
		return $service->sendRequest( $header );
	}
	
	/**
	 * 商户发起催收扣款
	 * @param array $param
	 * @return array
	 * @throws \Exception
	 */
	public function syncBill ( array $param ) : array
	{
		// TODO: Implement syncBill() method.
		$param = array_merge( $this->getConfig(), $param );
		$service = new SyncBillService( $param );
		$header = $this->getWxPayHeader( $service->url, CurlHandle::POST, json_encode( $service->param ) );
		return $service->sendRequest( $header );
	}
	
	
	/**
	 * 创单结单合并
	 * @param array $param
	 * @return array
	 * @throws \Exception
	 */
	public function directComplete ( array $param ) : array
	{
		// TODO: Implement directComplete() method.
		$param = array_merge( $this->getConfig(), $param );
		$service = new DirectCompleteService( $param );
		$header = $this->getWxPayHeader( $service->url, CurlHandle::POST, json_encode( $service->param ) );
		return $service->sendRequest( $header );
	}
	
	/**
	 * 查询用户授权状态
	 * @param array $param
	 * @return array
	 * @throws \Exception
	 */
	public function userServiceState ( array $param ) : array
	{
		// TODO: Implement userServiceState() method.
		$param = array_merge( $this->getConfig(), $param );
		$service = new UserServiceStateService( $param );
		$header = $this->getWxPayHeader( $service->url, CurlHandle::GET, '' );
		return $service->sendRequest( $header );
	}
	
	/**
	 *  商户解除用户授权关系
	 * @param array $param
	 * @return array
	 * @throws \Exception
	 */
	public function terminate ( array $param ) : array
	{
		// TODO: Implement terminate() method.
		$param = array_merge( $this->getConfig(), $param );
		$service = new TerminateService( $param );
		$header = $this->getWxPayHeader( $service->url, CurlHandle::POST, json_encode( $service->param ) );
		return $service->sendRequest( $header );
	}
	
	/**
	 *  商户预授权
	 * @param array $param
	 * @return array
	 * @throws \Exception
	 */
	public function permission ( array $param ) : array
	{
		// TODO: Implement permission() method.
		$param = array_merge( $this->getConfig(), $param );
		$service = new PermissionService( $param );
		$header = $this->getWxPayHeader( $service->url, CurlHandle::POST, json_encode( $service->param ) );
		return $service->sendRequest( $header );
	}
	
	/**
	 * 查询与用户授权记录（授权协议号）
	 * @param array $param
	 * @return array
	 * @throws \Exception
	 */
	public function authCodePermission ( array $param ) : array
	{
		// TODO: Implement authCodePermission() method.
		$param = array_merge( $this->getConfig(), $param );
		$service = new AuthCodePermissionService( $param );
		$header = $this->getWxPayHeader( $service->url, CurlHandle::GET, '' );
		return $service->sendRequest( $header );
	}
	
	/**
	 * 解除用户授权关系（授权协议号）
	 * @param array $param
	 * @return array
	 * @throws \Exception
	 */
	public function authCodeTerminate ( array $param ) : array
	{
		// TODO: Implement authCodeTerminate() method.
		$param = array_merge( $this->getConfig(), $param );
		$service = new AuthCodeTerminateService( $param );
		$header = $this->getWxPayHeader( $service->url, CurlHandle::POST, json_encode( $service->param ) );
		return $service->sendRequest( $header );
	}
	
	/**
	 * 解除用户授权关系（openid）
	 * @param array $param
	 * @return array
	 * @throws \Exception
	 */
	public function openidTerminate ( array $param ) : array
	{
		// TODO: Implement openidTerminate() method.
		$param = array_merge( $this->getConfig(), $param );
		$service = new OpenidTerminateService( $param );
		$header = $this->getWxPayHeader( $service->url, CurlHandle::POST, json_encode( $service->param ) );
		return $service->sendRequest( $header );
	}
	
	/**
	 * 查询与用户授权记录（openid）
	 * @param array $param
	 * @return array
	 * @throws \Exception
	 */
	public function openidPermission ( array $param ) : array
	{
		// TODO: Implement openidPermission() method.
		$param = array_merge( $this->getConfig(), $param );
		$service = new OpenidPermissionService( $param );
		$header = $this->getWxPayHeader( $service->url, CurlHandle::GET, '' );
		return $service->sendRequest( $header );
	}
	
	/**
	 * 申请退款
	 * @param array $param
	 * @return array
	 * @throws \Exception
	 */
	public function applyRefund ( array $param ) : array
	{
		// TODO: Implement payBill() method.
		$service = new ApplyRefundService( $param );
		$header = $this->getWxPayHeader( $service->url, CurlHandle::POST, json_encode( $service->param ) );
		return $service->sendRequest( $header );
	}
	
	/**
	 * 查询退款
	 * @param array $param
	 * @return array
	 * @throws \Exception
	 */
	public function queryRefund ( array $param ) : array
	{
		$service = new QueryRefundService( $param );
		$header = $this->getWxPayHeader( $service->url, CurlHandle::GET, '' );
		return $service->sendRequest( $header );
	}
}
