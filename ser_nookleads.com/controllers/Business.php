<?php
class Business extends BaseController {
    private $para;
    private $BusinessMod;
    function __construct($para = false) {
        parent::__construct();
        $this->para = $para;
        $this->BusinessMod = new Business_Model();
        $this->BusinessMod->setLeadData($this->postPara);
        $this->baseview->UserDets = $this->logindata;
        $this->baseview->UserId = $this->UserId;
    }
    public function Index() {
        $this->baseview->setHeader('businessHeader.php');
        $this->baseview->setBody('Business');
        $this->baseview->setFooter('Footer.php');
        $this->baseview->RenderView(true);
    }
    public function CreateBusiness() {
        $this->baseview->setjsonData($this->BusinessMod->CreateBusiness());
        echo $this->baseview->renderJson();
    }
    public function ListBusinesses() {
        $this->baseview->setjsonData($this->BusinessMod->ListBusinesses());
        echo $this->baseview->renderJson();
    }
    public function ListAdminBusinesses() {
        $this->baseview->setjsonData($this->BusinessMod->ListAdminBusinesses());
        echo $this->baseview->renderJson();
    }
    public function ListSubscribeBusinesses() {
        $this->baseview->setjsonData($this->BusinessMod->ListSubscribeBusinesses());
        echo $this->baseview->renderJson();
    }
    public function searchBusinesses() {
        $this->baseview->setjsonData($this->BusinessMod->searchBusinesses());
        echo $this->baseview->renderJson();
    }
    public function CreateNew_Lead($param = false) {
        if ($param && is_string($param)) {
            $this->BusinessMod->BusinessId = (integer) $param;
            $this->baseview->setjsonData($this->BusinessMod->CreateNew_Lead($param));
            echo $this->baseview->renderJson();
        }
    }
    public function getContinents() {
        $this->baseview->setjsonData($this->BusinessMod->ListContinents(isset($this->postPara['listtype']) ? $this->postPara['listtype'] : false));
        echo $this->baseview->renderJson();
    }
    public function getCountries() {
        $this->baseview->setjsonData($this->BusinessMod->ListCountries(isset($this->postPara['listtype']) ? $this->postPara['listtype'] : false));
        echo $this->baseview->renderJson();
    }
    public function getLanguages() {
        $this->baseview->setjsonData($this->BusinessMod->ListLanguages(isset($this->postPara['listtype']) ? $this->postPara['listtype'] : false));
        echo $this->baseview->renderJson();
    }
    public function getSectionsNames() {
        $this->baseview->setjsonData($this->BusinessMod->getSectionsNames($this->postPara['listtype']));
        echo $this->baseview->renderJson();
    }
    public function filterListLead($id = false) {
        if ($id && is_string($id)) {
            /* Set list Lead */
            $this->BusinessMod->BusinessId = (integer) $id;
            $this->BusinessMod->filterListLead();
            if (isset($_SESSION["ListNewLead"]) && count($_SESSION["ListNewLead"]) > 0) {
                $_SESSION["initial"] = 0;
                $_SESSION["final"] = 10;
                $this->baseview->setHTML('Business', 'listLead.php');
                echo $this->baseview->RenderView(false);
            }
            else{
                $this->baseview->setHTML('Business', 'listEndLead.php');
                echo $this->baseview->RenderView(false);
            }
        }
    }
    public function listDealLead($id = false) {
        if ($id && is_string($id)) {
            /* Set list Lead */
            $this->BusinessMod->BusinessId = (integer) $id;
            $this->BusinessMod->listDealLead();
            if (isset($_SESSION["ListNewLead"]) && count($_SESSION["ListNewLead"]) > 0) {
                $_SESSION["initial"] = 0;
                $_SESSION["final"] = 10;
                $this->baseview->setHTML('Business', 'listLead.php');
                echo $this->baseview->RenderView(false);
            }
            else{
                $this->baseview->setHTML('Business', 'listEndLead.php');
                echo $this->baseview->RenderView(false);
            }
        }
    }
    public function listUpdatedDealLead($id = false) {
        if ($id && is_string($id)) {
            /* Set list Lead */
            $this->BusinessMod->BusinessId = (integer) $id;
            if (isset($this->postPara["para"]["where"])) {
                switch ($this->postPara["para"]["where"]) {
                    case 'prepend': {
                            $this->BusinessMod->listDealLead();
                            $_SESSION["initial"] = 0;
                            $_SESSION["final"] = 10;
                            if (isset($this->postPara["para"]["lead_id"]))
                                $this->baseview->lead_id = (integer) $this->postPara["para"]["lead_id"];
                            else
                                $this->baseview->lead_id = NULL;
                            $this->baseview->setHTML('Business', 'listLead.php');
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
                                        $this->baseview->setHTML('Business', 'listEndLead.php');
                                        echo $this->baseview->RenderView(false);
                                    } else {
                                        $_SESSION["initial"] = $_SESSION["final"];
                                        $_SESSION["final"] += 10;
                                        $this->baseview->setHTML('Business', 'listLead.php');
                                        echo $this->baseview->RenderView(false);
                                    }
                                }
                            }
                            break;
                        }
                }
            } else {
                $this->baseview->setHTML('Business', 'listEndLead.php');
                echo $this->baseview->RenderView(false);
            }
        }
    }
    public function listDealLeadQuotation() {
        if (isset($_SESSION["ListNewLead"]) && count($_SESSION["ListNewLead"]) > 0) {
            $this->baseview->listLead = $this->BusinessMod->listDealLead();
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
            $this->baseview->setHTML('Business', 'listQuotation.php');
            echo $this->baseview->RenderView(false);
        }
    }
    public function listDealLeadQuotationWo() {
        if (isset($_SESSION["ListNewLead"]) && count($_SESSION["ListNewLead"]) > 0) {
            $this->baseview->listLead = $this->BusinessMod->listDealLead();
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
            $this->baseview->setHTML('Business', 'listWo.php');
            echo $this->baseview->RenderView(false);
        }
    }
    public function approvalLead($param = false) {
        $this->baseview->setjsonData($this->BusinessMod->approvalLead($param));
        echo $this->baseview->renderJson();
    }
    public function disApprovalLead($param = false) {
        $this->baseview->setjsonData($this->BusinessMod->disApprovalLead($param));
        echo $this->baseview->renderJson();
    }
    public function changeLeadPreferences($param = false) {
        $this->baseview->setjsonData($this->BusinessMod->changeLeadPreferences());
        echo $this->baseview->renderJson();
    }
    public function reportLead($param = false) {
        $this->baseview->setjsonData($this->BusinessMod->reportLead());
        echo $this->baseview->renderJson();
    }
    public function addQuotation($param = false) {
        $this->baseview->setjsonData($this->BusinessMod->addQuotation($param));
        echo $this->baseview->renderJson();
    }
    public function approvalLeadQuotation($param = false) {
        $this->baseview->setjsonData($this->BusinessMod->approvalLeadQuotation($param));
        echo $this->baseview->renderJson();
    }
    public function disApprovalLeadQuotation($param = false) {
        $this->baseview->setjsonData($this->BusinessMod->disApprovalLeadQuotation($param));
        echo $this->baseview->renderJson();
    }
    public function changeLeadQuotationPreferences($param = false) {
        $this->baseview->setjsonData($this->BusinessMod->changeLeadQuotationPreferences());
        echo $this->baseview->renderJson();
    }
    public function addQuotationWo($param = false) {
        $this->baseview->setjsonData($this->BusinessMod->addQuotationWo($param));
        echo $this->baseview->renderJson();
    }
    public function approvalLeadQuotationWo($param = false) {
        $this->baseview->setjsonData($this->BusinessMod->approvalLeadQuotationWo($param));
        echo $this->baseview->renderJson();
    }
    public function disApprovalLeadQuotationWo($param = false) {
        $this->baseview->setjsonData($this->BusinessMod->disApprovalLeadQuotationWo($param));
        echo $this->baseview->renderJson();
    }
    public function changeLeadQuotationWoPreferences($param = false) {
        $this->baseview->setjsonData($this->BusinessMod->changeLeadQuotationWoPreferences());
        echo $this->baseview->renderJson();
    }
    public function getBusinessAdmins($param = false) {
        if ($param && is_string($param)) {
            $this->BusinessMod->BusinessId = (integer) $param;
            $this->baseview->setjsonData($this->BusinessMod->ListUsers(isset($this->postPara['listtype']) ? $this->postPara['listtype'] : false));
            echo $this->baseview->renderJson();
        }
    }
    public function View($id = false) {
        if ($id && is_string($id)) {
            $_SESSION["BUSINESS_ID"] = (integer) base64_decode($id);
            $this->BusinessId = $_SESSION["BUSINESS_ID"];
            $this->BusinessDetails = (array) $this->BusinessMod->getBusinessDetails($_SESSION["BUSINESS_ID"]);
            $this->baseview->UserId = $this->UserId;
            $this->baseview->BusinessId = $this->BusinessId;
            $this->baseview->BusinessDetails = $this->BusinessDetails;
            $this->baseview->BusinessSize = $this->BusinessDetails["business_size"];
            $this->BusinessMod->BusinessId = $this->BusinessId;
            $this->BusinessMod->BusinessDetails = $this->BusinessDetails;
            $this->BusinessMod->BusinessSize = $this->BusinessDetails["business_size"];
            $this->Index();
        } else {
            $this->gotoDeal();
        }
    }
    public function fetchMessages($id = false) {
        if ($id && is_string($id)) {
            $this->BusinessMod->BusinessId = (integer) $id;
            $this->baseview->UserId = $this->UserId;
            $this->baseview->BusinessId = $this->BusinessId;
            $this->baseview->BusinessDetails = $this->BusinessMod->getBusinessDetails($id);
            $this->baseview->setHTML('Business', 'businessMessage.php');
            echo $this->baseview->RenderView(false);
        }
    }
    public function sendMessage($id = false) {
        if ($id && is_string($id)) {
            $this->BusinessMod->BusinessId = (integer) $id;
            $this->baseview->setjsonData($this->BusinessMod->sendMessage());
            echo $this->baseview->renderJson();
        }
    }
    public function removeAdmin($id = false) {
        if ($id && is_string($id)) {
            $this->BusinessMod->BusinessId = (integer) $id;
            $this->baseview->setjsonData($this->BusinessMod->removeAdmin());
            echo $this->baseview->renderJson();
        }
    }
    public function updateBusinessBG($id = false) {
        if ($id && is_string($id)) {
            $this->BusinessMod->BusinessId = (integer) $id;
            $this->baseview->setjsonData($this->BusinessMod->BusinessBG());
            echo $this->baseview->renderJson();
        }
    }
    public function updateBusinessIcon($id = false) {
        if ($id && is_string($id)) {
            $this->BusinessMod->BusinessId = (integer) $id;
            $this->baseview->setjsonData($this->BusinessMod->BusinessIcon());
            echo $this->baseview->renderJson();
        }
    }
    public function updateBusinessAdv($id = false) {
        if ($id && is_string($id)) {
            $this->BusinessMod->BusinessId = (integer) $id;
            $this->baseview->setjsonData($this->BusinessMod->BusinessAdv());
            echo $this->baseview->renderJson();
        }
    }
    public function ReportBusiness() {
        $this->baseview->setjsonData($this->BusinessMod->ReportBusiness());
        echo $this->baseview->renderJson();
    }
    public function subscribeBusiness($param = false) {
        if ($param && is_string($param)) {
            $this->BusinessMod->BusinessId = (integer) $param;
            $this->baseview->setjsonData($this->BusinessMod->subscribeBusiness($param));
            echo $this->baseview->renderJson();
        }
    }
    public function BlockBusiness($param = false) {
        if ($param && is_string($param)) {
            $this->BusinessMod->BusinessId = (integer) $param;
            $this->baseview->setjsonData($this->BusinessMod->BlockBusiness($param));
            echo $this->baseview->renderJson();
        }
    }
    public function approvalBusiness($param = false) {
        if ($param && is_string($param)) {
            $this->BusinessMod->BusinessId = (integer) $param;
            $this->baseview->setjsonData($this->BusinessMod->approvalBusiness($param));
            echo $this->baseview->renderJson();
        }
    }
    public function disApprovalBusiness($param = false) {
        if ($param && is_string($param)) {
            $this->BusinessMod->BusinessId = (integer) $param;
            $this->baseview->setjsonData($this->BusinessMod->disApprovalBusiness($param));
            echo $this->baseview->renderJson();
        }
    }
    public function UpdateBusinessDetails($param = false) {
        if ($param && is_string($param)) {
            $this->BusinessMod->BusinessId = (integer) $param;
            $this->baseview->setjsonData($this->BusinessMod->UpdateBusinessDetails());
            echo $this->baseview->renderJson();
        }
    }
    public function shareBusiness($param = false) {
        if ($param && is_string($param)) {
            $this->BusinessMod->BusinessId = (integer) $param;
            $this->baseview->setjsonData($this->BusinessMod->shareBusiness($param));
            echo $this->baseview->renderJson();
        }
    }
}
?>