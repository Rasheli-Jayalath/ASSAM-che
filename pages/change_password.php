<?php

$mode	= "I";
if($_SERVER['REQUEST_METHOD'] == "POST"){
	$flag 				= true;
	$current_password 	= trim($_POST['current_password']);
	$npassword 			= trim($_POST['npassword']);
	$cpassword 			= trim($_POST['c_password']);
	
	if(empty($current_password)){
		$flag 	= false;
		$objCommon->setMessage(CHANGEPWD_FLD_MSG_CURPWD,'Error');
	}
	if(empty($npassword)){
		$flag 	= false;
		$objCommon->setMessage(CHANGEPWD_FLD_MSG_NEWPWD,'Error');
	}
	if(empty($cpassword)){
		$flag 	= false;
		$objCommon->setMessage(CHANGEPWD_FLD_MSG_CNEWPWD,'Error');
	}
	if($npassword != $cpassword){
		$flag 	= false;
		$objCommon->setMessage(CHANGEPWD_FLD_MSG_DOESTMATCH,'Error');
	}
	 $sqlr="Select username from mis_tbl_users where user_cd=".$objAdminUser->ne_user_cd;
	$resr=mysql_query($sqlr);
	$row3r=mysql_fetch_array($resr);
	$objAdminUser->setProperty("username", $row3r['username']);
	$objAdminUser->setProperty("passwd", $current_password);
	$objAdminUser->lstAdminUser();
	if($objAdminUser->totalRecords() == 0){
		$flag 	= false;
		$objCommon->setMessage(CHANGEPWD_FLD_MSG_OLDPWDNOTMATCH,'Error');
	}
	if($flag != false){
		$user_cd = $_POST['user_cd'];
		$objAdminUser->resetProperty();
		$objAdminUser->setProperty("user_cd", $user_cd);
		$objAdminUser->setProperty("username", $row3r['username']);
		$objAdminUser->setProperty("passwd", $npassword);
		if($objAdminUser->changePassword()){
			$objCommon->setMessage('Password changed successfully.','Info');
			$activity="Password changed successfully by".$objAdminUser->ne_username;
				$sSQLlog_log = "INSERT INTO rs_tbl_user_log(user_id, epname, logintime, user_ip, user_pcname, url_capture) VALUES ('$uid', '$nameuser', '$nowdt', '$ipadd', '$hostname','$activity')";
				mysql_query($sSQLlog_log);		
			redirect('./?p=my_profile');
		}
	}
	extract($_POST);
}
else{
	$user_cd	= $objAdminUser->ne_user_cd;
	$objAdminUser->setProperty("user_cd", $user_cd);
	$objAdminUser->lstAdminUser();
	$data = $objAdminUser->dbFetchArray(1);
	$mode	= "U";
	extract($data);
}
?>
<script language="javascript" type="text/javascript">
function frmValidate(frm){
	var msg = "<?php echo _JS_FORM_ERROR;?>\r\n-----------------------------------------";
	var flag = true;
	if(frm.current_password.value == ""){
		msg = msg + "\r\n<?php echo CHANGEPWD_FLD_MSG_CURPWD;?>";
		flag = false;
	}
	if(frm.npassword.value == ""){
		msg = msg + "\r\n<?php echo CHANGEPWD_FLD_MSG_NEWPWD;?>";
		flag = false;
	}
	if(frm.c_password.value == ""){
		msg = msg + "\r\n<?php echo CHANGEPWD_FLD_MSG_CNEWPWD;?>";
		flag = false;
	}
	if(frm.npassword.value != frm.c_password.value){
		msg = msg + "\r\n<?php echo CHANGEPWD_FLD_MSG_DOESTMATCH;?>";
		flag = false;
	}
	if(flag == false){
		alert(msg);
		return false;
	}
}
</script>
<div id="wrapperPRight">
		<div id="pageContentName" class="shadowWhite"><?php echo CHANGEPWD_UPDATE_BRD;?></div>
		<div id="pageContentRight">
		
		</div>
		<div class="clear"></div>
	<?php echo $objCommon->displayMessage();?>
		<div class="clear"></div>
		<div class="NoteTxt"><?php echo _NOTE;?></div>
		<div id="tableContainer">
		
			<div class="clear"></div>			
	  	    <form name="frmPassword" id="frmPassword" action="" method="post" onSubmit="return frmValidate(this);">
        <input type="hidden" name="user_cd" id="user_cd" value="<?php echo $user_cd;?>" />
			<div class="formfield b shadowWhite"><?php echo CHANGEPWD_FLD_CPWD?> <span style="color:#FF0000;">*</span>:</div>
			<div class="formvalue"><input class="rr_input" type="password" name="current_password" id="current_password" /></div>
			<div class="clear"></div>
			
			<div class="formfield b shadowWhite"><?php echo CHANGEPWD_FLD_NPWD?> <span style="color:#FF0000;">*</span>:</div>
			<div class="formvalue"><input class="rr_input" type="password" name="npassword" id="npassword" /></div>
			<div class="clear"></div>
			
			<div class="formfield b shadowWhite"><?php echo CHANGEPWD_FLD_CNPWD?> <span style="color:#FF0000;">*</span>:</div>
			<div class="formvalue"><input class="rr_input" type="password" name="c_password" id="c_password" /></div>
			<div class="clear"></div>
		
			<div id="submit">
			
			  <input type="submit" class="SubmitButton" value="Save" /></div>
			  <div id="submit2">
             <input type="button" class="SubmitButton" value=" Cancel " onClick="document.location='./?p=my_profile';"  />
			</div>
			
			<div class="clear"></div>
			
			
            </form>
			<div class="clear"></div>
  	    </div>
	</div>