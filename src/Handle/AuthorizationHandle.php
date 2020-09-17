<?php


namespace WxPayPoint\Handle;


class AuthorizationHandle
{
	public $httpUrl;
	
	public $httpMethod;
	
	public $timestamp;
	
	public $nonce;
	
	public $body;
	
	public $mchPrivateKey;
	
	public $serialNo;
	
	public $merchantId;
	
	/**
	 * @return mixed
	 */
	public function getHttpUrl ()
	{
		return $this->httpUrl;
	}
	
	/**
	 * @param mixed $httpUrl
	 */
	public function setHttpUrl ( $httpUrl ) : void
	{
		$this->httpUrl = $httpUrl;
	}
	
	/**
	 * @return mixed
	 */
	public function getHttpMethod ()
	{
		return $this->httpMethod;
	}
	
	/**
	 * @param mixed $httpMethod
	 */
	public function setHttpMethod ( $httpMethod ) : void
	{
		$this->httpMethod = $httpMethod;
	}
	
	/**
	 * @return mixed
	 */
	public function setTimestamp ()
	{
		$this->timestamp = time();
	}
	
	
	/**
	 * @return mixed
	 */
	public function getTimestamp ()
	{
		return $this->timestamp;
	}
	
	
	/**
	 * @return mixed
	 */
	public function getNonce ()
	{
		return $this->nonce;
	}
	
	/**
	 * @param mixed $nonce
	 */
	public function setNonce ( $nonce ) : void
	{
		$this->nonce = $nonce;
	}
	
	/**
	 * @return mixed
	 */
	public function getBody ()
	{
		return $this->body;
	}
	
	/**
	 * @param mixed $body
	 */
	public function setBody ( $body ) : void
	{
		$this->body = $body;
	}
	
	/**
	 * @return mixed
	 */
	public function getMchPrivateKey ()
	{
		return $this->mchPrivateKey;
	}
	
	/**
	 * @param mixed $mchPrivateKey
	 */
	public function setMchPrivateKey ( $mchPrivateKey ) : void
	{
		$this->mchPrivateKey = $mchPrivateKey;
	}
	
	/**
	 * @return mixed
	 */
	public function getSerialNo ()
	{
		return $this->serialNo;
	}
	
	/**
	 * @param mixed $serialNo
	 */
	public function setSerialNo ( $serialNo ) : void
	{
		$this->serialNo = $serialNo;
	}
	
	/**
	 * @return mixed
	 */
	public function getMerchantId ()
	{
		return $this->merchantId;
	}
	
	/**
	 * @param mixed $merchantId
	 */
	public function setMerchantId ( $merchantId ) : void
	{
		$this->merchantId = $merchantId;
	}
	
	
	public function getAuthorization ()
	{
		$url_parts = parse_url( $this->httpUrl );
		$canonical_url = ( $url_parts['path'] . ( !empty( $url_parts['query'] ) ? "?${url_parts['query']}" : "" ) );
		$message = $this->httpMethod . "\n" .
			$canonical_url . "\n" .
			$this->timestamp . "\n" .
			$this->nonce . "\n" .
			$this->body . "\n";
		openssl_sign( $message, $raw_sign, $this->mchPrivateKey, 'sha256WithRSAEncryption' );
		$sign = base64_encode( $raw_sign );
		$token = sprintf( 'mchid="%s",nonce_str="%s",timestamp="%d",serial_no="%s",signature="%s"',
			$this->merchantId, $this->nonce, $this->timestamp, $this->serialNo, $sign );
		return 'WECHATPAY2-SHA256-RSA2048 ' . $token;
	}
	
	
}
