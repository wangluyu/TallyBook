<?php
/**
 * Created by PhpStorm.
 * User: wangluyu
 * Date: 2018/8/29
 * Time: 下午3:41
 */
/**
 * [AesSecurity aes加密，支持PHP7.1]
 */
class AES
{
    const SECRETKEY = '12f862d21d3ceafba1b88e5f22960d55';
    /**
     * [encrypt aes加密]
     * @param    [type]                   $input [要加密的数据]
     * @param    [type]                   $key   [加密key]
     * @return   [type]                          [加密后的数据]
     */
    public static function encrypt($input, $key = '')
    {
        $key = $key ?? self::SECRETKEY;
        $data = openssl_encrypt($input, 'AES-128-ECB', $key, OPENSSL_RAW_DATA);
        $data = base64_encode($data);
        return $data;
    }
    /**
     * [decrypt aes解密]
     * @param    [type]                   $sStr [要解密的数据]
     * @param    [type]                   $sKey [加密key]
     * @return   [type]                         [解密后的数据]
     */
    public static function decrypt($sStr, $sKey = '')
    {
        $sKey = $sKey ?? self::SECRETKEY;
        $decrypted = openssl_decrypt(base64_decode($sStr), 'AES-128-ECB', $sKey, OPENSSL_RAW_DATA);
        return $decrypted;
    }
}