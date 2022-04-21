<?php
if ($strusername==null  )
	{
		header("Location: ./index.php?init=3");
	}
else if ($newsadm_flag==0  and $newsentry_flag==0)
	{
		header("Location: ./index.php?init=3");
	}


include("./fckeditor/fckeditor.php");
$news_path=NEWS_PATH;
$mode	= "I";
if($_SERVER['REQUEST_METHOD'] == "POST")
{

		 $title 		= trim($_POST['title1']);
		 $newsdate 		= date('Y-m-d',strtotime($_POST['newsdate']));
		 $details 		= trim($_POST['details']);
		 $status 		= trim($_POST['status']);
		 $newsfile      = $_FILES['newsfile'];
		 $old_news_file =trim($_POST['old_news_file']);
		 $newsfile1		=$_FILES['newsfile1'];
		 $old_news_file1=trim($_POST['old_news_file1']);
		  $newsfile2	=$_FILES['newsfile2'];
		 $old_news_file2=trim($_POST['old_news_file2']);
		 $newsfile3	=$_FILES['newsfile3'];
		 $old_news_file3=trim($_POST['old_news_file3']);
		 $newsfile4	=$_FILES['newsfile4'];
		 $old_news_file4=trim($_POST['old_news_file4']);
		$news_cd = ($_POST['mode'] == "U") ? $_POST['news_cd'] : $objAdminUser->genCode("rs_tbl_news", "news_cd");		
		$objNews->setProperty("news_cd", $news_cd);
		$objNews->setProperty("title", $title);
		$objNews->setProperty("details", $details);
		$objNews->setProperty("newsdate", $newsdate);
		$objNews->setProperty("ordering", 1);		
		if(isset($_FILES["newsfile"]["name"])&&$_FILES["newsfile"]["name"]!="")
		{
		/* Upload the image File */
		import("Image");
		$objImage = new Image($news_path);
		$objImage->setImage($newsfile);
		if(($_FILES["newsfile"]["type"] == "image/jpg")|| 
		($_FILES["newsfile"]["type"] == "image/jpeg")|| 
		($_FILES["newsfile"]["type"] == "image/gif") || 
		($_FILES["newsfile"]["type"] == "image/png"))
		{ # max allowable image size in mb
			
			if($old_news_file){
					@unlink(NEWS_PATH . $old_news_file);
						
					}
			if($objImage->uploadImage($news_cd)){
				
					$newsfile = $objImage->filename;
					$objNews->setProperty("newsfile",$newsfile);
			}
		 }
			else
		 {
		 $objCommon->setMessage("Invalid file ", 'Error');
		 }
		 
		}
		if(isset($_FILES["newsfile1"]["name"])&&$_FILES["newsfile1"]["name"]!="")
		{
		/* Upload the image File */
		import("Image");
		$objImage = new Image($news_path);
		$objImage->setImage($newsfile1);
		if(($_FILES["newsfile1"]["type"] == "image/jpg")|| 
		($_FILES["newsfile1"]["type"] == "image/jpeg")|| 
		($_FILES["newsfile1"]["type"] == "image/gif") || 
		($_FILES["newsfile1"]["type"] == "image/png"))
		{ # max allowable image size in mb
			
			if($old_news_file1){
					@unlink(NEWS_PATH . $old_news_file1);
						
					}
			if($objImage->uploadImage($news_cd)){
				
					$newsfile1 = $objImage->filename;
					$objNews->setProperty("newsfile1",$newsfile1);
			}
		 }
			else
		 {
		 $objCommon->setMessage("Invalid file ", 'Error');
		 }
		 
		}
		if(isset($_FILES["newsfile2"]["name"])&&$_FILES["newsfile2"]["name"]!="")
		{
		/* Upload the image File */
		import("Image");
		$objImage = new Image($news_path);
		$objImage->setImage($newsfile2);
		if(($_FILES["newsfile2"]["type"] == "image/jpg")|| 
		($_FILES["newsfile2"]["type"] == "image/jpeg")|| 
		($_FILES["newsfile2"]["type"] == "image/gif") || 
		($_FILES["newsfile2"]["type"] == "image/png"))
		{ # max allowable image size in mb
			
			if($old_news_file2){
					@unlink(NEWS_PATH . $old_news_file2);
						
					}
			if($objImage->uploadImage($news_cd)){
				
					$newsfile2 = $objImage->filename;
					$objNews->setProperty("newsfile2",$newsfile2);
			}
		 }
			else
		 {
		 $objCommon->setMessage("Invalid file ", 'Error');
		 }
		 
		}
		if(isset($_FILES["newsfile3"]["name"])&&$_FILES["newsfile3"]["name"]!="")
		{
		/* Upload the image File */
		import("Image");
		$objImage = new Image($news_path);
		$objImage->setImage($newsfile3);
		if(($_FILES["newsfile3"]["type"] == "image/jpg")|| 
		($_FILES["newsfile3"]["type"] == "image/jpeg")|| 
		($_FILES["newsfile3"]["type"] == "image/gif") || 
		($_FILES["newsfile3"]["type"] == "image/png"))
		{ # max allowable image size in mb
			
			if($old_news_file3){
					@unlink(NEWS_PATH . $old_news_file3);
						
					}
			if($objImage->uploadImage($news_cd)){
				
					$newsfile3 = $objImage->filename;
					$objNews->setProperty("newsfile3",$newsfile3);
			}
		 }
			else
		 {
		 $objCommon->setMessage("Invalid file ", 'Error');
		 }
		 
		}
		
		if(isset($_FILES["newsfile4"]["name"])&&$_FILES["newsfile4"]["name"]!="")
		{
		/* Upload the image File */
		import("Image");
		$objImage = new Image($news_path);
		$objImage->setImage($newsfile4);
		if(($_FILES["newsfile4"]["type"] == "image/jpg")|| 
		($_FILES["newsfile4"]["type"] == "image/jpeg")|| 
		($_FILES["newsfile4"]["type"] == "image/gif") || 
		($_FILES["newsfile4"]["type"] == "image/png"))
		{ # max allowable image size in mb
			
			if($old_news_file4){
					@unlink(NEWS_PATH . $old_news_file4);
						
					}
			if($objImage->uploadImage($news_cd)){
				
					$newsfile4 = $objImage->filename;
					$objNews->setProperty("newsfile4",$newsfile4);
			}
		 }
			else
		 {
		 $objCommon->setMessage("Invalid file ", 'Error');
		 }
		 
		}
		
	$objNews->setProperty("status", $status);	
		if($objNews->actNews($_POST['mode'])){
			$objCommon->setMessage('News item is saved successfully.','Info');
			redirect('./?p=news_mgmt');
		}
	
	extract($_POST);
}
else
{
	if(isset($_GET['news_cd']) && !empty($_GET['news_cd']))
		$news_cd = $_GET['news_cd'];
	else if(isset($_POST['news_cd']) && !empty($_POST['news_cd']))
		$news_cd = $_POST['news_cd'];
	if(isset($news_cd) && !empty($news_cd))
	{
		$objNews->setProperty("news_cd", $news_cd);
		$objNews->lstNews();
		$data = $objNews->dbFetchArray(1);
		$mode	= "U";
		extract($data);
	}
}
?>
<script>
function frmValidate(frm){
	var msg = "<?php echo _JS_FORM_ERROR;?>\r\n-----------------------------------------";
	var flag = true;
	/*var invid=frm.invid.value;
	var id_inv='paymentdate_'+invid;
	alert(id_inv);
	alert(invid);*/
	if(frm.title1.value == ""){
		msg = msg + "\r\n<?php echo "News Title is required field";?>";
		flag = false;
	}
	if(frm.newsdate.value == ""){
		msg = msg + "\r\n<?php echo "Date is required field";?>";
		flag = false;
	}
	
	if(flag == false){
		alert(msg);
		return false;
	}
}
</script>
<script language="javascript" type="text/javascript">
function getXMLHTTP2() { //fuction to return the xml http object
		var xmlhttp;
	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
		return xmlhttp;
    }
function doDeleteNewsFile(news_cd,image,name) {

		
			var strURL="<?php echo SITE_URL; ?>delete_image.php?news_cd="+news_cd+"&image="+image+"&name="+name;
		
			var req = getXMLHTTP2();
				
			if (req) {
				//alert("if");
				
				req.onreadystatechange = function() {
					if (req.readyState == 4) {
						// only if "OK"
						if (req.status == 200) {	
						    document.getElementById('delete_'+name).innerHTML=req.responseText;	
						   						
						} else {
							alert("There was a problem while using XMLHTTP:7\n" + req.statusText);
						}
					}				
				}			
				req.open("GET", strURL, true);
				req.send(null);
			}
			
		
	}
</script>
<div id="wrapperPRight">
		<div id="pageContentName" class="shadowWhite"><?php echo ($mode == "U") ? 'News Edit' : 'News Add';?></div>
		<div id="pageContentRight">
		</div>
		<div class="clear"></div>
		<?php echo $objCommon->displayMessage();?>
		<div class="clear"></div>
		<div class="NoteTxt"><?php echo _NOTE;?></div>
		<div id="tableContainer">
		<script type="text/javascript">
		  $(function() {
			$( "#newsdate" ).datepicker();
		  });
		</script>
		<div class="clear"></div>			
	  	    <form name="frmNews" id="frmNews" action="" method="post" onSubmit="return frmValidate(this);" enctype="multipart/form-data">
			
			<input type="hidden" name="mode" id="mode" value="<?php echo $mode;?>" />
        	<input type="hidden" name="news_cd" id="news_cd" value="<?php echo $news_cd;?>" />
       		<div class="formfield b shadowWhite"><?php echo 'Title';?> <span style="color:#FF0000;">*</span>:</div>
			<div class="formvalue"><input class="rr_input" size="60" type="text" name="title1" id="title1" value="<?php echo $title;?>" /></div>
			<div class="clear"></div>
			<div class="formfield b shadowWhite"><?php echo 'News Date';?> <span style="color:#FF0000;">*</span>:</div>
			<div class="formvalue">
			<input type="text" class="rr_input" id="newsdate" name="newsdate" value="<?php if($newsdate!="")
			echo date('Y-m-d',strtotime($newsdate));?>" />
			</div>
			<div class="clear"></div>
			<div class="formfield b shadowWhite"><?php echo 'Upload Image1';?>:</div>
			<div class="formvalue">
			<input type="file" name="newsfile" id="newsfile" size="25" />
            <input type="hidden" name="old_news_file" value="<?php echo $newsfile;?>" />
			</div>
			<div class="clear"></div>
			<div class="formfield b shadowWhite">&nbsp;</div>
			<div class="formvalue">							
			<div id="delete_newsfile">
                        <?php if($newsfile!="") {?>
                        <a href="<?php echo NEWS_URL.$newsfile ;?>"  target="_blank"><img src="<?php echo NEWS_URL.$newsfile ;?>" width="40px" height="40px" /></a>
                       <a   onClick="doDeleteNewsFile(<?php echo $news_cd;?>,'<?php echo $newsfile;?>','newsfile');" href="javascript:void(null)">Remove Image?</a>
					   
					 
                        <?php }?>
						</div>
			</div>
			<div class="clear"></div>
			<div class="formfield b shadowWhite"><?php echo 'Upload Image2';?>:</div>
			<div class="formvalue">
			<input type="file" name="newsfile1" id="newsfile1" size="25" />
            <input type="hidden" name="old_news_file1" value="<?php echo $newsfile1;?>" />
			</div>
			<div class="clear"></div>
			<div class="formfield b shadowWhite">&nbsp;</div>
			<div class="formvalue">						
			<div id="delete_newsfile1">
                        <?php if($newsfile1!="") {?>
                        <a href="<?php echo NEWS_URL.$newsfile1 ;?>"  target="_blank"><img src="<?php echo NEWS_URL.$newsfile1 ;?>" width="40px" height="40px" /></a>
                       <a   onClick="doDeleteNewsFile(<?php echo $news_cd;?>,'<?php echo $newsfile1;?>','newsfile1');" href="javascript:void(null)">Remove Image?</a>
					   
					 
                        <?php }
						?>
						</div>
			</div>
			<div class="clear"></div>
			<div class="formfield b shadowWhite"><?php echo 'Upload Image3';?>:</div>
			<div class="formvalue">
			<input type="file" name="newsfile2" id="newsfile2" size="25" />
            <input type="hidden" name="old_news_file2" value="<?php echo $newsfile2;?>" />
			</div>
			<div class="clear"></div>
			<div class="formfield b shadowWhite">&nbsp;</div>
			<div class="formvalue">				
			<div id="delete_newsfile2">
                        <?php if($newsfile2!="") {?>
                        <a href="<?php echo NEWS_URL.$newsfile2 ;?>"  target="_blank"><img src="<?php echo NEWS_URL.$newsfile2 ;?>" width="40px" height="40px" /></a>
                       <a   onClick="doDeleteNewsFile(<?php echo $news_cd;?>,'<?php echo $newsfile2;?>','newsfile2');" href="javascript:void(null)">Remove Image?</a>
					   
					 
                        <?php }
						?>
						</div>
			</div>
			<div class="clear"></div>
			<div class="formfield b shadowWhite"><?php echo 'Upload Image4';?>:</div>
			<div class="formvalue">
			<input type="file" name="newsfile3" id="newsfile3" size="25" />
            <input type="hidden" name="old_news_file3" value="<?php echo $newsfile3;?>" />
			
			</div>	
			<div class="clear"></div>
			<div class="formfield b shadowWhite">&nbsp;</div>
			<div class="formvalue">			
			<div id="delete_newsfile3">
                        <?php if($newsfile3!="") {?>
                        <a href="<?php echo NEWS_URL.$newsfile3 ;?>"  target="_blank"><img src="<?php echo NEWS_URL.$newsfile3 ;?>" width="40px" height="40px" /></a>
                       <a   onClick="doDeleteNewsFile(<?php echo $news_cd;?>,'<?php echo $newsfile3;?>','newsfile3');" href="javascript:void(null)">Remove Image?</a>
					   
					 
                        <?php }
						?>
						</div>
			</div>					
			<div class="clear"></div>		
			<div class="formfield b shadowWhite"><?php echo 'Upload Image5';?>:</div>
			<div class="formvalue">
			<input type="file" name="newsfile4" id="newsfile4" size="25" />
            <input type="hidden" name="old_news_file4" value="<?php echo $newsfile4;?>" />
			</div>						
			<div class="clear"></div>
			<div class="formfield b shadowWhite">&nbsp;</div>
			<div class="formvalue">	
			<div id="delete_newsfile4">
                        <?php if($newsfile4!="") {?>
                        <a href="<?php echo NEWS_URL.$newsfile4 ;?>"  target="_blank"><img src="<?php echo NEWS_URL.$newsfile4 ;?>" width="40px" height="40px" /></a>
                       <a   onClick="doDeleteNewsFile(<?php echo $news_cd;?>,'<?php echo $newsfile4;?>','newsfile4');" href="javascript:void(null)">Remove Image?</a>
					   
					 
                        <?php }
						?>
						</div>
			</div>
			<div class="clear"></div>					
			<div class="formfield b shadowWhite"><?php echo 'Details';?> <span style="color:#FF0000;">*</span>:</div>
			<div class="formvalue"> 
			   <textarea rows="8" cols="1050" name="details"><?php echo $details; ?></textarea><?php
			 /* $oFCKeditor = new FCKeditor('details') ;
			  $oFCKeditor->BasePath   = SITE_URL.'fckeditor/';
			  $oFCKeditor->Width      = "506px";
			  $oFCKeditor->Height     = "250";
			  $oFCKeditor->ToolbarSet = "Basic";
			  $oFCKeditor->Value     = stripslashes($details);      
			  $oFCKeditor->Create( );*/
			  ?>
			</div>
			<div class="clear"></div>
			<div class="formfield b shadowWhite"><?php echo 'Status';?>:</div>
			<div class="formvalue" style="color:black"><input type="radio" name="status" checked="checked" value="Y" /> Active 
        		<input type="radio" name="status" value="N" <?php echo ($status == "N") ? "checked" : "";?> /> Inactive</div>
			<div class="clear"></div>		
			<div id="submit" style="margin-left:164px;"><input type="submit" class="SubmitButton" value="Save" /></div>
					  <div id="submit2">
					  <input type="button" class="SubmitButton" value=" Cancel " onclick="javascript: history.back(-1);" />
					  </div>
			<div class="clear"></div>
		    </form>
			<div class="clear"></div>
  	    </div>
	</div>







<!--<div class="title_div">
	<div style="float:left;padding-top:3px;"><?php echo ($mode == "U") ? 'Application &raquo; News Edit' : 'Application &raquo; News Add';?></div>
    <div style="float:right; padding:0px 2px 2px; *padding: 0 4px 2px 2px;">
        <a href="javascript:void(null);" onclick="history.go(-1);" class="lnkButton"><?php echo _BTN_BACK;?></a>
    </div>
</div>
<div align="left" style="padding-left:6px;"><?php echo _NOTE;?></div>
<div class="rr_form">
	<?php echo $objCommon->displayMessage();?>
	<br />
	<div id="divUpdate">
    <form name="frmContent" id="frmContent" action="" method="post">
        <input type="hidden" name="mode" id="mode" value="<?php echo $mode;?>" />
        <input type="hidden" name="news_cd" id="news_cd" value="<?php echo $news_cd;?>" />
		
		<div class="frmCaption"><?php echo 'Language';?> <span style="color:#FF0000;">*</span> </div><div class="frmDot">:</div>
        <div class="frmElement">
        <select name="language_cd" id="language_cd" class="rr_select" style="width:200px;">
			<option value="" selected>--- Language ---</option>
			<?php echo $objCommon->langCombo($language_cd);?>
		</select>
        </div>
		<br />
		<?php if($vResult['language_cd']){?>
		<div class="frmCaption">&nbsp;</div><div class="frmDot">&nbsp;</div><div class="frmElement">
		<div class="msgError"><?php echo $vResult['language_cd'];?></div></div>
		<br />
		<?php }?>
		
		<div class="frmCaption"><?php echo 'Title';?> <span style="color:#FF0000;">*</span></div><div class="frmDot">:</div>
        <div class="frmElement"><input class="rr_input" size="60" type="text" name="title" id="title" value="<?php echo $title;?>" /></div>
		<br />
        <?php if($vResult['title']){?>
        <div class="frmCaption">&nbsp;</div><div class="frmDot">&nbsp;</div><div class="frmElement">
		<div class="msgError"><?php echo $vResult['title'];?></div></div>
		<br />
		<?php }?>
		
		<div class="frmCaption"><?php echo 'Short';?> <span style="color:#FF0000;">*</span></div><div class="frmDot">:</div>
        <div>&nbsp;</div>
        <div style="clear:both;">
        <textarea name="short" id="short" cols="70" rows="15"><?php echo stripslashes($short);?></textarea>
        <script type="text/javascript">
		//<![CDATA[
			CKEDITOR.replace( 'short',{toolbar : toolBarSet});
		//]]>
		</script>
		</div>
		<br />
		<?php if($vResult['short']){?>
        <div class="frmCaption">&nbsp;</div><div class="frmDot">&nbsp;</div><div class="frmElement">
		<div class="msgError"><?php echo $vResult['short'];?></div></div>
		<br />
		<?php }?>
		
		<div class="frmCaption"><?php echo 'Details';?> <span style="color:#FF0000;">*</span></div><div class="frmDot">:</div>
        <div>&nbsp;</div>
        <div style="clear:both;">
        <textarea name="details" id="details" cols="70" rows="15"><?php echo stripslashes($details);?></textarea>
        <script type="text/javascript">
		//<![CDATA[
			CKEDITOR.replace( 'details',{toolbar : toolBarSet});
		//]]>
		</script>
		</div>
		<br />
		<?php if($vResult['details']){?>
        <div class="frmCaption">&nbsp;</div><div class="frmDot">&nbsp;</div><div class="frmElement">
		<div class="msgError"><?php echo $vResult['details'];?></div></div>
		<br />
		<?php }?>
		
		<div class="frmCaption"><?php echo 'Status';?> <span style="color:#FF0000;">*</span> </div><div class="frmDot">:</div>
        <div class="frmElement">
        <input type="radio" name="status" checked="checked" value="Y" /> Active 
        <input type="radio" name="status" value="N" <?php echo ($status == "N") ? "checked" : "";?> /> Inactive
        </div>
		<br />
		
        <div id="div_button">
            <input type="submit" class="rr_button" value="<?php echo _BTN_SAVE;?>" />
            <input type="button" class="rr_button" value="<?php echo _BTN_CANCEL;?>" onClick="document.location='./?p=news_mgmt';" />
        </div>
        </form>
    </div>
</div>-->