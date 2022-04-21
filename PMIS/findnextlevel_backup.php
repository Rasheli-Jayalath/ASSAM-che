<?php
error_reporting(E_ALL & ~E_NOTICE);
@require_once("requires/session.php");
//$uname = $_SESSION['uname'];
$parentcd		= $_REQUEST['parentcd'];
$div_id		= $_REQUEST['div_id'];


$objDb  = new Database( );
@require_once("get_url.php");
$sCondition = '';
?>
 <select name="itemid_<?php echo $div_id;?>" id="itemid_<?php echo $div_id;?>" onchange="getNextLevel(this.value,this.id)">
             <option value="0">BOQ LEVEL <?php echo $div_id;?> </option>
              <?php
				$str_g_query = "select * from maindata where stage='BOQ' and parentcd=".$parentcd;
				$str_g_result = mysql_query($str_g_query);
				while ($str_g_data = mysql_fetch_array($str_g_result)) {
				?>
		    <option value="<?php echo $str_g_data['itemid']; ?>"  <?php if(isset($_REQUEST["itemid_".$div_id])&&$_REQUEST["itemid_".$div_id]!=""&&$_REQUEST["itemid_".$div_id]==$str_g_data['itemid'])
			{?> selected="selected" <?php }?>>
								<?php echo $str_g_data['itemcode']."-".$str_g_data['itemname']; ?>
								</option>
							  <?php
				}
				?>
            </select>

