<?php
	class customer {
		protected $parameters = array();
		function __construct($para = false) {
			$this->parameters = $para;
		}
		public function fetchListOfGyms() {
			$query='SELECT gp.*,
			CASE WHEN a.`istatus` IS NULL OR a.`istatus`=""
			THEN
			"no"
			WHEN a.`istatus`=6
			THEN "no"
			ELSE
			"yes"
			END
			AS reqstatus
			FROM `gym_profile` gp
			LEFT JOIN userprofile_gymprofile upgp
			ON upgp.gym_id=gp.id
			LEFT JOIN
			(SELECT
			cr.status AS istatus,
			cr.gym_id AS creqgymid
			FROM customer_request cr
			WHERE cr.user_pk="'.mysql_real_escape_string($_SESSION['USER_LOGIN_DATA']['USER_ID']).'"
			AND cr.status !=6
			) AS a
			ON a.creqgymid=gp.id
			WHERE  gp.status=4
			AND upgp.status=11
			AND gp.id NOT IN(SELECT gym_id FROM userprofile_gymprofile WHERE user_pk="'.mysql_real_escape_string($_SESSION['USER_LOGIN_DATA']['USER_ID']).'")
			GROUP BY gp.gym_name
			ORDER BY gp.gym_name';
			$result=  executeQuery($query);
			$fetchdata=array();
			$data=array();
			$gymids=array();
			if(mysql_num_rows($result))
			{
				while ($row = mysql_fetch_assoc($result)) {
					$fetchdata[]=$row;
				}
				for($i=0;$i<sizeof($fetchdata);$i++)
				{
					$data[$i]=$fetchdata[$i]['gym_name'].'--'.$fetchdata[$i]['gym_type'].'--'.$fetchdata[$i]['addressline'].'--'.$fetchdata[$i]['town'].'--'.$fetchdata[$i]['city'].'--'.$fetchdata[$i]['district'].'--'.$fetchdata[$i]['province'].'--'.$fetchdata[$i]['zipcode'];
					$gymids[$i]=$fetchdata[$i]['id'];
				}
				$jsondata=array(
                "status" => "success",
                "data" => $data,
                "gymids" => $gymids,
                "gymdata" => $fetchdata,
				);
				return $jsondata;
			}
		}
		public function sendRequest() {
			$query="SELECT * FROM `customer_request` WHERE (`status`=4 OR `status`=14) AND `gym_id`='".  mysql_real_escape_string($this->parameters['gymid'])."' AND `user_pk`='".  mysql_real_escape_string($_SESSION['USER_LOGIN_DATA']['USER_ID'])."';";
			$result=  executeQuery($query);
			if(mysql_num_rows($result))
			{
				return 2;
			}
			else
			{
				$query='INSERT INTO `customer_request`(`id`,`user_pk`,`gym_id`,`status`)VALUES(NULL,'
				. '"'.  mysql_real_escape_string($_SESSION['USER_LOGIN_DATA']['USER_ID']).'",'
				. '"'.  mysql_real_escape_string($this->parameters['gymid']).'",14'
				. ')';
				if(executeQuery($query))
				{
					return 1;
				}
				else
				{
					return 0;
				}
			}
		}
		/*
		public function fetchListOfGyms() {
			$query='SELECT * FROM `gym_profile` WHERE status=4';
			$result=  executeQuery($query);
			$fetchdata=array();
			$data=array();
			$gymids=array();
			if(mysql_num_rows($result))
			{
				while ($row = mysql_fetch_assoc($result)) {
					$fetchdata[]=$row;
				}
				for($i=0;$i<sizeof($fetchdata);$i++)
				{
					$data[$i]=$fetchdata[$i]['gym_name'].'--'.$fetchdata[$i]['gym_type'].'--'.$fetchdata[$i]['addressline'].'--'.$fetchdata[$i]['town'].'--'.$fetchdata[$i]['city'].'--'.$fetchdata[$i]['district'].'--'.$fetchdata[$i]['province'].'--'.$fetchdata[$i]['zipcode'];
					$gymids[$i]=$fetchdata[$i]['id'];
				}
				$jsondata=array(
                "status" => "success",
                "data" => $data,
                "gymids" => $gymids,
                "gymdata" => $fetchdata,
				);
				return $jsondata;
			}
		}
		*/
		/* Main */
		public function customerPhotoUpload() {
			$dir = mysql_result(executeQuery('SELECT directory FROM `user_profile` WHERE `id`="' . $this->parameters["photo_id"] . '"'), 0);
			$photo = mysql_result(executeQuery('SELECT photo_id FROM `user_profile` WHERE `id`="' . $this->parameters["photo_id"] . '"'), 0);
			$target_dir = DOC_ROOT . ASSET_DIR . $dir . "/profile/";
			$target_file = $target_dir . basename($_FILES["file"]["name"]);
			$fn = explode(".", basename($_FILES["file"]["name"]));
			$ext = $fn[(sizeof($fn)) - 1];
			$fname = $target_dir . md5(generateRandomString()) . "." . $ext;
			$dbpath = str_replace(DOC_ROOT . ASSET_DIR, "", $fname);
			$uploadOk = 1;
			$imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
			// Check if image file is a actual image or fake image
			if (isset($_POST["submit"])) {
				$check = getimagesize($_FILES["file"]["tmp_name"]);
				if ($check !== false) {
					$uploadOk = 1;
					} else {
					echo "File is not an image.";
					$uploadOk = 0;
				}
			}
			// Check if file already exists
			if (file_exists($target_file)) {
				echo "Sorry, file already exists.";
				$uploadOk = 0;
			}
			// Check file size
			if ($_FILES["file"]["size"] > 5000000) {
				echo "Sorry, your file is too large.";
				$uploadOk = 0;
			}
			// Allow certain file formats
			if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
				echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
				$uploadOk = 0;
			}
			// Check if $uploadOk is set to 0 by an error
			if ($uploadOk == 0) {
				echo "Sorry, your file was not uploaded.";
				// if everything is ok, try to upload file
				} else {
				if (move_uploaded_file($_FILES["file"]["tmp_name"], $fname)) {
					executeQuery('UPDATE `photo` SET `ver2`= \'' . mysql_real_escape_string($dbpath) . '\'
					WHERE `id` = \'' . mysql_real_escape_string($this->parameters["photo_id"]) . '\'');
					$this->updateCUSTMasterPhoto($dbpath, $photo_id);
					} else {
					echo "Sorry, there was an error uploading your file.";
				}
			}
			//  ----------------- FILE DATA OVER
			echo $target_dir;
		}
		/* Slave */
		public function masterlistDel($mtid) {
			$query = NULL;
			$link1 = MySQLconnect(DBHOST, DBUSER, DBPASS);
			if (get_resource_type($link1) == 'mysql link') {
				if (($db_select = selectDB(DBNAME_ZERO, $link1)) == 1) {
					executeQuery("SET AUTOCOMMIT=0;");
					executeQuery("START TRANSACTION;");
					$query = 'UPDATE `user_profile` SET status = (SELECT id FROM `status` WHERE statu_name="Left" and status=1) WHERE id=' . $mtid . '';
					if (executeQuery($query)) {
						//  $flag = true;
						executeQuery("COMMIT;");
						echo "success";
					}
				}
			}
		}
		/* Slave */
		public function masterlistFlag($mtid) {
			$query = NULL;
			$link1 = MySQLconnect(DBHOST, DBUSER, DBPASS);
			if (get_resource_type($link1) == 'mysql link') {
				if (($db_select = selectDB(DBNAME_ZERO, $link1)) == 1) {
					executeQuery("SET AUTOCOMMIT=0;");
					executeQuery("START TRANSACTION;");
					$query = 'UPDATE `user_profile` SET status = (SELECT id FROM `status` WHERE statu_name="Flag" and status=1) WHERE id=' . $mtid . '';
					if (executeQuery($query)) {
						//  $flag = true;
						executeQuery("COMMIT;");
						echo "success";
					}
				}
			}
		}
		/* Slave */
		public function masterlistunFlag($mtid) {
			$query = NULL;
			$link1 = MySQLconnect(DBHOST, DBUSER, DBPASS);
			if (get_resource_type($link1) == 'mysql link') {
				if (($db_select = selectDB(DBNAME_ZERO, $link1)) == 1) {
					executeQuery("SET AUTOCOMMIT=0;");
					executeQuery("START TRANSACTION;");
					$query = 'UPDATE `user_profile` SET status = (SELECT id FROM `status` WHERE statu_name="Joined" and status=1) WHERE id=' . $mtid . '';
					if (executeQuery($query)) {
						//  $flag = true;
						executeQuery("COMMIT;");
						echo "success";
					}
				}
			}
		}
		/* Slave */
		public function editslaveListCust($data) {
			$flag = false;
			$res = executeQuery('UPDATE `customer` SET `name` = "' . $data["cname"] . '",`email` = "' . $data["cemail"] . '",`dob` = "' . $data["cdob"] . '",`date_of_join` = "' . $data["cdoj"] . '",`cell_number` = "' . $data["ccell"] . '",`occupation` = "' . $data["cocc"] . '" WHERE `id`=\'' . mysql_real_escape_string($data["cId"]) . '\';');
			$htmdata = '
			<ul>
			<li><strong>Name :</strong>' . $data["cname"] . '</li>
			<li><strong>Email :</strong>' . $data["cemail"] . '</li>
			<li><strong>Cell Number  :</strong>' . $data["ccell"] . '</li>
			<li><strong>DOB :</strong>' . date("j-M-Y", strtotime($data["cdob"])) . '</li>
			<li><strong>Joining Date :</strong>' . date("j-M-Y h:i:s A", strtotime($data["cdoj"])) . '</li>
			<li><strong>Occupation :</strong>' . $data["cocc"] . '</li>
			</ul>';
			if ($res)
			$flag = true;
			$updateAdd = array(
			"htm" => $htmdata,
			"status" => $flag,
			);
			$this->updateMasterCustomer($data);
			return $updateAdd;
		}
		/* Slave */
		public function customerEditPhotoUpload() {
			$dir = mysql_result(executeQuery('SELECT directory FROM `customer` WHERE `id`="' . $this->parameters["photo_id"] . '"'), 0);
			$photo = mysql_result(executeQuery('SELECT photo_id FROM `customer` WHERE `id`="' . $this->parameters["photo_id"] . '"'), 0);
			$photo_id = $this->parameters["user_id"];
			$target_dir = DOC_ROOT . ASSET_DIR . $dir . "/profile/";
			$target_file = $target_dir . basename($_FILES["file"]["name"]);
			$fn = explode(".", basename($_FILES["file"]["name"]));
			$ext = $fn[(sizeof($fn)) - 1];
			$fname = $target_dir . md5(generateRandomString()) . "." . $ext;
			$dbpath = str_replace(DOC_ROOT . ASSET_DIR, "", $fname);
			$uploadOk = 1;
			$imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
			// Check if image file is a actual image or fake image
			if (isset($_POST["submit"])) {
				$check = getimagesize($_FILES["file"]["tmp_name"]);
				if ($check !== false) {
					$uploadOk = 1;
					} else {
					echo "File is not an image.";
					$uploadOk = 0;
				}
			}
			// Check if file already exists
			if (file_exists($target_file)) {
				echo "Sorry, file already exists.";
				$uploadOk = 0;
			}
			// Check file size
			if ($_FILES["file"]["size"] > 50000000) {
				echo "Sorry, your file is too large.";
				$uploadOk = 0;
			}
			// Allow certain file formats
			if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
				echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
				$uploadOk = 0;
			}
			// Check if $uploadOk is set to 0 by an error
			if ($uploadOk == 0) {
				echo "Sorry, your file was not uploaded.";
				// if everything is ok, try to upload file
				} else {
				if (move_uploaded_file($_FILES["file"]["tmp_name"], $fname)) {
					executeQuery('UPDATE `photo` SET `ver2`= \'' . mysql_real_escape_string($dbpath) . '\'
					WHERE `id` = \'' . mysql_real_escape_string($photo) . '\'');
					$this->updateMasterPhoto($dbpath, $photo_id);
					} else {
					echo "Sorry, there was an error uploading your file.";
				}
			}
			//  ----------------- FILE DATA OVER
			echo $target_dir;
		}
		/* This */
		public function updateMasterCustomer($data) {
			$link1 = MySQLconnect(DBHOST, DBUSER, DBPASS);
			if (get_resource_type($link1) == 'mysql link') {
				if (($db_select = selectDB(DBNAME_ZERO, $link1)) == 1) {
					$query = 'UPDATE `user_profile` SET
					`user_name` =  \'' . mysql_real_escape_string($data["cname"]) . '\',
					`email_id` = \'' . mysql_real_escape_string($data["cemail"]) . '\',
					`cell_number` = \'' . mysql_real_escape_string($data["ccell"]) . '\',
					`dob` = \'' . mysql_real_escape_string($data["cdob"]) . '\',
					`date_of_join` = \'' . mysql_real_escape_string($data["cdoj"]) . '\'
					WHERE `id` = \'' . mysql_real_escape_string($data["master_pk"]) . '\'';
					if (executeQuery($query)) {
						$flag = true;
					}
				}
			}
			if (get_resource_type($link1) == 'mysql link')
			mysql_close($link1);
		}
		/* This */
		public function updateMasterPhoto($dbpath, $photo_id) {
			$flag = false;
			$link1 = MySQLconnect(DBHOST, DBUSER, DBPASS);
			if (get_resource_type($link1) == 'mysql link') {
				if (($db_select = selectDB(DBNAME_ZERO, $link1)) == 1) {
					$mphoto_id = mysql_result(executeQuery('SELECT photo_id FROM `user_profile` WHERE `id`="' . $photo_id . '"'), 0);
					$query = 'UPDATE `photo` SET `ver2`= \'' . mysql_real_escape_string($dbpath) . '\'
					WHERE `id` = \'' . mysql_real_escape_string($mphoto_id) . '\'';
					if (executeQuery($query)) {
						$flag = true;
					}
				}
			}
			return $flag;
		}
		/* This */
		public function updateCUSTMasterPhoto($dbpath, $photo_id) {
			$flag = false;
			$link1 = MySQLconnect(DBHOST, DBUSER, DBPASS);
			if (get_resource_type($link1) == 'mysql link') {
				if (($db_select = selectDB(DBNAME_ZERO, $link1)) == 1) {
					$mphoto_id = mysql_result(executeQuery('SELECT photo_id FROM `user_profile` WHERE `id`="' . $photo_id . '"'), 0);
					$query = 'UPDATE `photo` SET `ver2`= \'' . mysql_real_escape_string($dbpath) . '\'
					WHERE `id` = \'' . mysql_real_escape_string($mphoto_id) . '\'';
					if (executeQuery($query)) {
						$flag = true;
					}
				}
			}
			return $flag;
		}
	}
?>
