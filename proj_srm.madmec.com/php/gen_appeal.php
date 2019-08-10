<?php
	require_once("config.php");
	require_once(CONFIG_ROOT.MODULE_1);
	require_once(CONFIG_ROOT.MODULE_2);
	function main(){
		if(!ValidateAdmin()){
			session_destroy();
			header('Location:'.URL);
			exit(0);
		}
		elseif(isset($_POST['action']) && $_POST['action'] == 'fetch_letter_opt'){
			$_SESSION['letter_opt'] = FetchLetterOpt();
			unset($_POST);
			exit(0);
		}
		elseif(isset($_POST['action']) && $_POST['action'] == 'fetch_facilities'){
			$_SESSION['facilities'] = FetchFacilities();
			unset($_POST);
			exit(0);
		}
		elseif(isset($_POST['action']) && $_POST['action'] == 'fetch_artists'){
			$type="art";
			DisplayData($type);
			unset($_POST);
			exit(0);
		}
		elseif(isset($_POST['action']) && $_POST['action'] == 'fetch_advertisers'){
			$type="adv";
			DisplayData($type);
			unset($_POST);
			exit(0);
		}
		elseif(isset($_POST['action']) && $_POST['action'] == 'fetch_invitees'){
			$type="inv";
			DisplayData($type);
			unset($_POST);
			exit(0);
		}
		elseif(isset($_POST['action']) && $_POST['action'] == 'add_new_user_form'){
			$type = $_POST['type'];
			AddNewUserForm($type);
			unset($_POST);
			exit(0);
		}
		elseif(isset($_POST['action']) && $_POST['action'] == 'edit_entry'){
			$type = $_POST['type'];
			$id = $_POST['id'];
			EditEntry($type,$id);
			unset($_POST);
			exit(0);
		}
		elseif(isset($_POST['action']) && $_POST['action'] == 'add_entry'){
			$type = $_POST['type'];
			AddEntry($type);
			unset($_POST);
			exit(0);
		}
		elseif(isset($_POST['action']) && $_POST['action'] == 'update_entry'){
			$type = $_POST['type'];
			$id = $_POST['id'];
			UpdateEntry($type,$id);
			unset($_POST);
			exit(0);
		}
		elseif(isset($_POST['action']) && $_POST['action'] == 'delete_entry'){
			$type = $_POST['type'];
			$id = $_POST['id'];
			DeleteEntry($type,$id);
			unset($_POST);
			exit(0);
		}
		elseif(isset($_POST['action']) && $_POST['action'] == 'save_letter'){
			SaveLetter();
			unset($_POST);
			exit(0);
		}
		elseif(isset($_POST['action']) && $_POST['action'] == 'letter_list'){
			LetterList();
			unset($_POST);
			exit(0);
		}
		elseif(isset($_POST['action']) && $_POST['action'] == 'delete_letter'){
			DeleteList();
			unset($_POST);
			exit(0);
		}
		elseif(isset($_POST['action']) && $_POST['action'] == 'add_new_letter'){
			$type = $_POST['type'];
			$id = $_POST['id'];
			AddNewLetter($type,$id);
			unset($_POST);
			exit(0);
		}
		elseif(isset($_POST['action']) && $_POST['action'] == 'create_letter'){
			CreateLetter();
			unset($_POST);
			exit(0);
		}
		elseif(isset($_POST['action']) && $_POST['action'] == 'update_letter'){
			UpdateLetter();
			unset($_POST);
			exit(0);
		}
		elseif(isset($_POST['action']) && $_POST['action'] == 'print_list'){
			PrintAll($_POST['id'],$_POST['val'],$_POST['no_pages']);
			unset($_POST);
			exit(0);
		}	
		elseif(isset($_POST['action']) && $_POST['action'] == 'print_now'){
			printNow($_POST['id'],$_POST['type'],$_POST['no_pages'],$_POST['letter_sel']);
			unset($_POST);
			exit(0);
		}	
		elseif(isset($_POST['action']) && $_POST['action'] == 'print_summary'){
			PrintSummary();
			unset($_POST);
			exit(0);
		}
		/*elseif(isset($_POST['action']) && $_POST['action'] == 'edit_src_ac'){
			EditSrcAc($_POST['id']);
			unset($_POST);
			exit(0);
		}
		elseif(isset($_POST['action']) && $_POST['action'] == 'update_src_ac'){
			UpdateSrcAc($_POST['id']);
			unset($_POST);
			exit(0);
		}
		elseif(isset($_POST['action']) && $_POST['action'] == 'deactivate_src_ac'){
			DeactivateSrcAc($_POST['id']);
			unset($_POST);
			exit(0);
		}
		elseif(isset($_POST['action']) && $_POST['action'] == 'add_form_src_ac'){
			AddFormSrcAc();
			unset($_POST);
			exit(0);
		}
		elseif(isset($_POST['action']) && $_POST['action'] == 'add_src_ac'){
			AddSrcAc();
			unset($_POST);
			exit(0);
		} */
	}
	function PrintSummary(){
		$link = MySQLconnect(DBHOST,DBUSER,DBPASS);
		if(get_resource_type($link) == 'mysql link'){
			if(($db_select = selectDB(DBNAME_ZERO,$link)) == 1){
				echo '<table class="table table-striped table-bordered">
						<tr>
							<th colspan="2">
								Print Summary 
							</th>
							<th>
								Number of Pages
							</th>
							<th>
								Critical Actions
							</th>';
				$count = mysql_result(executeQuery('SELECT count(*) FROM `letters`;'),0);
					for($i=1;$i <= $count;$i++){
						$query = "SELECT A.*,B.`name` AS title 
						FROM `letters_info` AS A 
						JOIN `letters` AS B ON B.`id` = A.`let_sel` 
						WHERE 
						A.`status` = 'active' 
						AND 
						A.`print` = 'yes' 
						AND 
						A.`let_sel` = '".$i."'
						";
						$res = executeQuery($query);
						$total =mysql_num_rows($res);
						if($row = mysql_fetch_assoc($res)){
							echo '<tr>
								<td>Total Number of prints('.$row['title'].')</td><td>'.$total.'</td>
								<td>Pages: <input id="'.$i.'_no_pages" type="number" value="1" style="width:50px;border: 1px solid #f00;border-radius: 4px;" class=""></td>
								<td>
									<button style="width:200px" class="btn btn-warning form-control" onclick="javasript:print_list('.$i.',\'reset\');">
										<i class="fa fa-print"></i>
										Print AND Reset Data 
									</button>
									<button style="width:220px" class="btn btn-danger form-control" onclick="javasript:print_list('.$i.',\'no-reset\');">
										<i class="fa fa-print"></i>
										Print AND Dont Reset Data
									</button>
								</td></tr>';
						}
					}
			
				/*echo '<tr><td colspan="3" align="center">
					<button style="width:200px" class="btn btn-danger form-control" onclick="javasript:print_list(\'reset\');">
						<i class="fa fa-print"></i>
						Print All(Reset Data) 
					</button>
					<button style="width:200px" class="btn btn-danger form-control" onclick="javasript:print_list(\'no-reset\');">
						<i class="fa fa-print"></i>
						Print All(Dont Reset Data)
					</button>
					</td></tr></table>';*/
			
			}
		}
		if(get_resource_type($link) == 'mysql link')
		mysql_close($link);
	}
	function PrintAll($id,$val,$no_pages){
		$_SESSION['content'] = "";
		$link = MySQLconnect(DBHOST,DBUSER,DBPASS);
		if(get_resource_type($link) == 'mysql link'){
			if(($db_select = selectDB(DBNAME_ZERO,$link)) == 1){
				$query = "(SELECT a.*,b.*,c.`content` FROM `artists` as a 
				join `letters_info` as b on a.`id` = b.`link_id`
                join `letters` as c on b.`let_sel` = c.`id`
				where a.`status`='active' AND b.`link_type`='artists' AND b.`print` = 'yes' AND `let_sel` = '".$id."')
                UNION ALL
                (SELECT a.*,b.*,c.`content` FROM `advitisers` as a 
				join `letters_info` as b on a.`id` = b.`link_id`
                join `letters` as c on b.`let_sel` = c.`id`
				where a.`status`='active' AND b.`link_type`='advertisers' AND b.`print` = 'yes' AND `let_sel` = '".$id."')
                UNION ALL
                (SELECT a.*,b.*,c.`content` FROM `invitees` as a 
				join `letters_info` as b on a.`id` = b.`link_id`
                join `letters` as c on b.`let_sel` = c.`id`
				where a.`status`='active' AND b.`link_type`='invitees' AND b.`print` = 'yes' AND `let_sel` = '".$id."')";
				$res = executeQuery($query);
				if($res){
					while($row = mysql_fetch_assoc($res)){
					$phone = (strlen($row['phone']) > 2) ? 'Phone : '.$row['phone'].'<br />' : "";
					$mobile = (strlen($row['mobile']) > 2) ? 'Mobile : '.$row['mobile'].'<br />' : "";
					$address = '<b>'.$row['designation'].$row['name'].'</b><br />'.$row['address'].'<br />'.$phone.$mobile;
					$content = $row['content'];
					$content = preg_replace('/-----address-----/',$address,$content);
					$content = preg_replace('/last-----/',$row['last_amount'],$content);
					$content = preg_replace('/present-----/',$row['present_amount'],$content);
					$content = preg_replace('/-----facilities-----/',$row['fac_sel'],$content);
					$height = (1309 * $no_pages)+(140*($no_pages - 1));
					
					$_SESSION['content'] .=  '<div style="padding:70px;height:'.$height.'px; width:740px;position:relative;font-weight: bold !important;font-size: 17px !important;color: #1A2A5A !important; font-family:"Calibri (Body)" !important; ">
					'.nl2br($content).'</div>';
					}
					if($val == 'reset'){
						$query = "UPDATE `letters_info` SET `print`= 'no' WHERE `let_sel` = '".$id."'";
						$res = executeQuery($query);
					}
				}
				else{
					echo "Error!! try again later.";
				}
				/*
				$query = "SELECT * FROM `letters` WHERE 1";
				$res = executeQuery($query);
				if($res){
					$_SESSION['content'] = "";
					while($row = mysql_fetch_assoc($res)){
					$content = str_replace('*****address*****','bar',$row['content']);
					
					$_SESSION['content'] .=  '<div style="padding:60px;height:14in; width:8.5in; position:relative; box-shadow:0px 0px 10px 3px #ccc;">
					'.nl2br($row['content']).'</div><p></p>';
					}
				}
				else{
					echo "Error!! try again later.";
				}
				*/
			}
		}
		if(get_resource_type($link) == 'mysql link')
		mysql_close($link);

	}
	function PrintNow($id,$type,$no_pages=false,$let_id){
		$val = 'no-reset';
		$_SESSION['content'] = "";
		$link = MySQLconnect(DBHOST,DBUSER,DBPASS);
		if(get_resource_type($link) == 'mysql link'){
			if(($db_select = selectDB(DBNAME_ZERO,$link)) == 1){
				if($type == "art"){
					$query = "SELECT a.*,b.*,c.`content` FROM `artists` as a 
				join `letters_info` as b on a.`id` = b.`link_id`
                join `letters` as c on b.`let_sel` = c.`id`
				where a.`status`='active' AND b.`link_type`='artists'  AND `let_sel` = '".$let_id."' AND a.`id` = '".$id."'";
				}
				elseif($type == "adv"){
					$query = "SELECT a.*,b.*,c.`content` FROM `advitisers` as a 
				join `letters_info` as b on a.`id` = b.`link_id`
                join `letters` as c on b.`let_sel` = c.`id`
				where a.`status`='active' AND b.`link_type`='advertisers'  AND `let_sel` = '".$let_id."' AND a.`id` = '".$id."'";
				}
				elseif($type == "inv"){
					$query = "SELECT a.*,b.*,c.`content` FROM `invitees` as a 
				join `letters_info` as b on a.`id` = b.`link_id`
                join `letters` as c on b.`let_sel` = c.`id`
				where a.`status`='active' AND b.`link_type`='invitees'  AND `let_sel` = '".$let_id."' AND a.`id` = '".$id."'";
				}
				$res = executeQuery($query);
				if($res){
					while($row = mysql_fetch_assoc($res)){
					$phone = (strlen($row['phone']) > 2) ? 'Phone : '.$row['phone'].'<br />' : "";
					$mobile = (strlen($row['mobile']) > 2) ? 'Mobile : '.$row['mobile'].'<br />' : "";
					$address = '<b>'.$row['designation'].$row['name'].'</b><br />'.$row['address'].'<br />'.$phone.$mobile;
					$content = $row['content'];
					$content = preg_replace('/-----address-----/',$address,$content);
					$content = preg_replace('/last-----/',$row['last_amount'],$content);
					$content = preg_replace('/present-----/',$row['present_amount'],$content);
					$content = preg_replace('/-----facilities-----/',$row['fac_sel'],$content);
					$height = (1309 * $no_pages)+(140*($no_pages - 1));
					
					$_SESSION['content'] .=  '<div style="padding:70px;height:'.$height.'px; width:740px;position:relative;font-weight: bold !important;font-size: 17px !important;color: #1A2A5A !important; font-family:"Calibri (Body)" !important; ">
					'.nl2br($content).'</div>';
					}
					if($val == 'reset'){
						$query = "UPDATE `letters_info` SET `print`= 'no' WHERE `let_sel` = '".$id."'";
						$res = executeQuery($query);
					}
				}
				else{
					echo "Error!! try again later.";
				}
				/*
				$query = "SELECT * FROM `letters` WHERE 1";
				$res = executeQuery($query);
				if($res){
					$_SESSION['content'] = "";
					while($row = mysql_fetch_assoc($res)){
					$content = str_replace('*****address*****','bar',$row['content']);
					
					$_SESSION['content'] .=  '<div style="padding:60px;height:14in; width:8.5in; position:relative; box-shadow:0px 0px 10px 3px #ccc;">
					'.nl2br($row['content']).'</div><p></p>';
					}
				}
				else{
					echo "Error!! try again later.";
				}
				*/
			}
		}
		if(get_resource_type($link) == 'mysql link')
		mysql_close($link);

	}
	function CreateLetter(){
		$title = $_POST['title'];
		$content = $_POST['content'];
		$link = MySQLconnect(DBHOST,DBUSER,DBPASS);
		if(get_resource_type($link) == 'mysql link'){
			if(($db_select = selectDB(DBNAME_ZERO,$link)) == 1){
				$query = "INSERT INTO `letters`
				( `name`, `content`) 
				VALUES (
				'".mysql_real_escape_string($title)."',
				'".mysql_real_escape_string($content)."'
				);";
				$res = executeQuery($query);
				if($res){
					echo "Successfully Create New Letter.";
				}
				else{
					echo "Error!! try again later.";
				}
			}
		}
		if(get_resource_type($link) == 'mysql link')
		mysql_close($link);
	}
	function UpdateLetter(){
		$id = $_POST['id'];
		$title = $_POST['title'];
		$content = $_POST['content'];
		$link = MySQLconnect(DBHOST,DBUSER,DBPASS);
		if(get_resource_type($link) == 'mysql link'){
			if(($db_select = selectDB(DBNAME_ZERO,$link)) == 1){
				$query = "UPDATE `letters` 
				SET 
				`name` = '".mysql_real_escape_string($title)."',
				`content` = '".mysql_real_escape_string($content)."'
				WHERE 
				`id` = '".$id."' 
				; ";
				$res = executeQuery($query);
				if($res){
					echo "Successfully Updated Letter.";
				}
				else{
					echo "Error!! try again later.";
				}
			}
		}
		if(get_resource_type($link) == 'mysql link')
		mysql_close($link);
	}
	function AddNewLetter($type,$id=false){
		if($type == 'create'){
			echo '<form role="form">
					<div class="form-group">
						<span class="manditory">*</span>
						<label>Title :</label>
						<input id="title" class="form-control" placeholder="title of the letter">
						<span id="err_up_designation"></span>
					</div>
					<div class="form-group">
						<label>Content</label>
						<textarea id="content" class="form-control"  rows="35" placeholder="Copy paste for docx file over here"></textarea>
					</div>
					<button type="button" class="btn btn-danger form-control" onclick="javascript:create_letter();">Save Letter</button>
				</form>';
		}
		else if($type == 'edit'){
			$link = MySQLconnect(DBHOST,DBUSER,DBPASS);
			if(get_resource_type($link) == 'mysql link'){
				if(($db_select = selectDB(DBNAME_ZERO,$link)) == 1){
					$query = "SELECT * FROM `letters` 
						WHERE 
						`id` = '".$id."'";
					
					$res = executeQuery($query);
					if(mysql_num_rows($res) > 0){
						$row = mysql_fetch_assoc($res);
						echo '<form role="form">
					<div class="form-group">
						<span class="manditory">*</span>
						<label>Title :</label>
						<input id="title" class="form-control" value="'.$row['name'].'" placeholder="title of the letter">
						<span id="err_up_designation"></span>
					</div>
					<div class="form-group">
						<label>Content</label>
						<textarea id="content" class="form-control" rows="35" placeholder="Copy paste for docx file over here">'.$row['content'].'</textarea>
					</div>
					<button  type="button" class="btn btn-danger form-control" onclick="javascript:update_letter('.$row['id'].');">Save Letter</button>
				</form>';
					}
					
				}
			}
			if(get_resource_type($link) == 'mysql link')
			mysql_close($link);
		}
	}
	function LetterList(){
		$link = MySQLconnect(DBHOST,DBUSER,DBPASS);
		if(get_resource_type($link) == 'mysql link'){
			if(($db_select = selectDB(DBNAME_ZERO,$link)) == 1){
				$query = "SELECT * FROM `letters` WHERE `status` = 'active';";
				$res = executeQuery($query);
				echo '<center>
					<table class="table table-bordered " >
						<tbody>';
				if(mysql_num_rows($res) > 0){
					while($row = mysql_fetch_assoc($res)){
						echo '<tr>
								<td>
									Title: <strong style="color:#700000;">'.$row['name'].'</strong> 
										<a href="javascript:void();" onclick="javascript:add_new_letter(\'edit\','.$row['id'].')">EDIT</a> - <a href="javascript:void();" onclick="javascript:delete_letter('.$row['id'].')">DELETE</a><hr />
									<div class="dis_letters" >'.nl2br($row['content']).'</div>
									<p><hr /></p>
								</td>
							</tr>';
					}
				}
				else{
					echo '<tr><td>No letters to be displayed</td></tr>';
				}
				echo '<tr>
							<td>
								<button class="btn btn-danger btn-lg" onclick="javascript:add_new_letter(\'create\',\'new\');">Add New Letter</button>
							</td>
						</tr>
					</tbody>
				</table>';
			}
		}
		if(get_resource_type($link) == 'mysql link')
		mysql_close($link);
	}
	function DeleteList(){
		$id = $_POST['id']; 
		$link = MySQLconnect(DBHOST,DBUSER,DBPASS);
		if(get_resource_type($link) == 'mysql link'){
			if(($db_select = selectDB(DBNAME_ZERO,$link)) == 1){
				$query = "UPDATE `letters` 
				SET 
				`status` = 'delete'
				WHERE 
				`id` = '".$id."' 
				; ";
				$res = executeQuery($query);
				if($res){
					echo "Successfully deleted letter.. .";
				}
				else{
					echo "Error!! Please try delete later";
				}
			}
		}
		if(get_resource_type($link) == 'mysql link')
		mysql_close($link);
	}
	function AddNewUserForm($type){
						echo '<form role="form">
							<div class="form-group">
								<span class="manditory">*</span>
								<label>Designation</label>
								<input id="designation" class="form-control" placeholder="PLease Enter Keyword">
								<span id="err_designation"></span>
							</div>
							<div class="form-group">
								<span class="manditory">*</span>
								<label>Name</label>
								<input id="name" class="form-control" placeholder="first name last name">
								<span id="err_name"></span>
							</div>
							<div class="form-group">
								<label>Address</label>
								<textarea id="address" class="form-control" rows="3"></textarea>
							</div>
							<div class="form-group">
								<label>Phone</label>
								<input id="phone" class="form-control"  placeholder="9999999999">
								<span id="err_phone"></span>
							</div>
							<div class="form-group">
								<label>Mobile</label>
								<input id="mobile" class="form-control" placeholder="9999999999">
								<span id="err_mobile"></span>
							</div>
							<button  onclick="javascript:add_entry(\''.$type.'\');" type="button" class="btn btn-danger form-control">
								<i class="fa fa-smile-o"></i>
								Add New User
							</button>
						</form>';
				
	}
	function EditEntry($type,$id){
		$link = MySQLconnect(DBHOST,DBUSER,DBPASS);
		if(get_resource_type($link) == 'mysql link'){
			if(($db_select = selectDB(DBNAME_ZERO,$link)) == 1){
				if($type == "art"){
					$query = "SELECT * FROM `artists` WHERE `id` = '".$id."'";
				}
				elseif($type == "adv"){
					$query = "SELECT * FROM `advitisers` WHERE `id` = '".$id."'";
				}
				elseif($type == "inv"){
					$query = "SELECT * FROM `invitees` WHERE `id` = '".$id."'";
				}
				$res = executeQuery($query);
				if(mysql_num_rows($res) >0 ){
					$row = mysql_fetch_assoc($res);
						echo '<form role="form">
							<div class="form-group">
								<span class="manditory">*</span>
								<label>Designation</label>
								<input id="up_designation" class="form-control" value="'.$row['designation'].'"placeholder="PLease Enter Keyword">
								<span id="err_up_designation"></span>
							</div>
							<div class="form-group">
								<span class="manditory">*</span>
								<label>Name</label>
								<input id="up_name" class="form-control" value="'.$row['name'].'" placeholder="first name last name">
								<span id="err_up_name"></span>
							</div>
							<div class="form-group">
								<label>Address</label>
								<textarea id="up_address" class="form-control" rows="3">'.$row['address'].'</textarea>
							</div>
							<div class="form-group">
								<label>Phone</label>
								<input id="up_phone" class="form-control" value="'.$row['phone'].'" placeholder="9999999999">
								<span id="err_up_phone"></span>
							</div>
							<div class="form-group">
								<label>Mobile</label>
								<input id="up_mobile" class="form-control" value="'.$row['mobile'].'" placeholder="9999999999">
								<span id="err_up_mobile"></span>
							</div>
							<button  onclick="update_entry(\''.$type.'\','.$row['id'].');" type="button" class="btn btn-danger form-control">Save Changes</button>
						</form>';
				}
				else{
					echo "ERROR!!! Please try Editing later.";
				}
			}
		}
		if(get_resource_type($link) == 'mysql link')
		mysql_close($link);
	}
	function AddEntry($type){
		$designation = $_POST['designation'];
		$name = $_POST['name'];
		$address = $_POST['address'];
		$phone = $_POST['phone'];
		$mobile = $_POST['mobile'];
		$link = MySQLconnect(DBHOST,DBUSER,DBPASS);
		if(get_resource_type($link) == 'mysql link'){
			if(($db_select = selectDB(DBNAME_ZERO,$link)) == 1){
				if($type == "art"){
					$query = "INSERT INTO `artists`
					( `designation`, `name`, `address`, `phone`, `mobile`) 
					VALUES 
					('".mysql_real_escape_string($designation)."',
					'".mysql_real_escape_string($name)."',
					'".mysql_real_escape_string($address)."',
					 '".mysql_real_escape_string($phone)."',
					 '".mysql_real_escape_string($mobile)."' ); ";
				}
				elseif($type == "adv"){
					$query = "INSERT INTO `advitisers`
					( `designation`, `name`, `address`, `phone`, `mobile`) 
					VALUES 
					('".mysql_real_escape_string($designation)."',
					'".mysql_real_escape_string($name)."',
					'".mysql_real_escape_string($address)."',
					 '".mysql_real_escape_string($phone)."',
					 '".mysql_real_escape_string($mobile)."' ); ";
				}
				elseif($type == "inv"){
					$query = "INSERT INTO `invitees`
					( `designation`, `name`, `address`, `phone`, `mobile`) 
					VALUES 
					('".mysql_real_escape_string($designation)."',
					'".mysql_real_escape_string($name)."',
					'".mysql_real_escape_string($address)."',
					 '".mysql_real_escape_string($phone)."',
					 '".mysql_real_escape_string($mobile)."' );  ";
				}
				$res = executeQuery($query);
				if($res){
					echo "Add new user successfully";
				}
				else{
					echo "ERROR!!! Please try adding  later";
				}
			}
		}
		if(get_resource_type($link) == 'mysql link')
		mysql_close($link);
	}		
	function UpdateEntry($type,$id){
		$designation = $_POST['designation'];
		$name = $_POST['name'];
		$address = $_POST['address'];
		$phone = $_POST['phone'];
		$mobile = $_POST['mobile'];
		$link = MySQLconnect(DBHOST,DBUSER,DBPASS);
		if(get_resource_type($link) == 'mysql link'){
			if(($db_select = selectDB(DBNAME_ZERO,$link)) == 1){
				if($type == "art"){
					$query = "UPDATE `artists` SET 
					`designation` = '".mysql_real_escape_string($designation)."',
					`name` = '".mysql_real_escape_string($name)."',
					`address` = '".mysql_real_escape_string($address)."',
					`phone` = '".mysql_real_escape_string($phone)."',
					`mobile` = '".mysql_real_escape_string($mobile)."'
					WHERE 
					`id` = '".$id."'";
				}
				elseif($type == "adv"){
					$query = "UPDATE `advitisers`  SET 
					`designation` = '".mysql_real_escape_string($designation)."',
					`name` = '".mysql_real_escape_string($name)."',
					`address` = '".mysql_real_escape_string($address)."',
					`phone` = '".mysql_real_escape_string($phone)."',
					`mobile` = '".mysql_real_escape_string($mobile)."'
					WHERE 
					`id` = '".$id."'";
				}
				elseif($type == "inv"){
					$query = "UPDATE `invitees`  SET 
					`designation` = '".mysql_real_escape_string($designation)."',
					`name` = '".mysql_real_escape_string($name)."',
					`address` = '".mysql_real_escape_string($address)."',
					`phone` = '".mysql_real_escape_string($phone)."',
					`mobile` = '".mysql_real_escape_string($mobile)."'
					WHERE 
					`id` = '".$id."'";
				}
				$res = executeQuery($query);
				if($res){
					echo "Updated successfully";
				}
				else{
					echo "ERROR!!! Please try Updating  later";
				}
			}
		}
		if(get_resource_type($link) == 'mysql link')
		mysql_close($link);
	}		
	function DeleteEntry($type,$id){
		$link = MySQLconnect(DBHOST,DBUSER,DBPASS);
		if(get_resource_type($link) == 'mysql link'){
			if(($db_select = selectDB(DBNAME_ZERO,$link)) == 1){
				if($type == "art"){
					$query = "UPDATE `artists` SET `status` = '".mysql_real_escape_string('delete')."' WHERE `id` = '".$id."'";
				}
				elseif($type == "adv"){
					$query = "UPDATE `advitisers` SET `status` = '".mysql_real_escape_string('delete')."' WHERE `id` = '".$id."'";
				}
				elseif($type == "inv"){
					$query = "UPDATE `invitees` SET `status` = '".mysql_real_escape_string('delete')."' WHERE `id` = '".$id."'";
				}
				$res = executeQuery($query);
				if($res){
					echo "Deleted successfully";
				}
				else{
					echo "ERROR!!! Please try deleting later";
				}
			}
		}
		if(get_resource_type($link) == 'mysql link')
		mysql_close($link);
	}		
	
	function SaveLetter(){
		$result_fac = $_SESSION['facilities'];
		$type = $_POST['type'];
		$id = $_POST['id'];
		$last_amount = $_POST['last_amount'];
		$present_amount = $_POST['pres_amount'];
		$print = $_POST['print'];
		$letter_sel = $_POST['letter_sel'];
		$total_fac = $_POST['total_fac'];
		$facilities = $_POST['facilities'];
		if($type == 'art'){
			$link_type = 'artists';
		}
		elseif($type == 'adv'){
			$link_type = 'advertisers';
		}
		elseif($type == 'inv'){
			$link_type = 'invitees';
		}
		elseif($type == 'tar'){
			$link_type = 'target';
		}
		$link = MySQLconnect(DBHOST,DBUSER,DBPASS);
		if(get_resource_type($link) == 'mysql link'){
			if(($db_select = selectDB(DBNAME_ZERO,$link)) == 1){
				$query0 = "SELECT `id` , `link_id` FROM `letters_info` 
				WHERE 
				`link_id` = '".mysql_real_escape_string($id)."' 
				AND 
				`link_type` = '".mysql_real_escape_string($link_type)."'; ";
				$res0 = executeQuery($query0);
				if(mysql_num_rows($res0) > 0){
					$sub_query = "";
						for($i = 1 ; $i <= $total_fac ; $i++ ){
							$fac[$i] = $facilities[$i];
							$sub_query .= ( $fac[$i] != 0 || $fac[$i] != '0' ) ? "\t- ".$result_fac[$i]['name']."\n" : "";
					}
					$query = "UPDATE `letters_info` 
					SET 
					`last_amount` = '".mysql_real_escape_string($last_amount)."',
					`present_amount` = '".mysql_real_escape_string($present_amount)."',
					`print` = '".mysql_real_escape_string($print)."',
					`fac_sel` = '".mysql_real_escape_string($sub_query)."',
					`let_sel` = '".mysql_real_escape_string($letter_sel)."'
					WHERE 
					`link_id` = '".mysql_real_escape_string($id)."'
					AND
					`link_type` = '".mysql_real_escape_string($link_type)."' ;
					";
					$res = executeQuery($query);
					if($res){
						echo "Letter updated successfully";
					}
					else{
						executeQuery("ROLLBACK");
						echo "nothing happened";
					}
				}
				else
				{
					$sub_query = "";
						for($i = 1 ; $i <= $total_fac ; $i++ ){
							$fac[$i] = $facilities[$i];
							$sub_query .= ( $fac[$i] != 0 || $fac[$i] != '0' ) ? "\t- ".$result_fac[$i]['name']."\n" : "";
						}
					$query = "INSERT INTO `letters_info`
					( `link_id`, `link_type`, `last_amount`, `present_amount`, `print`,`fac_sel`,`let_sel`) 
					VALUES 
					('".mysql_real_escape_string($id)."',
					'".mysql_real_escape_string($link_type)."',
					'".mysql_real_escape_string($last_amount)."',
					'".mysql_real_escape_string($present_amount)."',
					'".mysql_real_escape_string($print)."',
					'".mysql_real_escape_string($sub_query)."',
					'".mysql_real_escape_string($letter_sel)."'
					);";
					$res = executeQuery($query);
					if($res){
						echo "New Letter Created successfully";
					}
					else{
						echo "ERROR!! Details:could not insert into letter_info";
					}
				}
			}
		}
		if(get_resource_type($link) == 'mysql link')
		mysql_close($link);
	}
	function FetchFacilities(){
		$result =  array();
		$link = MySQLconnect(DBHOST,DBUSER,DBPASS);
		if(get_resource_type($link) == 'mysql link'){
			if(($db_select = selectDB(DBNAME_ZERO,$link)) == 1){
				$query = "SELECT * FROM `letter_facilities` WHERE `status` = 'active';";
				$res = executeQuery($query);
				$_SESSION['total_facilities'] = mysql_num_rows($res);
				if($_SESSION['total_facilities'] > 0){
					$i=1;
					while($row = mysql_fetch_assoc($res)){
						$result[$i]['id'] = $row['id'];
						$result[$i]['name'] = $row['name'];
						$i++;
					}
				}
				else{
					$result = NULL;
				}
			}
		}
		if(get_resource_type($link) == 'mysql link')
		mysql_close($link);
		return $result;
	}
	function FetchLetterOpt(){
		$result =  array();
		$link = MySQLconnect(DBHOST,DBUSER,DBPASS);
		if(get_resource_type($link) == 'mysql link'){
			if(($db_select = selectDB(DBNAME_ZERO,$link)) == 1){
				$query = "SELECT * FROM `letters`;";
				$res = executeQuery($query);
				$_SESSION['total_letters'] = mysql_num_rows($res);
				if($_SESSION['total_letters'] > 0){
					$i=1;
					while($row = mysql_fetch_assoc($res)){
						$result[$i]['id'] = $row['id'];
						$result[$i]['name'] = $row['name'];
						$result[$i]['content'] = $row['content'];
						$result[$i]['status'] = $row['status'];
						$i++;
					}
				}
				else{
					$result = NULL;
				}
			}
		}
		if(get_resource_type($link) == 'mysql link')
		mysql_close($link);
		return $result;
	}
	
	function DisplayData($type){
		$facilities = $_SESSION['facilities'];
		$total_facilities = $_SESSION['total_facilities'];
		$letters_opt	 = $_SESSION['letter_opt'];
		$total_letters = $_SESSION['total_letters'];
		echo '<table class="table table-bordered ">
			<thead>
				<tr>
					<th width="250">Name & Address</th>
					<th>Amount</th>
					<th>Select Facilities</th>
					<th>Select Letter</th>
					<th>Print</th>
					<th>Critical Action</th>
				</tr>
			</thead>
			<tbody>';
		$link = MySQLconnect(DBHOST,DBUSER,DBPASS);
		if(get_resource_type($link) == 'mysql link'){
			if(($db_select = selectDB(DBNAME_ZERO,$link)) == 1){
				if($type == "art"){
					$query = "SELECT * FROM `artists` WHERE `status` ='active'; ";
				}
				elseif($type == "adv"){
					$query = "SELECT * FROM `advitisers` WHERE `status` ='active'; ";
				}
				elseif($type == "inv"){
					$query = "SELECT * FROM `invitees` WHERE `status` ='active'; ";
				}
				$res = executeQuery($query);
				if(mysql_num_rows($res)){
					
					while( $row = mysql_fetch_assoc($res)){
						//fetches all the given values from database
						$fetch_value = fetch_value($type,$row['id']);
						$print = ($fetch_value['print'] == 'yes') ? 'checked' : '';
						$sel_letter = $fetch_value['let_sel'];
						$dis_facilities = '<input type="hidden" id="total_fac_'.$type.'_'.$row['id'].'" value="'.$total_facilities.'" />';
						for( $j = 1;$j <= $total_facilities; $j++){
							$dis_facilities .='<input type="checkbox" name="facilities" value="'.$j.'" id="'.$type.'_fac_'.$row['id'].'_'.$facilities[$j]['id'].'"> '.substr($facilities[$j]['name'],0,25).'...<br />';
						}
						$dis_letter_opt = '<input type="hidden" id="total_let_'.$type.'_'.$row['id'].'" value="'.$total_letters.'" />';
						for( $k = 1; $k <= $total_letters; $k++){
							$vis = ($letters_opt[$k]['status'] != 'active') ? 'style="display:none;"' : '';
							if($sel_letter == $k){
								$dis_letter_opt .= '<div '.$vis.'><input  type="radio" checked name="'.$type.'_let_'.$row['id'].'" value="'.$k.'" id="'.$type.'_let_'.$row['id'].'_'.$letters_opt[$k]['id'].'"> '.substr($letters_opt[$k]['name'],0,25).'...</div>';
							}
							else{
								$dis_letter_opt .= '<div '.$vis.'><input type="radio"  name="'.$type.'_let_'.$row['id'].'" value="'.$k.'" id="'.$type.'_let_'.$row['id'].'_'.$letters_opt[$k]['id'].'"> '.substr($letters_opt[$k]['name'],0,25).'...</div>';
							}
						}
						if($print == 'checked'){
							$dis_facilities .= '<strong style="color:#700000;">Selected :</strong><br />'.nl2br($fetch_value['fac_sel']);
							echo '<tr style="background-color:#DFF0D8;">';
						}
						else{
							echo '<tr>';
						}
						echo '
							<td>
								<strong style="color:#700000;">'.$row['designation'].$row['name'].'</strong><br />
								<b>Address : </b>'.nl2br($row['address']).'<br />
								<strong>Phone : </strong>'.$row['phone'].'<br />
								<strong>Mobile : </strong>'.$row['mobile'].'
							</td>
							<td>
								<strong style="color:#700000;">Last Year : </strong>
								<input class="form-control" type="text" placeholder="00000" id="'.$type.'_last_'.$row['id'].'" value="'.$fetch_value['last_amount'].'"/><br />
								<strong style="color:#700000;">Present Year : </strong>
								<input class="form-control" type="text" placeholder="00000" id="'.$type.'_pres_'.$row['id'].'" value="'.$fetch_value['present_amount'].'"/>
							</td>
							<td>
								'.$dis_facilities.'
							</td>
							<td>
								'.$dis_letter_opt.'
							</td>
							<td>
								<input '.$print.' type="checkbox" name="print" onchange=" $(this).parent().parent().css({\'background-color\':\'#DFF0D8\'});" id="'.$type.'_print_'.$row['id'].'"> 
								<strong  style="color:#700000;">Print</strong>
							</td>
							<td align="center">
								<button style="width:100px;"class="btn btn-success"  onclick="javasript:save_letter(\''.$type.'\','.$row['id'].');">
									<i class="fa fa-save"></i>
									 Save
								</button>
								<br />
								<button style="width:100px;"class="btn btn-warning"  onclick="javasript:print_letter(\''.$type.'\','.$row['id'].');">
									<i class="fa fa-save"></i>
									 Print Now
								</button>
								<br />
								<button style="width:100px;"class="btn btn-primary"  onclick="javasript:edit_entry(\''.$type.'\','.$row['id'].');">
									<i class="fa fa-edit"></i>
									Edit
								</button>
								<br />
								<button style="width:100px;"class="btn btn-danger" onclick="javasript:delete_entry(\''.$type.'\','.$row['id'].');">
									<i class="fa fa-frown-o"></i>
									 Delete
								</button>
							</td>
						</tr>';
					}
				}
				else{
					echo '<tr>
							<td colspan="7">No Accouts to be displayed,Please add new account.</td>
						</tr>';
				}
			}
		}
		echo '<!--<tr>
					<td colspan="7" align="center">
						<a class="btn btn-danger btn-lg" onclick="javascript:print_all();" href="javascript:void(0);">
							PRINT ALL APPEALS
						</a>
					</td>
				</tr>-->
			</tbody>
		</table>';
		if(get_resource_type($link) == 'mysql link')
		mysql_close($link);
	}
	function fetch_value($type,$id){
		$result = array();
		$query = "SELECT * FROM `letters_info` WHERE `link_id` = '".$id."'  AND `link_type` LIKE '".$type."%'";
		/*$query = "SELECT a.*,b.`status` 
		FROM `letters_info` AS a 
		JOIN `letters` AS b ON a.`let_sel` = b.`id` 
		WHERE `link_id` = '".$id."'  AND `link_type` LIKE '".$type."%'"; */
		$res = $res = executeQuery($query);
		if(mysql_num_rows($res) > 0){
			$row = mysql_fetch_assoc($res);
			return $row;
		}
		else{
			return NULL;
		}
		
	}
	function display_facilities($type,$id){
		$result= '';
		$facilities = $_SESSION['facilities'];
		$total_facilities = $_SESSION['total_facilities'];
		for( $i = 1;$i <= $total_facilities; $i++){
			echo '<input type="checkbox" name="facilities" id="'.$type.'_fac_'.$id.'_'.$facilities[$i]['id'].'"> '.substr($facilities[$i]['name'],0,25).'...<br />';
		}
		return $result;
	}
	
	main();
?>

<?php include_once(DOC_ROOT.PHP.INC."header.php"); ?>
<div id="page-wrapper" >
	<div id="page-inner">
		<div class="row">
			
			<div class="col-md-12">
				<div class="btn-group btn-group-justified">
				  <div class="btn-group">
					<button type="button" class="btn btn-danger btn-lg" onclick="javascript:dis_print();">Print All Letters</button>
				  </div>
				  <div class="btn-group">
					<button type="button" class="btn btn-danger btn-lg" onclick="javascript:dis_add_letter()">Upload New Letter</button>
				  </div>
				 </div>
			</div>
			<hr />
			<hr />
			<div class="col-md-12">
				<div class="btn-group btn-group-justified">
				  <div class="btn-group">
					<button type="button" class="btn btn-primary btn-lg" onclick="javascript:dis_art();">Artists</button>
				  </div>
				  <div class="btn-group">
					<button type="button" class="btn btn-warning btn-lg" onclick="javascript:dis_adv()">Advertisers</button>
				  </div>
				  <div class="btn-group">
					<button type="button" class="btn btn-info btn-lg" onclick="javascript:dis_inv()">Invitees</button>
				  </div>
				</div>
			</div>
		</div>
		<hr />
		<div class="row"> 
			<div class="col-md-12">
				<div id="src_art" class="panel panel-primary">
					<div class="panel-heading">
						<h3>Artists - <a href="javascript:void(0);" onclick="add_new_user_form('art')" style="color:#000; float:right;">Add New Artist</a></h3>
					</div>
					<div class="panel-body">
						<div id="src_artists" class="table-responsive">
							<center><img class="img-circle" src="<?php echo URL.ASSET_IMG; ?>loader.gif" border="0"/></center>
						</div>
					</div>
					<div class="panel-footer">
					</div>
				</div>
				
				<div id="src_adv" class="panel panel-warning">
					<div class="panel-heading">
						<h3>Advertisers - <a href="javascript:void(0);" onclick="add_new_user_form('adv')" style="color:#000; float:right;">Add New Advertisers</a></h3>
					</div>
					<div class="panel-body">
						<div id="src_advertisers" class="table-responsive">
							<center><img class="img-circle" src="<?php echo URL.ASSET_IMG; ?>loader.gif" border="0"/></center>
						</div>
					</div>
					<div class="panel-footer">
					</div>
				</div>
				<div id="src_inv" class="panel panel-info" >
					<div class="panel-heading">
						<h3>Invitees - <a href="javascript:void(0);" onclick="add_new_user_form('inv')" style="color:#000; float:right;">Add New Invitees</a></h3>
					</div>
					<div class="panel-body">
						<div id="src_invitees" class="table-responsive">
							<center><img class="img-circle" src="<?php echo URL.ASSET_IMG; ?>loader.gif" border="0"/></center>
						</div>
					</div>
					<div class="panel-footer">
					</div>
				</div>
				<div id="src_prt" class="panel panel-danger" >
					<div class="panel-heading">
						<h3>Print All Letters</h3>
					</div>
					<div class="panel-body">
						<div id="src_print" class="table-responsive">
							<center><img class="img-circle" src="<?php echo URL.ASSET_IMG; ?>loader.gif" border="0"/></center>
						</div>
					</div>
					<div class="panel-footer">
					</div>
				</div>
				<div id="src_let" class="panel panel-danger" >
					<div class="panel-heading">
						<h3>Manage Letters</h3>
					</div>
					<div class="panel-body">
						<div id="src_letter" class="table-responsive">
							<center><img class="img-circle" src="<?php echo URL.ASSET_IMG; ?>loader.gif" border="0"/></center>
						</div>
					</div>
					<div class="panel-footer">
					</div>
				</div>
            </div>	
		</div>
		<!-- /. ROW  -->
    </div>
	<!-- /. PAGE INNER  -->
</div>
<!-- /. PAGE WRAPPER  -->
<?php include_once(DOC_ROOT.PHP.INC."footer.php"); ?>
<script src="<?php echo URL.ASSET_JS; ?>gen_appeal.js"></script>
<script>
		$("#gen_nav").addClass("active-menu");
</script>