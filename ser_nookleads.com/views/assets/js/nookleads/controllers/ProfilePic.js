function profilePicController() {
    var members = {};
    var picEditObj = {};
    this.__constructor = function (para) {
        members = para;
        $('#' + members.parentBut).bind('click', function (evt) {
            validateProfilePicForm();
            window.setTimeout(function () {
                picEditObj = $('#' + members.leadImg).picEdit({
                    imageUpdated: function (_this) {
                        //console.log(_this);
                        //picEditObj._setDefaultImage(img.src);
                        //throw new Error('Stop Damn Recursion');
                        //return false;
                    },
                    formError: function (res) {
                        members.picedit = false;
                    },
                    /* Soharab Modification */
                    formProgress: function (data) {
                        $('#' + members.create).prop('disabled', 'disabled');
                        var res = {};
                        if (typeof data === 'object') {
                            res = data;
                        } else {
                            res = $.parseJSON($.trim(data));
                        }
                        //console.log(res);
                    },
                    /* Soharab Modification */
                    formSubmitted: function (data) {
                        $('#' + members.create).removeAttr('disabled');
                        var res = {};
                        if (typeof data === 'object') {
                            res = data;
                        } else {
                            res = $.parseJSON($.trim(data));
                        }
                        if (res.readyState && picEditObj._formComplete()) {
                            updateProfilePic();
                            members.picedit = false;
                        } else {
                            alert('Error could not update profile picture !!!.');
                        }
                    },
                    FormObj: $('#' + members.form),
                    goFlag: true,
                    picEditUpload: false,
                    redirectUrl: false,
                    defaultImage: members.defaultImage
                });
                $('#' + members.leadImg).parent().css({
                    paddingLeft: '15%',
                    paddingRight: '15%',
                    backgroundColor: '#C0C0C0',
                });
            }, 500);
            window.setTimeout(function () {
                picEditObj._setDefaultValues();
            }, 1500);
            $('#' + members.leadImg).change(function(){
                members.picedit = true;
            });
        });
    };
    function updateProfilePic() {
        var mem = members;
        var res = {};
        if (mem.picedit) {
            $('#' + mem.create).prop('disabled', 'disabled');
            $.ajax({
                url: mem.url,
                type: mem.type,
                dataType: mem.dataType,
                async: false,
                data: {
                    autoloader: mem.autoloader,
                    action: mem.action,
                },
                success: function (data, textStatus, xhr) {
                    if (typeof data === 'object') {
                        res = data;
                    } else {
                        res = $.parseJSON($.trim(data));
                    }
                    if (res.status === "success") {
                        $('#' + mem.form).get(0).reset();
                        $('#' + mem.close).trigger('click');
                        alert("Your profile image successfully updated.");
                        window.location.href = window.location.href;
                        mem.picedit = false;
                        mem.ajaxForm = false;
                    }
                },
                error: function (xhr, textStatus) {
                },
                complete: function (xhr, textStatus) {
                    $('#' + mem.create).removeAttr('disabled');
                }
            });
        }
    }
    ;
    function validateProfilePicForm() {
        var memadd = members;
        var $params = {
            debug: true,
            rules: {},
            messages: {}
        };
        var form = $('#' + memadd.form);
        form.on('keyup', function (e) {
            var code = Number(e.keyCode || e.which);
            if (code === 13) {
                e.preventDefault();
                return false;
            }
        });
        var field = $('#' + memadd.leadImg).attr("name");
        $params['rules'][field] = {
            required: true,
            accept: nookleads.imgTypes
        };
        $params['messages'][field] = {
            required: 'Select Image',
            minlength: 'Select JPEG OR PNG image'
        };
        $params['submitHandler'] = function () {
            memadd.ajaxForm = true;
            picEditObj._setGoFlag(memadd.ajaxForm);
            if (memadd.ajaxForm && memadd.picedit) {
                picEditObj.formSubmit();
            }
            else {
                alert('Upload picture or fill in the blanks!!!');
            }
        };
        $params['invalidHandler'] = function () {
            //console.log('I am in errorHandler');
            memadd.ajaxForm = false;
            picEditObj._setGoFlag(memadd.ajaxForm);
        };
        $(form).validate($params);
    }
    ;
}
