<?php 

	// 步骤1.设置appid和appsecret
        $appid = 'wx4852fb06388bba05'; //此处填写绑定的微信公众号的appid
        $appsecret = '5faf6fbaeb4769bf888ee07780768d1e'; //此处填写绑定的微信公众号的密钥id

        // 步骤2.生成签名的随机串
        function nonceStr($length){
                $str = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJK1NGJBQRSTUVWXYZ';//随即串，62个字符
                $strlen = 62;
                while($length > $strlen){
                $str .= $str;
                $strlen += 62;
                }
                $str = str_shuffle($str);
                return substr($str,0,$length);
        }

        // 步骤3.获取access_token
        $result = http_get('https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$appid.'&secret='.$appsecret);
		$json = json_decode($result,true);
        $access_token = $json['access_token'];

        function http_get($url){
                $oCurl = curl_init();
                if(stripos($url,"https://")!==FALSE){
                        curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, FALSE);
                        curl_setopt($oCurl, CURLOPT_SSL_VERIFYHOST, FALSE);
                        curl_setopt($oCurl, CURLOPT_SSLVERSION, 1); //CURL_SSLVERSION_TLSv1
                }
                curl_setopt($oCurl, CURLOPT_URL, $url);
                curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1 );
                $sContent = curl_exec($oCurl);
                $aStatus = curl_getinfo($oCurl);
                curl_close($oCurl);
                if(intval($aStatus["http_code"])==200){
                        return $sContent;
                }else{
                        return false;
                }
        }

        // 步骤4.获取ticket
        $url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?type=jsapi&access_token=$access_token";
        $res = json_decode ( http_get ( $url ) );
        $ticket = $res->ticket;


        // 步骤5.生成wx.config需要的参数
        // $surl = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		$surl = urldecode($_POST['url']);
        $ws = getWxConfig( $ticket,$surl,time(),nonceStr(16) );

        function getWxConfig($jsapiTicket,$url,$timestamp,$nonceStr) {
                $string = "jsapi_ticket=$jsapiTicket&noncestr=$nonceStr&timestamp=$timestamp&url=$url";
                $signature = sha1 ( $string );
                $appid = 'wx4852fb06388bba05';
                $WxConfig["appId"] = $appid;
                $WxConfig["nonceStr"] = $nonceStr;
                $WxConfig["timestamp"] = $timestamp;
                $WxConfig["url"] = $url;
                $WxConfig["signature"] = $signature;
                $WxConfig["rawString"] = $string;
                return $WxConfig;
        }
        $wxInfo = '{"data": {
        		"appId": "'.$ws["appId"].'",
        		"nonceStr": "'.$ws["nonceStr"].'",
        		"timestamp": "'.$ws["timestamp"].'",
        		"url": "'.$ws["url"].'",
        		"signature": "'.$ws["signature"].'",
        		"rawString": "'.$ws["rawString"].'"
        	}
        }';
        echo $wxInfo;

 ?>