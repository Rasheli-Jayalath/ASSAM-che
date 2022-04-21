<?php //include('kfi-top-cache.php');?>
<?php
error_reporting(E_ALL & ~E_NOTICE);
@require_once("requires/session.php");
//$uname = $_SESSION['uname'];
$parentcd		= $_REQUEST['parentcd'];
$div_id		= $_REQUEST['div_id'];
$objDb  = new Database( );
$is_entry=0;
@require_once("get_url.php");
if($parentcd!="")
{
$str_g_query1 = "select * from boqdata where itemid=".$parentcd;
				$str_g_result1 = mysql_query($str_g_query1);
				$str_g_data1 = mysql_fetch_array($str_g_result1);
				$is_entry=$str_g_data1["isentry"];
}
$sCondition = '';
?>
 <select name="itemid_<?php echo $div_id;?>" id="itemid_<?php echo $div_id;?>" onchange="getNextLevel(this.value,this.id)">
             <option value="0">BOQ LEVEL <?php echo $div_id;?> </option>
              <?php
			  if($is_entry==1)
			  {
				$str_g_query = "select * from boq where itemid=".$parentcd;
				$str_g_result = mysql_query($str_g_query);
			  }
			  else
			  {
				  $str_g_query = "select * from boqdata where parentcd=".$parentcd;
				  $str_g_result = mysql_query($str_g_query);
			   }
				
				while ($str_g_data = mysql_fetch_array($str_g_result)) {
					if($is_entry==1)
					{
					$code=$str_g_data['boqcode'];
					$itemname=$str_g_data['boqitem'];
					}
					else
					{
					$code=$str_g_data['itemcode'];
					$itemname=$str_g_data['itemname'];
					}
				?>
		    <option value="<?php echo $str_g_data['itemid']; ?>"  <?php if(isset($_REQUEST["itemid_".$div_id])&&$_REQUEST["itemid_".$div_id]!=""&&$_REQUEST["itemid_".$div_id]==$str_g_data['itemid'])
			{?> selected="selected" <?php }?>>
								<?php echo $code."-".$itemname; ?>
								</option>
							  <?php
				}
				?>
            </select>

<?php //include('kfi-bottom-cache.php');?>