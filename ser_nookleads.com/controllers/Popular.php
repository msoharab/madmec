<?php
class Popular extends BaseController {
    private $para;
    private $PopularMod;
    function __construct($para = false) {
        parent::__construct();
        $this->para = $para;
        $this->PopularMod = new NewLead_Model();
        $this->PopularMod->setLeadData($this->postPara);
    }
    public function Index() {
        $this->baseview->setHeader('dealHeader.php');
        $this->baseview->setBody('Deal');
        $this->baseview->setFooter('Footer.php');
        $this->baseview->RenderView(true);
    }
    public function listDealLead() {
        /* Set list Lead */
        $this->PopularMod->listDealLead();
        if (isset($_SESSION["ListNewLead"]) && count($_SESSION["ListNewLead"]) > 0) {
            $_SESSION["initial"] = 0;
            $_SESSION["final"] = 10;
            $this->baseview->setHTML('Deal', 'listLead.php');
            echo $this->baseview->RenderView(false);
        }
    }
    public function listUpdatedDealLead() {
        if (isset($this->postPara["para"]["where"])) {
            switch ($this->postPara["para"]["where"]) {
                case 'prepend': {
                        $this->PopularMod->listDealLead();
                        $_SESSION["initial"] = 0;
                        $_SESSION["final"] = 10;
                        if (isset($this->postPara["para"]["lead_id"]))
                            $this->baseview->lead_id = (integer) $this->postPara["para"]["lead_id"];
                        else
                            $this->baseview->lead_id = NULL;
                        $this->baseview->setHTML('Deal', 'listLead.php');
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
                                    $this->baseview->setHTML('Deal', 'listEndLead.php');
                                    echo $this->baseview->RenderView(false);
                                } else {
                                    $_SESSION["initial"] = $_SESSION["final"];
                                    $_SESSION["final"] += 10;
                                    $this->baseview->setHTML('Deal', 'listLead.php');
                                    echo $this->baseview->RenderView(false);
                                }
                            }
                        }
                        break;
                    }
            }
        } else {
            $this->baseview->setHTML('Deal', 'listEndLead.php');
            echo $this->baseview->RenderView(false);
        }
    }
    public function listDealLeadQuotation() {
        if (isset($_SESSION["ListNewLead"]) && count($_SESSION["ListNewLead"]) > 0) {
            $this->baseview->listLead = $this->PopularMod->listDealLead();
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
            $this->baseview->setHTML('Deal', 'listQuotation.php');
            echo $this->baseview->RenderView(false);
        }
    }
    public function listDealLeadQuotationWo() {
        if (isset($_SESSION["ListNewLead"]) && count($_SESSION["ListNewLead"]) > 0) {
            $this->baseview->listLead = $this->PopularMod->listDealLead();
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
            $this->baseview->setHTML('Deal', 'listWo.php');
            echo $this->baseview->RenderView(false);
        }
    }
    public function approvalLead($param = false) {
        $this->baseview->setjsonData($this->PopularMod->approvalLead($param));
        echo $this->baseview->renderJson();
    }
    public function disApprovalLead($param = false) {
        $this->baseview->setjsonData($this->PopularMod->disApprovalLead($param));
        echo $this->baseview->renderJson();
    }
    public function changeLeadPreferences($param = false) {
        $this->baseview->setjsonData($this->PopularMod->changeLeadPreferences());
        echo $this->baseview->renderJson();
    }
    public function reportLead($param = false) {
        $this->baseview->setjsonData($this->PopularMod->reportLead());
        echo $this->baseview->renderJson();
    }
    public function subscribeBusiness($param = false) {
        $this->baseview->setjsonData($this->PopularMod->subscribeBusiness());
        echo $this->baseview->renderJson();
    }
    public function addQuotation($param = false) {
        $this->baseview->setjsonData($this->PopularMod->addQuotation($param));
        echo $this->baseview->renderJson();
    }
    public function approvalLeadQuotation($param = false) {
        $this->baseview->setjsonData($this->PopularMod->approvalLeadQuotation($param));
        echo $this->baseview->renderJson();
    }
    public function disApprovalLeadQuotation($param = false) {
        $this->baseview->setjsonData($this->PopularMod->disApprovalLeadQuotation($param));
        echo $this->baseview->renderJson();
    }
    public function changeLeadQuotationPreferences($param = false) {
        $this->baseview->setjsonData($this->PopularMod->changeLeadQuotationPreferences());
        echo $this->baseview->renderJson();
    }
    public function addQuotationWo($param = false) {
        $this->baseview->setjsonData($this->PopularMod->addQuotationWo($param));
        echo $this->baseview->renderJson();
    }
    public function approvalLeadQuotationWo($param = false) {
        $this->baseview->setjsonData($this->PopularMod->approvalLeadQuotationWo($param));
        echo $this->baseview->renderJson();
    }
    public function disApprovalLeadQuotationWo($param = false) {
        $this->baseview->setjsonData($this->PopularMod->disApprovalLeadQuotationWo($param));
        echo $this->baseview->renderJson();
    }
    public function changeLeadQuotationWoPreferences($param = false) {
        $this->baseview->setjsonData($this->PopularMod->changeLeadQuotationWoPreferences());
        echo $this->baseview->renderJson();
    }
}
?>