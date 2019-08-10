<?php
class Restaurants extends BaseController {

    private $para, $logindata, $UserId;

    function __construct($para = false) {
        parent::__construct();
        $this->gotoIndex();
        $this->para = $para;
        $this->RestaurantsMod = new MasterData_Model();
        $this->RestaurantsMod->setPostData($this->postPara);
        $this->logindata = $_SESSION["USERDATA"]["logindata"];
        $this->UserId = $this->logindata["user_pk"];
        $this->baseview->UserDets = $this->logindata;
    }
    public function Index() {
        $this->baseview->title = 'Process Company Info';
        $this->baseview->setMenuFile($this->logindata["users_type_nav_menu_file"]);
        $this->baseview->setHeader($this->logindata["users_type_header_file"]);
        $this->baseview->setHTML('MasterData', 'company.php');
        $this->baseview->setFooter('Footer.php');
        $this->baseview->RenderView(true);
    }
    public function Company() {
        $this->baseview->title = 'Process Company Info';
        $this->baseview->setMenuFile($this->logindata["users_type_nav_menu_file"]);
        $this->baseview->setHeader($this->logindata["users_type_header_file"]);
        $this->baseview->setHTML('MasterData', 'company.php');
        $this->baseview->setFooter('Footer.php');
        $this->baseview->RenderView(true);
    }
    public function Application() {
        $this->baseview->title = 'Application Details';
        $this->baseview->setMenuFile($this->logindata["users_type_nav_menu_file"]);
        $this->baseview->setHeader($this->logindata["users_type_header_file"]);
        $this->baseview->setHTML('MasterData', 'application.php');
        $this->baseview->setFooter('Footer.php');
        $this->baseview->RenderView(true);
    }
    public function User() {
        $this->baseview->title = 'Users';
        $this->baseview->setMenuFile($this->logindata["users_type_nav_menu_file"]);
        $this->baseview->setHeader($this->logindata["users_type_header_file"]);
        $this->baseview->setHTML('MasterData', 'users.php');
        $this->baseview->setFooter('Footer.php');
        $this->baseview->RenderView(true);
    }
    /* Edit view methods */
    public function BusinessInfoEdit($id = false) {
        $this->baseview->title = 'Edit Business Info';
        $this->baseview->setMenuFile($this->logindata["users_type_nav_menu_file"]);
        $this->baseview->setHeader($this->logindata["users_type_header_file"]);
        if ($id) {
            $uid = base64_decode($id);
            $this->baseview->getuserDet = $this->RestaurantsMod->getBusiness($uid);
            $this->baseview->setHTML('MasterData', 'business_info_edit.php');
        } else {
            $this->baseview->setHTML('MasterData', 'error.php');
        }
        $this->baseview->setFooter('Footer.php');
        $this->baseview->RenderView(true);
    }
    public function BusinessAddrEdit($id = false) {
        $this->baseview->title = 'Edit Business Address';
        $this->baseview->setMenuFile($this->logindata["users_type_nav_menu_file"]);
        $this->baseview->setHeader($this->logindata["users_type_header_file"]);
        if ($id) {
            $uid = base64_decode($id);
            $this->baseview->getuserDet = $this->RestaurantsMod->getBusinessAddr($uid);
            $this->baseview->setHTML('MasterData', 'business_address_edit.php');
        } else {
            $this->baseview->setHTML('MasterData', 'error.php');
        }
        $this->baseview->setFooter('Footer.php');
        $this->baseview->RenderView(true);
    }
    public function BankDetailsEdit($id = false) {
        $this->baseview->title = 'Edit Bank Details';
        $this->baseview->setMenuFile($this->logindata["users_type_nav_menu_file"]);
        $this->baseview->setHeader($this->logindata["users_type_header_file"]);
        if ($id) {
            $uid = base64_decode($id);
            $this->baseview->getuserDet = $this->RestaurantsMod->getBank($uid);
            $this->baseview->setHTML('MasterData', 'bank_details_edit.php');
        } else {
            $this->baseview->setHTML('MasterData', 'error.php');
        }
        $this->baseview->setFooter('Footer.php');
        $this->baseview->RenderView(true);
    }
    public function SetCurrencyEdit($id = false) {
        $this->baseview->title = 'Edit Currency Details';
        $this->baseview->setMenuFile($this->logindata["users_type_nav_menu_file"]);
        $this->baseview->setHeader($this->logindata["users_type_header_file"]);
        if ($id) {
            $uid = base64_decode($id);
            $this->baseview->getuserDet = $this->RestaurantsMod->getCurSet($uid);
            $this->baseview->setHTML('MasterData', 'set_currency_edit.php');
        } else {
            $this->baseview->setHTML('MasterData', 'error.php');
        }
        $this->baseview->setFooter('Footer.php');
        $this->baseview->RenderView(true);
    }
    public function ServiceEdit($id = false) {
        $this->baseview->title = 'Edit Service';
        $this->baseview->setMenuFile($this->logindata["users_type_nav_menu_file"]);
        $this->baseview->setHeader($this->logindata["users_type_header_file"]);
        if ($id) {
            $uid = base64_decode($id);
            $this->baseview->getuserDet = $this->RestaurantsMod->getService($uid);
            $this->baseview->setHTML('MasterData', 'services_edit.php');
        } else {
            $this->baseview->setHTML('MasterData', 'error.php');
        }
        $this->baseview->setFooter('Footer.php');
        $this->baseview->RenderView(true);
    }
    public function OperatorEdit($id = false) {
        $this->baseview->title = 'Edit Operator';
        $this->baseview->setMenuFile($this->logindata["users_type_nav_menu_file"]);
        $this->baseview->setHeader($this->logindata["users_type_header_file"]);
        if ($id) {
            $uid = base64_decode($id);
            $this->baseview->getuserDet = $this->RestaurantsMod->getOperator($uid);
            $this->baseview->setHTML('MasterData', 'operator_edit.php');
        } else {
            $this->baseview->setHTML('MasterData', 'error.php');
        }
        $this->baseview->setFooter('Footer.php');
        $this->baseview->RenderView(true);
    }
    public function OperatorTypeEdit($id = false) {
        $this->baseview->title = 'Edit Operator Type';
        $this->baseview->setMenuFile($this->logindata["users_type_nav_menu_file"]);
        $this->baseview->setHeader($this->logindata["users_type_header_file"]);
        if ($id) {
            $uid = base64_decode($id);
            $this->baseview->getuserDet = $this->RestaurantsMod->getOperatorType($uid);
            $this->baseview->setHTML('MasterData', 'operator_type_edit.php');
        } else {
            $this->baseview->setHTML('MasterData', 'error.php');
        }
        $this->baseview->setFooter('Footer.php');
        $this->baseview->RenderView(true);
    }
    public function CountriesEdit($id = false) {
        $this->baseview->title = 'Edit Country';
        $this->baseview->setMenuFile($this->logindata["users_type_nav_menu_file"]);
        $this->baseview->setHeader($this->logindata["users_type_header_file"]);
        if ($id) {
            $uid = base64_decode($id);
            $this->baseview->getuserDet = $this->RestaurantsMod->getCountry($uid);
            $this->baseview->setHTML('MasterData', 'portal_countries_edit.php');
        } else {
            $this->baseview->setHTML('MasterData', 'error.php');
        }
        $this->baseview->setFooter('Footer.php');
        $this->baseview->RenderView(true);
    }
    public function BusinessTypeEdit($id = false) {
        $this->baseview->title = 'Edit Business Type';
        $this->baseview->setMenuFile($this->logindata["users_type_nav_menu_file"]);
        $this->baseview->setHeader($this->logindata["users_type_header_file"]);
        if ($id) {
            $uid = base64_decode($id);
            $this->baseview->getuserDet = $this->RestaurantsMod->getBty($uid);
            $this->baseview->setHTML('MasterData', 'portal_business_type_edit.php');
        } else {
            $this->baseview->setHTML('MasterData', 'error.php');
        }
        $this->baseview->setFooter('Footer.php');
        $this->baseview->RenderView(true);
    }
    public function CurrencyEdit($id = false) {
        $this->baseview->title = 'Edit Currency';
        $this->baseview->setMenuFile($this->logindata["users_type_nav_menu_file"]);
        $this->baseview->setHeader($this->logindata["users_type_header_file"]);
        if ($id) {
            $uid = base64_decode($id);
            $this->baseview->getuserDet = $this->RestaurantsMod->getCur($uid);
            $this->baseview->setHTML('MasterData', 'portal_currencies_edit.php');
        } else {
            $this->baseview->setHTML('MasterData', 'error.php');
        }
        $this->baseview->setFooter('Footer.php');
        $this->baseview->RenderView(true);
    }
    public function MOPEdit($id = false) {
        $this->baseview->title = 'Edit MOP';
        $this->baseview->setMenuFile($this->logindata["users_type_nav_menu_file"]);
        $this->baseview->setHeader($this->logindata["users_type_header_file"]);
        if ($id) {
            $uid = base64_decode($id);
            $this->baseview->getuserDet = $this->RestaurantsMod->getMOP($uid);
            $this->baseview->setHTML('MasterData', 'portal_mode_of_payment_edit.php');
        } else {
            $this->baseview->setHTML('MasterData', 'error.php');
        }
        $this->baseview->setFooter('Footer.php');
        $this->baseview->RenderView(true);
    }
    public function MOSEdit($id = false) {
        $this->baseview->title = 'Edit MOS';
        $this->baseview->setMenuFile($this->logindata["users_type_nav_menu_file"]);
        $this->baseview->setHeader($this->logindata["users_type_header_file"]);
        if ($id) {
            $uid = base64_decode($id);
            $this->baseview->getuserDet = $this->RestaurantsMod->getMOS($uid);
            $this->baseview->setHTML('MasterData', 'portal_mode_of_service_edit.php');
        } else {
            $this->baseview->setHTML('MasterData', 'error.php');
        }
        $this->baseview->setFooter('Footer.php');
        $this->baseview->RenderView(true);
    }
    public function RestParamEdit($id = false) {
        $this->baseview->title = 'Edit User Type';
        $this->baseview->setMenuFile($this->logindata["users_type_nav_menu_file"]);
        $this->baseview->setHeader($this->logindata["users_type_header_file"]);
        if ($id) {
            $uid = base64_decode($id);
            $this->baseview->getuserDet = $this->RestaurantsMod->getRestParam($uid);
            $this->baseview->setHTML('MasterData', 'rest_parameters_edit.php');
        } else {
            $this->baseview->setHTML('MasterData', 'error.php');
        }
        $this->baseview->setFooter('Footer.php');
        $this->baseview->RenderView(true);
    }
    public function UserProofEdit($id = false) {
        $this->baseview->title = 'Edit Proof';
        $this->baseview->setMenuFile($this->logindata["users_type_nav_menu_file"]);
        $this->baseview->setHeader($this->logindata["users_type_header_file"]);
        if ($id) {
            $uid = base64_decode($id);
            $this->baseview->getuserDet = $this->RestaurantsMod->getUserProof($uid);
            $this->baseview->setHTML('MasterData', 'user_proof_edit.php');
        } else {
            $this->baseview->setHTML('MasterData', 'error.php');
        }
        $this->baseview->setFooter('Footer.php');
        $this->baseview->RenderView(true);
    }
    public function UserTypesEdit($id = false) {
        $this->baseview->title = 'Edit User Type';
        $this->baseview->setMenuFile($this->logindata["users_type_nav_menu_file"]);
        $this->baseview->setHeader($this->logindata["users_type_header_file"]);
        if ($id) {
            $uid = base64_decode($id);
            $this->baseview->getuserDet = $this->RestaurantsMod->getUserTypes($uid);
            $this->baseview->setHTML('MasterData', 'user_type_edit.php');
        } else {
            $this->baseview->setHTML('MasterData', 'error.php');
        }
        $this->baseview->setFooter('Footer.php');
        $this->baseview->RenderView(true);
    }
    /* Edit methods */
    public function EditBusinessDetails() {
        $this->baseview->setjsonData($this->RestaurantsMod->EditBusinessDetails());
        echo $this->baseview->renderJson();
    }
    public function EditBankDetails() {
        $this->baseview->setjsonData($this->RestaurantsMod->EditBankDetails());
        echo $this->baseview->renderJson();
    }
    public function EditSetCurrency() {
        $this->baseview->setjsonData($this->RestaurantsMod->EditSetCurrency());
        echo $this->baseview->renderJson();
    }
    public function EditService() {
        $this->baseview->setjsonData($this->RestaurantsMod->EditService());
        echo $this->baseview->renderJson();
    }
    public function EditOperator() {
        $this->baseview->setjsonData($this->RestaurantsMod->EditOperator());
        echo $this->baseview->renderJson();
    }
    public function EditOperatorType() {
        $this->baseview->setjsonData($this->RestaurantsMod->EditOperatorType());
        echo $this->baseview->renderJson();
    }
    public function EditCountryDetails() {
        $this->baseview->setjsonData($this->RestaurantsMod->EditCountryDetails());
        echo $this->baseview->renderJson();
    }
    public function EditCurrencyDetails() {
        $this->baseview->setjsonData($this->RestaurantsMod->EditCurrencyDetails());
        echo $this->baseview->renderJson();
    }
    public function EditBusinessTypeDetails() {
        $this->baseview->setjsonData($this->RestaurantsMod->EditBusinessTypeDetails());
        echo $this->baseview->renderJson();
    }
    public function EditProof() {
        $this->baseview->setjsonData($this->RestaurantsMod->EditProof());
        echo $this->baseview->renderJson();
    }
    public function EditModeOfService() {
        $this->baseview->setjsonData($this->RestaurantsMod->EditModeOfService());
        echo $this->baseview->renderJson();
    }
    public function EditModeOPayment() {
        $this->baseview->setjsonData($this->RestaurantsMod->EditModeOPayment());
        echo $this->baseview->renderJson();
    }
    public function EditRestParameters() {
        $this->baseview->setjsonData($this->RestaurantsMod->EditRestParameters());
        echo $this->baseview->renderJson();
    }
    public function EditUserTypes() {
        $this->baseview->setjsonData($this->RestaurantsMod->EditUserTypes());
        echo $this->baseview->renderJson();
    }
    /*  Add methods */
    public function AddBusinessInfo() {
        $this->baseview->setjsonData($this->RestaurantsMod->AddBusinessInfo());
        echo $this->baseview->renderJson();
    }
    public function AddBankDetails() {
        $this->baseview->setjsonData($this->RestaurantsMod->AddBankDetails());
        echo $this->baseview->renderJson();
    }
    public function AddService() {
        $this->baseview->setjsonData($this->RestaurantsMod->AddService());
        echo $this->baseview->renderJson();
    }
    public function AddOperator() {
        $this->baseview->setjsonData($this->RestaurantsMod->AddOperatorDB());
        echo $this->baseview->renderJson();
    }
    public function AddOperatorType() {
        $this->baseview->setjsonData($this->RestaurantsMod->AddOperatorTypeDB());
        echo $this->baseview->renderJson();
    }
    public function AddCountries() {
        $this->baseview->setjsonData($this->RestaurantsMod->AddCountries());
        echo $this->baseview->renderJson();
    }
    public function AddCurrencies() {
        $this->baseview->setjsonData($this->RestaurantsMod->AddCurrencies());
        echo $this->baseview->renderJson();
    }
    public function AddMOP() {
        $this->baseview->setjsonData($this->RestaurantsMod->AddMOP());
        echo $this->baseview->renderJson();
    }
    public function AddMOS() {
        $this->baseview->setjsonData($this->RestaurantsMod->AddMOS());
        echo $this->baseview->renderJson();
    }
    public function AddProtocols() {
        $this->baseview->setjsonData($this->RestaurantsMod->AddProtocols());
        echo $this->baseview->renderJson();
    }
    public function AddRestParameters() {
        $this->baseview->setjsonData($this->RestaurantsMod->AddRestParameters());
        echo $this->baseview->renderJson();
    }
    public function AddProof() {
        $this->baseview->setjsonData($this->RestaurantsMod->AddProof());
        echo $this->baseview->renderJson();
    }
    public function AddBusinessType() {
        $this->baseview->setjsonData($this->RestaurantsMod->AddBusinessType());
        echo $this->baseview->renderJson();
    }
    public function AddUserType() {
        $this->baseview->setjsonData($this->RestaurantsMod->AddUserType());
        echo $this->baseview->renderJson();
    }
    /* set currency */
    public function setCurrency() {
        $this->baseview->setjsonData($this->RestaurantsMod->setCurrency());
        echo $this->baseview->renderJson();
    }
    /* List methods */
    public function ListSetCurrency() {
        $this->baseview->setjsonData($this->RestaurantsMod->ListSetCurrency());
        echo $this->baseview->renderJson();
    }
    public function ListBusinessInfo() {
        $this->baseview->setjsonData($this->RestaurantsMod->ListBusinessInfo());
        echo $this->baseview->renderJson();
    }
    public function ListBusinessAddr() {
        $this->baseview->setjsonData($this->RestaurantsMod->ListBusinessAddr());
        echo $this->baseview->renderJson();
    }
    public function ListBankDetails() {
        $this->baseview->setjsonData($this->RestaurantsMod->ListBankDetails());
        echo $this->baseview->renderJson();
    }
    public function ListService() {
        $this->baseview->setjsonData($this->RestaurantsMod->ListService());
        echo $this->baseview->renderJson();
    }
    public function ListOperators() {
        $this->baseview->setjsonData($this->RestaurantsMod->ListOperators());
        echo $this->baseview->renderJson();
    }
    public function ListOperatorTypes() {
        $this->baseview->setjsonData($this->RestaurantsMod->ListOperatorTypes());
        echo $this->baseview->renderJson();
    }
    public function ListBusinessType() {
        $this->baseview->setjsonData($this->RestaurantsMod->ListBusinessType());
        echo $this->baseview->renderJson();
    }
    public function ListCountries() {
        $this->baseview->setjsonData($this->RestaurantsMod->ListCountries());
        echo $this->baseview->renderJson();
    }
    public function ListCurrencies() {
        $this->baseview->setjsonData($this->RestaurantsMod->ListCurrencies());
        echo $this->baseview->renderJson();
    }
    public function ListModeOfPay() {
        $this->baseview->setjsonData($this->RestaurantsMod->ListModeOfPay());
        echo $this->baseview->renderJson();
    }
    public function ListModeOfServ() {
        $this->baseview->setjsonData($this->RestaurantsMod->ListModeOfServ());
        echo $this->baseview->renderJson();
    }
    public function ListProtocols() {
        $this->baseview->setjsonData($this->RestaurantsMod->ListProtocols());
        echo $this->baseview->renderJson();
    }
    public function ListRestParam() {
        $this->baseview->setjsonData($this->RestaurantsMod->ListRestParam());
        echo $this->baseview->renderJson();
    }
    public function ListTraffic() {
        $this->baseview->setjsonData($this->RestaurantsMod->ListTraffic());
        echo $this->baseview->renderJson();
    }
    public function ListUserProof() {
        $this->baseview->setjsonData($this->RestaurantsMod->ListUserProof());
        echo $this->baseview->renderJson();
    }
    public function ListUserTypes() {
        $this->baseview->setjsonData($this->RestaurantsMod->ListUserTypes());
        echo $this->baseview->renderJson();
    }
    /* Delete methods */
    public function DeleteBankDetails($id = false) {
        $this->baseview->setjsonData($this->RestaurantsMod->DeleteBankDetails($id));
        echo $this->baseview->renderJson();
    }
    public function DeleteBusinessInfo($id = false) {
        $this->baseview->setjsonData($this->RestaurantsMod->DeleteBusinessInfo($id));
        echo $this->baseview->renderJson();
    }
    public function DeleteSetCurrency($id = false) {
        $this->baseview->setjsonData($this->RestaurantsMod->DeleteSetCurrency($id));
        echo $this->baseview->renderJson();
    }
    public function DeleteService($id = false) {
        $this->baseview->setjsonData($this->RestaurantsMod->DeleteService($id));
        echo $this->baseview->renderJson();
    }
    public function DeleteOperator($id = false) {
        $this->baseview->setjsonData($this->RestaurantsMod->DeleteOperator($id));
        echo $this->baseview->renderJson();
    }
    public function DeleteOperatorType($id = false) {
        $this->baseview->setjsonData($this->RestaurantsMod->DeleteOperatorType($id));
        echo $this->baseview->renderJson();
    }
    public function DeleteBusinessType($id = false) {
        $this->baseview->setjsonData($this->RestaurantsMod->DeleteBusinessType($id));
        echo $this->baseview->renderJson();
    }
    public function DeleteCountries($id = false) {
        $this->baseview->setjsonData($this->RestaurantsMod->DeleteCountries($id));
        echo $this->baseview->renderJson();
    }
    public function DeleteCurrency($id = false) {
        $this->baseview->setjsonData($this->RestaurantsMod->DeleteCurrency($id));
        echo $this->baseview->renderJson();
    }
    public function DeleteMOP($id = false) {
        $this->baseview->setjsonData($this->RestaurantsMod->DeleteMOP($id));
        echo $this->baseview->renderJson();
    }
    public function DeleteMOS($id = false) {
        $this->baseview->setjsonData($this->RestaurantsMod->DeleteMOS($id));
        echo $this->baseview->renderJson();
    }
    public function DeleteRestParam($id = false) {
        $this->baseview->setjsonData($this->RestaurantsMod->DeleteRestParam($id));
        echo $this->baseview->renderJson();
    }
    public function DeleteUserProof($id = false) {
        $this->baseview->setjsonData($this->RestaurantsMod->DeleteUserProof($id));
        echo $this->baseview->renderJson();
    }
}
?>
