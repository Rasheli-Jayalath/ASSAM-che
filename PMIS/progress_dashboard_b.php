<?php include('act-top-cache.php'); ?>
<?php
error_reporting(E_ALL & ~E_NOTICE);
@require_once("requires/session.php");
$module		= MAINDATA;
if ($uname==null)
{
	header("Location:index.php?init=3");
}
else if ($actd_flag==0)
{
	header("Location: index.php?init=3");
}
$edit			= $_GET['edit'];
$objDb  		= new Database( );
$temp_id			= $_GET['temp_id'];
@require_once("get_url.php");
$msg	= "";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include ('includes/metatag.php'); ?>

<link rel="stylesheet" type="text/css" href="css/styleNew.css">

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.js"></script>

<link rel="stylesheet" type="text/css" media="all" href="datepickercode/jquery-ui.css" />
  <script type="text/javascript" src="datepickercode/jquery-1.10.2.js"></script>
  <script type="text/javascript" src="datepickercode/jquery-ui.js"></script>
<script type="text/javascript">
function GetActivity(){
	
	var qString = '';
	
	var output_var=document.main_dash.output_id.value;
	
	var act_var=document.main_dash.act_id.value;
	
	
	if(document.main_dash.str_obj.value != "" && document.main_dash.str_obj.value != 0)
	{
		
		qString += 'obj=' + escape(document.main_dash.str_obj.value);
	}
	if(document.main_dash.outcome_id.value != "" && document.main_dash.outcome_id.value != 0)
	{
		
		qString += '&outcome=' + escape(document.main_dash.outcome_id.value);
	}
	if(document.main_dash.output_id.value != "" && document.main_dash.output_id.value != 0)
	{
		
		qString += '&output=' + escape(document.main_dash.output_id.value);
	}
	
	if(output_var!= "" && output_var != 0 &&  act_var!= "" && act_var != 0)
	{
		
		qString += '&activity=' + escape(act_var);
	}
	<?php if(isset($_REQUEST["activity"])&&$_REQUEST["activity"]!=""&&$_REQUEST["activity"]!=0)
	{?>
	
		var sub_act_str=document.getElementById('sub_act_id_' + <?php echo $_REQUEST["activity"];?>).value;
		if(sub_act_str!=0&&sub_act_str!="")
		{
		qString += '&sub_act_id_'+<?php echo $_REQUEST["activity"];?>+'='+ escape(sub_act_str);
		}
		//alert(sub_act_str);
	<?php }?>
		<?php if(isset($_REQUEST["sub_act_id_".$_REQUEST["activity"]])&&$_REQUEST["sub_act_id_".$_REQUEST["activity"]]!=""&&$_REQUEST["sub_act_id_".$_REQUEST["activity"]]!=0)
	{?>
	
		var sub_act_str_1=document.getElementById('sub_act_id_' + <?php echo $_REQUEST["sub_act_id_".$_REQUEST["activity"]];?>).value;
		if(sub_act_str_1!=0&&sub_act_str_1!="")
		{
		qString += '&sub_act_id_'+<?php echo $_REQUEST["sub_act_id_".$_REQUEST["activity"]];?>+'='+ escape(sub_act_str_1);
		}
		//alert(sub_act_str);
	<?php }?>
	document.location = 'progress_dashboard.php?' + qString;
}
function GetNextLevel(value,div_name)
{
	
	 var str=div_name;
	var div_id=str.substr(7, 8);
	
	  div_id=parseInt(div_id)+1;
	 if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else {  // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
	
      document.getElementById("str_obj_div_"+div_id).innerHTML=xmlhttp.responseText;

	 
    }
  }

  xmlhttp.open("GET","findnextlevelAct.php?parentgroup="+value+"&div_id="+div_id,true);
  xmlhttp.send();
}
</script>
</head>
<body>
<div style="display: inline-block; height:110px; background-color:#f8f8f8;">
<div style="width:auto;">
<a href="./index.php"><img src="images/logo.png"   height="106" title="Home"  align="left" style="border-color:#ccc; border-radius:1px; padding:2px" /></a>
<div style="width:auto; padding-top:10px">
<span style="font-family:Arial, Helvetica, sans-serif; font-size:24px; color:#333; font-weight:bold; padding-left:305px" >Project Management Information System</span><br/>
<span style="font-family:Arial, Helvetica, sans-serif; font-size:24px; color:#333; font-weight:bold; padding-left:360px" >Activity Monitoring Dashboard</span>
</div>
</div>
<?php include("includes/functions_progress_dashboard.php");?>
<table cellpadding="4px" cellspacing="0px" align="center" width="100%" style="border: solid 1px #ccc;" > 
<tr> 
<td width="25%" align="left" valign="top" style="border-right: solid 1px #ccc;"><div id="wrapper_MemberLogin" style="margin:10px;">
  <h1 style="color:#000;"><?php echo "Activity Monitoring Dashboard";?> </h1>
  <div class="clear"></div>
  <div id="LoginBox" class="borderRound borderShadow" style="padding:10px; width:300px">
    <form action="progress_dashboard.php" method="get" name="main_dash" id="main_dash" >
    <input type="hidden" id="temp_id" name="temp_id" value="<?php echo $temp_id;?>"  />
      <table border="0px" cellpadding="0px" cellspacing="0px" align="center"  >
      <?php $mquery = "select max(activitylevel) as max_activitylevel from maindata  ";
				$mresult = mysql_query($mquery);
				$mdata = mysql_fetch_array($mresult); 
				$max_activitylevel=$mdata["max_activitylevel"];
				$i=0;
				$levl="";
				while( $i<=$max_activitylevel)
				{
					if($i==0) $level="Component";
					elseif($i==1) $level="Sub Component ";
					elseif($i==2) $level="Activity ";
					else $level=" Sub-Activity ";
				?>
        <tr>
          <td ><strong>
            <label> <?php echo $level;?>: </label>
          </strong></td>
          <td><div id="str_obj_div_<?php echo $i;?>">
            <select name="itemid_<?php echo $i;?>" id="itemid_<?php echo $i;?>" onchange="GetNextLevel(this.value,this.name)">
             <option value="0"><?php echo $level;?></option>
              <?php
			  
			    $str_g_query = "select * from maindata WHERE activitylevel=".$i;
			    if(isset($_GET["parentcd"])&&$_GET["parentcd"])
				{
					$str_g_query .=" and parentcd=".$_GET["parentcd"];
				}
				$str_g_result = mysql_query($str_g_query);
				while ($str_g_data = mysql_fetch_array($str_g_result)) {
				?>
		    <option value="<?php echo $str_g_data['parentgroup']; ?>"  <?php if(isset($_GET["itemid_".$i])&&$_GET["itemid_".$i]!=""&&$_GET["itemid_".$i]==$str_g_data['parentgroup'])
			{?> selected="selected" <?php }?>>
								<?php echo $str_g_data['itemcode']."-".$str_g_data['itemname']; ?>
								</option>
							  <?php
				}
				?>
            </select>
          </div></td>
        </tr>
        <?php
		$i++ ; 
		}?>
        
         <tr >
          <td style="padding-top:20px" align="center" colspan="2">
            <input type="submit" value="Generate Report"  id="uLogin2"/>
            </td>
            <td></td>
            </tr>
      </table>
     
    </form>
    
  </div>
</div>
<table cellpadding="4px" cellspacing="0px" align="center" width="80%" style="border: solid 1px #ccc; margin:10px 10px 10px 30px" > 
    <tr style="background-color:<?php echo $bgcolor;?>; border-bottom-color:#FFF">
<td height="20" style="text-align:left;border-bottom-color:#FFF">
<img src="images/indicators/green.png" width="25px" title="Completed" style="vertical-align:middle">&nbsp;&nbsp;<span >Completed</span>
</td>
</tr>
<tr style="background-color:<?php echo $bgcolor;?>;">
<td height="20" style="text-align:left;border-bottom-color:#FFF">
<img src="images/indicators/red.png" width="25px" title="Delayed Against Schedule" style="vertical-align:middle">&nbsp;&nbsp;<span >Delayed Against Schedule</span>
</td>

</tr>
<tr style="background-color:<?php echo $bgcolor;?>;">
<td height="20" style="text-align:left;border-bottom-color:#FFF">
<img src="images/indicators/yellow.png" width="25px" title="Continued" style="vertical-align:middle">&nbsp;&nbsp;<span style="vertical-align:middle" >Continued</span>
</td>

</tr>
<tr style="background-color:<?php echo $bgcolor;?>;">
<td height="20" style="text-align:left;border-bottom-color:#FFF">
<img src="images/indicators/pink.png" width="25px" title="Indicator for Quantity Overuse"  style="vertical-align:middle">&nbsp;&nbsp;<span style="vertical-align:middle" >Indicator for Quantity Overuse</span>
</td>
</tr>
<tr style="background-color:<?php echo $bgcolor;?>;">
<td height="20" style="text-align:left;">
<img src="images/indicators/blue.png" width="25px" title="Not yet Started" style="vertical-align:middle" >&nbsp;&nbsp;<span style="vertical-align:middle" >Not yet Started</span>
</td>

</tr>
    </table>
  <script src="lightbox/js/lightbox.min.js"></script>
  <link href="lightbox/css/lightbox.css" rel="stylesheet" />      
</td>
<td width="75%" align="left" valign="top">
<script src="highcharts/js/highcharts.js"></script>
<script src="highcharts/js/modules/exporting.js"></script>
<script src="highcharts/js/modules/jquery.highchartTable.js"></script>
<?php //////////Activity  Title here
$url=basename($_SERVER['REQUEST_URI']);
list($str1,$str2)=explode('?',$url);
$param=explode('&',$str2);
$temp_levels=explode('=',$param[0]);
$temp_id=$temp_levels[1];
$parentgroup="";
$subquery="";
 $size=count($param);
if($size>1)
{
$para_count= count($param);
$j=$para_count;
$count=$size;
for($i=0; $i<=$para_count; $i++)
{
	
$data_levels=explode('=',$param[$i]);
$data_level_id=$data_levels[1];


$data_level_param=$data_levels[0];
if($data_level_id!=0)
{
$adata=getActDataLevel($data_level_id);
$adetail=$adata["itemcode"]."-".$adata["itemname"];
$aweight=$adata["weight"];
$afactor=$adata["factor"];
$aparentgroup=$adata["parentgroup"];
	
	if($count<$size)
	{
	//$parentgroup.="_";	
	
	}
	$parentgroup=$data_level_id;
	$parentcd=$adata["itemid"];
	$count--;
}
}
if($parentgroup!=""&&$parentgroup!=0)
{
  $gdetailq="SELECT* from maindata where parentgroup='".$parentgroup."'";
 $gdetailqresult = mysql_query($gdetailq);
  $gdetailqdata=mysql_fetch_array($gdetailqresult);
  if($gdetailqdata['itemid']!=""&&$gdetailqdata['itemid']!=0)
  {
	/*  $reportquery_sub1="SELECT sum(baseline) as baseline, unit FROM kpi_base_level_report where kpiid=".$gdetailqdata['kpiid']." Group By kpiid,scid";
  
	$reportresult_sub1 = mysql_query($reportquery_sub1);
    $reportdata_sub1 = mysql_fetch_array($reportresult_sub1);*/
	
  }
}
}
?>

 <?php include("includes/pdo_level_progress_dashboard.php");?>
<?php //include("includes/outcome_level_progress_dashboard.php");?>
<?php //include("includes/output_level_progress_dashboard.php");?>
<?php //include("includes/mainactivity_level_progress_dashboard.php");?>
<?php //include("includes/activity_level_progress_dashboard.php");?>
<?php //include("includes/data_level_progress_dashboard.php");?>
</td>
</tr>
</table>
 
<?php include ("includes/footer.php"); ?>
</div>
</body>
</html>
<?php
	$objDb ->close( );
?>
<?php include('act-bottom-cache.php'); ?>