<?php

/**
 * @File:   paylist.php
 * @Author: sofia
 * @Email:  1506798421@qq.com
 * @Date:   2018-08-17 09:44:50
 * @Last Modified by:   sofia
 * @Last Modified time: 2018-08-17 12:46:10
 * @Comment: 批量下单支付页面
 */

if (!defined('PAY_INC') && file_exists('vfm-admin/include/ispay/Ispay.class.php'))
    require 'vfm-admin/include/ispay/Ispay.class.php';
if (!defined('CFG_INC') && file_exists('vfm-admin/users/config.php'))
    require 'vfm-admin/users/config.php';
if (!defined('SHOP_INC') && file_exists('vfm-admin/users/shops.php'))
    require 'vfm-admin/users/shops.php';
if (file_exists('../include/mysql/MySQL.class.php')) {
    require '../include/mysql/MySQL.class.php';
}

// 参数个数少于3
if (!$_POST || count($_POST) < 3) {
    echo "<script>location.href='yinme.php'</script>";
    die();
}
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

date_default_timezone_set("Asia/Shanghai");

$data['order'] = date("YmdHis") . rand(100000, 999999);
$data['time'] = date('Y-m-d H:i:s');
/*var_dump('<pre>');
var_dump($data);
die();*/
$Ispay = new ispayService($config['payId'], $config['payKey']);

//商户编号
$Request['payId'] = $config['payId'];
//随机生成订单号
$Request['orderNumber'] = $data['order'];
//支付方式
if (isset($_GET['payChannel'])) {
    $Request['payChannel'] = $_GET['payChannel'];
} else {
    $Request['payChannel'] = "alipay";
}
//订单标题
$Request['Subject'] = "打印订单" . $Request['orderNumber'];
//交易金额（单位分）

//是否首单用户
$con = MySQL::getConn();
$querydata = [ ':username' => $_SESSION['vfm_user_name']];
$sql = "SELECT isfirstorder,orders,pages FROM user WHERE userName = :username";
$stmt = $con->prepare($sql);
$stmt->execute($querydata);
$result = $stmt->fetchAll();
$isfirstorder = $result[0]['isfirstorder'];
$orders = $result[0]['orders'];
$pages = $result[0]['pages'];

$this_off_pages=0;//本次优惠的页数
$off_price = 0;//优惠金额
$firstorderpages  = 10;//首单优惠页数

$Request['Money'] = 0;
for($i = 0 ; $i<count($data['file']);$i++){

    if ($data['file'][$i]['pagetype'] =='onepage') {
        $page_price = $_SHOPS[$data['shoplist']]['onesideprice'];
    }
    if ($data['file'][$i]['pagetype'] =='dualpage') {
        $page_price = $_SHOPS[$data['shoplist']]['bothsideprice'];
    }  
    $bind_price = $_SHOPS[$data['shoplist']]['bind_price'];
    if ($data['file'][$i]['ext'] == 'ppt') {
        $over = ceil($data['file'][$i]['over']/$data['file'][$i]['ppttype']);
    }else
    {
        $over = $data['file'][$i]['over'];
    }
    $Money = $over * $page_price;
    $Money = $data['file'][$i]['binding'] ? 
        $Money + $bind_price : 
        $Money;  
    $Money = round($Money * $data['file'][$i]['copies'] * 100);
    $Request['Money'] += $Money;
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
    //本次优惠金额

    if (isset($_SESSION['isinvited']) && $_SESSION['isinvited'] == 1) {
             if ($orders<3 && $pages<30) {
            $page_off = 30 - $pages;//剩余可优惠的页数
            if ($page_off>0) {
                $copies = $data['file'][$i]['copies'];
                if ($data['file'][$i]['ext'] == 'ppt') {
                    $over =ceil($data['file'][$i]['over']/$data['file'][$i]['ppttype']);
                   
                }else{
                     $over = $data['file'][$i]['over'];
                }
               
                if (1- $_SHOPS[$data['shoplist']]['discount']) {
                    if ($copies*$over<=$page_off) {
                        //首单前十页免费
                        if ($isfirstorder==1 && $firstorderpages>0) {
                            if ($copies*$over<$firstorderpages) {
                                $off_price +=$copies*$over*$page_price;
                                $this_off_pages += $copies*$over;
                                $firstorderpages -= $copies*$over;
                                $page_off -= $copies*$over;
                            }else{
                                $off_price +=$firstorderpages*$page_price;
                                $off_price +=($copies*$over - $firstorderpages)*$page_price*(1- $_SHOPS[$data['shoplist']]['discount']);
                                $this_off_pages += $copies*$over;
                                $page_off -= $copies*$over;
                                $firstorderpages = 0;
                            }
                            
                        }else{
                            $off_price += $copies*$over*$page_price*(1- $_SHOPS[$data['shoplist']]['discount']);
                            $this_off_pages +=$copies*$over;
                            $page_off -=$copies*$over;
                        }
                    }else{
                        $off_price += $page_off*$page_price*(1- $_SHOPS[$data['shoplist']]['discount']);  
                        $this_off_pages += $page_off;
                        $page_off=0;
                    }
                    }
            }else{
                break;
            }
        }
    }
   
   
} 
$off_price = floor($off_price*100)/100;//取整
    if ($off_price == 0) {
        $this_off_pages = 0;
    }
/*var_dump($this_off_pages);
var_dump($off_price);*/
//设置本次打印优惠页数
$_SESSION['off_pagenum'] = $this_off_pages;
$_SESSION['getisfirstorder'] = $isfirstorder;
/*var_dump($_SESSION['off_pagenum']);*/
//是否存在配送费
$deliveryprice = $_SHOPS[$data['shoplist']]['deliveryprice'];
$delivery_price = $data['deliverylist'] ? $deliveryprice:0;

$deliveryaddrelist = $data['deliverylist'] ? $data['deliveryaddrelist'] : '';
if($Request['Money']>1000){//超过十元免配送费
    $data['freedelivery'] = $delivery_price;
} else{
    $data['freedelivery'] = 0;
}
/*var_dump($data['input_off_pricelist']);
die();*/


$Request['Money'] -= $off_price*100;
$Request['Money'] += $delivery_price * 100;
if ($Request['Money'] == 0) {
    $Request['Money'] = 1;//单位为分
    $off_price -= 0.01;
}

$yuanjia=$Request['Money']/100;
//减免

$data['yinbi'] = '0';

$conn=MySQL::getlink();
$sql = "select invitation from user where userName = '".$_SESSION['vfm_user_name']."'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $price = $Request['Money'] / 100;
        $number = $row["invitation"];
        if($number > 0&& $price > 0.6) {
            $price -= 1;
			if($price<=0)$price=0.01;//最低付款1毛
            $_SESSION['yinbi'] = $number-1;
            $data['yinbi'] = 1;
            $Request['Money'] = $price * 100;
        }
    }
}
/*$Request['Money'] = round($Request['Money']);
var_dump(round($Request['Money']));*/

/*var_dump($Request['Money']);
die();*/
for ($i=0; $i <count($data['file']) ; $i++) { 
    if ($i==0) {
        $data['file'][$i]['price'] = $Request['Money']/100;
        $data['file'][$i]['free_delivery'] = $data['freedelivery']; 
        $data['file'][$i]['discount'] = $off_price;
        $data['file'][$i]['yinbi'] = $data['yinbi'];
    }else{
        $data['file'][$i]['price'] = '批量';
        $data['file'][$i]['free_delivery'] = '批量';
        $data['file'][$i]['discount'] = '批量';
        $data['file'][$i]['yinbi'] = '批量';
    }
    /*if ($data['file'][$i]['pagetype'] == 'onepage') {
         $data['file'][$i]['side'] = '否';
    }
    if ($data['file'][$i]['pagetype'] == 'dualpage') {
         $data['file'][$i]['side'] = '是';
    }*/
     $data['file'][$i]['side'] = $data['file'][$i]['pagetype'] == 'onepage' ? '否':'是';
    if ($data['file'][$i]['ext'] == 'ppt') {
        $data['file'][$i]['ppttype'] = $data['file'][$i]['ppttype'];
    }else{
         $data['file'][$i]['ppttype'] = '';
    }
  /*  $data['file'][$i]['ppttype'] = $data['file'][$i]['ext'] == 'ppt' ?  $data['file'][$i]['ppttype']:'';
    */
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
//附加数据（没有可不填）
$Request['attachData'] = "";
$Request['Notify_url'] = SetUp::getConfig('script_url') . 'yinme.php?notify&order=' . $data['order'];
//客户端同步跳转通知地址
$Request['Return_url'] = SetUp::getConfig('script_url') . 'yinme.php?return';
//签名（加密算法详见开发文档）
$Request['Sign'] = $Ispay -> Sign($Request);

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
if (!empty($res_arr)) {
    // 存在临时表单，更新
    for ($i=0; $i <count($data['file']) ; $i++) { 
            
        if($i<count($res_arr)){
            $sql_data=[
            ':order' =>$data['order'], 
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
            ':yinbi' => $data['file'][$i]['yinbi'],
            ':ppttype' => $data['file'][$i]['ppttype']          
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
                    `yinbi` =:yinbi,
                    `ppttype` =:ppttype
                    WHERE `ID`=' . $res_arr[$i]['ID'];
            $stmt = $mysql_conn->prepare($sql);
           /* var_dump($stmt);*/
          /* echo "<pre>";
            var_dump($sql_data);
die();*/
            if (!$stmt->execute($sql_data)) {
                echo "<h1 class='text-center'>生成订单失败，请重试...</h1>";
                die();  
            }
        }
        else{
            $sql_data=[
            ':order' =>$data['order'],
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
            ':yinbi' => $data['file'][$i]['yinbi'],
            ':ppttype' => $data['file'][$i]['ppttype']      
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
                    :yinbi,
                    :ppttype
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
            ':order' =>$data['order'],
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
            ':yinbi' => $data['file'][$i]['yinbi'],
            ':ppttype' => $data['file'][$i]['ppttype']      
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
                    :yinbi,
                    :ppttype
                )";
        $stmt = $mysql_conn->prepare($sql);
        if (!$stmt->execute($sql_data)) {
            echo "<h1 class='text-center'>生成订单失败，请重试...</h1>";
            die();
        }
    }
}

?>
<style type="text/css">
    .td1{
        font-weight: bold;
    }
</style>
<h3 class="text-center">支付信息</h3><br>
<div class="table-responsive">
    <form action="https://pay.ispay.cn/core/api/request/pay/" method="post">
        <table class="table table-condensed" style="font-size: 16px;" align="center">
            <tr>
              <td width="25%;"></td>
              <td class="td1">订单编号</td>
              <td><?php echo $Request['orderNumber']; ?></td>
            </tr>
            <tr>
              <td></td>
              <td class="td1">金额</td>
              <td>￥<?php echo $Request['Money']/100; ?>   <?php if($Request['Money']/100!=$yuanjia){echo '<div style="text-decoration:line-through; color:#FF0000;display:inline"><A style="color:#FF0000">￥'.$yuanjia.'</A></div>';echo "(印币减免".(floatval($yuanjia)-floatval($Request['Money']/100))."元)";}?></td>
            </tr>
            </tr>
            <tr>
              <td></td>
              <td class="td1">支付方式</td>
              <td><div class="input-group">
                    <select class="form-control" id="payChannel" name="payChannel">
                        <option value="alipay" <?php
                        if (isset($_GET['payChannel'])) {
                            $payChannel = $_GET['payChannel'];
                        } else {
                            $payChannel = 'alipay';
                        }
                        if ($payChannel == 'alipay') {echo 'selected = "selected"';
                        }
                        ?>>支付宝</option>
                        
                    </select>
                </div>
              </td>
            </tr>
            <input type="text" name="payId" value="<?php echo $Request['payId']; ?>" hidden>
            <input type="text" name="Subject" value="<?php echo $Request['Subject']; ?>" hidden>
            <input type="text" name="Money" value="<?php echo $Request['Money']; ?>" hidden>
            <input type="text" name="orderNumber" value="<?php echo $Request['orderNumber']; ?>" hidden>
            <input type="text" name="Sign" value="<?php echo $Request['Sign']; ?>" hidden>
            <input type="text" name="Return_url" value="<?php echo $Request['Return_url']; ?>" hidden>
            <input type="text" name="Notify_url" value="<?php echo $Request['Notify_url']; ?>" hidden>
            <tr><td colspan="3" align="center" style="height: 100px;">
                <span class="input-group-btn">
                    <button type="submit" class="btn btn-primary">
                        确认支付
                    </button>
                </span>
            </td></tr>
        </table>
    </form>
</div>
<script>
$("#payChannel").change(function() {
    var data = <?php echo json_encode($_POST); ?>;
    if($("#payChannel").val() == 'alipay') {
        $.redirect("yinme.php?pay&payChannel=alipay", data, "POST");
    }
    if($("#payChannel").val() == 'wxpay') {
        $.redirect("yinme.php?pay&payChannel=wxpay", data, "POST");
    }
    if($("#payChannel").val() == 'qqpay') {
        $.redirect("yinme.php?pay&payChannel=qqpay", data, "POST");
    }
    if($("#payChannel").val() == 'bank_pc') {
        $.redirect("yinme.php?pay&payChannel=bank_pc", data, "POST");
    }
    if($("#payChannel").val() == 'wxgzhpay') {
        $.redirect("yinme.php?pay&payChannel=wxgzhpay", data, "POST");
    }
})</script>
