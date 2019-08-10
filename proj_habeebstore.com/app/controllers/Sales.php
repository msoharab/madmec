<?php

class Sales extends BaseController {

    private $para, $SaleMod, $logindata, $UserId;

    function __construct($para = false) {
        parent::__construct();
		$this->gotoIndex();
        $this->para = $para;
        $this->SaleMod = new Sales_Model();
        $this->SaleMod->setPostData($this->postPara);
        $this->SaleMod->setPostFile($this->postFile);
        $this->logindata = $_SESSION["USERDATA"]["logindata"];
        $this->UserId = $this->logindata["id"];
    }

    public function Index() {
        $this->baseview->title = 'HabeebShop Dashboard  | Sales ';
        $this->baseview->setMenuFile('MMAdminLeftNavMenu.php');
        $this->baseview->setHeader('MMAdminHeader.php');
        $this->baseview->setBody('Sales');
        $this->baseview->setFooter('Footer.php');
        $this->baseview->RenderView(true);
    }

    public function BillGenerate() {
       $this->baseview->setjsonData($this->SaleMod->BillGenerate());
        echo $this->baseview->renderJson();
    }

    public function AddProductKg() {
        $this->baseview->setjsonData($this->SaleMod->AddProductKg());
        echo $this->baseview->renderJson();
    }

    public function AddProductUnit() {
        $this->baseview->setjsonData($this->SaleMod->AddProductUnit());
        echo $this->baseview->renderJson();
    }

    public function ProductSearch() {
        $this->baseview->setjsonData($this->SaleMod->ProductSearch());
        echo $this->baseview->renderJson();
    }

    public function SaleList() {
        $this->baseview->setjsonData($this->SaleMod->SaleList());
        echo $this->baseview->renderJson();
    }

    public function DeleteProduct() {
        $uid = base64_decode($this->postPara["fopid"]);
        $stat = $this->postPara["stat"];
        $this->baseview->jsonData = $this->SaleMod->DeleteProduct($uid, $stat);
        $this->baseview->setjsonData($this->baseview->jsonData);
        echo $this->baseview->renderJson();
    }

    public function Bill() {
        $this->baseview->title = 'HabeebShop Dashboard  | Sales ';
        $this->baseview->setMenuFile('MMAdminLeftNavMenu.php');
        $this->baseview->setHeader('MMAdminHeader.php');
        $this->baseview->setHTML('Sales', 'bill.php');
        $this->baseview->setFooter('Footer.php');
        $this->baseview->RenderView(true);
    }

}

?>
