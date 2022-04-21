<div id="wrapperPRight">
<div style="text-align:right; padding:5px; text-decoration:none"><a  style="text-align:right; padding:10px; text-decoration:none" href="./?p=my_profile" title="header=[My Profile] body=[&nbsp;] fade=[on]">
<?php 
echo  WELCOME." ".$objAdminUser->ne_fullname_name;   ?>
 
<?php 
echo   " [" ;
			if($objAdminUser->ne_user_type==1)  
			echo "SuperAdmin";
			elseif($objAdminUser->ne_user_type==2&&$objAdminUser->ne_member_cd==0)
			echo "SubAdmin";
			else
			echo "User";
			echo "]";

	?> 
   </a>  <a href="./?language=en"><img src="images/english.png" /></a> | <a href="./?language=rus"><img src="images/russian.png" /></a> </div>
		<div id="tableContainer">		 
			<table width="100%"  align="center" border="0" >
   <tr>
     <td height="20" colspan="5" align="left" style="color:#0E0989; font-size:21px" ><?php echo INTRO;?></td>
   </tr>
   <tr>
     <td  colspan="5"  style="line-height:18px; text-align:justify"><?php echo INTRODUCTION;?>
   </td>
   </tr>
    <tr><td colspan="5" align="center"><?php if($_SESSION["lang"]=='en')
{?><img src="images/pmis.png"  width="400px" /><?php } else{?><img src="images/pmis_rus.png"  width="400px" /><?php }?></td></tr>
     
</table>
		
	  </div>
<div style="width:100%; height:10px; border:0px; background:#fecb00"></div>
<div style="width:100%; text-align:center;"><h3><?php echo _DEVELOPE_BY; ?> SJ-SMEC-EGC</h3><br />
<a href="http://www.egcpakistan.com/index.php?id=it" target="_blank"><img src="images/sj.png"  /></a>
</div>
	</div>
	<div class="clear"></div>