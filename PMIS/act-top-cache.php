<?php
$url = $_SERVER["SCRIPT_NAME"];
$break = Explode('/', $url);
$file = $break[count($break) - 1];
$cachefile_act = $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$cachefile_act = 'act_cache/'.md5($cachefile_act).".html";
//$cachefile = 'cached-'.substr_replace($file ,"",-4).'.html';
$cachetime = 31536000;

// Serve from the cache if it is younger than $cachetime
if (file_exists($cachefile_act) && time() - $cachetime < filemtime($cachefile_act)) {
    echo "<!-- Cached copy, generated ".date('H:i', filemtime($cachefile_act))." -->\n";
    include($cachefile_act);
    exit;
}
ob_start(); // Start the output buffer
?>