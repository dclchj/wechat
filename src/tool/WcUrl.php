<?php 
/**
 * ================================
 * 微信公众号扩展
 * ================================
 * author:dclchj
 * date:2018-04-02
 * describe: 构造 url
 */
namespace dclchj\wechat\tool;

use dclchj\wechat\WcConfig;

class WcUrl
{
    //=========【url】==========================================
    // 获取 token [参数：appid, appsecret]
    const TOKEN_URL = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=%s&secret=%s";
    // OAUTH 获取 code [参数：appid, redirect_uri, scope]
    const OAUTH_URL = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=%s&redirect_uri=%s&response_type=code&scope=%s&state=%s#wechat_redirect";
    // OAUTH 获取 access_token [参数：appid, appsecret, code]
    const OAUTH_ACCESS_TOKEN_URL = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=%s&secret=%s&code=%s&grant_type=authorization_code";
    // OAUTH 获取 userinfo [参数：oauth_access_token, openid]
    const OAUTH_USERINFO_URL = "https://api.weixin.qq.com/sns/userinfo?access_token=%s&openid=%s";
    
    /**
     * 构造获取 access_token 的 url
     * @return string
     */
    public static function make_token_url()
    {
        $url = sprintf(self::TOKEN_URL, WcConfig::APPID, WcConfig::APPSECRET);
        return $url;
    }
    
    /**
     * 构造 oauth 基础授权的 url
     * @param string $url
     * @param string $scope 授权类型 snsapi_base 或 snsapi_userinfo
     * @return string
     */
    public static function make_oauthurl($baseUrl, $scope, $state = 'state')
    {
        $url = sprintf(self::OAUTH_URL, WcConfig::APPID, $baseUrl, $scope, $state);
        return $url;
    }
    
    /**
     * 构造 oauth 获得 access_token 和 openid 的 url
     * @param string $code
     * @return string
     */
    public static function make_oauthurl_access_token($code)
    {
        $url = sprintf(self::OAUTH_ACCESS_TOKEN_URL, WcConfig::APPID, WcConfig::APPSECRET, $code);
        return $url;
    }
    
    /**
     * 构造获得 oauth 用户信息的 url
     * @param string $access_token
     * @param string $openid
     * @return string
     */
    public static function make_oauthurl_userinfo($access_token, $openid)
    {
        $url = sprintf(self::OAUTH_USERINFO_URL, $access_token, $openid);
        return $url;
    }
}