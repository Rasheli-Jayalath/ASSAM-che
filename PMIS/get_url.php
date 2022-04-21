<?php
$request_uri = $_SERVER['REQUEST_URI'];
$log_id = $_SESSION['log_id'];
$iSQL = ("INSERT INTO pages_visit_log (log_id,request_url) VALUES ('$log_id','$request_uri')");
$objDb->execute($iSQL);
?>