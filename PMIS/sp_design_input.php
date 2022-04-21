<?php
error_reporting(E_ALL & ~E_NOTICE);
@require_once("requires/session.php");
$module			= "Design Progress";
if ($uname==null)
{
	header("Location:index.php?init=3");
}
else if ($dp_flag==0)
{
	header("Location: index.php?init=3");
}
$defaultLang = 'en';

//if ($pid=="" ) 
//{
//header("Location: project_calender.php");
//}

$user_cd=$uid;
header("Content-Type: text/html; charset=utf-8");
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
 $pSQL = "SELECT max(pid) as pid from project";
						 $pSQLResult = mysql_query($pSQL);
						 $pData = mysql_fetch_array($pSQLResult);
						 $pid=$pData["pid"];

if(isset($_REQUEST['save']))
{
	
	$serial=$_REQUEST['serial'];
	$description=$_REQUEST['description'];
	$total=$_REQUEST['total'];
	$submitted=$_REQUEST['submitted'];
	$revision=$_REQUEST['revision'];
	$approved=$_REQUEST['approved'];
	$approvedpct=$_REQUEST['approvedpct'];
	$item_id=$_REQUEST['item_id'];
	$unit=$_REQUEST['unit'];
	$remarks=$_REQUEST['remarks'];
	$message="";
	$pgid=1;
$sql_pro=mysql_query("INSERT INTO t0101designprogress (pid, serial, description, total, submitted, revision, approved, 
approvedpct,item_id,unit,remarks) Values(".$pid.",".$serial.", '".$description."', '".$total."' , '".$submitted."' , '".$revision."' , '".$approved."' , '".$approvedpct."' , ".$item_id.", '".$unit."' , '".$remarks."' )");

	if ($sql_pro == TRUE) {
    $message=  "New record added successfully";
} else {
    $message= mysql_error($db);
}
 	$serial='';
	$description='';
	$total = '';
	$submitted='';
	$revision='';
	$approved='';
	$approvedpct='';
	$unit='';
	$item_id='';
	$remarks='';
}

if(isset($_REQUEST['update']))
{
	$dgid=$_REQUEST['dgid'];
	$serial=$_REQUEST['serial'];
	$description=$_REQUEST['description'];
	$total=$_REQUEST['total'];
	$submitted=$_REQUEST['submitted'];
	$revision=$_REQUEST['revision'];
	$approved=$_REQUEST['approved'];
	$approvedpct=$_REQUEST['approvedpct'];
	$item_id=$_REQUEST['item_id'];
	$unit=$_REQUEST['unit'];
	 $remarks=$_REQUEST['remarks'];
	$message="";
	$pgid=1;
	
$sql_pro="UPDATE t0101designprogress SET serial='$serial', description='$description', total = $total, submitted=$submitted, revision=$revision, approved=$approved, approvedpct=$approvedpct , item_id='$item_id' , unit='$unit' ,remarks='$remarks' where dgid=$dgid";
	
	$sql_proresult=mysql_query($sql_pro) or die(mysql_error());
	
	
	if ($sql_proresult == TRUE) {
    $message=  "Record updated successfully";
} else {
    $message= mysql_error($db);
}
	
//	$item_id='';
//	$description='';
//	$price='';
//	$display_order='';
	
//header("Location: sp_design.php");
}
if(isset($_REQUEST['dgid']))
{
$dgid=$_REQUEST['dgid'];

$pdSQL1="SELECT dgid, pgid, pid, serial, description, total, submitted, revision, approved, approvedpct,item_id,unit, remarks FROM t0101designprogress  where pid = ".$pid." and  dgid = ".$dgid;

$pdSQLResult1 = mysql_query($pdSQL1) or die(mysql_error());
$pdData1 = mysql_fetch_array($pdSQLResult1);

	$serial=$pdData1['serial'];
	$description=$pdData1['description'];
	$total=$pdData1['total'];
	$submitted=$pdData1['submitted'];
	$revision=$pdData1['revision'];
	$approved=$pdData1['approved'];
	$approvedpct=$pdData1['approvedpct'];
	$item_id=$pdData1['item_id'];
	$unit=$pdData1['unit'];
	$remarks=$pdData1['remarks'];
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
</head>
<body>

<div id="wrap">
  <?php include 'includes/header.php'; ?>
<div id="content">
   <table class="issues" width="100%" style="background-color:#FFF">
  <tr ><th>Design Progress<span style="float:right"><form action="sp_design.php" method="post"><input type="submit" name="back" id="back" value="BACK" /></form></span></th></tr>
  <tr style="height:45%"><td align="center">
  <?php echo $message; ?>
  <form action="sp_design_input.php" target="_self" method="post" >
  <table class="issues" width="100%" style="background-color:#FFF">
  <tr><td><label>Serial #:</label></td><td><input  type="text" name="serial" id="serial" value="<?php echo $serial; ?>" /></td></tr>
  
    <tr>
      <td><label>Major Item:</label></td>
      <td><select id="item_id" name="item_id">
      <option value="">Select Major Item</option>
      <?php $pdSQL = "SELECT item_id, pid, title FROM  t014majoritems  order by item_id";
						 $pdSQLResult = mysql_query($pdSQL);
						$i=0;
							  if(mysql_num_rows($pdSQLResult)>=1)
							  {
							  while($pdData = mysql_fetch_array($pdSQLResult))
							  { 
							  $i++;?>
  <option value="<?php echo $pdData["item_id"];?>" <?php if($item_id==$pdData["item_id"]) {?> selected="selected" <?php }?>><?php echo $pdData["title"];?></option>
   <?php } 
   }?>
      </select></td>
    </tr>
    <tr><td><label>Description:</label></td><td><input  type="text" name="description" id="description" value="<?php echo $description; ?>" /></td></tr>
    <tr>
      <td><label>Unit:</label></td>
      <td><input  type="text" name="unit" id="unit" value="<?php echo $unit; ?>" /></td>
    </tr>
   
     <tr><td><label>Total:</label></td><td><input  type="text" name="total" id="total" value="<?php echo $total; ?>" /></td></tr>
     <tr><td><label>Design Submitted:</label></td><td><input  type="text" name="submitted" id="submitted" value="<?php echo $submitted; ?>" /></td></tr>

     <tr><td><label>Under Revision:</label></td><td><input  type="text" name="revision" id="revision" value="<?php echo $revision; ?>" /></td></tr>
	
	  <tr><td><label>Approved :</label></td><td><input  type="text" name="approved" id="approved" value="<?php echo $approved; ?>" /></td></tr>
	 
	  <tr>
	    <td>Approval %:</td><td><input  type="text" name="approvedpct" id="approvedpct" value="<?php echo $approvedpct; ?>" /></td></tr>
	  <tr>
	    <td><label>Remarks :</label></td>
	    <td><input  type="text" name="remarks" id="remarks" value="<?php echo $remarks; ?>" /></td>
	    </tr>
	  <tr><td colspan="2"> <?php if(isset($_REQUEST['dgid']))
	 {
		 
	 ?>
	    <input type="hidden" name="dgid" id="dgid" value="<?php echo $_REQUEST['dgid']; ?>" />
	    <input  type="submit" name="update" id="update" value="Update" />
	    <?php
	 }
	 else
	 {
	 ?>
	    <input  type="submit" name="save" id="save" value="Save" />
	    <?php
	 }
	 ?> <input  type="submit" name="cancel" id="cancel" value="Cancel" /></td></tr>
	 </table>
	  
	  
  
  
  </form> 
  </td></tr>
  
  </table>
  </figure>
</div>
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
