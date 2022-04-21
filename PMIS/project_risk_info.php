<?php
error_reporting(E_ALL & ~E_NOTICE);
@require_once("requires/session.php");
$module			= "Risk Register";
if ($uname==null)
{
	header("Location:index.php?init=3");
}
else if ($dp_flag==0)
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
$pSQL = "SELECT max(pid) as pid from project";
$pSQLResult = mysql_query($pSQL);
$pData = mysql_fetch_array($pSQLResult);
$pid=$pData["pid"];
$edit			= $_GET['edit'];
$objDb  		= new Database( );
@require_once("get_url.php");
//===============================================
if(isset($_REQUEST['delete'])&&isset($_REQUEST['risk_id'])&$_REQUEST['risk_id']!="")
{

 mysql_query("Delete from   tbl_risk_register where risk_id=".$_REQUEST['risk_id']);
 header("Location: sp_design.php");
}
$pdSQL="SELECT a.*, b.* FROM `tbl_risk_register` a inner join tbl_risk_register_context b on(a.risk_con_id=b.risk_con_id) ";
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
  <tr style="height:10%"><th colspan="3">Risk Register</th>
  <th width="19%" style="text-align:right; color:#FFF">
    <?php  if($dpentry_flag==1 || $dpadm_flag==1)
	{
	?>
    <?php if($pid != ""&&$pid!=0){?>  <a class="button"  href="javascript:void(null);" onclick="window.open('items_form.php', 'Upload Photos ','width=470px,height=550px,toolbar=0,menubar=0,location=0,status=0,scrollbars=0,resizable=0,left=0,top=0');"  style="margin:5px; text-decoration:none">Add Risk Context</a> &nbsp;<a href="project_risk_input.php"  class="button">Add New Risk</a><?php }}?></th>
  </tr>
  
  <tr>
  <td width="37%" >
    <table width="43%" cellpadding="0" cellspacing="0" class="issues_info" style="width:75%; vertical-align:center; text-align:center">
      
      <tr style="vertical-align:center; text-align:center">
        <th colspan="5">Likelihood Rating</th>
      </tr>
      <tr style="vertical-align:center; text-align:center">
        <th colspan="2" style="vertical-align:center; text-align:center">Score</th>
        <th colspan="2" style="vertical-align:center; text-align:center">Likelihood</th>
        <th width="188" style="vertical-align:center; text-align:center">Description</th>
        </tr>
      <tr style="vertical-align:center; text-align:center">
        <td colspan="2" style="vertical-align:center; text-align:center">1</td>
        <td colspan="2" style="vertical-align:center; text-align:center">10%</td>
        <td style="vertical-align:center; text-align:center">Unlikely</td>
        </tr>
      <tr style="vertical-align:center; text-align:center">
        <td colspan="2" style="vertical-align:center; text-align:center">2</td>
        <td colspan="2" style="vertical-align:center; text-align:center">25%</td>
        <td style="vertical-align:center; text-align:center">Remote</td>
        </tr>
      <tr style="vertical-align:center; text-align:center">
        <td colspan="2" style="vertical-align:center; text-align:center">3</td>
        <td colspan="2" style="vertical-align:center; text-align:center">50%</td>
        <td style="vertical-align:center; text-align:center">Occasional</td>
        </tr>
      <tr style="vertical-align:center; text-align:center">
        <td colspan="2" style="vertical-align:center; text-align:center">4</td>
        <td colspan="2" style="vertical-align:center; text-align:center">75%</td>
        <td style="vertical-align:center; text-align:center">Likely</td>
        </tr>
      <tr style="vertical-align:center; text-align:center">
        <td colspan="2" style="vertical-align:center; text-align:center">5</td>
        <td colspan="2" style="vertical-align:center; text-align:center">99%</td>
        <td style="vertical-align:center; text-align:center">Very Likely</td>
        </tr>
    </table> </td>
  <td width="26%" ><table cellspacing="0" cellpadding="0" class="issues_info" style="width:75%">
    
    <tr>
      <th colspan="6" width="156" style="vertical-align:center; text-align:center">Impact Rating</th>
    </tr>
    <tr>
      <th colspan="2" style="vertical-align:center; text-align:center">Score</th>
      <th colspan="4" style="vertical-align:center; text-align:center">Description</th>
    </tr>
    <tr>
      <td colspan="2" style="vertical-align:center; text-align:center">1</td>
      <td colspan="4" style="vertical-align:center; text-align:center">No Impact</td>
    </tr>
    <tr>
      <td colspan="2" style="vertical-align:center; text-align:center">2</td>
      <td colspan="4" style="vertical-align:center; text-align:center">Low</td>
    </tr>
    <tr>
      <td colspan="2" style="vertical-align:center; text-align:center">3</td>
      <td colspan="4" style="vertical-align:center; text-align:center">Medium</td>
    </tr>
    <tr>
      <td colspan="2" style="vertical-align:center; text-align:center">4</td>
      <td colspan="4" style="vertical-align:center; text-align:center">High</td>
    </tr>
    <tr>
      <td colspan="2" style="vertical-align:center; text-align:center">5</td>
      <td colspan="4" style="vertical-align:center; text-align:center">Very high</td>
    </tr>
  </table></td>
  <td colspan="2" style="vertical-align:top; text-align:center"><table width="10%" cellpadding="0" cellspacing="0" class="issues_info" style="width:55%">
    
    <tr>
      <th colspan="2" style="vertical-align:center; text-align:center">Risk    Score Rating &amp; Color Code</th>
    </tr>
    <tr>
      <td bgcolor="#FF0000" style="vertical-align:center; text-align:center; background:#F00" >More than 12</td>
      <td  style="vertical-align:center; text-align:center;background:#F00">High</td>
    </tr>
    <tr>
      <td style="vertical-align:center; text-align:center; background-color:#FF0">6 to 12</td>
      <td style="vertical-align:center; text-align:center;background-color:#FF0"">Medium</td>
      </tr>
    <tr>
      <td style="vertical-align:center; text-align:center; background-color:#0F0">Less than 6</td>
      <td style="vertical-align:center; text-align:center;background-color:#0F0">Low</td>
      </tr>
  </table></td>
  </tr>
  
  <tr style="height:100%">
  <td  colspan="4">
 
 <table class="issues_info" width="100%" style="background-color:#FFF; margin:0;border:1px solid #d4d4d4" cellspacing="0">
                              <thead>
                                <tr style="border:1px solid #d4d4d4">
                                  <th width="2%" style="text-align:center; vertical-align:middle">Risk ID</th>
                                  <th width="2%" style="text-align:center">Risk Status</th>
                                  <th width="15%" style="text-align:center">Risk Consequence Hazard</th>
                                  <th width="15%" style="text-align:center">Risk Cause (Description)</th>
                                  <th width="4%" style="text-align:center">Likelihood Score </th>
								  <th width="4%" style="text-align:center">Impact Score</th>
								  <th width="4%" style="text-align:center">Risk Score</th>
								  <th width="15%" style="text-align:center">Risk Control Measure</th>
								  <th width="8%" style="text-align:center">Risk Action Owner</th>
                                  <th width="8%" style="text-align:center">Action By Date</th>
                                  <th width="4%" style="text-align:center">RRLS</th>
                                  <th width="4%" style="text-align:center">RRIS</th>
                                  <th width="4%" style="text-align:center">RRS</th>
                                  <th width="15%" style="text-align:center">Comments</th>
                                 
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
							  $current=$pdData["risk_con_id"];
							  
							  if($prev!=$current)
							  {?>
                              <tr>
                          <td align="left" colspan="20" style="text-transform:capitalize; font-size:16px"><span ><strong><?php echo $pdData['risk_con_code']."-".$pdData['ris_con_desc'];?></strong></span></td>
                         
                        </tr>
                              <?php } ?>
                         <?php if($pdData['risk_no']!='')
							  {
								  $totl_impact=0;
								  $rss=0;
								  $totl_impact_color='';
								  $rss_color='';
								  $totl_impact=$pdData['risk_impact_score']*$pdData['risk_impact_score'];
								  $rss=$pdData['risk_rrls']*$pdData['risk_rris'];
								  $colr_qury="select * from tbl_risk_score_rating_color where risk_score_low_val<=". $totl_impact." AND risk_score_high_val>=".$totl_impact;
								  $col_SQLResult = mysql_query($colr_qury);
								  if ($col_SQLResult == TRUE) {
									  $col_data=mysql_fetch_array($col_SQLResult);
									 
								  }
								 $rrs_colr_qury="Select * from tbl_risk_score_rating_color where risk_score_low_val<=". $rss." AND risk_score_high_val>".$rss;
								  $rrs_col_SQLResult = mysql_query($rrs_colr_qury);
								  if ($rrs_col_SQLResult == TRUE) {
									  
									  $rrs_col_data=mysql_fetch_array($rrs_col_SQLResult);
									 $rss_color=$rrs_col_data["risk_color"];
								  }?>     
                        <tr>
                          <td align="center"><?php echo $pdData['risk_no'];?></td>
                          <td style="text-align:center;vertical-align:middle;"><?php if($pdData['risk_status']==1) echo "Open"; else "Close";?></td>
                          <td align="left" style="text-align:center; vertical-align:middle"><?php echo $pdData['risk_cons_hazard'];?></td>
                          <td align="left" style="text-align:center; vertical-align:middle"><?php echo $pdData['risk_cause'];?></td>
                          <td style="text-align:center; vertical-align:middle"><?php echo $pdData['risk_like_score'];?></td>
                          <td style="text-align:center;vertical-align:middle"><?php echo $pdData['risk_impact_score'];?></td>
                          <td style="text-align:center; vertical-align:middle;background-color:<?php echo $col_data["risk_color"];?>" ><?php echo $totl_impact;?></td>
                          <td style="text-align:center; vertical-align:middle"><?php echo $pdData['risk_control_measure'];?></td>
                          <td style="text-align:center;vertical-align:middle;"><?php echo $pdData['risk_owner'];?></td>
                          <td style="text-align:center;vertical-align:middle;"><?php echo date('d-m-Y',strtotime($pdData['risk_lastdate']));?></td>
                          <td style="text-align:center;vertical-align:middle;"><?php echo $pdData['risk_rrls'];?></td>
                          <td style="text-align:center;vertical-align:middle;"><?php echo $pdData['risk_rris'];?></td>
                          <td style="text-align:center;vertical-align:middle;background-color:<?php echo $rss_color;?>"><?php echo $rss ;?></td>
                          <td style="text-align:center; vertical-align:middle"><?php echo $pdData['risk_comments'];?></td>
						   
						   
						    <?php  if($dpentry_flag==1 || $dpadm_flag==1)
								  {
								   ?>
							<td align="right">
						   <span style="float:right"><form action="project_risk_input.php?risk_id=<?php echo $pdData['risk_id'] ?>" method="post"><input type="submit" name="edit" id="edit" value="Edit" /></form></span>
						     </td>
						   <?php  
							}
							if($ncfadm_flag==1)
								  {
								   ?>
						   <td align="right">
						   <span style="float:right"><form action="project_risk_info.php?risk_id=<?php echo $pdData['risk_id'] ?>" method="post"><input type="submit" name="delete" id="delete" value="Del" onclick="return confirm('Are you sure?')" /></form></span></td>
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
