<?php
/**
 * 
 *
 * @category  PHP
 * @author    sofia<QQ:1506798421@qqq.com>
 */ ?>
<section class="vfmblock">
    <div class="login">
        <noscript>
            <div class="alert alert-danger">Please activate JavaScript</div>
        </noscript>
          <div class="sendresponse"></div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-unlock-alt"></i> 找回用户名
                    </div>
                    <div class="panel-body">
                     
<?php

    ?>
            <form role="form" method="post" id="finduserForm" action="<?php print $encodeExplorer->makeLink(false, null, ""); ?>">
                 <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-phone fa-fw"></i></span>
                                <input type="mobile" name="user_email" id="user_email" class="form-control" placeholder="填写注册的手机号" />
                                <button id="findusername"></button>
                            </div>
                        </div>
                    <div class="form-group">   
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-user fa-fw"></i></span>
                                <input name="user_new_pass" id="newp" type="password" placeholder="" class="form-control">                          
                            </div>
                    <div class="mailpreload">
                        <div class="cta">
                            <i class="fa fa-refresh fa-spin"></i>
                        </div>
                    </div>
                </div>
            </form>
        <a href="?dir=">
            <i class="fa fa-sign-in"></i> <?php print $encodeExplorer->getString("log_in"); ?>
        </a>
    </div> <!-- .login -->
</section>