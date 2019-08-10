<?php
	require_once("config.php");
	require_once(CONFIG_ROOT.MODULE_1);
	require_once(CONFIG_ROOT.MODULE_2);
        if($_SESSION['USERTYPE'] != "admin")
                header("Location:".URL);
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml"> <html>
    <head>
		<script type="text/javascript" src="http://js.nicedit.com/nicEdit-latest.js"></script> 
		<script type="text/javascript">
		//<![CDATA[
		bkLib.onDomLoaded(function() { nicEditors.allTextAreas() });
		//]]>
		</script>
		
    <link href="<?php echo URL.ASSET_CSS; ?>bootstrap.css" rel="stylesheet" />
	</head>
<body style="min-height:1100px;width:900px;box-shadow:0px 0px 4px 1px #000;  margin-left: auto; margin-right: auto;padding:25px;
    ">
<?php
	function main(){
		if(!ValidateAdmin()){
			session_destroy();
			header('Location:'.URL);
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
		elseif(isset($_GET['action']) && $_GET['action'] == 'add_new_letter'){
			$type = $_GET['type'];
			$id = $_GET['id'];
			AddNewLetter($type,$id);
			unset($_GET);
		}
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
						<textarea id="content" class="form-control"  rows="40" style="width:850px;" placeholder="Copy paste for docx file over here"></textarea>
					</div>
					<button type="button" class="btn btn-danger form-control" onclick="javascript:create_letter();">Save Letter</button>
				</form>
				<div>
					Note: <br />
					TO replace Address use : <strong>  -----address-----   </strong>  <br />
					TO replace Last Year Amount use :  <strong>    last-----   </strong>  <br />
					TO replace Last This Amount use:  <strong>    present-----   </strong>  <br />
					TO replace Facilities :  <strong>    -----facilities-----   </strong>  <br />
					</div>';
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
	main();
?>
	
<script src="<?php echo URL.ASSET_JS; ?>jquery-1.10.2.js"></script>
<script src="<?php echo URL.MAIN_JS; ?>config.js"></script>
<script >

function create_letter(){
	var loc = URL+'php/gen_appeal.php';
	var title = $("#title").val();
	var cont = nicEditors.findEditor('content');
	content = cont.getContent();
	//$('#load_box').show();
	$.ajax({
		url:window.location.href,
		type:'POST',
		data:{action:'create_letter','title':title,'content':content},
		success:function(data){
		//	$('#load_box').hide();
			alert('Letter created successfully');
			window.location.href= loc;
		}
	}); 
}
function update_letter(id){
	var loc = URL+'php/gen_appeal.php';
	var title = $("#title").val();
	var cont = nicEditors.findEditor('content');
	content = cont.getContent();
	//$('#load_box').show();
	$.ajax({
		url:window.location.href,
		type:'POST',
		data:{action:'update_letter','id':id,'title':title,'content':content},
		success:function(data){
			alert('Letter Updated successfully');
			window.location.href= loc;
		}
	});
}
</script>
</body>
</html>
