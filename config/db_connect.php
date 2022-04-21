<?php
$db = @mysql_connect("localhost", "root", "") or die("Could not connect.");
	 /* }
	 else
	{
$db = mysql_connect("localhost", "root", "") or die("Could not connect.");
	} */ 
if(!$db) 
	die("no db");
	mysql_set_charset('UTF8',$db);
if(!@mysql_select_db("assam_pmis",$db))
 	die("No database selected.");
	$pmis_db="assam_pmis";
	$root_db="assam";

?>