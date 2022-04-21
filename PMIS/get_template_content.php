<?php
error_reporting(E_ALL & ~E_NOTICE);
@require_once("requires/session.php");
$uname = $_SESSION['uname'];
if ($uname==null)
{
	//header("Location: index.php?init=3");
}
$admflag 			= $_SESSION['admflag'];
$superadmflag	 	= $_SESSION['superadmflag'];
$module 			= $_REQUEST['module'];
$temp_id		= $_REQUEST['temp_id'];

$objDb  = new Database( );
$objDbb  = new Database( );
@require_once("get_url.php");

?>
<table class="reference" style="width:100%" >
              <tr bgcolor="#333333" style="text-decoration:inherit; color:#CCC; vertical-align:middle">
                <th align="center" width="2%"><strong>#</strong></th>
                <th align="center" width="2%"><strong>
                  <input  type="checkbox"  name="txtChkAll" id="txtChkAll"   
      form="reports"  onclick="group_checkbox();"/>
                </strong></th>
                <th align="center" width="25%"><strong>Resource Name </strong></th>
                <th width="10%"><strong>Unit</strong></th>
                <th width="15%"><strong>Quantity</strong></th>
                <th align="center" width="10%"><strong>Action </strong></th>
               <?php /*?> <th align="center" width="10%"><strong>Log </strong></th><?php */?>
              </tr>
              <strong>
                <?php
 $sSQL = " Select * from baseline where temp_id=$temp_id";
 $objDb->query($sSQL);
 $iCount = $objDb->getCount( );
 if($iCount>0)
 {
	for ($i = 0 ; $i < $iCount; $i ++)
	{
	  $rid 							= $objDb->getField($i,rid);
	  $resource 					= $objDb->getField($i,base_desc);
	  $unit 						= $objDb->getField($i,unit);
	  $quantity 					= $objDb->getField($i,quantity);
	  $schedulecode 				= $objDb->getField($i,schedulecode);
	  $boqcode 						= $objDb->getField($i,boqcode);
if ($i % 2 == 0) {
	$style = ' style="background:#f1f1f1;"';
} else {
	$style = ' style="background:#ffffff;"';
}
?>
              </strong>
              <tr <?php echo $style; ?>>
                <td width="5px"><center>
                  <?=$i+1;?>
                </center></td>
                <td><input class="checkbox" type="checkbox" name="sel_checkbox[]" id="sel_checkbox[]" value="<?=$rid ?>"   form="reports" onclick="group_checkbox();" /></td>
                <td width="210px"><?=$resource;?></td>
                <td width="100px"><?=$unit;?></td>
                <td width="210px" align="right"><?= number_format($quantity, 2, '.', '');?></td>
                <td style="border-bottom:1px solid #cccccc" width="210px" >&nbsp;
                  <?php  if($resentry_flag==1 || $resadm_flag==1)
	{
	?>
                  <a href="resources.php?edit=<?php echo $rid;?>"  >Edit</a>
                  <?php } ?>
                  <?php  if($resadm_flag==1)
	{
	?>
                  | <a href="resources.php?delete=<?php echo $rid;?>"  onclick="return confirm('Are you sure you want to delete this Resource?')" >Delete</a>
                  <?php
  }
  ?></td>
                <?php /*?><td width="210px" align="right" ><a href="log.php?trans_id=<?php echo $rid ; ?>&amp;module=<?php echo $module?>" target="_blank">Log</a></td><?php */?>
              </tr>
              <?php        
	}
	}
?>
            </table>