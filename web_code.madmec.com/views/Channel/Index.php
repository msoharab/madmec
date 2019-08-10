<!--Start Of Body Container-->
<div class="container-fluid">
    <?php require_once ('channelHeader.php'); ?>
</div>
<div class="col-md-5 pull-right text-right">    
    <?php require_once ('channelActions.php'); ?>
</div>
<div class="col-md-3"></div>
<div class="clearfix"></div></br>
<div class="col-lg-12 col-md-12 col-sm-12 colxs-12">
    <?php require_once ('channelForm.php'); ?>
</div>
<!-- End Of Body Container-->
<!-- Modal for post-->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title" id="myModalLabel">Post</h3>
            </div>
            <div class="modal-body">
                <div class='conatiner'>
                    <h4 class='text-center'>Upload / Post picture, we accept gif, jpg, & png format(Max size:1.5 MB)</h4>
                    <div class="input-group">
                        <span class="input-group-addon" id="basic-addon1">Upload Image</span>
                        <input type="text" class="form-control" placeholder="URL Link" aria-describedby="basic-addon1">
                    </div>
                    <div class="clearfix"> </div><br />
                    <div class="row">
                        <div class="col-lg-5">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search for...">
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="button">Select file</button>
                                </span>
                            </div><!-- /input-group -->
                        </div><!-- /.col-lg-6 -->
                        <div class="col-lg-2 text-center"><h4> - Or - </h4></div>
                        <div class="col-lg-5">
                            <div class="upload-drop-zone" id="drop-zone">
                                Just drag and drop files here
                            </div>
                        </div><!-- /.col-lg-6 -->
                    </div><!-- /.row -->
                    <div class="clearfix"> </div><br />
                    <div class="input-group">
                        <span class="input-group-addon" id="basic-addon1">Title</span>
                        <input type="text" class="form-control" placeholder="Picture heading goes here..." aria-describedby="basic-addon1">
                    </div>
                    <br />
                    <script type="text/javascript">
                        $(document).ready(function () {
                            $('#example-collapse').multiselect();
                        });
                    </script>
                    <div class="panel-group" id="example-collapse-accordion">
                        <div class="panel panel-default" style="overflow:visible;">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#example-collapse-accordion" href="#example-collapse-accordion-one">
                                        Language / Language's
                                    </a>
                                </h4>
                            </div>
                            <div id="example-collapse-accordion-one" class="panel-collapse collapse out">
                                <div class="panel-body">
                                    <select id="example-collapse" multiple="multiple">
                                        <option value="1">Option 1</option>
                                        <option value="2">Option 2</option>
                                        <option value="3">Option 3</option>
                                        <option value="4">Option 4</option>
                                        <option value="5">Option 5</option>
                                        <option value="6">Option 6</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"> </div><br />
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <input type="checkbox"  aria-label="...">
                                </span>
                                <input type="text" class="form-control" aria-label="..." readonly placeholder="News">
                            </div><!-- /input-group -->
                        </div><!-- /.col-lg-3 -->
                        <div class="col-lg-3">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <input type="checkbox"  aria-label="...">
                                </span>
                                <input type="text" class="form-control" aria-label="..." readonly placeholder="Comics">
                            </div><!-- /input-group -->
                        </div><!-- /.col-lg-3 -->
                        <div class="col-lg-3">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <input type="checkbox"  aria-label="...">
                                </span>
                                <input type="text" class="form-control" aria-label="..." readonly placeholder="Memes">
                            </div><!-- /input-group -->
                        </div><!-- /.col-lg-3 -->
                        <div class="col-lg-3">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <input type="checkbox"  aria-label="...">
                                </span>
                                <input type="text" class="form-control" aria-label="..." readonly placeholder="Funny">
                            </div><!-- /input-group -->
                        </div><!-- /.col-lg-3 -->
                        <div class="clearfix"></div><br />
                        <div class="col-lg-3">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <input type="checkbox"  aria-label="...">
                                </span>
                                <input type="text" class="form-control" aria-label="..." readonly placeholder="Anime">
                            </div><!-- /input-group -->
                        </div><!-- /.col-lg-3 -->
                        <div class="col-lg-3">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <input type="checkbox"  aria-label="...">
                                </span>
                                <input type="text" class="form-control" aria-label="..." readonly placeholder="Gif">
                            </div><!-- /input-group -->
                        </div><!-- /.col-lg-3 -->
                        <div class="col-lg-3">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <input type="checkbox"  aria-label="...">
                                </span>
                                <input type="text" class="form-control" aria-label="..." readonly placeholder="Story">
                            </div><!-- /input-group -->
                        </div><!-- /.col-lg-3 -->
                        <div class="col-lg-3">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <input type="checkbox"  aria-label="...">
                                </span>
                                <input type="text" class="form-control" aria-label="..." readonly placeholder="Travels">
                            </div><!-- /input-group -->
                        </div><!-- /.col-lg-3 -->
                        <div class="clearfix"></div><br />
                        <div class="col-lg-6">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <input type="checkbox"  aria-label="...">
                                </span>
                                <input type="text" class="form-control" aria-label="..." readonly placeholder="Post to channels">
                            </div><!-- /input-group -->
                        </div><!-- /.col-lg-3 -->
                        <div class="col-lg-6">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <input type="checkbox"  aria-label="...">
                                </span>
                                <input type="text" class="form-control" aria-label="..." readonly placeholder="Post to pic3pic (only 30pic/day)">
                            </div><!-- /input-group -->
                        </div><!-- /.col-lg-3 -->
                        <br />
                        <div class="col-lg-12">
                            <div class="input-group">
                                <span class="input-group-addon woborder">
                                    <input type="checkbox"  aria-label="...">
                                </span>
                                <p class="wop"> I Accept the <a href="#">Community Guidelines</a></p>
                            </div><!-- /input-group -->
                        </div><!-- /.col-lg-3 -->
                    </div><!-- /.row -->
                </div><!-- /.row -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>
<!--End modal-->
<!-- modal for post report start-->
<div id="report" class="modal fade bs-example-modal-sm" tabindex="-2" role="dialog" aria-labelledby="mySmallModalLabel">
    <div class="modal-dialog modal-sm">
        <div class="modal-content col-lg-12">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"><strong>Report This Post</strong></h4>
            </div>
            <div class="modal-body">
                <h4>What is the Issue .. ?</h4>
            </div>
            <div class="row">
                <div class="input-group">
                    <span class="input-group-addon woborder">
                        <input type="radio" aria-label="..." name="ReportAbuse">
                    </span>
                    <p class="wop">Violate Community Guidelines </p>
                </div><!-- /input-group --> 
                <div class="input-group">
                    <span class="input-group-addon woborder">
                        <input type="radio" aria-label="..." name="ReportAbuse">
                    </span>
                    <p class="wop">Annoying and not interesting </p>
                </div><!-- /input-group --> 
                <div class="input-group">
                    <span class="input-group-addon woborder">
                        <input type="radio" aria-label="..." name="ReportAbuse">
                    </span>
                    <p class="wop">Offensive, sexual content, hate speech </p>
                </div><!-- /input-group --> 
                <div class="input-group">
                    <span class="input-group-addon woborder">
                        <input type="radio" aria-label="..." name="ReportAbuse">
                    </span>
                    <p class="wop">Report from other site/channel without modification</p>
                </div><!-- /input-group --> 
                <div class="input-group">
                    <span class="input-group-addon woborder">
                        <input type="radio" aria-label="..." name="ReportAbuse">
                    </span>
                    <p class="wop">Advertisment and Spam </p>
                </div><!-- /input-group -->
                <div class="input-group">
                    <span class="input-group-addon woborder">
                        <input type="radio" aria-label="..." name="ReportAbuse">
                    </span>
                    <p class="wop">Caption report Intellectual property </p>
                </div><!-- /input-group -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="submitreport">Submit</button>
                </div>
            </div>
        </div>
    </div>
</div>    
<!-- modal for post report end-->
<!-- modal for Channel report start-->
<div id="channelreport" class="modal fade bs-example-modal-sm" tabindex="-3" role="dialog" aria-labelledby="mySmallModalLabel">
    <div class="modal-dialog modal-sm">
        <div class="modal-content col-lg-12">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"><strong>Report This Channel</strong></h4>
            </div>
            <div class="modal-body">
                <h4>What is the Issue .. ?</h4>
            </div>
            <div class="row">
                <div class="input-group">
                    <span class="input-group-addon woborder">
                        <input type="radio" aria-label="..." name="ReportAbuse">
                    </span>
                    <p class="wop">Violate Community Guidelines</p>
                </div><!-- /input-group --> 
                <div class="input-group">
                    <span class="input-group-addon woborder">
                        <input type="radio" aria-label="..." name="ReportAbuse">
                    </span>
                    <p class="wop">Captain, Admin are Abusive</p>
                </div><!-- /input-group --> 
                <div class="input-group">
                    <span class="input-group-addon woborder">
                        <input type="radio" aria-label="..." name="ReportAbuse">
                    </span>
                    <p class="wop">Contain Spam Ads</p>
                </div><!-- /input-group --> 
                <div class="input-group">
                    <span class="input-group-addon woborder">
                        <input type="radio" aria-label="..." name="ReportAbuse">
                    </span>
                    <p class="wop">Contain offensive, sexual content, hate speech</p>
                </div><!-- /input-group --> 
                <div class="input-group">
                    <span class="input-group-addon woborder">
                        <input type="radio" aria-label="..." name="ReportAbuse">
                    </span>
                    <p class="wop">Intellectual property infringment</p>
                </div><!-- /input-group -->
                <div class="input-group">
                    <span class="input-group-addon woborder">
                        <input type="radio" aria-label="..." name="ReportAbuse">
                    </span>
                    <p class="wop">Contain report from other site / channel without modification</p>
                </div><!-- /input-group -->
                <div class="input-group">
                    <span class="input-group-addon woborder">
                        <input type="radio" aria-label="..." name="ReportAbuse">
                    </span>
                    <p class="wop">Caption Report</p>
                </div><!-- /input-group -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="submitreport">Submit</button>
                </div>
            </div>
        </div>
    </div>
</div>    
<!-- modal for Channel report end-->
