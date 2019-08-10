<?php

class BaseController extends configure {
    protected $baseview, $basemodel, $postPara, $getPara, $postFile, $jsonData;

    public function __construct() {
        parent::__construct();
        $this->getPara = isset($_GET) ? $_GET : NULL;
        $this->postPara = isset($_POST) ? $_POST : NULL;
        $this->postFile = isset($_FILES) ? $_FILES : NULL;
        $this->basemodel = new BaseModel();
        $this->basemodel->setPostData($this->postPara);
        $this->basemodel->setPostFile($this->postFile);
        $this->baseview = new BaseView();
        spl_autoload_register(function($class) {
            $obj = new configure();
            $file = $obj->config["DOC_ROOT"] . $obj->config["CONTROLLERS"] . $class . '.php';
            if (file_exists($file)) {
                require_once $file;
            }
        });
    }

    public function gotoDashboard() {
        if (isset($_SESSION["USERDATA"]["loggedin"]) && $_SESSION["USERDATA"]["loggedin"] == 1) {
            header('Location:' . $this->config["URL"] . $this->config["CTRL_35"]);
        }
    }

    public function gotoIndex() {
        if (!isset($_SESSION["USERDATA"])) {
            header('Location:' . $this->config["URL"] . $this->config["CTRL_1"]);
        }
    }

    public function gotoHome() {
        if (!isset($_SESSION["GYM_DETAILS"])) {
            header('Location:' . $this->config["URL"] . $this->config["CTRL_35"]);
        }
    }

    public function checkEmail() {
        $this->baseview->setjsonData($this->basemodel->checkEmailDB());
        echo $this->baseview->renderJson();
    }

    public function fetchAdmin() {
        $this->baseview->setjsonData($this->basemodel->fetchAdminDB(isset($this->postPara['listtype']) ? $this->postPara['listtype'] : false));
        echo $this->baseview->renderJson();
    }

    public function fetchGyms() {
        $this->baseview->setjsonData($this->basemodel->fetchGymsDB(isset($this->postPara['listtype']) ? $this->postPara['listtype'] : false));
        echo $this->baseview->renderJson();
    }

    public function fetchGender() {
        $this->baseview->setjsonData($this->basemodel->fetchGenderDB(isset($this->postPara['listtype']) ? $this->postPara['listtype'] : false));
        echo $this->baseview->renderJson();
    }

    public function fetchUserTypes() {
        $this->baseview->setjsonData($this->basemodel->fetchUserTypesDB(isset($this->postPara['listtype']) ? $this->postPara['listtype'] : false));
        echo $this->baseview->renderJson();
    }

    public function fetchFacility() {
        $this->baseview->setjsonData($this->basemodel->fetchFacilityDB(isset($this->postPara['listtype']) ? $this->postPara['listtype'] : false));
        echo $this->baseview->renderJson();
    }
    public function fetchDuration() {
        $this->baseview->setjsonData($this->basemodel->fetchDurationDB(isset($this->postPara['listtype']) ? $this->postPara['listtype'] : false));
        echo $this->baseview->renderJson();
    }
    public function fetchMinMember() {
        $this->baseview->setjsonData($this->basemodel->fetchMinMemberDB(isset($this->postPara['listtype']) ? $this->postPara['listtype'] : false));
        echo $this->baseview->renderJson();
    }

    public function fetchMediumAds() {
        $this->baseview->setjsonData($this->basemodel->fetchMediumAdsDB(isset($this->postPara['listtype']) ? $this->postPara['listtype'] : false));
        echo $this->baseview->renderJson();
    }

    public function fetchDocTypes() {
        $this->baseview->setjsonData($this->basemodel->fetchDocTypesDB(isset($this->postPara['listtype']) ? $this->postPara['listtype'] : false));
        echo $this->baseview->renderJson();
    }

    public function fetchPackages() {
        $this->baseview->setjsonData($this->basemodel->fetchPackagesDB(isset($this->postPara['listtype']) ? $this->postPara['listtype'] : false));
        echo $this->baseview->renderJson();
    }


    public function fetchCompany() {
        $this->baseview->setjsonData($this->basemodel->fetchCompanyDB(isset($this->postPara['listtype']) ? $this->postPara['listtype'] : false));
        echo $this->baseview->renderJson();
    }

    public function fetchBusIdTypes() {
        $this->baseview->setjsonData($this->basemodel->fetchBusAddTypes(isset($this->postPara['listtype']) ? $this->postPara['listtype'] : false));
        echo $this->baseview->renderJson();
    }

    public function fetchBusAddTypes() {
        $this->baseview->setjsonData($this->basemodel->fetchBusAddTypes(isset($this->postPara['listtype']) ? $this->postPara['listtype'] : false));
        echo $this->baseview->renderJson();
    }

    public function fetchBusinessTypes() {
        $this->baseview->setjsonData($this->basemodel->fetchBusinessTypesDB(isset($this->postPara['listtype']) ? $this->postPara['listtype'] : false));
        echo $this->baseview->renderJson();
    }

    public function fetchListOperators() {
        $this->baseview->setjsonData($this->basemodel->fetchOperatorDB(isset($this->postPara['listtype']) ? $this->postPara['listtype'] : false));
        echo $this->baseview->renderJson();
    }

    public function fetchListOperatorTypes() {
        $this->baseview->setjsonData($this->basemodel->fetchOperatorTypeDB(isset($this->postPara['listtype']) ? $this->postPara['listtype'] : false));
        echo $this->baseview->renderJson();
    }

    public function fetchListServices() {
        $this->baseview->setjsonData($this->basemodel->fetchServicesDB(isset($this->postPara['listtype']) ? $this->postPara['listtype'] : false));
        echo $this->baseview->renderJson();
    }

    public function fetchListContinents() {
        $this->baseview->setjsonData($this->basemodel->fetchListContinentsDB(isset($this->postPara['listtype']) ? $this->postPara['listtype'] : false));
        echo $this->baseview->renderJson();
    }

    public function fetchListCountries() {
        $this->baseview->setjsonData($this->basemodel->fetchListCountriesDB(isset($this->postPara['listtype']) ? $this->postPara['listtype'] : false));
        echo $this->baseview->renderJson();
    }

    public function fetchListGateways() {
        $this->baseview->setjsonData($this->basemodel->fetchListGatewaysDB(isset($this->postPara['listtype']) ? $this->postPara['listtype'] : false));
        echo $this->baseview->renderJson();
    }

    public function fetchGatewayOperators() {
        $this->baseview->setjsonData($this->basemodel->fetchGatewayOperatorDB(isset($this->postPara['listtype']) ? $this->postPara['listtype'] : false));
        echo $this->baseview->renderJson();
    }

    public function fetchGatewayOperatorTypes() {
        $this->baseview->setjsonData($this->basemodel->fetchGatewayOperatorTypeDB(isset($this->postPara['listtype']) ? $this->postPara['listtype'] : false));
        echo $this->baseview->renderJson();
    }

    public function fetchProtocolTypes() {
        $this->baseview->setjsonData($this->basemodel->fetchProtocolTypesDB(isset($this->postPara['listtype']) ? $this->postPara['listtype'] : false));
        echo $this->baseview->renderJson();
    }

    public function fetchRestMethods() {
        $this->baseview->setjsonData($this->basemodel->fetchRestMethodsDB(isset($this->postPara['listtype']) ? $this->postPara['listtype'] : false));
        echo $this->baseview->renderJson();
    }

    public function fetchRestTypes() {
        $this->baseview->setjsonData($this->basemodel->fetchRestTypesDB(isset($this->postPara['listtype']) ? $this->postPara['listtype'] : false));
        echo $this->baseview->renderJson();
    }

    public function fetchRestParameters() {
        $this->baseview->setjsonData($this->basemodel->fetchRestParametersDB(isset($this->postPara['listtype']) ? $this->postPara['listtype'] : false));
        echo $this->baseview->renderJson();
    }

    public function getjsonData($jsonData) {
        return $this->jsonData;
    }

    public function setjsonData($jsonData) {
        $this->jsonData = (array) $jsonData;
    }

}
