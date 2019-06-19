   var delay = (function(){
      var timer = 0;
      return function(callback, ms){
        clearTimeout (timer);
        timer = setTimeout(callback, ms);
      };
    })();

window.onload=function () {
    

    //是否为学生，模块是否展示
    var isStudent = document.getElementById("isStudent");
    var oIsdisplay = document.getElementById('Isdisplay');

    isStudent.onchange=function () {
       if(isStudent.value=='否'){
            $("#schoolName>option:first").val(0);
            console.log($("#schoolName>option:first").val());
            $("#academyName>option:first").val(0);
            $("#majorName>option:first").val(0);
           oIsdisplay.style.display="none";          
        }else{
            oIsdisplay.style.display="block";
        }
    }
    
    
    $(function() {
        //ajax查询学院
        $('#schoolName').change(function(){

            var schoolName = encodeURI($('#schoolName').val());
            $.ajax({
                url:"vfm-admin/ajax/get-academy.php",
                type:'post',
                data:{
                    schoolName: schoolName,        
                },
                dataType:"json", 
                success:function(data){
                    // console.log(data);
                    var html = '';
                    var academy = data.academy[0].academyName;
                    fu(academy);
                    for (var i = 0; i < data.academy.length; i++) {
                        
                        html+='<option name="academy">'+data.academy[i].academyName+'</option>';
                    }
                    $('#academyName').html(html);                       
                },
                error: function(){
                    console.log('error');
                }
            });
            
        });

        //专业查询 
        var fu = function(academyName){
            var schoolName = encodeURI($('#schoolName').val());
            // var academyName = encodeURI($('#academyName').val());
            /*console.log('academyName:' + academyName);*/
            $.ajax({
                url:"vfm-admin/ajax/get-major.php",
                type:'post',
                data:{
                    schoolName:schoolName,
                    academyName: academyName,        
                },
                dataType:"json", 
                success:function(data){
                    console.log(data);
                    var html = '';
                    for (var i = 0; i < data.major.length; i++) {                       
                        html+='<option name="major">'+data.major[i].majorName+'</option>';
                    }
                    $('#majorName').html(html);                   
                },
                error: function(){
                    console.log('error');
                }
            });  
        };
        $('#academyName').change(function(){
            fu($('#academyName').val());
        });
    });

    //check the old pass if is right
    $(document).on('change', '#oldp', function(){
        delay(function(){
        $('#oldp').parent().next('.form-control-feedback').removeClass('glyphicon-minus').removeClass('glyphicon-remove').removeClass('glyphicon-ok').addClass('glyphicon-refresh').addClass('fa-spin');
        $('#oldp').closest('.has-feedback').removeClass('has-error').removeClass('has-success');
        var oldpass = encodeURI($('#oldpass').val().trim());
        var oldp = encodeURI($('#oldp').val().trim());
        $.ajax({
            url:"vfm-admin/ajax/check-oldpass.php",
            method: "POST",
            data:{oldpass:oldpass,oldp:oldp}     
            
            })
           /* dataType:"json",*/ 
            .done(function(msg){
                console.log(msg);
                 if (msg == 1) {
                    $('#oldp').closest('.has-feedback').addClass('has-'+'success');
                    $('#oldp').parent().next('.form-control-feedback').removeClass('glyphicon-refresh').removeClass('fa-spin').addClass('glyphicon-ok'); 
                        return true;
                 }
                 else {
                    $('#oldp').closest('.has-feedback').addClass('has-error');
                    $('#oldp').parent().next('.form-control-feedback').removeClass('glyphicon-refresh').removeClass('fa-spin').addClass('glyphicon-remove');         
                 }
            });
        },1000);
    });
}


