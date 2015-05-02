<?php

function getIPaddress(){
    $IPaddress = '';
    if (isset($_SERVER)){
        if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])){
            $IPaddress = $_SERVER["HTTP_X_FORWARDED_FOR"];
        } else if (isset($_SERVER["HTTP_CLIENT_IP"])) {
            $IPaddress = $_SERVER["HTTP_CLIENT_IP"];
        } else {
            $IPaddress = $_SERVER["REMOTE_ADDR"];
        }
    } else {
        if (getenv("HTTP_X_FORWARDED_FOR")){
            $IPaddress = getenv("HTTP_X_FORWARDED_FOR");
        } else if (getenv("HTTP_CLIENT_IP")) {
            $IPaddress = getenv("HTTP_CLIENT_IP");
        } else {
            $IPaddress = getenv("REMOTE_ADDR");
        }
    }
    return $IPaddress;
}

 function taobaoIP($clientIP){
    $taobaoIP = 'http://ip.taobao.com/service/getIpInfo.php?ip='.$clientIP;
    $IPinfo = json_decode(file_get_contents($taobaoIP));
    $province = $IPinfo->data->region;
    $city = $IPinfo->data->city;
    $data = $province.$city;
    return $data;
 }
