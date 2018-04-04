<?php
/**
 * ================================
 * 微信公众号扩展
 * ================================
 * author:dclchj
 * date:2018-04-03
 * describe: 数据类基类，提供 array 和 xml 互转、生成签名的功能。
 */
namespace dclchj\wechat\data;


use dclchj\wechat\WcConfig;
use Exception;

class WcPayDataBase
{
    protected $values = array();
    
    /**
     * 使用 xmp 初始化
     * @param string $xml
     * @throws Exception
     */
    public function fromXml($xml)
    {
        if (!$xml) {
            throw new Exception("xml数据异常！");
        }
        
        //禁止引用外部xml实体
        libxml_disable_entity_loader(true);
        $this->values = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA), JSON_UNESCAPED_UNICODE), true);
    }
    
    /**
     * 使用数组初始化
     * @param array $array
     */
    public function fromArray($array)
    {
        $this->values = $array;
    }
    
    /**
     * 将 $this->values 输出为 xml 字符
     * @throws Exception
     **/
    public function toXml()
    {
        if (!is_array($this->values) || count($this->values) <= 0) {
            throw new Exception("数组为空或不是数组！");
        }
        
        $xml = "<xml>";
        foreach ($this->values as $key => $val) {
            
            if (is_numeric($val)) {
                $xml .="<" . $key . ">" . $val . "</" . $key . ">";
            } else {
                $xml .="<" . $key . "><![CDATA[" . $val . "]]></" . $key . ">";
            }
        }
        $xml .= "</xml>";
        return $xml;
    }
    
    /**
     * 获取设置的值
     */
    public function getValues()
    {
        return $this->values;
    }
    
    /**
     * 设置签名
     * @param string $value
     * @return array
     **/
    public function setSign()
    {
        $sign = $this->makeSign();
        $this->values['sign'] = $sign;
        return $sign;
    }
    
    /**
     * 获取签名
     * @return string
     **/
    public function getSign()
    {
        return $this->values['sign'];
    }
    
    /**
     * 判断是否已签名
     * @return true 或 false
     **/
    public function isSignSet()
    {
        return array_key_exists('sign', $this->values);
    }
    
    /**
     * 格式化参数格式化成url参数
     */
    private function toUrlParams()
    {
        $buff = "";
        foreach ($this->values as $k => $v)
        {
            if($k != "sign" && $v != "" && !is_array($v)){
                $buff .= $k . "=" . $v . "&";
            }
        }
        
        $buff = trim($buff, "&");
        return $buff;
    }
    
    /**
     * 生成签名
     * @return 签名，本函数不覆盖sign成员变量
     */
    public function makeSign()
    {
        // sign 不参与排序，如果设置了 sign 参数（当该类用于保存支付回调数据时会有sign值）要过滤掉。
        $values = $this->values;
        if (isset($values)) {
            unset($values['sign']);
        }
        
        //签名步骤一：按字典序排序参数
        ksort($values);
        $string = $this->toUrlParams();
        //签名步骤二：在string后加入KEY
        $string = $string . "&key=" . WcConfig::KEY;
        //签名步骤三：MD5加密
        $string = md5($string);
        //签名步骤四：所有字符转为大写
        $result = strtoupper($string);
        return $result;
    }
}