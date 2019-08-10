<?php
$home = isset($this->idHolders["tamboola"]["home"]) ? (array) $this->idHolders["tamboola"]["home"] : false;
$searchGym = isset($this->idHolders["tamboola"]["home"]["searchGym"]) ? (array) $this->idHolders["tamboola"]["home"]["searchGym"] : false;
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Home
        </h1>
        <ol class="breadcrumb">
            <li class="active">Home</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <form class="form-horizontal"
                    action=""
                    id="<?php echo $searchGym["form"]; ?>"
                    name="<?php echo $searchGym["form"]; ?>"
                    novalidate="novalidate"
                    method="post">
                    <select class="form-control"
                            id="<?php echo $searchGym["fields"][0]; ?>"
                            name="<?php echo $searchGym["fields"][0]; ?>"
                            data-rules='{}'
                            data-messages='{}'>
                    </select>
                    </form>
            </div>
            <div class="col-xs-12">&nbsp;</div>
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title"><strong>See all your Gyms</strong></h3>
                    </div>
                    <?php
                    require_once 'gymPanelView.php';
                    ?>
                </div>
            </div>
        </div>
    </section><!-- /.content -->
</div>
<script data-autoloader="false" type="text/javascript" src="<?php echo $this->config["URL"] . $this->config["VIEWS"] . $this->config["ASSSET_REG"] . $this->config["CONTROLLERS"]; ?>Gym.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        var this_js_script = $("script[src$='Home.js']");
        if (this_js_script) {
            var flag = this_js_script.attr('data-autoloader');
            if (flag === 'true') {
                LogMessages('I am In Home');
                var para = getJSONIds({
                    autoloader: true,
                    action: 'getIdHolders',
                    url: URL + 'Home/getIdHolders',
                    type: 'POST',
                    dataType: 'JSON'
                }).tamboola;
                var obj = new homeController();
                obj.__constructor(para);
                obj.__gymSearch();
            }
            else {
                LogMessages('I am Out Home');
            }
        }
    });
</script>
