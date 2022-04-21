<?php
 $user_cd	= $objAdminUser->ne_user_cd;
$objAdminUser->setProperty("user_cd", $user_cd);
$objAdminUser->lstAdminUser();
$data = $objAdminUser->dbFetchArray(1);
$mode	= "U";
extract($data);
?>
<div id="wrapperPRight">
		<div id="pageContentName" class="shadowWhite"><?php echo USER_VIEW_BRD;?></div>
		
        <div id="pageContentRight">
			<div class="menu1">
				<ul>
					<li><a href="./?p=update_profile&user_cd=<?php echo  $user_cd;?>" class="lnkButton"><?php echo USER_BTN_UPDATE;?>
					</a></li>
					<?php if($objAdminUser->ne_sadmin!=1)
					{
					?>
					<li><a href="./?p=change_password" class="lnkButton"><?php echo "Change Password";?>
					</a></li>
					<?php
					}
					?>
					</ul>
				<br style="clear:left"/>
			</div>
		</div>
		<div class="clear"></div>
		
		<div id="tableContainer">
			<!--<div class="formheading shadowWhite">--><?php echo $objCommon->displayMessage();?><!--</div>-->
			<div class="clear"></div>			
	  	    <form id="form1" name="form1" method="post" action="">
			
			<div class="formfield b shadowWhite"><?php echo USER_FLD_FULLNAME;?>:</div>
			<div class="formvalue"><?php echo $first_name." ".$middle_name." ".$last_name;?></div>
			<div class="clear"></div>
			<div class="formfield b shadowWhite"><?php echo "User Name";?>:</div>
			<div class="formvalue"><?php echo $username;?></div>
			<div class="clear"></div>
			
			<div class="formfield b shadowWhite"><?php echo USER_FLD_EMAIL;?>:</div>
			<div class="formvalue"><?php echo $email;?></div>
			<div class="clear"></div>
			
			<div class="formfield b shadowWhite"><?php echo USER_FLD_PHONE;?>:</div>
			<div class="formvalue"><?php echo $phone;?></div>
			<div class="clear"></div>
			
			<div class="formfield b shadowWhite"><?php echo USER_FLD_DESIGNATION;?>:</div>
			<div class="formvalue" style="width:50%"><?php 
			
			echo $designation;
			?></div>
			<div class="clear"></div>
			<div class="formfield b shadowWhite"><?php echo "Role";?>:</div>
			<div class="formvalue"><?php 
			if($objAdminUser->ne_sadmin==1) 
			echo "Super Admin";
			else
			echo "User";?></div>
			<div class="clear"></div>
			
            </form>
			<div class="clear"></div>
  	    </div>
	</div>