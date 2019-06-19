<?php
function setWater($imgSrc,$markImg)
{
	$srcInfo = @getimagesize($imgSrc);
	$srcim =imagecreatefrompng($imgSrc);
	$srcImg_w  = $srcInfo[0];
	$srcImg_h  = $srcInfo[1];
	$markImgInfo = @getimagesize($markImg);
    $logow  = $markImgInfo[0];
    $logoh  = $markImgInfo[1];
    $markim =imagecreatefrompng($markImg); 
	$dst_img = @imagecreatetruecolor($srcImg_w, $srcImg_h);
	imagecopy ( $dst_img, $srcim, 0, 0, 0, 0, $srcImg_w, $srcImg_h); 
	//销毁印么LOGO
	imagedestroy($srcim);
	imagecopy($dst_img, $markim, ($srcImg_w - $logow) / 2, ($srcImg_h - $logoh) / 2, 0, 0, $logow, $logoh);
	imagecopy($dst_img, $markim, 5, 5, 0, 0, $logow, $logoh);
	imagecopy($dst_img, $markim, $srcImg_w - $logow - 5, $srcImg_h - $logoh -5, 0, 0, $logow, $logoh);
	imagedestroy($markim);
	//缩放50%
	$image = imagecreatetruecolor($srcImg_w*0.5,$srcImg_h*0.5);
	imagecopyresampled( $image,$dst_img, 0, 0, 0, 0, $srcImg_w*0.5, $srcImg_h*0.5, $srcImg_w, $srcImg_h);
	imagedestroy($dst_img);
	//以JPG形式输出 质量为66 减少带宽使用
	header('Content-Type: image/jpeg');
	imagejpeg($image,NULL,66);
	imagedestroy($image);	
}
if(!isset($_GET["src"]))
	echo '你好，这是印么分享文件预览服务器的主页！出现此页代表你比较调皮。--印么';
else{
	if(file_exists('C:\\p\\'.$_GET['src'].'.png'))setWater('C:\\p\\'.$_GET['src'].'.png',"./images/y.png");
	else echo '你想干啥？？？还想看我服务器其他图片啊？！--印么';
}
?>