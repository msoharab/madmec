<?php
$oprs = isset($this->idHolders["onlinefood"]["gateway"]["AddOperator"]) ? (array) $this->idHolders["onlinefood"]["gateway"]["AddOperator"] : false;
?>
<form class="form-horizontal"
      action=""
      id="<?php echo $oprs["form"]; ?>"
      name="<?php echo $oprs["form"]; ?>"
      method="post">
    <div class="box">
        <div class="box-header with-border">
            <section class="content-header">
                <h1>
                    Gateway Operator
                </h1>
            </section>
        </div>
        <div class="box-body">
            <div class="col-sm-12">
                <div class="form-group">
                    <label for="inputservicee" class="col-sm-1 control-label">Gateway</label>
                    <div class="col-sm-5">
                        <select class="form-control"
                                id="<?php echo $oprs["fields"][0]; ?>"
                                name="<?php echo $oprs["fields"][0]; ?>"
                                data-rules='{"required": true}'
                                data-messages='{"required": "Select Gateway"}'>
                        </select>
                    </div>
                    <label for="inputType" class="col-sm-1 control-label">Operator name</label>
                    <div class="col-sm-5">
                        <input  type="text"
                                class="form-control"
                                id="<?php echo $oprs["fields"][1]; ?>"
                                name="<?php echo $oprs["fields"][1]; ?>"
                                data-rules='{"required": true,"minlength": "4"}'
                                data-messages='{"required": "Enter Operator name","minlength": "Length Should be minimum 4 Characters"}'
                                placeholder="Operator name">
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="form-group">
                    <label for="inputservicee" class="col-sm-1 control-label">Operator Code</label>
                    <div class="col-sm-5">
                        <input  type="text"
                                class="form-control"
                                id="<?php echo $oprs["fields"][2]; ?>"
                                name="<?php echo $oprs["fields"][2]; ?>"
                                data-rules='{"required": true,"minlength": "2"}'
                                data-messages='{"required": "Enter Operator Code","minlength": "Length Should be minimum 2 Characters"}'
                                placeholder="Operator Code">
                    </div>
                    <label for="inputType" class="col-sm-1 control-label">Operator Alias</label>
                    <div class="col-sm-5">
                        <input  type="text"
                                class="form-control"
                                id="<?php echo $oprs["fields"][3]; ?>"
                                name="<?php echo $oprs["fields"][3]; ?>"
                                data-rules='{"required": true,"minlength": "3"}'
                                data-messages='{"required": "Enter Operator Alias","minlength": "Length Should be minimum 3 Characters"}'
                                placeholder="Operator Alias">
                    </div>
                </div>
            </div>
             <div class="col-sm-12">
                <div class="form-group">
                    <label for="inputName" class="col-sm-1 control-label">Flat Commission</label>
                    <div class="col-sm-5">
                        <input type="text"
                               class="form-control"
                               id="<?php echo $oprs["fields"][4]; ?>"
                               name="<?php echo $oprs["fields"][4]; ?>"
                               data-rules='{"required": true}'
                               data-messages='{"required": "Enter Flat Commission"}'
                               placeholder="Flat Commission">
                    </div>
                    <label for="inputType" class="col-sm-1 control-label">Variable Commission</label>
                    <div class="col-sm-5">
                        <input  type="text"
                                class="form-control"
                                id="<?php echo $oprs["fields"][5]; ?>"
                                name="<?php echo $oprs["fields"][5]; ?>"
                                data-rules='{"required": true}'
                                data-messages='{"required": "Enter Variable Commission"}'
                                placeholder="Variable Commission">
                    </div>
                </div>
            </div>
            <div class="col-sm-12 form-group">
                <div class="text-center">
                    <button type="submit"
                            id="<?php echo $oprs["fields"][6]; ?>"
                            name="<?php echo $oprs["fields"][6]; ?>"
                            data-rules='{}'
                            data-messages='{}'
                            class="btn btn-primary">Add Operator</button>
                </div>
            </div>
        </div>
    </div>
</form>
