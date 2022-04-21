<?php
error_reporting(E_ALL & ~E_NOTICE);
@require_once("requires/session.php");
$module		= "Manage Locations";
if ($uname==null  ) {
header("Location: index.php?init=3");
}
if($_SESSION['ne_user_type']!=1)
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
$objDb  		= new Database( );
@require_once("get_url.php");
$msg						= "";

 $pSQL = "SELECT max(pid) as pid from project";
						 $pSQLResult = mysql_query($pSQL);
						 $pData = mysql_fetch_array($pSQLResult);
						 $pid=$pData["pid"];
if(isset($_REQUEST['lcid']))
{
$lcid=$_REQUEST['lcid'];
$pdSQL1="SELECT lcid,lid, pid, title FROM  locations_component  WHERE  lcid = ".$lcid;
$pdSQLResult1 = mysql_query($pdSQL1) or die(mysql_error());
$pdData1 = mysql_fetch_array($pdSQLResult1);

$title=$pdData1['title'];
$lid=$pdData1['lid'];
}
if(isset($_REQUEST['delete'])&&isset($_REQUEST['lcid'])&$_REQUEST['lcid']!="")
{

$pdSQL = "SELECT * FROM  project_photos WHERE pid = ".$pid." and lcid=".$lcid." and ph_cap=$lid";
$pdSQLResult = mysql_query($pdSQL);
$sql_num=mysql_num_rows($pdSQLResult);
if($sql_num>=1)
{
	$message="Delete its photos first, then you will be able to delete canal";
	 $activity= $lid."_".$_REQUEST['lcid']." - Delete its photos first, then you will be able to delete canal";
	$iSQL = ("INSERT INTO pages_visit_log (log_id,request_url) VALUES ('$log_id','$activity')");
mysql_query($iSQL);
}
else
{
 mysql_query("Delete from  locations_component where lcid=".$_REQUEST['lcid']);
 $message="Canal deleted successfully";
 $activity= $lid."_".$_REQUEST['lcid']." - Canal deleted successfully";
 $iSQL = ("INSERT INTO pages_visit_log (log_id,request_url) VALUES ('$log_id','$activity')");
mysql_query($iSQL);
 header("Location: location_form.php");
}
// header("Location: location_form.php");
}


if(isset($_REQUEST['save']))
{ 
    $title=$_REQUEST['title'];
	$lid=$_REQUEST['lid'];
	$sql_pro=mysql_query("INSERT INTO  locations_component(lid,pid, title) Values(".$lid.",".$pid.", '".$title."' )");
	$insert_record=mysql_insert_id();
	if ($sql_pro == TRUE) {
    $message=  "New record added successfully";
	$activity= $lid."_".$insert_record." - New canal record added successfully";
	} else {
    $message= mysql_error($db);
	$activity= mysql_error($db);
	}
	
	$iSQL = ("INSERT INTO pages_visit_log (log_id,request_url) VALUES ('$log_id','$activity')");
mysql_query($iSQL);
	$title="";
	$lid="";
	//header("Location: location_form.php");
	
}

if(isset($_REQUEST['update']))
{
$title=$_REQUEST['title'];
$lid=$_REQUEST['lid'];
	 $sql_pro="UPDATE  locations_component SET title='$title',lid=$lid where lcid=$lcid";
	
	$sql_proresult=mysql_query($sql_pro) or die(mysql_error());
	
	
		if ($sql_proresult == TRUE) {
		$message=  "Record updated successfully";
		$activity= $lid."_".$lcid." - Canal Record updated successfully";
	} else {
		$message= mysql_error($db);
		$activity= mysql_error($db);
	}
	$iSQL = ("INSERT INTO pages_visit_log (log_id,request_url) VALUES ('$log_id','$activity')");
mysql_query($iSQL);
	$title="";
	$lid="";
//header("Location: location_form.php");
}
if(isset($_REQUEST['cancel']))
{
	print "<script type='text/javascript'>";
    print "window.location.reload();";
    print "self.close();";
    print "</script>";
}
?>
<script>
window.onunload = function(){
window.opener.location.reload();
};


  function required(){
	
	var x =document.getElementById("title").value;
	
	
	 if (x == "") {
    alert("Enter Location Name first");
    return false;
  		}
		
  
  }
  function cancelButton()
{
 window.opener.location.reload();
 self.close();
}
</script>
<link rel="stylesheet" type="text/css" href="css/style.css">
<div id="content">
<!--<h1> Location Control Panel</h1>-->
<table align="center">
  <tr style="height:10%">
    <td align="center" style="font-family:Verdana, Geneva, sans-serif; font-size:24px; font-weight:bold;"><span><?php echo LOCATIONS;?></span><span style="float:right">
    <form action="pictorial_form.php" method="post"><input type="submit" name="back" id="back" value="<?php echo BACK?>" /></form></span></td></tr>
  <tr ><td align="center">
  <?php echo $message; ?>
  <div id="LoginBox" class="borderRound borderShadow" >
  <form action="location_form.php" target="_self" method="post"  enctype="multipart/form-data" onsubmit="return required();">
 <table border="0"  height="23%" cellspacing="5" style="padding:5px 0 5px 5px; margin:5px 0 5px 5px;">
 <tr><td><label><?php echo "Component";?>:</label></td>
  <td>
  <select id="lid" name="lid" >
     <option value="0"><?php echo "SelectComponent"; ?></option>
  		<?php $pdSQL = "SELECT lid, pid, title, user_right, user_ids FROM  locations WHERE pid=".$pid." order by lid";
						 $pdSQLResult = mysql_query($pdSQL);
						$i=0;
							  if(mysql_num_rows($pdSQLResult)>=1)
							  {
							  while($pdData = mysql_fetch_array($pdSQLResult))
							  { 
							  $i++;
							  if($_SESSION['ne_user_type']==1)
							{?>
  <option value="<?php echo $pdData["lid"];?>" <?php if($lid==$pdData["lid"]) {?> selected="selected" <?php }?>><?php echo $pdData["title"];?></option>
   <?php }
   else
   {
	   
								$u_rightr=$pdData['user_right'];			
			$arrurightr= explode(",",$u_rightr);
			$arr_right_usersr=count($arrurightr);		
			 foreach($arrurightr as $key => $val) 
			 	{
			$arrurightr[$key] = trim($val);
			   $arightr= explode("_", $arrurightr[$key]);
			    if($arightr[0]==$user_cd)
						{
						
							if($arightr[1]==1)
							{
							$read_right=1;
							}
							else if($arightr[1]==2)
							{
							$read_right=2;
							}
							else if($arightr[1]==3)
							{
							$read_right=3;
							}
							if($read_right==1 || $read_right==3)
								  {	
								  ?>
                                  <option value="<?php echo $pdData["lid"];?>" <?php if($ph_cap==$pdData["lid"]) {?> selected="selected" <?php }?>><?php echo $pdData["title"];?></option>
                                  <?php
								  }
						}
				}
							
	   
   }} 
   }?>
  </select></td>
  </tr>
  <tr><td><label><?php echo "Sub Component";?>:</label></td>
  <td>
  <input type="text" name="title" id="title" value="<?php echo $title;?>"   size="100"/></td>
  </tr>
  
  <tr><td colspan="2"> <?php if(isset($_REQUEST['lcid']))
	 {
		 
	 ?>
     <input type="hidden" name="lcid" id="lcid" value="<?php echo $_REQUEST['lcid']; ?>" />
     <input  type="submit" name="update" id="update" value="<?php echo UPDATE;?>" />
	 <?php
	 }
	 else
	 {
	 ?>
	 <input  type="submit" name="save" id="save" value="<?php echo SAVE;?>" />
	 <?php
	 }
	 ?> <input  type="button" name="cancel" id="cancel" value="<?php echo CANCEL?>"   onclick="cancelButton();"/></td></tr>
	 </table>
	
  </form> 
  </div>
  </td></tr>
  </table>
<table style="width:100%; height:100%">
  <tr>
  <td>
   <div style="overflow-y: scroll; height:360px;">
  <table class="reference" style="width:100%">
                              <thead>
                                <tr bgcolor="#333333" style="text-decoration:inherit; color:#CCC">
                                  <th style="text-align:center; vertical-align:middle">#</th>
                                  <th width="20%" style="text-align:center"><?php echo "Component Name";?></th>
                                  <th width="50%" style="text-align:center"><?php echo TITLE;?></th>
                                
								
								 
								  <th style="text-align:center"><?php echo ACTION;?></th>
								
                                </tr>
                              </thead>
                              <tbody>
							  <?php
						
						 $pdSQL = "SELECT lcid,lid, pid, title FROM  locations_component WHERE pid=".$pData["pid"]." order by lid";
						 $pdSQLResult = mysql_query($pdSQL);
						$i=0;
							  if(mysql_num_rows($pdSQLResult)>=1)
							  {
							  while($pdData = mysql_fetch_array($pdSQLResult))
							  { 
							  				$lid=$pdData['lid'];
							  		$pdSQL1 = "SELECT title FROM  locations WHERE lid=$lid";
						 			$pdSQLResult1 = mysql_query($pdSQL1);
									$pdData1 = mysql_fetch_array($pdSQLResult1);
							  $i++;
							  ?>
                        <tr>
                          <td align="center"><?php echo $i;?></td>
                          <td align="center"><?php echo $pdData1['title'];?></td>
                          <td align="center"><?php echo $pdData['title'];?></td>
                         
						   <td align="right"><span style="float:left"><form action="location_form.php?lcid=<?php echo $pdData['lcid'] ?>" method="post"><input type="submit" name="edit" id="edit" value="Edit" /></form></span><span style="float:right"><form action="location_form.php?lcid=<?php echo $pdData['lcid'] ?>" method="post">
						    
						   <input type="submit" name="delete" id="delete" value="<?php echo DEL;?>" onclick="return confirm('<?php echo "Are you sure, You want to delete this canal and its photos";?>')" /></form>
						  </span>
						 </td>
                        </tr>
						<?php
						}
						}else
						{
						?>
						<tr>
                          <td colspan="4" >No Record Found</td>
                        </tr>
						<?php
						}
						?>
                            
                              </tbody>
                        </table>
                        </div>
                        </td>
                        </tr>
  </table>
</div>

<?php
	$objDb  -> close( );
?>
