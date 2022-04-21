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
$pSQL = "SELECT max(pid) as pid from project";
$pSQLResult = mysql_query($pSQL);
$pData = mysql_fetch_array($pSQLResult);
$pid=$pData["pid"];
$edit			= $_GET['edit'];
$objDb  		= new Database( );
@require_once("get_url.php");
//===============================================
if(isset($_REQUEST['delete'])&&isset($_REQUEST['dgid'])&$_REQUEST['dgid']!="")
{

 mysql_query("Delete from  t0101designprogress where dgid=".$_REQUEST['dgid']);
 header("Location: sp_design.php");
}
$pdSQL = "SELECT a.dgid, a.pgid, a.pid, a.serial, a.description, a.total, a.submitted, a.revision, a.approved, a.approvedpct, a.unit, a.item_id , a.remarks, b.title ,b.item_id FROM t014majoritems b left join  t0101designprogress a on (a.item_id=b.item_id)   order by a.item_id, a.dgid ";
$pdSQLResult = mysql_query($pdSQL);
 
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
 <table class="issues" width="100%" style="background-color:#FFF" cellspacing="0">
  <tr style="height:10%"><th>Design Progress</th>
  <th style="text-align:right; color:#FFF">
   <?php  if($dpentry_flag==1 || $dpadm_flag==1)
	{
	?>
   <?php if($pid != ""&&$pid!=0){?>  <a class="button"  href="javascript:void(null);" onclick="window.open('items_form.php', 'Upload Photos ','width=470px,height=550px,toolbar=0,menubar=0,location=0,status=0,scrollbars=0,resizable=0,left=0,top=0');"  style="margin:5px; text-decoration:none">Add Major Items</a> &nbsp;<a href="sp_design_input.php"  class="button">Add New Record</a><?php }}?></th>
  </tr>
  <tr style="height:100%">
  <td align="center" colspan="2">
 
 <table class="issues_info" width="100%" style="background-color:#FFF" cellspacing="0">
                              <thead>
                                <tr>
                                  <th width="5%" style="text-align:center; vertical-align:middle">S#</th>
                                  <th width="30%" style="text-align:center">Description</th>
                                  <th width="5%" style="text-align:center">Unit</th>
                                  <th width="5%" style="text-align:center">Total</th>
                                  <th width="5%" style="text-align:center">Design Submitted </th>
								  <th width="5%" style="text-align:center">Under Revision</th>
								  <th width="5%" style="text-align:center">Approved</th>
								  <th width="5%" style="text-align:center">Approval %</th>
								  <th width="5%" style="text-align:center">Remarks</th>
								  <?php if($dpentry_flag==1 || $dpadm_flag==1)
								  {
								   ?>
								<th width="10%" style="text-align:center" colspan="2">Action</th>
								  <?php
								  }
								  ?>
								  
								 
								  
                                </tr>
                              </thead>
                              <tbody>
							  <?php
							  $current=0;
							  $prev=0;
							  if(mysql_num_rows($pdSQLResult)>=1)
							  {
							  while($pdData = mysql_fetch_array($pdSQLResult))
							  { 
							  $current=$pdData["item_id"];
							  
							  if($prev!=$current)
							  {?>
                              <tr>
                          <td align="left" colspan="13" style="text-transform:capitalize; font-size:16px"><span ><strong><?php echo $pdData['title'];?></strong></span></td>
                         
                        </tr>
                              <?php } ?>
                         <?php if($pdData['description']!='')
							  {?>     
                        <tr>
                          <td align="center"><?php echo $pdData['serial'];?></td>
                          <td align="left"><?php echo $pdData['description'];?></td>
                          <td align="left"><?php echo $pdData['unit'];?></td>
                          <td align="right"><?php echo number_format($pdData['total'],2);?></td>
                          <td align="right"><?php echo number_format($pdData['submitted'],2);?></td>
                          <td align="right"><?php echo number_format($pdData['revision'],2);?></td>
                          <td align="right"><?php echo number_format($pdData['approved'],2);?></td>
                          <td align="right"><?php echo number_format($pdData['approvedpct'],2)."%";?></td>
                          <td align="right"><?php echo $pdData['remarks'];?></td>
						   
						   
						    <?php  if($dpentry_flag==1 || $dpadm_flag==1)
								  {
								   ?>
							<td align="right">
						   <span style="float:right"><form action="sp_design_input.php?dgid=<?php echo $pdData['dgid'] ?>" method="post"><input type="submit" name="edit" id="edit" value="Edit" /></form></span>
						     </td>
						   <?php  
							}
							if($ncfadm_flag==1)
								  {
								   ?>
						   <td align="right">
						   <span style="float:right"><form action="sp_design.php?dgid=<?php echo $pdData['dgid'] ?>" method="post"><input type="submit" name="delete" id="delete" value="Del" onclick="return confirm('Are you sure?')" /></form></span></td>
						  <?php
						   }
						   ?>
                        </tr>
                        <?php }?>
						<?php
						$prev=$current;
						}
						}else
						{
						?>
						<tr>
                          <td colspan="7" >No Record Found</td>
                        </tr>
						<?php
						}
						?>
                            
                              </tbody>
                        </table>
						
						</td></tr>
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
