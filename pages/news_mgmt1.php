<?php
if($_GET['mode'] == 'delete'){
	$objNews->setProperty('news_cd', $_GET['news_cd']);
	$objNews->actNews('D');
	$objCommon->setMessage('News deleted successfully!', 'Info');
	redirect('./?p=news_mgmt');
}
?>
<div class="title_div">
	<div style="float:left;padding-top:3px;"><?php echo 'Application &raquo; News Management';?></div>
	<div style="float:right; padding:0px 2px 2px; *padding: 0 4px 2px 2px;">
		<a href="./?p=news_form&amp;mode=add" class="lnkButton"><?php echo _ADD_NEW . " News";?></a>
	</div>
</div>
<?php echo $objCommon->displayMessage();?>
<div class="child_main_div">
  <table id="tblList" width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <th style="width:5%;"><?php echo CMS_FLD_SN;?></th>
      <th style="width:60%;" class="clsleft"><?php echo 'Title';?></th>
      <th style="width:10%;" class="clsleft"><?php echo 'Language';?></th>
	  <th style="width:15%;" class="clsleft"><?php echo 'Date';?></th>
      <th style="width:10%;" colspan="2"><?php echo _ACTION;?></th>
    </tr>
    <?php
	$objNews->setProperty("limit", PERPAGE);
	$objNews->lstNews();
	$Sql = $objNews->getSQL();
	if($objNews->totalRecords() >= 1){
		$sno = 1;
		while($rows = $objNews->dbFetchArray(1)){
			$bgcolor = ($bgcolor == "#FFFFFF") ? "#f1f0f0" : "#FFFFFF";
			?>
    		<tr bgcolor="<?php echo $bgcolor;?>">
                <td><?php echo $sno;?></td>
                <td class="clsleft"><?php echo $rows['title'];?></td>
                <td class="clsleft"><?php echo $rows['language_cd'];?></td>
                <td class="clsleft"><?php echo date('d-m-Y', strtotime($rows['news_date']));?></td>
                <td width="5%"><a href="./?p=news_form&mode=edit&news_cd=<?php echo $rows['news_cd'];?>" title="Edit"><img src="../images/b_edit.png" border="0" title="Edit" alt="Edit" /></a></td>
                <td width="5%"><a onClick="return doConfirm('Are you sure to delete this news?');" href="./?p=news_mgmt&mode=delete&news_cd=<?php echo $rows['news_cd'];?>" title="Delete"><img src="../images/b_drop.png" border="0" title="Delete" alt="Delete" /></a></td>
    		</tr>
    		<?php
			$sno++;
		}
    }
	else{
	?>
    <tr>
    	<td colspan="6" align="center"><?php echo 'No news found.';?></td>
    </tr>
    <?php
	}
	?>
  </table>
</div>
<br />
<?php
if($objNews->totalRecords() >= 1){
	$objPaginate = new Paginate($Sql, PERPAGE, OFFSET, "./?p=news_mgmt");
	?>
	<div class="pagination_div">
	<div style="float:left;width:150px;"><?php $objPaginate->recordMessage();?></div>
	<div id="paging" style="float:right;width:650px;text-align:right; padding-right:5px;">
	    <?php $objPaginate->showpages();?>
	</div>
<?php }?>
</div>	