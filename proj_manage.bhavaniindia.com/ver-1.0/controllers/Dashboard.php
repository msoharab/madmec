<?php

class Dashboard extends BaseController {

    private $para, $DashMod, $logindata, $UserId,$PicController;

    function __construct($para = false) {
        parent::__construct();
        $this->gotoIndex();
        $this->para = $para;
        $this->DashMod = new Dashboard_Model();
        $this->DashMod->setPostData($this->postPara);
        $this->DashMod->setPostFile($this->postFile);
        $this->logindata = $_SESSION["USERDATA"]["logindata"];
        $this->UserId = $this->logindata["id"];
    }

    public function Index() {
        $this->baseview->UserDets = $this->logindata;
        $this->baseview->title = 'Welcome To Dashboard | Admin';
        $this->baseview->setHeader('Header.php');
        $this->baseview->setHTML('Dashboard', 'Dashboard.php');
        $this->baseview->setFooter('Footer.php');
        $this->baseview->RenderView(true);
    }

    public function Dashboard() {
        $this->baseview->UserDets = $this->logindata;
        $this->baseview->title = 'Welcome To Dashboard | Admin';
        $this->baseview->setHeader('Header.php');
        $this->baseview->setHTML('Dashboard', 'Dashboard.php');
        $this->baseview->setFooter('Footer.php');
        $this->baseview->RenderView(true);
    }

    public function Product() {
        $this->baseview->UserDets = $this->logindata;
        $this->baseview->title = 'Welcome To Dashboard | Admin';
        $this->baseview->setHeader('Header.php');
        $this->baseview->setHTML('Dashboard', 'Add_Product.php');
        $this->baseview->setFooter('Footer.php');
        $this->baseview->RenderView(true);
    }

    public function ListProduct() {
        $this->baseview->UserDets = $this->logindata;
        $this->baseview->title = 'Welcome To Dashboard | Admin';
        $this->baseview->setHeader('Header.php');
        $this->baseview->setHTML('Dashboard', 'List_Products.php');
        $this->baseview->setFooter('Footer.php');
        $this->baseview->RenderView(true);
    }
     public function Members() {
        $this->baseview->UserDets = $this->logindata;
        $this->baseview->title = 'Welcome To Dashboard | Admin';
        $this->baseview->setHeader('Header.php');
        $this->baseview->setHTML('Dashboard', 'Add_Members.php');
        $this->baseview->setFooter('Footer.php');
        $this->baseview->RenderView(true);
    }

    public function ListMembers() {
        $this->baseview->UserDets = $this->logindata;
        $this->baseview->title = 'Welcome To Dashboard | Admin';
        $this->baseview->setHeader('Header.php');
        $this->baseview->setHTML('Dashboard', 'List_Members.php');
        $this->baseview->setFooter('Footer.php');
        $this->baseview->RenderView(true);
    }

    public function AddProduct() {
        $jsonData = $this->DashMod->AddProduct();
        if ((int) $jsonData["id"] > 0 && count($jsonData["picids"]) > 0 && $jsonData["status"] != "error") {
            $this->PicController = new Picture();
            $this->PicController->setjsonData($jsonData);
            $this->PicController->UploadPic("product");
            for ($i = 0; $i < count($_SESSION['IMG_RESPONSE']) && isset($_SESSION['IMG_RESPONSE']); $i++) {
                $this->DashMod->updatePortalPhotoDetails($_SESSION['IMG_RESPONSE'][$i], $jsonData["picids"][$i], "photo");
            }
            $jsonData["imgstatus"] = $_SESSION['IMG_RESPONSE'];
        }
        $this->baseview->setjsonData($jsonData);
        echo $this->baseview->renderJson();
    }
    public function ListProducts() {
        $this->baseview->setjsonData($this->DashMod->ListProduct());
        echo $this->baseview->renderJson();
    }
     public function AddMembers() {
        $jsonData = $this->DashMod->AddMembers();
        if ((int) $jsonData["id"] > 0 && count($jsonData["picids"]) > 0 && $jsonData["status"] != "error") {
            $this->PicController = new Picture();
            $this->PicController->setjsonData($jsonData);
            $this->PicController->UploadPic("user");
            for ($i = 0; $i < count($_SESSION['IMG_RESPONSE']) && isset($_SESSION['IMG_RESPONSE']); $i++) {
                $this->DashMod->updatePortalPhotoDetails($_SESSION['IMG_RESPONSE'][$i], $jsonData["picids"][$i], "photo");
            }
            $jsonData["imgstatus"] = $_SESSION['IMG_RESPONSE'];
        }
        $this->baseview->setjsonData($jsonData);
        echo $this->baseview->renderJson();
    }
    public function ListMembersDB() {
        $this->baseview->setjsonData($this->DashMod->ListMembers());
        echo $this->baseview->renderJson();
    }
    public function DeleteProduct($id = false) {
        $this->baseview->setjsonData($this->DashMod->DeleteProduct($id));
        echo $this->baseview->renderJson();
    }

}

?>
