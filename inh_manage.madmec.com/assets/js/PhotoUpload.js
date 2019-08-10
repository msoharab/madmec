function UploadPicture() {
    /* Members variables */
    var JsonID = {}; /* User name & pk should be saved as json */
    var AjaxLoader = '<img class="img-circle" src="' + URL + ASSET_IMG + 'spinner_grey_120.gif" border="0" width="60" height="60" />';
    var HowMany = false;
    var ToWhom = false;
    var num_reg = /^[0-9]{1,10}$/;
    var name_reg = /^[A-Z_a-z\.\'\- 0-9]{3,100}$/;
    var UploadIds = {};
    /* Constructor */
    this.__constructor = function (para) {
        HowMany = para.HowMany;
        ToWhom = para.ToWhom;
        UploadIds = {
            LoaderIMG: '<img class="img-circle" src="' + URL + ASSET_IMG + 'spinner_grey_120.gif" border="0" width="60" height="60" />',
            TabLoader: ".photo_loader",
            PageLoader: para.PageLoader,
            ParentDiv: para.ParentDiv,
            ParentMenuDiv: {HardDiskLink: "#action_upload-" + para.uniqueDiv,
                CameraLink: "#action_capture-" + para.uniqueDiv
            },
            HardDiskDiv: {MenuTab: "#upload-pills-" + para.uniqueDiv,
                ParentDiv: "#upload_photo-" + para.uniqueDiv,
                FormID: "#uploadphoto-" + para.uniqueDiv,
                FormURL: para.HardDiskURL,
                BrowseButton: "#imgfile-" + para.uniqueDiv,
                TableUploadPhoto: "#table_upload_photo-" + para.uniqueDiv,
                PbarParent: "#progress-" + para.uniqueDiv,
                Pbar: "#bar-" + para.uniqueDiv,
                PbarPercent: "#percent-" + para.uniqueDiv,
                PbarStatus: "#status-" + para.uniqueDiv
            },
            CameraDiv: {MenuTab: "#capture-pills-" + para.uniqueDiv,
                ParentDiv: "#capture_photo-" + para.uniqueDiv,
                FormID: "#capturephoto-" + para.uniqueDiv,
                FormURL: para.CameraURL,
                TableCapturePhoto: "#table_capture_photo-" + para.uniqueDiv,
                CatpureLayout: "#catpure_layout-" + para.uniqueDiv,
                TakeSnapshot: "#take-snapshot-" + para.uniqueDiv,
                WebcamConfigure: "#webcam-configure-" + para.uniqueDiv,
                ProgressBar: "#upload_results-" + para.uniqueDiv
            },
            CropDiv: {ParentDiv: "#crop_photo-" + para.uniqueDiv,
                JCropIMG: "#cropbox-" + para.uniqueDiv,
                JCropIMGW: 400,
                JCropIMGH: 400,
                PreviewIMG: "#preview-" + para.uniqueDiv,
                PreviewParent: "#preview_parent-" + para.uniqueDiv,
                PreviewIMGW: 100,
                PreviewIMGH: 100,
                FormID: "#cropphoto-" + para.uniqueDiv,
                FormURL: para.CropURL,
                Left: "#x-" + para.uniqueDiv,
                Top: "#y-" + para.uniqueDiv,
                Right: "#x2-" + para.uniqueDiv,
                Bottom: "#y2-" + para.uniqueDiv,
                Width: "#w-" + para.uniqueDiv,
                Height: "#h-" + para.uniqueDiv,
                JcropHolder: ".jcrop-holder",
                JcropTracker: ".jcrop-tracker",
                RotatePic: "#rotatephoto-" + para.uniqueDiv,
                CropDone: "#checkcoords-" + para.uniqueDiv,
                Done: "#doneupload-" + para.uniqueDiv
            }
        };
        // UploadIds.ParentDiv = para.ParentDiv;
        // UploadIds.HardDiskDiv.FormURL = para.HardDiskURL;
        // UploadIds.CameraDiv.FormURL = para.CameraURL;
        // UploadIds.CropDiv.FormURL = para.CropURL;
        IntializeJSON();
    };
    /* Members methods */
    function IntializeJSON() {
        $(UploadIds.PageLoader).html(UploadIds.LoaderIMG);
        $.ajax({
            url: window.location.href,
            type: 'POST',
            data: {autoloader: true, action: 'IntializeJSON', HowMany: HowMany},
            success: function (data, textStatus, xhr) {
                console.log(xhr.status);
                switch (data, textStatus, xhr) {
                    case 'logout':
                        logoutAdmin({});
                        break;
                    case 'login':
                        loginAdmin({});
                        break;
                    default:
                        $(UploadIds.PageLoader).fadeOut(300);
                        JsonID = $.parseJSON(data);
                        var name = "";
                        var id = "";
                        switch (HowMany) {
                            case "Individual":
                                if (JsonID.name.match(name_reg) && JsonID.id.match(num_reg)) {
                                    name = JsonID.name;
                                    id = JsonID.id;
                                }
                                break;
                            case "Group":
                                if (JsonID.name[0].match(name_reg) && JsonID.id[0].match(num_reg)) {
                                    name = JsonID.name[0];
                                    id = JsonID.id[0];
                                    JsonID.name.shift();
                                    JsonID.id.shift();
                                }
                                break;
                        }
                        InstallHTML(id, name);
                        break;
                }
            },
            error: function () {
                $(outputDiv).html(INET_ERROR);
            },
            complete: function (xhr, textStatus) {
                console.log(xhr.status);
            }
        });
    }
    ;
    function InstallHTML(id, name) {
        $(UploadIds.PageLoader).show(300);
        $.ajax({
            url: window.location.href,
            type: 'POST',
            async: false,
            data: {autoloader: true,
                action: 'InstallHTML',
                UploadIds: UploadIds,
                id: id,
                name: name},
            success: function (data, textStatus, xhr) {
                data = $.trim(data);
                switch (data) {
                    case 'logout':
                        logoutAdmin({});
                        break;
                    case 'login':
                        loginAdmin({});
                        break;
                    default:
                        $(UploadIds.PageLoader).fadeOut(300);
                        $(UploadIds.ParentDiv).html(data);
                        window.setTimeout(function () {
                            $(UploadIds.ParentMenuDiv.HardDiskLink).on("click", function () {
                                ConfigureHardDisk();
                            });
                            $(UploadIds.ParentMenuDiv.CameraLink).on("click", function () {
                                ConfigureCamera();
                            });
                            ConfigureHardDisk();
                            ConfigureCamera();
                            $(UploadIds.TabLoader).each(function () {
                                $(UploadIds.TabLoader).hide().html(UploadIds.LoaderIMG);
                            });
                            $(UploadIds.ParentDiv).show(300);
                            $(UploadIds.HardDiskDiv.ParentDiv).show(500);
                        }, 400);
                        break;
                }
            },
            error: function () {
                $(outputDiv).html(INET_ERROR);
            },
            complete: function (xhr, textStatus) {
                console.log(xhr.status);
            }
        });
    }
    ;
    function ConfigureHardDisk() {
        $(UploadIds.CameraDiv.ParentDiv).hide();
        $(UploadIds.CropDiv.ParentDiv).hide();
        var bar = $(UploadIds.HardDiskDiv.Pbar);
        var percent = $(UploadIds.HardDiskDiv.PbarPercent);
        var status = $(UploadIds.HardDiskDiv.PbarStatus);
        $(UploadIds.HardDiskDiv.FormID).attr("action", UploadIds.HardDiskDiv.FormURL);
        $(UploadIds.HardDiskDiv.FormID).ajaxForm({
            beforeSend: function () {
                status.empty();
                var percentVal = '0%';
                bar.width(percentVal)
                percent.html(percentVal);
                if ($(UploadIds.HardDiskDiv.BrowseButton).val().length == 0)
                    return;
            },
            uploadProgress: function (event, position, total, percentComplete) {
                var percentVal = percentComplete + '%';
                bar.width(percentVal)
                percent.html(percentVal);
            },
            success: function (data) {
                if (data == 'logout')
                    window.location.href = URL;
                else {
                    window.setTimeout(function () {
                        var percentVal = '100%';
                        bar.width(percentVal);
                        percent.html(percentVal);
                        /* Load the crop plug in */
                        CropPicture(data);
                    }, 500);
                }
            },
            complete: function (xhr) {
                var percentVal = '0%';
                if (xhr.responseText.length == 0) {
                    bar.width(percentVal);
                    percent.html(percentVal);
                }
                // status.html(xhr.responseText);
            }
        });
        $(UploadIds.HardDiskDiv.ParentDiv).show(500);
    }
    ;
    function ConfigureCamera() {
        $(UploadIds.HardDiskDiv.ParentDiv).hide();
        $(UploadIds.CropDiv.ParentDiv).hide();
        $(UploadIds.CameraDiv.WebcamConfigure).bind("click", function () {
            webcam.configure();
        });
        $(UploadIds.CameraDiv.TakeSnapshot).bind("click", function () {
            TakeSnapShot();
        });
        $(UploadIds.CameraDiv.ParentDiv).show(500);
    }
    ;
    function TakeSnapShot() {
        $(UploadIds.CameraDiv.ProgressBar).html('<h3>Uploading...</h3>');
        webcam.set_swf_url(URL + ASSET_JSF + 'jpegcam/webcam.swf');
        webcam.set_api_url(UploadIds.CameraDiv.FormURL);
        webcam.set_quality(90);
        webcam.set_shutter_sound(true, URL + ASSET_JSF + 'jpegcam/shutter.mp3');
        webcam.set_stealth(false);
        $(UploadIds.CameraDiv.CatpureLayout).html(webcam.get_html(320, 240, 640, 480));
        webcam.set_hook('onComplete', 'CompleteSnapShot', false);
        webcam.snap(UploadIds.CameraDiv.FormURL, 'CompleteSnapShot', false);
    }
    ;
    function CompleteSnapShot() {
        /* extract URL out of PHP output */
        if (msg == 'logout')
            window.location.href = URL;
        else if (msg.length > 0) {
            $(UploadIds.CameraDiv.ProgressBar).html('Done');
            /* reset camera for another shot */
            webcam.reset();
            /* Load the crop plug in */
            window.setTimeout(function () {
                CropPicture(msg);
            }, 500);
        }
        else
            alert("PHP Error: " + msg);
    }
    ;
    function CropPicture(imgurl) {
        $(UploadIds.CameraDiv.ParentDiv).hide();
        $(UploadIds.HardDiskDiv.ParentDiv).hide();
        $(UploadIds.CropDiv.PreviewIMG).attr("src", imgurl);
        $(UploadIds.CropDiv.PreviewParent).css({
            width: UploadIds.CropDiv.PreviewIMGW,
            height: UploadIds.CropDiv.PreviewIMGH,
            overflow: "hidden",
            marginLeft: "5",
            transform: "rotate(0deg)"
        });
        $(UploadIds.CropDiv.JCropIMG).attr("src", imgurl).attr("width", UploadIds.CropDiv.JCropIMGW).attr("height", UploadIds.CropDiv.JCropIMGH).attr('style', 'transform: rotate(0deg);position:absolute;').Jcrop({aspectRatio: 1, onChange: showPreview, onSelect: showPreview, onSelect: updateCoords});
        window.setTimeout(function () {
            $(UploadIds.CropDiv.JcropHolder).find('img').each(function () {
                $(this).attr("src", $(UploadIds.CropDiv.JCropIMG).attr("src"));
            });
            $(UploadIds.CropDiv.JcropTracker).find('img').each(function () {
                $(this).attr("src", $(UploadIds.CropDiv.JCropIMG).attr("src"));
            });
        }, 100);
        $(UploadIds.CameraDiv.ProgressBar).hide();
        $(UploadIds.CropDiv.RotatePic).on("click", function () {
            rotatePhoto();
        });
        $(UploadIds.CropDiv.CropDone).on("click", function () {
            UploadPicture();
        });
        $(UploadIds.CropDiv.Done).on("click", function () {
            UploadPicture();
        });
        $(UploadIds.CropDiv.ParentDiv).show(500);
    }
    ;
    function updateCoords(c) {
        $(UploadIds.CropDiv.Left).val(c.x);
        $(UploadIds.CropDiv.Top).val(c.y);
        $(UploadIds.CropDiv.Right).val(c.x2);
        $(UploadIds.CropDiv.Bottom).val(c.y2);
        $(UploadIds.CropDiv.Width).val(c.w);
        $(UploadIds.CropDiv.Height).val(c.h);
        $(UploadIds.CropDiv.CropDone).show();
        $(UploadIds.CropDiv.Done).hide();
    }
    ;
    function showPreview(coords) {
        var rx = 100 / coords.w;
        var ry = 100 / coords.h;
        $(UploadIds.CropDiv.PreviewIMG).css({
            width: Math.round(rx * 500) + 'px',
            height: Math.round(ry * 370) + 'px',
            marginLeft: '-' + Math.round(rx * coords.x) + 'px',
            marginTop: '-' + Math.round(ry * coords.y) + 'px'
        });
        $(UploadIds.CropDiv.JcropHolder, UploadIds.CropDiv.JcropTracker).find('img').each(function () {
            if ($(this).attr("src") != $(UploadIds.CropDiv.JCropIMG).attr("src")) {
                $(this).attr("src", $(UploadIds.CropDiv.JCropIMG).attr("src"));
            }
        });
    }
    ;
    function showCoords(c) {
        $(UploadIds.CropDiv.Left).val(c.x);
        $(UploadIds.CropDiv.Top).val(c.y);
        $(UploadIds.CropDiv.Right).val(c.x2);
        $(UploadIds.CropDiv.Bottom).val(c.y2);
        $(UploadIds.CropDiv.Width).val(c.w);
        $(UploadIds.CropDiv.Height).val(c.h);
    }
    ;
    function UploadPicture() {
        var fields = {};
        if ($('#x').val() > 0 && $('#y').val() > 0 && $('#x2').val() > 0 && $('#y2').val() > 0) {
            fields = {crop: 'yes',
                left: $(UploadIds.CropDiv.Left).val(),
                top: $(UploadIds.CropDiv.Top).val(),
                right: $(UploadIds.CropDiv.Right).val(),
                bottom: $(UploadIds.CropDiv.Bottom).val(),
                width: $(UploadIds.CropDiv.Width).val(),
                height: $(UploadIds.CropDiv.Height).val()
            };
        }
        else {
            fields = {crop: 'no', left: 10, top: 10, right: 10, bottom: 10, width: 0, height: 0};
        }
        $.ajax({
            url: UploadIds.HardDiskDiv.FormURL,
            type: 'POST',
            data: fields,
            success: function (data, textStatus, xhr) {
                console.log(xhr.status);
                switch (data) {
                    case 'logout':
                        logoutAdmin({});
                        break;
                    case 'login':
                        loginAdmin({});
                        break;
                    default:
                        var flag = true;
                        var name = "";
                        var id = "";
                        switch (HowMany) {
                            case "Individual":
                                /* do nothing */
                                break;
                            case "Group":
                                if (JsonID.name[0].match(name_reg) && JsonID.id[0].match(num_reg)) {
                                    name = JsonID.name[0];
                                    id = JsonID.id[0];
                                    JsonID.name.shift();
                                    JsonID.id.shift();
                                    flag = false;
                                    InstallHTML(id, name);
                                }
                                break;
                        }
                        if (flag) {
                            $(UploadIds.CropDiv.ParentDiv).hide(200);
                            $(UploadIds.CameraDiv.ParentDiv).html('<div class="col-lg-12"><img src="' + data + '" border="0" width="150" height="150" /><div>');
                            $(UploadIds.HardDiskDiv.ParentDiv).html('<div class="col-lg-12"><img src="' + data + '" border="0" width="150" height="150" /><div>');
                            $(UploadIds.CameraDiv.ParentDiv).show(100);
                            $(UploadIds.HardDiskDiv.ParentDiv).show(200);
                            $(UploadIds.ParentMenuDiv.HardDiskLink).unbind("click");
                            $(UploadIds.ParentMenuDiv.CameraLink).unbind("click");
                        }
                        break;
                }
            },
            error: function () {
                $(outputDiv).html(INET_ERROR);
            },
            complete: function (xhr, textStatus) {
                console.log(xhr.status);
            }
        });
        setTimeout(function () {
            HideAjaxCall();
        }, 500);
    }
    ;
    function HideAjaxCall() {
        $.ajax({
            url: URL + 'Admin/user/upload_user_photo.php',
            type: 'POST',
            data: {crop: 'no', left: 0, top: 0, right: 0, bottom: 0},
            success: function (data) {
                console.log(xhr.status);
                switch (data) {
                    case 'logout':
                        logoutAdmin({});
                        break;
                    case 'login':
                        loginAdmin({});
                        break;
                    default:
                        $(UploadIds.CropDiv.JCropIMG).attr('src', data);
                        break;
                }
            },
            error: function () {
                $(outputDiv).html(INET_ERROR);
            },
            complete: function (xhr, textStatus) {
                console.log(xhr.status);
            }
        });
    }
    ;
    function rotatePhoto() {
        $.ajax({
            url: UploadIds.HardDiskDiv.FormURL,
            type: 'POST',
            data: {crop: 'no', left: 0, top: 0, right: 0, bottom: 0, rotate: 'yes'},
            success: function (data, textStatus, xhr) {
                console.log(xhr.status);
                switch (data) {
                    case 'logout':
                        logoutAdmin({});
                        break;
                    case 'login':
                        loginAdmin({});
                        break;
                    default:
                        window.setTimeout(function () {
                            $(UploadIds.CropDiv.JcropHolder).find('img').each(function () {
                                $(this).rotate(-parseInt(data));
                            });
                            $(UploadIds.CropDiv.JcropTracker).find('img').each(function () {
                                $(this).rotate(-parseInt(data));
                            });
                        }, 100);
                        $(UploadIds.CropDiv.JcropHolder, UploadIds.CropDiv.JcropTracker).find('img').each(function () {
                            $(this).rotate(-parseInt(data));
                            $(UploadIds.CropDiv.JCropIMG).rotate(-parseInt(data));
                        });
                        $(UploadIds.CropDiv.PreviewIMG).rotate(-parseInt(data));
                        break;
                }
            },
            error: function () {
                $(outputDiv).html(INET_ERROR);
            },
            complete: function (xhr, textStatus) {
                console.log(xhr.status);
            }
        });
    }
}