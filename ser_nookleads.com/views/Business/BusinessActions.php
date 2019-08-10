<?php
$chreport = $this->idHolders["nookleads"]["business"]["report"];
$chsubscribe = $this->idHolders["nookleads"]["business"]["subscribe"];
$chblock = $this->idHolders["nookleads"]["business"]["block"];
?>
<div class="btn-group gap-right sm-pad-top">
    <a href="javascript:void(0);"
       id="<?php echo $chDiv["approval"]["id"]; ?>"
       name="<?php echo $businessId; ?>"
       class="<?php echo $chDiv["approval"]["class"]; ?>">
           <?php echo $chDiv["approval"]["text"]; ?>
    </a>
    <span style="padding-right:20px;"></span>
    <a href="javascript:void(0);"
       id="<?php echo $chDiv["disapproval"]["id"]; ?>"
       name="<?php echo $businessId; ?>"
       class="<?php echo $chDiv["disapproval"]["class"]; ?>">
           <?php echo $chDiv["disapproval"]["text"]; ?>
    </a>
</div>
<?php if ($this->UserId == $this->BusinessDetails["business"]["chuid"]): ?>
    <div class="btn-group gap-right sm-pad-top">
        <button type="button"
                id="<?php echo $this->idHolders["nookleads"]["business"]["home"]["create"]["parentBut"]; ?>"
                name="<?php echo $this->idHolders["nookleads"]["business"]["home"]["create"]["parentBut"]; ?>"
                data-toggle="modal"
                data-target="#<?php echo $this->idHolders["nookleads"]["business"]["home"]["create"]["parentDiv"]; ?>"
                data-whatever="@mdo"
                class="btn btn-danger  pull-right btn-circle">
            Lead
        </button>
    </div>
<?php endif; ?>
<?php
if ($this->UserId != $this->BusinessDetails["business"]["chuid"]):
    ?>
    <div class="btn-group gap-right sm-pad-top"
         id="<?php echo $chreport["parentDiv"] . $businessId; ?>">
        <button type="button" class="btn btn-danger  pull-right dropdown-toggle btn-circle" data-toggle="dropdown">
            <?php echo $chreport["icon"]; ?>
        </button>
        <ul class="dropdown-menu slidedown"
            id="<?php echo $chreport["outputDiv"] . $businessId; ?>">
                <?php
                for ($lp = 0; $lp < count($chreport) && isset($chreport[$lp]); $lp++) {
                    if ($chreport[$lp]["status_id"] === 4):
                        ?>
                    <li name="<?php echo $businessId; ?>">
                        <a href="javascript:void(0);"
                           id="<?php echo $chreport[$lp]["id"] . $businessId; ?>"
                           name="<?php echo $chreport[$lp]["acid"]; ?>"
                           class="<?php echo $chreport[$lp]["class"]; ?>">
                               <?php echo $chreport[$lp]["text"]; ?>
                        </a>
                    </li>
                    <li><div class="divider"></div></li>
                    <?php
                endif;
            }
            ?>
            <li><div class="clearfix"></div></li>
        </ul>
    </div>
    <div class="btn-group gap-right sm-pad-top"
         id="<?php echo $chblock["parentDiv"] . $businessId; ?>">
        <button class="btn btn-danger pull-right btn-circle"
                data-toggle="modal"
                data-target="#<?php echo $chblock["parentDiv"]; ?>">
                    <?php echo $chblock["icon"]; ?>
        </button>
    </div>
    <div class="btn-group gap-right sm-pad-top"
         id="<?php echo $chsubscribe["parentDiv"] . $businessId; ?>">
        <button class="btn btn-danger  pull-right btn-circle" data-toggle="modal" data-target="#<?php echo $chsubscribe["parentDiv"]; ?>">
            <?php echo $chsubscribe["icon"]; ?>
        </button>
    </div>
<?php endif; ?>
