<?php 
/**
 * ================================
 * 微信公众号扩展
 * ================================
 * author:dclchj
 * date:2018-04-03
 * describe: 获得用户信息
 */
namespace dclchj\wechat\api;

use dclchj\wechat\tool\WcUrl;
use dclchj\wechat\tool\WcCurl;

class WcUser extends WcBase
{
    /**
     * 获得用户信息
     * @param string $openid
     * @return array
     */
    public function getInfo($openid)
    {
        $url = WcUrl::make_userinfo_url($this->access_token, $openid);
        $res = WcCurl::get_http($url);
        return json_decode($res, true);
    }
}