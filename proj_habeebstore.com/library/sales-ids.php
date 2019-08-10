<?php

class sales_ids {

    private $sales_ids;

    public function __construct($config) {

        $this->sales_ids = array(
            "ProductKg" => array(
                "form" => "ProductKgform",
                "fields" => array(
                    "fieldd1",
                    "fieldd2",
                    "fieldd3",
                    "fieldd4",
                ),
                "dataType" => "JSON",
                "processData" => false,
                "contentType" => false,
                "type" => "POST",
                "url" => $config["EGPCSURL"] . $config["CTRL_21"] . "AddProductKg",
                "Redurl" => $config["EGPCSURL"] . $config["CTRL_19"],
                "btnDiv" => "assignBtn",
                "searchProduct" => array(
                    "form" => "ProductSaleform",
                    "fields" => array(
                        "field1",
                    ),
                    "dataType" => "JSON",
                    "processData" => false,
                    "contentType" => false,
                    "loadProd" => 'Per Kg',
                    "listtype" => "select",
                    "type" => "POST",
                    "url" => $config["EGPCSURL"] . $config["CTRL_21"] . "ProductSearch",
                    "Redurl" => $config["EGPCSURL"] . $config["CTRL_19"],
                ),
            ),
            "ProductUnit" => array(
                "form" => "ProductUnitform",
                "fields" => array(
                    "field11",
                    "field22",
                    "field33",
                ),
                "dataType" => "JSON",
                "processData" => false,
                "contentType" => false,
                "type" => "POST",
                "url" => $config["EGPCSURL"] . $config["CTRL_21"] . "AddProductUnit",
                "Redurl" => $config["EGPCSURL"] . $config["CTRL_19"],
                "btnDiv" => "assignBtn",
                "searchProduct" => array(
                    "form" => "ProductSaleform",
                    "fields" => array(
                        "fld1",
                    ),
                    "dataType" => "JSON",
                    "processData" => false,
                    "contentType" => false,
                    "loadProd" => 'Per Unit',
                    "listtype" => "select",
                    "type" => "POST",
                    "url" => $config["EGPCSURL"] . $config["CTRL_21"] . "ProductSearch",
                    "Redurl" => $config["EGPCSURL"] . $config["CTRL_19"],
                ),
            ),
            "BillGenerate" => array(
                "dataType" => "JSON",
                "processData" => false,
                "contentType" => false,
                "type" => "POST",
                "url" => $config["EGPCSURL"] . $config["CTRL_21"] . "BillGenerate",
                "Redurl" => $config["EGPCSURL"] . $config["CTRL_19"],
            ),
            "SaleList" => array(
                "fields" => array(
                    "fieldL1",
                    "fieldL2",
                ),
                "dataType" => "JSON",
                "processData" => false,
                "contentType" => false,
                "type" => "POST",
                "url" => $config["EGPCSURL"] . $config["CTRL_21"] . "BillGenerate",
                "Redurl" => $config["EGPCSURL"] . $config["CTRL_19"],
                "deactivate" => array(
                    "processData" => false,
                    "contentType" => false,
                    "dataType" => "JSON",
                    "type" => "POST",
                    "url" => $config["EGPCSURL"] . $config["CTRL_21"] . "DeleteProduct",
                    "Redurl" => $config["EGPCSURL"] . $config["CTRL_19"],
                ),
                "btnDiv" => "DeactProduct",
            ),
        );
    }

    public function getIds() {
        return $this->sales_ids;
    }

}

?>