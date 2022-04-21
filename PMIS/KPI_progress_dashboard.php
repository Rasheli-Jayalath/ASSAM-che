<?php //include('kpi-top-cache.php');?>
<?php
error_reporting(E_ALL & ~E_NOTICE);
@require_once("requires/session.php");
$module		= "Key Performance Indicators (KPI)";
if ($uname==null)
{
	header("Location:index.php?init=3");
}
else if ($kpid_flag==0)
{
	header("Location: index.php?init=3");
}
$kpi_temp_id			= $_GET['kpi_temp_id'];
$objDb  		= new Database( );
@require_once("get_url.php");
$msg	= "";
//This is the default language. We will use it 2 places, so i am put it 
//into a varaible.
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
 $current_kpi_start_date=date('Y-m-d');
 $ps="SELECT pstart from project ";
 $psresult = mysql_query($ps);
 $psdata=mysql_fetch_array($psresult);
 $pstartdate=$psdata["pstart"];
$qss="SELECT Max(progressdate) as progressdate from progress ";
 $qssresult = mysql_query($qss);
 $qssdata=mysql_fetch_array($qssresult);
  $end_kpi_date=$qssdata["progressdate"];
 $newdate = date("Y-m-d", strtotime("-12 months"));
  if($newdate<$pstartdate)
    $start_kpi_date=$newdate;
	else
	$start_kpi_date=$pstartdate;
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

 <script>
  $(function() {
    $( "#start_date" ).datepicker({ dateFormat: 'yy-mm-dd' }).val();
	
  });
   $(function() {
    $( "#end_date" ).datepicker({ dateFormat:'yy-mm-dd'}).val();
	
  });
  
  </script>
  <script type="text/javascript">

function GetNextLevel(value,div_name)
{
	
	var str=div_name;
	var div_id=str.substr(6, 7);
	 var nextlevel;
	
	  if(value==0)
	  {
	   document.getElementById("str_obj_div_"+div_id).innerHTML=xmlhttp.responseText;
	  document.getElementById("str_obj_div_"+div_id).style.display="none";
	  document.getElementById("str_obj_div_"+div_id).style.visibility="hidden";
	  document.getElementById("lab_"+div_id).style.display="none";
	  document.getElementById("lab_"+div_id).style.visibility="hidden";
	  }
	  else
	  {
		    div_id=parseInt(div_id)+1;
	   if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttpN=new XMLHttpRequest();
  } else {  // code for IE6, IE5
    xmlhttpN=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttpN.onreadystatechange=function() {
    if (xmlhttpN.readyState==4 && xmlhttpN.status==200) {
		
		 document.getElementById("level_count").value=xmlhttpN.responseText;
	}
  }
	
  xmlhttpN.open("GET","findnextlevelkpicount.php?parentgroup="+value+"&div_id="+div_id,true);
  xmlhttpN.send();
	/////////////////////////////////////
	
	nextlevel= document.getElementById('level_count').value;
	
	if(nextlevel>0)
	{
	 if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else {  // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
	
      document.getElementById("str_obj_div_"+div_id).innerHTML=xmlhttp.responseText;
	  document.getElementById("str_obj_div_"+div_id).style.display="";
	  document.getElementById("str_obj_div_"+div_id).style.visibility="visible";
	  document.getElementById("lab_"+div_id).style.display="";
	  document.getElementById("lab_"+div_id).style.visibility="visible";
      
	 
    }
  }


  xmlhttp.open("GET","findnextlevelkpi.php?parentgroup="+value+"&div_id="+div_id,true);
  xmlhttp.send();
	}
	  }
}
</script>
</head>
<body>
<div style="display: inline-block; height:110px;  background-color:#f8f8f8;">
<div style="width:auto; text-align:center">
<a href="./index.php"><img src="images/logo.png"   height="106" title="Home"  align="left" style="border-color:#ccc; border-radius:1px; padding:2px" /></a> 
<div style="width:auto; padding-top:10px">
<span style="font-family:Arial, Helvetica, sans-serif; font-size:24px; color:#333; font-weight:bold; padding-left:305px" ><?php echo ADMIN_SITE_TITLE;?></span><br/>
<span style="font-family:Arial, Helvetica, sans-serif; font-size:24px; color:#333; font-weight:bold; padding-left:300px" ><?php echo KPI_DASHBOARD;?></span>
</div>
</div>
<?php /*?><?php if(isset($kpi_temp_id)&&$kpi_temp_id!=""&&$kpi_temp_id!=0)
{?> <?php */?>
<table cellpadding="4px" cellspacing="0px" align="center" width="100%" style="border: solid 1px #ccc;" > 
<tr> 
<td width="20%" align="left" valign="top" style="border-right: solid 1px #ccc;">
<div id="wrapper_MemberLogin" style="height: 289px;margin:10; width:350px;">
  <h1 style="color:#000;"><?php echo KPI_DASHBOARDS;?> </h1>
  <div class="clear"></div>
  <div id="LoginBox" class="borderRound borderShadow"  style="padding:10px">
    <form action="KPI_progress_dashboard.php" method="get" name="main_dash" id="main_dash" >
    <input type="hidden" id="kpi_temp_id" name="kpi_temp_id" value="<?php echo $kpi_temp_id;?>" />
     <input type="hidden" id="level_count" name="level_count" value="1" />
      <table border="0px" cellpadding="1px" cellspacing="0px" align="center"  >
      <tr>
          <td >
            <strong>
            <label> <?php echo START;?>: </label>
          </strong>
            </td>
            <td><input type="text" id="start_date" name="start_date" value="<?php if(isset($_REQUEST["start_date"])&&$_REQUEST["start_date"]!=""&&$_REQUEST["start_date"]!="1970-01-01")echo $_REQUEST["start_date"]; else echo date("Y-m-d", strtotime($start_kpi_date));?>" style="width:150px"/></td>
            </tr>
                 <tr>
          <td >
            <strong>
            <label> <?php echo END;?>: </label>
          </strong>
            </td>
            <td><input type="text" id="end_date" name="end_date" value="<?php if(isset($_REQUEST["end_date"])&&$_REQUEST["end_date"]!=""&&$_REQUEST["end_date"]!="1970-01-01")echo $_REQUEST["end_date"]; else echo date("Y-m-d", strtotime($end_kpi_date));?>" style="width:150px"/></td>
            </tr>
      <?php $mquery = "select max(activitylevel) as max_activitylevel from kpidata where kpi_temp_id=$kpi_temp_id ";
				$mresult = mysql_query($mquery);
				$mdata = mysql_fetch_array($mresult); 
				$max_activitylevel=$mdata["max_activitylevel"];
				$i=0;
				$levl="";?>
               
                <?php
				while( $i<=$max_activitylevel)
				{
					if($i==0) $level=PROJECT_KPI;
					elseif($i==1) $level=COMP;
					elseif($i==2) $level=ACT;
					else $level=SUB_ACT;
				?>
                
        <tr>
          <td ><strong>
          <?php  ?>
            <label id="lab_<?php echo $i;?>"  > <?php echo $level;?>: </label>
          </strong></td>
          <td><div id="str_obj_div_<?php echo $i;?>">
            <select name="kpiid_<?php echo $i;?>" id="kpiid_<?php echo $i;?>" onchange="GetNextLevel(this.value,this.name)">
             <option value="0"><?php echo $level;?></option>
              <?php
			  
			    $str_g_query = "select * from kpidata where kpi_temp_id=$kpi_temp_id AND activitylevel=".$i;
			    if((isset($_GET["kpiid_".$i])&&$_GET["kpiid_".$i]!=""&&$_GET["kpiid_".$i]!=0))
				{
					
				$tempquery = "select parentcd from kpidata where parentgroup='".$_GET["kpiid_".$i]."'";
					$tempresult = mysql_query($tempquery);
					 $tempcount = mysql_num_rows($tempresult);
					if($tempcount>0)
					{   $tempdata = mysql_fetch_array($tempresult);
						$parentcd=$tempdata["parentcd"];
					}
				
					$str_g_query .=" and parentcd=".$parentcd;
				}
				$str_g_result = mysql_query($str_g_query);
				while ($str_g_data = mysql_fetch_array($str_g_result)) {
				?>
		    <option value="<?php echo $str_g_data['parentgroup']; ?>"  <?php if(isset($_GET["kpiid_".$i])&&$_GET["kpiid_".$i]!=""&&$_GET["kpiid_".$i]==$str_g_data['parentgroup'])
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
  <script src="lightbox/js/lightbox.min.js"></script>
  <link href="lightbox/css/lightbox.css" rel="stylesheet" />      
</td>
<td width="80%" align="left" valign="top">
<script src="highcharts/js/highcharts.js"></script>
<script src="highcharts/js/modules/exporting.js"></script>
<script src="highcharts/js/modules/jquery.highchartTable.js"></script>
 <?php include("includes/functions_kpi.php");?>

<?php  

//////////Activity  Title here
$url=basename($_SERVER['REQUEST_URI']);
list($str1,$str2)=explode('?',$url);
$param=explode('&',$str2);
$temp_levels=explode('=',$param[0]);
$temp_id=$temp_levels[1];?>
 <?php include("includes/report_kpiN.php");?>
<?php
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
	
	if($count<$size)
	{
	//$parentgroup.="_";	
	
	}
	$parentgroup=$data_level_id;
	$count--;
}
}
if($parentgroup!=""&&$parentgroup!=0)
{
  $gdetailq="SELECT kpiid,itemname, isentry from kpidata where parentgroup='".$parentgroup."'";
 $gdetailqresult = mysql_query($gdetailq);
  $gdetailqdata=mysql_fetch_array($gdetailqresult);
  if($gdetailqdata['kpiid']!=""&&$gdetailqdata['kpiid']!=0)
  {
	  $reportquery_sub1="SELECT sum(baseline) as baseline, unit FROM kpi_base_level_report where kpiid=".$gdetailqdata['kpiid']." Group By kpiid,scid";
  
	$reportresult_sub1 = mysql_query($reportquery_sub1);
    $reportdata_sub1 = mysql_fetch_array($reportresult_sub1);
	
  }
}
}
?>

    
           
<?php include("includes/project_level.php");?>

</td>
</tr>
</table>
<?php /*?> <?php }
 else
 {?>
 <table cellpadding="4px" cellspacing="0px" align="center" width="100%" style="border: solid 1px #ccc;" > 
<tr> 
<td width="20%" align="left" valign="top" style="border-right: solid 1px #ccc;" colspan="2">
	<?php echo "<h1>NO TEMPLATE IS SELECTED</h1>";
 }?>
 </td>
 
 </tr>
 </table><?php */?>
<?php //include ("includes/footer.php"); ?>
</div>
</body>
</html>
<?php
	$objDb ->close( );
?>
<?php //include('kpi-bottom-cache.php');?>
