<?php 
error_reporting(E_ALL & ~E_NOTICE);
@require_once("requires/session.php");
$objDb  		= new Database( );
if ($uname==null  ) {
header("Location: index.php?init=3");
}
else if ($process_flag==0 ) {
header("Location: index.php?init=3");
}

?><?php 


//$projectid = $_REQUEST['projectid'];
$msgFlag=false;
$graphflag=false;
$data=NULL;
$subactivityflag2=0;
$from_date = date('Y-m-d',strtotime($_REQUEST['from_date']));
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
<title><?php echo PROJECT;?></title>
<link href="css/CssAdminStyle.css" rel="stylesheet" type="text/css" />
<link href="css/CssLogin2.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" media="all" href="datepickercode/jquery-ui.css" />
  <script type="text/javascript" src="datepickercode/jquery-1.10.2.js"></script>
  <script type="text/javascript" src="datepickercode/jquery-ui.js"></script>
  <script>
  $(function() {
    $( "#from_date" ).datepicker();
	$( "#to_date" ).datepicker();
  });
  </script>

<script src="lightbox/js/lightbox.min.js"></script>
  <link href="lightbox/css/lightbox.css" rel="stylesheet" />      
  <script src="highcharts/js/highcharts.js"></script>
<script src="highcharts/js/modules/exporting.js"></script>
<script src="highcharts/js/modules/jquery.highchartTable.js"></script>
<script src="highcharts/js/highcharts-more.js"></script>
<script language="javascript" type="text/javascript">
function getXMLHTTP() { //fuction to return the xml http object
		var xmlhttp;
	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
		return xmlhttp;
    }
	
	function getcomponent(projectid) {		
		if (projectid!=0) {
			var strURL="findevacomponent.php?project="+projectid;
			var req = getXMLHTTP();
			
			if (req) {
				
				req.onreadystatechange = function() {
					if (req.readyState == 4) {
						// only if "OK"
						if (req.status == 200) {						
							document.getElementById('componentdiv').innerHTML=req.responseText;						
						} else {
							alert("There was a problem while using XMLHTTP COM:\n" + req.statusText);
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
	
	function getsubcomponent(componentid) {	
		
		if (componentid!=0) {
		var strURL="findevasubcomponent.php?component="+componentid;
			var req = getXMLHTTP();
			
			if (req) {
				
				req.onreadystatechange = function() {
					if (req.readyState == 4) {
						// only if "OK"
						if (req.status == 200) {						
							document.getElementById('subcomponentdiv').innerHTML=req.responseText;						
						} else {
							alert("There was a problem while using XMLHTTP: 5\n" + req.statusText);
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
			var strURL="findevaactivity.php?subcomponent="+subcomponentid;
			var req = getXMLHTTP();
			
			if (req) {
				
				req.onreadystatechange = function() {
					if (req.readyState == 4) {
						// only if "OK"
						if (req.status == 200) {						
							document.getElementById('activitydiv').innerHTML=req.responseText;						
						} else {
							alert("There was a problem while using XMLHTTP:6\n" + req.statusText);
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
</script>
</head>
<body>
<div style="width:auto">
<div style="height:110px; background-color:#000066; text-align:center; min-width:5137px; width:auto">
<div class="wrap" style="margin:0px; padding:0px;  min-width:1500px; width:auto">
<a href="home.php"><img src="images/homeico.png"    title="Home" width="100" height="96" align="left" style="border-color:#ccc; border-radius:1px" /></a>
<span style="color:#FFF; font-size:28px; text-align:left; padding-right:3200px; vertical-align:middle; font-weight:bold; padding-top:200px"><?php echo PROJECT;?></span>

<a href="home.php" ><img src="images/124126-matte-red-and-white-square-icon-transport-travel-car-gauge3.png"    width="100" height="96" align="right" style="border-color:#ccc; border-radius:1px"  title="Main Dashboard"/></a>
</div></div>
<?php include("includes/functions_eva.php");?>
<?php $start="2014-11-01";
$end="2017-07-01";
$last="2017-07-01";
?>
<table cellpadding="0px" cellspacing="0px" align="center" width="100%" style="border: solid 1px #ccc;" > 
<tr> 
<td width="165" align="left" valign="top" style="border-right: solid 1px #ccc;">


<?php include("includes/eva_cpi_speedometer_graph.php");?>
<?php include("includes/eva_spi_speedometer_graph.php");?>
<?php include("includes/eva_tcpi1_speedometer_graph.php");?>
<?php include("includes/eva_latest_indicator_value.php");?>
<?php include("includes/eva_latest_indicator_value_text.php");?>
  
 
</td>
<td valign="top" align="left"> <?php 

				?>
<?php include("includes/eva_main_graph.php");?>
<?php include("includes/eva_spi_cpi_graph.php");?>
<?php include("includes/eva_cost_var_graph.php");?>
<?php include("includes/eva_schedule_var_graph.php");?>
<?php include("includes/eva_monthly_indicator_data.php");?>
<br/>
<?php include("includes/eva_monthly_forecast_data.php");?>

</td>
</tr>

</table>


</div>
<div class="clear"></div>
	<?php //include("includes/footer.php");?>
	<div class="clear"></div>
</body>
</html>

