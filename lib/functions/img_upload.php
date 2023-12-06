<?php

class ImageUpload{
    function imageProcessing($fileName,$tmp_name,$id){
        $randNumber = rand(1,10000);
        $ext = substr($fileName,strpos($fileName,'.'));
        $customId = $id."_".$randNumber.$ext;
        $path ="../../images/emp/".$customId;
        $dbPath = "images/emp/".$customId;
        move_uploaded_file($tmp_name,$path);
        return $dbPath;
    }
    }
    
?>