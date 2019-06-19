<?php

/**
 * @File:   pdf.php
 * @Author: Alan_Albert
 * @Email:  1766447919@qq.com
 * @Date:   2018-07-26 08:33:44
 * @Last Modified by:   Alan_Albert
 * @Last Modified time: 2018-07-27 13:13:55
 * @Comment: 
 */
define('PDF_INC', true);

function getPageNumFromPdf($file)
{
    if (!file_exists($file)){
        echo "file(", $file, ") not exists";
        return false;
    }
    if (!$fp = @fopen($file,"r")) {
        echo "open file(", $file, ") faild";
        return false;
    }
    $page = 0;
    while(!feof($fp)) {
        $line = fgets($fp,255);
        if (preg_match('/\/Count [0-9]+/', $line, $matches)){
            preg_match('/[0-9]+/',$matches[0], $matches2);
            if ($page<$matches2[0]) $page=$matches2[0];
        }
    }
    fclose($fp);
    return $page;
}


// /**
//  * PDF转PNG图片（require: ImageImagick, PHP imagick扩展, Ghostscript）
//  * @param  String $pdf_path   pdf文件路径
//  * @param  String $output_dir png图片保存目录
//  * @return array             结果数组
//  */
// function pdf2png($pdf_path, $output_dir)
// {
//    if(!extension_loaded('imagick')){
//        return false;
//    }
//    if(!file_exists($pdf_path)){
//        return false;
//    }
//    $IM = new imagick();
//    $IM->setResolution(120,120);
//    $IM->setCompressionQuality(100);
//    $IM->readImage($pdf_path);
//    foreach ($IM as $Key => $Var){
//        $Var->setImageFormat('png');
//        $file = md5($Key.time()).'.png';
//        if($Var->writeImage($output_dir.'/'.$file) == true){
//            $Return[] = $file;
//        }
//    }
//    return $Return;
// }