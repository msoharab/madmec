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
            if (!empty($_FILES["newspic"]["name"])) {
	    $file_name=$_FILES["newspic"]["name"];
	    $temp_name=$_FILES["newspic"]["tmp_name"];
	    $imgtype=$_FILES["newspic"]["type"];
	    $ext= GetImageExtension($imgtype);
	    $imagename=date("d-m-Y")."-".time().$ext;
	    $target_path = "images/".$imagename;
            $target_path1 = "images/".$imagename;
            if(move_uploaded_file($temp_name, $target_path)) {
            $_SESSION['imagepath']=$target_path1;
            }else{
	   exit("Error While uploading image on the server");
	}
	}
         if (!empty($_FILES["bussinessimg"]["name"])) {
	    $file_name=$_FILES["bussinessimg"]["name"];
	    $temp_name=$_FILES["bussinessimg"]["tmp_name"];
	    $imgtype=$_FILES["bussinessimg"]["type"];
	    $ext= GetImageExtension($imgtype);
	    $imagename=date("d-m-Y")."-".time().$ext;
	    $target_path = "images/"."bus".$imagename;
            $target_path1 = "images/"."bus".$imagename;
            if(move_uploaded_file($temp_name, $target_path)) {
            $_SESSION['imagepathbuss']=$target_path1;
            }else{
	   exit("Error While uploading image on the server");
	}
	} 
        if (!empty($_FILES["sponimg"]["name"])) {
	    $file_name=$_FILES["sponimg"]["name"];
	    $temp_name=$_FILES["sponimg"]["tmp_name"];
	    $imgtype=$_FILES["sponimg"]["type"];
	    $ext= GetImageExtension($imgtype);
	    $imagename=date("d-m-Y")."-".time().$ext;
	    $target_path = "images/"."spon".$imagename;
            $target_path1 = "images/"."spon".$imagename;
            if(move_uploaded_file($temp_name, $target_path)) {
            $_SESSION['imagepathspon']=$target_path1;
            }else{
	   exit("Error While uploading image on the server");
	}
	}
?>