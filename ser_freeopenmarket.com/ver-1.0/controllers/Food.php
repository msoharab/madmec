<?php

class Food extends BaseController {

    private $para, $logindata, $UserId, $FoodMod;

    function __construct($para = false) {
        parent::__construct();
        $this->para = $para;
        $this->FoodMod = new Food_Model();
        $this->FoodMod->setPostData($this->postPara);
        $this->FoodMod->setPostFile($this->postFile);
        $this->logindata = $_SESSION["USERDATA"]["logindata"];
        $this->UserId = $this->logindata["users_pk"];
    }

    public function Index() {
        $this->baseview->UserDets = $this->logindata;
        $this->baseview->title = 'Process Food Users Info';
        $this->baseview->setMenuFile($this->logindata["users_type_nav_menu_file"]);
        $this->baseview->setHeader($this->logindata["users_type_header_file"]);
        $this->baseview->setBody('Food');
        $this->baseview->setFooter('Footer.php');
        $this->baseview->RenderView(true);
    }

    public function FoodUserPersonal() {
        $this->baseview->UserDets = $this->logindata;
        $this->baseview->title = 'Process Personal Info';
        $this->baseview->setMenuFile($this->logindata["users_type_nav_menu_file"]);
        $this->baseview->setHeader($this->logindata["users_type_header_file"]);
        $this->baseview->setHTML('Food', 'Food.php');
        $this->baseview->setFooter('Footer.php');
        $this->baseview->RenderView(true);
    }

    public function FoodUserBusiness() {
        $this->baseview->UserDets = $this->logindata;
        $this->baseview->title = 'Process Business Info';
        $this->baseview->setMenuFile($this->logindata["users_type_nav_menu_file"]);
        $this->baseview->setHeader($this->logindata["users_type_header_file"]);
        $this->baseview->setHTML('Food', 'Food_business.php');
        $this->baseview->setFooter('Footer.php');
        $this->baseview->RenderView(true);
    }

    public function FoodUserRequest() {
        $this->baseview->UserDets = $this->logindata;
        $this->baseview->title = 'New Registrations';
        $this->baseview->setMenuFile($this->logindata["users_type_nav_menu_file"]);
        $this->baseview->setHeader($this->logindata["users_type_header_file"]);
        $this->baseview->setHTML('Food', 'Food_request.php');
        $this->baseview->setFooter('Footer.php');
        $this->baseview->RenderView(true);
    }

    public function UserEdit($id = false) {
        $this->baseview->UserDets = $this->logindata;
        $this->baseview->title = 'Edit User';
        $this->baseview->setMenuFile($this->logindata["users_type_nav_menu_file"]);
        $this->baseview->setHeader($this->logindata["users_type_header_file"]);
        if ($id) {
            $uid = base64_decode($id);
            $this->baseview->getuserDet = $this->FoodMod->getUser($uid);
            //var_dump($this->baseview->getuserDet["data"]);
            //exit(0);
            $this->baseview->setHTML('Food', 'Food_personal_edit.php');
        } else {
            $this->baseview->setHTML('Food', 'Food_personal_edit_error.php');
        }
        $this->baseview->setFooter('Footer.php');
        $this->baseview->RenderView(true);
    }

    public function UserBusinessEdit($id = false) {
        $this->baseview->UserDets = $this->logindata;
        $this->baseview->title = 'Edit User';
        $this->baseview->setMenuFile($this->logindata["users_type_nav_menu_file"]);
        $this->baseview->setHeader($this->logindata["users_type_header_file"]);
        if ($id) {
            $uid = base64_decode($id);
            $this->baseview->getuserDet = $this->FoodMod->getUserBusiness($uid);
            //var_dump($this->baseview->getuserDet["data"]);
            //exit(0);
            $this->baseview->setHTML('Food', 'Food_business_edit.php');
        } else {
            $this->baseview->setHTML('Food', 'Food_personal_edit_error.php');
        }
        $this->baseview->setFooter('Footer.php');
        $this->baseview->RenderView(true);
    }

    public function UserCommissionEdit($id = false) {
        $this->baseview->UserDets = $this->logindata;
        $this->baseview->title = 'Edit User';
        $this->baseview->setMenuFile($this->logindata["users_type_nav_menu_file"]);
        $this->baseview->setHeader($this->logindata["users_type_header_file"]);
        if ($id) {
            $uid = base64_decode($id);
            $this->baseview->getuserDet = $this->FoodMod->getUserCommission($uid);
            //var_dump($this->baseview->getuserDet["data"]);
            //exit(0);
            $this->baseview->setHTML('Food', 'Food_commission_edit.php');
        } else {
            $this->baseview->setHTML('Food', 'Food_personal_edit_error.php');
        }
        $this->baseview->setFooter('Footer.php');
        $this->baseview->RenderView(true);
    }

    public function UserRequestNew() {
        $this->baseview->setjsonData($this->FoodMod->UserRequestNew());
        echo $this->baseview->renderJson();
    }

    public function UserRequestAccepted() {
        $this->baseview->setjsonData($this->FoodMod->UserRequestAccepted());
        echo $this->baseview->renderJson();
    }

    public function UserRequestRejected() {
        $this->baseview->setjsonData($this->FoodMod->UserRequestRejected());
        echo $this->baseview->renderJson();
    }

    public function ProcessUser() {
        $this->baseview->setjsonData($this->FoodMod->ProcessUser());
        echo $this->baseview->renderJson();
    }

    public function FoodFinancialTransactions() {
        $this->baseview->UserDets = $this->logindata;
        $this->baseview->title = 'Financial Transactions';
        $this->baseview->setMenuFile($this->logindata["users_type_nav_menu_file"]);
        $this->baseview->setHeader($this->logindata["users_type_header_file"]);
        $this->baseview->setHTML('Food', 'Food_finance.php');
        $this->baseview->setFooter('Footer.php');
        $this->baseview->RenderView(true);
    }

    public function FoodServiceTransactions() {
        $this->baseview->UserDets = $this->logindata;
        $this->baseview->title = 'Service Transactions';
        $this->baseview->setMenuFile($this->logindata["users_type_nav_menu_file"]);
        $this->baseview->setHeader($this->logindata["users_type_header_file"]);
        $this->baseview->setHTML('Food', 'Food_service.php');
        $this->baseview->setFooter('Footer.php');
        $this->baseview->RenderView(true);
    }

    public function FoodCommissions() {
        $this->baseview->UserDets = $this->logindata;
        $this->baseview->title = 'User Commissions';
        $this->baseview->setMenuFile($this->logindata["users_type_nav_menu_file"]);
        $this->baseview->setHeader($this->logindata["users_type_header_file"]);
        $this->baseview->setHTML('Food', 'Food_commission.php');
        $this->baseview->setFooter('Footer.php');
        $this->baseview->RenderView(true);
    }

    public function AddUser() {
        $this->baseview->setjsonData($this->FoodMod->AddUser());
        echo $this->baseview->renderJson();
    }

    public function ListUserPersonal() {
        $this->baseview->setjsonData($this->FoodMod->ListUserPersonal());
        echo $this->baseview->renderJson();
    }

    public function ListUserBusiness() {
        $this->baseview->setjsonData($this->FoodMod->ListUserBusiness());
        echo $this->baseview->renderJson();
    }

    public function DisplayUserList() {
        $this->baseview->setjsonData($this->FoodMod->DisplayUserList());
        echo $this->baseview->renderJson();
    }

    public function AddBusinessDetails() {
        $this->baseview->setjsonData($this->FoodMod->AddBusinessDetails());
        echo $this->baseview->renderJson();
    }

    public function searchUser() {
        $this->baseview->setjsonData($this->FoodMod->searchUserDB());
        echo $this->baseview->renderJson();
    }

    public function ListBusinessDetails() {
        $this->baseview->setjsonData($this->FoodMod->ListBusinessDetails());
        echo $this->baseview->renderJson();
    }

    public function ListNewRequest() {
        $this->baseview->setjsonData($this->FoodMod->ListNewRequest());
        echo $this->baseview->renderJson();
    }

    public function ListAcceptedRequest() {
        $this->baseview->setjsonData($this->FoodMod->ListAcceptedRequest());
        echo $this->baseview->renderJson();
    }

    public function ListRejectedRequest() {
        $this->baseview->setjsonData($this->FoodMod->ListRejectedRequest());
        echo $this->baseview->renderJson();
    }

    public function ListFinancialSuccess() {
        $this->baseview->setjsonData($this->FoodMod->ListFinancialSuccess());
        echo $this->baseview->renderJson();
    }

    public function ListFinancialUnsuccess() {
        $this->baseview->setjsonData($this->FoodMod->ListFinancialUnsuccess());
        echo $this->baseview->renderJson();
    }

    public function ListServiceSuccess() {
        $this->baseview->setjsonData($this->FoodMod->ListServiceSuccess());
        echo $this->baseview->renderJson();
    }

    public function ListServiceUnsuccess() {
        $this->baseview->setjsonData($this->FoodMod->ListServiceUnsuccess());
        echo $this->baseview->renderJson();
    }

    public function SetFixedCommission() {
        $this->baseview->setjsonData($this->FoodMod->SetFixedCommission());
        echo $this->baseview->renderJson();
    }

    public function SetVariableCommission() {
        $this->baseview->setjsonData($this->FoodMod->SetVariableCommission());
        echo $this->baseview->renderJson();
    }

    public function SetCommissionDetails() {
        $this->baseview->setjsonData($this->FoodMod->SetCommissionDetails());
        echo $this->baseview->renderJson();
    }

    public function EditUserPersonal() {
        $this->baseview->setjsonData($this->FoodMod->EditUserPersonal());
        echo $this->baseview->renderJson();
    }

}

?>