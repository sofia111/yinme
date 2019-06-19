
<section class="vfmblock">
    <div class="panel panel-default">
        <div class="panel-body">
            <?php  echo $encodeExplorer->getString("order_statu");?>
        </div>
    </div>
    <?php 
         if (file_exists('mysql/MySQL.class.php')) {
    require 'mysql/MySQL.class.php';
}
        $link = MySQL::getlink();
       
        $sql=mysqli_query($link,"select * from print where `user` ='".$_SESSION['vfm_user_name']."' and `is_temp`=0");
        $result = mysqli_num_rows($sql);
        $orderlist=0;
        if ($result) {
            
        echo '
        <div class="vfmblock tableblock ghost"> 
            <form  id="tableform" >
                <table class="table" width="100%">
                    <thead>  
                        <tr class="rowa one" > 
                            <td class="taglia mini  text-center header">
                                <span class="text-center nowrap">单号</span>
                            </td> 
                             <td class=" text-center mini gridview-hidden hidden-xs header">     <span class="text-center nowrap">份数</span>
                            </td> 
                             <td class="mini  text-center h-filename" >
                                <span class="visible-xs sorta nowrap"> <i class=" fa fa-sort-alpha-asc"></i>
                                </span>
                                <span class="hidden-xs sorta nowrap">文件名</span>
                            </td>
                             <td class=" text-center mini  gridview-hidden   hidden-xs header">
                                <span class="text-center nowrap">商家</span>
                            </td>
                            <td class=" text-center mini gridview-hidden hidden-xs header">     <span class="text-center nowrap">页数</span>
                            </td>      
                             
                            <td  class=" text-center gridview-hidden mini hidden-xs header">     <span class="text-center nowrap">装订</span>
                            </td> 
                            <td class=" text-center mini ">
                                <span class="text-center nowrap">价格</span>
                            </td>               
                            <td class=" text-center mini">
                                <span class="text-center nowrap">状态</span>
                            </td>
                              <td class=" text-center mini  gridview-hidden sorting_disabled ">
                                <span class="text-center nowrap hidden-xs">备注</span>
                                <span class="text-center nowrap visible-xs">详情</span>
                            </td>                          
                        </tr>                            
                    </thead>
                    <tbody class="gridbody">
                        <tr class="rowa">';
            while($info=mysqli_fetch_array($sql))
                {
                    $orderlist++;
                   
                    echo '<td class="text-center">'.$info['order'].'</td>';
                     echo '<td class=" mini hidden-xs text-center">'.$info['copies'].'</td>';
                     echo '<td class="name  text-center"><a class="  text-center  item file">'.$info['filename'].'</td>';
                     echo '<td class=" mini hidden-xs text-center">'.$info['shop'].'</td>';
                    echo '<td class=" mini hidden-xs text-center">'.$info['range'].'</td>';
                   
                    echo '<td class="mini hidden-xs  text-center">'.$info['side'].'</td>';
                    echo '<td class="text-center">'.$info['price'].'</td>';
                   echo '<td class="text-center">'.$info['state'].'</td>';

                    echo '<td class=" text-center"> <div class="hidden-xs text-center mini dropdown">
                       <a class="round-butt butt-mini dropdown-toggle" data-toggle="dropdown">
                              <span class="caret"><span>
                              </a>
                              <ul class="dropdown-menu dropdown-menu-right">
                              <li><span>备注:</span>'.$info['remarks'].'</li>
                              </ul>';

                        
                    echo  '</div><div  class="dropdown visible-xs ">
                              <a class="round-butt butt-mini dropdown-toggle" data-toggle="dropdown">
                              <span class="caret"><span>
                              </a>
                              
                              <ul class="dropdown-menu dropdown-menu-right">
                              <li><span>商家:</span>'.$info['shop'].'</li>
                              <li><span>装订:</span>'.$info['bind'].'</li>
                              <li><span>单双面:</span>'.$info['side'].'</li>
                              <li><span>份数:</span>'.$info['copies'].'</li>
                              <li><span>备注:</span>'.$info['remarks'].'</li>
                              </ul>
                          </div>
                          </td>
                          </tr>

                    ';
                }
                echo "</tbody></table></form></div>";
        }
        else{
            echo '<div style="text-align: center;">'.$encodeExplorer->getString("no_order")."</div></section>";
        }
    ?> 
</section>