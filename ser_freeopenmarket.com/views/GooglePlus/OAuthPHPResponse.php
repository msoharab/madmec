<?php
$googleplus = isset($this->idHolders["onlinefood"]["index"]["googleplus"]) ? (array) $this->idHolders["onlinefood"]["index"]["googleplus"] : false;
?>
<hr />
<center>
    <h1>
        <i class="fa fa-5x fa-google-plus-square"></i>
    </h1>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <?php
                if ($this->GPError != NULL):
                    echo $this->GPError;
                    ?>
                    <a href="<?php echo $this->config["URL"]; ?>" 
                       class="btn btn-danger">
                        OFO
                    </a>
                    <?php
                elseif ($this->GPData != NULL):
                    echo $this->GPData;
                    ?><hr />
                    Loading.....<i class="fa fa-5x fa-spin fa-spinner"></i><hr />
                    <a href="<?php echo $this->config["URL"]; ?>" 
                       class="btn btn-danger">
                        OFO
                    </a>
                    <?php
                else:
                    ?>
                    <strong>Waiting for Google Response..........</strong><hr />
                    <a href="<?php echo $this->config["URL"]; ?>" 
                       class="btn btn-danger">
                        OFO
                    </a>
                <?php
                endif;
                ?>
            </div>
        </div>
    </div>
</center>
<hr />
