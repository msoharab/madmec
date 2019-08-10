<?php
$serviceAdd = isset($this->idHolders["recharge"]["masterdata"]["AddService"]) ? (array) $this->idHolders["recharge"]["masterdata"]["AddService"] : false;
?>
<div class="content">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Add Service
        </h1>
    </section>
    <!-- Post -->
    <section class="content">
        <form class="form-horizontal"
              action=""
              id="<?php echo $serviceAdd["form"]; ?>"
              name="<?php echo $serviceAdd["form"]; ?>"
              method="post">
            <div class="box">
                <div class="box-header with-border">
                    <strong></strong>
                </div>
                <div class="box-body">
                    <div class="col-sm-12 ">
                        <div class="form-group">
                            <label for="inputcomp" class="col-sm-2 control-label">Company</label>
                            <div class="col-sm-8">
                                <select class="form-control"
                                        id="<?php echo $serviceAdd["fields"][0]; ?>"
                                        name="<?php echo $serviceAdd["fields"][0]; ?>"
                                        data-rules='{"required": true}'
                                        data-messages='{"required": "Select Company"}'>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputName" class="col-sm-1 control-label">Service Name</label>
                            <div class="col-sm-5">
                                <input type="text"
                                       class="form-control"
                                       id="<?php echo $serviceAdd["fields"][1]; ?>"
                                       name="<?php echo $serviceAdd["fields"][1]; ?>"
                                       data-rules='{"required": true}'
                                       data-messages='{"required": "Enter Service Name"}'
                                       placeholder="Service Name">
                            </div>
                            <label for="inputType" class="col-sm-1 control-label">Service LT code</label>
                            <div class="col-sm-5">
                                <input  type="text"
                                        class="form-control"
                                        id="<?php echo $serviceAdd["fields"][2]; ?>"
                                        name="<?php echo $serviceAdd["fields"][2]; ?>"
                                        data-rules='{"required": true,"minlength":"2"}'
                                        data-messages='{"required": "Enter Service LT code","minlength":"Length Should be minimum 2 Characters"}'
                                        placeholder="Service LT code">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputName" class="col-sm-1 control-label">Flat Commission</label>
                            <div class="col-sm-5">
                                <input type="text"
                                       class="form-control"
                                       id="<?php echo $serviceAdd["fields"][3]; ?>"
                                       name="<?php echo $serviceAdd["fields"][3]; ?>"
                                       data-rules='{"required": true}'
                                       data-messages='{"required": "Enter Flat Commission"}'
                                       placeholder="Flat Commission">
                            </div>
                            <label for="inputType" class="col-sm-1 control-label">Variable Commission</label>
                            <div class="col-sm-5">
                                <input  type="text"
                                        class="form-control"
                                        id="<?php echo $serviceAdd["fields"][4]; ?>"
                                        name="<?php echo $serviceAdd["fields"][4]; ?>"
                                        data-rules='{"required": true}'
                                        data-messages='{"required": "Enter Variable Commission"}'
                                        placeholder="Variable Commission">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 form-group">
                        <div class="text-center">
                            <button type="submit"
                                    id="<?php echo $serviceAdd["fields"][5]; ?>"
                                    name="<?php echo $serviceAdd["fields"][5]; ?>"
                                    data-rules='{}'
                                    data-messages='{}'
                                    class="btn btn-primary">Add Service</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section><!-- /.content -->
</div>
