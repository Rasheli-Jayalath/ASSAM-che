<?php
error_reporting(E_ALL & ~E_NOTICE);
@require_once("requires/session.php");
$module			="Issues";
if ($uname==null)
{
	header("Location:index.php?init=3");
}
else if ($issueAdm_flag==0)
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
@require_once("get_url.php");
$msg						= "";
$pid=1;
$file_path="project_data/";
function genRandom($char = 5){
	$md5 = md5(time());
	return substr($md5, rand(5, 25), $char);
}
function getExtention($type){
	if($type == "image/jpeg" || $type == "image/jpg" || $type == "image/pjpeg")
		return "jpg";
	elseif($type == "image/png")
		return "png";
	elseif($type == "image/gif")
		return "gif";
	elseif($type == "application/pdf")
		return "pdf";
	elseif($type == "application/msword")
		return "doc";
	elseif($type == "application/vnd.openxmlformats-officedocument.wordprocessingml.document")
		return "docx";
	elseif($type == "text/plain")
		return "doc";
		
}
if(isset($_REQUEST['save']))
{
	
	$pid=1;
	$risk_entry_date=date('Y-m-d',strtotime($_REQUEST['risk_entry_date']));
	$risk_no=$_REQUEST['risk_no'];
	$risk_con_id=$_REQUEST['risk_con_id'];
	$risk_status=$_REQUEST['risk_status'];
	$risk_cons_hazard=$_REQUEST['risk_cons_hazard'];
	$risk_cause=$_REQUEST['risk_cause'];
	$risk_like_score=$_REQUEST['risk_like_score'];
	$risk_impact_score=$_REQUEST['risk_impact_score'];
	$risk_control_measure=$_REQUEST['risk_control_measure'];
	$risk_owner=$_REQUEST['risk_owner'];
	$risk_lastdate=date('Y-m-d',strtotime($_REQUEST['risk_lastdate']));
	$risk_update_date=date('Y-m-d'); 
	$risk_rrls=$_REQUEST['risk_rrls'];
	$risk_rris=$_REQUEST['risk_rris'];
	$risk_comments=$_REQUEST['risk_comments'];
	
	$message="";
	$pgid=1;
	
	echo "INSERT INTO tbl_risk_register(pid, risk_con_id, risk_no, risk_entry_date, risk_status, risk_cons_hazard, risk_cause, risk_like_score, risk_impact_score, risk_control_measure, risk_owner, risk_lastdate, risk_update_date, risk_rrls, risk_rris, risk_comments) Values(".$pid.",'".$risk_con_id.",'".$risk_no."', '".$risk_entry_date."', '".$risk_status."', '".$risk_cons_hazard."', '".$risk_cause."', '".$risk_like_score."', '".$risk_impact_score."', '".$risk_control_measure."', '".$risk_owner."', '".$risk_lastdate."', '".$risk_update_date."', '".$risk_rrls."', '".$risk_rris."', '".$risk_comments."')";
 $sql_pro=mysql_query("INSERT INTO tbl_risk_register(pid, risk_con_id, risk_no, risk_entry_date, risk_status, risk_cons_hazard, risk_cause, risk_like_score, risk_impact_score, risk_control_measure, risk_owner, risk_lastdate, risk_update_date, risk_rrls, risk_rris, risk_comments) Values(".$pid.",'".$risk_con_id."','".$risk_no."', '".$risk_entry_date."', '".$risk_status."', '".$risk_cons_hazard."', '".$risk_cause."', '".$risk_like_score."', '".$risk_impact_score."', '".$risk_control_measure."', '".$risk_owner."', '".$risk_lastdate."', '".$risk_update_date."', '".$risk_rrls."', '".$risk_rris."', '".$risk_comments."')");
	if ($sql_pro == TRUE) {
    $message=  "New record added successfully";
} else {
    $message= "Error in adding record1";
}
	
	
}

if(isset($_REQUEST['update']))
{
	
	$risk_entry_date=date('Y-m-d',strtotime($_REQUEST['risk_entry_date']));
	$risk_no=$_REQUEST['risk_no'];
	$risk_con_id=$_REQUEST['risk_con_id'];
	$risk_status=$_REQUEST['risk_status'];
	$risk_cons_hazard=$_REQUEST['risk_cons_hazard'];
	$risk_cause=$_REQUEST['risk_cause'];
	$risk_like_score=$_REQUEST['risk_like_score'];
	$risk_impact_score=$_REQUEST['risk_impact_score'];
	$risk_control_measure=$_REQUEST['risk_control_measure'];
	$risk_owner=$_REQUEST['risk_owner'];
	$risk_lastdate=date('Y-m-d',strtotime($_REQUEST['risk_lastdate']));
	$risk_update_date=date('Y-m-d'); 
	$risk_rrls=$_REQUEST['risk_rrls'];
	$risk_rris=$_REQUEST['risk_rris'];
	$risk_comments=$_REQUEST['risk_comments'];

	$message="";
	$pgid=1;
	$risk_id=$_REQUEST['risk_id'];
 $sql_pro="UPDATE tbl_risk_register SET risk_no='$risk_no',risk_con_id='$risk_con_id',risk_status='$risk_status',risk_cons_hazard='$risk_cons_hazard',risk_cause='$risk_cause',risk_like_score='$risk_like_score',risk_impact_score='$risk_impact_score', risk_control_measure='$risk_control_measure', risk_owner='$risk_owner',  risk_lastdate='$risk_lastdate',  risk_update_date='$risk_update_date', risk_rrls='$risk_rrls', risk_rris='$risk_rris', risk_comments='$risk_comments' where risk_id=$risk_id";
	
	$sql_proresult=mysql_query($sql_pro) or die(mysql_error());
	
	
	if ($sql_proresult == TRUE) {
    $message=  "Record updated successfully";
} else {
    $message= "Error in updating record";
}
	
//	$item_id='';
//	$description='';
//	$price='';
//	$display_order='';
	
header("Location: project_risk_info.php");
}
if(isset($_REQUEST['risk_id']))
{
$risk_id=$_REQUEST['risk_id'];

$pdSQL1="SELECT risk_id, pid, risk_con_id, risk_no, risk_entry_date, risk_status, risk_cons_hazard, risk_cause, risk_like_score, risk_impact_score, risk_control_measure, risk_owner, risk_lastdate, risk_update_date, risk_rrls, risk_rris, risk_comments FROM tbl_risk_register  where pid = ".$pid." and  risk_id = ".$risk_id;

$pdSQLResult1 = mysql_query($pdSQL1) or die(mysql_error());
$pdData1 = mysql_fetch_array($pdSQLResult1);

	$risk_no=$pdData1['risk_no'];
	$risk_con_id=$pdData1['risk_con_id'];
	$risk_entry_date=$pdData1['risk_entry_date'];
	$risk_status=$pdData1['risk_status'];
	$risk_cons_hazard=$pdData1['risk_cons_hazard'];
	$risk_cause=$pdData1['risk_cause'];
	$risk_like_score=$pdData1['risk_like_score'];
	$risk_impact_score=$pdData1['risk_impact_score'];
	$risk_control_measure=$pdData1['risk_control_measure'];
	$risk_owner=$pdData1['risk_owner'];
	$risk_lastdate=$pdData1['risk_lastdate'];
	$risk_update_date=$pdData1['risk_update_date']; 
	$risk_rrls=$pdData1['risk_rrls'];
	$risk_rris=$pdData1['risk_rris'];
	$risk_comments=$pdData1['risk_comments'];
	
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
  <script type="text/javascript">
		  $(function() {
			$( "#iss_date" ).datepicker();
		  });
		    $(function() {
			$( "#risk_entry_date" ).datepicker();
		  });
		</script>
</head>
<body>

<div id="wrap">
  <?php include 'includes/header.php'; ?>
<div id="content">
	 <table class="issues" width="100%" style="background-color:#FFF">
  <tr ><th><?php echo "Add Risk";?><span style="float:right"><form action="project_risk_info.php" method="post" enctype="multipart/form-data"><input type="submit" name="back" id="back" value="BACK" /></form></span></th></tr>
  <tr style="height:45%"><td align="center">
  <?php echo $message; ?>
  <form action="project_risk_input.php" target="_self" method="post" >
  <table class="issues" width="100%" style="background-color:#FFF">
  <tr>
    <td><strong>Risk Context:</strong></td>
    <td><select id="risk_con_id" name="risk_con_id">
      <option value="">Select Risk Context</option>
      <?php $pdSQLc = "SELECT *  FROM  tbl_risk_register_context  order by risk_con_id";
						 $pdSQLResultc = mysql_query($pdSQLc);
						$i=0;
							  if(mysql_num_rows($pdSQLResultc)>=1)
							  {
							  while($pdDatac = mysql_fetch_array($pdSQLResultc))
							  { 
							  $i++;?>
      <option value="<?php echo $pdDatac["risk_con_id"];?>" <?php if($risk_con_id==$pdDatac["risk_con_id"]) {?> selected="selected" <?php }?>><?php echo $pdDatac["risk_con_code"]."-".$pdDatac["ris_con_desc"];?></option>
      <?php } 
   }?>
    </select></td>
  </tr>
  <tr>
    <td width="21%"><strong>Risk Id:</strong></td><td width="79%"><input  type="text" name="risk_no" id="risk_no" value="<?php echo $risk_no; ?>" /></td></tr>
  <tr>
    <td><strong>Risk Entry Date:</strong></td>
    <td><input  type="text" name="risk_entry_date" id="risk_entry_date" value="<?php if(isset($risk_entry_date)&&$risk_entry_date!="0000-00-00"&&$risk_entry_date!="1970-01-01")echo $risk_entry_date; ?>" /></td>
  </tr>
  <tr>
    <td><strong>Risk Status:</strong></td>
    <td><input type="radio" id="risk_status" name="risk_status" value="1" checked="checked"/>
      <?php echo "Open";?>
      <input type="radio" id="risk_status" name="risk_status" value="0" <?php if($risk_status==0)  { ?>checked="checked" <?php }?>/>
      <?php echo "Close";?></td>
  </tr>
  <tr>
    <td><strong>Risk Consequence Hazard:</strong></td>
    <td><textarea rows="4" cols="50" name="risk_cons_hazard"><?php echo $risk_cons_hazard; ?></textarea></td>
  </tr>
  <tr>
    <td><strong>Risk Cause (Description):</strong></td>
    <td><textarea rows="4" cols="50" name="risk_cause"><?php echo $risk_cause; ?></textarea></td>
  </tr>
  <tr>
    <td><strong>Likelihood Score:</strong></td>
    <td><select id="risk_like_score" name="risk_like_score">
      <option value="">Select Likelihood Score</option>
      <?php $pdSQL = "SELECT *  FROM  tbl_risk_likelihood_rating  order by score";
						 $pdSQLResult = mysql_query($pdSQL);
						$i=0;
							  if(mysql_num_rows($pdSQLResult)>=1)
							  {
							  while($pdData = mysql_fetch_array($pdSQLResult))
							  { 
							  $i++;?>
      <option value="<?php echo $pdData["score"];?>" <?php if($risk_like_score==$pdData["score"]) {?> selected="selected" <?php }?>><?php echo $pdData["score"]."-".$pdData["like_per"]."-".$pdData["like_desc"];?></option>
      <?php } 
   }?>
    </select></td>
  </tr>
  <tr>
    <td><strong>Impact Score:</strong></td>
    <td><select id="risk_impact_score" name="risk_impact_score">
      <option value="">Select Impact Score</option>
      <?php $pdSQLi = "SELECT * FROM  tbl_risk_impact_rating  order by impact_score";
						 $pdSQLResulti = mysql_query($pdSQLi);
							$i=0;
							  if(mysql_num_rows($pdSQLResulti)>=1)
							  {
							  while($pdDatai = mysql_fetch_array($pdSQLResulti))
							  { 
							  $i++;?>
      <option value="<?php echo $pdDatai["impact_score"];?>" <?php if($risk_impact_score==$pdDatai["impact_score"]) {?> selected="selected" <?php }?>><?php echo $pdDatai["impact_score"]."-".$pdDatai["impact_desc"];?></option>
      <?php } 
   }?>
      </select></td>
  </tr>
  <tr>
    <td><strong>Risk Control Measure:</strong></td>
    <td><textarea rows="4" cols="50" name="risk_control_measure"><?php echo $risk_control_measure; ?></textarea></td>
  </tr>
  <tr>
    <td><strong>Risk Action Owner:</strong></td>
    <td><input  type="text" name="risk_owner" id="risk_owner" value="<?php echo $risk_owner; ?>" /></td>
  </tr>
  <tr>
    <td><strong>
      <label>Action By Date:</label>
    </strong></td><td><input  type="text" name="risk_lastdate" id="risk_lastdate" value="<?php if(isset($risk_lastdate)&&$risk_lastdate!="0000-00-00"&&$risk_lastdate!="1970-01-01")echo $risk_lastdate; ?>" /></td></tr>
  <tr>
    <td><strong>RRLS:</strong></td>
    <td><select id="risk_rrls" name="risk_rrls">
      <option value="">Select RRLS</option>
      <?php $pdSQL = "SELECT *  FROM  tbl_risk_likelihood_rating  order by score";
						 $pdSQLResult = mysql_query($pdSQL);
						$i=0;
							  if(mysql_num_rows($pdSQLResult)>=1)
							  {
							  while($pdData = mysql_fetch_array($pdSQLResult))
							  { 
							  $i++;?>
      <option value="<?php echo $pdData["score"];?>" <?php if($risk_rrls==$pdData["score"]) {?> selected="selected" <?php }?>><?php echo $pdData["score"]."-".$pdData["like_per"]."-".$pdData["like_desc"];?></option>
      <?php } 
   }?>
    </select></td>
  </tr>
  <tr>
    <td><strong>RRIS:</strong></td>
    <td><select id="risk_rris" name="risk_rris">
      <option value="">Select  RRIS</option>
      <?php $pdSQLi = "SELECT * FROM  tbl_risk_impact_rating  order by impact_score";
						 $pdSQLResulti = mysql_query($pdSQLi);
						$i=0;
							  if(mysql_num_rows($pdSQLResulti)>=1)
							  {
							  while($pdDatai = mysql_fetch_array($pdSQLResulti))
							  { 
							  $i++;?>
      <option value="<?php echo $pdDatai["impact_score"];?>" <?php if($risk_rris==$pdDatai["impact_score"]) {?> selected="selected" <?php }?>><?php echo $pdDatai["impact_score"]."-".$pdDatai["impact_desc"];?></option>
      <?php } 
   }?>
    </select></td>
  </tr>
  <tr>
    <td><strong>Comments/Additional Information:</strong></td><td><textarea rows="4" cols="50" name="risk_comments"><?php echo $risk_comments; ?></textarea></td></tr>
	  <tr>
	    <td>&nbsp;</td>
	    <td > <?php if(isset($_REQUEST['risk_id']))
	 {
		 
	 ?>
	      <input type="hidden" name="risk_id" id="risk_id" value="<?php echo $_REQUEST['risk_id']; ?>" />
	      <input  type="submit" name="update" id="update" value="<?php echo UPDATE?>" />
	      <?php
	 }
	 else
	 {
	 ?>
	      <input  type="submit" name="save" id="save" value="<?php echo SAVE;?>" />
	      <?php
	 }
	 ?> </td></tr>
	 </table>
	  
	  
  
  
  </form> 
  </td></tr>
  
  </table>
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
