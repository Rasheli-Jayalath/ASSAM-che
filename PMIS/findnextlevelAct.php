<?php //include('kfi-top-cache.php');?>
<?php
error_reporting(E_ALL & ~E_NOTICE);
@require_once("requires/session.php");
$objDb  = new Database( );
//$uname = $_SESSION['uname'];
$parentgroup = $_REQUEST['parentgroup'];
$div_id		= $_REQUEST['div_id'];
if($div_id==0) 
$level="Component";
elseif($div_id==1) $level="Sub Component ";
elseif($div_id==2) $level="Activity ";
else $level=" Sub-Activity ";
 $tempquery = "select itemid from maindata where parentgroup='$parentgroup' ";
				$tempresult = mysql_query($tempquery);
				$tempcount = mysql_num_rows($tempresult);
				if($tempcount>0)
				{   $tempdata = mysql_fetch_array($tempresult);
					$parentcd=$tempdata["itemid"];
				}
@require_once("get_url.php");
$sCondition = '';
?>
 <select name="itemid_<?php echo $div_id;?>" id="itemid_<?php echo $div_id;?>" onchange="GetNextLevel(this.value,<?php $div_id?>)">
             <option value="0"><?php echo $level;?></option>
              <?php
			  
			    $str_g_query = "select * from maindata WHERE activitylevel=".$div_id." AND parentcd=$parentcd";
			    if(isset($_GET["parentcd"])&&$_GET["parentcd"])
				{
					$str_g_query .=" and parentcd=".$_GET["parentcd"];
				}
				$str_g_result = mysql_query($str_g_query);
				while ($str_g_data = mysql_fetch_array($str_g_result)) {
				?>
		    <option value="<?php echo $str_g_data['parentgroup']; ?>"  <?php if(isset($_GET["itemid_".$div_id])&&$_GET["itemid_".$div_id]!=""&&$_GET["itemid_".$div_id]==$str_g_data['parentgroup'])
			{?> selected="selected" <?php }?>>
								<?php echo $str_g_data['itemcode']."-".$str_g_data['itemname']; ?>
								</option>
							  <?php
				}
				?>
            </select>

<?php //include('kfi-bottom-cache.php');?>