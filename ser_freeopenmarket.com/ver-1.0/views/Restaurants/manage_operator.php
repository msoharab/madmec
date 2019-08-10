<?php
$optype = isset($this->idHolders["recharge"]["masterdata"]["AddOperatorType"]) ? (array) $this->idHolders["recharge"]["masterdata"]["AddOperatorType"] : false;
$ops = isset($this->idHolders["recharge"]["masterdata"]["AddOperator"]) ? (array) $this->idHolders["recharge"]["masterdata"]["AddOperator"] : false;
?>
<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#act1" data-toggle="tab" id="<?php echo $ops["parentBut"]; ?>">Operator</a></li>
        <li><a href="#act2" data-toggle="tab"  id="<?php echo $optype["parentBut"]; ?>">Operator Type</a></li>
    </ul>
    <div class="tab-content">
        <div class="active tab-pane" id="act1">
            <?php
            require_once 'operator.php';
            ?>
        </div>
        <div class="tab-pane" id="act2">
            <?php
            require_once 'operator_type.php';
            ?>
        </div><!-- /.tab-content -->
    </div><!-- /.nav-tabs-custom -->
</div><!-- /.col -->
