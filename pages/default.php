<?php
 $incPage = $objCommon->getAdminPage(trim($_GET['p']));


?>


<!--# Main including page.-->
<?php if(isset($incPage)&&$incPage!="")
{

require_once("$incPage");
}
/*if(isset($incPage)&&$incPage=="index.php")
{
*/
?>


<?php //}?>