aliyun-dysms-php-sdk
===============

感谢选择 aliyun-dysms-php-sdk 扩展, 该扩展是基于[Yii2](https://github.com/yiisoft/yii2)框架基础开发,借助Yii2的强劲特性可以定制开发属于您自己的短信服务

[![Latest Stable Version](https://poser.pugx.org/life2016/aliyun-dysms-php-sdk/version)](https://packagist.org/packages/life2016/aliyun-dysms-php-sdk)[![Total Downloads](https://poser.pugx.org/life2016/aliyun-dysms-php-sdk/downloads)](https://packagist.org/packages/life2016/aliyun-dysms-php-sdk)[![Latest Unstable Version](https://poser.pugx.org/life2016/aliyun-dysms-php-sdk/v/unstable)](//packagist.org/packages/life2016/aliyun-dysms-php-sdk)[![Monthly Downloads](https://poser.pugx.org/life2016/aliyun-dysms-php-sdk/d/monthly)](https://packagist.org/packages/life2016/aliyun-dysms-php-sdk)[![Daily Downloads](https://poser.pugx.org/life2016/aliyun-dysms-php-sdk/d/daily)](https://packagist.org/packages/life2016/aliyun-dysms-php-sdk)

注意
---
  ** 该版本整合了阿里短信服务的aliyun-dysms-php-sdk，包含了发送短信，查询短信，短信消息模块
  
  目前有2个主要文件
  - `src\Sms.php` 短信发送API(SendSms)[这里](https://help.aliyun.com/document_detail/55451.html?spm=5176.doc55452.6.561.c9apum) && 短信查询API(QuerySendDetails)[这里](https://help.aliyun.com/document_detail/55452.html?spm=5176.doc55451.6.562.Qy7ncm)
  - `src\Msg.php` 短信消息API[这里](https://help.aliyun.com/document_detail/55500.html?spm=5176.doc55452.6.563.JwgFiJ)

环境条件
--------
- >= php5.5
- Yii2

安装
----

您可以使用composer来安装, 添加下列代码在您的``composer.json``文件中并执行``composer update``操作

```json
{
    "require": {
       "life2016/aliyun-dysms-php-sdk": "*"
    }
}
```

使用示例
--------
在使用前,请先参考阿里云平台的[开发文档](https://help.aliyun.com/document_detail/55451.html?spm=5176.10629532.106.2.4afa0f2e3l7djH)

配置参数,
```php
   //在common\config\params.php配置文件中定义配置信息
    return [
    	......
        'smsAppKey'=>'LTAIKG534543523',
        'smsAppSecret'=>'1kqm43254546tgfdgfdfsrffgttetretI',
        ......
    ];
```
	1.发送短信(SendSms)
```php
	
	$response  = Sms::getInstance()->sendSms($phone, $signName, $templateCode, $code);
    $phone ,短信接收号码。支持以逗号分隔的形式进行批量调用，批量上限为1000个手机号码,批量调用相对于单条调用及时性稍有延迟,验证码类型的短信推荐使用单条调用的方式;
    $signName,短信签名;
    $templateCode 短信模板ID
    $code 验证码
    $outId 可选，设置流水号,未传参，默认YmdHis . time()
    $upExtendCode 选填，上行短信扩展码（扩展码字段控制在7位或以下，无特殊需求用户请忽略此字段）
```

2.查询短信(QuerySendDetails)
```php
    $list = Sms::getInstance()->querySendDetails($phone, $date, $pageSize, $pageNo);
    $phone 手机号
    $date 年月日， 短信发送日期格式yyyyMMdd,支持最近30天记录查询
    $pageSize 当前页码  页大小Max=50
    $pageNo 当前页码
    $bizId 选填，发送流水号,从调用发送接口返回值中获取
```

3.短信消息
```php
		echo "消息接口查阅短信状态报告返回结果:\n";
		MsgDemo::receiveMsg(
		    // 消息类型，SmsReport: 短信状态报告
		    "SmsReport",
		    // 在云通信页面开通相应业务消息后，就能在页面上获得对应的queueName
		    "Alicom-Queue-xxxxxxxx-SmsReport",
		    /**
		     * 回调
		     * @param stdClass $message 消息数据
		     * @return bool 返回true，则工具类自动删除已拉取的消息。返回false，消息不删除可以下次获取
		     */
		    function ($message) {
		        print_r($message);
		        return false;
		    }
		);
		echo "消息接口查阅短信服务上行返回结果:\n";
		MsgDemo::receiveMsg(
		    // 消息类型，SmsUp: 短信服务上行
		    "SmsUp",
		    // 在云通信页面开通相应业务消息后，就能在页面上获得对应的queueName
		    "Alicom-Queue-xxxxxxxx-SmsUp",
		    /**
		     * 回调
		     * @param stdClass $message 消息数据
		     * @return bool 返回true，则工具类自动删除已拉取的消息。返回false，消息不删除可以下次获取
		     */
		    function ($message) {
		        print_r($message);
		        return false;
		    }
		);
```

反馈或贡献代码
--------------
您可以在[这里](https://github.com/ran1990/aliyun_sms)给我提出在使用中碰到的问题或Bug.
我会在第一时间回复您并修复.

您也可以 发送邮件r503948796@163.com给我并且说明您的问题.
