<?php
 header("Content-Type: text/html; charset=UTF-8");
 error_reporting(E_ALL || ~E_NOTICE);
 ini_set('display_errors', 'On');

  if(isset($_POST["order_create"]))
  {
  	  require_once "./lib/config.php";
      require_once "./lib/Log.class.php";
      require_once "./lib/Epay.class.php";  


      $EpayClient = new EpayClientAop($config);
      $LogClient  = new LogClientAop();

      /****设置订单号****/
      $EpayClient->setOutTradeNo($_POST["order_no"]);

      /****设置支付商品名称****/
      $EpayClient->setSubject($_POST["subject"]);

      /****设置订单金额****/
      $EpayClient->setTradeAmount($_POST["order_amount"]);

      /****设置订单等待时间****/ //非必选 格式为"1m","2m"等默认"5m"
      $EpayClient->setTimeOut($_POST["time_expire"]);

      /****设置订单支付类型****/ //非必选 1为手机H5支付0为电脑支付 0为默认 QQ钱包目前不支持H5支付
      $EpayClient->setMobile($_POST["mobile"]);

      /****记录所有发出参数****/
      $data = $EpayClient->getAllparam();

      $LogClient->request_log($data);

      /****发送请求获取支付二维码或支付连接****/
      if($_POST["payChannel"] != "wx" || $_POST["mobile"] != "1")
      {
        $result = json_decode($EpayClient->create($_POST["payChannel"]));
        //建议打印$result查看是否有错误,var_dump($result);
      }
      else
      {
        /****针对微信H5支付因为微信限制必须通过方法访问对应链接进行支付****/
        $url = $EpayClient->WxMobilePay();

        header("Location:$url");exit;
      }

      /****最终处理****/
      if($_POST["mobile"])
      {
        header("Location:".$result->pay_url);exit;
      }
      else
      {
         $result = $EpayClient->imgCode($result->pay_url);
         $img = "<img src=\"data:image/png;base64,".str_replace(PHP_EOL, '',$result)."\">";
      }

?>
<script type="text/javascript" src="https://www.payonline.xin/static/js/jquery.min.js"></script>
<script type="text/javascript">

    /***轮询检查支付结果***/

    setInterval(function(){

      $.ajax({

        url : "./log/success.log",
        async : "true",
        dataType : 'json',
        type : "post",

        success:function(data) {

          if(data == <?php echo $_POST["order_no"]; ?>)
          {
            alert("支付成功!请自行完成剩余逻辑处理!");
          }
        },

        error:function(XMLHttpRequest, textStatus, errorThrown) {

            // 状态码
            console.log(XMLHttpRequest.status);
            // 状态
            console.log(XMLHttpRequest.readyState);
            // 错误信息   
            console.log(textStatus);
        }

      });

    },1000);

</script>
<?php
  } 
?>
