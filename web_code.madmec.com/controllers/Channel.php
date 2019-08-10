<?php
class Channel extends BaseController {

    private $para;
    private $ChannelMod;

    function __construct($para = false) {
        parent::__construct();
        $this->para = $para;
        $this->ChannelMod = new Channel_Model();
        $this->ChannelMod->setPostData($this->postPara);
    }
    public function Index() {
        $this->baseview->setHeader('channelHeader.php');
        $this->baseview->setBody('Channel');
        $this->baseview->setFooter('Footer.php');
        $this->baseview->RenderView(true);
    }
    public function CreateChannel() {
        $this->baseview->setjsonData($this->ChannelMod->CreateChannel());
        echo $this->baseview->renderJson();
    }
    public function ListChannels() {
        $this->baseview->setjsonData($this->ChannelMod->ListChannels());
        echo $this->baseview->renderJson();
    }
    public function getContinents() {
        $this->baseview->setjsonData($this->ChannelMod->ListContinents(isset($this->postPara['listtype']) ? $this->postPara['listtype'] : false));
        echo $this->baseview->renderJson();
    }
    public function getCountries() {
        $this->baseview->setjsonData($this->ChannelMod->ListCountries(isset($this->postPara['listtype']) ? $this->postPara['listtype'] : false));
        echo $this->baseview->renderJson();
    }
    public function getLanguages() {
        $this->baseview->setjsonData($this->ChannelMod->ListLanguages(isset($this->postPara['listtype']) ? $this->postPara['listtype'] : false));
        echo $this->baseview->renderJson();
    }
    public function View($id = false) {
        //$id = base64_decode($id);
        //$this->ChannelMod->View($id);
        //$this->baseview->setjsonData();
        $this->baseview->setHeader('channelHeader.php');
        $this->baseview->setBody('Channel');
        $this->baseview->setFooter('Footer.php');
        $this->baseview->RenderView(true);
    }
}
?>