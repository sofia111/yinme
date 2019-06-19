/*$(function(){
	$.ajax({
		cache: false,
		type:'POST',
		url:'vfm-admin/ajax/loadsharefile.php',
		data:{}
		dataType:"json",
		async: false,
		success:function(data){
                 console.log(data);
                var html ='<table class="table table-striped">'+
                            '<thead>'+
                            '<tr>'+
                                '<th>编号</th>'+
                                '<th>文件名</th>'+
                                '<th>预览</th>'+
                                '<th>上传时间</th>'+
                                '<th>打印</th>'+
                            '</tr>'+   
                            '</thead>'+
                            '<tbody id="filebody">'+      
                            '</tbody>';
                if (data.status==1) {
                    for (var i = 0; i < data['data'].length; i++) {
                        var imgdata = 'data-ext="' + data['data'][i].ext + '"';
                        imgdata += ' data-name="' + data['data'][i].filename + '"';
                        imgdata += ' data-user="'+data['data'][i].username + '"';
                        imgdata += ' data-link="'+data.link+'/'+data['data'][i].username+'/'+encodeURI(data['data'][i].filename)+ '"';
                        if (data['data'][i].ext == "pdf") 
                            imgdata += ' class="thumb vfm-gall"';
                        else if (data['data'][i].ext == 'docx' ||
                            data['data'][i].ext == 'doc'||
                            data['data'][i].ext == 'ppt'||
                            data['data'][i].ext == 'pptx'||
                            data['data'][i].ext == 'xls'||
                            data['data'][i].ext == 'xlsx')
                            imgdata += ' class="office vfm-gall"';
                        html+='<tr><td>'+(i+1)+'</td>'+
                        '<td>'+decodeURI(data['data'][i].filename)+'</td>'+
                        '<td><a href="javascript:void(0);" '+imgdata+'>预览'+'</a></td>'+
                        '<td>'+data['data'][i].time+'</td>'+
                        '<td><a href="javascript:void(0);" id="createord" data-thisfile="'+ decodeURI(data['data'][i].filename) +
                         '" data-thisext="'+data['data'][i].ext+'" data-username="'+
                         data['data'][i].username+'">打印</a></td>'+
                        '</tr>';
                    }
                    $('#searched').html(html);
                }
		},
		error:function(msg){
			console.log(msg);
			console.log("error");
		}
	});
});*/