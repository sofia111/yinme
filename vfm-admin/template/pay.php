<?php

/**
 * @File:   pay.php
 * @Author: Alan_Albert
 * @Email:  1766447919@qq.com
 * @Date:   2018-07-19 09:44:50
 * @Last Modified by:   Alan_Albert
 * @Last Modified time: 2018-07-26 12:46:10
 * @Comment: 支付页面
 */

if (!defined('PAY_INC') && file_exists('vfm-admin/include/ispay/Ispay.class.php'))
    require 'vfm-admin/include/ispay/Ispay.class.php';
if (!defined('CFG_INC') && file_exists('vfm-admin/users/config.php'))
    require 'vfm-admin/users/config.php';
if (!defined('SHOP_INC') && file_exists('vfm-admin/users/shops.php'))
    require 'vfm-admin/users/shops.php';


// 参数个数少于8
if (!$_POST || count($_POST) < 8) {
    echo "<script>location.href='yinme.php'</script>";
    die();
}

$data = $_POST;
if ($data['shop'] == 0) {
	echo "<script>location.href='yinme.php'</script>";
    die();
}
$data['shop'] -= 1;
global $mysql_conn; // 数据库连接

// 获取用户工作路径
$work_path = basename(SetUp::getConfig('starting_dir')) . '/' . json_decode(GateKeeper::getUserInfo('dir'))[0] . '/' ;

if (!file_exists(realpath($work_path . $data['realfilename']))) {
    echo "<h2>文件错误</h2>";
    echo "<script>setTimeout(\"location.href='yinme.php'\", 2000);</script>";
    die();
}


date_default_timezone_set("Asia/Shanghai");

$data['order'] = date("YmdHis") . rand(100000, 999999);
$data['time'] = date('Y-m-d H:i:s');

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
$page_price = $data['pagetype'] == 'onepage' ?
    $_SHOPS[$data['shop']]['onesideprice'] :
    $_SHOPS[$data['shop']]['bothsideprice'];
$bind_price = $_SHOPS[$data['shop']]['bind_price'];

if ($data['fileext'] == 'ppt') {
    $Request['Money'] = ceil(($data['over'] - $data['start'] + 1)/$data['ppttype']) * $page_price;
    
}else{
    $Request['Money'] = ($data['over'] - $data['start'] + 1) * $page_price;
    $data['ppttype']='';
}
$Request['Money'] = $data['binding'] ? 
    $Request['Money'] + $bind_price : 
    $Request['Money'];

$Request['Money'] = round($Request['Money'] * $data['copies'] * 100);

//是否存在配送费
$deliveryprice = $_SHOPS[$data['shop']]['deliveryprice'];
$delivery_price = $data['delivery'] ? $deliveryprice:0;
if($Request['Money']>1000){//超过十元免配送费
    $data['freedelivery'] = $delivery_price;
} else{
    $data['freedelivery'] = 0;
}
/*var_dump($data['input_off_price']);
die();*/
 if (isset($_SESSION['isinvited']) && $_SESSION['isinvited'] == 1) {
$Request['Money'] -= $data['off_price']*100;}
$Request['Money'] += $delivery_price * 100;


$yuanjia=$Request['Money']/100;
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
//附加数据（没有可不填）
$Request['attachData'] = "";
$Request['Notify_url'] = SetUp::getConfig('script_url') . 'yinme.php?notify&order=' . $data['order'];
//客户端同步跳转通知地址
$Request['Return_url'] = SetUp::getConfig('script_url') . 'yinme.php?return';
//签名（加密算法详见开发文档）
$Request['Sign'] = $Ispay -> Sign($Request);

// 生成下载链接
$alt = SetUp::getConfig('salt');
$altone = SetUp::getConfig('session_name');
$thislink = $work_path . rawurlencode($data['realfilename']);
$dash = md5($alt.base64_encode($thislink).$altone.$alt);
if (SetUp::getConfig('enable_prettylinks') == true) {
    $downlink = 'download/'.base64_encode($thislink).'/h/'.$dash;
} else {
    $downlink = 'vfm-admin/vfm-downloader.php?q='.base64_encode($thislink).'&h='.$dash;
}
$data['download'] = $downlink;
// 添加数据
// 
$data['price'] = $Request['Money']/100;
$data['side'] = $data['pagetype'] == 'onepage' ?
    '否' : '是';
$data['range'] = $data['start'] . '-' . $data['over'];
$data['bind'] = $data['binding'] ? '是' : '否';
$data['state'] = '已下单';
$data['is_temp'] = 1;
$data['school'] = $_SHOPS[$data['shop']]['school'];
$data['shop'] = $_SHOPS[$data['shop']]['name'];
$data['user'] = $_SESSION['vfm_user_name'];
$data['discount'] = $data['off_price'];

$data['mobile'] = isset($data['deliveryphone']) ? $data['deliveryphone'] : GateKeeper::getUserInfo('email');
$data['delivery_addre'] = $data['deliveryaddre'] ? $data['deliveryaddre'] : '';//保存配送地址
$data['remarks'] = isset($data['comment']) ? $data['comment'] : '';
//设置本次打印优惠页数
$_SESSION['off_pagenum'] = $data['off_pagenum'];
/*var_dump($_SESSION['off_pagenum']);*/

if ($data['delivery_addre'] !='') {
    $que_data = [
        ':delivery_addre' => $data['delivery_addre'],
        ':user' => $_SESSION['vfm_user_name']
    ];
    $sql = "UPDATE user SET `addre` = :delivery_addre WHERE userName =:user";
    $stmt = $mysql_conn->prepare($sql);
    $stmt->execute($que_data);
}
// 删除多余键值
unset($data['start'], $data['over'],$data['delivery'], $data['binding'], $data['pagetype'], $data['realfilename'], $data['comment'],$data['off_price'],$data['deliveryaddre'],$data['off_pagenum'],$data['deliveryphone']);

$sql_data = [];
foreach ($data as $key => $value) {
    $sql_data[':' . $key] = $value;
}
/*$sql_data[':free_delivery'] = '0';
$sql_data[':delivery_addre'] = '';
$sql_data[':discount'] = '0';*/
unset($data);  

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

if (!empty($res_arr)) {
    // 存在临时表单，更新
    unset($sql_data[':user'], $sql_data[':mobile'], $sql_data[':is_temp']); // 删除多余键值
/*    echo "<pre>";
var_dump($sql_data);
die();*/
    $sql = 'UPDATE print SET 
                `order`=:order,
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
                `time`=:time ,
                `free_delivery` = :freedelivery,
                `delivery_addre` = :delivery_addre,
                `discount` = :discount,
                `yinbi` = :yinbi,
                `ppttype` = :ppttype
                WHERE `ID`=' . $res_arr[0]['ID'];
    $stmt = $mysql_conn->prepare($sql);
    // var_dump($sql_data);
    // die();
    if (!$stmt->execute($sql_data)) {
        echo "<h1 class='text-center'>生成订单失败，请重试...</h1>";
        die();  
    }
} else {
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
				:freedelivery,
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
