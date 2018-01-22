<?php
namespace Aliyun\Src;
use Yii;
use yii\base\Exception;
/** 
 * 配置账号信息
 */

class GlobalConfig
{
    private $config = [];
    
    protected static $_instance = null;
    
    protected   function __construct(){
        if (!isset(Yii::$app->params['smsAppKey'])) {
            throw  new Exception('缺少AppKey参数');
        }
        if (!isset(Yii::$app->params['smsAppSecret'])) {
            throw  new Exception('缺少AppSecret参数');
        }
        
        //APPID：Access Key ID
        $this->config['appid'] =  Yii::$app->params['smsAppKey'];
        // 	Access Key Secret
        $this->config['appsecret'] =  Yii::$app->params['smsAppSecret'];
    }
    
    /**
     * 单例模式，唯一入口
     */
    public static  function getInstance()
    {
        if (self::$_instance === null) {
            self::$_instance = new self();
        }
        
        return self::$_instance->config;
    }
    
}
