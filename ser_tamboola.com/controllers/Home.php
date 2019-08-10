<?php
class Home extends BaseController {

    private $para, $HomeMod, $logindata, $UserId, $GymId, $GymData, $PicController;

    function __construct($para = false) {
        parent::__construct();
        $this->gotoIndex();
        $this->PicController = new Picture();
        $this->para = $para;
        $this->HomeMod = new Home_Model();
        $this->HomeMod->setPostData($this->postPara);
        $this->HomeMod->setPostFile($this->postFile);
        $this->logindata = $_SESSION["USERDATA"]["logindata"];
        $this->UserId = $this->logindata["user_pk"];
        $this->baseview->UserDets = $this->logindata;
    }
    public function Index() {
        $this->baseview->gymPanelView = $this->HomeMod->GymPanelView();
        $this->baseview->title = 'Tamboola - See all Gyms | ' . $this->logindata["type"];
        $this->baseview->setMenuFile(NULL);
        $this->baseview->setHeader($this->config["DEFAULT_HEADER"]);
        $this->baseview->setHTML('Home', 'Index.php');
        $this->baseview->setFooter('Footer.php');
        $this->baseview->RenderView(true);
    }
    public function addGym() {
        $this->baseview->title = 'Tamboola -  Add a Gym | ' . $this->logindata["type"];
        $this->baseview->setMenuFile(NULL);
        $this->baseview->setHeader($this->config["DEFAULT_HEADER"]);
        $this->baseview->setHTML('Home', 'gym.php');
        $this->baseview->setFooter('Footer.php');
        $this->baseview->RenderView(true);
    }
    public function SetGym($id = false) {
        if ($id) {
            $this->baseview->GymDets = $this->HomeMod->getGym($id);
            if ($this->baseview->GymDets["status"] == "success") {
                $this->GymData = $_SESSION["GYM_DETAILS"];
            } else {
                $this->gotoHome();
            }
        } else {
            $this->gotoHome();
        }
        $this->baseview->GymDets = $this->GymData;
        $this->GymId = $this->GymData["gymid"];
        $this->baseview->title = "Tamboola - " . $this->GymData["gymname"] . ' - Details';
        $this->baseview->setMenuFile($this->logindata["users_type_nav_menu_file"]);
        $this->baseview->setHeader($this->logindata["users_type_header_file"]);
        $this->baseview->setHTML('Manage', 'manage_add_facility.php');
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
        $this->baseview->setMenuFile(NULL);
        $this->baseview->setHeader($this->config["DEFAULT_HEADER"]);
        $this->baseview->setHTML('Home', 'viewGym.php');
        $this->baseview->setFooter('Footer.php');
        $this->baseview->RenderView(true);
    }
    public function EditGym($id = false) {
        if ($id) {
            $uid = base64_decode($id);
            $this->baseview->GymDets = $this->HomeMod->getGym($uid);
            if ($this->baseview->GymDets["status"] !== "success") {
                $this->gotoHome();
            }
        } else {
            $this->gotoHome();
        }
        $this->baseview->title = 'Tamboola - Edit - ' . $this->baseview->GymDets["data"]["gymname"] . ' - Details';
        $this->baseview->setMenuFile(NULL);
        $this->baseview->setHeader($this->config["DEFAULT_HEADER"]);
        $this->baseview->setHTML('Home', 'gym_edit.php');
        $this->baseview->setFooter('Footer.php');
        $this->baseview->RenderView(true);
    }
    public function GymAdd() {
        $jsonData = $this->HomeMod->AddGym();
        if ((int) $jsonData["id"] > 0 && count($jsonData["picids"]) > 0 && $jsonData["status"] != "error") {
            $this->PicController->setjsonData($jsonData);
            $this->PicController->UploadPic("gym");
            for ($i = 0; $i < count($_SESSION['IMG_RESPONSE']) && isset($_SESSION['IMG_RESPONSE']); $i++) {
                $this->HomeMod->updatePortalPhotoDetails($_SESSION['IMG_RESPONSE'][$i], $jsonData["picids"][$i], "gym_photo");
            }
            $jsonData["imgstatus"] = $_SESSION['IMG_RESPONSE'];
        }
        $this->baseview->setjsonData($jsonData);
        echo $this->baseview->renderJson();
    }
    public function ListGym() {
        $this->baseview->setjsonData($this->HomeMod->ListGym());
        echo $this->baseview->renderJson();
    }
    public function GymSearch() {
        $this->baseview->setjsonData($this->HomeMod->GymSearch());
        echo $this->baseview->renderJson();
    }
    public function UserSearch() {
        $this->baseview->setjsonData($this->HomeMod->UserSearch());
        echo $this->baseview->renderJson();
    }
    public function GymPanelView() {
        $this->baseview->setjsonData($this->HomeMod->GymPanelView());
        echo $this->baseview->renderJson();
    }
    public function GymEdit() {
        $jsonData = $this->HomeMod->EditGym();
        if ((int) $jsonData["id"] > 0 && count($jsonData["picids"]) > 0 && $jsonData["status"] != "error") {
            $this->PicController->setjsonData($jsonData);
            $this->PicController->UploadPic("gym");
            for ($i = 0; $i < count($_SESSION['IMG_RESPONSE']) && isset($_SESSION['IMG_RESPONSE']); $i++) {
                $this->HomeMod->updatePortalPhotoDetails($_SESSION['IMG_RESPONSE'][$i], $jsonData["picids"][$i], "gym_photo");
            }
            $jsonData["imgstatus"] = $_SESSION['IMG_RESPONSE'];
        }
        $this->baseview->setjsonData($jsonData);
        echo $this->baseview->renderJson();
    }
    public function DeleteGym($id = false) {
        $this->baseview->setjsonData($this->HomeMod->DeleteGymDetails($id));
        echo $this->baseview->renderJson();
    }
}
?>