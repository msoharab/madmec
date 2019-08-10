<?php
session_start();
$temp = rtrim($_SERVER["DOCUMENT_ROOT"], "/");
$temp = explode("/", $temp);
$config_root = str_replace($temp[count($temp) - 1], "library/" . $temp[count($temp) - 1], $_SERVER["DOCUMENT_ROOT"]) . "/";
define("CONFIG_ROOT", $config_root);
require_once(CONFIG_ROOT . 'configure.php');
$obj = new configure();
require_once(CONFIG_ROOT . $obj->config["MODULE_1"]);
require_once($obj->config["DOC_ROOT"] . $obj->config["LIBS"] . $obj->config["MODULE_2"]);
require_once($obj->config["DOC_ROOT"] . $obj->config["LIBS"] . $obj->config["MODULE_3"]);
require_once($obj->config["DOC_ROOT"] . $obj->config["LIBS"] . $obj->config["MODULE_4"]);
require_once($obj->config["DOC_ROOT"] . $obj->config["LIBS"] . $obj->config["MODULE_5"]);
require_once($obj->config["DOC_ROOT"] . $obj->config["LIBS"] . $obj->config["MODULE_6"]);
spl_autoload_register(function($class) {
    $obj = new configure();
    $file = $obj->config["DOC_ROOT"] . $obj->config["MODELS"] . $class . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
});
?>