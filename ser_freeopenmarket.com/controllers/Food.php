<?php

class Food extends BaseController {

    private $para, $logindata, $UserId, $FoodMod;

    function __construct($para = false) {
        parent::__construct();
        $this->gotoIndex();
        $this->para = $para;
        $this->PicController = new Picture();
        $this->FoodMod = new Food_Model();
        $this->FoodMod->setPostData($this->postPara);
        $this->FoodMod->setPostFile($this->postFile);
        if (isset($_SESSION["USERDATA"]["logindata"])) {
            $this->logindata = $_SESSION["USERDATA"]["logindata"];
            $this->UserId = $this->logindata["users_pk"];
            $this->baseview->UserDets = $this->logindata;
        }
    }

    public function Index() {
        $this->baseview->UserDets = $this->logindata;
        $this->baseview->title = 'Process Food Users Info';
        $this->baseview->setMenuFile($this->logindata["users_type_nav_menu_file"]);
        $this->baseview->setHeader($this->logindata["users_type_header_file"]);
        $this->baseview->setBody('Food');
        $this->baseview->setFooter('Footer.php');
        $this->baseview->RenderView(true);
    }

    public function AddFood() {
        
    }

    public function ListFood() {
        
    }

    public function SearchFood() {
        
    }

}

?>