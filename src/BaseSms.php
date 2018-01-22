<?php
namespace Aliyun\Src;

use Aliyun\Core\Config;

/**
 * Class BaseSms
 * @author ran
 * @date 2018/1/19
 * @desc 短信类基本配置
 */
class BaseSms
{
    public static $appKey;
    public static  $appSecret;
    
    protected function __construct(){
        $config  = GlobalConfig::getInstance();
        
        if (!isset($config['appid']) || empty($config['appid'])) {
            throw  new \Exception('缺少appid参数');
        }
        
        if (!isset($config['appsecret']) || empty($config['appsecret'])) {
            throw new \Exception('缺少appsecret参数');
        }
        
        static::$appKey = $config['appid'];
        static::$appSecret = $config['appsecret'];
        
        // 加载区域结点配置
        Config::load();
    }
    
    
}
