<?php
class BaseView extends configure {

    private $msg, $header, $body, $controller, $footer, $menufile;
    public $FoodDets, $OrdersDets, $SalesDets, $UserDets, $title, $jsonData;
    public $FBRequest, $FBError, $FBData;
    public $GPRequest, $GPError, $GPData;

    public function __construct($param = false) {
        parent::__construct();
        $this->msg = NULL;
        $this->title = NULL;
        $this->header = NULL;
        $this->menufile = NULL;
        $this->controller = NULL;
        $this->body = NULL;
        $this->footer = NULL;
        $this->jsonData = NULL;
        $this->FBError = NULL;
        $this->FBRequest = NULL;
        $this->FBData = NULL;
        $this->GPResponse = NULL;
        $this->GPError = NULL;
    }
    public function RenderView($flag) {
        if ($flag) {
            if ($this->header != NULL)
                require_once($this->header);
            if ($this->menufile != NULL)
                require_once($this->menufile);
            if ($this->body != NULL)
                require_once($this->body);
            if ($this->footer != NULL)
                require_once($this->footer);
        } else {
            if ($this->body != NULL)
                require_once($this->body);
        }
    }
    public function renderJson() {
        if (is_array($this->jsonData)) {
            return json_encode($this->jsonData);
        }
    }
    public function getMessage() {
        return $this->msg;
    }
    public function getTitle() {
        return $this->title;
    }
    public function getHeader() {
        return $this->header;
    }
    public function getMenuFile() {
        return $this->menufile;
    }
    public function getBody() {
        return $this->body;
    }
    public function getFooter() {
        return $this->footer;
    }
    public function getJsonData() {
        return $this->jsonData;
    }
    public function setMessage($msg) {
        $this->msg = $msg;
    }
    public function setTitle($title) {
        $this->title = $title;
    }
    public function setHeader($header) {
        if ($header)
            $this->header = $this->config["DOC_ROOT"] . $this->config["VIEWS"] . $this->config["INC"] . $header;
    }
    public function setMenuFile($menu) {
        if ($menu)
            $this->menufile = $this->config["DOC_ROOT"] . $this->config["VIEWS"] . $this->config["INC"] . $menu;
    }
    public function setBody($body) {
        if ($body) {
            $this->controller = $body;
            $this->body = $this->config["DOC_ROOT"] . $this->config["VIEWS"] . $body . '/Index.php';
        }
    }
    public function setHTML($body, $page) {
        if ($body && $page) {
            $this->controller = $body;
            $this->body = $this->config["DOC_ROOT"] . $this->config["VIEWS"] . $body . '/' . $page;
        }
    }
    public function setFooter($footer) {
        if ($footer)
            $this->footer = $this->config["DOC_ROOT"] . $this->config["VIEWS"] . $this->config["INC"] . $footer;
    }
    public function setjsonData($jsonData) {
        $this->jsonData = (array) $jsonData;
    }
}
?>