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
    //=========【基础】==========================================
    // 获取 access_token [参数：appid, appsecret]
    const ACCESSTOKEN_URL = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=%s&secret=%s";
    
    //=========【user】==========================================
    // 获取用户信息 [参数：access_token, openid]
    const USERINFO_URL = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=%s&openid=%s&lang=zh_CN";
    // 批量获取用户信息 [参数：access_token]
    const BATCHGET_USERINFO_URL = "https://api.weixin.qq.com/cgi-bin/user/info/batchget?access_token=%s";
    // 获取关注者列表 [参数：access_token, next_openid]
    const SUBSCRIBE_LIST_URL = "https://api.weixin.qq.com/cgi-bin/user/get?access_token=%s&next_openid=%s";
    // 创建用户分组 [参数：access_token]
    const CREATE_GROUP_URL = "https://api.weixin.qq.com/cgi-bin/groups/create?access_token=%s";
    // 修改用户分组名称 [参数：access_token]
    const UPDATE_GROUP_URL = "https://api.weixin.qq.com/cgi-bin/groups/update?access_token=$";
    // 查询用户分组列表 [参数：access_token]
    const list_GROUP_URL = "https://api.weixin.qq.com/cgi-bin/groups/get?access_token=%s";
    // 移动用户到分组 [参数：access_token]
    const MOVE_MEMBER_GROUP_URL = "https://api.weixin.qq.com/cgi-bin/groups/members/update?access_token=%s";
    
    //=========【custom】==========================================
    // 发送客服消息 [参数：access_token]
    const CUSTOM_MSG_URL = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=%s";
    
    //=========【custom】==========================================
    // 创建菜单 [参数：access_token]
    const CREATE_MUNU_URL = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=%s";
    // 创建有条件的菜单 [参数：access_token]
    const CREATE_CONDITIONAL_MENU_URL = "https://api.weixin.qq.com/cgi-bin/menu/addconditional?access_token=%s";
    
    //=========【OAuth】==========================================
    // 获取 code [参数：appid, redirect_uri, scope]
    const OAUTH_URL = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=%s&redirect_uri=%s&response_type=code&scope=%s&state=%s#wechat_redirect";
    // 获取 access_token [参数：appid, appsecret, code]
    const OAUTH_ACCESS_TOKEN_URL = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=%s&secret=%s&code=%s&grant_type=authorization_code";
    // 获取 userinfo [参数：oauth_access_token, openid]
    const OAUTH_USERINFO_URL = "https://api.weixin.qq.com/sns/userinfo?access_token=%s&openid=%s";
    
    
    //=========【JSAPI】==========================================
    // 获取 jsapi_ticket [参数：access_token]
    const JSAPI_TICKET = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?type=jsapi&access_token=%s";
    
    
    
    
    //=========【基础】==========================================
    /**
     * 构造获取 access_token 的 url
     * @return string
     */
    public static function make_accesstoken_url()
    {
        $url = sprintf(self::ACCESSTOKEN_URL, WcConfig::APPID, WcConfig::APPSECRET);
        return $url;
    }
    
    
    //=========【user】==========================================
    /**
     * 构造获取用户信息的 url
     * @param string $access_token
     * @param string $openid
     * @return string
     */
    public static function make_userinfo_url($access_token, $openid)
    {
        $url = sprintf(self::USERINFO_URL, $access_token, $openid);
        return $url;
    }
    
    
    //=========【custom】==========================================
    /**
     * 构造发送客服消息的 url
     * @param string $access_token
     * @return string
     */
    public static function make_custommsg_url($access_token)
    {
        $url = sprintf(self::CUSTOM_MSG_URL, $access_token);
        return $url;
    }
    
    //=========【custom】==========================================
    /**
     * 构造创建菜单的 url
     * @param string $access_token
     * @return string
     */
    public static function make_createmenu_url($access_token)
    {
        $url = sprintf(self::CREATE_MUNU_URL, $access_token);
        return $url;
    }
    
    /**
     * 构造创建有条件的菜单的 url
     * @param string $access_token
     * @return string
     */
    public static function make_conditional_menu_url($access_token)
    {
        $url = sprintf(self::CREATE_CONDITIONAL_MENU_URL, $access_token);
        return $url;
    }
    
    //=========【OAuth】==========================================
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
    
    //=========【JSAPI】==========================================
    public static function make_jsapi_ticket($access_token)
    {
        $url = sprintf(self::JSAPI_TICKET, $access_token);
        return $url;
    }
}