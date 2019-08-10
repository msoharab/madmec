<?php
$googleplus = isset($this->idHolders["onlinefood"]["index"]["googleplus"]) 
        ? (array) $this->idHolders["onlinefood"]["index"]["googleplus"] 
        : false;
?>
<hr />
<center>
    <h1>
        <i class="fa fa-5x ion ion-social-googleplus"></i>, Appid and URL Verified....
    </h1>
    <!--<i class="fa fa-5x fa-spin fa-spinner"></i>-->
    <?php
    if ($this->GPRequest != NULL):
        echo $this->GPRequest;
    else:
        ?><hr />
        <a href="<?php echo $this->config["URL"]; ?>" 
           class="btn btn-danger">
            OFO
        </a>
    <?php endif; ?>
</center>
<hr />
