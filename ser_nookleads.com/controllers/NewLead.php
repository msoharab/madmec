<?php
class NewLead extends BaseController {
    private $para;
    private $NewLeadMod;
    function __construct($para = false) {
        parent::__construct();
        $this->para = $para;
        $this->NewLeadMod = new NewLead_Model();
        $this->NewLeadMod->setLeadData($this->postPara);
    }
    public function Index() {
        $this->baseview->setHeader('dealHeader.php');
        $this->baseview->setBody('Deal');
        $this->baseview->setFooter('Footer.php');
        $this->baseview->RenderView(true);
    }
    public function CreateNew_Lead() {
        $this->baseview->setjsonData($this->NewLeadMod->CreateNew_Lead());
        echo $this->baseview->renderJson();
    }
    public function getContinents() {
        $this->baseview->setjsonData($this->NewLeadMod->ListContinents(isset($this->postPara['listtype']) ? $this->postPara['listtype'] : false));
        echo $this->baseview->renderJson();
    }
    public function getCountries() {
        $this->baseview->setjsonData($this->NewLeadMod->ListCountries(isset($this->postPara['listtype']) ? $this->postPara['listtype'] : false));
        echo $this->baseview->renderJson();
    }
    public function getLanguages() {
        $this->baseview->setjsonData($this->NewLeadMod->ListLanguages(isset($this->postPara['listtype']) ? $this->postPara['listtype'] : false));
        echo $this->baseview->renderJson();
    }
    public function getSectionsNames() {
        $this->baseview->setjsonData($this->NewLeadMod->getSectionsNames($this->postPara['listtype']));
        echo $this->baseview->renderJson();
    }
    public function getUserLead($param = false) {
        $this->baseview->setjsonData($this->NewLeadMod->getUserLead($param));
        echo $this->baseview->renderJson();
    }
    public function filterListLead() {
        $this->NewLeadMod->filterListLead();
        if (isset($_SESSION["ListNewLead"]) && count($_SESSION["ListNewLead"]) > 0) {
            $_SESSION["initial"] = 0;
            $_SESSION["final"] = 10;
            $this->baseview->setHTML('Deal', 'listLead.php');
            echo $this->baseview->RenderView(false);
        } else {
            $this->baseview->setHTML('Deal', 'listEndLead.php');
            echo $this->baseview->RenderView(false);
        }
    }
    public function listDealLead() {
        /* Set list Lead */
        $this->NewLeadMod->listDealLead();
        if (isset($_SESSION["ListNewLead"]) && count($_SESSION["ListNewLead"]) > 0) {
            $_SESSION["initial"] = 0;
            $_SESSION["final"] = 10;
            $this->baseview->setHTML('Deal', 'listLead.php');
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
                        $this->NewLeadMod->listDealLead();
                        if (!isset($_SESSION["initial"]))
                            $_SESSION["initial"] = 0;
                        if (!isset($_SESSION["final"]))
                            $_SESSION["final"] = 10;
                        if (isset($this->postPara["para"]["lead_id"]))
                            $this->baseview->lead_id = (integer) $this->postPara["para"]["lead_id"];
                        else
                            $this->baseview->lead_id = NULL;
                        if (isset($this->postPara["para"]["view"]))
                            $this->baseview->setHTML('Deal', 'viewIndividualLead.php');
                        else
                            $this->baseview->setHTML('Deal', 'listLead.php');
                        echo $this->baseview->RenderView(false);
                        if (isset($_SESSION["initial"]))
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
            $this->baseview->listLead = $this->NewLeadMod->listDealLead();
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
            $this->baseview->listLead = $this->NewLeadMod->listDealLead();
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
        $this->baseview->setjsonData($this->NewLeadMod->approvalLead($param));
        echo $this->baseview->renderJson();
    }
    public function disApprovalLead($param = false) {
        $this->baseview->setjsonData($this->NewLeadMod->disApprovalLead($param));
        echo $this->baseview->renderJson();
    }
    public function changeLeadPreferences($param = false) {
        $this->baseview->setjsonData($this->NewLeadMod->changeLeadPreferences());
        echo $this->baseview->renderJson();
    }
    public function reportLead($param = false) {
        $this->baseview->setjsonData($this->NewLeadMod->reportLead());
        echo $this->baseview->renderJson();
    }
    public function subscribeBusiness($param = false) {
        $this->baseview->setjsonData($this->NewLeadMod->subscribeBusiness());
        echo $this->baseview->renderJson();
    }
    public function addQuotation($param = false) {
        $this->baseview->setjsonData($this->NewLeadMod->addQuotation($param));
        echo $this->baseview->renderJson();
    }
    public function approvalLeadQuotation($param = false) {
        $this->baseview->setjsonData($this->NewLeadMod->approvalLeadQuotation($param));
        echo $this->baseview->renderJson();
    }
    public function disApprovalLeadQuotation($param = false) {
        $this->baseview->setjsonData($this->NewLeadMod->disApprovalLeadQuotation($param));
        echo $this->baseview->renderJson();
    }
    public function changeLeadQuotationPreferences($param = false) {
        $this->baseview->setjsonData($this->NewLeadMod->changeLeadQuotationPreferences());
        echo $this->baseview->renderJson();
    }
    public function addQuotationWo($param = false) {
        $this->baseview->setjsonData($this->NewLeadMod->addQuotationWo($param));
        echo $this->baseview->renderJson();
    }
    public function approvalLeadQuotationWo($param = false) {
        $this->baseview->setjsonData($this->NewLeadMod->approvalLeadQuotationWo($param));
        echo $this->baseview->renderJson();
    }
    public function disApprovalLeadQuotationWo($param = false) {
        $this->baseview->setjsonData($this->NewLeadMod->disApprovalLeadQuotationWo($param));
        echo $this->baseview->renderJson();
    }
    public function changeLeadQuotationWoPreferences($param = false) {
        $this->baseview->setjsonData($this->NewLeadMod->changeLeadQuotationWoPreferences());
        echo $this->baseview->renderJson();
    }
}
?>