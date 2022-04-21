<?php
function imageResize($flink, $id,$resizeto,$resizeto_thumb,$uploadPath)
	{
$imagelink = "temp/".$flink;
$upload_thumb = "$uploadPath/thumb/".$id;
$upload_path = "$uploadPath/".$id;
 getimagesize($imagelink);
	
	list($width, $height, $type, $attr) = getimagesize($imagelink);
	//for thumbnails
	if($width>$resizeto_thumb)
		{
		$image_dividing_factor=$width/$resizeto_thumb;
		$thumb_width=$width/$image_dividing_factor;
		$thumb_height=$height/$image_dividing_factor;
		}
	else
		{
		$thumb_width = $width;
		$thumb_height = $height;
		}
	
	//for blowup
	if($width>$resizeto)
		{
		$image_dividing_factor=$width/$resizeto;
		$new_width=$width/$image_dividing_factor;
		$new_height=$height/$image_dividing_factor;
		}
	else
		{
		$new_width=$width;
		$new_height=$height;
		}
		
	$length=strlen($imagelink);
	$ext= strtolower(substr($imagelink,$length-3,3));
	if($ext=="jpg")
		{
		//for thumbnails
		$orig_image = imagecreatefromjpeg($imagelink);
		$sm_image = imagecreatetruecolor($thumb_width,$thumb_height);
		imagecopyresampled($sm_image,$orig_image,0,0,0,0,$thumb_width,$thumb_height,imagesx($orig_image),imagesy($orig_image));
		imagejpeg($sm_image,$upload_thumb.".jpg");

		//for blowup
		$orig_image = imagecreatefromjpeg($imagelink);
		$sm_image = imagecreatetruecolor($new_width,$new_height);
		imagecopyresampled($sm_image,$orig_image,0,0,0,0,$new_width,$new_height,imagesx($orig_image),imagesy($orig_image));
		imagejpeg($sm_image,$upload_path.".jpg");
		unlink($imagelink);	   
		}
		
	else if($ext=="gif")
		{
		//for thumbnails
		$orig_image = imagecreatefromgif($imagelink);
		$sm_image = imagecreatetruecolor($thumb_width,$thumb_height);
		imagecopyresampled($sm_image,$orig_image,0,0,0,0,$thumb_width,$thumb_height,imagesx($orig_image),imagesy($orig_image));
		imagegif($sm_image,$upload_thumb.".gif");
		
		//for blowup
		$orig_image = imagecreatefromgif($imagelink);
		$sm_image = imagecreatetruecolor($new_width,$new_height);
		imagecopyresampled($sm_image,$orig_image,0,0,0,0,$new_width,$new_height,imagesx($orig_image),imagesy($orig_image));
		imagegif($sm_image,$upload_path.".gif");
		unlink($imagelink);		
		}
		
	else if($ext=="png")
		{
		//for thumbnails
		$orig_image = imagecreatefrompng($imagelink);
		$sm_image = imagecreatetruecolor($thumb_width,$thumb_height);
		imagecopyresampled($sm_image,$orig_image,0,0,0,0,$thumb_width,$thumb_height,imagesx($orig_image),imagesy($orig_image));
		imagepng($sm_image,$upload_thumb.".png");
		
		//for blowup
		$orig_image = imagecreatefrompng($imagelink);
		$sm_image = imagecreatetruecolor($new_width,$new_height);
		imagecopyresampled($sm_image,$orig_image,0,0,0,0,$new_width,$new_height,imagesx($orig_image),imagesy($orig_image));
		imagepng($sm_image,$upload_path.".png");
		unlink($imagelink);		
		}	   
	
	return $ext;
	
	}	
?>