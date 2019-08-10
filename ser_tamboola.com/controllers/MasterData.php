<?php
class MasterData extends BaseController {
    private $para, $logindata, $UserId, $GymId, $MasterDataMod;
    function __construct($para = false) {
        parent::__construct();
        $this->gotoIndex();
        $this->para = $para;
        $this->MasterDataMod = new MasterData_Model();
        $this->MasterDataMod->setPostData($this->postPara);
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
            $this->baseview->getuserDet = $this->MasterDataMod->getBusiness($uid);
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
            $this->baseview->getuserDet = $this->MasterDataMod->getBusinessAddr($uid);
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
            $this->baseview->getuserDet = $this->MasterDataMod->getBank($uid);
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
            $this->baseview->getuserDet = $this->MasterDataMod->getCurSet($uid);
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
            $this->baseview->getuserDet = $this->MasterDataMod->getService($uid);
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
            $this->baseview->getuserDet = $this->MasterDataMod->getOperator($uid);
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
            $this->baseview->getuserDet = $this->MasterDataMod->getOperatorType($uid);
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
            $this->baseview->getuserDet = $this->MasterDataMod->getCountry($uid);
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
            $this->baseview->getuserDet = $this->MasterDataMod->getBty($uid);
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
            $this->baseview->getuserDet = $this->MasterDataMod->getCur($uid);
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
            $this->baseview->getuserDet = $this->MasterDataMod->getMOP($uid);
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
            $this->baseview->getuserDet = $this->MasterDataMod->getMOS($uid);
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
            $this->baseview->getuserDet = $this->MasterDataMod->getRestParam($uid);
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
            $this->baseview->getuserDet = $this->MasterDataMod->getUserProof($uid);
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
            $this->baseview->getuserDet = $this->MasterDataMod->getUserTypes($uid);
            $this->baseview->setHTML('MasterData', 'user_type_edit.php');
        } else {
            $this->baseview->setHTML('MasterData', 'error.php');
        }
        $this->baseview->setFooter('Footer.php');
        $this->baseview->RenderView(true);
    }
    /* Edit methods */
    public function EditBusinessDetails() {
        $this->baseview->setjsonData($this->MasterDataMod->EditBusinessDetails());
        echo $this->baseview->renderJson();
    }
    public function EditBankDetails() {
        $this->baseview->setjsonData($this->MasterDataMod->EditBankDetails());
        echo $this->baseview->renderJson();
    }
    public function EditSetCurrency() {
        $this->baseview->setjsonData($this->MasterDataMod->EditSetCurrency());
        echo $this->baseview->renderJson();
    }
    public function EditService() {
        $this->baseview->setjsonData($this->MasterDataMod->EditService());
        echo $this->baseview->renderJson();
    }
    public function EditOperator() {
        $this->baseview->setjsonData($this->MasterDataMod->EditOperator());
        echo $this->baseview->renderJson();
    }
    public function EditOperatorType() {
        $this->baseview->setjsonData($this->MasterDataMod->EditOperatorType());
        echo $this->baseview->renderJson();
    }
    public function EditCountryDetails() {
        $this->baseview->setjsonData($this->MasterDataMod->EditCountryDetails());
        echo $this->baseview->renderJson();
    }
    public function EditCurrencyDetails() {
        $this->baseview->setjsonData($this->MasterDataMod->EditCurrencyDetails());
        echo $this->baseview->renderJson();
    }
    public function EditBusinessTypeDetails() {
        $this->baseview->setjsonData($this->MasterDataMod->EditBusinessTypeDetails());
        echo $this->baseview->renderJson();
    }
    public function EditProof() {
        $this->baseview->setjsonData($this->MasterDataMod->EditProof());
        echo $this->baseview->renderJson();
    }
    public function EditModeOfService() {
        $this->baseview->setjsonData($this->MasterDataMod->EditModeOfService());
        echo $this->baseview->renderJson();
    }
    public function EditModeOPayment() {
        $this->baseview->setjsonData($this->MasterDataMod->EditModeOPayment());
        echo $this->baseview->renderJson();
    }
    public function EditRestParameters() {
        $this->baseview->setjsonData($this->MasterDataMod->EditRestParameters());
        echo $this->baseview->renderJson();
    }
    public function EditUserTypes() {
        $this->baseview->setjsonData($this->MasterDataMod->EditUserTypes());
        echo $this->baseview->renderJson();
    }
    /*  Add methods */
    public function AddBusinessInfo() {
        $this->baseview->setjsonData($this->MasterDataMod->AddBusinessInfo());
        echo $this->baseview->renderJson();
    }
    public function AddBankDetails() {
        $this->baseview->setjsonData($this->MasterDataMod->AddBankDetails());
        echo $this->baseview->renderJson();
    }
    public function AddService() {
        $this->baseview->setjsonData($this->MasterDataMod->AddService());
        echo $this->baseview->renderJson();
    }
    public function AddOperator() {
        $this->baseview->setjsonData($this->MasterDataMod->AddOperatorDB());
        echo $this->baseview->renderJson();
    }
    public function AddOperatorType() {
        $this->baseview->setjsonData($this->MasterDataMod->AddOperatorTypeDB());
        echo $this->baseview->renderJson();
    }
    public function AddCountries() {
        $this->baseview->setjsonData($this->MasterDataMod->AddCountries());
        echo $this->baseview->renderJson();
    }
    public function AddCurrencies() {
        $this->baseview->setjsonData($this->MasterDataMod->AddCurrencies());
        echo $this->baseview->renderJson();
    }
    public function AddMOP() {
        $this->baseview->setjsonData($this->MasterDataMod->AddMOP());
        echo $this->baseview->renderJson();
    }
    public function AddMOS() {
        $this->baseview->setjsonData($this->MasterDataMod->AddMOS());
        echo $this->baseview->renderJson();
    }
    public function AddProtocols() {
        $this->baseview->setjsonData($this->MasterDataMod->AddProtocols());
        echo $this->baseview->renderJson();
    }
    public function AddRestParameters() {
        $this->baseview->setjsonData($this->MasterDataMod->AddRestParameters());
        echo $this->baseview->renderJson();
    }
    public function AddProof() {
        $this->baseview->setjsonData($this->MasterDataMod->AddProof());
        echo $this->baseview->renderJson();
    }
    public function AddBusinessType() {
        $this->baseview->setjsonData($this->MasterDataMod->AddBusinessType());
        echo $this->baseview->renderJson();
    }
    public function AddUserType() {
        $this->baseview->setjsonData($this->MasterDataMod->AddUserType());
        echo $this->baseview->renderJson();
    }
    /* set currency */
    public function setCurrency() {
        $this->baseview->setjsonData($this->MasterDataMod->setCurrency());
        echo $this->baseview->renderJson();
    }
    /* List methods */
    public function ListSetCurrency() {
        $this->baseview->setjsonData($this->MasterDataMod->ListSetCurrency());
        echo $this->baseview->renderJson();
    }
    public function ListBusinessInfo() {
        $this->baseview->setjsonData($this->MasterDataMod->ListBusinessInfo());
        echo $this->baseview->renderJson();
    }
    public function ListBusinessAddr() {
        $this->baseview->setjsonData($this->MasterDataMod->ListBusinessAddr());
        echo $this->baseview->renderJson();
    }
    public function ListBankDetails() {
        $this->baseview->setjsonData($this->MasterDataMod->ListBankDetails());
        echo $this->baseview->renderJson();
    }
    public function ListService() {
        $this->baseview->setjsonData($this->MasterDataMod->ListService());
        echo $this->baseview->renderJson();
    }
    public function ListOperators() {
        $this->baseview->setjsonData($this->MasterDataMod->ListOperators());
        echo $this->baseview->renderJson();
    }
    public function ListOperatorTypes() {
        $this->baseview->setjsonData($this->MasterDataMod->ListOperatorTypes());
        echo $this->baseview->renderJson();
    }
    public function ListBusinessType() {
        $this->baseview->setjsonData($this->MasterDataMod->ListBusinessType());
        echo $this->baseview->renderJson();
    }
    public function ListCountries() {
        $this->baseview->setjsonData($this->MasterDataMod->ListCountries());
        echo $this->baseview->renderJson();
    }
    public function ListCurrencies() {
        $this->baseview->setjsonData($this->MasterDataMod->ListCurrencies());
        echo $this->baseview->renderJson();
    }
    public function ListModeOfPay() {
        $this->baseview->setjsonData($this->MasterDataMod->ListModeOfPay());
        echo $this->baseview->renderJson();
    }
    public function ListModeOfServ() {
        $this->baseview->setjsonData($this->MasterDataMod->ListModeOfServ());
        echo $this->baseview->renderJson();
    }
    public function ListProtocols() {
        $this->baseview->setjsonData($this->MasterDataMod->ListProtocols());
        echo $this->baseview->renderJson();
    }
    public function ListRestParam() {
        $this->baseview->setjsonData($this->MasterDataMod->ListRestParam());
        echo $this->baseview->renderJson();
    }
    public function ListTraffic() {
        $this->baseview->setjsonData($this->MasterDataMod->ListTraffic());
        echo $this->baseview->renderJson();
    }
    public function ListUserProof() {
        $this->baseview->setjsonData($this->MasterDataMod->ListUserProof());
        echo $this->baseview->renderJson();
    }
    public function ListUserTypes() {
        $this->baseview->setjsonData($this->MasterDataMod->ListUserTypes());
        echo $this->baseview->renderJson();
    }
    /* Delete methods */
    public function DeleteBankDetails($id = false) {
        $this->baseview->setjsonData($this->MasterDataMod->DeleteBankDetails($id));
        echo $this->baseview->renderJson();
    }
    public function DeleteBusinessInfo($id = false) {
        $this->baseview->setjsonData($this->MasterDataMod->DeleteBusinessInfo($id));
        echo $this->baseview->renderJson();
    }
    public function DeleteSetCurrency($id = false) {
        $this->baseview->setjsonData($this->MasterDataMod->DeleteSetCurrency($id));
        echo $this->baseview->renderJson();
    }
    public function DeleteService($id = false) {
        $this->baseview->setjsonData($this->MasterDataMod->DeleteService($id));
        echo $this->baseview->renderJson();
    }
    public function DeleteOperator($id = false) {
        $this->baseview->setjsonData($this->MasterDataMod->DeleteOperator($id));
        echo $this->baseview->renderJson();
    }
    public function DeleteOperatorType($id = false) {
        $this->baseview->setjsonData($this->MasterDataMod->DeleteOperatorType($id));
        echo $this->baseview->renderJson();
    }
    public function DeleteBusinessType($id = false) {
        $this->baseview->setjsonData($this->MasterDataMod->DeleteBusinessType($id));
        echo $this->baseview->renderJson();
    }
    public function DeleteCountries($id = false) {
        $this->baseview->setjsonData($this->MasterDataMod->DeleteCountries($id));
        echo $this->baseview->renderJson();
    }
    public function DeleteCurrency($id = false) {
        $this->baseview->setjsonData($this->MasterDataMod->DeleteCurrency($id));
        echo $this->baseview->renderJson();
    }
    public function DeleteMOP($id = false) {
        $this->baseview->setjsonData($this->MasterDataMod->DeleteMOP($id));
        echo $this->baseview->renderJson();
    }
    public function DeleteMOS($id = false) {
        $this->baseview->setjsonData($this->MasterDataMod->DeleteMOS($id));
        echo $this->baseview->renderJson();
    }
    public function DeleteRestParam($id = false) {
        $this->baseview->setjsonData($this->MasterDataMod->DeleteRestParam($id));
        echo $this->baseview->renderJson();
    }
    public function DeleteUserProof($id = false) {
        $this->baseview->setjsonData($this->MasterDataMod->DeleteUserProof($id));
        echo $this->baseview->renderJson();
    }
}
?>
