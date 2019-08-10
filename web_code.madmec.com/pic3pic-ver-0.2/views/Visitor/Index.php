<div class="container">
    <div class="row">
        <aside class="col-xs-12 col-md-3 border-right-lightgrey takemetop">    
            <div class="channel-heading align-center">My Channels</div>
            <div class="list-group" id="exlist">
                <a class="list-group-item" href="channels.php"> Channels-1</a>
                <a class="list-group-item" href="channels.php"> Channels-2</a>
                <a class="list-group-item" href="channels.php"> Channels-3</a>
                <button type="button" data-toggle="modal" data-target="#createchannel" data-whatever="@mdo" class="list-group-item btn btn-block btn-default" id="ex1">Create Channel</button>
            </div>
            <div class="clearfix"></div>
            <div class="channel-heading align-center">Admin Channels</div>
            <div class="list-group sub-scroll scrollbar" id="ex3">
                <a class="list-group-item" href="#"> Subscription-1</a>
                <a class="list-group-item" href="#"> Subscription-2</a>
                <a class="list-group-item" href="#"> Subscription-3</a>
                <a class="list-group-item" href="#"> Subscription-4</a>
                <a class="list-group-item" href="#"> Subscription-5</a>
                <a class="list-group-item" href="#"> Subscription-6</a>
                <a class="list-group-item" href="#"> Subscription-7</a>
                <a class="list-group-item" href="#"> Subscription-8</a>
            </div>
        </aside>
        <div class="col-xs-12 col-sm-12 col-md-7" id="show-post" style="display:none;">&nbsp;
        </div>
        <div class="col-xs-12 col-sm-12 col-md-7" id="hide-post">
            <div class="thumbnail">              
                <h4 class="">Heading Dummy Content</h4>
                <div class="dropdown close-post">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-close"></i></a>
                    <div class="dropdown-menu close-post-dd">
                        <div class="close-post-dd-item"><a href="javascript:void();" id="del-post" onclick=" $('#hide-post').hide('fast');
                                $('#show-post').show('fast');">Remove this image</a></div>
                        <div class="close-post-dd-item-child"><a href="#">Block this channel</a></div>
                    </div>
                </div>
                <div class="">
                    <a class="fancybox" rel="gallery2" title="Gallery 1 - 1" href="<?php echo $this->config["URL"] . $this->config["VIEWS"]; ?>assets/img/photo1.png"><img src="<?php echo $this->config["URL"] . $this->config["VIEWS"]; ?>assets/img/photo1.png" alt=""/></a>
                    <div class="hidden">
                        <a class="fancybox" rel="gallery2" title="Gallery 1 - 2" href="<?php echo $this->config["URL"] . $this->config["VIEWS"]; ?>assets/img/slider/1.jpg"><img src="<?php echo $this->config["URL"] . $this->config["VIEWS"]; ?>assets/img/slider/1.jpg" alt=""/></a>
                        <a class="fancybox" rel="gallery2" title="Gallery 1 - 3" href="<?php echo $this->config["URL"] . $this->config["VIEWS"]; ?>assets/img/slider/2.jpg"><img src="<?php echo $this->config["URL"] . $this->config["VIEWS"]; ?>assets/img/slider/2.jpg" alt=""/></a>
                    </div>
                </div>
                <div class="caption">
                    <div class="row">
                        <div class="col-md-2">
                            <a class="" href="#"><i class="fa fa-thumbs-o-up thumbs-up fa-lg"></i></a>
                            <span style="padding-right:20px;"></span>
                            <a class="" href="#"><i class="fa fa-thumbs-o-down fa-lg "></i></a><div class="clearfix"><br></div>
                            <a href="javascript:void();" class="ellipsis" onclick="$('#target1').slideToggle('slow');"><i class="fa fa-ellipsis-h fa-lg"></i> <i class="fa fa-ellipsis-h fa-lg"></i></a>
                        </div>
                        <div class="col-md-7">
                            <i class="fa fa-tags"></i><a class="" href="#"> education & resarch industry</a><br>
                            <i class="fa fa-user"></i><a class="" href="#"> Bikram keshari pattnayak</a>
                        </div>
                        <div class="col-md-3"><a class="btn btn-danger pull-right" href="#"><i class="fa fa-eye"></i> Subscribe</a></div>
                        <div class="clearfix"><br><br></div>
                        <div id="target1" style="display:none;"><hr>
                            <div class="col-md-2 " onclick="$('#share-list').slideToggle('slow');"><a class="" href="javascript:void();"><i class="fa fa-share-alt"></i> Share </a></div>                  
                            <div id="share-list" style="display:none;"><div class="col-md-1"><a class="" href="#"><i class="fa fa-facebook-square"></i></a></div>
                                <div class="col-md-1"><a class="" href="#"><i class="fa fa-twitter-square"></i></a></div>
                                <div class="col-md-1"><a class="" href="#"><i class="fa fa-instagram"></i></a></div>
                                <div class="col-md-1"><a class="" href="#"><i class="fa fa-dribbble"></i></a></div>
                                <div class="col-md-1"><a class="" href="#"><i class="fa fa-flickr"></i></a></div>
                                <div class="col-md-1"><a class="" href="#"><i class="fa fa-pinterest-square"></i></a></div>
                                <div class="col-md-1"><a class="" href="#"><i class="fa fa-google-plus-square"></i></a></div></div>
                            <div class="col-md-3 pull-right text-right">
                                <button class="btn btn-danger btn-subscribe " data-toggle="modal" data-target="#report">
                                    <i class="fa fa-flag"></i> Report
                                </button>
                            </div>
                            <div class="clearfix">&nbsp;</div>
                            <div class="col-md-12"></div><br>
                            <ul id="comments">
                                <i class="fa fa-thumbs-o-up thumbs-up"></i> <a href="#"> 786</a> people like this
                                <a href="#"> . </a>
                                <i class="fa fa-envelope-square thumbs-up"></i> <a href="#"> 34</a> comments
                                <li class="cmmnt ">
                                    <!--Comments in parent-->
                                    <div class="avatar">
                                        <a href="javascript:void(0);">
                                            <img src="<?php echo $this->config["URL"] . $this->config["VIEWS"]; ?>assets/img/comments-img/dark-cubes.png" class="img-input-small" alt="DarkCubes photo avatar">
                                        </a>
                                    </div>
                                    <div class="cmmnt-content">
                                        <div class="input-group add-on">
                                            <input class="form-control" placeholder="Comment ..." name="srch-term" id="srch-term" type="text">
                                            <input type="file" id="CommentfileLoader" name="Commentfiles" title="Load comment File" style = "display:none;" />
                                            <div class="input-group-btn">
                                                <button class="btn btn-default" id="comment-button" onclick="OpenFileDialogForCommentSection();"><i class="glyphicon glyphicon-camera"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="clearfix"><br></div>              
                                </li><!-- end parent-->
                                <li class="cmmnt cmmnts-border ParentsComment  onhovershowcross">
                                    <div class="avatar "><a href="javascript:void(0);"><img src="<?php echo $this->config["URL"] . $this->config["VIEWS"]; ?>assets/img/comments-img/dark-cubes.png" class="img-comnt-small" alt="DarkCubes photo avatar"></a></div>
                                    <div class="cmmnt-content ">
                                        <header>
                                            <a href="javascript:void(0);" class="userlink">DarkCubes</a> - 
                                            <span class="pubdate"> 1 week ago</span>
                                        </header>
                                        <div class="dropdown close-post">
                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-close"></i></a>
                                            <div class="dropdown-menu close-post-dd">
                                                <div class="close-post-dd-item"><a href="javascript:void();" id="del-post" onclick="if (confirm('Are you sure...? ')) {
                                                            $('.ParentsComment').hide('fast');
                                                        }">Remove this Comment</a></div>
                                                <div class="close-post-dd-item-child"><a href="#">Report Comment</a></div>
                                            </div>
                                        </div>
                                        <p>Ut nec interdum libero. Sed felis lorem, venenatis sed malesuada vitae,
                                            tempor vel turpis. Mauris in dui velit, vitae mollis risus. 
                                            Cras lacinia lorem sit amet augue mattis vel cursus enim laoreet. 
                                            Vestibulum faucibus scelerisque nisi vel sodales. Lorem ipsum dolor sit amet, 
                                            consectetur adipiscing elit. Duis pellentesque massa ac justo tempor eu 
                                            pretium massa accumsan. In pharetra mattis mi et ultricies. 
                                            Nunc vel eleifend augue. Donec venenatis egestas iaculis.
                                        </p>
                                        <a href="#">Like</a><span style="padding-right:10px;"></span>
                                        <a href="#">Reply</a>
                                        <a href="#"> . </a>
                                        <i class="fa fa-thumbs-o-up thumbs-up"></i> <a href="#"> 786</a> 
                                        <i class="fa fa-envelope-square thumbs-up"></i> <a href="#"> 34</a> 
                                    </div>
                                    <div class="cmmnt ">
                                        <!--Comments in child-->
                                        <div class="avatar"><a href="javascript:void(0);"><img src="<?php echo $this->config["URL"] . $this->config["VIEWS"]; ?>assets/img/comments-img/dark-cubes.png" class="img-input-small" alt="DarkCubes photo avatar"></a></div>
                                        <div class="cmmnt-content">
                                            <div class="input-group add-on">
                                                <input class="form-control" placeholder="Reply to comment..." name="srch-term" id="srch-term" type="text">
                                                <input type="file" id="ReplyfileLoader" name="Replyfiles" title="Load Reply File" style = "display:none;" />
                                                <div class="input-group-btn">
                                                    <button class="btn btn-default" id="reply-button" onclick="OpenFileDialogForReplySection();"><i class="glyphicon glyphicon-camera"></i></button>
                                                </div>
                                            </div>                             
                                        </div>
                                        <div class="clearfix"><br></div>              
                                    </div><!-- end child-->
                                <li class="cmmnt ChildComment onhovershowcross">                                 
                                    <ul class="replies">
                                        <li class="cmmnt cmmnts-border">
                                            <div class="avatar"><a href="javascript:void(0);"><img src="<?php echo $this->config["URL"] . $this->config["VIEWS"]; ?>assets/img/comments-img/pig.png" class="img-comnt-small" alt="Sir_Pig photo avatar"></a></div>
                                            <div class="cmmnt-content">
                                                <header>
                                                    <a href="javascript:void(0);" class="userlink">Sir_Pig</a> - 
                                                    <span class="pubdate"> 1 day ago</span>
                                                </header>
                                                <div class="dropdown close-post" id="close-post">
                                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-close"></i></a>
                                                    <div class="dropdown-menu close-post-dd">
                                                        <div class="close-post-dd-item"><a href="javascript:void();" id="del-post" onclick="if (confirm('Are you sure...? ')) {
                                                                    $('.ChildComment').hide('fast');
                                                                }">Remove this comment</a></div>
                                                        <div class="close-post-dd-item-child"><a href="#">Report Comment</a></div>
                                                    </div>
                                                </div>
                                                <p>Sed felis lorem, venenatis sed malesuada vitae, tempor vel turpis. Mauris in dui velit, vitae mollis risus.</p>
                                                <p>Morbi id neque nisl, nec fringilla lorem. Duis molestie sodales leo a blandit. Mauris sit amet ultricies libero. Etiam quis diam in lacus molestie fermentum non vel quam.</p>
                                                <a href="#">Like</a><span style="padding-right:10px;"> </span><a href="#"><i class="fa fa-thumbs-o-up thumbs-up"></i> 786</a> people like this
                                            </div> 
                                        </li>
                                    </ul>
                                </li>
                                </li>                        
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <aside class="col-xs-12 col-md-2 border-left-lightgrey takemetop"> 
            <div class="list-group">
                <button type="button" data-toggle="modal" data-target="#postindividual" data-whatever="@mdo" class="list-group-item btn btn-block btn-success">Individual Post</button>
            </div>
            <div class="channel-heading align-center">Subscription</div>
            <div class="list-group">
                <a class="list-group-item" href="#"> Subscription-1</a>
                <a class="list-group-item" href="#"> Subscription-2</a>
                <a class="list-group-item" href="#"> Subscription-3</a>
            </div>
        </aside>
    </div>
    <!-- modal for report start-->
    <div id="report" class="modal fade bs-example-modal-sm" tabindex="-2" role="dialog" aria-labelledby="mySmallModalLabel">
        <div class="modal-dialog modal-sm">
            <div class="modal-content col-lg-12">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel"><strong>Report This Profile</strong></h4>
                </div>
                <div class="modal-body">
                    <h4>What is the Issue .. ?</h4>
                </div>
                <div class="row">
                    <div class="input-group">
                        <span class="input-group-addon woborder">
                            <input type="radio" aria-label="..." name="ReportAbuse">
                        </span>
                        <p class="wop">I just don't like it"</p>
                    </div><!-- /input-group --> 
                    <div class="input-group">
                        <span class="input-group-addon woborder">
                            <input type="radio" aria-label="..." name="ReportAbuse">
                        </span>
                        <p class="wop">It's harassing me or someone I know"</p>
                    </div><!-- /input-group --> 
                    <div class="input-group">
                        <span class="input-group-addon woborder">
                            <input type="radio" aria-label="..." name="ReportAbuse">
                        </span>
                        <p class="wop">Posted in wrong language board"</p>
                    </div><!-- /input-group --> 
                    <div class="input-group">
                        <span class="input-group-addon woborder">
                            <input type="radio" aria-label="..." name="ReportAbuse">
                        </span>
                        <p class="wop">It's spam or a scam, advertisment"</p>
                    </div><!-- /input-group --> 
                    <div class="input-group">
                        <span class="input-group-addon woborder">
                            <input type="radio" aria-label="..." name="ReportAbuse">
                        </span>
                        <p class="wop">Repost from other site/channel without modification</p>
                    </div><!-- /input-group -->
                    <div class="input-group">
                        <span class="input-group-addon woborder">
                            <input type="radio" aria-label="..." name="ReportAbuse">
                        </span>
                        <p class="wop">Sexual content"</p>
                    </div><!-- /input-group -->
                    <div class="input-group">
                        <span class="input-group-addon woborder">
                            <input type="radio" aria-label="..." name="ReportAbuse">
                        </span>
                        <p class="wop">Violent or repulsive content"</p>
                    </div><!-- /input-group -->
                    <div class="input-group">
                        <span class="input-group-addon woborder">
                            <input type="radio" aria-label="..." name="ReportAbuse">
                        </span>
                        <p class="wop">Hateful or abusive content"</p>
                    </div><!-- /input-group -->
                    <div class="input-group">
                        <span class="input-group-addon woborder">
                            <input type="radio" aria-label="..." name="ReportAbuse">
                        </span>
                        <p class="wop">Offensive to me"</p>
                    </div><!-- /input-group -->
                    <div class="input-group">
                        <span class="input-group-addon woborder">
                            <input type="radio" aria-label="..." name="ReportAbuse">
                        </span>
                        <p class="wop">Child abuse"</p>
                    </div><!-- /input-group -->
                    <div class="input-group">
                        <span class="input-group-addon woborder">
                            <input type="radio" aria-label="..." name="ReportAbuse">
                        </span>
                        <p class="wop">Infringes my rights"</p>
                    </div><!-- /input-group -->
                    <div class="input-group">
                        <span class="input-group-addon woborder">
                            <input type="radio" aria-label="..." name="ReportAbuse">
                        </span>
                        <p class="wop">Captions report (CVAA)"</p>
                    </div><!-- /input-group -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="submitreport">Continue</button>
                    </div>
                </div>
            </div>
        </div>
    </div>    
    <!-- modal for report end-->
    <!-- Modal for individual post-->
    <div class="modal fade" id="postindividual" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h3 class="modal-title" id="myModalLabel">Post</h3>
                </div>
                <div class="modal-body">
                    <div class='conatiner'>
                        <h4 class='text-center'>Upload / Post picture, we accept gif, jpg, & png format. <br>(<strong>Max size:</strong>1.5 MB & <strong>Max Upload:</strong> 30 pics / day)</h4>
                        <div class="input-group">
                            <span class="input-group-addon" id="basic-addon1">Upload Image</span>
                            <input type="text" class="form-control" placeholder="URL Link" aria-describedby="basic-addon1">
                        </div>
                        <div class="clearfix"> </div><br>
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
                        <div class="clearfix"> </div><br>
                        <div class="input-group">
                            <span class="input-group-addon" id="basic-addon1">Title</span>
                            <input type="text" class="form-control" placeholder="Picture heading goes here..." aria-describedby="basic-addon1">
                        </div>
                        <br>
                        <div class="input-group">
                            <span class="input-group-addon" id="basic-addon1">                
                                <input type="radio" name="createchannel" value="world" checked class="gap-right"><label>&nbsp; World </label>  <span class="gap-right"></span>              
                                <input type="radio" name="createchannel" value="world" ><label>&nbsp; Country</label>
                            </span>
                            <select class="form-control" id="sel1">
                                <option>Country Name-1</option>
                                <option>Country Name-2</option>
                                <option>Country Name-3</option>
                                <option>Country Name-4</option>
                            </select>
                        </div>
                        <p>In English Only | Local Language</p>
                    </div>
                    <br>
                    <div class="panel-group" id="example-collapse-accordion">
                        <div class="panel panel-default" style="overflow:visible;">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#example-collapse-accordion" href="#example-collapse-accordion-one">
                                        Language / Language's
                                    </a>
                                </h4>
                            </div>
                            <div id="example-collapse-accordion-one" class="panel-collapse collapse in">
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
                    <div class="clearfix"> </div><br>
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="input-group">
                                <span class="input-group-addon woborder">
                                    <input type="checkbox"  aria-label="...">
                                </span>
                                <p class="wop">News </p>
                            </div><!-- /input-group -->
                        </div><!-- /.col-lg-3 -->
                        <div class="col-lg-3">
                            <div class="input-group">
                                <span class="input-group-addon woborder">
                                    <input type="checkbox"  aria-label="...">
                                </span>
                                <p class="wop">Comics </p>
                            </div><!-- /input-group -->
                        </div><!-- /.col-lg-3 -->
                        <div class="col-lg-3">
                            <div class="input-group">
                                <span class="input-group-addon woborder">
                                    <input type="checkbox"  aria-label="...">
                                </span>
                                <p class="wop">Memes </p>
                            </div><!-- /input-group -->
                        </div><!-- /.col-lg-3 -->
                        <div class="col-lg-3">
                            <div class="input-group">
                                <span class="input-group-addon woborder">
                                    <input type="checkbox"  aria-label="...">
                                </span>
                                <p class="wop">Funny </p>
                            </div><!-- /input-group -->
                        </div><!-- /.col-lg-3 -->
                        <div class="clearfix"></div><br>
                        <div class="col-lg-3">
                            <div class="input-group">
                                <span class="input-group-addon woborder">
                                    <input type="checkbox"  aria-label="...">
                                </span>
                                <p class="wop">Anime </p>
                            </div><!-- /input-group -->
                        </div><!-- /.col-lg-3 -->
                        <div class="col-lg-3">
                            <div class="input-group">
                                <span class="input-group-addon woborder">
                                    <input type="checkbox"  aria-label="...">
                                </span>
                                <p class="wop">Gif </p>
                            </div><!-- /input-group -->
                        </div><!-- /.col-lg-3 -->
                        <div class="col-lg-3">
                            <div class="input-group">
                                <span class="input-group-addon woborder">
                                    <input type="checkbox"  aria-label="...">
                                </span>
                                <p class="wop">Story </p>
                            </div><!-- /input-group -->
                        </div><!-- /.col-lg-3 -->
                        <div class="col-lg-3">
                            <div class="input-group">
                                <span class="input-group-addon woborder">
                                    <input type="checkbox"  aria-label="...">
                                </span>
                                <p class="wop">Travels </p>
                            </div><!-- /input-group -->
                        </div><!-- /.col-lg-3 -->
                        <div class="clearfix"></div><br>
                        <div class="col-lg-3">
                            <div class="input-group">
                                <span class="input-group-addon woborder">
                                    <input type="checkbox"  aria-label="...">
                                </span>
                                <p class="wop"> Anonymous Post </p>
                            </div><!-- /input-group -->
                        </div><!-- /.col-lg-3 -->
                        <div class="col-lg-3">
                            <div class="input-group">
                                <span class="input-group-addon woborder">
                                    <input type="checkbox"  aria-label="...">
                                </span>
                                <p class="wop"> 18+ </p>
                            </div><!-- /input-group -->
                        </div><!-- /.col-lg-3 -->
                        <div class="col-lg-3">
                            <div class="input-group">
                                <span class="input-group-addon woborder">
                                    <input type="checkbox"  aria-label="...">
                                </span>
                                <p class="wop"> anything </p>
                            </div><!-- /input-group -->
                        </div><!-- /.col-lg-3 -->
                        <div class="col-lg-3">
                            <div class="input-group">
                                <span class="input-group-addon woborder">
                                    <input type="checkbox"  aria-label="...">
                                </span>
                                <p class="wop"> something </p>
                            </div><!-- /input-group -->
                        </div><!-- /.col-lg-3 -->
                        <div class="clearfix"></div><br>
                        <div class="col-lg-12">
                            <div class="input-group">
                                <span class="input-group-addon woborder">
                                    <input type="checkbox"  aria-label="...">
                                </span>
                                <p class="wop"> I Agree to the <a href="#">Community Rules. </a></p>
                            </div><!-- /input-group -->
                        </div><!-- /.col-lg-3 -->
                        <br><hr><br>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary">Submit</button>
                        </div>
                    </div><!-- /.row -->
                </div>
            </div>
        </div>
    </div>
</div>
<!--End modal-->
<!-- Modal for create channel-->
<div class="modal fade" id="createchannel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title" id="myModalLabel">Create Channel</h3>
            </div>
            <form class="" id="channelForm" name="channelForm" method="post" action="">
                <fieldset>
                    <div class="modal-body">
                        <div class='conatiner'>
                            <div class="input-group">
                                <span class="input-group-addon" id="basic-addon1">Channel Name </span>
                                <input type="text" class="form-control" name="ex4" placeholder="channel name" aria-describedby="basic-addon1" id="ex4">
                            </div>
                            <div class="clearfix"> </div><br>
                            <div class="input-group">
                                <span class="input-group-addon" id="basic-addon1">Select Target Location </span>
                                <select class="form-control" id="ex5" name="ex5">
                                    <option value="World" selected="selected">World</option>
                                    <option value="Country">Country</option>
                                </select>
                            </div>
                            <div class="clearfix"> </div><br>
                            <div class="input-group">
                                <span class="input-group-addon" id="basic-addon1">Select Language</span>
                                <select class="form-control" id="ex6" name="ex6">
                                    <option value="One" selected="selected">One</option>
                                    <option value="Two">Two</option>
                                    <option value="English">English</option>
                                </select>
                            </div>
                            <div class="clearfix"> </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal" name="ex8" id="ex8">Close</button>
                        <button type="submit" class="btn btn-primary" name="ex9" id="ex9">Create</button>
                    </div>
                </fieldset>
            </form>
        </div>     
    </div>
</div>
<!--End of create channel modal-->
