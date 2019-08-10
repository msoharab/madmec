<?php
class BaseController extends configure {
    protected $baseview, $basemodel, $postPara, $postFile,$jsonData;
    public function __construct() {
        parent::__construct();
        $this->jsonData = NULL;
        $this->getPara = isset($_GET) ? $_GET : NULL;
        $this->postPara = isset($_POST) ? $_POST : NULL;
        $this->postFile = isset($_FILES) ? $_FILES : NULL;
        $this->basemodel = new BaseModel();
        $this->basemodel->setPostData($this->postPara);
        $this->basemodel->setPostFile($this->postFile);
        $this->baseview = new BaseView(array(
            "msg" => 'Ricepark',
            "title" => 'Welcome To Ricepark',
            "header" => $this->config["DOC_ROOT"] . $this->config["VIEWS"] . $this->config["INC"] . 'Header.php',
//            "menufile" => $this->config["DOC_ROOT"] . $this->config["VIEWS"] . $this->config["INC"] . 'IndexLeftNavMenu.php',
            "body" => $this->config["DOC_ROOT"] . $this->config["VIEWS"] . $this->config["CTRL_2"] . 'Index.php',
            "footer" => $this->config["DOC_ROOT"] . $this->config["VIEWS"] . $this->config["INC"] . 'Footer.php',
            "data" => (array) $this->postPara
        ));
    }
    public function gotoDashboard() {
        if (isset($_SESSION["USERDATA"]["loggedin"]) && $_SESSION["USERDATA"]["loggedin"] == 1) {
            header('Location:' . $this->config["URL"] . $this->config["CTRL_9"]);
        }
    }
    public function gotoIndex() {
        if (!isset($_SESSION["USERDATA"])) {
            header('Location:' . $this->config["URL"] . $this->config["CTRL_1"]);
        }
    }
    public function checkEmail() {
        $this->baseview->setjsonData($this->basemodel->checkEmailDB());
        echo $this->baseview->renderJson();
    }
    public function fetchGender() {
        $this->baseview->setjsonData($this->basemodel->fetchGenderDB(isset($this->postPara['listtype']) ? $this->postPara['listtype'] : false));
        echo $this->baseview->renderJson();
    }
    public function getjsonData($jsonData) {
        return $this->jsonData;
    }
    public function setjsonData($jsonData) {
        $this->jsonData = (array) $jsonData;
    }
}