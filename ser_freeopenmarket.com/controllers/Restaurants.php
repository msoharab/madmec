<?php

class Restaurants extends BaseController {

    private $para, $logindata, $UserId, $RestaurantMod;

    function __construct($para = false) {
        parent::__construct();
        $this->gotoIndex();
        $this->para = $para;
        $this->PicController = new Picture();
        $this->RestaurantMod = new Restaurants_Model();
        $this->RestaurantMod->setPostData($this->postPara);
        $this->RestaurantMod->setPostFile($this->postFile);
        if (isset($_SESSION["USERDATA"]["logindata"])) {
            $this->logindata = $_SESSION["USERDATA"]["logindata"];
            $this->UserId = $this->logindata["users_pk"];
            $this->baseview->UserDets = $this->logindata;
        }
    }

    public function Index() {
        $this->baseview->title = 'Add - List Restaurants';
        $this->baseview->setMenuFile($this->logindata["users_type_nav_menu_file"]);
        $this->baseview->setHeader($this->logindata["users_type_header_file"]);
        $this->baseview->setBody('Restaurant', 'Index.php');
        $this->baseview->setFooter('Footer.php');
        $this->baseview->RenderView(true);
    }

    public function RestaurantAdd() {
        $jsonData = $this->RestaurantMod->AddRestaurant();
        if ((int) $jsonData["id"] > 0 && count($jsonData["picids"]) > 0 && $jsonData["status"] != "error") {
            $this->PicController->setjsonData($jsonData);
            $this->PicController->UploadPic("Restaurant");
            for ($i = 0; $i < count($_SESSION['IMG_RESPONSE']) && isset($_SESSION['IMG_RESPONSE']); $i++) {
                $this->RestaurantMod->updatePortalPhotoDetails($_SESSION['IMG_RESPONSE'][$i], $jsonData["picids"][$i], "Restaurant_photo");
            }
            $jsonData["imgstatus"] = $_SESSION['IMG_RESPONSE'];
        }
        $this->baseview->setjsonData($jsonData);
        echo $this->baseview->renderJson();
    }

    public function ListRestaurant() {
        $this->baseview->setjsonData($this->RestaurantMod->ListRestaurant());
        echo $this->baseview->renderJson();
    }

    public function RestaurantSearch() {
        $this->baseview->setjsonData($this->RestaurantMod->RestaurantSearch());
        echo $this->baseview->renderJson();
    }

    public function RestaurantPanelView() {
        $this->baseview->setjsonData($this->RestaurantMod->RestaurantPanelView());
        echo $this->baseview->renderJson();
    }

}

?>