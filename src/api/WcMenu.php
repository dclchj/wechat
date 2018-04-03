<?php 
/**
 * ================================
 * 微信公众号扩展
 * ================================
 * author:dclchj
 * date:2018-04-02
 * describe: 公众号菜单
 */
namespace dclchj\wechat\api;

use dclchj\wechat\tool\WcUrl;
use dclchj\wechat\tool\WcCurl;

class WcMenu extends WcBase
{
    /*
    // 菜单数组格式
    $button = array(array('type' => "view",
                          'name' => "微信小店",
                          'url'  => "http://www.baidu.com/",
                         ),
                    array('name' => "我的交易",
                          'sub_button' => array(
                                                array('type' => "click",
                                                      'name' => "我的订单",
                                                      'key'  => "订单KEY"
                                                      ),
                                                array('type' => "view",
                                                      'name' => "维权",
                                                      'url'  => "https://mp.weixin.qq.com/payfb/payfeedbackindex?appid="
                                                     ),
                                                )
                          )
                    );
    // 个性化菜单配置信息
    $matchrule = array('group_id' => "",
                      'sex' => "1",
                      'country'  => "中国",
                      'province'  => "新疆",
                      'city'  => "五家渠",
                      'client_platform_type'  => "IOS"
                      );
     */
    /**
     * 创建菜单
     * @param array $button 菜单内容
     * @param array $matchrule 适用条件，用于创建个性化菜单
     * @return mixed
     */
    public function create($button, $matchrule = NULL)
    {
        // 对菜单名进行编码
        foreach ($button as &$item) {
            foreach ($item as $k => $v) {
                if (is_array($v)){
                    foreach ($item[$k] as &$subitem) {
                        foreach ($subitem as $k2 => $v2) {
                            $subitem[$k2] = urlencode($v2);
                        }
                    }
                }else{
                    $item[$k] = urlencode($v);
                }
            }
        }
        
        // 有全局菜单和为符合规则的用户订单菜单两种类型
        $url = '';
        if ($matchrule) {
            foreach ($matchrule as $k => $v) {
                $matchrule[$k] = urlencode($v);
            }
            $data = urldecode(json_encode(array('button' => $button, 'matchrule' => $matchrule)));
            $url = WcUrl::make_conditional_menu_url($this->access_token);
        }else{
            $data = urldecode(json_encode(array('button' => $button)));
            $url = WcUrl::make_createmenu_url($this->access_token);
        }
        $res = WcCurl::post_https($url, $data);
        
        return json_decode($res, true);
    }
}