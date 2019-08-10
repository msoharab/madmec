<?php
class Channel extends BaseController {

    private $para;
    private $ChannelMod,$UserId;

    function __construct($para = false) {
        parent::__construct();
        $this->para = $para;
        $this->ChannelMod = new Channel_Model();
        $this->ChannelMod->setPostData($this->postPara);
        $this->UserId = (integer) isset($_SESSION["USERDATA"]["logindata"]["id"]) ?
                $_SESSION["USERDATA"]["logindata"]["id"] :
                0;
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
    public function ListAdminChannels() {
        $this->baseview->setjsonData($this->ChannelMod->ListAdminChannels());
        echo $this->baseview->renderJson();
    }
    public function ListSubscribeChannels() {
        $this->baseview->setjsonData($this->ChannelMod->ListSubscribeChannels());
        echo $this->baseview->renderJson();
    }
    public function searchChannels() {
        $this->baseview->setjsonData($this->ChannelMod->searchChannels());
        echo $this->baseview->renderJson();
    }
    public function CreateNew_Post($param = false) {
        if ($param && is_string($param)) {
            $this->baseview->setjsonData($this->ChannelMod->CreateNew_Post($param));
            echo $this->baseview->renderJson();
        }
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
    public function getSectionsNames() {
        $this->baseview->setjsonData($this->ChannelMod->getSectionsNames($this->postPara['listtype']));
        echo $this->baseview->renderJson();
    }
    public function listWallPost($id = false) {
        if ($id && is_string($id)) {
            /* Set list Post */
            $this->ChannelMod->ChannelId = (integer) $id;
            $this->ChannelMod->listWallPost();
            if (isset($_SESSION["ListNewPost"])) {
                $_SESSION["initial"] = 0;
                $_SESSION["final"] = 10;
                $this->baseview->setHTML('Channel', 'listPost.php');
                echo $this->baseview->RenderView(false);
            }
        }
    }
    public function listUpdatedWallPost($id = false) {
        if ($id && is_string($id)) {
            /* Set list Post */
            $this->ChannelMod->ChannelId = (integer) $id;
            if (isset($this->postPara["para"]["where"])) {
                switch ($this->postPara["para"]["where"]) {
                    case 'prepend': {
                            $this->ChannelMod->listWallPost();
                            $_SESSION["initial"] = 0;
                            $_SESSION["final"] = 10;
                            if (isset($this->postPara["para"]["post_id"]))
                                $this->baseview->post_id = (integer) $this->postPara["para"]["post_id"];
                            else
                                $this->baseview->post_id = NULL;
                            $this->baseview->setHTML('Channel', 'listPost.php');
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
                                        $this->baseview->setHTML('Channel', 'listEndPost.php');
                                        echo $this->baseview->RenderView(false);
                                    } else {
                                        $_SESSION["initial"] = $_SESSION["final"];
                                        $_SESSION["final"] += 10;
                                        $this->baseview->setHTML('Channel', 'listPost.php');
                                        echo $this->baseview->RenderView(false);
                                    }
                                }
                            }
                            break;
                        }
                }
            } else {
                $this->baseview->setHTML('Channel', 'listEndPost.php');
                echo $this->baseview->RenderView(false);
            }
        }
    }
    public function listWallPostComment() {
        if (isset($_SESSION["ListNewPost"]) && count($_SESSION["ListNewPost"]) > 0) {
            $this->baseview->listPost = $this->ChannelMod->listWallPost();
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
            $this->baseview->setHTML('Channel', 'listComment.php');
            echo $this->baseview->RenderView(false);
        }
    }
    public function listWallPostCommentReply() {
        if (isset($_SESSION["ListNewPost"]) && count($_SESSION["ListNewPost"]) > 0) {
            $this->baseview->listPost = $this->ChannelMod->listWallPost();
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
            $this->baseview->setHTML('Channel', 'listReply.php');
            echo $this->baseview->RenderView(false);
        }
    }
    public function likePost($param = false) {
        $this->baseview->setjsonData($this->ChannelMod->likePost($param));
        echo $this->baseview->renderJson();
    }
    public function disLikePost($param = false) {
        $this->baseview->setjsonData($this->ChannelMod->disLikePost($param));
        echo $this->baseview->renderJson();
    }
    public function changePostPreferences($param = false) {
        $this->baseview->setjsonData($this->ChannelMod->changePostPreferences());
        echo $this->baseview->renderJson();
    }
    public function reportPost($param = false) {
        $this->baseview->setjsonData($this->ChannelMod->reportPost());
        echo $this->baseview->renderJson();
    }
    public function addComment($param = false) {
        $this->baseview->setjsonData($this->ChannelMod->addComment($param));
        echo $this->baseview->renderJson();
    }
    public function likePostComment($param = false) {
        $this->baseview->setjsonData($this->ChannelMod->likePostComment($param));
        echo $this->baseview->renderJson();
    }
    public function disLikePostComment($param = false) {
        $this->baseview->setjsonData($this->ChannelMod->disLikePostComment($param));
        echo $this->baseview->renderJson();
    }
    public function changePostCommentPreferences($param = false) {
        $this->baseview->setjsonData($this->ChannelMod->changePostCommentPreferences());
        echo $this->baseview->renderJson();
    }
    public function addCommentReply($param = false) {
        $this->baseview->setjsonData($this->ChannelMod->addCommentReply($param));
        echo $this->baseview->renderJson();
    }
    public function likePostCommentReply($param = false) {
        $this->baseview->setjsonData($this->ChannelMod->likePostCommentReply($param));
        echo $this->baseview->renderJson();
    }
    public function disLikePostCommentReply($param = false) {
        $this->baseview->setjsonData($this->ChannelMod->disLikePostCommentReply($param));
        echo $this->baseview->renderJson();
    }
    public function changePostCommentReplyPreferences($param = false) {
        $this->baseview->setjsonData($this->ChannelMod->changePostCommentReplyPreferences());
        echo $this->baseview->renderJson();
    }
    public function getChannelAdmins($param = false) {
        if ($param && is_string($param)) {
            $this->ChannelMod->ChannelId = (integer) $param;
            $this->baseview->setjsonData($this->ChannelMod->ListUsers(isset($this->postPara['listtype']) ? $this->postPara['listtype'] : false));
            echo $this->baseview->renderJson();
        }
    }
    public function View($id = false) {
        if ($id && is_string($id)) {
            $_SESSION["CHANNEL_ID"] = (integer) base64_decode($id);
            $this->ChannelId = $_SESSION["CHANNEL_ID"];
            $this->ChannelDetails = (array) $this->ChannelMod->getChannelDetails($_SESSION["CHANNEL_ID"]);
            $this->baseview->UserId = $this->UserId;
            $this->baseview->ChannelId = $this->ChannelId;
            $this->baseview->ChannelDetails = $this->ChannelDetails;
            $this->ChannelMod->ChannelId = $this->ChannelId;
            $this->ChannelMod->ChannelDetails = $this->ChannelDetails;
            $this->Index();
        } else {
            $this->gotoWall();
        }
    }
    public function fetchMessages($id = false) {
        if ($id && is_string($id)) {
            $this->ChannelMod->ChannelId = (integer) $id;
            $this->baseview->UserId = $this->UserId;
            $this->baseview->ChannelId = $this->ChannelId;
            $this->baseview->ChannelDetails = $this->ChannelMod->getChannelDetails($id);
            $this->baseview->setHTML('Channel', 'channelMessage.php');
            echo $this->baseview->RenderView(false);
        }
    }
    public function sendMessage($id = false) {
        if ($id && is_string($id)) {
            $this->ChannelMod->ChannelId = (integer) $id;
            $this->baseview->setjsonData($this->ChannelMod->sendMessage());
            echo $this->baseview->renderJson();
        }
    }
    public function removeAdmin($id = false) {
        if ($id && is_string($id)) {
            $this->ChannelMod->ChannelId = (integer) $id;
            $this->baseview->setjsonData($this->ChannelMod->removeAdmin());
            echo $this->baseview->renderJson();
        }
    }
    public function updateChannelBG($id = false) {
        if ($id && is_string($id)) {
            $this->ChannelMod->ChannelId = (integer) $id;
            $this->baseview->setjsonData($this->ChannelMod->ChannelBG());
            echo $this->baseview->renderJson();
        }
    }
    public function updateChannelIcon($id = false) {
        if ($id && is_string($id)) {
            $this->ChannelMod->ChannelId = (integer) $id;
            $this->baseview->setjsonData($this->ChannelMod->ChannelIcon());
            echo $this->baseview->renderJson();
        }
    }
    public function ReportChannel() {
        $this->baseview->setjsonData($this->ChannelMod->ReportChannel());
        echo $this->baseview->renderJson();
    }
    public function subscribeChannel($param = false) {
        if ($param && is_string($param)) {
            $this->ChannelMod->ChannelId = (integer) $param;
            $this->baseview->setjsonData($this->ChannelMod->subscribeChannel($param));
            echo $this->baseview->renderJson();
        }
    }
    public function BlockChannel($param = false) {
        if ($param && is_string($param)) {
            $this->ChannelMod->ChannelId = (integer) $param;
            $this->baseview->setjsonData($this->ChannelMod->BlockChannel($param));
            echo $this->baseview->renderJson();
        }
    }
    public function likeChannel($param = false) {
        if ($param && is_string($param)) {
            $this->ChannelMod->ChannelId = (integer) $param;
            $this->baseview->setjsonData($this->ChannelMod->likeChannel($param));
            echo $this->baseview->renderJson();
        }
    }
    public function disLikeChannel($param = false) {
        if ($param && is_string($param)) {
            $this->ChannelMod->ChannelId = (integer) $param;
            $this->baseview->setjsonData($this->ChannelMod->disLikeChannel($param));
            echo $this->baseview->renderJson();
        }
    }
    public function UpdateChannelDetails($param = false) {
        if ($param && is_string($param)) {
            $this->ChannelMod->ChannelId = (integer) $param;
            $this->baseview->setjsonData($this->ChannelMod->UpdateChannelDetails());
            echo $this->baseview->renderJson();
        }
    }
    public function shareChannel($param = false) {
        if ($param && is_string($param)) {
            $this->ChannelMod->ChannelId = (integer) $param;
            $this->baseview->setjsonData($this->ChannelMod->shareChannel($param));
            echo $this->baseview->renderJson();
        }
    }
}
?>