<?php
$chicon = $this->idHolders["pic3pic"]["channel"]["icon"];
$chbg = $this->idHolders["pic3pic"]["channel"]["backgroud"];
$chad = $this->idHolders["pic3pic"]["channel"]["advertisement"];
$chWeb = !empty($this->ChannelDetails["channel"]["channel_website"]) ?
        $this->ChannelDetails["channel"]["channel_website"] :
        '';
$chGP = !empty($this->ChannelDetails["channel"]["channel_googleplus"]) ?
        $this->ChannelDetails["channel"]["channel_googleplus"] :
        '';
$chFB = !empty($this->ChannelDetails["channel"]["channel_facebook"]) ?
        $this->ChannelDetails["channel"]["channel_facebook"] :
        '';
$chTT = !empty($this->ChannelDetails["channel"]["channel_twitter"]) ?
        $this->ChannelDetails["channel"]["channel_twitter"] :
        '';
?>
<div class="panel" id="<?php echo $chSetting["outputDiv"]; ?>">
    <div class="panel-heading"><h3>Setting, <?php echo $channelName; ?></h3></div>
    <div class="panel-body table-responsive">
        <form class=""
              id="<?php echo $chSetting["form"]; ?>"
              name="<?php echo $chSetting["form"]; ?>"
              action="<?php echo $chSetting["url"]; ?>"
              method="post"
              enctype="multipart/form-data">
            <fieldset>
                <table class="table table-striped">
                    <tbody>
                        <tr>
                            <td class="text-right col-md-2 about-heading">Total Disk Space :</td>
                            <td class="about-body col-md-4">
                                <?php echo $ChannelSize; ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-right col-md-2 about-heading">Edit Name :</td>
                            <td class="about-body col-md-4">
                                <input type="text"
                                       id="<?php echo $chSetting["name"]; ?>"
                                       name="<?php echo $chSetting["name"]; ?>"
                                       class="form-control"
                                       placeholder="Channel Name"
                                       value="<?php echo $channelName; ?>"/>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-right col-md-2 about-heading">Edit Description :</td>
                            <td class="about-body col-md-4">
                                <textarea id="<?php echo $chSetting["description"]; ?>"
                                          name="<?php echo $chSetting["description"]; ?>"
                                          class="form-control"
                                          placeholder="Add description"><?php echo $chDes; ?></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-right col-md-2 about-heading">Change Banner :</td>
                            <td class="about-body col-md-4">
                                <button type="button"
                                        class="btn btn-block btn-danger btn-circle"
                                        id="<?php echo $chbg["parentBut"]; ?>"
                                        name="<?php echo $chbg["parentBut"]; ?>"
                                        data-toggle="modal"
                                        data-target="#<?php echo $chbg["parentDiv"]; ?>"
                                        data-whatever="@mdo">Change</button>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-right col-md-2 about-heading">Change Icon :</td>
                            <td class="about-body col-md-4">
                                <button type="button"
                                        class="btn btn-block btn-danger btn-circle"
                                        id="<?php echo $chicon["parentBut"]; ?>"
                                        name="<?php echo $chicon["parentBut"]; ?>"
                                        data-toggle="modal"
                                        data-target="#<?php echo $chicon["parentDiv"]; ?>"
                                        data-whatever="@mdo">Change</button>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-right col-md-2 about-heading">Advertisement :</td>
                            <td class="about-body col-md-4">
                                <button type="button"
                                        class="btn btn-block btn-danger btn-circle"
                                        id="<?php echo $chad["parentBut"]; ?>"
                                        name="<?php echo $chad["parentBut"]; ?>"
                                        data-toggle="modal"
                                        data-target="#<?php echo $chad["parentDiv"]; ?>"
                                        data-whatever="@mdo">Change</button>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-right col-md-2 about-heading">Add Admin's :</td>
                            <td class="about-body col-md-4">
                                <div id="room_fileds">
                                    <div>
                                        <div class="contentpic">
                                            <div class="input-group">
                                                <span class="input-group-addon" id="basic-addon1"><i class="fa fa-user"></i></span>
                                                <select id="<?php echo $chSetting["admins"]; ?>"
                                                        name="<?php echo $chSetting["admins"]; ?>"
                                                        class="js-data-example-ajax form-control"
                                                        multiple="multiple">
                                                </select>
                                            </div>
                                        </div>
                                    </div><br />
                                </div>
                                <div class="clearfix"></div>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-right col-md-2 about-heading">Edit Social Info :</td>
                            <td class="about-body col-md-4">
                                <input type="text" class="admin-social"
                                       id="<?php echo $chSetting["facebook"]; ?>"
                                       name="<?php echo $chSetting["facebook"]; ?>"
                                       placeholder="Facebook Link"
                                       value="<?php echo $chFB; ?>"/><br />
                                <input type="text" class="admin-social"
                                       id="<?php echo $chSetting["googleplus"]; ?>"
                                       name="<?php echo $chSetting["googleplus"]; ?>"
                                       placeholder="Google plus Link"
                                       value="<?php echo $chGP; ?>"/><br />
                                <input type="text" class="admin-social"
                                       id="<?php echo $chSetting["twitter"]; ?>"
                                       name="<?php echo $chSetting["twitter"]; ?>"
                                       placeholder="Twitter Link"
                                       value="<?php echo $chTT; ?>"/>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-right col-md-2 about-heading">Edit Website Info :</td>
                            <td class="about-body col-md-4">
                                <input type="text" class="admin-social"
                                       id="<?php echo $chSetting["website"]; ?>"
                                       name="<?php echo $chSetting["website"]; ?>"
                                       placeholder="Website Link"
                                       value="<?php echo $chWeb; ?>" /><br />
                            </td>
                        </tr>
                        <tr>
                            <td class="text-right col-md-2 about-heading"></td>
                            <td class="about-body col-md-4">
                                <input type="submit"
                                       class="btn btn-sm btn-success pull-righ"
                                       id="<?php echo $chSetting["submit"]; ?>"
                                       name="<?php echo $chSetting["submit"]; ?>"
                                       value="Submit Info" />
                            </td>
                        </tr>
                    </tbody>
                </table>
            </fieldset>
        </form>
    </div>
</div>
