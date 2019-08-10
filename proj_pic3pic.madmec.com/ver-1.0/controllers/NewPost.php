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
    public function getUserPost($param = false) {
        $this->baseview->setjsonData($this->NewPostMod->getUserPost($param));
        echo $this->baseview->renderJson();
    }
    public function listWallPost() {
        /* Set list Post */
        $this->NewPostMod->listWallPost();
        if (isset($_SESSION["ListNewPost"]) && count($_SESSION["ListNewPost"]) > 0) {
            $_SESSION["initial"] = 0;
            $_SESSION["final"] = 10;
            $this->baseview->setHTML('Wall', 'listPost.php');
            echo $this->baseview->RenderView(false);
        }
    }
    public function listUpdatedWallPost() {
        if (isset($this->postPara["para"]["where"])) {
            switch ($this->postPara["para"]["where"]) {
                case 'prepend': {
                        $this->NewPostMod->listWallPost();
                        if (!isset($_SESSION["initial"]))
                            $_SESSION["initial"] = 0;
                        if (!isset($_SESSION["final"]))
                            $_SESSION["final"] = 10;
                        if (isset($this->postPara["para"]["post_id"]))
                            $this->baseview->post_id = (integer) $this->postPara["para"]["post_id"];
                        else
                            $this->baseview->post_id = NULL;
                        if (isset($this->postPara["para"]["view"]))
                            $this->baseview->setHTML('Wall', 'viewIndividualPost.php');
                        else
                            $this->baseview->setHTML('Wall', 'listPost.php');
                        echo $this->baseview->RenderView(false);
                        if (isset($_SESSION["initial"]))
                            $_SESSION["initial"] ++;
                        break;
                    }
                default: {
                        if (isset($_SESSION["initial"]) && isset($_SESSION["final"])) {
                            if (isset($_SESSION["ListNewPost"]) && count($_SESSION["ListNewPost"]) > 0) {
                                if ($_SESSION["final"] >= count($_SESSION["ListNewPost"])) {
                                    unset($_SESSION["initial"]);
                                    unset($_SESSION["final"]);
                                    $this->baseview->setHTML('Wall', 'listEndPost.php');
                                    echo $this->baseview->RenderView(false);
                                } else {
                                    $_SESSION["initial"] = $_SESSION["final"];
                                    $_SESSION["final"] += 10;
                                    $this->baseview->setHTML('Wall', 'listPost.php');
                                    echo $this->baseview->RenderView(false);
                                }
                            }
                        }
                        break;
                    }
            }
        } else {
            $this->baseview->setHTML('Wall', 'listEndPost.php');
            echo $this->baseview->RenderView(false);
        }
    }
    public function listWallPostComment() {
        if (isset($_SESSION["ListNewPost"]) && count($_SESSION["ListNewPost"]) > 0) {
            $this->baseview->listPost = $this->NewPostMod->listWallPost();
            if (isset($this->postPara["para"]["pindex"]) && $this->postPara["para"]["pindex"] != NULL) {
                $this->baseview->ploop = (integer) $this->postPara["para"]["pindex"];
                if (isset($this->baseview->listPost[$this->baseview->ploop]["posts"]["pc_ct"]) &&
                        $this->baseview->listPost[$this->baseview->ploop]["posts"]["pc_ct"] != '') {
                    $this->baseview->commentNo = $this->baseview->listPost[$this->baseview->ploop]["posts"]["pc_ct"];
                }
            }
            if (isset($this->postPara["para"]["postID"]) && $this->postPara["para"]["postID"] != '' && $this->postPara["para"]["pindex"] == '') {
                $this->baseview->post_id = (integer) $this->postPara["para"]["postID"];
                for ($j = 0; $j < count($this->baseview->listPost); $j++) {
                    if ($this->baseview->post_id === (integer) $this->baseview->listPost[$j]["posts"]["id"]) {
                        $this->baseview->commentNo = $this->baseview->listPost[$j]["posts"]["pc_ct"];
                        break;
                    }
                }
            }
            $this->baseview->setHTML('Wall', 'listComment.php');
            echo $this->baseview->RenderView(false);
        }
    }
    public function listWallPostCommentReply() {
        if (isset($_SESSION["ListNewPost"]) && count($_SESSION["ListNewPost"]) > 0) {
            $this->baseview->listPost = $this->NewPostMod->listWallPost();
            if (isset($this->postPara["para"]["pindex"]) && $this->postPara["para"]["pindex"] != NULL && $this->postPara["para"]["pcindex"] != NULL) {
                $this->baseview->ploop = (integer) $this->postPara["para"]["pindex"];
                $this->baseview->pcloop = (integer) $this->postPara["para"]["pcindex"];
                if (isset($this->baseview->listPost[$this->baseview->ploop]["posts"]["comments"]["replys"]["pcr_ct"]) &&
                        $this->baseview->listPost[$this->baseview->ploop]["posts"]["comments"]["replys"]["pcr_ct"] != '') {
                    $this->baseview->commentNoReplies = $this->baseview->listPost[$this->baseview->ploop]["posts"]["comments"]["replys"]["pcr_ct"];
                }
            }
            if (isset($this->postPara["para"]["postComID"]) && $this->postPara["para"]["postComID"] != '' && $this->postPara["para"]["pindex"] == '' && $this->postPara["para"]["pcindex"] == '') {
                $this->baseview->post_comment_id = (integer) $this->postPara["para"]["postComID"];
                $flag = false;
                for ($j = 0; $j < count($this->baseview->listPost); $j++) {
                    for ($k = 0; $k < count($this->baseview->listPost[$j]["posts"]["comments"]["pc_id"]); $k++) {
                        if ($this->baseview->post_comment_id === (integer) $this->baseview->listPost[$j]["posts"]["comments"]["pc_id"][$k]) {
                            $this->baseview->commentNoReplies = $this->baseview->listPost[$j]["posts"]["comments"]["replys"]["pcr_ct"];
                            $flag = true;
                            break;
                        }
                    }
                    if ($flag) {
                        break;
                    }
                }
            }
            $this->baseview->setHTML('Wall', 'listReply.php');
            echo $this->baseview->RenderView(false);
        }
    }
    public function likePost($param = false) {
        $this->baseview->setjsonData($this->NewPostMod->likePost($param));
        echo $this->baseview->renderJson();
    }
    public function disLikePost($param = false) {
        $this->baseview->setjsonData($this->NewPostMod->disLikePost($param));
        echo $this->baseview->renderJson();
    }
    public function changePostPreferences($param = false) {
        $this->baseview->setjsonData($this->NewPostMod->changePostPreferences());
        echo $this->baseview->renderJson();
    }
    public function reportPost($param = false) {
        $this->baseview->setjsonData($this->NewPostMod->reportPost());
        echo $this->baseview->renderJson();
    }
    public function subscribeChannel($param = false) {
        $this->baseview->setjsonData($this->NewPostMod->subscribeChannel());
        echo $this->baseview->renderJson();
    }
    public function addComment($param = false) {
        $this->baseview->setjsonData($this->NewPostMod->addComment($param));
        echo $this->baseview->renderJson();
    }
    public function likePostComment($param = false) {
        $this->baseview->setjsonData($this->NewPostMod->likePostComment($param));
        echo $this->baseview->renderJson();
    }
    public function disLikePostComment($param = false) {
        $this->baseview->setjsonData($this->NewPostMod->disLikePostComment($param));
        echo $this->baseview->renderJson();
    }
    public function changePostCommentPreferences($param = false) {
        $this->baseview->setjsonData($this->NewPostMod->changePostCommentPreferences());
        echo $this->baseview->renderJson();
    }
    public function addCommentReply($param = false) {
        $this->baseview->setjsonData($this->NewPostMod->addCommentReply($param));
        echo $this->baseview->renderJson();
    }
    public function likePostCommentReply($param = false) {
        $this->baseview->setjsonData($this->NewPostMod->likePostCommentReply($param));
        echo $this->baseview->renderJson();
    }
    public function disLikePostCommentReply($param = false) {
        $this->baseview->setjsonData($this->NewPostMod->disLikePostCommentReply($param));
        echo $this->baseview->renderJson();
    }
    public function changePostCommentReplyPreferences($param = false) {
        $this->baseview->setjsonData($this->NewPostMod->changePostCommentReplyPreferences());
        echo $this->baseview->renderJson();
    }
}
?>