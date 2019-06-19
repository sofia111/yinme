<?php
if (isset($_POST['shoplist'])) {
if(file_exists('vfm-admin/users/shops.php'))
    require 'vfm-admin/users/shops.php';
$data = $_POST;

if ($data['shoplist'] == 0) {
  echo "<script>location.href='yinme.php'</script>";
    die();
}
$data['shoplist'] -= 1;
global $mysql_conn; // 数据库连接

// 获取用户工作路径
$work_path = basename(SetUp::getConfig('starting_dir')) . '/' . json_decode(GateKeeper::getUserInfo('dir'))[0] . '/' ;
/*var_dump($data);
die();*/
for ($i = 0 ; $i<count($data['file']);$i++) {
    if (!file_exists(realpath($work_path . $data['file'][$i]['realfilename']))) {
        echo "<h2>文件错误</h2>";
        echo "<script>setTimeout(\"location.href='yinme.php'\", 2000);</script>";
        die();
    }
}

//时间
$data['time'] = date('Y-m-d H:i:s');
//订单号
$data['order_no'] = date("YmdHis") . rand(100000, 999999);
//订单标题
$data['subject'] = "打印订单" . $data['order_no'];
//交易金额（单位元）
$data['order_amount'] = 0;


for($i = 0 ; $i<count($data['file']);$i++){
    $page_price = $data['file'][$i]['pagetype'] =='onepage'?
        $_SHOPS[$data['shoplist']]['onesideprice'] :
        $_SHOPS[$data['shoplist']]['bothsideprice'];
   
    $bind_price = $_SHOPS[$data['shoplist']]['bind_price'];
    $Money = $data['file'][$i]['over'] * $page_price;
    $Money = $data['file'][$i]['binding'] ? 
        $Money + $bind_price : 
        $Money;  
   
    $Money = $Money * $data['file'][$i]['copies'];
   
    $data['order_amount'] += $Money;
    // 生成下载链接
    $alt = SetUp::getConfig('salt');
    $altone = SetUp::getConfig('session_name');
    $thislink = $work_path . rawurlencode($data['file'][$i]['realfilename']);
    $dash = md5($alt.base64_encode($thislink).$altone.$alt);
    if (SetUp::getConfig('enable_prettylinks') == true) {
        $downlink = 'download/'.base64_encode($thislink).'/h/'.$dash;
    } else {
        $downlink = 'vfm-admin/vfm-downloader.php?q='.base64_encode($thislink).'&h='.$dash;
    }
    $data['file'][$i]['download'] = $downlink;
}
//设置本次打印优惠页数
$_SESSION['off_pagenum'] = $data['off_pagenumlist'];
$_SESSION['getisfirstorder'] = $data['getisfirstorder'];
/*var_dump($_SESSION['off_pagenum']);*/
//是否存在配送费
$deliveryprice = $_SHOPS[$data['shoplist']]['deliveryprice'];
$delivery_price = $data['deliverylist'] ? $deliveryprice:0;
var_dump($data['deliverylist']);
var_dump($data['deliveryaddrelist']);
$deliveryaddrelist = $data['deliverylist'] ? $data['deliveryaddrelist'] : '';
if($data['order_amount']>10){//超过十元免配送费
    $data['freedelivery'] = $delivery_price;
} else{
    $data['freedelivery'] = 0;
}
/*var_dump($data['input_off_pricelist']);
die();*/
$data['order_amount'] -= $data['off_pricelist'];
$data['order_amount'] += $delivery_price;

$yuanjia=$data['order_amount'];
//减免

$data['yinbi'] = '0';
if (file_exists('../include/mysql/MySQL.class.php')) {
    require '../include/mysql/MySQL.class.php';
}
$conn=MySQL::getlink();
$sql = "select invitation from user where userName = '".$_SESSION['vfm_user_name']."'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $price = $data['order_amount'];
        $number = $row["invitation"];
        if($number > 0&& $price > 0.6) {
            $price -= 1;
      if($price<=0)$price=0.01;//最低付款1毛
            $_SESSION['yinbi'] = $number-1;
            $data['yinbi'] = 1;
            $data['order_amount'] = $price ;
        }
    }
}
$data['order_amount'] = $data['order_amount'];
for ($i=0; $i <count($data['file']) ; $i++) { 
    if ($i==0) {
        $data['file'][$i]['price'] = $data['order_amount'];
        $data['file'][$i]['free_delivery'] = $data['freedelivery']; 
        $data['file'][$i]['discount'] = $data['off_pricelist'];
        $data['file'][$i]['yinbi'] = $data['yinbi'];
    }else{
        $data['file'][$i]['price'] = '批量';
        $data['file'][$i]['free_delivery'] = '批量';
        $data['file'][$i]['discount'] = '批量';
        $data['file'][$i]['yinbi'] = '批量';
    }
    
    $data['file'][$i]['side'] = $data['file'][$i]['pagetype'] == 'onepage' ?
        '否' : '是';
    $data['file'][$i]['range'] = $data['file'][$i]['start'] . '-' . $data['file'][$i]['over'];
    $data['file'][$i]['bind'] = $data['file'][$i]['binding'] ? '是' : '否';
    $data['state'] = '已下单';
    $data['is_temp'] = 1;
    $data['school'] = $_SHOPS[$data['shoplist']]['school'];
    $data['shop'] = $_SHOPS[$data['shoplist']]['name'];
    $data['user'] = $_SESSION['vfm_user_name'];
    /*$data['mobile'] = GateKeeper::getUserInfo('email');*/
    $data['remarks'] = isset($data['commentlist']) ? $data['commentlist'] : '';
    $data['mobile'] = isset($data['deliveryphonelist']) ? $data['deliveryphonelist'] : GateKeeper::getUserInfo('email');
    $data['delivery_addre'] = $deliveryaddrelist;
   

    // 删除多余键值
    unset($data['file'][$i]['start'], $data['file'][$i]['over'], $data['file'][$i]['binding'], $data['file'][$i]['pagetype'], $data['file'][$i]['realfilename']);
}
unset($data['commentlist'],$data['delivery']);
if ($data['delivery_addre'] !='') {
    $que_data = [
        ':delivery_addre' => $data['delivery_addre'],
        ':user' => $_SESSION['vfm_user_name']
    ];
    $sql = "UPDATE user SET `addre` = :delivery_addre WHERE userName =:user";
    $stmt = $mysql_conn->prepare($sql);
    $stmt->execute($que_data);
}
// 查询是否存在该用户的临时订单
$sql = "SELECT ID FROM print 
            WHERE `user`=:user
            AND `is_temp`=:is_temp";
$query_data = [
    ':user' => $_SESSION['vfm_user_name'],
    ':is_temp' => 1
];
$stmt = $mysql_conn->prepare($sql);
$stmt->execute($query_data);
$res_arr = $stmt->fetchAll();
/*var_dump($data['mobile']);
die();*/
/*md5("app_id=KUXNk07WD19bgpF&charset=UTF-8&order_amount=0.1&order_no=20181012210444203518&sign-type=md5&key=DVU0AFHabg6oWLc")*/
$data['sign']=md5("app_id=KUXNk07WD19bgpF&key=DVU0AFHabg6oWLc");
if (!empty($res_arr)) {
    // 存在临时表单，更新
    for ($i=0; $i <count($data['file']) ; $i++) { 
            
        if($i<count($res_arr)){
            $sql_data=[
            ':order' =>$data['order_no'], 
            ':mobile' => $data['mobile'],                 
            ':school' =>$data['school'],
            ':shop' =>$data['shop'],
            ':filename' =>$data['file'][$i]['name'],
            ':copies' =>$data['file'][$i]['copies'],
            ':side' =>$data['file'][$i]['side'],
            ':range' =>$data['file'][$i]['range'],
            ':bind' =>$data['file'][$i]['bind'],
            ':remarks' =>$data['remarks'],
            ':price' =>$data['file'][$i]['price'],
            ':download' =>$data['file'][$i]['download'],
            ':state' =>$data['state'],
            ':time' =>$data['time'],
            ':free_delivery' =>$data['file'][$i]['free_delivery'],
            ':delivery_addre' => $data['delivery_addre'],
            ':discount' =>$data['file'][$i]['discount'],
            ':yinbi' => $data['file'][$i]['yinbi']          
            ];
      
            $sql = 'UPDATE print SET 
                    `order`=:order,
                    `mobile`=:mobile,
                    `school`=:school,
                    `shop`=:shop,
                    `filename`=:filename,
                    `copies`=:copies,
                    `side`=:side,
                    `range`=:range,
                    `bind`=:bind,
                    `remarks`=:remarks,
                    `price`=:price,
                    `download`=:download,
                    `state`=:state,
                    `time`=:time,
                    `free_delivery` =:free_delivery,
                    `delivery_addre` = :delivery_addre,
                    `discount` = :discount,
                    `yinbi` =:yinbi
                    WHERE `ID`=' . $res_arr[$i]['ID'];
            $stmt = $mysql_conn->prepare($sql);
           /* var_dump($stmt);*/
    /*       echo "<pre>";
            var_dump($sql_data);
die();*/
            if (!$stmt->execute($sql_data)) {
                echo "<h1 class='text-center'>生成订单失败，请重试...</h1>";
                die();  
            }
        }
        else{
            $sql_data=[
            ':order' =>$data['order_no'],
            ':user' =>$data['user'], 
            ':mobile' =>$data['mobile'],       
            ':school' =>$data['school'],
            ':shop' =>$data['shop'],
            ':filename' =>$data['file'][$i]['name'],
            ':copies' =>$data['file'][$i]['copies'],
            ':side' =>$data['file'][$i]['side'],
            ':range' =>$data['file'][$i]['range'],
            ':bind' =>$data['file'][$i]['bind'],
            ':remarks' =>$data['remarks'],
            ':price' =>$data['file'][$i]['price'],
            ':download' =>$data['file'][$i]['download'],
            ':state' =>$data['state'],
            ':time' =>$data['time'],
            ':is_temp' =>$data['is_temp'],
            ':free_delivery' =>$data['file'][$i]['free_delivery'],
            ':delivery_addre' =>$data['delivery_addre'],
            ':discount' =>$data['file'][$i]['discount'],
            ':yinbi' => $data['file'][$i]['yinbi']    
        ];
      /*  var_dump($sql_data);*/
            $sql = "INSERT INTO print VALUES(
                    NULL, 
                    :order, 
                    :user, 
                    :mobile, 
                    :school, 
                    :shop, 
                    :filename,
                    :copies,
                    :side,
                    :range,
                    :bind,
                    :remarks,
                    :price,
                    :download,
                    :state,
                    :time,
                    :is_temp,
                    :free_delivery,
                    :delivery_addre,
                    :discount,
                    :yinbi
                )";
            $stmt = $mysql_conn->prepare($sql);
            /*var_dump($sql_data);*/
            if (!$stmt->execute($sql_data)) {
            echo "<h1 class='text-center'>生成订单失败，请重试...</h1>";
            die();  
            }
        }                  
        
    } 
}else {
    for ($i=0; $i <count($data['file']) ; $i++) { 
        $sql_data=[
            ':order' =>$data['order_no'],
            ':user' =>$data['user'], 
            ':mobile' =>$data['mobile'],       
            ':school' =>$data['school'],
            ':shop' =>$data['shop'],
            ':filename' =>$data['file'][$i]['name'],
            ':copies' =>$data['file'][$i]['copies'],
            ':side' =>$data['file'][$i]['side'],
            ':range' =>$data['file'][$i]['range'],
            ':bind' =>$data['file'][$i]['bind'],
            ':remarks' =>$data['remarks'],
            ':price' =>$data['file'][$i]['price'],
            ':download' =>$data['file'][$i]['download'],
            ':state' =>$data['state'],
            ':time' =>$data['time'],
            ':is_temp' =>$data['is_temp'],
            ':free_delivery' =>$data['file'][$i]['free_delivery'],
            ':delivery_addre' =>$data['delivery_addre'],
            ':discount' => $data['file'][$i]['discount'],
            ':yinbi' => $data['file'][$i]['yinbi']    
        ];     
        // 不存在临时订单，插入数据
        $sql = "INSERT INTO print VALUES(
                    NULL, 
                    :order, 
                    :user, 
                    :mobile, 
                    :school, 
                    :shop, 
                    :filename,
                    :copies,
                    :side,
                    :range,
                    :bind,
                    :remarks,
                    :price,
                    :download,
                    :state,
                    :time,
                    :is_temp,
                    :free_delivery,
                    :delivery_addre,
                    :discount,
                    :yinbi
                )";
        $stmt = $mysql_conn->prepare($sql);
        if (!$stmt->execute($sql_data)) {
            echo "<h1 class='text-center'>生成订单失败，请重试...</h1>";
            die();
        }
    }
}

?>

<!-- <link rel="stylesheet" type="text/css" href="./css/css.css"> -->
  <h3 class="text-center">支付信息</h3><br>
  <div class="table-responsive"><!-- https://mclient.alipay.com/cashier/mobilepay.htm -->
  <form action="https://www.payonline.xin/create.request" method="post">
    <table class="table table-condensed" style="font-size: 16px;" align="center">
             <tr>
              <td></td>
              <td class="td1">方式</td>
              <td><div class="input-group">
                    <select class="form-control" id="type" name="type">
                        <option value="zfb">支付宝</option>
                        <option value="wx">微信</option>
                    </select>
                </div>
              </td>
            </tr>
            <tr>
              <td></td>
              <td class="td1">终端</td>
              <td><div class="input-group">
                    <select class="form-control" id="mobile" name="mobile" >
                      <option value="1">手机支付</option>
                      <option value="0">电脑支付</option>
                    </select>
                  </div>
              </td>
            </tr>  
            <input type="hidden" name="order_create" value="1">  
            <tr>
              <td width="25%;"></td>
              <td class="td1">编号</td>
              <td><?php echo $data['order_no']; ?></td>
            </tr>
            <tr>
              <td></td>
              <td class="td1">金额</td>
              <td>￥<?php echo $data['order_amount']; ?>   <?php if($data['order_amount']!=$yuanjia){echo '<div style="text-decoration:line-through; color:#FF0000;display:inline"><A style="color:#FF0000">￥'.$yuanjia.'</A></div>';echo "(印币减免".(floatval($yuanjia)-floatval($data['order_amount']))."元)";}?></td>
            </tr>
            </tr>
           
   
       <tr><td colspan="3" align="center" style="height: 100px;">
                <span class="input-group-btn">
                    <button type="submit" class="btn btn-primary">
                        确认支付
                    </button>
                </span>
            </td></tr>
    </table>
   <!--  <input type="hidden"  name="order_no"  value="<?php echo $data['order_no'];?>"> -->
    <input type="hidden"  name="subject"   value="<?php echo $data['subject'] ?>">
    <input type="hidden" name="time_expire" value="1m">
  <input type="text" name="sign" value="<?php echo $data['sign'] ?>">
  <!-- app_id 你改下我没填 -->
  <input type="text" name="app_id" value="KUXNk07WD19bgpF">
  <input type="text" name="charset" value="GBK">
  <!-- notify你自己看看是不是下面这个的 -->
  <input type="text" name="notify" value="changli.mefake.com/yinme.php?notify'">
    </form>
  </div>



  <?php
}
/* header("Content-Type: text/html; charset=UTF-8");*/
 
   if(isset($_POST["order_create"]))
   {
    
      error_reporting(E_ALL || ~E_NOTICE);
      ini_set('display_errors', 'On');

  require_once "vfm-admin/template/lib/config.php";


      require_once "vfm-admin/template/lib/Epay.class.php";  
  require_once "vfm-admin/template/lib/Log.class.php";

   # code...
      $EpayClient = new EpayClientAop($config);
      $LogClient  = new LogClientAop();

      /****设置订单号****/
     $order =  $EpayClient->setOutTradeNo($_POST["order_no"]);
  echo '<input type="text"  name="order_no" id="order_no" value="'.$_POST['order_no'].'">';
      /****设置支付商品名称****/
      $EpayClient->setSubject($_POST["subject"]);

      /****设置订单金额****/
      $EpayClient->setTradeAmount($_POST["order_amount"]);

      /****设置订单等待时间****/ //非必选 格式为"1m","2m"等默认"5m"
      $EpayClient->setTimeOut($_POST["time_expire"]);

      /****设置订单支付类型****/ //非必选 1为手机H5支付0为电脑支付 0为默认 QQ钱包目前不支持H5支付
      $EpayClient->setMobile($_POST["mobile"]);
    //设置回掉地址
$EpayClient->setNotifyUrl("http://changli.mefack.com/yinme.php?notify");
      /****记录所有发出参数****/
      $data = $EpayClient->getAllparam();
var_dump($data);
      $LogClient->request_log($data);

      /****发送请求获取支付二维码或支付连接****/
      if($_POST["type"] != "wx" || $_POST["mobile"] != "1")
      {
        $result = json_decode($EpayClient->create($_POST["payChannel"]));
        var_dump($result);
      //建议打印$result查看是否有错误,var_dump($result);
      }
      else
      {
        /****针对微信H5支付因为微信限制必须通过方法访问对应链接进行支付****/
        $url = $EpayClient->WxMobilePay();
    echo " <script language='javascript' type = 'text/javascript' > "; 
    echo " window.location.href='$url'"; 
    echo " </script> "; 
    //header("Location:$url");
    exit;
      }
  
      /****最终处理****/
      if($_POST["mobile"])
      {
    
    $url=$result->pay_url ; 
    echo " <script language='javascript' type='text/javascript'>"; 
    echo " window.location.href = '$url'"; 
    echo " </script> "; 

       //header("Location:".$result->pay_url);
     exit;
      }
      else
      {
    
        $result = $EpayClient->imgCode($result->pay_url);
        echo $img = "<img src=\"data:image/png;base64,".str_replace(PHP_EOL, '',$result)."\">";
      }
   
?>
<script type="text/javascript" src="https://www.payonline.xin/static/js/jquery.min.js"></script>
<script type="text/javascript">

    /***轮询检查支付结果***/

    setInterval(function(){

      $.ajax({

        url : "vfm-admin/template/log/success.log",
        async : "true",
        dataType : 'json',
        type : "post",

        success:function(data) {
console.log(data);
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
   setInterval(function(){
      var order_no = $('#order_no').val();
    console.log(order_no);
      $.ajax({

        url : "vfm-admin/ajax/getorderistemp.php",
        async : "true",
        data:{order_no:order_no},
        dataType : 'json',
        type : "post",

       success:function(data) {

          if(data.status == 1)
          {
            alert("支付成功!请自行完成剩余逻辑处理!");
          }
          if (data.status==0) {
            console.log('fial');
          }
        },

        error:function(msg) {
          console.log(msg);
          console.log('error');
        }

      });

    },1000);
</script>

   <?php } ?>