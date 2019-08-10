<?php

class stock {

    protected $parameters = array();

    function __construct($parameters = false) {
        $this->parameters = $parameters;
    }

    public function itemAdd() {
        $item_pk = 0;
        $flag = false;
        executeQuery("SET AUTOCOMMIT=0;");
        executeQuery("START TRANSACTION;");
        /* Item */
        $query = 'INSERT INTO  `item_type` (`id`,
							`type`,
							`min_criteria`,
							`add_item_date`,
							`status_id` )  VALUES(
						NULL,
						\'' . mysql_real_escape_string($this->parameters["name"]) . '\',
						\'' . mysql_real_escape_string($this->parameters["min"]) . '\',
						NOW(),
						4);';
        if (executeQuery($query)) {
            executeQuery("COMMIT");
            $flag = true;
        }
        return $flag;
    }

    public function updateStock() {
        $flag = false;
        executeQuery("SET AUTOCOMMIT=0;");
        executeQuery("START TRANSACTION;");
        /* Item */
        $query = 'INSERT INTO  `stock` (`id`,
							`type_id`,
							`quantity`,
							`date_entry`,
							`status_id` )  VALUES(
						NULL,
						\'' . mysql_real_escape_string($this->parameters["iid"]) . '\',
						\'' . mysql_real_escape_string($this->parameters["qty"]) . '\',
						NOW(),
						4);';
        if (executeQuery($query)) {


            if (executeQuery('UPDATE `item_type` SET `avaliable`=(`avaliable` + \'' . mysql_real_escape_string($this->parameters["qty"]) . '\')
										WHERE `id`= \'' . mysql_real_escape_string($this->parameters["iid"]) . '\'')) {

                executeQuery("COMMIT");
                $flag = true;
            }
            echo "I am here !!!";
            return $flag;
        }
    }

    /* Fetching avaliable stock from database */

    function fetchAvaliableStocks() {
        $ptype = array();
        $jsonptype = array();
        $query = 'SELECT * FROM item_type';
//                echo $query;
        $res = executeQuery($query);
        if (mysql_num_rows($res) > 0) {
            while ($row = mysql_fetch_assoc($res)) {
                $ptype[] = $row;
            }
        }
        if (is_array($ptype))
            $num = sizeof($ptype);
        if ($num) {
            for ($i = 0; $i < $num; $i++) {
                $jsonptype[] = array(
                    "html" => '<tr><th>' . $ptype[$i]["id"] . '</th><th>' . $ptype[$i]["type"] . '</th><th>' . $ptype[$i]["min_criteria"] . '</th><th>' . $ptype[$i]["avaliable"] . '</th></tr>'
                );
            }
        }
        return $jsonptype;
    }

    /* Ending fetching available stock from database */
}

?>