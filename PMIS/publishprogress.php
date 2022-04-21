<?php
error_reporting(E_ALL & ~E_NOTICE);
@require_once("requires/session.php");
$module		= ADD_PROGRESS;

if ($uname==null  ) {
header("Location: index.php?init=3");
} 
$temp_id			= $_GET['temp_id'];
$objDb  		= new Database( );
$objDbI 		= new Database( );
$objDbD  		= new Database( );
$objDbB  		= new Database( );
@require_once("get_url.php");
$msg						= "";
function GetBaseline($temp_id,$rid,$itemid)
{
	 $actQuery="SELECT baseline FROM activity where rid=$rid AND temp_id=$temp_id AND itemid=$itemid";
	$res=mysql_query($actQuery);
    $baserows=mysql_fetch_array($res);
	return $baserows["baseline"];
}
if($temp_id != "")
{
	
$sdSQL = "DELETE FROM progress where temp_id=$temp_id";  
$objDbD->execute($sdSQL);

$baseQuery="SELECT a.itemid, b.rid, b.temp_id, b.unit_type, c.boqid, d.ipcqty,d.ipcid, e.boqqty, e.boqunit, e.cur_1_exchrate, e.boq_cur_1_rate, e.cur_2_exchrate, e.boq_cur_2_rate, e.cur_3_exchrate, e.boq_cur_3_rate, (d.ipcqty * e.cur_1_exchrate * e.boq_cur_1_rate) as amount1, (d.ipcqty * e.cur_2_exchrate * e.boq_cur_2_rate) as amount2, (d.ipcqty * e.cur_3_exchrate * e.boq_cur_3_rate) as amount3 FROM activity a left outer join baseline b on (a.rid = b.rid) left outer join baseline_mapping_boqs c on (a.rid = c.rid) inner join ipcv d on (c.boqid = d.boqid) inner join boq e on (d.boqid = e.boqid) where b.temp_id=$temp_id";
$res=mysql_query($baseQuery);
while($baserows=mysql_fetch_array($res))
{
	$itemid=$baserows["itemid"];
	$rid=$baserows["rid"];
	$ipcquey="SELECT ipcmonth from ipc where ipcid=".$baserows["ipcid"];
	
	$ipcres=mysql_query($ipcquey);
	$ipsrow=mysql_fetch_array($ipcres);
	$ipcdate=$ipsrow["ipcmonth"];
	$fmonth= date('m',strtotime($ipcdate));
	$fyear= date('Y',strtotime($ipcdate));
	$fmonth_days=cal_days_in_month(CAL_GREGORIAN,$fmonth,$fyear);
	$ipcmonth=$fyear."-".$fmonth."-".$fmonth_days;
	
	$baseline=GetBaseline($baserows["temp_id"],$baserows["rid"],$baserows["itemid"]);
	$factor=1;
	if($baserows["boqqty"]!=""&&$baserows["boqqty"]!=0)
	{
	$factor=$baseline/$baserows["boqqty"];
	}
	else
	{
	 $factor=0;
	 }
	 if($baserows["unit_type"]==1)
	 {
		 $progessqty=$factor*$baserows["ipcqty"]; 
	  }
	  else
	  {
	$progessqty=($baserows["amount1"]+$baserows["amount2"]+$baserows["amount3"])*$factor;
	  }
 $sSQL = ("INSERT INTO progress (itemid,  rid,  temp_id, progressdate,progressqty) VALUES ($itemid,'$rid', '$temp_id', '$ipcmonth','$progessqty')");
$objDb->execute($sSQL);
$txtid = $objDb->getAutoNumber();
$ipcmonth="";
}


	
	$msg=6;
		}
$suSQL = "UPDATE template_progress SET update_flag=0 where temp_id=$temp_id AND progress_type=1";  
		$objDbI->execute($suSQL);
	header("Location: template_progress.php?msg=$msg");
?>

