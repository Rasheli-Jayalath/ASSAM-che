<?php
error_reporting(E_ALL & ~E_NOTICE);
@require_once("requires/session.php");
$module			= "Issues";
if ($uname==null)
{
	header("Location:index.php?init=3");
}
else if ($issueAdm_flag==0)
{
	header("Location: index.php?init=3");
}
$pid=1;
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
$objDb  		= new Database( );
@require_once("get_url.php");
if(isset($_REQUEST['delete']))
{
mysql_query("Delete from t012issues where iss_id=".$_REQUEST['iss_id']);
}

//===============================================

 $pdSQL = "SELECT iss_id, pid, iss_no, iss_title, iss_detail, iss_status, iss_action, iss_remarks, comp_id FROM t012issues where pid=$pid";
 $counter = 0;
 if(isset($_REQUEST['iss_status'])&&$_REQUEST['iss_status']!="")
 {
	  $pdSQL .= " AND iss_status=".$_REQUEST['iss_status'];
 }
  if(isset($_REQUEST['comp_id'])&&$_REQUEST['comp_id']!="")
 {
	  $pdSQL .= " AND comp_id=".$_REQUEST['comp_id'];
 }
  $pdSQL .= " order by iss_no";
$pdSQLResult = mysql_query($pdSQL);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include ('includes/metatag.php'); ?>
<script>
function doFilter(frm){
	var qString = '';
	if(frm.comp_id.value != ""){
		qString += 'comp_id=' + escape(frm.comp_id.value);
	}
	if(frm.iss_status.value != ""){
		qString += '&iss_status=' + escape(frm.iss_status.value);
	}
	
	document.location = 'project_issues_info.php?' + qString;
}


</script>
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
	  <table class="issues" width="100%" style="background-color:#FFF" cellspacing="0">
            <form action="" target="_self" method="post"  enctype="multipart/form-data">
  <tr style="height:10%"><th><?php echo MAJ_ISS;?></th>
  
  <th style="text-align:right; color:#FFF">
  
<?php echo COMP; ?>:  <select id="comp_id" name="comp_id" onchange="getDates(this.value)" style="width:242px">
     	<option value=""><?php echo COMP ?></option>
  		<?php $pdSQLc = "SELECT * FROM  component_tbl WHERE project_id=".$pid." order by comp_id";
						 $pdSQLResultc = mysql_query($pdSQLc);
						$i=0;
							  if(mysql_num_rows($pdSQLResultc)>=1)
							  {
							  while($pdDatac = mysql_fetch_array($pdSQLResultc))
							  { 
							  $i++;?>
  <option value="<?php echo $pdDatac["comp_id"];?>" <?php if($_REQUEST['comp_id']==$pdDatac["comp_id"]) {?> selected="selected" <?php }?>><?php echo $pdDatac["comp_name"];?></option>
   <?php } 
   }?>
  </select> Status : <select id="iss_status" name="iss_status" >
  <option value="">Select Status</option>
  <option value="1" <?php if($_REQUEST["iss_status"]==1) {?> selected="selected" <?php }?>>Pending</option>
  <option value="2" <?php if($_REQUEST["iss_status"]==2) {?> selected="selected" <?php }?>>Closed</option>
  
  </select>
  <input type="button"  onclick="doFilter(this.form);" class="SubmitButton" name="Submit" id="Submit" value=" <?php echo VIEW; ?> " />

   <?php  if($ncfentry_flag==1 || $ncfadm_flag==1)
	{
	?>
   <?php if($pid != ""&&$pid!=0){?> <a href="project_issues_input.php"  class="button"><?php echo ADD_NEW_REC;?></a>&nbsp;  <a href="project_issues_archieve.php"  class="button"><?php echo ARCH_ISS; ?></a><?php } }?></th>
  </tr>
  </form>
 
 
  <tr style="height:100%">
  <td align="center" colspan="2">
  
  <table class="issues_info" width="100%" style="background-color:#FFF" cellspacing="0">
                              <thead>
                                <tr>
                                  <th width="5%" style="text-align:center; font-size:13px;"><?php echo "Serial No.";?></th>                                
                                  <th width="5%" style="text-align:center; font-size:13px;"><?php echo COMP;?></th>                                
                                  <th width="2%" style="text-align:center; font-size:13px; vertical-align:middle"><?php echo ISS_NO;?></th>
                                  <th width="20%" style="text-align:center; font-size:13px;"><?php echo TITLE;?></th>
                                  <th width="28%" style="text-align:center;font-size:13px;"><?php echo DETAIL;?></th>
								  <th width="20%" style="text-align:center;font-size:13px;"><?php echo STATUS;?></th>
								  <th width="10%" style="text-align:center;font-size:13px;"><?php echo ACTION;?></th>
								  <th width="10%" style="text-align:center;font-size:13px;"><?php echo REMARKS;?></th>
								 
								  <?php if($ncfentry_flag==1 || $ncfadm_flag==1)
								  {
								   ?>
								 <th width="10%" style="text-align:center;font-size:13px;" colspan="2"><?php echo ACTION;?></th>
								  <?php
								  }
								  ?>
								 
								  
								  
                                </tr>
                              </thead>
                              <tbody>
							  <?php
							  
							  if(mysql_num_rows($pdSQLResult)>=1)
							  {
							  while($pdData = mysql_fetch_array($pdSQLResult))
							  { ?>
                        <tr>
                          <td align="center" style="font-size:13px"><?php echo ++$counter; ?></td>                        
                        <td align="center" style="font-size:13px"><?php  if($pdData['comp_id']!=0&&$pdData['comp_id']!="")
							  {
							  $pdSQLcn = "SELECT * FROM  component_tbl WHERE comp_id=".$pdData['comp_id']." order by comp_id";
						      $pdSQLResultcn = mysql_query($pdSQLcn);
							  $compdata=mysql_fetch_array($pdSQLResultcn);
							  if($compdata['comp_name']!="")echo $compdata['comp_name'];
							  }?></td>
                        
                          <td align="center" style="font-size:13px"><?php echo $pdData['iss_no'];?></td>
                          <td align="left" style="font-size:13px"><?php echo $pdData['iss_title'];?></td>
                          <td align="left" style="font-size:13px"><?php echo $pdData['iss_detail'];?></td>
                          <td align="left" style="font-size:13px"><?php 
						  if($pdData['iss_status']==1) 
						  { 
						  echo ACTIVE;
						   } else  { echo INACTIVE; }?></td>
                          <td align="left" style="font-size:13px"><?php echo $pdData['iss_action'];?></td>
						  <td align="left" style="font-size:13px"><?php echo $pdData['iss_remarks'];?></td>
						   <?php  if($_SESSION['ne_user_cd']==1 || $_SESSION['ne_user_cd']==41)
			{
			?>

						   <td align="center" style="font-size:13px; text-align:center">
						   <span style="float:right"><form action="project_issues_info.php?iss_id=<?php echo $pdData['iss_id'] ?>" method="post"><input type="submit" name="delete" id="delete" value="<?php echo DEL;?>" onclick="return confirm('<?php echo DEL_MSG;?>')" /></form></span>
						   </td>
                           <td align="center" style="font-size:13px; text-align:center">
						   <span style="float:right">
                           <form action="project_issues_input.php?iss_id=<?php echo $pdData['iss_id'] ?>" method="post"><input type="submit" name="edit" id="edit" value="<?php echo EDIT;?>" /></form></span></td>
       			<?php
			}
			else
			{
			?>
            <td></td><td></td>
			<?php
			}
			?>
                        </tr>
						<?php
						}
						}else
						{
						?>
						<tr>
                          <td colspan="7" ><?php echo NO_RECORD;?></td>
                        </tr>
						<?php
						}
						?>
                            
                              </tbody>
                        </table></td></tr>
  
  </table>

	<br clear="all" />

</div>
  <?php include ("includes/footer.php"); ?>
</div>
</body>
</html>
<?php
	$objDb  -> close( );
?>
