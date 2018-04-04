<?php
/**
 * ================================
 * 微信公众号扩展
 * ================================
 * author:dclchj
 * date:2018-04-0
 * describe: 调用结果类。用于：统一下单的返回值、公众号H5支付回调的返回值
 */
namespace dclchj\wechat\data;

use Exception;

class WcPayResults extends WcPayDataBase
{
    /**
     * 获得数据
     * @param mix
     */
    public function getValue($key)
    {
        return $this->values[$key];
    }
    
    /**
     * 检测返回结果
     * @throws Exception
     */
    public function checkResult()
    {
        if(!array_key_exists("appid", $this->values) || !array_key_exists("prepay_id", $this->values) || $this->values['prepay_id'] == "") {
            throw new Exception("统一下单返回参数错误");
        }
    }
    
    /**
     * 检测签名
     * @throws Exception
     * @return true
     */
    public function checkSign()
    {
        if (!$this->isSignSet()) {
            throw new Exception("未设置签名！");
        }
        
        $sign = $this->makeSign();
        if ($this->getSign() != $sign) {
            throw new Exception("签名错误！");
        }
        
        return true;
    }
}