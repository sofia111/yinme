 <?php   

//if (file_exists('.././vfm-admin/include/mysql/MySQL.class.php')) {
 //   require '.././vfm-admin/include/mysql/MySQL.class.php';
//}
 ?><hr>

 <div class="row">
    <div class="col-md-12">
        <div class="box box-default box-solid">
            <div class="box-header with-border">
                <strong>新的派单</strong>
            </div>
            <div class="box-body">
                <div class="table-responsive">                  
                        <table class="table table-hover table-condense" id="data-shops">
                        <thead>
                            <tr>
                                <th><span class="sorta nowrap">商家平台</span></th>
                                <th><span class="sorta nowrap">目的地</span></th>
                                <th><span class="sorta nowrap">配送时间</span></th>
                                <th><span class="sorta nowrap">订单</span></th>
                                <th><span class="nowrap">获得印币</span></th>					
                            </tr>
                        </thead>
                        <tbody>
                             <tr> 
                                <td>弘一电信文印室</td>
                                <td>行健轩一</td>
                                <td>12:00am前</td>
                                <td>5</td>
                                 <td>2.0</td>
                            </tr>
                             <tr>
                            <td>弘一电信文印室</td>
                            <td>至诚轩二</td>
                            <td>6:00pm前</td>
                            <td>4</td>
                             <td>0.8</td>
                        </tr>
                        <tr>
                            <td>西门图文打印</td>
                            <td>行健轩四</td>
                            <td>12:00pm前</td>
                            <td>6</td>
                             <td>3.0</td>
                        </tr>
                        </tbody>
                    </table>
                    <ul>
                        
                    </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 
<!-- <script type="text/javascript" src="js/datatables.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    $('#data-shops').DataTable({
        dom        : 'flprtip',
        lengthMenu : [[25, 50, 100], [25, 50, 100]],
        order      : [[ 0, 'desc' ]], // Sort by first column descending
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




 -->