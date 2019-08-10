<?php

class Stock extends BaseController {

    private $para, $StockMod, $logindata, $UserId;

    function __construct($para = false) {
        parent::__construct();
		$this->gotoIndex();
        $this->para = $para;
        $this->StockMod = new Stock_Model();
        $this->StockMod->setPostData($this->postPara);
        $this->StockMod->setPostFile($this->postFile);
        $this->logindata = $_SESSION["USERDATA"]["logindata"];
        $this->UserId = $this->logindata["id"];
    }

    public function Index() {
        $this->baseview->title = 'HabeebShop | Stock ';
        $this->baseview->setMenuFile('MMAdminLeftNavMenu.php');
        $this->baseview->setHeader('MMAdminHeader.php');
        $this->baseview->setBody('Stock');
        $this->baseview->setFooter('Footer.php');
        $this->baseview->RenderView(true);
    }

    public function ProductEdit($id = false) {
        $this->baseview->UserDets = $this->logindata;
        $this->baseview->title = 'HabeebShop | Edit Stock';
        $this->baseview->setMenuFile('MMAdminLeftNavMenu.php');
        $this->baseview->setHeader('MMAdminHeader.php');
        if ($id) {
            $uid = base64_decode($id);
            $this->baseview->getuserDet = $this->StockMod->getProduct($uid);
            $this->baseview->setHTML('Stock', 'Edit_Product.php');
        } else {
            $this->baseview->setHTML('Error', 'error.php');
        }
        $this->baseview->setFooter('Footer.php');
        $this->baseview->RenderView(true);
    }

    public function AddProduct() {
        $this->baseview->setjsonData($this->StockMod->AddProducts());
        echo $this->baseview->renderJson();
    }

    public function ListProducts() {
        $this->baseview->setjsonData($this->StockMod->ListProducts());
        echo $this->baseview->renderJson();
    }

    public function EditProduct() {
        $this->baseview->setjsonData($this->StockMod->EditProduct());
        echo $this->baseview->renderJson();
    }

    public function DeleteProduct() {
        $uid = isset($this->postPara["id"]) ? $this->postPara["id"] : 0;
        $this->baseview->jsonData = $this->StockMod->DeleteProduct($uid);
        $this->baseview->setjsonData($this->baseview->jsonData);
        echo $this->baseview->renderJson();
    }

}

?>
