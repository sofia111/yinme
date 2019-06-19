<?php
/**
 * VFM - veno file manager: include/reset.php
 * password reset form
 *
 * PHP version >= 5.3
 *
 * @category  PHP
 * @package   VenoFileManager
 * @author    sofia<QQ:1506798421@qqq.com>
 * @license   Exclusively sold on CodeCanyon: http://bit.ly/veno-file-manager
 * @link      http://filemanager.veno.it/
 */ ?>

<script type="text/javascript" src="vfm-admin/js/resetpswd.js"></script>
<script type="text/javascript" src="vfm-admin/js/registration.js"></script>
<section class="vfmblock">
    <div class="login">
        <noscript>
            <div class="alert alert-danger">Please activate JavaScript</div>
        </noscript>
          <div class="sendresponse"></div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-unlock-alt"></i> <?php print $encodeExplorer->getString('reset_password'); ?>
                    </div>
                    <div class="panel-body">
                     
<?php

    ?>
            <form role="form" method="post" id="resetForm" action="<?php print $encodeExplorer->makeLink(false, null, ""); ?>">
                 <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-phone fa-fw"></i></span>
                                <input type="mobile" name="user_email" id="user_email" class="form-control" placeholder="填写注册的手机号" />
                            </div>
                        </div>
                    <div class="form-group"> 
                       <div class="has-feedback">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-lock fa-fw"></i></span>
                                <input name="user_new_pass" id="newp" type="password" placeholder="请输入八位以上数字或者字母的新密码" class="form-control">
                                
                            </div>
                            <span class="glyphicon glyphicon-minus form-control-feedback"></span>
                        </div>
                    </div>
                     <div class="form-group">
                        <div class="has-feedback">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-lock fa-fw"></i></span>
                                <input name="user_new_pass_confirm" id="checknewp" type="password" class="form-control" placeholder="确认新密码">
                                
                            </div>
                            <span class="glyphicon glyphicon-minus form-control-feedback"></span>
                        </div>
                    </div>

                        <div class="form-group">
                               <!--  <label for="user_email">* 
                                    验证码
                                </label> -->
                               <div class="input-group">
                                    <input type="text" name="resetsms_code" class="form-control" id="resetsms_code" placeholder="填写验证码" />
                                    <span class="input-group-btn">
                                          <button class="btn btn-success" type="button" id="resetsendCode">发送</button>
                                    </span>
                                </div>
                                <div id="regresponse"></div>
                            </div>
                        <?php 
                        /* ************************ CAPTCHA ************************* */
                       /* if ($setUp->getConfig("show_captcha_reset") == true ) { 
                            $capath = "vfm-admin/";
                            include "vfm-admin/include/captcha.php";
                        }*/ ?>
                        <button type="submit" class="btn btn-block btn-primary">
                            <i class="fa fa-arrow-circle-right"></i>
                            重置
                        </button>
                    </div>
                   <!--  <div class="panel-footer">
                        <?php print $encodeExplorer->getString("enter_email_receive_link"); ?>
                    </div> -->

                    <div class="mailpreload">
                        <div class="cta">
                            <i class="fa fa-refresh fa-spin"></i>
                        </div>
                    </div>
                </div>
            </form>
             <div class="mailpreload">
        <div class="cta">
            <i class="fa fa-refresh fa-spin"></i>
        </div>
    </div>

        <a href="?dir=">
            <i class="fa fa-sign-in"></i> <?php print $encodeExplorer->getString("log_in"); ?>
        </a>
    </div> <!-- .login -->
</section>