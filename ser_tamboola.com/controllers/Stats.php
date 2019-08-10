<?php
class Stats extends BaseController {
    private $para, $logindata, $UserId, $GymId, $GymData;
    function __construct($para = false) {
        parent::__construct();
        $this->gotoIndex();
        $this->gotoHome();
        $this->para = $para;
        $this->logindata = $_SESSION["USERDATA"]["logindata"];
        $this->UserId = $this->logindata["user_pk"];
        $this->baseview->GymDets = $_SESSION["GYM_DETAILS"];
        $this->baseview->UserDets = $this->logindata;
    }
    public function Index() {
        $this->baseview->title = 'Stats | ' . $this->logindata["type"];
        $this->baseview->setMenuFile($this->logindata["users_type_nav_menu_file"]);
        $this->baseview->setHeader($this->logindata["users_type_header_file"]);
        $this->baseview->setHTML('Stats', 'stats_accounts.php');
        $this->baseview->setFooter('Footer.php');
        $this->baseview->RenderView(true);
    }
    public function Transaction() {
        $this->baseview->title = 'Stats Accounts';
        $this->baseview->setMenuFile($this->logindata["users_type_nav_menu_file"]);
        $this->baseview->setHeader($this->logindata["users_type_header_file"]);
        $this->baseview->setHTML('Stats', 'stats_accounts.php');
        $this->baseview->setFooter('Footer.php');
        $this->baseview->RenderView(true);
    }
    public function Customers() {
        $this->baseview->title = 'Stats Customers';
        $this->baseview->setMenuFile($this->logindata["users_type_nav_menu_file"]);
        $this->baseview->setHeader($this->logindata["users_type_header_file"]);
        $this->baseview->setHTML('Stats', 'stats_customers.php');
        $this->baseview->setFooter('Footer.php');
        $this->baseview->RenderView(true);
    }
    public function Registration() {
        $this->baseview->title = 'Stats Registrations';
        $this->baseview->setMenuFile($this->logindata["users_type_nav_menu_file"]);
        $this->baseview->setHeader($this->logindata["users_type_header_file"]);
        $this->baseview->setHTML('Stats', 'stats_registrations.php');
        $this->baseview->setFooter('Footer.php');
        $this->baseview->RenderView(true);
    }
}
?>
