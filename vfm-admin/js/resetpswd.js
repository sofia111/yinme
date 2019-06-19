 //重置密码验证是否填写正确的手机号
$(document).on('change','#user_email',function (event) {
  var re = /(^1[0-9]{10}$)/;
    var user_email = $.trim($("#user_email").val());       
    if(user_email == '') {
        alert('手机号为空！请填写');
        $("#user_email").focus();
        return false;
    }
    if(!re.test(user_email)) {
       alert('手机号格式有误！');
       $("#user_email").val('').focus();
        return false;
    }
    $.ajax({
        cache: false,
        type:"POST",
        url:'vfm-admin/ajax/get-user_email.php',
        dataType:'json',
        data:
        {user_email:user_email},
        async:false,
        success:function (data) {
            if (data.status==1) {
                if (data.phoneNum == -1) {
                    alert('非注册时手机号，请正确填写');
                }
            }
        },
        error:function(data){
           alert('error');
           console.log(data);
        }

    });
});
//重置密码时发送手机验证码
$(document).on('click','#resetsendCode',function () {   
/*})*/
/*$('#sendCode').click(function(){ 
 */
    var reg = /^\d{11}$/;
    var re = /(^1[0-9]{10}$)/;
    var mobile = $.trim($("#user_email").val());  
    var newp = $.trim($('#newp').val());
    var checknewp = $.trim($('#checknewp').val());
    var resetsms_code = $.trim($('#resetsms_code').val());
    var patternPass = /^[a-zA-Z0-9]{8,}$/;
     
    if(mobile == '') {
        $('#regresponse').html('<div class="alert alert-warning" role="alert">请填写手机号</div>');
        $("#user_email").focus();
        return false;
    }
    if(!re.test(mobile)) {
        $('#regresponse').html('<div class="alert alert-warning" role="alert">手机号格式有误</div>');
        $("#user_email").val('').focus();
        return false;
    }
    if (newp == '') {
        $('#newp').focus();
        $('#regresponse').html('<div class="alert alert-warning" role="alert">请设置新密码</div>');
        return false;
    }else if (checknewp =='') {
        $('#newp').focus();
        $('#regresponse').html('<div class="alert alert-warning" role="alert">请填写确认密码</div>');
        return false;
    }else if (!patternPass.test(newp)) {
        $('#newp').focus();
        $('#regresponse').html('<div class="alert alert-warning" role="alert">密码格式输入有误请重新填写</div>');
        return false;
    }else if (checknewp != newp) {
        $('#newp').focus();
        $('#regresponse').html('<div class="alert alert-warning" role="alert">两次密码输入不一致</div>');
        return false;
    }
    var obj = $(this);

    var time = 60;
    $.ajax({
        url:"vfm-admin/ajax/resetpswd-send.php",
        type:'post',
        data:{
            mobile:mobile,        
        },
        dataType:"json", 
        success:function(data){
            if(data.status==1){
                obj.attr("disabled","disabled");/*按钮倒计时*/
                var set=setInterval(function(){
                    obj.text(--time+"(s)");
                }, 1000);/*等待时间*/
                setTimeout(function(){
                    obj.attr("disabled",false).text("重新获取验证码");/*倒计时*/
                    clearInterval(set);
                }, 60000);
            }else{
                alert(data.info);
            }
        }
    });
});

 $(document).on('submit', '#resetForm', function(){   
        $('#resetForm').data('success', false);
        var newp = $.trim($('#newp').val());
        var user_email = $.trim($('#user_email').val());
        var checknewp = $.trim($('#checknewp').val());
        var resetsms_code = $.trim($('#resetsms_code').val());
        var patternPass = /^[a-zA-Z0-9]{8,}$/;

        if (user_email =='') {
        $('#resetForm').data('submitted', false);
        $('#user_email').focus();
        $('#regresponse').html('<div class="alert alert-warning" role="alert">请填写手机号</div>');
        
        }else if (newp == '') {
            $('#resetForm').data('submitted', false);
            $('#newp').focus();
            $('#regresponse').html('<div class="alert alert-warning" role="alert">请设置新密码</div>');
        }else if (checknewp =='') {
            $('#resetForm').data('submitted', false);
            $('#newp').focus();
            $('#regresponse').html('<div class="alert alert-warning" role="alert">请填写确认密码</div>');
        
        }else if (!patternPass.test(newp)) {
            $('#resetForm').data('submitted', false);
            $('#newp').focus();
            $('#regresponse').html('<div class="alert alert-warning" role="alert">密码格式输入有误请重新填写</div>');
        
        }else if (checknewp != newp) {
            $('#resetForm').data('submitted', false);
            $('#newp').focus();
            $('#regresponse').html('<div class="alert alert-warning" role="alert">两次密码输入不一致</div>');
        
        }else if (resetsms_code =='') {
            $('#resetForm').data('submitted', false);
            $('#newp').focus();
            $('#regresponse').html('<div class="alert alert-warning" role="alert">请输入验证码</div>');   
        }
        $.ajax({
            cache: false,
            method: "POST",
            url: "vfm-admin/ajax/sms_code_resetpsw.php",
            data:{
                user_email:user_email,
                newp:newp,
                resetsms_code:resetsms_code

            },
            async:false
            })
        .done(function( msg ) {
            console.log(msg);
            $('#regresponse').html(msg);
            if (msg == '<div class="alert alert-warning" role="alert"><strong></strong>手机验证成功</div>' ||
                msg == '')
                $('#resetForm').data('success', true);
            
        })
        .fail(function() {
            $('#regresponse').html('<div class="alert alert-danger" role="alert">error connecting user-refresh.php</div>');
            $('.mailpreload').fadeOut('slow', function(){
                $('#resetForm').data('submitted', false);
            });
            return false;
        });
       
        if (!$('#resetForm').data('success'))
            return false;
    });
