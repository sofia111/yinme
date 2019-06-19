
<div class="row">
    <div class="col-md-12">
        <div class="box box-default box-solid">
            <div class="box-header with-border">
                <strong>意见反馈</strong>
            </div>
            <div class="box-body">
                <div class="table-responsive">
                        
                        <table class="table table-hover table-condense" id="data-shops">
                        <thead>
                            <tr>
                                <th><span class="nowrap">ID</span></th>
                                <th><span class="nowrap">意见</span></th>                              
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $link = MySQL::getlink();
                        $sql = "select * from suggestion order by suggestion desc";
						$result = $link->query($sql);
                        $i=0;
						if ($result->num_rows > 0) {
						    while($row = $result->fetch_assoc()) {
						        $i++;
	                    ?>
	                            <tr>
	                            	<td><?php echo $i; ?></td>
	                                <td><?php echo $row["suggestion"]; ?></td>
	                            </tr>
	                    <?php
                        	}
                     	} else{
                         	echo '<div>没有反馈</div>'; 
                        }?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>