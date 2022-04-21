<?php
// Cache the contents to a file
$cached_kfi = fopen($cachefile_kfi, 'w');
fwrite($cached_kfi, ob_get_contents());
fclose($cached_kfi);
ob_end_flush(); // Send the output to the browser
?>