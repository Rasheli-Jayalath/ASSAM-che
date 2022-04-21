<?php
error_reporting(E_ALL & ~E_NOTICE);
@require_once("requires/session.php");
$module		= ACTIVITY;
if ($uname==null  ) {
header("Location: index.php?init=3");
}
$objDb  		= new Database( );
$objDb2  		= new Database( );
$defaultLang = 'en';

//Checking, if the $_GET["language"] has any value
//if the $_GET["language"] is not empty
if (!empty($_GET["language"])) { //<!-- see this line. checks 
    //Based on the lowecase $_GET['language'] value, we will decide,
    //what lanuage do we use
    switch (strtolower($_GET["language"])) {
        case "en":
            //If the string is en or EN
            $_SESSION['lang'] = 'en';
            break;
        case "rus":
            //If the string is tr or TR
            $_SESSION['lang'] = 'rus';
            break;
        default:
            //IN ALL OTHER CASES your default langauge code will set
            //Invalid languages
            $_SESSION['lang'] = $defaultLang;
            break;
    }
}

//If there was no language initialized, (empty $_SESSION['lang']) then
if (empty($_SESSION["lang"])) {
    //Set default lang if there was no language
    $_SESSION["lang"] = $defaultLang;
}
if($_SESSION["lang"]=='en')
{
require_once('rs_lang.admin.php');

}
else
{
	require_once('rs_lang.admin_rus.php');

}
$edit			= $_GET['edit'];
$delete			= $_GET['del'];
if(isset($_GET['subaid']))
{
$subaid			= $_GET['subaid'];
}
else
{
$subaid			= $edit;
}
/*$sql_bt="Select * from baseline_template where temp_is_default=1";
			$res_bt=mysql_query($sql_bt);
			$row_bt=mysql_fetch_array($res_bt);
			$temp_id= $row_bt['temp_id'];
			$temp_tilte=$row_bt['temp_title'];
*/
$temp_id=1;
if($subaid!="")
{
 $sqlgx="Select itemname, parentcd,parentgroup from maindata where  itemid=$subaid";
$resgx=mysql_query($sqlgx);
$row3gx=mysql_fetch_array($resgx);
$name_activity=$row3gx['itemname'];
$parent=$row3gx['parentcd'];
$pgroup=$row3gx['parentgroup'];
$ar_group=explode("_",$pgroup);
$sizze= count($ar_group);
for($i=0; $i<$sizze; $i++)
{
$sqlgx1="Select itemname, parentcd from maindata where itemid=$ar_group[$i]";
$resgx1=mysql_query($sqlgx1);
$row3gx1=mysql_fetch_array($resgx1);
$itemname_1=$row3gx1['itemname'];
if ($i==0){ $title="Activity"; }
    else if ($i>1){ $title="Subactivity"; }
$trail.="<table><tr><td><b>".$title;

 $trail.=": </b></td><td>".$itemname_1; 
 $trail.="</td></tr></table>";

}

 }
if(isset($_GET['levelid']))
{

$levelid		= $_GET['levelid'];
}
else
{
$levelid		= 0;
}

@require_once("get_url.php");
$msg						= "";
$saveBtn					= $_REQUEST['save']; 
$updateBtn					= $_REQUEST['update'];
$clear						= $_REQUEST['clear'];
$next						= $_REQUEST['next'];
$txtstage				 	= "Activity";
$txtitemcode				= $_REQUEST['txtitemcode'];
$txtitemname				= mysql_real_escape_string($_REQUEST['txtitemname']);

$txtrid						= $_REQUEST['txtrid'];
$startdate					= $_REQUEST['txtstartdate'];
$enddate					= $_REQUEST['txtenddate'];
$txtremaining_quantity		= $_REQUEST['remaining_quantity'];
$txtused_quantity			= $_REQUEST['used_quantity'];
$txtactivity				= $subaid;
$activitylevel				= $levelid;
$txtisentry					= $_REQUEST['txtisentry'];
if($txtisentry==1)
{
	$res_s						= $_REQUEST['res'];
	$length=count($res_s);
	if($length>0)
	{
	$txtresources="";
		for($i=0; $i<$length; $i++)
		{
		if($i==0)
		{
		$txtresources=$res_s[$i];
		}
		else
		{
		$txtresources=$txtresources.",".$res_s[$i];
		}
		}
	}
	else
	{
	$txtresources="";
	}
}
else
{
$txtresources="";
}

if($clear!="")
{

$txtitemcode 				= '';
$txtitemname 				= '';
$txtweight					= '';
$txtactivity				= '';
}

if($saveBtn != "")
{
if(!isset($_GET['levelid']))
{

 $txtparentcd =0;
   $sSQL = ("INSERT INTO maindata (parentcd,itemcode, itemname,  isentry,resources) VALUES ($txtparentcd,'$txtitemcode', '$txtitemname',$txtisentry,'$txtresources')");
	$objDb->execute($sSQL);
	$txtid = $objDb->getAutoNumber();
	$itemids = $txtid;
	
	$parentgroup=str_repeat("0",$_SESSION['codelength']-strlen($itemids)).$itemids;
	
	
	$uSqlu = "Update maindata SET 
			 parentgroup			= '$parentgroup'
			where itemid 				= $itemids";	
	$objDb->execute($uSqlu);




}
else
{
$eSqls = "Select * from maindata where itemid='$txtactivity'";
  $objDb -> query($eSqls);
  $eCount = $objDb->getCount();
	if($eCount > 0){
	  $parentgroup2 					= $objDb->getField(0,parentgroup);
	   $txtparentcd 					= $objDb->getField(0,itemid);
	  }
 $sSQL = ("INSERT INTO maindata (parentcd, activitylevel, itemcode, itemname,  isentry) VALUES ($txtparentcd,$activitylevel+1,'$txtitemcode', '$txtitemname',$txtisentry)");
	$objDb->execute($sSQL);
	$txtid = $objDb->getAutoNumber();
	$itemids = $txtid;
	
	$parentgroup1=str_repeat("0",$_SESSION['codelength']-strlen($itemids)).$itemids;
		
	$parentgroup=$parentgroup2."_".$parentgroup1;
		
	 $uSqlu = "Update maindata SET 
			 parentgroup			= '$parentgroup'
			where itemid 				= $itemids";	
	$objDb->execute($uSqlu);
}	
	
	 $ssSQL = ("INSERT INTO activity (itemid, startdate, enddate, rid,baseline,temp_id) VALUES ($itemids, '$startdate', '$enddate',$txtrid,$txtused_quantity,$temp_id)");
	$objDb->execute($ssSQL);
	$txtid = $objDb->getAutoNumber();
	$aid = $txtid;	
	$msg="Saved!";
	
	
	$log_module  = $module." Module";
	$log_title   = "Add ".$module." Record";
	$log_ip      = $_SERVER['REMOTE_ADDR'];	
	
	$sSQL = ("INSERT INTO maindata_log (log_module,log_title,log_ip, parentcd, parentgroup,activitylevel, stage, itemcode, itemname, weight, activities	, isentry, resources,transaction_id) VALUES ('$log_module','$log_title','$log_ip',$txtparentcd,'$parentgroup',$activitylevel+1,'$txtstage', '$txtitemcode', '$txtitemname',$txtweight,'$txtactivities',$txtisentry, '$txtresources',$itemids)");
	$objDb->execute($sSQL);
	
		 $sSQL_pln = ('INSERT INTO planned (itemid,rid,budgetdate,budgetqty,temp_id) select d.itemid, d.rid, d.pl_date,d.planned_qty ,'.$temp_id.' as temp_id from (select e.itemid as itemid , e.rid as rid , f.itemid as itemid1, f.rid as rid1, f.baseline, f.pl_date as pl_date1, f.days, f.total_days ,(f.planned_qty+e.budgetqty) as planned_qty, e.pl_date as pl_date from (select b.itemid, b.rid, b.baseline,a.pl_date, a.days, c.total_days,((a.days/c.total_days)*b.baseline) as planned_qty from activity b , (select LAST_DAY(CONCAT(YEAR(pd_date),"-",IF(LENGTH(MONTH(pd_date))=1,CONCAT("0",MONTH(pd_date)),MONTH(pd_date)),"-01")) as pl_date, count(LAST_DAY(CONCAT(YEAR(pd_date),"-",IF(LENGTH(MONTH(pd_date))=1,CONCAT("0",MONTH(pd_date)),MONTH(pd_date)),"-01"))) as days from project_days where pd_date BETWEEN (select startdate from activity where aid='.$aid.') AND (select enddate from activity where aid='.$aid.') AND pd_status=1 group by LAST_DAY(CONCAT(YEAR(pd_date),"-",IF(LENGTH(MONTH(pd_date))=1,CONCAT("0",MONTH(pd_date)),MONTH(pd_date)),"-01"))) a ,(select count(LAST_DAY(CONCAT(YEAR(pd_date),"-",IF(LENGTH(MONTH(pd_date))=1,CONCAT("0",MONTH(pd_date)),MONTH(pd_date)),"-01"))) as total_days from project_days where pd_date BETWEEN (select startdate from activity where aid='.$aid.') AND (select enddate from activity where aid='.$aid.') AND pd_status=1) c where b.aid='.$aid.') f right outer join (select bb.itemid, bb.rid, LAST_DAY(CONCAT(YEAR(aa.pd_date),"-",IF(LENGTH(MONTH(aa.pd_date))=1,CONCAT("0",MONTH(aa.pd_date)),MONTH(aa.pd_date)),"-01")) as pl_date , 0 as budgetqty from project_days aa, activity bb where bb.aid = '.$aid.' group by LAST_DAY(CONCAT(YEAR(aa.pd_date),"-",IF(LENGTH(MONTH(aa.pd_date))=1,CONCAT("0",MONTH(aa.pd_date)),MONTH(aa.pd_date)),"-01"))) e on (f.pl_date=e.pl_date) ) d');
	 mysql_query($sSQL_pln);
	
	
	print "<script type='text/javascript'>";
				print "window.opener.location.reload();";
				print "self.close();";
				print "</script>";  

}

if($updateBtn !=""){


		 $eSql_s = "Select * from maindata where itemid='$txtactivity'";
  	$objDb -> query($eSql_s);
  	$eCount2 = $objDb->getCount();
	if($eCount2 > 0){
	  $parentgroup_s	 				= $objDb->getField(0,parentgroup);
	  }
	   $itmid=str_repeat("0",$_SESSION['codelength']-strlen($edit)).$edit;
	
		$parentgroup=$parentgroup_s."_".$itmid;
	
	 $uSql = "Update maindata SET 			
			 itemcode         		= '$txtitemcode',
			 itemname   			= '$txtitemname',
			 parentcd				= $txtactivity,
			 parentgroup            = '$parentgroup',
			 isentry				= '$txtisentry'
			where itemid 			= $edit ";
		  
 	if($objDb->execute($uSql)){
	
	$eSql_l = "Select * from maindata where itemid='$edit'";
  	$objDb -> query($eSql_l);
  	$eCount1 = $objDb->getCount();
	if($eCount1 > 0){
	  $parentcd 					= $objDb->getField(0,parentcd);
	  $parentgroup	 				= $objDb->getField(0,parentgroup);
	  }
	  $eSql_s = "Select * from activity where itemid=".$edit;
  	$ms_res=mysql_query($eSql_s);
	$res_m=mysql_fetch_array($ms_res);
	$act_count=mysql_num_rows($ms_res);
	if($eCount1 > 0&&$act_count==0)
	{
		 $ssSQL = ("INSERT INTO activity (itemid, startdate, enddate, rid,baseline,temp_id) VALUES ($edit, '$startdate', '$enddate',$txtrid,$txtused_quantity,$temp_id)");
	$objDb->execute($ssSQL);
	$txtid = $objDb->getAutoNumber();
	$aid = $txtid;	
	$log_module  = $module." Module";
	$log_title   = "Add ".$module." Record";
	$log_ip      = $_SERVER['REMOTE_ADDR'];	
	
	$sSQL = ("INSERT INTO maindata_log (log_module,log_title,log_ip, parentcd, parentgroup,activitylevel, stage, itemcode, itemname, weight, activities	, isentry, resources,transaction_id) VALUES ('$log_module','$log_title','$log_ip',$txtparentcd,'$parentgroup',$activitylevel+1,'$txtstage', '$txtitemcode', '$txtitemname',$txtweight,'$txtactivities',$txtisentry, '$txtresources',$itemids)");
	$objDb->execute($sSQL);
	
		 $sSQL_pln = ('INSERT INTO planned (itemid,rid,budgetdate,budgetqty,temp_id) select d.itemid, d.rid, d.pl_date,d.planned_qty ,'.$temp_id.' as temp_id from (select e.itemid as itemid , e.rid as rid , f.itemid as itemid1, f.rid as rid1, f.baseline, f.pl_date as pl_date1, f.days, f.total_days ,(f.planned_qty+e.budgetqty) as planned_qty, e.pl_date as pl_date from (select b.itemid, b.rid, b.baseline,a.pl_date, a.days, c.total_days,((a.days/c.total_days)*b.baseline) as planned_qty from activity b , (select LAST_DAY(CONCAT(YEAR(pd_date),"-",IF(LENGTH(MONTH(pd_date))=1,CONCAT("0",MONTH(pd_date)),MONTH(pd_date)),"-01")) as pl_date, count(LAST_DAY(CONCAT(YEAR(pd_date),"-",IF(LENGTH(MONTH(pd_date))=1,CONCAT("0",MONTH(pd_date)),MONTH(pd_date)),"-01"))) as days from project_days where pd_date BETWEEN (select startdate from activity where aid='.$aid.') AND (select enddate from activity where aid='.$aid.') AND pd_status=1 group by LAST_DAY(CONCAT(YEAR(pd_date),"-",IF(LENGTH(MONTH(pd_date))=1,CONCAT("0",MONTH(pd_date)),MONTH(pd_date)),"-01"))) a ,(select count(LAST_DAY(CONCAT(YEAR(pd_date),"-",IF(LENGTH(MONTH(pd_date))=1,CONCAT("0",MONTH(pd_date)),MONTH(pd_date)),"-01"))) as total_days from project_days where pd_date BETWEEN (select startdate from activity where aid='.$aid.') AND (select enddate from activity where aid='.$aid.') AND pd_status=1) c where b.aid='.$aid.') f right outer join (select bb.itemid, bb.rid, LAST_DAY(CONCAT(YEAR(aa.pd_date),"-",IF(LENGTH(MONTH(aa.pd_date))=1,CONCAT("0",MONTH(aa.pd_date)),MONTH(aa.pd_date)),"-01")) as pl_date , 0 as budgetqty from project_days aa, activity bb where bb.aid = '.$aid.' group by LAST_DAY(CONCAT(YEAR(aa.pd_date),"-",IF(LENGTH(MONTH(aa.pd_date))=1,CONCAT("0",MONTH(aa.pd_date)),MONTH(aa.pd_date)),"-01"))) e on (f.pl_date=e.pl_date) ) d');
	 mysql_query($sSQL_pln);
	}
	else
	{
	$aid=$res_m['aid'];
	$rid=$res_m['rid'];
	 $uSql_act = "Update activity SET 			
			 startdate         	= '$startdate',
			 enddate  			= '$enddate',
			 rid				= $txtrid,
			 baseline      		= $txtused_quantity
			where itemid 		= $edit ";
		$objDb->execute($uSql_act);  
	
	  $msg="Updated!";
	   $sSQLD = "DELETE FROM planned where itemid=".$edit." AND rid=".$rid;
	$objDb->execute($sSQLD);
	$log_module  = $module." Module";
	$log_title   = "Update".$module ."Record";
	$log_ip      = $_SERVER['REMOTE_ADDR'];		
	
	$sSQL2 = ("INSERT INTO maindata_log (log_module,log_title,log_ip, parentcd, parentgroup,activitylevel, stage, itemcode, itemname, weight, activities,isentry,  resources,transaction_id) VALUES ('$log_module','$log_title','$log_ip',$parentcd,'$parentgroup',$activitylevel,'$txtstage', '$txtitemcode', '$txtitemname',$txtweight,'$txtactivities', $txtisentry, '$txtresources',$edit)");
		$objDb->execute($sSQL2);
	
	
	 
	
	 $sSQL_pln = ('INSERT INTO planned (itemid,rid,budgetdate,budgetqty,temp_id) select d.itemid, d.rid, d.pl_date,d.planned_qty ,'.$temp_id.' as temp_id from (select e.itemid as itemid , e.rid as rid , f.itemid as itemid1, f.rid as rid1, f.baseline, f.pl_date as pl_date1, f.days, f.total_days ,(f.planned_qty+e.budgetqty) as planned_qty, e.pl_date as pl_date from (select b.itemid, b.rid, b.baseline,a.pl_date, a.days, c.total_days,((a.days/c.total_days)*b.baseline) as planned_qty from activity b , (select LAST_DAY(CONCAT(YEAR(pd_date),"-",IF(LENGTH(MONTH(pd_date))=1,CONCAT("0",MONTH(pd_date)),MONTH(pd_date)),"-01")) as pl_date, count(LAST_DAY(CONCAT(YEAR(pd_date),"-",IF(LENGTH(MONTH(pd_date))=1,CONCAT("0",MONTH(pd_date)),MONTH(pd_date)),"-01"))) as days from project_days where pd_date BETWEEN (select startdate from activity where aid='.$aid.') AND (select enddate from activity where aid='.$aid.') AND pd_status=1 group by LAST_DAY(CONCAT(YEAR(pd_date),"-",IF(LENGTH(MONTH(pd_date))=1,CONCAT("0",MONTH(pd_date)),MONTH(pd_date)),"-01"))) a ,(select count(LAST_DAY(CONCAT(YEAR(pd_date),"-",IF(LENGTH(MONTH(pd_date))=1,CONCAT("0",MONTH(pd_date)),MONTH(pd_date)),"-01"))) as total_days from project_days where pd_date BETWEEN (select startdate from activity where aid='.$aid.') AND (select enddate from activity where aid='.$aid.') AND pd_status=1) c where b.aid='.$aid.') f right outer join (select bb.itemid, bb.rid, LAST_DAY(CONCAT(YEAR(aa.pd_date),"-",IF(LENGTH(MONTH(aa.pd_date))=1,CONCAT("0",MONTH(aa.pd_date)),MONTH(aa.pd_date)),"-01")) as pl_date , 0 as budgetqty from project_days aa, activity bb where bb.aid = '.$aid.' group by LAST_DAY(CONCAT(YEAR(aa.pd_date),"-",IF(LENGTH(MONTH(aa.pd_date))=1,CONCAT("0",MONTH(aa.pd_date)),MONTH(aa.pd_date)),"-01"))) e on (f.pl_date=e.pl_date) ) d');
	 mysql_query($sSQL_pln);
		
		$txtparentcd				= '';
		$txtparentgroup				= '';
		$txtstage					= '';
		$txtitemcode 				= '';
		$txtitemname 				= '';
		$txtweight					= '';
		$txtactivities				= '';
		$txtisentry					= '';
		$txtresources 				= '';
	}
	}
	print "<script type='text/javascript'>";
				print "window.opener.location.reload();";
				print "self.close();";
				print "</script>";  
}

if($delete != ""){
$eSql = "Select * from maindata where itemid=$delete";
$q_ry=mysql_query($eSql);
$res_s=mysql_fetch_array($q_ry);
$p_group=$res_s['parentgroup'];
$aSql = "Select * from activity where itemid=$delete";
$a_ry=mysql_query($aSql);
$res_a=mysql_fetch_array($a_ry);
$aid=$res_a['aid'];
$p_group=$res_s['parentgroup'];
$eSqlr = "Select * from maindata where parentgroup like '$p_group%'";
$q_ryr=mysql_query($eSqlr);
while($res_sr=mysql_fetch_array($q_ryr))
{
	$itemid			=$res_sr['itemid'];
	$parentcd		=$res_sr['parentcd'];
	$parentgroup	=$res_sr['parentgroup'];
	$activitylevel  =$res_sr['activitylevel'];
	$stage			=$res_sr['stage'];
	$itemcode		=$res_sr['itemcode'];
	$itemname		=$res_sr['itemname'];
	$isentry  		=$res_sr['isentry'];
	$txtactivities	="";
	$txtresources	="";
	
	
	 $msg="Deleted!";
	$log_module  = $module." Module";
	$log_title   = "Deleted".$module ."Record";
	$log_ip      = $_SERVER['REMOTE_ADDR'];	
	$sSQL7 = ("INSERT INTO maindata_log (log_module,log_title,log_ip, parentcd, parentgroup,activitylevel, stage, itemcode, itemname, weight, activities,isentry,  resources,transaction_id) VALUES ('$log_module','$log_title','$log_ip',$parentcd,'$parentgroup',$activitylevel,'$stage', '$itemcode', '$itemname',$weight,'$txtactivities', $isentry, '$txtresources',$itemid)");
	$objDb->execute($sSQL7);
	
		
	$eSql_child = "delete from activity where itemid=$itemid";
    $objDb -> query($eSql_child);
	$eSql_child1 = "delete from planned where itemid=$itemid";
    $objDb -> query($eSql_child1);
	$eSql_child2 = "delete from progress where itemid=$itemid";
    $objDb -> query($eSql_child2);
	$eSql_child2 = "delete from kpi_activity where aid=$aid";
    $objDb -> query($eSql_child2);
	$eSql_d = "delete from maindata where itemid=$itemid";
    $objDb -> query($eSql_d);

}

header("Location: maindata.php");	
}

if($edit != ""){
	$eSql = "Select * from maindata where itemid=$edit";
    $objDb -> query($eSql);
    $eCount = $objDb->getCount();
	if($eCount > 0){
	 $parentcd 						= $objDb->getField($g,parentcd);
	  $parentgroup	 				= $objDb->getField($g,parentgroup);
	  $itemcode 					= $objDb->getField($g,itemcode);
	  $itemname 					= $objDb->getField($g,itemname);
	  $isentry 						= $objDb->getField($g,isentry);
	  $ar_list=explode("_",$parentgroup);
	  $st_g=$ar_list[0];
	  $ou_cm=$ar_list[1];
	  $ou_pt=$ar_list[2];
	  $ac_ty=$ar_list[3];
	 	
	}
	
	
}

?>
<!doctype html>
<html lang="en">
<head>
<?php /*?>  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
   <meta name="author" content="Jake Rocheleau">
  <link rel="shortcut icon" href="http://static02.hongkiat.com/logo/hkdc/favicon.ico">
  <link rel="icon" href="http://static02.hongkiat.com/logo/hkdc/favicon.ico">
  <link rel="stylesheet" type="text/css" media="all" href="Forms/style.css">
  <link rel="stylesheet" type="text/css" media="all" href="Forms/responsive.css">

<?php include ('includes/metatag.php'); ?><?php */?>

<link rel="stylesheet" type="text/css" href="css/style.css">
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="datepickercode/jquery-ui.css" />
  <script type="text/javascript" src="datepickercode/jquery-1.10.2.js"></script>
  <script type="text/javascript" src="datepickercode/jquery-ui.js"></script>
  <!--<script src='jquery-3.2.1.min.js' type='text/javascript'></script>
        <script src='select2/dist/js/select2.min.js' type='text/javascript'></script>
        <link href='select2/dist/css/select2.min.css' rel='stylesheet' type='text/css'> -->
  		<script>
 function ShowDataDiv(did)
   {
   
	   if(did==1)
	   {
		document.getElementById("data_div").style.display="";
		document.getElementById("w_div").style.display="none";
		document.getElementById("remaining_quantity").value="";
	   }
		else
		{
		document.getElementById("data_div").style.display="none";
		document.getElementById("w_div").style.display="";
		}
	
	}
	
	</script>
   		<script>
	function getQuantity(rid)
   {
	 
if(rid!=0)
{
   <?php 
	$sqlg="Select * from baseline";
			$resg=mysql_query($sqlg);
			while($abc=mysql_fetch_array($resg))
			{
			
			
			
			?>
			
			if(<?php echo $abc['rid']?>==rid)
			{
			
			<?php
			$sqlg3="Select sum(baseline) as used_qt from activity where rid=".$abc['rid'];
			$resg3=mysql_query($sqlg3);
			
			$abc3=mysql_fetch_array($resg3);
			$used_qty=$abc3['used_qt'];
			//$used_qty=0;
			$remaining_qtyy=$abc['quantity']-$used_qty;
			
			?>
			
			if(<?php echo $abc['unit_type'] ?>==1)
			{
			var utype="Quantity";
			}
			else if(<?php echo $abc['unit_type'] ?>==2)
			{
			var utype="Amount";
			}
			document.getElementById("total_quantity").value="<?php echo $abc['quantity'] ?>";	
			document.getElementById("quantity_unit").value="<?php echo $abc['unit'] ?>";	
			document.getElementById("quantity_unit_r").value="<?php echo $abc['unit'] ?>";	
			document.getElementById("quantity_unit_a").value="<?php echo $abc['unit'] ?>";		
			document.getElementById("h_remaining_quantity").value="<?php echo $remaining_qtyy ?>";
			document.getElementById("remaining_quantity").value="<?php echo $remaining_qtyy ?>";
			document.getElementById("used_quantity").value="";
			document.getElementById("to_qt").innerHTML=utype;
			document.getElementById("to_av_qt").innerHTML=utype;
			document.getElementById("to_al_qt").innerHTML=utype;
			
			}
			<?php
			}
			?>
   	}
	else
	{
			document.getElementById("total_quantity").value="";	
			document.getElementById("quantity_unit").value="";	
			document.getElementById("quantity_unit_r").value="";	
			document.getElementById("quantity_unit_a").value="";		
			document.getElementById("h_remaining_quantity").value="";
			document.getElementById("remaining_quantity").value="";
			document.getElementById("used_quantity").value="";
			document.getElementById("to_qt").innerHTML="";
			document.getElementById("to_av_qt").innerHTML="";
			document.getElementById("to_al_qt").innerHTML="";
			
			
	}
	
	}
	
	
	
	function showResult(remaining_quantity,used_quantity,hidden_value,u_r_quantity,itemid) {
	
	if(isNaN(used_quantity))
	{
	alert(used_quantity+" Is not a Number");
	document.getElementById("used_quantity").value="";
	document.getElementById("remaining_quantity").value=hidden_value;
	}
	else
	{
	t_q="";

if(u_r_quantity=="")
{
remaining_quantity=hidden_value-0;

}
else
{
remaining_quantity=u_r_quantity-0;

}

document.getElementById("remaining_quantity").value=remaining_quantity-used_quantity;

 } 
}
	
		</script>
  
  <script type="text/javascript">
		 
 $(function() {
   $('#txtstartdate').datepicker({ dateFormat: 'yy-mm-dd' }).val();
  });
   $(function() {
    $('#txtenddate').datepicker({ dateFormat: 'yy-mm-dd' }).val();
  });
$("#datepicker1,#datepicker2").datepicker({dateFormat: 'dd-mm-yy', minDate: 0});

</script>
   
  <script>
  function validateform(){
var itemcode=document.frmresources.txtitemcode.value;  
var itemname=document.frmresources.txtitemname.value;
var is_entry=document.frmresources.txtisentry.value;
var rid=document.frmresources.txtrid.value;

if (itemcode==null || itemcode==""){  
  alert("Code is required field");  
  return false;  
}else if(itemname==null || itemname==""){  
  alert("Item Name is required field");  
  return false;  
  }
  if(is_entry=="1")
  {	
  	if(rid=="0")
	{
	 alert("Baseline is required field");
	 return false;    
	}
	
  }
  
  }
  </script>
 
</head>
<body>


<div class="form-style-2">
<?php
			if(isset($_REQUEST['edit']))
			{
			$action=UPDATE." ";
			}
			else
			{
			$action=ADD." ";
			}
			?>
<div class="form-style-2-heading" style="color:#FF9900;"><?php echo $action.$module; ?></div>
<form name="frmresources" id="frmresources"  action=""  method="post" onSubmit="return validateform()" enctype="multipart/form-data">
<input type="hidden" name="txtparentcd" id="txtparentcd"   value="<?php echo $parentcd; ?>">
<label for="field1"><span><?php echo CODE;?>: <span class="required">*</span></span><input type="text" class="input-field" name="txtitemcode" id="txtitemcode"  value="<?php echo $itemcode; ?>" /></label>
<label for="field2"><span><?php echo NAME;?>: <span class="required">*</span></span><input type="text" class="input-field" name="txtitemname" id="txtitemname" value="<?php echo $itemname; ?>" /></label>
<label for="field4"><span><?php echo IS_ENTRY;?>:</span><select name="txtisentry"  onChange="ShowDataDiv(this.value)" class="select-field">
<option value="0"  <?php if($isentry==0){?>selected="selected"<?php }?>  >No</option>
<option value="1" <?php if($isentry==1){?>selected="selected"<?php }?> >Yes</option>
</select></label>

<div id="data_div" <?php if($isentry==0){?>style="display:none"<?php }?>>
               <?php  $itemid_a=$edit;
			   if(isset($itemid_a)&&$itemid_a!=0&&$itemid_a!='')
			   {
			    
			$sql_a="Select * from activity where itemid=$itemid_a";
			$res_a=mysql_query($sql_a);
			$i=1;
			$row3=mysql_fetch_array($res_a);
			   }
			?>
<label for="field4">
<span>
<?php echo SELECT_RESOR;
?>
:<span class="required">*</span>
</span>

<select name="txtrid" id="selUser" onChange="getQuantity(this.value)"   >
         <?php  
			$sqlg="Select * from baseline ";
			$resg=mysql_query($sqlg);
			?>
			<option value="0"><?php echo SELECT_RESOR;?></option>
			<?php
			while($row3g=mysql_fetch_array($resg))
			{
			
				if($row3g['rid']==$row3['rid'])
				{
				$sele = " selected" ;
				}
				else
				{
				$sele = "" ;
				}
				
				
			?>
			  <option value="<?php echo $row3g['rid'];?>"  <?php echo $sele; ?>><?php echo $row3g['base_code']."-".$row3g['base_desc']; ?> </option>
			  <?php
			  }
			   ?>
			   </select>
               <br/>
         <!--<input type='button' value='Seleted option' id='but_read'>-->
          <div id='result'></div>
        <!-- Script -->
        <script>
        $(document).ready(function(){
            
            // Initialize select2
            $("#selUser").select2();

            // Read selected option
            $('#but_read').click(function(){
                var username = $('#selUser option:selected').text();
                var userid = $('#selUser').val();
           
                $('#result').html("id : " + userid + ", name : " + username);
            });
        });
        </script>
</label>
<label for="field2"><span><?php echo START;?>:</span><input type="text" class="input-field" name="txtstartdate" id="txtstartdate" value="<?php echo $row3['startdate']; ?>" /></label>
<label for="field2"><span><?php echo END;?>:</span><input type="text" class="input-field" name="txtenddate" id="txtenddate" value="<?php echo $row3['enddate']; ?>" /></label>




<?php  
			$u_r_quantity="";
			$itemid_a=$edit;
			   if(isset($itemid_a)&&$itemid_a!=0&&$itemid_a!=''&&$row3['rid']!="")
			   {
			 $sqlgb="Select * from baseline where rid=".$row3['rid'];
			$resgb=mysql_query($sqlgb);  
			$row3gb=mysql_fetch_array($resgb);
			$total_quantity=$row3gb['quantity'];
			$quantity_unit=$row3gb['unit'];
			$sql_au="Select sum(baseline) as used_q from activity where rid=".$row3['rid'];
			$res_au=mysql_query($sql_au);
			$row3u=mysql_fetch_array($res_au);
			$remaining=$total_quantity - $row3u['used_q'];
			
			
			
			$sql_as="Select baseline from activity where itemid=".$itemid_a;
			$res_as=mysql_query($sql_as);
			$row3s=mysql_fetch_array($res_as);
			$u_r_quantity=$remaining+$row3s['baseline'];
			
			   }
			?>

	<input type="hidden" name="h_remaining_quantity" id="h_remaining_quantity"  tabindex="3" class="txtinput" value="<?php echo $total_quantity;?>">
	<label for="field2"><span><?php echo TOTAL;?> <span id="to_qt"></span>:</span><input type="text" class="input-field-unit" name="total_quantity" id="total_quantity" value="<?php echo $total_quantity;?>"  readonly=""/>
	<input type="text" class="input-field-unit1" name="quantity_unit" id="quantity_unit" value="<?php echo $quantity_unit;?>"  readonly=""/>	
	</label>
	<label for="field2"><span><?php echo TOTAL_AVAIL;?> <span id="to_av_qt"></span>:</span><input type="text" class="input-field-unit" name="remaining_quantity" id="remaining_quantity" value="<?php echo $remaining;?>"  readonly=""/>
	<input type="text" class="input-field-unit1" name="quantity_unit_r" id="quantity_unit_r" value="<?php echo $quantity_unit;?>"  readonly=""/></label>			
	<input type="hidden" name="u_r_quantity" id="u_r_quantity"  value="<?php echo $u_r_quantity; ?>">
	<label for="field2"><span><?php echo ALOCATED;?> <span id="to_al_qt"></span>:</span><input type="text" class="input-field-unit" name="used_quantity" id="used_quantity" value="<?php echo $row3['baseline']; ?>" onKeyUp="showResult(remaining_quantity.value,this.value,h_remaining_quantity.value,u_r_quantity.value,<?php echo $itemid_a ?>)"/>
	<input type="text" class="input-field-unit1" name="quantity_unit_a" id="quantity_unit_a" value="<?php echo $quantity_unit;?>"  readonly=""/></label>
			
			<?php
			$remaining="";	
			$total_quantity="";
			?>
			</div>

 <?php
			  if($edit!=""){?>
			  <input type="submit" name="update" id="resetbtn"  value="<?php echo UPDATE;?>">
			
			<?php } else { ?>
			<input type="submit" name="save" id="submitbtn"   value="<?php echo SAVE;?>">
			
			 <?php } ?>

</form>
</div>
</body>
</html>
<?php
	$objDb  -> close( );
?>
