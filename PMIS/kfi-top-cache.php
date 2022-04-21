<?php
$url = $_SERVER["SCRIPT_NAME"];
$break = Explode('/', $url);
$file = $break[count($break) - 1];
$cachefile_kfi = $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$cachefile_kfi = 'kfi_cache/'.md5($cachefile_kfi).".html";
//$cachefile = 'cached-'.substr_replace($file ,"",-4).'.html';
$cachetime = 31536000;

// Serve from the cache if it is younger than $cachetime
if (file_exists($cachefile_kfi) && time() - $cachetime < filemtime($cachefile_kfi)) {
    echo "<!-- Cached copy, generated ".date('H:i', filemtime($cachefile_kfi))." -->\n";
    include($cachefile_kfi);
    exit;
}
ob_start(); // Start the output buffer
?>