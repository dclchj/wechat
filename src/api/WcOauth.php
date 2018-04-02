<?php 
/**
 * ================================
 * 微信公众号扩展
 * ================================
 * author:dclchj
 * date:2018-04-02
 * describe: OAuth2.0 授权，用于获得用户信息
 */
namespace dclchj\wechat\api;

use dclchj\wechat\tool\WcUrl;
use dclchj\wechat\tool\WcCurl;
use think\Exception;

class WcOauth extends WcBase
{
    /**
     * 获得用户数据
     * @param string $baseUrl 获得授权以后回跳到这个网址
     * @param string $scope 类型，snsapi_base（静默授权） 或 snsapi_userinfo（需用户同意的授权）
     * @return array
     */
    public function get_userinfo($baseUrl, $scope)
    {
        if (!isset($_GET['code'])) {
            $url = WcUrl::make_oauthurl($baseUrl, $scope);
            header("Location: $url");
            exit();
        } else {
            $code = $_GET['code'];
            $url = WcUrl::make_oauthurl_access_token($code);
            $wcCurl = new WcCurl();
            $res = $wcCurl->get_http($url);
            $result = json_decode($res, true);
            if (isset($result['errcode'])) {
                throw new Exception('获取用户信息出错，出错码：' . $result['errcode'] . ": " . $result['errmsg']);
            }
            switch ($code) {
                case 'snsapi_base':
                    // 无需后续操作，只能获得用户的 openid
                    break;
                case 'snsapi_userinfo':
                    // 进一步获得用户信息
                    $access_token = $result['access_token'];
                    $openid = $result['openid'];
                    $url = WcUrl::make_oauthurl_userinfo($access_token, $openid);
                    $wcCurl = new WcCurl();
                    $res = $wcCurl->get_http($url);
                    $result = json_decode($res, true);
                    if (isset($result['errcode'])) {
                        throw new Exception('获取用户信息出错，出错码：' . $result['errcode'] . ": " . $result['errmsg']);
                    }
                    break;
            }
            return $result;
        }
    }
}