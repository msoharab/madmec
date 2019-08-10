<?php
$Prof = isset($this->idHolders["ricepark"]["profile"]["ChangePassword"]) ? (array) $this->idHolders["ricepark"]["profile"]["ChangePassword"] : false;
?>
<?php
require_once 'change_password.php';
?>
<script type="text/javascript">
    $(document).ready(function () {
        var para = getJSONIds({
            autoloader: true,
            action: 'getIdHolders',
            url: URL + 'Profile/getIdHolders',
            type: 'POST',
            dataType: 'JSON'
        }).ricepark.profile;
        var obj = new profile();
        obj.__constructor(para);
    });
</script>
