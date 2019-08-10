<?php
class NewPost extends BaseController {

    private $para;
    private $NewPostMod;

    function __construct($para = false) {
        parent::__construct();
        $this->para = $para;
        $this->NewPostMod = new NewPost_Model();
        $this->NewPostMod->setPostData($this->postPara);
    }
    public function Index() {
        $this->baseview->setHeader('wallHeader.php');
        $this->baseview->setBody('Wall');
        $this->baseview->setFooter('Footer.php');
        $this->baseview->RenderView(true);
    }
    public function CreateNew_Post() {
        $this->baseview->setjsonData($this->NewPostMod->CreateNew_Post());
        echo $this->baseview->renderJson();
    }
    public function getContinents() {
        $this->baseview->setjsonData($this->NewPostMod->ListContinents(isset($this->postPara['listtype']) ? $this->postPara['listtype'] : false));
        echo $this->baseview->renderJson();
    }
    public function getCountries() {
        $this->baseview->setjsonData($this->NewPostMod->ListCountries(isset($this->postPara['listtype']) ? $this->postPara['listtype'] : false));
        echo $this->baseview->renderJson();
    }
    public function getLanguages() {
        $this->baseview->setjsonData($this->NewPostMod->ListLanguages(isset($this->postPara['listtype']) ? $this->postPara['listtype'] : false));
        echo $this->baseview->renderJson();
    }
    public function getSectionsNames() {
        $this->baseview->setjsonData($this->NewPostMod->getSectionsNames($this->postPara['listtype']));
        echo $this->baseview->renderJson();
    }
    public function listWallPost() {
        /* Set list Post */
        $this->NewPostMod->listWallPost();
        if (isset($_SESSION["ListNewPost"]) && sizeof($_SESSION["ListNewPost"]) > 0) {
            $_SESSION["initial"] = 0;
            $_SESSION["final"] = 10;
            $this->baseview->setHTML('Wall', 'listPost.php');
            echo $this->baseview->RenderView(false);
        } else {
            $this->baseview->setHTML('Wall', 'listPost.php');
            echo $this->baseview->RenderView(false);
        }
    }
    public function listUpdatedWallPost() {
        /* Set list Post */
        if (isset($_SESSION["initial"]) && isset($_SESSION["final"])) {
            if (isset($_SESSION["ListNewPost"]) && sizeof($_SESSION["ListNewPost"]) > 0) {
                if ($_SESSION["final"] >= sizeof($_SESSION["ListNewPost"])) {
                    unset($_SESSION["initial"]);
                    unset($_SESSION["final"]);
                } else {
                    $_SESSION["initial"] = $_SESSION["final"];
                    $_SESSION["final"] += 10;
                    $this->baseview->setHTML('Wall', 'listPost.php');
                    echo $this->baseview->RenderView(false);
                }
            }
        }
    }
}
?>