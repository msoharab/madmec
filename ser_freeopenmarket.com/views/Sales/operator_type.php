<?php
$oprtype = isset($this->idHolders["onlinefood"]["gateway"]["AddOperatorType"]) ? (array) $this->idHolders["onlinefood"]["gateway"]["AddOperatorType"] : false;
?>
<form class="form-horizontal"
      action=""
      id="<?php echo $oprtype["form"]; ?>"
      name="<?php echo $oprtype["form"]; ?>"
      method="post">
    <div class="box">
        <div class="box-header with-border">
            <section class="content-header">
                <h1>
                    Gateway Operator Type
                </h1>
            </section>
        </div>
        <div class="box-body">
            <div class="col-sm-12">
                <div class="form-group">
                    <label for="inputservicee" class="col-sm-2 control-label">Operator</label>
                    <div class="col-sm-9">
                        <select class="form-control"
                                id="<?php echo $oprtype["fields"][0]; ?>"
                                name="<?php echo $oprtype["fields"][0]; ?>"
                                data-rules='{"required": true}'
                                data-messages='{"required": "Select operator"}'>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="form-group">
                    <label for="inputType" class="col-sm-1 control-label">Operator type</label>
                    <div class="col-sm-5">
                        <input  type="text"
                                class="form-control"
                                id="<?php echo $oprtype["fields"][1]; ?>"
                                name="<?php echo $oprtype["fields"][1]; ?>"
                                data-rules='{"required": true,"minlength": "3"}'
                                data-messages='{"required": "Enter Operator type","minlength": "Length Should be minimum 3 Characters"}'
                                placeholder="Operator type">
                    </div>
                    <label for="inputservicee" class="col-sm-1 control-label">Operator LT Code</label>
                    <div class="col-sm-5">
                        <input  type="text"
                                class="form-control"
                                id="<?php echo $oprtype["fields"][2]; ?>"
                                name="<?php echo $oprtype["fields"][2]; ?>"
                                data-rules='{"required": true,"minlength": "2"}'
                                data-messages='{"required": "Enter Operator LT Code","minlength": "Length Should be minimum 2 Characters"}'
                                placeholder="Operator LT Code">
                    </div>
                </div>
            </div>
             <div class="col-sm-12">
                <div class="form-group">
                    <label for="inputName" class="col-sm-1 control-label">Flat Commission</label>
                    <div class="col-sm-5">
                        <input type="text"
                               class="form-control"
                               id="<?php echo $oprtype["fields"][3]; ?>"
                               name="<?php echo $oprtype["fields"][3]; ?>"
                               data-rules='{"required": true}'
                               data-messages='{"required": "Enter Flat Commission"}'
                               placeholder="Flat Commission">
                    </div>
                    <label for="inputType" class="col-sm-1 control-label">Variable Commission</label>
                    <div class="col-sm-5">
                        <input  type="text"
                                class="form-control"
                                id="<?php echo $oprtype["fields"][4]; ?>"
                                name="<?php echo $oprtype["fields"][4]; ?>"
                                data-rules='{"required": true}'
                                data-messages='{"required": "Enter Variable Commission"}'
                                placeholder="Variable Commission">

                    </div>
                </div>
            </div>
            <div class="col-sm-12 form-group">
                <div class="text-center">
                    <button type="submit"
                            id="<?php echo $oprtype["fields"][5]; ?>"
                            name="<?php echo $oprtype["fields"][5]; ?>"
                            data-rules='{}'
                            data-messages='{}'
                            class="btn btn-primary">Add Operator Type</button>
                </div>
            </div>
        </div>
    </div>
</form>
