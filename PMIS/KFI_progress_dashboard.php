<?php include('kfi-top-cache.php'); ?>
<?php
error_reporting(E_ALL & ~E_NOTICE);
@require_once("requires/session.php");
$module		= BOQDATA;
if ($uname==null)
{
	header("Location:index.php?init=3");
}
else if ($kfid_flag==0)
{
	header("Location: index.php?init=3");
}
$edit			= $_GET['edit'];
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
$objDb  		= new Database( );
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
<script>
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
	
function getNextLevel(val,id)
{
	var idv=id;
	var res =idv.split("_");
	var div_id=parseInt(res[1])+1;
	var div_name="str_obj_div_"+div_id;
	if (val!=0) {
			var strURL="findnextlevel.php?parentcd="+val+"&div_id="+div_id;
			var req = getXMLHTTP();
			
			if (req) {
				
				req.onreadystatechange = function() {
					if (req.readyState == 4) {
						// only if "OK"
						if (req.status == 200) {						
							document.getElementById(div_name).innerHTML=req.responseText;						
						} else {
							alert("There was a problem while using XMLHTTP COM:\n" + req.statusText);
						}
					}				
				}			
				req.open("GET", strURL, true);
				req.send(null);
			}
		} 

}
</script>
</head>
<body>
<div style="display: inline-block; height:110px; background-color:#f8f8f8;">
<div style="width:auto;">
<a href="./index.php"><img src="images/logo.png"   height="106" title="Home"  align="left" style="border-color:#ccc; border-radius:1px; padding:2px" /></a>
<div style="width:auto; padding-top:10px">
<span style="font-family:Arial, Helvetica, sans-serif; font-size:24px; color:#333; font-weight:bold; padding-left:305px" >Project Management Information System</span><br/>
<span style="font-family:Arial, Helvetica, sans-serif; font-size:24px; color:#333; font-weight:bold; padding-left:297px" >Key Financial Indicators (KFIs) Dashboard</span>
</div>
</div>
<table cellpadding="4px" cellspacing="0px" align="center" width="100%" style="border: solid 1px #ccc;" > 
<tr> 
<td width="20%" align="left" valign="top" style="border-right: solid 1px #ccc;"><div id="wrapper_MemberLogin" style="width:400px;margin:10px;">
  <h1 style="color:#000;"><?php echo "KFI Monitoring Dashboard";?> </h1>
  <div class="clear"></div>
  <div id="LoginBox" class="borderRound borderShadow" style="padding:10px">
    <form action="KFI_progress_dashboard.php" method="get" name="main_dash" id="main_dash" >
      <table border="0px" cellpadding="0px" cellspacing="0px" align="center"  >
      <?php $mquery = "select max(activitylevel) as max_activitylevel from boqdata where stage='BOQ'";
				$mresult = mysql_query($mquery);
				$mdata = mysql_fetch_array($mresult); 
				$max_activitylevel=$mdata["max_activitylevel"];
				$i=0;
				$levl="";
				while( $i<=$max_activitylevel)
				{
					if($i==0) $level="Component/Package";
					elseif($i==1) $level="Sub Component ";
					elseif($i==2) $level="Activity ";
					else $level=" Sub-Activity ";
				?>
        <tr>
          <td ><strong>
            <label> <?php echo $level;?> Level : </label>
          </strong></td>
          <td><div id="str_obj_div_<?php echo $i;?>">
            <select name="itemid_<?php echo $i;?>" id="itemid_<?php echo $i;?>" onchange="getNextLevel(this.value,this.id)">
             <option value="0"><?php echo $level;?> Level </option>
              <?php
			  
			    $str_g_query = "select * from boqdata where stage='BOQ' and activitylevel=".$i;
			    if(isset($_GET["parentcd"])&&$_GET["parentcd"])
				{
					$str_g_query .=" and parentcd=".$_GET["parentcd"];
				}
				$str_g_result = mysql_query($str_g_query);
				while ($str_g_data = mysql_fetch_array($str_g_result)) {
				?>
		    <option value="<?php echo $str_g_data['itemid']; ?>"  <?php if(isset($_GET["itemid_".$i])&&$_GET["itemid_".$i]!=""&&$_GET["itemid_".$i]==$str_g_data['itemid'])
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
 <?php include("includes/report_kpi.php");?>
<?php  
//////////Activity  Title here

				$data_level_idf=0;
				for($i=0;$i<=$max_activitylevel;$i++)
				{ 
				$data_level_id=$_REQUEST["itemid_".$i];
				if($data_level_id!=0)
				{
					$data_level_idf=$data_level_id;
				
				$adata=getActDataLevel($data_level_idf);
				$adetail=$adata["itemcode"]."-".$adata["itemname"];
				$aweight=$adata["weight"];
				$afactor=$adata["factor"];
				$aparentgroup=$adata["parentgroup"];
			    $aparentcd=$adata["parentcd"];
				$actlevel=$adata["activitylevel"];
				}
				//echo $aitemid=$adata["itemid"];
				
			    if($aparentcd!="")
				{
					$parentcd=$aparentcd;
				}
			
				
				}
				//echo $data_level_idf;
			
?>
<?php /// Calculate MaX Activity Level
		if(isset($data_level_id)&&$data_level_id!=""&&$data_level_id!=0)
		{
		$act_level_query="Select MAX(activitylevel) as max_level  from boqdata where parentcd=".$data_level_id;
		$max_level_result = mysql_query($act_level_query);
		$max_level_data=mysql_fetch_array($max_level_result);
		$max_level=$max_level_data["max_level"];
		$act_level_querym="Select MIN(activitylevel) as min_level  from boqdata where parentcd=".$data_level_id;
		$min_level_resultm = mysql_query($act_level_querym);
		$min_level_datam=mysql_fetch_array($min_level_resultm);
		$min_level=$min_level_datam["min_level"];
		}
		?>
    
<?php  include("includes/kfi_main_level_progress_dashboard.php");?>           
<?php  include("includes/kfi_data_level_progress_dashboard.php");?>

</td>
</tr>
</table>
 
<?php //include ("includes/footer.php"); ?>
</div>
</body>
</html>
<?php
	$objDb ->close( );
?>
<?php include('kfi-bottom-cache.php'); ?>