<?php
define("MODULE_0", "config.php");
require_once (MODULE_0);
require_once(CONFIG_ROOT . MODULE_0);
require_once DOC_ADMIN_ROOT . INC . 'header.php';
if(!isset($_SESSION['USER_LOGIN_DATA'])){
    header("Location:".URL);
}
?>
<section id="admin_jobreply" style="background-color:grey" >
    <div class="center">
        <h2><center> Job Replies</center></h2></div>
    <div  class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body table-responsive" id="jobreplylist">
<!--                        <table id="jobreplies" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Job Title</th>
                                    <th>Picture</th>
                                    <th>Resume</th>
                                    <th>Message</th>
                                    <th>Date of Apply</th>
                                </tr>
                            </thead>
                            <tbody id="jobreplylist">
                            </tbody>
                        </table>-->
                    </div> 
                </div> 
            </div> 
        </div> 
    </div>
    </section> 
    
    <section class="admin_blog_list" style="background-color:grey">
    <div class="center">
        <h2><center>Blog Reviews</center></h2></div>
    <div  class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body table-responsive" id="blogreviewlist">
<!--                        <table id="blogreview" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>User Name</th>
                                    <th>Blog Title</th>
                                    <th>Image</th>
                                    <th>Description</th>
                                    <th>Time of Reply</th>
                                </tr>
                            </thead>
                            <tbody id="blogreviewlist">
                            </tbody>
                        </table>-->
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div>
    </section>
<?php
require_once DOC_ADMIN_ROOT . INC . 'footer.php';
?>
<script type="text/javascript">
    $(document).ready(function () {
        window.setTimeout(function () {
               jobReplyList();
               blogReviewList();
        }, 400);
    });
</script>