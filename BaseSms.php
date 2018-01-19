<?php
namespace Aliyun;

/**
 * Class BaseSms
 * @author ran
 * @date 2018/1/19
 * @desc 短信类基本配置
 */
class BaseSms
{
    public  $appKey;
    public  $appSecret;
    
    public function __construct(){
        $config  = GlobalConfig::getInstance();
        
        if (!isset($config['appid']) || empty($config['appid'])) {
            throw  new \Exception('缺少appid参数');
        }
        
        if (!isset($config['appsecret']) || empty($config['appsecret'])) {
            throw new \Exception('缺少appsecret参数');
        }
        
        $this->appKey = $config['appid'];
        $this->appSecret = $config['appsecret'];
    }
    
    
}
