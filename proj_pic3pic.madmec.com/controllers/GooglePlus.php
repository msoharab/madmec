<?php
class GooglePlus extends BaseController {

    private $para, $redirect_uri, $client_id, $client_secret, $loginMod, $registerMod;

    function __construct($para = false) {
        parent::__construct();
        $this->para = $para;
        $this->loginMod = new Login_Model(true);
        $this->registerMod = new Register_Model(true);
        $this->current_uri = $this->config["URL"] . $this->config["CTRL_27"] . 'Index';
        $this->redirect_uri = $this->config["URL"] . $this->config["CTRL_27"] . 'OAuthPHPResponse';
        $this->client_id = '44963497708-gpdf4er8498qlpsas10bhncdmuul949a.apps.googleusercontent.com';
        $this->client_secret = 'w-tsoBU6ygl9E0sGG7maTXCq';
        $this->gotoWall();
    }
    public function Index() {
        require_once($this->config["LIB_ROOT"] . $this->config["GP_OAuth_API_ROOT"] . $this->config["GP_OAuth_API_MOD"]);
        $client = new Google_Client();
        $client->setClientId($this->client_id);
        $client->setClientSecret($this->client_secret);
        $client->setRedirectUri($this->redirect_uri);
        $client->addScope("email");
        $client->addScope("profile");
        $service = new Google_Service_Oauth2($client);
        if (isset($this->getPara['code']) && !isset($_SESSION['GP_access_token'])) {
            $client->authenticate($this->getPara['code']);
            $_SESSION['GP_access_token'] = $client->getAccessToken();
            header('Location: ' . filter_var($this->redirect_uri, FILTER_SANITIZE_URL));
            exit();
        }
        if (isset($_SESSION['GP_access_token']) && $_SESSION['GP_access_token']) {
            $client->setAccessToken($_SESSION['GP_access_token']);
            $this->baseview->GPData = $service->userinfo->get();
            print_r($this->baseview->GPData);
            $this->OAuthPHPResponse();
        } else {
            $this->baseview->GPRequest = '<a href="' . $client->createAuthUrl() . '" class="btn btn-google-plus">Log in with GooglePlus!</a>';
        }
        $this->baseview->setHeader('commonHeader.php');
        $this->baseview->setBody('GooglePlus');
        $this->baseview->setFooter('Footer.php');
        $this->baseview->RenderView(true);
    }
    public function OAuthPHPResponse() {
        require_once($this->config["LIB_ROOT"] . $this->config["GP_OAuth_API_ROOT"] . $this->config["GP_OAuth_API_MOD"]);
        $client = new Google_Client();
        $client->setClientId($this->client_id);
        $client->setClientSecret($this->client_secret);
        $client->setRedirectUri($this->redirect_uri);
        $client->addScope("email");
        $client->addScope("profile");
        $service = new Google_Service_Oauth2($client);
        $code = isset($this->getPara['code']) ?
                $this->getPara['code'] :
                (isset($_SESSION['GP_access_token']) ?
                        $_SESSION['GP_access_token'] :
                        NULL);
        if ($code != NULL) {
            echo 'I am code';
            $client->authenticate($this->getPara['code']);
            $_SESSION['GP_access_token'] = $client->getAccessToken();
            $client->setAccessToken($_SESSION['GP_access_token']);
            $this->baseview->GPData = $service->userinfo->get();
        }
        if ($this->baseview->GPData != NULL) {
            echo 'I am data';
            $socid = $this->baseview->GPData->id;
            $name = $this->baseview->GPData->name;
            $email = $this->baseview->GPData->email;
            $this->registerMod->setPostData(
                    array(
                        "user_name" => $email,
                    )
            );
            $stat = $this->registerMod->checkEmailDB();
            if (isset($stat["status"]) && $stat["status"] === 'failed') {
                $this->registerMod->setPostData(
                        array("details" => array(
                                "name" => $name,
                                "email" => $email,
                                "socailid" => $socid,
                                "pass" => $this->generateRandomString(),
                                "browser" => $_SERVER['HTTP_USER_AGENT'],
                            )
                        )
                );
                $stat = $this->registerMod->signUp();
                if (isset($stat["status"]) && $stat["status"] === 'success') {
                    $this->baseview->GPData = '<script type="text/javascript">window.location.href = "' . $this->config["URL"] . $this->config["CTRL_7"] . '"</script>';
                } else {
                    $this->baseview->GPData = '<script type="text/javascript">window.location.href = "' . $this->config["URL"] . '"</script>';
                }
            } else {
                $this->loginMod->setPostData(
                        array(
                            "autoloader" => true,
                            "action" => "signIn",
                            "user_name" => $stat["userdata"]["email"],
                            "password" => $stat["userdata"]["password"],
                            "browser" => $_SERVER['HTTP_USER_AGENT'],
                        )
                );
                $stat = $this->loginMod->signIn();
                if (isset($stat["status"]) && $stat["status"] === 'success') {
                    $this->baseview->GPData = '<script type="text/javascript">window.location.href = "' . $this->config["URL"] . $this->config["CTRL_7"] . '"</script>';
                } else {
                    $this->baseview->GPData = '<script type="text/javascript">window.location.href = "' . $this->config["URL"] . '"</script>';
                }
            }
        }
        $this->renderOAuthView();
    }
    public function renderOAuthView() {
        $this->baseview->setHeader('commonHeader.php');
        $this->baseview->setHTML('GooglePlus', 'OAuthPHPResponse.php');
        $this->baseview->setFooter('Footer.php');
        echo $this->baseview->RenderView(true);
    }
}
?>