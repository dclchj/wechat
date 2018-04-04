<?php
/**
 * ================================
 * 微信公众号扩展
 * ================================
 * author:dclchj
 * date:2018-04-04
 * describe: 微信支付回调数据类
 */
namespace dclchj\wechat\data;

class WcPayNotifyReply extends  WcPayDataBase
{
    /**
     * 设置错误码 FAIL 或者 SUCCESS
     * @param string
     */
    public function setReturn_code($return_code)
    {
        $this->values['return_code'] = $return_code;
    }
    
    /**
     *
     * 获取错误码 FAIL 或者 SUCCESS
     * @return string $return_code
     */
    public function getReturn_code()
    {
        return $this->values['return_code'];
    }
    
    /**
     *
     * 设置错误信息
     * @param string $return_code
     */
    public function setReturn_msg($return_msg)
    {
        $this->values['return_msg'] = $return_msg;
    }
    
    /**
     *
     * 获取错误信息
     * @return string
     */
    public function getReturn_msg()
    {
        return $this->values['return_msg'];
    }
}