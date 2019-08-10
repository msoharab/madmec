<?php
	define("MODULE_1","config.php");
	define("MODULE_2","database.php");
	require_once(MODULE_1);
	require_once(CONFIG_ROOT.MODULE_1);
	require_once(CONFIG_ROOT.MODULE_2);
	function main(){
		update_admin_out_log();
		session_destroy();
		clear_cookies();
		header('Location:'.URL);
	}
	function update_admin_out_log(){
		$link = MySQLconnect(DBHOST,DBUSER,DBPASS);
		if(get_resource_type($link) == 'mysql link'){
			if(($db_select = selectDB(DBNAME_ZERO,$link)) == 1){
				$query = "SELECT *
						FROM `admin_logs`
						WHERE `admin_id` = '".$_SESSION['ADMIN_ID']."'
						AND `out_time` IS NULL;
						" ;
				$res = executeQuery($query);
				if(mysql_num_rows($res) > 0){
					$res = executeQuery("UPDATE `admin_logs` 
										SET `out_time`= NOW() 
										WHERE `admin_id` = '".$_SESSION['ADMIN_ID']."'
										AND `out_time` IS NULL;");
					echo '1';
				}
				else{
					//do nothing to database
				}
			}
		}
		if(get_resource_type($link) == 'mysql link')
		mysql_close($link);
	}
	function clear_cookies(){
		// unset cookies
		if (isset($_SERVER['HTTP_COOKIE'])) {
			$cookies = explode(';', $_SERVER['HTTP_COOKIE']);
			foreach($cookies as $cookie) {
				$parts = explode('=', $cookie);
				$name = trim($parts[0]);
				setcookie($name, '', time()-1000);
				setcookie($name, '', time()-1000, '/');
			}
		}
	}
	main();
?>
