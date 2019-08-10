function profile() {
    var members = {};
    var picEditObj = {};

    this.__constructor = function (para) {
        members = para;
        changePassword();
        changeEmail();
        changeCell();
        changePic();
    };
    function changePassword() {
        var mem = members.ChangePassword;
        var fields = members.ChangePassword.fields;
        var params = {debug: false, rules: {}, messages: {}};
        var form = $('#' + mem.form);
        var checkusr = 0;
        form.on('keyup', function (e) {
            var code = Number(e.keyCode || e.which);
            if (code === 13) {
                e.preventDefault();
                return false;
            }
        });
        for (i = 0; i < fields.length; i++) {
            var field = $('#' + fields[i]).attr("name");
            var rules = $('#' + field).attr("data-rules");
            var messages = $('#' + field).attr("data-messages");
            if (rules.length > 0 && messages.length > 0) {
                rules = $.parseJSON(rules);
                messages = $.parseJSON(messages);
                params['rules'][field] = rules;
                params['messages'][field] = messages;
            }
        }
        params['submitHandler'] = function () {
            checkusr = 1;
        }
        ;
        params['invalidHandler'] = function () {
            checkusr = 0;
            alert('Please correct the credentials..');
        };
        $(form).validate(params);
        $(form).submit(function (e) {
            if (checkusr) {
                var frmdata = new FormData();
                frmdata.append("oldpass", $('#' + fields[0]).val());
                frmdata.append("newpass", $('#' + fields[1]).val());
                frmdata.append("confrmpass", $('#' + fields[2]).val());
                AddDB({jsonattr: mem, attr: frmdata});
            }
            else {
                alert('Please correct the credentials..');
            }
        });
    }
    ;
    function changeEmail() {
        var mem = members.ChangeEmail;
        var fields = members.ChangeEmail.fields;
        var params = {debug: false, rules: {}, messages: {}};
        var form = $('#' + mem.form);
        var checkusr = 0;
        form.on('keyup', function (e) {
            var code = Number(e.keyCode || e.which);
            if (code === 13) {
                e.preventDefault();
                return false;
            }
        });
        for (i = 0; i < fields.length; i++) {
            var field = $('#' + fields[i]).attr("name");
            var rules = $('#' + field).attr("data-rules");
            var messages = $('#' + field).attr("data-messages");
            if (rules.length > 0 && messages.length > 0) {
                rules = $.parseJSON(rules);
                messages = $.parseJSON(messages);
                params['rules'][field] = rules;
                params['messages'][field] = messages;
            }
        }
        var reqClone = new Array();
        $('#' + mem.cloneplusbut[0]).click(function () {
            var $div = $('div[id^="' + mem.clone[0] + '"]:last');
            var num = parseInt($div.prop("id").match(/\d+/g), 10) + 1;
            var $klon = $div.clone().prop('id', mem.clone[0] + num).insertAfter('div[id^="' + mem.clone[0] + '"]:last');
            window.setTimeout(function () {
                for (i = 0; i < mem.reqparam.length; i++) {
                    $div.find('input.' + mem.reqparam[i]).prop('id', mem.reqparam[i] + num);
                    $div.find('input.' + mem.reqparam[i]).prop('name', mem.reqparam[i] + num);
                }
            }, 500);
            reqClone.push($klon);
            // $(form).validate(params);
        });
        $('#' + mem.cloneminusbut[0]).click(function () {
            var $div = $('div[id^="' + mem.clone[0] + '"]:last');
            var num = parseInt($div.prop("id").match(/\d+/g), 10);
            if (num != 0) {
                $div.remove();
                reqClone.pop();
            }
        });
        var respClone = new Array();
        $('#' + mem.cloneplusbut[1]).click(function () {
            var $div = $('div[id^="' + mem.clone[1] + '"]:last');
            var num = parseInt($div.prop("id").match(/\d+/g), 10) + 1;
            var $klon = $div.clone().prop('id', mem.clone[1] + num).insertAfter('div[id^="' + mem.clone[1] + '"]:last');
            window.setTimeout(function () {
                for (i = 0; i < mem.resparam.length; i++) {
                    $div.find('input.' + mem.resparam[i]).prop('id', mem.resparam[i] + num);
                    $div.find('input.' + mem.resparam[i]).prop('name', mem.resparam[i] + num);
                }
            }, 500);
            respClone.push($klon);
        });
        $('#' + mem.cloneminusbut[1]).click(function () {
            var $div = $('div[id^="' + mem.clone[1] + '"]:last');
            var num = parseInt($div.prop("id").match(/\d+/g), 10);
            if (num != 0) {
                $div.remove();
                respClone.pop();
            }
        });
        params['submitHandler'] = function () {
            checkusr = 1;
        }
        ;
        params['invalidHandler'] = function () {
            checkusr = 0;
        };
        $(form).validate(params);
        $(form).submit(function (e) {
            var reqparam = mem.reqparam;
            var reqparam1 = new Array();
            $('.' + reqparam[0]).each(function () {
                reqparam1.push($(this).val());
            });
            if (checkusr) {
                var frmdata = new FormData();
                frmdata.append("emails", JSON.stringify({mail: reqparam1}));
                AddDB({jsonattr: mem, attr: frmdata});
            }
            else {
                alert('Please correct the credentials..');
            }
        });
    }
    ;
    function changeCell() {
        var mem = members.ChangeCell;
        var fields = members.ChangeCell.fields;
        var params = {debug: false, rules: {}, messages: {}};
        var form = $('#' + mem.form);
        var checkusr = 0;
        form.on('keyup', function (e) {
            var code = Number(e.keyCode || e.which);
            if (code === 13) {
                e.preventDefault();
                return false;
            }
        });
        for (i = 0; i < fields.length; i++) {
            var field = $('#' + fields[i]).attr("name");
            var rules = $('#' + field).attr("data-rules");
            var messages = $('#' + field).attr("data-messages");
            if (rules.length > 0 && messages.length > 0) {
                rules = $.parseJSON(rules);
                messages = $.parseJSON(messages);
                params['rules'][field] = rules;
                params['messages'][field] = messages;
            }
        }
        var reqClone = new Array();
        $('#' + mem.cloneplusbut[0]).click(function () {
            var $div = $('div[id^="' + mem.clone[0] + '"]:last');
            var num = parseInt($div.prop("id").match(/\d+/g), 10) + 1;
            var $klon = $div.clone().prop('id', mem.clone[0] + num).insertAfter('div[id^="' + mem.clone[0] + '"]:last');
            window.setTimeout(function () {
                for (i = 0; i < mem.reqparam.length; i++) {
                    $div.find('input.' + mem.reqparam[i]).prop('id', mem.reqparam[i] + num);
                    $div.find('input.' + mem.reqparam[i]).prop('name', mem.reqparam[i] + num);
                }
            }, 500);
            reqClone.push($klon);
            // $(form).validate(params);
        });
        $('#' + mem.cloneminusbut[0]).click(function () {
            var $div = $('div[id^="' + mem.clone[0] + '"]:last');
            var num = parseInt($div.prop("id").match(/\d+/g), 10);
            if (num != 0) {
                $div.remove();
                reqClone.pop();
            }
        });
        var respClone = new Array();
        $('#' + mem.cloneplusbut[1]).click(function () {
            var $div = $('div[id^="' + mem.clone[1] + '"]:last');
            var num = parseInt($div.prop("id").match(/\d+/g), 10) + 1;
            var $klon = $div.clone().prop('id', mem.clone[1] + num).insertAfter('div[id^="' + mem.clone[1] + '"]:last');
            window.setTimeout(function () {
                for (i = 0; i < mem.resparam.length; i++) {
                    $div.find('input.' + mem.resparam[i]).prop('id', mem.resparam[i] + num);
                    $div.find('input.' + mem.resparam[i]).prop('name', mem.resparam[i] + num);
                }
            }, 500);
            respClone.push($klon);
        });
        $('#' + mem.cloneminusbut[1]).click(function () {
            var $div = $('div[id^="' + mem.clone[1] + '"]:last');
            var num = parseInt($div.prop("id").match(/\d+/g), 10);
            if (num != 0) {
                $div.remove();
                respClone.pop();
            }
        });
        params['submitHandler'] = function () {
            checkusr = 1;
        }
        ;
        params['invalidHandler'] = function () {
            checkusr = 0;
        };
        $(form).validate(params);
        $(form).submit(function (e) {
            var respparam = mem.resparam;
            var respparam1 = new Array();
            var respparam2 = new Array();
            $('.' + respparam[0]).each(function () {
                respparam1.push($(this).val());
            });
            $('.' + respparam[1]).each(function () {
                respparam2.push($(this).val());
            });
            if (checkusr) {
                var frmdata = new FormData();
                frmdata.append("cellnumner", JSON.stringify({cod: respparam1, num: respparam2}));
                AddDB({jsonattr: mem, attr: frmdata});
            }
            else {
                alert('Please correct the credentials..');
            }
        });
    }
    ;
    function changePic() {
        var mem = members.ChangePic;
        var fields = members.ChangePic.fields;
        var params = {debug: false, rules: {}, messages: {}};
        var form = $('#' + mem.form);
        var checkusr = 0;
        form.on('keyup', function (e) {
            var code = Number(e.keyCode || e.which);
            if (code === 13) {
                e.preventDefault();
                return false;
            }
        });
        window.setTimeout(function () {
            picEditObj = $('#' + mem.inView).picEdit({
                imageUpdated: function (_this) {
                },
                formError: function (res) {
                    mem.picedit = false;
                },
                /* Soharab Modification */
                formProgress: function (data) {
                    var res = {};
                    if (typeof data === 'object') {
                        res = data;
                    } else {
                        res = $.parseJSON($.trim(data));
                    }
                    //console.log(res);
                },
                formSubmitted: false,
                FormObj: $('#' + mem.form),
                goFlag: false,
                picEditUpload: false,
                redirectUrl: false,
                defaultImage: mem.defaultImage
            });
            $('#' + mem.inView).parent().css({
                paddingLeft: '0%',
                paddingRight: '0%',
                backgroundColor: '#C0C0C0',
            });
        }, 500);
        window.setTimeout(function () {
            picEditObj._setDefaultValues();
        }, 1000);

        for (i = 0; i < fields.length; i++) {
            var field = $('#' + fields[i]).attr("name");
            var rules = $('#' + field).attr("data-rules");
            var messages = $('#' + field).attr("data-messages");
            if (rules.length > 0 && messages.length > 0) {
                rules = $.parseJSON(rules);
                messages = $.parseJSON(messages);
                params['rules'][field] = rules;
                params['messages'][field] = messages;
            }
        }
        params['submitHandler'] = function () {
            checkusr = 1;
        }
        ;
        params['invalidHandler'] = function () {
            checkusr = 0;
            alert('Please correct the credentials..');
        };
        $(form).validate(params);
        $(form).submit(function (e) {
            if (checkusr) {
                var frmdata = new FormData();
                frmdata.append("inView", $('#' + mem.inView)[0].files[0]);
                AddDB({jsonattr: mem, attr: frmdata});
            }
            else {
                alert('Please correct the credentials..');
            }
        });
    }
    ;
    function AddDB(jdata) {
        var mem = jdata.jsonattr;
        var attr = jdata.attr;
        var form = $('#' + mem.form);
        LogMessages(attr);
        var obj = {};
        $.ajax({
            url: mem.url,
            type: mem.type,
            dataType: mem.dataType,
            processData: mem.processData,
            contentType: mem.contentType,
            data: attr,
            success: function (data, textStatus, xhr) {
                LogMessages(data);
                if (typeof data === 'object') {
                    obj = data;
                }
                else {
                    obj = $.parseJSON($.trim(data));
                }
                if (obj.status === "success") {
                    alert('Changed successfully');
                    $(form).get(0).reset();
                }
                else if (obj.status === "alreadyexist") {
                    alert('Not changed, Enter diferent entries');
                    $(form).get(0).reset();
                }
                else if (obj.status === "error") {
                    alert('Wrong Entries');
                    $(form).get(0).reset();
                }
            },
            error: function () {
            },
            complete: function (xhr, textStatus) {
            }
        });
    }
    ;
}
