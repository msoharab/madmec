<?php

class showstatus {

    protected $parameters = array();

    function __construct($para = false) {
        $this->parameters = $para;
    }

    function showhidestatus() {
        $result = false;
        $query = 'SELECT * FROM status WHERE statu_name="Show" OR statu_name="Hide" AND status=1';
        $result = executeQuery($query);
        while ($row = mysql_fetch_assoc($result)) {
            echo '<option value=' . $row["id"] . '>' . $row["statu_name"] . '</option>';
        }
        echo '</select>';
    }

}

?>	