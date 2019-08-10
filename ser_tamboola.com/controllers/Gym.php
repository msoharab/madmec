<?php
class Gym extends BaseController {
    private $para, $GymMod, $logindata, $UserId, $GymId, $PicController;
    function __construct($para = false) {
        parent::__construct();
        $this->gotoIndex();
        $this->PicController = new Picture();
        $this->para = $para;
        $this->GymMod = new Gym_Model();
        $this->GymMod->setPostData($this->postPara);
        $this->GymMod->setPostFile($this->postFile);
        $this->logindata = $_SESSION["USERDATA"]["logindata"];
        $this->UserId = $this->logindata["user_pk"];
        $this->baseview->UserDets = $this->logindata;
    }
    public function Index() {
        $this->baseview->title = 'Gym | ' . $this->logindata["type"];
        $this->baseview->setMenuFile($this->config["DEFAULT_LMENU"]);
        $this->baseview->setHeader($this->logindata["users_type_header_file"]);
        $this->baseview->setBody('Gym', 'Index.php');
        $this->baseview->setFooter('Footer.php');
        $this->baseview->RenderView(true);
    }
    public function ViewGym($id = false) {
        if ($id) {
            $this->baseview->GymDets = $this->HomeMod->getGym($id);
            if ($this->baseview->GymDets["status"] === "success") {
                $this->GymData = $_SESSION["GYM_DETAILS"];
                $this->GymId = $this->GymData["gymid"];
                $this->baseview->GymDets = $this->GymData;
            } else {
                $this->gotoHome();
            }
        } else {
            $this->gotoHome();
        }
        $this->baseview->title = "Tamboola - " . $this->GymData["gymname"] . ' - Details';
        $this->baseview->setMenuFile($this->logindata["users_type_nav_menu_file"]);
        $this->baseview->setHeader($this->logindata["users_type_header_file"]);
        $this->baseview->setHTML('Gym', 'Index.php');
        $this->baseview->setFooter('Footer.php');
        $this->baseview->RenderView(true);
    }
    public function EditGym($id = false) {
        if ($id) {
            $uid = base64_decode($id);
            $this->baseview->GymDets = $this->GymMod->getGym($uid);
            if ($this->baseview->GymDets["status"] !== "success") {
                $this->gotoHome();
            }
        } else {
            $this->gotoHome();
        }
        $this->baseview->title = 'Tamboola - Edit - '. $this->baseview->GymDets["gymname"] .' - Details';
        $this->baseview->setMenuFile($this->logindata["users_type_nav_menu_file"]);
        $this->baseview->setHeader($this->logindata["users_type_header_file"]);
        $this->baseview->setHTML('Gym', 'gym_edit.php');
        $this->baseview->setFooter('Footer.php');
        $this->baseview->RenderView(true);
    }
    public function GymAdd() {
        $jsonData = $this->GymMod->AddGym();
        if ((int) $jsonData["id"] > 0 && count($jsonData["picids"]) > 0 && $jsonData["status"] != "error") {
            $this->PicController->setjsonData($jsonData);
            $this->PicController->UploadPic("gym");
            for ($i = 0; $i < count($_SESSION['IMG_RESPONSE']) && isset($_SESSION['IMG_RESPONSE']); $i++) {
                $this->GymMod->updatePortalPhotoDetails($_SESSION['IMG_RESPONSE'][$i], $jsonData["picids"][$i], "gym_photo");
            }
            $jsonData["imgstatus"] = $_SESSION['IMG_RESPONSE'];
        }
        $this->baseview->setjsonData($jsonData);
        echo $this->baseview->renderJson();
    }
    public function ListGym() {
        $this->baseview->setjsonData($this->GymMod->ListGym());
        echo $this->baseview->renderJson();
    }
    public function GymSearch() {
        $this->baseview->setjsonData($this->GymMod->GymSearch());
        echo $this->baseview->renderJson();
    }
    public function GymPanelView() {
        $this->baseview->setjsonData($this->GymMod->GymPanelView());
        echo $this->baseview->renderJson();
    }
    public function GymEdit() {
        $this->baseview->setjsonData($this->GymMod->EditGym());
        echo $this->baseview->renderJson();
    }
    public function DeleteGym($id = false) {
        $this->baseview->setjsonData($this->GymMod->DeleteGymDetails($id));
        echo $this->baseview->renderJson();
    }
}
?>