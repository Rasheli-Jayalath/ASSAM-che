<?php 

require_once("config/config.php");
/*require_once("requires/Database.php");
$obj= new Database();*/
$objCommon 		= new Common;
$objMenu 		= new Menu;
$objNews 		= new News;
$objContent 	= new Content;
$objTemplate 	= new Template;
$objMail 		= new Mail;
$objCustomer 	= new Customer;
$objCart 	= new Cart;
$objAdminUser 	= new AdminUser;
$objProduct 	= new Product;
$objValidate 	= new Validate;
$objOrder 		= new Order;
$objLog 		= new Log;
require_once('rs_lang.admin.php');
require_once('rs_lang.website.php');
?><?php 

if($objAdminUser->is_login== false){
	header("location: index.php");
}
include_once("includes/dbconnect.php");
//include_once("contigencyAmount.php");
$projectid = $_REQUEST['projectid'];
$msgFlag=false;
$graphflag=false;
$data=NULL;
$subactivityflag2=0;
if($projectid == 0 || $projectid =='') {
	$projectflag=0;
} else {
	$projectflag=1;
}
$componentid = $_REQUEST['componentid'];
if($componentid == 0 || $componentid =='') {
	$componentflag=0;
} else {
	$componentflag=1;
}
$activitytypeid = $_REQUEST['activitytypeid'];
if($activitytypeid == 0 || $activitytypeid =='') {
	$activitytypeflag=0;
} else {
	$activitytypeflag=1;
}
$subcomponentid = $_REQUEST['subcomponentid'];
if($subcomponentid == 0 || $subcomponentid =='') {
	$subcomponentflag=0;
} else {
	$subcomponentflag=1;
}
$activityid = $_REQUEST['activityid'];
if($activityid == 0 || $activityid =='') {
	$activityflag=0;
} else {
	$activityflag=1;
}
$subactivityid = $_REQUEST['subactivityid'];
if($subactivityid == 0 || $subactivityid =='') {
	$subactivityflag=0;
} else {
	$subactivityflag=1;
}
if($_SERVER['REQUEST_METHOD']=="POST" &&isset($_POST['edit_sa']))
{
 $sa_id=$_POST["sa_id"];
 $aid=$_POST["aid"];
 $sid=$_POST["sid"];
 $s_id=$_POST["s_id"];
  $cid=$_POST["cid"];
 $pid=$_POST["pid"];
  $pqty=$_POST["pqty"];
 $bid=$_POST["bid"];
$subactivityid=$sa_id;
$activityid=$aid;
$activitytypeid=$sid;
$subcomponentid=$s_id;
$componentid=$cid;
$projectid=$pid;
$subactivityflag=1;
$subactivityflag2=0;
$activityflag=1; 
$activitytypeflag=1;
$subcomponentflag=1;
$componentflag=1;
$projectflag=1;
$query_1="SELECT qty,rs from subactivity where sa_id=".$sa_id;
$result_1 = mysql_query($query_1)or die(mysql_error());
$res_data_1=mysql_fetch_array($result_1);
$query_2="SELECT sum(pqty) as tqty from progress where sa_id=".$sa_id;
$result_2 = mysql_query($query_2)or die(mysql_error());
$res_data_2=mysql_fetch_array($result_2);
if($res_data_2["tqty"]==0)

{
	if($pqty>$res_data_1["qty"])
	{
		$vqty=$pqty-$res_data_1["qty"];
		$reportquery="UPDATE progress SET pqty=".$res_data_1["qty"]." Where bid=".$bid." AND sa_id=".$sa_id;
        $reportresult = mysql_query($reportquery)or die(mysql_error());
		$vquery="SELECT * FROM variation_order where sa_id=".$sa_id." AND bid=".$bid;
	$result_v= mysql_query($vquery)or die(mysql_error());
	$check=mysql_num_rows($result_v);
	if($check==0)
	{
		$query1="INSERT INTO `variation_order` (`vo_id`, `contigency_code`, `sa_id`, `vqty`, `vrate`, `vamount`, `vono`, `vodate`, 
		`bid`, `remark`, `vstatus`, `cid`) VALUES (NULL, '1', ".$sa_id.", ".$vqty.", '0', '0', '0', '', ".$bid.",'Nill', '0', '".$cid."');";
	 $aresult1 = mysql_query($query1);
	}
	else
	{
		$reportquery_v="UPDATE variation_order SET vqty=".$vqty." Where bid=".$bid." AND sa_id=".$sa_id;
        $reportresult_v= mysql_query($reportquery_v)or die(mysql_error());
	}
	}
	elseif($pqty==0)
		{
		$reportquery="UPDATE progress SET pqty=".$pqty." Where bid=".$bid." AND sa_id=".$sa_id;
		$reportresult = mysql_query($reportquery)or die(mysql_error());	
		$reportquery_v="UPDATE variation_order SET vqty=".$pqty." Where bid=".$bid." AND sa_id=".$sa_id;
        $reportresult_v= mysql_query($reportquery_v)or die(mysql_error());
		}
	else
	{
	$reportquery="UPDATE progress SET pqty=".$pqty." Where bid=".$bid." AND sa_id=".$sa_id;
	$reportresult = mysql_query($reportquery)or die(mysql_error());
	}
}
else
{
if($res_data_2["tqty"]>=$res_data_1["qty"])
{
	$vquery="SELECT * FROM variation_order where sa_id=".$sa_id." AND bid=".$bid;
	$result_v= mysql_query($vquery)or die(mysql_error());
	$check=mysql_num_rows($result_v);
	if($check==0)
	{
		$query1="INSERT INTO `variation_order` (`vo_id`, `contigency_code`, `sa_id`, `vqty`, `vrate`, `vamount`, `vono`, `vodate`, 
		`bid`, `remark`, `vstatus`, `cid`) VALUES (NULL, '1', ".$sa_id.", ".$pqty.", '0', '0', '0', '', ".$bid.",'Nill', '0', '".$cid."');";
	 $aresult1 = mysql_query($query1);
	}
	else
	{ //echo "h2";
		if($pqty==0)
		{
		$reportquery="UPDATE progress SET pqty=".$pqty." Where bid=".$bid." AND sa_id=".$sa_id;
		$reportresult = mysql_query($reportquery)or die(mysql_error());	
		$reportquery_v="UPDATE variation_order SET vqty=".$pqty." Where bid=".$bid." AND sa_id=".$sa_id;
        $reportresult_v= mysql_query($reportquery_v)or die(mysql_error());
		}
		else
		{ 
		$gqty=$pqty+$res_data_2["tqty"];
			if($gqty>$res_data_1["qty"])
			{
				$p_qty=$res_data_1["qty"]-$res_data_2["tqty"];
				$reportquery="UPDATE progress SET pqty=".$p_qty." Where bid=".$bid." AND sa_id=".$sa_id;
			    $reportresult = mysql_query($reportquery)or die(mysql_error());	
				$vqty=$pqty-$p_qty;
				$reportquery_v="UPDATE variation_order SET vqty=".$vqty." Where bid=".$bid." AND sa_id=".$sa_id;
         		$reportresult_v= mysql_query($reportquery_v)or die(mysql_error());
			}
			elseif($pqty<$res_data_1["qty"])
			{
			$reportquery="UPDATE progress SET pqty=".$pqty." Where bid=".$bid." AND sa_id=".$sa_id;
			$reportresult = mysql_query($reportquery)or die(mysql_error());	
		 	$reportquery_v="UPDATE variation_order SET vqty=0 Where bid=".$bid." AND sa_id=".$sa_id;
         	$reportresult_v= mysql_query($reportquery_v)or die(mysql_error());
			}
			else
			{
				$reportquery="UPDATE progress SET pqty=".$pqty." Where bid=".$bid." AND sa_id=".$sa_id;
				$reportresult = mysql_query($reportquery)or die(mysql_error());
				$reportquery_v="UPDATE variation_order SET vqty=0 Where bid=".$bid." AND sa_id=".$sa_id;
         		$reportresult_v= mysql_query($reportquery_v)or die(mysql_error());
			}
		}
	}
}
else
{

	
		 $gqty=$pqty+$res_data_2["tqty"];
			if($gqty>$res_data_1["qty"])
			{
				$p_qty=$res_data_1["qty"]-$res_data_2["tqty"];
				$reportquery="UPDATE progress SET pqty=".$p_qty." Where bid=".$bid." AND sa_id=".$sa_id;
			    $reportresult = mysql_query($reportquery)or die(mysql_error());	
				$vqty=$pqty-$p_qty;
				$reportquery_v="UPDATE variation_order SET vqty=".$vqty." Where bid=".$bid." AND sa_id=".$sa_id;
         		$reportresult_v= mysql_query($reportquery_v)or die(mysql_error());
			}
			elseif($pqty>$res_data_1["qty"])
			{
		
			$vqty=$pqty-$res_data_1["qty"];
			$reportquery="UPDATE progress SET pqty=".$res_data_1["qty"]." Where bid=".$bid." AND sa_id=".$sa_id;
        	$reportresult = mysql_query($reportquery)or die(mysql_error());
			$query1="UPDATE `variation_order` SET vqty=".$vqty." Where bid=".$bid." AND sa_id=".$sa_id;;
			$aresult1 = mysql_query($query1);
			}
			elseif($pqty==0)
		{
		$reportquery="UPDATE progress SET pqty=".$pqty." Where bid=".$bid." AND sa_id=".$sa_id;
		$reportresult = mysql_query($reportquery)or die(mysql_error());	
		$reportquery_v="UPDATE variation_order SET vqty=".$pqty." Where bid=".$bid." AND sa_id=".$sa_id;
        $reportresult_v= mysql_query($reportquery_v)or die(mysql_error());
		}
			else
			{
				
			$reportquery="UPDATE progress SET pqty=".$pqty." Where bid=".$bid." AND sa_id=".$sa_id;
			$reportresult = mysql_query($reportquery)or die(mysql_error());
			}
}
}
if($reportresult)
{
$msgFlag=true;
}
}
/*if($_SERVER['REQUEST_METHOD']=="POST" &&isset($_POST['view_graph']))
{
$projectid = $_POST['projectid'];
$coms_weights=$_POST["com_weight"];
$coms_progress=$_POST["com_prog"];
$com_names=array("Baloki","Jandraka","15L","ICB-01","ICB-02","ICB-03","ICB-04","ICB-05","ICB-06","GW","OFWM","ISOM","PM","RC");

$data = array_map(NULL,$com_names,$coms_weights,$coms_progress); 
$data = array(
  array('Baloki',  9.60,    2.62),
  array('Jandraka',  0.63,   0.23),
  array('15L',  1.48,   0.50),
  array('ICB-01',  8.18,  3.08),
  array('ICB-02',  12.96,   5.05),
  array('ICB-03',  3.54,   1.35),
  array('ICB-04',  7.82,     1.43),
  array('ICB-05',  9.24,    1.44),
  array('ICB-06', 6.55,    0.64),
  array('GW', 10,    3.49),
  array('OFWM', 10,    4.84),
  array('ISOM', 10,   8.24),
  array('PM', 5,     4.67),
  array('RS', 5,    5)
);

$projectflag=1;
$graphflag=true;
}*/
?>
<?php 
function dateDiff($start, $end) 
{   
$start_ts = strtotime($start);  
$end_ts = strtotime($end);  
$diff = $end_ts - $start_ts;  
return round($diff / 86400); 
}?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Physical Progress Monitoring Dashboard</title>
<link href="css/CssAdminStyle.css" rel="stylesheet" type="text/css" />
<link href="css/CssLogin.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript">
function getXMLHTTP() { //fuction to return the xml http object
		var xmlhttp=false;	
		try{
			xmlhttp=new XMLHttpRequest();
		}
		catch(e)	{		
			try{			
				xmlhttp= new ActiveXObject("Microsoft.XMLHTTP");
			}
			catch(e){
				try{
				xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
				}
				catch(e1){
					xmlhttp=false;
				}
			}
		}
		 	
		return xmlhttp;
    }
	function getManagementReport(activitytypeid, subcomponentid,componentid)
	{
	if (activitytypeid!=0) {
		var strURL="findManagementReports.php?activitytype="+activitytypeid+"&subcomponent="+subcomponentid+"&componentid="+componentid;
			var req = getXMLHTTP();
			
			if (req) {
				
				req.onreadystatechange = function() {
					if (req.readyState == 4) {
						// only if "OK"
						if (req.status == 200) {						
							document.getElementById('result4').innerHTML=req.responseText;						
						} else {
							alert("There was a problem while using XMLHTTP:\n" + req.statusText);
						}
					}				
				}			
				req.open("GET", strURL, true);
				req.send(null);
			}
		} 
		else {
		    
			document.getElementById('subcomponentid').value = 0;
			document.getElementById('subcomponentid').disabled = true;
			document.getElementById('activityid').value = 0;
			document.getElementById('activityid').disabled = true;
			document.getElementById('subactivityid').value = 0;
			document.getElementById('subactivityid').disabled = true;		
		}
	}
	
	function getEditProgress(subactivityid,activityid,activitytypeid,subcomponentid,componentid,projectid)
	{
	
	if (subactivityid!=0) {
		
		var strURL="findEditProgress.php?subactivityid="+subactivityid+"&activityid="+activityid+"&activitytypeid="+activitytypeid+"&subcomponentid="+subcomponentid+"&componentid="+componentid+"&projectid="+projectid;
		
			var req = getXMLHTTP();
			
			if (req) {
				
				req.onreadystatechange = function() {
					if (req.readyState == 4) {
						// only if "OK"
						if (req.status == 200) {						
							document.getElementById('result5').innerHTML=req.responseText;						
						} else {
							alert("There was a problem while using XMLHTTP:\n" + req.statusText);
						}
					}				
				}			
				req.open("GET", strURL, true);
				req.send(null);
			}
		} 
		else {
		    
			document.getElementById('subcomponentid').value = 0;
			document.getElementById('subcomponentid').disabled = true;
			document.getElementById('activityid').value = 0;
			document.getElementById('activityid').disabled = true;
			document.getElementById('subactivityid').value = 0;
			document.getElementById('subactivityid').disabled = true;		
		}
	}
	
	function getDetailProgressReport(projectid,componentid)
	{
	if (componentid!=0) {
		var strURL="findDetailProgressReports.php?projectid="+projectid+"&componentid="+componentid;
			var req = getXMLHTTP();
			
			if (req) {
				
				req.onreadystatechange = function() {
					if (req.readyState == 4) {
						// only if "OK"
						if (req.status == 200) {						
							document.getElementById('result3').innerHTML=req.responseText;						
						} else {
							alert("There was a problem while using XMLHTTP:\n" + req.statusText);
						}
					}				
				}			
				req.open("GET", strURL, true);
				req.send(null);
			}
		} 
		else {
		    
			document.getElementById('subcomponentid').value = 0;
			document.getElementById('subcomponentid').disabled = true;
			document.getElementById('activityid').value = 0;
			document.getElementById('activityid').disabled = true;
			document.getElementById('subactivityid').value = 0;
			document.getElementById('subactivityid').disabled = true;		
		}
	}
	
	function getProjectReport(projectid,componentid)
	{
	if (projectid!=0) {
		var strURL="findProjectReports.php?projectid="+projectid+"&componentid="+componentid;
			var req = getXMLHTTP();
			
			if (req) {
				
				req.onreadystatechange = function() {
					if (req.readyState == 4) {
						// only if "OK"
						if (req.status == 200) {						
							document.getElementById('result2').innerHTML=req.responseText;						
						} else {
							alert("There was a problem while using XMLHTTP:\n" + req.statusText);
						}
					}				
				}			
				req.open("GET", strURL, true);
				req.send(null);
			}
		} 
		else {
		    
			document.getElementById('subcomponentid').value = 0;
			document.getElementById('subcomponentid').disabled = true;
			document.getElementById('activityid').value = 0;
			document.getElementById('activityid').disabled = true;
			document.getElementById('subactivityid').value = 0;
			document.getElementById('subactivityid').disabled = true;		
		}
	}
	
	function getProgressReport(projectid,componentid)
	{
	if (componentid!=0) {
		var strURL="findProgressReports.php?projectid="+projectid+"&componentid="+componentid;
			var req = getXMLHTTP();
			
			if (req) {
				
				req.onreadystatechange = function() {
					if (req.readyState == 4) {
						// only if "OK"
						if (req.status == 200) {						
							document.getElementById('result3').innerHTML=req.responseText;						
						} else {
							alert("There was a problem while using XMLHTTP:\n" + req.statusText);
						}
					}				
				}			
				req.open("GET", strURL, true);
				req.send(null);
			}
		} 
		else {
		    
			document.getElementById('subcomponentid').value = 0;
			document.getElementById('subcomponentid').disabled = true;
			document.getElementById('activityid').value = 0;
			document.getElementById('activityid').disabled = true;
			document.getElementById('subactivityid').value = 0;
			document.getElementById('subactivityid').disabled = true;		
		}
	}
/*	function getGeneralReport(activitytypeid, subcomponentid)
	{
	if (activitytypeid!=0) {
		var strURL="mosactlevel.php?activitytype="+activitytypeid+"&subcomponent="+subcomponentid;
			var req = getXMLHTTP();
			
			if (req) {
				
				req.onreadystatechange = function() {
					if (req.readyState == 4) {
						// only if "OK"
						if (req.status == 200) {						
							document.getElementById('result4').innerHTML=req.responseText;						
						} else {
							alert("There was a problem while using XMLHTTP:\n" + req.statusText);
						}
					}				
				}			
				req.open("GET", strURL, true);
				req.send(null);
			}
		} 
		else {
		    
			document.getElementById('subcomponentid').value = 0;
			document.getElementById('subcomponentid').disabled = true;
			document.getElementById('activityid').value = 0;
			document.getElementById('activityid').disabled = true;
			document.getElementById('subactivityid').value = 0;
			document.getElementById('subactivityid').disabled = true;		
		}
	}*/
	function getExceedActivity(activitytypeid, subcomponentid,activityid)
	{
	
	if (activitytypeid!=0) {
		var strURL="findExceedActivity.php?activitytypeid="+activitytypeid+"&subcomponentid="+subcomponentid+"&activityid="+activityid;
		
			var req = getXMLHTTP();
			
			if (req) {
				
				req.onreadystatechange = function() {
					if (req.readyState == 4) {
						// only if "OK"
						if (req.status == 200) {	
										
							document.getElementById('result9').innerHTML=req.responseText;						
						} else {
							alert("There was a problem while using XMLHTTP:\n" + req.statusText);
						}
					}				
				}			
				req.open("GET", strURL, true);
				req.send(null);
			}
		} 
		else {
		    
		
			document.getElementById('subactivityid').value = 0;
			document.getElementById('subactivityid').disabled = true;		
		}}
		function getIPCActivity(activitytypeid, subcomponentid,activityid,componentid)
	{
	
	if (activitytypeid!=0) {
		var strURL="findIPCActivities.php?activitytypeid="+activitytypeid+"&subcomponentid="+subcomponentid+"&activityid="+activityid+"&componentid="+componentid;
		
			var req = getXMLHTTP();
			
			if (req) {
				
				req.onreadystatechange = function() {
					if (req.readyState == 4) {
						// only if "OK"
						if (req.status == 200) {	
										
							document.getElementById('result9').innerHTML=req.responseText;						
						} else {
							alert("There was a problem while using XMLHTTP:\n" + req.statusText);
						}
					}				
				}			
				req.open("GET", strURL, true);
				req.send(null);
			}
		} 
		else {
		    
		
			document.getElementById('subactivityid').value = 0;
			document.getElementById('subactivityid').disabled = true;		
		}}
		function getIPCSubcomponent(activitytypeid, subcomponentid,componentid)
	{
	
	if (activitytypeid!=0) {
		var strURL="findIPCSubcomponent.php?activitytypeid="+activitytypeid+"&subcomponentid="+subcomponentid+"&componentid="+componentid;
		
			var req = getXMLHTTP();
			
			if (req) {
				
				req.onreadystatechange = function() {
					if (req.readyState == 4) {
						// only if "OK"
						if (req.status == 200) {	
										
							document.getElementById('result10').innerHTML=req.responseText;						
						} else {
							alert("There was a problem while using XMLHTTP:\n" + req.statusText);
						}
					}				
				}			
				req.open("GET", strURL, true);
				req.send(null);
			}
		} 
		else {
		    
		
			document.getElementById('subactivityid').value = 0;
			document.getElementById('subactivityid').disabled = true;		
		}}
	function getExceedSubComponent(activitytypeid,subcomponentid)
	{
	if (subcomponentid!=0) {
		var strURL="findExceedSubComponent.php?activitytypeid="+activitytypeid+"&subcomponentid="+subcomponentid;
		
			var req = getXMLHTTP();
			
			if (req) {
				
				req.onreadystatechange = function() {
					if (req.readyState == 4) {
						// only if "OK"
						if (req.status == 200) {	
										
							document.getElementById('result10').innerHTML=req.responseText;						
						} else {
							alert("There was a problem while using XMLHTTP:\n" + req.statusText);
						}
					}				
				}			
				req.open("GET", strURL, true);
				req.send(null);
			}
		} 
		else {
		    
		    document.getElementById('activityid').value = 0;
			document.getElementById('activityid').disabled = true;
			document.getElementById('subactivityid').value = 0;
			document.getElementById('subactivityid').disabled = true;		
		}}
	function getExceedComponent(projectid,componentid)
	{
	if (componentid!=0) {
		var strURL="findExComponent.php?projectid="+projectid+"&componentid="+componentid;
		
			var req = getXMLHTTP();
			
			if (req) {
				
				req.onreadystatechange = function() {
					if (req.readyState == 4) {
						// only if "OK"
						if (req.status == 200) {						
							document.getElementById('result3').innerHTML=req.responseText;						
						} else {
							alert("There was a problem while using XMLHTTP:\n" + req.statusText);
						}
					}				
				}			
				req.open("GET", strURL, true);
				req.send(null);
			}
		} 
		else {
		    
			document.getElementById('subcomponentid').value = 0;
			document.getElementById('subcomponentid').disabled = true;
			document.getElementById('activityid').value = 0;
			document.getElementById('activityid').disabled = true;
			document.getElementById('subactivityid').value = 0;
			document.getElementById('subactivityid').disabled = true;		
		}
		}
	function getcomponent(projectid) {		
		if (projectid!=0) {
			var strURL="findcomponent.php?project="+projectid;
			var req = getXMLHTTP();
			
			if (req) {
				
				req.onreadystatechange = function() {
					if (req.readyState == 4) {
						// only if "OK"
						if (req.status == 200) {						
							document.getElementById('componentdiv').innerHTML=req.responseText;						
						} else {
							alert("There was a problem while using XMLHTTP:\n" + req.statusText);
						}
					}				
				}			
				req.open("GET", strURL, true);
				req.send(null);
			}
		} else {
			document.getElementById('componentid').value = 0;
			document.getElementById('componentid').disabled = true;
			document.getElementById('activitytypeid').value = 0;
			document.getElementById('activitytypeid').disabled = true;
			document.getElementById('subcomponentid').value = 0;
			document.getElementById('subcomponentid').disabled = true;
			document.getElementById('activityid').value = 0;
			document.getElementById('activityid').disabled = true;	
			document.getElementById('subactivityid').value = 0;
			document.getElementById('subactivityid').disabled = true;	
		}
		   document.getElementById('componentid').value = 0;
			document.getElementById('componentid').disabled = true;
			document.getElementById('activitytypeid').value = 0;
			document.getElementById('activitytypeid').disabled = true;
			document.getElementById('subcomponentid').value = 0;
			document.getElementById('subcomponentid').disabled = true;
			document.getElementById('activityid').value = 0;
			document.getElementById('activityid').disabled = true;	
			document.getElementById('subactivityid').value = 0;
			document.getElementById('subactivityid').disabled = true;	
	}

	function getactivitytype(componentid) {		
		if (componentid!=0) {
			var strURL="findactivitytype.php?component="+componentid;
			var req = getXMLHTTP();
			
			if (req) {
				
				req.onreadystatechange = function() {
					if (req.readyState == 4) {
						// only if "OK"
						if (req.status == 200) {						
							document.getElementById('activitytypediv').innerHTML=req.responseText;						
						} else {
							alert("There was a problem while using XMLHTTP:\n" + req.statusText);
						}
					}				
				}			
				req.open("GET", strURL, true);
				req.send(null);
			}
		} else {
			document.getElementById('activitytypeid').value = 0;
			document.getElementById('activitytypeid').disabled = true;
			document.getElementById('subcomponentid').value = 0;
			document.getElementById('subcomponentid').disabled = true;
			document.getElementById('activityid').value = 0;
			document.getElementById('activityid').disabled = true;
			document.getElementById('subactivityid').value = 0;
			document.getElementById('subactivityid').disabled = true;		
		}
		    document.getElementById('activitytypeid').value = 0;
			document.getElementById('activitytypeid').disabled = true;
			document.getElementById('subcomponentid').value = 0;
			document.getElementById('subcomponentid').disabled = true;
			document.getElementById('activityid').value = 0;
			document.getElementById('activityid').disabled = true;
			document.getElementById('subactivityid').value = 0;
			document.getElementById('subactivityid').disabled = true;		
	}
	
	function getsubcomponent(activitytypeid, componentid) {	
		
		if (activitytypeid!=0) {
		var strURL="findsubcomponent.php?activitytype="+activitytypeid+"&component="+componentid;
			var req = getXMLHTTP();
			
			if (req) {
				
				req.onreadystatechange = function() {
					if (req.readyState == 4) {
						// only if "OK"
						if (req.status == 200) {						
							document.getElementById('subcomponentdiv').innerHTML=req.responseText;						
						} else {
							alert("There was a problem while using XMLHTTP:\n" + req.statusText);
						}
					}				
				}			
				req.open("GET", strURL, true);
				req.send(null);
			}
		} 
		else {
		    
			document.getElementById('subcomponentid').value = 0;
			document.getElementById('subcomponentid').disabled = true;
			document.getElementById('activityid').value = 0;
			document.getElementById('activityid').disabled = true;
			document.getElementById('subactivityid').value = 0;
			document.getElementById('subactivityid').disabled = true;		
		}
		    document.getElementById('subcomponentid').value = 0;
			document.getElementById('subcomponentid').disabled = true;
		    document.getElementById('activityid').value = 0;
			document.getElementById('activityid').disabled = true;
			document.getElementById('subactivityid').value = 0;
			document.getElementById('subactivityid').disabled = true;	
	}
	
	function getactivity(subcomponentid) {		
		if (subcomponentid!=0) {
			var strURL="findactivity.php?subcomponent="+subcomponentid;
			var req = getXMLHTTP();
			
			if (req) {
				
				req.onreadystatechange = function() {
					if (req.readyState == 4) {
						// only if "OK"
						if (req.status == 200) {						
							document.getElementById('activitydiv').innerHTML=req.responseText;						
						} else {
							alert("There was a problem while using XMLHTTP:\n" + req.statusText);
						}
					}				
				}			
				req.open("GET", strURL, true);
				req.send(null);
			}
		} else {
			document.getElementById('activityid').value = 0;
			document.getElementById('activityid').disabled = true;
			document.getElementById('subactivityid').value = 0;
			document.getElementById('subactivityid').disabled = true;		
		}
		document.getElementById('subactivityid').value = 0;
			document.getElementById('subactivityid').disabled = true;	
	}
	
	function getsubactivity(activityid) {
		
		if (activityid!=0) {
			var strURL="findsubactivity.php?activity="+activityid;
			var req = getXMLHTTP();
			
			if (req) {
				
				req.onreadystatechange = function() {
					if (req.readyState == 4) {
						// only if "OK"
						if (req.status == 200) {						
							document.getElementById('subactivitydiv').innerHTML=req.responseText;						
						} else {
							alert("There was a problem while using XMLHTTP:\n" + req.statusText);
						}
					}				
				}			
				req.open("GET", strURL, true);
				req.send(null);
			}
		} else {
			document.getElementById('subactivityid').value = 0;
			document.getElementById('subactivityid').disabled = true;				
		}
	}
	function GetProgressQuantity(bid,subactivityid) 
	{
			
		if (bid!=0) {
			var strURL="findProgressQuantity.php?bid="+bid+"&subactivityid="+subactivityid;
			var req = getXMLHTTP();
			
			if (req) {
				
				req.onreadystatechange = function() {
					if (req.readyState == 4) {
						// only if "OK"
						if (req.status == 200) {						
							document.getElementById('ProgressQunatity').innerHTML=req.responseText;						
						} else {
							alert("There was a problem while using XMLHTTP:\n" + req.statusText);
						}
					}				
				}			
				req.open("GET", strURL, true);
				req.send(null);
			}
		} 
		   
	}
	function frmValidate(frm){
	var flag = true;
	
	if(frm.bid.value == 0){
		msg = "Progress month is required";
		flag = false;
	}
	if(flag == false){
		alert(msg);
		return false;
	}
	}
</script>
<style type="text/css">
<!--
.style1 {color: #3C804D;
font-family:Verdana, Arial, Helvetica, sans-serif;
	font-size:18px;
	font-weight:bold;
	text-align:center;}
-->
</style>
<style type="text/css"> 
.imgA1 { position:absolute;  z-index: 3; } 
.imgB1 { position:relative;  z-index: 3;
float:right;
padding:10px 10px 0 0; } 
</style> 
<style type="text/css"> 
.msg_list {
	margin: 0px;
	padding: 0px;
	width: 100%;
}
.msg_head {
	padding: 5px 10px;
	cursor: pointer;
	position: relative;
	background-color:#FF0033;
	margin:1px;
}
.msg_body {
	padding: 5px 10px 15px;
	background-color:#F4F4F8;
}
select {
     
        width: 186px;
        overflow:visible ;
    }

select:focus { width:auto ;
position:relative ;
}​
</style>
<script type="text/javascript" src="jquery.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	//hide the all of the element with class msg_body
	$(".msg_body").hide();
	//toggle the componenet with class msg_body
	$(".msg_head").click(function(){
		$(this).next(".msg_body").slideToggle(600);
	});
});
</script>

</head>
<body>

<table border="0px" cellpadding="0px" cellspacing="0px" align="center" width="100%" > 
<tr> 
<td width="155" ><div align="right"><img src="images/punjab_govt_logo.png" width="125" height="112" /></div></td>
<td > <h1 align="center" style="font-size:36px">LBDCIP</h1>
  <div align="center"><br/>
      <span class="style1"><?php echo $ADMIN_SITE_TITLE="Lower Bari Doab Canal Improvment Project";?></span></div></td>
<td width="150">  <div align="left"><img src="images/pmu.png" width="97px" height="85px"  align="right" /></div></td>
</tr>

<tr>
<td colspan="3">
<img src="images/top.png" width="100%" height="39px"   class="imgA1" />	

<a href="./index.php"><img src="images/Home-icon.png"  alt="Home" title="Home" class="imgB1"/></a>	
</td>
</tr>
</table>
<div id="wrapper_MemberLogin">
<h1><?php echo "Physical/Financial Progress Monitoring Dashboard";?>
</h1>
	<div class="clear"></div>
	<!--<div class="imgbutton">
			   <ul>
               <li><a href="#" >
				<img src="images/ico_print.gif"  alt="Print" title="Print"/>
				</a></li>
				 <li><a href="#" >
				<img src="images/database-process-icon.png"  alt="Import"  title="Import"/>
				</a></li>
		  </ul>
		  </div>-->
<div id="LoginBox" class="borderRound borderShadow" <?php if($componentflag == 1 && $activitytypeid == 0){?>style="width:550px;"<?php } ?><?php if($activityflag == 1 && $subactivityid == 0){?>style="width:550px;"<?php } ?>>

<table border="0px" cellpadding="0px" cellspacing="0px" align="center"  >

<form action="mosactlevel.php" method="post" name="boqlevel" id="boqlevel">
<tr>
<td ><label>Project</label></td>
<td>
<div id="projectdiv">
<select name="projectid" id="projectid" onchange="getcomponent(this.value)" >
<option value="0">Seclect Project..</option>
<?php
$pquery = "select * from project";
$presult = mysql_query($pquery);
while ($pdata = mysql_fetch_array($presult)) {
?>
	<option value="<?php echo $pdata['pid']; ?>" <?php if ($projectid == $pdata['pid']) {echo ' selected="selected"';} ?>><?php echo $pdata['code']." - ".$pdata['detail']; ?></option>
<?php
}
?>
</select>
</div></td>
</tr>
<tr>
<td ><label>Component</label></td>
<td>
<div id="componentdiv">
<?php
if ($componentflag !=1 && $projectid == 0) {
?>
<select name="componentid" id="componentid" disabled="disabled" >
		<option>Select Component..</option>
    </select>
<?php
} else {
?>
<select name="componentid" id="componentid" onchange="getactivitytype(this.value)">
<option value="0">Select Component..</option>
<?php
$cquery = "select * from components where pid = ".$projectid." order by cid";
echo $cquery;
$cresult = mysql_query($cquery);
while ($cdata = mysql_fetch_array($cresult)) {
?>
	<option value="<?php echo $cdata['cid']; ?>" <?php if ($componentid == $cdata['cid']) {echo ' selected="selected"';} ?>><?php echo $cdata['code']." - ".$cdata['detail']; ?></option>
<?php
}
?>
</select>
<?php
}
?>
</div></td>
</tr>
<tr>
<td ><label>Activity Type</label></td>
<td>
<div id="activitytypediv">
<?php
if ($activitytypeflag !=1 && $componentid == 0) {
?>
	<select name="activitytypeid" id="activitytypeid"  disabled="disabled" >
		<option>Select Activity Type..</option>
    </select>
<?php
} else {
?>
<select name="activitytypeid" id="activitytypeid" onchange="getsubcomponent(this.value, componentid.value)">
<option value="0">Select Activity Type..</option>
<?php
$query="SELECT * FROM subcomponents where (sid=3 OR sid=4) and cid=".$componentid;
$queryresult = mysql_query($query);
$numrows=mysql_num_rows($queryresult);
if($numrows>0)
{
$squery = "select * from activitytype Limit 0,4";
}
else
{
if($componentid==13)
{
$squery = "select * from activitytype where sid=5 OR sid=6";
}
else
{
$squery = "select * from activitytype where sid=1";
}
}
$sresult = mysql_query($squery);
while ($sdata = mysql_fetch_array($sresult)) {
?>
	<option value="<?php echo $sdata['sid']; ?>" <?php if ($activitytypeid == $sdata['sid']) {echo ' selected="selected"';} ?>><?php echo $sdata['code']." - ".$sdata['detail']; ?></option>
<?php
}
?>
</select>
<?php
}
?>
</div></td>
</tr>
<tr>
<td ><label>Sub Component</label></td>
<td>
<div id="subcomponentdiv">
<?php
if ($subcomponentflag !=1 && $activitytypeid == 0) {
?>
	<select name="subcomponentid" id="subcomponentid" disabled="disabled" >
		<option>Select Sub Component..</option>
    </select>
<?php
} else {
?>
<select name="subcomponentid" id="subcomponentid" onchange="getactivity(this.value)">
<option value="0">Select Sub Component..</option>
<?php
$tquery = "select * from subcomponents where cid = ".$componentid." and sid = ".$activitytypeid;
$tresult = mysql_query($tquery);
while ($tdata = mysql_fetch_array($tresult)) {
?>
	<option value="<?php echo $tdata['s_id']; ?>" <?php if ($subcomponentid == $tdata['s_id']) {echo ' selected="selected"';} ?>><?php echo $tdata['code']." - ".$tdata['detail']; ?></option>
<?php
}
?>
</select>
<?php
}
?>
</div></td>
</tr>
<tr>
<td ><label>Activity</label></td>
<td>
<div id="activitydiv">
<?php
if ($activityflag !=1 && $subcomponentid == 0) {
?>
	<select name="activityid" id="activityid" disabled="disabled" >
		<option>Select Activity..</option>
    </select>
<?php
} else {
?>
<select name="activityid" id="activityid" onchange="getsubactivity(this.value)">
<option value="0">Select Activity..</option>
<?php
$aquery = "select * from activity where s_id = ".$subcomponentid;
$aresult = mysql_query($aquery);
while ($adata = mysql_fetch_array($aresult)) {
?>
	<option value="<?php echo $adata['aid']; ?>" <?php if ($activityid == $adata['aid']) {echo ' selected="selected"';} ?>><?php echo $adata['code']." - ".$adata['detail']; ?></option>
<?php
}
?>
</select>
<?php
}
?>   
</div></td>
</tr>
<tr>
<td ><label>Sub Activity</label></td>
<td>
<div id="subactivitydiv">
<?php
if ($subactivityflag !=1 && $activityid == 0) {
?>
	<select name="subactivityid" id="subactivityid" disabled="disabled" >
		<option>Select Sub Activity..</option>
    </select>
<?php
} else { 
?>
<select name="subactivityid" id="subactivityid" >
<option value="0">Select Sub Activity..</option>
<?php
$bquery = "select * from subactivity where aid = ".$activityid;
$bresult = mysql_query($bquery);
while ($bdata = mysql_fetch_array($bresult)) {
?>
	<option value="<?php echo $bdata['sa_id']; ?>" <?php if ($subactivityid == $bdata['sa_id']) {echo ' selected="selected"';} ?>> <?php echo $bdata['code']." - ".$bdata['detail']; ?></option>
<?php
}
?>
</select>
<?php
}
?>   
</div></td>
</tr>

<tr >
<td style="padding-top:20px" align="right"><?php /*?><?php
if ($projectid == 0 ) {
?><input type="submit" value="Project Report"  id="uLogin"/><?php }?><?php */?>
<?php /*?><?php
if ($componentid == 0&&$projectflag == 1 ) {
?><?php */?><input type="submit" value="General Report"  id="uLogin"/><?php /*?><?php }?><?php */?></td>
<td style="padding-top:20px;"align="right">
<?php
if ($subactivityflag == 1) {
if($subactivityflag2!=1)
{?>
<input type="button" value="Update Progress" name="editp"  onclick="getEditProgress(<?php echo $subactivityid?>,<?php echo $activityid; ?>,<?php echo $activitytypeid; ?>,<?php echo $subcomponentid;?>,<?php echo $componentid;?>,<?php echo $projectid; ?>)" id="uLogin"/>
<?php }} ?>
<?php if($activitytypeflag == 1 && $subcomponentid == 0){?>
<span style=""><a style="text-decoration:none;color:#ffffff" href="javascript:void(null);" onclick="window.open('print_consultant_report_icb2.php?componentid=<?php echo $componentid;?>&projectid=<?php echo $projectid;?>', 'INV', 'width=1520,height=550,scrollbars=yes');" >Consultant Report</a></span>
<?php }?>
<?php
if ($projectflag == 1 && $componentid == 0 ) {
?>
<?php /*?><input type="button" value="Financial Report"  name="proports"  
onclick="getProjectReport(<?php echo $projectid;?>,<?php echo $componentid;?>)" id="uLogin"/><?php */?>
<?php }?>
<?php if($componentflag == 1 && $activitytypeid == 0){?>
<input type="button" value="ProgressReport"  id="uLogin" name="drports"  
onclick="getProgressReport(<?php echo $projectid;?>,<?php echo $componentid;?>)"/>
<?php /*?><input type="button" value="FinancialReport"  name="prports"  
onclick="getDetailProgressReport(<?php echo $projectid;?>,<?php echo $componentid;?>)" id="uLogin"/><?php */?>
<input type="button" value="Exceed Components"  name="exports"  
onclick="getExceedComponent(<?php echo $projectid;?>,<?php echo $componentid;?>)" id="uLogin"/>
<?php }?><?php if ($activityflag == 1 && $subactivityid == 0 ) {?>
<input type="button" value="Exceed Activities" name="exced"  onclick="getExceedActivity(<?php echo $activitytypeid?>,<?php echo $subcomponentid; ?>,<?php echo $activityid; ?>)" id="uLogin"/>
<input type="button" value="IPC Report" name="aipc"  onclick="getIPCActivity(<?php echo $activitytypeid?>,<?php echo $subcomponentid; ?>,<?php echo $activityid; ?>,<?php echo $componentid; ?>)" id="uLogin"/>
 <?php }?><?php if ($subcomponentflag == 1 && $activityid == 0 ) {?>
 <input type="button" value="IPC Report" name="aipc"  onclick="getIPCSubcomponent(<?php echo $activitytypeid?>,<?php echo $subcomponentid; ?>,<?php echo $componentid; ?>)" id="uLogin"/>
<input type="button" value="Exceed SubComponents" name="sexced"  onclick="getExceedSubComponent(<?php echo $activitytypeid; ?>,<?php echo $subcomponentid; ?>)" id="uLogin"/><?php }?></td>
</tr>
<tr>
<td colspan="2"></td>
</tr>
</form>
</table>
</div>
</div>

<!--Start Project Table Here-->
<div id="result2">

<?php
if ($projectflag == 1 && $componentid == 0 ) 
{

?>
<form id="progress_graph" name="progress_graph" method="post" action="gph2.php" target="_blank">

<table id="tblList"  cellpadding="0" cellspacing="0"   width="48%" align="center" >
<tr align="center" id="title">
<td colspan="5"><span class="white"><strong>Project Progress Report</strong></span> 
  <input type="submit" name="view_graph" value="View Graph"><span style="position:absolute; padding-left:50px; padding-top:5px;"> <a style="text-decoration:none; color:#FFFFFF" href="javascript:void(null);" onclick="window.open('print_project_report3.php?projectid=<?php echo $projectid;?>', 'INV', 'width=1120,height=550,scrollbars=yes');" >
		<img src="images/ico_print.gif" border="0" />  Print IPC Report								</a></span>
<span style="position:absolute; padding-left:250px; padding-top:5px;"> <a style="text-decoration:none; color:#FFFFFF" href="javascript:void(null);" onclick="window.open('print_project_report.php?projectid=<?php echo $projectid;?>', 'INV', 'width=1120,height=550,scrollbars=yes');" >
		<img src="images/ico_print.gif" border="0" />  Print Report								</a></span></td>	
</tr>
<tr id="tblHeading1">
<th  nowrap="nowrap">Sr. No.</th>
<th width="122" nowrap="nowrap"><div align="center">Component</div></th>
    <th width="128" nowrap="nowrap">Assigned weight %</th>
    <!--  <th width="110">Contract Amount</th> -->  
      <th width="127" nowrap="nowrap">Component  Progress %</th>
      <th width="153" nowrap="nowrap">overall Weighted Progress % </th>
  </tr>
  
<!--<tr>
<td style="text-align:center;">Code</td>
<td style="text-align:left;">Detail</td>
<td style="text-align:center;">Start Date</td>
<td style="text-align:center;">End Date</td>
<td style="text-align:right;">Assigned Weight</td>
<td style="text-align:right;">Remark</td>
<td style="text-align:right;">Progress Date</td>
<td style="text-align:right;">Total Amount</td>
<td style="text-align:right;">Uptodate Progress Amount</td>
<td style="text-align:right;">Current Month Amount</td>
</tr>-->


<?php
//$reportquery = "select code, detail, uom, qty, rs, amount from sub_activity where pid=".$projectid." and cid=".$componentid." and sid=".$activitytypeid." and s_id=".

$weighted_progress=0;
$total_weighted_progress=0;
$activity_weight=0;
$physical_contigency=0;
function getProgressAmount($cid,$s_id)
{
 $sql2="SELECT MAX(bdate) as lastdate , SUM( pqty * prs ) AS tamount
FROM  `progress` 
WHERE s_id =".$s_id."
AND cid =".$cid."
GROUP BY s_id";
$pamountresult = mysql_query($sql2)or die(mysql_error());
$pdata=mysql_fetch_array($pamountresult);
return $pdata;
}
function getCurrentProgressAmount($cid,$sa_id)
{

$thismonth=date('Ym');
$sql="SELECT SUM(pamount) AS cprogress
FROM `progressdata` 
WHERE  sa_id =".$sa_id."
AND lbdate LIKE '%".$thismonth."'
GROUP BY sa_id
";
$current_month_result = mysql_query($sql)or die(mysql_error());
$data=mysql_fetch_array($current_month_result);
return $data;
}
function getCode($aid)
{
 $sql="SELECT code  FROM  `activity` where aid=".$aid;
 $amountresult = mysql_query($sql);
//echo $amountsize= mysql_num_rows($amountresult);
 $data=mysql_fetch_array($amountresult);

return $data;
}
function getNameCode($aid)
{
 $sql="SELECT subcomponentname FROM  `subactivitydata` where aid=".$aid;
 $amountresult = mysql_query($sql);
//echo $amountsize= mysql_num_rows($amountresult);
 $data=mysql_fetch_array($amountresult);

return $data;
}
function getComponentWeight($cid)
{
 $sql="SELECT com_weight FROM   `subactivitydata` where cid=".$cid;
 $amountresult = mysql_query($sql);
//echo $amountsize= mysql_num_rows($amountresult);
 $data=mysql_fetch_array($amountresult);

return $data;
}
function getComponentWeight1($aid)
{
 $sql="SELECT c_weight FROM  `subactivitydata` where aid=".$aid;
 $amountresult = mysql_query($sql);
//echo $amountsize= mysql_num_rows($amountresult);
 $data=mysql_fetch_array($amountresult);

return $data;
}
function getActivityWeight($aid)
{
 $sql="SELECT a_weight FROM  `subactivitydata` where aid=".$aid;
 $amountresult = mysql_query($sql);
//echo $amountsize= mysql_num_rows($amountresult);
 $data=mysql_fetch_array($amountresult);
return $data;
}
function getWeightSumTotal()
{
 $sql="select Sum(assig) as component_weighted_sum from components ";
 $amountresult = mysql_query($sql);
//echo $amountsize= mysql_num_rows($amountresult);
 $data=mysql_fetch_array($amountresult);
return $data;
}
function getWeightSum($cid,$sid)
{
 $sql="select Sum(assig) as component_weighted_sum from subcomponents where cid=".$cid." and sid=".$sid;
 $amountresult = mysql_query($sql);
//echo $amountsize= mysql_num_rows($amountresult);
 $data=mysql_fetch_array($amountresult);
return $data;
}
function getComponentWeight2($sid,$cid)
{
 $sql="SELECT assig as c_weight FROM  `subcomponents` where sid=".$sid." And cid=".$cid;
 $amountresult = mysql_query($sql);
//echo $amountsize= mysql_num_rows($amountresult);
 $data=mysql_fetch_array($amountresult);

return $data;
}
////////////start variation
 ///// ///////point 2
function getSubActivityVariationData_project($sa_id)
{ 
$sql2="SELECT sum(vd.vqty) As tvqty, sum(vd.vrate*cc.quantity) as variation_in_rate_amount, sum(vd.vqty*dd.prs) as variation_in_qty_amount,sum(vd.`vamount`) as variation_in_amount,vd.`vo_id`,vd.`contigency_code`,vd.`vono`,vd.`vodate`,vd.`bid`,vd.`remark`,vd.`vstatus`,vd.`bdate`
FROM variationdata vd
LEFT OUTER JOIN (subactivitydata cc) on (vd.sa_id = cc.sa_id) 
LEFT OUTER JOIN (progressdata dd) on (vd.sa_id = dd.sa_id) where cc.sa_id=".$sa_id." GROUP BY cc.sa_id";
$pamountresultp = mysql_query($sql2)or die(mysql_error());
$pgdata=mysql_fetch_array($pamountresultp);
return $pgdata;
}
function getLastMonthSubactivityVariationData($sa_id,$bid)
{ 
 $sql2="SELECT sum(vd.vqty) As lvqty, sum(vd.vrate*cc.quantity) as last_variation_in_rate_amount, sum(vd.vqty*dd.prs) as last_variation_in_qty_amount,sum(vd.`vamount`) as last_variation_in_amount,vd.`vo_id`,vd.`contigency_code`,vd.`vono`,vd.`vodate`,vd.`bid`,vd.`remark`,vd.`vstatus`,vd.`bdate`
FROM variationdata vd
LEFT OUTER JOIN (subactivitydata cc) on (vd.sa_id = cc.sa_id) 
LEFT OUTER JOIN (progressdata dd) on (vd.sa_id = dd.sa_id) where cc.sa_id=".$sa_id." AND vd.bid=".$bid." GROUP BY cc.sa_id";
$pamountresultp = mysql_query($sql2)or die(mysql_error());
$pgdata=mysql_fetch_array($pamountresultp);
return $pgdata;
}
function getCode_new($sa_id)
{
 $sql="SELECT code FROM  `subactivity` where sa_id=".$sa_id;
 
$amountresult = mysql_query($sql);
//echo $amountsize= mysql_num_rows($amountresult);
$data=mysql_fetch_array($amountresult);

return $data;
}
function LastMonthProgressDate()
{
$sql="SELECT  MIN(bdate) as lastMonthdate,bid FROM  `progressmonth`  Group by bid order by bid ASC";
$amountresult = mysql_query($sql);
//echo $amountsize= mysql_num_rows($amountresult);
$data=mysql_fetch_array($amountresult);
return $data;
}
/////////end variation 
function caculateTotalWeightedProgress1($s_id,$all_total)
{   $progress=0;
$physical_contigency=0;
	$sql="SELECT ca.aid,ca.cid,ca.sa_id,ca.sid, sum(ca.quantity*ca.rates) as amount, sum(cb.pamount)As totalamount FROM subactivitydata ca 
        	LEFT OUTER join (progressdata cb)
			on (ca.sa_id = cb.sa_id ) Where s_id=".$s_id."  GROUP BY ca.aid";
    $amountresult = mysql_query($sql);
    while($reportdata=mysql_fetch_array($amountresult))
	{
	$CWeightData=getComponentWeight1($reportdata['aid']);
		$AWeightData=getActivityWeight($reportdata['aid']);
	if($reportdata['sid']==3||$reportdata['sid']==4)
	{
			if($all_total!=0&&$all_total!="")
			{
			 $weight= ($reportdata['amount']/$all_total)*100;
			 //$totalweight+=$weight;
			}
			$codeData=getCode($reportdata['aid']);?> <!--// here is the point where we will manage  contigencies main point-->
			<?php if($codeData['code']=='F') {
			
$last_month_data=LastMonthProgressDate();
 $last_month_bid=$last_month_data["bid"];?>

<?php /*?><div class="msg_list" style="display:none;">
		<p class="msg_head" style="background-color:#00CC66">View Subactivities <span> <a style="text-decoration:none;color:#ffffff" href="javascript:void(null);" onclick="window.open('print_variation_subactivity_level_report.php?subcomponentid=<?php echo $var_s_id;?>&amp;projectid=<?php echo $projectid;?>&amp;activitytypeid=<?php echo $var_sid;?>&amp;componentid=<?php echo $reportdata['cid'];?>&amp;activityid=<?php echo $var_a_id;?>&amp;subactivityid=<?php echo $reportdata['sa_id'];?>&last_aid=<?php echo $reportdata['aid'];?>','INV','width=1120,height=550,scrollbars=yes');" ><img src="images/popout.gif" border="0" title="pop out"/></a></span></p>
		<div class="msg_body" style="display:none;"><?php */?>
			<?php /*?><table id="tblList" cellpadding="0px" cellspacing="0px"   width="98%" align="center" >

<tr id="tblHeading">
<th rowspan="2"> Sr. No. </th>
<th rowspan="2">Description </th>
<th rowspan="2"> UOM </th>
<!--<th colspan="3">As Per Estimate</th>-->
<th colspan="3"> As Per Bid</th>
<th colspan="2">Paid Upoto Previous </th>
<th colspan="2">During This Month </th>
<th colspan="2">(Executed) Upto Date </th>
<th rowspan="2"> % in Progress</th>
</tr>
<tr id="tblHeading">
<!--<th>Qty. (Units) </th>
<th>Rate </th>
<th> Amount</th>-->
<th>Qty. (Units) </th>
<th>Rate (Rs.) </th>
<th>Amount (Rs.) </th>
<th> Qty. (Units)</th>
<th> Amount(Rs.)</th>
<th> Qty. (Units)</th>
<th> Amount(Rs.)</th>
<th> Qty. (Units)</th>
<th> Amount(Rs.)</th>
</tr><?php */?>
<?php
$grand_total=0;
$total_month_total=0;
$grand_last_amount=0;
$last_month_act_total=0;
$this_month_act_total=0;
$ph_grand_total=0;
$ph_total_month_total=0;
$ph_last_month_act_total=0;
$ph_this_month_act_total=0;
$ph_vo_total_todate=0;
$ph_vo_grand_total_todate=0;
$ph_vo_lastmonth=0;
$ph_vo_grand_lastmonth=0;
$ph_vo_currentmonth=0;
$ph_vo_grand_currentmonth=0;
$query="SELECT * FROM variation_order where  cid=".$reportdata['cid']." GROUP by sa_id";
$reportresult_var = mysql_query($query)or die(mysql_error());
while ($reportdata_var = mysql_fetch_array($reportresult_var)) {
$reportquerynew ="SELECT  ca.cid,sum(cc.lqty) as lqty, sum(cc.lqty*ca.rates) as lastamount,ca.subactivityname,ca.aid,ca.s_id,ca.sa_id,ca.sid,ca.startdate,ca.units, min(ca.startdate) as mindate, ca.enddate, max(ca.enddate) as maxdate,  ca.quantity, ca.rates, cb.pqty, sum(cb.pqty) as tpqty,sum(ca.quantity*ca.rates) as amount, sum(ca.quantity) as tqty ,sum(cb.pamount)As totalamount,cb.pamount, cb.lbdate as lastdate , cb.prs FROM subactivitydata ca 
LEFT OUTER join (progressdata cb)
on (ca.sa_id = cb.sa_id )
LEFT OUTER join (lastmonthdata cc) 
on (cb.sa_id = cc.sa_id) Where  ca.sa_id=".$reportdata_var['sa_id']." GROUP BY ca.sa_id";

$reportresult_act = mysql_query($reportquerynew)or die(mysql_error());
while ($reportdata_act = mysql_fetch_array($reportresult_act)) {
 $bgcolor = ($bgcolor == "#33CC99") ? "#B7FFDB" : "#33CC99";
/*$bgcolor = ($bgcolor == "#FF9999") ? "#FFD5D5" : "#FF9999";*/
$variation_data_sub=getSubActivityVariationData_project($reportdata_act['sa_id']);
$variation_last_data_sub=getLastMonthSubactivityVariationData($reportdata_act['sa_id'],$last_month_bid);
$during_this_variation=$variation_data_sub['tvqty']-$variation_last_data_sub['lvqty'];
$ph_vo_total_todate=$variation_data_sub["variation_in_qty_amount"]+$variation_data_sub["variation_in_rate_amount"];
$ph_vo_lastmonth=$variation_last_data_sub["last_variation_in_qty_amount"]+$variation_last_data_sub["last_variation_in_rate_amount"];
$ph_vo_currentmonth=$ph_vo_total_todate-$ph_vo_lastmonth;
$total_amount_act=$reportdata_act['amount'];
$last_amount=$reportdata_act['lastamount'];
$grand_last_amount+=$last_amount;
$codeData_new=getCode_new($reportdata_act['sa_id']);
$total_qty=$variation_data_sub['tvqty']+$reportdata_act['tpqty'];
$last_progress_qty=$reportdata_act['tpqty']-$reportdata_act['lqty'];
$total_last_qty=$variation_last_data_sub['lvqty']+$last_progress_qty; //lqty is during this month qty
if($variation_data_sub['vrate']==0)
{
$this_month_act=(($reportdata_act['lqty'] + $during_this_variation) * $reportdata_act['prs']);
}
else
{
$this_month_act=(($reportdata_act['lqty'] + $during_this_variation) * $variation_data_sub['vrate']);
}

if($variation_last_data_sub['vrate']==0)
{
$last_month_act=($total_last_qty) * $reportdata_act['prs'];
}
else
{
$last_month_act=($total_last_qty) * $variation_last_data_sub['vrate'];
}

if($variation_data_sub['vrate']==0)
{
$total_month=($total_qty) * $reportdata_act['prs'];
}
else
{
$total_month=($total_qty) * $variation_data_sub['vrate'];
}

?>
<?php if($variation_data_sub['tvqty']!=0)
{

$ph_vo_grand_total_todate+=$ph_vo_total_todate;
$ph_vo_grand_lastmonth+=$ph_vo_lastmonth;
$ph_vo_grand_currentmonth+=$ph_vo_currentmonth;
$grand_total+=$total_amount_act;
$total_month_total+=$total_month;
$last_month_act_total+=$last_month_act;
$this_month_act_total+=$this_month_act;?>
<?php /*?><tr style="background-color:<?php echo $bgcolor;?>;">
<td style="text-align:center;"><?php echo  $codeData_new['code']; ?></td>
<td style="text-align:left;"><?php   echo $reportdata_act['subactivityname']; ?></td>
<td style="text-align:center;"><?php echo $reportdata_act['units']; ?></td>

<td style="text-align:center;"><?php echo number_format($reportdata_act['tqty'],2); ?></td>
<td style="text-align:right;"><?php  echo number_format($reportdata_act['rates'],2); ?></td>
<td style="text-align:right;"><?php  echo number_format (($reportdata_act['tqty'] * $reportdata_act['rates']),2) ; ?></td>
<td style="text-align:center;"><?php echo number_format ($total_last_qty,2); ?></td>
<td style="text-align:right;"><?php  echo number_format (($last_month_act),2) ; ?></td>
<td style="text-align:center;"><?php echo number_format ($total_qty - $total_last_qty,2); ?></td>
<td style="text-align:right;"><?php  echo number_format($this_month_act,2) ; ?></td>
<td style="text-align:center;"><?php echo number_format ($total_qty,2); ?></td>   
<td style="text-align:right;"><?php  echo number_format (($total_month),2) ; ?></td>
<td style="text-align:right;"><?php  if($reportdata_act['tpqty']!=0 && $reportdata_act['tqty']!=0)
{
echo number_format((($total_qty / $reportdata_act['tqty'])*100),2);
}
else
{
echo "0.0";
} ?></td>
</tr><?php */?>
<?php }?>
<?php
}
}
?>
<?php /*?><tr align="right" id="grand_total">
<td style="text-align:right;" colspan="5"><strong><?php echo  "Grand Total:"; ?></strong></td>

<td style="text-align:right;"><?php  
echo number_format ($grand_total,2); ?></td>
<td style="text-align:center;">&nbsp;</td>
<td style="text-align:right;"><?php  echo number_format (($this_month_act_total),2) ; ?></td>
<td style="text-align:center;">&nbsp;</td>
<td style="text-align:right;"><?php  echo  number_format ($last_month_act_total,2) ; ?></td>
<td style="text-align:center;">&nbsp;</td>   
<td style="text-align:right;"><?php  echo  number_format ($total_month_total,2) ; ?></td>
<td style="text-align:right;"><?php  if($total_month_total!=0&&$grand_total!=0)
{
echo number_format((($total_month_total/$grand_total)*100),2);
}
else
{
echo "0.0";
} ?></td>
</tr>
</table><?php */?>
		<?php /*?></div>	
		
</div><?php */?>
<?php 
 $physical_contigency=$ph_vo_grand_total_todate/$reportdata['amount']*100;
            }?>
	<?php if($physical_contigency!=0)
	{
	$actual_progress=$physical_contigency; //check here
	$physical_contigency=0;
	}
	else
	{
		
		if($reportdata['amount']!=0)
		{
	    $actual_progress=$reportdata['totalamount']  / $reportdata['amount']*100;
		}
		else
		{
			$actual_progress=0;
		}//check here
	}
	
	if($reportdata['sid']==4)
	{
	$CWeightData=getComponentWeight2(3,$reportdata['cid']);
	}
    $progress+=($CWeightData['c_weight']/100)*$weight*($actual_progress/100);
	}
	else
	{
	$actual_progress=$reportdata['totalamount']  / $reportdata['amount']*100;
    $progress+=($CWeightData['c_weight']/100)*($AWeightData['a_weight'])*($actual_progress/100);
	}
	}
	return $progress;
}
 $total_weighted_progress=0;
 /**********************function used*********/
function caculateTotalWeightedProgress($componentid)
{   $total_weighted_progress=0;
  
	$reportquery ="SELECT  ca.s_id FROM subactivitydata ca 
    LEFT OUTER join (progressdata cb) on (ca.sa_id = cb.sa_id) Where ca.cid=".$componentid." GROUP BY ca.s_id";
    $amountresult = mysql_query($reportquery);
    while($reportdata=mysql_fetch_array($amountresult))
	{
	 
     $weighted_progress=caculateTotalWeightedProgress3($reportdata["s_id"]);
	 $total_weighted_progress+=$weighted_progress;

	}
	/*if($progress>$CWeightData['c_weight']&&$progress<$CWeightData['c_weight']+1)
	{
	$progress=$CWeightData['c_weight'];
	}*/
	return $total_weighted_progress;
}

function caculateTotalWeightedProgress_new($componentid,$all_total)
{   $total_weighted_progress=0;
  
	$reportquery ="SELECT  ca.cid,ca.s_id FROM subactivitydata ca 
    LEFT OUTER join (progressdata cb) on (ca.sa_id = cb.sa_id) Where ca.cid=".$componentid." GROUP BY ca.s_id";
    $amountresult = mysql_query($reportquery);
    while($reportdata=mysql_fetch_array($amountresult))
	{
	 
     $weighted_progress=caculateTotalWeightedProgress1($reportdata["s_id"],$all_total);
	 $total_weighted_progress+=$weighted_progress;

	}
	/*if($progress>$CWeightData['c_weight']&&$progress<$CWeightData['c_weight']+1)
	{
	$progress=$CWeightData['c_weight'];
	}*/
	return $total_weighted_progress;
}
$progress=0;
/************************funtion used***************/
function caculateTotalWeightedProgress3($s_id)
{   $progress=0;
  
	$sql="SELECT ca.aid,sum(ca.quantity*ca.rates) as amount, sum(cb.pamount)As totalamount FROM subactivitydata ca 
			LEFT OUTER join (progressdata cb)
			on (ca.sa_id = cb.sa_id ) Where ca.s_id=".$s_id." GROUP BY ca.aid";
    $amountresult = mysql_query($sql);
    while($reportdata=mysql_fetch_array($amountresult))
	{
	 $CWeightData=getComponentWeight1($reportdata['aid']);
    $AWeightData=getActivityWeight($reportdata['aid']);
	if($reportdata['amount']!=0)
	{
	$actual_progress=$reportdata['totalamount']  / $reportdata['amount']*100;
	}
	else
	{
	$actual_progress=0;
	}
    $progress+=($CWeightData['c_weight']/100)*($AWeightData['a_weight'])*($actual_progress/100);

	}
	/*if($progress>$CWeightData['c_weight']&&$progress<$CWeightData['c_weight']+1)
	{
	$progress=$CWeightData['c_weight'];
	}*/
	return $progress;
}
function GetActualPrgoress($cid,$actual_progress)
{     $total_weighted_progress=0;
		$reportquery ="SELECT  ca.cid,ca.activityname,ca.aid,ca.s_id,ca.sa_id,ca.sid,ca.startdate, min(ca.startdate) as mindate, ca.enddate, 
		max(ca.enddate) as maxdate, ca.quantity, ca.rates, cb.pqty, sum(ca.quantity*ca.rates) as amount, sum(cb.pamount)As totalamount,cb.pamount, 
		cb.lbdate as lastdate FROM subactivitydata ca 
		LEFT OUTER join (progressdata cb)
		on (ca.sa_id = cb.sa_id ) Where ca.cid=".$cid." GROUP BY ca.aid";
		$reportresult = mysql_query($reportquery);
		while ($reportdata = mysql_fetch_array($reportresult)) {
		$weighted_progress=caculateTotalWeightedProgress($reportdata["s_id"]);
		$total_weighted_progress+=$weighted_progress;
		}
		
		return $total_weighted_progress;
}

$grand_total=0;
$total_progress=0;
$total_current_month_progress=0;
$total_upto_last_month_progress=0;
$total_noofdays=0;
$total_timeElps=0;
$total_planned_progress=0;
$to_date_progress=0;
$current_month_progress=0;
$actual_progress=0;
$weighted_progress=0;
$totalweight=0;
$ComponentWeightSumTotal=0;

 ?>
<input type="hidden" id="projectid" name="projectid" value="<?php echo $projectid; ?>" />
<?php 
$current=0;
$prev=0;
$prev_prog=0;
$actual=0;
$activity_weight=0;
$total_weighted_progress=0;
$bgcolor="";
$ComponentWeightSum=0;
$wactual_progress=0;
$activity_weight=0;
/*$totalresultquery="SELECT sum(`quantity`* `rates` ) grand_total FROM subactivitydata WHERE cid =1 AND (sid =3 OR sid =4) GROUP BY cid";
$totalresult=mysql_query($totalresultquery);
 $all_total_data=mysql_fetch_array($totalresult);
 $all_total=$all_total_data["grand_total"];*/
$reportquery ="SELECT  ca.cid,ca.componentname,ca.aid FROM subactivitydata ca 
LEFT OUTER join (progressdata cb) on (ca.sa_id = cb.sa_id) Where ca.pid=".$projectid." GROUP BY ca.cid";
$i=0;
//$start_time=microtime(true);
$reportresult = mysql_query($reportquery);
//$stop_time=microtime(true);
//echo "<br/>Time taken: ".number_format($stop_time-$start_time,4);
while($reportdata = mysql_fetch_array($reportresult))
 {
 $i++;
 $bgcolor = ($bgcolor == "#FFFFFF") ? "#EAF4FF" : "#FFFFFF";
/*$codeNameData=getNameCode($reportdata['aid']);*/
$CWeightData=getComponentWeight($reportdata['cid']);
$AWeightData=getActivityWeight($reportdata['aid']);
$activity_weight=$AWeightData['a_weight'];
/*$SCWeightData=getWeightSum($reportdata['cid'],$reportdata['sid']);*/
/*$ComponentWeightSum=$SCWeightData["component_weighted_sum"];*/

/*$AWeightData=getActivityWeight($reportdata['aid']);*/
/*$activity_weight=$AWeightData['a_weight'];*/
//$actual_progress=$reportdata['totalamount']/$reportdata['amount']*100;


 
$query="SELECT * FROM subcomponents where (sid=3 OR sid=4) and cid=".$reportdata['cid'];
$queryresult = mysql_query($query);
$numrows=mysql_num_rows($queryresult);
if($numrows>0)
{
$totalresultquery="SELECT sum(`quantity`* `rates` ) grand_total FROM subactivitydata WHERE cid =".$reportdata['cid']." AND (sid =3 OR sid =4) GROUP BY cid";
$totalresult=mysql_query($totalresultquery);
 $all_total_data=mysql_fetch_array($totalresult);
 $all_total=$all_total_data["grand_total"];
$wactual_progress=caculateTotalWeightedProgress_new($reportdata['cid'],$all_total);

}
else
{
$wactual_progress=caculateTotalWeightedProgress($reportdata["cid"]);
}

/*$total_progress+=$reportdata['totalamount'];
$grand_total+=$reportdata['amount'];*/

/*if($all_total!=0&&$all_total!="")
{
$weight= ($reportdata['amount']/$all_total)*100;
$totalweight+=$weight;
}
else
{
echo "0.0"; 
}*/

?>
<tr style="background-color:<?php echo $bgcolor;?>;">
<td align="center"><?php echo $i;?></td>
<td nowrap="nowrap" style="text-align:center;"><div align="left"><?php echo $reportdata['componentname']; ?> </div></td>
<td nowrap="nowrap" style="text-align:right;"><?php echo number_format ($CWeightData['com_weight'],2); ?>
<input type="hidden" id="com_weight[<?php echo $i;?>]" name="com_weight[<?php echo $i;?>]" value="<?php echo $CWeightData['com_weight']; ?>" /></td>
<!--<td style="text-align:left;"></td>-->
<td nowrap="nowrap" style="text-align:right;"><?php 
/*echo $actual_progress;
echo "</br>";
echo $ComponentWeightSum;
echo "<br/>"*/;
// $wactual_progress=$actual_progress*$ComponentWeightSum/100;
echo  number_format (($wactual_progress),2); ?></td>
<td nowrap="nowrap" style="text-align:right;"><?php $weighted_progress=$wactual_progress*$CWeightData['com_weight']/100;
$total_weighted_progress+=$weighted_progress;
echo number_format($weighted_progress,2)?>
<input type="hidden" id="com_prog[<?php echo $i;?>]" name="com_prog[<?php echo $i;?>]" value="<?php echo $weighted_progress; ?>" />
</td>
</tr>

<?php

}
?>
<tr align="right" id="grand_total">
<td align="right" nowrap="nowrap" colspan="2">
<strong>Grand Total:</strong></td>

<td align="right" nowrap="nowrap"><strong><?php 
$WeightSumDataTotal=getWeightSumTotal();
$ComponentWeightSumTotal=$WeightSumDataTotal["component_weighted_sum"];
echo number_format($ComponentWeightSumTotal,2);?></strong></td>
<?php /*?><!--<td align="right"><?php echo number_format($grand_total,2);?></td>--><?php */?>
<td align="right" nowrap="nowrap">
<?php 
//echo  number_format(($total_progress/$grand_total*100),2);?></td>
<td align="right" nowrap="nowrap">
<strong><?php echo  number_format($total_weighted_progress,2);?></strong></td>
</tr>
</table>
<?php /*?><img src="gph2.php?projectid=<?php echo $projectid; ?>&com_weight=<?php echo $com_weight; ?>&com_prog=<?php echo $com_prog; ?>"><?php */?>
</form>

<?php
}
?>
</div>



<!--Start Component Table Here-->

<div id="result3">
<?php
if ($componentflag == 1 && $activitytypeid == 0 ) {
?>
<table  cellpadding="0px" cellspacing="0px"   width="93%" align="center"  id="tblList">

<tr  id="title">
<td colspan="6" align="center"><span class="white"><strong>Component Detail Progress Report</strong></span> 
<span style="position:absolute; padding-left:250px">  <a style="text-decoration:none;color:#ffffff" href="javascript:void(null);" onclick="window.open('printcomponent_detail_report.php?componentid=<?php echo $componentid;?>&projectid=<?php echo $projectid;?>', 'INV', 'width=1120,height=550,scrollbars=yes');" ><img src="images/ico_print.gif" border="0" /> Print Report</a></span> </td>  
</tr>
<tr id="tblHeading1">
<th width="253" height="37"><div align="left">Component</div></th>
      <th width="77"> Code</th>
    <th width="274">Sub-Activity Name</th>
    <th width="135" nowrap="nowrap">Assigned weight %</th>
    <!--  <th width="110">Contract Amount</th> -->  
      <th width="137" nowrap="nowrap">Activity Actual Progress %</th>
      <th width="153" nowrap="nowrap">Component Weighted Progress % </th>
  </tr>

<!--<tr>
<td style="text-align:center;">Code</td>
<td style="text-align:left;">Detail</td>
<td style="text-align:center;">Start Date</td>
<td style="text-align:center;">End Date</td>
<td style="text-align:right;">Assigned Weight</td>
<td style="text-align:right;">Remark</td>
<td style="text-align:right;">Progress Date</td>
<td style="text-align:right;">Total Amount</td>
<td style="text-align:right;">Uptodate Progress Amount</td>
<td style="text-align:right;">Current Month Amount</td>
</tr>-->

<?php
//$reportquery = "select code, detail, uom, qty, rs, amount from sub_activity where pid=".$projectid." and cid=".$componentid." and sid=".$activitytypeid." and s_id=".

$weighted_progress=0;

function getProgressAmount($cid,$s_id)
{
 $sql2="SELECT MAX(bdate) as lastdate , SUM( pqty * prs ) AS tamount
FROM  `progress` 
WHERE s_id =".$s_id."
AND cid =".$cid."
GROUP BY s_id";
$pamountresult = mysql_query($sql2)or die(mysql_error());
$pdata=mysql_fetch_array($pamountresult);
return $pdata;
}
function getCurrentProgressAmount($cid,$sa_id)
{

$thismonth=date('Ym');
$sql="SELECT SUM(pamount) AS cprogress
FROM `progressdata` 
WHERE  sa_id =".$sa_id."
AND lbdate LIKE '%".$thismonth."'
GROUP BY sa_id
";
$current_month_result = mysql_query($sql)or die(mysql_error());
$data=mysql_fetch_array($current_month_result);
return $data;
}
function getCode($aid)
{
 $sql="SELECT code FROM  `activity` where aid=".$aid;
 $amountresult = mysql_query($sql);
//echo $amountsize= mysql_num_rows($amountresult);
 $data=mysql_fetch_array($amountresult);

return $data;
}
function getNameCode($aid)
{
 $sql="SELECT subcomponentname FROM  `subactivitydata` where aid=".$aid;
 $amountresult = mysql_query($sql);
//echo $amountsize= mysql_num_rows($amountresult);
 $data=mysql_fetch_array($amountresult);

return $data;
}
function getComponentWeight($aid)
{
 $sql="SELECT c_weight FROM  `subactivitydata` where aid=".$aid;
 $amountresult = mysql_query($sql);
//echo $amountsize= mysql_num_rows($amountresult);
 $data=mysql_fetch_array($amountresult);

return $data;
}
function getSubComponentWeight($cid,$s_id)
{
 $sql="SELECT assig as c_weight FROM  `subcomponents` where cid=".$cid." AND s_id=".$s_id;
 $amountresult = mysql_query($sql);
//echo $amountsize= mysql_num_rows($amountresult);
 $data=mysql_fetch_array($amountresult);

return $data;
}
function getSubComponentWeight1($sid,$cid,$s_id)
{
 $sql="SELECT assig as c_weight FROM  `subcomponents` where cid=".$cid." AND s_id=".$s_id." AND sid=".$sid;
 $amountresult = mysql_query($sql);
//echo $amountsize= mysql_num_rows($amountresult);
 $data=mysql_fetch_array($amountresult);

return $data;
}
function getComponentWeight1($sid,$cid)
{
 $sql="SELECT assig as c_weight FROM  `subcomponents` where sid=".$sid." And cid=".$cid;
 $amountresult = mysql_query($sql);
//echo $amountsize= mysql_num_rows($amountresult);
 $data=mysql_fetch_array($amountresult);

return $data;
}
function getActivityWeight($aid)
{
 $sql="SELECT a_weight FROM  `subactivitydata` where aid=".$aid;
 $amountresult = mysql_query($sql);
//echo $amountsize= mysql_num_rows($amountresult);
 $data=mysql_fetch_array($amountresult);
return $data;
}
function getWeightSum($cid,$sid)
{
 $sql="select Sum(assig) as component_weighted_sum from subcomponents where cid=".$cid." and sid=".$sid;
 $amountresult = mysql_query($sql);
//echo $amountsize= mysql_num_rows($amountresult);
 $data=mysql_fetch_array($amountresult);
return $data;
}
function getStructureName($sid)
{
 $sql="select detail from activitytype where  sid=".$sid;
 $amountresult = mysql_query($sql);
//echo $amountsize= mysql_num_rows($amountresult);
 $data=mysql_fetch_array($amountresult);
return $data;
}
function getWeightSumTotal($cid)
{
 $sql="select Sum(assig) as component_weighted_sum from subcomponents where cid=".$cid;
 $amountresult = mysql_query($sql);
//echo $amountsize= mysql_num_rows($amountresult);
 $data=mysql_fetch_array($amountresult);
return $data;
}
$progress=0;
function caculateTotalWeightedProgress($s_id)
{   $progress=0;
  
	$sql="SELECT ca.aid,sum(ca.quantity*ca.rates) as amount, sum(cb.pamount)As totalamount FROM subactivitydata ca 
			LEFT OUTER join(progressdata cb)
			on (ca.sa_id = cb.sa_id ) Where ca.s_id=".$s_id." GROUP BY ca.aid ";
    $amountresult = mysql_query($sql);
    while($reportdata=mysql_fetch_array($amountresult))
	{
	 $CWeightData=getComponentWeight($reportdata['aid']);
    $AWeightData=getActivityWeight($reportdata['aid']);
	if($reportdata['amount']!=0)
	{
	$actual_progress=$reportdata['totalamount']  / $reportdata['amount']*100;
	}
	else
	{
	$actual_progress=0;
	}
    $progress+=($CWeightData['c_weight']/100)*($AWeightData['a_weight'])*($actual_progress/100);

	}
	/*if($progress>$CWeightData['c_weight']&&$progress<$CWeightData['c_weight']+1)
	{
	$progress=$CWeightData['c_weight'];
	}*/
	return $progress;
}
function getSubActivityVariationData_phy_cont($sa_id)
{ 
$sql2="SELECT sum(vd.vqty) As tvqty, sum(vd.vrate*cc.quantity) as variation_in_rate_amount, sum(vd.vqty*cc.rates) as variation_in_qty_amount,sum(vd.`vamount`) as variation_in_amount,vd.`vo_id`,vd.`contigency_code`,vd.`vono`,vd.`vodate`,vd.`bid`,vd.`remark`,vd.`vstatus`,vd.`bdate`
FROM variationdata vd
LEFT OUTER JOIN (subactivitydata cc) on (vd.sa_id = cc.sa_id) where cc.sa_id=".$sa_id." GROUP BY cc.sa_id";
$pamountresultp = mysql_query($sql2)or die(mysql_error());
$pgdata=mysql_fetch_array($pamountresultp);
return $pgdata;
}
function GetPhysicalContigencyAmount($cid)
{
$total_qty=0;
$total_qty_all=0;
$total_month=0;
$total_month_total=0;
$reportquerynew ="SELECT  ca.cid,sum(cc.lqty) as lqty, sum(cc.lqty*ca.rates) as lastamount,ca.subactivityname,ca.aid,ca.s_id,ca.sa_id,ca.sid,ca.startdate,ca.units, min(ca.startdate) as mindate, ca.enddate, max(ca.enddate) as maxdate,  ca.quantity, ca.rates, cb.pqty, sum(cb.pqty) as tpqty,sum(ca.quantity*ca.rates) as amount, sum(ca.quantity) as tqty ,sum(cb.pamount)As totalamount,cb.pamount, cb.lbdate as lastdate , cb.prs FROM subactivitydata ca 
LEFT OUTER join (progressdata cb)
on (ca.sa_id=cb.sa_id)
LEFT OUTER join (lastmonthdata cc) 
on (cb.sa_id=cc.sa_id)Where ca.cid=".$cid." GROUP BY ca.sa_id order by ca.sub_order ASC";

$reportresult_act = mysql_query($reportquerynew)or die(mysql_error());
while ($reportdata_act = mysql_fetch_array($reportresult_act)) {
$variation_data_sub=getSubActivityVariationData_phy_cont($reportdata_act['sa_id']);
 if($variation_data_sub['tvqty']!=0)
{
$total_amount_act_all=$reportdata_act['amount'];
$total_qty=$variation_data_sub['tvqty'];
$total_qty_all=$variation_data_sub['tvqty']+$reportdata_act['tpqty'];

if($variation_data_sub['vrate']==0)
{
$total_month=($total_qty) * $reportdata_act['prs'];
$total_month_all=($total_qty_all) * $reportdata_act['prs'];
}
else
{
$total_month=($total_qty) * $variation_data_sub['vrate'];
$total_month_all=($total_qty_all) * $variation_data_sub['vrate'];
}
$total_month_total+=$total_month;
}
}
return $total_month_total;
}

function caculateTotalWeightedProgress1($cid,$all_total,$s_id,$total_phy_cont)
{   $progress=0;
	$phy_contract_amount=0;
	$cont_prog=0;
	
      $sql="SELECT * FROM subcomponents where cid=".$cid." AND sid=3 ";
 	$result = mysql_query($sql);
 	$size= mysql_num_rows($result);
 	if($size>1)
 	{
	 $sql="SELECT ca.sid,sum(ca.quantity*ca.rates) as amount, sum(cb.pamount)As totalamount,ca.activitycode FROM subactivitydata ca 
        	LEFT OUTER join (progressdata cb)
			on (ca.sa_id = cb.sa_id ) Where ca.cid=".$cid." AND s_id=".$s_id." AND (ca.sid=3 or sid=4) GROUP BY ca.aid";
	}
	else
	{
		$sql="SELECT ca.sid,sum(ca.quantity*ca.rates) as amount, sum(cb.pamount)As totalamount,ca.activitycode FROM subactivitydata ca 
        	LEFT OUTER join (progressdata cb)
			on (ca.sa_id = cb.sa_id ) Where ca.cid=".$cid."  AND (ca.sid=3 or sid=4) GROUP BY ca.aid";
	}
    $amountresult = mysql_query($sql);
    while($reportdata=mysql_fetch_array($amountresult))
	{
		$code=$reportdata["activitycode"];
	 $CWeightData=getSubComponentWeight($cid,$s_id);
			if($all_total!=0&&$all_total!="")
			{
			  $weight= ($reportdata['amount']/$all_total)*100;
			
			 //$totalweight+=$weight;
			}
			
	if($reportdata['amount']!=0)
	{
     $actual_progress=$reportdata['totalamount']  / $reportdata['amount']*100;
	//echo "</br>";
	}
	else
	{
	$actual_progress=0;
	}
	if($reportdata['sid']==4)
	{
	$CWeightData=getSubComponentWeight1(3,$cid,$s_id);
	}
	
    $progress+=($CWeightData['c_weight']/100)*$weight*($actual_progress/100);
 if($reportdata["activitycode"]=='F')
	{
	    $phy_contract_amount=$reportdata["amount"];
		$actual_progress=$total_phy_cont/$phy_contract_amount;
	 	$CWeightData['c_weight'];
	 	$res=($CWeightData['c_weight']/100)*$weight*($actual_progress/100)*100;
		$progress+=$res;
	}
	}
	
	
	return $progress;
}
$grand_total=0;
$total_progress=0;
$total_current_month_progress=0;
$total_upto_last_month_progress=0;
$total_noofdays=0;
$total_timeElps=0;
$total_planned_progress=0;
$to_date_progress=0;
$current_month_progress=0;
$actual_progress=0;
$weighted_progress=0;
$totalweight=0;
$total_weighted_progress=0;
$ComponentWeightSum=0;
$ComponentWeightSumTotal=0;
$sub_total_actual_progress=0;
$grand_total_weighted_progress=0;
$weightedp=0;
$physical_contigency=0;
/*$outerquery="SELECT * FROM subactivitydata where  cid=".$componentid;
$outeresult = mysql_query($outerquery);
while($outerdata= mysql_fetch_array($outeresult))
{*/
 ?>

<?php 
$mob_weighted_progress=0;
$w1=0;
 $bgcolor=0;
$weightedp_cont=0;
$weightedp1=0;
$weightedp2=0;
$StructureName="";
$current=0;
$prev=0;
$current1=0;
$prev1=0;
$activity_weight=0;
$pre_total_weighted_progress=0;
$total_phy_cont=0;
$reportquery ="SELECT  ca.cid,ca.activityname,ca.aid,ca.s_id,ca.sa_id,ca.sid, sum(ca.quantity*ca.rates) as amount, sum(cb.pamount)As totalamount,cb.pamount FROM subactivitydata ca 
LEFT OUTER join (progressdata cb)
on (ca.sa_id = cb.sa_id ) Where ca.cid=".$componentid." GROUP BY ca.sid,ca.s_id,ca.aid ORDER by ca.a_order,ca.sub_order,ca.sa_id";
$i=0;
$reportresult = mysql_query($reportquery);
$totalresultquery="SELECT sum(`quantity`* `rates` ) grand_total FROM subactivitydata WHERE cid =".$componentid." AND (sid =3 OR sid =4) GROUP BY cid";
$totalresult=mysql_query($totalresultquery);
 $all_total_data=mysql_fetch_array($totalresult);
 $all_total=$all_total_data["grand_total"];
$total_phy_cont=GetPhysicalContigencyAmount($componentid);
while ($reportdata = mysql_fetch_array($reportresult)) {
  $bgcolor = ($bgcolor == "#FFFFFF") ? "#EAF4FF" : "#FFFFFF";
$codeNameData=getNameCode($reportdata['aid']);
$CWeightData=getComponentWeight($reportdata['aid']);
$AWeightData=getActivityWeight($reportdata['aid']);
$current=$reportdata['s_id'];
$current1=$reportdata['sid'];
if($all_total!=0&&$all_total!="")
{
 $weight= ($reportdata['amount']/$all_total)*100;
 $totalweight+=$weight;
}
$activity_weight=$AWeightData['a_weight'];
if($reportdata['amount']!=0)
{
$actual_progress=$reportdata['totalamount']  / $reportdata['amount']*100;
}
else
{
$actual_progress=0;
}
if($reportdata['sid']==1|| $reportdata['sid']==2 || $reportdata['sid']==5|| $reportdata['sid']==6)
{
if($prev!=$current)
{

$weightedp=caculateTotalWeightedProgress($reportdata['s_id']);
if($reportdata['sid']==2)
{
$mob_weighted_progress=$weightedp;
}
}
}
else if($reportdata['sid']==3|| $reportdata['sid']==4)
{
/*if($prev1!=$current1)
{*/
/*if($reportdata['sid']==3)
{
$weightedp1=caculateTotalWeightedProgress1($reportdata['s_id'],$all_total);
}
if($reportdata['sid']==4)
{
  $weightedp2=caculateTotalWeightedProgress1($reportdata['s_id'],$all_total);
}*/

 $weightedp=caculateTotalWeightedProgress1($componentid,$all_total,$reportdata['s_id'],$total_phy_cont);
//}
}

/*else
{
$weightedp+=caculateTotalWeightedProgress($activity_weight,$CWeightData['c_weight'],$actual_progress);
}
*/

if($current1!=4)
{
if($prev!=$current)
{?>
<?php
if($prev1!=$current1)
{
?>
<?php if($prev1!=0)
{?>
<tr align="right" id="sub_title">
<td align="left">&nbsp;</td>

<td colspan="2" align="right">
<strong><?php echo  $StructureName; ?>&nbsp;Sub Total:</strong></td>
<td align="right"><strong><?php 
$WeightSumData=getWeightSum($reportdata['cid'],$prev1);
$ComponentWeightSum=$WeightSumData["component_weighted_sum"];
echo number_format($ComponentWeightSum,2);?></strong></td>
<?php /*?><!--<td align="right"><?php echo number_format($ComponentWeightSum,2);?></td>--><?php */?>
<td align="right">
<?php $sub_total_actual_progress=($total_weighted_progress/$ComponentWeightSum*100);
//echo  number_format($sub_total_actual_progress,2);?></td>
<td align="right">
<strong><?php echo  number_format($total_weighted_progress,2);
$grand_total_weighted_progress+=$total_weighted_progress;

$total_weighted_progress=0;?></strong></td>
</tr>
<?php }?>
<tr align="right" id="sub_title">
<td align="left">
<strong><?php
$StructureNameData=getStructureName($reportdata['sid']);
$StructureName=$StructureNameData["detail"];
echo  $StructureName;?></strong></td>
<td colspan="5" style="text-align:center;">&nbsp;  </td>
<!--<td style="text-align:left;"></td>-->
</tr>

<?php }?>
<tr id="sub_title">
<td height="20" style="text-align:center;"><div align="left"><?php echo $codeNameData['subcomponentname']; ?></div></td>
<td colspan="2" style="text-align:center;">&nbsp;  </td>
<td style="text-align:right;"><strong><?php echo number_format ($CWeightData['c_weight'],2); ?></strong></td>
<!--<td style="text-align:left;"></td>-->
<td style="text-align:right;"><strong><?php 
if($CWeightData['c_weight']!=0)
{
echo number_format (($weightedp/$CWeightData['c_weight']*100),2);
} ?></strong></td>
<td style="text-align:right;"><strong><?php echo number_format($weightedp,2); 
?></strong></td>
</tr>

<?php

}
}
//$progressData=getProgressAmount($componentid,$reportdata['s_id']);
$codeData=getCode($reportdata['aid']);

/*$reportdata["lastamount"]=1;*/
//$this_month_progress=getCurrentProgressAmount($componentid,$reportdata['sa_id']);
//$current_month_progress=$this_month_progress['cprogress'];
/*$total_current_month_progress+=$reportdata["lastamount"];
$mindate=$reportdata["mindate"];
$maxdate=$reportdata["maxdate"];*/

?>
<?php
/*$aenddate = strtotime(substr($reportdata['enddate'],0,4)."-".substr($reportdata['enddate'],4,2)."-".substr($reportdata['enddate'],6,2));
$astartdate = strtotime(substr($reportdata['startdate'],0,4)."-".substr($reportdata['startdate'],4,2)."-".substr($reportdata['startdate'],6,2));
$datediff = $aenddate - $astartdate;
$noofdays = number_format($datediff/(60*60*24),0);
$noofdays=trim(str_replace(",","",$noofdays));
$total_noofdays+=$noofdays;*/
?>

<?php
/*$aenddate = strtotime(substr($reportdata['enddate'],0,4)."-".substr($reportdata['enddate'],4,2)."-".substr($reportdata['enddate'],6,2));
$tlbdate = strtotime(substr($reportdata['lastdate'],0,4)."-".substr($reportdata['lastdate'],4,2)."-".substr($reportdata['lastdate'],6,2));
$datediff = $aenddate - $tlbdate;
$timeElps = number_format($datediff/(60*60*24),0);
$total_timeElps+=$timeElps;*/
?>
<tr style="background-color:<?php echo $bgcolor;?>;">
<td height="20" style="text-align:center;">&nbsp;</td>
<td style="text-align:center;"><?php echo $codeData['code']; ?></td>
<td style="text-align:left;"><?php echo $reportdata['activityname']; ?></td>
<td style="text-align:right;"><?php 
if($reportdata['sid']==3|| $reportdata['sid']==4)
{
echo number_format($weight,2);

}
else
{
echo number_format ($activity_weight,2);
} ?></td>

<?php /*?><td style="text-align:right;"><?php $grand_total+=$reportdata['amount'];
									echo number_format(($reportdata['amount']),2); ?></td>
<?php */?>									
									
<td style="text-align:right;"><?php if($codeData['code']=='F') { ///// ///////point 2
function getSubActivityVariationData($sa_id)
{ 
$sql2="SELECT sum(vd.vqty) As tvqty, sum(vd.vrate*cc.quantity) as variation_in_rate_amount, sum(vd.vqty*dd.prs) as variation_in_qty_amount,sum(vd.`vamount`) as variation_in_amount,vd.`vo_id`,vd.`contigency_code`,vd.`vono`,vd.`vodate`,vd.`bid`,vd.`remark`,vd.`vstatus`,vd.`bdate`
FROM variationdata vd
LEFT OUTER JOIN (subactivitydata cc) on (vd.sa_id = cc.sa_id)
LEFT OUTER JOIN (progressdata dd) on (vd.sa_id = dd.sa_id) where cc.sa_id=".$sa_id." GROUP BY cc.sa_id";
$pamountresultp = mysql_query($sql2)or die(mysql_error());
$pgdata=mysql_fetch_array($pamountresultp);
return $pgdata;
}
function getLastMonthSubactivityVariationData($sa_id,$bid)
{ 
 $sql2="SELECT sum(vd.vqty) As lvqty, sum(vd.vrate*cc.quantity) as last_variation_in_rate_amount, sum(vd.vqty*dd.prs) as last_variation_in_qty_amount,sum(vd.`vamount`) as last_variation_in_amount,vd.`vo_id`,vd.`contigency_code`,vd.`vono`,vd.`vodate`,vd.`bid`,vd.`remark`,vd.`vstatus`,vd.`bdate`
FROM variationdata vd
LEFT OUTER JOIN (subactivitydata cc) on (vd.sa_id = cc.sa_id)
LEFT OUTER JOIN (progressdata dd) on (vd.sa_id = dd.sa_id) where cc.sa_id=".$sa_id." AND vd.bid=".$bid." GROUP BY cc.sa_id";
$pamountresultp = mysql_query($sql2)or die(mysql_error());
$pgdata=mysql_fetch_array($pamountresultp);
return $pgdata;
}
function getCode_new($sa_id)
{
 $sql="SELECT code FROM  `subactivity` where sa_id=".$sa_id;
 
$amountresult = mysql_query($sql);
//echo $amountsize= mysql_num_rows($amountresult);
$data=mysql_fetch_array($amountresult);

return $data;
}
function LastMonthProgressDate()
{
$sql="SELECT  MIN(bdate) as lastMonthdate,bid FROM  `progressmonth`  Group by bid order by bid ASC";
$amountresult = mysql_query($sql);
//echo $amountsize= mysql_num_rows($amountresult);
$data=mysql_fetch_array($amountresult);
return $data;
}
$last_month_data=LastMonthProgressDate();
$last_month_bid=$last_month_data["bid"];?>

<div class="msg_list" style="display:none">
		<p class="msg_head" style="background-color:#00CC66">View Subactivities <span> <a style="text-decoration:none;color:#ffffff" href="javascript:void(null);" onclick="window.open('print_variation_subactivity_level_report.php?subcomponentid=<?php echo $var_s_id;?>&amp;projectid=<?php echo $projectid;?>&amp;activitytypeid=<?php echo $var_sid;?>&amp;componentid=<?php echo $reportdata['cid'];?>&amp;activityid=<?php echo $var_a_id;?>&amp;subactivityid=<?php echo $reportdata['sa_id'];?>&last_aid=<?php echo $reportdata['aid'];?>','INV','width=1120,height=550,scrollbars=yes');" ><img src="images/popout.gif" border="0" title="pop out"/></a></span></p>
		<div class="msg_body">
			<table id="tblList" cellpadding="0px" cellspacing="0px"   width="98%" align="center" >

<tr id="tblHeading">
<th rowspan="2"> Sr. No. </th>
<th rowspan="2">Description </th>
<th rowspan="2"> UOM </th>
<!--<th colspan="3">As Per Estimate</th>-->
<th colspan="3"> As Per Bid</th>
<th colspan="2">Paid Upoto Previous </th>
<th colspan="2">During This Month </th>
<th colspan="2">(Executed) Upto Date </th>
<th rowspan="2"> % in Progress</th>
</tr>
<tr id="tblHeading">
<!--<th>Qty. (Units) </th>
<th>Rate </th>
<th> Amount</th>-->
<th>Qty. (Units) </th>
<th>Rate (Rs.) </th>
<th>Amount (Rs.) </th>
<th> Qty. (Units)</th>
<th> Amount(Rs.)</th>
<th> Qty. (Units)</th>
<th> Amount(Rs.)</th>
<th> Qty. (Units)</th>
<th> Amount(Rs.)</th>
</tr>
<?php
$grand_total=0;
$total_month_total=0;
$grand_last_amount=0;
$last_month_act_total=0;
$this_month_act_total=0;
$ph_grand_total=0;
$ph_total_month_total=0;
$ph_last_month_act_total=0;
$ph_this_month_act_total=0;
$ph_vo_total_todate=0;
$ph_vo_grand_total_todate=0;
$ph_vo_lastmonth=0;
$ph_vo_grand_lastmonth=0;
$ph_vo_currentmonth=0;
$ph_vo_grand_currentmonth=0;
$query="SELECT * FROM variation_order where  cid=".$reportdata['cid']." GROUP by sa_id";
$reportresult_var = mysql_query($query)or die(mysql_error());
while ($reportdata_var = mysql_fetch_array($reportresult_var)) {
$reportquerynew ="SELECT  ca.cid,sum(cc.lqty) as lqty, sum(cc.lqty*ca.rates) as lastamount,ca.subactivityname,ca.aid,ca.s_id,ca.sa_id,ca.sid,ca.startdate,ca.units, min(ca.startdate) as mindate, ca.enddate, max(ca.enddate) as maxdate,  ca.quantity, ca.rates, cb.pqty, sum(cb.pqty) as tpqty,sum(ca.quantity*ca.rates) as amount, sum(ca.quantity) as tqty ,sum(cb.pamount)As totalamount,cb.pamount, cb.lbdate as lastdate , cb.prs FROM subactivitydata ca 
LEFT OUTER join (progressdata cb)
on (ca.sa_id = cb.sa_id )
LEFT OUTER join (lastmonthdata cc) 
on (cb.sa_id = cc.sa_id) Where  ca.sa_id=".$reportdata_var['sa_id']." GROUP BY ca.sa_id";

$reportresult_act = mysql_query($reportquerynew)or die(mysql_error());
while ($reportdata_act = mysql_fetch_array($reportresult_act)) {
 $bgcolor = ($bgcolor == "#33CC99") ? "#B7FFDB" : "#33CC99";
/*$bgcolor = ($bgcolor == "#FF9999") ? "#FFD5D5" : "#FF9999";*/
$variation_data_sub=getSubActivityVariationData($reportdata_act['sa_id']);
$variation_last_data_sub=getLastMonthSubactivityVariationData($reportdata_act['sa_id'],$last_month_bid);
$during_this_variation=$variation_data_sub['tvqty']-$variation_last_data_sub['lvqty'];
$ph_vo_total_todate=$variation_data_sub["variation_in_qty_amount"]+$variation_data_sub["variation_in_rate_amount"];
$ph_vo_lastmonth=$variation_last_data_sub["last_variation_in_qty_amount"]+$variation_last_data_sub["last_variation_in_rate_amount"];
$ph_vo_currentmonth=$ph_vo_total_todate-$ph_vo_lastmonth;
$total_amount_act=$reportdata_act['amount'];
$last_amount=$reportdata_act['lastamount'];
$grand_last_amount+=$last_amount;
$codeData_new=getCode_new($reportdata_act['sa_id']);
$total_qty=$variation_data_sub['tvqty']+$reportdata_act['tpqty'];
$last_progress_qty=$reportdata_act['tpqty']-$reportdata_act['lqty'];
$total_last_qty=$variation_last_data_sub['lvqty']+$last_progress_qty; //lqty is during this month qty
if($variation_data_sub['vrate']==0)
{
$this_month_act=(($reportdata_act['lqty'] + $during_this_variation) * $reportdata_act['prs']);
}
else
{
$this_month_act=(($reportdata_act['lqty'] + $during_this_variation) * $variation_data_sub['vrate']);
}

if($variation_last_data_sub['vrate']==0)
{
$last_month_act=($total_last_qty) * $reportdata_act['prs'];
}
else
{
$last_month_act=($total_last_qty) * $variation_last_data_sub['vrate'];
}

if($variation_data_sub['vrate']==0)
{
$total_month=($total_qty) * $reportdata_act['prs'];
}
else
{
$total_month=($total_qty) * $variation_data_sub['vrate'];
}

?>
<?php if($variation_data_sub['tvqty']!=0)
{

$ph_vo_grand_total_todate+=$ph_vo_total_todate;
$ph_vo_grand_lastmonth+=$ph_vo_lastmonth;
$ph_vo_grand_currentmonth+=$ph_vo_currentmonth;
$grand_total+=$total_amount_act;
$total_month_total+=$total_month;
$last_month_act_total+=$last_month_act;
$this_month_act_total+=$this_month_act;?>
<tr style="background-color:<?php echo $bgcolor;?>;">
<td style="text-align:center;"><?php echo  $codeData_new['code']; ?></td>
<td style="text-align:left;"><?php   echo $reportdata_act['subactivityname']; ?></td>
<td style="text-align:center;"><?php echo $reportdata_act['units']; ?></td>
<?php /*?><td style="text-align:center;"><?php echo number_format($reportdata['quantity'],2); ?></td>
<td style="text-align:right;"><?php  echo number_format($reportdata['rates'],2); ?></td>
<td style="text-align:right;"><?php  echo number_format (($reportdata['quantity'] * $reportdata['rates']),2) ; ?></td><?php */?>
<td style="text-align:center;"><?php echo number_format($reportdata_act['tqty'],2); ?></td>
<td style="text-align:right;"><?php  echo number_format($reportdata_act['rates'],2); ?></td>
<td style="text-align:right;"><?php  echo number_format (($reportdata_act['tqty'] * $reportdata_act['rates']),2) ; ?></td>
<td style="text-align:center;"><?php echo number_format ($total_last_qty,2); ?></td>
<td style="text-align:right;"><?php  echo number_format (($last_month_act),2) ; ?></td>
<td style="text-align:center;"><?php echo number_format ($total_qty - $total_last_qty,2); ?></td>
<td style="text-align:right;"><?php  echo number_format($this_month_act,2) ; ?></td>
<td style="text-align:center;"><?php echo number_format ($total_qty,2); ?></td>   
<td style="text-align:right;"><?php  echo number_format (($total_month),2) ; ?></td>
<td style="text-align:right;"><?php  if($reportdata_act['tpqty']!=0 && $reportdata_act['tqty']!=0)
{
echo number_format((($total_qty / $reportdata_act['tqty'])*100),2);
}
else
{
echo "0.0";
} ?></td>
</tr>
<?php }?>
<?php
}
}
?>
<tr align="right" id="grand_total">
<td style="text-align:right;" colspan="5"><strong><?php echo  "Grand Total:"; ?></strong></td>
<?php /*?><td style="text-align:center;"><?php echo number_format ($grand_total,2); ?></td>
<td style="text-align:right;">&nbsp;</td>
<td style="text-align:right;">&nbsp;</td><?php */?>
<td style="text-align:right;"><?php  
echo number_format ($grand_total,2); ?></td>
<td style="text-align:center;">&nbsp;</td>
<td style="text-align:right;"><?php  echo number_format (($this_month_act_total),2) ; ?></td>
<td style="text-align:center;">&nbsp;</td>
<td style="text-align:right;"><?php  echo  number_format ($last_month_act_total,2) ; ?></td>
<td style="text-align:center;">&nbsp;</td>   
<td style="text-align:right;"><?php  echo  number_format ($total_month_total,2) ; ?></td>
<td style="text-align:right;"><?php  if($total_month_total!=0&&$grand_total!=0)
{
echo number_format((($total_month_total/$grand_total)*100),2);
}
else
{
echo "0.0";
} ?></td>
</tr>
</table>
		</div>	
		
</div>
<?php 
 $physical_contigency=$ph_vo_grand_total_todate/$reportdata['amount']*100;
}?>
<?php if($physical_contigency!=0)
{
$actual_progress=$physical_contigency;
echo  number_format (($actual_progress),2); 
$physical_contigency=0;
}
else
{
echo  number_format ($actual_progress,2); 

}?></td>
<td style="text-align:right;"> <?php
									if($reportdata['sid']==3|| $reportdata['sid']==4)
									{
									 if($physical_contigency!=0)          /////////////////for physical contigency////
									{
									if($reportdata['sid']==4)
									{
									$CWeightData=getComponentWeight1(3,$reportdata['cid']);
									}
									
									$weighted_progress=($CWeightData['c_weight']/100)*($weight)*($physical_contigency/100);
									
									echo number_format ($weighted_progress,2);
									$grand_total_weighted_progress+=$weighted_progress;
									$total_weighted_progress+=$weighted_progress;
									$pre_total_weighted_progress=$total_weighted_progress;
									}
									else
									{
									if($reportdata['sid']==4)
									{
									$CWeightData=getComponentWeight1(3,$reportdata['cid']);
									}
									
									$weighted_progress=($CWeightData['c_weight']/100)*($weight)*($actual_progress/100);
									
									echo number_format ($weighted_progress,2);
									$grand_total_weighted_progress+=$weighted_progress;
									$total_weighted_progress+=$weighted_progress;
									$pre_total_weighted_progress=$total_weighted_progress;
									}                         ///////////////////for remaining items
									}
									else
									{
                                     
									$weighted_progress=$CWeightData['c_weight']*($activity_weight/100)*($actual_progress/100);
									
									echo number_format ($weighted_progress,2);
									//$grand_total_weighted_progress+=$weighted_progress;
									$total_weighted_progress+=$weighted_progress;
									$pre_total_weighted_progress=$total_weighted_progress;
									}?></td>
</tr>

<?php
$prev=$reportdata['s_id'];
$prev1=$reportdata['sid'];
}
?>
<tr align="right" id="sub_title">
<td align="left">&nbsp;</td>

<td colspan="2" align="right">
<strong><?php echo  $StructureName;?> &nbsp;Sub Total:</strong></td>
<td align="right"><strong><?php 
$size=0;
$sql="SELECT * FROM subcomponents where cid=".$componentid." AND (sid=3 OR sid=4) ";
 $result = mysql_query($sql);
 $size= mysql_num_rows($result);
 if($size==0)
 {
 if($componentid==13)
 {
 $WeightSumData=getWeightSum($componentid,6);
 $ComponentWeightSum=$WeightSumData["component_weighted_sum"];
 echo number_format($ComponentWeightSum,2);
 }
 else
 {
 $WeightSumData=getWeightSum($componentid,1);
 $ComponentWeightSum=$WeightSumData["component_weighted_sum"];
 echo number_format($ComponentWeightSum,2);
 }
 }
 else
 {
$WeightSumData=getWeightSum($componentid,3);
$ComponentWeightSum=$WeightSumData["component_weighted_sum"];
echo number_format($totalweight*$ComponentWeightSum/100,2);
}
 ?></strong></td>
<?php /*?><!--<td align="right"><?php echo number_format($ComponentWeightSum,2);?></td>--><?php */?>
<td align="right">
<?php /*?><?php $sub_total_actual_progress=($total_weighted_progress/$totalweight*100);
echo  number_format($sub_total_actual_progress,2);
?><?php */?>
<?php
$CWeightData=getComponentWeight1(3,$componentid); 
//echo number_format (($weightedp/$CWeightData['c_weight']*100),2); ?></td>
<td align="right">
<strong><?php echo  number_format($total_weighted_progress,2);
?></strong></td>
</tr>
<tr align="right" id="sub_title">
<td align="left">&nbsp;</td>

<td colspan="2" align="right">
<strong><?php echo  $StructureName;?> &nbsp;Total:</strong></td>
<td align="right"><strong><?php 
$size=0;
$sql="SELECT * FROM subcomponents where cid=".$componentid." AND (sid=3 OR sid=4) ";
 $result = mysql_query($sql);
 $size= mysql_num_rows($result);
 if($size==0)
 {
 if($componentid==13)
 {
 $WeightSumData=getWeightSum($componentid,6);
 $ComponentWeightSum=$WeightSumData["component_weighted_sum"];
 echo number_format($ComponentWeightSum,2);
 }
 else
 {
 $WeightSumData=getWeightSum($componentid,1);
 $ComponentWeightSum=$WeightSumData["component_weighted_sum"];
 echo number_format($ComponentWeightSum,2);
 }
 }
 else
 {
$WeightSumData1=getWeightSum($componentid,3);
$WeightSumData2=getWeightSum($componentid,2);
$ComponentWeightSum1=$WeightSumData1["component_weighted_sum"];
$w1=$totalweight*$ComponentWeightSum1/100;
echo number_format($w1+$WeightSumData2["component_weighted_sum"],2);
}
 ?></strong></td>
<?php /*?><!--<td align="right"><?php echo number_format($ComponentWeightSum,2);?></td>--><?php */?>
<td align="right">
<?php /*?><?php $sub_total_actual_progress=($total_weighted_progress/$totalweight*100);
echo  number_format($sub_total_actual_progress,2);
?><?php */?>
<?php
$CWeightData=getComponentWeight1(3,$componentid); 
//echo number_format (($weightedp/$CWeightData['c_weight']*100),2); ?></td>
<td align="right">
<strong><?php echo  number_format($total_weighted_progress+$mob_weighted_progress,2);
?></strong></td>
</tr>
<tr align="right" id="grand_total">
<td colspan="3" align="right">
<strong>Grand Total:</strong></td>
<td align="right"><strong><?php 
$WeightSumDataTotal=getWeightSumTotal($componentid);
$ComponentWeightSumTotal=$WeightSumDataTotal["component_weighted_sum"];
echo number_format($ComponentWeightSumTotal,2);?></strong></td>
<?php /*?><!--<td align="right"><?php echo number_format($grand_total,2);?></td>--><?php */?>
<td align="right">
<?php //echo  number_format(($total_progress/$grand_total*100),2);?></td>
<td align="right">
<strong><?php $size=0;
$sql="SELECT * FROM subcomponents where cid=".$componentid." AND (sid=3 OR sid=4) ";
 $result = mysql_query($sql);
 $size= mysql_num_rows($result);
 if($size==0)
 {
 echo  number_format($total_weighted_progress,2);
 }
 else
 {
 echo  number_format($grand_total_weighted_progress,2);
 }?>
 </strong>
 </td>
</tr>

</table>
<?php
}
?>
</div>


<!-- Start Avtivity Type  Table here-->

<div id="result4">
<?php
if ($activitytypeflag == 1 && $subcomponentid == 0 ) {
$query="SELECT * FROM subcomponents where (sid=3 OR sid=4) and cid=".$componentid;
$queryresult = mysql_query($query);
$numrows=mysql_num_rows($queryresult);
if($numrows>0)
{
function getComponentName($cid)
{
$sql="SELECT detail as c_name FROM  `components` where cid=".$cid;
$amountresult = mysql_query($sql);
//echo $amountsize= mysql_num_rows($amountresult);
$data=mysql_fetch_array($amountresult);
return $data;
}
function ProgressDate()
{
$sql="SELECT  MAX(bdate) as lastdate FROM  `progressmonth` ";
$amountresult = mysql_query($sql);
//echo $amountsize= mysql_num_rows($amountresult);
$data=mysql_fetch_array($amountresult);
return $data;
}
function LastMonthProgressDate()
{
$sql="SELECT  MAX(bdate) as lastMonthdate,bid FROM  `progressmonth`  Group by bid order by bid DESC";
$amountresult = mysql_query($sql);
//echo $amountsize= mysql_num_rows($amountresult);
$data=mysql_fetch_array($amountresult);
return $data;
}
$com_name=getComponentName($componentid);
$last_date=ProgressDate();
$time=0;
$time_elapsed_percent=0;
$time = strtotime($last_date["lastdate"]);
$Date = date( 'd-m-Y', $time );
$last_month_data=LastMonthProgressDate();
$this_month_bid=$last_month_data["bid"];
$last_month_date=$last_month_data["lastMonthdate"];
?>
<form id="component_progress" name="component_progress" action="gph3.php" target="_blank" method="post">
<table id="tblList" cellpadding="0px" cellspacing="0px"   width="181%" align="center">
<tr align="center" id="title">
    <td colspan="30"><span class="white"><strong>Progress Report For&nbsp;<?php echo $com_name["c_name"]." As On ".$Date;?></strong></span><span style="position:absolute; padding-left:550px"><a style="text-decoration:none;color:#ffffff" href="javascript:void(null);" onclick="window.open('print_project_management.php?componentid=<?php echo $componentid;?>&projectid=<?php echo $projectid;?>', 'INV', 'width=1520,height=550,scrollbars=yes');" ><img src="images/ico_print.gif" border="0" /></a></span><input type="submit" id="com_prog_submit" name="com_prog_submit" value="View Graph" /><a style="text-decoration:none;color:#ffffff" href="javascript:void(null);" onclick="window.open('print_act_exceed.php?componentid=<?php echo $componentid;?>&projectid=<?php echo $projectid;?>', 'INV', 'width=1520,height=550,scrollbars=yes');" >Exceed Report</a></td>
</tr>
<tr id="tblHeading" align="center">
  <td width="39" rowspan="4" style="background-image:url(images/table_headingBG3.png)"> Bill No. </td>
  <td width="349" rowspan="4" style="background-image:url(images/table_headingBG3.png)">Activities</td>
  <td width="57" rowspan="4" style="background-image:url(images/table_headingBG3.png)">Weight</td>
  <td width="76" rowspan="4" style="background-image:url(images/table_headingBG3.png)"> Accepted Contract Amount </td>
  <td rowspan="3" valign="top" style="background-image:url(images/table_headingBG3.png)">Start Date </td>
  <td width="93" rowspan="4" style="background-image:url(images/table_headingBG3.png)"> Scheduled Date of Completion </td>
  <td width="86" rowspan="4" style="background-image:url(images/table_headingBG3.png)">Scheduled No of Days to Complete </td>
  <td width="86" rowspan="4" style="background-image:url(images/table_headingBG3.png)">Days Elapsed from Scheduled Start to Date of </td>
  <td width="86" rowspan="4" style="background-image:url(images/table_headingBG3.png)">% Time Elpsed from Scheduled Start to Date of </td>
  <td colspan="7" style="background-image:url(images/table_headingBG3.png)">Physical Progress </td>
  <td colspan="9" style="background-image:url(images/table_headingBG3.png)">Cost Performance </td>
  </tr>
<tr id="tblHeading" align="center">
  <td colspan="7">&nbsp;</td>
  <td colspan="4" style="background-image:url(images/table_headingBG3.png)">Variation Order</td>
  <td colspan="3" style="background-image:url(images/table_headingBG3.png)">Actual Cost </td>
  <td width="103" rowspan="3" style="background-image:url(images/table_headingBG3.png)">Cost Performance Index </td>
  <td width="99" rowspan="3" style="background-image:url(images/table_headingBG3.png)">Up to Date % Progress</td>
</tr>
<tr id="tblHeading" align="center" >
    <td colspan="3"  align="center">Planned Value, in Rupees</td>
    <td colspan="3"  align="center">Earned Value, in Rupees</td>
    <td width="61" rowspan="2"  align="center">SPI</td>
    <td width="51" rowspan="2"  align="center">Up to Last Month</td>
    <td width="59" rowspan="2"  align="center">During The month</td>
    <td width="107" rowspan="2"  align="center">Up To Date</td>
    <td width="100" rowspan="2"  align="center">% To Accepted Contract Cost</td>
    <td width="107" rowspan="2"  align="center">Up to Last Month</td>
    <td width="107" rowspan="2"  align="center">During The Month </td>
    <td width="107" rowspan="2"  align="center" >Up To Date</td>
  </tr>
<tr id="tblHeading" style="font-size:10px">
  <td width="86"  align="center">Scheduled </td>
  <td width="55"  align="center">Up to Last Month </td>
  <td width="59"  align="center">During The Month </td>
  <td width="107"  align="center">Up To Date </td>
  <td width="51"  align="center">Up to Last Month</td>
  <td width="59"  align="center">During The Month</td>
  <td width="107"  align="center">Up To Date </td>
  </tr>
<tr id="tblHeading" align="center" >
  <td>1</td>
  <td>2</td>
  <td>3</td>
  <td>4</td>
  <td>5</td>
  <td>6</td>
  <td>7</td>
  <td>8</td>
  <td>9</td>
  <td>10</td>
  <td>11</td>
  <td>12</td>
  <td>13</td>
  <td>14</td>
  <td>15</td>
  <td>16</td>
  <td>17</td>
  <td>18</td>
  <td>19</td>
  <td>20</td>
  <td>21</td>
  <td>22</td>
  <td>23</td>
  <td>24</td>
  <td>25</td>
</tr>
<tr id="tblHeading" align="center" >
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>Date of Report less Col.4+1 </td>
  <td>Col.8/ Col.7*100</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>Col.10+Col.11</td>
  <td>13</td>
  <td>14</td>
  <td>Col.13+Col.14</td>
  <td>Col.15/ Col.12</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>Col.17+Col.18</td>
  <td>Col.19/Total of Col.4*100</td>
  <td>Col.13+Col.17</td>
  <td>Col.14+Col.18</td>
  <td>Col.21+Col.22</td>
  <td>Col.15/Col.23</td>
  <td>Col.15/Col.4
  *100</td>
  </tr>
<?php

function getSubComponentProgressAmount($cid,$sid,$sa_id,$s_id)
{
 $sql2="SELECT sa_id,sum( pamount) AS tamount, max( bdate ) AS lastdate
FROM `progress` 
WHERE sa_id =".$sa_id." AND cid=".$cid." AND sid=".$sid." AND s_id=".$s_id." GROUP BY sa_id";
$pamountresult2 = mysql_query($sql2)or die(mysql_error());
$pdata=mysql_fetch_array($pamountresult2);
return $pdata;
}
function getLastMonthProgress($aid)
{
 $thismonth=date('Ym');
 $sql2="SELECT  ca.cid,cc.lqty, sum( cc.lqty*ca.rates) as lastamount
FROM subactivitydata ca
LEFT OUTER join (lastmonthdata cc) on (ca.sa_id = cc.sa_id) where ca.aid=".$aid." GROUP BY ca.aid";
$pamountresultp = mysql_query($sql2)or die(mysql_error());
$pgdata=mysql_fetch_array($pamountresultp);
return $pgdata;
}
function getVariationData($aid)
{ 
$sql2="SELECT sum(vd.vqty) As tvqty, sum(vd.vrate*cc.quantity) as variation_in_rate_amount, sum(vd.vqty*dd.prs) as variation_in_qty_amount,sum(vd.`vamount`) as variation_in_amount,vd.`vo_id`,vd.`contigency_code`,vd.`vono`,vd.`vodate`,vd.`bid`,vd.`remark`,vd.`vstatus`,vd.`bdate`
FROM variationdata vd
LEFT OUTER JOIN (subactivitydata cc) on (vd.sa_id = cc.sa_id) 
LEFT OUTER JOIN (progressdata dd) on (vd.sa_id = dd.sa_id) where cc.aid=".$aid." GROUP BY cc.aid";
$pamountresultp = mysql_query($sql2)or die(mysql_error());
$pgdata=mysql_fetch_array($pamountresultp);
return $pgdata;
}
function getSubActivityVariationData($sa_id)
{ 
$sql2="SELECT sum(vd.vqty) As tvqty, sum(vd.vrate*cc.quantity) as variation_in_rate_amount, sum(vd.vqty*dd.prs) as variation_in_qty_amount,sum(vd.`vamount`) as variation_in_amount,vd.`vo_id`,vd.`contigency_code`,vd.`vono`,vd.`vodate`,vd.`bid`,vd.`remark`,vd.`vstatus`,vd.`bdate`
FROM variationdata vd
LEFT OUTER JOIN (subactivitydata cc) on (vd.sa_id = cc.sa_id)
LEFT OUTER JOIN (progressdata dd) on (vd.sa_id = dd.sa_id) where cc.sa_id=".$sa_id." GROUP BY cc.sa_id";
$pamountresultp = mysql_query($sql2)or die(mysql_error());
$pgdata=mysql_fetch_array($pamountresultp);
return $pgdata;
}
function getThisMonthVariationData($aid,$bid)
{ 
 $sql2="SELECT sum(vd.vqty) As tvqty, sum(vd.vrate*cc.quantity) as variation_in_rate_amount, sum(vd.vqty*dd.prs) as variation_in_qty_amount,sum(vd.`vamount`) as variation_in_amount,vd.`vo_id`,vd.`contigency_code`,vd.`vono`,vd.`vodate`,vd.`bid`,vd.`remark`,vd.`vstatus`,vd.`bdate`
FROM variationdata vd
LEFT OUTER JOIN (subactivitydata cc) on (vd.sa_id = cc.sa_id)
LEFT OUTER JOIN (progressdata dd) on (vd.sa_id = dd.sa_id) where cc.aid=".$aid." AND vd.bid=".$bid." GROUP BY cc.aid";
$pamountresultp = mysql_query($sql2)or die(mysql_error());
$pgdata=mysql_fetch_array($pamountresultp);
return $pgdata;
}
function getThisMonthSubactivityVariationData($sa_id,$bid)
{ 
 $sql2="SELECT sum(vd.vqty) As lvqty, sum(vd.vrate*cc.quantity) as last_variation_in_rate_amount, sum(vd.vqty*dd.prs) as last_variation_in_qty_amount,sum(vd.`vamount`) as last_variation_in_amount,vd.`vo_id`,vd.`contigency_code`,vd.`vono`,vd.`vodate`,vd.`bid`,vd.`remark`,vd.`vstatus`,vd.`bdate`
FROM variationdata vd
LEFT OUTER JOIN (subactivitydata cc) on (vd.sa_id = cc.sa_id)
LEFT OUTER JOIN (progressdata dd) on (vd.sa_id = dd.sa_id) where cc.sa_id=".$sa_id." AND vd.bid=".$bid." GROUP BY cc.sa_id";
$pamountresultp = mysql_query($sql2)or die(mysql_error());
$pgdata=mysql_fetch_array($pamountresultp);
return $pgdata;
}
function getCode($aid)
{
 $sql="SELECT code FROM  `activity` where aid=".$aid;
 
$amountresult = mysql_query($sql);
//echo $amountsize= mysql_num_rows($amountresult);
$data=mysql_fetch_array($amountresult);

return $data;
}
function getLastDate($sa_id)
{
 $sql="SELECT lbdate as lastdate FROM  `progressdata` where sa_id=".$sa_id;
 
$amountresult = mysql_query($sql);
//echo $amountsize= mysql_num_rows($amountresult);
$data=mysql_fetch_array($amountresult);

return $data;
}
function getActivityProgressAmount($cid,$sid,$sa_id,$s_id,$aid)
{
 
$sql2="SELECT sa_id,sum( pqty * prs ) AS tamount, max( bdate ) AS lastdate
FROM `progress` 
WHERE sa_id =".$sa_id." AND cid=".$cid." AND sid=".$sid." AND s_id=".$s_id." AND aid=".$aid." GROUP BY sa_id";
$pamountresult3 = mysql_query($sql2)or die(mysql_error());
$pdata=mysql_fetch_array($pamountresult3);
return $pdata;
}
function getCode_new($sa_id)
{
 $sql="SELECT code FROM  `subactivity` where sa_id=".$sa_id;
 
$amountresult = mysql_query($sql);
//echo $amountsize= mysql_num_rows($amountresult);
$data=mysql_fetch_array($amountresult);

return $data;
}
$ph_contigency_total=0;
$ph_contigency_lastmonth=0;
$ph_contigency_thismonth=0;
$grand_total=0;
$grand_total_final=0;
$total_progress=0;
$total_current_month_progress=0;
$total_upto_last_month_progress=0;
$total_noofdays=0;
$total_timeElps=0;
$total_planned_progress=0;
$to_date_progress=0;
$contigency=$subcomponentid+1;
$weight=0;
$totalweight=0;
$days_of_current_month=0;
$current_month_planned_progress=0;
$total_current_month_planned_progress=0;
$vo_lastmonth=0;
$vo_currentmonth=0;
$vo_todate=0;
$vo_total_lastmonth=0;
$vo_total_currentmonth=0;
$vo_total_todate=0;
$vo_grand_total_todate=0;
$orignal_contract_cost=0;
$percent_progress=0;
$actual_total=0;
$adjusted_cost=0;
$actual_uptolast=0;
$actual_current=0;
$CPI=0;
$total_uptolast_planned_progress=0;
$total_current_month_planned_progress=0;
$total_actual_uptolast=0;
$total_actual_current=0;
$grand_actual_total=0;
$total_adjusted_cost=0;
$mindate=0;
$maxdate=0;
$timeElps =0;
$bgcolor=0;
$during_this_month_progress=0;
/*$reportquery ="SELECT  ca.cid,cc.lqty, sum( cc.lqty*ca.rates) as lastamount,ca.activityname,ca.aid,ca.s_id,ca.sa_id,ca.sid,ca.startdate, min(ca.startdate) as mindate, ca.enddate, max(ca.enddate) as maxdate,  ca.quantity, ca.rates, cb.pqty, sum(ca.quantity*ca.rates) as amount, sum(cb.pamount)As totalamount,cb.pamount, cb.lbdate as lastdate FROM subactivitydata ca 
inner join (progressdata cb inner join lastmonthdata cc)
on (ca.sa_id = cb.sa_id and cb.sa_id = cc.sa_id) Where ca.sid=".$activitytypeid."  AND ca.s_id=".$subcomponentid." OR ca.s_id=".$contigency." GROUP BY ca.aid";
*/
$query="SELECT * FROM subcomponents where (sid=3 OR sid=4) and cid=".$componentid;
$queryresult = mysql_query($query);
$numrows=mysql_num_rows($queryresult);
if($numrows>0)
{
$reportquery ="SELECT ca.cid,ca.activityname,ca.aid,ca.s_id,ca.sa_id,ca.sid,ca.startdate, min(ca.startdate) as mindate, ca.enddate, max(ca.enddate) as maxdate, ca.quantity, ca.rates, cb.pqty, sum(ca.quantity*ca.rates) as amount, sum(cb.pamount)As totalamount,cb.pamount, cb.lbdate as lastdate FROM subactivitydata ca 
 LEFT OUTER join (progressdata cb) on (ca.sa_id=cb.sa_id)
 where ca.cid=".$componentid." and (ca.sid=3 or ca.sid =4)  GROUP BY ca.aid ORDER by ca.a_order,ca.s_id";
}
else
{
$reportquery ="SELECT ca.cid,ca.activityname,ca.aid,ca.s_id,ca.sa_id,ca.sid,ca.startdate, min(ca.startdate) as mindate, ca.enddate, max(ca.enddate) as maxdate, ca.quantity, ca.rates, cb.pqty, sum(ca.quantity*ca.rates) as amount, sum(cb.pamount)As totalamount,cb.pamount, cb.lbdate as lastdate FROM subactivitydata ca LEFT OUTER join (progressdata cb) on (ca.sa_id = cb.sa_id ) where ca.cid=".$componentid." and (ca.sid=1)  GROUP BY ca.aid";
}

$reportresult = mysql_query($reportquery);
if($numrows>0)
{
$totalresultquery="SELECT sum(`quantity`* `rates` ) grand_total FROM subactivitydata WHERE cid =".$componentid." AND (sid =3 OR sid =4) GROUP BY cid";
}
else
{
$totalresultquery="SELECT sum(`quantity`* `rates` ) grand_total FROM subactivitydata WHERE cid =".$componentid." AND (sid=1) GROUP BY cid";

}
$totalresult=mysql_query($totalresultquery);
 $all_total_data=mysql_fetch_array($totalresult);
 $all_total=$all_total_data["grand_total"];
$i=0;
$var_s_id=0;
$var_a_id=0;
$var_sid=0;
while ($reportdata = mysql_fetch_array($reportresult)) {
  $bgcolor = ($bgcolor == "#FFFFFF") ? "#EAF4FF" : "#FFFFFF";
$mindate=$reportdata["mindate"];
$maxdate=$reportdata["maxdate"];
/*$codeData=getCode($reportdata['sa_id']);*/
$grand_total_final+=$reportdata['amount'];
$codeData=getCode($reportdata['aid']);
//$SubComponentData=getSubComponentProgressAmount($componentid,$reportdata['sid'],$reportdata['sa_id'],$reportdata['s_id']); /////SubComponentProgressAmount
$last_month_progress=getLastMonthProgress($reportdata['aid']);
$current_month_progress=$last_month_progress['lastamount'];

$variation_data=getVariationData($reportdata['aid']);
$this_variation_data=getThisMonthVariationData($reportdata['aid'],$this_month_bid);///during this month
 $vo_thismonth=$this_variation_data["variation_in_qty_amount"]+$this_variation_data["variation_in_rate_amount"];
$vo_total_thismonth+=$this_variation_data["variation_in_qty_amount"]+$this_variation_data["variation_in_rate_amount"];
/*$vo_total_lastmonth+=$this_variation_data["variation_in_qty_amount"]+$this_variation_data["variation_in_rate_amount"];*/
$vo_total_todate=$variation_data["variation_in_qty_amount"]+$variation_data["variation_in_rate_amount"];
$vo_uptolast=$vo_total_todate-$vo_thismonth;
$vo_total_uptolast+=$vo_uptolast;
$vo_grand_total_todate+=$vo_total_todate;
?>
<?php
$aenddate = strtotime(substr($reportdata['enddate'],0,4)."-".substr($reportdata['enddate'],4,2)."-".substr($reportdata['enddate'],6,2));
$astartdate = strtotime(substr($reportdata['startdate'],0,4)."-".substr($reportdata['startdate'],4,2)."-".substr($reportdata['startdate'],6,2));
$datediff = $aenddate - $astartdate;
$noofdays = round(($aenddate - $astartdate) / 86400,0); 
$noofdays=trim(str_replace(",","",$noofdays));
$noofdays+=1;

$total_noofdays+=$noofdays;
?>

<?php
$aenddate = strtotime(substr($reportdata['startdate'],0,4)."-".substr($reportdata['startdate'],4,2)."-".substr($reportdata['startdate'],6,2));
if($last_month_date!=""&&$last_month_date!=NULL)
{
$tlbdate = strtotime($last_month_date);
$datediff = $tlbdate-$aenddate ;
$timeElps = round(($tlbdate-$aenddate) / 86400,0); 
$timeElps+=1;
if($timeElps<0)
{
$timeElps=0;
}

}
else
{
$timeElps=0;
}
$total_timeElps+=$timeElps;
$i++;
	 if($reportdata['sid']!='4')
	 {
	if($timeElps>$noofdays)
	{
	$timeElps=$noofdays;
	$planned_progress=($reportdata['amount']/$noofdays) * $timeElps;
	}
	elseif($timeElps>0&&$noofdays>0)
	{
	$planned_progress=($reportdata['amount']/$noofdays) * $timeElps;
	}
	elseif($timeElps==0)
	{
	$planned_progress=0;
	}

	else
	{
		$planned_progress=0;
	}
	
	if($planned_progress!=0&&$last_month_date!=""&&$last_month_date!=NULL)
	{
	 $cmonth=substr($last_month_date,4,2);
	 $cyear=substr($last_month_date,6,2);
	$days_of_current_month=cal_days_in_month(CAL_GREGORIAN, $cmonth, $cyear);
	}
	else
	{
	$days_of_current_month=0;
	}
	 if($days_of_current_month>0&&$noofdays>0)
	 {
	 $current_month_planned_progress=($reportdata['amount']/$noofdays)*$days_of_current_month;
	 }
	 elseif($days_of_current_month==0)
	 {
	  $current_month_planned_progress=0;
	 }
	 
	 }
	 else
	 {   
     $planned_progress=0;
	 $current_month_planned_progress=0;
	 }
	 $total_planned_progress+=$planned_progress;
	 $total_current_month_planned_progress+= $current_month_planned_progress;
 $during_this_month_progress=$last_month_progress['lastamount'];
 $upto_last_month_progress=$reportdata['totalamount']-$last_month_progress['lastamount'];
 $to_date_progress=$last_month_progress['lastamount']+$upto_last_month_progress;
$time_elapsed_percent=$timeElps/$noofdays*100;
?>
<?php if($vo_total_todate>0)
$bgcolor="#FFFF00";
?>
<?php if($reportdata['sid']!='4')
{?>
<input type="hidden" id="projectid" name="projectid" value="<?php echo  $projectid; ?>"/>
<input type="hidden" id="componentid" name="componentid" value="<?php echo $componentid; ?>"/>
<input type="hidden" id="bill_code[]" name="bill_code[]" value="<?php echo $codeData['code']; ?>"/>
<input type="hidden" id="bill_detail[]" name="bill_detail[]" value="<?php echo $reportdata['activityname']; ?>"/>
<input type="hidden" id="bill_actual_progress[]" name="bill_actual_progress[]" value="
<?php if($to_date_progress!=0 && $reportdata['amount']!=0)
{
	echo $bill_actual_progress=($to_date_progress/$reportdata['amount']*100);
}
else
{
echo "0.0";
}?>"/>
<input type="hidden" id="plan[]" name="plan[]" value="<?php if($planned_progress!=0 && $reportdata['amount']!=0)
		{ 
		echo $bill_planned_progress=($planned_progress/$reportdata['amount']*100);
		}
		else
		{
			echo "0.0";
		}?>"/>
        <input type="hidden" id="time_eplapsed_p[]" name="time_eplapsed_p[]" value="<?php echo $time_elapsed_percent;?>"  />
<?php }?>
<tr style="background-color:<?php echo $bgcolor;?>;">
<td style="text-align:center;"><?php echo $codeData['code']; ?></td>
<td style="text-align:left;"><?php echo $reportdata['activityname']; ?>
<?php if($vo_total_todate>0) {
$var_s_id=$reportdata['s_id'];
$var_a_id=$reportdata['aid'];
$var_sid=$reportdata['sid'];?><div class="msg_list">
		<p class="msg_head">View Subactivities <span> <a style="text-decoration:none;color:#ffffff" href="javascript:void(null);" onclick="window.open('print_variation_subactivity_level_report.php?subcomponentid=<?php echo $reportdata['s_id'];?>&amp;projectid=<?php echo $projectid;?>&amp;activitytypeid=<?php echo $reportdata['sid'];?>&amp;componentid=<?php echo $reportdata['cid'];?>&amp;activityid=<?php echo $reportdata['aid'];?>&amp;subactivityid=<?php echo $reportdata['sa_id'];?>','INV','width=1120,height=550,scrollbars=yes');" ><img src="images/popout.gif" border="0" title="pop out"/></a></span></p>
		<div class="msg_body">
<table id="tblList" cellpadding="0px" cellspacing="0px"   width="98%" align="center" >
<tr id="tblHeading">
<th rowspan="2"> Sr. No. </th>
<th rowspan="2">Description </th>
<th rowspan="2"> UOM </th>
<!--<th colspan="3">As Per Estimate</th>-->
<th colspan="3"> As Per Bid</th>
<th colspan="2">Paid Upoto Previous </th>
<th colspan="2">During This Month </th>
<th colspan="2">(Executed) Upto Date </th>
<th rowspan="2"> % in Progress</th>
</tr>
<tr id="tblHeading">
<!--<th>Qty. (Units) </th>
<th>Rate </th>
<th> Amount</th>-->
<th>Qty. (Units) </th>
<th>Rate (Rs.) </th>
<th>Amount (Rs.) </th>
<th> Qty. (Units)</th>
<th> Amount(Rs.)</th>
<th> Qty. (Units)</th>
<th> Amount(Rs.)</th>
<th> Qty. (Units)</th>
<th> Amount(Rs.)</th>
</tr>
<?php


$grand_total=0;
$total_month_total=0;
$grand_last_amount=0;
$last_month_act_total=0;
$this_month_act_total=0;
$reportquerynew ="SELECT  ca.cid,sum(cc.lqty) as lqty, sum(cc.lqty*ca.rates) as lastamount,ca.subactivityname,ca.aid,ca.s_id,ca.sa_id,ca.sid,ca.startdate,ca.units, min(ca.startdate) as mindate, ca.enddate, max(ca.enddate) as maxdate,  ca.quantity, ca.rates, cb.pqty, sum(cb.pqty) as tpqty,sum(ca.quantity*ca.rates) as amount, sum(ca.quantity) as tqty ,sum(cb.pamount)As totalamount,cb.pamount, cb.lbdate as lastdate , cb.prs FROM subactivitydata ca 
LEFT OUTER join (progressdata cb)
on (ca.sa_id = cb.sa_id )
LEFT OUTER join (lastmonthdata cc) 
on (cb.sa_id = cc.sa_id) Where ca.sid=".$reportdata['sid']." AND ca.s_id=".$reportdata['s_id']." AND ca.aid=".$reportdata['aid']." GROUP BY ca.sa_id";

/*$reportquerynew ="SELECT ca.subactivityname,ca.aid,ca.s_id,ca.sa_id,ca.sid,ca.startdate,ca.units, min(ca.startdate) as mindate, ca.enddate, max(ca.enddate) as maxdate,  ca.quantity, ca.rates,sum(ca.quantity*ca.rates) as amount, sum(ca.quantity) as tqty ,sum(vd.vqty) As tvqty, sum(vd.vrate*ca.quantity) as variation_in_rate_amount, sum(vd.vqty*ca.rates) as variation_in_qty_amount,sum(vd.`vamount`) as variation_in_amount,vd.`vo_id`,vd.`contigency_code`,vd.`vono`,vd.`vodate`,vd.`bid`,vd.`remark`,vd.`vstatus`,vd.`bdate`
FROM variationdata vd
LEFT OUTER JOIN (subactivitydata ca) on (vd.sa_id = ca.sa_id) where ca.aid=".$reportdata['aid']." GROUP BY ca.sa_id";*/
$reportresult_act = mysql_query($reportquerynew)or die(mysql_error());
while ($reportdata_act = mysql_fetch_array($reportresult_act)) {
 $bgcolor = ($bgcolor == "#FFFFFF") ? "#EAF4FF" : "#FFFFFF";
/*$bgcolor = ($bgcolor == "#FF9999") ? "#FFD5D5" : "#FF9999";*/

$variation_data_sub=getSubActivityVariationData($reportdata_act['sa_id']);
$variation_this_data_sub=getThisMonthSubactivityVariationData($reportdata_act['sa_id'],$this_month_bid);
$uptolast_variation=$variation_data_sub['tvqty']-$variation_this_data_sub['lvqty'];
$total_amount_act=$reportdata_act['amount'];
$this_amount=$reportdata_act['lastamount'];

$codeData_new=getCode_new($reportdata_act['sa_id']);
$total_qty=$variation_data_sub['tvqty']+$reportdata_act['tpqty'];
/*$last_progress_qty=$reportdata_act['tpqty']-$reportdata_act['lqty'];*/
$uptolast_progress_qty=$reportdata_act['tpqty']-$reportdata_act['lqty'];
$total_uptolast_qty=$uptolast_variation+$uptolast_progress_qty; //lqty is during this month qty
if($variation_data_sub['vrate']==0)
{
$this_month_act=(($reportdata_act['lqty'] + $variation_this_data_sub['lvqty']) * $reportdata_act['prs']);
}
else
{
$this_month_act=(($reportdata_act['lqty'] + $variation_this_data_sub['lvqty']) * $variation_data_sub['vrate']);
}

if($variation_last_data_sub['vrate']==0)
{
$uptolast_month_act=($total_uptolast_qty) * $reportdata_act['prs'];
}
else
{
$uptolast_month_act=($total_uptolast_qty) * $variation_this_data_sub['vrate'];
}

if($variation_data_sub['vrate']==0)
{
$total_month=($total_qty) * $reportdata_act['prs'];
}
else
{
$total_month=($total_qty) * $variation_data_sub['vrate'];
}
/*if($reportdata_act['sa_id']=='6439')
{   echo $last_month_bid;
    echo "</br>";
	echo $total_last_qty;
	 echo "</br>";
	echo $variation_data_sub['tvqty'];
}*/
?>
<?php if($variation_data_sub['tvqty']>0)
{
$grand_total+=$total_amount_act;
$total_month_total+=$total_month;
$last_month_act_total+=$uptolast_month_act;
$this_month_act_total+=$this_month_act;?>
<tr style="background-color:<?php echo $bgcolor;?>;">
<td style="text-align:center;"><?php echo  $codeData_new['code']; ?></td>
<td style="text-align:left;"><?php   echo $reportdata_act['subactivityname']; ?></td>
<td style="text-align:center;"><?php echo $reportdata_act['units']; ?></td>
<?php /*?><td style="text-align:center;"><?php echo number_format($reportdata['quantity'],2); ?></td>
<td style="text-align:right;"><?php  echo number_format($reportdata['rates'],2); ?></td>
<td style="text-align:right;"><?php  echo number_format (($reportdata['quantity'] * $reportdata['rates']),2) ; ?></td><?php */?>
<td style="text-align:center;"><?php echo number_format($reportdata_act['tqty'],2); ?></td>
<td style="text-align:right;"><?php  echo number_format($reportdata_act['rates'],2); ?></td>
<td style="text-align:right;"><?php  echo number_format (($reportdata_act['tqty'] * $reportdata_act['rates']),2) ; ?></td>
<td style="text-align:center;"><?php echo number_format ($total_uptolast_qty,2); ?></td>
<td style="text-align:right;"><?php  echo number_format (($uptolast_month_act),2) ; ?></td>
<td style="text-align:center;"><?php echo number_format ($total_qty - $total_uptolast_qty,2); ?></td>
<td style="text-align:right;"><?php  echo number_format($this_month_act,2) ; ?></td>
<td style="text-align:center;"><?php echo number_format ($total_qty,2); ?></td>   
<td style="text-align:right;"><?php  echo number_format (($total_month),2) ; ?></td>
<td style="text-align:right;"><?php  if($reportdata_act['tpqty']!=0 && $reportdata_act['tqty']!=0)
{
echo number_format((($total_qty / $reportdata_act['tqty'])*100),2);
}
else
{
echo "0.0";
} ?></td>
</tr>
<?php }?>
<?php
}
?>
<tr align="right" id="grand_total">
<td style="text-align:right;" colspan="5"><strong><?php echo  "Grand Total:"; ?></strong></td>
<?php /*?><td style="text-align:center;"><?php echo number_format ($grand_total,2); ?></td>
<td style="text-align:right;">&nbsp;</td>
<td style="text-align:right;">&nbsp;</td><?php */?>
<td style="text-align:right;"><?php  
echo number_format ($grand_total,2); ?></td>
<td style="text-align:center;">&nbsp;</td>
<td style="text-align:right;"><?php  echo number_format (($last_month_act_total),2) ; ?></td>
<td style="text-align:center;">&nbsp;</td>
<td style="text-align:right;"><?php  echo  number_format ($this_month_act_total,2) ; ?></td>
<td style="text-align:center;">&nbsp;</td>   
<td style="text-align:right;"><?php  echo  number_format ($total_month_total,2) ; ?></td>
<td style="text-align:right;"><?php  if($total_month_total!=0&&$grand_total!=0)
{
echo number_format((($total_month_total/$grand_total)*100),2);
}
else
{
echo "0.0";
} ?></td>
</tr>
</table>
		</div>	
		
</div>
<?php }?>
<?php if($codeData['code']=='F' ) {
?>
<!--<tr >
<td colspan="15">
-->

<div class="msg_list">
		<p class="msg_head" style="background-color:#00CC66">View Subactivities <span> <a style="text-decoration:none;color:#ffffff" href="javascript:void(null);" onclick="window.open('print_variation__physical_cont_subactivity_level_report_classification.php?subcomponentid=<?php echo $var_s_id;?>&amp;projectid=<?php echo $projectid;?>&amp;activitytypeid=<?php echo $var_sid;?>&amp;componentid=<?php echo $reportdata['cid'];?>&amp;activityid=<?php echo $var_a_id;?>&amp;subactivityid=<?php echo $reportdata['sa_id'];?>&last_aid=<?php echo $reportdata['aid'];?>','INV','width=1120,height=550,scrollbars=yes');" ><img src="images/popout.gif" border="0" title="pop out"/></a>
        <a style="text-decoration:none;color:#ffffff" href="javascript:void(null);" onclick="window.open('print_variation__physical_cont_subactivity_level_report_summary.php?subcomponentid=<?php echo $var_s_id;?>&amp;projectid=<?php echo $projectid;?>&amp;activitytypeid=<?php echo $var_sid;?>&amp;componentid=<?php echo $reportdata['cid'];?>&amp;activityid=<?php echo $var_a_id;?>&amp;subactivityid=<?php echo $reportdata['sa_id'];?>&last_aid=<?php echo $reportdata['aid'];?>','INV','width=1120,height=550,scrollbars=yes');" >summary</a></span></p>
		<div class="msg_body">
			<table id="tblList" cellpadding="0px" cellspacing="0px"   width="98%" align="center" >

<tr id="tblHeading">
<th rowspan="2"> Sr. No. </th>
<th rowspan="2">Description </th>
<th rowspan="2"> UOM </th>
<!--<th colspan="3">As Per Estimate</th>-->
<th colspan="3"> As Per Bid</th>
<th colspan="2">Paid Upoto Previous </th>
<th colspan="2">During This Month </th>
<th colspan="2">(Executed) Upto Date </th>
<th rowspan="2"> % in Progress</th>
</tr>
<tr id="tblHeading">
<!--<th>Qty. (Units) </th>
<th>Rate </th>
<th> Amount</th>-->
<th>Qty. (Units) </th>
<th>Rate (Rs.) </th>
<th>Amount (Rs.) </th>
<th> Qty. (Units)</th>
<th> Amount(Rs.)</th>
<th> Qty. (Units)</th>
<th> Amount(Rs.)</th>
<th> Qty. (Units)</th>
<th> Amount(Rs.)</th>
</tr>
<?php
$grand_total=0;
$total_month_total=0;
$grand_last_amount=0;
$last_month_act_total=0;
$this_month_act_total=0;
$ph_grand_total=0;
$ph_total_month_total=0;
$ph_last_month_act_total=0;
$ph_this_month_act_total=0;
$ph_vo_total_todate=0;
$ph_vo_grand_total_todate=0;
$ph_vo_lastmonth=0;
$ph_vo_grand_lastmonth=0;
$ph_vo_currentmonth=0;
$ph_vo_grand_currentmonth=0;
$query="SELECT * FROM variation_order where cid=".$reportdata['cid']." GROUP by sa_id";
$reportresult_var = mysql_query($query)or die(mysql_error());
while ($reportdata_var = mysql_fetch_array($reportresult_var)) {
 $reportquerynew ="SELECT  ca.cid,sum(cc.lqty) as lqty, sum(cc.lqty*ca.rates) as lastamount,ca.subactivityname,ca.aid,ca.s_id,ca.sa_id,ca.sid,ca.startdate,ca.units, min(ca.startdate) as mindate, ca.enddate, max(ca.enddate) as maxdate,  ca.quantity, ca.rates, cb.pqty, sum(cb.pqty) as tpqty,sum(ca.quantity*ca.rates) as amount, sum(ca.quantity) as tqty ,sum(cb.pamount)As totalamount,cb.pamount, cb.lbdate as lastdate , cb.prs FROM subactivitydata ca 
LEFT OUTER join (progressdata cb)
on (ca.sa_id = cb.sa_id )
LEFT OUTER join (lastmonthdata cc) 
on (cb.sa_id = cc.sa_id) Where  ca.sa_id=".$reportdata_var['sa_id']." GROUP BY ca.sa_id";

$reportresult_act = mysql_query($reportquerynew)or die(mysql_error());
while ($reportdata_act = mysql_fetch_array($reportresult_act)) {
 $bgcolor = ($bgcolor == "#33CC99") ? "#B7FFDB" : "#33CC99";
/*$bgcolor = ($bgcolor == "#FF9999") ? "#FFD5D5" : "#FF9999";*/
$variation_data_sub=getSubActivityVariationData($reportdata_act['sa_id']);
 if($variation_data_sub['tvqty']>0)
{
$variation_this_data_sub=getThisMonthSubactivityVariationData($reportdata_act['sa_id'],$this_month_bid);
$uptolast_variation=$variation_data_sub['tvqty']-$variation_this_data_sub['lvqty'];
$ph_vo_total_todate=$variation_data_sub["variation_in_qty_amount"]+$variation_data_sub["variation_in_rate_amount"];
$ph_vo_thismonth=$variation_this_data_sub["last_variation_in_qty_amount"]+$variation_this_data_sub["last_variation_in_rate_amount"];
$ph_vo_uptolast=$ph_vo_total_todate-$ph_vo_thismonth;
$total_amount_act=$reportdata_act['amount'];
$this_amount=$reportdata_act['lastamount'];
$grand_this_amount+=$this_amount;
$codeData_new=getCode_new($reportdata_act['sa_id']);
$total_qty=$variation_data_sub['tvqty']+$reportdata_act['tpqty'];
$uptolast_progress_qty=$reportdata_act['tpqty']-$reportdata_act['lqty'];
$total_duringthis_qty=$variation_this_data_sub['lvqty']+$reportdata_act['lqty']; //lqty is during this month qty
$total_uptolast_qty=$uptolast_progress_qty+$uptolast_variation; 
if($variation_data_sub['vrate']==0)
{
$this_month_act=(($reportdata_act['lqty'] + $variation_this_data_sub['lvqty']) * $reportdata_act['prs']);
}
else
{
$this_month_act=(($reportdata_act['lqty'] + $variation_this_data_sub['lvqty']) * $variation_data_sub['vrate']);
}

if($variation_last_data_sub['vrate']==0)
{
$last_month_act=($total_uptolast_qty) * $reportdata_act['prs'];
}
else
{
$last_month_act=($total_uptolast_qty) * $variation_this_data_sub['vrate'];
}

if($variation_data_sub['vrate']==0)
{
$total_month=($total_qty) * $reportdata_act['prs'];
}
else
{
$total_month=($total_qty) * $variation_data_sub['vrate'];
}

?>
<?php /*if($variation_data_sub['tvqty']>0)
{*/

$ph_vo_grand_total_todate+=$ph_vo_total_todate;
$ph_vo_grand_lastmonth+=$ph_vo_uptolast;
$ph_vo_grand_currentmonth+=$ph_vo_thismonth;
$grand_total+=$total_amount_act;
$total_month_total+=$total_month;
$last_month_act_total+=$last_month_act;
$this_month_act_total+=$this_month_act;?>
<tr style="background-color:<?php echo $bgcolor;?>;">
<td style="text-align:center;"><?php echo  $codeData_new['code']; ?></td>
<td style="text-align:left;"><?php   echo $reportdata_act['subactivityname']; ?></td>
<td style="text-align:center;"><?php echo $reportdata_act['units']; ?></td>
<?php /*?><td style="text-align:center;"><?php echo number_format($reportdata['quantity'],2); ?></td>
<td style="text-align:right;"><?php  echo number_format($reportdata['rates'],2); ?></td>
<td style="text-align:right;"><?php  echo number_format (($reportdata['quantity'] * $reportdata['rates']),2) ; ?></td><?php */?>
<td style="text-align:center;"><?php echo number_format($reportdata_act['tqty'],2); ?></td>
<td style="text-align:right;"><?php  echo number_format($reportdata_act['rates'],2); ?></td>
<td style="text-align:right;"><?php  echo number_format (($reportdata_act['tqty'] * $reportdata_act['rates']),2) ; ?></td>
<td style="text-align:center;"><?php echo number_format ($total_last_qty,2); ?></td>
<td style="text-align:right;"><?php  echo number_format (($last_month_act),2) ; ?></td>
<td style="text-align:center;"><?php echo number_format ($total_qty - $total_last_qty,2); ?></td>
<td style="text-align:right;"><?php  echo number_format($this_month_act,2) ; ?></td>
<td style="text-align:center;"><?php echo number_format ($total_qty,2); ?></td>   
<td style="text-align:right;"><?php  echo number_format (($total_month),2) ; ?></td>
<td style="text-align:right;"><?php  if($reportdata_act['tpqty']!=0 && $reportdata_act['tqty']!=0)
{
echo number_format((($total_qty / $reportdata_act['tqty'])*100),2);
}
else
{
echo "0.0";
} ?></td>
</tr>
<?php //}?>
<?php
}
}
}
?>
<tr align="right" id="grand_total">
<td style="text-align:right;" colspan="5"><strong><?php echo  "Grand Total:"; ?></strong></td>
<?php /*?><td style="text-align:center;"><?php echo number_format ($grand_total,2); ?></td>
<td style="text-align:right;">&nbsp;</td>
<td style="text-align:right;">&nbsp;</td><?php */?>
<td style="text-align:right;"><?php  
echo number_format ($grand_total,2); ?></td>
<td style="text-align:center;">&nbsp;</td>
<td style="text-align:right;"><?php  echo number_format (($this_month_act_total),2) ; ?></td>
<td style="text-align:center;">&nbsp;</td>
<td style="text-align:right;"><?php  echo  number_format ($last_month_act_total,2) ; ?></td>
<td style="text-align:center;">&nbsp;</td>   
<td style="text-align:right;"><?php  echo  number_format ($total_month_total,2) ; ?></td>
<td style="text-align:right;"><?php  if($total_month_total!=0&&$grand_total!=0)
{
echo number_format((($total_month_total/$grand_total)*100),2);
}
else
{
echo "0.0";
} ?></td>
</tr>
</table>
		</div>	
		
</div>

<!--</td>
</tr>-->
<?php 

$ph_contigency_total=$vo_grand_total_todate;
$ph_contigency_thismonth=$vo_total_thismonth;
$ph_contigency_lastmonth=$vo_total_uptolast;
$to_date_progress= $to_date_progress+$vo_grand_total_todate;
$upto_last_month_progress=$upto_last_month_progress+$vo_total_uptolast;
$during_this_month_progress=$during_this_month_progress+$vo_total_thismonth;

}
$actual_uptolast=$upto_last_month_progress+$vo_uptolast;
$total_actual_uptolast+=$actual_uptolast;
$actual_current=$during_this_month_progress+$vo_thismonth;
$total_actual_current+=$actual_current;
$actual_total=$actual_uptolast+$actual_current;
$grand_actual_total+=$actual_total;
?>
</td>
<td style="text-align:left;"><?php 
if($all_total!=0&&$all_total!="")
{
$weight= ($reportdata['amount']/$all_total)*100;
echo number_format($weight,4);
$totalweight+=$weight;
}
else
{
echo "0.0"; 
}?></td>
<td style="text-align:right;"> <?php echo number_format(($reportdata['amount']),2); 
?></td>
<td style="text-align:left;min-width:75px"><?php if($reportdata['startdate']!="")
{
$time = strtotime($reportdata['startdate']);
$Date = date( 'd-M-Y', $time );
echo $Date;
}//echo substr($reportdata['startdate'],0,4)."/".substr($reportdata['startdate'],4,2)."/".substr($reportdata['startdate'],6,2); ?> </td>
<td style="text-align:left;min-width:75px"><?php if($reportdata['enddate']!="")
{
$time = strtotime($reportdata['enddate']);
$Date = date( 'd-M-Y', $time );
echo $Date;
}
/*else
{
echo "Not Available";
}*/
//echo substr($reportdata['enddate'],0,4)."/".substr($reportdata['enddate'],4,2)."/".substr($reportdata['enddate'],6,2); ?></td>

<td style="text-align:right;"> 
<?php if($reportdata['sid']=='4')
{   $noofdays=0;
	echo "-";
}else
{
	echo $noofdays;
}?>  </td>

<td style="text-align:right;"><?php  if($timeElps>$noofdays)
{
	$timeElps=$noofdays;
											echo "-";}
else
{
	if($timeElps<0)
										{
										$timeElps=0;
										echo "0" ;
										}
										else
										{
										 if($reportdata['sid']=='4')
										{  $timeElps=0;
											echo "-";
										}else
										{
											echo $timeElps;
										}
										}
}?></td>
<td style="text-align:right;"> <?php if($noofdays!=0&&$timeElps!=0)
{
echo number_format(($timeElps/$noofdays)*100,2);

}
else
{
echo "0.0";}?></td>
<td style="text-align:right;"><?php $uptolast_planned_progress=$planned_progress-$current_month_planned_progress;
									$total_uptolast_planned_progress+=$uptolast_planned_progress;
									echo number_format($uptolast_planned_progress,2);?></td>
<td style="text-align:right;"><?php $total_current_month_planned_progress+=$current_month_planned_progress;
									 echo number_format($current_month_planned_progress,2);?></td>
<td style="text-align:right;"><?php  
										echo number_format($planned_progress,2);?></td>
<td style="text-align:right;"> <?php 
									echo number_format($upto_last_month_progress,2);
									?> </td>
<td style="text-align:right;"><?php echo number_format(($during_this_month_progress),2); ?></td>
<td style="text-align:right;"><?php 
						
										echo number_format(($to_date_progress),2);
										 ?></td>
<td style="text-align:right;"> <?php if($to_date_progress!=0&&$planned_progress!=0)
										{
										$SPI=$to_date_progress/$planned_progress;
									     echo number_format($SPI,2);
										}
										 else
										 {
										 echo "0.00";
										 } ?></td>
<td style="text-align:right;"><?php 
									//col18=col14-col4
									/*$vo_lastmonth=0;
									if($upto_last_month_progress-$reportdata['amount']>0)
									echo number_format(($upto_last_month_progress-$reportdata['amount']),2);
									else*/
									echo number_format($vo_uptolast,2);
									?></td>
<td style="text-align:right;"><?php 
									//col19=(col14+col15)-col4
								/*	$vo_currentmonth=0;
									if(($upto_last_month_progress+$last_month_progress['lastamount'])-$reportdata['amount']>0)
									echo number_format(($upto_last_month_progress+$last_month_progress['lastamount'])-$reportdata['amount'],2);
									else*/
									echo number_format($vo_thismonth,2);?></td>
<td style="text-align:right;"><?php //col20=(col6)-col4
									/*$vo_total_todate=0;
									if(($to_date_progress-$reportdata['amount'])>0)
									{
									
									echo number_format($to_date_progress-$reportdata['amount'],2);
									$vo_total_todate=$to_date_progress-$reportdata['amount'];
									}
									else
									{*/
									echo number_format($vo_total_todate,2);
									//}
									?></td>
<td style="text-align:right;"><?php if($reportdata['amount']!=0&&$reportdata['amount']!="")
									{
									/*echo $vo_total_todate;
									echo "</br>";
									echo $all_total;
									echo "</br>";*/
									echo $orignal_contract_cost=number_format((($vo_total_todate/$all_total)*100),2);
									}
									else
									{
									echo "0.0";
									}?></td>
<td style="text-align:right;"><?php 
									echo number_format($actual_uptolast,2);
									?></td>
<td style="text-align:right;"><?php
									echo number_format($actual_current,2);
									?></td>
<td style="text-align:right;"><?php 
									echo number_format($actual_total,2);?></td>
<td style="text-align:right;"><?php if($actual_total!=0&&$actual_total!="")
										{
										echo $CPI= number_format(($to_date_progress/ $actual_total),2);
										}
										else
										{
										echo "0.00";
										}?></td>
<td style="text-align:right;"><?php if($reportdata['amount']!=0 && $reportdata['amount']!="")
{
$percent_progress=($to_date_progress/$reportdata['amount']*100);
echo number_format($percent_progress,2);
}
else
{
echo "0.0";
}?></td>
</tr>


<?php
 $total_progress+=$to_date_progress;
 $total_upto_last_month_progress+=$upto_last_month_progress;
 $total_current_month_progress+= $during_this_month_progress;
}
?>
<tr align="right" id="grand_total">
<td colspan="2" align="right">
<strong>Grand Total:</strong></td>
<td align="right">
<?php echo $totalweight;?></td>
<td align="right">
<?php echo number_format($grand_total_final,2);?></td>
<td style="min-width:80px;" align="left">
<?php $yr=substr($mindate,0,4);
$month=substr($mindate,4,-2);
$day=substr($mindate,6,8);
if($mindate!="")
{
$time = strtotime($mindate);
$Date = date( 'd-m-Y', $time );
echo $Date;
}?></td>
<td align="left" style="min-width:75px">
<?php $yr=substr($maxdate,0,4);
$month=substr($maxdate,4,-2);
$day=substr($maxdate,6,8);
if($maxdate!="")
{
$time = strtotime($maxdate);
$Date = date( 'd-m-Y', $time );
echo $Date;
}?></td>
<td>
<?php $mindate=str_replace("/","-",$mindate);
      
      $maxdate=str_replace("/","-",$maxdate);
	  
	 // echo $ress=dateDiff($mindate,$maxdate);?></td>

<td>
<?php //echo $timeElps;?></td>
<td>
<?php /*?><?php if($ress!=0)
{
echo number_format(($timeElps/$ress)*100,2);
}
else
{
echo "0.0";
}
?><?php */?>
</td>
<td><?php echo number_format($total_uptolast_planned_progress,2);?></td>
<td><?php echo number_format($total_current_month_planned_progress,2);?></td>
<td><?php echo number_format($total_planned_progress,2);?></td>
<td>
<?php echo  number_format($total_upto_last_month_progress,2);?></td>
<td align="right">
<?php echo  number_format($total_current_month_progress,2);?></td>
<td align="right">
<?php echo  number_format($total_progress,2);?></td>
<td align="right">
<?php if($total_progress!=0&&$total_planned_progress!=0)
{
 echo  number_format(($total_progress/$total_planned_progress),2);
 }
 else
 {
echo "0.00";
}
?></td>
<td style="text-align:right;"><?php echo number_format($vo_total_uptolast,2);?></td>
<td style="text-align:right;"><?php echo number_format($vo_total_thismonth,2);?></td>
<td style="text-align:right;"><?php echo number_format($vo_grand_total_todate,2);?></td>
<td align="right">&nbsp;</td>
<td align="right"><?php if($ph_contigency_lastmonth!=0)
						{
							$total_actual_uptolast=$total_actual_uptolast-$ph_contigency_lastmonth;
							echo number_format($total_actual_uptolast,2);
						}
						else
						{
							echo number_format($total_actual_uptolast,2);
						}?></td>
<td align="right"><?php 	if($ph_contigency_thismonth!=0)
								{
								$total_actual_current=$total_actual_current-$ph_contigency_thismonth;
								echo number_format($total_actual_current,2);
								}
								else
								{
									echo number_format($total_actual_current,2);
								}?></td>
<td align="right"><?php if($ph_contigency_total!=0)
							{ 
							$grand_actual_total=$grand_actual_total-$ph_contigency_total;
							echo number_format(($grand_actual_total),2);
							}
							else
							{
							echo number_format(($grand_actual_total),2);
							}?></td>
<td align="right">&nbsp;</td>
<td align="right"><?php 
				if($grand_total_final!=0 && $grand_total_final!="")
				{
				$final_progress=($grand_actual_total/$grand_total_final)*100;
				echo number_format($final_progress,2);
				}
				else
				{
				echo "0.00";
				}?></td>
</tr>

</table>
</form>
<?php }
else
{
function getComponentName($cid)
{
$sql="SELECT detail as c_name FROM  `components` where cid=".$cid;
$result = mysql_query($sql);
//echo $amountsize= mysql_num_rows($amountresult);
$data=mysql_fetch_array($result);
return $data;
}
function ProgressDate()
{
$sql="SELECT  MAX(bdate) as lastdate FROM  `progressmonth` ";
$amountresult = mysql_query($sql);
//echo $amountsize= mysql_num_rows($amountresult);
$data=mysql_fetch_array($amountresult);
return $data;
}
$last_date=ProgressDate();
$component_name=getComponentName($componentid);?>
<table id="tblList" cellpadding="0px" cellspacing="0px"   width="102%" align="center" >
<tr  id="title">
<td colspan="15" align="center"><span class="white"><strong>Progress Report For (<?php echo $component_name["c_name"];?>)</strong> </span> <span style="position:absolute; padding-left:230px">  <a style="text-decoration:none;color:#ffffff" href="javascript:void(null);" onclick="window.open('printsubcomponent_detail_report.php?componentid=<?php echo $componentid;?>&projectid=<?php echo $projectid;?>&activitytypeid=<?php echo $activitytypeid;?>', 'INV', 'width=1120,height=550,scrollbars=yes');" ><img src="images/ico_print.gif" border="0" /> Print Report</a></span> 
  </th></tr>
<tr id="tblHeading" align="center">
<th rowspan="2" width="46"> Sr. No.</th>
    <th rowspan="2" width="201">Activity / Sub-activity</th>
	 <th rowspan="2" width="37"> Unit </th>
    <th rowspan="2" width="59"> Total Target </th>
    <th colspan="2">Starting Date</th>
    <th colspan="2">Date Of Completion </th>
    <th width="68" rowspan="2">Schedule Number Of days </th>
	 <th width="62" rowspan="2">Days Elapsed </th>
     <th width="62" rowspan="2">% Time Elapsed </th>
     <th colspan="4">Progress</th>
    </tr>
  <tr id="tblHeading">
    <th width="83">Scheduled </th>
    <th width="79">Actual</th>
    <th width="88">Scheduled </th>
    <th width="89">Actual</th>
    <th width="46">Up to Last Month</th>
    <th width="56">During Month</th>
    <th width="68">To Date Progress</th>
    <th width="68">Up to Date % Progress</th>
  </tr>
<tr >
<td align="center">&nbsp;</td>
<td style="text-align:center;" >1</td>
<td style="text-align:center;">2</td>
<td style="text-align:center;">3</td>
<td style="text-align:center;">4</td>
<td style="text-align:center;">5</td>
<td style="text-align:center;">6</td>
<td style="text-align:center;">7</td>
<td style="text-align:center;">8</td>
<td style="text-align:center;">9</td>
<td style="text-align:center;">10</td>
<td style="text-align:center;">11</td>
<td style="text-align:center;">12</td>
<td style="text-align:center;">13</td>
<td style="text-align:center;">14</td>
</tr>
<?php


function getThisMonthSubComponentProgress($sa_id)
{
 $thismonth=date('Ym');
 $sql2="SELECT sum(pamount) AS cprogress
FROM `progressdata` 
WHERE  sa_id =".$sa_id."  AND lbdate LIKE '%".$thismonth."%' GROUP BY sa_id";
$pamountresultp = mysql_query($sql2)or die(mysql_error());
$pgdata=mysql_fetch_array($pamountresultp);
return $pgdata;
}

function getSDate($aid)
{
 $sql="SELECT actual_stardate  FROM  `activity` where aid=".$aid;
 
$amountresult = mysql_query($sql);
//echo $amountsize= mysql_num_rows($amountresult);
$data=mysql_fetch_array($amountresult);

return $data;
}
function getEDate($aid)
{
 $sql="SELECT actual_enddate  FROM  `activity` where aid=".$aid;
 
$amountresult = mysql_query($sql);
//echo $amountsize= mysql_num_rows($amountresult);
$data=mysql_fetch_array($amountresult);

return $data;
}
$grand_total=0;
$total_progress=0;
$total_current_month_progress=0;
$total_upto_last_month_progress=0;
$total_noofdays=0;
$total_timeElps=0;
$total_planned_progress=0;
$to_date_progress=0;

function getSubComponentProgressAmount($cid,$sid,$sa_id,$s_id)
{
 $sql2="SELECT sa_id,sum( pamount) AS tamount, max( bdate ) AS lastdate
FROM `progress` 
WHERE sa_id =".$sa_id." AND cid=".$cid." AND sid=".$sid." AND s_id=".$s_id." GROUP BY sa_id";
$pamountresult2 = mysql_query($sql2)or die(mysql_error());
$pdata=mysql_fetch_array($pamountresult2);
return $pdata;
}
function getLastMonthProgress($aid)
{
 $thismonth=date('Ym');
 $sql2="SELECT  ca.cid,cc.lqty, sum( cc.lqty*ca.rates) as lastamount
FROM subactivitydata ca
LEFT OUTER join (lastmonthdata cc) on (ca.sa_id = cc.sa_id) where ca.aid=".$aid." GROUP BY ca.aid";
$pamountresultp = mysql_query($sql2)or die(mysql_error());
$pgdata=mysql_fetch_array($pamountresultp);
return $pgdata;
}
function getVariationData($aid)
{ 
$sql2="SELECT sum(vd.vqty) As tvqty, sum(vd.vrate*cc.quantity) as variation_in_rate_amount, sum(vd.vqty*dd.prs) as variation_in_qty_amount,sum(vd.`vamount`) as variation_in_amount,vd.`vo_id`,vd.`contigency_code`,vd.`vono`,vd.`vodate`,vd.`bid`,vd.`remark`,vd.`vstatus`,vd.`bdate`
FROM variationdata vd
LEFT OUTER JOIN (subactivitydata cc) on (vd.sa_id = cc.sa_id) 
LEFT OUTER JOIN (progressdata dd) on (vd.sa_id = dd.sa_id) where cc.aid=".$aid." GROUP BY cc.aid";
$pamountresultp = mysql_query($sql2)or die(mysql_error());
$pgdata=mysql_fetch_array($pamountresultp);
return $pgdata;
}
function getSubActivityVariationData($sa_id)
{ 
$sql2="SELECT sum(vd.vqty) As tvqty, sum(vd.vrate*cc.quantity) as variation_in_rate_amount, sum(vd.vqty*dd.prs) as variation_in_qty_amount,sum(vd.`vamount`) as variation_in_amount,vd.`vo_id`,vd.`contigency_code`,vd.`vono`,vd.`vodate`,vd.`bid`,vd.`remark`,vd.`vstatus`,vd.`bdate`
FROM variationdata vd
LEFT OUTER JOIN (subactivitydata cc) on (vd.sa_id = cc.sa_id)
LEFT OUTER JOIN (progressdata dd) on (vd.sa_id = dd.sa_id) where cc.sa_id=".$sa_id." GROUP BY cc.sa_id";
$pamountresultp = mysql_query($sql2)or die(mysql_error());
$pgdata=mysql_fetch_array($pamountresultp);
return $pgdata;
}
function getThisMonthVariationData($aid,$bid)
{ 
 $sql2="SELECT sum(vd.vqty) As tvqty, sum(vd.vrate*cc.quantity) as variation_in_rate_amount, sum(vd.vqty*dd.prs) as variation_in_qty_amount,sum(vd.`vamount`) as variation_in_amount,vd.`vo_id`,vd.`contigency_code`,vd.`vono`,vd.`vodate`,vd.`bid`,vd.`remark`,vd.`vstatus`,vd.`bdate`
FROM variationdata vd
LEFT OUTER JOIN (subactivitydata cc) on (vd.sa_id = cc.sa_id)
LEFT OUTER JOIN (progressdata dd) on (vd.sa_id = dd.sa_id) where cc.aid=".$aid." AND vd.bid=".$bid." GROUP BY cc.aid";

$pamountresultp = mysql_query($sql2)or die(mysql_error());
$pgdata=mysql_fetch_array($pamountresultp);
return $pgdata;
}
function getThisMonthSubactivityVariationData($sa_id,$bid)
{ 
 $sql2="SELECT sum(vd.vqty) As lvqty, sum(vd.vrate*cc.quantity) as last_variation_in_rate_amount, sum(vd.vqty*dd.prs) as last_variation_in_qty_amount,sum(vd.`vamount`) as last_variation_in_amount,vd.`vo_id`,vd.`contigency_code`,vd.`vono`,vd.`vodate`,vd.`bid`,vd.`remark`,vd.`vstatus`,vd.`bdate`
FROM variationdata vd
LEFT OUTER JOIN (subactivitydata cc) on (vd.sa_id = cc.sa_id)
LEFT OUTER JOIN (progressdata dd) on (vd.sa_id = dd.sa_id) where cc.sa_id=".$sa_id." AND vd.bid=".$bid." GROUP BY cc.sa_id";
$pamountresultp = mysql_query($sql2)or die(mysql_error());
$pgdata=mysql_fetch_array($pamountresultp);
return $pgdata;
}
function getCode($aid)
{
 $sql="SELECT code FROM  `activity` where aid=".$aid;
 
$amountresult = mysql_query($sql);
//echo $amountsize= mysql_num_rows($amountresult);
$data=mysql_fetch_array($amountresult);

return $data;
}
function getLastDate($sa_id)
{
 $sql="SELECT lbdate as lastdate FROM  `progressdata` where sa_id=".$sa_id;
 
$amountresult = mysql_query($sql);
//echo $amountsize= mysql_num_rows($amountresult);
$data=mysql_fetch_array($amountresult);

return $data;
}
function getActivityProgressAmount($cid,$sid,$sa_id,$s_id,$aid)
{
 
$sql2="SELECT sa_id,sum( pqty * prs ) AS tamount, max( bdate ) AS lastdate
FROM `progress` 
WHERE sa_id =".$sa_id." AND cid=".$cid." AND sid=".$sid." AND s_id=".$s_id." AND aid=".$aid." GROUP BY sa_id";
$pamountresult3 = mysql_query($sql2)or die(mysql_error());
$pdata=mysql_fetch_array($pamountresult3);
return $pdata;
}
function getCode_new($sa_id)
{
 $sql="SELECT code FROM  `subactivity` where sa_id=".$sa_id;
 
$amountresult = mysql_query($sql);
//echo $amountsize= mysql_num_rows($amountresult);
$data=mysql_fetch_array($amountresult);

return $data;
}
function LastMonthProgressDate()
{
$sql="SELECT  MAX(bdate) as lastMonthdate,bid FROM  `progressmonth`  Group by bid order by bid DESC";
$amountresult = mysql_query($sql);
//echo $amountsize= mysql_num_rows($amountresult);
$data=mysql_fetch_array($amountresult);
return $data;
}
$last_month_data=LastMonthProgressDate();
$this_month_bid=$last_month_data["bid"];
$ph_contigency_total=0;
$ph_contigency_lastmonth=0;
$ph_contigency_thismonth=0;
$grand_total=0;
$grand_total_final=0;
$total_progress=0;
$total_current_month_progress=0;
$total_upto_last_month_progress=0;
$total_noofdays=0;
$total_timeElps=0;
$total_planned_progress=0;
$to_date_progress=0;
$contigency=$subcomponentid+1;
$weight=0;
$totalweight=0;
$days_of_current_month=0;
$current_month_planned_progress=0;
$total_current_month_planned_progress=0;
$vo_lastmonth=0;
$vo_currentmonth=0;
$vo_todate=0;
$vo_total_lastmonth=0;
$vo_total_currentmonth=0;
$vo_total_todate=0;
$vo_grand_total_todate=0;
$orignal_contract_cost=0;
$percent_progress=0;
$actual_total=0;
$adjusted_cost=0;
$actual_uptolast=0;
$actual_current=0;
$CPI=0;
$total_uptolast_planned_progress=0;
$total_current_month_planned_progress=0;
$total_actual_uptolast=0;
$total_actual_current=0;
$grand_actual_total=0;
$total_adjusted_cost=0;
$mindate=0;
$maxdate=0;
$timeElps =0;
$bgcolor=0;
$during_this_month_progress=0;

$reportquery ="SELECT sum( cc.lqty*ca.rates) as lastamount,ca.subcomponentname,ca.activityname,ca.aid,ca.s_id,ca.sa_id,ca.startdate,ca.units, min(ca.startdate) as mindate, ca.enddate, max(ca.enddate) as maxdate,sum(ca.quantity*ca.rates) as amount ,sum(cb.pamount)As totalamount,cb.pamount, cb.lbdate as lastdate FROM subactivitydata ca 
LEFT OUTER join (progressdata cb)
on (ca.sa_id = cb.sa_id )
LEFT OUTER join (lastmonthdata cc) 
on (cb.sa_id = cc.sa_id) where ca.sid=".$activitytypeid." AND ca.cid=".$componentid."  GROUP BY ca.aid ORDER BY ca.sub_order,ca.sa_id";
$reportresult = mysql_query($reportquery);
$i=0;
while ($reportdata = mysql_fetch_array($reportresult)) {
$bgcolor = ($bgcolor == "#FFFFFF") ? "#EAF4FF" : "#FFFFFF";
$mindate=$reportdata["mindate"];
$maxdate=$reportdata["maxdate"];
$codeData=getCode($reportdata['aid']);
$SDateData=getSDate($reportdata['aid']);
$EDateData=getEDate($reportdata['aid']);
$last_month_progress=getLastMonthProgress($reportdata['aid']);
$during_this_month_progress=$reportdata['lastamount'];

$variation_data=getVariationData($reportdata['aid']);
$this_variation_data=getThisMonthVariationData($reportdata['aid'],$this_month_bid);///during this month
 $vo_thismonth=$this_variation_data["variation_in_qty_amount"]+$this_variation_data["variation_in_rate_amount"];
$vo_total_thismonth+=$this_variation_data["variation_in_qty_amount"]+$this_variation_data["variation_in_rate_amount"];
/*$vo_total_lastmonth+=$this_variation_data["variation_in_qty_amount"]+$this_variation_data["variation_in_rate_amount"];*/
$vo_total_todate=$variation_data["variation_in_qty_amount"]+$variation_data["variation_in_rate_amount"];
$vo_uptolast=$vo_total_todate-$vo_thismonth;
$vo_total_uptolast+=$vo_uptolast;
$vo_grand_total_todate+=$vo_total_todate;
$total_current_month_progress+=$reportdata['lastamount'];
$upto_last_month_progress=$reportdata['totalamount']-$reportdata['lastamount'];
$total_upto_last_month_progress+=$upto_last_month_progress;
$to_date_progress=$reportdata['lastamount']+$upto_last_month_progress;
$total_progress+=$to_date_progress;
$actual_uptolast=$upto_last_month_progress+$vo_uptolast;
$total_actual_uptolast+=$actual_uptolast;
$actual_current=$during_this_month_progress+$vo_thismonth;
$total_actual_current+=$actual_current;
$actual_total=$actual_uptolast+$actual_current;
$grand_actual_total+=$actual_total;?>
<?php
$current=$reportdata['s_id'];
$time1 = strtotime($reportdata['startdate']);
 $Date1 = date( 'd-m-Y', $time1 );
$time2 = strtotime( $reportdata['enddate']);
 $Date2 = date( 'd-m-Y', $time2 );
$aenddate = strtotime($Date2);
$astartdate = strtotime($Date1);
//$noofdays = ceil(abs($aenddate - $astartdate) / 86400); 
$noofdays = round(($aenddate - $astartdate) / 86400,0); 
$noofdays=trim(str_replace(",","",$noofdays));

$noofdays+=1;

?>
<?php
if($actual_total<$reportdata['amount'])
{
$aenddate = strtotime(substr($reportdata['startdate'],0,4)."-".substr($reportdata['startdate'],4,2)."-".substr($reportdata['startdate'],6,2));
$tlbdate = strtotime(substr($last_date["lastdate"],0,4)."-".substr($last_date["lastdate"],4,2)."-".substr($last_date["lastdate"],6,2));
//$aenddate = strtotime(substr($reportdata['enddate'],0,4)."-".substr($reportdata['enddate'],4,2)."-".substr($reportdata['enddate'],6,2));
//$tlbdate = strtotime(substr($reportdata['lastdate'],0,4)."-".substr($reportdata['lastdate'],4,2)."-".substr($reportdata['lastdate'],6,2));
$datediff = $tlbdate-$aenddate ;

$timeElps = round(($tlbdate-$aenddate) / 86400,0); 
$timeElps+=1;
if($timeElps<0)
{
$timeElps=0;
}



}
else
{
$aenddate = strtotime(substr($reportdata['startdate'],0,4)."-".substr($reportdata['startdate'],4,2)."-".substr($reportdata['startdate'],6,2));
$tlbdate = strtotime(substr($EDateData['actual_enddate'],0,4)."-".substr($EDateData['actual_enddate'],4,2)."-".substr($EDateData['actual_enddate'],6,2));
//$aenddate = strtotime(substr($reportdata['enddate'],0,4)."-".substr($reportdata['enddate'],4,2)."-".substr($reportdata['enddate'],6,2));
//$tlbdate = strtotime(substr($reportdata['lastdate'],0,4)."-".substr($reportdata['lastdate'],4,2)."-".substr($reportdata['lastdate'],6,2));
$datediff = $tlbdate-$aenddate ;
$timeElps = round(($tlbdate-$aenddate) / 86400,0); 
$timeElps+=1;
if($timeElps<0)
{
$timeElps=0;
}



}
if($prev!=$current)
{
$i++;?>
<?php if($vo_total_todate>0)
$bgcolor="#FFFF00";
?>
<tr >
<td align="center"><?php echo $i;?> </td>
<td style="text-align:left; text-transform:capitalize" ><?php echo $reportdata['subcomponentname']; ?></td>
<td style="text-align:center;">&nbsp;</td>
<td style="text-align:center;">&nbsp;</td>
<td style="text-align:center;">&nbsp;</td>
<td style="text-align:center;">&nbsp;</td>
<td style="text-align:center;">&nbsp;</td>
<td style="text-align:center;">&nbsp;</td>
<td style="text-align:center;">&nbsp;</td>
<td style="text-align:center;">&nbsp;</td>
<td style="text-align:center;">&nbsp;</td>
<td style="text-align:center;">&nbsp;</td>
<td style="text-align:center;">&nbsp;</td>
<td style="text-align:center;">&nbsp;</td>
<td style="text-align:center;">&nbsp;</td>
</tr>
<?php } ?>


<tr style="background-color:<?php echo $bgcolor;?>;">
<td style="text-align:center;">&nbsp;</td>

<td style="text-align:left;"><?php echo $codeData['code'].".&nbsp;".$reportdata['activityname']; ?></td>
<td style="text-align:center;text-transform:capitalize"><?php echo $reportdata['units']; ?></td>
<td style="text-align:right; padding-right:5px"> <?php echo $reportdata['amount']; 
$grand_total+=$reportdata['amount'];?></td>
<td align="left" style="min-width:75px"><?php if($reportdata['startdate']!=""){									
$time = strtotime($reportdata['startdate']);
$Date = date( 'd-M-Y', $time );
echo $Date;
} ?> </td>
<td style="text-align:left;"><?php if($SDateData['actual_stardate']!=""){									
$time = strtotime($SDateData['actual_stardate']);
$Date = date( 'd-M-Y', $time );
echo $Date;
} ?></td>
<td style="text-align:left; min-width:75px"><?php if($reportdata['enddate']!=""){									
$time = strtotime($reportdata['enddate']);
$Date = date( 'd-M-Y', $time );
echo $Date;
}?> </td>
<td style="text-align:left; min-width:75px"><?php if($EDateData['actual_enddate']!=""){									
$time = strtotime($EDateData['actual_enddate']);
$Date = date( 'd-M-Y', $time );
echo $Date;
} ?></td>
<td style="text-align:right;padding-right:5px"> <?php echo $noofdays; ?>   </td>
<td style="text-align:right;padding-right:5px"><?php  
										echo $timeElps;
										?>  </td>
										<td align="right"><?php 
								
										if($noofdays!=0)
										{
										$p_time_elapsed=($timeElps/$noofdays)*100;
										echo number_format(($timeElps/$noofdays)*100,2);
										}
										else
										{
										echo "0.0";
										}
										
								
								?></td>
<td style="text-align:right;padding-right:5px"> <?php 
									echo $actual_uptolast;
									?> </td>
<td style="text-align:right;padding-right:5px"><?php if($actual_current==0)
echo "0";
else
echo $actual_current;?></td>
<td style="text-align:right;padding-right:5px"><?php 
						
										echo $actual_total;
										 ?></td>
<td style="text-align:right;padding-right:5px"> <?php if($reportdata['amount']!=0)
{
echo  number_format (($actual_total  / $reportdata['amount']*100),2);
}
else
{
echo "0.0";} ?></td>
</tr>


<?php
$prev=$reportdata['s_id'];
}
?>
<?php /*?><tr align="right" id="grand_total">
<td colspan="3" align="right">
<strong>Grand Total:</strong></td>
<td align="right">
<?php echo number_format($grand_total,2);?></td>
<td align="left" style="min-width:75px">
<?php $yr=substr($mindate,0,4);
$month=substr($mindate,4,-2);
$day=substr($mindate,6,8);
if($mindate!="")
{									
$time = strtotime($mindate);
$Date = date( 'd-M-Y', $time );
echo $Date;
}?></td>
<td>
<?php //echo $maxdate;?></td>
<td align="left" style="min-width:75px">
<?php $yr=substr($maxdate,0,4);
$month=substr($maxdate,4,-2);
$day=substr($maxdate,6,8);
if($maxdate!="")
{	
$time = strtotime($maxdate);
$Date = date( 'd-M-Y', $time );
echo $Date;								
}
?></td>
<td align="left" style="min-width:75px">&nbsp;</td>
<td>
<?php $mindate=str_replace("/","-",$mindate);
      
      $maxdate=str_replace("/","-",$maxdate);
	  
	  echo $ress=dateDiff($mindate,$maxdate);?></td>
<td>
<?php echo $timeElps;?></td>
<td>
<?php if($ress!=0)
{
echo number_format(($timeElps/$ress)*100,2);
}
else
{
echo "0.0";
}
?></td>
<td>
<?php echo  number_format($total_upto_last_month_progress,2);?></td>
<td align="right">
<?php echo  number_format($total_current_month_progress,2);?></td>
<td align="right">
<?php echo  number_format($total_progress,2);?></td>
<td align="right">
<?php echo  number_format(($total_progress/$grand_total*100),2);?></td>
</tr><?php */?>
</table>
<?php
}?>

<?php
}
?>
</div>

<!-- Start Subcomponent  Table here-->

<div id="result10">
<?php
if ($subcomponentflag == 1 && $activityid == 0 ) {
$query="SELECT * FROM subcomponents where (sid=3 OR sid=4) and cid=".$componentid;
$queryresult = mysql_query($query);
$numrows=mysql_num_rows($queryresult);
if($numrows>0)
{?>
<table id="tblList" cellpadding="0px" cellspacing="0px"   width="98%" align="center" >
<tr  id="title">
<td colspan="18" align="center"><span class="white"><strong>General Report At Sub-Component Level(<?php echo $subcomponentid; ?>)</strong></span> 
  </th>  
  <span style="position:absolute; padding-left:230px"> <a style="text-decoration:none;color:#ffffff" href="javascript:void(null);" onclick="window.open('printsubcomponent_level_report.php?componentid=<?php echo $componentid;?>&projectid=<?php echo $projectid;?>&activitytypeid=<?php echo $activitytypeid;?>&subcomponentid=<?php echo $subcomponentid;?>', 'INV', 'width=1120,height=550,scrollbars=yes');" ><img src="images/ico_print.gif" border="0" /> Print Report</a></span></tr>
<tr id="tblHeading">
<th rowspan="2" width="70px;"> Sr.No.</th>
      <th rowspan="2" width="70px;"> Code</th>
    <th rowspan="2" width="200px;">Activity Name</th>
    <th rowspan="2" width="100px;"> Contract Amount </th>
    <th colspan="2">Starting Date</th>
    <th colspan="2"> Ending Date</th>
    <th colspan="2">No of Days </th>
    <th colspan="2">Time Elps % </th>
    <th rowspan="2">Last Month</th>
    <th rowspan="2">During Month</th>
    <th rowspan="2">To Date Progress</th>   
      <th rowspan="2" width="70px;">Upto Date Percent</th>
    <th rowspan="2"width="70px;">Planned Progress</th>
    <th rowspan="2">SPI</th>
	</tr>
  <tr id="tblHeading">
    <th>Scheduled </th>
    <th>Actual</th>
    <th> Scheduled</th>
    <th>Actual</th>
    <th>Scheduled</th>
    <th>Actual</th>
    <th>Scheduled</th>
    <th>Actual</th>
</tr>

<?php
function getVariationData($aid)
{ 
$sql2="SELECT sum(vd.vqty) As tvqty, sum(vd.vrate*cc.quantity) as variation_in_rate_amount, sum(vd.vqty*dd.prs) as variation_in_qty_amount,sum(vd.`vamount`) as variation_in_amount,vd.`vo_id`,vd.`contigency_code`,vd.`vono`,vd.`vodate`,vd.`bid`,vd.`remark`,vd.`vstatus`,vd.`bdate`
FROM variationdata vd
LEFT OUTER JOIN (subactivitydata cc) on (vd.sa_id = cc.sa_id) 
LEFT OUTER JOIN (progressdata dd) on (vd.sa_id = dd.sa_id) where cc.aid=".$aid." GROUP BY cc.aid";
$pamountresultp = mysql_query($sql2)or die(mysql_error());
$pgdata=mysql_fetch_array($pamountresultp);
return $pgdata;
}
function getThisMonthVariationData($aid,$bid)
{ 
$sql2="SELECT sum(vd.vqty) As tvqty, sum(vd.vrate*cc.quantity) as variation_in_rate_amount, sum(vd.vqty*dd.prs) as variation_in_qty_amount,sum(vd.`vamount`) as variation_in_amount,vd.`vo_id`,vd.`contigency_code`,vd.`vono`,vd.`vodate`,vd.`bid`,vd.`remark`,vd.`vstatus`,vd.`bdate`
FROM variationdata vd
LEFT OUTER JOIN (subactivitydata cc) on (vd.sa_id = cc.sa_id)
LEFT OUTER JOIN (progressdata dd) on (vd.sa_id = dd.sa_id) where cc.aid=".$aid." AND vd.bid=".$bid." GROUP BY cc.aid";
$pamountresultp = mysql_query($sql2)or die(mysql_error());
$pgdata=mysql_fetch_array($pamountresultp);
return $pgdata;
}
function getSubComponentProgressAmount($cid,$sid,$sa_id,$s_id)
{
 $sql2="SELECT sa_id,sum( pamount) AS tamount, max( bdate ) AS lastdate
FROM `progress` 
WHERE sa_id =".$sa_id." AND cid=".$cid." AND sid=".$sid." AND s_id=".$s_id." GROUP BY sa_id";
$pamountresult2 = mysql_query($sql2)or die(mysql_error());
$pdata=mysql_fetch_array($pamountresult2);
return $pdata;
}
function getThisMonthSubComponentProgress($sa_id)
{
 $thismonth=date('Ym');
 $sql2="SELECT sum(pamount) AS cprogress
FROM `progressdata` 
WHERE  sa_id =".$sa_id."  AND lbdate LIKE '%".$thismonth."%' GROUP BY sa_id";
$pamountresultp = mysql_query($sql2)or die(mysql_error());
$pgdata=mysql_fetch_array($pamountresultp);
return $pgdata;
}
function getCode($aid)
{
 $sql="SELECT code FROM  `activity` where aid=".$aid;
 
$amountresult = mysql_query($sql);
//echo $amountsize= mysql_num_rows($amountresult);
$data=mysql_fetch_array($amountresult);

return $data;
}
function LastMonthProgressDate()
{
$sql="SELECT  MIN(bdate) as lastMonthdate,bid FROM  `progressmonth` Group by bid order by bid ASC";
$amountresult = mysql_query($sql);
//echo $amountsize= mysql_num_rows($amountresult);
$data=mysql_fetch_array($amountresult);
return $data;
}
function ThisMonthProgressDate()
{
$sql="SELECT  MAX(bdate) as lastMonthdate,bid FROM  `progressmonth` Group by bid order by bid desc";
$amountresult = mysql_query($sql);
//echo $amountsize= mysql_num_rows($amountresult);
$data=mysql_fetch_array($amountresult);
return $data;
}
$this_month_data=ThisMonthProgressDate();
$this_month_bid=$this_month_data["bid"];
$grand_total=0;
$total_progress=0;
$total_current_month_progress=0;
$total_upto_last_month_progress=0;
$total_noofdays=0;
$total_timeElps=0;
$total_planned_progress=0;
$to_date_progress=0;

$reportquery ="SELECT  ca.cid,cc.lqty, sum( cc.lqty*ca.rates) as lastamount,ca.activityname,ca.aid,ca.s_id,ca.sa_id,ca.sid,ca.startdate, min(ca.startdate) as mindate, ca.enddate, max(ca.enddate) as maxdate,  ca.quantity, ca.rates, cb.pqty, sum(ca.quantity*ca.rates) as amount, sum(cb.pamount)As totalamount,cb.pamount, cb.lbdate as lastdate FROM subactivitydata ca 
LEFT OUTER join (progressdata cb)
on (ca.sa_id = cb.sa_id )
LEFT OUTER join (lastmonthdata cc) 
on (cb.sa_id = cc.sa_id) Where ca.sid=".$activitytypeid." AND ca.s_id=".$subcomponentid." GROUP BY ca.aid";
$reportresult = mysql_query($reportquery);
$i=0;
while ($reportdata = mysql_fetch_array($reportresult)) {
$bgcolor = ($bgcolor == "#FFFFFF") ? "#EAF4FF" : "#FFFFFF";
$mindate=$reportdata["mindate"];
$maxdate=$reportdata["maxdate"];
$codeData=getCode($reportdata['aid']);
$current_month_progress=$reportdata['lastamount'];
$upto_last_month_progress=$reportdata['totalamount']-$reportdata['lastamount'];

$variation_data=getVariationData($reportdata['aid']);///////////////variation data

$this_variation_data=getThisMonthVariationData($reportdata['aid'],$this_month_bid);//////////////this variation data

$vo_thismonth=$this_variation_data["variation_in_qty_amount"]+$this_variation_data["variation_in_rate_amount"];
$this_month_progress=$current_month_progress+$vo_thismonth;
$total_this_month_progress+=$this_month_progress;
$vo_total_todate=$variation_data["variation_in_qty_amount"]+$variation_data["variation_in_rate_amount"];
$vo_uptolastmonth=$vo_total_todate-$vo_thismonth;
$uptolast_month_progress=$upto_last_month_progress+$vo_uptolastmonth;
 $total_uptolast_month_progress+=$uptolast_month_progress;
$to_date_progress=$this_month_progress+$uptolast_month_progress;
$total_progress+=$to_date_progress;

if($noofdays!=0)
{
$planned_progress=($reportdata['amount']/$noofdays) * $timeElps;
}
$total_planned_progress+=$planned_progress;
?>
<?php
$aenddate = strtotime(substr($reportdata['enddate'],0,4)."-".substr($reportdata['enddate'],4,2)."-".substr($reportdata['enddate'],6,2));
$astartdate = strtotime(substr($reportdata['startdate'],0,4)."-".substr($reportdata['startdate'],4,2)."-".substr($reportdata['startdate'],6,2));
$datediff = $aenddate - $astartdate;
$noofdays = number_format($datediff/(60*60*24),0);
$noofdays=trim(str_replace(",","",$noofdays));
$total_noofdays+=$noofdays;
?>

<?php
$aenddate = strtotime(substr($reportdata['startdate'],0,4)."-".substr($reportdata['startdate'],4,2)."-".substr($reportdata['startdate'],6,2));
$tlbdate = strtotime(substr($reportdata['lastdate'],0,4)."-".substr($reportdata['lastdate'],4,2)."-".substr($reportdata['lastdate'],6,2));
//$aenddate = strtotime(substr($reportdata['enddate'],0,4)."-".substr($reportdata['enddate'],4,2)."-".substr($reportdata['enddate'],6,2));
//$tlbdate = strtotime(substr($reportdata['lastdate'],0,4)."-".substr($reportdata['lastdate'],4,2)."-".substr($reportdata['lastdate'],6,2));
$datediff = $tlbdate-$aenddate ;
$timeElps = number_format($datediff/(60*60*24),0);
$total_timeElps+=$timeElps;
$i++;
?>
<?php if($to_date_progress>$reportdata['amount'])
{
$bgcolor="#FF0000";
}?>
<tr style="background-color:<?php echo $bgcolor;?>;">
<td style="text-align:center;"><?php echo $i;?> </td>
<td style="text-align:center;"><?php echo $codeData['code']; ?></td>
<td style="text-align:left;"><?php echo $reportdata['activityname']; ?></td>
<td style="text-align:right;"> <?php echo number_format(($reportdata['amount']),2); 
$grand_total+=$reportdata['amount'];?></td>
<td align="left" style="min-width:75px"><?php if($reportdata['startdate']!=""){									
$time = strtotime($reportdata['startdate']);
$Date = date( 'd-M-Y', $time );
echo $Date;
} ?> </td>
<td style="text-align:right;">&nbsp;</td>
<td style="text-align:left; min-width:75px"><?php if($reportdata['enddate']!=""){									
$time = strtotime($reportdata['enddate']);
$Date = date( 'd-M-Y', $time );
echo $Date;
}?></td>
<td style="text-align:right;">&nbsp;  </td>
<td style="text-align:right;"> <?php echo $noofdays; ?>  </td>
<td style="text-align:right;">&nbsp;  </td>
<td style="text-align:right;"><?php  if($timeElps<0)
										{
										$timeElps=0;
										echo "0" ;
										}
										else
										{
										echo $timeElps;
										}?> </td>
<td style="text-align:right;">&nbsp;  </td>
<td style="text-align:right;"> <?php 
									echo number_format($uptolast_month_progress,2);
									?> </td>
<td style="text-align:right;"><?php echo number_format(($this_month_progress),2); ?></td>
<td style="text-align:right;"><?php 
						
										echo number_format(($to_date_progress),2);
										 ?></td>
<td style="text-align:right;"> <?php if($reportdata['amount']!=0)
{
	echo  number_format (($to_date_progress  / $reportdata['amount']*100),2);
}else
{
	echo  number_format (0,2);
	}?></td>
<td style="text-align:right;">  <?php 
									
									
									echo number_format ($planned_progress,2); ?></td>
<td style="text-align:right;"> <?php if($to_date_progress!=0&&$planned_progress!=0)
										{
										$SPI=$to_date_progress/$planned_progress;
									     echo number_format($SPI,2);
										 }
										 else
										 {
										 echo "0.0";} ?></td>
</tr>




<?php
}
?>
<tr align="right" id="grand_total">
<td colspan="3" align="right">
<strong>Grand Total:
</strong></td>
<td align="right">
<?php echo number_format($grand_total,2);?>
</td>
<td align="left" style="min-width:75px">
<?php $yr=substr($mindate,0,4);
$month=substr($mindate,4,-2);
$day=substr($mindate,6,8);
if($mindate!="")
{									
$time = strtotime($mindate);
$Date = date( 'd-m-Y', $time );
echo $Date;
}?> 
</td>
<td>
<?php //echo $maxdate;?> 
</td>
<td align="left" style="min-width:75px">
<?php $yr=substr($maxdate,0,4);
$month=substr($maxdate,4,-2);
$day=substr($maxdate,6,8);
if($maxdate!="")
{	
$time = strtotime($mindate);
$Date = date( 'd-m-Y', $time );
echo $Date;								
}
?> 
</td>
<td>
<?php //echo $total_noofdays;?> 
</td>
<td>
<?php $mindate=str_replace("/","-",$mindate);
      
      $maxdate=str_replace("/","-",$maxdate);
	  
	  echo $ress=dateDiff($mindate,$maxdate);?> 
</td>
<td>
<?php //echo $mindate;?> 
</td>
<td>
<?php echo $timeElps;?> 
</td>
<td>
<?php //echo $mindate;?> 
</td>
<td>
<?php echo  number_format($total_uptolast_month_progress,2);?>
</td>
<td align="right">
<?php echo  number_format($total_this_month_progress,2);?>
</td>
<td align="right">
<?php echo  number_format($total_progress,2);?>
</td>
<td align="right">
<?php echo  number_format(($total_progress/$grand_total*100),2);?>
</td>
<td align="right">
<?php echo  number_format($total_planned_progress,2);?>
</td>
<td align="right">
<?php if($total_progress!=0&&$total_planned_progress!=0)
{
 echo  number_format(($total_progress/$total_planned_progress),2);
 }
 else
 {
echo "0.0";
}
?>
</td>
</tr>
</table>
<?php }
else
{?>
<table id="tblList" cellpadding="0px" cellspacing="0px"   width="98%" align="center" >
<tr  id="title">
<td colspan="15" align="center"><span class="white"><strong>General Report At Sub-Component Level(<?php echo $subcomponentid; ?>)</strong></span><span style="position:absolute; padding-left:250px">  <a style="text-decoration:none;color:#ffffff" href="javascript:void(null);" onclick="window.open('printsubcomponent_report.php?subcomponentid=<?php echo $subcomponentid;?>&projectid=<?php echo $projectid;?>&activitytypeid=<?php echo $activitytypeid;?>&componentid=<?php echo $componentid;?>', 'INV', 'width=1120,height=550,scrollbars=yes');" ><img src="images/ico_print.gif" border="0" /> Print Report</a></span>
  </th></tr>
<tr id="tblHeading">
<th rowspan="2" width="44"> Sr. No.</th>
      <th rowspan="2" width="207" align="left"> Activity / Sub-activity </th>
    <th rowspan="2" width="34">Unit</th>
    <th rowspan="2" width="57"> Total Target </th>
    <th colspan="2">Starting Date</th>
    <th colspan="2">  date of Completion</th>
    <th width="63" rowspan="2">Schedule Number Of days</th>
    <th width="63" rowspan="2">days Elapsed</th>
    <th width="63" rowspan="2"> % Time Elapsed</th>
    <th colspan="4">Progress</th>
    </tr>
  <tr id="tblHeading">
    <th width="87">Scheduled </th>
    <th width="70">Actual</th>
    <th width="88">Scheduled</th>
    <th width="75">Actual</th>
    <th width="50">Up to Last Month</th>
    <th width="60">During Month</th>
    <th width="73">To Date Progress</th>
    <th width="75">Up to Date % Progress</th>
  </tr>
<tr >
<td align="center">&nbsp;</td>
<td style="text-align:center;" >1</td>
<td style="text-align:center;">2</td>
<td style="text-align:center;">3</td>
<td style="text-align:center;">4</td>
<td style="text-align:center;">5</td>
<td style="text-align:center;">6</td>
<td style="text-align:center;">7</td>
<td style="text-align:center;">8</td>
<td style="text-align:center;">9</td>
<td style="text-align:center;">10</td>
<td style="text-align:center;">11</td>
<td style="text-align:center;">12</td>
<td style="text-align:center;">13</td>
<td style="text-align:center;">14</td>
</tr>
<?php

function getActivityProgressAmount($cid,$sid,$sa_id,$s_id,$aid)
{
 
$sql2="SELECT sa_id,sum( pqty * prs ) AS tamount, max( bdate ) AS lastdate
FROM `progress` 
WHERE sa_id =".$sa_id." AND cid=".$cid." AND sid=".$sid." AND s_id=".$s_id." AND aid=".$aid." GROUP BY sa_id";
$pamountresult3 = mysql_query($sql2)or die(mysql_error());
$pdata=mysql_fetch_array($pamountresult3);
return $pdata;
}
function getCode_new($sa_id)
{
 $sql="SELECT code FROM  `subactivity` where sa_id=".$sa_id;
 
$amountresult = mysql_query($sql);
//echo $amountsize= mysql_num_rows($amountresult);
$data=mysql_fetch_array($amountresult);

return $data;
}
function getSubActivityVariationData($sa_id)
{ 
$sql2="SELECT sum(vd.vqty) As tvqty, sum(vd.vrate*cc.quantity) as variation_in_rate_amount, sum(vd.vqty*dd.prs) as variation_in_qty_amount,sum(vd.`vamount`) as variation_in_amount,vd.`vo_id`,vd.`contigency_code`,vd.`vono`,vd.`vodate`,vd.`bid`,vd.`remark`,vd.`vstatus`,vd.`bdate`
FROM variationdata vd
LEFT OUTER JOIN (subactivitydata cc) on (vd.sa_id = cc.sa_id) 
LEFT OUTER JOIN (progressdata dd) on (vd.sa_id = dd.sa_id) where cc.sa_id=".$sa_id." GROUP BY cc.sa_id";
$pamountresultp = mysql_query($sql2)or die(mysql_error());
$pgdata=mysql_fetch_array($pamountresultp);
return $pgdata;
}
function getThisMonthSubactivityVariationData($sa_id,$bid)
{ 
 $sql2="SELECT sum(vd.vqty) As lvqty, sum(vd.vrate*cc.quantity) as last_variation_in_rate_amount, sum(vd.vqty*dd.prs) as last_variation_in_qty_amount,sum(vd.`vamount`) as last_variation_in_amount,vd.`vo_id`,vd.`contigency_code`,vd.`vono`,vd.`vodate`,vd.`bid`,vd.`remark`,vd.`vstatus`,vd.`bdate`
FROM variationdata vd
LEFT OUTER JOIN (subactivitydata cc) on (vd.sa_id = cc.sa_id)
LEFT OUTER JOIN (progressdata dd) on (vd.sa_id = dd.sa_id) where cc.sa_id=".$sa_id." AND vd.bid=".$bid." GROUP BY cc.sa_id";
$pamountresultp = mysql_query($sql2)or die(mysql_error());
$pgdata=mysql_fetch_array($pamountresultp);
return $pgdata;
}
function LastMonthProgressDate()
{
$sql="SELECT  MIN(bdate) as lastMonthdate,bid FROM  `progressmonth` Group by bid order by bid ASC";
$amountresult = mysql_query($sql);
//echo $amountsize= mysql_num_rows($amountresult);
$data=mysql_fetch_array($amountresult);
return $data;
}
function ThisMonthProgressDate()
{
$sql="SELECT  MAX(bdate) as lastMonthdate,bid FROM  `progressmonth` Group by bid order by bid desc";
$amountresult = mysql_query($sql);
//echo $amountsize= mysql_num_rows($amountresult);
$data=mysql_fetch_array($amountresult);
return $data;
}
$this_month_data=ThisMonthProgressDate();
 $this_month_bid=$this_month_data["bid"];
$reportquerynew ="SELECT  ca.cid,sum(cc.lqty) as lqty, sum(cc.lqty*ca.rates) as lastamount,ca.subactivityname,ca.aid,ca.s_id,ca.sa_id,ca.sid,ca.startdate,ca.units,  ca.actual_stardate,ca.actual_enddate,min(ca.startdate) as mindate, ca.enddate, max(ca.enddate) as maxdate,  ca.quantity, ca.rates, cb.pqty, sum(cb.pqty) as tpqty,sum(ca.quantity*ca.rates) as amount, sum(ca.quantity) as tqty ,sum(cb.pamount)As totalamount,cb.pamount, cb.lbdate as lastdate , cb.prs FROM subactivitydata ca 
LEFT OUTER join (progressdata cb)
on (ca.sa_id = cb.sa_id )
LEFT OUTER join (lastmonthdata cc) 
on (cb.sa_id = cc.sa_id)Where ca.sid=".$activitytypeid." AND ca.s_id=".$subcomponentid."  GROUP BY ca.aid ORDER BY ca.sub_order, ca.sa_id" ;

/*$reportquerynew ="SELECT ca.subactivityname,ca.aid,ca.s_id,ca.sa_id,ca.sid,ca.startdate,ca.units, min(ca.startdate) as mindate, ca.enddate, max(ca.enddate) as maxdate,  ca.quantity, ca.rates,sum(ca.quantity*ca.rates) as amount, sum(ca.quantity) as tqty ,sum(vd.vqty) As tvqty, sum(vd.vrate*ca.quantity) as variation_in_rate_amount, sum(vd.vqty*ca.rates) as variation_in_qty_amount,sum(vd.`vamount`) as variation_in_amount,vd.`vo_id`,vd.`contigency_code`,vd.`vono`,vd.`vodate`,vd.`bid`,vd.`remark`,vd.`vstatus`,vd.`bdate`
FROM variationdata vd
LEFT OUTER JOIN (subactivitydata ca) on (vd.sa_id = ca.sa_id) where ca.aid=".$reportdata['aid']." GROUP BY ca.sa_id";*/
$reportresult_act = mysql_query($reportquerynew)or die(mysql_error());
while ($reportdata_act = mysql_fetch_array($reportresult_act)) {
 $bgcolor = ($bgcolor == "#FFFFFF") ? "#EAF4FF" : "#FFFFFF";
/*$bgcolor = ($bgcolor == "#FF9999") ? "#FFD5D5" : "#FF9999";*/
$variation_data_sub=getSubActivityVariationData($reportdata_act['sa_id']);
$variation_this_data_sub=getThisMonthSubactivityVariationData($reportdata_act['sa_id'],$this_month_bid);

$upto_last_variation=$variation_data_sub['tvqty']-$variation_this_data_sub['lvqty'];
$total_amount_act=$reportdata_act['amount'];
$last_amount=$reportdata_act['lastamount'];
$grand_last_amount+=$last_amount;
$grand_total+=$total_amount_act;
$codeData_new=getCode_new($reportdata_act['sa_id']);
$total_qty=$variation_data_sub['tvqty']+$reportdata_act['tpqty'];
$last_progress_qty=$reportdata_act['tpqty']-$reportdata_act['lqty'];
$total_last_qty=$upto_last_variation+$last_progress_qty; //lqty is during this month qty
if($variation_data_sub['vrate']==0)
{
$this_month_act=(($reportdata_act['lqty'] + $variation_this_data_sub['lvqty']) * $reportdata_act['prs']);
}
else
{
$this_month_act=(($reportdata_act['lqty'] + $variation_this_data_sub['lvqty']) * $variation_data_sub['vrate']);
}
$this_month_act_total+=$this_month_act;
if($variation_last_data_sub['vrate']==0)
{
$last_month_act=($total_last_qty) * $reportdata_act['prs'];
}
else
{
$last_month_act=($total_last_qty) * $variation_last_data_sub['vrate'];
}
$last_month_act_total+=$last_month_act;
if($variation_data_sub['vrate']==0)
{
$total_month=($total_qty) * $reportdata_act['prs'];
}
else
{
$total_month=($total_qty) * $variation_data_sub['vrate'];
}
$total_month_total+=$total_month;
?>
<?php if($variation_data_sub['tvqty']>0)
{
$bgcolor="#FF0000";
}
$mindate=$reportdata_act["mindate"];
$maxdate=$reportdata_act["maxdate"];
//$codeData=getCode($reportdata['sa_id']);
//$SubComponentData=getSubComponentProgressAmount($componentid,$reportdata['sid'],$reportdata['sa_id'],$reportdata['s_id']); /////SubComponentProgressAmount
/*$this_month_progress=getThisMonthSubComponentProgress($componentid,$reportdata['sid'],$reportdata['sa_id'],$reportdata['s_id']);
$current_month_progress=$this_month_progress['cprogress'];*/
$total_current_month_progress+=$reportdata_act['lastamount'];
?>
<?php
$aenddate = strtotime(substr($reportdata_act['enddate'],0,4)."-".substr($reportdata_act['enddate'],4,2)."-".substr($reportdata_act['enddate'],6,2));
$astartdate = strtotime(substr($reportdata_act['startdate'],0,4)."-".substr($reportdata_act['startdate'],4,2)."-".substr($reportdata_act['startdate'],6,2));
$datediff = $aenddate - $astartdate;
$noofdays = number_format($datediff/(60*60*24),0);
$noofdays=trim(str_replace(",","",$noofdays));
$total_noofdays+=$noofdays;
?>

<?php
$aenddate = strtotime(substr($reportdata_act['startdate'],0,4)."-".substr($reportdata_act['startdate'],4,2)."-".substr($reportdata_act['startdate'],6,2));
$tlbdate = strtotime(substr($reportdata_act['lastdate'],0,4)."-".substr($reportdata_act['lastdate'],4,2)."-".substr($reportdata_act['lastdate'],6,2));
//$aenddate = strtotime(substr($reportdata['enddate'],0,4)."-".substr($reportdata['enddate'],4,2)."-".substr($reportdata['enddate'],6,2));
//$tlbdate = strtotime(substr($reportdata['lastdate'],0,4)."-".substr($reportdata['lastdate'],4,2)."-".substr($reportdata['lastdate'],6,2));
$datediff = $tlbdate-$aenddate ;
$timeElps = number_format($datediff/(60*60*24),0);
$total_timeElps+=$timeElps;
$i++;
$upto_last_month_progress=$reportdata_act['totalamount']-$reportdata_act['lastamount'];
$total_upto_last_month_progress+=$upto_last_month_progress;
$to_date_progress=$reportdata_act['lastamount']+$upto_last_month_progress;
$total_progress+=$to_date_progress;
?>
<tr style="background-color:<?php echo $bgcolor;?>;">
<td style="text-align:center;"><?php echo $i;?> </td>
<td ><span style="text-align:left;"><?php echo $codeData_new['code'].".&nbsp;".$reportdata_act['subactivityname']; ?></span></td>
<td style="text-align:left;"><span style="text-align:center;"><?php echo $reportdata_act['units']; ?></span></td>
<td style="text-align:right;"><?php  echo number_format (($reportdata_act['tqty'] * $reportdata_act['rates']),2) ; ?></td>
<td align="left" style="min-width:75px"><?php if($reportdata_act['startdate']!=""){									
$time = strtotime($reportdata_act['startdate']);
$Date = date( 'd-M-Y', $time );
echo $Date;
} ?> </td>
<td style="text-align:right;"><?php if($reportdata_act['actual_stardate']!=""){									
$time = strtotime($reportdata_act['actual_stardate']);
$Date = date( 'd-M-Y', $time );
echo $Date;
} ?> </td>
<td style="text-align:left; min-width:75px"><?php if($reportdata_act['enddate']!=""){									
$time = strtotime($reportdata_act['enddate']);
$Date = date( 'd-M-Y', $time );
echo $Date;
}?> </td>
<td style="text-align:left; min-width:75px"><?php if($reportdata_act['actual_enddate']!=""){									
$time = strtotime($reportdata_act['actual_enddate']);
$Date = date( 'd-M-Y', $time );
echo $Date;
} ?> </td>
<td style="text-align:right;"><?php echo $noofdays; ?></td>
<td style="text-align:right;"><?php  if($timeElps<0)
										{
										$timeElps=0;
										echo "0" ;
										}
										else
										{
										if($reportdata_act['lastdate']>$reportdata_act['enddate'])
										{
										$timeElps=0;
										echo $timeElps;
										}
										else
										{
										echo $timeElps;
										}
										}?></td>
<td style="text-align:right;"><?php 
								if($reportdata_act['lastdate']>$reportdata_act['enddate'])
										{
										$p_time_elapsed=100;
										echo $p_time_elapsed;
										}
										else
										{
										$p_time_elapsed=($timeElps/$noofdays)*100;
										echo number_format(($timeElps/$noofdays)*100,2);
										}
								
								?></td>
<td style="text-align:right;"><?php  echo number_format (($last_month_act),2) ; ?></td>
<td style="text-align:right;"><?php  echo number_format($this_month_act,2) ; ?></td>
<td style="text-align:right;"><?php  echo number_format (($total_month),2) ; ?></td>
<td style="text-align:right;"><?php  if($reportdata_act['tpqty']!=0 && $reportdata_act['tqty']!=0)
{
echo number_format((($total_qty / $reportdata_act['tqty'])*100),2);
}
else
{
echo "0.0";
} ?></td>
</tr>




<?php
}
?>
<tr align="right" id="grand_total">
<td colspan="3" align="right">
<strong>Grand Total:</strong></td>
<td align="right"><span style="text-align:right;">
  <?php  
echo number_format ($grand_total,2); ?>
</span></td>
<td align="left" style="min-width:75px">
<?php $yr=substr($mindate,0,4);
$month=substr($mindate,4,-2);
$day=substr($mindate,6,8);
if($mindate!="")
{									
$time = strtotime($mindate);
$Date = date( 'd-M-Y', $time );
echo $Date;
}?></td>
<td>
<?php //echo $maxdate;?></td>
<td align="left" style="min-width:75px">
<?php $yr=substr($maxdate,0,4);
$month=substr($maxdate,4,-2);
$day=substr($maxdate,6,8);
if($maxdate!="")
{	
$time = strtotime($maxdate);
$Date = date( 'd-M-Y', $time );
echo $Date;								
}
?></td>
<td align="left" style="min-width:75px">&nbsp;</td>
<td><?php $mindate=str_replace("/","-",$mindate);
      
      $maxdate=str_replace("/","-",$maxdate);
	  
	  echo $ress=dateDiff($mindate,$maxdate);?></td>
<td>
<?php $mindate=str_replace("/","-",$mindate);
      
      $maxdate=str_replace("/","-",$maxdate);
	  
	  echo $ress=dateDiff($mindate,$maxdate);?></td>
<td>
<?php echo $timeElps;?></td>
<td><span style="text-align:right;">
  <?php  echo  number_format ($last_month_act_total,2) ; ?>
</span></td>
<td align="right"><span style="text-align:right;">
  <?php  echo number_format (($this_month_act_total),2) ; ?>
</span></td>
<td align="right"><span style="text-align:right;">
  <?php  echo  number_format ($total_month_total,2) ; ?>
</span></td>
<td align="right"><span style="text-align:right;">
  <?php  if($total_month_total!=0&&$grand_total!=0)
{
echo number_format((($total_month_total/$grand_total)*100),2);
}
else
{
echo "0.0";
} ?>
</span></td>
</tr>
</table>

<?php }?>
<?php
}
?>

</div>
<!-- Start Activity  Table here-->

<div id="result9">
<?php
if ($activityflag == 1 && $subactivityid == 0 ) {
$query="SELECT * FROM subcomponents where (sid=3 OR sid=4) and cid=".$componentid;
$queryresult = mysql_query($query);
$numrows=mysql_num_rows($queryresult);
if($numrows>0)
{
?>


<table id="tblList" cellpadding="0px" cellspacing="0px"   width="98%" align="center" >
<tr  id="title">
<td colspan="18" align="center"><span class="white"><strong>General Report At Activity Level (<?php echo $activityid; ?>)</strong></span> 
  </th>  
  <span style="position:absolute; padding-left:230px"> <a style="text-decoration:none;color:#ffffff" href="javascript:void(null);" onclick="window.open('printactivity_level_report.php?subcomponentid=<?php echo $subcomponentid;?>&projectid=<?php echo $projectid;?>&activitytypeid=<?php echo $activitytypeid;?>&componentid=<?php echo $componentid;?>&activityid=<?php echo $activityid;?>', 'INV', 'width=1120,height=550,scrollbars=yes');" ><img src="images/ico_print.gif" border="0" /> Print Report</a></span></tr>
<tr id="tblHeading">
<th rowspan="2"> Sr. No. </th>
<th rowspan="2">Description </th>
<th rowspan="2"> UOM </th>
<!--<th colspan="3">As Per Estimate</th>-->
<th colspan="3"> As Per Bid</th>
<th colspan="2">Paid Upoto Previous </th>
<th colspan="2">Due This Certificate </th>
<th colspan="2">(Executed) Upto Date </th>
<th rowspan="2"> % in Progress</th>
</tr>
<tr id="tblHeading">
<!--<th>Qty. (Units) </th>
<th>Rate </th>
<th> Amount</th>-->
<th>Qty. (Units) </th>
<th>Rate (Rs.) </th>
<th>Amount (Rs.) </th>
<th> Qty. (Units)</th>
<th> Amount(Rs.)</th>
<th> Qty. (Units)</th>
<th> Amount(Rs.)</th>
<th> Qty. (Units)</th>
<th> Amount(Rs.)</th>
</tr>
<?php

function getActivityProgressAmount($cid,$sid,$sa_id,$s_id,$aid)
{
 
$sql2="SELECT sa_id,sum( pqty * prs ) AS tamount, max( bdate ) AS lastdate
FROM `progress` 
WHERE sa_id =".$sa_id." AND cid=".$cid." AND sid=".$sid." AND s_id=".$s_id." AND aid=".$aid." GROUP BY sa_id";
$pamountresult3 = mysql_query($sql2)or die(mysql_error());
$pdata=mysql_fetch_array($pamountresult3);
return $pdata;
}
function getCode_new($sa_id)
{
 $sql="SELECT code FROM  `subactivity` where sa_id=".$sa_id;
 
$amountresult = mysql_query($sql);
//echo $amountsize= mysql_num_rows($amountresult);
$data=mysql_fetch_array($amountresult);

return $data;
}
function getSubActivityVariationData($sa_id)
{ 
$sql2="SELECT sum(vd.vqty) As tvqty, sum(vd.vrate*cc.quantity) as variation_in_rate_amount, sum(vd.vqty*dd.prs) as variation_in_qty_amount,sum(vd.`vamount`) as variation_in_amount,vd.`vo_id`,vd.`contigency_code`,vd.`vono`,vd.`vodate`,vd.`bid`,vd.`remark`,vd.`vstatus`,vd.`bdate`
FROM variationdata vd
LEFT OUTER JOIN (subactivitydata cc) on (vd.sa_id = cc.sa_id) 
LEFT OUTER JOIN (progressdata dd) on (vd.sa_id = dd.sa_id) where cc.sa_id=".$sa_id." GROUP BY cc.sa_id";
$pamountresultp = mysql_query($sql2)or die(mysql_error());
$pgdata=mysql_fetch_array($pamountresultp);
return $pgdata;
}
function getThisMonthSubactivityVariationData($sa_id,$bid)
{ 
 $sql2="SELECT sum(vd.vqty) As lvqty, sum(vd.vrate*cc.quantity) as last_variation_in_rate_amount, sum(vd.vqty*dd.prs) as last_variation_in_qty_amount,sum(vd.`vamount`) as last_variation_in_amount,vd.`vo_id`,vd.`contigency_code`,vd.`vono`,vd.`vodate`,vd.`bid`,vd.`remark`,vd.`vstatus`,vd.`bdate`
FROM variationdata vd
LEFT OUTER JOIN (subactivitydata cc) on (vd.sa_id = cc.sa_id)
LEFT OUTER JOIN (progressdata dd) on (vd.sa_id = dd.sa_id) where cc.sa_id=".$sa_id." AND vd.bid=".$bid." GROUP BY cc.sa_id";
$pamountresultp = mysql_query($sql2)or die(mysql_error());
$pgdata=mysql_fetch_array($pamountresultp);
return $pgdata;
}
function LastMonthProgressDate()
{
$sql="SELECT  MIN(bdate) as lastMonthdate,bid FROM  `progressmonth` Group by bid order by bid ASC";
$amountresult = mysql_query($sql);
//echo $amountsize= mysql_num_rows($amountresult);
$data=mysql_fetch_array($amountresult);
return $data;
}
function ThisMonthProgressDate()
{
$sql="SELECT  MAX(bdate) as lastMonthdate,bid FROM  `progressmonth` Group by bid order by bid desc";
$amountresult = mysql_query($sql);
//echo $amountsize= mysql_num_rows($amountresult);
$data=mysql_fetch_array($amountresult);
return $data;
}
$this_month_data=ThisMonthProgressDate();
 $this_month_bid=$this_month_data["bid"];
$reportquerynew ="SELECT  ca.cid,sum(cc.lqty) as lqty, sum(cc.lqty*ca.rates) as lastamount,ca.subactivityname,ca.aid,ca.s_id,ca.sa_id,ca.sid,ca.startdate,ca.units, min(ca.startdate) as mindate, ca.enddate, max(ca.enddate) as maxdate,  ca.quantity, ca.rates, cb.pqty, sum(cb.pqty) as tpqty,sum(ca.quantity*ca.rates) as amount, sum(ca.quantity) as tqty ,sum(cb.pamount)As totalamount,cb.pamount, cb.lbdate as lastdate , cb.prs FROM subactivitydata ca 
LEFT OUTER join (progressdata cb)
on (ca.sa_id = cb.sa_id )
LEFT OUTER join (lastmonthdata cc) 
on (cb.sa_id = cc.sa_id)Where ca.sid=".$activitytypeid." AND ca.s_id=".$subcomponentid." AND ca.aid=".$activityid." GROUP BY ca.sa_id";

/*$reportquerynew ="SELECT ca.subactivityname,ca.aid,ca.s_id,ca.sa_id,ca.sid,ca.startdate,ca.units, min(ca.startdate) as mindate, ca.enddate, max(ca.enddate) as maxdate,  ca.quantity, ca.rates,sum(ca.quantity*ca.rates) as amount, sum(ca.quantity) as tqty ,sum(vd.vqty) As tvqty, sum(vd.vrate*ca.quantity) as variation_in_rate_amount, sum(vd.vqty*ca.rates) as variation_in_qty_amount,sum(vd.`vamount`) as variation_in_amount,vd.`vo_id`,vd.`contigency_code`,vd.`vono`,vd.`vodate`,vd.`bid`,vd.`remark`,vd.`vstatus`,vd.`bdate`
FROM variationdata vd
LEFT OUTER JOIN (subactivitydata ca) on (vd.sa_id = ca.sa_id) where ca.aid=".$reportdata['aid']." GROUP BY ca.sa_id";*/
$reportresult_act = mysql_query($reportquerynew)or die(mysql_error());
while ($reportdata_act = mysql_fetch_array($reportresult_act)) {
 $bgcolor = ($bgcolor == "#FFFFFF") ? "#EAF4FF" : "#FFFFFF";
/*$bgcolor = ($bgcolor == "#FF9999") ? "#FFD5D5" : "#FF9999";*/

$variation_data_sub=getSubActivityVariationData($reportdata_act['sa_id']);
$variation_this_data_sub=getThisMonthSubactivityVariationData($reportdata_act['sa_id'],$this_month_bid);

$upto_last_variation=$variation_data_sub['tvqty']-$variation_this_data_sub['lvqty'];
$total_amount_act=$reportdata_act['amount'];
$last_amount=$reportdata_act['lastamount'];
$grand_last_amount+=$last_amount;
$grand_total+=$total_amount_act;
$codeData_new=getCode_new($reportdata_act['sa_id']);
$total_qty=$variation_data_sub['tvqty']+$reportdata_act['tpqty'];
$last_progress_qty=$reportdata_act['tpqty']-$reportdata_act['lqty'];
$total_last_qty=$upto_last_variation+$last_progress_qty; //lqty is during this month qty
if($variation_data_sub['vrate']==0)
{
$this_month_act=(($reportdata_act['lqty'] + $variation_this_data_sub['lvqty']) * $reportdata_act['prs']);
}
else
{
$this_month_act=(($reportdata_act['lqty'] + $variation_this_data_sub['lvqty']) * $variation_data_sub['vrate']);
}
$this_month_act_total+=$this_month_act;
if($variation_last_data_sub['vrate']==0)
{
$last_month_act=($total_last_qty) * $reportdata_act['prs'];
}
else
{
$last_month_act=($total_last_qty) * $variation_last_data_sub['vrate'];
}
$last_month_act_total+=$last_month_act;
if($variation_data_sub['vrate']==0)
{
$total_month=($total_qty) * $reportdata_act['prs'];
}
else
{
$total_month=($total_qty) * $variation_data_sub['vrate'];
}
$total_month_total+=$total_month;
?>
<?php if($variation_data_sub['tvqty']>0)
{
$bgcolor="#FF0000";
}?>
<tr style="background-color:<?php echo $bgcolor;?>;">
<td style="text-align:center;"><?php echo  $codeData_new['code']; ?></td>
<td style="text-align:left;"><?php   echo $reportdata_act['subactivityname']; ?></td>
<td style="text-align:center;"><?php echo $reportdata_act['units']; ?></td>
<?php /*?><td style="text-align:center;"><?php echo number_format($reportdata['quantity'],2); ?></td>
<td style="text-align:right;"><?php  echo number_format($reportdata['rates'],2); ?></td>
<td style="text-align:right;"><?php  echo number_format (($reportdata['quantity'] * $reportdata['rates']),2) ; ?></td><?php */?>
<td style="text-align:center;"><?php echo number_format($reportdata_act['tqty'],2); ?></td>
<td style="text-align:right;"><?php  echo number_format($reportdata_act['rates'],2); ?></td>
<td style="text-align:right;"><?php  echo number_format (($reportdata_act['tqty'] * $reportdata_act['rates']),2) ; ?></td>
<td style="text-align:center;"><?php echo number_format ($total_last_qty,2); ?></td>
<td style="text-align:right;"><?php  echo number_format (($last_month_act),2) ; ?></td>
<td style="text-align:center;"><?php echo number_format ($total_qty - $total_last_qty,2); ?></td>
<td style="text-align:right;"><?php  echo number_format($this_month_act,2) ; ?></td>
<td style="text-align:center;"><?php echo number_format ($total_qty,2); ?></td>   
<td style="text-align:right;"><?php  echo number_format (($total_month),2) ; ?></td>
<td style="text-align:right;"><?php  if($reportdata_act['tpqty']!=0 && $reportdata_act['tqty']!=0)
{
echo number_format((($total_qty / $reportdata_act['tqty'])*100),2);
}
else
{
echo "0.0";
} ?></td>
</tr>

<?php
}
?>
<tr align="right" id="grand_total">
<td style="text-align:right;" colspan="5"><strong><?php echo  "Grand Total:"; ?></strong></td>
<?php /*?><td style="text-align:center;"><?php echo number_format ($grand_total,2); ?></td>
<td style="text-align:right;">&nbsp;</td>
<td style="text-align:right;">&nbsp;</td><?php */?>
<td style="text-align:right;"><?php  
echo number_format ($grand_total,2); ?></td>
<td style="text-align:center;">&nbsp;</td>
<td style="text-align:right;"><?php  echo  number_format ($last_month_act_total,2) ; ?></td>
<td style="text-align:center;">&nbsp;</td>
<td style="text-align:right;"><?php  echo number_format (($this_month_act_total),2) ; ?></td>
<td style="text-align:center;">&nbsp;</td>   
<td style="text-align:right;"><?php  echo  number_format ($total_month_total,2) ; ?></td>
<td style="text-align:right;"><?php  if($total_month_total!=0&&$grand_total!=0)
{
echo number_format((($total_month_total/$grand_total)*100),2);
}
else
{
echo "0.0";
} ?></td>
</tr>
</table> <!--///New-->
<?php
}
else
{
?>

<table id="tblList" cellpadding="0px" cellspacing="0px"   width="98%" align="center" >
<tr  id="title">
<td colspan="15" align="center"><span class="white"><strong>General Report At Activity Level(<?php echo $subcomponentid; ?>)</strong> 
 </span> </th></tr>
<tr id="tblHeading">
<th rowspan="2" width="46"> Sr. No.</th>
      <th rowspan="2" width="37"> Unit </th>
    <th rowspan="2" width="159">Activity / Sub-activity</th>
    <th rowspan="2" width="53"> Total Target </th>
    <th colspan="2">Starting Date</th>
    <th colspan="2">  date of Completion</th>
    <th width="68" rowspan="2">Schedule Number Of days</th>
    <th width="63" rowspan="2">days Elapsed</th>
    <th width="63" rowspan="2"> % Time Elapsed</th>
    <th colspan="4">Progress</th>
    </tr>
  <tr id="tblHeading">
    <th width="94">Scheduled </th>
    <th width="81">Actual</th>
    <th width="83">Scheduled</th>
    <th width="51">Actual</th>
    <th width="54">Up to Last Month</th>
    <th width="60">During Month</th>
    <th width="72">To Date Progress</th>
    <th width="84">Up to Date % Progress</th>
  </tr>
<tr >
<td align="center">&nbsp;</td>
<td style="text-align:center;" >1</td>
<td style="text-align:center;">2</td>
<td style="text-align:center;">3</td>
<td style="text-align:center;">4</td>
<td style="text-align:center;">5</td>
<td style="text-align:center;">6</td>
<td style="text-align:center;">7</td>
<td style="text-align:center;">8</td>
<td style="text-align:center;">9</td>
<td style="text-align:center;">10</td>
<td style="text-align:center;">11</td>
<td style="text-align:center;">12</td>
<td style="text-align:center;">13</td>
<td style="text-align:center;">14</td>
</tr>

<?php

function getActivityProgressAmount($cid,$sid,$sa_id,$s_id,$aid)
{
 
$sql2="SELECT sa_id,sum( pqty * prs ) AS tamount, max( bdate ) AS lastdate
FROM `progress` 
WHERE sa_id =".$sa_id." AND cid=".$cid." AND sid=".$sid." AND s_id=".$s_id." AND aid=".$aid." GROUP BY sa_id";
$pamountresult3 = mysql_query($sql2)or die(mysql_error());
$pdata=mysql_fetch_array($pamountresult3);
return $pdata;
}
function getCode_new($sa_id)
{
 $sql="SELECT code FROM  `subactivity` where sa_id=".$sa_id;
 
$amountresult = mysql_query($sql);
//echo $amountsize= mysql_num_rows($amountresult);
$data=mysql_fetch_array($amountresult);

return $data;
}
function getSubActivityVariationData($sa_id)
{ 
$sql2="SELECT sum(vd.vqty) As tvqty, sum(vd.vrate*cc.quantity) as variation_in_rate_amount, sum(vd.vqty*dd.prs) as variation_in_qty_amount,sum(vd.`vamount`) as variation_in_amount,vd.`vo_id`,vd.`contigency_code`,vd.`vono`,vd.`vodate`,vd.`bid`,vd.`remark`,vd.`vstatus`,vd.`bdate`
FROM variationdata vd
LEFT OUTER JOIN (subactivitydata cc) on (vd.sa_id = cc.sa_id) 
LEFT OUTER JOIN (progressdata dd) on (vd.sa_id = dd.sa_id) where cc.sa_id=".$sa_id." GROUP BY cc.sa_id";
$pamountresultp = mysql_query($sql2)or die(mysql_error());
$pgdata=mysql_fetch_array($pamountresultp);
return $pgdata;
}
function getThisMonthSubactivityVariationData($sa_id,$bid)
{ 
 $sql2="SELECT sum(vd.vqty) As lvqty, sum(vd.vrate*cc.quantity) as last_variation_in_rate_amount, sum(vd.vqty*dd.prs) as last_variation_in_qty_amount,sum(vd.`vamount`) as last_variation_in_amount,vd.`vo_id`,vd.`contigency_code`,vd.`vono`,vd.`vodate`,vd.`bid`,vd.`remark`,vd.`vstatus`,vd.`bdate`
FROM variationdata vd
LEFT OUTER JOIN (subactivitydata cc) on (vd.sa_id = cc.sa_id)
LEFT OUTER JOIN (progressdata dd) on (vd.sa_id = dd.sa_id) where cc.sa_id=".$sa_id." AND vd.bid=".$bid." GROUP BY cc.sa_id";
$pamountresultp = mysql_query($sql2)or die(mysql_error());
$pgdata=mysql_fetch_array($pamountresultp);
return $pgdata;
}
function LastMonthProgressDate()
{
$sql="SELECT  MIN(bdate) as lastMonthdate,bid FROM  `progressmonth` Group by bid order by bid ASC";
$amountresult = mysql_query($sql);
//echo $amountsize= mysql_num_rows($amountresult);
$data=mysql_fetch_array($amountresult);
return $data;
}
function ThisMonthProgressDate()
{
$sql="SELECT  MAX(bdate) as lastMonthdate,bid FROM  `progressmonth` Group by bid order by bid desc";
$amountresult = mysql_query($sql);
//echo $amountsize= mysql_num_rows($amountresult);
$data=mysql_fetch_array($amountresult);
return $data;
}
$this_month_data=ThisMonthProgressDate();
 $this_month_bid=$this_month_data["bid"];
$reportquerynew ="SELECT  ca.cid,sum(cc.lqty) as lqty, sum(cc.lqty*ca.rates) as lastamount,ca.subactivityname,ca.aid,ca.s_id,ca.sa_id,ca.sid,ca.startdate,ca.units,  ca.actual_stardate,ca.actual_enddate,min(ca.startdate) as mindate, ca.enddate, max(ca.enddate) as maxdate,  ca.quantity, ca.rates, cb.pqty, sum(cb.pqty) as tpqty,sum(ca.quantity*ca.rates) as amount, sum(ca.quantity) as tqty ,sum(cb.pamount)As totalamount,cb.pamount, cb.lbdate as lastdate , cb.prs FROM subactivitydata ca 
LEFT OUTER join (progressdata cb)
on (ca.sa_id = cb.sa_id )
LEFT OUTER join (lastmonthdata cc) 
on (cb.sa_id = cc.sa_id)Where ca.sid=".$activitytypeid." AND ca.s_id=".$subcomponentid." AND ca.aid=".$activityid." GROUP BY ca.sa_id ORDER BY ca.sub_order, ca.sa_id";

/*$reportquerynew ="SELECT ca.subactivityname,ca.aid,ca.s_id,ca.sa_id,ca.sid,ca.startdate,ca.units, min(ca.startdate) as mindate, ca.enddate, max(ca.enddate) as maxdate,  ca.quantity, ca.rates,sum(ca.quantity*ca.rates) as amount, sum(ca.quantity) as tqty ,sum(vd.vqty) As tvqty, sum(vd.vrate*ca.quantity) as variation_in_rate_amount, sum(vd.vqty*ca.rates) as variation_in_qty_amount,sum(vd.`vamount`) as variation_in_amount,vd.`vo_id`,vd.`contigency_code`,vd.`vono`,vd.`vodate`,vd.`bid`,vd.`remark`,vd.`vstatus`,vd.`bdate`
FROM variationdata vd
LEFT OUTER JOIN (subactivitydata ca) on (vd.sa_id = ca.sa_id) where ca.aid=".$reportdata['aid']." GROUP BY ca.sa_id";*/
$reportresult_act = mysql_query($reportquerynew)or die(mysql_error());
while ($reportdata_act = mysql_fetch_array($reportresult_act)) {
 $bgcolor = ($bgcolor == "#FFFFFF") ? "#EAF4FF" : "#FFFFFF";
/*$bgcolor = ($bgcolor == "#FF9999") ? "#FFD5D5" : "#FF9999";*/
$variation_data_sub=getSubActivityVariationData($reportdata_act['sa_id']);
$variation_this_data_sub=getThisMonthSubactivityVariationData($reportdata_act['sa_id'],$this_month_bid);

$upto_last_variation=$variation_data_sub['tvqty']-$variation_this_data_sub['lvqty'];
$total_amount_act=$reportdata_act['amount'];
$last_amount=$reportdata_act['lastamount'];
$grand_last_amount+=$last_amount;
$grand_total+=$total_amount_act;
$codeData_new=getCode_new($reportdata_act['sa_id']);
$total_qty=$variation_data_sub['tvqty']+$reportdata_act['tpqty'];
$last_progress_qty=$reportdata_act['tpqty']-$reportdata_act['lqty'];
$total_last_qty=$upto_last_variation+$last_progress_qty; //lqty is during this month qty
if($variation_data_sub['vrate']==0)
{
$this_month_act=(($reportdata_act['lqty'] + $variation_this_data_sub['lvqty']) * $reportdata_act['prs']);
}
else
{
$this_month_act=(($reportdata_act['lqty'] + $variation_this_data_sub['lvqty']) * $variation_data_sub['vrate']);
}
$this_month_act_total+=$this_month_act;
if($variation_last_data_sub['vrate']==0)
{
$last_month_act=($total_last_qty) * $reportdata_act['prs'];
}
else
{
$last_month_act=($total_last_qty) * $variation_last_data_sub['vrate'];
}
$last_month_act_total+=$last_month_act;
if($variation_data_sub['vrate']==0)
{
$total_month=($total_qty) * $reportdata_act['prs'];
}
else
{
$total_month=($total_qty) * $variation_data_sub['vrate'];
}
$total_month_total+=$total_month;
?>
<?php if($variation_data_sub['tvqty']>0)
{
$bgcolor="#FF0000";
}
$mindate=$reportdata_act["mindate"];
$maxdate=$reportdata_act["maxdate"];
//$codeData=getCode($reportdata['sa_id']);
//$SubComponentData=getSubComponentProgressAmount($componentid,$reportdata['sid'],$reportdata['sa_id'],$reportdata['s_id']); /////SubComponentProgressAmount
/*$this_month_progress=getThisMonthSubComponentProgress($componentid,$reportdata['sid'],$reportdata['sa_id'],$reportdata['s_id']);
$current_month_progress=$this_month_progress['cprogress'];*/
$total_current_month_progress+=$reportdata_act['lastamount'];
?>
<?php
$aenddate = strtotime(substr($reportdata_act['enddate'],0,4)."-".substr($reportdata_act['enddate'],4,2)."-".substr($reportdata_act['enddate'],6,2));
$astartdate = strtotime(substr($reportdata_act['startdate'],0,4)."-".substr($reportdata_act['startdate'],4,2)."-".substr($reportdata_act['startdate'],6,2));
$datediff = $aenddate - $astartdate;
$noofdays = number_format($datediff/(60*60*24),0);
$noofdays=trim(str_replace(",","",$noofdays));
$total_noofdays+=$noofdays;
?>

<?php
$aenddate = strtotime(substr($reportdata_act['startdate'],0,4)."-".substr($reportdata_act['startdate'],4,2)."-".substr($reportdata_act['startdate'],6,2));
$tlbdate = strtotime(substr($reportdata_act['lastdate'],0,4)."-".substr($reportdata_act['lastdate'],4,2)."-".substr($reportdata_act['lastdate'],6,2));
//$aenddate = strtotime(substr($reportdata['enddate'],0,4)."-".substr($reportdata['enddate'],4,2)."-".substr($reportdata['enddate'],6,2));
//$tlbdate = strtotime(substr($reportdata['lastdate'],0,4)."-".substr($reportdata['lastdate'],4,2)."-".substr($reportdata['lastdate'],6,2));
$datediff = $tlbdate-$aenddate ;
$timeElps = number_format($datediff/(60*60*24),0);
$total_timeElps+=$timeElps;
$i++;
$upto_last_month_progress=$reportdata_act['totalamount']-$reportdata_act['lastamount'];
$total_upto_last_month_progress+=$upto_last_month_progress;
$to_date_progress=$reportdata_act['lastamount']+$upto_last_month_progress;
$total_progress+=$to_date_progress;
?>
<tr style="background-color:<?php echo $bgcolor;?>;">
<td style="text-align:center;"><?php echo $i;?> </td>
<td style="text-align:center;"><?php echo $reportdata_act['units']; ?></td>
<td style="text-align:left;"><?php echo $codeData_new['code'].".&nbsp;".$reportdata_act['subactivityname']; ?></td>
<td style="text-align:right;"><?php  echo number_format (($reportdata_act['tqty'] * $reportdata_act['rates']),2) ; ?></td>
<td align="left" style="min-width:75px"><?php if($reportdata_act['startdate']!=""){									
$time = strtotime($reportdata_act['startdate']);
$Date = date( 'd-M-Y', $time );
echo $Date;
} ?> </td>
<td style="text-align:right;"><?php if($reportdata_act['actual_stardate']!=""){									
$time = strtotime($reportdata_act['actual_stardate']);
$Date = date( 'd-M-Y', $time );
echo $Date;
} ?> </td>
<td style="text-align:left; min-width:75px"><?php if($reportdata_act['enddate']!=""){									
$time = strtotime($reportdata_act['enddate']);
$Date = date( 'd-M-Y', $time );
echo $Date;
}?> </td>
<td style="text-align:left; min-width:75px"><?php if($reportdata_act['actual_enddate']!=""){									
$time = strtotime($reportdata_act['actual_enddate']);
$Date = date( 'd-M-Y', $time );
echo $Date;
} ?> </td>
<td style="text-align:right;"><?php echo $noofdays; ?></td>
<td style="text-align:right;"><?php  if($timeElps<0)
										{
										$timeElps=0;
										echo "0" ;
										}
										else
										{
										if($reportdata_act['lastdate']>$reportdata_act['enddate'])
										{
										$timeElps=0;
										echo $timeElps;
										}
										else
										{
										echo $timeElps;
										}
										}?></td>
<td style="text-align:right;"><?php 
								if($reportdata_act['lastdate']>$reportdata_act['enddate'])
										{
										$p_time_elapsed=100;
										echo $p_time_elapsed;
										}
										else
										{
										$p_time_elapsed=($timeElps/$noofdays)*100;
										echo number_format(($timeElps/$noofdays)*100,2);
										}
								
								?></td>
<td style="text-align:right;"><?php  echo number_format (($last_month_act),2) ; ?></td>
<td style="text-align:right;"><?php  echo number_format($this_month_act,2) ; ?></td>
<td style="text-align:right;"><?php  echo number_format (($total_month),2) ; ?></td>
<td style="text-align:right;"><?php  if($reportdata_act['tpqty']!=0 && $reportdata_act['tqty']!=0)
{
echo number_format((($total_qty / $reportdata_act['tqty'])*100),2);
}
else
{
echo "0.0";
} ?></td>
</tr>




<?php
}
?>
<tr align="right" id="grand_total">
<td colspan="3" align="right">
<strong>Grand Total:</strong></td>
<td align="right"><span style="text-align:right;">
  <?php  
echo number_format ($grand_total,2); ?>
</span></td>
<td align="left" style="min-width:75px">
<?php $yr=substr($mindate,0,4);
$month=substr($mindate,4,-2);
$day=substr($mindate,6,8);
if($mindate!="")
{									
$time = strtotime($mindate);
$Date = date( 'd-M-Y', $time );
echo $Date;
}?></td>
<td>
<?php //echo $maxdate;?></td>
<td align="left" style="min-width:75px">
<?php $yr=substr($maxdate,0,4);
$month=substr($maxdate,4,-2);
$day=substr($maxdate,6,8);
if($maxdate!="")
{	
$time = strtotime($maxdate);
$Date = date( 'd-M-Y', $time );
echo $Date;								
}
?></td>
<td align="left" style="min-width:75px">&nbsp;</td>
<td><?php $mindate=str_replace("/","-",$mindate);
      
      $maxdate=str_replace("/","-",$maxdate);
	  
	  echo $ress=dateDiff($mindate,$maxdate);?></td>
<td>
<?php $mindate=str_replace("/","-",$mindate);
      
      $maxdate=str_replace("/","-",$maxdate);
	  
	  echo $ress=dateDiff($mindate,$maxdate);?></td>
<td>
<?php echo $timeElps;?></td>
<td><span style="text-align:right;">
  <?php  echo  number_format ($last_month_act_total,2) ; ?>
</span></td>
<td align="right"><span style="text-align:right;">
  <?php  echo number_format (($this_month_act_total),2) ; ?>
</span></td>
<td align="right"><span style="text-align:right;">
  <?php  echo  number_format ($total_month_total,2) ; ?>
</span></td>
<td align="right"><span style="text-align:right;">
  <?php  if($total_month_total!=0&&$grand_total!=0)
{
echo number_format((($total_month_total/$grand_total)*100),2);
}
else
{
echo "0.0";
} ?>
</span></td>
</tr>
</table>
<?php }
}
?>
</div>

<!-- Start Sub Activity  Table here-->
<div id="result5">
<?php
if ($subactivityflag == 1) {
$query="SELECT * FROM subcomponents where (sid=3 OR sid=4) and cid=".$componentid;
$queryresult = mysql_query($query);
$numrows=mysql_num_rows($queryresult);
if($numrows>0)
{?>
<table id="tblList" cellpadding="0px" cellspacing="0px"   width="98%" align="center" >
<tr  id="title">
<td colspan="18" align="center"><span class="white"><strong>General Report At Sub-Activity Level (<?php echo $subactivityid; ?>)</strong></span> 
  </th>  
  <span style="position:absolute; padding-left:210px"> <a style="text-decoration:none;color:#ffffff" href="javascript:void(null);" onclick="window.open('printsubactivity_level_report.php?subcomponentid=<?php echo $subcomponentid;?>&amp;projectid=<?php echo $projectid;?>&amp;activitytypeid=<?php echo $activitytypeid;?>&amp;componentid=<?php echo $componentid;?>&amp;activityid=<?php echo $activityid;?>&amp;subactivityid=<?php echo $subactivityid;?>','INV','width=1120,height=550,scrollbars=yes');" ><img src="images/ico_print.gif" border="0" /> Print Report</a></span></tr>
<tr id="tblHeading">
<th rowspan="2"> Sr. No. </th>
<th rowspan="2">Description </th>
<th rowspan="2"> UOM </th>
<!--<th colspan="3">As Per Estimate</th>-->
<th colspan="3"> As Per Bid</th>
<th colspan="2">Paid Upoto Previous </th>
<th colspan="2">Due This Certificate </th>
<th colspan="2">(Executed) Upto Date </th>
<th rowspan="2"> % in Progress</th>
</tr>
<tr id="tblHeading">
<!--<th>Qty. (Units) </th>
<th>Rate </th>
<th> Amount</th>-->
<th>Qty. (Units) </th>
<th>Rate (Rs.) </th>
<th>Amount (Rs.) </th>
<th> Qty. (Units)</th>
<th> Amount(Rs.)</th>
<th> Qty. (Units)</th>
<th> Amount(Rs.)</th>
<th> Qty. (Units)</th>
<th> Amount(Rs.)</th>
</tr>
<?php

function getActivityProgressAmount($cid,$sid,$sa_id,$s_id,$aid)
{
 
$sql2="SELECT sa_id,sum( pqty * prs ) AS tamount, max( bdate ) AS lastdate
FROM `progress` 
WHERE sa_id =".$sa_id." AND cid=".$cid." AND sid=".$sid." AND s_id=".$s_id." AND aid=".$aid." GROUP BY sa_id";
$pamountresult3 = mysql_query($sql2)or die(mysql_error());
$pdata=mysql_fetch_array($pamountresult3);
return $pdata;
}
function getCode_new($sa_id)
{
 $sql="SELECT code FROM  `subactivity` where sa_id=".$sa_id;
 
$amountresult = mysql_query($sql);
//echo $amountsize= mysql_num_rows($amountresult);
$data=mysql_fetch_array($amountresult);

return $data;
}
function getSubActivityVariationData($sa_id)
{ 
$sql2="SELECT sum(vd.vqty) As tvqty, sum(vd.vrate*cc.quantity) as variation_in_rate_amount, sum(vd.vqty*dd.prs) as variation_in_qty_amount,sum(vd.`vamount`) as variation_in_amount,vd.`vo_id`,vd.`contigency_code`,vd.`vono`,vd.`vodate`,vd.`bid`,vd.`remark`,vd.`vstatus`,vd.`bdate`
FROM variationdata vd
LEFT OUTER JOIN (subactivitydata cc) on (vd.sa_id = cc.sa_id) 
LEFT OUTER JOIN (progressdata dd) on (vd.sa_id = dd.sa_id) where cc.sa_id=".$sa_id." GROUP BY cc.sa_id";
$pamountresultp = mysql_query($sql2)or die(mysql_error());
$pgdata=mysql_fetch_array($pamountresultp);
return $pgdata;
}
function getThisMonthSubactivityVariationData($sa_id,$bid)
{ 
 $sql2="SELECT sum(vd.vqty) As lvqty, sum(vd.vrate*cc.quantity) as last_variation_in_rate_amount, sum(vd.vqty*dd.prs) as last_variation_in_qty_amount,sum(vd.`vamount`) as last_variation_in_amount,vd.`vo_id`,vd.`contigency_code`,vd.`vono`,vd.`vodate`,vd.`bid`,vd.`remark`,vd.`vstatus`,vd.`bdate`
FROM variationdata vd
LEFT OUTER JOIN (subactivitydata cc) on (vd.sa_id = cc.sa_id)
LEFT OUTER JOIN (progressdata dd) on (vd.sa_id = dd.sa_id) where cc.sa_id=".$sa_id." AND vd.bid=".$bid." GROUP BY cc.sa_id";
$pamountresultp = mysql_query($sql2)or die(mysql_error());
$pgdata=mysql_fetch_array($pamountresultp);
return $pgdata;
}
function LastMonthProgressDate()
{
$sql="SELECT  MIN(bdate) as lastMonthdate,bid FROM  `progressmonth` Group by bid order by bid ASC";
$amountresult = mysql_query($sql);
//echo $amountsize= mysql_num_rows($amountresult);
$data=mysql_fetch_array($amountresult);
return $data;
}
function ThisMonthProgressDate()
{
$sql="SELECT  MAX(bdate) as lastMonthdate,bid FROM  `progressmonth` Group by bid order by bid desc";
$amountresult = mysql_query($sql);
//echo $amountsize= mysql_num_rows($amountresult);
$data=mysql_fetch_array($amountresult);
return $data;
}
$this_month_data=ThisMonthProgressDate();
 $this_month_bid=$this_month_data["bid"];
$reportquerynew ="SELECT  ca.cid,sum(cc.lqty) as lqty, sum(cc.lqty*ca.rates) as lastamount,ca.subactivityname,ca.aid,ca.s_id,ca.sa_id,ca.sid,ca.startdate,ca.units, min(ca.startdate) as mindate, ca.enddate, max(ca.enddate) as maxdate,  ca.quantity, ca.rates, cb.pqty, sum(cb.pqty) as tpqty,sum(ca.quantity*ca.rates) as amount, sum(ca.quantity) as tqty ,sum(cb.pamount)As totalamount,cb.pamount, cb.lbdate as lastdate , cb.prs FROM subactivitydata ca 
LEFT OUTER join (progressdata cb)
on (ca.sa_id = cb.sa_id )
LEFT OUTER join (lastmonthdata cc) 
on (cb.sa_id = cc.sa_id)Where ca.sid=".$activitytypeid." AND ca.s_id=".$subcomponentid." AND ca.aid=".$activityid." AND ca.sa_id=".$subactivityid." GROUP BY ca.sa_id";

/*$reportquerynew ="SELECT ca.subactivityname,ca.aid,ca.s_id,ca.sa_id,ca.sid,ca.startdate,ca.units, min(ca.startdate) as mindate, ca.enddate, max(ca.enddate) as maxdate,  ca.quantity, ca.rates,sum(ca.quantity*ca.rates) as amount, sum(ca.quantity) as tqty ,sum(vd.vqty) As tvqty, sum(vd.vrate*ca.quantity) as variation_in_rate_amount, sum(vd.vqty*ca.rates) as variation_in_qty_amount,sum(vd.`vamount`) as variation_in_amount,vd.`vo_id`,vd.`contigency_code`,vd.`vono`,vd.`vodate`,vd.`bid`,vd.`remark`,vd.`vstatus`,vd.`bdate`
FROM variationdata vd
LEFT OUTER JOIN (subactivitydata ca) on (vd.sa_id = ca.sa_id) where ca.aid=".$reportdata['aid']." GROUP BY ca.sa_id";*/
$reportresult_act = mysql_query($reportquerynew)or die(mysql_error());
while ($reportdata_act = mysql_fetch_array($reportresult_act)) {
 $bgcolor = ($bgcolor == "#FFFFFF") ? "#EAF4FF" : "#FFFFFF";
/*$bgcolor = ($bgcolor == "#FF9999") ? "#FFD5D5" : "#FF9999";*/
$variation_data_sub=getSubActivityVariationData($reportdata_act['sa_id']);
$variation_this_data_sub=getThisMonthSubactivityVariationData($reportdata_act['sa_id'],$this_month_bid);

$upto_last_variation=$variation_data_sub['tvqty']-$variation_this_data_sub['lvqty'];
$total_amount_act=$reportdata_act['amount'];
$last_amount=$reportdata_act['lastamount'];
$grand_last_amount+=$last_amount;
$grand_total+=$total_amount_act;
$codeData_new=getCode_new($reportdata_act['sa_id']);
$total_qty=$variation_data_sub['tvqty']+$reportdata_act['tpqty'];
$last_progress_qty=$reportdata_act['tpqty']-$reportdata_act['lqty'];
$total_last_qty=$upto_last_variation+$last_progress_qty; //lqty is during this month qty
if($variation_data_sub['vrate']==0)
{
$this_month_act=(($reportdata_act['lqty'] + $variation_this_data_sub['lvqty']) * $reportdata_act['prs']);
}
else
{
$this_month_act=(($reportdata_act['lqty'] + $variation_this_data_sub['lvqty']) * $variation_data_sub['vrate']);
}
$this_month_act_total+=$this_month_act;
if($variation_last_data_sub['vrate']==0)
{
$last_month_act=($total_last_qty) * $reportdata_act['prs'];
}
else
{
$last_month_act=($total_last_qty) * $variation_last_data_sub['vrate'];
}
$last_month_act_total+=$last_month_act;
if($variation_data_sub['vrate']==0)
{
$total_month=($total_qty) * $reportdata_act['prs'];
}
else
{
$total_month=($total_qty) * $variation_data_sub['vrate'];
}
$total_month_total+=$total_month;
?>
<?php if($variation_data_sub['tvqty']>0)
{
$bgcolor="#FF0000";
}?>
<tr style="background-color:<?php echo $bgcolor;?>;">
<td style="text-align:center;"><?php echo  $codeData_new['code']; ?></td>
<td style="text-align:left;"><?php   echo $reportdata_act['subactivityname']; ?></td>
<td style="text-align:center;"><?php echo $reportdata_act['units']; ?></td>
<?php /*?><td style="text-align:center;"><?php echo number_format($reportdata['quantity'],2); ?></td>
<td style="text-align:right;"><?php  echo number_format($reportdata['rates'],2); ?></td>
<td style="text-align:right;"><?php  echo number_format (($reportdata['quantity'] * $reportdata['rates']),2) ; ?></td><?php */?>
<td style="text-align:center;"><?php echo number_format($reportdata_act['tqty'],2); ?></td>
<td style="text-align:right;"><?php  echo number_format($reportdata_act['rates'],2); ?></td>
<td style="text-align:right;"><?php  echo number_format (($reportdata_act['tqty'] * $reportdata_act['rates']),2) ; ?></td>
<td style="text-align:center;"><?php echo number_format ($total_last_qty,2); ?></td>
<td style="text-align:right;"><?php  echo number_format (($last_month_act),2) ; ?></td>
<td style="text-align:center;"><?php echo number_format ($total_qty - $total_last_qty,2); ?></td>
<td style="text-align:right;"><?php  echo number_format($this_month_act,2) ; ?></td>
<td style="text-align:center;"><?php echo number_format ($total_qty,2); ?></td>   
<td style="text-align:right;"><?php  echo number_format (($total_month),2) ; ?></td>
<td style="text-align:right;"><?php  if($reportdata_act['tpqty']!=0 && $reportdata_act['tqty']!=0)
{
echo number_format((($total_qty / $reportdata_act['tqty'])*100),2);
}
else
{
echo "0.0";
} ?></td>
</tr>

<?php
}
?>
<tr align="right" id="grand_total">
<td style="text-align:right;" colspan="5"><strong><?php echo  "Grand Total:"; ?></strong></td>
<?php /*?><td style="text-align:center;"><?php echo number_format ($grand_total,2); ?></td>
<td style="text-align:right;">&nbsp;</td>
<td style="text-align:right;">&nbsp;</td><?php */?>
<td style="text-align:right;"><?php  
echo number_format ($grand_total,2); ?></td>
<td style="text-align:center;">&nbsp;</td>
<td style="text-align:right;"><?php  echo  number_format ($last_month_act_total,2) ; ?></td>
<td style="text-align:center;">&nbsp;</td>
<td style="text-align:right;"><?php  echo number_format (($this_month_act_total),2) ; ?></td>
<td style="text-align:center;">&nbsp;</td>   
<td style="text-align:right;"><?php  echo  number_format ($total_month_total,2) ; ?></td>
<td style="text-align:right;"><?php  if($total_month_total!=0&&$grand_total!=0)
{
echo number_format((($total_month_total/$grand_total)*100),2);
}
else
{
echo "0.0";
} ?></td>
</tr>
</table>
<?php
}else
{
?>
<table id="tblList" cellpadding="0px" cellspacing="0px"   width="98%" align="center" >
<tr  id="title">
<td colspan="15" align="center"><span class="white"><strong>General Report At sub-Activity Level(<?php echo $activityid; ?>)</strong> </span>
  </th></tr>
<tr id="tblHeading">
<th rowspan="2" width="46"> Sr. No.</th>
      <th rowspan="2" width="37"> Unit </th>
    <th rowspan="2" width="170">Activity / Sub-activity</th>
    <th rowspan="2" width="53"> Total Target </th>
    <th colspan="2">Starting Date</th>
    <th colspan="2">  date of Completion</th>
    <th width="68" rowspan="2">Schedule Number Of days</th>
    <th width="63" rowspan="2">days Elapsed</th>
    <th width="63" rowspan="2"> % Time Elapsed</th>
    <th colspan="4">Progress</th>
    </tr>
  <tr id="tblHeading">
    <th width="85">Scheduled </th>
    <th width="71">Actual</th>
    <th width="86">Scheduled</th>
    <th width="56">Actual</th>
    <th width="54">Up to Last Month</th>
    <th width="60">During Month</th>
    <th width="72">To Date Progress</th>
    <th width="84">Up to Date % Progress</th>
  </tr>
<tr >
<td align="center">&nbsp;</td>
<td style="text-align:center;" >1</td>
<td style="text-align:center;">2</td>
<td style="text-align:center;">3</td>
<td style="text-align:center;">4</td>
<td style="text-align:center;">5</td>
<td style="text-align:center;">6</td>
<td style="text-align:center;">7</td>
<td style="text-align:center;">8</td>
<td style="text-align:center;">9</td>
<td style="text-align:center;">10</td>
<td style="text-align:center;">11</td>
<td style="text-align:center;">12</td>
<td style="text-align:center;">13</td>
<td style="text-align:center;">14</td>
</tr>
<?php

function getActivityProgressAmount($cid,$sid,$sa_id,$s_id,$aid)
{
 
$sql2="SELECT sa_id,sum( pqty * prs ) AS tamount, max( bdate ) AS lastdate
FROM `progress` 
WHERE sa_id =".$sa_id." AND cid=".$cid." AND sid=".$sid." AND s_id=".$s_id." AND aid=".$aid." GROUP BY sa_id";
$pamountresult3 = mysql_query($sql2)or die(mysql_error());
$pdata=mysql_fetch_array($pamountresult3);
return $pdata;
}
function getCode_new($sa_id)
{
 $sql="SELECT code FROM  `subactivity` where sa_id=".$sa_id;
 
$amountresult = mysql_query($sql);
//echo $amountsize= mysql_num_rows($amountresult);
$data=mysql_fetch_array($amountresult);

return $data;
}
function getSubActivityVariationData($sa_id)
{ 
$sql2="SELECT sum(vd.vqty) As tvqty, sum(vd.vrate*cc.quantity) as variation_in_rate_amount, sum(vd.vqty*dd.prs) as variation_in_qty_amount,sum(vd.`vamount`) as variation_in_amount,vd.`vo_id`,vd.`contigency_code`,vd.`vono`,vd.`vodate`,vd.`bid`,vd.`remark`,vd.`vstatus`,vd.`bdate`
FROM variationdata vd
LEFT OUTER JOIN (subactivitydata cc) on (vd.sa_id = cc.sa_id) 
LEFT OUTER JOIN (progressdata dd) on (vd.sa_id = dd.sa_id) where cc.sa_id=".$sa_id." GROUP BY cc.sa_id";
$pamountresultp = mysql_query($sql2)or die(mysql_error());
$pgdata=mysql_fetch_array($pamountresultp);
return $pgdata;
}
function getThisMonthSubactivityVariationData($sa_id,$bid)
{ 
 $sql2="SELECT sum(vd.vqty) As lvqty, sum(vd.vrate*cc.quantity) as last_variation_in_rate_amount, sum(vd.vqty*dd.prs) as last_variation_in_qty_amount,sum(vd.`vamount`) as last_variation_in_amount,vd.`vo_id`,vd.`contigency_code`,vd.`vono`,vd.`vodate`,vd.`bid`,vd.`remark`,vd.`vstatus`,vd.`bdate`
FROM variationdata vd
LEFT OUTER JOIN (subactivitydata cc) on (vd.sa_id = cc.sa_id)
LEFT OUTER JOIN (progressdata dd) on (vd.sa_id = dd.sa_id) where cc.sa_id=".$sa_id." AND vd.bid=".$bid." GROUP BY cc.sa_id";
$pamountresultp = mysql_query($sql2)or die(mysql_error());
$pgdata=mysql_fetch_array($pamountresultp);
return $pgdata;
}
function LastMonthProgressDate()
{
$sql="SELECT  MIN(bdate) as lastMonthdate,bid FROM  `progressmonth` Group by bid order by bid ASC";
$amountresult = mysql_query($sql);
//echo $amountsize= mysql_num_rows($amountresult);
$data=mysql_fetch_array($amountresult);
return $data;
}
function ThisMonthProgressDate()
{
$sql="SELECT  MAX(bdate) as lastMonthdate,bid FROM  `progressmonth` Group by bid order by bid desc";
$amountresult = mysql_query($sql);
//echo $amountsize= mysql_num_rows($amountresult);
$data=mysql_fetch_array($amountresult);
return $data;
}
$this_month_data=ThisMonthProgressDate();
 $this_month_bid=$this_month_data["bid"];
$reportquerynew ="SELECT  ca.cid,sum(cc.lqty) as lqty, sum(cc.lqty*ca.rates) as lastamount,ca.subactivityname,ca.aid,ca.s_id,ca.sa_id,ca.sid,ca.startdate,ca.units,  ca.actual_stardate,ca.actual_enddate,min(ca.startdate) as mindate, ca.enddate, max(ca.enddate) as maxdate,  ca.quantity, ca.rates, cb.pqty, sum(cb.pqty) as tpqty,sum(ca.quantity*ca.rates) as amount, sum(ca.quantity) as tqty ,sum(cb.pamount)As totalamount,cb.pamount, cb.lbdate as lastdate , cb.prs FROM subactivitydata ca 
LEFT OUTER join (progressdata cb)
on (ca.sa_id = cb.sa_id )
LEFT OUTER join (lastmonthdata cc) 
on (cb.sa_id = cc.sa_id)Where ca.sid=".$activitytypeid." AND ca.s_id=".$subcomponentid." AND ca.aid=".$activityid." AND ca.sa_id=".$subactivityid." GROUP BY ca.sa_id";

/*$reportquerynew ="SELECT ca.subactivityname,ca.aid,ca.s_id,ca.sa_id,ca.sid,ca.startdate,ca.units, min(ca.startdate) as mindate, ca.enddate, max(ca.enddate) as maxdate,  ca.quantity, ca.rates,sum(ca.quantity*ca.rates) as amount, sum(ca.quantity) as tqty ,sum(vd.vqty) As tvqty, sum(vd.vrate*ca.quantity) as variation_in_rate_amount, sum(vd.vqty*ca.rates) as variation_in_qty_amount,sum(vd.`vamount`) as variation_in_amount,vd.`vo_id`,vd.`contigency_code`,vd.`vono`,vd.`vodate`,vd.`bid`,vd.`remark`,vd.`vstatus`,vd.`bdate`
FROM variationdata vd
LEFT OUTER JOIN (subactivitydata ca) on (vd.sa_id = ca.sa_id) where ca.aid=".$reportdata['aid']." GROUP BY ca.sa_id";*/
$reportresult_act = mysql_query($reportquerynew)or die(mysql_error());
while ($reportdata_act = mysql_fetch_array($reportresult_act)) {
 $bgcolor = ($bgcolor == "#FFFFFF") ? "#EAF4FF" : "#FFFFFF";
/*$bgcolor = ($bgcolor == "#FF9999") ? "#FFD5D5" : "#FF9999";*/
$variation_data_sub=getSubActivityVariationData($reportdata_act['sa_id']);
$variation_this_data_sub=getThisMonthSubactivityVariationData($reportdata_act['sa_id'],$this_month_bid);

$upto_last_variation=$variation_data_sub['tvqty']-$variation_this_data_sub['lvqty'];
$total_amount_act=$reportdata_act['amount'];
$last_amount=$reportdata_act['lastamount'];
$grand_last_amount+=$last_amount;
$grand_total+=$total_amount_act;
$codeData_new=getCode_new($reportdata_act['sa_id']);
$total_qty=$variation_data_sub['tvqty']+$reportdata_act['tpqty'];
$last_progress_qty=$reportdata_act['tpqty']-$reportdata_act['lqty'];
$total_last_qty=$upto_last_variation+$last_progress_qty; //lqty is during this month qty
if($variation_data_sub['vrate']==0)
{
$this_month_act=(($reportdata_act['lqty'] + $variation_this_data_sub['lvqty']) * $reportdata_act['prs']);
}
else
{
$this_month_act=(($reportdata_act['lqty'] + $variation_this_data_sub['lvqty']) * $variation_data_sub['vrate']);
}
$this_month_act_total+=$this_month_act;
if($variation_last_data_sub['vrate']==0)
{
$last_month_act=($total_last_qty) * $reportdata_act['prs'];
}
else
{
$last_month_act=($total_last_qty) * $variation_last_data_sub['vrate'];
}
$last_month_act_total+=$last_month_act;
if($variation_data_sub['vrate']==0)
{
$total_month=($total_qty) * $reportdata_act['prs'];
}
else
{
$total_month=($total_qty) * $variation_data_sub['vrate'];
}
$total_month_total+=$total_month;
?>
<?php if($variation_data_sub['tvqty']>0)
{
$bgcolor="#FF0000";
}
$mindate=$reportdata_act["mindate"];
$maxdate=$reportdata_act["maxdate"];
//$codeData=getCode($reportdata['sa_id']);
//$SubComponentData=getSubComponentProgressAmount($componentid,$reportdata['sid'],$reportdata['sa_id'],$reportdata['s_id']); /////SubComponentProgressAmount
/*$this_month_progress=getThisMonthSubComponentProgress($componentid,$reportdata['sid'],$reportdata['sa_id'],$reportdata['s_id']);
$current_month_progress=$this_month_progress['cprogress'];*/
$total_current_month_progress+=$reportdata_act['lastamount'];
?>
<?php
$aenddate = strtotime(substr($reportdata_act['enddate'],0,4)."-".substr($reportdata_act['enddate'],4,2)."-".substr($reportdata_act['enddate'],6,2));
$astartdate = strtotime(substr($reportdata_act['startdate'],0,4)."-".substr($reportdata_act['startdate'],4,2)."-".substr($reportdata_act['startdate'],6,2));
$datediff = $aenddate - $astartdate;
$noofdays = number_format($datediff/(60*60*24),0);
$noofdays=trim(str_replace(",","",$noofdays));
$total_noofdays+=$noofdays;
?>

<?php
$aenddate = strtotime(substr($reportdata_act['startdate'],0,4)."-".substr($reportdata_act['startdate'],4,2)."-".substr($reportdata_act['startdate'],6,2));
$tlbdate = strtotime(substr($reportdata_act['lastdate'],0,4)."-".substr($reportdata_act['lastdate'],4,2)."-".substr($reportdata_act['lastdate'],6,2));
//$aenddate = strtotime(substr($reportdata['enddate'],0,4)."-".substr($reportdata['enddate'],4,2)."-".substr($reportdata['enddate'],6,2));
//$tlbdate = strtotime(substr($reportdata['lastdate'],0,4)."-".substr($reportdata['lastdate'],4,2)."-".substr($reportdata['lastdate'],6,2));
$datediff = $tlbdate-$aenddate ;
$timeElps = number_format($datediff/(60*60*24),0);
$total_timeElps+=$timeElps;
$i++;
$upto_last_month_progress=$reportdata_act['totalamount']-$reportdata_act['lastamount'];
$total_upto_last_month_progress+=$upto_last_month_progress;
$to_date_progress=$reportdata_act['lastamount']+$upto_last_month_progress;
$total_progress+=$to_date_progress;
?>
<tr style="background-color:<?php echo $bgcolor;?>;">
<td style="text-align:center;"><?php echo $i;?> </td>
<td style="text-align:center;"><?php echo $reportdata_act['units']; ?></td>
<td style="text-align:left;"><?php echo $codeData_new['code'].".&nbsp;".$reportdata_act['subactivityname']; ?></td>
<td style="text-align:right;"><?php  echo number_format (($reportdata_act['tqty'] * $reportdata_act['rates']),2) ; ?></td>
<td align="left" style="min-width:75px"><?php if($reportdata_act['startdate']!=""){									
$time = strtotime($reportdata_act['startdate']);
$Date = date( 'd-M-Y', $time );
echo $Date;
} ?> </td>
<td style="text-align:right;"><?php if($reportdata_act['actual_stardate']!=""){									
$time = strtotime($reportdata_act['actual_stardate']);
$Date = date( 'd-M-Y', $time );
echo $Date;
} ?> </td>
<td style="text-align:left; min-width:75px"><?php if($reportdata_act['enddate']!=""){									
$time = strtotime($reportdata_act['enddate']);
$Date = date( 'd-M-Y', $time );
echo $Date;
}?> </td>
<td style="text-align:left; min-width:75px"><?php if($reportdata_act['actual_enddate']!=""){									
$time = strtotime($reportdata_act['actual_enddate']);
$Date = date( 'd-M-Y', $time );
echo $Date;
} ?> </td>
<td style="text-align:right;"><?php echo $noofdays; ?></td>
<td style="text-align:right;"><?php  if($timeElps<0)
										{
										$timeElps=0;
										echo "0" ;
										}
										else
										{
										if($reportdata_act['lastdate']>$reportdata_act['enddate'])
										{
										$timeElps=0;
										echo $timeElps;
										}
										else
										{
										echo $timeElps;
										}
										}?></td>
<td style="text-align:right;"><?php 
								if($reportdata_act['lastdate']>$reportdata_act['enddate'])
										{
										$p_time_elapsed=100;
										echo $p_time_elapsed;
										}
										else
										{
										$p_time_elapsed=($timeElps/$noofdays)*100;
										echo number_format(($timeElps/$noofdays)*100,2);
										}
								
								?></td>
<td style="text-align:right;"><?php  echo number_format (($last_month_act),2) ; ?></td>
<td style="text-align:right;"><?php  echo number_format($this_month_act,2) ; ?></td>
<td style="text-align:right;"><?php  echo number_format (($total_month),2) ; ?></td>
<td style="text-align:right;"><?php  if($reportdata_act['tpqty']!=0 && $reportdata_act['tqty']!=0)
{
echo number_format((($total_qty / $reportdata_act['tqty'])*100),2);
}
else
{
echo "0.0";
} ?></td>
</tr>




<?php
}
?>
<tr align="right" id="grand_total">
<td colspan="3" align="right">
<strong>Grand Total:</strong></td>
<td align="right"><span style="text-align:right;">
  <?php  
echo number_format ($grand_total,2); ?>
</span></td>
<td align="left" style="min-width:75px">
<?php $yr=substr($mindate,0,4);
$month=substr($mindate,4,-2);
$day=substr($mindate,6,8);
if($mindate!="")
{									
$time = strtotime($mindate);
$Date = date( 'd-M-Y', $time );
echo $Date;
}?></td>
<td>
<?php //echo $maxdate;?></td>
<td align="left" style="min-width:75px">
<?php $yr=substr($maxdate,0,4);
$month=substr($maxdate,4,-2);
$day=substr($maxdate,6,8);
if($maxdate!="")
{	
$time = strtotime($maxdate);
$Date = date( 'd-M-Y', $time );
echo $Date;								
}
?></td>
<td align="left" style="min-width:75px">&nbsp;</td>
<td><?php $mindate=str_replace("/","-",$mindate);
      
      $maxdate=str_replace("/","-",$maxdate);
	  
	  echo $ress=dateDiff($mindate,$maxdate);?></td>
<td>
<?php $mindate=str_replace("/","-",$mindate);
      
      $maxdate=str_replace("/","-",$maxdate);
	  
	  echo $ress=dateDiff($mindate,$maxdate);?></td>
<td>
<?php echo $timeElps;?></td>
<td><span style="text-align:right;">
  <?php  echo  number_format ($last_month_act_total,2) ; ?>
</span></td>
<td align="right"><span style="text-align:right;">
  <?php  echo number_format (($this_month_act_total),2) ; ?>
</span></td>
<td align="right"><span style="text-align:right;">
  <?php  echo  number_format ($total_month_total,2) ; ?>
</span></td>
<td align="right"><span style="text-align:right;">
  <?php  if($total_month_total!=0&&$grand_total!=0)
{
echo number_format((($total_month_total/$grand_total)*100),2);
}
else
{
echo "0.0";
} ?>
</span></td>
</tr>
</table>
<?php }
}
?>
</div>
<div class="clear"></div>
<div class="clear"></div>
	<?php include("includes/footer.php");?>
	<div class="clear"></div>
</body>
</html>

