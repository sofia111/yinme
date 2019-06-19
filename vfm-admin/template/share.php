<?php
$hasimage = true;
if (file_exists('mysql/MySQL.class.php')) {
	require 'mysql/MySQL.class.php';
}
?>
<script type="text/javascript" src="vfm-admin/js/loadsharefile.js"></script>
<section class="vfmblock tableblock">
	<div >**&nbsp请在下列选择框中选择搜索的学校、专业
	</div>
	<br>
	<div class="form-group">
	    <div class="input-group col-xs-12">
	        <div class="input-group-btn" style="width:25%;">
	            <select name="searchschool" id="searchschool" class="form-control" >
	                <option value="0">全部(学校)</option>
	                <?php 
		                $link = MySQL::getlink();
		                $sql=mysqli_query($link,"select distinct(school) from p_file where share = '1'");
		                $result = mysqli_num_rows($sql);                                      
		                if ($result) {
		                    while ($info=mysqli_fetch_array($sql)) {
		                        echo '<option  value="'.$info['school'].'">'.$info['school'].'</option>';
		                    }
		                }
		            ?> 
	            </select>
	        </div>
	        <div class="input-group-btn" style="width:25%;">
	            <select name="searchmajor" id="searchmajor" class="form-control" style="overflow-y: scroll;">
	                <option value="0">全部(专业)</option>
	                <?php 
		                $sql=mysqli_query($link,"select distinct(major) from p_file where share ='1'");
		                $result = mysqli_num_rows($sql);                           
		                if ($result) {
		                    while ($info=mysqli_fetch_array($sql)) {
		                        echo '<option name="sharemajor" value="'.$info['major'].'">'.$info['major'].'</option>';
		                    }
		                }
		            ?> 
	            </select>
	        </div>
	        <input type="text"  value="" name="keyword" id="keyword" class="form-control" placeholder="请您输入关键词">
	        <span class="input-group-btn">
	            <button class="btn btn-success" id="search_submit" type="submit">Go</button>
	        </span>
	    </div>
    </div>
    <div id="searched">    
    </div>
    </table>
    <button class="sharefiles"><input type="hidden" name="siji" value="siji">四级</button>
    <button class="sharefiles"><input type="hidden" name="liuji" value="liuji">六级</button>
    <script type="text/javascript">
    	/*$(document).on('click','.sharefiles',function () {
    		var e= $(this).children('input').val();
    		console.log(e);
    		// body...
    	})*/
    </script>
</section>
