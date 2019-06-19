<?php
/**
 * VFM - veno file manager: ajax/streamvid.php
 *
 * Stream videos
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
require_once '../config.php';
session_name($_CONFIG["session_name"]);
session_start();
require_once '../class.php'; 
if (!GateKeeper::isAccessAllowed()) {
    die('access denied');
}

$get = filter_input(INPUT_GET, 'vid', FILTER_SANITIZE_STRING);
$path = '../../'.$get;

$setUp = new SetUp();
$utils = new Utils();

if ($get && $utils->checkVideo($path) == true) {

    $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
    $mime = $ext == 'ogv' ? "video/ogg" : "video/".$ext;
    $size = filesize($path);

    // disable zlib so that progress bar of player shows up correctly
    if (ini_get('zlib.output_compression')) {
        @ini_set('zlib.output_compression', 'Off'); 
    }
    @set_time_limit(0);
    session_write_close();

    header('Content-type: '.$mime);

    if (isset($_SERVER['HTTP_RANGE'])) {
        // Parse the range header to get the byte offset
        $ranges = array_map('intval', explode('-', substr($_SERVER['HTTP_RANGE'], 6)));
        // If the last range param is empty, it means the EOF
        if (!$ranges[1]) {
            $ranges[1] = $size - 1;
        }
        header('HTTP/1.1 206 Partial Content');
        header('Accept-Ranges: bytes');
        header('Content-Length: ' . ($ranges[1] - $ranges[0]));
        header(sprintf('Content-Range: bytes %d-%d/%d', $ranges[0], $ranges[1], $size));

        $f = fopen($path, 'rb');
        $chunkSize = 8192;

        fseek($f, $ranges[0]);

        while (true) {
            if (ftell($f) >= $ranges[1]) {
                break;
            }
            if (ob_get_level()) {
                ob_end_clean();
            }
            echo fread($f, $chunkSize);
        }
    } else {
        header('Content-Length: '.$size);
        if (ob_get_level()) {
            ob_end_clean();
        }
        readfile($path);
    }
}
exit;