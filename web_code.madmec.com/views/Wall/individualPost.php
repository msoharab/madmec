<?php
$create = (array) $this->idHolders["wall"]["post"]["create"];
?>
<!-- Modal for individual post-->
<div class="modal fade" id="<?php echo $create["parentDiv"]; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title" id="myModalLabel">Post</h3>
            </div>
            <form class="" id="<?php echo $create["form"]; ?>" name="<?php echo $create["form"]; ?>" action="<?php echo $this->config["URL"].$this->config["CTRL_18"]; ?>UploadPic/posts" method="post" action="" enctype="multipart/form-data">
                <fieldset>
                    <div class="modal-body">
                        <div class='conatiner'>
                            <div style="margin:10% auto 0 auto; display: table;">
                                <!-- begin_picedit_box -->
                                <div class="<?php echo $create["postImg"]; ?>">
                                    <!-- Placeholder for messaging -->
                                    <div class="<?php echo $create["postImgMsg"]; ?>">
                                        <span class="picedit_control ico-picedit-close" data-action="hide_messagebox"></span>
                                        <div></div>
                                    </div>
                                    <!-- Picedit navigation -->
                                    <div class="<?php echo $create["postImgNav"]; ?> picedit_gray_gradient">
                                        <div class="picedit_pos_elements"></div>
                                        <div class="picedit_nav_elements">
                                            <!-- Picedit button element begin -->
                                            <div class="picedit_element">
                                                <span class="picedit_control picedit_action ico-picedit-pencil" title="Pen Tool"></span>
                                                <div class="picedit_control_menu">
                                                    <div class="picedit_control_menu_container picedit_tooltip picedit_elm_3">
                                                        <label class="picedit_colors">
                                                            <span title="Black" class="picedit_control picedit_action picedit_black active" data-action="toggle_button" data-variable="pen_color" data-value="black"></span>
                                                            <span title="Red" class="picedit_control picedit_action picedit_red" data-action="toggle_button" data-variable="pen_color" data-value="red"></span>
                                                            <span title="Green" class="picedit_control picedit_action picedit_green" data-action="toggle_button" data-variable="pen_color" data-value="green"></span>
                                                        </label>
                                                        <label>
                                                            <span class="picedit_separator"></span>
                                                        </label>
                                                        <label class="picedit_sizes">
                                                            <span title="Large" class="picedit_control picedit_action picedit_large" data-action="toggle_button" data-variable="pen_size" data-value="16"></span>
                                                            <span title="Medium" class="picedit_control picedit_action picedit_medium" data-action="toggle_button" data-variable="pen_size" data-value="8"></span>
                                                            <span title="Small" class="picedit_control picedit_action picedit_small" data-action="toggle_button" data-variable="pen_size" data-value="3"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Picedit button element end -->
                                            <!-- Picedit button element begin -->
                                            <div class="picedit_element">
                                                <span class="picedit_control picedit_action ico-picedit-insertpicture" title="Crop" data-action="crop_open"></span>
                                            </div>
                                            <!-- Picedit button element end -->
                                            <!-- Picedit button element begin -->
                                            <div class="picedit_element">
                                                <span class="picedit_control picedit_action ico-picedit-redo" title="Rotate"></span>
                                                <div class="picedit_control_menu">
                                                    <div class="picedit_control_menu_container picedit_tooltip picedit_elm_1">
                                                        <label>
                                                            <span>90° CW</span>
                                                            <span class="picedit_control picedit_action ico-picedit-redo" data-action="rotate_cw"></span>
                                                        </label>
                                                        <label>
                                                            <span>90° CCW</span>
                                                            <span class="picedit_control picedit_action ico-picedit-undo" data-action="rotate_ccw"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Picedit button element end -->
                                            <!-- Picedit button element begin -->
                                            <div class="picedit_element">
                                                <span class="picedit_control picedit_action ico-picedit-arrow-maximise" title="Resize"></span>
                                                <div class="picedit_control_menu">
                                                    <div class="picedit_control_menu_container picedit_tooltip picedit_elm_2">
                                                        <label>
                                                            <span class="picedit_control picedit_action ico-picedit-checkmark" data-action="resize_image"></span>
                                                            <span class="picedit_control picedit_action ico-picedit-close" data-action=""></span>
                                                        </label>
                                                        <label>
                                                            <span>Width (px)</span>
                                                            <input type="text" class="picedit_input" data-variable="resize_width" value="0">
                                                        </label>
                                                        <label class="picedit_nomargin">
                                                            <span class="picedit_control ico-picedit-link" data-action="toggle_button" data-variable="resize_proportions"></span>
                                                        </label>
                                                        <label>
                                                            <span>Height (px)</span>
                                                            <input type="text" class="picedit_input" data-variable="resize_height" value="0">
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Picedit button element end -->
                                        </div>
                                    </div>
                                    <!-- Picedit canvas element -->
                                    <div class="<?php echo $create["postImgBox"]; ?>">
                                        <div class="picedit_painter">
                                            <canvas></canvas>
                                        </div>
                                        <div class="picedit_canvas">
                                            <canvas></canvas>
                                        </div>
                                        <div class="picedit_action_btns active">
                                            <div class="picedit_control ico-picedit-picture" data-action="load_image"></div>
                                            <div class="picedit_control ico-picedit-camera" data-action="camera_open"></div>
                                            <div class="center">or copy/paste image here</div>
                                        </div>
                                    </div>
                                    <!-- Picedit Video Box -->
                                    <div class="<?php echo $create["postVid"]; ?>">
                                        <video autoplay></video>
                                        <div class="picedit_video_controls">
                                            <span class="picedit_control picedit_action ico-picedit-checkmark" data-action="take_photo"></span>
                                            <span class="picedit_control picedit_action ico-picedit-close" data-action="camera_close"></span>
                                        </div>
                                    </div>
                                    <!-- Picedit draggable and resizeable div to outline cropping boundaries -->
                                    <div class="<?php echo $create["postImgDrag"]; ?>">
                                        <div class="picedit_drag_resize_canvas"></div>
                                        <div class="picedit_drag_resize_box">
                                            <div class="picedit_drag_resize_box_corner_wrap">
                                                <div class="picedit_drag_resize_box_corner"></div>
                                            </div>
                                            <div class="picedit_drag_resize_box_elements">
                                                <span class="picedit_control picedit_action ico-picedit-checkmark" data-action="crop_image"></span>
                                                <span class="picedit_control picedit_action ico-picedit-close" data-action="crop_close"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end_picedit_box -->
                            </div>
                            <h4 class='text-center'>Upload / Post picture, we accept gif, jpg, & png format. <br />(<strong>Max size:</strong>1.5 MB & <strong>Max Upload:</strong> 30 pics / day)</h4>
                            <div class="row">
                                <div class="col-lg-12"><h4>Title of the post.</h4></div>
                                <div class="col-lg-12">
                                    <input id="<?php echo $create["title"]; ?>" name="<?php echo $create["title"]; ?>" type="text" class="form-control" placeholder="Picture heading goes here..." aria-describedby="basic-addon1" required="required"/>
                                </div>
                                <div class="col-lg-12"><h4>Select target.</h4></div>
                                <div class="col-lg-12">
                                    <select class="form-control" id="<?php echo $create["target"]; ?>" name="<?php echo $create["target"]; ?>">
                                        <option value="0" selected="selected">World</option>
                                        <option value="Country">Country</option>
                                    </select>
                                </div>
                                
                                <div class="col-lg-12">&nbsp;</div>
                                <div class="col-lg-12">
                                    <div class="row" id="<?php echo $create["parentFild"]; ?>"></div>
                                </div>
                                <div class="col-lg-12">&nbsp;</div>
                                <div class="col-lg-12">
                                    <div class="row" id="<?php echo $create["section"]; ?>"></div>
                                </div>
                                <div class="col-lg-12">&nbsp;</div>
                                <div class="col-lg-12">
                                    <div class="input-group">
                                        <span class="input-group-addon woborder">
                                            <input type="checkbox" name="<?php echo $create["iagree"]; ?>" id="<?php echo $create["iagree"]; ?>"  class="iagreeCheck" aria-label="..." required=""/>
                                        </span>
                                        <p class="wop"> I Agree to the <a href="#">Community Rules. </a></p>
                                    </div>
                                </div>
                                <div class="col-lg-12">&nbsp;</div><hr />
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal" name="<?php echo $create["close"]; ?>" id="<?php echo $create["close"]; ?>">Close</button>
                        <button type="submit" class="btn btn-primary" name="<?php echo $create["create"]; ?>" id="<?php echo $create["create"]; ?>">Submit</button>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
</div>
