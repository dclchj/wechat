<?php 
/**
 * ================================
 * 微信公众号扩展
 * ================================
 * author:dclchj
 * date:2018-04-02
 * describe: curl 请求
 */
namespace dclchj\wechat\tool;

use Exception;
use dclchj\wechat\WcConfig;

class WcCurl
{
    /**
     * 发送 http 请求，以 get 方式传参
     * @param string $url
     * @param int $timeout 超时时间，默认 30 秒。
     * @return string
     */
    public static function get_http($url, $timeout = 30)
    {
        // 初始化
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,FALSE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        // 如果有配置代理这里就设置代理
        if(WcConfig::CURL_PROXY_HOST != "0.0.0.0"
            && WcConfig::CURL_PROXY_PORT != 0){
                curl_setopt($ch,CURLOPT_PROXY, WcConfig::CURL_PROXY_HOST);
                curl_setopt($ch,CURLOPT_PROXYPORT, WcConfig::CURL_PROXY_PORT);
        }
        // 运行
        $res = curl_exec($ch);
        //返回结果
        if($res){
            curl_close($ch);
            return $res;
        } else {
            $error = curl_errno($ch);
            curl_close($ch);
            throw new Exception("curl出错，错误码：$error");
        }
    }
    
    /**
     * 发送 https 请求，以 post 方式传参
     * @param string $url
     * @param string $data 数据
     * @param boolean $useCert 是否使用证书
     * @param int $timeout 超时时间，默认 30 秒
     */
    public static function post_https($url, $data, $useCert = false, $timeout = 30)
    {
        // 初始化
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        // 如果有配置代理这里就设置代理
        if(WcConfig::CURL_PROXY_HOST != "0.0.0.0"
            && WcConfig::CURL_PROXY_PORT != 0) {
                curl_setopt($ch,CURLOPT_PROXY, WcConfig::CURL_PROXY_HOST);
                curl_setopt($ch,CURLOPT_PROXYPORT, WcConfig::CURL_PROXY_PORT);
            }
            // 设置证书 使用证书：cert 与 key 分别属于两个.pem文件
            if($useCert == true){
                curl_setopt($ch,CURLOPT_SSLCERTTYPE,'PEM');
                curl_setopt($ch,CURLOPT_SSLCERT, WcConfig::SSLCERT_PATH);
                curl_setopt($ch,CURLOPT_SSLKEYTYPE,'PEM');
                curl_setopt($ch,CURLOPT_SSLKEY, WcConfig::SSLKEY_PATH);
            }
            curl_setopt($ch, CURLOPT_POST, TRUE);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            // 运行
            $data = curl_exec($ch);
            //返回结果
            if($data){
                curl_close($ch);
                return $data;
            } else {
                $error = curl_errno($ch);
                curl_close($ch);
                throw new Exception("curl出错，错误码：$error");
            }
    }
}