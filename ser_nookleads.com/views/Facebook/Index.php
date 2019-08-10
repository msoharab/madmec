<?php
$facebook = isset($this->idHolders["nookleads"]["index"]["facebook"]) ? (array) $this->idHolders["nookleads"]["index"]["facebook"] : false;
?>
<center>
    <h1>
        <i class="fa fa-5x fa-facebook-square"></i>
    </h1>
    <!--<i class="fa fa-5x fa-spin fa-spinner"></i>-->
    <?php
    if ($this->FBRequest != NULL):
        echo $this->FBRequest;
    else:
        ?><hr />
        <a href="<?php echo $this->config["URL"]; ?>" 
           class="btn btn-danger">
            nOOkLeads
        </a>
    <?php endif; ?>
</center>
<hr />
<!--<script src="https://connect.facebook.net/en_US/all.js"></script>-->
