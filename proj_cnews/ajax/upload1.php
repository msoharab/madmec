<?php
session_start();
function GetImageExtension($imagetype)
	     {
	       if(empty($imagetype)) return false;
	       switch($imagetype)
	       {
	           case 'image/bmp': return '.bmp';
	           case 'image/gif': return '.gif';
	           case 'image/jpeg': return '.jpg';
	           case 'image/png': return '.png';
	           default: return false;
	       }
	    }
            if (!empty($_FILES["patientphoto1"]["name"])) {
	    $file_name=$_FILES["patientphoto1"]["name"];
	    $temp_name=$_FILES["patientphoto1"]["tmp_name"];
	    $imgtype=$_FILES["patientphoto1"]["type"];
	    $ext= GetImageExtension($imgtype);
	    $imagename=date("d-m-Y")."-".time().'.jpg';
	    $target_path = "images/".$imagename;
            $target_path1 = "images/".$imagename;
            if(move_uploaded_file($temp_name, $target_path)) {
            $_SESSION['imagepathspon']=$target_path1;
            }else{
	   exit("Error While uploading image on the server");
	}
	}
?>
