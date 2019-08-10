<?php
	define("MODULE_0","config.php");
	require_once (MODULE_0);
	function main(){
		$link = MySQLconnect(DBHOST,DBUSER,DBPASS);
		if(get_resource_type($link) == 'mysql link'){
			if(($db_select = selectDB(DBNAME_ZERO,$link)) == 1){
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
		}
		if(get_resource_type($link) == 'mysql link')
			mysql_close($link);
		exit(0);
	}
	main();
?>