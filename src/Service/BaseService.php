<?php


namespace WxPayPoint\Service;


use WxPayPoint\Handle\CurlHandle;

abstract class BaseService
{
	/**
	 *
	 */
	abstract protected function init () : void;
	
	/**
	 * @return array|mixed
	 */
	abstract protected function getDefault () : array;
	
	/**
	 * @return array
	 */
	abstract protected function getArrayField () : array;
	
	/**
	 * @return array
	 */
	abstract protected function getObjectField () : array;
	
	
	/*
	* @return array
	*/
	abstract public function sendRequest ( array $header ) : array;
	
	/**
	 * One or the other
	 *
	 * @param array $param
	 * @param array $default
	 * @throws \Exception
	 */
	public function checkAofParam ( array $param, array $default )
	{
		if ( !$param ) {
			throw new \Exception( 'config configuration information is missing' );
		}
		$ishave = false;
		for ( $i = 0 ; $i < count( $default ) ; $i++ ){
			if ( array_key_exists( $default[$i], $param ) ) {
				$ishave = true;
			}
		}
		if ( !$ishave ) {
			$error = implode( ' ', $default );
			throw new \Exception( "The parameter $error must have one of them" );
		}
	}
	
	/**
	 * change param
	 */
	public function changeParam ( $param )
	{
		foreach ( $this->getArrayField() as $cost ){
			if ( array_key_exists( $cost, $param ) ) {
				$param[$cost] = $this->changeArray( $param[$cost] );
			}
		}
		foreach ( $this->getObjectField() as $cost ){
			if ( array_key_exists( $cost, $param ) ) {
				$param[$cost] = $this->changeObject( $param[$cost] );
			}
		}
		return $param;
	}
	
	/**
	 * check param
	 *
	 * @param array $param
	 * @param array $default
	 * @return bool
	 * @throws \Exception
	 */
	public function checkParam ( array $param, array $default )
	{
		if ( !$param ) {
			throw new \Exception( 'config configuration information is missing' );
		}
		foreach ( $default as $cost ){
			if ( !array_key_exists( $cost, $param ) ) {
				throw new \Exception( "config missing $cost fields" );
			}
		}
		return true;
	}
	
	/**
	 * change data to object
	 * @param array $value
	 * @return mixed
	 */
	public function changeObject ( array $value )
	{
		return json_decode( json_encode( $value ) );
	}
	
	/**
	 * change data to array
	 *
	 * @param array $value
	 * @return array
	 */
	public function changeArray ( array $value )
	{
		return [ $value ];
	}
	
}