<?php


namespace WxPayPoint\Handle;


class StockHandle
{
    /**
     * @return string
     */
    public static function getNonceStr ()
    {
        static $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen( $characters );
        $randomString = '';
        for ( $i = 0 ; $i < 32 ; $i++ ) {
            $randomString .= $characters[rand( 0 , $charactersLength - 1 )];
        }
        return $randomString;
    }

    /**
     * 生成签名,需要传递对象和apiKey
     * @param $obj
     * @param $apiKey
     * @return string
     */
    public static function getSign ( $obj , $apikey )
    {

        foreach ( $obj as $key => $value ) {
            $Parameters[strtolower( $key )] = $value;
        }
        //签名步骤一:按字典排序参数
        ksort( $Parameters );
        $string = self::formatBizQueryParaMap( $Parameters , false );
        //步骤二:在string后加入Key
        $string = $string . "&key=" . $apikey;
        //步骤三:HMAC-SHA256加密
        $result_ = strtoupper( hash_hmac( "sha256" , $string , $apikey ) );
        return $result_;
    }

    /**
     * 将数组转成uri字符串
     * @param $paraMap
     * @param $urlencode
     * @return bool|string
     */
    public static function formatBizQueryParaMap ( $paraMap , $urlencode )
    {
        $buff = "";
        //排序数组
        ksort( $paraMap );
        foreach ( $paraMap as $key => $value ) {
            if ( $urlencode ) {
                $value = urlencode( $value );
            }
            $buff .= strtolower( $key ) . "=" . $value . "&";
        }
        $reqPar = "";
        if ( strlen( $buff ) > 0 ) {
            $reqPar = substr( $buff , 0 , strlen( $buff ) - 1 );
        }
        return $reqPar;
    }

    /**
     * @param $key
     * @return bool|resource
     */
    public static function getPrivateKey ( $key )
    {
        return \openssl_get_privatekey( \file_get_contents( $key ) );
    }

    /**
     * @param $key
     * @return resource
     */
    public static function getPublicKey ( $key )
    {
        return openssl_get_publickey( $key );
    }

}
