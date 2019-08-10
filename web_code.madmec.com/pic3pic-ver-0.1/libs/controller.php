<?php
class BaseController extends configure {

    protected $baseview, $basemodel, $postPara;

    public function __construct() {
        parent::__construct();
        $this->postPara = isset($_POST) ? $_POST : NULL;
        //$this->basemodel = new BaseModel();
        //$this->basemodel->setPostBaseData($this->postPara);
        $this->baseview = new BaseView(array(
            "msg" => 'Pic3Pic.com',
            "title" => 'Welcome To Pic3Pic.com',
            "header" => $this->config["DOC_ROOT"] . $this->config["VIEWS"] . $this->config["INC"] . 'Header.php',
            "body" => $this->config["DOC_ROOT"] . $this->config["VIEWS"] . 'Index/Index.php',
            "footer" => $this->config["DOC_ROOT"] . $this->config["VIEWS"] . $this->config["INC"] . 'Footer.php',
            "data" => (array) $this->postPara
        ));
    }
}
?>