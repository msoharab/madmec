<?php
	define("MODULE_1","config.php");
	define("MODULE_2","database.php");
	require_once(MODULE_1);
	require_once(CONFIG_ROOT.MODULE_1);
	require_once(CONFIG_ROOT.MODULE_2);
	function main(){
		$temp = explode(".", $_FILES["file"]["name"]);
		$extension = end($temp);
		$uploaddir = DOC_ROOT."uploads/";
		recursiveRemove($uploaddir);
		$uploadfile = $uploaddir . basename('contacts.'.$extension);
		 echo '<pre>';
		if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile)) {
			echo "File is valid, and was successfully uploaded.\n";
			header('Location:'.URL.'bulksms.php');
		} else {
			echo "Possible file upload attack!\n";
		}
		echo 'ERROR!! Here is some more debugging info:';
		print_r($_FILES);
		print "</pre>";
	}
	function recursiveRemove($dir) {
		$files = glob($dir.'/*'); // get all file names
		foreach($files as $file){ // iterate files
		  if(is_file($file))
			unlink($file); // delete file
		}
	}
	 main();
?>