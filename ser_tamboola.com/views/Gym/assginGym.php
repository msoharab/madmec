<?php
$gymAss = isset($this->idHolders["tamboola"]["gym"]["AssignGym"]) ? (array) $this->idHolders["tamboola"]["gym"]["AssignGym"] : false;
?>
<form class="form-horizontal"
      novalidate="novalidate"
      action=""
      id="<?php echo $gymAss["form"]; ?>"
      name="<?php echo $gymAss["form"]; ?>"
      method="post">
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title"><strong> Assign Gym</strong></h3>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <select class="form-control"
                                    id="<?php echo $gymAss["fields"][0]; ?>"
                                    name="<?php echo $gymAss["fields"][0]; ?>"
                                    data-rules='{"required": true}'
                                    data-messages='{"required": "Select Owner"}'>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            &nbsp;
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <select class="form-control"
                                    id="<?php echo $gymAss["fields"][1]; ?>"
                                    name="<?php echo $gymAss["fields"][1]; ?>"
                                    data-rules='{"required": true}'
                                    data-messages='{"required": "Select Gym"}'>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            &nbsp;
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 text-center">
                            <button type="submit"
                                    id="<?php echo $gymAss["fields"][2]; ?>"
                                    name="<?php echo $gymAss["fields"][2]; ?>"
                                    data-rules='{}'
                                    data-messages='{}'
                                    class="btn btn-primary">Activate</button>
                            <button type="submit"
                                    id="<?php echo $gymAss["fields"][3]; ?>"
                                    name="<?php echo $gymAss["fields"][3]; ?>"
                                    data-rules='{}'
                                    data-messages='{}'
                                    class="btn btn-danger">Deactivate</button>
                        </div>
                    </div>
                </div><!-- /.box -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </section><!-- /.content -->
</form>
