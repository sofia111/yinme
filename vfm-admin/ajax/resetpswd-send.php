<?php
require '../config.php';
session_name($_CONFIG["session_name"]);
session_start();
require('sms.php');
require_once '../users/users.php';
/**
 * 发送短信
 */
function sendSms($mobile,$code) {
    $params = array ();

    // *** 需用户填写部分 ***

    // fixme 必填: 请参阅 https://ak-console.aliyun.com/ 取得您的AK信息
    $accessKeyId = "LTAIXiFNguwbr1Td";
    $accessKeySecret = "BBfyL5I0Vs3Qkw82oYMMnd6m9HiCwT";

    // fixme 必填: 短信接收号码
    $params["PhoneNumbers"] = $mobile;

    // fixme 必填: 短信签名，应严格按"签名名称"填写，请参考: https://dysms.console.aliyun.com/dysms.htm#/develop/sign
    $params["SignName"] = "印了么";

    // fixme 必填: 短信模板Code，应严格按"模板CODE"填写, 请参考: https://dysms.console.aliyun.com/dysms.htm#/develop/template
    $params["TemplateCode"] = "SMS_130911722";

    // fixme 可选: 设置模板参数, 假如模板中存在变量需要替换则为必填项
    $params['TemplateParam'] = array(
        "code" => $code
    );

    // *** 需用户填写部分结束, 以下代码若无必要无需更改 ***
    if(!empty($params["TemplateParam"]) && is_array($params["TemplateParam"])) {
        $params["TemplateParam"] = json_encode($params["TemplateParam"]);
    }

    // 初始化SignatureHelper实例用于设置参数，签名以及发送请求
    $helper = new SignatureHelper();
	
    // 此处可能会抛出异常，注意catch
    $content = $helper->request(
        $accessKeyId,
        $accessKeySecret,
        "dysmsapi.aliyuncs.com",
        array_merge($params, array(
            "RegionId" => "cn-hangzhou",
            "Action" => "SendSms",
            "Version" => "2017-05-25",
        ))
    );
    //var_dump($content);exit();
    return json_decode(json_encode($content),true);
}

if( !empty($_POST['mobile']) ){
	$mobile = trim($_POST['mobile']);
	$_SESSION["mobile_".$mobile] = rand(100000,999999);
	//var_dump($_SESSION["mobile_".$mobile]);
	$result = sendSms($mobile,$_SESSION["mobile_".$mobile]);
	
	if( strtolower($result['Code']) == 'ok' ){
		exit(json_encode(array('status'=>1,'info'=>'发送成功')));
	}else{
		exit(json_encode(array('status'=>0,'info'=>$result['Message'])));
	}
}
