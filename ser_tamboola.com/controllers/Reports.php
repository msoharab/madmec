<?php
class Reports extends BaseController {
    private $para, $logindata, $ReportMod, $UserId, $GymId, $GymData;
    function __construct($para = false) {
        parent::__construct();
        $this->gotoIndex();
        $this->gotoHome();
        $this->para = $para;
        $this->ReportMod = new Reports_Model();
        $this->ReportMod->setPostData($this->postPara);
        $this->ReportMod->setPostFile($this->postFile);
        $this->logindata = $_SESSION["USERDATA"]["logindata"];
        $this->UserId = $this->logindata["user_pk"];
        $this->baseview->GymDets = $_SESSION["GYM_DETAILS"];
        $this->baseview->UserDets = $this->logindata;
    }
    public function Index() {
        $this->baseview->title = 'Reports';
        $this->baseview->setMenuFile($this->logindata["users_type_nav_menu_file"]);
        $this->baseview->setHeader($this->logindata["users_type_header_file"]);
        $this->baseview->setHTML('Reports', 'reports.php');
        $this->baseview->setFooter('Footer.php');
        $this->baseview->RenderView(true);
    }
    public function OfferReport() {
        $this->baseview->title = 'Reports';
        $this->baseview->setMenuFile($this->logindata["users_type_nav_menu_file"]);
        $this->baseview->setHeader($this->logindata["users_type_header_file"]);
        $this->baseview->setHTML('Reports', 'report_offers.php');
        $this->baseview->setFooter('Footer.php');
        $this->baseview->RenderView(true);
    }
    public function PackageReport() {
        $this->baseview->title = 'Reports';
        $this->baseview->setMenuFile($this->logindata["users_type_nav_menu_file"]);
        $this->baseview->setHeader($this->logindata["users_type_header_file"]);
        $this->baseview->setHTML('Reports', 'report_package.php');
        $this->baseview->setFooter('Footer.php');
        $this->baseview->RenderView(true);
    }
    public function PaymentReport() {
        $this->baseview->title = 'Reports';
        $this->baseview->setMenuFile($this->logindata["users_type_nav_menu_file"]);
        $this->baseview->setHeader($this->logindata["users_type_header_file"]);
        $this->baseview->setHTML('Reports', 'report_payments.php');
        $this->baseview->setFooter('Footer.php');
        $this->baseview->RenderView(true);
    }
    public function ExpensesReport() {
        $this->baseview->title = 'Reports';
        $this->baseview->setMenuFile($this->logindata["users_type_nav_menu_file"]);
        $this->baseview->setHeader($this->logindata["users_type_header_file"]);
        $this->baseview->setHTML('Reports', 'report_expenses.php');
        $this->baseview->setFooter('Footer.php');
        $this->baseview->RenderView(true);
    }
    public function BalanceReport() {
        $this->baseview->title = 'Reports';
        $this->baseview->setMenuFile($this->logindata["users_type_nav_menu_file"]);
        $this->baseview->setHeader($this->logindata["users_type_header_file"]);
        $this->baseview->setHTML('Reports', 'report_balancesheet.php');
        $this->baseview->setFooter('Footer.php');
        $this->baseview->RenderView(true);
    }
    public function AttendanceReport() {
        $this->baseview->title = 'Reports';
        $this->baseview->setMenuFile($this->logindata["users_type_nav_menu_file"]);
        $this->baseview->setHeader($this->logindata["users_type_header_file"]);
        $this->baseview->setHTML('Reports', 'report_attendance.php');
        $this->baseview->setFooter('Footer.php');
        $this->baseview->RenderView(true);
    }
    public function ReceiptReport() {
        $this->baseview->title = 'Reports';
        $this->baseview->setMenuFile($this->logindata["users_type_nav_menu_file"]);
        $this->baseview->setHeader($this->logindata["users_type_header_file"]);
        $this->baseview->setHTML('Reports', 'report_receipts.php');
        $this->baseview->setFooter('Footer.php');
        $this->baseview->RenderView(true);
    }
}
?>