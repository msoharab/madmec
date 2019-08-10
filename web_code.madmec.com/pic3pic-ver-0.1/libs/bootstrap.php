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
                    /* Controlelr Method Parameter list */
                    if (isset($url[2])) {
                        $this->parameters = $url[2];
                    } else {
                        $this->parameters = false;
                    }
                    /* Controller Method */
                    if (isset($url[1])) {
                        if (method_exists($this->controller, $url[1])) {
                            $this->controller->{$url[1]}($this->parameters);
                        } else {
                            //$this->callError();
                            $this->controller->Index();
                        }
                    } else {
                        $this->controller->Index();
                    }
                } else {
                    $this->callError();
                }
            }
        } else if (!isset($_GET["url"])) {
            $this->callDefault();
        }
        unset($_GET);
    }
    public function callError() {
        require_once ($this->config["CONTROLLERS"] . "Error.php");
        $this->controller = new Error();
        $this->controller->Index();
    }
    public function callDefault() {
        require_once ($this->config["CONTROLLERS"] . $this->config["DEFAULT_CNTRL"]);
        $this->controller = new Index();
        $this->controller->Index();
    }
}
?>