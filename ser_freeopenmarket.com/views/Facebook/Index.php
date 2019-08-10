<?php
$facebook = isset($this->idHolders["onlinefood"]["index"]["facebook"]) ? (array) $this->idHolders["onlinefood"]["index"]["facebook"] : false;
?>
<hr />
<center>
    <h1>
        <i class="fa fa-5x ion ion-social-facebook"></i>, Appid and URL Verified....
    </h1>
    <!--<i class="fa fa-5x fa-spin fa-spinner"></i>-->
    <?php
    if ($this->FBRequest != NULL):
        echo $this->FBRequest;
    else:
        ?><hr />
        <a href="<?php echo $this->config["URL"]; ?>" 
           class="btn btn-warning">
            OFO
        </a>
    <?php endif; ?>
</center>
<hr />
<!--<script src="https://connect.facebook.net/en_US/all.js"></script>-->
