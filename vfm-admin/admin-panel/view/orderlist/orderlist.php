<!-- 
 * @File:   orderlist.php
 * @Author: Sofia
 * @Email:  1506798421@qq.com
 * @Date:   2018-08-22 16:30:33
 * @Comment: 订单管理文件
 */ -->

<hr>
<div class="row">
    <div class="col-md-12">
            <h4>查询条件</h4><span style="color: red;" id="error"></span>
            <div class="input-group" >
                <div class="input-group-btn">
                    <select class="form-control " id="seaschool">
                        <option value="0">全部(学校)</option>
                        <?php 
                        $get_conn=MySQL::getConn();
                        $sql="SELECT DISTINCT(`school`) FROM shop";
                        $stmt = $get_conn->query($sql);
                        foreach ($stmt as $key ) {
                            echo '<option value="'.$key['school'].'">'.$key['school'].'</option>';
                        }
                         ?>
                    </select>
                </div>
                 <div class="input-group-btn">
                    <select class="form-control" id="seashop" >
                        <option value="0">全部(商家)</option>
                        <?php 
                        $sql="SELECT DISTINCT(`name`) FROM shop";
                        $stmt = $get_conn->query($sql);
                        foreach ($stmt as $key ) {
                            echo '<option value="'.$key['name'].'">'.$key['name'].'</option>';
                        }
                         ?>
                    </select>
                </div>
            </div>
            <div class="input-group">
                <span class="input-group-addon">日期</span>
                <input type="text" name="starttime" class="form-control" placeholder="请输入开始日期,格式如：2018-8-20" id="starttime"  required>
                <input type="text" name="endtime" class="form-control" placeholder="请输入结束日期，格式如：2018-8-21" id="endtime"  required>
                <input type="button" style="background:#eee" class="form-control" id="orderCheck" value="查询" >
            </div><br>
        <div class="box box-default box-solid">
            <div class="box-header with-border">
                <strong>订单管理</strong>
            </div>
            <div id="searched_order">
            <div id="listDisplay">

            <div class="box-body">
                <div class="table-responsive" >                   
                     <table id="data-orderlist" class="table table-hover table-condense">
                    <thead>
                    <tr> 
                        <th><span class="sorta nowrap">编号</span></th>
                        <th><span class="sorta nowrap">单号</span></th>
                        <th><span class="sorta nowrap">文件</span></th>
                        <th><span class="sorta nowrap">商家</span></th>
                        <th><span class="sorta nowrap">学校</span></th>
                        <th><span class="sorta nowrap">价格</span></th>
                        <th><span class="sorta nowrap">免配送费</span></th>
                        <th><span class="sorta nowrap">折扣优惠</span></th>
                        <th><span class="sorta nowrap">印币抵现</span></th>
                        <th><span class="sorta nowrap">日期</span></th>
                    </tr>   
                    </thead>
                    <tbody id="orderlistbody">
                     
                    <?php 
                        $mysql_conn=MySQL::getConn();
                        $sql_data = [':is_temp' =>'0'];
                        $sql = "SELECT `order`,`filename`,`shop`,`school`,`price`,`free_delivery`,`discount`,`yinbi`,Date(`time`) FROM print WHERE `is_temp` =:is_temp ORDER BY `time` DESC ";
                        $stmt = $mysql_conn->prepare($sql);
                        $stmt->execute($sql_data);
                        $res_arr = $stmt->fetchAll();
                        $i=0;
                       
                        if (!empty($res_arr)) {
                            foreach ($res_arr as $key => $value) {
                                $i++;

                    ?>               
                                <tr>
                                <td><?php echo $i; ?></td> 
                                <td><?php echo $value[0]; ?></td><!--订单 -->
                                <td><?php echo $value[1]; ?></td><!-- 文件名 -->
                                <td><?php echo $value[2]; ?></td><!-- 商家 -->
                                <td><?php echo $value[3]; ?></td><!-- 学校 -->
                                <td><?php echo $value[4]; ?></td><!-- 价格 -->
                                <td><?php echo $value[5]; ?></td> <!-- 免配送费 -->
                                <td><?php echo $value[6]; ?></td><!-- 折扣优惠 -->
                                <td><?php echo $value[7]; ?></td><!-- 印币抵现 -->
                                <td><?php echo $value[8]; ?></td>
                                </tr> 
                                
                    <?php  
                            if ($value[4] !='批量'){
                                $sum += floatval($value[4]);
                                $free_delivery +=floatval($value[5]);
                                $discount +=floatval($value[6]);
                                $yinbi +=floatval($value[7]);
                                }
                            }                           
                        }
                    ?>          
                        </tbody>
                    </table>

                </div>
            </div>
			<div class="input-group" id="earn">
				<span class="input-group-addon" style="font-weight: bold; ">交易金额</span>
				<input type="text" id="sum"  class="form-control" placeholder="收入" readonly required value="<?php echo $sum ?>">
				<span class="input-group-addon"  style="font-weight: bold; ">免配送费</span>
				<input type="text"  class="form-control" placeholder="免配送费" readonly id="dedu_money" required value="<?php echo $free_delivery ?>">
                <span class="input-group-addon"  style="font-weight: bold; ">折扣优惠</span>
                <input type="text"  class="form-control" placeholder="折扣优惠" readonly id="discount_money" required value="<?php echo $discount ?>">
                <span class="input-group-addon"  style="font-weight: bold; ">印币抵现</span>
                <input type="text"  class="form-control" placeholder="印币抵现" readonly id="yinbi_money" required value="<?php echo $yinbi ?>">
			
			</div>
            </div>
        </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="js/datatables.min.js"></script>
<style type="text/css">
   #seaschool,#seashop{
        width:100%;
        padding:3px 10px;
        border-top-left-radius: 5px;
        border-bottom-left-radius: 5px;
    }  
</style>
<script type="text/javascript">


//订单管理查询

$(document).on('click','#orderCheck',function(){
   
    var seaschool = encodeURI($('#seaschool').val());
    var seashop = encodeURI($('#seashop').val());
    var starttime = encodeURI($('#starttime').val().trim());
    var endtime = encodeURI($('#endtime').val().trim());

    var a = /^(\d{4})-(\d{2})-(\d{2})$/;
    if (!a.test(starttime)){
        $('#starttime').focus();
        $('#error').html('时间格式有误,格式：0000-00-00');
        return false;
    }
    if (!a.test(endtime)) {
        $('#endtime').focus();
        $('#error').html('时间格式有误,格式：0000-00-00');
        return false;
    }
  
    var time1 = new Date(endtime.replace("-", "/").replace("-", "/"));
    var time2 = new Date(starttime.replace("-", "/").replace("-", "/"));
    if (time1<time2) {
		 $('#endtime').focus();
        $('#error').html('结束时间应>=开始时间')
        return false;
    }
    $('#error').css('display','none');
    $.ajax({
        cache: false,
        url: "ajax/orderlistfile.php",
        type: "POST",
        data: {
            seaschool:seaschool,
            seashop:seashop,
            starttime:starttime,
            endtime:endtime
            },     
            dataType:"json",
            async: false,
            success:function(data){
                 console.log(data);
                var html ='<div class="box-body">'+
                '<div class="table-responsive"  >'+                   
                     '<table  id="data-orderlistsearch" class=" table table-hover table-condense">'+
                    '<thead>'+
                    '<tr>'+ 
                        '<th><span class="sorta nowrap">编号</span></th>'+
                        '<th><span class="sorta nowrap">单号</span></th>'+
                        '<th><span class="sorta nowrap">文件</span></th>'+
                        '<th><span class="sorta nowrap">商家</span></th>'+
                        '<th><span class="sorta nowrap">学校</span></th>'+
                        '<th><span class="sorta nowrap">价格</span></th>'+
                        '<th><span class="nowrap">免配送费</span></th>'+
                        '<th><span class="nowrap">折扣优惠</span></th>'+
                        '<th><span class="nowrap">印币抵现</span></th>'+
                        '<th><span class="nowrap">日期</span></th>'+
                    '</tr>'+   
                    '</thead>'+
                    '<tbody  >';
                if (data.status==1) {
                    var allprice = 0;
                    var alldelivery = 0;
                    var alldiscount = 0;
                    var allyinbi = 0;
                    for (var i = 0; i < data['data'].length; i++) {
                       html+='<tr><td>'+i+'</td>'+
                       '<td>'+data['data'][i].order+'</td>'+
                              '<td>'+data['data'][i].filename+'</td>'+
                              '<td>'+data['data'][i].shop+'</td>'+
                              '<td>'+data['data'][i].school+'</td>'+
                              '<td>'+data['data'][i].price+'</td>'+
                              '<td>'+data['data'][i].free_delivery+'</td>'+
                              '<td>'+data['data'][i].discount+'</td>'+
                              '<td>'+data['data'][i].yinbi+'</td>'+
                              '<td>'+data['data'][i].time+'</td></tr>';
                              if (data['data'][i].price !='批量'){
                                allprice +=parseFloat(data['data'][i].price);
                                alldelivery +=parseFloat(data['data'][i].free_delivery);
                                alldiscount +=parseFloat(data['data'][i].discount);
                                allyinbi +=parseFloat(data['data'][i].yinbi);
                                
                              } 

                             // if( data['data'][i].free_delivery !='批量' && data['data'][i].free_delivery !=null) {
                             //   console.log(parseFloat(data['data'][i].free_delivery));
                             // }
                                
                             }
                    html+='</tbody>'+
                    '</table></div></div>'+
                    '<div class="input-group">'+
                        '<span class="input-group-addon" style="font-weight: bold; ">交易金额</span>'+
                        '<input type="text"  class="form-control" placeholder="收入" readonly required value="'+allprice+'">'+
                        '<span class="input-group-addon"  style="font-weight: bold; ">免配送费</span>'+
                        '<input type="text" class="form-control" placeholder="免配送费" readonly required value="'+alldelivery+'"></div>'+
                        '<span class="input-group-addon"  style="font-weight: bold; ">折扣优惠</span>'+
                        '<input type="text" class="form-control" placeholder="折扣优惠" readonly required value="'+alldiscount+'">'+
                        '<span class="input-group-addon"style="font-weight: bold; ">印币抵现</span>'+
                        '<input type="text"class="form-control"placeholder="印币抵现" readonly required value="'+allyinbi+'"></div>';
                    
                    $('#listDisplay').hide();
                    $('#searched_order').html(html);
                }
               else{
                $('#listDisplay').hide();
                $('#searched_order').html('<div class="text-center">无订单,请重新搜索</div>');
               }
            },
            error:function(data){
              console.log(data);
                console.log('error');

            }
        });
    r();
});
var r= function() {
    $('#data-orderlistsearch').DataTable({
        dom        : 'flprtip',
        lengthMenu : [[25, 50, 100], [25, 50, 100]],
        order      : [[ 0, 'asc' ]], // Sort by first column descending
        language : {
            emptyTable     : '--',
            info           : '_START_-_END_ / _TOTAL_ ',
            infoEmpty      : '',
            infoFiltered   : '',
            infoPostFix    : '',
            lengthMenu     : ' _MENU_',
            loadingRecords : '<i class="fa fa-refresh fa-spin"></i>',
            processing     : '<i class="fa fa-refresh fa-spin"></i>',
            search         : '<span class="input-group-addon"><i class="fa fa-search"></i></span> ',
            zeroRecords    : '--',
            paginate : {
                first    : '<i class="fa fa-angle-double-left"></i>',
                last     : '<i class="fa fa-angle-double-right"></i>',
                previous : '<i class="fa fa-angle-left"></i>',
                next     : '<i class="fa fa-angle-right"></i>'
            }
        },
        columnDefs : [ 
            { 
                targets : [ 0, 1, 3 ], 
                searchable : false
            },
            { 
                targets : [ 5, 6, 7 ], 
                orderable  : false,
                searchable : false
            }
        ]

    });
};

 
    $(document).ready(function() {
    $('#data-orderlist').DataTable({
        dom        : 'flprtip',
        lengthMenu : [[25, 50, 100], [25, 50, 100]],
        order      : [[ 0, 'asc' ]], // Sort by first column descending
        language : {
            emptyTable     : '--',
            info           : '_START_-_END_ / _TOTAL_ ',
            infoEmpty      : '',
            infoFiltered   : '',
            infoPostFix    : '',
            lengthMenu     : ' _MENU_',
            loadingRecords : '<i class="fa fa-refresh fa-spin"></i>',
            processing     : '<i class="fa fa-refresh fa-spin"></i>',
            search         : '<span class="input-group-addon"><i class="fa fa-search"></i></span> ',
            zeroRecords    : '--',
            paginate : {
                first    : '<i class="fa fa-angle-double-left"></i>',
                last     : '<i class="fa fa-angle-double-right"></i>',
                previous : '<i class="fa fa-angle-left"></i>',
                next     : '<i class="fa fa-angle-right"></i>'
            }
        },
        columnDefs : [ 
            { 
                targets : [ 0, 1, 3 ], 
                searchable : false
            },
            { 
                targets : [ 5, 6, 7 ], 
                orderable  : false,
                searchable : false
            }
        ]

    });
});
</script>