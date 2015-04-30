<?php
/**
 * 对 $_SERVER 的封装
 */
class Helper_Server {
    private $server;
    public $userAgent;

    public function __construct() {
        $this->server    = $_SERVER;
        $this->userAgent = $this->getServer('HTTP_USER_AGENT');
    }

    /**
     * 是否是 Ajax 请求
     * note：安卓内嵌页打开就有这个变量
     *
     * @return bool
     */
    public function isAjax() {
        return (bool)$this->getServer('HTTP_X_REQUESTED_WITH') == 'xmlhttprequest';
    }

    /**
     * @param        $key
     * @param string $default
     * @return string
     */
    public function getServer($key, $default = '') {
        return isset($_SERVER[$key]) ? $_SERVER[$key] : $default;
    }


    /**
     * 检测类型
     * @return bool
     */
    public function isMobile() {
        $userAgent = @$_SERVER['HTTP_USER_AGENT'];
        if(empty($userAgent)){
            return false;
        }
        $mobile_browser = false;
        if (preg_match('/(ipod|iphone|ipad)/i', $userAgent)){
            $mobile_browser = true;
        }elseif(preg_match('/android/i', $userAgent)){ //Android
            $mobile_browser = true;
        }elseif(preg_match('/(series60|series 60)/i',$userAgent)){ //Symbian OS
            $mobile_browser = true;
        }elseif(preg_match('/(IEMobile|Windows Phone)/i',$userAgent)){
            $mobile_browser = true;
        }
        return $mobile_browser;
    }
}