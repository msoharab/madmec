<!-- container start -->
<div class="container">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-7" id="show-post" style="display:none;">&nbsp; </div>
        <div class="col-xs-12 col-sm-12 col-md-7" id="hide-post">
            <div class="thumbnail">
                <h4 class="">Heading Dummy Content</h4>
                <div class="dropdown close-post">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-close"></i></a>
                    <div class="dropdown-menu close-post-dd">
                        <div class="close-post-dd-item"><a href="javascript:void();" id="del-post" onclick=" $('#hide-post').hide('fast');
                                $('#show-post').show('fast');">Remove this image</a></div>
                        <div class="close-post-dd-item"><a href="#">Block this channel</a></div>
                        <div class="close-post-dd-item-child"><a href="#">Remove this section</a></div>
                    </div>
                </div>
                <div class="">
                    <a class="fancybox" rel="gallery2" title="Gallery 1 - 1" href="<?php
                    echo $this->config["URL"] . $this->config["VIEWS"];
                    ;
                    ?>assets/img/photo1.png">
                        <img src="<?php echo $this->config["URL"] . $this->config["VIEWS"]; ?>assets/img/photo1.png" alt=""/>
                    </a>
                    <div class="hidden">
                        <a class="fancybox" rel="gallery2" title="Gallery 1 - 2" href="<?php echo $this->config["URL"] . $this->config["VIEWS"]; ?>assets/img/slider/1.jpg">
                            <img src="<?php echo $this->config["URL"] . $this->config["VIEWS"]; ?>assets/img/slider/1.jpg" alt=""/>
                        </a>
                        <a class="fancybox" rel="gallery2" title="Gallery 1 - 3" href="<?php echo $this->config["URL"] . $this->config["VIEWS"]; ?>assets/img/slider/2.jpg">
                            <img src="<?php echo $this->config["URL"] . $this->config["VIEWS"]; ?>assets/img/slider/2.jpg" alt=""/>
                        </a>
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
                                <i class="fa fa-thumbs-o-up thumbs-up"></i> <a href="#" id="shakil"> 786</a> people like this
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
        </div><!--end of class="col-xs-12 col-sm-12 col-md-6" -->
        <div class="col-xs-12 col-sm-12 col-md-5">
            <div class="text-center">
                <h3>Connect With Pic3Pic</h3>
                <a href="" title="" target="_blank" class="btn btn-facebook"><i class="fa fa-facebook"></i> Facebook</a>
                <a href="" title="" target="_blank" class="btn btn-twitter"><i class="fa fa-twitter"></i> Twitter</a>
                <a href="" title="" target="_blank" class="btn btn-instagram"><i class="fa fa-instagram"></i> Instagram</a>
            </div>
            <hr>
            <div class="text-center">
                <a href="javascript:void();" data-toggle="modal" data-target="#contactus"  class="gap-right">Contact</a>
                <a href="" class="gap-right">| &nbsp; Rules & Regulation</a>
                <a href="" class="gap-right">| &nbsp; Community Guidelines</a>
                <a href="" class="gap-right">| &nbsp; Help</a>
            </div>
        </div>
    </div>
</div>
<!-- container start -->
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
<!-- Login modal start-->
<div class="modal fade" id="login" tabindex="-1" role="dialog" aria-labelledby="loginModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="loginCloseBut"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="loginModal"> Login</h4>
                <button type="button" class="btn btn-primary pull-right" id="registerLogBut"> Register</button>
            </div>
            <div class="modal-body">
                <form id="signinform">
                    <div class="form-group" >
                        <label for="recipient-name" class="control-label" id="user_name_msg">Email-Id / Username:</label>
                        <input type="text" class="form-control" id="recipient-name" placeholder="Email-Id / Username:">
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="control-label" id="pass_msg">Password:</label>
                        <input class="form-control" id="message-text" type="password" placeholder="Password"></input>
                    </div>
                    <div class="clearfix"></div>
                    <div class="form-group">
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <a href="javascript:void(0);" title="" target="_blank" class="btn btn-facebook btn-block" id="facebookLogBut"><i class="fa fa-facebook"></i> Login With Facebook</a>
                        </div>
                        <div class="visible-sm visible-xs hidden-md hidden-lg"><br><br></div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <a href="javascript:void(0);" title="" target="_blank" class="btn btn-google-plus btn-block" id="googleLogBut"><i class="fa fa-google-plus"></i> Login With Google</a>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </form>
            </div>
            <div class="modal-footer">
                <a href="javascript:void(0);" class="pull-left" id="forgotPassBut">Forgot password... ?</a>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="getIn">Login</button>
                <div class="clearfix"></div>
                <div id="outputLogRes" class="col-lg-12"></div>
            </div>
        </div>
    </div>
</div>
<!-- login modal end-->
<!-- Register modal start-->
<div class="modal fade" id="register" tabindex="-1" role="dialog" aria-labelledby="RegisterModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="RegisterModal">Register</h4>
            </div>
            <div class="modal-body">
                <form id="custregform">
                    <div class="form-group">
                        <div class="col-md-6 col-lg-6">
                            <a href="javascript:void(0);" title="Facebook" target="_blank" class="btn btn-facebook btn-block" id="rfacebookBut"><i class="fa fa-facebook"></i> Register Using Facebook</a>
                        </div>
                        <div class="col-md-6 col-lg-6">
                            <a href="javascript:void(0);" title="Google+" target="_blank" class="btn btn-google-plus btn-block" id="rgoogleBut"><i class="fa fa-google-plus"></i> Register Using Google</a>
                        </div>
                    </div><br>
                    <p class="text-center"> - Or - </p>
                    <div class="form-group">
                        <label for="recipient-name1" class="control-label" id="cust_nmmsg"> Full Name:</label>
                        <input type="text" class="form-control" id="recipient-name1" placeholder="Full Name">
                    </div>
                    <div class="form-group">
                        <label for="recipient-email" class="control-label" id="emmsg"> Email-Id:</label>
                        <input type="text" class="form-control" id="recipient-email" placeholder="Email-Id">
                    </div>
                    <div class="form-group">
                        <label for="recipientpass1" class="control-label" id="passmsgmsg"> Password:</label>
                        <input class="form-control"  type="password" placeholder="Password" id="recipientpass1"></input>
                    </div>
                    <div class="form-group">
                        <label for="recipientpass2" class="control-label" id="cpassmsgmsg"> Confirm Password:</label>
                        <input class="form-control"  placeholder="Confirm Password" type="password" id="recipientpass2"></input>
                    </div>
                    <div class="form-group">
                        <p class="pull-left" id="engmsg">Prove you are a human</p>
                        <i class="fa fa-thumbs-o-up fa-fw pull-right"></i>
                    </div>
                    <div class="clearfix"></div>
                    <div class="form-group">
                        <input class="form-control" type="checkbox" name="test" value="Agreed" id="human" checked="checked"><label>&nbsp; Accept Terms & Condition</label>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary pull-left" id="old-receipent">Already have an account Login</button>
                <button type="button" class="btn btn-default" data-dismiss="modal" id="regCloseBut">Close</button>
                <button type="button" class="btn btn-primary" id="registerInBut">Register</button>
                <div id="RegisterOutput" class="col-lg-12"></div>
            </div>
        </div>
    </div>
</div>
<!-- Register modal end-->
<!-- Modal for contact us start -->
<div class="modal fade" id="contactus" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Contact Us</h4>
            </div>
            <div class="modal-body">
                <form role="form" action="" method="post" >
                    <div class="form-group">
                        <label for="InputName">Your Name</label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="InputName" id="InputName" placeholder="Enter Name" required>
                            <span class="input-group-addon"><i class="glyphicon glyphicon-ok form-control-feedback"></i></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="InputEmail">Your Email</label>
                        <div class="input-group">
                            <input type="email" class="form-control" id="InputEmail" name="InputEmail" placeholder="Enter Email" required  >
                            <span class="input-group-addon"><i class="glyphicon glyphicon-ok form-control-feedback"></i></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="InputEmail">Category </label>
                        <select name="colors" class="form-control" >
                            <span class="input-group-addon"><i class="glyphicon glyphicon-ok form-control-feedback"></i></span>
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
                            <textarea name="InputMessage" id="InputMessage" class="form-control" rows="5" required></textarea>
                            <span class="input-group-addon"><i class="glyphicon glyphicon-ok form-control-feedback"></i></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="InputReal">What is 4+3? (Simple Spam Checker)</label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="InputReal" id="InputReal" required>
                            <span class="input-group-addon"><i class="glyphicon glyphicon-ok form-control-feedback"></i></span>
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
