<?
	include("includes/check.php");
	include("includes/db.php");
	include("functions.php");
	//include("tiny.php");
	//include_once("cute/CuteEditor_Files/include_CuteEditor.php") ; 	
		include("tiny.php");
	include("thumbnail.class.php");		
		
	$error = "";
	if($_POST)
	{
		
		$pname 			= $_POST['pname'];
		$model			= $_REQUEST["model"];
		$pnumber		= $_POST["pnumber"];	
		$newtime 		= date("Y-m-j H:i:s");		
		$description	= $_POST['description'];
		$price			= $_POST['price'];		

		$q2 = "INSERT INTO star_product(product_name, product_model, product_datetime, product_des, product_cost)	 
		values('$pname', '$model', '$newtime', '$description', '$price')";		
		$r = mysql_query($q2) or die(mysql_error());				
		$product_id = @mysql_insert_id();
		
		$pic  		= $_FILES['pic']['name'];
		$pic1 		= $_FILES['pic1']['name'];
		$pic2 		= $_FILES['pic2']['name'];
		$pic3 		= $_FILES['pic3']['name'];
		$pic4 		= $_FILES['pic4']['name'];
		$pic5 		= $_FILES['pic5']['name'];		
		
		if($pic!="")
		{
			$picpath = '1'.$product_id.$pic;
			$uploadfilefolder = "../productmainimages/1$product_id".$pic;
			if(move_uploaded_file($_FILES['pic']['tmp_name'],$uploadfilefolder))
			{									
						$uploaddir= '../productmainthumb/';
						$uploadfileth = $uploaddir.'1'.$product_id.basename($_FILES['pic']['name']);					
						copy($uploadfilefolder, $uploadfileth);
						$imageful=new Thumbnail($uploadfileth, 150, 150, 150);
						$imageful->save($uploadfileth);				
			}
		}	
		
		if($pic1!="")
		{
			$picpath1 = '1'.$product_id.$pic1;
			$uploadfilefolder = "../productmainimages/1$product_id".$pic1;
			if(move_uploaded_file($_FILES['pic1']['tmp_name'],$uploadfilefolder))
			{									
						$uploaddir= '../productmainthumb/';
						$uploadfileth = $uploaddir.'1'.$product_id.basename($_FILES['pic1']['name']);					
						copy($uploadfilefolder, $uploadfileth);
						$imageful=new Thumbnail($uploadfileth, 150, 150, 150);
						$imageful->save($uploadfileth);				
			}
		}	

		if($pic2!="")
		{
			$picpath2 = '1'.$product_id.$pic2;
			$uploadfilefolder = "../productmainimages/1$product_id".$pic2;
			if(move_uploaded_file($_FILES['pic2']['tmp_name'],$uploadfilefolder))
			{									
						$uploaddir= '../productmainthumb/';
						$uploadfileth = $uploaddir.'1'.$product_id.basename($_FILES['pic2']['name']);					
						copy($uploadfilefolder, $uploadfileth);
						$imageful=new Thumbnail($uploadfileth, 150, 150, 150);
						$imageful->save($uploadfileth);				
			}
		}	

		if($pic3!="")
		{
			$picpath3 = '1'.$product_id.$pic3;
			$uploadfilefolder = "../productmainimages/1$product_id".$pic3;
			if(move_uploaded_file($_FILES['pic3']['tmp_name'],$uploadfilefolder))
			{									
						$uploaddir= '../productmainthumb/';
						$uploadfileth = $uploaddir.'1'.$product_id.basename($_FILES['pic3']['name']);					
						copy($uploadfilefolder, $uploadfileth);
						$imageful=new Thumbnail($uploadfileth, 150, 150, 150);
						$imageful->save($uploadfileth);				
			}
		}	

		if($pic4!="")
		{
			$picpath4 = '1'.$product_id.$pic4;
			$uploadfilefolder = "../productmainimages/1$product_id".$pic4;
			if(move_uploaded_file($_FILES['pic4']['tmp_name'],$uploadfilefolder))
			{									
						$uploaddir= '../productmainthumb/';
						$uploadfileth = $uploaddir.'1'.$product_id.basename($_FILES['pic4']['name']);					
						copy($uploadfilefolder, $uploadfileth);
						$imageful=new Thumbnail($uploadfileth, 150, 150, 150);
						$imageful->save($uploadfileth);				
			}
		}	

		if($pic5!="")
		{
			$picpath5 = '1'.$product_id.$pic5;
			$uploadfilefolder = "../productmainimages/1$product_id".$pic5;
			if(move_uploaded_file($_FILES['pic5']['tmp_name'],$uploadfilefolder))
			{									
						$uploaddir= '../productmainthumb/';
						$uploadfileth = $uploaddir.'1'.$product_id.basename($_FILES['pic5']['name']);					
						copy($uploadfilefolder, $uploadfileth);
						$imageful=new Thumbnail($uploadfileth, 150, 150, 150);
						$imageful->save($uploadfileth);				
			}
		}	

			$q = "UPDATE star_product set product_pic='$picpath', product_pic1='$picpath1',
			product_pic2='$picpath2', product_pic3='$picpath3', product_pic4 = '$picpath4', product_pic5='$picpath5' where product_id='$product_id'";
			$r = mysql_query($q) or die(mysql_error());
			$error = "New product has been inserted";
	}	
?>
<html>
	<head>
		<title>:: Welcome to the Admin Panel. ::</title>
		<SCRIPT LANGUAGE="JavaScript" type="text/javascript">
			function check()
			{
				if(window.document.addproduct.pname.value == "")
				{
					alert("Please enter product name");
					window.document.addproduct.pname.focus();
					return;
				}

				if(window.document.addproduct.price.value == "")
				{
					alert("Please enter product price");
					window.document.addproduct.price.focus();
					return;
				}
				
				/*if(window.document.addproduct.code.value == "")
				{
					alert("Product code not given");
					window.document.addproduct.code.focus();
					return;
				}*/				
				
				/*if(window.document.addproduct.subcategory.value == "nothing")
				{
					alert("Please select Subcategory");
					window.document.addproduct.subcategory.focus();
					return;
				}*/								
				
				/*if(window.document.addproduct.pic1.value == "")
				{
					alert("Please upload main picture");
					window.document.addproduct.pic1.focus();
					return;
				}*/				
				document.addproduct.submit();
			}
		</SCRIPT>	
		<script src="javascripts.js"></script>
		<link href="includes/style.css" rel="stylesheet" type="text/css">
	</head>
	

<body>
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="20"><? include("header.php");?></td>
  </tr>
  <tr>
    <td valign="top"><form action="" method="post" enctype="multipart/form-data" name="addproduct">

  <table width="100%" align="center">
  <tr>
  	<td width="150" valign="top">
	<? include("left.php")?>	</td>
	<td align="center">
  <table width="98%"  border="1" align="center" cellpadding="5" cellspacing="2" bordercolor="#FFE1E1" bgcolor="#FFECEC" style="border-collapse:collapse">
			<tr>
				<td height="30" align="center" bgcolor="#DF0424" class="header_text">Add Product</td>
			</tr>
			<tr>
				<td bgcolor="#FFFFFF">
					<table width="100%"   border="1" align="center" cellpadding="5" cellspacing="2" bordercolor="#FFE1E1" bgcolor="#FFF9F9" style="border-collapse:collapse">
          <?
						if ($error!="")
						{
						
						 echo "<tr><td colspan=2 align=center class=tableleft><div align=center><font  color=#FF0000><strong>".$error."</strong></font></div></td></tr>";

						}
						?>
          <tr>
            <td width="24%"  align="center"><div align="left" class="texto">Product Name : </div></td>
            <td colspan="3" align="left" bgcolor="#FFF9F9" ><input name=pname type=text class="input" id="pname" size="25" maxlength="255"></td>
            </tr>
          <tr>
            <td  align="center"><div align="left" class="texto">Product Model : </div></td>
            <td colspan="3" align="left" bgcolor="#FFF9F9" ><input name=model type=text class="input" id="model" size="25" maxlength="255"></td>
          </tr>
          <tr>
            <td  align="left" class="texto">Price: </td>
            <td colspan="3" align="left" bgcolor="#FFF9F9" class="texto" ><input name=price type=text class="input" id="price" size="15" maxlength="255">
$</td>
            </tr>
        
         <!-- <tr>
            <td  align="center"><div align="left" class="texto"> Capacity: </div></td>
            <td align="left" class="tableright"><input type=text name=spotnumber maxlength="65" size="25" class="input" id="spotnumber"></td>
            <td align="left" class="tableright"><div align="left" class="texto"> Commodity Units: </div></td>
            <td align="left" class="tableright"><input type=text name=comm_units maxlength="65" size="25" class="input" id="comm_units"></td>
          </tr>
          <tr>
            <td align="center"><div align="left" class="texto"> Commodities Size: </div></td>
            <td align="left" class="tableright"><input type=text name=comm_size maxlength="65" size="25" class="input" id="comm_size"></td>
            <td align="left" class="tableright"><div align="left" class="texto"> Single Weight: </div></td>
            <td align="left" class="tableright"><input type=text name=single_weight maxlength="65" size="25" class="input" id="single_weight"></td>
          </tr>
          <tr>
            <td align="center"><div align="left" class="texto"> Materials Goods: </div></td>
            <td align="left" class="tableright"><input type=text name=mat_good maxlength="65" size="25" class="input" id="mat_good"></td>
            <td align="left" class="tableright"><div align="left" class="texto"> Packaging: </div></td>
            <td align="left" class="tableright"><input type=text name=packaging maxlength="65" size="25" class="input" id="packaging"></td>
          </tr>
          <tr>
            <td align="center"><div align="left" class="texto">Origin of Goods : </div></td>
            <td align="left" class="tableright"><input type=text name=origin_good maxlength="65" size="25" class="input" id="origin_good"></td>
            <td align="left" class="tableright"><div align="left" class="texto"> Packing Quantity: </div></td>
            <td align="left" class="tableright"><input type=text name=packing_qty maxlength="65" size="25" class="input" id="packing_qty"></td>
          </tr>-->
		  			

  <!--        <tr> 
            <td align="center"><div align="left" class="texto">Number of pills : </div></td>
            <td align="left" class="tableright"><input name=nopills type=text class="input" id="nopills" size=30></td>
          </tr>-->
          
       <!--   <tr> 
            <td align="center" ><div align="left" class="texto">Price : </div></td>
            <td align="left" class="tableright"><input name=cost type=text  class="input" id="cost" size=30></td>
          </tr>-->
		<!--	<tr>
			  <td align="center"><div align="left" class="texto">Price: </div></td>
			  <td align="left"><span class="tableright">
			    <input name=cost type=text class="input" id="cost" size="30" maxlength="65">
			  </span></td>
			  </tr>-->
			<tr>
				<td align="center" valign="top"><div align="left" class="texto">Upload Main Picture  :</div></td>
				<td align="left" valign="top"><input name=pic type=file id="pic" size=15></td>
			    <td align="left" valign="top" class="texto">&nbsp;</td>
			    <td align="left" valign="top">&nbsp;</td>
			</tr>
			<tr>
			  <td colspan="4" align="center" valign="top"><div align="left" class="texto"><strong>Upload Related Photos  :</strong></div></td>
			  </tr>
			<tr>
			  <td align="center" valign="top"><div align="left" class="texto">Upload Related Picture 1 :</div></td>
			  <td width="28%" align="left" valign="top"><input name=pic1 type=file id="pic1" size=15></td>
			  <td width="23%" align="left" valign="top"><div align="left" class="texto">Upload Related Picture 2 :</div></td>
			  <td width="25%" align="left" valign="top"><input name=pic2 type=file id="pic2" size=15></td>
			</tr>
			<tr>
			  <td align="center" valign="top"><div align="left" class="texto">Upload Related Picture 3  :</div></td>
			  <td align="left" valign="top"><input name=pic3 type=file id="pic3" size=15></td>
			  <td align="left" valign="top"><div align="left" class="texto">Upload Related Picture 4 :</div></td>
			  <td align="left" valign="top"><input name=pic4 type=file id="pic4" size=15></td>
			</tr>
			<tr>
			  <td align="center" valign="top"><div align="left" class="texto">Upload Related Picture 5:</div></td>
			  <td colspan="3" align="left" valign="top"><input name=pic5 type=file id="pic5" size=15></td>
			  </tr>
			<!--<tr>
			  <td colspan="2" align="center" valign="top"><table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#DDDDDD" bgcolor="#ffffff" class="Home_payment" style="border-collapse:collapse">
                <tbody>
                  <tr align="middle" >
                    <td  align="left" class="texto" style="padding:3px;" >&nbsp;</td>
                    <td height="20"  align="center" 
                            bgcolor="#f1f1f1" class="texto" style="padding:3px;" ><b class="text">Master Case Pk. </b></td>
                    <td align="center" bgcolor="#f1f1f1" class="texto"><strong>Innre Case Pk. </strong></td>
                    <td align="center" bgcolor="#f1f1f1" class="texto"><b class="text">Selling Unit </b></td>
                    <td class="texto">&nbsp;</td>
                  </tr>
                  <tr align="middle">
                    <td width="13%" align="right" class="texto" style="padding:3px;">Length:</td>
                    <td width="30%" height="20" align="center" class="texto" style="padding:3px;"><input name="mastercasel" type="text" value="<?=$f["mastercasel"]?>" size="20"/></td>
                    <td width="24%" align="center" class="texto"><input name="innercasel" type="text" id="innercasel" value="<?=$f["innercasel"]?>" size="20"/></td>
                    <td width="22%" align="center" class="texto"><input name="sellingunitl" type="text" id="sellingunitl" value="<?=$f["sellingunitl"]?>" size="20"/></td>
                    <td width="11%" align="left" class="texto">inches</td>
                  </tr>
                  <tr>
                    <td align="right" class="texto" style="padding:3px;">Width:</td>
                    <td height="20" align="center" class="texto" style="padding:3px;"><input name="mastercasew" type="text" id="mastercasew" value="<?=$f["mastercasew"]?>" size="20"/></td>
                    <td align="center" class="texto"><input name="innercasew" type="text" id="innercasew" value="<?=$f["innercasew"]?>" size="20"/></td>
                    <td align="center" class="texto"><input name="sellingunitw" type="text" id="sellingunitw" value="<?=$f["sellingunitw"]?>" size="20"/></td>
                    <td align="left" class="texto">inches</td>
                  </tr>
                  <tr>
                    <td align="right" class="texto" style="padding:3px;">Height:</td>
                    <td height="20" align="center" class="texto" style="padding:3px;"><input name="mastercaseh" type="text" id="mastercaseh" value="<?=$f["mastercaseh"]?>" size="20"/></td>
                    <td align="center" class="texto"><input name="innercaseh" type="text" id="innercaseh" value="<?=$f["innercaseh"]?>" size="20"/></td>
                    <td align="center" class="texto"><input name="sellingunith" type="text" id="sellingunith" value="<?=$f["sellingunith"]?>" size="20"/></td>
                    <td align="left" class="texto">inches</td>
                  </tr>
                  <tr>
                    <td align="right" class="texto" style="padding:3px;">Weight:</td>
                    <td height="20" align="center" class="texto" style="padding:3px;"><input name="mastercaselbs" type="text" id="mastercaselbs" value="<?=$f["mastercaselbs"]?>" size="20"/></td>
                    <td align="center" class="texto"><input name="innercaselbs" type="text" id="innercaselbs" value="<?=$f["innercaselbs"]?>" size="20"/></td>
                    <td align="center" class="texto"><input name="sellingunitlbs" type="text" id="sellingunitlbs" value="<?=$f["sellingunitlbs"]?>" size="20"/></td>
                    <td align="left" class="texto">lbs</td>
                  </tr>
                 
                  <tr>
                    <td align="middle" class="texto">&nbsp;</td>
                    <td align="middle" class="texto">&nbsp;</td>
                    <td class="texto">&nbsp;</td>
                    <td align="right" class="texto"><strong>Ti X HI </strong></td>
                    <td class="texto"><input name="tlxhl" type="text" id="tlxhl" value="<?=$f["tlxhl"]?>" size="20"/></td>
                  </tr>
                </tbody>
              </table></td>
			  </tr>-->
			
<!--			<tr>
				<td align="center" ><div align="left" class="texto">Picture 2 :</div></td>
				<td align="left" class="tableright"><input name=pic2 type=file   id="pic2" size=30></td>
			</tr>
			<tr>
				<td align="center"><div align="left" class="texto">Picture 3 :</div></td>
				<td align="left" class="tableright"><input name=pic3 type=file  id="pic3" size=30></td>
			</tr>
-->			
			<!--<tr>
				<td align="center"><div align="left" class="texto">Upload PDF File :</div></td>
				<td align="left" class="tableright"><input name=pdf type=file id="pdf" size=30></td>
			</tr>-->
			<tr>
			  <td colspan="4" align="left"><div align="left" class="texto"><strong>Description / Specifications :</strong></div></td>
			  </tr>
			<tr>
			  <td colspan="4" align="left">
<?php											
										/*	$editor=new CuteEditor();
											$editor->ID="description";
											$editor->Text="$Detail";
											$editor->EditorBodyStyle="font:normal 12px arial;";
											$editor->EditorWysiwygModeCss="includes/style.css";
											$editor->Draw();
											$editor=null;											
											//use $_POST["Editor1"]to retrieve the data*/
?>			  
			  <textarea name="description" rows="10" id="description" style="width:70%"></textarea></td>
			  </tr>
			
          <tr> 
            <td align="center" bgcolor="#FFFFFF" colspan="4"> <input type="button" class="boton" value="Add Product" height="22" onClick="check();">            </td>
          </tr>
        </table>
				</td>
			</tr>
		</table>     
	  </td>
		  </tr> 
		</table>
	</form></td>
  </tr>
  <tr>
    <td height="10"><?
	
	 include("footer.php");

?></td>
  </tr>
</table>
</body>
</html>