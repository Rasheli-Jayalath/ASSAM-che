<?php require_once("config/config.php");
header("Content-Type: text/html; charset=utf-8");

$objCommon 		= new Common;
$objMenu 		= new Menu;
//$objNews 		= new News;
$objContent 	= new Content;
$objTemplate 	= new Template;
$objMail 		= new Mail;
$objCustomer 	= new Customer;
//$objCart 	= new Cart;
$objAdminUser 	= new AdminUser;
$objProduct 	= new Product;
$objValidate 	= new Validate;
//$objOrder 		= new Order;
$objLog 		= new Log;
require_once('rs_lang.admin.php');
require_once('rs_lang.website.php');
?><?php 

if($objAdminUser->ne_is_login== false){
	header("location: index.php");
}?>

<style>
.inactive
{
pointer-events: none;
opacity: 0.5;
background: #CCC;
}
.active
{
//font-weight:bold;
 
}
</style>
<?php
require_once("config/db_connect.php");
$abc= $_GET["user_cd"];
 $cat_cd=$_GET['cat_cd'];
 $main_cat_s_value=$_GET['main_cat_s_value'];
 $indent_space1=$_GET['indent_space'];
$indent_space= $indent_space1+1;
 ?>
<div id="abcd<?php echo $cat_cd;?>">
<table border="1px solid" width="100%" >
			<tr>
			
<?php
$cdsql2 = "select albumid,album_name,parent_album,user_right from $pmis_db.t031project_albums where albumid = ".$cat_cd;
		$cdsqlresult2 = mysql_query($cdsql2);
		$cddata2 = mysql_fetch_array($cdsqlresult2);
		
		$category_cd2 = $cddata2['albumid'];
		$parent_cdd = $cddata2['parent_album'];
		?>
		
		<?php $h="";
			for($j=1; $j<$indent_space; $j++)
			{
			$k="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
			$h=$h.$k;
			if($j==$indent_space-1)
				{
					if($j==1)
					{
					//red
					
					$colorr1="#FFF0F0";
					}
					elseif($j==2)
					{
					//green
					
					$colorr1="#EAFFEA";
					}
					elseif($j==3)
					{
					
					//blue
					$colorr1="#F1F1F1";
					} 
					elseif($j==4)
					{
					
					//yellow
					$colorr1="#FFFFD5";
					} 
					elseif($j==5)
					{
					
					//green
					$colorr1="#EAFFEA";
					}
				}  
			
			}
			//echo $j;
				?>
				<td width="70%" style="color: #000000; background-color:  <?php echo $colorr1; ?>">
				<?php
			echo $category_name =$h.$cddata2['album_name'];
		?>
		</td>
		
		<?php
		$colorr1="";
		if( $main_cat_s_value==1 ||  $main_cat_s_value==2 ||  $main_cat_s_value==3)
		{		
		$active="active";
		}
		else if($main_cat_s_value==0)
		{
		$active="inactive";
		
		}
		
		$user_rit="0";
		
		/*if ((strpos($cddata2['user_right'], $abc."_1") !== false) || (strpos($cddata2['user_right'], ",". $abc."_1")!== false))
		  {
		 
		 $user_rit="1";
		  
		  }
		  else  if ((strpos($cddata2['user_right'], $abc."_2") !== false) || (strpos($cddata2['user_right'], ",". $abc."_2")!== false))
		  {
		  
		 $user_rit="2";
		 
		  }
		  else
		  {
		 
		  $user_rit="0";
		  }*/
		 
		  ?>
<td width="30%">
<div class="<?php echo $active; ?>"  >
  <input type="radio" name="status<?php echo $category_cd2;?>" value="2" <?php if($user_rit=="2"){ echo "checked";} ?> <?php if($user_rit=="0"){ ?> onclick="Showactive(<?php echo $category_cd2;?>,2,<?php echo  $indent_space; ?>,<?php echo $abc; ?>)" <?php }?>>R
  <input type="radio" name="status<?php echo $category_cd2;?>" value="1" <?php if($user_rit=="1"){ echo "checked";} ?> <?php if($user_rit=="0"){ ?>onclick="Showactive(<?php echo $category_cd2;?>,1,<?php echo $indent_space; ?>,<?php echo $abc; ?>)"<?php }?>>R/W
   <input type="radio" name="status<?php echo $category_cd2;?>" value="3" <?php if($user_rit=="3"){ echo "checked";} ?> <?php if($user_rit=="0"){ ?>onclick="Showactive(<?php echo $category_cd2;?>,3,<?php echo $indent_space; ?>,<?php echo $abc; ?>)"<?php }?>>R/W/D
  <input type="radio" name="status<?php echo $category_cd2;?>" value="0"  <?php if($user_rit=="0"){ echo "checked";} ?> onclick="Showactive(<?php echo $category_cd2;?>,0,<?php echo $indent_space; ?>,<?php echo $abc; ?>)" > No
  </div>
  </td>
</tr>
</table>