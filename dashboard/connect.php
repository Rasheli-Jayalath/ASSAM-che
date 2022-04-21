<?php
 /* if($_SERVER['HTTP_HOST'] == "mysqlcluster10.registeredsite.com" )
	{ */

	$db = mysql_connect("localhost", "root", "") or die("Could not connect.");
	 /* }
	 else
	{
$db = mysql_connect("localhost", "root", "") or die("Could not connect.");
	} */ 
if(!$db) 
	die("no db");
if(!mysql_select_db("idip2_gmc_dashboard",$db))
 	die("No database selected.");
?>