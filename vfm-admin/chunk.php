<?php
/**
 * VFM - veno file manager: chunk.php
 *
 * Resumable uploads
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
if (!defined('SQL_INC') && 
    file_exists('include/mysql/MySQL.class.php'))
    require 'include/mysql/MySQL.class.php';
if (!defined('PDF_INC') &&
    file_exists('include/pdf/pdf.php'))
    require 'include/pdf/pdf.php';
require '../vendor/autoload.php';
require 'include/pdf/XrefParser.php';
require 'config.php';
session_name($_CONFIG["session_name"]);
session_start();
require 'users/users.php';
require 'class.php';

$timeconfig = $_CONFIG['default_timezone'];
$timezone = (strlen($timeconfig) > 0) ? $timeconfig : "UTC";
date_default_timezone_set($timezone);

// 连接数据库
$mysql_conn = MySQL::getConn();

$chunk = new Chunk();
$encodeExplorer = new EncodeExplorer();


if (isset($_SESSION['lang'])) {
    $lang = $_SESSION['lang'];
} else {
    $lang = SetUp::getConfig("lang");
}
require "translations/".$lang.".php";

$gateKeeper = new GateKeeper();

if ($gateKeeper->isAccessAllowed() 
    && ($gateKeeper->isAllowed('upload_enable'))
) {

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {

        if ($_GET['resumableChunkNumber'] == 1) {
            $firstChunk = true;
        } else {
            $firstChunk = false;
        }
        $resumabledata = $chunk->setupFilename($_GET['resumableFilename'], $_GET['resumableIdentifier']);

        $resumableFilename = $resumabledata['filename'];

        $extension = $resumabledata['extension'];
        $basename = $resumabledata['basename'];

        $fullfilepath = $_GET['loc'].$resumableFilename;

        if (Utils::notList(
            $extension, SetUp::getConfig('upload_allow_type')
        ) == true
            || Utils::inList(
                $extension, SetUp::getConfig('upload_reject_extension')
            ) == true
            || Utils::inList(
                $resumableFilename, array('.htaccess','.htpasswd','.ftpquota')
            ) == true
            || substr($resumableFilename, 0, 1) === "."
        ) {
            if ($_GET['resumableChunkNumber'] == 1) {
                $chunk->setError(
                    '<span><i class="fa fa-exclamation-triangle"></i> '.$basename.'<strong>.'
                    .$extension.'</strong> '
                    .SetUp::getLangString('upload_type_not_allowed').'</span> '
                );
            }
            header("HTTP/1.0 200 Ok");

        } elseif (Actions::fileExists($fullfilepath)) {
            if ($_GET['resumableChunkNumber'] == 1) {
                $chunk->setWarning(
                    ' <span><i class="fa fa-info-circle"></i> <strong>'
                    .$resumableFilename.'</strong> '.SetUp::getLangString('file_exists').'</span> '
                );
            }
            header("HTTP/1.0 200 Ok");

        } elseif ($chunk->checkUserUp($_GET['resumableTotalSize']) == false) {
            if ($_GET['resumableChunkNumber'] == 1) {
                $chunk->setError(
                    '<span><i class="fa fa-exclamation-triangle"></i>'
                    .' <strong>'.SetUp::getLangString('upload_exceeded').'</strong>: '
                    .$_GET['resumableFilename'].'</span> '
                );
            }
            header("HTTP/1.0 200 Ok");

        } else {
            $temp_dir = 'tmp/'.$_GET['resumableIdentifier'];
            $chunk_file = $temp_dir.'/'.$_GET['resumableFilename'].'.part'.$_GET['resumableChunkNumber'];
            if (file_exists($chunk_file)) {
                header("HTTP/1.0 200 Ok");
            } else {
                header("HTTP/1.0 204 No Content");
            }
        }
    }

    if (!empty($_FILES)) {

        $resumabledata = $chunk->setupFilename($_POST['resumableFilename'], $_POST['resumableIdentifier']);
        $resumableFilename = $resumabledata['filename'];
		
               

        foreach ($_FILES as $file) {
            // init the destination file (format <filename.ext>.part<#chunk>
            // the file is stored in a temporary directory
            $temp_dir = 'tmp/'.$_POST['resumableIdentifier'];

            $dest_file = $temp_dir.'/'.$resumableFilename
            .'.part'.$_POST['resumableChunkNumber'];

            // create the temporary directory
            if (!is_dir($temp_dir)) {
                mkdir($temp_dir, 0777, true);
            }

            // move the temporary file
            if (!move_uploaded_file($file['tmp_name'], $dest_file)) {
                $chunk->setError(
                    ' <span><i class="fa fa-exclamation-triangle"></i> Error saving chunk'
                    .$_POST['resumableChunkNumber'].'for '.$resumableFilename.'</span> '
                );
            } else {
                // check if all the parts present, and create the final destination file
                $res = $chunk->createFileFromChunks(
                    $_GET['loc'],
                    $temp_dir,
                    $resumableFilename,
                    $_POST['resumableChunkSize'],
                    $_POST['resumableTotalSize'],
                    $_GET['logloc']
                );
				
			
            	
					
				if ($res) {
					$school = $gateKeeper->getUserInfo('schoolName') ? 
						$gateKeeper->getUserInfo('schoolName') : '';
					$academy = $gateKeeper->getUserInfo('academyName') ? 
						$gateKeeper->getUserInfo('academyName') : '';
					$major = $gateKeeper->getUserInfo('majorName') ? 
						$gateKeeper->getUserInfo('majorName') : '';
					$mobile = $gateKeeper->getUserInfo('email') ?
						$gateKeeper->getUserInfo('email') : '';
					// 生成download link
					$alt = SetUp::getConfig('salt');
					$altone = SetUp::getConfig('session_name');
					$dir = basename(SetUp::getConfig('starting_dir')).'/'.$_SESSION['vfm_user_name'].'/';
					$thislink = $dir . rawurlencode($resumableFilename);
					$dash = md5($alt.base64_encode($thislink).$altone.$alt);
					if (SetUp::getConfig('enable_prettylinks') == true) {
						$downlink = 'download/'.base64_encode($thislink).'/h/'.$dash;
					} else {
						$downlink = 'vfm-admin/vfm-downloader.php?q='.base64_encode($thislink).'&h='.$dash;
					}
					$data = [
						':school' => $school,
						':academy' => $academy,
						':major' => $major,
						':time' => date('Y-m-d H:i:s'),
						':user' => $_SESSION['vfm_user_name'],
						':mobile' => $mobile,
						':download' => $downlink,
						':page' => 0,
						':filename' => $resumableFilename,
						':filesize' => $_POST['resumableTotalSize'],
						':share' => 0,
						':preview' => '',
						':sharecredit' => ''
					];
					/**
					 * 数据库部分
					 */
					$ext = pathinfo($resumableFilename, PATHINFO_EXTENSION);
					$path = $_GET['loc'] . $resumableFilename;
					if ($ext == 'pdf' && file_exists($path)) {
						// while (!file_exists($path)) ;
						//$page = getPageNumFromPdf($path);
						$page = '0';
						$data[':page'] = $page;
					}
					$sql = 'SELECT `ID` FROM p_file 
						WHERE `user`=:user AND `filename`=:filename';
					$query_data = [
						':user' => $_SESSION['vfm_user_name'],
						':filename' => $resumableFilename
					];
					$stmt = $mysql_conn->prepare($sql);
					$stmt->execute($query_data);
					$result = $stmt->fetchAll();
					if (empty($result)) {
						$sql = 'INSERT INTO p_file VALUES(
							null, 
							:school,
							:academy,
							:major,
							:time,
							:user,
							:mobile,
							:download,
							:page,
							:filename,
							:filesize,
							:share,
							:preview,
							:sharecredit
						)';
						try {
							$stmt = $mysql_conn->prepare($sql);
							$stmt->execute($data);
						} catch (PDOException $e) {
							unlink($_GET['loc'] . $resumableFilename);
							$chunk->setError(
								'<span><i class="fa fa-exclamation-triangle"></i>'
								.' <strong>DATABASE ERROR</strong>: '
								.$e->getMessage().'</span> '
							);
							exit();
						}
					} else {
						$update_data = [
							':page' => $page ? $page : 0,
							':ID' => $result[0]['ID']
						];
						$sql = "UPDATE p_file SET `page`=:page WHERE `ID`=:ID";
						$stmt = $mysql_conn->prepare($sql);
						$stmt->execute($update_data);
					}
				}
            }
        }

       

    } 
}
?>