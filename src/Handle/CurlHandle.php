<?php

namespace WxPayPoint\Handle;

class CurlHandle
{
	
	/**
	 * @var string 请求地址
	 */
	public $baseUrl;
	
	/**
	 * @var string 请求方式[POST、GET]
	 */
	public $method;
	
	/**
	 * @var array 请求头
	 */
	public $header = [];
	
	/**
	 * @var array 请求数据
	 */
	public $queryData = [];
	
	/**
	 * @var string 请求格式
	 */
	public $inputformat;
	
	/**
	 * @var string 输出格式
	 */
	public $outputFormat;
	
	/**
	 * @var int 超时时间
	 */
	public $exeTimeout = 10;
	
	/**
	 * @var int 连接时间
	 */
	public $connTimeout = 10;
	
	/**
	 * @var int dns超时时间
	 */
	public $dnsTimeout = 3600;
	
	/**
	 * @var bool ssl验证
	 */
	public $ssl = false;
	
	/**
	 * POST
	 */
	CONST POST = "POST";
	
	/**
	 * GET
	 */
	CONST GET = "GET";
	
	/**
	 * JSON
	 */
	CONST JSON = "JSON";
	
	public function setBaseUrl ( $baseUrl )
	{
		$this->baseUrl = $baseUrl;
	}
	
	public function setMethod ( $method )
	{
		$this->method = $method;
	}
	
	public function setHeader ( $header )
	{
		$this->header = $header;
	}
	
	public function setQueryData ( $queryData )
	{
		$this->queryData = $queryData;
	}
	
	public function setInputFormat ( $inputformat )
	{
		$this->inputformat = $inputformat;
	}
	
	public function setOutputFormat ( $outputFormat )
	{
		$this->outputFormat = $outputFormat;
	}
	
	public function setExeTimeout ( $exeTimeout )
	{
		$this->exeTimeout = $exeTimeout;
	}
	
	public function setConnTimeout ( $connTimeout )
	{
		$this->connTimeout = $connTimeout;
	}
	
	public function setDnsTimeout ( $dnsTimeout )
	{
		$this->dnsTimeout = $dnsTimeout;
	}
	
	public function packageGet ()
	{
		if ( ( !empty( $this->queryData ) ) && ( is_array( $this->queryData ) ) ) {
			$connectSymbol = ( strpos( $this->baseUrl, '?' ) ) ? '&' : '?';
			foreach ( $this->queryData as $key => $val ){
				if ( is_array( $val ) ) {
					$val = serialize( $val );
				}
				$this->baseUrl .= $connectSymbol . $key . '=' . rawurlencode( $val );
				$connectSymbol = '&';
			}
		}
	}
	
	public function packagePost ()
	{
		if ( ( !empty( $this->queryData ) ) && ( is_array( $this->queryData ) ) ) {
			foreach ( $this->queryData as $key => $val ){
				if ( is_array( $val ) ) {
					$this->queryData[$key] = $val;
				}
			}
			
			if ( $this->inputformat == self::JSON ) {
				$this->queryData = json_encode( $this->queryData );
			}
		}
	}
	
	public function packageOutput ( $output )
	{
		if ( !$output ) {
			return [];
		}
		if ( $this->outputFormat == self::JSON ) {
			$data = json_decode( $output, true );
			if ( !$data ) {
				return [$output];
			}
			return $data;
		}
	}
	
	public function sendCurl ()
	{
		$ch = curl_init();
		if ( $this->method == self::GET ) {
			$this->packageGet();
		} else {
			$this->packagePost();
			curl_setopt( $ch, CURLOPT_POST, true );
			curl_setopt( $ch, CURLOPT_POSTFIELDS, $this->queryData );
		}
		curl_setopt( $ch, CURLOPT_URL, $this->baseUrl );
		curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, $this->connTimeout );
		curl_setopt( $ch, CURLOPT_DNS_CACHE_TIMEOUT, $this->dnsTimeout );
		curl_setopt( $ch, CURLOPT_TIMEOUT, $this->exeTimeout );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $ch, CURLOPT_HTTPHEADER, $this->header );
		// 关闭ssl验证
		curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, $this->ssl );
		curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, $this->ssl );
		$output = $this->packageOutput( curl_exec( $ch ) );
		curl_close( $ch );
		return $output;
	}
}
