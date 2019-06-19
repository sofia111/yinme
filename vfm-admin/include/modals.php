<?php
/**
 * VFM - veno file manager: include/modals.php
 * popup windows
 *
 * PHP version >= 5.3
 *
 * @category  PHP
 * @package   VenoFileManager
 * @author    Nicola Franchini <support@veno.it>
 * @copyright 2013 Nicola Franchini
 * @license   Exclusively sold on CodeCanyon: http://bit.ly/veno-file-manager
 * @link      http://filemanager.veno.it/
 */
if (file_exists('mysql/MySQL.class.php')) {
    require 'mysql/MySQL.class.php';
}
/**
* Group Actions
*/
if ($gateKeeper->isAccessAllowed()) {

    /**
     * Get shop
     */
    $shops = false;
    if (file_exists('vfm-admin/users/shops.php')) {
        include 'vfm-admin/users/shops.php';
        $shops = $_SHOPS;
    }

    $time = time();
    $hash = md5($_CONFIG['salt'].$time);
    $doit = ($time * 12);
    $pulito = rtrim($setUp->getConfig("script_url"), "/");

    $insert4 = $encodeExplorer->getString('insert_4_chars');

    if ($setUp->getConfig("show_pagination_num") == true 
        || $setUp->getConfig("show_pagination") == true 
        || $setUp->getConfig("show_search") == true
    ) {
        $activepagination = true;
    } else {
        $activepagination = 0;
    }
    $selectfiles = $encodeExplorer->getString("select_files");
    $toomanyfiles = $encodeExplorer->getString('too_many_files');

    $maxzipfiles = $setUp->getConfig('max_zip_files');
    $prettylinks = ($setUp->getConfig('enable_prettylinks') ? true : 0);
    ?>
    <script type="text/javascript">
        createShareLink(
            <?php echo json_encode($insert4); ?>, 
            <?php echo json_encode($time); ?>, 
            <?php echo json_encode($hash); ?>, 
            <?php echo json_encode($pulito); ?>, 
            <?php echo json_encode($activepagination); ?>,
            <?php echo json_encode($maxzipfiles); ?>,
            <?php echo json_encode($selectfiles); ?>, 
            <?php echo json_encode($toomanyfiles); ?>,
            <?php echo json_encode($prettylinks); ?>
        );

        
    </script>
    <style type="text/css">
        .require{
            padding: 20px 0;
            /*margin-bottom: 20px;*/
            /*background: #eeeeee;*/
            /*border-radius: 10px;*/
        }
        .loading {
            width: 300px;
            height: 56px;
            margin-top: 20%;
            line-height: 56px;
            color: #fff;
            padding-left: 60px;
            font-size: 15px;
            background: #000 url(vfm-admin/images/loading.gif) no-repeat 20px 50%;
            background-size: 30px;
            opacity: 0.7;
            z-index: 9999;
            -moz-border-radius: 20px;
            -webkit-border-radius: 20px;
            border-radius: 20px;
            filter: progid:DXImageTransform.Microsoft.Alpha(opacity=70);
        }
    </style>
    <div class="modal fade downloadmulti" id="downloadmulti" tabindex="-1">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                    </button>
                    <p class="modal-title">
                        <?php echo " " .$encodeExplorer->getString('selected_files'); ?>: 
                        <span class="numfiles badge badge-danger"></span>
                    </p>
                </div>
                <div class="text-center modal-body">
                    <a class="btn btn-primary btn-lg centertext bigd sendlink" href="#">
                        <i class="fa fa-cloud-download fa-5x"></i>
                    </a>
                </div>
            </div>
         </div>
    </div>
    <?php
    /**
    * Send files window
    */
    if ($setUp->getConfig('sendfiles_enable')) { ?>
            <div class="modal fade sendfiles" id="sendfilesmodal" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">

                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">
                                <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                            </button>
                            <h5 class="modal-title">
                                <?php echo " " .$encodeExplorer->getString("selected_files"); ?>: 
                                <span class="numfiles badge badge-danger"></span>
                            </h5>
                        </div>

                        <div class="modal-body">
                            <div class="form-group createlink-wrap">
                                <button id="createlink" class="btn btn-primary btn-block"><i class="fa fa-check"></i> 
                                    <?php echo $encodeExplorer->getString("generate_link"); ?></button>
                            </div>
        <?php
        if ($setUp->getConfig('secure_sharing')) { ?>
                            <div class="checkbox">
                                <label>
                                    <input id="use_pass" name="use_pass" type="checkbox"><i class="fa fa-key"></i> 
                                    <?php echo $encodeExplorer->getString("password_protection"); ?>
                                </label>
                            </div>
        <?php
        } ?>
                        <div class="form-group shalink">
                            <div class="input-group">
                                <span class="input-group-btn">
                                    <a class="btn btn-primary sharebutt" href="#" target="_blank">
                                        <i class="fa fa-link fa-fw"></i>
                                    </a>
                                </span>
                                <input id="copylink" class="sharelink form-control" type="text" onclick="this.select()" readonly>
        <?php
        if ($setUp->getConfig('clipboard')) { ?>
                                <script src="vfm-admin/js/clipboard.min.js"></script>
                                <span class="input-group-btn">
                                    <button id="clipme" class="clipme btn btn-primary" 
                                    data-toggle="popover" data-placement="bottom" 
                                    data-content="<?php echo $encodeExplorer->getString("copied"); ?>" 
                                    data-clipboard-target="#copylink">
                                        <i class="fa fa-clipboard fa-fw"></i>
                                    </button>
                                </span>
        <?php
        } ?>
                            </div>
                        </div>
        <?php
        if ($setUp->getConfig('secure_sharing')) { ?>
                            <div class="form-group seclink">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-lock fa-fw"></i></span>
                                    <input class="form-control passlink setpass" type="text" onclick="this.select()" 
                                    placeholder="<?php echo $encodeExplorer->getString("random_password"); ?>">
                                </div>
                            </div>
        <?php
        } 
        $mailsystem = $setUp->getConfig('email_from');
        if (strlen($mailsystem) > 0) { ?>
                            <div class="openmail">
                                <span class="fa-stack fa-lg">
                                  <i class="fa fa-circle-thin fa-stack-2x"></i>
                                  <i class="fa fa-envelope fa-stack-1x"></i>
                                </span>
                            </div>
                            <form role="form" id="sendfiles">
                                <div class="mailresponse"></div>
                                
                                <input name="thislang" type="hidden" 
                                value="<?php echo $encodeExplorer->lang; ?>">

                                <label for="mitt">
                                    <?php echo $encodeExplorer->getString("from"); ?>:
                                </label>

                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-user fa-fw"></i></span>
                                    <input name="mitt" type="email" class="form-control" id="mitt" 
                                    value="<?php echo $gateKeeper->getUserInfo('email'); ?>" 
                                     placeholder="<?php echo $encodeExplorer->getString("your_email"); ?>" required >
                                </div>
                            
                                <div class="wrap-dest">
                                    <div class="form-group">
                                        <label for="dest">
                                            <?php echo $encodeExplorer->getString("send_to"); ?>:
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-envelope fa-fw"></i></span>
                                            <input name="dest" type="email" data-role="multiemail" class="form-control addest" id="dest" 
                                            placeholder="" required >
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group clear">
                                    <div class="btn btn-primary btn-xs shownext">
                                        <i class="fa fa-plus"></i> <i class="fa fa-user"></i>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <textarea class="form-control" name="message" id="mess" rows="3" 
                                    placeholder="<?php echo $encodeExplorer->getString("message"); ?>"></textarea>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-block">
                                        <i class="fa fa-envelope"></i>
                                    </button>
                                </div>

                                <input name="passlink" class="form-control passlink" type="hidden">
                                <input name="attach" class="attach" type="hidden">
                                <input name="sharelink" class="sharelink" type="hidden">
                            </form>
                            
                            <div class="mailpreload">
                                <div class="cta">
                                    <i class="fa fa-refresh fa-spin"></i>
                                </div>
                            </div>
        <?php
        } ?>
                        </div> <!-- modal-body -->
                    </div>
                </div>
            </div>
        <?php
    } // end sendfiles enabled

    /**
    * Rename files and folders
    */
    if ($gateKeeper->isAllowed('rename_enable')) { ?>

        <div class="modal fade changename" id="modalchangename" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">
                            <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                        </button>
                        <h4 class="modal-title"><i class="fa fa-edit"></i> <?php echo $encodeExplorer->getString("rename"); ?></h4>
                    </div>

                    <div class="modal-body">
                        <form role="form" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING']);?>">
                            <input readonly name="thisdir" type="hidden" 
                            class="form-control" id="dir">
                            <input readonly name="thisext" type="hidden"
                            class="form-control" id="ext">
                            <input readonly name="oldname" type="hidden" 
                            class="form-control" id="oldname">

                            <div class="input-group">
                                <label for="newname" class="sr-only">
                                    <?php echo $encodeExplorer->getString("rename"); ?>
                                </label>
                                <input name="newname" type="text" 
                                class="form-control" id="newname">
                                <span class="input-group-btn">
                                    <button type="submit" class="btn btn-primary">
                                        <?php echo $encodeExplorer->getString("rename"); ?>
                                    </button>
                                </span>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php
    } // end rename_enable

    /**
     * 下单
     */
    if (1) { ?>
         <div class="modal fade createorderlist" id="modalcreateorderlist" tabindex="-1"  >
            <div id="fileloadinglist"  class="loading center-block">文件解析中...</div>
            <div class="modal-dialog" id="orderDivlist">
                <div class="modal-content">

                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">
                            <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                        </button>
                        <h4 class="modal-title"><i class="fa fa-money"></i> <?php echo $encodeExplorer->getString("createorder"); ?></h4>
                    </div>
                    
                    <div class="modal-body">
                        <form role="form" method="post" action="?paylist" id="orderlistForm">
                            <div class="input-group">
                                <span class="input-group-addon">打印店</span>
                                <select class="form-control" id="shoplist" name="shoplist" >
                                    <option value="0">---请选择---</option>
                                    <?php
                                        foreach ($shops as $key => $value) {
                                            $tmp = $key + 1;
                                            echo "<option id={$tmp} value={$tmp} >{$value['name']}</option>";
                                        }
                                    ?><!-- （详细地址：{$value['address']}） -->
                                    <!-- <option style="background-color: #eee;" value="">西门打印-----忙碌中----距离1550m</option> -->
                                   <!--  <option id="tushu">长理图书馆打印------空闲中----(距离最近商家)约66米</option> -->
                                  <!--   <option id="hongyi">弘一电信打印室-----空闲中----距离639m</option>
                                    <option id="ximen">西门图文打印-----空闲中----距离1.2k</option> -->
                                </select>    
                            </div><br>
                            <img id="gongtotu" style="width: 150px; float: right; display: none;">
                            <!-- <img id="gongtohong" src="vfm-admin/images/gongtohong.png" style="width: 150px; float: right; display: none;">
                            <img id="gongtoxi" src="vfm-admin/images/gongtoxi.png" style="width: 150px; float: right; display: none;"> -->
                            <input type="hidden" value='<?php echo json_encode($shops); ?>' readonly id="shopslist">
                            <input type="hidden" id="usernamelist" value="<?php echo $_SESSION['vfm_user_name']; ?>" readonly>
                            <script type="text/javascript">
                                 
                                    
                                </script>
                            <div id="filelist">
                                
                            </div>

                            <!--  <div class="input-group">
                                <span class="input-group-addon">备注</span> -->
                                <input type="hidden" name="commentlist" class="form-control" placeholder="填写备注信息" id="commentlist">
                          <!--   </div><br> -->
                            <div id="isDeliverylist">
                            <div class="input-group">
                                
                                <span class="input-group-addon">配送</span>
                                <select class="form-control" name="deliverylist" id="deliverylist">
                                 <!--  <option value="0">否</option>
                                  <option value="1" id="delivery_pricelist">是（+ 0 元）
                                  </option> -->
                                  <option value="0">否</option>
                                   <option value="1">加急！半小时后送到  配送费：￥2.0</option>
                                   <option value="2">普通！中午十二点送到  配送费：￥1.0</option>
                                   <option value="3">普通！下午六点送到  配送费：￥1.0</option>
                                </select>
                            </div><br>
                            <div id="displaylist" style="display: none;">
                                <div class="input-group">
                                    <?php 
                                    $mysql_conn = MySQL::getConn();
                                    $data_query = [':user' => $_SESSION['vfm_user_name']];
                                    $sql = 'SELECT `addre`,`phoneNum` FROM user WHERE `userName`=:user';
                                    $stmt = $mysql_conn->prepare($sql);
                                    $stmt->execute($data_query);
                                    $res_arr = $stmt->fetchAll(); 
                                     ?>
                                    <span class="input-group-addon">配送电话</span>
                                    <input type="text" name="deliveryphonelist" class="form-control" placeholder="填写正确手机号" id="deliveryphonelist" value="<?php echo $res_arr[0]['phoneNum'] ?> ">
                                </div>
                                <div class="input-group">
                                    <span class="input-group-addon">配送地址</span>
                                    <select class="form-control" name="deliveryaddrelist" id="deliveryaddrelist">
                                        <option value="0">---请选择---</option>
                                  <option>行健轩1</option>
                                  <option>行健轩2</option>
                                  <option>行健轩3</option>
                                  <option>行健轩4</option>
                                  <option>行健轩5</option>
                                  <option>行健轩6</option>
                                  <option>至诚轩1</option>
                                  <option>至诚轩2</option>
                                  <option>至诚轩3</option>
                                  <option>至诚轩4</option>
                                  <option>弘毅轩1</option>
                                  <option>弘毅轩2</option>
                                  <option>弘毅轩3</option>
                                  <option>弘毅轩4</option>
                                  <option>敏行轩</option>
                                </select>
                                    <!-- <input type="text" name="deliveryaddre" class="form-control" placeholder="填写配送地址" id="deliveryaddre" value="<?php echo $res_arr[0]['addre'] ?>"> -->
                                </div>
                            </div><br>
                            </div>
                            <div id="failedfile"></div>
                            <input type="hidden" id="page">
                            <div class="input-group" id="show_pricelist">
                                <span>小计</span>&nbsp;<label style="font-size: 16px;" id="all_pricelist">0</label><span>元</span>
                            </div>
                            <div style="text-decoration:line-through; color:#FF0000;" class="input-group" id="show_original_pricelist">
                                <span>原价</span>&nbsp;<span style="font-size: 16px;" id="original_pricelist">0</span><span>元</span>
                            </div>
                            <div class="input-group" style="color: red;" id="show_off_pricelist">
                                <span>优惠</span>&nbsp;<label style="font-size: 16px;" id="off_pricelist">0</label><span>元</span><input type="hidden" name="off_pricelist" id="input_off_pricelist">
                            </div> 
                            <div   style="display:none" class="input-group"><label>订单数</label>
                           <span id="getorderslist"></span><label>优惠页数</label><span id="getpageslist"></span><input type="text" name="off_pagenumlist" id="off_pagenumlist"><input type="text" name="getisfirstorder" id="getisfirstorder"></div><div class="input-group" style="color: red;" id="warnninglist">
                                <span id="warnning_textlist"></span>
                            </div><br>

                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-primary">
                                    提交订单
                                </button>
                            </span>
                

                            
                        </form>
                    </div>
                </div>
            </div>
        </div>
<!-- 
我要接单模块
 -->

 <div class="modal fade acceptlist" id="modalacceptlist" tabindex="-1">
     <div class="modal-dialog">
         <div class="modal-content">
             <div class="modal-header">
                 <button type="button" class="close" data-dismiss="modal">
                            <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                        </button>
                        <h4 class="modal-title"><i class="fa fa-first-order"></i>&nbsp&nbsp跑跑腿</h4>
             </div>
             <div class="modal-body">
                <table class=" table table-hover table-condense" >
                    <thead>
                        <tr><th><input type="checkbox" value=""></th>
                            <th>商家</th>
                            <th>订单个数</th>
                            <th>目的地</th>
                            <th>配送时间</th>
                            <th>获印币(/个)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><input type="checkbox" ></td>
                            <td>弘一电信文印室</td>
                            <td>5</td>
                            <td>行健轩一</td>
                            <td>12:00am前</td>
                             <td>2.0</td>
                        </tr>
                        <tr>
                            <td><input type="checkbox" value=""></td>
                            <td>弘一电信文印室</td>
                            <td>4</td>
                            <td>至诚轩二</td>
                            <td>6:00pm前</td>
                             <td>0.8</td>
                        </tr>
                        <tr>
                            <td><input type="checkbox" value=""></td>
                            <td>西门图文打印</td>
                            <td>6</td>
                            <td>行健轩四</td>
                            <td>12:00pm前</td>
                             <td>3.0</td>
                        </tr>
                        <tr>
                            <td><input type="checkbox" value=""></td>
                            <td>长理图书馆打印</td>
                            <td>6</td>
                            <td>敏行轩</td>
                            <td>12:00pm前</td>
                             <td>1.8</td>
                        </tr>
                    </tbody>
                </table>
                 <span class="input-group-btn">
                                <button type="submit" class="btn btn-primary" id="acceptlistsuccess">
                                    我要接单
                                </button>
                            </span>
             </div>
         </div>
     </div>

 </div>
        <div class="modal fade createorder" id="modalcreateorder" tabindex="-1"  >
            <div id="fileloading" class="loading center-block">文件解析中...</div>
            <div class="modal-dialog" id="orderDiv">
                <div class="modal-content">

                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">
                            <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                        </button>
                        <h4 class="modal-title"><i class="fa fa-money"></i> <?php echo $encodeExplorer->getString("createorder"); ?></h4>
                    </div>
                    
                    <div class="modal-body">
                        <form role="form" method="post" action="/pay?index" id="orderForm">
                            

                            <div class="input-group">
                                <span class="input-group-addon">打印店</span>
                                <select class="form-control" id="shop" name="shop">
									<option value="0">---请选择---</option>
                                    <?php
                                        foreach ($shops as $key => $value) {
											$tmp = $key + 1;
                                            echo "<option value={$tmp}>{$value['name']}（详细地址：{$value['address']}）</option>";
                                        }
                                    ?>
                                </select>
                            </div><br>

                            <div class="input-group">
                                <span class="input-group-addon">文件名</span>
                                <input type="text" name="filename" class="form-control" placeholder="文件名" id="filename" readonly required>
                                
                            </div>
                            <span style="color:#aaaaaa;" id="filetype_tips"></span>
                            <br>

                            <div class="require">
                            <div class="input-group">
                                <span class="input-group-addon">份数</span>
                                <input type="number" name="copies" class="form-control" min="1" placeholder="份数" id="copies" value="1" required>
                                <span class="input-group-addon">胶装</span>
                                <select class="form-control" name="binding" id="binding">
                                  <option value="0">否</option>
                                  <option value="1" id="bind_price">是（+ 0 元）
                                  </option>
                                </select>
                            </div><br>
                            
                            <div class="input-group">
                                <span class="input-group-addon">页数范围</span>
                                <input type="number" name="start" class="form-control" placeholder="起始页" id="start"required readonly>
                                <span class="input-group-addon">~</span>
                                <input type="number" name="over" class="form-control" placeholder="终止页" id="over" required readonly>
                            </div>


                            <div class="radio"> 
                                <label class="radio-inline"><input type="radio" name="pagetype" value="onepage" checked id="onepage">
                                    单面（￥
                                    <span id="onesideprice">0</span>
                                    /页）
                                </label>
                                <label class="radio-inline"><input type="radio" name="pagetype" value="dualpage" id="dualpage">
                                    双面（￥
                                    <span id="bothsideprice">0</span>
                                    /页）
                                </label>
                            </div>
                            <div id="insertOrder"></div>
                            <input type="hidden" name="realfilename" id="realfilename" readonly>
                            <input type="hidden" value='<?php echo json_encode($shops); ?>' readonly id="shops">
                            <input type="hidden" id="username" value="<?php echo $_SESSION['vfm_user_name']; ?>" readonly>
                            </div>


                             <!--  <div class="input-group">
                                <span class="input-group-addon">备注</span> -->
                                <input type="hidden" name="comment" class="form-control" placeholder="备注信息" id="comment">
                          <!--   </div><br>
 -->						<div id="isDelivery">
                            <div class="input-group">
                                
                                <span class="input-group-addon">配送</span>
                                <select class="form-control" name="delivery" id="delivery">
                                  <option value="0">否</option>
                                  <option value="1" id="delivery_price">是（+ 0 元）
                                  </option>
                                </select>
                            </div><br>
                            <div id="display" style="display: none;">
                                <div class="input-group">
                                    <?php 
                                    $mysql_conn = MySQL::getConn();
                                    $data_query = [':user' => $_SESSION['vfm_user_name']];
                                    $sql = 'SELECT `addre`,`phoneNum` FROM user WHERE `userName`=:user';
                                    $stmt = $mysql_conn->prepare($sql);
                                    $stmt->execute($data_query);
                                    $res_arr = $stmt->fetchAll(); 
                                     ?>
                                    <span class="input-group-addon">配送电话</span>
                                    <input type="text" name="deliveryphone" class="form-control" placeholder="填写正确手机号" id="deliveryphone" value="<?php echo $res_arr[0]['phoneNum'] ?> ">
                                </div>
                                <div class="input-group">
                                    <span class="input-group-addon">配送地址</span>
                                    <select class="form-control" name="deliveryaddre" id="deliveryaddre">
                                        <option value="0">---请选择---</option>
                                  <option>行健轩1</option>
                                  <option>行健轩2</option>
                                  <option>行健轩3</option>
                                  <option>行健轩4</option>
                                  <option>行健轩5</option>
                                  <option>行健轩6</option>
                                  <option>至诚轩1</option>
                                  <option>至诚轩2</option>
                                  <option>至诚轩3</option>
                                  <option>至诚轩4</option>
                                  <option>弘毅轩1</option>
                                  <option>弘毅轩2</option>
                                  <option>弘毅轩3</option>
                                  <option>弘毅轩4</option>
                                  <option>敏行轩</option>
                                </select>
                                    <!-- <input type="text" name="deliveryaddre" class="form-control" placeholder="填写配送地址" id="deliveryaddre" value="<?php echo $res_arr[0]['addre'] ?>"> -->
                                </div>
                            </div><br>
                            </div>
                            <div class="input-group" id="show_price">
                                <span>小计</span>&nbsp;<label style="font-size: 16px;" id="all_price">0</label><span>元</span>
                            </div>
                             <div class="input-group" style="text-decoration:line-through; color:#FF0000;" id="show_original_price">
                                <span>原价</span>&nbsp;<span style="font-size: 16px;" id="original_price">0</span><span>元</span>
                            </div>
                            <div class="input-group" style="color: red;" id="show_off_price">
                                <span>优惠</span>&nbsp;<label style="font-size: 16px;" id="off_price">0</label><span>元</span><input type="hidden" name="off_price" id="input_off_price">
                            </div>
                            <div  style="display:none;" class="input-group"><label>订单数</label>
                           <span id="getorders"></span><label>优惠页数</label><span id="getpages"></span><input type="text" name="off_pagenum" id="off_pagenum"></div>
                            <div class="input-group" style="color: red;" id="warnning">
                                <span id="warnning_text"></span>
                            </div><br>

                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-primary">
                                    提交订单
                                </button>
                            </span>

                            
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade share" id="modalshare" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">
                            <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                        </button>
                        <span>确认分享文件 <i style="color:#666;font-size:13px;">
                         （*提示: 分享后该文件对其他人可见*）</i></span><br>
                        
                    </div>

                    <div class="modal-body">
                        <form role="form" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING']);?>" id="isshare">
                            <input type="hidden" name="getfile" id="getfile">
                            <input type="hidden" name="getuser" id="getuser">
							
							<label for="selectschool">&nbsp;学校选择</label>
                            <div class="input-group">
                                <span class="input-group-addon"> 
                                    <i class="fa fa-user fa-fw"></i></span>
                                <select class="form-control" id="shareschool" name="shareschool">
                                    
                                    <?php 
                                         if ($gateKeeper->getUserInfo('schoolName')=='0') {
                                                    echo '<option value="0">请选择分享的学校</option>';
                                                    
                                                }else{
                                                
                                                 echo '<option value="'.$gateKeeper->getUserInfo('schoolName').'">'.$gateKeeper->getUserInfo('schoolName').'</option>';
                                                 }
                                       $link= MySQL::getlink();
                                        $sql=mysqli_query($link,"select distinct(schoolName) from school order by schoolID asc");
                                        $result = mysqli_num_rows($sql);                                      
                                        if ($result) {
                                            while ($info=mysqli_fetch_array($sql)) {
                                                echo '<option  name="selectschool" value="'.$info['schoolName'].'">'.$info['schoolName'].'</option>';
                                            }
                                        } else {
                                            die();
                                        }
                                    ?>     
                                </select>
                            </div>
                            <label for="user_pass">&nbsp;专业选择</label>
                            <div class="input-group">
                                <span class="input-group-addon"> 
                                    <i class="fa fa-user fa-fw"></i></span>
                                <select class="form-control" id="sharemajor" name="sharemajor">
                                    
                                    <?php
                                          if ($gateKeeper->getUserInfo('majorName')=='0') {
                                            echo '<option value="0">请选择分享的专业</option>';
                                        }
                                        else{
                                        echo '<option value="'.$gateKeeper->getUserInfo('majorName').'">'.$gateKeeper->getUserInfo('majorName').'</option>';
                                        }
                                        $sql=mysqli_query($link,"select distinct(majorName) from school");
                                        $result = mysqli_num_rows($sql);                                      
                                        if ($result) {
                                            while ($info=mysqli_fetch_array($sql)) {
                                                echo '<option  name="sharemajor" value="'.$info['majorName'].'">'.$info['majorName'].'</option>';
                                            }
                                        }         
                                    ?>     
                                </select>
                            </div>
                            <br>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                                <button type="submit"  class="btn btn-primary" >
                                    分享
                                </button>                      
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <?php
    }



    /**
    * Move files
    */
    if ($gateKeeper->isAllowed('move_enable') || $gateKeeper->isAllowed('copy_enable')) { 
        ?>
        <script type="text/javascript">
        setupMove(
            <?php echo json_encode($activepagination); ?>,
            <?php echo json_encode($selectfiles); ?>,
            <?php echo json_encode($time); ?>, 
            <?php echo json_encode($hash); ?>, 
            <?php echo json_encode($doit); ?>
        );
        </script>

        <div class="modal fade movefiles" id="movemulti" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">
                            <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                        </button>
                        <h4 class="modal-title">
                            <i class="fa fa-list"></i> 
                            <?php echo $encodeExplorer->getString("select_destination_folder"); ?>
                        </h4>
                    </div>
                    <div class="modal-body">
                        <div class="hiddenalert"></div>
                        <?php
                        if (isset($_GET['dir']) && strlen($_GET['dir']) > 0) {
                            $currentdir = "./".trim($_GET['dir'], "/")."/";
                        } else {
                            $currentdir = $setUp->getConfig('starting_dir');
                        }
                        // check if any folder is assigned to the current user
                        if ($gateKeeper->getUserInfo('dir') !== null) {
                            $userpatharray = array();
                            $userpatharray = json_decode(GateKeeper::getUserInfo('dir'), true);

                            // show all available directories trees
                            foreach ($userpatharray as $userdir) {
                                $path = $setUp->getConfig('starting_dir').$userdir.'/'; ?>
                            <ul class="foldertree">
                                <li class="folderoot">
                                <?php
                                if ($path === $currentdir) { ?>
                                    <i class="fa fa-folder-open"></i> <?php echo $userdir ?>
                                <?php
                                } else { ?>
                                    <a href="#" data-dest="<?php echo urlencode($path); ?>" class="movelink">
                                        <i class="fa fa-folder"></i> <?php echo $userdir; ?>
                                    </a>
                                <?php
                                }
                                Actions::walkDir($path, $currentdir);
                                ?>
                                </li>
                            </ul>
                            <?php
                            }
                        } else {
                            // no directory assigned, access to all folders
                            $movedir = $setUp->getConfig('starting_dir');
                            $cleandir = substr(
                                $setUp->getConfig('starting_dir'), 2
                            );
                            $cleandir = substr_replace($cleandir, '', -1); ?>
            
                            <ul class="foldertree">
                                <li class="folderoot">
                            <?php
                            if ($movedir === $currentdir) { ?>
                                    <i class="fa fa-folder-open"></i> <?php echo $cleandir; ?>
                            <?php
                            } else { ?>
                                    <a href="#" data-dest="<?php echo urlencode($movedir); ?>" class="movelink">
                                        <i class="fa fa-folder"></i> <?php echo $cleandir; ?>
                                    </a>
                            <?php
                            }
                            Actions::walkDir($movedir, $currentdir); ?>
                                </li>
                            </ul>
                        <?php
                        } ?>
                        <form id="moveform">
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php
    } // end move_enable

    /**
    * Delete multiple files
    */
    if ($gateKeeper->isAllowed('delete_enable')) { 
        $confirmthisdel = $encodeExplorer->getString('delete_this_confirm');
        $confirmdel = $encodeExplorer->getString('delete_confirm'); ?>
        <script type="text/javascript">
            setupDelete(
                <?php echo json_encode($confirmthisdel); ?>, 
                <?php echo json_encode($confirmdel); ?>, 
                <?php echo json_encode($activepagination); ?>, 
                <?php echo json_encode($time); ?>, 
                <?php echo json_encode($hash); ?>, 
                <?php echo json_encode($doit); ?>, 
                <?php echo json_encode($selectfiles); ?>
            );
        </script>
        <div class="modal fade deletemulti" id="deletemulti" tabindex="-1">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">
                            <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                        </button>
                        <p class="modal-title"> 
                            <?php echo $encodeExplorer->getString("selected_files"); ?>: 
                            <span class="numfiles badge badge-danger"></span>
                        </p>
                    </div>
                    <div class="text-center modal-body">
                        <form id="delform">
                            <a class="btn btn-primary btn-lg centertext bigd removelink" href="#">
                            <i class="fa fa-trash-o fa-5x"></i></a>
                            <p class="delresp"></p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php  
    } // end delete enabled
} // end isAccessAllowed

/**
* Show Thumbnails
*/
if (($setUp->getConfig("thumbnails") == true && $hasimage == true) 
    || ($setUp->getConfig("playvideo") == true && $hasvideo == true)
) { ?>
<script type="text/javascript">
    var script_url = <?php echo json_encode($setUp->getConfig('script_url')); ?>;
    <?php 
    if ($setUp->getConfig('enable_prettylinks') == true) { ?>
    var baselink = "download/";
    <?php 
    } else { ?>
    var baselink = "vfm-admin/vfm-downloader.php?q=";
    <?php 
    } ?>
</script>
    <div class="modal fade zoomview" id="zoomview" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                    </button>
                    <div class="modal-title">
                        <div class="input-group">
                            <h5 class="thumbtitle btn btn-primary" disabled="disabled"></h5>
                            <!-- <input type="text" class="thumbtitle form-control" value="" onclick="this.select()" readonly > -->
                        </div>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="vfm-zoom"></div>
                    <!--            
                     <div style="position:absolute; right:10px; bottom:10px;">Custom Watermark</div>
                    -->                
                </div>
            </div>
        </div>
    </div>
    <?php    
    /**
    * Load video preview 
    */ 
    if ($setUp->getConfig('playvideo') == true && $hasvideo == true) : ?>

    <link href="vfm-admin/js/videojs/video-js.min.css" rel="stylesheet">
    <script src="vfm-admin/js/videojs/video.min.js"></script>
    <script type="text/javascript">
    function loadVid(thislink, thislinkencoded, thisname, thisID, ext){
        if (ext == 'ogv') {
            ext = 'ogg';
        }
        var vidlink = 'vfm-admin/ajax/streamvid.php?vid=' + thislink;
        var playerhtml = '<video id="my-video" class="video-js vjs-16-9" >' + '<source src="'+ vidlink +'" type="video/'+ ext +'">';
        $(".vfm-zoom").html(playerhtml);
        videojs('#my-video', { 
            "controls": true, 
            "autoplay": true, 
            "preload": "auto"
        }, function(){
            $('#zoomview').on('hidden.bs.modal', function (e) {
                if ( $( "#my-video" ).length ) {
                    videojs('#my-video').dispose();
                }
            });
        });
        $("#zoomview .thumbtitle").html(thisname);
        $("#zoomview").data('id', thisID);
        $("#zoomview").modal();
        // $(".vfmlink").attr("href", baselink + thislinkencoded);
        <?php 
        if ($setUp->getConfig('direct_links') == true) { ?>
            $("#zoomview .thumbtitle").val(script_url + thislink);
            // $(".vfmlink").attr('target','_blank');
        <?php 
        } ?>
    }
    </script>
    <?php 
    endif;

    /**
    * Load image preview 
    */ 
    if ($setUp->getConfig('thumbnails') == true && $hasimage == true) : ?>

    <script type="text/javascript">
    function loadImg(thislink, thisname, thispage){
        var data = "thumb=" + thislink + "&y=1&page=" + thispage;
        console.log(data);
        var data = btoa('me' + data + 'yin');
        $(".vfm-zoom").html("<i class=\"fa fa-refresh fa-spin\"></i><img class=\"preimg\" src=\"vfm-thumb.php?s="+ data + "\" \/>");
        // $("#zoomview").data('id', thisID);
        $("#zoomview .thumbtitle").html(thisname);
        var firstImg = $('.preimg');
        firstImg.css('display','none');
        $("#zoomview").modal();

        firstImg.one('load', function() {
            $(".vfm-zoom .fa-refresh").fadeOut();
            $(this).fadeIn();
            // checkNextPrev(thisID);
            $('a.thumb').data('thispage', thispage);
            checkPage(thislink, thisname, thispage);
            // $(".vfmlink").attr("href", baselink + thislinkencoded);
            <?php 
            if ($setUp->getConfig('direct_links') == true) { ?>
                $(".vfmlink").attr('target','_blank');
                // $("#zoomview .thumbtitle").val(script_url + thislink);
            <?php 
            } ?>
        }).each(function() {
            if(this.complete) {
                $(this).load();
            }
        });   
    }
    
    function loadOffice(thislink, thisname, thispage){
        var preview = $('a.office').data('preview');
        var src = 'http://120.79.77.83/vfm-admin/preview.php?src=' + 
            decodeURI(preview) + (thispage+1);
        
        $(".vfm-zoom").html("<i class=\"fa fa-refresh fa-spin\"></i><img class=\"preimg\" src=" + src + " \/>");
        // $("#zoomview").data('id', thisID);
        $("#zoomview .thumbtitle").html(thisname);
        var firstImg = $('.preimg');
        firstImg.css('display','none');
        $("#zoomview").modal();

        firstImg.one('load', function() {
            $(".vfm-zoom .fa-refresh").fadeOut();
            $(this).fadeIn();
            // checkNextPrev(thisID);
            $('a.office').data('thispage', thispage);
            checkPageOffice(thislink, thisname, thispage);
            // $(".vfmlink").attr("href", baselink + thislinkencoded);
            <?php 
            if ($setUp->getConfig('direct_links') == true) { ?>
                $(".vfmlink").attr('target','_blank');
                // $("#zoomview .officetitle").val(script_url + thislink);
            <?php 
            } ?>
        }).each(function() {
            if(this.complete) {
                $(this).load();
            }
        });   
    }
    </script>
    <?php
    endif;
} // end thumbnails || video
