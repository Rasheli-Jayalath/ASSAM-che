<?php $files = glob('cache/*'); //get all file names
foreach($files as $file){
    if(is_file($file))
    unlink($file); //delete file
} 
print "<script type='text/javascript'>";
    print "self.close();";
    print "</script>";
?>