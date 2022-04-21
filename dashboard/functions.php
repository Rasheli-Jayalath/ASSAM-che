<?php
function proj_name($pid)
{
include_once("connect.php");
$sql="Select proj_name from t002project where pid=".$pid;
$res=mysql_query($sql);
$resset=mysql_fetch_array($res);
$proj_name=$resset['proj_name'];
return $proj_name;
}

function pcolor($pid)
{
include_once("connect.php");
$sql="Select pcolor from t002project where pid=".$pid;
$res=mysql_query($sql);
$resset=mysql_fetch_array($res);
$pcolor=$resset['pcolor'];
return $pcolor;
}
?>