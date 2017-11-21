# yqt-sdk-php
# YQT-SDK-PHP 服务介绍

> YQT-SDK-PHP是基于[YQT](http://doc.jia007.com)接口封装的开发工具包。她屏蔽了大部分细节、简化了接入流程、同时提供了一些便捷的方法。帮助开发者在接入过程中避开一些常见的问题，让开发者快速接入[YQT](http://doc.jia007.com)的服务。

> *注: 该开发工具包仅支持PHP语言，其他语言开发者可以参照[YQT](http://doc.jia007.com)的官方文档。*

## 一、快速接入

### 准备工作

1. 说的再好都不如一个栗子吃得饱，让我们一起来看下干货。

### DEMO 

下面我们使用php作为开发语言，对接[YQT](http://doc.jia007.com)的用户消费接口。

```php
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
'merchantNo'=>'1051100110000070',
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
if(strpos($result,'code') !== false){
//由于未请求到业务系统，返回未加密字符串
print_r(json_decode($result));
}else{
//解密结果
$froms = $aes->decrypt("$result");
print_r(json_decode($froms));
}

Console打印日志为：

(
    [code] => 1
    [orderAmount] => 0.01
    [orderNo] => 11171110141733367670
    [redirectUrl] => weixin://wxpay/bizpayurl?pr=ELVjB5S
    [message] => 受理成功
    [status] => PROCESS
)

```
