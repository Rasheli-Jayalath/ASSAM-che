<?php
error_reporting(E_ALL & ~E_NOTICE);
@require_once("requires/session.php");
$module		= MAINDATA;
if ($uname==null  ) {
header("Location: index.php?init=3");
} 
else if ($picentry_flag==0 ) {
header("Location: index.php?init=3");
} 
$edit			= $_GET['edit'];
$objDb  		= new Database( );
@require_once("get_url.php");
$msg						= "";

$file_path1="banners";
$file_path="banners/thumb";

//Maximize script execution time
ini_set('max_execution_time', 0);

//Initial settings, Just specify Source and Destination Image folder.
//$ImagesDirectory    = '/home/public_html/websites/images/';
$ImagesDirectory    = 'photos/'; //Source Image Directory End with Slash
$DestImagesDirectory    = 'photos/thumb/'; //Destination Image Directory End with Slash
$NewImageWidth      = 150; //New Width of Image
$NewImageHeight     = 120; // New Height of Image
$Quality        = 80; //Image Quality

//Open Source Image directory, loop through each Image and resize it.
if($dir = opendir($ImagesDirectory)){
    while(($file = readdir($dir))!== false){

        $imagePath = $ImagesDirectory.$file;
        $destPath = $DestImagesDirectory.$file;
        $checkValidImage = @getimagesize($imagePath);

        if(file_exists($imagePath) && $checkValidImage) //Continue only if 2 given parameters are true
        {
            //Image looks valid, resize.
            if(resizeImage($imagePath,$destPath,$NewImageWidth,$NewImageHeight,$Quality))
            {
                echo $file.' resize Success!<br />';
                /*
                Now Image is resized, may be save information in database?
                */

            }else{
                echo $file.' resize Failed!<br />';
            }
        }
    }
    closedir($dir);
}

//Function that resizes image.
function resizeImage($SrcImage,$DestImage, $MaxWidth,$MaxHeight,$Quality)
{
    list($iWidth,$iHeight,$type)    = getimagesize($SrcImage);
	if($MaxWidth/$iWidth>1)
	{
	$NewWidth             = $iWidth;
   	$NewHeight              = $iHeight;
	$NewCanves              = imagecreatetruecolor($iWidth, $iHeight);
	}
	else
	{
    echo $ImageScale             = min($MaxWidth/$iWidth, $MaxHeight/$iHeight);
   echo  $NewWidth               = ceil($ImageScale*$iWidth);
   echo  $NewHeight              = ceil($ImageScale*$iHeight);
    $NewCanves              = imagecreatetruecolor($NewWidth, $NewHeight);
	}

    switch(strtolower(image_type_to_mime_type($type)))
    {
        case 'image/jpeg':
            $NewImage = imagecreatefromjpeg($SrcImage);
            break;
        case 'image/png':
            $NewImage = imagecreatefrompng($SrcImage);
            break;
        case 'image/gif':
            $NewImage = imagecreatefromgif($SrcImage);
            break;
        default:
            return false;
    }

    // Resize Image
    if(imagecopyresampled($NewCanves, $NewImage,0, 0, 0, 0, $NewWidth, $NewHeight, $iWidth, $iHeight))
    {
        // copy file
        if(imagejpeg($NewCanves,$DestImage,$Quality))
        {
            imagedestroy($NewCanves);
            return true;
        }
    }
}

?>