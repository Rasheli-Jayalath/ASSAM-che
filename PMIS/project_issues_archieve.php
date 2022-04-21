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


//===============================================


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
  <tr style="height:10%"><th><?php echo ARCH_ISS;?></th>
  <th style="text-align:right; color:#FFF"> <?php if($pid != ""&&$pid!=0){?> <a href="project_issues_input.php"  class="button"><?php echo ADD_NEW_REC;?></a>  &nbsp;  <a href="project_issues_info.php"  class="button"><?php echo CURRENT_ISS;?></a><?php }?></th>
  </tr>
 
  <tr style="height:100%">
  <td align="center" colspan="2">
  <table class="issues_info" width="100%" style="background-color:#FFF" cellspacing="0">
                              <thead>
                                <tr>
                                  <th width="5%" style="text-align:center; font-size:13px;"><?php echo "Serial No.";?></th>                                
                                  <th width="5%" style="text-align:center; font-size:13px;"><?php echo COMP;?></th>
                                  <th width="2%" style="text-align:center; font-size:13px; vertical-align:middle"> #</th>
                                  <th width="15%" style="text-align:center; font-size:13px;"><?php echo TITLE;?></th>
                                  <th width="28%" style="text-align:center;font-size:13px;"><?php echo DETAIL;?></th>
                                  <th width="10%" style="text-align:center;font-size:13px;"><?php echo ATTACH;?></th>
								  <th width="10%" style="text-align:center;font-size:13px;"><?php echo STATUS;?></th>
								    <th width="10%" style="text-align:center;font-size:13px;"><?php echo ACTION;?></th>
								  <th width="10%" style="text-align:center;font-size:13px;"><?php echo REMARKS;?></th>
								  <th width="10%" style="text-align:center;font-size:13px;" colspan="2"><?php echo ACTION;?></th>					  
                                </tr>
                              </thead>
                              <tbody>
							  <?php
							     if(isset($_REQUEST['comp_id']) && $_REQUEST['comp_id']!="")
							 {
								  $compid=$_REQUEST['comp_id'];
								 $pdSQLcn = "SELECT * FROM  component_tbl where comp_id=$compid";
							 }
							 else
							 {
								  $pdSQLcn = "SELECT * FROM  component_tbl order by comp_id";
							 }
							 
						      $pdSQLResultcn = mysql_query($pdSQLcn);
							  $i=1;
							  while($compdata=mysql_fetch_array($pdSQLResultcn))
							  {
								  
								 $cmpid= $compdata['comp_id'];
									 if($_SESSION['ne_user_type']==1)
									{
								  ?>
                                  <tr>
                          		<td colspan="11"  style="font-weight:bold; font-size:14; background: #FFB062"><?php echo $compdata['comp_name'];?></td>
                        		</tr>
                                  <?php
									}
									else
									{
										
			$u_rightr=$compdata['user_right'];			
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
                       
						 
									  ?>
                                      <tr>
                          		<td colspan="11"  style="font-weight:bold; font-size:14; background: #FFB062"><?php echo $compdata['comp_name'];?></td>
                        		</tr>
                           <?php
						   
						}
						 
				}
						   
									}
						
								 
							 $pdSQL = "SELECT nos_id, pid, iss_no, iss_title, iss_detail, iss_status, iss_action, iss_remarks, attachment, comp_id FROM t012issues where pid=$pid and iss_status=0 and comp_id=$cmpid";
							 
							   $pdSQL .= " order by iss_no";
							$pdSQLResult = mysql_query($pdSQL);
							  
							  
							  
							  if(mysql_num_rows($pdSQLResult)>=1)
							  {
								  $counter=0;
							  while($pdData = mysql_fetch_array($pdSQLResult))
							  { 
							 
							  ?>
                              <?php  
							
                          if($_SESSION['ne_user_type']==1)
							{
				
							
								   ?>
                        <tr>
                        <td align="center" style="font-size:13px"><?php echo ++$counter; ?></td>                        
                        <td align="center" style="font-size:13px"><?php  echo $compdata['comp_name'];
							  ?></td>
                          <td align="center" style="font-size:13px"><?php echo $pdData['iss_no'];?></td>
                          <td align="left" style="font-size:13px"><?php echo $pdData['iss_title'];?></td>
                          <td align="left" style="font-size:13px"><?php echo $pdData['iss_detail'];?></td>
                          <td align="center" style="text-align:center">
                          <?php if($pdData['attachment']!=""){?>
                          <a href="<?php echo "project_data/issues/".$pdData['attachment'];?>" target="_blank">
                          <img src="images/pdf.png" width="50" height="50"/></a>
                          <?php
						  }
						  ?></td>
                          <td align="center" style="font-size:13px"><?php if($pdData['iss_status']==0) echo Archived;?></td>
                          <td align="left" style="font-size:13px"><?php echo $pdData['iss_action'];?></td>
						  <td align="left" style="font-size:13px"><?php echo $pdData['iss_remarks'];?></td>						 
						    
						   <td align="center" style="font-size:13px; text-align:center">
						    <span style="float:right">
						   <form action="project_issues_input.php?nos_id=<?php echo $pdData['nos_id'] ?>" method="post"><input type="submit" name="edit" id="edit" value="<?php echo EDIT;?>" /></form></span>
						  
						   </td>					  
								    <td align="right">
						   <span style="float:right"><form action="project_issues_info.php?nos_id=<?php echo $pdData['nos_id'] ?>" method="post"><input type="submit" name="delete" id="delete" value="<?php echo DEL;?>" onclick="return confirm('Are you sure?')" /></form></span>
						    </td>
                            </tr>
						   <?php
						   
						  
						   }
						   else
						   {
			$u_rightr=$compdata['user_right'];			
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
                       
						 
									  ?>
                                      <tr>
                        <td align="center" style="font-size:13px"><?php echo ++$counter; ?></td>                        
                        <td align="center" style="font-size:13px"><?php  echo $compdata['comp_name'];
							  ?></td>
                          <td align="center" style="font-size:13px"><?php echo $pdData['iss_no'];?></td>
                          <td align="left" style="font-size:13px"><?php echo $pdData['iss_title'];?></td>
                          <td align="left" style="font-size:13px"><?php echo $pdData['iss_detail'];?></td>
                          <td align="center" style="text-align:center">
                          <a href="<?php echo "project_data/".$pdData['attachment'];?>" target="_blank">
                          <img src="images/pdf.png" width="50" height="50"/></a></td>
                          <td align="center" style="font-size:13px"><?php if($pdData['iss_status']==1) echo "Pending"; else echo "Closed";?></td>
                          <td align="left" style="font-size:13px"><?php echo $pdData['iss_action'];?></td>
						  <td align="left" style="font-size:13px"><?php echo $pdData['iss_remarks'];?></td>
                         <?php if($read_right==1 || $read_right==3)
								  {	
								  ?>
                                      <td align="center" style="font-size:13px; text-align:center">
						    <span style="float:right">
						   <form action="project_issues_input.php?nos_id=<?php echo $pdData['nos_id'] ?>" method="post"><input type="submit" name="edit" id="edit" value="<?php echo EDIT;?>" /></form></span>
						  
						   </td>				
                           <?php
								  }
								  if($read_right==3)
								  {
								   ?>
                                   <td align="right">
						   <span style="float:right"><form action="project_issues_info.php?nos_id=<?php echo $pdData['nos_id'] ?>" method="post"><input type="submit" name="delete" id="delete" value="<?php echo DEL;?>" onclick="return confirm('Are you sure?')" /></form></span>
						    </td>
                            <?php							   
						   }
						   ?>
                           </tr>
                           <?php
						   
						}
						 
				}
						   }
						   ?>
						  
                        
						<?php
						}
						}else
						{
						?>
						<tr>
                          <td colspan="11" ><?php echo NO_RECORD;?></td>
                        </tr>
						<?php
						}
						$i=$i+1;
						}
						?>
                            
                              </tbody>
        </table>
  
  <?php /*?><table class="issues_info" width="100%" style="background-color:#FFF" cellspacing="0">
                              <thead>
                                <tr>
                                  <th width="2%" style="text-align:center; font-size:13px; vertical-align:middle"><?php echo ISS_NO;?></th>
                                  <th width="20%" style="text-align:center; font-size:13px;"><?php echo TITLE;?></th>
                                  <th width="28%" style="text-align:center;font-size:13px;"><?php echo DETAIL;?></th>
								  <th width="20%" style="text-align:center;font-size:13px;"><?php echo STATUS;?></th>
								  <th width="10%" style="text-align:center;font-size:13px;"><?php echo ACTION;?></th>
								  <th width="10%" style="text-align:center;font-size:13px;"><?php echo REMARKS;?></th>
								 
								  <th width="10%" style="text-align:center;font-size:13px;"><?php echo ACTION;?></th>
								  
								  
                                </tr>
                              </thead>
                              <tbody>
							  <?php
							  
							  if(mysql_num_rows($pdSQLResult)>=1)
							  {
							  while($pdData = mysql_fetch_array($pdSQLResult))
							  { ?>
                        <tr>
                          <td align="center" style="font-size:13px"><?php echo $pdData['iss_no'];?></td>
                          <td align="left" style="font-size:13px"><?php echo $pdData['iss_title'];?></td>
                          <td align="left" style="font-size:13px"><?php echo $pdData['iss_detail'];?></td>
                          <td align="left" style="font-size:13px"><?php 
						  if($pdData['iss_status']==1) 
						  { 
						  echo ACTIVE;
						   } else  { echo INACTVE; }?></td>
                          <td align="left" style="font-size:13px"><?php echo $pdData['iss_action'];?></td>
						  <td align="left" style="font-size:13px"><?php echo $pdData['iss_remarks'];?></td>
						 
						   <td align="center" style="font-size:13px; text-align:center">
						   <span style="float:right"><form action="project_issues_info.php?iss_id=<?php echo $pdData['iss_id'] ?>" method="post"><input type="submit" name="delete" id="delete" value="<?php echo DEL;?>" onclick="return confirm('<?php echo DEL_MSG;?>')" /></form></span>
						   <span style="float:right">
						   <form action="project_issues_input.php?iss_id=<?php echo $pdData['iss_id'] ?>" method="post"><input type="submit" name="edit" id="edit" value="<?php echo EDIT;?>" /></form></span></td>
						  
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
                        </table><?php */?></td></tr>
  
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
