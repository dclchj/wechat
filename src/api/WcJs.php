<?php 
/**
 * ================================
 * 微信公众号扩展
 * ================================
 * author:dclchj
 * date:2018-04-02
 * describe: JSAPI
 */
namespace dclchj\wechat\api;

use dclchj\wechat\tool\WcCurl;
use dclchj\wechat\tool\WcUrl;
use think\Exception;
use dclchj\wechat\tool\WcTool;
use dclchj\wechat\WcConfig;

class WcJs extends WcBase
{
    // jsapi_ticket
    protected $jsapi_ticket = '';
    protected $jsapi_ticket_time = '';
    
    /**
     * 构造函数。自动获取 jsapi_ticket。
     */
    public function __construct()
    {
        parent::__construct();
        
        // 获取 jsapi_ticket
        $this->getJsApiTicket();
    }
    
    /**
     * 获得签名包
     * @return array
     */
    public function getSignPackage() 
    {
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        $url = "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $timestamp = time();
        $nonceStr = WcTool::createNonceStr();
        $string = "jsapi_ticket={$this->jsapi_ticket}&noncestr=$nonceStr&timestamp=$timestamp&url=$url";
        $signature = sha1($string);
        $signPackage = array(
            "appId"     => WcConfig::APPID,
            "nonceStr"  => $nonceStr,
            "timestamp" => $timestamp,
            "url"       => $url,
            "signature" => $signature,
            "rawString" => $string
        );
        return $signPackage;
    }
    
    
    
    
    /**
     * 获取 jsapi_ticket
     * @throws Exception
     */
    private function getJsApiTicket()
    {
        $file_path = __DIR__ . '/../../cache/jsapi_ticket.json';
        
        $res = file_get_contents($file_path);
        $result = json_decode($res, true);
        $this->jsapi_ticket = $result["jsapi_ticket"];
        $this->jsapi_ticket_time = $result["jsapi_ticket_time"];
        
        // 如果 jsapi_ticket 已过期则重新获取
        if (time() > ($this->jsapi_ticket_time + 3600)) {
            $url = WcUrl::make_jsapi_ticket($this->access_token);
            $res = WcCurl::get_http($url);
            $result = json_decode($res, true);
            if (isset($result['errcode']) && $result['errcode']) {
                throw new Exception("获取 jsapi_ticket 出错，错误码:" . $result['errcode'] . ":" . $result['errmsg']);
            }
            $this->jsapi_ticket = $result["ticket"];
            $this->jsapi_ticket_time = time();
            file_put_contents($file_path, '{"jsapi_ticket": "'.$this->jsapi_ticket.'", "jsapi_ticket_time": '.$this->jsapi_ticket_time.'}');
        }
    }
}