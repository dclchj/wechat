<?php 
/**
 * ================================
 * 微信公众号扩展
 * ================================
 * author:dclchj
 * date:2018-04-02
 * describe: 回复用户消息
 */
namespace dclchj\wechat\api;

class WcTransmit
{
    /**
     * 回复文本消息
     * @param string $to_user_name 用户的oppenid
     * @param string $from_user_name 公众号的oppenid
     * @parma string $content 文本消息
     * @return string xml格式的字符串
     */
    public static function text($to_user_name, $from_user_name, $content)
    {
        $xmlTpl = "<xml>
                        <ToUserName><![CDATA[%s]]></ToUserName>
                        <FromUserName><![CDATA[%s]]></FromUserName>
                        <CreateTime>%s</CreateTime>
                        <MsgType><![CDATA[text]]></MsgType>
                        <Content><![CDATA[%s]]></Content>
                    </xml>";
        $result = sprintf($xmlTpl, $to_user_name, $from_user_name, time(), $content);
        return $result;
    }
    
    /*
     单图文：
     $content = [];
     $content[] = ["Title"=>"单图文标题",  "Description"=>"单图文内容", "PicUrl"=>"http://images2015.cnblogs.com/blog/340216/201605/340216-20160515215306820-740762359.jpg", "Url" =>"http://m.cnblogs.com/?u=txw1958"];
     
     多图文：
     $content = [];
     $content[] = ["Title"=>"多图文1标题", "Description"=>"", "PicUrl"=>"http://images2015.cnblogs.com/blog/340216/201605/340216-20160515215306820-740762359.jpg", "Url" =>"http://m.cnblogs.com/?u=txw1958"];
     $content[] = ["Title"=>"多图文2标题", "Description"=>"", "PicUrl"=>"http://d.hiphotos.bdimg.com/wisegame/pic/item/f3529822720e0cf3ac9f1ada0846f21fbe09aaa3.jpg", "Url" =>"http://m.cnblogs.com/?u=txw1958"];
     $content[] = ["Title"=>"多图文3标题", "Description"=>"", "PicUrl"=>"http://g.hiphotos.bdimg.com/wisegame/pic/item/18cb0a46f21fbe090d338acc6a600c338644adfd.jpg", "Url" =>"http://m.cnblogs.com/?u=txw1958"];
     */
    /**
     * 回复图文消息（支持单图文和多图文）
     * @param string $to_user_name 用户的oppenid
     * @param string $from_user_name 公众号的oppenid
     * @parma array $newArray 图文内容
     * @return string xml格式的字符串
     */
    public static function news($to_user_name, $from_user_name, $newsArray)
    {
        $itemTpl = "<item>
                        <Title><![CDATA[%s]]></Title>
                        <Description><![CDATA[%s]]></Description>
                        <PicUrl><![CDATA[%s]]></PicUrl>
                        <Url><![CDATA[%s]]></Url>
                    </item>";
        $item_str = "";
        foreach ($newsArray as $item){
            $item_str .= sprintf($itemTpl, $item['Title'], $item['Description'], $item['PicUrl'], $item['Url']);
        }
        
        $xmlTpl = "<xml>
                        <ToUserName><![CDATA[%s]]></ToUserName>
                        <FromUserName><![CDATA[%s]]></FromUserName>
                        <CreateTime>%s</CreateTime>
                        <MsgType><![CDATA[news]]></MsgType>
                        <ArticleCount>%s</ArticleCount>
                        <Articles>$item_str</Articles>
                </xml>";
        $result = sprintf($xmlTpl, $to_user_name, $from_user_name, time(), count($newsArray));
        return $result;
    }
    
    /*
     $musicArray = [];
     $musicArray = ["Title"=>"最炫民族风", "Description"=>"歌手：凤凰传奇", "MusicUrl"=>"http://mascot-music.stor.sinaapp.com/zxmzf.mp3", "HQMusicUrl"=>"http://mascot-music.stor.sinaapp.com/zxmzf.mp3"];
     */
    /**
     * 回复音乐消息
     * @param string $to_user_name 用户的oppenid
     * @param string $from_user_name 公众号的oppenid
     * @parma array $musicArray 音乐内容
     * @return string xml格式的字符串
     */
    public static function music($to_user_name, $from_user_name, $musicArray)
    {
        $itemTpl = "<Music>
                        <Title><![CDATA[%s]]></Title>
                        <Description><![CDATA[%s]]></Description>
                        <MusicUrl><![CDATA[%s]]></MusicUrl>
                        <HQMusicUrl><![CDATA[%s]]></HQMusicUrl>
                    </Music>";
        $item_str = sprintf($itemTpl, $musicArray['Title'], $musicArray['Description'], $musicArray['MusicUrl'], $musicArray['HQMusicUrl']);
        
        $xmlTpl = "<xml>
                        <ToUserName><![CDATA[%s]]></ToUserName>
                        <FromUserName><![CDATA[%s]]></FromUserName>
                        <CreateTime>%s</CreateTime>
                        <MsgType><![CDATA[music]]></MsgType>
                        $item_str
                    </xml>";
                        $result = sprintf($xmlTpl, $to_user_name, $from_user_name, time());
                        return $result;
    }
    
    /*
     $imageArray = ["MediaId" => MediaId];
     */
    /**
     * 回复图片消息
     * @param string $to_user_name 用户的oppenid
     * @param string $from_user_name 公众号的oppenid
     * @parma array $imageArray 音乐内容
     * @return string xml格式的字符串
     */
    public static function image($to_user_name, $from_user_name, $imageArray)
    {
        $itemTpl = "<Image>
                        <MediaId><![CDATA[%s]]></MediaId>
                    </Image>";
        $item_str = sprintf($itemTpl, $imageArray['MediaId']);
        
        $xmlTpl = "<xml>
                        <ToUserName><![CDATA[%s]]></ToUserName>
                        <FromUserName><![CDATA[%s]]></FromUserName>
                        <CreateTime>%s</CreateTime>
                        <MsgType><![CDATA[image]]></MsgType>
                        $item_str
                    </xml>";
                        $result = sprintf($xmlTpl, $to_user_name, $from_user_name, time());
                        return $result;
    }
    
    /*
     $voiceArray = ["MediaId" => MediaId];
     */
    /**
     * 回复语音消息
     * @param string $to_user_name 用户的oppenid
     * @param string $from_user_name 公众号的oppenid
     * @parma array $voiceArray 语音内容
     * @return string xml格式的字符串
     */
    public static function voice($to_user_name, $from_user_name, $voiceArray)
    {
        $itemTpl = "<Voice>
                        <MediaId><![CDATA[%s]]></MediaId>
                    </Voice>";
        $item_str = sprintf($itemTpl, $voiceArray['MediaId']);
        
        $xmlTpl = "<xml>
                        <ToUserName><![CDATA[%s]]></ToUserName>
                        <FromUserName><![CDATA[%s]]></FromUserName>
                        <CreateTime>%s</CreateTime>
                        <MsgType><![CDATA[voice]]></MsgType>
                        $item_str
                    </xml>";
                        $result = sprintf($xmlTpl, $to_user_name, $from_user_name, time());
                        return $result;
    }
    
    /*
     $videoArray = ["MediaId" => MediaId, "ThumbMediaId"= > ThumbMediaId, "Title" => "", "Description" => ""];
     */
    /**
     * 回复视频消息
     * @param string $to_user_name 用户的oppenid
     * @param string $from_user_name 公众号的oppenid
     * @parma array $videoArray 视频内容
     * @return string xml格式的字符串
     */
    public static function video($to_user_name, $from_user_name, $videoArray)
    {
        $itemTpl = "<Video>
                        <MediaId><![CDATA[%s]]></MediaId>
                        <ThumbMediaId><![CDATA[%s]]></ThumbMediaId>
                        <Title><![CDATA[%s]]></Title>
                        <Description><![CDATA[%s]]></Description>
                    </Video>";
        $item_str = sprintf($itemTpl, $videoArray['MediaId'], $videoArray['ThumbMediaId'], $videoArray['Title'], $videoArray['Description']);
        
        $xmlTpl = "<xml>
                        <ToUserName><![CDATA[%s]]></ToUserName>
                        <FromUserName><![CDATA[%s]]></FromUserName>
                        <CreateTime>%s</CreateTime>
                        <MsgType><![CDATA[video]]></MsgType>
                        $item_str
                    </xml>";
                        $result = sprintf($xmlTpl, $to_user_name, $from_user_name, time());
                        return $result;
    }
    
    /**
     * 回复多客服消息
     * @param string $to_user_name 用户的oppenid
     * @param string $from_user_name 公众号的oppenid
     * @return string xml格式的字符串
     */
    public static function service($to_user_name, $from_user_name)
    {
        $xmlTpl = "<xml>
                        <ToUserName><![CDATA[%s]]></ToUserName>
                        <FromUserName><![CDATA[%s]]></FromUserName>
                        <CreateTime>%s</CreateTime>
                        <MsgType><![CDATA[transfer_customer_service]]></MsgType>
                    </xml>";
        $result = sprintf($xmlTpl, $to_user_name, $from_user_name, time());
        return $result;
    }
}