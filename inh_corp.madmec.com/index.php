<?php
define("MODULE_0", "config.php");
define("MODULE_1", "database.php");
require_once (MODULE_0);
require_once(CONFIG_ROOT . MODULE_0);
require_once(CONFIG_ROOT . MODULE_1);
require_once DOC_ROOT . INC . 'index_header.php';
require_once DOC_ROOT . INC . 'index_body.php';
require_once DOC_ROOT . INC . 'index_footer.php';
?>