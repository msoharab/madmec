<?php
class Index extends BaseController {
    private $para, $IndexLeadMod;
    function __construct($para = false) {
        parent::__construct();
        $this->para = $para;
        $this->IndexLeadMod = new Index_Model();
        $this->IndexLeadMod->setLeadData($this->postPara);
        $this->gotoDeal();
    }
    public function Index() {
        $this->baseview->setHeader('Header.php');
        $this->baseview->setBody('Index');
        $this->baseview->setFooter('Footer.php');
        $this->baseview->RenderView(true);
    }
    public function Popular() {
    }
    public function New_() {
    }
    public function filterListLead() {
        $this->IndexLeadMod->filterListLead();
        if (isset($_SESSION["ListNewLead"]) && count($_SESSION["ListNewLead"]) > 0) {
            $_SESSION["initial"] = 0;
            $_SESSION["final"] = 10;
            $this->baseview->setHTML('Index', 'listLead.php');
            echo $this->baseview->RenderView(false);
        } else {
            $this->baseview->setHTML('Index', 'listEndLead.php');
            echo $this->baseview->RenderView(false);
        }
    }
    public function listDealLead() {
        /* Set list Lead */
        $this->IndexLeadMod->listDealLead();
        if (isset($_SESSION["ListNewLead"]) && count($_SESSION["ListNewLead"]) > 0) {
            $_SESSION["initial"] = 0;
            $_SESSION["final"] = 10;
            $this->baseview->setHTML('Index', 'listLead.php');
            echo $this->baseview->RenderView(false);
        } else {
            $this->baseview->setHTML('Business', 'listEndLead.php');
            echo $this->baseview->RenderView(false);
        }
    }
    public function listUpdatedDealLead() {
        if (isset($this->postPara["para"]["where"])) {
            switch ($this->postPara["para"]["where"]) {
                case 'prepend': {
                        $this->IndexLeadMod->listDealLead();
                        $_SESSION["initial"] = 0;
                        $_SESSION["final"] = 10;
                        if (isset($this->postPara["para"]["lead_id"]))
                            $this->baseview->lead_id = (integer) $this->postPara["para"]["lead_id"];
                        else
                            $this->baseview->lead_id = NULL;
                        $this->baseview->setHTML('Index', 'listLead.php');
                        echo $this->baseview->RenderView(false);
                        $_SESSION["initial"] ++;
                        break;
                    }
                default: {
                        if (isset($_SESSION["initial"]) && isset($_SESSION["final"])) {
                            if (isset($_SESSION["ListNewLead"]) && count($_SESSION["ListNewLead"]) > 0) {
                                if ($_SESSION["final"] >= count($_SESSION["ListNewLead"])) {
                                    unset($_SESSION["initial"]);
                                    unset($_SESSION["final"]);
                                    $this->baseview->setHTML('Index', 'listEndLead.php');
                                    echo $this->baseview->RenderView(false);
                                } else {
                                    $_SESSION["initial"] = $_SESSION["final"];
                                    $_SESSION["final"] += 10;
                                    $this->baseview->setHTML('Index', 'listLead.php');
                                    echo $this->baseview->RenderView(false);
                                }
                            }
                        }
                        break;
                    }
            }
        } else {
            $this->baseview->setHTML('Index', 'listEndLead.php');
            echo $this->baseview->RenderView(false);
        }
    }
    public function listDealLeadQuotation() {
        if (isset($_SESSION["ListNewLead"]) && count($_SESSION["ListNewLead"]) > 0) {
            $this->baseview->listLead = $this->IndexLeadMod->listDealLead();
            if (isset($this->postPara["para"]["pindex"]) && $this->postPara["para"]["pindex"] != NULL) {
                $this->baseview->ploop = (integer) $this->postPara["para"]["pindex"];
                if (isset($this->baseview->listLead[$this->baseview->ploop]["leads"]["pc_ct"]) &&
                        $this->baseview->listLead[$this->baseview->ploop]["leads"]["pc_ct"] != '') {
                    $this->baseview->quotationNo = $this->baseview->listLead[$this->baseview->ploop]["leads"]["pc_ct"];
                }
            }
            if (isset($this->postPara["para"]["leadID"]) && $this->postPara["para"]["leadID"] != '' && $this->postPara["para"]["pindex"] == '') {
                $this->baseview->lead_id = (integer) $this->postPara["para"]["leadID"];
                for ($j = 0; $j < count($this->baseview->listLead); $j++) {
                    if ($this->baseview->lead_id === (integer) $this->baseview->listLead[$j]["leads"]["id"]) {
                        $this->baseview->quotationNo = $this->baseview->listLead[$j]["leads"]["pc_ct"];
                        break;
                    }
                }
            }
            $this->baseview->setHTML('Index', 'listQuotation.php');
            echo $this->baseview->RenderView(false);
        }
    }
    public function listDealLeadQuotationWo() {
        if (isset($_SESSION["ListNewLead"]) && count($_SESSION["ListNewLead"]) > 0) {
            $this->baseview->listLead = $this->IndexLeadMod->listDealLead();
            if (isset($this->postPara["para"]["pindex"]) && $this->postPara["para"]["pindex"] != NULL && $this->postPara["para"]["pcindex"] != NULL) {
                $this->baseview->ploop = (integer) $this->postPara["para"]["pindex"];
                $this->baseview->pcloop = (integer) $this->postPara["para"]["pcindex"];
                if (isset($this->baseview->listLead[$this->baseview->ploop]["leads"]["quotations"]["wos"]["pcr_ct"]) &&
                        $this->baseview->listLead[$this->baseview->ploop]["leads"]["quotations"]["wos"]["pcr_ct"] != '') {
                    $this->baseview->quotationNoWo = $this->baseview->listLead[$this->baseview->ploop]["leads"]["quotations"]["wos"]["pcr_ct"];
                }
            }
            if (isset($this->postPara["para"]["leadComID"]) && $this->postPara["para"]["leadComID"] != '' && $this->postPara["para"]["pindex"] == '' && $this->postPara["para"]["pcindex"] == '') {
                $this->baseview->lead_quotation_id = (integer) $this->postPara["para"]["leadComID"];
                $flag = false;
                for ($j = 0; $j < count($this->baseview->listLead); $j++) {
                    for ($k = 0; $k < count($this->baseview->listLead[$j]["leads"]["quotations"]["pc_id"]); $k++) {
                        if ($this->baseview->lead_quotation_id === (integer) $this->baseview->listLead[$j]["leads"]["quotations"]["pc_id"][$k]) {
                            $this->baseview->quotationNoWo = $this->baseview->listLead[$j]["leads"]["quotations"]["wos"]["pcr_ct"];
                            $flag = true;
                            break;
                        }
                    }
                    if ($flag) {
                        break;
                    }
                }
            }
            $this->baseview->setHTML('Index', 'listWo.php');
            echo $this->baseview->RenderView(false);
        }
    }
}
?>