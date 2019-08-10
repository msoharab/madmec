<?php
$chreport = $this->idHolders["pic3pic"]["channel"]["report"];
$chsubscribe = $this->idHolders["pic3pic"]["channel"]["subscribe"];
$chblock = $this->idHolders["pic3pic"]["channel"]["block"];
?>
<div class="btn-group gap-right sm-pad-top">        
    <a href="javascript:void(0);" 
       id="<?php echo $chDiv["like"]["id"]; ?>" 
       name="<?php echo $channelId; ?>" 
       class="<?php echo $chDiv["like"]["class"]; ?>">
           <?php echo $chDiv["like"]["text"]; ?>
    </a>
    <span style="padding-right:20px;"></span>
    <a href="javascript:void(0);" 
       id="<?php echo $chDiv["dislike"]["id"]; ?>" 
       name="<?php echo $channelId; ?>" 
       class="<?php echo $chDiv["dislike"]["class"]; ?>">
           <?php echo $chDiv["dislike"]["text"]; ?>
    </a>
</div>
<?php if ($this->UserId == $this->ChannelDetails["channel"]["chuid"]): ?>
    <div class="btn-group gap-right sm-pad-top">
        <button type="button" 
                id="<?php echo $this->idHolders["pic3pic"]["post"]["create"]["parentBut"]; ?>" 
                name="<?php echo $this->idHolders["pic3pic"]["post"]["create"]["parentBut"]; ?>" 
                data-toggle="modal" 
                data-target="#<?php echo $this->idHolders["pic3pic"]["post"]["create"]["parentDiv"]; ?>" 
                data-whatever="@mdo" 
                class="btn btn-danger  pull-right btn-circle">
            Post
        </button>
    </div>
<?php endif; ?>
<?php
if ($this->UserId != $this->ChannelDetails["channel"]["chuid"]):
    ?>
    <div class="btn-group gap-right sm-pad-top" 
         id="<?php echo $chreport["parentDiv"] . $channelId; ?>">
        <button type="button" class="btn btn-danger  pull-right dropdown-toggle btn-circle" data-toggle="dropdown">
            <?php echo $chreport["icon"]; ?>
        </button>
        <ul class="dropdown-menu slidedown" 
            id="<?php echo $chreport["outputDiv"] . $channelId; ?>">
                <?php
                for ($lp = 0; $lp < count($chreport) && isset($chreport[$lp]); $lp++) {
                    if ($chreport[$lp]["status_id"] === 4):
                        ?>
                    <li name="<?php echo $channelId; ?>">
                        <a href="javascript:void(0);" 
                           id="<?php echo $chreport[$lp]["id"] . $channelId; ?>" 
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
         id="<?php echo $chblock["parentDiv"] . $channelId; ?>">
        <button class="btn btn-danger pull-right btn-circle" 
                data-toggle="modal" 
                data-target="#<?php echo $chblock["parentDiv"]; ?>">
                    <?php echo $chblock["icon"]; ?>
        </button>
    </div>
    <div class="btn-group gap-right sm-pad-top" 
         id="<?php echo $chsubscribe["parentDiv"] . $channelId; ?>">
        <button class="btn btn-danger  pull-right btn-circle" data-toggle="modal" data-target="#<?php echo $chsubscribe["parentDiv"]; ?>">
            <?php echo $chsubscribe["icon"]; ?>
        </button>
    </div>
<?php endif; ?>
