<?php
/**
 * Created by yqt.
 * User: pengfei.he
 * Date: 17/11/7
 * Time: 下午3:13
 */
/**
 * 接口请求函数
 */
namespace yqt;

use yqt\http\ApiClient;
require_once(dirname(dirname(__FILE__)).'/yqt/security/CryptAES.php');
require_once(dirname(dirname(__FILE__)).'/yqt/http/ApiClient.php');

//加解密类
$aes = new \yqt\security\CryptAES();
//请求服务类
$request_yqt = new ApiClient();

//商户编号（如为代理商模式，此处为代理商商编和对应秘钥。
//如为直销商户模式，为直销商户商编和对应秘钥）
$agentNO = '';//商编
//商户秘钥（前16位）
$aes->set_key('');//秘钥
$aes->require_pkcs5();
//请求参数
$data = array(
    'requestNo'=>'asdfghj123456789sd',
    'merchantNo'=>'商户编号',
    'orderAmount'=> '0.01',
    'payTool' =>'WECHAT_SCAN',
    'currency'=>'CNY',
    'openId'=>'testopenid',
    'orderDate'=>'2017-11-17 11:10:04',
    'productName'=>'测试',
    'productDesc'=>'ceshi',
    'serverCallbackUrl'=>'http://www.qq.com',
    'sceneType'=>'MIS',
    'clientIp'=>'192.168.1.1'
);
//对请求参数进行加密
$from = $aes->encrypt(json_encode($data));

//请求的地址
$url = 'https://api.jia007.com/api-center/rest/v1.0/yqt/consume';
$params = "appKey=$agentNO&data=$from";

//接口请求返回加密内容
$result = $request_yqt->curl_post($url,$params);
//对接口返回内容进行解密


//打印输出
if(strpos($result,'code') !== false){
    //由于未请求到业务系统，返回未加密字符串
    print_r(json_decode($result));
}else{
    //解密结果
    $froms = $aes->decrypt("$result");
    print_r(json_decode($froms));
}
//输出结果
//stdClass Object
//(
//    [code] => 1
//    [orderAmount] => 0.01
//    [orderNo] => 11171110141733367670
//    [redirectUrl] => weixin://wxpay/bizpayurl?pr=ELVjB5S
//    [message] => 受理成功
//[status] => PROCESS
//)

