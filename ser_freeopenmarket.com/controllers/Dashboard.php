<?php

class Dashboard extends BaseController {

    private $para, $logindata, $UserId;

    function __construct($para = false) {
        parent::__construct();
        $this->gotoIndex();
        $this->para = $para;
        if (isset($_SESSION["USERDATA"]["logindata"])) {
            $this->logindata = $_SESSION["USERDATA"]["logindata"];
            $this->UserId = $this->logindata["users_pk"];
            $this->baseview->UserDets = $this->logindata;
            $this->baseview->UserDets = $this->logindata;
            $this->baseview->title = 'Welcome To '.$this->logindata["users_type_type"].' Dashboard ;';
            $this->baseview->setMenuFile($this->logindata["users_type_nav_menu_file"]);
            $this->baseview->setHeader($this->logindata["users_type_header_file"]);
        }
    }

    public function Index() {
        switch($this->logindata["user_type_id"]){
            case 1:
                //Sub Retailer
                break;
            case 2:
                //Admin
                break;
            case 3:
                //Super Distributor
                break;
            case 4:
                //Distributor
                break;
            case 5:
                //Sub Distributor
                break;
            case 6:
                //Retailer
                break;
            case 7:
                //Sub Retailer
                break;
            case 8:
                //API User
                break;
            case 9:
                //Customer
                $this->CustomerDash();
                break;
            case 10:
                //MMAdmin
                $this->AdminDash();
                break;
            case 11:
                //Employee
                $this->EmployeeDash();
                break;
        }
    }
    public function AdminDash(){
        $this->baseview->setBody('Dashboard');
        $this->baseview->setFooter('Footer.php');
        $this->baseview->RenderView(true);
    }
    public function CustomerDash(){
        $this->baseview->setBody('Customer');
        $this->baseview->setFooter('Footer.php');
        $this->baseview->RenderView(true);
    }
    public function EmployeeDash(){
        $this->baseview->setBody('Employee');
        $this->baseview->setFooter('Footer.php');
        $this->baseview->RenderView(true);
    }

}

?>
