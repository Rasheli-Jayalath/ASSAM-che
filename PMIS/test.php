<!DOCTYPE html>
<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
function MySuperFunction()
{
	alert("hell");
	}
$(document).ready(function(){
$("input").click(function(){
        $(this).next().show();
        $(this).next().hide();
    });

});
$('datalist#brow').change(MySuperFunction);
$('datalist#brow').change(function(){
 alert("he");
});
</script>

</head>
<body>
<input list="brow">
<datalist id="brow">
  <option value="Internet Explorer">
  <option value="Firefox">
  <option value="Chrome">
  <option value="Opera">
  <option value="Safari">
</datalist>  
</body>
</html>