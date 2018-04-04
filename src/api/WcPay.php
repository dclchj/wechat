<?php 
/**
 * ================================
 * 微信公众号扩展
 * ================================
 * author:dclchj
 * date:2018-04-03
 * describe: 公众号支付功能
 */
namespace dclchj\wechat\api;

use dclchj\wechat\WcConfig;
use dclchj\wechat\data\WcPayUnifiedOrder;
use dclchj\wechat\tool\WcTool;
use dclchj\wechat\tool\WcCurl;
use dclchj\wechat\tool\WcUrl;
use dclchj\wechat\data\WcPayResults;
use dclchj\wechat\data\WcPayJsApiPay;

class WcPay extends WcBase
{
    /**
     * 统一下单
     * @param WcPayResults
     */
    public function unifiedOrder(WcPayUnifiedOrder $dataObj)
    {
        // 公众账号ID
        $dataObj->setAppid(WcConfig::APPID);
        // 商户号
        $dataObj->setMch_id(WcConfig::MCHID);
        // 终端IP
        $dataObj->setSpbill_create_ip($_SERVER['REMOTE_ADDR']);
        // 随机32位字符串
        $dataObj->setNonce_str(WcTool::createNonceStr(32));
        
        // 签名
        $dataObj->setSign();
        // 转化为 xml 格式
        $xml = $dataObj->toXml();
        
        // 发送请求
        $url = WcUrl::make_unified_order();
        $res = WcCurl::post_https($url, $xml);
        // 获得结果
        $wcPayResults = new WcPayResults();
        return $wcPayResults->fromXml($res);
    }
    
    /**
     * 生成微信内H5调起支付参数
     * @param WcPayResults $dataObj
     * @return string
     */
    public function getJsapiParam(WcPayResults $dataObj)
    {
        $jsapiObj = new WcPayJsApiPay();
        // 公众号id
        $jsapiObj->setAppid($dataObj->getValue('appid'));
        // 时间戳
        $jsapiObj->setTimeStamp(time());
        // 32 位随机字符串
        $jsapiObj->setNonceStr(WcTool::createNonceStr(32));
        // 订单详情扩展字符串，统一下单接口返回的prepay_id参数值
        $jsapiObj->setPackage($dataObj->getValue('prepay_id'));
        // 签名方式
        $jsapiObj->setSignType('MD5');
        // 签名
        $jsapiObj->setSign($dataObj->makeSign());
        
        $param = json_encode($jsapiObj->getValues(), JSON_UNESCAPED_UNICODE);
        return $param;
    }
}