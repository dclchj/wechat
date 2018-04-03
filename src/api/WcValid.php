<?php 
/**
 * ================================
 * 微信公众号扩展
 * ================================
 * author:dclchj
 * date:2018-04-03
 * describe: 验证微信公众号消息接口
 */
namespace dclchj\wechat\api;

use dclchj\wechat\WcConfig;

class WcValid
{
    /**
     * 验证
     */
    public function valid()
    {
        $echoStr = $_GET["echostr"];
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];
        $token = WcConfig::TOKEN;
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr);
        $tmpStr = implode($tmpArr);
        $tmpStr = sha1($tmpStr);
        if($tmpStr == $signature) {
            echo $echoStr;
            exit;
        }
    }
}