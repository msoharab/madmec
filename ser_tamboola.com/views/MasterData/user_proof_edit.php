<?php
$UsrProf = isset($this->idHolders["recharge"]["masterdata"]["EditProof"]) ? (array) $this->idHolders["recharge"]["masterdata"]["EditProof"] : false;
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Edit Id Proof
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $this->config["URL"] . $this->config["CTRL_19"]; ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Edit Id Proof</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Edit</h3>
                    </div><!-- /.box-header -->
                    <form class="form-horizontal"
                          action=""
                          id="<?php echo $UsrProf["form"]; ?>"
                          name="<?php echo $UsrProf["form"]; ?>"
                          method="post">
                        <div class="content">
                            <section class="content">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="box">
                                            <div class="box-body">
                                                <input type="hidden"
                                                       name="<?php echo $UsrProf["fields"][3]; ?>"
                                                       id="<?php echo $UsrProf["fields"][3]; ?>"
                                                       data-rules='{}'
                                                       data-messages='{}'
                                                       value="<?php echo base64_encode($this->getuserDet["data"]["portal_proof_id"]); ?>" />
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label for="inputbusiness" class="col-sm-1 control-label">Country</label>
                                                        <div class="col-sm-5">
                                                            <select class="form-control"
                                                                    id="<?php echo $UsrProf["fields"][0]; ?>"
                                                                    name="<?php echo $UsrProf["fields"][0]; ?>"
                                                                    data-rules='{"required": true}'
                                                                    data-messages='{"required": "Select Country"}'>
                                                            </select>
                                                        </div>
                                                        <label for="inputbusiness" class="col-sm-1 control-label">User Proof</label>
                                                        <div class="col-sm-5">
                                                            <input class="form-control"
                                                                   id="<?php echo $UsrProf["fields"][1]; ?>"
                                                                   name="<?php echo $UsrProf["fields"][1]; ?>"
                                                                   value="<?php echo trim($this->getuserDet["data"]["portal_proof_name"]); ?>"
                                                                   data-rules='{"required": true,"minlength": "2"}'
                                                                   data-messages='{"required": "Enter User Proof","minlength": "Length Should be minimum 2 numbers"}'
                                                                   placeholder="User Proof" type="text">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><!-- /.box-body -->
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-offset-5 col-sm-10">
                                                <button type="submit"
                                                        class="btn btn-danger"
                                                        id="<?php echo $UsrProf["fields"][2]; ?>"
                                                        name="<?php echo $UsrProf["fields"][2]; ?>"
                                                        data-rules='{}'
                                                        data-messages='{}'>Update Details</button>
                                            </div>
                                        </div>
                                    </div>
                            </section>
                        </div><!-- /.tab-pane -->
                    </form>
                </div>
            </div>
            <!-- /. box -->
        </div>
    </section>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        var para = getJSONIds({
            autoloader: true,
            action: 'getIdHolders',
            url: URL + 'MasterData/getIdHolders',
            type: 'POST',
            dataType: 'JSON'
        }).tamboola.masterdata;
        var obj = new masterdataController();
        obj.__constructor(para);
        obj.__ProofEdit();
    });
</script>