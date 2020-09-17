<?php

namespace WxPayPoint\Handle;

class NotifyHandle
{
	
	/**
	 * 回调解密
	 *
	 * @param $associatedData
	 * @param $nonceStr
	 * @param $ciphertext
	 * @return bool|string
	 */
	public static function notifyDecode ( $associatedData, $nonceStr, $ciphertext, $v3key )
	{
		$aesHandle = new AesHandle( $v3key );
		return $aesHandle->decryptToString( $associatedData, $nonceStr, $ciphertext );
	}
	
	
	/**
	 * send fail return
	 *
	 * @param string $code
	 * @param string $message
	 * @return mixed
	 */
	public static function sendFailReturn ( string $code = "ERROR_NAME", string $message = "ERROR_DESCRIPTION" )
	{
		return self::sendReturn( $code, $message );
	}
	
	/**
	 * send success return
	 *
	 * @param string $code
	 * @param string $message
	 * @return mixed
	 */
	public static function sendSuccessReturn ( string $code = "SUCCESS", string $message = "SUCCESS" )
	{
		return self::sendReturn( $code, $message );
	}
	
	/**
	 * send json return
	 *
	 * @param string $code
	 * @param string $message
	 * @return mixed
	 */
	public static function sendReturn ( string $code, string $message )
	{
		return json_encode( [
			"code"    => $code,
			"message" => $message
		] );
	}
	
}