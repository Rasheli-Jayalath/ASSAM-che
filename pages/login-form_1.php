<?php
if($_SERVER['REQUEST_METHOD'] == "POST"){
	 $username 	= trim($_POST['username']);
	 $passwd 	= trim($_POST['password']);
	 $user_type	= trim($_POST['user_type']);
	$objValidate->setArray($_POST);
	$objValidate->setCheckField("username", LOGIN_FLD_VAL_USERNAME, "S");
	$objValidate->setCheckField("password", LOGIN_FLD_VAL_PASSWD, "S");
	$vResult = $objValidate->doValidate();
	
	if(!$vResult){
		$objAdminUser->setProperty("username", $username);
//		$objAdminUser->setProperty("passwd", md5($passwd));
		$objAdminUser->setProperty("passwd", $passwd);
		
		$objAdminUser->lstAdminUser();
		if($objAdminUser->totalRecords() >= 1){
		
		
		/*$objAdminUser->setProperty("user_type", $user_type);
		$objAdminUser->lstAdminUser();
		if($objAdminUser->totalRecords() >= 1){*/
			$rows = $objAdminUser->dbFetchArray(1);
			$fullname = $rows['first_name'] . " " . $rows['last_name'];
			$objAdminUser->setProperty("user_cd", $rows['user_cd']);
			$objAdminUser->setProperty("username", $rows['username']);
			$objAdminUser->setProperty("fullname_name", $fullname);
			$objAdminUser->setProperty("user_type", $rows['user_type']);
			$log_time= date('Y-m-d H:i:s');
			$objAdminUser->setProperty("logged_in_time", date('Y-m-d H:i:s'));
			$objAdminUser->setProperty("member_cd", $rows['member_cd']);
			$objAdminUser->setProperty("designation", $rows['designation']);
			$objAdminUser->setProperty("sadmin", $rows['sadmin']);
			$objAdminUser->setProperty("news", $rows['news']);
			$objAdminUser->setProperty("newsadm", $rows['newsadm']);
			$objAdminUser->setProperty("newsentry", $rows['newsentry']);
			
			$objAdminUser->setProperty("res", $rows['res']);
			$objAdminUser->setProperty("resadm",$rows['resadm']);
			$objAdminUser->setProperty("resentry",$rows['resentry']);
			
			$objAdminUser->setProperty("mdata", $rows['mdata']);
			$objAdminUser->setProperty("mdataadm", $rows['mdataadm']);
			$objAdminUser->setProperty("mdataentry", $rows['mdataentry']);
			$objAdminUser->setProperty("mile", $rows['mile']);
			$objAdminUser->setProperty("mileadm", $rows['mileadm']);
			$objAdminUser->setProperty("mileentry", $rows['mileentry']);
			$objAdminUser->setProperty("spg", $rows['spg']);
			$objAdminUser->setProperty("spgadm", $rows['spgadm']);
			$objAdminUser->setProperty("spgentry", $rows['spgentry']);
			
			$objAdminUser->setProperty("spln", $rows['spln']);
			$objAdminUser->setProperty("splnadm", $rows['splnadm']);
			$objAdminUser->setProperty("splnentry", $rows['splnentry']);
			
			$objAdminUser->setProperty("kpi", $rows['kpi']);
			$objAdminUser->setProperty("kpiadm", $rows['kpiadm']);
			$objAdminUser->setProperty("kpientry", $rows['kpientry']);
			
			$objAdminUser->setProperty("cam", $rows['cam']);
			$objAdminUser->setProperty("camadm", $rows['camadm']);
			$objAdminUser->setProperty("camentry", $rows['camentry']);
			
			$objAdminUser->setProperty("boq", $rows['boq']);
			$objAdminUser->setProperty("boqadm", $rows['boqadm']);
			$objAdminUser->setProperty("boqentry", $rows['boqentry']);
			
			$objAdminUser->setProperty("ipc", $rows['ipc']);
			$objAdminUser->setProperty("ipcadm", $rows['ipcadm']);
			$objAdminUser->setProperty("ipcentry", $rows['ipcentry']);
			
			$objAdminUser->setProperty("eva", $rows['eva']);
			$objAdminUser->setProperty("evaadm", $rows['evaadm']);
			$objAdminUser->setProperty("evaentry", $rows['evaentry']);
			
			$objAdminUser->setProperty("padm", $rows['padm']);
			$objAdminUser->setProperty("issueAdm", $rows['issueAdm']);
		
			$objAdminUser->setProperty("actd", $rows['actd']);
			
			$objAdminUser->setProperty("miled", $rows['miled']);
			
			$objAdminUser->setProperty("kpid", $rows['kpid']);
			
			$objAdminUser->setProperty("camd", $rows['camd']);
			
			$objAdminUser->setProperty("kfid", $rows['kfid']);
			
			$objAdminUser->setProperty("evad", $rows['evad']);
			
			$objAdminUser->setProperty("pic", $rows['pic']);
			$objAdminUser->setProperty("picadm", $rows['picadm']);
			$objAdminUser->setProperty("picentry", $rows['picentry']);
			
			$objAdminUser->setProperty("draw", $rows['draw']);
			$objAdminUser->setProperty("drawadm", $rows['drawadm']);
			$objAdminUser->setProperty("drawentry", $rows['drawentry']);
			
			$objAdminUser->setProperty("ncf", $rows['ncf']);
			$objAdminUser->setProperty("ncfadm", $rows['ncfadm']);
			$objAdminUser->setProperty("ncfentry", $rows['ncfentry']);
			
			$objAdminUser->setProperty("dp", $rows['dp']);
			$objAdminUser->setProperty("dpadm", $rows['dpadm']);
			$objAdminUser->setProperty("dpentry", $rows['dpentry']);
			
			$objAdminUser->setProperty("process", $rows['process']);
			$_SESSION['login_count']=1;
			$_SESSION['user_pasword']=$passwd;
			$objAdminUser->setAdminLogin();
		/***** Log Entry *****/
		$log_desc 	= "User <strong>" . $fullname . "</strong> is login at.". $log_time;
			$log_module = "Login";
			$log_title 	= "User Login";
			doLog($log_module, $log_title, $log_desc,$rows['user_cd']);
			header("location: index.php");
			
		/*}
		else
		{
			$objCommon->setMessage("Invalid User Accesss Rights! Please try again", 'Error');
		}*/
		}
		else{
			$objCommon->setMessage(LOGIN_FLD_INVALID, 'Error');
		}
	}
}
?>

<script>
function frmValidate(frm){
	var msg = "<?php echo _JS_FORM_ERROR;?>\r\n-----------------------------------------";
	var flag = true;
	if(frm.username.value == ""){
		msg = msg + "\r\n<?php echo LOGIN_FLD_VAL_USERNAME;?>";
		flag = false;
	}
	if(frm.password.value == ""){
		msg = msg + "\r\n<?php echo LOGIN_FLD_VAL_PASSWD;?>";
		flag = false;
	}
	if(flag == false){
		alert(msg);
		return false;
	}
	
}
</script>
<script type="text/javascript">
function toggleDiv(divId) {
 /*  $("#"+divId).toggle();*/
   $("#"+divId).hide(800);
/*   $("p").hide("slow");*/

}
</script>

<div id="wrapper_MemberLogin_main" style="padding-bottom:50px">
	<h1 style="color:#000"><?php echo "LOGIN";?></h1>
	<div class="clear"></div>
	<div id="LoginBox" class="borderRound borderShadow">
		<!--<div id="useralert">Please Enter Correct User/Pass.</div>-->
		<?php echo $objCommon->displayMessage();?> 
		   
	<form name="frmlogin" onsubmit="return frmValidate(this);" method="post" action="">
	  
	  	<div class="loginboxContainer borderRound borderShadow">
			<div id="username1">
			 <input name="username" type="text" id="username" value="<?php echo $_POST['username'];?>" class="userinbox"/>
			</div>
		</div>
		<div class="loginboxContainer borderRound borderShadow">
			<div id="userpass">
			 <input name="password" id="password" type="password" class="userinbox"/>
			</div>
		</div>	  
	  
	  	<?php /*?><div class="loginboxContainer borderRound borderShadow">
			<div id="usertype">
			  <input type="radio"  
			id="user_type" name="user_type" value="1" checked="checked" />
			 SuperAdmin 
			 <input type="radio" 
			 id="user_type" name="user_type" value="2" />
			SubAdmin
            <input type="radio" 
			 id="user_type" name="user_type" value="3" />
			User</div>
		</div><?php */?>
		
	  <div id="userLogin"> <input type="submit" name="Submit" value="<?php echo LOGIN_BTN_LOGIN;?>" id="uLogin" />
	 
	  </div>
	 
	  <div class="clear"></div>	  
      </form>
	<div style="font-weight:normal; text-align:right; margin-right:5px"><a href="<?php echo $_CONFIG['site_url'];?>DMS">Directly Access DMS</a></div>
	</div>
	 <!--<div id="forgotPass"><a href="./?forgot=forgot" id="forgotPass">Forgot Password?</a></div>-->
	
</div>
