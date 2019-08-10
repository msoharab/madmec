<?php
class Enquiry extends BaseController {
    private $para, $EnquiryMod, $logindata, $UserId, $GymId, $GymData;
    function __construct($para = false) {
        parent::__construct();
        $this->gotoIndex();
        $this->para = $para;
        $this->EnquiryMod = new Enquiry_Model();
        $this->EnquiryMod->setPostData($this->postPara);
        $this->EnquiryMod->setPostFile($this->postFile);
        $this->logindata = $_SESSION["USERDATA"]["logindata"];
        $this->UserId = $this->logindata["user_pk"];
        $this->baseview->UserDets = $this->logindata;
    }
    public function Index() {
        $this->baseview->title = 'Enquiry | ' . $this->logindata["type"];
        $this->baseview->setMenuFile($this->logindata["users_type_nav_menu_file"]);
        $this->baseview->setHeader($this->logindata["users_type_header_file"]);
        $this->baseview->setHTML('Enquiry', 'enquiry_add.php');
        $this->baseview->setFooter('Footer.php');
        $this->baseview->RenderView(true);
    }
    public function EnquiryAdd() {
        $this->baseview->title = 'Add Enquiry';
        $this->baseview->setMenuFile($this->logindata["users_type_nav_menu_file"]);
        $this->baseview->setHeader($this->logindata["users_type_header_file"]);
        $this->baseview->setHTML('Enquiry', 'enquiry_add.php');
        $this->baseview->setFooter('Footer.php');
        $this->baseview->RenderView(true);
    }
    public function EnquiryFollows() {
        $this->baseview->title = 'Enquiry Follows';
        $this->baseview->setMenuFile($this->logindata["users_type_nav_menu_file"]);
        $this->baseview->setHeader($this->logindata["users_type_header_file"]);
        $this->baseview->setHTML('Enquiry', 'enquiry_follow.php');
        $this->baseview->setFooter('Footer.php');
        $this->baseview->RenderView(true);
    }
    public function EnquiryList() {
        $this->baseview->title = 'Enquiry List';
        $this->baseview->setMenuFile($this->logindata["users_type_nav_menu_file"]);
        $this->baseview->setHeader($this->logindata["users_type_header_file"]);
        $this->baseview->setHTML('Enquiry', 'enquiry_listall.php');
        $this->baseview->setFooter('Footer.php');
        $this->baseview->RenderView(true);
    }
    public function EnquirySentCred() {
        $this->baseview->title = 'Sent Credential';
        $this->baseview->setMenuFile($this->logindata["users_type_nav_menu_file"]);
        $this->baseview->setHeader($this->logindata["users_type_header_file"]);
        $this->baseview->setHTML('Enquiry', 'enquiry_sentcred.php');
        $this->baseview->setFooter('Footer.php');
        $this->baseview->RenderView(true);
    }
    public function AddEnquiry() {
        $this->baseview->setjsonData($this->EnquiryMod->EnquiryAdd());
        echo $this->baseview->renderJson();
    }
    public function ListEnquiry() {
        $this->baseview->setjsonData($this->EnquiryMod->ListEnquiry());
        echo $this->baseview->renderJson();
    }
    public function DeleteEnquiry($id = false) {
        $this->baseview->setjsonData($this->EnquiryMod->DeleteEnquiry($id));
        echo $this->baseview->renderJson();
    }
}
?>
