<?php
$listMsg = isset($this->BusinessDetails["chmsg"]) ? (array) $this->BusinessDetails["chmsg"] : array();
?>
<div class="panel">
    <div class="panel-heading">
        <h3>Messages</h3>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="box box-primary direct-chat direct-chat-primary">
                    <div style="display: block;" class="box-body">
                        <div class="direct-chat-messages">
                            <?php
                            if (count($listMsg["chmsgid"]) > 0 && isset($listMsg["chmsgtime"][0]) && !empty($listMsg["chmsgtime"][0])):
                                for ($i = 0; $i < count($listMsg["chmsgid"]) && isset($listMsg["chmsgid"][$i]); $i++) {
                                    ?>
                                    <div class="direct-chat-msg">
                                        <div class="direct-chat-info clearfix">
                                            <span class="direct-chat-name pull-left"><?php echo $listMsg["msginname"][$i]; ?></span>
                                            <span class="direct-chat-timestamp pull-right"><?php echo $listMsg["chmsgtime"][$i]; ?></span>
                                        </div>
                                        <img class="direct-chat-img" src="<?php echo $listMsg["msginpic"][$i]; ?>" alt="Profile">
                                        <div class="direct-chat-text">
                                            <?php echo $listMsg["message"][$i]; ?>
                                        </div>
                                    </div>
                                    <?php
                                }
                            else :
                                ?>
                                <div class="direct-chat-msg">There are no messages to show.</div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
