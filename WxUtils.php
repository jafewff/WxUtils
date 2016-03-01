<?php
  /********************************************************
   *   @author jafewff
   *   @link http://www.liangboy.com
   *   @version 1.0.0
   *   @uses $wxUtils = new WxUtils();
   *   @package 微信接口工具类
   ********************************************************/
  
  class WxUtils {    
    
    /**
     * @param string $appId
     * @param string $appSecret
     * @return array 包含accessToken 和 expiresId 数据
     */
    public static function getAccessToken($appId, $appSecret) {
      $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appId&secret=$appSecret";
      $json = self::httpGet($url);
      $data = json_decode($json, TRUE);
      if (isset($data["errcode"])) {
        throw new Exception("getAccessToken Failed : [" . $data["errmsg"] . "]");
      }
      return $data;
    }
    
    /**
     * @param string $accessToken
     * @param string $openId
     * @return array 包含用户基本信息数据
     */
    public static function getWxUserInfo($accessToken, $openId) {
      $url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=$accessToken&openid=$openId&lang=zh_CN";
      $json = self::httpGet($url);
      $data = json_decode($json, TRUE);
      if (isset($data["errcode"])) {
        throw new Exception("getWxUserInfo Failed : [" . $data["errmsg"] . "]");
      }
      return $data;
    }
    
    /**
     * @param string $url
     * @return string 请求返回的数据字符串
     */
    public static function httpGet($url){
      $curl = curl_init();
      curl_setopt($curl, CURLOPT_URL, $url);
      curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
      curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
      $output = curl_exec($curl);
      curl_close($curl);
      return $output;
    }
    
    /**
     * @param string $url
     * @param array $data
     * @return string 请求返回的数据字符串
     */
    public static function httpPost($url, $data){
      $curl = curl_init();
      curl_setopt($curl, CURLOPT_URL, $url);
      curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
      curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
      curl_setopt($curl, CURLOPT_POST, 1);
      curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
      $output = curl_exec($curl);
      curl_close($curl);
      return $output;
    }
  }
?>