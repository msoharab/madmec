<?php
class LoadJSON extends BaseController {

    private $res;

    function __construct() {
        parent::__construct();
        $this->res = array(
            "status" => 'error',
            "script" => NULL
        );
    }
    public function Load($file) {
        $this->res["status"] = 'success';
        $this->res["script"] = '<script src="' .
                $this->config["URL"] .
                $this->config["VIEWS"] .
                $this->config["ASSSET_PIC"] .
                $this->config["JSONS"] . $file . '.js" type="text/javascript"></script>';
        $this->baseview->setjsonData($this->res);
        echo $this->baseview->renderJson();
    }
    public function Index() {
        return json_encode($this->res);
    }
}
?>