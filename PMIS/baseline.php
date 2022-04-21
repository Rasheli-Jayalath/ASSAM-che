<?php
error_reporting(E_ALL & ~E_NOTICE);
@require_once("requires/session.php");
$module		="Baseline";
$edit= $_GET['edit'];
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

if ($uname==null  ) {
header("Location: index.php?init=3");
}
else if ($res_flag==0) {
header("Location: index.php?init=3");
}
$objDb  = new Database( );
$objDbD  = new Database( );
$objDbI  = new Database( );
$objDbII  = new Database( );
$objDbB  = new Database( );
$objDbBQ  = new Database( );
@require_once("get_url.php");
$msg						= "";
$saveBtn					= $_REQUEST['save']; 
$updateBtn					= $_REQUEST['update'];
$clear						= $_REQUEST['clear'];
$next						= $_REQUEST['next'];
$delete						= $_REQUEST['delete'];
$txtresource				= mysql_real_escape_string($_REQUEST['txtresource']);
$txtunit					= $_REQUEST['txtunit'];
$base_code					= $_REQUEST['base_code'];
$txtquantity				= $_REQUEST['txtquantity'];
$baseline_unit_id			= 1;
$temp_id				    = 1;
$boq_id				        = $_REQUEST['txtboqcode'];
$boq_ids				    = $_POST['txtboqcodem'];
if($clear!="")
{
$txtresource				= '';
$txtunit					= '';
$txtquantity				= '';
$txtschedulecode 			= '';
$txtboqcode 				= '';
}

if($saveBtn != "")
{	
	$sSQL = ("INSERT INTO baseline (base_desc,base_code,unit,quantity,unit_type,temp_id) VALUES ('".mysql_real_escape_string($txtresource)."','".mysql_real_escape_string($base_code)."','".mysql_real_escape_string($txtunit)."',$txtquantity, '$baseline_unit_id', '$temp_id')");
	$objDb->execute($sSQL);
	$txtid = $objDb->getAutoNumber();
	$resource_id = $txtid;
	$msg="Saved!";
	header("Location: baseline.php");
	/*$log_module  = "resources Module";
	$log_title   = "Add Resource Record";
	$log_ip      = $_SERVER['REMOTE_ADDR'];	*/
	

}


if($updateBtn !=""){
	
  $uSql = "Update baseline SET 
		 base_desc           	= '".mysql_real_escape_string($txtresource)."',
		 base_code				= '".mysql_real_escape_string($base_code)."',
		 unit					= '".mysql_real_escape_string($txtunit)."',
		 quantity				= $txtquantity,
		 unit_type				=  $baseline_unit_id,
		 temp_id				= '$temp_id'
		 where rid 				= $edit";
		  
 	if($objDb->execute($uSql)){
		

     $dSQL = ("DELETE FROM baseline_mapping_boqs where rid=$edit");
	$objDbD->execute($dSQL);  
	$bSQL = ("INSERT INTO baseline_mapping_boqs (rid, boqid) VALUES ('$edit','$boq_id')");
	$objDbB->execute($bSQL);
	if(!empty($boq_ids))
	{
	foreach($boq_ids as $boq_id)
	{
		$sbSQL = ("INSERT INTO baseline_mapping_boqs (rid, boqid) VALUES ('$edit','$boq_id')");
	    $objDbBQ->execute($sbSQL);
	}
	}
	}
	
	header("Location: baseline.php");
}


if($delete != ""){

$eSql_child2 = "update activity set rid=0, secheduleid='0' where rid=$delete";
mysql_query($eSql_child2);
$eSql_plrid= "delete from planned where rid=$delete";
mysql_query($eSql_plrid);
$eSql_pgrid = "delete from progress where rid=$delete";
mysql_query($eSql_pgrid);
$eSql_rid = "delete from baseline where rid=$delete";
mysql_query($eSql_rid);

header("Location: baseline.php");	
}


if($edit != ""){
 $eSql = "Select * from baseline where rid='$edit'";
  $objDb -> query($eSql);
  $eCount = $objDb->getCount();
	if($eCount > 0){
	  $rid_e 					= $objDb->getField($i,rid);
	  $resource_e 					= $objDb->getField($i,base_desc);
	  $base_code_e						= $objDb->getField($i,base_code);
	  $unit_e						= $objDb->getField($i,unit);
	  $quantity_e					= $objDb->getField($i,quantity);
	  $temp_id_e					= $objDb->getField($i,temp_id);
	  $unit_type_e					= $objDb->getField($i,unit_type);
	  $btemb="Select * from baseline_template where temp_id=$temp_id_e";
	  $resbtempb=mysql_query($btemb);
      $row3tmpgb=mysql_fetch_array($resbtempb);
	  $temp_id_e=$row3tmpgb["temp_id"];
	  $temp_title_e=$row3tmpgb["temp_title"];
	  $use_data_e=$row3tmpgb["use_data"];
	  $temp_is_default_e= $row3tmpgb["temp_is_default"];
	   //$temp_id_e					= $objDb->getField($i,temp_id);
	 	
	}
}
$pquery = "Select * from project";
				$presult = mysql_query($pquery);
				$presultd = mysql_fetch_array($presult);
				$pdata = mysql_num_rows($presult);
				$project_type=$presultd["ptype"];
	if(isset($_REQUEST["edit"])&&$_REQUEST["edit"]!=0)
	{
		$bcount="";
		$bquery = "Select * from boq where boqid=".$_REQUEST["edit"];
		$bresult = mysql_query($bquery);
		$bcount = mysql_num_rows($bresult);
	}				
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include ('includes/metatag.php'); ?>
<link rel="stylesheet" type="text/css" href="css/style.css">
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="datepickercode/jquery-ui.css" />
<script type="text/javascript" src="datepickercode/jquery-1.10.2.js"></script>
<script type="text/javascript" src="datepickercode/jquery-ui.js"></script>
<script>
function showResult(strmodule,strresource,strtunit,strquantity,strschedulecode,strboqcode) {
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
  xmlhttp.open("GET","search.php?module="+strmodule+"&resource="+strresource+"&unit="+strtunit+"&quantity="+strquantity+"&schedulecode="+strschedulecode+"&boqcode="+strboqcode,true);
  xmlhttp.send();
}

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

<!--<script>
function getLocked(status)
{

if(status=="Pending" || status=="Paid")
{
document.getElementById("txtlocked").value="Locked";
	 document.getElementById("txtlocked").disabled=true;
}
else
{
document.getElementById("txtlocked").value="Unlocked";
	 document.getElementById("txtlocked").disabled=false;
}
	
}
</script>-->
<style>
.label1
{
	text-align:left;
}
</style>
</head>
<body>
<div id="wrap">
  <?php include 'includes/header.php'; ?>
<div id="content">
	  <form name="frmresources" id="frmresources" action=""  method="post" onsubmit="" enctype="multipart/form-data">
	  <table width="100%" border="0"  align="center" cellpadding="1" cellspacing="1" style="padding-left:10px" >
            <tr>
            <tr><td style="color:#0C6; font-size:12px; text-align:center"><?php if($msg!="") echo $msg; ?></td></tr>
              <td valign="top"><table style="padding-top:10px" class="baseform" width="109%">
            <tr>
              <td colspan="2" class="label1"><h1><?php echo ADD_RESOURCE;?></h1></td>
            </tr>
           
            
              <tr>
                <td class="label1"><?php echo CODE;?>:</td>
                <td colspan="2" ><div id="baselinecodediv"><input type="text"  name="base_code" id="base_code" value="<?php echo $base_code_e; ?>" /></div></td>
              </tr>
              <tr>
              <td width="43%" class="label1"> <?php echo NAME;?>:</t d>
              <td colspan="2" >
                <div id="baselinediv">
			 <input type="text"  name="txtresource" id="txtresource" value="<?php echo $resource_e; ?>" /> 
             </div> </td>
             </tr>
			<tr>
			  <td class="label1"> <?php echo UNIT;?>:</td>
              <td colspan="2" >
              <div id="baselineunitdiv">
			 <input type="text"  name="txtunit" id="txtunit" value="<?php echo $unit_e; ?>" /> 
             </div>
              </td>
             </tr>
			<tr>
			  <td class="label1"><?php echo QTY_AMNT;?>:</td>
              <td colspan="2"  > <div id="baselineqtydiv">
              <input type="text"  name="txtquantity" id="txtquantity" value="<?php echo $quantity_e; ?>" /></div> </td>
            </tr>
        <?php /*?>    <tr>
              <td class="label1">&nbsp;</td>
              <td class="label1">Schedule Code:</td>
              <td ><input id="txtschedulecode" name="txtschedulecode" type="text" value="<?php echo $schedulecode; ?>"/></td>
             </tr><?php */?>
			 
			<tr>
			 <td height="39"></td>
			 <td align="left" colspan="3"  >
			 <?php
			  if($resentry_flag==1 || $resadm_flag==1)
				{
	
			  if($edit!=""){?>
			  <input type="submit" value="Update" name="update" />
			  <?php } else { ?>
			  <input type="submit" value="Save" name="save" id="save" />
			  &nbsp;&nbsp;<input type="submit" value="Clear" name="clear"  />
			  <?php }
			  
			  } ?></td>
			 </tr>
            
             </table></td>
              <td width="66%" rowspan="13" valign="top"><div id="templatedata" style="height:450px; overflow:scroll">
			  <table class="reference" style="width:100%" >
                <tr bgcolor="#333333" style="text-decoration:inherit; color:#CCC; vertical-align:middle">
                  <th align="center" width="2%"><strong>#</strong></th>
                  <th align="center" width="5%"><?php echo CODE;?></th>
                  <th align="center" width="25%"><strong><?php echo NAME;?></strong></th>
                  <th width="10%"><strong><?php echo UNIT;?></strong></th>
                  <th width="15%"><strong><?php echo QTY_AMNT;?></strong></th>
                  <th align="center" width="10%"><strong><?php echo ACTION;?></strong></th>
                  <?php /*?> <th align="center" width="10%"><strong>Log </strong></th><?php */?>
                </tr>
                <strong>
                <?php
 $sSQL = " Select * from baseline ";
 $objDb->query($sSQL);
 $iCount = $objDb->getCount( );
 if($iCount>0)
 {
	for ($i = 0 ; $i < $iCount; $i ++)
	{
	  $rid 							= $objDb->getField($i,rid);
	  $res_code 					= $objDb->getField($i,base_code);
	  $resource 					= $objDb->getField($i,base_desc);
	  $unit 						= $objDb->getField($i,unit);
	  $quantity 					= $objDb->getField($i,quantity);
	  //$schedulecode 				= $objDb->getField($i,schedulecode);
	 // $boqcode 						= $objDb->getField($i,boqcode);
if ($i % 2 == 0) {
	$style = ' style="background:#f1f1f1;"';
} else {
	$style = ' style="background:#ffffff;"';
}
?>
                </strong>
                <tr <?php echo $style; ?>>
                  <td width="5px"><center>
                    <?php echo $i+1;?>
                  </center></td>
                  <td width="210px"><?php echo $res_code;?></td>
                  <td width="210px"><?php echo $resource;?></td>
                  <td width="100px"><?php echo $unit;?></td>
                  <td width="210px" align="right"><?php echo  number_format($quantity, 2, '.', '');?></td>
                  <td style="border-bottom:1px solid #cccccc" width="210px" >&nbsp;
                    <?php  if($resentry_flag==1 || $resadm_flag==1)
	{
	?>
                    <a href="baseline.php?edit=<?php echo $rid;?>"  >Edit</a>
                    <?php } ?>
                    <?php  if($resadm_flag==1)
	{
	?>
                    | <a href="baseline.php?delete=<?php echo $rid;?>"  onclick="return confirm('Are you sure you want to delete this Baseline Item?')" >Delete</a>
                  <?php
  }
  ?></td>
                  <?php /*?><td width="210px" align="right" ><a href="log.php?trans_id=<?php echo $rid ; ?>&amp;module=<?php echo $module?>" target="_blank">Log</a></td><?php */?>
                </tr>
                <?php        
	}
	}
?>
              </table></div></td>
            </tr>
            
 		</table>
     </form>
	
</div>
  <?php include ("includes/footer.php"); ?>
</div>
</body>
</html>
<?php
	$objDb  -> close( );
?>
