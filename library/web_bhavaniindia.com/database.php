<?php

$db = NULL;
$out = NULL;

class dataBase extends PDO {

    private $connString;

    function __construct($para = false) {
        $this->connString = isset($para) && is_array($para) ?
                ($para["dbtype"] . ':host=' . $para["host"] . ';dbname=' . $para["dbname"]) :
                ('mysql:host=' . DBHOST . ';dbname=' . DBNAME_ZERO);
        if (is_array($para) && isset($para["user"]) && isset($para["password"])) {
            parent::__construct($this->connString, $para["user"], $para["password"]);
        } else {
            parent::__construct($this->connString, DBUSER, DBPASS);
        }
        $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    }

}

//require_once('mysql2i.class.php');
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