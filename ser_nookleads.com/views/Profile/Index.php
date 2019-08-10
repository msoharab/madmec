<!--//////////////////-------- Cover Image Start ////////////////////////////-->
<div class="container-fluid">
    <h2 class="business-heading">Mera bharat mahan</h2>
    <div class="business-cover">
        <img src="<?php echo $this->config["URL"] . $this->config["VIEWS"]; ?>assets/img/businesss/business.jpg" class="img-responsive">
    </div>      
    <div class="col-md-2 col-sm-7 col-xs-7">
        <img src="<?php echo $this->config["URL"] . $this->config["VIEWS"]; ?>assets/img/businesss/profile1.jpg" class="img-responsive img-thumbnail business-profile">
    </div>      
    <br>
    <div class="col-md-1">        
        <a href="#" class="" > <i class="fa fa-thumbs-o-up thumbs-up fa-lg"></i> 23</a> Approvals <span class="gap-right"></span>        
    </div>
    <div class="col-md-1 " onclick="$('#share-list-main').slideToggle('slow');">
        <a class="text-right" href="javascript:void();"><i class="fa fa-share-alt"></i> Share </a>
    </div>                  
    <div id="share-list-main" class="col-md-3" style="display:none;">
        <a class="" href="#"><i class="fa fa-facebook-square fa fa-lg"></i></a>
        <a class="" href="#"><i class="fa fa-twitter-square fa fa-lg"></i></a>
        <a class="" href="#"><i class="fa fa-instagram fa fa-lg"></i></a>
        <a class="" href="#"><i class="fa fa-dribbble fa fa-lg"></i></a>
        <a class="" href="#"><i class="fa fa-flickr fa fa-lg"></i></a>
        <a class="" href="#"><i class="fa fa-pinterest-square fa fa-lg"></i></a>
        <a class="" href="#"><i class="fa fa-google-plus-square fa fa-lg"></i></a>
    </div>
</div>   
<div class="col-md-4 pull-right text-right">    
    <button class="btn btn-deafult btn-subscribe pull-right"></i> 213 </button>    
    <button class="btn btn-danger btn-subscribe pull-right"><i class="fa fa-eye"> </i> Subscribe </button>
    <button class="btn btn-danger btn-subscribe" data-toggle="modal" data-target="#profilereport">
        <i class="fa fa-flag"></i> Report</button><span class="gap-right"></span>
    <button class="btn btn-danger btn-subscribe">
        <i class="fa fa-flag"></i> Block</button><span class="gap-right"></span>
</div>  
<!--//////////////////--------  Cover Image End --------////////////////////////////-->
<div class="col-md-3"></div>
<div class="clearfix"></div></br>
<!--/////////////////////--------  Bottom Tabs Start ------//////////////////////////////////-->
<div class="col-lg-12 col-md-12 col-sm-12 colxs-12">
    <div id="exTab1" class=""> 
        <ul class="nav nav-tabs">
            <li class="active">
                <a  href="#1a" data-toggle="tab">Home</a>
            </li>
            <li>
                <a href="#2a" data-toggle="tab">Business</a>
            </li>
            <li>
                <a href="#3a" data-toggle="tab">About</a>
            </li>
            <li>
                <a href="#4a" data-toggle="tab">Message</a>
            </li>
            <li>
                <a href="#5a" data-toggle="tab">Setting</a>
            </li>
        </ul>
        <div class="tab-content clearfix">
            <!--////////////////////////// 1a TAB Start -------- HOME --------/////////////////////////////////-->
            <div class="tab-pane active" id="1a"><br>
                <div id="exTab2" class=""> 
                    <ul class="nav nav-pills">
                        <li class="active">
                            <a  href="#1b" data-toggle="tab">Lead</a>
                        </li>
                        <li>
                            <a href="#2b" data-toggle="tab">Activity</a>
                        </li>
                    </ul>
                    <div class="tab-content clearfix">
                        <!--//////////// ------  1b TAB POST Start ------ ///////////-->
                        <div class="tab-pane active" id="1b">
                            <div class="container"><br>
                                <div class="col-xs-12 col-sm-12 col-md-6" id="show-lead" style="display:none;">&nbsp;</div>
                                <div class="col-xs-12 col-sm-12 col-md-6" id="hide-lead">
                                    <div class="thumbnail">
                                        <h4 class="">Heading Dummy Content</h4>
                                        <div class="dropdown close-lead">
                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-close"></i></a>
                                            <div class="dropdown-menu close-lead-dd">
                                                <div class="close-lead-dd-item"><a href="javascript:void();" id="del-lead" onclick=" $('#hide-lead').hide('fast');
                                                        $('#show-lead').show('fast');">Remove this image</a></div>
                                                <div class="close-lead-dd-item-child"><a href="#">Block this business</a></div>
                                            </div>
                                        </div>
                                        <div class="">
                                            <a class="fancybox" rel="gallery2" title="Gallery 1 - 1" href="<?php echo $this->config["URL"] . $this->config["VIEWS"]; ?>assets/img/photo1.jpg"><img src="<?php echo $this->config["URL"] . $this->config["VIEWS"]; ?>assets/img/photo1.jpg" alt=""/></a>
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
                                                <div id="target1" style="display:none;"><hr />
                                                    <div class="col-md-2 " onclick="$('#share-list').slideToggle('slow');"><a class="" href="javascript:void();"><i class="fa fa-share-alt"></i> Share </a></div>                  
                                                    <div id="share-list" style="display:none;"><div class="col-md-1"><a class="" href="#"><i class="fa fa-facebook-square"></i></a></div>
                                                        <div class="col-md-1"><a class="" href="#"><i class="fa fa-twitter-square"></i></a></div>
                                                        <div class="col-md-1"><a class="" href="#"><i class="fa fa-instagram"></i></a></div>
                                                        <div class="col-md-1"><a class="" href="#"><i class="fa fa-dribbble"></i></a></div>
                                                        <div class="col-md-1"><a class="" href="#"><i class="fa fa-flickr"></i></a></div>
                                                        <div class="col-md-1"><a class="" href="#"><i class="fa fa-pinterest-square"></i></a></div>
                                                        <div class="col-md-1"><a class="" href="#"><i class="fa fa-google-plus-square"></i></a></div></div>
                                                    <div class="col-md-3 pull-right text-right">
                                                        <button class="btn btn-danger btn-subscribe " data-toggle="modal" data-target="#leadreport">
                                                            <i class="fa fa-flag"></i> Report
                                                        </button>
                                                    </div>
                                                    <div class="clearfix">&nbsp;</div>
                                                    <div class="col-md-12"></div><br>
                                                    <ul id="quotations">
                                                        <i class="fa fa-thumbs-o-up thumbs-up"></i> <a href="#"> 786</a> people approval this
                                                        <a href="#"> . </a>
                                                        <i class="fa fa-envelope-square thumbs-up"></i> <a href="#"> 34</a> quotations
                                                        <li class="cmmnt ">
                                                            <!--Quotations in parent-->
                                                            <div class="avatar">
                                                                <a href="javascript:void(0);">
                                                                    <img src="<?php echo $this->config["URL"] . $this->config["VIEWS"]; ?>assets/img/quotations-img/dark-cubes.png" class="img-input-small" alt="DarkCubes photo avatar">
                                                                </a>
                                                            </div>
                                                            <div class="cmmnt-content">
                                                                <div class="input-group add-on">
                                                                    <input class="form-control" placeholder="Quotation ..." name="srch-term" id="srch-term" type="text">
                                                                    <input type="file" id="QuotationfileLoader" name="Quotationfiles" title="Load quotation File" style = "display:none;" />
                                                                    <div class="input-group-btn">
                                                                        <button class="btn btn-default" id="quotation-button" onclick="OpenFileDialogForQuotationSection();"><i class="glyphicon glyphicon-camera"></i></button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="clearfix"><br></div>              
                                                        </li><!-- end parent-->
                                                        <li class="cmmnt cmmnts-border ParentsQuotation  onhovershowcross">
                                                            <div class="avatar "><a href="javascript:void(0);"><img src="<?php echo $this->config["URL"] . $this->config["VIEWS"]; ?>assets/img/quotations-img/dark-cubes.png" class="img-comnt-small" alt="DarkCubes photo avatar"></a></div>
                                                            <div class="cmmnt-content ">
                                                                <header>
                                                                    <a href="javascript:void(0);" class="userlink">DarkCubes</a> - 
                                                                    <span class="pubdate"> 1 week ago</span>
                                                                </header>
                                                                <div class="dropdown close-lead">
                                                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-close"></i></a>
                                                                    <div class="dropdown-menu close-lead-dd">
                                                                        <div class="close-lead-dd-item"><a href="javascript:void();" id="del-lead" onclick="if (confirm('Are you sure...? ')) {
                                                                                    $('.ParentsQuotation').hide('fast');
                                                                                }">Remove this Quotation</a></div>
                                                                        <div class="close-lead-dd-item-child"><a href="#">Report Quotation</a></div>
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
                                                                <a href="#">Approval</a><span style="padding-right:10px;"></span>
                                                                <a href="#">Wo</a>
                                                                <a href="#"> . </a>
                                                                <i class="fa fa-thumbs-o-up thumbs-up"></i> <a href="#"> 786</a> 
                                                                <i class="fa fa-envelope-square thumbs-up"></i> <a href="#"> 34</a> 
                                                            </div>
                                                            <div class="cmmnt ">
                                                                <!--Quotations in child-->
                                                                <div class="avatar"><a href="javascript:void(0);"><img src="<?php echo $this->config["URL"] . $this->config["VIEWS"]; ?>assets/img/quotations-img/dark-cubes.png" class="img-input-small" alt="DarkCubes photo avatar"></a></div>
                                                                <div class="cmmnt-content">
                                                                    <div class="input-group add-on">
                                                                        <input class="form-control" placeholder="Wo to quotation..." name="srch-term" id="srch-term" type="text">
                                                                        <input type="file" id="WofileLoader" name="Wofiles" title="Load Wo File" style = "display:none;" />
                                                                        <div class="input-group-btn">
                                                                            <button class="btn btn-default" id="wo-button" onclick="OpenFileDialogForWoSection();"><i class="glyphicon glyphicon-camera"></i></button>
                                                                        </div>
                                                                    </div>                             
                                                                </div>
                                                                <div class="clearfix"><br></div>              
                                                            </div><!-- end child-->
                                                        <li class="cmmnt ChildQuotation onhovershowcross">                                 
                                                            <ul class="wo">
                                                                <li class="cmmnt cmmnts-border">
                                                                    <div class="avatar"><a href="javascript:void(0);"><img src="<?php echo $this->config["URL"] . $this->config["VIEWS"]; ?>assets/img/quotations-img/pig.png" class="img-comnt-small" alt="Sir_Pig photo avatar"></a></div>
                                                                    <div class="cmmnt-content">
                                                                        <header>
                                                                            <a href="javascript:void(0);" class="userlink">Sir_Pig</a> - 
                                                                            <span class="pubdate"> 1 day ago</span>
                                                                        </header>
                                                                        <div class="dropdown close-lead" id="close-lead">
                                                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-close"></i></a>
                                                                            <div class="dropdown-menu close-lead-dd">
                                                                                <div class="close-lead-dd-item"><a href="javascript:void();" id="del-lead" onclick="if (confirm('Are you sure...? ')) {
                                                                                            $('.ChildQuotation').hide('fast');
                                                                                        }">Remove this quotation</a></div>
                                                                                <div class="close-lead-dd-item-child"><a href="#">Report Quotation</a></div>
                                                                            </div>
                                                                        </div>
                                                                        <p>Sed felis lorem, venenatis sed malesuada vitae, tempor vel turpis. Mauris in dui velit, vitae mollis risus.</p>
                                                                        <p>Morbi id neque nisl, nec fringilla lorem. Duis molestie sodales leo a blandit. Mauris sit amet ultricies libero. Etiam quis diam in lacus molestie fermentum non vel quam.</p>
                                                                        <a href="#">Approval</a><span style="padding-right:10px;"> </span><a href="#"><i class="fa fa-thumbs-o-up thumbs-up"></i> 786</a> people approval this
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
                                <div class="col-xs-12 col-sm-12 col-md-6">
                                    <div class="pull-right">
                                        <button type="button" class="btn btn-danger btn-small" data-toggle="modal" data-target="#myModal">
                                            <i class="fa fa-edit"></i> Lead
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
                        <!--//////////// ------  1b TAB POST End ------ ///////////-->
                        <!--//////////// ------  2b TAB ACTIVITY Start ------ ///////////-->
                        <div class="tab-pane" id="2b"><br>
                            <div class="tab-content clearfix">
                                <div class="tab-pane active" id="1b">
                                    <div class="container">
                                        <div class="col-xs-12 col-sm-12 col-md-6" id="hide-lead">
                                            <div class="thumbnail">
                                                <h4 class="">Heading Dummy Content</h4>
                                                <div class="dropdown close-lead">
                                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-close"></i></a>
                                                    <div class="dropdown-menu close-lead-dd">
                                                        <div class="close-lead-dd-item"><a href="javascript:void();" id="del-lead" onclick=" $('#hide-lead').hide('fast');
                                                                $('#show-lead').show('fast');">Remove this image</a></div>
                                                        <div class="close-lead-dd-item-child"><a href="#">Block this business</a></div>
                                                    </div>
                                                </div>
                                                <div class="">
                                                    <a class="fancybox" rel="gallery2" title="Gallery 1 - 1" href="<?php echo $this->config["URL"] . $this->config["VIEWS"]; ?>assets/img/photo1.jpg"><img src="<?php echo $this->config["URL"] . $this->config["VIEWS"]; ?>assets/img/photo1.jpg" alt=""/></a>
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
                                                            <a href="javascript:void();" class="ellipsis" onclick="$('#target2').slideToggle('slow');">
                                                                <i class="fa fa-ellipsis-h fa-lg"></i> <i class="fa fa-ellipsis-h fa-lg"></i>
                                                            </a>
                                                        </div>
                                                        <div class="col-md-7">
                                                            <i class="fa fa-tags"></i><a class="" href="#"> education & resarch industry</a><br>
                                                            <i class="fa fa-user"></i><a class="" href="#"> Bikram keshari pattnayak</a>
                                                        </div>
                                                        <div class="col-md-3"><a class="btn btn-danger pull-right" href="#">
                                                                <i class="fa fa-eye"></i> Subscribe</a></div>
                                                        <div class="clearfix"><br><br></div>
                                                        <div id="target2" style="display:none;"><hr />
                                                            <div class="col-md-2 " onclick="$('#share-list').slideToggle('slow');"><a class="" href="javascript:void();"><i class="fa fa-share-alt"></i> Share </a></div>                  
                                                            <div id="share-list" style="display:none;"><div class="col-md-1"><a class="" href="#"><i class="fa fa-facebook-square"></i></a></div>
                                                                <div class="col-md-1"><a class="" href="#"><i class="fa fa-twitter-square"></i></a></div>
                                                                <div class="col-md-1"><a class="" href="#"><i class="fa fa-instagram"></i></a></div>
                                                                <div class="col-md-1"><a class="" href="#"><i class="fa fa-dribbble"></i></a></div>
                                                                <div class="col-md-1"><a class="" href="#"><i class="fa fa-flickr"></i></a></div>
                                                                <div class="col-md-1"><a class="" href="#"><i class="fa fa-pinterest-square"></i></a></div>
                                                                <div class="col-md-1"><a class="" href="#"><i class="fa fa-google-plus-square"></i></a></div></div>
                                                            <div class="col-md-3 pull-right text-right">
                                                                <button class="btn btn-danger btn-subscribe " data-toggle="modal" data-target="#activityreport">
                                                                    <i class="fa fa-flag"></i> Report
                                                                </button>
                                                            </div>
                                                            <div class="clearfix">&nbsp;</div>
                                                            <div class="col-md-12"></div><br>
                                                            <ul id="quotations">
                                                                <i class="fa fa-thumbs-o-up thumbs-up"></i> <a href="#"> 786</a> people approval this
                                                                <a href="#"> . </a>
                                                                <i class="fa fa-envelope-square thumbs-up"></i> <a href="#"> 34</a> quotations
                                                                <li class="cmmnt ">
                                                                    <!--Quotations in parent-->
                                                                    <div class="avatar">
                                                                        <a href="javascript:void(0);">
                                                                            <img src="<?php echo $this->config["URL"] . $this->config["VIEWS"]; ?>assets/img/quotations-img/dark-cubes.png" class="img-input-small" alt="DarkCubes photo avatar">
                                                                        </a>
                                                                    </div>
                                                                    <div class="cmmnt-content">
                                                                        <div class="input-group add-on">
                                                                            <input class="form-control" placeholder="Quotation ..." name="srch-term" id="srch-term" type="text">
                                                                            <input type="file" id="QuotationfileLoader" name="Quotationfiles" title="Load quotation File" style = "display:none;" />
                                                                            <div class="input-group-btn">
                                                                                <button class="btn btn-default" id="quotation-button" onclick="OpenFileDialogForQuotationSection();"><i class="glyphicon glyphicon-camera"></i></button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="clearfix"><br></div>              
                                                                </li><!-- end parent-->
                                                                <li class="cmmnt cmmnts-border ParentsQuotation  onhovershowcross">
                                                                    <div class="avatar "><a href="javascript:void(0);"><img src="<?php echo $this->config["URL"] . $this->config["VIEWS"]; ?>assets/img/quotations-img/dark-cubes.png" class="img-comnt-small" alt="DarkCubes photo avatar"></a></div>
                                                                    <div class="cmmnt-content ">
                                                                        <header>
                                                                            <a href="javascript:void(0);" class="userlink">DarkCubes</a> - 
                                                                            <span class="pubdate"> 1 week ago</span>
                                                                        </header>
                                                                        <div class="dropdown close-lead">
                                                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-close"></i></a>
                                                                            <div class="dropdown-menu close-lead-dd">
                                                                                <div class="close-lead-dd-item"><a href="javascript:void();" id="del-lead" onclick="if (confirm('Are you sure...? ')) {
                                                                                            $('.ParentsQuotation').hide('fast');
                                                                                        }">Remove this Quotation</a></div>
                                                                                <div class="close-lead-dd-item-child"><a href="#">Report Quotation</a></div>
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
                                                                        <a href="#">Approval</a><span style="padding-right:10px;"></span>
                                                                        <a href="#">Wo</a>
                                                                        <a href="#"> . </a>
                                                                        <i class="fa fa-thumbs-o-up thumbs-up"></i> <a href="#"> 786</a> 
                                                                        <i class="fa fa-envelope-square thumbs-up"></i> <a href="#"> 34</a> 
                                                                    </div>
                                                                    <div class="cmmnt ">
                                                                        <!--Quotations in child-->
                                                                        <div class="avatar"><a href="javascript:void(0);"><img src="<?php echo $this->config["URL"] . $this->config["VIEWS"]; ?>assets/img/quotations-img/dark-cubes.png" class="img-input-small" alt="DarkCubes photo avatar"></a></div>
                                                                        <div class="cmmnt-content">
                                                                            <div class="input-group add-on">
                                                                                <input class="form-control" placeholder="Wo to quotation..." name="srch-term" id="srch-term" type="text">
                                                                                <input type="file" id="WofileLoader" name="Wofiles" title="Load Wo File" style = "display:none;" />
                                                                                <div class="input-group-btn">
                                                                                    <button class="btn btn-default" id="wo-button" onclick="OpenFileDialogForWoSection();"><i class="glyphicon glyphicon-camera"></i></button>
                                                                                </div>
                                                                            </div>                             
                                                                        </div>
                                                                        <div class="clearfix"><br></div>              
                                                                    </div><!-- end child-->
                                                                <li class="cmmnt ChildQuotation onhovershowcross">                                 
                                                                    <ul class="wo">
                                                                        <li class="cmmnt cmmnts-border">
                                                                            <div class="avatar"><a href="javascript:void(0);"><img src="<?php echo $this->config["URL"] . $this->config["VIEWS"]; ?>assets/img/quotations-img/pig.png" class="img-comnt-small" alt="Sir_Pig photo avatar"></a></div>
                                                                            <div class="cmmnt-content">
                                                                                <header>
                                                                                    <a href="javascript:void(0);" class="userlink">Sir_Pig</a> - 
                                                                                    <span class="pubdate"> 1 day ago</span>
                                                                                </header>
                                                                                <div class="dropdown close-lead" id="close-lead">
                                                                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-close"></i></a>
                                                                                    <div class="dropdown-menu close-lead-dd">
                                                                                        <div class="close-lead-dd-item"><a href="javascript:void();" id="del-lead" onclick="if (confirm('Are you sure...? ')) {
                                                                                                    $('.ChildQuotation').hide('fast');
                                                                                                }">Remove this quotation</a></div>
                                                                                        <div class="close-lead-dd-item-child"><a href="#">Report Quotation</a></div>
                                                                                    </div>
                                                                                </div>
                                                                                <p>Sed felis lorem, venenatis sed malesuada vitae, tempor vel turpis. Mauris in dui velit, vitae mollis risus.</p>
                                                                                <p>Morbi id neque nisl, nec fringilla lorem. Duis molestie sodales leo a blandit. Mauris sit amet ultricies libero. Etiam quis diam in lacus molestie fermentum non vel quam.</p>
                                                                                <a href="#">Approval</a><span style="padding-right:10px;"> </span><a href="#"><i class="fa fa-thumbs-o-up thumbs-up"></i> 786</a> people approval this
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
                                            <!-- End of Thumbnail -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--//////////// ------  2b TAB ACTIVITY End ------ ///////////-->
                    </div>
                </div>
            </div>
            <!--//////////////////// end of 1a tab-------- HOME --------////////////////////////////////-->
            <!-- /////////////////////////// 2a TAB Start -------- CHANNEL  --------//////////////////////////////-->
            <div class="tab-pane" id="2a"><br>
                <div class="col-lg-4">
                    <div class="list-group">
                        <a href="javascript:void();" class="list-group-item col-md-12 active">
                            <h4 class="list-group-item-heading col-md-6 align-left">Captain Business</h4>
                        </a>
                        <a href="javascript:void();" class="list-group-item col-md-12 ">
                            <h4 class="list-group-item-heading col-md-6 align-left">CaptainBusiness-1</h4>
                            <h5 class="list-group-item-heading col-md-6 align-right">Lead</h5>
                        </a>
                        <a href="javascript:void();" class="list-group-item col-md-12 ">
                            <h4 class="list-group-item-heading col-md-6 align-left">CaptainBusiness-2</h4>
                            <h5 class="list-group-item-heading col-md-6 align-right">Lead</h5>
                        </a>
                        <a href="javascript:void();" class="list-group-item col-md-12 ">
                            <h4 class="list-group-item-heading col-md-6 align-left">CaptainBusiness-3</h4>
                            <h5 class="list-group-item-heading col-md-6 align-right">Lead</h5>
                        </a>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="list-group">
                        <a href="javascript:void();" class="list-group-item col-md-12 active">
                            <h4 class="list-group-item-heading col-md-6 align-left">Captain Business</h4>
                        </a>
                        <a href="javascript:void();" class="list-group-item col-md-12 ">
                            <h4 class="list-group-item-heading col-md-6 align-left">CaptainBusiness-1</h4>
                            <h5 class="list-group-item-heading col-md-6 align-right">Lead</h5>
                        </a>
                        <a href="javascript:void();" class="list-group-item col-md-12 ">
                            <h4 class="list-group-item-heading col-md-6 align-left">CaptainBusiness-2</h4>
                            <h5 class="list-group-item-heading col-md-6 align-right">Lead</h5>
                        </a>
                        <a href="javascript:void();" class="list-group-item col-md-12 ">
                            <h4 class="list-group-item-heading col-md-6 align-left">CaptainBusiness-3</h4>
                            <h5 class="list-group-item-heading col-md-6 align-right">Lead</h5>
                        </a>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="list-group">
                        <a href="javascript:void();" class="list-group-item col-md-12 active">
                            <h4 class="list-group-item-heading col-md-6 align-left">Subscribed Business</h4>
                        </a>
                        <a href="javascript:void();" class="list-group-item col-md-12 ">
                            <h4 class="list-group-item-heading col-md-6 align-left">SubscribedBusiness-1</h4>
                            <h5 class="list-group-item-heading col-md-6 align-right">Lead</h5>
                        </a>
                        <a href="javascript:void();" class="list-group-item col-md-12 ">
                            <h4 class="list-group-item-heading col-md-6 align-left">SubscribedBusiness-2</h4>
                            <h5 class="list-group-item-heading col-md-6 align-right">Lead</h5>
                        </a>
                    </div>
                </div>
            </div><!-- //////////////////// end of 2a tab -------- CHANNEL  --------///////////////////////////// -->
            <!-- ////////////////////////////////// 3a TAB Start -------- ABOUT --------//////////////////// -->
            <div class="tab-pane" id="3a"><br>
                <div class="container">
                    <table class="table table-condensed">
                        <tbody>
                            <tr>
                                <td class="text-right col-md-2 about-heading">About :</td>
                                <td class="about-body col-md-10">There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.</td>
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
            </div><!--///////////////////////////  End of 3a tab -------- ABOUT --------/////////////////////// -->
            <!--/////////////////////////////////////  4a TAB Start -------- MESSAGE --------//////////////////// -->
            <div class="tab-pane" id="4a"><br>
                <div class="container">
                    <h1>Message</h1>
                </div>
            </div><!-- ///////////////////////////// End of 4a tab  -------- MESSAGE --------////////////////// -->  
            <!-- ////////////////////////////////// 5a TAB Start -------- SETTING  --------///////////////////// -->
            <div class="tab-pane" id="5a"><br>
                <div class="container">
                    <div class="panel panel-default">
                        <div class="panel-heading">Setting</div>
                        <div class="panel-body">
                            <h3>Default Lead Setting</h3>
                            <div class="row">
                                <div class="col-lg-2">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <input type="checkbox" aria-label="...">
                                        </span>
                                        <input type="text" class="form-control" aria-label="..." readonly value="World">
                                    </div><!-- /input-group -->
                                </div><!-- /.col-lg-3 -->
                                <div class="col-lg-2">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <input type="checkbox" aria-label="...">
                                        </span>
                                        <input type="text" class="form-control" aria-label="..." readonly value="Country">
                                    </div><!-- /input-group -->
                                </div><!-- /.col-lg-3 -->
                                <div class="col-lg-4">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            Choose Country
                                        </span>
                                        <select class="form-control" id="sel1">
                                            <option>Country Name-1</option>
                                            <option>Country Name-2</option>
                                            <option>Country Name-3</option>
                                            <option>Country Name-4</option>
                                        </select>
                                    </div><!-- /input-group -->
                                </div><!-- /.col-lg-3 -->
                                <div class="col-lg-4">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            Language
                                        </span>
                                        <select class="form-control" id="sel1">
                                            <option>Country Name-1</option>
                                            <option>Country Name-2</option>
                                            <option>Country Name-3</option>
                                            <option>Country Name-4</option>
                                        </select>
                                    </div><!-- /input-group -->
                                </div><!-- /.col-lg-3 -->
                                <div class="clearfix"><br><br></div>
                                <div class="col-lg-6">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            Choose Sections
                                        </span>
                                        <select class="form-control" id="sel1">
                                            <option>Choose Section-1</option>
                                            <option>Choose Section-2</option>
                                            <option>Choose Section-3</option>
                                            <option>Choose Section-4</option>
                                        </select>
                                    </div><!-- /input-group -->
                                </div><!-- /.col-lg-3 -->
                                <div class="col-lg-6">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            Block List
                                        </span>
                                        <select class="form-control" id="sel1">
                                            <option>Block List-1</option>
                                            <option>Block List-2</option>
                                            <option>Block List-3</option>
                                            <option>Block List-4</option>
                                        </select>
                                    </div><!-- /input-group -->
                                </div><!-- /.col-lg-3 -->
                                <div class="clearfix"><br><br></div>
                                <div class="col-lg-12">
                                    <div class="input-group pull-right">
                                        <button type="button" class="btn btn-primary ">Set As Default  </button>                              
                                    </div><!-- /input-group -->
                                </div><!-- /.col-lg-3 -->
                            </div><!-- /.row -->
                        </div>
                    </div>
                </div>
            </div><!--///////////////////////////  End of 5a tab -------- SETTING  --------////////////////////// -->
        </div>
    </div>
</div>
<!--/////////////////////--------  Bottom Tabs Ends ------//////////////////////////////////-->   
<!-- modal for Profile report start-->
<div id="profilereport" class="modal fade bs-example-modal-sm" tabindex="-3" role="dialog" aria-labelledby="mySmallModalLabel">
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
                    <p class="wop">Stealing intellectual property</p>
                </div><!-- /input-group --> 
                <div class="input-group">
                    <span class="input-group-addon woborder">
                        <input type="radio" aria-label="..." name="ReportAbuse">
                    </span>
                    <p class="wop"> Abusive</p>
                </div><!-- /input-group --> 
                <div class="input-group">
                    <span class="input-group-addon woborder">
                        <input type="radio" aria-label="..." name="ReportAbuse">
                    </span>
                    <p class="wop">Harssing me in nookleads</p>
                </div><!-- /input-group --> 
                <div class="input-group">
                    <span class="input-group-addon woborder">
                        <input type="radio" aria-label="..." name="ReportAbuse">
                    </span>
                    <p class="wop">Violate community guidelines</p>
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
                    <p class="wop">Others</p>
                </div><!-- /input-group -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="submitreport">Submit</button>
                </div>
            </div>
        </div>
    </div>
</div>    
<!-- modal for Business report end-->
<!-- modal for lead TAB report start-->
<div id="leadreport" class="modal fade bs-example-modal-sm" tabindex="-2" role="dialog" aria-labelledby="mySmallModalLabel">
    <div class="modal-dialog modal-sm">
        <div class="modal-content col-lg-12">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"><strong>Report This Lead</strong></h4>
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
                    <p class="wop">Relead from other site/business without modification</p>
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
<!-- modal for lead report end-->
<!-- modal for lead TAB report start-->
<div id="activityreport" class="modal fade bs-example-modal-sm" tabindex="-2" role="dialog" aria-labelledby="mySmallModalLabel">
    <div class="modal-dialog modal-sm">
        <div class="modal-content col-lg-12">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"><strong>Report This Lead</strong></h4>
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
                    <p class="wop">Report from other site/business without modification</p>
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
<!-- modal for lead report end-->
<!-- ///////////////////////////Modal for lead pic start////////////////////////////////////////-->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title" id="myModalLabel">Lead</h3>
            </div>
            <div class="modal-body">
                <div class='conatiner'>
                    <h4 class='text-center'>Upload / Lead picture, we accept gif, jpg, & png format. <br>(<strong>Max size:</strong>1.5 MB & <strong>Max Upload:</strong> 30 pics / day)</h4>
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
                            <input type="radio" name="createbusiness" value="world" checked class="gap-right"><label>&nbsp; World </label>  <span class="gap-right"></span>              
                            <input type="radio" name="createbusiness" value="world" ><label>&nbsp; Country</label>
                        </span>
                        <select class="form-control" id="sel1">
                            <option>Country Name-1</option>
                            <option>Country Name-2</option>
                            <option>Country Name-3</option>
                            <option>Country Name-4</option>
                        </select>
                    </div>
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
                            <p class="wop"> Anonymous Lead </p>
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
                    <br><hr /><br>
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
<!--/////////////////////////////////End modal/////////////////////////////////////////////////-->
