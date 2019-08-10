<!--Start Of Body Container-->
<div class="container-fluid">
    <h2 class="channel-heading">Mera bharat mahan</h2>
    <div class="channel-cover">
        <img src="<?php echo $this->config["URL"] . $this->config["VIEWS"]; ?>assets/img/channels/channel_cover.jpg" class="img-responsive">
    </div>      
    <div class="col-md-2 col-sm-7 col-xs-7">
        <img src="<?php echo $this->config["URL"] . $this->config["VIEWS"]; ?>assets/img/channels/channel_logo.png" class="img-responsive img-thumbnail channel-profile">
    </div>      
    <br>
    <div class="col-md-1">        
        <a class=""><i class="fa fa-thumbs-o-up thumbs-up fa-lg"></i> 23 </a> Likes 
        <span class="gap-right"></span>        
    </div>
    <div class="col-md-1">
        <a class="" href="javascript:void();" onclick="$('#share-list-channel').slideToggle('slow');"><i class="fa fa-share-alt"></i> Share </a></div>                  
    <div id="share-list-channel" style="display:none;">
        <div class="col-md-1 min-wid"><a class="" href="#"><i class="fa fa-facebook-square"></i></a></div>
        <div class="col-md-1 min-wid"><a class="" href="#"><i class="fa fa-twitter-square"></i></a></div>
        <div class="col-md-1 min-wid"><a class="" href="#"><i class="fa fa-instagram"></i></a></div>
        <div class="col-md-1 min-wid"><a class="" href="#"><i class="fa fa-dribbble"></i></a></div>
        <div class="col-md-1 min-wid"><a class="" href="#"><i class="fa fa-flickr"></i></a></div>
        <div class="col-md-1 min-wid"><a class="" href="#"><i class="fa fa-pinterest-square"></i></a></div>
        <div class="col-md-1 min-wid"><a class="" href="#"><i class="fa fa-google-plus-square"></i></a></div>
    </div>
</div>
<div class="col-md-5 pull-right text-right">    
    <button class="btn btn-deafult btn-subscribe pull-right"></i> 213 </button>    
    <button class="btn btn-danger btn-subscribe pull-right"><i class="fa fa-eye"> </i> Subscribe </button>
    <button class="btn btn-danger btn-subscribe " data-toggle="modal" data-target="#channelreport"><i class="fa fa-flag"></i> Report</button><span class="gap-right"></span>
    <button class="btn btn-danger btn-subscribe" data-toggle="modal" data-target="#profilereport">
        <i class="fa fa-flag"></i> Block</button><span class="gap-right"></span>
</div>
<div class="col-md-3"></div>
<div class="clearfix"></div></br>
<div class="col-lg-12 col-md-12 col-sm-12 colxs-12">
    <div id="exTab1" class=""> 
        <ul class="nav nav-tabs">
            <li class="active">
                <a  href="#1a" data-toggle="tab">Home</a>
            </li>
            <li>
                <a href="#2a" data-toggle="tab">About</a>
            </li>
            <li>
                <a href="#3a" data-toggle="tab">Setting</a>
            </li>
            <li>
                <a href="#4a" data-toggle="tab">Message</a>
            </li>
        </ul>
        <div class="tab-content clearfix">
            <!-- tab1 HOME Start-->
            <div class="tab-pane active" id="1a">
                <div class="container"><br>
                    <div class="col-xs-12 col-sm-12 col-md-7" id="show-post" style="display:none;">&nbsp;</div>
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
                                        <div class="col-md-2 " onclick="$('#share-list').slideToggle('slow');">
                                            <a class="" href="javascript:void();"><i class="fa fa-share-alt"></i> Share </a></div>                  
                                        <div id="share-list" style="display:none;">
                                            <div class="col-md-1"><a class="" href="#"><i class="fa fa-facebook-square"></i></a></div>
                                            <div class="col-md-1"><a class="" href="#"><i class="fa fa-twitter-square"></i></a></div>
                                            <div class="col-md-1"><a class="" href="#"><i class="fa fa-instagram"></i></a></div>
                                            <div class="col-md-1"><a class="" href="#"><i class="fa fa-dribbble"></i></a></div>
                                            <div class="col-md-1"><a class="" href="#"><i class="fa fa-flickr"></i></a></div>
                                            <div class="col-md-1"><a class="" href="#"><i class="fa fa-pinterest-square"></i></a></div>
                                            <div class="col-md-1"><a class="" href="#"><i class="fa fa-google-plus-square"></i></a></div>
                                        </div>
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
                    <div class="col-xs-12 col-sm-12 col-md-5">
                        <div class="pull-right">
                            <button type="button" class="btn btn-danger btn-small" data-toggle="modal" data-target="#myModal">
                                <i class="fa fa-edit"></i> Post
                            </button>
                            <a href="#" class=""></a>
                        </div>
                        <div class="clearfix"></div>
                        <div class="pull-right">
                            <a href="#"><i> https://www.loyaltyprogram.com</i> </a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Home Tab1 ENDS -->
            <!-- ABOUT Tab2 Start -->
            <div class="tab-pane" id="2a"><br>
                <div class="container">
                    <div class="pull-right">
                        <a href="#" class="btn btn-danger btn-small"><i class="fa fa-users"></i> Admin's Login</a>
                    </div>
                    <table class="table table-condensed">
                        <tbody>
                            <tr>
                                <td class="text-right col-md-2 about-heading">Description :</td>
                                <td class="about-body col-md-10">There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.</td>
                            </tr>
                            <tr>
                                <td class="text-right col-md-2 about-heading">Admin's :</td>
                                <td class="about-body col-md-10">
                                    <div class="">
                                        <span class="pull-left">
                                            <label class="admin-label">Bravo</label>
                                        </span>
                                        <span class="pull-right">
                                            <a class="input-group-addon btn btn-sm btn-danger">
                                                <i class="fa fa-close"></i>Remove
                                            </a>
                                        </span>
                                    </div>
                                    <div class="clearfix"></div><hr>
                                    <div class="">
                                        <span class="pull-left">
                                            <label class="admin-label">Scarlet</label>
                                        </span>
                                        <span class="pull-right">
                                            <a class="input-group-addon btn btn-sm btn-danger">
                                                <i class="fa fa-close"></i>Remove
                                            </a>
                                        </span>
                                    </div> 
                                    <div class="clearfix"></div><hr>
                                    <div class="">
                                        <span class="pull-left">
                                            <label class="admin-label">Scarlet</label>
                                        </span>
                                        <span class="pull-right">
                                            <a class="input-group-addon btn btn-sm btn-danger">
                                                <i class="fa fa-close"></i>Remove
                                            </a>
                                        </span>
                                    </div> 
                                    <div class="clearfix"></div><hr>                            
                                </td>
                            </tr>
                            <tr>
                                <td class="text-right col-md-2 about-heading">Captain :</td>
                                <td class="about-body col-md-10">Charlie Chachu</td>
                            </tr>
                            <tr>
                                <td class="text-right col-md-2 about-heading">Social Info :</td>
                                <td class="about-body col-md-10">
                                    <a href="https://www.facebook.com/" class=""><i class="fa fa-facebook-square fa-2x fa-color"></i></a>
                                    <a href="https://www.google.com/" class=""><i class="fa fa-google-plus-square fa-2x fa-color"></i></a>
                                    <a href="https://www.twitter.com/" class=""><i class="fa fa-twitter-square fa-2x fa-color"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-right col-md-2 about-heading">Website :</td>
                                <td class="about-body col-md-10"><a href="https://www.twitter.com/">JohnDoe</a></td>
                            </tr>
                            <tr>
                                <td class="text-right col-md-2 about-heading">Say "Hi" to Admin :</td>
                                <td class="about-body col-md-10"><input type="text" class="admin-msg" placeholder="Maximum 250 words...." > <a href=""class="btn btn-primary btn-small"><i class="fa fa-envelope"></i> Send Message</a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- About Tab2 ENDS -->
            <!-- SETTING Tab3 Start -->
            <div class="tab-pane" id="3a"><br>
                <div class="container">
                    <h3>Setting</h3>
                    <table class="table table-condensed">
                        <tbody>
                            <tr>
                                <td class="text-right col-md-2 about-heading">Edit Description :</td>
                                <td class="about-body col-md-10"><textarea placeholder="Add description"></textarea></td>
                            </tr>
                            <tr>
                                <td class="text-right col-md-2 about-heading">Add Admin's :</td>
                                <td class="about-body col-md-10">
                                    <div id="room_fileds">
                                        <div>
                                            <div class="contentpic">
                                                <div class="input-group">
                                                    <span class="input-group-addon" id="basic-addon1"><i class="fa fa-user"></i></span>
                                                    <input type="text" class="form-control" name="width[]" placeholder="Username" aria-describedby="basic-addon1">
                                                    <span class="input-group-addon btn btn-sm btn-success add-admin" id="basic-addon1"><i class="fa fa-user"></i> Add Admin</span>
                                                </div> 
                                            </div>
                                        </div><br>
                                    </div>
                                    <div class="clearfix"></div>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-right col-md-2 about-heading">Edit Social Info :</td>
                                <td class="about-body col-md-10">
                                    <input type="text" class="admin-social" placeholder="Facebook Link" ><br>
                                    <input type="text" class="admin-social" placeholder="Google plus Link" ><br>
                                    <input type="text" class="admin-social" placeholder="Twitter Link" >
                                </td>
                            </tr>
                            <tr>
                                <td class="text-right col-md-2 about-heading">Edit Website Info :</td>
                                <td class="about-body col-md-10">
                                    <input type="text" class="admin-social" placeholder="Website Link" ><br>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-right col-md-2 about-heading"></td>
                                <td class="about-body col-md-10">
                                    <input type="submit" class="btn btn-sm btn-success pull-righ" value="Submit Info" >
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- SETTING Tab3 END -->
            <!-- MESSAGE Tab4 Start -->
            <div class="tab-pane" id="4a"><br>
                <div class="container">
                    <h1>Message</h1>
                </div>
            </div>
            <!-- MESSAGE Tab4 END -->
        </div>
    </div>
</div> 
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
                    <div class="clearfix"> </div><br>
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
                        <div class="clearfix"></div><br>
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
                        <div class="clearfix"></div><br>
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
                        <br>
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
</div><!--End modal-->
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
