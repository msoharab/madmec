<?php
$fpassword = isset($this->idHolders["tamboola"]["index"]["ForgotPassword"]) ? (array) $this->idHolders["tamboola"]["index"]["ForgotPassword"] : false;
?>
<div class="modal-primary">
    <div class="modal-dialog">
        <form action="" 
              id="<?php echo $fpassword["form"]; ?>" 
              name="<?php echo $fpassword["form"]; ?>" 
              method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Forgot Password</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group has-feedback">
                        <input type="email" 
                               class="form-control" 
                               id="<?php echo $fpassword["fields"][0]; ?>" 
                               name="<?php echo $fpassword["fields"][0]; ?>"  
                               data-rules='{"required": true,"email": true,"minlength": "8"}'
                               data-messages='{"required": "Enter Email ID","email": "Enter Email id","minlength": "Length Should be minimum 8 Characters"}'
                               placeholder="Email">
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" 
                            id="<?php echo $fpassword["fields"][1]; ?>" 
                            name="<?php echo $fpassword["fields"][1]; ?>"  
                            data-rules='{}'
                            data-messages='{}'
                            class="btn btn-outline">Send</button>
                </div>
            </div><!-- /.modal-content -->
        </form>
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script type="text/javascript">
    $(document).ready(function () {
        var para = getJSONIds({
            autoloader: true,
            action: 'getIdHolders',
            url: '<?php echo $this->config["URL"] . $this->config["CTRL_18"] . 'getIdHolders' ?>',
            type: 'POST',
            dataType: 'JSON'
        }).tamboola.index;
        var obj = new ForgotPassword();
        obj.__constructor(para);
        obj.__SendPass();
    });
</script>
