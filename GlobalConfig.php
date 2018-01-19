<?php
namespace Aliyun;

/** 
 * 配置账号信息
 */

class GlobalConfig
{
    private $config = [];
    
    protected static $_instance = null;
    
    protected   function __construct(){
        //APPID：Access Key ID
        $this->config['appid'] =  \Yii::$app->params['wxpay']['smsAppKey'];
        // 	Access Key Secret
        $this->config['appsecret'] =  \Yii::$app->params['wxpay']['smsAppSecret'];
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
