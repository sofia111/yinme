<?php
/**
 * VFM - veno file manager: include/list-files.php
 * list files inside current directory
 *
 * PHP version >= 5.3
 *
 * @category  PHP
 * @package   VenoFileManager
 * @author    Nicola Franchini <support@veno.it>
 * @copyright 2013 Nicola Franchini
 * @license   Exclusively sold on CodeCanyon: http://bit.ly/veno-file-manager
 * @link      http://filemanager.veno.it/
 */

/**
* List Files
*/
// if (!defined('SQL_INC') &&
//     file_exists('vfm-admin/include/mysql/MySQL.class.php'))
//     require 'vfm-admin/include/mysql/MySQL.class.php';

// $mysql_conn = MySQL::getConn();
// $sql = "SELECT `page` FROM p_file 
//             WHERE `user`=:user AND `filename`=:filename";
// $query_req[':user'] = $_SESSION['vfm_user_name'];

if ($gateKeeper->isAccessAllowed() && $location->editAllowed()) { 
    if ($encodeExplorer->files) { ?>
    <section class="vfmblock tableblock ghost ghost-hidden">
        <div class="action-group"><!-- class="hidden-xs btn btn-default " -->
            <div style=" width: 100px; line-height: 30px; height: 30px; border: 1px solid #000; text-align: center;float: left;" ><a id="creatorderlist" href="javascript:void(0);"><i class="fa fa-money"></i>&nbsp&nbsp批量下单</a></div>
            <div style=" width: 100px; line-height: 30px; height: 30px; border: 1px solid #000; text-align: center;float: left;" ><a id="wantlist" href="javascript:void(0);"><i class="fa fa-first-order"></i>&nbsp&nbsp跑跑腿</a></div>
            <!--  "  -->
     <!--    <script type="text/javascript">
function copyUrl2()
    {
        var Url2=document.getElementById("copywords").value;
        console.log(Url2);
        var oInput = document.createElement('input');
        oInput.value = Url2;
        document.body.appendChild(oInput);
        oInput.select(); // 选择对象
        document.execCommand("Copy"); // 执行浏览器复制命令
        oInput.className = 'oInput';
        oInput.style.display='none';
        alert('复制成功');
    }
</script>
<input type="visible-xs" id="copywords" value="别人放假花钱，我放假送钱，复制这段文案打开支付宝就能拿到我发的红包噢！uL8MqY4702" />

<input id="HBCopy" type="button" onClick="copyUrl2()" value="点击复制" />   
 -->
            <?php 
            $listdefault = $setUp->getConfig('list_view') ? $setUp->getConfig('list_view') : 'list';
            $listview = isset($_SESSION['listview']) ? $_SESSION['listview'] : $listdefault;

            if ($listview == 'grid') {
                $listclass = 'gridview';
                $switchclass = 'grid';
            } else {
                $listclass = '';
                $switchclass = '';
            } ?>
          <!--   <button class="switchview btn btn-link pull-right <?php echo $switchclass; ?>" title="<?php echo $encodeExplorer->getString("view"); ?>"></button> -->
        </div> <!-- .action-group -->

        <form id="tableform">
            <table class="table <?php echo $listclass; ?>" width="100%" id="sort">
                <thead>
                    <tr class="rowa one">
                        <td class="text-center">
							
                            <a href="javascript:void(0);" title="<?php echo $encodeExplorer->getString("select_all"); ?>" id="selectall">
                                <i class="fa fa-check fa-lg"></i>
                            </a>
                        </td>
                        <td class="icon"></td>
                        <td class="mini h-filename">
                            <span class="visible-xs sorta nowrap">
                                <i class="fa fa-sort-alpha-asc"></i>
                            </span>
                            <span class="hidden-xs sorta nowrap">
                                <?php echo $encodeExplorer->getString("file_name"); ?>
                            </span>
                        </td>
                        <td class="taglia reduce mini h-filesize hidden-xs">
                            <span class="text-center sorta nowrap">
                                <?php echo $encodeExplorer->getString("size"); ?>
                            </span>
                        </td>
                        <td class="reduce mini h-filedate hidden-xs">
                            <span class="text-center sorta nowrap">
                                <?php echo $encodeExplorer->getString("last_changed"); ?>
                            </span>
                        </td>
                    <?php
                    if ($gateKeeper->isAllowed('rename_enable')) { ?>
                        <!-- <td class="mini text-center gridview-hidden hidden-xs">
                            <i class="fa fa-pencil"></i>
                            
                        </td> -->
                    <?php
                    } ?>
					<!-- download -->
                    <?php
                  if ($gateKeeper->isAllowed('rename_enable')) {?>
                        <td class="mini text-center gridview-hidden hidden-xs">
                          <!--   <i class="fa fa-paper-plane"></i> -->
                            下载
                        </td>
                    <?php
                    } ?>

					<!--  share -->
					
					<?php
                    if ($gateKeeper->isAllowed('rename_enable')) { ?>
                        <td class="mini text-center gridview-hidden hidden-xs">
                            <!-- <i class="fa fa-paper-plane"></i> -->
                            分享
                        </td>
                    <?php
                    } ?>
 
					
					<!--  订单表头 -->
					<?php
                    if ($gateKeeper->isAllowed('rename_enable')) { ?>
                       <td class="mini text-center gridview-hidden hidden-xs"> 
                             下单
                        </td> 
                          <!--   <i class="fa fa-money"></i>  -->
                    <?php
                    } ?>
					
								
					
                    <?php 
                    if ($gateKeeper->isAllowed('delete_enable')) {  ?>

                        <td>       
                            <!-- <i class="fa fa-trash-o hidden-xs"></i> -->
                            <span class="mini text-center gridview-hidden hidden-xs">删除</span>
                            <span class="text-center visible-xs">       
                                <!-- <i class="fa fa-trash-o hidden-xs"></i> -->
                                操作 
                            </span>
                        </td>
                    <?php
                    } ?>
                        
                      <!--   <i class="fa fa-cogs visible-xs"></i> -->
                     
					
                    </tr>
                </thead>
                <tbody class="gridbody">
                <?php
                // Display the files
                $alt = $setUp->getConfig('salt');
                $altone = $setUp->getConfig('session_name');
                $hasvideo = false;
                $hasimage = false;
                $hasaudio = false;
                
                foreach ($encodeExplorer->files as $key => $file) {
                    $thisdir = urldecode($encodeExplorer->location->getDir(false, true, false, 0));
                    $thisfile = $file->getName();

                    // 查询文件最大页数
                    // $query_req[':filename'] = $thisfile;
                    // $stmt = $mysql_conn->prepare($sql);
                    // $stmt->execute($query_req);
                    // $res = $stmt->fetchAll();
                    // $maxpage = $res[0]['page'];
                    

                    $thisname = $file->getNameHtml();
                    $fullsize = $file->getSize();
                    $thislink = $encodeExplorer->location->getDir(false, true, false, 0).$file->getNameEncoded();
                    $formatsize = $setUp->formatSize($fullsize);
                    $formattime = $setUp->formatModTime($file->getModTime());
                    $directlinks = $setUp->getConfig('direct_links');
                    $dash = md5($alt.base64_encode($thislink).$altone.$alt);
                    $ext = strtolower(pathinfo($thisfile, PATHINFO_EXTENSION));
                    $withoutExt = preg_replace("/\\.[^.\\s]{2,4}$/", "", $thisfile);
                    $del = $location->getDir(false, true, false, 0).$file->getName();
                    $delquery = base64_encode($del);
                    $cash = md5($delquery.$setUp->getConfig('salt').$setUp->getConfig('session_name'));
                    $thisdel = $encodeExplorer->makeLink(false, $del, $location->getDir(false, true, false, 0));
                    $imgdata = 'data-ext="'.$ext.'"';

                    if ($setUp->getConfig('enable_prettylinks') == true) {
                         $downlink = 'download/'.base64_encode($thislink).'/h/'.$dash;
                        $imgdata .= ' data-name="'.$thisname.'" data-link="'.$thislink
                        .'"';
                    } else {
                         $downlink = 'vfm-admin/vfm-downloader.php?q='.base64_encode($thislink).'&h='.$dash;
                        $imgdata .= ' data-name="'.$thisname.'" data-link="'.$thislink
                        .'"';
                    }
                    $imgdata .= ' data-user="'.$_SESSION['vfm_user_name'].'"';
                    $thisicon = "fa-file-o";
                    
                    $iconkey = strtolower($file->getType());
                    if (array_key_exists($iconkey, $_IMAGES)) {
                        $thisicon = $_IMAGES[$iconkey];
                    }
                    if ($file->isValidForVideo()) {
                        $hasvideo = true;
                        $thisicon = "fa-video-camera";
                    }
                    $gallclass = "";
                    $gallid = "";

                    if ($file->isValidForThumb() || $ext == 'docx' ||$ext == 'doc'||$ext == 'ppt'||$ext == 'pptx'||$ext == 'xls'||$ext == 'xlsx' || $ext == 'png' || $ext == 'jpg') {
                        $hasimage = true;
                        $gallclass = 'gallindex';
                        $gallid = ' id="gall-'.$key.'"';
                    } ?>
                    <tr class="rowa <?php echo $gallclass; ?>" <?php echo $gallid; ?>>
                        <td class="checkb text-center">
                            <div class="checkbox checkbox-primary checkbox-circle">
                                <label class="round-butt" name="">
                                    <input type="checkbox" name="selecta" class="selecta" value="<?php echo base64_encode($thislink); ?>">
                                    <a href="javascript:void(0)" data-thisfile="<?php echo $thisfile; ?>" data-filelink="<?php echo $downlink; ?>" data-thisext="<?php echo $ext; ?>" ></a>
                                </label>
                            </div>
                        </td>
                        <?php
                        // MP3 inline player link
                        if ($file->isValidForAudio() ) { 
                            $hasaudio = true;
                            ?>
                            <td class="icon text-center playme itemicon">
                            <?php
                            if ($setUp->getConfig('enable_prettylinks') == true) {
                                $linkaudio = "download/".base64_encode($thislink)."/h/".$dash;
                            } else {
                                $linkaudio = "vfm-admin/vfm-downloader.php?q=".base64_encode($thislink)."&h=".$dash;
                            } ?>
                        
                            <a type="audio/<?php echo $ext; ?>" class="sm2_button" href="<?php echo $linkaudio; ?>&audio=play">
                                <div class="icon-placeholder">
                                    <div class="cta">
                                        <i class="trackload fa fa-refresh fa-spin fa-lg"></i>
                                        <i class="trackpause fa fa-play-circle-o fa-lg"></i>
                                        <i class="trackplay fa fa-circle-o-notch fa-spin fa-lg"></i>
                                        <i class="trackstop fa fa-play-circle fa-lg"></i>
                                    </div>
                                </div>
                            <?php
                        } else { ?>
                        <td class="icon text-center itemicon">
						<!--javascript:void(0);-->
                            <a href="<?php echo $downlink; ?>"  
                            <?php
                            if ($file->isValidForThumb() || $file->isValidForVideo()) {
                                echo $imgdata;
                            }
                            if ($ext == 'pdf' || $directlinks) {
                                 echo ' target="_blank"';
                            } ?> class="item file 
                            <?php
                            if ($file->isValidForVideo()) {
                                echo ' vid';
                            } ?>
                            <?php 
                            if ($file->isValidForThumb() && $setUp->getConfig('thumbnails')) {
                                echo ' thumb vfm-gall';
                            } ?>
                            <?php
                            if ($ext == 'docx' ||$ext == 'doc'||$ext == 'ppt'||$ext == 'pptx'||$ext == 'xls'||$ext == 'xlsx')
                                echo ' office vfm-gall';
                            ?>">
                            <?php
                            // INLINE THUMBNAILS
                            if ($setUp->getConfig('inline_thumbs') == true) {
                                if ($file->isValidForThumb()) { ?>
                                <div class="icon-placeholder">
                                    <img src="<?php echo $imageServer->showThumbnail($thislink, true);?>">
                                </div>
                                <?php
                                } else { ?>
                                <div class="icon-placeholder">
                                    <div class="cta">
                                        <i class="fa <?php echo $thisicon; ?> fa-lg"></i>
                                    </div>
                                </div>
                                <?php
                                }
                            } else { ?>
                                <div class="icon-placeholder">
                                    <div class="cta">
                                        <i class="fa <?php echo $thisicon; ?> fa-lg"></i>
                                    </div>
                                </div>
                            <?php
                            } 
                        } ?>
                                <div class="hover">
                                    <div>
                                        <div class="round-butt">
                                        <?php
                                        if ($file->isValidForThumb()) { ?>
                                            <i class="fa fa-eye fa-fw"></i>
                                        <?php
                                        } elseif ($file->isValidForVideo()) { ?>
                                           <i class="fa fa-play fa-fw"></i>
                                        <?php
                                        } elseif ($ext == 'pdf') { ?>
                                           <i class="fa fa-external-link fa-fw"></i>
                                        <?php
                                        } elseif ($file->isValidForAudio()) { ?>
                                           <i class="fa fa-play-circle fa-fw"></i>
                                        <?php
                                        } else { ?>
                                            <i class="fa fa-download fa-fw"></i>
                                        <?php
                                        } ?>
                                        </div><br>
                                        <span class="badge">
                                            <strong>
                                                <?php echo $formatsize; ?>
                                            </strong>
                                        </span>
                                    </div>
                                </div>
                            </a>
                            <div class="infopanel">
                                <?php
                                if ($file->isValidForAudio() 
                                    || $file->isValidForThumb()
                                    || $file->isValidForVideo()
                                ) { ?>
                                
                                <?php
                                }
                                if ($gateKeeper->isAllowed('rename_enable') 
                                    && $location->editAllowed()
                                ) { ?>
                                   
								 <div class="minibutt">
								<!--javascript:void(0);-->
                                    <a class="round-butt" href="<?php echo $downlink; ?>" 
                                        <?php if ($directlinks) echo ' target="_blank"'; ?>>
                                        <i class="fa fa-download"></i>
                                    </a>
                                </div>
                                    <div class="icon share text-center minibutt">
                                        <a class="round-butt" href="javascript:void(0)" target="_blank" data-filename="<?php echo $thisfile; ?>" data-username="<?php echo $_SESSION['vfm_user_name']; ?>">
                                            <i class="fa fa-paper-plane"></i>
                                        </a>
                                    </div>  

                                 <?php
                                }						
								//share 平铺订单
                                if ($ext == 'pdf' ||$ext == 'docx' ||$ext == 'doc'||$ext == 'ppt'||$ext == 'pptx'||$ext == 'xls'||$ext == 'xlsx'  
                                ) { ?>
                                    <div class="icon order text-center minibutt">
                                        <a class="round-butt butt-mini" href="javascript:void(0)" data-thisfile="<?php echo $thisfile; ?>" data-filelink="javascript:void(0);<?php //echo $downlink; ?>" data-thisext="<?php echo $ext; ?>">
                                            <i class="fa fa-money"></i>
                                        </a>
                                    </div>
																	
                                <?php
                                } else {?>
									<div class="icon share text-center minibutt">
                                        <a class="round-butt" >
                                        </a>
                                    </div>
								<?php }?>
								
								
								
                                <?php if ($gateKeeper->isAllowed('delete_enable') 
                                    && $location->editAllowed()
                                ) {
                                    $delquery = base64_encode($del);
                                    $cash = md5($delquery.$setUp->getConfig('salt').$setUp->getConfig('session_name')); ?>
                                    <div class="del text-center minibutt">
                                        <a class="round-butt" data-name="<?php echo $thisfile; ?>" href="<?php echo $thisdel; ?>&h=<?php echo $cash; ?>">
                                            <i class="fa fa-trash-o"></i>
                                        </a>
                                    </div>
                                <?php
                                } ?>
                            </div>
                        </td>

                        <td class="name" data-order="<?php echo $thisname; ?>">
                            <div class="relative">
                                <a href="javascript:void(0);<?php //echo $downlink; ?>" 
                                    <?php
                                    if ($file->isValidForThumb() || $file->isValidForVideo() || $ext == 'docx' ||$ext == 'doc'||$ext == 'ppt'||$ext == 'pptx'||$ext == 'xls'||$ext == 'xlsx') {
                                        echo $imgdata;
                                    }
                                    if ($ext == 'pdf' || $directlinks) {
                                        //echo ' target="_blank"';
                                    } ?> class="full-lenght item file 
                                    <?php
                                    if ($file->isValidForThumb() && $setUp->getConfig('thumbnails')) {
                                        echo ' thumb vfm-gall';
                                    } ?>
                                    <?php
                                    if ($file->isValidForVideo()) {
                                        echo ' vid';
                                    } ?>
                                    <?php
                                    if ($ext == 'docx' ||$ext == 'doc'||$ext == 'ppt'||$ext == 'pptx'||$ext == 'xls'||$ext == 'xlsx')
                                        echo ' office vfm-gall';
                                    ?>
                                    "><?php echo $thisname; ?>
                                </a>
                                <div class="grid-item-title"><?php echo $thisname; ?></div>

                                <?php
                                if ($file->isValidForThumb()) { ?>
                                    <span class="hover"><i class="fa fa-eye fa-fw"></i></span>
                                <?php
                                } elseif ($ext == 'pdf') { ?>
                                    <span class="hover"><i class="fa fa-external-link fa-fw"></i></span>
                                <?php
                                } elseif ($file->isValidForVideo()) { ?>
                                    <span class="hover"><i class="fa fa-play fa-fw"></i></span>
                                <?php
                                } else { ?>
                                    <span class="hover"><i class="fa fa-download fa-fw"></i></span>
                                <?php
                                } ?>
                            </div>
                        </td>
						
						<!--  显示文件大小、排序 -->
                        <td class="mini reduce nowrap hidden-xs" data-order="<?php echo $fullsize; ?>">
                            <span class="text-center">
                                <?php echo $formatsize; ?>
                            </span>
                        </td>
						
						<!--  显示文件更改时间、排序 -->
                        <td class="mini reduce hidden-xs nowrap" data-order="<?php echo $file->getModTime(); ?>">
                            <span class="text-center">
                                <?php echo $formattime; ?>
                            </span>
                        </td>
						
                        <?php
                        if ($location->editAllowed()) {
							//<!--  重命名 button -->
                            if ($gateKeeper->isAllowed('rename_enable')) { ?>
                            <!-- <td class="icon rename text-center hidden-xs">
                                <a class="round-butt butt-mini" href="javascript:void(0)" data-thisdir="<?php echo $thisdir; ?>" 
                                    data-thisext="<?php echo $ext; ?>" data-thisname="<?php echo $withoutExt; ?>">
                                    <i class="fa fa-pencil-square-o"></i>
                                </a>
                            </td> -->
                            <?php
                            } ?>
							 <td class="icon text-center hidden-xs">
                                <a class="round-butt butt-mini" href="<?php echo $downlink; ?>" 
                                    <?php
                                    if ($ext == 'pdf' || $directlinks) {
                                        echo ' target="_blank"';
                                    } 
                                    ?>>
                                    <i class="fa fa-cloud-download"></i> 
                                </a>
                            </td> 

							<!-- 分享  -->
							<?php         
							
							if ($ext == 'pdf' ||$ext == 'docx' ||$ext == 'doc'||$ext == 'ppt'||$ext == 'pptx'||$ext == 'xls'|| $ext == 'xlsx' ) { ?>
                            <td class="icon share text-center hidden-xs"><!-- target="_blank" -->
                                <a class="round-butt butt-mini" href="javascript:void(0)"  data-filename="<?php echo $thisfile; ?>" data-username="<?php echo $_SESSION['vfm_user_name']; ?>">
                                    <i class="fa fa-paper-plane"></i>
                                </a>
                            </td>
                            <?php
                            } else {?>
								<td class="icon share text-center hidden-xs">
                                <!-- <span class="round-butt butt-mini" /> -->
                                <i class="glyphicon glyphicon-ban-circle"></i>
                                
                            </td>
							<?php }?>
                            
							
							
							<!--  列表订单 -->
							<?php         
							
							if ($ext == 'pdf' ||$ext == 'docx' ||$ext == 'doc'||$ext == 'ppt'||$ext == 'pptx'||$ext == 'xls'||$ext == 'xlsx' || $ext == 'png' || $ext == 'jpg' ) { ?>
                            <td class="icon order text-center hidden-xs">
                                <a class="round-butt butt-mini" href="javascript:void(0)" data-thisfile="<?php echo $thisfile; ?>" data-filelink="javascript:void(0);<?php //echo $downlink; ?>" data-thisext="<?php echo $ext; ?>">
                                    <i class="fa fa-money"></i>
                                </a>
                            </td>
                            <?php
                            } else {?>
								<td class="icon share text-center hidden-xs">
                                <i class="glyphicon glyphicon-ban-circle"></i>
                                
                            </td>
							<?php }?>
                            <td class="text-center">							
														
							<!--  删除 button -->
                            <?php
                            if ($gateKeeper->isAllowed('delete_enable')) { ?>
                                <div class="del hidden-xs">
                                    <a class="round-butt butt-mini" data-name="<?php echo $thisfile; ?>" href="<?php echo $thisdel; ?>&h=<?php echo $cash; ?>">
                                        <i class="fa fa-times"></i>
                                    </a>
                                </div>
                            <?php
                            } ?>						
                                <div class="dropdown visible-xs">
                                    <a class="round-butt butt-mini dropdown-toggle" data-toggle="dropdown" href="javascript:void(0);">
                                        <i class="fa fa-cog"></i>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-right">
                                       <!--  <li>
                                            <a href="<?php echo $downlink; ?>" 
                                                <?php
                                                if ($ext == 'pdf' || $directlinks) {
                                                    echo ' target="_blank"';
                                                } 
												?>>
                                                <i class="fa fa-cloud-download"></i> 
                                                <?php echo $encodeExplorer->getString("download"); ?>
                                            </a>
                                        </li> -->
                                    <?php
                                    if ($gateKeeper->isAllowed('rename_enable')) { ?>
                                        <!-- <li class="rename">
                                            <a href="javascript:void(0)" 
                                                data-thisdir="<?php //echo $thisdir; ?>" 
                                                data-thisname="<?php //echo $withoutExt; ?>">
                                                <i class="fa fa-edit"></i> 
                                                <?php //echo $encodeExplorer->getString("rename"); ?>
                                            </a>
                                        </li> -->
                                    <?php
                                    }
                                    if ($gateKeeper->isAllowed('delete_enable')) { ?>
                                        <li class="del">
                                            <a href="<?php echo $thisdel; ?>&h=<?php echo $cash; ?>" data-name="<?php echo $thisfile; ?>">
                                                <i class="fa fa-trash-o"></i> 
                                                <?php echo $encodeExplorer->getString("delete"); ?>
                                            </a>
                                        </li>
									<!--share-->
									<?php
                                    }
                                    if ($ext == 'pdf' ||$ext == 'docx' ||$ext == 'doc'||$ext == 'ppt'||$ext == 'pptx'||$ext == 'xls'||$ext == 'xlsx' || $ext == 'png' || $ext == 'jpg' ) { ?>
                                        <li class="share"><!-- target="_blank" -->
                                            <a href="javascript:void(0)"  data-filename="<?php echo $thisfile; ?>" data-username="<?php echo $_SESSION['vfm_user_name']; ?>">
                                                <i class="fa fa-paper-plane"></i> 
                                                <?php echo $encodeExplorer->getString("share"); ?>
                                            </a>
                                        </li>
									<!--下拉订单-->
                                        <li class="order">
                                            <a class="butt-mini" href="javascript:void(0)" data-thisfile="<?php echo $thisfile; ?>" data-filelink="javascript:void(0);<?php //echo $downlink; ?>" data-thisext="<?php echo $ext; ?>">
                                                <i class="fa fa-money"></i>
                                                <?php echo $encodeExplorer->getString("xiadan"); ?>
                                            </a>
                                        </li>										
                                    <?php
                                    } else {?>
										 <li class="share">
                                            
                                        </li>
									<?php
                                    } ?>
                                  </ul>
                                </div>
                            </td>
                        <?php
                        } ?>
                        </tr>
                    <?php
                } ?>
                    </tbody>
                </table>
               
            </form>
            <!-- <div  class="text-center"> --><!-- type="button" -->
        </section>
            <!-- <div style="text-align: center; font-size: 20px; width: 50%;height:50px;line-height: 50px;position:fixed;left:0px;bottom:0px;background:#448AFF;z-index: 1;border-right:solid 1px #fff; " class="visible-xs "><a id="creatorderlist" href="javascript:void(0);" ><span style="color: #fff;"><i class="fa fa-money"></i>&nbsp&nbsp批量下单</a></span></div> -->
<!-- type="button" -->

            
       
       <!--  </div> -->

    <?php
    } else { 
        // end if files, show big icon for empty folders
        ?>
        <section class="vfmblock tableblock text-center lead hidetable">
            <span class="fa-stack fa-4x alpha-light">
                <i class="fa fa-circle-thin fa-stack-2x"></i>
                <?php
                // show upload icon
                if ($gateKeeper->isAllowed('upload_enable')) { 
                    echo '<i class="fa fa-cloud-upload fa-stack-1x"></i>';
                } else {
                    echo '<i class="fa fa-folder-open fa-stack-1x"></i>';
                } ?>
            </span>
        </section>
        <?php
    }
} // end access allowed
