<?php
define("MODULE_0", "config.php");
require_once (MODULE_0);
require_once(CONFIG_ROOT . MODULE_0);
require_once DOC_ROOT . INC . 'header.php';
if (isset($_GET['id'])) {
    $id = $_GET['id'];
}
?>
<div class="aboutus  wow flipInY" >
    <div class="carousel-caption">
        <p class="wow flipInX" style="color:white;">
            Stay up to date with our most recent news and updates.
        </p>
    </div>
</div>
<section>
    <section id="blogreply">
        <div class="container">
            <div class="row col-xs-12">
                <div class="center">
                    <h4>Blog Review</h4>
                </div>
                <form id="blogreplyform" name="blogreplyform" method="post">
                    <div class="col-sm-12 center">
                        <div class="form-group">
                            <input type="hidden" name="id" id="id" class="form-control" value="<?php echo $id; ?>">
                        </div>
                        <div class="col-lg-10 col-lg-offset-1">
                            <div class="form-group">
                                <label for="name">
                                    User Name *</label>
                                <input type="text" name="name" id="name" class="form-control" placeholder="User Name" required="required" />
                            </div>
                            <div class="form-group">
                                <label for="email">
                                    Email *</label>
                                <input type="email" name="email" id="email" class="form-control" placeholder="Email Id" required="required" />
                            </div>
                            <div class="form-group">
                                <label for="desc">
                                    Description</label>
                                <textarea name="message" id="message" class="form-control" rows="9" cols="25" required="required"
                                          placeholder="Description"></textarea>
                            </div>
                            <div class="col-md-12 center">
                                <button type="submit" id="blogreply" name="blogreply" class="btn btn-primary btn-lg ">SUBMIT</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <?php
    require_once DOC_ROOT . INC . 'footer.php';
    ?>
    <link href="<?php echo URL . ASSET_CSS; ?>blogs.css" rel="stylesheet" type="text/css" media="screen" />
    <script type="text/javascript">
        $(document).ready(function () {
            window.setTimeout(function () {
                blogreply();
            }, 400);
        });
    </script>