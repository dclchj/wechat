<?php 
/**
 * ================================
 * 微信公众号扩展
 * ================================
 * author:dclchj
 * date:2018-04-03
 * describe: 客服功能
 */
namespace dclchj\wechat\api;

use dclchj\wechat\tool\WcUrl;
use dclchj\wechat\tool\WcCurl;

class WcCustom extends WcBase
{
    /**
     * 发送文本客服消息
     * @param string $touser 用户的 oppenid
     * @param string $content 文本内容
     * @return mixed
     */
    public function send_text($touser, $content)
    {
        $msg = [];
        $msg['touser'] = $touser;
        $msg['msgtype'] = 'text';
        $msg['text'] = ['content' => $content];
        $msg = json_encode($msg, JSON_UNESCAPED_UNICODE);
        
        $url = WcUrl::make_custommsg_url($this->access_token);
        return $res = WcCurl::post_https($url, $msg);
    }
}