<?php
class profile_ids {

    private $profile_ids;

    public function __construct($config) {

        $this->profile_ids = array(
            "pic" => array(
                "parentDiv" => "changeProfilePicDiv",
                "parentBut" => "changeProfilePic",
                "form" => "proIMGForm",
                "postImg" => "proIMGID",
                "proIMGName" => "file",
                "picedit" => false,
                "ajaxForm" => false,
                "close" => "Poclose",
                "create" => "PoCreateButton",
                "autoloader" => true,
                "action" => "fetchSections",
                "type" => "POST",
                "dataType" => "JSON",
                "url" => $config["URL"] . $config["CTRL_5"] . "ProfilePic",
                "defaultImage" => $config["URL"] . $config["VIEWS"] . $config["ASSSET_IMG"] . "photo1.jpg",
            ),
            "backgroud" => array(
                "parentDiv" => "changeProfileBGDiv",
                "parentBut" => "changeProfileBG",
                "form" => "proBgIMGForm",
                "postImg" => "proBgIMGID",
                "proIMGName" => "file",
                "picedit" => false,
                "ajaxForm" => false,
                "close" => "PoBgclose",
                "create" => "PoBgCreateButton",
                "autoloader" => true,
                "action" => "fetchSections",
                "type" => "POST",
                "dataType" => "JSON",
                "url" => $config["URL"] . $config["CTRL_5"] . "ProfileBG",
                "defaultImage" => $config["URL"] . $config["VIEWS"] . $config["ASSSET_IMG"] . "photo1.jpg",
            ),
        );
    }
    public function getIds() {
        return $this->profile_ids;
    }
}
?>