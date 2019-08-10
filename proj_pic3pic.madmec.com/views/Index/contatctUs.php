<?php
$contuctus = isset($this->idHolders["pic3pic"]["index"]["contactus"]) 
        ? (array) $this->idHolders["pic3pic"]["index"]["contactus"] 
        : false;
?>
<!-- Modal for contact us start -->
<div class="modal fade" id="<?php echo $contuctus["target"]?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" 
                        class="close" 
                        data-dismiss="modal" 
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Contact Us</h4>
            </div>
            <div class="modal-body">
                <form role="form" action="" method="post" >
                    <div class="form-group">
                        <label for="InputName">Your Name</label>
                        <div class="input-group">
                            <input type="text" 
                                   class="form-control" 
                                   name="InputName" 
                                   id="InputName" 
                                   placeholder="Enter Name" required />
                            <span class="input-group-addon">
                                <i class="glyphicon glyphicon-ok form-control-feedback"></i>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="InputEmail">Your Email</label>
                        <div class="input-group">
                            <input type="email" 
                                   class="form-control" 
                                   id="InputEmail" 
                                   name="InputEmail" 
                                   placeholder="Enter Email" required  />
                            <span class="input-group-addon">
                                <i class="glyphicon glyphicon-ok form-control-feedback"></i>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="InputEmail">Category </label>
                        <select name="colors" class="form-control" >
                            <span class="input-group-addon">
                                <i class="glyphicon glyphicon-ok form-control-feedback"></i>
                            </span>
                            <option value="" selected disabled>--Please Select--</option>
                            <option value="black">Bug Report</option>
                            <option value="blue">Add New Language</option>
                            <option value="green">Question</option>
                            <option value="orange">Suggestion</option>
                            <option value="orange">Complain</option>
                            <option value="red">Other Inquires</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="InputMessage">Message</label>
                        <div class="input-group">
                            <textarea 
                                name="InputMessage" 
                                id="InputMessage" 
                                class="form-control" 
                                rows="5" required></textarea>
                            <span class="input-group-addon">
                                <i class="glyphicon glyphicon-ok form-control-feedback"></i>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="InputReal">What is 4+3? (Simple Spam Checker)</label>
                        <div class="input-group">
                            <input type="text" 
                                   class="form-control" 
                                   name="InputReal" 
                                   id="InputReal" required/>
                            <span class="input-group-addon">
                                <i class="glyphicon glyphicon-ok form-control-feedback"></i>
                            </span>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Submit</button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal for contact us end -->