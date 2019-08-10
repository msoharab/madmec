<?php

class Sales extends BaseController {

    private $para, $logindata, $SalesMod, $UserId;

    function __construct($para = false) {
        parent::__construct();
        $this->para = $para;
        $this->SalesMod = new Sales_Model();
        $this->SalesMod->setPostData($this->postPara);
        $this->SalesMod->setPostFile($this->postFile);
        $this->logindata = $_SESSION["USERDATA"]["logindata"];
        $this->UserId = $this->logindata["users_pk"];
    }

    public function Index() {
        $this->baseview->UserDets = $this->logindata;
        $this->baseview->title = 'Process Gateway Info';
        $this->baseview->setMenuFile($this->logindata["users_type_nav_menu_file"]);
        $this->baseview->setHeader($this->logindata["users_type_header_file"]);
        $this->baseview->setHTML('Gateway', 'user_profile.php');
        $this->baseview->setFooter('Footer.php');
        $this->baseview->RenderView(true);
    }

    public function GatewayBusiness() {
        $this->baseview->UserDets = $this->logindata;
        $this->baseview->title = 'Process Gateway Info';
        $this->baseview->setMenuFile($this->logindata["users_type_nav_menu_file"]);
        $this->baseview->setHeader($this->logindata["users_type_header_file"]);
        $this->baseview->setHTML('Gateway', 'user_profile.php');
        $this->baseview->setFooter('Footer.php');
        $this->baseview->RenderView(true);
    }

    public function GatewayFinancialTransactions() {
        $this->baseview->UserDets = $this->logindata;
        $this->baseview->title = 'Financial Transactions';
        $this->baseview->setMenuFile($this->logindata["users_type_nav_menu_file"]);
        $this->baseview->setHeader($this->logindata["users_type_header_file"]);
        $this->baseview->setHTML('Gateway', 'recharge_finance.php');
        $this->baseview->setFooter('Footer.php');
        $this->baseview->RenderView(true);
    }

    public function GatewayServiceTransactions() {
        $this->baseview->UserDets = $this->logindata;
        $this->baseview->title = 'Service Transactions';
        $this->baseview->setMenuFile($this->logindata["users_type_nav_menu_file"]);
        $this->baseview->setHeader($this->logindata["users_type_header_file"]);
        $this->baseview->setHTML('Gateway', 'recharge_service.php');
        $this->baseview->setFooter('Footer.php');
        $this->baseview->RenderView(true);
    }

    public function GatewayTechnical() {
        $this->baseview->UserDets = $this->logindata;
        $this->baseview->title = 'Gateway Technical';
        $this->baseview->setMenuFile($this->logindata["users_type_nav_menu_file"]);
        $this->baseview->setHeader($this->logindata["users_type_header_file"]);
        $this->baseview->setHTML('Gateway', 'user_type_1.php');
        $this->baseview->setFooter('Footer.php');
        $this->baseview->RenderView(true);
    }

    public function Mapping() {
        $this->baseview->UserDets = $this->logindata;
        $this->baseview->title = 'Process Mapping';
        $this->baseview->setMenuFile($this->logindata["users_type_nav_menu_file"]);
        $this->baseview->setHeader($this->logindata["users_type_header_file"]);
        $this->baseview->setHTML('Gateway', 'mapping.php');
        $this->baseview->setFooter('Footer.php');
        $this->baseview->RenderView(true);
    }

    /* Edit view methods */

    public function GatewayEdit($id = false) {
        $this->baseview->UserDets = $this->logindata;
        $this->baseview->title = 'Edit Gateway Details';
        $this->baseview->setMenuFile($this->logindata["users_type_nav_menu_file"]);
        $this->baseview->setHeader($this->logindata["users_type_header_file"]);
        if ($id) {
            $uid = base64_decode($id);
            $this->baseview->getuserDet = $this->SalesMod->getGateway($uid);
            $this->baseview->setHTML('Gateway', 'user_personal_edit.php');
        } else {
            $this->baseview->setHTML('Gateway', 'error.php');
        }
        $this->baseview->setFooter('Footer.php');
        $this->baseview->RenderView(true);
    }

    public function GatewayOperatorEdit($id = false) {
        $this->baseview->UserDets = $this->logindata;
        $this->baseview->title = 'Edit Gateway Operators';
        $this->baseview->setMenuFile($this->logindata["users_type_nav_menu_file"]);
        $this->baseview->setHeader($this->logindata["users_type_header_file"]);
        if ($id) {
            $uid = base64_decode($id);
            $this->baseview->getuserDet = $this->SalesMod->getGatewayOperator($uid);
            $this->baseview->setHTML('Gateway', 'operator_edit.php');
        } else {
            $this->baseview->setHTML('Gateway', 'error.php');
        }
        $this->baseview->setFooter('Footer.php');
        $this->baseview->RenderView(true);
    }

    public function GatewayOperatorTypeEdit($id = false) {
        $this->baseview->UserDets = $this->logindata;
        $this->baseview->title = 'Edit Gateway Operator Types';
        $this->baseview->setMenuFile($this->logindata["users_type_nav_menu_file"]);
        $this->baseview->setHeader($this->logindata["users_type_header_file"]);
        if ($id) {
            $uid = base64_decode($id);
            $this->baseview->getuserDet = $this->SalesMod->getGatewayOperatorType($uid);
            $this->baseview->setHTML('Gateway', 'operator_type_edit.php');
        } else {
            $this->baseview->setHTML('Gateway', 'error.php');
        }
        $this->baseview->setFooter('Footer.php');
        $this->baseview->RenderView(true);
    }

    /* methods */

    public function AddGateway() {
        $this->baseview->setjsonData($this->SalesMod->AddGateway());
        echo $this->baseview->renderJson();
    }

    public function AssignGateway() {
        $this->baseview->setjsonData($this->SalesMod->AssignGateway());
        echo $this->baseview->renderJson();
    }

    public function AddSubscription() {
        $this->baseview->setjsonData($this->SalesMod->AddSubscription());
        echo $this->baseview->renderJson();
    }

    public function AddRest() {
        $this->baseview->setjsonData($this->SalesMod->AddRest());
        echo $this->baseview->renderJson();
    }

    public function ListGateway() {
        $this->baseview->setjsonData($this->SalesMod->ListGateway());
        echo $this->baseview->renderJson();
    }

    public function TechnicalRest() {
        $this->baseview->setjsonData($this->SalesMod->TechnicalRest());
        echo $this->baseview->renderJson();
    }

    public function ListFinancialSuccess() {
        $this->baseview->setjsonData($this->SalesMod->ListFinancialSuccess());
        echo $this->baseview->renderJson();
    }

    public function ListFinancialUnsuccess() {
        $this->baseview->setjsonData($this->SalesMod->ListFinancialUnsuccess());
        echo $this->baseview->renderJson();
    }

    public function ListServiceSuccess() {
        $this->baseview->setjsonData($this->SalesMod->ListServiceSuccess());
        echo $this->baseview->renderJson();
    }

    public function ListServiceUnsuccess() {
        $this->baseview->setjsonData($this->SalesMod->ListServiceUnsuccess());
        echo $this->baseview->renderJson();
    }

    public function SetFixedCommission() {
        $this->baseview->setjsonData($this->SalesMod->SetFixedCommission());
        echo $this->baseview->renderJson();
    }

    public function SetVariableCommission() {
        $this->baseview->setjsonData($this->SalesMod->SetVariableCommission());
        echo $this->baseview->renderJson();
    }

    public function SetCommissionDetails() {
        $this->baseview->setjsonData($this->SalesMod->SetCommissionDetails());
        echo $this->baseview->renderJson();
    }

    /* Operators */

    public function Manage() {
        $this->baseview->UserDets = $this->logindata;
        $this->baseview->title = 'Process Operator Data';
        $this->baseview->setMenuFile($this->logindata["users_type_nav_menu_file"]);
        $this->baseview->setHeader($this->logindata["users_type_header_file"]);
        $this->baseview->setHTML('Gateway', 'operator_index.php');
        $this->baseview->setFooter('Footer.php');
        $this->baseview->RenderView(true);
    }

    public function ListOperator() {
        $this->baseview->UserDets = $this->logindata;
        $this->baseview->title = 'Process Operator Data';
        $this->baseview->setMenuFile($this->logindata["users_type_nav_menu_file"]);
        $this->baseview->setHeader($this->logindata["users_type_header_file"]);
        $this->baseview->setHTML('Gateway', 'list.php');
        $this->baseview->setFooter('Footer.php');
        $this->baseview->RenderView(true);
    }

    public function AddOperator() {
        $this->baseview->setjsonData($this->SalesMod->AddOperator());
        echo $this->baseview->renderJson();
    }

    public function AddOperatorType() {
        $this->baseview->setjsonData($this->SalesMod->AddOperatorTypeDB());
        echo $this->baseview->renderJson();
    }

    public function ListOperators() {
        $this->baseview->setjsonData($this->SalesMod->ListOperators());
        echo $this->baseview->renderJson();
    }

    public function ListOperatorTypes() {
        $this->baseview->setjsonData($this->SalesMod->ListOperatorTypes());
        echo $this->baseview->renderJson();
    }

    public function DisplayOperatorList() {
        $this->baseview->setjsonData($this->SalesMod->DisplayOperatorList());
        echo $this->baseview->renderJson();
    }

    public function EditGateway() {
        $this->baseview->setjsonData($this->SalesMod->EditGateway());
        echo $this->baseview->renderJson();
    }

    public function EditOperator() {
        $this->baseview->setjsonData($this->SalesMod->EditOperator());
        echo $this->baseview->renderJson();
    }

    public function EditOperatorType() {
        $this->baseview->setjsonData($this->SalesMod->EditOperatorType());
        echo $this->baseview->renderJson();
    }

    public function DeleteGateway($id = false) {
        $this->baseview->setjsonData($this->SalesMod->DeleteGateway($id));
        echo $this->baseview->renderJson();
    }

}

?>