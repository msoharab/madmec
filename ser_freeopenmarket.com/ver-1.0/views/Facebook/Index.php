<?php
$facebook = isset($this->idHolders["pic3pic"]["index"]["facebook"]) ? (array) $this->idHolders["pic3pic"]["index"]["facebook"] : false;
?>
<hr />
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
            Pic3Pic
        </a>
    <?php endif; ?>
</center>
<hr />
<!--<script src="https://connect.facebook.net/en_US/all.js"></script>-->
