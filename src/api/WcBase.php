<?php 
/**
 * ================================
 * 微信公众号扩展
 * ================================
 * author:dclchj
 * date:2018-04-02
 * describe: API 基类，自动获取 access_token
 */
namespace dclchj\wechat\api;

use think\Exception;
use dclchj\wechat\tool\WcUrl;
use dclchj\wechat\tool\WcCurl;

class WcBase
{
    // 过期时间
    protected $expires_time = '';
    // access_token
    protected $access_token = '';
    
    /**
     * 构造函数。自动获取 accessToken。
     */
    public function __construct()
    {
        $res = file_get_contents('../../cache/access_token.json');
        $result = json_decode($res, true);
        $this->expires_time = $result["expires_time"];
        $this->access_token = $result["access_token"];
        
        // 如果 access_tocke 已过期则重新获取
        if (time() > ($this->expires_time + 3600)){
            $url = WcUrl::make_token_url();
            $wcCurl = new WcCurl();
            $res = $wcCurl->get_http($url);
            $result = json_decode($res, true);
            if (isset($result['errcode'])) {
                throw new Exception("获取 access_token 出错，错误码:" . $result['errcode'] . ":" . $result['errmsg']);
            }
            $this->access_token = $result["access_token"];
            $this->expires_time = time();
            file_put_contents('access_token.json', '{"access_token": "'.$this->access_token.'", "expires_time": '.$this->expires_time.'}');
        }
    }
}