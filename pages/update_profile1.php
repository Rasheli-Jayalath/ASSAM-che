<?php
error_reporting(E_ALL & ~E_NOTICE);
$mode	= "I";
if($_SERVER['REQUEST_METHOD'] == "POST"){
	$flag 			= true;
	$first_name		= trim($_POST['first_name']);
	$username		= trim($_POST['username']);
	$last_name 		= trim($_POST['last_name']);
	$passwd 		= trim($_POST['passwd']);
	$email_old 		= trim($_POST['email_old']);
	$email 			= trim($_POST['email']);
	$designation	= trim($_POST["designation"]);
	$phone 			= trim($_POST['phone']);
	$mode 			= trim($_POST['mode']);
	$sadmin			= $_POST["sadmin"];
	$news			= $_POST["news"];
	$newsadm 		= $_POST['newsadm'];
	$newsentry 		= $_POST['newsentry'];
	
	$res			= $_POST["res"];
	$resadm 		= $_POST['resadm'];
	$resentry 		= $_POST['resentry'];
	
	
	$mdata			= $_POST["mdata"];
	$mdataadm 		= $_POST['mdataadm'];
	$mdataentry 	= $_POST['mdataentry'];
	$mile			= $_POST["mile"];
	$mileadm 		= $_POST['mileadm'];
	$mileentry 		= $_POST['mileentry'];
	$spg			= $_POST["spg"];
	$spgadm 		= $_POST['spgadm'];
	$spgentry 		= $_POST['spgentry'];
	
	$kpi			= $_POST["kpi"];
	$kpiadm 		= $_POST['kpiadm'];
	$kpientry 		= $_POST['kpientry'];
	
	$cam			= $_POST["cam"];
	$camadm 		= $_POST['camadm'];
	$camentry 		= $_POST['camentry'];
	
	$boq			= $_POST["boq"];
	$boqadm 		= $_POST['boqadm'];
	$boqentry 		= $_POST['boqentry'];
	
	$ipc			= $_POST["ipc"];
	$ipcadm 		= $_POST['ipcadm'];
	$ipcentry 		= $_POST['ipcentry'];
	
	$eva			= $_POST["eva"];
	$evaadm 		= $_POST['evaadm'];
	$evaentry 		= $_POST['evaentry'];
	
	$padm			= $_POST["padm"];
	
	$actd 			= $_POST['actd'];
	
	$miled 			= $_POST['miled'];
	
	$kpid 			= $_POST['kpid'];
	
	$camd 			= $_POST['camd'];
	
	$kfid 			= $_POST['kfid'];
	
	$evad 			= $_POST['evad'];
	
	$pic			= $_POST["pic"];
	$picadm 		= $_POST['picadm'];
	$picentry 		= $_POST['picentry'];
	
	$process 			= $_POST['process'];
	
	
	
	
	
	/*$designation= trim($_POST['designation']);*/
	/*if(isset($_POST['user_type'])&&$_POST['user_type']!="")
	 $user_type= trim($_POST['user_type']);*/
	
	if(empty($first_name)){
		$flag 	= false;
		$objCommon->setMessage(USER_FLD_MSG_FIRSTNAME,'Error');
	}
	if(empty($last_name)){
		$flag 	= false;
		$objCommon->setMessage(USER_FLD_MSG_LASTNAME,'Error');
	}
	if(empty($email)){
		$flag 	= false;
		$objCommon->setMessage(USER_FLD_MSG_EMAIL,'Error');
	}
	if(!$objValidate->checkEmail($email)){
		$flag 	= false;
		$objCommon->setMessage(USER_FLD_MSG_INVALID_EMAIL,'Error');
	}
	# Check whether the email address is changed.
	if($email_old != $email){
		$objAdminUser->setProperty("email", $email);
		$objAdminUser->checkAdminEmailAddress();
		if($objAdminUser->totalRecords() >= 1){
			$flag 	= false;
			$objCommon->setMessage(USER_FLD_MSG_EXISTS_EMAIL,'Error');
		}
	}
	if($flag != false){
		$user_cd = ($mode == "U") ? $_POST['user_cd'] : 
		$objAdminUser->genCode("mis_tbl_users", "user_cd");
		
		$objAdminUser->resetProperty();
		$objAdminUser->setProperty("user_cd", $user_cd);
		$objAdminUser->setProperty("username", $username);
		$objAdminUser->setProperty("passwd", $passwd);
		$objAdminUser->setProperty("first_name", $first_name);
		/*$objAdminUser->setProperty("middle_name", $middle_name);*/
		$objAdminUser->setProperty("last_name", $last_name);
		$objAdminUser->setProperty("email", $email);
		$objAdminUser->setProperty("phone", $phone);
		$objAdminUser->setProperty("designation", $designation);
		$objAdminUser->setProperty("sadmin", $sadmin);
		$objAdminUser->setProperty("news", $news);
		$objAdminUser->setProperty("newsadm", $newsadm);
		$objAdminUser->setProperty("newsentry", $newsentry);
		
		$objAdminUser->setProperty("res", $res);
		$objAdminUser->setProperty("resadm", $resadm);
		$objAdminUser->setProperty("resentry", $resentry);
		
		$objAdminUser->setProperty("mdata", $mdata);
		$objAdminUser->setProperty("mdataadm", $mdataadm);
		$objAdminUser->setProperty("mdataentry", $mdataentry);
		$objAdminUser->setProperty("mile", $mile);
		$objAdminUser->setProperty("mileadm", $mileadm);
		$objAdminUser->setProperty("mileentry", $mileentry);
		
		$objAdminUser->setProperty("spg", $spg);
		$objAdminUser->setProperty("spgadm", $spgadm);
		$objAdminUser->setProperty("spgentry", $spgentry);
		
		$objAdminUser->setProperty("kpi", $kpi);
		$objAdminUser->setProperty("kpiadm", $kpiadm);
		$objAdminUser->setProperty("kpientry", $kpientry);
		
		$objAdminUser->setProperty("cam", $cam);
		$objAdminUser->setProperty("camadm", $camadm);
		$objAdminUser->setProperty("camentry", $camentry);
		
		$objAdminUser->setProperty("boq", $boq);
		$objAdminUser->setProperty("boqadm", $boqadm);
		$objAdminUser->setProperty("boqentry", $boqentry);
		
		$objAdminUser->setProperty("ipc", $ipc);
		$objAdminUser->setProperty("ipcadm", $ipcadm);
		$objAdminUser->setProperty("ipcentry", $ipcentry);
		
		$objAdminUser->setProperty("eva", $eva);
		$objAdminUser->setProperty("evaadm", $evaadm);
		$objAdminUser->setProperty("evaentry", $evaentry);
		
		$objAdminUser->setProperty("padm", $padm);
		
		$objAdminUser->setProperty("actd", $actd);
		
		$objAdminUser->setProperty("miled", $miled);
		
		$objAdminUser->setProperty("kpid", $kpid);
		
		$objAdminUser->setProperty("camd", $camd);
		
		$objAdminUser->setProperty("kfid", $kfid);
		
		$objAdminUser->setProperty("evad", $evad);
		
		$objAdminUser->setProperty("pic", $pic);
		$objAdminUser->setProperty("picadm", $picadm);
		$objAdminUser->setProperty("picentry", $picentry);
		
		$objAdminUser->setProperty("process", $process);
		
		
		
		
		//$objAdminUser->setProperty("user_type", $user_type);
		if($objAdminUser->actAdminUser($_POST['mode'])){
			
			if($mode=="U")
			{
			$objCommon->setMessage(USER_FLD_MSG_SUCCESSFUL_UPDATE,'Update');
			}
			else
			{
			$objCommon->setMessage("New User added successfully",'Info');
			}
			
				/*if($objAdminUser->user_type==1)
				redirect('./?p=user_mgmt');
				else
				redirect('./?p=user_mgmt');*/
				

		}
	}
	extract($_POST);
}
else{
if(isset($_GET['user_cd']) && !empty($_GET['user_cd']))
	{	
	 $user_cd = $_GET['user_cd'];
	if(isset($user_cd) && !empty($user_cd)){
		$objAdminUser->setProperty("user_cd", $user_cd);
		$objAdminUser->lstAdminUser();
		$data = $objAdminUser->dbFetchArray(1);
		$mode	= "U";
		extract($data);

	}
	}
	
}
?>
<script language="javascript" type="text/javascript">
function frmValidate(frm){
	var msg = "<?php echo _JS_FORM_ERROR;?>\r\n-----------------------------------------";
	var flag = true;
	if(frm.first_name.value == ""){
		msg = msg + "\r\n<?php echo USER_FLD_MSG_FIRSTNAME;?>";
		flag = false;
	}

	if(frm.email.value == ""){
		msg = msg + "\r\n<?php echo USER_FLD_MSG_EMAIL;?>";
		flag = false;
	}
	if(flag == false){
		alert(msg);
		return false;
	}
}
</script>
<div id="wrapperPRight">
		<div id="pageContentName" class="shadowWhite"><?php echo ($mode == "U") ? USER_UPDATE_BRD : USER_ADD_BRD;?></div>
		
		<div class="clear"></div>
	<?php echo $objCommon->displayMessage();?>
		<div class="clear"></div>
		<div class="NoteTxt"><?php echo _NOTE;?></div>
		<div id="tableContainer">
		
			<div class="clear"></div>			
	  	    <form name="frmProfile" id="frmProfile" action="" method="post" onSubmit="return 
			frmValidate(this);">
        <input type="hidden" name="mode" id="mode" value="<?php echo $mode;?>" />
        <input type="hidden" name="user_cd" id="user_cd" value="<?php echo $user_cd;?>" />
			
			<div class="formfield b shadowWhite"><?php echo "First Name";?>:</div>
			<div class="formvalue">
			<input class="rr_input" type="text" name="first_name" id="first_name" value="<?php echo 
			$first_name;?>" size="50"/></div>
			<div class="clear"></div>
			<div class="formfield b shadowWhite"><?php echo "Last Name";?>:</div>
			<div class="formvalue"><input class="rr_input" type="text" name="last_name" id=
			"last_name" value="<?php echo $last_name;?>" size="50"/></div>
			<div class="clear"></div>
			<div class="formfield b shadowWhite"><?php echo "User Name";?>:</div>
			<div class="formvalue"><input class="rr_input" type="text" name="username" id="username"
			 value="<?php echo $username;?>" size="50"/></div>
			<div class="clear"></div>
			<div class="formfield b shadowWhite"><?php echo "Password";?>:</div>
			<div class="formvalue"><input class="rr_input" type="text" name="passwd" id="passwd" 
			value="<?php echo $passwd;?>" size="50"/></div>
			<div class="clear"></div>
			
			<div class="formfield b shadowWhite"><?php echo USER_FLD_EMAIL;?>:</div>
			<div class="formvalue"><input type="hidden" name="email_old" id="email_old" value="<?php 
			echo $email;?>" />
        <input class="rr_input" type="text" name="email" id="email" value="<?php echo $email;?>" 
		style="width:200px;" /></div>
			<div class="clear"></div>
            <div class="formfield b shadowWhite"><?php echo "Designation";?>:</div>
			<div class="formvalue">
        <input class="rr_input" type="text" name="designation" id="designation" value="<?php echo $designation;?>" 
		style="width:200px;" /></div>
			<div class="clear"></div>
			
			<div class="formfield b shadowWhite"><?php echo USER_FLD_PHONE;?>:</div>
			<div class="formvalue"><input class="rr_input" type="text" name="phone" id="phone" value
			="<?php echo $phone;?>" /></div>
			<div class="clear"></div>
					
			<table width="97%"   border="0" align="left"   class="reference">
			<tr>
			<td align="right">&nbsp;</td>
			<td colspan="7"  style="color:#FFF; "bgcolor="#999999"><strong>Superadmin</strong></td>
			 </tr>
		  <tr>
    <td align="right">&nbsp;</td>
    <td width="87" valign="middle">Superadmin</td>
    <td width="79"  ><select name="sadmin" id="sadmin">
      <option value="0" <?php if ($sadmin==0) {echo "selected='selected'";} ?>>Deny</option>
      <option value="1" <?php if ($sadmin==1) {echo "selected='selected'";} ?>>Allow</option>
    </select></td>
  
    <td colspan="5">&nbsp;</td>
    </tr>
			
			 <tr>
			<td align="right">&nbsp;</td>
			<td colspan="7"  style="color:#FFF; "bgcolor="#999999"><strong>News</strong></td>
			
		  </tr>
		  <tr>
    <td align="right">&nbsp;</td>
    <td width="87" valign="middle">News View</td>
    <td width="79"  ><select name="news" id="news">
      <option value="0" <?php if ($news==0) {echo "selected='selected'";} ?>>Deny</option>
      <option value="1" <?php if ($news==1) {echo "selected='selected'";} ?>>Allow</option>
    </select></td>
    <td width="85" valign="middle"  >News Admin</td>
    <td  ><select name="newsadm" id="newsadm">
      <option value="0" <?php if ($newsadm==0) {echo "selected='selected'";} ?>>Deny</option>
      <option value="1" <?php if ($newsadm==1) {echo "selected='selected'";} ?>>Allow</option>
    </select></td>
    <td width="84" align="right"  >News Entry</td>
    <td width="79"  ><select name="newsentry" id="newsentry">
      <option value="0" <?php if ($newsentry==0) {echo "selected='selected'";} ?>>Deny</option>
      <option value="1" <?php if ($newsentry==1) {echo "selected='selected'";} ?>>Allow</option>
    </select></td>
   
    <td>&nbsp;</td>
    </tr>
	<tr>
			<td align="right">&nbsp;</td>
			<td colspan="7"  style="color:#FFF; "bgcolor="#999999"><strong>PMIS</strong></td>
			
		  </tr>
	      <tr>
			<td align="right">&nbsp;</td>
			<td colspan="7"  style="color:#FFF; "bgcolor="#999999"><strong>Add Project</strong></td>
			
		  </tr>
		  <tr>
    <td align="right">&nbsp;</td>
    <td width="87" valign="middle">Project Admin</td>
    <td width="79"  ><select name="padm" id="padm">
      <option value="0" <?php if ($padm==0) {echo "selected='selected'";} ?>>Deny</option>
      <option value="1" <?php if ($padm==1) {echo "selected='selected'";} ?>>Allow</option>
    </select></td>
	</tr>
	
	<tr>
			<td align="right">&nbsp;</td>
			<td colspan="7"  style="color:#FFF; "bgcolor="#999999"><strong>Resources</strong></td>
			
		  </tr>
		  <tr>
    <td align="right">&nbsp;</td>
    <td width="87" valign="middle">Resource</td>
    <td width="79"  ><select name="res" id="res">
      <option value="0" <?php if ($res==0) {echo "selected='selected'";} ?>>Deny</option>
      <option value="1" <?php if ($res==1) {echo "selected='selected'";} ?>>Allow</option>
    </select></td>
    <td width="85" valign="middle"  >Resource Admin</td>
    <td  ><select name="resadm" id="resadm">
      <option value="0" <?php if ($resadm==0) {echo "selected='selected'";} ?>>Deny</option>
      <option value="1" <?php if ($resadm==1) {echo "selected='selected'";} ?>>Allow</option>
    </select></td>
    <td width="84" align="right"  >Resource Entry</td>
    <td width="79"  ><select name="resentry" id="resentry">
      <option value="0" <?php if ($resentry==0) {echo "selected='selected'";} ?>>Deny</option>
      <option value="1" <?php if ($resentry==1) {echo "selected='selected'";} ?>>Allow</option>
    </select></td>
   
    <td>&nbsp;</td>
    </tr>
	
	
	 <tr>
			<td align="right">&nbsp;</td>
			<td colspan="7"  style="color:#FFF; "bgcolor="#999999"><strong>Maindata</strong></td>
			
		  </tr>
		  <tr>
    <td align="right">&nbsp;</td>
    <td width="87" valign="middle">Maindata </td>
    <td width="79"  ><select name="mdata" id="mdata">
      <option value="0" <?php if ($mdata==0) {echo "selected='selected'";} ?>>Deny</option>
      <option value="1" <?php if ($mdata==1) {echo "selected='selected'";} ?>>Allow</option>
    </select></td>
    <td width="85" valign="middle"  >Maindata Admin</td>
    <td  ><select name="mdataadm" id="mdataadm">
      <option value="0" <?php if ($mdataadm==0) {echo "selected='selected'";} ?>>Deny</option>
      <option value="1" <?php if ($mdataadm==1) {echo "selected='selected'";} ?>>Allow</option>
    </select></td>
    <td width="84" align="right"  >Maindata Entry</td>
    <td width="79"  ><select name="mdataentry" id="mdataentry">
      <option value="0" <?php if ($mdataentry==0) {echo "selected='selected'";} ?>>Deny</option>
      <option value="1" <?php if ($mdataentry==1) {echo "selected='selected'";} ?>>Allow</option>
    </select></td>
   
    <td>&nbsp;</td>
    </tr>
	<tr>
			<td align="right">&nbsp;</td>
			<td colspan="7"  style="color:#FFF; "bgcolor="#999999"><strong>Schedule Progress</strong></td>
			
		  </tr>
		  <tr>
    <td align="right">&nbsp;</td>
    <td width="87" valign="middle">Schedule progress</td>
    <td width="79"  ><select name="spg" id="spg">
      <option value="0" <?php if ($spg==0) {echo "selected='selected'";} ?>>Deny</option>
      <option value="1" <?php if ($spg==1) {echo "selected='selected'";} ?>>Allow</option>
    </select></td>
    <td width="85" valign="middle"  >Schedule progress Admin</td>
    <td  ><select name="spgadm" id="spgadm">
      <option value="0" <?php if ($spgadm==0) {echo "selected='selected'";} ?>>Deny</option>
      <option value="1" <?php if ($spgadm==1) {echo "selected='selected'";} ?>>Allow</option>
    </select></td>
    <td width="84" align="right"  >Schedule progress Entry</td>
    <td width="79"  ><select name="spgentry" id="spgentry">
      <option value="0" <?php if ($spgentry==0) {echo "selected='selected'";} ?>>Deny</option>
      <option value="1" <?php if ($spgentry==1) {echo "selected='selected'";} ?>>Allow</option>
    </select></td>
   
    <td>&nbsp;</td>
    </tr>
	<tr>
			<td align="right">&nbsp;</td>
			<td colspan="7"  style="color:#FFF; "bgcolor="#999999"><strong>Activity Dashboard</strong></td>
			
		  </tr>
		  <tr>
    <td align="right">&nbsp;</td>
    <td width="87" valign="middle">Act-D</td>
    <td width="79"  ><select name="actd" id="actd">
      <option value="0" <?php if ($actd==0) {echo "selected='selected'";} ?>>Deny</option>
      <option value="1" <?php if ($actd==1) {echo "selected='selected'";} ?>>Allow</option>
    </select></td>
     </tr>
	<tr>
			<td align="right">&nbsp;</td>
			<td colspan="7"  style="color:#FFF; "bgcolor="#999999"><strong>Milestone Data</strong></td>
		  </tr>
		  <tr>
    <td align="right">&nbsp;</td>
    <td width="87" valign="middle">Milestone</td>
    <td width="79"  ><select name="mile" id="mile">
      <option value="0" <?php if ($mile==0) {echo "selected='selected'";} ?>>Deny</option>
      <option value="1" <?php if ($mile==1) {echo "selected='selected'";} ?>>Allow</option>
    </select></td>
    <td width="85" valign="middle"  >Milestone Admin</td>
    <td  ><select name="mileadm" id="mileadm">
      <option value="0" <?php if ($mileadm==0) {echo "selected='selected'";} ?>>Deny</option>
      <option value="1" <?php if ($mileadm==1) {echo "selected='selected'";} ?>>Allow</option>
    </select></td>
    <td width="84" align="right"  >Milestone Entry</td>
    <td width="79"  ><select name="mileentry" id="mileentry">
      <option value="0" <?php if ($mileentry==0) {echo "selected='selected'";} ?>>Deny</option>
      <option value="1" <?php if ($mileentry==1) {echo "selected='selected'";} ?>>Allow</option>
    </select></td>
   
    <td>&nbsp;</td>
    </tr>
	
	<tr>
			<td align="right">&nbsp;</td>
			<td colspan="7"  style="color:#FFF; "bgcolor="#999999"><strong>Milestone Dashboard</strong></td>
		  </tr>
		  <tr>
    <td align="right">&nbsp;</td>
    <td width="87" valign="middle">Milestone-D</td>
    <td width="79"  ><select name="miled" id="miled">
      <option value="0" <?php if ($miled==0) {echo "selected='selected'";} ?>>Deny</option>
      <option value="1" <?php if ($miled==1) {echo "selected='selected'";} ?>>Allow</option>
    </select></td>
    </tr>
	
	
	
	<tr>
			<td align="right">&nbsp;</td>
			<td colspan="7"  style="color:#FFF; "bgcolor="#999999"><strong>KPI Data</strong></td>
			
		  </tr>
		  <tr>
    <td align="right">&nbsp;</td>
    <td width="87" valign="middle">KPI</td>
    <td width="79"  ><select name="kpi" id="kpi">
      <option value="0" <?php if ($kpi==0) {echo "selected='selected'";} ?>>Deny</option>
      <option value="1" <?php if ($kpi==1) {echo "selected='selected'";} ?>>Allow</option>
    </select></td>
    <td width="85" valign="middle"  >KPI Admin</td>
    <td  ><select name="kpiadm" id="kpiadm">
      <option value="0" <?php if ($kpiadm==0) {echo "selected='selected'";} ?>>Deny</option>
      <option value="1" <?php if ($kpiadm==1) {echo "selected='selected'";} ?>>Allow</option>
    </select></td>
    <td width="84" align="right"  >KPI Entry</td>
    <td width="79"  ><select name="kpientry" id="kpientry">
      <option value="0" <?php if ($kpientry==0) {echo "selected='selected'";} ?>>Deny</option>
      <option value="1" <?php if ($kpientry==1) {echo "selected='selected'";} ?>>Allow</option>
    </select></td>
   
    <td>&nbsp;</td>
    </tr>
	
	<tr>
			<td align="right">&nbsp;</td>
			<td colspan="7"  style="color:#FFF; "bgcolor="#999999"><strong>KPI Dashboard</strong></td>
			
		  </tr>
		  <tr>
    <td align="right">&nbsp;</td>
    <td width="87" valign="middle">KPI-D</td>
    <td width="79"  ><select name="kpid" id="kpid">
      <option value="0" <?php if ($kpid==0) {echo "selected='selected'";} ?>>Deny</option>
      <option value="1" <?php if ($kpid==1) {echo "selected='selected'";} ?>>Allow</option>
    </select></td>
    </tr>
	
	<tr>
			<td align="right">&nbsp;</td>
			<td colspan="7"  style="color:#FFF; "bgcolor="#999999"><strong>CAM Data</strong></td>
			
		  </tr>
		  <tr>
    <td align="right">&nbsp;</td>
    <td width="87" valign="middle">CAM</td>
    <td width="79"  ><select name="cam" id="cam">
      <option value="0" <?php if ($cam==0) {echo "selected='selected'";} ?>>Deny</option>
      <option value="1" <?php if ($cam==1) {echo "selected='selected'";} ?>>Allow</option>
    </select></td>
    <td width="85" valign="middle"  >CAM Admin</td>
    <td  ><select name="camadm" id="camadm">
      <option value="0" <?php if ($camadm==0) {echo "selected='selected'";} ?>>Deny</option>
      <option value="1" <?php if ($camadm==1) {echo "selected='selected'";} ?>>Allow</option>
    </select></td>
    <td width="84" align="right"  >CAM Entry</td>
    <td width="79"  ><select name="camentry" id="camentry">
      <option value="0" <?php if ($camentry==0) {echo "selected='selected'";} ?>>Deny</option>
      <option value="1" <?php if ($camentry==1) {echo "selected='selected'";} ?>>Allow</option>
    </select></td>
   
    <td>&nbsp;</td>
    </tr>
	
	<tr>
			<td align="right">&nbsp;</td>
			<td colspan="7"  style="color:#FFF; "bgcolor="#999999"><strong>CAM Dashboard</strong></td>
			
		  </tr>
		  <tr>
    <td align="right">&nbsp;</td>
    <td width="87" valign="middle">CAM-D</td>
    <td width="79"  ><select name="camd" id="camd">
      <option value="0" <?php if ($camd==0) {echo "selected='selected'";} ?>>Deny</option>
      <option value="1" <?php if ($camd==1) {echo "selected='selected'";} ?>>Allow</option>
    </select></td>
    </tr>
	
	<tr>
			<td align="right">&nbsp;</td>
			<td colspan="7"  style="color:#FFF; "bgcolor="#999999"><strong>BOQ Data</strong></td>
			
		  </tr>
		  <tr>
    <td align="right">&nbsp;</td>
    <td width="87" valign="middle">BOQ</td>
    <td width="79"  ><select name="boq" id="boq">
      <option value="0" <?php if ($boq==0) {echo "selected='selected'";} ?>>Deny</option>
      <option value="1" <?php if ($boq==1) {echo "selected='selected'";} ?>>Allow</option>
    </select></td>
    <td width="85" valign="middle"  >BOQ Admin</td>
    <td  ><select name="boqadm" id="boqadm">
      <option value="0" <?php if ($boqadm==0) {echo "selected='selected'";} ?>>Deny</option>
      <option value="1" <?php if ($boqadm==1) {echo "selected='selected'";} ?>>Allow</option>
    </select></td>
    <td width="84" align="right"  >BOQ Entry</td>
    <td width="79"  ><select name="boqentry" id="boqentry">
      <option value="0" <?php if ($boqentry==0) {echo "selected='selected'";} ?>>Deny</option>
      <option value="1" <?php if ($boqentry==1) {echo "selected='selected'";} ?>>Allow</option>
    </select></td>
   
    <td>&nbsp;</td>
    </tr>
	
	<tr>
			<td align="right">&nbsp;</td>
			<td colspan="7"  style="color:#FFF; "bgcolor="#999999"><strong>IPC Data</strong></td>
			
		  </tr>
		  <tr>
    <td align="right">&nbsp;</td>
    <td width="87" valign="middle">IPC</td>
    <td width="79"  ><select name="ipc" id="ipc">
      <option value="0" <?php if ($ipc==0) {echo "selected='selected'";} ?>>Deny</option>
      <option value="1" <?php if ($ipc==1) {echo "selected='selected'";} ?>>Allow</option>
    </select></td>
    <td width="85" valign="middle"  >IPC Admin</td>
    <td  ><select name="ipcadm" id="ipcadm">
      <option value="0" <?php if ($ipcadm==0) {echo "selected='selected'";} ?>>Deny</option>
      <option value="1" <?php if ($ipcadm==1) {echo "selected='selected'";} ?>>Allow</option>
    </select></td>
    <td width="84" align="right"  >IPC Entry</td>
    <td width="79"  ><select name="ipcentry" id="ipcentry">
      <option value="0" <?php if ($ipcentry==0) {echo "selected='selected'";} ?>>Deny</option>
      <option value="1" <?php if ($ipcentry==1) {echo "selected='selected'";} ?>>Allow</option>
    </select></td>
   
    <td>&nbsp;</td>
    </tr>
	<tr>
			<td align="right">&nbsp;</td>
			<td colspan="7"  style="color:#FFF; "bgcolor="#999999"><strong>IPC Dashboard</strong></td>
			
		  </tr>
		  <tr>
    <td align="right">&nbsp;</td>
    <td width="87" valign="middle">KFI-D</td>
    <td width="79"  ><select name="kfid" id="kfid">
      <option value="0" <?php if ($kfid==0) {echo "selected='selected'";} ?>>Deny</option>
      <option value="1" <?php if ($kfid==1) {echo "selected='selected'";} ?>>Allow</option>
    </select></td>
    </tr>
	<tr>
			<td align="right">&nbsp;</td>
			<td colspan="7"  style="color:#FFF; "bgcolor="#999999"><strong>EVA Data</strong></td>
			
		  </tr>
		  <tr>
    <td align="right">&nbsp;</td>
    <td width="87" valign="middle">EVA</td>
    <td width="79"  ><select name="eva" id="eva">
      <option value="0" <?php if ($eva==0) {echo "selected='selected'";} ?>>Deny</option>
      <option value="1" <?php if ($eva==1) {echo "selected='selected'";} ?>>Allow</option>
    </select></td>
    <td width="85" valign="middle"  >EVA Admin</td>
    <td  ><select name="evaadm" id="evaadm">
      <option value="0" <?php if ($evaadm==0) {echo "selected='selected'";} ?>>Deny</option>
      <option value="1" <?php if ($evaadm==1) {echo "selected='selected'";} ?>>Allow</option>
    </select></td>
    <td width="84" align="right"  >EVA Entry</td>
    <td width="79"  ><select name="evaentry" id="evaentry">
      <option value="0" <?php if ($evaentry==0) {echo "selected='selected'";} ?>>Deny</option>
      <option value="1" <?php if ($evaentry==1) {echo "selected='selected'";} ?>>Allow</option>
    </select></td>
   
    <td>&nbsp;</td>
    </tr>
	<tr>
			<td align="right">&nbsp;</td>
			<td colspan="7"  style="color:#FFF; "bgcolor="#999999"><strong>EVA Dashboard</strong></td>
			
		  </tr>
		  <tr>
    <td align="right">&nbsp;</td>
    <td width="87" valign="middle">EVA-D</td>
    <td width="79"  ><select name="evad" id="evad">
      <option value="0" <?php if ($evad==0) {echo "selected='selected'";} ?>>Deny</option>
      <option value="1" <?php if ($evad==1) {echo "selected='selected'";} ?>>Allow</option>
    </select></td>
    </tr>
	
	<tr>
			<td align="right">&nbsp;</td>
			<td colspan="7"  style="color:#FFF; "bgcolor="#999999"><strong>Pictorial Analysis</strong></td>
			
		  </tr>
		  <tr>
    <td align="right">&nbsp;</td>
    <td width="87" valign="middle">Pictorial Analysis</td>
    <td width="79"  ><select name="pic" id="pic">
      <option value="0" <?php if ($pic==0) {echo "selected='selected'";} ?>>Deny</option>
      <option value="1" <?php if ($pic==1) {echo "selected='selected'";} ?>>Allow</option>
    </select></td>
    <td width="85" valign="middle"  >Pictorial Analysis Admin</td>
    <td  ><select name="picadm" id="picadm">
      <option value="0" <?php if ($picadm==0) {echo "selected='selected'";} ?>>Deny</option>
      <option value="1" <?php if ($picadm==1) {echo "selected='selected'";} ?>>Allow</option>
    </select></td>
    <td width="84" align="right"  >Pictorial Analysis Entry</td>
    <td width="79"  ><select name="picentry" id="evaentry">
      <option value="0" <?php if ($picentry==0) {echo "selected='selected'";} ?>>Deny</option>
      <option value="1" <?php if ($picentry==1) {echo "selected='selected'";} ?>>Allow</option>
    </select></td>
   
    <td>&nbsp;</td>
    </tr>
	
	<tr>
			<td align="right">&nbsp;</td>
			<td colspan="7"  style="color:#FFF; "bgcolor="#999999"><strong>Process</strong></td>
			
		  </tr>
		  <tr>
    <td align="right">&nbsp;</td>
    <td width="87" valign="middle">Process</td>
    <td width="79"  ><select name="process" id="process">
      <option value="0" <?php if ($process==0) {echo "selected='selected'";} ?>>Deny</option>
      <option value="1" <?php if ($process==1) {echo "selected='selected'";} ?>>Allow</option>
    </select></td>
    </tr>
			</table>
			<div id="submit">
			
			  <input type="submit" class="SubmitButton" value="<?php echo ($mode == "U") ? " Update " : " Save ";?>" /></div>
              &nbsp;
			  <div id="submit2">
            <input type="button" class="SubmitButton" value="Cancel" onClick="document.location='./?p=user_mgmt';" />
			</div>
			
			<div class="clear"></div>
			
			
            </form>
			<div class="clear"></div>
  	    </div>
	</div>