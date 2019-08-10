<?php
class dataBase extends PDO {

    private $connString, $obj;

    function __construct($para = false) {
        $this->obj = new configure();
        $this->connString = isset($para) && is_array($para) ?
                ($para["dbtype"] . ':host=' . $para["host"] . ';dbname=' . $para["dbname"]) : ('mysql:host=' . $this->obj->config["DBHOST"] . ';dbname=' . $this->obj->config["DBNAME_ZERO"]);
        if (is_array($para) && isset($para["user"]) && isset($para["password"])) {
            parent::__construct($this->connString, $para["user"], $para["password"]);
        } else {
            parent::__construct($this->connString, $this->obj->config["DBUSER"], $this->obj->config["DBPASS"]);
        }
        $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    }
}
?>