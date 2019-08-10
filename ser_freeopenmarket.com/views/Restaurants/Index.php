<?php
$restaurant = isset($this->idHolders["onlinefood"]["restaurant"]) ? (array) $this->idHolders["onlinefood"]["restaurant"] : false;
?>
<div class="content-wrapper">
    <div class="content">
        <section class="content-header">
            <h1>
                Restaurant
                <small></small>
            </h1>
            <ol class="breadcrumb">
                <li>
                    <a href="<?php echo $this->config["URL"] . $this->config["CTRL_0"]; ?>">
                        <i class="fa fa-dashboard"></i> Dashboard
                    </a>
                </li>
                <li class="active">Restaurant</li>
            </ol>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#add" data-toggle="tab">Add Restaurant</a></li>
                            <li><a href="#list" data-toggle="tab">List Restaurant</a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="active tab-pane" id="add">
                                <?php
                                require_once 'RestaurantAdd.php';
                                ?>
                            </div>
                            <div class="tab-pane" id="list">
                                <?php
                                require_once 'listRestaurant.php';
                                ?>
                            </div><!-- /.tab-pane -->
                        </div><!-- /.tab-content -->
                    </div><!-- /.nav-tabs-custom -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </section><!-- /.content -->
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        var this_js_script = $("script[src$='Restaurant.js']");
        if (this_js_script) {
            var flag = this_js_script.attr('data-autoloader');
            if (flag === 'true') {
                LogMessages('I am In Restaurant');
                //var para = getJSONIds({
                    //autoloader: true,
                    //action: 'getIdHolders',
                    //url: URL + 'Restaurant/getIdHolders',
                    //type: 'POST',
                    //dataType: 'JSON'
                //}).onlinefood.restaurant;
                //var obj = new RestaurantController();
                //obj.__constructor(para);
                //obj.__AddRestaurant();
            }
            else {
                LogMessages('I am Out Restaurant');
            }
        }
    });
</script>
