<?php
/**
 * VFM - veno file manager: include/navbar.php
 * user menu, user panel and language selector
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
if (file_exists('include/mysql/MySQL.class.php')) {
    require 'include/mysql/MySQL.class.php';
}
$parent = basename($_SERVER["SCRIPT_FILENAME"]);
$islogin = ($parent === "login.php" ? true : false); 
$stepback = $islogin ? '' : 'vfm-admin/';


$link = MySQL::getlink();
$sql = "select phoneNum from user where userName = '".$_SESSION['vfm_user_name']."'";
$result = $link->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $phoneNum = $row["phoneNum"];
    }
} else{
    $phoneNum = 1;
}
?>



<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#collapse-vfm-menu">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <?php
            /**
            * Brand button
            */
            ?>
            <!-- <a class="navbar-brand" href="<?php echo $setUp->getConfig("script_url"); ?>">首页</a> -->
             <a href="<?php echo $setUp->getConfig("script_url").'yinme.php'; ?>"><img src="vfm-admin/images/indexlogo2.png" class="navbar-brand" style="line-height: 50px;margin: 0px -20px 0px -10px;"></a>
            <!-- <a class="navbar-brand" href="<?php echo $setUp->getConfig("script_url").'yinme.php'; ?>">
                <?php echo $setUp->getConfig("appname"); ?>
            </a> -->
			<div class="hidden-xs" style="display: inline; width: 40px;"></div>
            <a class="navbar-brand" href="<?php echo $setUp->getConfig("share_url"); ?>">
                <?php echo $setUp->getConfig("share"); ?>
            </a>
			<a class="navbar-brand" href="http://www.vdabao.cn/download.aspx?id=232202">
                APP下载
            </a>

        </div>
        <div class="collapse navbar-collapse" id="collapse-vfm-menu">
            <ul class="nav navbar-nav navbar-right">
<?php
/**
* User menu
*/
if ($gateKeeper->isUserLoggedIn()) {

    $username = $gateKeeper->getUserInfo('name');
    $avaimg = $gateKeeper->getAvatar($username, $stepback);
    $avadefault = $gateKeeper->getAvatar('', $stepback);

    if ($setUp->getConfig("show_usermenu") == true ) { ?>
        <li>
            <a class="edituser" href="#" data-toggle="modal" data-target="#userpanel">

                <img class="img-circle avatar" width="28px" height="28px" src="<?php echo $avaimg."?t=".rand(1, 100); ?>" />
                <span class="hidden-sm">
                    <strong><?php echo $username; ?></strong>
                </span>
            </a>
        </li>
        <li class="yinbi">
            <a>    
                <span class="hidden-sm">
                <i class="fa fa-user"></i>&nbsp&nbsp印币：
                    <?php
                        $sql = "select invitation from user where userName = '".$_SESSION['vfm_user_name']."'";
                        $result = $link->query($sql);
                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                echo $row["invitation"];
                            }
                        } else{
                            echo 0;
                        }
                    ?>
                </span>
                <div class="yinbito">
                    <a><span style="color: #fff;">1.1印币 = 1.00元</span></a>
                    <a><span style="color: #fff;">2.费用大于1元方可使用</span></a>
                    <a><span style="color: #fff;">3.每邀请一人可获得1印币</span></a>
                </div>
            </a>
        </li>
        <li class="invited">
            <a>    
                <span class="hidden-sm" style="position: relative;">
                <i class="fa fa-users"></i>&nbsp&nbsp邀请
                </span>
                <div class="invitedto">
                    <a target="_blank"
                    <?php
                    $href="share.html?phoneNum=".$phoneNum;
                    echo "href='".$href."'";
                    ?>
                     style="background: #448AFF;">
                        <span style="color: #fff;cursor: pointer;"><img src="vfm-admin/images/QQ.png" width="16px;" />QQ好友</span>
                    </a>
                    <!-- <a>
                        <span style="color: #fff;cursor: pointer;"><img src="vfm-admin/images/QQz.png" width="16px;" />QQ空间</span>
                    </a>
                    <a>
                        <span style="color: #fff;cursor: pointer;"><img src="vfm-admin/images/wx.png" width="16px;" />微信好友</span>
                    </a>
                    <a>
                        <span style="color: #fff;cursor: pointer;"><img src="vfm-admin/images/wxf.png" width="16px;" />朋友圈</span>
                    </a> -->
                </div>
            </a>
        </li>
        <script src="http://res.wx.qq.com/open/js/jweixin-1.2.0.js" type="text/javascript" charset="utf-8"></script>
        <script type="text/javascript">
            
            function toShare() {
				alert("您的邀请码已自动传递,微信请点击右上角进行分享(非微信端仅能进行QQ好友分享)");
				
                var phoneNum = <?php echo $phoneNum;?>;
                //这里的AJAX用于获取后台数据，当然也可以不用这么写，您只需要提取您需要的代码即可
                $.ajax({
                    url: "vfm-admin/sharelink.php",
                    data: {
                        //需要encodeURIComponent转码，默认为分享当前地址
                        url: encodeURIComponent(location.href.split('#')[0])
                    },
                    type: 'POST',
                    success: function(res) {
                        //获取数据之后的操作，如果配置信息在其他地方获取，删掉这段AJAX请求，该参数就好
                        var result = JSON.parse(res);
                        var obj = result.data;
                        //配置微信参数
                        wx.config({
                            //debug: true, //开启调试模式,调用的所有api的返回值会在客户端alert出来
                            appId:obj.appId, //在微信绑定公众号时生成的appid,有后台返回 
                            timestamp: obj.timestamp, //生成签名的时间戳，由后台返回
                            nonceStr: obj.nonceStr, //生成签名的随机串，由后台返回
                            signature: obj.signature, //签名，由后台返回
                            jsApiList: ['onMenuShareAppMessage', 'onMenuShareTimeline','onMenuShareQQ','onMenuShareQZone'] 
                            //jsApiList参数可以有很多，一下一一对应列出来
                            //但是下面需要添加对应的参数信息（下面只写了分享到微信好友和朋友圈，方便复制）
                            //onMenuShareQQ   分享到QQ好友
                            //onMenuShareWeibo  分享到腾讯微博
                            //onMenuShareQZone  分享QQ空间
                        });
                        wx.ready(function(){
							wx.onMenuShareQQ({
								title: "印么",
								link: "http://changli.mefack.com/yinme.php?reg="+phoneNum,
								imgUrl: "http://changli.mefack.com/vfm-admin/images/logo.ico",
								desc: "一起加入印么",
								
								success: function() {
									alert('分享QQ好友成功');  
								},
								cancel: function() {
									alert('你没有分享到QQ好友');  
								}
							});
							wx.onMenuShareQZone({
								title: "印么",
								link: "http://changli.mefack.com/yinme.php?reg="+phoneNum,
								imgUrl: "http://changli.mefack.com/vfm-admin/images/logo.ico",
								desc: "一起加入印么",
								
								success: function() {
									alert('分享到QQ空间成功');  
								},
								cancel: function() {
									alert('你没有分享到QQ空间');  
								}
							});
							wx.onMenuShareTimeline({
								//以下是微信的分享的配置信息，建议从后端获取
								title: "印么",
								link: "http://changli.mefack.com/yinme.php?reg="+phoneNum,
								imgUrl: "http://changli.mefack.com/vfm-admin/images/logo.ico",
								
								success: function() {
									
									alert('分享到朋友圈成功');  
								}
							});
							wx.onMenuShareAppMessage({
								title: "印么",
								link: "http://changli.mefack.com/yinme.php?reg="+phoneNum,
								imgUrl: "http://changli.mefack.com/vfm-admin/images/logo.ico",
								desc: "一起加入印么",
								
								success: function(res) {
									alert('分享到朋友成功');
								}
							});
						})
                    }
                });
            }
        </script>

        <?php
        if ($gateKeeper->isSuperAdmin()) { ?>
                <li>
                    <a href="<?php echo $setUp->getConfig("script_url"); ?>vfm-admin/">
                        <i class="fa fa-cogs fa-fw"></i> 
                        <span class="hidden-sm">
                            <?php echo $encodeExplorer->getString("administration"); ?>
                        </span>
                    </a>
                </li>
        <?php
        } ?>
                <li>
                    <a href="?order">    
                        <span class="hidden-sm">
                        <i class="fa fa-first-order fa-fw"></i>  
                            
                            <?php echo $encodeExplorer->getString("my_order"); ?>
                        </span>
                    </a>
                </li>
				<li>
                    <a href="http://shang.qq.com/wpa/qunwpa?idkey=2d270f8f9d79a3073c16d3a8080d6f56767f7f5cda4dc6eff92d8e15359f83c3">    
                        <span class="hidden-sm">
                        <i class="fa fa-first-order fa-fw"></i>  
                            
                            联系我们
                        </span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo $setUp->getConfig("script_url").$encodeExplorer->makeLink(true, null, ""); ?>">
                        <i class="fa fa-sign-out fa-fw"></i> 
                        <span class="hidden-sm">
                            <?php echo $encodeExplorer->getString("log_out"); ?>
                        </span>
                    </a>
                </li>
    <?php
    } else { ?>
                <li>
                    <a href="<?php echo $encodeExplorer->makeLink(true, null, ""); ?>">
                        <i class="fa fa-sign-out fa-fw"></i> 
                        <span class="hidden-sm">
                            <?php echo $encodeExplorer->getString("log_out"); ?>
                        </span>
                    </a>
                </li>
        <?php 
        if ($gateKeeper->isSuperAdmin()) { ?>
                <li>
                    <a href="<?php echo $setUp->getConfig("script_url"); ?>vfm-admin/">
                        <i class="fa fa-cogs fa-fw"></i> 
                        <span class="hidden-sm">
                            <?php echo $encodeExplorer->getString("administration"); ?>
                        </span>
                    </a>
                </li>
        <?php
        }
    }
} // end logged user
?>
            </ul>
        </div>
    </div>
</nav>

<?php
/**
* User Panel
*/
if ($gateKeeper->isUserLoggedIn() && $setUp->getConfig("show_usermenu") == true ) { ?>

    <script src="<?php echo $stepback; ?>js/avatars.min.js"></script>
    <script type="text/javascript">
    $(document).ready(function(){
      Avatars('<?php echo $avaimg; ?>', '<?php echo $avadefault; ?>');
    });
    </script>
    <script type="text/javascript" src="vfm-admin/js/registration.js"></script>
    <div class="modal userpanel fade" id="userpanel" tabindex="-1">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">
                <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
            </button>
            <ul class="nav nav-pills" role="tablist">
              <li role="presentation" class="active">
                    <a href="#upprof" aria-controls="home" role="tab" data-toggle="pill">
                        <i class="fa fa-edit"></i> 
                        <?php echo $encodeExplorer->getString("update_profile"); ?>
                    </a>
              </li>
              <li role="presentation">
                    <a href="#upava" aria-controls="home" role="tab" data-toggle="pill">
                        <i class="fa fa-user"></i> 
                        <?php echo $encodeExplorer->getString("avatar"); ?>
                    </a>
              </li>
            </ul>
          </div>

          <div class="modal-body">
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane fade text-center" id="upava">
                    <div class="avatar-panel">
                        <div class="image-editor">
                            <label for="uppavatar" class="upload-wrapper">
                                <input type="file" id="uppavatar" class="cropit-image-input">
                            </label>
                            <i class="fa fa-times fa-lg pull-right text-muted remove-avatar"></i>
                            <div class="updated"></div>

                            <input type="hidden" class="image-name" value="<?php print md5($gateKeeper->getUserInfo('name')); ?>">
                            <div class="cropit-image-preview"></div>
                            <div class="image-size-wrapper">         
                                <input type="range" class="cropit-image-zoom-input slider">
                            </div>
                        </div>
                    </div>
                    <div class="uppa btn btn-default">
                        <?php print $encodeExplorer->getString("upload"); ?> <i class="fa fa-upload fa-fw"></i>
                    </div>
                    <div class="export btn btn-primary hidden">
                        <?php print $encodeExplorer->getString("update"); ?> <i class="fa fa-check-circle fa-fw"></i>
                    </div>
                </div> 

                <div role="tabpanel" class="tab-pane fade in active" id="upprof">
                <form role="form" method="post" id="usrForm" autocomplete="off" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING']);?>">
                    <div class="form-group">
                        <label for="user_new_name">带*为必填项<br>*
                            <?php print $encodeExplorer->getString("username"); ?>

                        </label>
                        <input name="name"  readonly id="name"
                        class="form-control" value="<?php print $gateKeeper->getUserInfo('name'); ?>">
                        <br> 
                        <label for="isStudent">*&nbsp;您是否为在校学生</label>
                        <div class="input-group">
                            <span class="input-group-addon"> 
                                <i class="fa fa-user fa-fw"></i></span>
                            <select class="form-control" id="isStudent" name="isStudent" >
                                    
                                <option value="0">请选择是否为学生</option>                          
                                <option value="是">是</option>
                                <option value="否">否</option>
                            </select> 
                            <input name="oldisStudent"  readonly id="oldisStudent"
                        class="form-control" type="hidden" value="<?php print $gateKeeper->getUserInfo('isStudent'); ?>">                       
                        </div>
                        
                        <div id="Isdisplay">
                            <label for="user_school">&nbsp;学校选择</label>
                            <div class="input-group">
                                <span class="input-group-addon"> 
                                     <i class="fa fa-user fa-fw"></i></span>
                                <select class="form-control" id="schoolName" name="schoolName">
                                    <?php
                                                if ($gateKeeper->getUserInfo('schoolName')=='0') {
                                                    echo '<option value="0">请选择学校</option>';
                                                    
                                                }else{
                                                 echo '<option value="'.$gateKeeper->getUserInfo('schoolName').'">'.$gateKeeper->getUserInfo('schoolName').'</option>';
                                                 }
                                                                                                                   
                                        $sql=mysqli_query($link,"select distinct(schoolName) from school order by schoolID asc");
                                        $result = mysqli_num_rows($sql);                                      
                                        if ($result) {
                                            while ($info=mysqli_fetch_array($sql)) {
                                                echo '<option id="schoolName" name="schoolName" value="'.$info['schoolName'].'">'.$info['schoolName'].'</option>';
                                            }
                                        } else {
                                            die();
                                        }
                                    ?>     
                                </select>  
                                <input name="oldschoolName"  readonly type="hidden"
                                class="form-control" value="<?php print $gateKeeper->getUserInfo('schoolName'); ?>">      
                            </div>
                            
                            <label for="user_academy">&nbsp;学院选择</label>
                            <div class="input-group">
                                <span class="input-group-addon"> 
                                     <i class="fa fa-user fa-fw"></i></span>
                                <select class="form-control" id="academyName" name="academyName" >
                                    <?php

                                        if ($gateKeeper->getUserInfo('academyName')=='0') {
                                            echo '<option value="0">请选择学院</option>';
                                        }
                                        else{
                                        echo '<option value="'.$gateKeeper->getUserInfo('academyName').'">'.$gateKeeper->getUserInfo('academyName').'</option>';
                                        }
                                    
                                ?>
                                </select>
                                <input name="oldacademyName"  readonly type="hidden"
                                class="form-control" value="<?php print $gateKeeper->getUserInfo('academyName'); ?>"> 
                            </div>
                            
                            <label for="user_pass">&nbsp;专业选择</label>
                            <div class="input-group">
                                <span class="input-group-addon"> 
                                    <i class="fa fa-user fa-fw"></i></span>
                                <select class="form-control" id="majorName" name="majorName">
                                    <?php                                    
                                    
                                        if ($gateKeeper->getUserInfo('majorName')=='0') {
                                            echo '<option value="0">请选择专业</option>';
                                        }
                                        else{
                                        echo '<option value="'.$gateKeeper->getUserInfo('majorName').'">'.$gateKeeper->getUserInfo('majorName').'</option>';
                                        }
                                    
                                ?>     
                                </select>
                                <input name="oldmajorName"  readonly type="hidden"
                                class="form-control" value="<?php print $gateKeeper->getUserInfo('majorName'); ?>">
                            </div>
                            
                        </div>
                        <div class="has-feedback">

                            <label for="user_old_pass">
                                * <?php print $encodeExplorer->getString("current_pass"); ?>
                            </label> 
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-unlock fa-fw"></i></span>
                                <input name="user_old_pass" type="password" id="oldp" class="form-control" > 
                                <?php 
                                $sql=mysqli_query($link,"select * from user where userName ='".$_SESSION['vfm_user_name']."'");
                                $info = mysqli_fetch_array($sql);
                                ?>
                                <input type="hidden" readonly id="oldpass"  value="<?php print $info['password'] ?> 
                                  ">                             
                            </div>
                            <span class="glyphicon glyphicon-minus form-control-feedback"></span>           
                        </div>
                        <div class="has-feedback">
                            <label for="user_new_pass">
                                <?php print $encodeExplorer->getString("new_password"); ?>
                            </label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-lock fa-fw"></i></span>
                                <input name="user_new_pass" id="newp" type="password" placeholder="请输入八位以上数字或者字母的新密码" class="form-control">
                                
                            </div>
                            <span class="glyphicon glyphicon-minus form-control-feedback"></span>
                        </div>
                        <div class="has-feedback">
                            <label for="user_new_pass_confirm">
                                <?php print $encodeExplorer->getString("new_password")
                                ." (".$encodeExplorer->getString("confirm").")"; ?>
                            </label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-lock fa-fw"></i></span>
                                <input name="user_new_pass_confirm" id="checknewp" type="password" class="form-control">
                                
                            </div>
                            <span class="glyphicon glyphicon-minus form-control-feedback"></span>
                        </div>
                        
                            <label for="user_old_email">
                                *现在的手机号
                            </label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-phone fa-fw"></i></span> 
                                <input name="user_old_email"  readonly id="user_old_email"
                                   class="form-control" value="<?php print $gateKeeper->getUserInfo('email');?>">
                        </div>  
                        <label for="user_email"> 
                                新手机号
                        </label>                                          
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-phone fa-fw"></i></span>                     
                            <input type="mobile" name="user_email" id="user_email" class="form-control" placeholder="请输入新手机号" />
                        </div>                        
                        <label for="user_email"> 
                                验证码
                        </label>
                        <div class="input-group">
                            
                            <input type="text" name="sms_code" id="sms_code" class="form-control" />
                            <span class="input-group-btn">
                                  <button class="btn btn-success" type="button" id="sendCode">发送</button>
                            </span>
                        </div>
                        <div id="refreshresponse"></div>
                    </div> 
                    <div class="form-group">
                      <button type="submit" class="btn btn-primary btn-block">
                        <i class="fa fa-refresh"></i>
                        <?php print $encodeExplorer->getString("update"); ?>
                      </button>
                    </div>
                </form>
                </div> <!-- tabpanel -->
            </div><!-- tab-content -->
          </div> <!-- modal-body -->
        </div> <!-- modal-content -->
      </div> <!-- modal-dialog -->
    </div> <!-- modal -->
	


<?php 
} ?>
<?php

    if (isset($_SESSION['vfm_user_name'])) {
    echo '<script src="vfm-admin/js/refresh.js"></script>';
}
?>

