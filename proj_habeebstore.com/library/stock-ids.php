<?php

class stock_ids {

    private $stock_ids;

    public function __construct($config) {

        $this->stock_ids = array(
            "AddProduct" => array(
                "form" => "AddProductform",
                "fields" => array(
                    "field1",
                    "field2",
                    "field3",
                    "field4",
                ),
                "dataType" => "JSON",
                "processData" => false,
                "contentType" => false,
                "type" => "POST",
                "url" => $config["EGPCSURL"] . $config["CTRL_20"] . "AddProduct",
                "Redurl" => $config["EGPCSURL"] . $config["CTRL_19"],
            ),
            "ListProducts" => array(
                "fields" => array(
                    "fieldL1",
                    "fieldL2",
                ),
                "dataType" => "JSON",
                "type" => "POST",
                "url" => $config["EGPCSURL"] . $config["CTRL_20"] . "ListProducts",
                "deactivate" => array(
                    "processData" => false,
                    "contentType" => false,
                    "dataType" => "JSON",
                    "type" => "POST",
                    "url" => $config["EGPCSURL"] . $config["CTRL_20"] . "DeleteProduct",
                    "Redurl" => $config["EGPCSURL"] . $config["CTRL_19"],
                ),
                "btnDiv" => "DeactProduct",
            ),
            "EditProduct" => array(
                "form" => "EditProductform",
                "fields" => array(
                    "fieldE1",
                    "fieldE2",
                    "fieldE3",
                    "fieldE4",
                    "fieldE5",
                ),
                "dataType" => "JSON",
                "processData" => false,
                "contentType" => false,
                "type" => "POST",
                "url" => $config["EGPCSURL"] . $config["CTRL_20"] . "EditProduct",
                "Redurl" => $config["EGPCSURL"] . $config["CTRL_19"],
            ),
        );
    }

    public function getIds() {
        return $this->stock_ids;
    }

}

?>