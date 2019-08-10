<?php
$googleplus = isset($this->idHolders["nookleads"]["index"]["googleplus"]) ? (array) $this->idHolders["nookleads"]["index"]["googleplus"] : false;
var_dump($this->GPData);
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
                        nOOkLeads
                    </a>
                    <?php
                elseif ($this->GPData != NULL):
                    var_dump($this->GPData);
                    ?><hr />
                    Loading.....<i class="fa fa-5x fa-spin fa-spinner"></i><hr />
                    <a href="<?php echo $this->config["URL"]; ?>" 
                       class="btn btn-danger">
                        nOOkLeads
                    </a>
                    <?php
                else:
                    ?>
                    <strong>Waiting for Google Response..........</strong><hr />
                    <a href="<?php echo $this->config["URL"]; ?>" 
                       class="btn btn-danger">
                        nOOkLeads
                    </a>
                <?php
                endif;
                ?>
            </div>
        </div>
    </div>
</center>
<hr />
