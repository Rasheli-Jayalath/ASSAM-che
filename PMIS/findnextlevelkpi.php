<?php //include('kfi-top-cache.php');?>
<?php
error_reporting(E_ALL & ~E_NOTICE);
@require_once("requires/session.php");
$objDb  = new Database( );
$parentgroup		= $_REQUEST['parentgroup'];
$div_id		= $_REQUEST['div_id'];
if($div_id==0) $level="Component";
elseif($div_id==1) $level="Sub Component ";
elseif($div_id==2) $level="Activity ";
else $level=" Sub-Activity ";

$tempquery = "select kpiid from kpidata where parentgroup='$parentgroup' ";
				$tempresult = mysql_query($tempquery);
				$tempcount = mysql_num_rows($tempresult);
				if($tempcount>0)
				{   $tempdata = mysql_fetch_array($tempresult);
					$parentcd=$tempdata["kpiid"];
				}
@require_once("get_url.php");
$sCondition = '';
?>
<select name="kpiid_<?php echo $div_id;?>" id="kpiid_<?php echo $div_id;?>" onchange="GetNextLevel(this.value,this.name)">
             <option value="0">KPI LEVEL <?php echo $div_id;?> </option>
              <?php
				$str_g_query = "select * from kpidata WHERE activitylevel=".$div_id." AND parentcd=$parentcd";
				$str_g_result = mysql_query($str_g_query);
				while ($str_g_data = mysql_fetch_array($str_g_result)) {
				?>
		    <option value="<?php echo $str_g_data['parentgroup']; ?>"  <?php if(isset($_REQUEST["kpiid_".$div_id])&&$_REQUEST["kpiid_".$div_id]!=""&&$_REQUEST["kpiid_".$div_id]==$str_g_data['kpiid'])
			{?> selected="selected" <?php }?>>
								<?php echo $str_g_data['itemcode']."-".$str_g_data['itemname']; ?>
								</option>
							  <?php
				}
				?>
            </select>

<?php //include('kfi-bottom-cache.php');?>