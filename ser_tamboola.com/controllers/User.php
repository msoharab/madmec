<?php
class User extends BaseController {
    private $para, $UserMod, $logindata, $UserId, $GymId, $GymData;
    function __construct($para = false) {
        parent::__construct();
        $this->gotoIndex();
        $this->gotoHome();
        $this->para = $para;
        $this->UserMod = new User_Model();
        $this->UserMod->setPostData($this->postPara);
        $this->UserMod->setPostFile($this->postFile);
        $this->logindata = $_SESSION["USERDATA"]["logindata"];
        $this->UserId = $this->logindata["user_pk"];
        $this->baseview->UserDets = $this->logindata;
    }
    public function Index() {
        $this->baseview->title = 'Process Personal Info';
        $this->baseview->setMenuFile($this->logindata["users_type_nav_menu_file"]);
        $this->baseview->setHeader($this->logindata["users_type_header_file"]);
        $this->baseview->setHTML('User', 'user_profile.php');
        $this->baseview->setFooter('Footer.php');
        $this->baseview->RenderView(true);
    }
    public function UserPersonal() {
        $this->baseview->title = 'Process Personal Info';
        $this->baseview->setMenuFile($this->logindata["users_type_nav_menu_file"]);
        $this->baseview->setHeader($this->logindata["users_type_header_file"]);
        $this->baseview->setHTML('User', 'user_profile.php');
        $this->baseview->setFooter('Footer.php');
        $this->baseview->RenderView(true);
    }
    public function UserBusiness() {
        $this->baseview->title = 'Process Business Info';
        $this->baseview->setMenuFile($this->logindata["users_type_nav_menu_file"]);
        $this->baseview->setHeader($this->logindata["users_type_header_file"]);
        $this->baseview->setHTML('User', 'user_business.php');
        $this->baseview->setFooter('Footer.php');
        $this->baseview->RenderView(true);
    }
    public function UserRequest() {
        $this->baseview->title = 'New Registrations';
        $this->baseview->setMenuFile($this->logindata["users_type_nav_menu_file"]);
        $this->baseview->setHeader($this->logindata["users_type_header_file"]);
        $this->baseview->setHTML('User', 'user_request.php');
        $this->baseview->setFooter('Footer.php');
        $this->baseview->RenderView(true);
    }
    public function UserEdit($id = false) {
        $this->baseview->title = 'Edit User';
        $this->baseview->setMenuFile($this->logindata["users_type_nav_menu_file"]);
        $this->baseview->setHeader($this->logindata["users_type_header_file"]);
        if ($id) {
            $uid = base64_decode($id);
            $this->baseview->getuserDet = $this->UserMod->getUser($uid);
            $this->baseview->setHTML('User', 'user_personal_edit.php');
        } else {
            $this->baseview->setHTML('User', 'user_personal_edit_error.php');
        }
        $this->baseview->setFooter('Footer.php');
        $this->baseview->RenderView(true);
    }
    public function UserBusinessEdit($id = false) {
        $this->baseview->title = 'Edit User';
        $this->baseview->setMenuFile($this->logindata["users_type_nav_menu_file"]);
        $this->baseview->setHeader($this->logindata["users_type_header_file"]);
        if ($id) {
            $uid = base64_decode($id);
            $this->baseview->getuserDet = $this->UserMod->getUserBusiness($uid);
            //var_dump($this->baseview->getuserDet["data"]);
            //exit(0);
            $this->baseview->setHTML('User', 'user_business_edit.php');
        } else {
            $this->baseview->setHTML('User', 'user_personal_edit_error.php');
        }
        $this->baseview->setFooter('Footer.php');
        $this->baseview->RenderView(true);
    }
    public function UserCommissionEdit($id = false) {
        $this->baseview->title = 'Edit User';
        $this->baseview->setMenuFile($this->logindata["users_type_nav_menu_file"]);
        $this->baseview->setHeader($this->logindata["users_type_header_file"]);
        if ($id) {
            $uid = base64_decode($id);
            $this->baseview->getuserDet = $this->UserMod->getUserCommission($uid);
            //var_dump($this->baseview->getuserDet["data"]);
            //exit(0);
            $this->baseview->setHTML('User', 'user_commission_edit.php');
        } else {
            $this->baseview->setHTML('User', 'user_personal_edit_error.php');
        }
        $this->baseview->setFooter('Footer.php');
        $this->baseview->RenderView(true);
    }
    public function UserRequestNew() {
        $this->baseview->setjsonData($this->UserMod->UserRequestNew());
        echo $this->baseview->renderJson();
    }
    public function UserRequestAccepted() {
        $this->baseview->setjsonData($this->UserMod->UserRequestAccepted());
        echo $this->baseview->renderJson();
    }
    public function UserRequestRejected() {
        $this->baseview->setjsonData($this->UserMod->UserRequestRejected());
        echo $this->baseview->renderJson();
    }
    public function ProcessUser() {
        $this->baseview->setjsonData($this->UserMod->ProcessUser());
        echo $this->baseview->renderJson();
    }
    public function UserFinancialTransactions() {
        $this->baseview->title = 'Financial Transactions';
        $this->baseview->setMenuFile($this->logindata["users_type_nav_menu_file"]);
        $this->baseview->setHeader($this->logindata["users_type_header_file"]);
        $this->baseview->setHTML('User', 'user_finance.php');
        $this->baseview->setFooter('Footer.php');
        $this->baseview->RenderView(true);
    }
    public function UserServiceTransactions() {
        $this->baseview->title = 'Service Transactions';
        $this->baseview->setMenuFile($this->logindata["users_type_nav_menu_file"]);
        $this->baseview->setHeader($this->logindata["users_type_header_file"]);
        $this->baseview->setHTML('User', 'user_service.php');
        $this->baseview->setFooter('Footer.php');
        $this->baseview->RenderView(true);
    }
    public function UserCommissions() {
        $this->baseview->title = 'User Commissions';
        $this->baseview->setMenuFile($this->logindata["users_type_nav_menu_file"]);
        $this->baseview->setHeader($this->logindata["users_type_header_file"]);
        $this->baseview->setHTML('User', 'user_commission.php');
        $this->baseview->setFooter('Footer.php');
        $this->baseview->RenderView(true);
    }
    public function AddUser() {
        $this->baseview->setjsonData($this->UserMod->AddUser());
        echo $this->baseview->renderJson();
    }
    public function AddUserCompany($params) {
        $id = base64_decode($params);
        $this->baseview->setjsonData($this->UserMod->AddUserCompany($id));
        echo $this->baseview->renderJson();
    }
    public function ListUserPersonal() {
        $this->baseview->setjsonData($this->UserMod->ListUserPersonal());
        echo $this->baseview->renderJson();
    }
    public function ListUserBusiness() {
        $this->baseview->setjsonData($this->UserMod->ListUserBusiness());
        echo $this->baseview->renderJson();
    }
    public function DisplayUserList() {
        $this->baseview->setjsonData($this->UserMod->DisplayUserList());
        echo $this->baseview->renderJson();
    }
    public function AddBusinessDetails() {
        $this->baseview->setjsonData($this->UserMod->AddBusinessDetails());
        echo $this->baseview->renderJson();
    }
    public function searchUser() {
        $this->baseview->setjsonData($this->UserMod->searchUserDB());
        echo $this->baseview->renderJson();
    }
    public function ListBusinessDetails() {
        $this->baseview->setjsonData($this->UserMod->ListBusinessDetails());
        echo $this->baseview->renderJson();
    }
    public function ListNewRequest() {
        $this->baseview->setjsonData($this->UserMod->ListNewRequest());
        echo $this->baseview->renderJson();
    }
    public function ListAcceptedRequest() {
        $this->baseview->setjsonData($this->UserMod->ListAcceptedRequest());
        echo $this->baseview->renderJson();
    }
    public function ListRejectedRequest() {
        $this->baseview->setjsonData($this->UserMod->ListRejectedRequest());
        echo $this->baseview->renderJson();
    }
    public function ListFinancialSuccess() {
        $this->baseview->setjsonData($this->UserMod->ListFinancialSuccess());
        echo $this->baseview->renderJson();
    }
    public function ListFinancialUnsuccess() {
        $this->baseview->setjsonData($this->UserMod->ListFinancialUnsuccess());
        echo $this->baseview->renderJson();
    }
    public function ListServiceSuccess() {
        $this->baseview->setjsonData($this->UserMod->ListServiceSuccess());
        echo $this->baseview->renderJson();
    }
    public function ListServiceUnsuccess() {
        $this->baseview->setjsonData($this->UserMod->ListServiceUnsuccess());
        echo $this->baseview->renderJson();
    }
    public function SetFixedCommission() {
        $this->baseview->setjsonData($this->UserMod->SetFixedCommission());
        echo $this->baseview->renderJson();
    }
    public function SetVariableCommission() {
        $this->baseview->setjsonData($this->UserMod->SetVariableCommission());
        echo $this->baseview->renderJson();
    }
    public function SetCommissionDetails() {
        $this->baseview->setjsonData($this->UserMod->SetCommissionDetails());
        echo $this->baseview->renderJson();
    }
    public function EditUserPersonal() {
        $this->baseview->setjsonData($this->UserMod->EditUserPersonal());
        echo $this->baseview->renderJson();
    }
    public function DeleteUser($id) {
        $this->baseview->setjsonData($this->UserMod->DeleteUser($id));
        echo $this->baseview->renderJson();
    }
}
?>