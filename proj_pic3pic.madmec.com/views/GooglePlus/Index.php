<?php
$googleplus = isset($this->idHolders["pic3pic"]["index"]["googleplus"]) 
        ? (array) $this->idHolders["pic3pic"]["index"]["googleplus"] 
        : false;
?>
<hr />
<center>
    <h1>
        <i class="fa fa-5x fa-google-plus-square"></i>
    </h1>
    <!--<i class="fa fa-5x fa-spin fa-spinner"></i>-->
    <?php
    if ($this->GPRequest != NULL):
        echo $this->GPRequest;
    else:
        ?><hr />
        <a href="<?php echo $this->config["URL"]; ?>" 
           class="btn btn-danger">
            Pic3Pic
        </a>
    <?php endif; ?>
</center>
<hr />
