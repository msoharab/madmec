<?php

class BaseController extends configure {

    protected $baseview, $basemodel, $postPara, $postFile;

    public function __construct() {
        parent::__construct();
        $this->getPara = isset($_GET) ? $_GET : NULL;
        $this->postPara = isset($_POST) ? $_POST : NULL;
        $this->postFile = isset($_FILES) ? $_FILES : NULL;
        $this->basemodel = new BaseModel();
        $this->basemodel->setPostData($this->postPara);
        $this->basemodel->setPostFile($this->postFile);
        $this->baseview = new BaseView();
        spl_autoload_register(function($class) {
            $obj = new configure();
            $file = $obj->config["DOC_ROOT"] . $obj->config["CONTROLLERS"] . $class . '.php';
            if (file_exists($file)) {
                require_once $file;
            }
        });
    }

    public function gotoDashboard() {
        if (isset($_SESSION["USERDATA"]["loggedin"]) && $_SESSION["USERDATA"]["loggedin"] == 1) {
            header('Location:' . $this->config["URL"] . $this->config["CTRL_0"]);
        }
    }

    public function gotoIndex() {
        if (!isset($_SESSION["USERDATA"])) {
            header('Location:' . $this->config["URL"] . $this->config["CTRL_5"]);
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

    public function fetchCompany() {
        $this->baseview->setjsonData($this->basemodel->fetchCompanyDB(isset($this->postPara['listtype']) ? $this->postPara['listtype'] : false));
        echo $this->baseview->renderJson();
    }

    public function fetchUserTypes() {
        $this->baseview->setjsonData($this->basemodel->fetchUserTypesDB(isset($this->postPara['listtype']) ? $this->postPara['listtype'] : false));
        echo $this->baseview->renderJson();
    }

}
