<?php

class food_ids {

    private $api_user_ids;

    public function __construct($config) {

        $this->api_user_ids = array(
            "ApiPersonal" => array(
                "AddUser" => array(
                    "form" => "personalDetailsForm",
                    "fields" => array(
                        "field1",
                        "field2",
                        "field3",
                        "field4",
                        "field5",
                        "field6",
                        "field7",
                        "field8",
                        "field9",
                        "field10",
                        "field11",
                        "field12",
                        "field13",
                        "field14",
                        "field15",
                        "field16",
                        "field17"
                    ),
                    "dataType" => "JSON",
                    "type" => "POST",
                    "checkemail" => array(
                        "dataType" => "JSON",
                        "processData" => false,
                        "contentType" => false,
                        "type" => "POST",
                        "url" => $config["URL"] . $config["CTRL_20"] . "checkEmail",
                    ),
                    "gender" => array(
                        "id" => "genderme_",
                        "class" => "megender",
                        "listtype" => "option",
                        "dataType" => "JSON",
                        "type" => "POST",
                        "url" => $config["URL"] . $config["CTRL_20"] . "fetchGender",
                    ),
                    "doctype" => array(
                        "id" => "doctypeme_",
                        "class" => "medoctype",
                        "listtype" => "option",
                        "dataType" => "JSON",
                        "type" => "POST",
                        "url" => $config["URL"] . $config["CTRL_20"] . "fetchDocTypes",
                    ),
                    "dataType" => "JSON",
                    "type" => "POST",
                    "processData" => false,
                    "contentType" => false,
                    "url" => $config["URL"] . $config["CTRL_20"] . "AddUser",
                    "defaultImage" => $config["DEFAULT_IMG"],
                    "Redurl" => $config["URL"] . $config["CTRL_0"],
                ),
                "ListUser" => array(
                    "fields" => array(
                        "fieldtab1",
                        "fieldtab2",
                    ),
                    "dataType" => "JSON",
                    "type" => "POST",
                    "processData" => false,
                    "contentType" => false,
                    "url" => $config["URL"] . $config["CTRL_20"] . "ListUserPersonal",
                    "Redurl" => $config["URL"] . $config["CTRL_0"],
                ),
            ),
            "ApiBusiness" => array(
                "AddBusiness" => array(
                    "form" => "businessDetailsForm",
                    "fields" => array(
                        "field1",
                        "field2",
                        "field3",
                        "field4",
                        "field5",
                        "field6",
                        "field7",
                        "field8",
                        "field9",
                        "field10",
                        "field11",
                        "field12",
                        "field13",
                        "field14",
                        "field15",
                        "field16",
                        "field17",
                        "field18",
                        "field19",
                        "field20",
                        "field21",
                        "field22",
                        "field23",
                        "field24",
                        "field25",
                        "field26"
                    ),
                    "searchuser" => array(
                        "dataType" => "JSON",
                        "type" => "POST",
                        "processData" => false,
                        "contentType" => false,
                        "url" => $config["URL"] . $config["CTRL_20"] . "searchUser",
                    ),
                    "busidtype" => array(
                        "id" => "doctypeme_",
                        "class" => "medoctype",
                        "listtype" => "option",
                        "dataType" => "JSON",
                        "type" => "POST",
                        "url" => $config["URL"] . $config["CTRL_20"] . "fetchBusIdTypes",
                    ),
                    "busadddoctype" => array(
                        "id" => "doctypeme_",
                        "class" => "medoctype",
                        "listtype" => "option",
                        "dataType" => "JSON",
                        "type" => "POST",
                        "url" => $config["URL"] . $config["CTRL_20"] . "fetchBusAddTypes",
                    ),
                    "dataType" => "JSON",
                    "type" => "POST",
                    "processData" => false,
                    "contentType" => false,
                    "defaultImage" => $config["DEFAULT_IMG"],
                    "url" => $config["URL"] . $config["CTRL_20"] . "AddBusinessDetails",
                    "Redurl" => $config["URL"] . $config["CTRL_0"],
                ),
                "ListBusiness" => array(
                    "fields" => array(
                        "fieldtab1",
                        "fieldtab2",
                    ),
                    "dataType" => "JSON",
                    "processData" => false,
                    "contentType" => false,
                    "type" => "POST",
                    "url" => $config["URL"] . $config["CTRL_20"] . "ListUserBusiness",
                    "Redurl" => $config["URL"] . $config["CTRL_0"],
                ),
                "EditBusiness" => array(
                    "form" => "businessDetailsForm",
                    "fields" => array(
                        "field1",
                        "field2",
                        "field3",
                        "field4",
                        "field5",
                        "field6",
                        "field7",
                        "field8",
                        "field9",
                        "field10",
                        "field11",
                        "field12",
                        "field13",
                        "field14",
                        "field15",
                        "field16",
                        "field17",
                        "field18",
                        "field19",
                        "field20",
                        "field21",
                        "field22",
                        "field23",
                        "field24",
                        "field25",
                        "field26"
                    ),
                    "searchuser" => array(
                        "dataType" => "JSON",
                        "type" => "POST",
                        "processData" => false,
                        "contentType" => false,
                        "url" => $config["URL"] . $config["CTRL_20"] . "searchUser",
                    ),
                    "dataType" => "JSON",
                    "type" => "POST",
                    "processData" => false,
                    "contentType" => false,
                    "defaultImage" => $config["DEFAULT_IMG"],
                    "url" => $config["URL"] . $config["CTRL_20"] . "AddBusinessDetails",
                    "Redurl" => $config["URL"] . $config["CTRL_0"],
                ),
            ),
            "ApiRequest" => array(
                "ListNewRequest" => array(
                    "fields" => array(
                        "fieldnew1",
                        "fieldnew2",
                    ),
                    "dataType" => "JSON",
                    "type" => "POST",
                    "processData" => false,
                    "contentType" => false,
                    "url" => $config["URL"] . $config["CTRL_20"] . "UserRequestNew",
                    "Redurl" => $config["URL"] . $config["CTRL_0"],
                ),
                "ListAcceptRequest" => array(
                    "fields" => array(
                        "fieldacc1",
                        "fieldacc2",
                    ),
                    "dataType" => "JSON",
                    "type" => "POST",
                    "processData" => false,
                    "contentType" => false,
                    "url" => $config["URL"] . $config["CTRL_20"] . "UserRequestAccepted",
                    "Redurl" => $config["URL"] . $config["CTRL_0"],
                ),
                "ListRejectRequest" => array(
                    "fields" => array(
                        "fieldrej1",
                        "fieldrej2",
                    ),
                    "dataType" => "JSON",
                    "type" => "POST",
                    "processData" => false,
                    "contentType" => false,
                    "url" => $config["URL"] . $config["CTRL_20"] . "UserRequestRejected",
                    "Redurl" => $config["URL"] . $config["CTRL_0"],
                ),
                "ProcessUser" => array(
                    "dataType" => "JSON",
                    "type" => "POST",
                    "processData" => false,
                    "contentType" => false,
                    "url" => $config["URL"] . $config["CTRL_20"] . "ProcessUser",
                    "Redurl" => $config["URL"] . $config["CTRL_0"],
                ),
                "but1" => "but1",
                "but2" => "but2",
                "but3" => "but3",
            ),
            "ApiTransaction" => array(
                "Financial" => array(
                    "ListSuccessTran" => array(
                        "fields" => array(
                            "field1",
                        ),
                        "dataType" => "JSON",
                        "type" => "POST",
                        "url" => $config["URL"] . $config["CTRL_20"] . "UserFinancialTransactions",
                        "Redurl" => $config["URL"] . $config["CTRL_0"],
                    ),
                    "ListUnsuccessTran" => array(
                        "fields" => array(
                            "field1",
                        ),
                        "dataType" => "JSON",
                        "type" => "POST",
                        "url" => $config["URL"] . $config["CTRL_20"] . "UserFinancialTransactions",
                        "Redurl" => $config["URL"] . $config["CTRL_0"],
                    ),
                ),
                "Service" => array(
                    "ListSuccessTran" => array(
                        "fields" => array(
                            "field1",
                        ),
                        "dataType" => "JSON",
                        "type" => "POST",
                        "url" => $config["URL"] . $config["CTRL_20"] . "UserServiceTransactions",
                        "Redurl" => $config["URL"] . $config["CTRL_0"],
                    ),
                    "ListUnsuccessTran" => array(
                        "fields" => array(
                            "field1",
                        ),
                        "dataType" => "JSON",
                        "type" => "POST",
                        "url" => $config["URL"] . $config["CTRL_20"] . "UserServiceTransactions",
                        "Redurl" => $config["URL"] . $config["CTRL_0"],
                    ),
                ),
            ),
            "ApiCommission" => array(
                "FixedCommission" => array(
                    "form" => "fixedCommisionForm",
                    "fields" => array(
                        "field1",
                        "field2",
                        "field3",
                        "field4",
                        "field5",
                    ),
                    "dataType" => "JSON",
                    "type" => "POST",
                    "url" => $config["URL"] . $config["CTRL_20"] . "UserCommissions",
                    "Redurl" => $config["URL"] . $config["CTRL_0"],
                ),
                "VariableCommission" => array(
                    "form" => "variableCommisionForm",
                    "fields" => array(
                        "field1",
                        "field2",
                        "field3",
                        "field4",
                        "field5",
                        "field6",
                    ),
                    "dataType" => "JSON",
                    "type" => "POST",
                    "url" => $config["URL"] . $config["CTRL_20"] . "UserCommissions",
                    "Redurl" => $config["URL"] . $config["CTRL_0"],
                ),
                "ListCommission" => array(
                    "fields" => array(
                        "field1",
                        "field2",
                        "field3",
                        "field4",
                    ),
                    "dataType" => "JSON",
                    "type" => "POST",
                    "url" => $config["URL"] . $config["CTRL_20"] . "UserCommissions",
                    "Redurl" => $config["URL"] . $config["CTRL_0"],
                ),
            ),
            "EditUser" => array(
                "form" => "personalDetailsForm",
                "fields" => array(
                    "field1",
                    "field2",
                    "field3",
                    "field4",
                    "field5",
                    "field6",
                    "field7",
                    "field8",
                    "field9",
                    "field10",
                    "field11",
                    "field12",
                    "field13",
                    "field14",
                    "field15",
                    "field16",
                    "field17"
                ),
                "dataType" => "JSON",
                "type" => "POST",
                "checkemail" => array(
                    "dataType" => "JSON",
                    "processData" => false,
                    "contentType" => false,
                    "type" => "POST",
                    "url" => $config["URL"] . $config["CTRL_20"] . "checkEmail1",
                ),
                "gender" => array(
                    "id" => "genderme_",
                    "class" => "megender",
                    "listtype" => "option",
                    "dataType" => "JSON",
                    "type" => "POST",
                    "url" => $config["URL"] . $config["CTRL_20"] . "fetchGender1",
                ),
                "usertype" => array(
                    "id" => "usertypeme_",
                    "class" => "meusertype",
                    "listtype" => "option",
                    "dataType" => "JSON",
                    "type" => "POST",
                    "url" => $config["URL"] . $config["CTRL_20"] . "fetchUserTypes1",
                ),
                "dataType" => "JSON",
                "type" => "POST",
                "processData" => false,
                "contentType" => false,
                "url" => $config["URL"] . $config["CTRL_20"] . "EditUserPersonal",
                "defaultImage" => $config["DEFAULT_IMG"],
                "Redurl" => $config["URL"] . $config["CTRL_0"],
            ),
        );
    }

    public function getIds() {
        return $this->api_user_ids;
    }

}

?>