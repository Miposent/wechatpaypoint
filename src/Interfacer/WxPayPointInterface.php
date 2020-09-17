<?php

namespace WxPayPoint\Interfacer;

Interface WxPayPointInterface
{
	
	/**
	 * 解除用户授权关系（openid）
	 * @param array $param
	 * @return array
	 */
	public function openidTerminate ( array $param ) : array;
	
	/**
	 * 查询与用户授权记录（openid）
	 * @param array $param
	 * @return array
	 */
	public function openidPermission ( array $param ) : array;
	
	/**
	 * 解除用户授权关系（授权协议号）
	 * @param array $param
	 * @return array
	 */
	public function authCodeTerminate ( array $param ) : array;
	
	/**
	 * 查询与用户授权记录（授权协议号）
	 * @param array $param
	 * @return array
	 */
	public function authCodePermission ( array $param ) : array;
	
	/**
	 * 商户预授权
	 * @param array $param
	 * @return array
	 */
	public function permission ( array $param ) : array;
	
	/**
	 * 商户解除用户授权关系
	 * @param array $param
	 * @return array
	 */
	public function terminate ( array $param ) : array;
	
	/**
	 * 查询用户授权状态
	 * @param array $param
	 * @return array
	 */
	public function userServiceState ( array $param ) : array;
	
	
	/**
	 * 创单结单合并
	 * @param array $param
	 * @return array
	 */
	public function directComplete ( array $param ) : array;
	
	
	/**
	 * 创建支付分订单
	 *
	 * @param array $param
	 * @return array
	 * @throws \Exception
	 */
	public function createBill ( array $param ) : array;
	
	
	/**
	 * 查询支付分订单
	 *
	 * @param array $param
	 * @return array
	 *
	 */
	public function queryBill ( array $param ) : array;
	
	
	/**
	 * 撤销支付分订单
	 *
	 * @param $param
	 * @return array|mixed
	 *
	 */
	public function cancelBill ( array $param ) : array;
	
	
	/**
	 * 修改支付分订单金额
	 *
	 * @param $param
	 * @return array|mixed
	 */
	public function modifyBill ( array $param ) : array;
	
	
	/**
	 * 完结支付分订单
	 *
	 * @param $param
	 * @return array|mixed
	 */
	public function completeBill ( array $param ) : array;
	
	/**
	 * 商户发起催收扣款
	 *
	 * @param $param
	 * @return array|mixed
	 */
	public function payBill ( array $param ) : array;
	
	/**
	 * 商户发起催收扣款
	 *
	 * @param $param
	 * @return array|mixed
	 */
	public function syncBill ( array $param ) : array;
}