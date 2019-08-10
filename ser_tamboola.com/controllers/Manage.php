<?php
class Manage extends BaseController {

    private $para, $logindata, $UserId, $GymId, $GymData;

    function __construct($para = false) {
        parent::__construct();
        $this->gotoIndex();
        $this->gotoHome();
        $this->para = $para;
        $this->ManageMod = new Manage_Model();
        $this->ManageMod->setPostData($this->postPara);
        $this->ManageMod->setPostFile($this->postFile);
        $this->logindata = $_SESSION["USERDATA"]["logindata"];
        $this->UserId = $this->logindata["user_pk"];
        $this->baseview->GymDets = $_SESSION["GYM_DETAILS"];
        $this->baseview->UserDets = $this->logindata;
    }
    public function Index() {
        $this->baseview->title = 'Manage | ' . $this->logindata["type"];
        $this->baseview->setMenuFile($this->logindata["users_type_nav_menu_file"]);
        $this->baseview->setHeader($this->logindata["users_type_header_file"]);
        $this->baseview->setBody('Manage', 'manage_add_facility.php');
        $this->baseview->setFooter('Footer.php');
        $this->baseview->RenderView(true);
    }
    /* Facilities */
    public function Facility() {
        $this->baseview->title = 'Manage | ' . $this->logindata["type"];
        $this->baseview->setMenuFile($this->logindata["users_type_nav_menu_file"]);
        $this->baseview->setHeader($this->logindata["users_type_header_file"]);
        $this->baseview->setHtml('Manage', 'manage_add_facility.php');
        $this->baseview->setFooter('Footer.php');
        $this->baseview->RenderView(true);
    }
    public function AddFacility() {
        $this->baseview->setjsonData($this->ManageMod->AddFacility());
        echo $this->baseview->renderJson();
    }
    public function EditFacility($id = false) {
        $this->baseview->UserDets = $this->logindata;
        $this->baseview->title = 'Edit Gym Facility';
        $this->baseview->setMenuFile($this->logindata["users_type_nav_menu_file"]);
        $this->baseview->setHeader($this->logindata["users_type_header_file"]);
        if ($id) {
            $uid = base64_decode($id);
            $this->baseview->ManageDets = $this->ManageMod->getFacility($uid);
            $this->baseview->setHTML('Manage', 'manage_edit_facility.php');
        } else {
            $this->baseview->setHTML('Error', 'Index.php');
        }
        $this->baseview->setFooter('Footer.php');
        $this->baseview->RenderView(true);
    }
    public function ShowFacilities() {
        $this->baseview->setjsonData($this->ManageMod->ListFacilityShow());
        echo $this->baseview->renderJson();
    }
    public function ReactFacilities() {
        $this->baseview->setjsonData($this->ManageMod->ListFacilityReactive());
        echo $this->baseview->renderJson();
    }
    public function chageFacilityStatus() {
        $uid = base64_decode($this->postPara["fopid"]);
        $stat = $this->postPara["stat"];
        $this->baseview->jsonData = $this->ManageMod->chageFacilityStatusDB($uid, $stat);
        $this->baseview->setjsonData($this->baseview->jsonData);
        echo $this->baseview->renderJson();
    }
    public function DeleteFacility($id = false) {
        $this->baseview->setjsonData($this->ManageMod->DeleteFacility($id));
        echo $this->baseview->renderJson();
    }
    public function FacilityEdit() {
        $this->baseview->setjsonData($this->ManageMod->EditFacility());
        echo $this->baseview->renderJson();
    }
    /* Offers */
    public function Offers() {
        $this->baseview->title = 'Manage | ' . $this->logindata["type"];
        $this->baseview->setMenuFile($this->logindata["users_type_nav_menu_file"]);
        $this->baseview->setHeader($this->logindata["users_type_header_file"]);
        $this->baseview->setHtml('Manage', 'manage_offer.php');
        $this->baseview->setFooter('Footer.php');
        $this->baseview->RenderView(true);
    }
    public function AddOffers() {
        $this->baseview->setjsonData($this->ManageMod->AddOffer());
        echo $this->baseview->renderJson();
    }
    public function chageOfferStatus() {
        $uid = base64_decode($this->postPara["fopid"]);
        $stat = $this->postPara["stat"];
        $this->baseview->jsonData = $this->ManageMod->chageOfferStatusDB($uid, $stat);
        $this->baseview->setjsonData($this->baseview->jsonData);
        echo $this->baseview->renderJson();
    }
    public function EditOffer($id = false) {
        $this->baseview->UserDets = $this->logindata;
        $this->baseview->title = 'Edit Gym Offer';
        $this->baseview->setMenuFile($this->logindata["users_type_nav_menu_file"]);
        $this->baseview->setHeader($this->logindata["users_type_header_file"]);
        if ($id) {
            $uid = base64_decode($id);
            $this->baseview->ManageDets = $this->ManageMod->getOffer($uid);
            $this->baseview->setHTML('Manage', 'manage_edit_offer.php');
        } else {
            $this->baseview->setHTML('Error', 'Index.php');
        }
        $this->baseview->setFooter('Footer.php');
        $this->baseview->RenderView(true);
    }
    public function OfferEdit() {
        $this->baseview->setjsonData($this->ManageMod->EditOffer());
        echo $this->baseview->renderJson();
    }
    public function DeleteOffer($id = false) {
        $this->baseview->setjsonData($this->ManageMod->DeleteOffer($id));
        echo $this->baseview->renderJson();
    }
    public function ListOffers() {
        $this->baseview->setjsonData($this->ManageMod->ListOffer());
        echo $this->baseview->renderJson();
    }
    public function ViewOffers() {
    }
    /* Packages */
    public function Packages() {
        $this->baseview->title = 'Manage | ' . $this->logindata["type"];
        $this->baseview->setMenuFile($this->logindata["users_type_nav_menu_file"]);
        $this->baseview->setHeader($this->logindata["users_type_header_file"]);
        $this->baseview->setHtml('Manage', 'manage_package.php');
        $this->baseview->setFooter('Footer.php');
        $this->baseview->RenderView(true);
    }
    public function EditPackage($id = false) {
        $this->baseview->UserDets = $this->logindata;
        $this->baseview->title = 'Edit Gym Package';
        $this->baseview->setMenuFile($this->logindata["users_type_nav_menu_file"]);
        $this->baseview->setHeader($this->logindata["users_type_header_file"]);
        if ($id) {
            $uid = base64_decode($id);
            $this->baseview->ManageDets = $this->ManageMod->getPackage($uid);
            $this->baseview->setHTML('Manage', 'manage_edit_package.php');
        } else {
            $this->baseview->setHTML('Error', 'Index.php');
        }
        $this->baseview->setFooter('Footer.php');
        $this->baseview->RenderView(true);
    }
    public function AddPackages() {
        $this->baseview->setjsonData($this->ManageMod->AddPackage());
        echo $this->baseview->renderJson();
    }
    public function chagePackageStatus() {
        $uid = base64_decode($this->postPara["fopid"]);
        $stat = $this->postPara["stat"];
        $this->baseview->jsonData = $this->ManageMod->chagePackageStatusDB($uid, $stat);
        $this->baseview->setjsonData($this->baseview->jsonData);
    }
    public function ListPackages() {
        $this->baseview->setjsonData($this->ManageMod->ListPackages());
        echo $this->baseview->renderJson();
    }
    public function DeletePackage($id = false) {
        $this->baseview->setjsonData($this->ManageMod->DeletePackage($id));
        echo $this->baseview->renderJson();
    }
    public function PackagesEdit() {
        $this->baseview->setjsonData($this->ManageMod->EditPackage());
        echo $this->baseview->renderJson();
    }
    public function ViewPackage() {
    }
}
?>