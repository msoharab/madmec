<?php
	function MySQLconnect($host,$user,$pass)
	{
		$lnk = mysql_connect($host,$user,$pass);
		if (!$lnk) 
		{
    		die('<font color=\"#99AD00\">Error 1 :- Connection error: ' . mysql_error()."<br /> Check the Database server.</font>");
			return false;
		}
		else
		{
			return $lnk;
		}
	}
	
	function selectDB($db,$link)
	{
		$db_select = mysql_select_db($db,$link);
		if (!$db_select) 
		{
    		die('<font color=\"#99AA00\">Error 2 :- Database name: ' . mysql_error()."<br /> Check the table name.</font>");
			return false;
		}
		else
		{
			return $db_select;
		}
	}
	
	function executeQuery($query)
	{
		$out = mysql_query($query);
		if (!$out) 
		{
			$message  = '<font color=\"#990099\">Error 3 :- Invalid query: ' . mysql_error() . "<br />";
			$message .= 'Whole query: ' . $query. "</font><br />";
			die($message);
			return false;
		}
		else
		{
			return $out;
		}
	}
?>