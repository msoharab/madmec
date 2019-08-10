<?php
$AddGroup = isset($this->idHolders["tamboola"]["groups"]["AddGroups"]) ? (array) $this->idHolders["tamboola"]["enquiry"]["AddGroups"] : false;
?>
<div class="content-wrapper">
    <div class="content">
        <section class="content-header">
            <h1>
                Groups
                <small></small>
            </h1>
            <ol class="breadcrumb">
                <li>
                    <a href="<?php echo $this->config["URL"] . $this->config["CTRL_19"]; ?>">
                        <i class="fa fa-dashboard"></i> Dashboard
                    </a>
                </li>
                <li class="active">Groups</li>
            </ol>
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title"><strong>Add Group</strong></h3>
                        </div>
                        <div class="box-body" id="userbox">
                            <form class="form-horizontal"
                                  action=""
                                  id="<?php echo $AddGroup["form"]; ?>"
                                  name="<?php echo $AddGroup["form"]; ?>"
                                  method="post">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="inputdesc" class="col-sm-1  control-label">Group Name</label>
                                        <div class="col-sm-11 ">
                                            <input type="text"
                                                   class="form-control"
                                                   id="<?php echo $AddGroup["fields"][0]; ?>"
                                                   name="<?php echo $AddGroup["fields"][0]; ?>"
                                                   data-rules='{"required": true,"maxlength":15}'
                                                   data-messages='{"required": "Enter Group Name","maxlength":"Maximum 15 characters allowed"}'
                                                   placeholder="Group Name" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="inputgymtype" class="col-sm-1  control-label">Number of customers</label>
                                        <div class="col-sm-5">
                                            <select class="form-control"
                                                    id="<?php echo $AddGroup["fields"][1]; ?>"
                                                    name="<?php echo $AddGroup["fields"][1]; ?>"
                                                    data-rules='{"required": true}'
                                                    data-messages='{"required": "Select Number of customers"}'>
                                            </select>
                                        </div>
                                        <label for="inputgymtype" class="col-sm-1  control-label">Mode of payments</label>
                                        <div class="col-sm-5">
                                            <select class="form-control"
                                                    id="<?php echo $AddGroup["fields"][2]; ?>"
                                                    name="<?php echo $AddGroup["fields"][2]; ?>"
                                                    data-rules='{"required": true}'
                                                    data-messages='{"required": "Select Mode of payments"}'>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="inputdesc" class="col-sm-1 control-label">Description</label>
                                        <div class="col-sm-11">
                                            <textarea class="form-control"
                                                      id="<?php echo $AddGroup["fields"][3]; ?>"
                                                      name="<?php echo $AddGroup["fields"][3]; ?>" rows="9"
                                                      data-rules='{"required": true}'
                                                      data-messages='{"required": "Enter Description"}'
                                                      placeholder="Description"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-offset-5 col-sm-10">
                                        <button type="submit"
                                                class="btn btn-primary"
                                                id="<?php echo $AddGroup["fields"][4]; ?>"
                                                name="<?php echo $AddGroup["fields"][4]; ?>"
                                                data-rules='{}'
                                                data-messages='{}'>Save Group</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
