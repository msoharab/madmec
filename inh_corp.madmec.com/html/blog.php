<?php
define("MODULE_0", "config.php");
require_once (MODULE_0);
require_once(CONFIG_ROOT . MODULE_0);
require_once DOC_ROOT . INC . 'header.php';
?>
<div class="aboutus  wow flipInY" >
    <div class="carousel-caption">
        <p class="wow flipInX" style="color:white;">
            Stay up to date with our most recent news and updates.
        </p>
    </div>
</div>
<section class="blog_list">
    <div class="center">
        <h2>Blogs</h2>
    </div>
    <div  class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body table-responsive" id="bloglist">
<!--                        <table id="blog" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>User Name</th>
                                    <th>Blog Title</th>
                                    <th>Image</th>
                                    <th>Description</th>
                                    <th>Url</th>
                                    <th>Blog time</th>
                                </tr>
                            </thead>
                            <tbody id="bloglist">
                            </tbody>
                        </table>-->
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div>
</section><!-- /.content -->
<section>
    <?php
    require_once DOC_ROOT . INC . 'footer.php';
    ?>
    <link href="<?php echo URL . ASSET_CSS; ?>blogs.css" rel="stylesheet" type="text/css" media="screen" />
    <script type="text/javascript">
        $(document).ready(function () {
            window.setTimeout(function () {
                listBlog();
            }, 400);
        });
    </script>