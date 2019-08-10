<?php
$opslist = isset($this->idHolders["recharge"]["masterdata"]["ListOperator"]) ? (array) $this->idHolders["recharge"]["masterdata"]["ListOperator"] : false;
$optypelist = isset($this->idHolders["recharge"]["masterdata"]["ListOperatorType"]) ? (array) $this->idHolders["recharge"]["masterdata"]["ListOperatorType"] : false;
?>
<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#action2" data-toggle="tab">Operator</a></li>
        <li><a href="#action1" data-toggle="tab">Operator Type</a></li>
    </ul>
    <div class="active tab-content">
        <div class="active tab-pane" id="action2">
            <?php
            require_once 'list_operators.php';
            ?>
        </div>
        <div class="tab-pane" id="action1">
            <?php
            require_once 'list_operator_type.php';
            ?>
        </div>
    </div><!-- /.nav-tabs-custom -->
</div><!-- /.col -->
