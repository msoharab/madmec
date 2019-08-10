<?php

class Orders_Model extends BaseModel {

    private $para;

    function __construct($para = false) {
        parent::__construct();

        $this->para = $para;
    }

}

?>