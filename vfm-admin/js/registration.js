   var delay = (function(){
      var timer = 0;
      return function(callback, ms){
        clearTimeout (timer);
        timer = setTimeout(callback, ms);
      };
    })();
/*
function checkUserAvailable(thisinput){
    
       
    var gliph;

    thisinput.parent().next('.form-control-feedback').removeClass('glyphicon-minus').removeClass('glyphicon-remove').removeClass('glyphicon-ok').addClass('glyphicon-refresh').addClass('fa-spin');
    thisinput.closest('.has-feedback').removeClass('has-error').removeClass('has-success');

    
        var username = $("#user_name").val();
        var patternName = /^[a-zA-Z]{1,}\w*$/;
        
        if (username.length >= 3 && patternName.test(username)==true) {
            $.ajax({
              method: "POST",
              url: "vfm-admin/ajax/usr-check.php",
              data: { user_name: username }
            })
            .done(function( msg ) {
                // console.log( "Data Saved: " + msg );
                // $("#user-result").html( msg );
                if (msg == 'success') {
                    gliph = 'glyphicon-ok';
                } else {
                    gliph = 'glyphicon-remove';
                }
                thisinput.closest('.has-feedback').addClass('has-'+msg);
                thisinput.parent().next('.form-control-feedback').removeClass('glyphicon-refresh').removeClass('fa-spin').addClass(gliph);
            });
            return true;
        } else {
            thisinput.closest('.has-feedback').addClass('has-error');
            thisinput.parent().next('.form-control-feedback').removeClass('glyphicon-refresh').removeClass('fa-spin').addClass('glyphicon-remove');
           return false;
        }
  
}

$(document).on('keyup', '#user_name', function(){
    checkUserAvailable($(this));
});
*/
$(document).on('keyup keypress', '#regform', function(e){
    var keyCode = e.keyCode || e.which;
    if (keyCode === 13) { 
        e.preventDefault();
        return false;
    }
});
//邀请
function invited(){
    if($("input[name='user_invited']").val() !== ""){
        if ($("input[name='user_email']").val() == $("input[name='user_invited']").val()) {
            alert('不能自己邀请自己');
            $("input[name='user_invited']").val('');
        }
    }
};


function checkUserPassAvailable(thisinput){
    
    

    thisinput.parent().next('.form-control-feedback').removeClass('glyphicon-minus').removeClass('glyphicon-remove').removeClass('glyphicon-ok').addClass('glyphicon-refresh').addClass('fa-spin');
    thisinput.closest('.has-feedback').removeClass('has-error').removeClass('has-success');

    delay(function(){
        var pwd1 = $('#user_pass').val();
        var pwd2 = $('#user_pass_check').val();
        var patternPass = /^[a-zA-Z0-9]{8,}$/;
        
        if (patternPass.test(pwd1)) { 
            
            
                thisinput.closest('.has-feedback').addClass('has-'+'success');
                thisinput.parent().next('.form-control-feedback').removeClass('glyphicon-refresh').removeClass('fa-spin').addClass('glyphicon-ok');
            }
         else {
            thisinput.closest('.has-feedback').addClass('has-error');
            thisinput.parent().next('.form-control-feedback').removeClass('glyphicon-refresh').removeClass('fa-spin').addClass('glyphicon-remove');
        }
    },1000);
        
}

function checkUserNewPassAvailable(thisinput){
    
   

    thisinput.parent().next('.form-control-feedback').removeClass('glyphicon-minus').removeClass('glyphicon-remove').removeClass('glyphicon-ok').addClass('glyphicon-refresh').addClass('fa-spin');
    thisinput.closest('.has-feedback').removeClass('has-error').removeClass('has-success');

    delay(function(){
        var pwd1 = $('#newp').val();
        var pwd2 = $('#checknewp').val();
        var patternPass = /^[a-zA-Z0-9]{8,}$/;
        
        if (patternPass.test(pwd1)) { 
            
            
                thisinput.closest('.has-feedback').addClass('has-'+'success');
                thisinput.parent().next('.form-control-feedback').removeClass('glyphicon-refresh').removeClass('fa-spin').addClass('glyphicon-ok');
            }
         else {
            thisinput.closest('.has-feedback').addClass('has-error');
            thisinput.parent().next('.form-control-feedback').removeClass('glyphicon-refresh').removeClass('fa-spin').addClass('glyphicon-remove');
        }
    },1000);
        
}

function checkUserPassCheckAvailable(thisinput){
    
    

    thisinput.parent().next('.form-control-feedback').removeClass('glyphicon-minus').removeClass('glyphicon-remove').removeClass('glyphicon-ok').addClass('glyphicon-refresh').addClass('fa-spin');
    thisinput.closest('.has-feedback').removeClass('has-error').removeClass('has-success');

    delay(function(){
        var pwd1 = $('#user_pass').val();
        var pwd2 = $('#user_pass_check').val();
        var patternPass = /^[a-zA-Z0-9]{8,}$/;
        
        if (pwd2==pwd1) { 
            thisinput.closest('.has-feedback').addClass('has-'+'success');
            thisinput.parent().next('.form-control-feedback').removeClass('glyphicon-refresh').removeClass('fa-spin').addClass('glyphicon-ok');
            }
        else {
            thisinput.closest('.has-feedback').addClass('has-error');
            thisinput.parent().next('.form-control-feedback').removeClass('glyphicon-refresh').removeClass('fa-spin').addClass('glyphicon-remove');
        }
    },1000);
      
}

function checkUserNewPassCheckAvailable(thisinput){
    
    

    thisinput.parent().next('.form-control-feedback').removeClass('glyphicon-minus').removeClass('glyphicon-remove').removeClass('glyphicon-ok').addClass('glyphicon-refresh').addClass('fa-spin');
    thisinput.closest('.has-feedback').removeClass('has-error').removeClass('has-success');

    delay(function(){
        var pwd1 = $('#newp').val();
        var pwd2 = $('#checknewp').val();
        var patternPass = /^[a-zA-Z0-9]{6,}$/;
        
        if (pwd2==pwd1) { 
            thisinput.closest('.has-feedback').addClass('has-'+'success');
            thisinput.parent().next('.form-control-feedback').removeClass('glyphicon-refresh').removeClass('fa-spin').addClass('glyphicon-ok');
            }
        else {
            thisinput.closest('.has-feedback').addClass('has-error');
            thisinput.parent().next('.form-control-feedback').removeClass('glyphicon-refresh').removeClass('fa-spin').addClass('glyphicon-remove');
        }
    },1000);
      
}



$(document).on('keyup', '#user_pass', function(){
    checkUserPassAvailable($(this));
});
$(document).on('keyup', '#user_pass_check', function(){
    checkUserPassCheckAvailable($(this));
});

$(document).on('keyup', '#newp', function(){
    checkUserNewPassAvailable($(this));
});
$(document).on('keyup', '#checknewp', function(){
    checkUserNewPassCheckAvailable($(this));
});

$(document).on('submit', '#regform', function (event) {
        
    $regform = $(this);
    $regform.data('submitted', false);
    event.preventDefault();
    $('#regresponse').html('');

    var pwd1 = $('#user_pass').val();
    var pwd2 = $('#user_pass_check').val();
    var patternPass = /^[a-zA-Z0-9]{8,}$/;

    if ($('#agree').length && !$('#agree').prop('checked')){
        var transaccept = $('#trans_accept_terms').val();
        $('#regresponse').html('<div class="alert alert-warning" role="alert">'+transaccept+'</div>');
        return false;
    }
    
    if (!patternPass.test(pwd1) || pwd1 !== pwd2) {
        var transerror = $('#trans_pwd_match').val();
        $('#user_pass_check').focus();
        $('#regresponse').html('<div class="alert alert-warning" role="alert">'+transerror+'</div>');
        return false;
    }

	/* if(!checkUserAvailable($('#user_name')))
        {
            $('#regresponse').html('<div class="alert alert-warning" role="alert">用户名填写有误，请重新填写！</div>');
             return false;
        }*/

    $('.mailpreload').fadeIn('fast', function(){

        if ($regform.data('submitted') == false) {
            $regform.data('submitted', true);
            var now = $.now();
            var serial = $("#regform").serialize();
            $.ajax({
                cache: false,
                method: "POST",
                url: "vfm-admin/ajax/usr-reg.php?t=" + now,
                data: serial
            })
            .done(function( msg ) {
                // console.log(msg);
                $('#regresponse').html(msg);
               /* $('#captcha').attr('src', 'vfm-admin/captcha.php?' + now);*/
                $('.mailpreload').fadeOut('slow', function(){
                    $regform.data('submitted', false);
                });
                
            }).fail(function() {
                $('#regresponse').html('<div class="alert alert-danger" role="alert">error connecting user-reg.php</div>');
               /* $('#captcha').attr('src', 'vfm-admin/captcha.php?' + now);*/
                $('.mailpreload').fadeOut('slow', function(){
                    $regform.data('submitted', false);
                });
            });
        }
    });
});

//手机验证码
$(document).on('click','#sendCode',function () {   
/*})*/
/*$('#sendCode').click(function(){ 
 */
    var reg = /^\d{11}$/;
    var re = /(^1[0-9]{10}$)/;
    var mobile = $.trim($("#user_email").val());       
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
    var obj = $(this);

    var time = 60;
    $.ajax({
        url:"vfm-admin/ajax/send.php",
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

 $(document).on('submit', '#usrForm', function(){
        var serial = $("#usrForm").serialize();    
        $('#usrForm').data('success', false);
        
        $.ajax({
            cache: false,
            method: "POST",
            url: "vfm-admin/ajax/sms_code.php",
            data: serial,
            async: false
            })
        .done(function( msg ) {
            console.log(msg);
            $('#refreshresponse').html(msg);
            if (msg == '<div class="alert alert-warning" role="alert"><strong></strong>手机验证成功</div>' ||
                msg == '')
                $('#usrForm').data('success', true);
            
        })
        .fail(function() {
            $('#refreshresponse').html('<div class="alert alert-danger" role="alert">error connecting user-refresh.php</div>');
            $('.mailpreload').fadeOut('slow', function(){
                $('#usrForm').data('submitted', false);
            });
            return false;
        });
        if (!$('#usrForm').data('success'))
            return false;
    });


