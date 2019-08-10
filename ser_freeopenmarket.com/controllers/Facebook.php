<?php

class Facebook extends BaseController {

    private $para, $loginMod, $registerMod;

    function __construct($para = false) {
        parent::__construct();
        $this->gotoDashboard();
        $this->para = $para;
        $this->loginMod = new Login_Model(true);
        $this->registerMod = new Register_Model(true);
    }

    public function Index() {
        set_include_path(get_include_path() . PATH_SEPARATOR . $this->config["LIB_ROOT"]);
        require_once($this->config["LIB_ROOT"] . $this->config["FB_OAuth_API_ROOT"] . $this->config["FB_OAuth_API_MOD"]);
        $fb = new Facebook\Facebook([
            'app_id' => '457732571094681',
            'app_secret' => '2256860e872c127f4767d72139ddf17d',
            'default_graph_version' => 'v2.5',
            'auth_type' => 'reauthenticate',
        ]);
        $helper = $fb->getRedirectLoginHelper();
        $permissions = ['email'];
        $loginUrl = $helper->getLoginUrl(
                $this->config["URL"] .
                $this->config["CTRL_2"] . 'OAuthPHPResponse', $permissions);
        $this->baseview->FBRequest = '<a href="' . $loginUrl . '" class="btn btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Register / Login Using Facebook!</a>';
        $this->baseview->setHeader('CommonHeader.php');
        $this->baseview->setBody('Facebook');
        $this->baseview->setFooter('Footer.php');
        $this->baseview->RenderView(true);
    }

    public function OAuthPHPResponse() {
        set_include_path(get_include_path() . PATH_SEPARATOR . $this->config["LIB_ROOT"]);
        require_once($this->config["LIB_ROOT"] . $this->config["FB_OAuth_API_ROOT"] . $this->config["FB_OAuth_API_MOD"]);
        $fb = new Facebook\Facebook([
            'app_id' => '457732571094681',
            'app_secret' => '2256860e872c127f4767d72139ddf17d',
            'default_graph_version' => 'v2.5',
            'auth_type' => 'reauthenticate',
        ]);
        $helper = $fb->getRedirectLoginHelper();
        try {
            $accessToken = $helper->getAccessToken();
        } catch (Facebook\Exceptions\FacebookResponseException $e) {
            // When Graph returns an error
            $this->baseview->FBError = 'Graph returned an error 1: ' . $e->getMessage();
        } catch (Facebook\Exceptions\FacebookSDKException $e) {
            // When validation fails or other local issues
            $this->baseview->FBError = 'Facebook SDK returned an error 1: ' . $e->getMessage();
        }

        if (isset($accessToken)) {
            // Logged in!
            $_SESSION['facebook_access_token'] = (string) $accessToken;
            $fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
            try {
                //$response = $fb->get('/me');
                $response = $fb->get('/me?locale=en_US&fields=id,name,email');
                $this->baseview->FBData = $response->getGraphUser();
            } catch (Facebook\Exceptions\FacebookResponseException $e) {
                // When Graph returns an error
                $this->baseview->FBError = 'Graph returned an error 2: ' . $e->getMessage();
            } catch (Facebook\Exceptions\FacebookSDKException $e) {
                // When validation fails or other local issues
                $this->baseview->FBError = 'Facebook SDK returned an error 2: ' . $e->getMessage();
            }
        }
        if ($this->baseview->FBData != NULL) {
            $socid = $this->baseview->FBData->getProperty('id');
            $name = $this->baseview->FBData->getProperty('name');
            $email = $this->baseview->FBData->getProperty('email');
            $this->registerMod->setPostData(
                    array(
                        "user_name" => $email,
                    )
            );
            $stat = $this->registerMod->checkEmailDB($email);
            if (isset($stat["status"]) && $stat["status"] === 'error') {
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
                    $this->baseview->FBData = '<script type="text/javascript">window.location.href = "' . $this->config["URL"] . $this->config["CTRL_0"] . '"</script>';
                } else {
                    $this->baseview->FBData = '<script type="text/javascript">window.location.href = "' . $this->config["URL"] . '"</script>';
                }
            } else {
                $stat = $this->registerMod->CustomerLoginByEmail($email);
                if (isset($stat["status"]) && $stat["status"] === 'success') {
                    $this->baseview->FBData = '<script type="text/javascript">window.location.href = "' . $this->config["URL"] . $this->config["CTRL_0"] . '"</script>';
                } else {
                    $this->baseview->FBData = '<script type="text/javascript">window.location.href = "' . $this->config["URL"] . '"</script>';
                }
            }
        }
        $this->renderOAuthView();
    }

    public function renderOAuthView() {
        $this->baseview->setHeader('CommonHeader.php');
        $this->baseview->setHTML('Facebook', 'OAuthPHPResponse.php');
        $this->baseview->setFooter('Footer.php');
        echo $this->baseview->RenderView(true);
    }

}

?>