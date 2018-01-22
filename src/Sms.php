<?php
namespace Aliyun\Src;

use Aliyun\Core\Profile\DefaultProfile;
use Aliyun\Core\DefaultAcsClient;
use Aliyun\Api\Sms\Request\V20170525\SendSmsRequest;
use Aliyun\Api\Sms\Request\V20170525\QuerySendDetailsRequest;
use yii\base\Exception;
/**
 * 发送短信
 * @author Administrator
 *
 */
class Sms extends BaseSms
{
    static $acsClient = null;
    
    protected static $_instance = null;
    
    /**
     * 取得AcsClient
     * @return DefaultAcsClient
     */
    public  function getAcsClient() {
        //产品名称:云通信流量服务API产品,开发者无需替换
        $product = "Dysmsapi";
        //产品域名,开发者无需替换
        $domain = "dysmsapi.aliyuncs.com";
        // 暂时不支持多Region
        $region = "cn-hangzhou";
        // 服务结点
        $endPointName = "cn-hangzhou";

        if(static::$acsClient == null) {
            //初始化acsClient,暂不支持region化
            $profile = DefaultProfile::getProfile($region, static::$appKey, static::$appSecret);
            // 增加服务结点
            DefaultProfile::addEndpoint($endPointName, $region, $product, $domain);

            // 初始化AcsClient用于发起请求
            static::$acsClient = new DefaultAcsClient($profile);
        }
        
        return static::$acsClient;
    }

    /**
     * 发送短信sendSms
     * @param string $phone 手机号，多个用逗号隔开
     * @param string $signName 签名名称
     * @param string $templateCode 模板id
     * @param string $code 发送验证码
     * @param string $outId 流水号
     * @param string $upExtendCode 上行短信扩展码
     * @throws Exception
     * @return unknown|mixed
     */
    public function sendSms($phone,$signName,$templateCode,$code,$outId=null,$upExtendCode=null) {
        
        if (empty($phone)) {
            throw  new Exception('缺少$phone参数');
        }
        if (empty($signName)) {
            throw new Exception('缺少$signName参数');
        }
        if (empty($templateCode)) {
            throw  new Exception('缺少$templateCode参数');
        }
        if (empty($code)) {
            throw  new Exception('缺少code参数');
        }
        // 初始化SendSmsRequest实例用于设置发送短信的参数
        $request = new SendSmsRequest();

        // 必填，设置短信接收号码
        $request->setPhoneNumbers($phone);

        // 必填，设置签名名称，应严格按"签名名称"填写，请参考: https://dysms.console.aliyun.com/dysms.htm#/develop/sign
        $request->setSignName($signName);

        // 必填，设置模板CODE，应严格按"模板CODE"填写, 请参考: https://dysms.console.aliyun.com/dysms.htm#/develop/template
        $request->setTemplateCode($templateCode);

        // 可选，设置模板参数, 假如模板中存在变量需要替换则为必填项
        $request->setTemplateParam(json_encode(array(  // 短信模板中字段的值
            "code"=>$code,
            "product"=>"dsd"
        ), JSON_UNESCAPED_UNICODE));
            
        // 可选，设置流水号
        $request->setOutId(empty($outId) ? (date('YmdHis') . time()) : $outId);

        // 选填，上行短信扩展码（扩展码字段控制在7位或以下，无特殊需求用户请忽略此字段）
        if (!empty($upExtendCode)) {
            $request->setSmsUpExtendCode($upExtendCode);
        }
        // 发起访问请求
        $acsResponse = $this->getAcsClient()->getAcsResponse($request);

        return $acsResponse;

    }

    /**
     * 查询短信api
     * @param string $phone 手机号单个
     * @param integer $date Ymd日期
     * @param integer $pageSize 页码
     * @param integer $pageNo 当前页
     * @param string $bizId 流水号
     * @throws Exception
     * @return unknown|mixed
     */
    public function querySendDetails($phone,$date,$pageSize,$pageNo,$bizId=null) {
        
        if (empty($phone) || !preg_match('/^1[345678]{1}\d{9}$/', $phone)) {
            throw  new Exception('缺少$phone参数');
        }
        if (empty($date)) {
            throw new Exception('缺少$date参数');
        }
        if (empty($pageSize) || intval($pageSize) < 1) {
            throw  new Exception('缺少$pageSize参数');
        }
        if (empty($pageNo) || intval($pageNo) < 1) {
            throw  new Exception('缺少$pageNo参数');
        }
        // 初始化QuerySendDetailsRequest实例用于设置短信查询的参数
        $request = new QuerySendDetailsRequest();

        // 必填，短信接收号码
        $request->setPhoneNumber($phone);

        // 必填，短信发送日期，格式Ymd，支持近30天记录查询
        $request->setSendDate($date);

        // 必填，分页大小
        $request->setPageSize($pageSize);

        // 必填，当前页码
        $request->setCurrentPage($pageNo);
        
        // 选填，短信发送流水号
        if (isset($bizId)) {
            $request->setBizId($bizId);
        }
        // 发起访问请求
        $acsResponse = static::getAcsClient()->getAcsResponse($request);

        return $acsResponse;
    }
    
    /**
     * 单例模式，唯一入口
     */
    public static  function getInstance()
    {
        if (self::$_instance === null) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
    
    

}