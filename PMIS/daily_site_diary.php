<?php
error_reporting(E_ALL & ~E_NOTICE);
@require_once("requires/session.php");
$module			= "Daily Site Diary";
if ($uname==null)
{
	header("Location:index.php?init=3");
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


/*else if ($issueAdm_flag==0)
{
	header("Location: index.php?init=3");
}*/
$pid=1;

$edit			= $_GET['edit'];
$objDb  		= new Database( );
@require_once("get_url.php");
if(isset($_REQUEST['delete']))
{
mysql_query("Delete from tbl_daily_site_entry where dsid=".$_REQUEST['dsid']);
}

//===============================================

 $pdSQL = "SELECT a.dsid, a.did, a.wsid, a.item_name, a.item_desc, a.pdate, a.latitude, a.longitude, (select b.dname from tbl_district b where b.did=a.did) as district, (select c.wsname from tbl_wsscheme c where c.wsid=a.wsid) as water_supply FROM tbl_daily_site_entry a  order by a.pdate  DESC";
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
  <tr style="height:10%"><th><?php echo "Daily Site Diary";?></th>
  <th style="text-align:right; color:#FFF"> <?php if($pid != ""&&$pid!=0){?> <a href="#"  class="button"><?php echo ADD_NEW_REC;?></a><?php }?></th>
  </tr>
 
  <tr style="height:100%">
  <td align="center" colspan="2">
  
  <table class="issues_info" width="100%" style="background-color:#FFF" cellspacing="0">
                              <thead>
                                <tr>
                                  <th width="2%" style="text-align:center; font-size:13px; vertical-align:middle"><?php echo "#";?></th>
                                  
                                  <th width="10%" style="text-align:center; font-size:13px;">Component</th>
                                  <!--<th width="10%" style="text-align:center; font-size:13px;">Water Scheme</th>-->
                                  <th width="10%" style="text-align:center; font-size:13px;">Date</th>
                                  <th width="20%" style="text-align:center; font-size:13px;"><?php echo "Title";?></th>
                                  <th width="20%" style="text-align:center;font-size:13px;"><?php echo DETAIL;?></th>
							<?php /*?>	  <th width="20%" style="text-align:center;font-size:13px;"><?php echo STATUS;?></th>
								  <th width="10%" style="text-align:center;font-size:13px;"><?php echo ACTION;?></th><?php */?>
								  <th width="10%" style="text-align:center;font-size:13px;"><?php echo "Photo";?></th>
								 
								  <th width="10%" style="text-align:center;font-size:13px;">Action</th>
								  
								  
                                </tr>
                              </thead>
                              <tbody>
							  <?php
							  
							  if(mysql_num_rows($pdSQLResult)>=1)
							  {
								  $i=0;
							  while($pdData = mysql_fetch_array($pdSQLResult))
							  {
								  $pdSQL1 = "SELECT  * FROM photos where dsid=".$pdData["dsid"];
								  $pdSQLResult1 = mysql_query($pdSQL1);
								  $photodata=mysql_fetch_array($pdSQLResult1);
								  $i++; ?>
                        <tr>
                          <td align="center" style="font-size:13px"><?php echo $i;?></td>
                          <td align="left" style="font-size:13px"><?php echo $pdData['district'];?></td>
                         <!-- <td align="left" style="font-size:13px"><?php echo $pdData['water_supply'];?></td> -->
                          <td align="left" style="font-size:13px"><?php if($pdData['pdate']!=""|| $pdData['pdate']!="0000-00-00") echo date('d-m-Y',strtotime($pdData['pdate']));?></td>
                          <td align="left" style="font-size:13px"><?php echo $pdData['item_name'];?></td>
                          <td align="left" style="font-size:13px"><?php echo $pdData['item_desc'];?></td>
                          <td align="left" style="font-size:13px"> <a  href="<?php echo  "dailysitephotos/".$photodata['file_name']; ?>" data-lightbox="roadtrip" data-title="" style="text-decoration:none" ><img src="<?php echo "dailysitephotos/".$photodata['file_name']; ?>"  border="0" width="150px" height="112px" title=""/></a></td>
						 
						   <td align="center" style="font-size:13px; text-align:center">
						   <span style="float:right"><form action="daily_site_diary.php?dsid=<?php echo $pdData['dsid'] ?>" method="post"><input type="submit" name="delete" id="delete" value="<?php echo DEL;?>" onclick="return confirm('<?php echo DEL_MSG;?>')" /></form></span>
						   <span style="float:right">
						   <form action="#" method="post"><input type="submit" name="edit" id="edit" value="<?php echo EDIT;?>" /></form></span></td>
						  
                        </tr>
						<?php
						}
						}else
						{
						?>
						<tr>
                          <td colspan="8" ><?php echo NO_RECORD;?></td>
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
