<?php
define("MODULE_0", "config.php");
define("MODULE_1", "database.php");
require_once (MODULE_0);
require_once(CONFIG_ROOT . MODULE_0);
require_once(CONFIG_ROOT . MODULE_1);
if(!isset($_SESSION['USER_LOGIN_DATA'])){
    header("Location:index.php");
}
require_once DOC_ADMIN_ROOT . INC . 'header.php';
require_once DOC_ADMIN_ROOT . INC . 'Admin.php';
require_once DOC_ADMIN_ROOT . INC . 'footer.php';
?>
<script type="text/javascript">
    $(document).ready(function () {
        $("#doj").datepicker();
        window.setTimeout(function () {
            bindJobPost();
            bindBlogPost();
        }, 400);
    });
</script>