<?php
/**
 * VFM - veno file manager: include/register.php
 * front-end registration panel
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

/**
* Get additional custom fields
*/
$customfields = false;
if (file_exists('vfm-admin/users/customfields.php')) {
    include 'vfm-admin/users/customfields.php';
}

if (file_exists('mysql/MySQL.class.php')) {
    require 'mysql/MySQL.class.php';
}

/*
link database
*/


 $link = MySQL::getlink(); 
/**
* Registration Mask
*/
if ($setUp->getConfig("registration_enable") == true) { ?>
    
    <script type="text/javascript" src="vfm-admin/js/registration.js"></script>
<br>
<br>
<br>
    <section class="vfmblock">
        <div class="login">            
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-user-plus"></i> <?php print $encodeExplorer->getString('registration'); ?>
                </div>
                <div class="panel-body">
                    <form id="regform" action="<?php print $encodeExplorer->makeLink(false, null, ""); ?>">
                       
                        <div id="login_bar" class="form-group">

                            <!-- <label for="user_pass">*&nbsp;您是否为在校学生</label>
                            <div class="input-group">
                                <span class="input-group-addon"> 
                                    <i class="fa fa-user fa-fw"></i></span>
                                <select class="form-control" id="isStudent" name="isStudent" >
                                    <option value="0">请选择是否为在校学生</option> 
                                    <option value="是">是</option>
                                    <option value="否">否</option>
                                </select>                         
                            </div>
                        </br>
                        <div id="Isdisplay"> 
                            <label for="user_pass">*&nbsp;学校选择</label>
                            <div class="input-group">
                                <span class="input-group-addon"> 
                                     <i class="fa fa-user fa-fw"></i></span>
                                    <select class="form-control" id="schoolName" name="schoolName">
                                        <option value="0">请选择学校</option>
                                        <?php  
                                            
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
                            </div>
                            </br>
                        
                            <label for="user_pass">*&nbsp;学院选择</label>
                            <div class="input-group">
                                <span class="input-group-addon"> 
                                     <i class="fa fa-user fa-fw"></i></span>
                                <select class="form-control" id="academyName" name="academyName" >
                                    <option value="0" >请选择学院</option>
                                </select>
                            </div>
                            </br>
                            <label for="user_pass">*&nbsp;专业选择</label>
                            <div class="input-group">
                                <span class="input-group-addon"> 
                                    <i class="fa fa-user fa-fw"></i></span>
                                <select class="form-control" id="majorName" name="majorName">
                                    <option value="0">请选择专业</option>  
                                </select>
                            </div>
                            <br/>
                        </div>
                            <div class="form-group">

                                <div class="has-feedback">
                                    <label for="user_name">* 
                                        <?php echo $encodeExplorer->getString("username"); ?>
                                    </label>  
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                        <i class="fa fa-user fa-fw"></i>
                                        </span>
                                        <input type="hidden" name="user_name" value="" id="user_name" placeholder="请输入以字母开头且三位以上的用户名" class="form-control" />
                                    </div>
                                    <span class="glyphicon glyphicon-minus form-control-feedback"></span>
                                </div>
                            </div>
                        -->
                        <input type="hidden" id="isStudent" name="isStudent" value="是">
                        <input type="hidden" id="schoolName" name="schoolName" value="0">
                        <input type="hidden" id="academyName" name="academyName" value="0">
                        <input type="hidden" id="majorName" name="majorName" value="0">
                        
                             <div class="form-group">
                                <!-- <label for="user_email">* 
                                    手机
                                </label> -->
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-phone fa-fw"></i></span>
                                    <input type="mobile" name="user_email" id="user_email" class="form-control"  placeholder="填写手机号" />
                                </div>
                            </div>
                            <div class="has-feedback">
                                <!-- <label for="user_pass">* 
                                    <?php echo $encodeExplorer->getString("password"); ?>
                                </label> -->
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-lock fa-fw"></i></span>
                                    <input type="password" name="user_pass" id="user_pass" class="form-control" placeholder="请输入八位以上数字或者字母的密码" />             
                                </div>
                                <span class="glyphicon glyphicon-minus form-control-feedback"></span>
                            </div>
                            <br>
                            <div class="has-feedback">
                               <!--  <label for="user_pass">* 
                                    <?php echo $encodeExplorer->getString("password")." (".$encodeExplorer->getString("confirm").")"; ?>
                                </label> -->
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-lock fa-fw"></i></span>
                                    <input type="password" name="user_pass_confirm" id="user_pass_check" class="form-control" placeholder="确认密码" />
                                </div>
                                <span class="glyphicon glyphicon-minus form-control-feedback"></span>
                            </div>
                            <br>
                            <div class="form-group">
                                <!-- <label for="user_invited">
                                    邀请手机号
                                </label> -->
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-phone fa-fw"></i></span>
                                    <input type="mobile" name="user_invited" id="user_invited" class="form-control" placeholder="邀请者手机号(可不填)" onblur="invited()"
                                     <?php
									 if($_GET['reg'] !== "1"){
										 echo "value='".$_GET['reg']."'";
									 }
									 ?> />
                                </div>
                            </div>
                           
                            <div class="form-group">
                               <!--  <label for="user_email">* 
                                    验证码
                                </label> -->
                               <div class="input-group">
                                    <input type="text" name="sms_code" class="form-control" placeholder="填写验证码" />
                                    <span class="input-group-btn">
                                          <button class="btn btn-success" type="button" id="sendCode">发送</button>
                                    </span>
                                </div>
                            </div>
                            <div id="regresponse"></div>
 <script type="text/javascript" src="vfm-admin/js/refresh.js"></script> 
    <?php
    /**
    * Additional user custom fields
    */
    if (is_array($customfields)) { ?>
        <?php
        foreach ($customfields as $customkey => $customfield) { ?>
            <div class="form-group">
                <label><?php echo $customfield['name']; ?></label>
            <?php
            if ($customfield['type'] === 'textarea') { ?>
                <textarea name="<?php echo $customkey; ?>" class="form-control" rows="2"></textarea>
            <?php
            }
            if ($customfield['type'] === 'select' && is_array($customfield['options'])) { ?>
                <select name="<?php echo $customkey; ?>" class="form-control coolselect">
                <?php
                foreach ($customfield['options'] as $optionval => $optiontitle) { ?>
                    <option value="<?php echo $optionval; ?>"><?php echo $optiontitle; ?></option>
                <?php
                } ?>
                </select>
            <?php
            }
            if ($customfield['type'] === 'text' || $customfield['type'] === 'email') { ?>
                 <input type="<?php echo $customfield['type']; ?>" name="<?php echo $customkey; ?>" class="form-control">
            <?php
            } ?>
            </div>
        <?php
        }
    } ?>

    <?php
    $disclaimerfile = 'vfm-admin/registration-disclaimer.html';
    if (file_exists($disclaimerfile)) {
        $disclaimer = file_get_contents($disclaimerfile);
        echo $disclaimer; ?>
        <div class="checkbox">
            <label>
                <input type="checkbox" id="agree" name="agree"> Accept 
                <a href="#" data-toggle="modal" data-target="#disclaimer" required>
                    <u>terms and conditions</u>
                </a>
            </label>
        </div>
    <?php
    } ?>
            <div class="form-group">
            <?php 
            /* ************************ CAPTCHA ************************* */
            if ($setUp->getConfig("show_captcha_register") == true ) { 
                $capath = "vfm-admin/";
                include "vfm-admin/include/captcha.php"; 
            }   ?>
                <button type="submit" class="btn btn-primary btn-block" />
                    <i class="fa fa-check"></i> 
                    <?php print $encodeExplorer->getString("register"); ?>
                </button>
            </div>
        </div>
    </form>
</div>
    <div class="mailpreload">
        <div class="cta">
            <i class="fa fa-refresh fa-spin"></i>
        </div>
    </div>
</div>
            <a href="?dir="><i class="fa fa-sign-in"></i>  <?php print $encodeExplorer->getString("log_in"); ?></a>
        </div>
    </section>
    <?php
}
