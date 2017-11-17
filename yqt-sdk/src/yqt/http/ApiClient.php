<?php
namespace yqt\http;
/**
 * Created by yqt.
 * User: pengfei.he
 * Date: 17/11/7
 * Time: 下午3:13
 */

 class ApiClient{
     /**
      * 接口请求,返回
      */
     public function curl_post($url,$str_from){
         $ch = curl_init();
         $this_header = array(
             "content-type: application/x-www-form-urlencoded;
			charset=UTF-8"
         );
         $params[CURLOPT_URL] = $url;
         $params[CURLOPT_HTTPHEADER] = $this_header;
         $params[CURLOPT_HEADER] = false;
         $params[CURLOPT_RETURNTRANSFER] = true;
         $params[CURLOPT_FOLLOWLOCATION] = true;
         $params[CURLOPT_USERAGENT] = 'Mozilla/5.0 (Windows NT 5.1; rv:9.0.1) Gecko/20100101 Firefox/9.0.1';
         $params[CURLOPT_POST] = true;
         $params[CURLOPT_TIMEOUT] = 10;//定义超时3秒钟
         $params[CURLOPT_POSTFIELDS] = $str_from;
         curl_setopt_array($ch, $params);
         $content = curl_exec($ch);
         curl_close($ch);
         return $content;
     }

 }

