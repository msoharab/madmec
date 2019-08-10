<?php
class Index extends BaseController {

    private $para,$IndexPostMod;

    function __construct($para = false) {
        parent::__construct();
        $this->para = $para;
        $this->IndexPostMod = new Index_Model();
        $this->gotoWall();
    }
    public function Index() {
        $this->baseview->setHeader('Header.php');
        $this->baseview->setBody('Index');
        $this->baseview->setFooter('Footer.php');
        $this->baseview->RenderView(true);
    }
    public function listWallPost() {
        /* Set list Post */
        $this->IndexPostMod->listWallPost();
        if (isset($_SESSION["ListNewPost"]) && count($_SESSION["ListNewPost"]) > 0) {
            $_SESSION["initial"] = 0;
            $_SESSION["final"] = 10;
            $this->baseview->setHTML('Index', 'listPost.php');
            echo $this->baseview->RenderView(false);
        }
    }
    public function listUpdatedWallPost() {
        if (isset($this->postPara["para"]["where"])) {
            switch ($this->postPara["para"]["where"]) {
                case 'prepend': {
                        $this->IndexPostMod->listWallPost();
                        $_SESSION["initial"] = 0;
                        $_SESSION["final"] = 10;
                        if (isset($this->postPara["para"]["post_id"]))
                            $this->baseview->post_id = (integer) $this->postPara["para"]["post_id"];
                        else
                            $this->baseview->post_id = NULL;
                        $this->baseview->setHTML('Index', 'listPost.php');
                        echo $this->baseview->RenderView(false);
                        $_SESSION["initial"] ++;
                        break;
                    }
                default: {
                        if (isset($_SESSION["initial"]) && isset($_SESSION["final"])) {
                            if (isset($_SESSION["ListNewPost"]) && count($_SESSION["ListNewPost"]) > 0) {
                                if ($_SESSION["final"] >= count($_SESSION["ListNewPost"])) {
                                    unset($_SESSION["initial"]);
                                    unset($_SESSION["final"]);
                                    $this->baseview->setHTML('Index', 'listEndPost.php');
                                    echo $this->baseview->RenderView(false);
                                } else {
                                    $_SESSION["initial"] = $_SESSION["final"];
                                    $_SESSION["final"] += 10;
                                    $this->baseview->setHTML('Index', 'listPost.php');
                                    echo $this->baseview->RenderView(false);
                                }
                            }
                        }
                        break;
                    }
            }
        } else {
            $this->baseview->setHTML('Index', 'listEndPost.php');
            echo $this->baseview->RenderView(false);
        }
    }
    public function listWallPostComment() {
        if (isset($_SESSION["ListNewPost"]) && count($_SESSION["ListNewPost"]) > 0) {
            $this->baseview->listPost = $this->IndexPostMod->listWallPost();
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
            $this->baseview->setHTML('Index', 'listComment.php');
            echo $this->baseview->RenderView(false);
        }
    }
    public function listWallPostCommentReply() {
        if (isset($_SESSION["ListNewPost"]) && count($_SESSION["ListNewPost"]) > 0) {
            $this->baseview->listPost = $this->IndexPostMod->listWallPost();
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
            $this->baseview->setHTML('Index', 'listReply.php');
            echo $this->baseview->RenderView(false);
        }
    }
}
?>