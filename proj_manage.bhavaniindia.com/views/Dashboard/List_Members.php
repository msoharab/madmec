<?php
$List = isset($this->idHolders["ricepark"]["dashboard"]["ListMembers"]) ? (array) $this->idHolders["ricepark"]["dashboard"]["ListMembers"] : false;
?>
<div id="content-outer">
    <!-- start content -->
    <div id="content">
        <!--  start page-heading -->
        <div id="page-heading">
            <h1>Members List</h1>
        </div>
        <!-- end page-heading -->
        <table border="0" width="100%" cellpadding="0" cellspacing="0" id="content-table">
            <tr>
                <th rowspan="3" class="sized"><img src="<?php echo $this->config["URL"] . $this->config["VIEWS"] . $this->config["ASSSET_IMG"]; ?>/shared/side_shadowleft.jpg" width="20" height="300" alt="" /></th>
                <th class="topleft"></th>
                <td id="tbl-border-top">&nbsp;</td>
                <th class="topright"></th>
                <th rowspan="3" class="sized"><img src="<?php echo $this->config["URL"] . $this->config["VIEWS"] . $this->config["ASSSET_IMG"]; ?>/shared/side_shadowright.jpg" width="20" height="300" alt="" /></th>
            </tr>
            <tr>
                <td id="tbl-border-left"></td>
                <td>
                    <!--  start content-table-inner ...................................................................... START -->
                    <div id="content-table-inner">
                        <!--  start table-content  -->
                        <div id="table-content">
                            <!--  start product-table ..................................................................................... -->
                            <div>
                                <table id="<?php echo $List["fields"][0]; ?>"  border="0" width="100%" cellpadding="0" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Designation</th>
                                            <th>Email</th>
                                            <th>Mobile</th>
                                            <th>Address</th>
                                            <th>Facebook</th>
                                            <th>Image</th>
                                            <th>Date</th>
                                            <th>Edit</th>
                                            <th>Delete</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                                <!--  end product-table................................... -->
                            </div>
                        </div>
                        <!--  end content-table  -->
                        <div class="clear"></div>
                    </div>
                    <!--  end content-table-inner ............................................END  -->
                </td>
                <td id="tbl-border-right"></td>
            </tr>
            <tr>
                <th class="sized bottomleft"></th>
                <td id="tbl-border-bottom">&nbsp;</td>
                <th class="sized bottomright"></th>
            </tr>
        </table>
        <div class="clear">&nbsp;</div>
    </div>
    <!--  end content -->
    <div class="clear">&nbsp;</div>
</div>
<!--  end content-outer........................................................END -->
<script>$(document).ready(function () {
        var this_js_script = $("script[src$='Dashboard.js']");
        if (this_js_script) {
            var flag = this_js_script.attr('data-autoloader');
            if (flag === 'true') {
                LogMessages('I am In Dashboard');
                var para = getJSONIds({
                    autoloader: true,
                    action: 'getIdHolders',
                    url: URL + 'Dashboard/getIdHolders',
                    type: 'POST',
                    dataType: 'JSON'
                }).ricepark.dashboard;
                var obj = new dashboardController();
                obj.__constructor(para);
                obj.__ListMembers(para);
            }
            else {
                LogMessages('I am Out Dashboard');
            }
        }
    });
</script>