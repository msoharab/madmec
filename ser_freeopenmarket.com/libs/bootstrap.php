<?php

class Bootstrap extends configure {

    private $parameters = '';
    private $controller = '';

    public function __construct() {
        parent::__construct();
        if (isset($_GET["url"])) {
            $url = rtrim($_GET["url"], "/");
            $url = explode("/", $url);
            /* Controlelr */
            if (isset($url[0])) {
                if (file_exists($this->config["CONTROLLERS"] . $url[0] . ".php")) {
                    require_once ($this->config["CONTROLLERS"] . $url[0] . ".php");
                    $this->controller = new $url[0]();
                    $_SESSION["CURR_CTRL"] = $url[0];
                    /* Controlelr Method Parameter list */
                    if (isset($url[2])) {
                        $this->parameters = $url[2];
                    } else {
                        $this->parameters = false;
                    }
                    $_SESSION["CURR_CTRL_MTD_PARA"] = $this->parameters;
                    /* Controller Method */
                    if (isset($url[1]) && method_exists($this->controller, $url[1])) {
                        $_SESSION["CURR_CTRL_MTD"] = $url[1];
                        $this->controller->{$url[1]}($this->parameters);
                    } else {
                        //$this->callError();
                        $this->controller->Index();
                    }
                } else {
                    $this->callDefault();
                }
            }
        } else if (!isset($_GET["url"])) {
            $this->callDefault();
        }
        unset($_GET);
    }

    public function callError() {
        require_once ($this->config["CONTROLLERS"] . "Errors.php");
        $this->controller = new Errors();
        $this->controller->Index();
        $_SESSION["CURR_CTRL"] = 'Error';
        $_SESSION["CURR_CTRL_MTD"] = '';
        $_SESSION["CURR_CTRL_MTD_PARA"] = '';
    }

    public function callDefault() {
        require_once ($this->config["CONTROLLERS"] . $this->config["DEFAULT_CNTRL"]);
        $this->controller = new Index();
        $this->controller->Index();
        $_SESSION["CURR_CTRL"] = 'Index';
        $_SESSION["CURR_CTRL_MTD"] = '';
        $_SESSION["CURR_CTRL_MTD_PARA"] = '';
    }

}

?>