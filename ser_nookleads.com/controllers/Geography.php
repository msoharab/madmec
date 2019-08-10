<?php
class Geography extends BaseController {
    private $para;
    private $GeoMod;
    function __construct() {
        parent::__construct();
        $this->BusinessMod = new Business_Model();
        $this->GeoMod = new Geography_Model($this->postPara);
        $this->GeoMod->setLeadData($this->postPara);
    }
    public function Index() {
    }
    public function getContinents() {
        $this->baseview->setjsonData($this->GeoMod->ListContinents(isset($this->postPara['listtype']) ? $this->postPara['listtype'] : false));
        echo $this->baseview->renderJson();
    }
    public function getCountries() {
        $this->baseview->setjsonData($this->GeoMod->ListCountries(isset($this->postPara['listtype']) ? $this->postPara['listtype'] : false));
        echo $this->baseview->renderJson();
    }
    public function getLanguages() {
        $this->baseview->setjsonData($this->GeoMod->ListLanguages(isset($this->postPara['listtype']) ? $this->postPara['listtype'] : false));
        echo $this->baseview->renderJson();
    }
}
?>