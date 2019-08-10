<?php
	define("MODULE_0","config.php");
	require_once (MODULE_0);
	require_once(CONFIG_ROOT.MODULE_0);
	require_once(CONFIG_ROOT.MODULE_1);
	require_once(CONFIG_ROOT.MODULE_2);
	function main(){
		$link = MySQLconnect(DBHOST,DBUSER,DBPASS);
		if(get_resource_type($link) == 'mysql link'){
			if(($db_select = selectDB(DBNAME_ZERO,$link)) == 1){
				if(isset($_GET)){
					if(isset($_GET["action"]) && $_GET["action"] == 'add')}{
						$query = 'SELECT `directory` FROM  `user_profile`;';
						$res = executeQuery($query);
						if(mysql_num_rows($res)){
							while($row = mysql_fetch_assoc($res)){
								if($row["directory"]){
									$dir = explode("/",$row["directory"]);
									if(createdirectories($dir[1])){
										echo $dir[1] . ' Created <br />';
									}
									else{
										echo $dir[1] . ' Failed to create <br />';
									}
								}
							}
						}
					}
					if(isset($_GET["action"]) && $_GET["action"] == 'delete' && isset($_GET["type_id"])){
					}
				}
				else{
					echo '<h2>Invalid parameters.</h2>';
				}
			}
		}
		if(get_resource_type($link) == 'mysql link')
			mysql_close($link);
		exit(0);
	}
	function Delete($path)
	{
		if (is_dir($path) === true)
		{
			$files = array_diff(scandir($path), array('.', '..'));
			foreach ($files as $file)
			{
				Delete(realpath($path) . '/' . $file);
			}
			return rmdir($path);
		}
		else if (is_file($path) === true)
		{
			return unlink($path);
		}
		return false;
	}	
	main();
?>