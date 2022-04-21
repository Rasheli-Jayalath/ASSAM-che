<?php
error_reporting(E_ALL & ~E_NOTICE);
@require_once("requires/session.php");
$module			= PROJECT;
if ($uname==null)
{
	header("Location:index.php?init=3");
}
else if ($padm_flag==0)
{
	header("Location: index.php?init=3");
}
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
$revert			= $_GET['revert'];
$objDb  		= new Database( );
$objSDb  		= new Database( );
$objVSDb  		= new Database( );
$objCSDb  		= new Database( );
$objPD  		= new Database( );
$objIC   		= new Database( );
@require_once("get_url.php");
$msg						= "";
$saveBtn					= $_REQUEST['save']; 
$updateBtn					= $_REQUEST['update'];
$clear						= $_REQUEST['clear'];
$next						= $_REQUEST['next'];
$txtstage				 	= "Project";
$base_cur				= $_REQUEST['base_cur'];
$cur_1					= $_REQUEST['cur_1'];
$cur_1_rate			    = trim($_REQUEST['cur_1_rate']);
$cur_2					= $_REQUEST['cur_2'];
$cur_2_rate				= trim($_REQUEST['cur_2_rate']);
$cur_3					= $_REQUEST['cur_3'];
$cur_3_rate				= trim($_REQUEST['cur_3_rate']);
$txtpcode				= $_REQUEST['txtpcode'];
$txtpdetail				= $_REQUEST['txtpdetail'];
$ptype				= $_REQUEST['txtptype'];
$txtpstart				= date('Y-m-d',strtotime($_REQUEST['txtpstart']));
$txtpend				= date('Y-m-d',strtotime($_REQUEST['txtpend']));
$client					= $_REQUEST['client'];
$funding_agency			= $_REQUEST['funding_agency'];
$contractor				= $_REQUEST['contractor'];
$pcost				    =str_replace(',','',$_REQUEST['pcost']);
$sector_id				= $_REQUEST['sector_id'];
$country_id				= $_REQUEST['country_id'];
$location				= $_REQUEST['location'];
$consultant				= $_REQUEST['consultant'];
$smec_code				= $_REQUEST['smec_code'];
if($clear!="")
{
$txtpcode 				= '';
$txtpdetail 				= '';
$txtpstart					= '';
$client                    ='';
$funding_agency='';
$contractor='';
$pcost=0;
}

$ffSql = "Select * from project";
  $objPD  -> query($ffSql);
  $ffCount = $objPD ->getCount();
	if($ffCount > 0){
	  
	  $pstart 					= $objPD ->getField($i,pstart);
	  $pend 					= $objPD ->getField($i,pend);

	}
	  
if($saveBtn != "")
{

 $sSQLc = ("INSERT INTO project_currency(base_cur,cur_1,cur_1_rate,cur_2,cur_2_rate,cur_3,cur_3_rate)VALUES('$base_cur','$cur_1','$cur_1_rate','$cur_2','$cur_2_rate','$cur_3','$cur_3_rate')");
	$objIC->execute($sSQLc);

	
 $sSQL = ("INSERT INTO project (pcode,pdetail,ptype, pstart,pend,client,funding_agency,contractor,pcost,sector_id,country_id,location,consultant,smec_code)VALUES('$txtpcode','$txtpdetail','$ptype','$txtpstart','$txtpend','$client','$funding_agency','$contractor','$pcost','$sector_id','$country_id','$location','$consultant','$smec_code')");
	$objDb->execute($sSQL);
	$txtid = $objDb->getAutoNumber();
	$pid = $txtid;
	
	 #Check if the new dates are added
			$arr_yh_title 	= $_POST['yh_title'];
			$arr_yh_date 	= $_POST['yh_date'];
			$arr_yh_status 	= $_POST['yh_status'];
			if(count($arr_yh_title) >= 1 && count($arr_yh_date) == count($arr_yh_status)){
				for($i = 0; $i < count($arr_yh_title); $i++){
					if($arr_yh_title[$i] != "" && $arr_yh_date[$i] != "" && $arr_yh_status[$i] != ""){
						
						$yh_title 	= $arr_yh_title[$i];
						$yh_status	= $arr_yh_status[$i];
						$yh_date	= date('Y-m-d',strtotime($arr_yh_date[$i]));
						$yhSQL = ("INSERT INTO yearly_holidays(yh_title,yh_date,yh_status,pid) VALUES('$yh_title','$yh_date','$yh_status',$pid)");
						$objDb->execute($yhSQL);
					}
				}
			}
			$status=0;
			$yhSQLD = ("update weekdays SET status=0");
			$objDb->execute($yhSQLD);
			$arr_working_days 	= $_REQUEST['working_days'];
			$swSQL = " Select * from weekdays";
 			$objDb->query($swSQL);
			 $iwCount = $objDb->getCount( );
			 $wd_id						= $objDb->getField($i,wd_id);
	 		 $wd_day					= $objDb->getField($i,wd_day);
	  		 $status	 				= $objDb->getField($i,status);
			count($arr_working_days);
						foreach($arr_working_days as $work_day)
						{
				$yhSQL = ("update weekdays SET status=1 where wd_id=$work_day ");
						$objDb->execute($yhSQL);
						}
			
////////////////////////// Make Project Data

$pSql="INSERT INTO project_days (pd_date,pd_status) select v.selected_date, if(y.yh_status=0,y.yh_status,w.status)from 
(select adddate('1970-01-01',t4*10000 + t3*1000 + t2*100 + t1*10 + t0) selected_date from
(select 0 t0 union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t0,
(select 0 t1 union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t1,
(select 0 t2 union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t2,
(select 0 t3 union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t3,
(select 0 t4 union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t4) v left outer join weekdays w on (WEEKDAY(v.selected_date)=w.wd_day) left outer join yearly_holidays y on (v.selected_date=y.yh_date) 
where v.selected_date between '".$txtpstart."' and '".$txtpend."' order by v.selected_date";
$objDb->execute($pSql);

 $sSQLc = ("INSERT INTO t031project_albums(parent_album,parent_group,pid,album_name,status)VALUES('0','001','1','Photos/Videos','1')");
	$objIC->execute($sSQLc);


//include("basetable.php");
header("location: project_calender.php");
}
$objbck  		= new Database( );
$objrvt1  		= new Database( );
$objrvt2  		= new Database( );
$objrvt3  		= new Database( );
if($revert!="")
{

		$q13="TRUNCATE project";
		$objrvt1 ->query($q13) or die('ERROR');
		$q12="INSERT INTO project SELECT * FROM project_backup";
		$objrvt2 ->query($q12);	
		$q11="TRUNCATE project_backup ";
		$objrvt3 ->query($q11);
		
		$q14="TRUNCATE project_days";
		$objrvt1 ->query($q14) or die('ERROR');
		$q15="INSERT INTO project_days SELECT * FROM project_days_backup";
		$objrvt2 ->query($q15);	
		$q16="TRUNCATE project_days_backup ";
		$objrvt3 ->query($q16);
		

		$q20="TRUNCATE planned";
		$objrvt1 ->query($q20) or die('ERROR');
		$q21="INSERT INTO planned SELECT * FROM planned_backup";
		$objrvt2 ->query($q21);	
		$q22="TRUNCATE planned_backup ";
		$objrvt3 ->query($q22);
		
		
		$q23="TRUNCATE weekdays";
		$objrvt1 ->query($q23) or die('ERROR');
		$q24="INSERT INTO weekdays SELECT * FROM weekdays_backup";
		$objrvt2 ->query($q24);	
		$q25="TRUNCATE weekdays_backup ";
		$objrvt3 ->query($q25);
		
		$q26="TRUNCATE kpiscale";
		$objrvt1 ->query($q26) or die('ERROR');
		$q27="INSERT INTO kpiscale SELECT * FROM kpiscale_backup";
		$objrvt2 ->query($q27);	
		$q28="TRUNCATE kpiscale_backup ";
		$objrvt3 ->query($q28);
		
	header("location: project_calender.php");
	}
if($updateBtn !=""){
	
	$objDbPC 		= new Database( );
	$pid=$edit;
  $uSql ="Update project_currency SET 
			base_cur        		= '$base_cur',
			 cur_1  				= '$cur_1',
			 cur_1_rate             = '$cur_1_rate',
			 cur_2					= '$cur_2',
			 cur_2_rate				= '$cur_2_rate'	,
			 cur_3					= '$cur_3',
			 cur_3_rate				= '$cur_3_rate'				
			where pcid 				= $pid";
		  
 	if($objDbPC->execute($uSql)){
	
		}
	if($txtpstart!=$pstart||$txtpend!=$pend)
	{
		$q1="TRUNCATE project_backup ";
		$objbck ->query($q1);
		$q2="INSERT INTO project_backup SELECT * FROM project";
		$objbck ->query($q2);	
		$q3="TRUNCATE project_days_backup ";
		$objbck ->query($q3);
		$q4="INSERT INTO project_days_backup SELECT * FROM project_days";
		$objbck ->query($q4);	
		$q5="TRUNCATE planned_backup ";
		$objbck ->query($q5);
		$q6="INSERT INTO planned_backup SELECT * FROM planned";
		$objbck ->query($q6);
		$q7="TRUNCATE weekdays_backup ";
		$objbck ->query($q7);
		$q8="INSERT INTO weekdays_backup SELECT * FROM weekdays";
		$objbck ->query($q8);
		$q9="TRUNCATE kpiscale_backup ";
		$objbck ->query($q9);
		$q10="INSERT INTO kpiscale_backup SELECT * FROM  kpiscale";
		$objbck ->query($q10);
		
		
	}
	
	////////////////////// Change Planned Data//////////////////////////
$objDbP 		= new Database( );
$objDbPP		= new Database( );

if($txtpstart>$pstart)
{
$d1_m=date('m',	strtotime($txtpstart));
$d1_y=date('Y',	strtotime($txtpstart));
$d1_d=cal_days_in_month(CAL_GREGORIAN, $d1_m, $d1_y);
$txtpstart=$d1_y."-".$d1_m."-".$d1_d;
$d2_m=date('m',	strtotime($pstart));
$d2_y=date('Y',	strtotime($pstart));
$d2_d=cal_days_in_month(CAL_GREGORIAN, $d2_m, $d2_y);
$pstart=$d2_y."-".$d2_m."-".$d2_d;
$d1 = strtotime($txtpstart);
$d2 = strtotime($pstart);
 $min_date = min($d1, $d2);
 $max_date = max($d1, $d2);
$min_date = strtotime("-2 MONTH", $min_date);
$max_date = strtotime("-1 MONTH", $max_date);
while (($min_date = strtotime("+1 MONTH", $min_date)) < $max_date) {

  $eSqls = "Select itemid,aid,rid from activity ";
  $objDbP  -> query($eSqls);
	$iCount = $objDbP->getCount( );
 if($iCount>0)
 {
	for ($i = 0 ; $i < $iCount; $i ++)
	{
		$aid 	= $objDbP->getField($i,aid);
		$rid 	= $objDbP->getField($i,rid);
		$itemid 	= $objDbP->getField($i,itemid);
		 $planned_date=date('Y-m-d',$min_date);
		 $planned_date_m=date('m',strtotime($planned_date));
		 $planned_date_y=date('Y',strtotime($planned_date));
		$planned_date_d=cal_days_in_month(CAL_GREGORIAN, $planned_date_m, $planned_date_y);
		 $planned_date=$planned_date_y."-".$planned_date_m."-".$planned_date_d;
		$qq="DELETE FROM planned WHERE itemid='$itemid ' AND  rid='$rid' AND budgetdate='$planned_date'";
		$objDbPP->execute($qq);
		
	}
 }
   $i++;
}	// end while
}
if($pstart>$txtpstart)
{
$d1_m=date('m',	strtotime($txtpstart));
$d1_y=date('Y',	strtotime($txtpstart));
$d1_d=cal_days_in_month(CAL_GREGORIAN, $d1_m, $d1_y);
$txtpstart=$d1_y."-".$d1_m."-".$d1_d;
$d2_m=date('m',	strtotime($pstart));
$d2_y=date('Y',	strtotime($pstart));
$d2_d=cal_days_in_month(CAL_GREGORIAN, $d2_m, $d2_y);
$pstart=$d2_y."-".$d2_m."-".$d2_d;
$d1 = strtotime($txtpstart);
$d2 = strtotime($pstart);
$min_date = min($d1, $d2);
$max_date = max($d1, $d2);
$min_date = strtotime("-2 MONTH", $min_date);
$max_date = strtotime("-1 MONTH", $max_date);
while (($min_date = strtotime("+1 MONTH", $min_date)) <= $max_date) {
  $eSqls = "Select itemid,aid,rid from activity ";
  $objDbP  -> query($eSqls);
	$iCount = $objDbP->getCount( );
 if($iCount>0)
 {
	for ($i = 0 ; $i < $iCount; $i ++)
	{
		$aid 	= $objDbP->getField($i,aid);
		$rid 	= $objDbP->getField($i,rid);
		$itemid 	= $objDbP->getField($i,itemid);
		 $planned_date=date('Y-m-d',$min_date);
		 $planned_date_m=date('m',strtotime($planned_date));
		 $planned_date_y=date('Y',strtotime($planned_date));
		$planned_date_d=cal_days_in_month(CAL_GREGORIAN, $planned_date_m, $planned_date_y);
		 $planned_date=$planned_date_y."-".$planned_date_m."-".$planned_date_d;
		 $qq="INSERT INTO planned (itemid,rid,budgetdate,budgetqty) VALUES ('$itemid ', '$rid', '$planned_date', 0)";
		
		$objDbPP->execute($qq);
	}
 }
   $i++;
}	// end while
}
if($txtpend>$pend)
{
$d1_m=date('m',	strtotime($pend));
$d1_y=date('Y',	strtotime($pend));
$d1_d=cal_days_in_month(CAL_GREGORIAN, $d1_m, $d1_y);
$pend=$d1_y."-".$d1_m."-".$d1_d;
$d2_m=date('m',	strtotime($txtpend));
$d2_y=date('Y',	strtotime($txtpend));
$d2_d=cal_days_in_month(CAL_GREGORIAN, $d2_m, $d2_y);
$txtpend=$d2_y."-".$d2_m."-".$d2_d;
$d1 = strtotime($pend);
$d2 = strtotime($txtpend);
$min_date = min($d1, $d2);
$max_date = max($d1, $d2);
$min_date = strtotime("-1 MONTH", $min_date);
//$max_date = strtotime("-1 MONTH", $max_date);
while (($min_date = strtotime("+1 MONTH", $min_date)) <= $max_date) {
  $eSqls = "Select itemid,aid,rid from activity ";
  $objDbP  -> query($eSqls);
	$iCount = $objDbP->getCount( );
 if($iCount>0)
 {
	for ($i = 0 ; $i < $iCount; $i ++)
	{
		$aid 	= $objDbP->getField($i,aid);
		$rid 	= $objDbP->getField($i,rid);
		$itemid 	= $objDbP->getField($i,itemid);
		 $planned_date=date('Y-m-d',$min_date);
		 $planned_date_m=date('m',strtotime($planned_date));
		 $planned_date_y=date('Y',strtotime($planned_date));
		$planned_date_d=cal_days_in_month(CAL_GREGORIAN, $planned_date_m, $planned_date_y);
		 $planned_date=$planned_date_y."-".$planned_date_m."-".$planned_date_d;
		 $qq="INSERT INTO planned (itemid,rid,budgetdate,budgetqty) VALUES ('$itemid ', '$rid', '$planned_date', 0)";
		
		$objDbPP->execute($qq);
	}
 }
   $i++;
}	// end while
}
if($txtpend<$pend)
{
$d1_m=date('m',	strtotime($pend));
$d1_y=date('Y',	strtotime($pend));
$d1_d=cal_days_in_month(CAL_GREGORIAN, $d1_m, $d1_y);
$pend=$d1_y."-".$d1_m."-".$d1_d;
$d2_m=date('m',	strtotime($txtpend));
$d2_y=date('Y',	strtotime($txtpend));
$d2_d=cal_days_in_month(CAL_GREGORIAN, $d2_m, $d2_y);
$txtpend=$d2_y."-".$d2_m."-".$d2_d;
$d1 = strtotime($pend);
$d2 = strtotime($txtpend);
$min_date = min($d1, $d2);
$max_date = max($d1, $d2);
$min_date = strtotime("-2 MONTH", $min_date);
$max_date = strtotime("-1 MONTH", $max_date);
while (($min_date = strtotime("+1 MONTH", $min_date)) <= $max_date) {
  $eSqls = "Select itemid,aid,rid from activity ";
  $objDbP  -> query($eSqls);
	$iCount = $objDbP->getCount( );
 if($iCount>0)
 {
	for ($i = 0 ; $i < $iCount; $i ++)
	{
		$aid 	= $objDbP->getField($i,aid);
		$rid 	= $objDbP->getField($i,rid);
		$itemid = $objDbP->getField($i,itemid);
		 $planned_date=date('Y-m-d',$min_date);
		  $planned_date_m=date('m',strtotime($planned_date));
		 $planned_date_y=date('Y',strtotime($planned_date));
		$planned_date_d=cal_days_in_month(CAL_GREGORIAN, $planned_date_m, $planned_date_y);
		  $planned_date=$planned_date_y."-".$planned_date_m."-".$planned_date_d;
		 $qq="DELETE FROM planned WHERE itemid='$itemid ' AND  rid='$rid' AND budgetdate='$planned_date'";
		$objDbPP->execute($qq);
	}
 }
   
}	// end while
}
	
	$pid=$edit;
 $uSql ="Update project SET 
			 pcode         		= '$txtpcode',
			 pdetail  			= '$txtpdetail',
			 ptype  			= '$ptype',
			 client             = '$client',
			 funding_agency		= '$funding_agency',
			 contractor			= '$contractor',
			 pcost				= '$pcost',
			 sector_id			= '$sector_id',
			 country_id			= '$country_id',
			 location           = '$location',
			 consultant			= '$consultant',
			 smec_code			= '$smec_code',
			 pstart				= '$txtpstart',
			 pend				= '$txtpend'				
			where pid 			= $edit ";
		  
 	if($objDb->execute($uSql)){
	$eSql_l = "Select * from project where pid='$edit'";
  	$objDb -> query($eSql_l);
  	$eCount1 = $objDb->getCount();
		}
		# See if any child to be deleted (checked for deletion)
			$arr_yh_ids = $_POST['yh_id'];
			if(count($arr_yh_ids) >= 1){
				for($i = 0; $i < count($arr_yh_ids); $i++){
					$yh_id 	= $arr_yh_ids[$i];
					 $yhDSQL = ("DELETE FROM yearly_holidays where yh_id=$yh_id");
						$objDb->execute($yhDSQL);
				}
			}
			# See if any sizes are updated
			$swwSQL = " Select * from yearly_holidays ";
							 $objSDb->query($swwSQL);
							  $iiCount = $objSDb->getCount( );
					 if($iiCount>0)
					 {
						for ($j = 0 ; $j < $iiCount; $j ++)
						{
							
						 $yh_id= $objSDb->getField($j,yh_id);
						if($_POST['yh_title_' . $yh_id] && $_POST['yh_date_'. $yh_id])
						{
							
						$yh_title 	= $_POST['yh_title_' .$yh_id];
						$yh_status	= $_POST['yh_status_' . $yh_id];
						$yh_date 	= date('Y-m-d',strtotime($_POST['yh_date_' . $yh_id]));
						$yhSQL = ("Update yearly_holidays SET yh_title='$yh_title',yh_date='$yh_date',yh_status='$yh_status'  where yh_id=$yh_id");
						$objDb->execute($yhSQL);
						
					  }
				}
			}
			
	 #Check if the new dates are added
			$arr_yh_title 	= $_POST['yh_title'];
			$arr_yh_date 	= $_POST['yh_date'];
			$arr_yh_status 	= $_POST['yh_status'];
			if(count($arr_yh_title) >= 1 && count($arr_yh_date) == count($arr_yh_status)){
				for($i = 0; $i < count($arr_yh_title); $i++){
				if($arr_yh_title[$i] != "" && $arr_yh_date[$i] != "" && $arr_yh_status[$i] != ""){
						$yh_title 	= $arr_yh_title[$i];
						$yh_status	= $arr_yh_status[$i];
						$yh_date	= date('Y-m-d',strtotime($arr_yh_date[$i]));
						 $yhSQL = ("INSERT INTO yearly_holidays(yh_title,yh_date,yh_status,pid) VALUES('$yh_title','$yh_date','$yh_status',$pid)");
						$objDb->execute($yhSQL);
					}
				}
			}
	$status=0;
			$arr_working_days 	= $_REQUEST['working_days'];
			$swSQL = " Select * from weekdays";
 			$objDb->query($swSQL);
			 $iwCount = $objDb->getCount( );
		
				  $yhSQLD = ("update weekdays SET status=0");
				 $objDb->execute($yhSQLD);
			
			 $wd_id						= $objDb->getField($i,wd_id);
	 		 $wd_day					= $objDb->getField($i,wd_day);
	  		 $status	 				= $objDb->getField($i,status);
			
						foreach($arr_working_days as $work_day)
						{
			$yhSQL = ("update weekdays SET status=1 where wd_id=$work_day ");
				
						$objDb->execute($yhSQL);
						}
						$objDb->execute("TRUNCATE project_days");
						$pSql="INSERT INTO project_days (pd_date,pd_status) select v.selected_date, if(y.yh_status=0,y.yh_status,w.status)from 
(select adddate('1970-01-01',t4*10000 + t3*1000 + t2*100 + t1*10 + t0) selected_date from
(select 0 t0 union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t0,
(select 0 t1 union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t1,
(select 0 t2 union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t2,
(select 0 t3 union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t3,
(select 0 t4 union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t4) v left outer join weekdays w on (WEEKDAY(v.selected_date)=w.wd_day) left outer join yearly_holidays y on (v.selected_date=y.yh_date) 
where v.selected_date between '".$txtpstart."' and '".$txtpend."' order by v.selected_date";
$objDb->execute($pSql);
/*if($txtpstart!=$pstart||$txtpend!=$pend)
	{*/
//include("basetable_update.php");
	//}

header("location: project_calender.php");
}
 $eSql = "Select * from project";
  $objDb -> query($eSql);
  $eCount = $objDb->getCount();
	if($eCount > 0){
	  $pid 						= $objDb->getField($i,pid);
	  $pcode 					= $objDb->getField($i,pcode);
	  $pname	 				= $objDb->getField($i,pname);
	  $pdetail					= $objDb->getField($i,pdetail);
	  $ptype					= $objDb->getField($i,ptype);
	  $pstart 					= $objDb->getField($i,pstart);
	  $pend 					= $objDb->getField($i,pend);
	  $client					= $objDb->getField($i,client);
	  $funding_agency			= $objDb->getField($i,funding_agency);
	  $contractor				= $objDb->getField($i,contractor);
	  $pcost					= $objDb->getField($i,pcost);
	  $ssector_id				= $objDb->getField($i,sector_id);
	  if($ssector_id!=0)
	  {
		  $sssSql = "Select * from rs_tbl_sectors where sector_id='$ssector_id'";
		  $objVSDb -> query($sssSql);
		  $sssCount = $objVSDb->getCount();
			if($sssCount > 0){
			  $sector_name = $objVSDb->getField($i,sector_name);
			}
	  }
	  $scountry_id				= $objDb->getField($i,country_id);
	  if($scountry_id!=0)
	  {
		  $cccSql = "Select * from rs_tbl_countries where country_id='$scountry_id'";
		  $objCSDb -> query($cccSql);
		  $cccCount = $objCSDb->getCount();
			if($cccCount > 0){
			  $country_name = $objCSDb->getField($i,country_name);
			}
	  }
	  $consultant				= $objDb->getField($i,consultant);
	  $location				    = $objDb->getField($i,location);
	  $smec_code				= $objDb->getField($i,smec_code);
	}
	
	 $cSqls = "Select * from project_currency ";
			    $objDb -> query($cSqls);
			    $eeCount = $objDb->getCount();
			    if($eeCount > 0){
			    $cur_1_rate 					= $objDb->getField(0,cur_1_rate);
			    $cur_2_rate 					= $objDb->getField(0,cur_2_rate);
				$cur_3_rate 					= $objDb->getField(0,cur_3_rate);
			    $cur_1 					= $objDb->getField(0,cur_1);
			    $cur_2 					= $objDb->getField(0,cur_2);
				$cur_3 					= $objDb->getField(0,cur_3);
			    $base_cur 					= $objDb->getField(0,base_cur);
				}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include ('includes/metatag.php'); ?>

<link rel="stylesheet" type="text/css" href="css/style.css">

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.js"></script>
<script type="text/javascript" src="scripts/JsCommon.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="datepickercode/jquery-ui.css" />
  <script type="text/javascript" src="datepickercode/jquery-1.10.2.js"></script>
  <script type="text/javascript" src="datepickercode/jquery-ui.js"></script>
<script>
function showResult(strmodule,strstage,stritemcode,stritemname,strweight,strisentry) {
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else {  // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
	
      document.getElementById("search").innerHTML=xmlhttp.responseText;
      document.getElementById("search").style.border="1px solid #A5ACB2";
	   document.getElementById("without_search").style.display="none";
	  document.getElementById("without_search").disabled=true;
	// document.getElementById("without_search").removeClass("checkbox").addClass("");
	  var nodes = document.getElementById("without_search").getElementsByTagName('*');
			for(var i = 0; i < nodes.length; i++){
			 $("#cvcheck").attr( "class", "" ); 
				 nodes[i].disabled = true;
			}
	 
    }
  }
  xmlhttp.open("GET","search.php?module="+strmodule+"&stage="+strstage+"&itemcode="+stritemcode+"&itemname="+stritemname+"&weight="+strweight+"&isentry="+strisentry,true);
  xmlhttp.send();
}

</script>
<script type="text/javascript">
		 
 $(function() {
   $('#txtpstart').datepicker({ dateFormat: 'yy-mm-dd' }).val();
  });
   $(function() {
    $('#txtpend').datepicker({ dateFormat: 'yy-mm-dd' }).val();
  });
$("#datepicker1,#datepicker2").datepicker({dateFormat: 'dd-mm-yy', minDate: 0});

</script>
<script>
function atleast_onecheckbox(e) {
  if ($("input[type=checkbox]:checked").length === 0) {
      e.preventDefault();
      alert('Please check atleast on record');
      return false;
  }
}
</script>
<script>
function group_checkbox2()
{
	var select_all = document.getElementById("txtChkAll2"); //select all checkbox
	var checkboxes = document.getElementsByClassName("checkbox2"); //checkbox items
	
	//select all checkboxes
	select_all.addEventListener("change", function(e){
		for (i = 0; i < checkboxes.length; i++) {
			checkboxes[i].checked = select_all.checked;
		}
	});
	
	
	for (var i = 0; i < checkboxes.length; i++) {
		checkboxes[i].addEventListener('change', function(e){ //".checkbox" change
			//uncheck "select all", if one of the listed checkbox item is unchecked
			if(this.checked == false){
				select_all.checked = false;
			}
			//check "select all" if all checkbox items are checked
			if(document.querySelectorAll('.with_search .checkbox2:checked').length == checkboxes.length){
				select_all.checked = true;
			}
		});
	}
}
</script>
<script>
function group_checkbox()
{
	var select_all = document.getElementById("txtChkAll"); //select all checkbox
	var checkboxes = document.getElementsByClassName("checkbox"); //checkbox items
	
	//select all checkboxes
	select_all.addEventListener("change", function(e){
		for (i = 0; i < checkboxes.length; i++) {
			checkboxes[i].checked = select_all.checked;
		}
	});
	
	
	for (var i = 0; i < checkboxes.length; i++) {
		checkboxes[i].addEventListener('change', function(e){ //".checkbox" change
			//uncheck "select all", if one of the listed checkbox item is unchecked
			if(this.checked == false){
				select_all.checked = false;
			}
			//check "select all" if all checkbox items are checked
			if(document.querySelectorAll('.checkbox:checked').length == checkboxes.length){
				select_all.checked = true;
			}
		});
	}
}

function AddNewSize(){
	var td1 = '<a href="javascript:void(null);" onClick="doRmTr(this);" title="Remove size">[X]</a>';
	var td2 = '<input type="text" name="yh_title[]" size="25" />';
	var td3 = '<input type="text" name="yh_date[]" style="text-align:right;" size="15" id="datepicker3"/>';
	var td4 = '<select name="yh_status[]">' + "\n";
	td4 	+= "\t" + '<option value="1">Active</option>' + "\n";
	td4 	+= "\t" + '<option value="0">Inactive</option>' + "\n";
	td4 	+= '</select>' + "\n";
	
	var arrTds = new Array(td1, td2, td3, td4);
	doAddTr(arrTds, 'tblPrdSizes');
}


function CheckProjectDetail(frm){
	var msg = "<?php echo "Please do the following:";?>\r\n-----------------------------------------";
	var flag = true;

	if(frm.txtpdetail.value == ""){
		msg = msg + "\r\n<?php echo "Project Detail is required field";?>";
		flag = false;
	}
	if(frm.txtpstart.value == ""){
		msg = msg + "\r\n<?php echo "Project Start Date is required field";?>";
		flag = false;
	}
	if(frm.txtpend.value == ""){
		msg = msg + "\r\n<?php echo "Project End Date is required field";?>";
		flag = false;
	}
	
	if(flag == false){
		alert(msg);
		return false;
	}
}
</script>


</head>
<body>

<div id="wrap">
  <?php include 'includes/header.php'; ?>
<div id="content">
	  <form name="frmstgoal" id="frmstgoal" action=""  method="post" 
      onsubmit="return CheckProjectDetail(this)" enctype="multipart/form-data">
	  
<table class="reference" width="100%" cellspacing="0" >
      
       			<?php
			if(isset($_REQUEST['edit']))
			{
			$action="Update ";
			}
			else
			{
			$action="Add ";
			}
		 	$objDbr = new Database( );
		 	$fSql = "Select * from project_backup";
		 	$objDbr -> query($fSql);
		 	$rCount = $objDbr->getCount();
			if($rCount > 0)
			{
			  $rpid = $objDbr->getField($i,pid);
			}
			else
			{
				$rpid ="";
			}
			?>
			
            <tr >
            <th> <?php echo $action."Project Details:"; ?></th>
            <th colspan="3" style="text-align:right; color:#FFF"> <?php if($pid != ""&&$pid!=0){?> <a href="project_calender.php?edit=<?php echo $pid;?>"  class="button">Change Project Detail</a><?php }?><?php if($rpid!="") {?><a href="project_calender.php?revert=<?php echo $rpid;?>"  class="button" >Revert Changes</a><?php }?></th>
            </tr>
                  
           <?php if((isset($pid)&&$pid!=""&&$pid!=0)&&(!isset($_REQUEST['edit'])&&$_REQUEST['edit']==""))
			{
				$cSqls = "Select * from project_currency ";
  $objDb -> query($cSqls);
  $eeCount = $objDb->getCount();
	if($eeCount > 0){
	  $cur_1_rate 					= $objDb->getField(0,cur_1_rate);
	  $cur_2_rate 					= $objDb->getField(0,cur_2_rate);
	  $cur_3_rate 					= $objDb->getField(0,cur_3_rate);
	  $cur_1 					= $objDb->getField(0,cur_1);
	  $cur_2 					= $objDb->getField(0,cur_2);
	  $cur_3 					= $objDb->getField(0,cur_3);
	  $base_cur 					= $objDb->getField(0,base_cur);
	  }
	?>
      
            <tr>
              <td width="16%" class="labelp"><strong>Project code:</strong></td>
              <td colspan="3" ><?php echo $pcode; ?></td>
        </tr>
            <tr>
              <td class="labelp" ><strong>Project Name:</strong></td>
              <td colspan="3" style="line-height:20px"><?php echo $pdetail; ?></td>
            </tr>
             <tr>
              <td class="labelp" ><strong>Project Type:</strong></td>
              <td colspan="3" ><?php if($ptype==1) echo "Time-Based";
			  elseif($ptype==2) echo "Milestone"; ?></td>
            </tr>
            <tr>
              <td class="labelp"><strong>Start Date:</strong></td>
              <td colspan="3" ><?php echo date("d-m-Y", strtotime($pstart)); ?></td>
        </tr>
			 <tr>
              <td class="labelp"><strong>End Date:</strong></td>
              <td colspan="3" ><?php echo date("d-m-Y", strtotime($pend)); ?></td>
             </tr>
              <tr>
              <td class="labelp"><strong>Client:</strong></td>
              <td colspan="3" ><?php echo $client; ?></td>
             </tr>
               <tr>
              <td class="labelp"><strong>Consultant:</strong></td>
              <td colspan="3" ><?php echo $consultant; ?></td>
             </tr>
             <tr>
              <td class="labelp"><strong>Funding Agency:</strong></td>
              <td colspan="3" ><?php echo $funding_agency; ?></td>
             </tr>
             <tr>
              <td class="labelp"><strong>Contractor:</strong></td>
              <td colspan="3" ><?php echo $contractor; ?></td>
             </tr>
             <tr>
              <td class="labelp"><strong>Contract Value:</strong></td>
              <td colspan="3" ><?php echo number_format($pcost,0); ?></td>
             </tr>
             <tr>
              <td class="labelp"><strong>Sector:</strong></td>
              <td colspan="3" ><?php echo $sector_name; ?></td>
             </tr>
             <tr>
              <td class="labelp"><strong>Country:</strong></td>
              <td colspan="3" ><?php echo $country_name; ?></td>
             </tr>
             <tr>
              <td class="labelp"><strong>Location:</strong></td>
              <td colspan="3" ><?php echo $location; ?></td>
             </tr>
             <tr>
              <td class="labelp"><strong>SMEC Code:</strong></td>
              <td colspan="3" ><?php echo $smec_code; ?></td>
             </tr>
              <tr>
              <td class="labelp"><strong>Project Currencies:</strong></td>
              <td colspan="3" ><table><tr><td colspan="2"><?php echo "<strong>Base Currency:</strong> ".$base_cur;?></td></tr>
              <tr><td><?php echo "<strong>Currency 1:</strong> ".$cur_1;?></td>
              <td><?php echo "<strong>Rate:</strong> ".$cur_1_rate;?></td></tr>
              <?php if($cur_2!="")
			  {?>
              <tr><td><?php echo "<strong>Currency 2:</strong> ".$cur_2;?></td>
              <td><?php echo "<strong>Rate:</strong> ".$cur_2_rate;?></td></tr>
              <?php }?>
              <?php if($cur_3!="")
			  {?>
              <tr><td><?php echo "<strong>Currency 3:</strong> ".$cur_3;?></td>
              <td><?php echo "<strong>Rate:</strong> ".$cur_3_rate;?></td></tr>
              <?php }?>
              </table></td>
             </tr>
			 <tr>
			  <td class="labelp"><strong>Working Days:</strong></td>
              <td colspan="3" >
             
              		 <?php  $swSQL = " Select * from weekdays ";
							 $objDb->query($swSQL);
							 $iCount = $objDb->getCount( );
							 if($iCount>0)
							 {
								for ($i = 0 ; $i < $iCount; $i ++)
								{
								  $wd_id						= $objDb->getField($i,wd_id);
								  $wd_day						= $objDb->getField($i,wd_day);
								  $wd_detail					= $objDb->getField($i,wd_detail);
								  $status						= $objDb->getField($i,status);
								  ?>
                                  <?php if($status==1) { 
								  echo $wd_detail; 
								  if($i < $iCount-1)
								  {
								  echo ", ";
								  }
								  }?>
                                  <?php
								}
							}
						?>
         
	
              </td>
             </tr>
             <tr>
			  <td class="labelp"><strong>Annual Holidays:</strong></td>
              <td colspan="3" >
             
              		 <?php  $swSQL = " Select * from yearly_holidays where yh_status=0 ";
							 $objDb->query($swSQL);
							  $iCount = $objDb->getCount( );
							 if($iCount>0)
							 {
								for ($i = 0 ; $i < $iCount; $i ++)
								{
								  $yh_id						= $objDb->getField($i,yh_id);
								  $yh_title						= $objDb->getField($i,yh_title);
								  $yh_date					= $objDb->getField($i,yh_date);
								  $yh_status				= $objDb->getField($i,yh_status);
								  ?>
                                  <?php if($yh_status==0) { 
								  echo $yh_title." - ".date("d-m-Y",strtotime($yh_date)); 
								  if($i < $iCount-1)
								  {
								  echo ", ";
								  }
								  }?>
                                  <?php
								}
							}
						?>
         
	
              </td>
             </tr>
			
      
      
	<?php }
	else
	{
	?>
			
    <tr>
              <td width="16%" class="labelp"><strong>Project code:</strong></td>
              <td colspan="3" ><input id="txtpcode" name="txtpcode" type="text" value="<?php echo $pcode; ?>"/></td>
            </tr>
            <tr>
              <td class="labelp"><strong>Project Name:<span style="color:#FF0000;">*</span></strong></td>
              <td colspan="3" ><input id="txtpdetail" name="txtpdetail" type="text" 
              value="<?php echo $pdetail; ?>" style="width:300px"/></td>
            </tr>
             <tr>
              <td class="labelp"><strong>Project Type:<span style="color:#FF0000;">*</span>:</strong></td>
              <td colspan="3">
              <select id="txtptype" name="txtptype"> 
              <option value="">Select Project Type</option>
              <option value="1" <?php if($ptype==1) {?> selected="selected" <?php }?>>Time-Based</option>
              <option value="2" <?php if($ptype==2) {?> selected="selected" <?php }?>>Milestone</option>
               </select>
              
              </td>
             </tr>
            <tr>
              <td class="labelp"><strong>Start Date<span style="color:#FF0000;">*</span>:</strong></td>
              <td colspan="3">
              <input id="txtpstart" name="txtpstart" type="text" value="<?php echo $pstart; ?>"/> &nbsp;<span style="color:#FF0000;">(Note: PMIS will use start and end date for calculations)</span>
              </td>
             </tr>
             <tr>
              <td class="labelp"><strong>End Date<span style="color:#FF0000;">*</span>:</strong></td>
              <td colspan="3" ><input id="txtpend" name="txtpend" type="text" value="<?php echo $pend; ?>"/>
              </td>
             </tr>
			 <tr>
			   <td class="labelp"><strong>Client:</strong></td>
			   <td colspan="3" >
               <input id="client" name="client" type="text" value="<?php echo $client; ?>"/></td>
	    </tr>
			 <tr>
			   <td class="labelp"><strong>Funding Agency:</strong></td>
			   <td colspan="3" ><input id="funding_agency" name="funding_agency" type="text" 
               value="<?php echo $funding_agency; ?>"/></td>
	    </tr>
			 <tr>
			   <td class="labelp"><strong>Project Cost:</strong></td>
			   <td colspan="3" ><input id="pcost" name="pcost" type="text" 
               value="<?php if($pcost!=0&&$pcost!="")echo number_format($pcost,0); ?>"/></td>
	    </tr>
			 <tr>
			   <td class="labelp"><strong>Contractor:</strong></td>
			   <td colspan="3" ><input id="contractor" name="contractor" type="text" 
               value="<?php echo $contractor; ?>"/></td>
	    </tr>
			 <tr>
			   <td class="labelp"><strong>Consultant:</strong></td>
			   <td colspan="3" ><input id="consultant" name="consultant" type="text" 
               value="<?php echo $consultant; ?>"/></td>
	    </tr>
			 <tr>
			   <td class="labelp"><strong>Sector:</strong></td>
			   <td colspan="3" ><select id="sector_id" name="sector_id"> 
               	<option value="">Select Sector</option>
              		 <?php  $ssSQL = " Select * from rs_tbl_sectors ";
							 $objDb->query($ssSQL);
							 $siCount = $objDb->getCount( );
							 if($siCount>0)
							 {
								for ($i = 0 ; $i < $siCount; $i ++)
								{
								  $sector_id= $objDb->getField($i,sector_id);
								  $sector_name= $objDb->getField($i,sector_name);
								 
								  ?>
                                  <option value="<?php echo $sector_id;?>" 
								  <?php if($ssector_id==$sector_id) {?> selected="selected" 
								  <?php }?>><?php echo $sector_name; ?></option>
                                  <?php
								}
							}
						?>
              </select>
              </td>
	    </tr>
			 <tr>
			   <td class="labelp"><strong>Country</strong></td>
			   <td colspan="3" ><select id="country_id" name="country_id"> 
               	<option value="">Select Country</option>
              		 <?php  $scSQL = " Select * from rs_tbl_countries ";
							 $objDb->query($scSQL);
							 $ciCount = $objDb->getCount( );
							 if($ciCount>0)
							 {
								for ($i = 0 ; $i < $ciCount; $i ++)
								{
								  $country_id= $objDb->getField($i,country_id);
								  $country_name= $objDb->getField($i,country_name);
								 
								  ?>
                                  <option value="<?php echo $country_id;?>" 
								  <?php if($scountry_id==$country_id) {?> selected="selected" 
								  <?php }?>><?php echo $country_name; ?></option>
                                  <?php
								}
							}
						?>
              </select></td>
	    </tr>
			 <tr>
			   <td class="labelp"><strong>Location</strong></td>
			   <td colspan="3" >
               <input id="location" name="location" type="text" value="<?php echo $location; ?>"/></td>
	    </tr>
			 <tr>
			   <td class="labelp"><strong>SMEC Project Code</strong></td>
			   <td colspan="3"><input id="smec_code" name="smec_code" type="text" value="<?php echo $smec_code; ?>"/></td>
	    </tr>
			 
			 <tr>
              <td width="16%" class="labelp"><strong>Base Currency:<span style="color:#FF0000;">*</span></strong></td>
              <td colspan="3" ><input id="base_cur" name="base_cur" type="text" value="<?php echo $base_cur; ?>"/></td>
            </tr>
                <tr>
                  <td class="labelp"><strong>Currency 1:<span style="color:#FF0000;">*</span></strong></td>
                  <td width="20%" ><input id="cur_1" name="cur_1" type="text" value="<?php echo $cur_1; ?>" /></td>
                  <td width="18%" ><strong>Currency 1 Rate:<span style="color:#FF0000;">*</span></strong></td>
                  <td width="46%" ><input id="cur_1_rate" name="cur_1_rate" type="text" value="<?php echo $cur_1_rate; ?>"/></td>
                </tr>
                <tr>
                   <td class="labelp"><strong>Currency 2:</strong></td>
                   <td ><input id="cur_2" name="cur_2" type="text" value="<?php echo $cur_2; ?>"/></td>
                   <td ><strong>Currency 2 Rate:</strong></td>
                   <td ><input id="cur_2_rate" name="cur_2_rate" type="text" value="<?php echo $cur_2_rate; ?>"/></td>
            </tr>
                <tr>
                   <td class="labelp"><strong>Currency 3:</strong></td>
                   <td ><input id="cur_3" name="cur_3" type="text" value="<?php echo $cur_3; ?>"/></td>
                   <td ><strong>Currency 3 Rate:</strong></td>
                   <td ><input id="cur_3_rate" name="cur_3_rate" type="text" value="<?php echo $cur_3_rate; ?>"/></td>
            </tr>
                <tr>
			  <td class="labelp"><strong>Project Working Days:</strong></td>
              <td colspan="3" >
              <select id="working_days[]" name="working_days[]" multiple="multiple"> 
              <!--<option>Select Working Days</option>-->
              		 <?php  $swSQL = " Select * from weekdays ";
							 $objDb->query($swSQL);
							 $iCount = $objDb->getCount( );
							 if($iCount>0)
							 {
								for ($i = 0 ; $i < $iCount; $i ++)
								{
								  $wd_id						= $objDb->getField($i,wd_id);
								  $wd_day						= $objDb->getField($i,wd_day);
								  $wd_detail						= $objDb->getField($i,wd_detail);
								  $status						= $objDb->getField($i,status);
								  ?>
                                  <option value="<?php echo $wd_id;?>" <?php if($status==1) {?> selected="selected" <?php }?>><?php echo $wd_detail; ?></option>
                                  <?php
								}
							}
						?>
              </select>
			 </td>
             </tr>
			    <tr>
					   <td class="labelp" valign="middle"><strong>Project Annual Holidays</strong></td>
					  <td colspan="3"  valign="top"><table class="clsTable" width="500" cellpadding="1" cellspacing="1">
            	<tbody id="tblPrdSizes">
                    <tr>
                        <th style="width:5%;">&nbsp;</th>
						<th style="width:45%;"><?php echo "Title";?></th>
                        <th style="width:25%;"><?php echo "Date (yyyy-mm-dd)";?></th>
                        <th style="width:25%;"><?php echo "Status";?></th>
                    </tr>
                    <?php
					
								$swSQL = " Select * from yearly_holidays  ";
							 $objDb->query($swSQL);
							 $iCount = $objDb->getCount( );
							 if($iCount>0)
							 {
								for ($i = 0 ; $i < $iCount; $i ++)
								{
								  $yh_id						= $objDb->getField($i,yh_id);
								  $yh_title						= $objDb->getField($i,yh_title);
								  $yh_date					= $objDb->getField($i,yh_date);
								  $yh_status				= $objDb->getField($i,yh_status);
								?>
					<tr>
			        <td>
                    <input type="checkbox" name="yh_id[]" value="<?php echo $yh_id;?>" />
                    </td>
					<td><input type="text" name="yh_title_<?php echo $yh_id;?>" 
                    value="<?php echo $yh_title;?>" size="25" /></td>
		             <td><input type="text" name="yh_date_<?php echo $yh_id;?>" 
                       value="<?php echo $yh_date;?>" style="text-align:right;" size="15" />
                       </td>
			           <td><select name="yh_status_<?php echo $yh_id;?>">
							<option value="0" selected>Active</option>
							<option value="1"<?php echo ($yh_status == "1") ? " selected" : "";?>>
                            Inactive</option>
										</select>
									</td>
			                    </tr>
								<?php
							}
						}
					
					else{
					?>
                    <tr>
                    	<td>&nbsp;</td>
                        <td><input type="text" name="yh_title[]" size="25" /></td>
                        <td><input type="text" name="yh_date[]" style="text-align:right;" size="15" /></td>
                    	<td>
							<select name="yh_status[]">
								<option value="0">Active</option>
								<option value="1">Inactive</option>
							</select>
						</td>
					</tr>
                    <?php }?>
                </tbody>
            </table>
            <div style="width:610px;padding:2px;height:25px;text-align:right;"><a onClick="AddNewSize();" href="javascript:void(null);">Add New</a></div></td>
					 
			  </tr>
              	
                
			<tr>
			 <td height="39"></td>
			 <td align="left" colspan="7"  >
			 <?php
			  if($edit!=""){?>
			  <input type="submit" value="Update" name="update" />
			  <?php } else { ?>
			  <input type="submit" value="Save" name="save" id="save" />
			  &nbsp;&nbsp;<input type="submit" value="Clear" name="clear"  />
			  <?php } ?></td>
			 </tr>
             
              <?php }?>
 		</table>
     </form>

	<br clear="all" />
	
	
	
<div id="search"></div>
	<div id="without_search"></div>

</div>
  <?php include ("includes/footer.php"); ?>
</div>
</body>
</html>
<?php
	$objDb  -> close( );
?>
