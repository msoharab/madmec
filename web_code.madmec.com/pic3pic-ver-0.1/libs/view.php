<?php
class BaseView extends configure {

    private $title, $msg, $header, $body, $controller, $footer, $jsonData;

    public function __construct($param) {
        parent::__construct();
        $this->msg = $param["msg"];
        $this->title = $param["title"];
        $this->header = $param["header"];
        $this->controller = $param["body"];
        $this->body = $param["body"];
        $this->footer = $param["footer"];
        $this->jsonData = (array) $param["data"];
    }
    public function RenderView($flag) {
        if ($flag) {
            require_once($this->header);
            require_once($this->body);
            require_once($this->footer);
        } else {
            require_once($this->body);
        }
    }
    public function renderJson() {
        if (is_array($this->jsonData))
            return json_encode($this->jsonData);
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
        $this->header = $this->config["DOC_ROOT"] . $this->config["VIEWS"] . $this->config["INC"] . $header;
    }
    public function setBody($body) {
        $this->controller = $body;
        $this->body = $this->config["DOC_ROOT"] . $this->config["VIEWS"] . $body . '/Index.php';
    }
    public function setFooter($footer) {
        $this->footer = $this->config["DOC_ROOT"] . $this->config["VIEWS"] . $this->config["INC"] . $footer;
    }
    public function setjsonData($jsonData) {
        $this->jsonData = (array) $jsonData;
    }
}
?>