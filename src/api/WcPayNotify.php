<?php 
/**
 * ================================
 * 微信公众号扩展
 * ================================
 * author:dclchj
 * date:2018-04-03
 * describe: 微信内H5支付回调处理类
 */
namespace dclchj\wechat\api;

use dclchj\wechat\data\WcPayResults;
use dclchj\wechat\data\WcPayNotifyReply;

class WcPayNotify
{
    private $wcPayResults = NULL;
    
    /**
     * 获得结果
     * @return WcPayResults
     */
    public function getResult()
    {
        if (!$this->wcPayResults) {
            // 获取通知的数据
            $xml = file_get_contents('php://input');
            // 构造支付结果数据对象
            $this->wcPayResults = new WcPayResults();
            $this->wcPayResults->fromXml($xml);
        }
        return $this->wcPayResults;
    }
    
    /**
     * 返回处理结果
     * @param string $result SUCCESS 或 FAIL 。SUCCESS表示商户接收通知成功并校验成功
     */
    public function replyResult($result = 'SUCCESS')
    {
        $wcPayNotifyReply = new WcPayNotifyReply();
        $wcPayNotifyReply->setReturn_code($result);
        echo $wcPayNotifyReply->toXml();
    }
}