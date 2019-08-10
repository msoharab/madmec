<?php
class BaseController extends configure {
    protected $baseview, $basemodel, $postPara, $postFile;
    protected $BusinessDetails,$BusinessId,$BusinessSize;
    protected $FBRequest,$FBError,$FBData;
    protected $GPRequest,$GPError,$GPData;
    public function __construct() {
        parent::__construct();
        $this->getPara = isset($_GET) ? $_GET : NULL;
        $this->postPara = isset($_POST) ? $_POST : NULL;
        $this->postFile = isset($_FILES) ? $_FILES : NULL;
        $this->basemodel = new BaseModel();
        $this->baseview = new BaseView(array(
            "msg" => 'nOOkLeads.com',
            "title" => 'Welcome To nOOkLeads.com',
            "header" => $this->config["DOC_ROOT"] . $this->config["VIEWS"] . $this->config["INC"] . 'Header.php',
            "body" => $this->config["DOC_ROOT"] . $this->config["VIEWS"] . $this->config["CTRL_28"] .'Index.php',
            "footer" => $this->config["DOC_ROOT"] . $this->config["VIEWS"] . $this->config["INC"] . 'Footer.php',
            "data" => (array) $this->postPara
        ));
    }
    public function gotoDeal() {
        if (isset($_SESSION["USERDATA"]["loggedin"]) && $_SESSION["USERDATA"]["loggedin"] == 1) {
            header('Location:' . $this->config["URL"] . 'Deal');
        }
    }
    public function gotoIndex() {
        if (!isset($_SESSION["USERDATA"])) {
            header('Location:' . $this->config["URL"] . 'Logout');
        }
    }
}
?>