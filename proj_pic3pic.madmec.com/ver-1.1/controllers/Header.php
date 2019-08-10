<?php
class Header extends BaseController {

    private $para;
    private $HeaderMod;

    function __construct($para = false) {
        parent::__construct();
        $this->para = $para;
        $this->HeaderMod = new Header_Model();
        $this->HeaderMod->setPostData($this->postPara);
    }
    public function Index() {
        $this->baseview->setHeader('channelHeader.php');
        $this->baseview->setBody('Channel');
        $this->baseview->setFooter('Footer.php');
        $this->baseview->RenderView(true);
    }
    public function getContinents() {
        $this->baseview->setjsonData($this->HeaderMod->ListContinents(isset($this->postPara['listtype']) ? $this->postPara['listtype'] : false));
        echo $this->baseview->renderJson();
    }
    public function getCountries() {
        $this->baseview->setjsonData($this->HeaderMod->ListCountries(isset($this->postPara['listtype']) ? $this->postPara['listtype'] : false));
        echo $this->baseview->renderJson();
    }
    public function getLanguages() {
        $this->baseview->setjsonData($this->HeaderMod->ListLanguages(isset($this->postPara['listtype']) ? $this->postPara['listtype'] : false));
        echo $this->baseview->renderJson();
    }
    public function getSectionsNames() {
        $this->baseview->setjsonData($this->HeaderMod->getSectionsNames($this->postPara['listtype']));
        echo $this->baseview->renderJson();
    }
}
?>