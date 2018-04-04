<?php 
/**
 * ================================
 * 微信公众号扩展
 * ================================
 * author:dclchj
 * date:2018-04-02
 * describe: 配置文件
 */
namespace dclchj\wechat;

class WcConfig
{
    //==============【基础配置】=======================
    // 微信号
    const ACCOUNT = 'gh_d720dda92c45';
    // 公众账号ID
    const APPID = 'wx8754867149113c77';
    // 令牌，用于验证公众号接收用户消息接口，如用户关注公众号、点击公众号菜单、在公众号聊天框发送消息。
    const TOKEN = 'tshop';
    
    //==============【微信内H5支付】=======================
    // 公众帐号secert，仅JSAPI支付的时候需要配置
    const APPSECRET = '3e502a8ebf9a17d8b8b54d172246f646';
    // 商户号
    const MCHID = '1234';
    // 商户设置的密钥key
    const KEY = '12341';
    
    //=======【证书路径设置】=====================================
    /**
     * TODO：设置商户证书路径
     * 证书路径,注意应该填写绝对路径（仅退款、撤销订单时需要，可登录商户平台下载，
     * API证书下载地址：https://pay.weixin.qq.com/index.php/account/api_cert，下载之前需要安装商户操作证书）
     * @var path
     */
    const SSLCERT_PATH = '../cert/apiclient_cert.pem';
    const SSLKEY_PATH = '../cert/apiclient_key.pem';
    
    //=======【curl代理设置】===================================
    /**
     * TODO：这里设置代理机器，只有需要代理的时候才设置，不需要代理，请设置为0.0.0.0和0
     * 本例程通过curl使用HTTP POST方法，此处可修改代理服务器，
     * 默认CURL_PROXY_HOST=0.0.0.0和CURL_PROXY_PORT=0，此时不开启代理（如有需要才设置）
     * @var unknown_type
     */
    const CURL_PROXY_HOST = "0.0.0.0";//"10.152.18.220";
    const CURL_PROXY_PORT = 0;//8080;
}