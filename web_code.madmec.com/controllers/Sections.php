<?php
class Sections extends BaseController {

    private $para;
    private $ChannelMod, $GeoMod;

    function __construct($para = false) {
        parent::__construct();
        $this->para = $para;
        $this->SessionMod = new Sections_Model();
        $this->SessionMod->setPostData($this->postPara);
    }
    public function getSectionsNames() {
        $this->baseview->setjsonData($this->SessionMod->getSectionsNames($this->postPara['listtype']));
        echo $this->baseview->renderJson();
    }
}
?>