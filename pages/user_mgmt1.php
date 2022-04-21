<?php
if($superadmin==0)
{
header("Location: ./index.php?init=3");
}
if($_GET['mode'] == 'Delete')
{
	$user_cd = $_GET['user_cd'];
	
	$objAdminUser->setProperty("user_cd", $user_cd);
	$objAdminUser->actAdminUser('D');
	$objCommon->setMessage('User\'s account deleted successfully.', 'Error');
	redirect('./?p=user_mgmt');
	
}
if($_GET['mode'] == 'Suspend'){

	$user_cd = $_GET['user_cd'];
	$objAdminUser->setProperty("user_cd", $user_cd);
	$objAdminUser->setProperty("is_active", "0");
	if($objAdminUser->actAdminUser("U")){
		$objAdminUserN = new AdminUser;
		$objAdminUserN->setProperty("user_cd", $user_cd);
		$objAdminUserN->lstAdminUser();
		$rows_c = $objAdminUserN->dbFetchArray();
		
		# Send mail to customer
		$content 		= $objTemplate->getTemplate('account_suspend','EN');
		$sender_name 	= $content['sender_name'];
		$sender_email 	= $content['sender_email'];
		$subject 		= $content['template_subject'];
		$content 		= $content['template_detail'];
		
		$content		= str_replace("[USER_NAME]", $rows_c['fullname'], $content);
		$content		= str_replace("[REASON]", '', $content);
		$content		= str_replace("[SITENAME]", SITE_NAME, $content);
		$content		= str_replace("[SITE_NAME]", SITE_NAME, $content);
		$content		= str_replace("[SENDER_NAME]", $sender_name, $content);
		
		$body 			= file_get_contents(TEMPLATE_URL . "template.php");
		$body			= str_replace("[BODY]", $content, $body);
		
		$objMail		= new Mail;
		$objMail->IsHTML(true);
		$objMail->setSender($sender_email, $sender_name);
		$objMail->AddEmbeddedImage(TEMPLATE_PATH . "agro_email.jpg", 1, 'agro_email.jpg');
		$objMail->setSubject($subject);
		$objMail->setReciever($rows_c['email'], $rows_c['fullname']);
		$objMail->setBody($body);
		//$objMail->Send();
	
		$objCommon->setMessage('User\'s account suspended successfully.', 'Error');
		redirect('./?p=user_mgmt');
	}
}

if($_GET['mode'] == 'Activate'){
	$user_cd = $_GET['user_cd'];
	$newpwd = $objCommon->genPassword();
	$objAdminUser->setProperty("user_cd", $user_cd);
	$objAdminUser->setProperty("password", md5($newpwd));
	$objAdminUser->setProperty("is_active", "1");
	if($objAdminUser->actAdminUser("U")){
		$objAdminUserN = new AdminUser;
		$objAdminUserN->setProperty("user_cd", $user_cd);
		$objAdminUserN->lstAdminUser();
		$rows_c = $objAdminUserN->dbFetchArray();
		
		# Send mail to customer
		$content 		= $objTemplate->getTemplate('account_activate','EN');
		$sender_name 	= $content['sender_name'];
		$sender_email 	= $content['sender_email'];
		$subject 		= $content['template_subject'];
		$content 		= $content['template_detail'];
		
		$content		= str_replace("[USER_NAME]", $rows_c['fullname'], $content);
		$content		= str_replace("[EMAIL_ADD]", $rows_c['email'], $content);
		$content		= str_replace("[PASSWORD]", $newpwd, $content);
		$content		= str_replace("[SITE_NAME]", SITE_NAME, $content);
		$content		= str_replace("[SENDER_NAME]", $sender_name, $content);
		
		$body 			= file_get_contents(TEMPLATE_URL . "template.php");
		$body			= str_replace("[BODY]", $content, $body);
		
		$objMail		= new Mail;
		$objMail->IsHTML(true);
		$objMail->setSender($sender_email, $sender_name);
		$objMail->AddEmbeddedImage(TEMPLATE_PATH . "agro_email.jpg", 1, 'agro_email.jpg');
		$objMail->setSubject($subject);
		$objMail->setReciever($rows_c['email'], $rows_c['fullname']);
		$objMail->setBody($body);
		//$objMail->Send();
		
		
		$objCommon->setMessage('User\'s account activated successfully.', 'Info');
		redirect('./?p=user_mgmt');
	}
}

if(!empty($_GET['user_name'])){
	$user_name = urldecode($_GET['user_name']);
	$objAdminUser->setProperty("user_name", strtolower($user_name));
}
?>
<script type="text/javascript">
function doFilter(frm){
	var qString = '';
	if(frm.user_name.value != ""){
		qString += '&user_name=' + escape(frm.user_name.value);
	}
	document.location = '?p=user_mgmt' + qString;
}
</script>

<div id="wrapperPRight">
		<div id="pageContentName"><a href="./?p=update_profile"  style="font-size:12px; color:black; font-weight:normal"><?php echo "Add New User";?>
					</a></div>
		
		<div class="clear"></div>
		
			<form name="frmCustomer" id="frmCustomer">
<div id="divfilteration">
    <div class="holder">
        
        <div>
        	<label>User Name</label>
			<input type="text" size="40" name="user_name" id="user_name" value="<?php echo $_GET['user_name'];?>" />
        </div>
    </div>
    <div class="holder">
       
        <div><input type="button" onClick="doFilter(this.form);" class="rr_buttonsearch" name="Submit" id="Submit" value=" GO " /></div>
    </div>
</div>
</form>
		<?php echo $objCommon->displayMessage();?>
        
		<form name="prd_frm" id="prd_frm" method="post" action="">	
		<table id="tblList" width="100%" border="0" cellspacing="1" cellpadding="5" style="padding:3px; margin:3px">
        <tr>
		<th style="border-left:1px solid #000000; border-top:1px solid #000000;" ><?php echo "UID";?></th>
		<th style="text-align:left;border-top:1px solid #000000;"><?php echo "Name";?></th>
		<th style="text-align:left;border-top:1px solid #000000;"><?php echo "Designation";?></th>
        <th style="text-align:left;border-top:1px solid #000000;"><?php echo "User Name";?></th>
		<th style="text-align:left;border-top:1px solid #000000;"><?php echo "News";?></th>
		<th style="text-align:left;border-top:1px solid #000000;"><?php echo "NewsA";?></th>
		<th style="text-align:left;border-top:1px solid #000000;"><?php echo "NewsE";?></th>
		<th style="text-align:left;border-top:1px solid #000000;"><?php echo "ADDP";?></th>
		<th style="text-align:left;border-top:1px solid #000000;"><?php echo "IssueA";?></th>
		<th style="text-align:left;border-top:1px solid #000000;"><?php echo "Res";?></th>
		<th style="text-align:left;border-top:1px solid #000000;"><?php echo "ResA";?></th>
		<th style="text-align:left;border-top:1px solid #000000;"><?php echo "ResE";?></th>
		<th style="text-align:left;border-top:1px solid #000000;"><?php echo "Mdata";?></th>
		<th style="text-align:left;border-top:1px solid #000000;"><?php echo "MdataA";?></th>
		<th style="text-align:left;border-top:1px solid #000000;"><?php echo "MdataE";?></th>
		<th style="text-align:left;border-top:1px solid #000000;"><?php echo "Act-D";?></th>
		<th style="text-align:left;border-top:1px solid #000000;"><?php echo "Mile";?></th>
		<th style="text-align:left;border-top:1px solid #000000;"><?php echo "MileA";?></th>
		<th style="text-align:left;border-top:1px solid #000000;"><?php echo "MileE";?></th>
		<th style="text-align:left;border-top:1px solid #000000;"><?php echo "Mile-D";?></th>
		<th style="text-align:left;border-top:1px solid #000000;"><?php echo "Sprogress";?></th>
		<th style="text-align:left;border-top:1px solid #000000;"><?php echo "SprogressA";?></th>
		<th style="text-align:left;border-top:1px solid #000000;"><?php echo "SprogressE";?></th>
		<th style="text-align:left;border-top:1px solid #000000;"><?php echo "Splanned";?></th>
		<th style="text-align:left;border-top:1px solid #000000;"><?php echo "SplannedA";?></th>
		<th style="text-align:left;border-top:1px solid #000000;"><?php echo "SplannedE";?></th>
		<th style="text-align:left;border-top:1px solid #000000;"><?php echo "KPI";?></th>
		<th style="text-align:left;border-top:1px solid #000000;"><?php echo "KPIA";?></th>
		<th style="text-align:left;border-top:1px solid #000000;"><?php echo "KPIE";?></th>
		<th style="text-align:left;border-top:1px solid #000000;"><?php echo "KPI-D";?></th>
		<th style="text-align:left;border-top:1px solid #000000;"><?php echo "CAM";?></th>
		<th style="text-align:left;border-top:1px solid #000000;"><?php echo "CAMA";?></th>
		<th style="text-align:left;border-top:1px solid #000000;"><?php echo "CAME";?></th>
		<th style="text-align:left;border-top:1px solid #000000;"><?php echo "CAM-D";?></th>
		<th style="text-align:left;border-top:1px solid #000000;"><?php echo "BOQ";?></th>
		<th style="text-align:left;border-top:1px solid #000000;"><?php echo "BOQA";?></th>
		<th style="text-align:left;border-top:1px solid #000000;"><?php echo "BOQE";?></th>
		<th style="text-align:left;border-top:1px solid #000000;"><?php echo "IPC";?></th>
		<th style="text-align:left;border-top:1px solid #000000;"><?php echo "IPCA";?></th>
		<th style="text-align:left;border-top:1px solid #000000;"><?php echo "IPCE";?></th>
		<th style="text-align:left;border-top:1px solid #000000;"><?php echo "KFI-D";?></th>
		<th style="text-align:left;border-top:1px solid #000000;"><?php echo "EVA";?></th>
		<th style="text-align:left;border-top:1px solid #000000;"><?php echo "EVAA";?></th>
		<th style="text-align:left;border-top:1px solid #000000;"><?php echo "EVAE";?></th>
		<th style="text-align:left;border-top:1px solid #000000;"><?php echo "EVA-D";?></th>
		<th style="text-align:left;border-top:1px solid #000000;"><?php echo "PIC";?></th>
		<th style="text-align:left;border-top:1px solid #000000;"><?php echo "PICA";?></th>
		<th style="text-align:left;border-top:1px solid #000000;"><?php echo "PICE";?></th>
		
		<th style="text-align:left;border-top:1px solid #000000;"><?php echo "Draw";?></th>
		<th style="text-align:left;border-top:1px solid #000000;"><?php echo "DrawA";?></th>
		<th style="text-align:left;border-top:1px solid #000000;"><?php echo "DrawE";?></th>
		
		<th style="text-align:left;border-top:1px solid #000000;"><?php echo "NCF";?></th>
		<th style="text-align:left;border-top:1px solid #000000;"><?php echo "NCFA";?></th>
		<th style="text-align:left;border-top:1px solid #000000;"><?php echo "NCFE";?></th>
		
		<th style="text-align:left;border-top:1px solid #000000;"><?php echo "DP";?></th>
		<th style="text-align:left;border-top:1px solid #000000;"><?php echo "DPA";?></th>
		<th style="text-align:left;border-top:1px solid #000000;"><?php echo "DPE";?></th>
		
		<th style="text-align:left;border-top:1px solid #000000;"><?php echo "PROCESS";?></th>
		<th style="border-top:1px solid #000000;">Action</th>
		</tr>
		<?php
	//$objAdminUser->setProperty("ORDER BY", "a.first_name");
	$objAdminUser->setProperty("limit", PERPAGE);
	$objAdminUser->setProperty("GROUP BY", "b.user_cd");
	$objAdminUser->setProperty("GROUP BY", "b.user_cd");
	$objAdminUser->lstAdminUser();
	$Sql = $objAdminUser->getSQL();
	if($objAdminUser->totalRecords() >= 1){
		$sno = 1;
		while($rows = $objAdminUser->dbFetchArray(1)){
			$bgcolor = ($bgcolor == "#FFFFFF") ? "#f1f0f0" : "#FFFFFF";
			?>
			<!-- Start Your Php Code her For Display Record's -->
			<tr style="background-color:<?php echo $bgcolor;?>">
				<td style="border-left:1px solid #000000;"><?php echo $rows['user_cd'];?></td>
				<td><?php echo $rows['fullname'];?></td>
                <td><?php echo $rows['designation'];?></td>
				<td><?php echo $rows['username'];?></td>
				<td><?php echo $rows['news'];?></td>
				<td><?php echo $rows['newsadm'];?></td>
				<td><?php echo $rows['newsentry'];?></td>
				<td><?php echo $rows['padm'];?></td>
				<td><?php echo $rows['issueAdm'];?></td>
				<td><?php echo $rows['res'];?></td>
				<td><?php echo $rows['resadm'];?></td>
				<td><?php echo $rows['resentry'];?></td>
				<td><?php echo $rows['mdata'];?></td>
				<td><?php echo $rows['mdataadm'];?></td>
				<td><?php echo $rows['mdataentry'];?></td>
				<td><?php echo $rows['actd'];?></td>
				<td><?php echo $rows['mile'];?></td>
				<td><?php echo $rows['mileadm'];?></td>
				<td><?php echo $rows['mileentry'];?></td>
				<td><?php echo $rows['miled'];?></td>
				<td><?php echo $rows['spg'];?></td>
				<td><?php echo $rows['spgadm'];?></td>
				<td><?php echo $rows['spgentry'];?></td>
				<td><?php echo $rows['spln'];?></td>
				<td><?php echo $rows['splnadm'];?></td>
				<td><?php echo $rows['splnentry'];?></td>
				<td><?php echo $rows['kpi'];?></td>
				<td><?php echo $rows['kpiadm'];?></td>
				<td><?php echo $rows['kpientry'];?></td>
				<td><?php echo $rows['kpid'];?></td>
				<td><?php echo $rows['cam'];?></td>
				<td><?php echo $rows['camadm'];?></td>
				<td><?php echo $rows['camentry'];?></td>
				<td><?php echo $rows['camd'];?></td>
				<td><?php echo $rows['boq'];?></td>
				<td><?php echo $rows['boqadm'];?></td>
				<td><?php echo $rows['boqentry'];?></td>
				<td><?php echo $rows['ipc'];?></td>
				<td><?php echo $rows['ipcadm'];?></td>
				<td><?php echo $rows['ipcentry'];?></td>
				<td><?php echo $rows['kfid'];?></td>
				<td><?php echo $rows['eva'];?></td>
				<td><?php echo $rows['evaadm'];?></td>
				<td><?php echo $rows['evaentry'];?></td>
				<td><?php echo $rows['evad'];?></td>
				<td><?php echo $rows['pic'];?></td>
				<td><?php echo $rows['picadm'];?></td>
				<td><?php echo $rows['picentry'];?></td>
				
				
				<td><?php echo $rows['draw'];?></td>
				<td><?php echo $rows['drawadm'];?></td>
				<td><?php echo $rows['drawentry'];?></td>
				
				<td><?php echo $rows['ncf'];?></td>
				<td><?php echo $rows['ncfadm'];?></td>
				<td><?php echo $rows['ncfentry'];?></td>
				
				<td><?php echo $rows['dp'];?></td>
				<td><?php echo $rows['dpadm'];?></td>
				<td><?php echo $rows['dpentry'];?></td>
				
				
				<td><?php echo $rows['process'];?></td>
				
			 <td align="center">
			 <a href="./?p=update_profile&user_cd=<?php echo $rows['user_cd'];?>" title="Edit"><img src="images/iconedit.png" border="0" /></a></td>
				</tr>
			<?php
			
		}
    }
	else{
	?>
	<tr>
	<td colspan="59" style="border-left:1px solid #000000;">
  <div align="center" style="padding:5px 5px 5px 5px"> <?php echo NOT_FOUND_CUST;?></div>
   </td></tr>
    <?php
	}
	?>
	<tr>
	<td colspan="59" style="padding:0;border-left:1px solid #000000; background-color:white">		
	<div id="tblFooter">
			<?php
if($objAdminUser->totalRecords() >= 1){
	$objPaginate = new Paginate($Sql, PERPAGE, OFFSET, "./?p=user_mgmt");
	?>
	
	<div style="float:left;width:170px;font-weight:bold"><?php $objPaginate->recordMessage();?></div>
	<div id="paging" style="float:right;text-align:right; padding-right:5px;  font-weight:bold">
	    <?php $objPaginate->showpages();?>
	</div>
<?php }?>
			</div>
	</td></tr>
		 </table>
	  </form>
	</div>