<?
error_reporting(E_ALL & ~E_NOTICE);
	function showPaging($iCount, $iTotalRecords, $iStart, $iPageId, $iPageCount, $sData, $sParams = "")
	{
?>
		    <br />
		    <hr />

		    <table border="0" width="100%" cellpadding="5" cellspacing="0">
		      <tr valign="top">
		        <td>
<?
		if ($iCount > 0)
		{
?>
		        Displaying <b><?= ($iStart + 1) ?></b> to <b><?= ($iStart + $iCount) ?></b> (of <b><?= $iTotalRecords ?></b> <?= $sData ?>)</td>
<?
		}
?>

		        <td align="right" id="Paging">
<?
		if ($iPageCount > 1)
		{
			if ($iPageId > 1)
			{
?>
		          <a href="<?= $_SERVER['PHP_SELF'] ?>?PageId=<?= ($iPageId - 1) ?><?= $sParams ?>">« Back</a>&nbsp;
<?
			}

			for ($i = 1; $i <= $iPageCount; $i ++)
			{
				if ($i == $iPageId)
				{
?>
		          <b><?= $i ?></b>
<?
				}

				else
				{
?>
		          <a href="<?= $_SERVER['PHP_SELF'] ?>?PageId=<?= $i ?><?= $sParams ?>"><?= $i ?></a>
<?
				}

				if ($i < $iPageCount)
				{
?>
		          |
<?
				}
			}

			if ($iPageId < $iPageCount)
			{
?>
		          &nbsp;<a href="<?= $_SERVER['PHP_SELF'] ?>?PageId=<?= ($iPageId + 1) ?><?= $sParams ?>">Next »</a>
<?
			}
		}
?>
			    </td>
			  </tr>
		    </table>
<?
	}
?>