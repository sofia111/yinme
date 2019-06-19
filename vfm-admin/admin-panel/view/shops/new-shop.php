
<div class="col-sm-6">
    <button class="btn btn-info btn-lg btn-block" data-toggle="modal" data-target="#newshoppanel">
        <i class="fa fa-user-plus"></i>派单业务
    </button>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="newshoppanel">
  <div class="modal-dialog">
    <div class="modal-content">
        <form role="form" method="post" autocomplete="off" 
        action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>?shops=new" 
        class="clear intero" enctype="multipart/form-data" id ="newShopForm">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">
                    <i class="fa fa-first-order"></i>发布跑跑腿派单业务
                </h4>
            </div>
              <div class="modal-body">
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <div class="input-group">
                                <span class="input-group-addon">
                                   商家平台 
                                </span>
                                <input type="text" class="form-control addme" name="shopschool"  
                                placeholder="*">
                            </div>
                        </div>
                        <div class="col-md-6 form-group">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    目的地
                                </span>
                                <input type="text" class="form-control addme" name="shopname"
                                placeholder="*">
                            </div>
                        </div>
                    </div> <!-- row -->
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    配送时间
                                </span>
                                <input type="text" class="form-control addme" name="shopschool" 
                                placeholder="*">
                            </div>
                        </div>
                        <div class="col-md-6 form-group">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    配送订单(份)
                                </span>
                                <input type="text" class="form-control addme" name="shopname"
                                placeholder="*">
                            </div>
                        </div>
                    </div>
                    
                     <div class="row">
                        <div class="col-md-6 form-group">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    获得印币
                                </span>
                                <input type="text" class="form-control addme" name="shopschool"
                                placeholder="*">
                            </div>
                        </div>
                        
                    </div>
                    
                </div>
                <span class="input-group-btn">
                                <button class="btn btn-primary" id="ee">
                                    发布配送单
                                </button>
                            </span>
            </div>
                 
        </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script type="text/javascript">
$(document).on('click','#ee',function () {
    $('#newshoppanel').modal('hide');
  /* alert('发布成功！');*/
 $('#data-shops tbody').append('<tr><td>长理图书馆打印</td><td>敏行轩</td><td>12：00pm前</td><td>6</td><td>1.8</td></tr>')
})
</script>