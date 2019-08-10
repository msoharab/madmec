<?php
define("MODULE_1", "config.php");
define("MODULE_2", "database.php");
require_once(MODULE_1);
require_once(CONFIG_ROOT . MODULE_1);
require_once(CONFIG_ROOT . MODULE_2);
?>

<?php include_once(DOC_ROOT . INC . "header.php"); ?>

<div id="page-wrapper">
    <div id="container">
        <div id="output"></div>
</div>
</div>
<!-- /#page-wrapper -->
<?php include_once(DOC_ROOT . INC . "footer.php"); ?>
