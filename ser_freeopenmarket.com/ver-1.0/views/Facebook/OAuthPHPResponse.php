<?php
$facebook = isset($this->idHolders["pic3pic"]["index"]["facebook"]) ? (array) $this->idHolders["pic3pic"]["index"]["facebook"] : false;
?>
<hr />
<center>
    <h1>
        <i class="fa fa-5x fa-facebook-square"></i>
    </h1>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <?php
                if ($this->FBError != NULL):
                    echo $this->FBError;
                    ?>
                    <a href="<?php echo $this->config["URL"]; ?>" 
                       class="btn btn-danger">
                        Pic3Pic
                    </a>
                    <?php
                elseif ($this->FBData != NULL):
                    echo $this->FBData;
                    ?><hr />
                    Loading.....<i class="fa fa-5x fa-spin fa-spinner"></i><hr />
                    <a href="<?php echo $this->config["URL"]; ?>" 
                       class="btn btn-danger">
                        Pic3Pic
                    </a>
                    <?php
                else:
                    ?>
                    <strong>Waiting for Facebook Response..........</strong><hr />
                    <a href="<?php echo $this->config["URL"]; ?>" 
                       class="btn btn-danger">
                        Pic3Pic
                    </a>
                <?php
                endif;
                ?>
            </div>
        </div>
    </div>
</center>
<hr />
