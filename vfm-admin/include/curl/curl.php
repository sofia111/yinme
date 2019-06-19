<?php
/**
 * 使用curl发送POST请求  
 * @param  string  $url     请求地址
 * @param  array   $data    发送的数据
 * @param  integer $timeout 请求等待时间 s
 * @return string | false   返回数据，或false
 */
function curl_post($url, $data = null, $timeout = 0)
{
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
    if(!empty($data)){
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                "cache-control: no-cache",
                // "content-type: application/json",
            )
        );
    }
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
    if ($timeout > 0) { //超时时间秒
        curl_setopt($curl, CURLOPT_TIMEOUT, $timeout);
    }
    $output = curl_exec($curl);
    $error = curl_errno($curl);
    curl_close($curl);
 
    if($error){
        return false;
    }
    return $output;
}