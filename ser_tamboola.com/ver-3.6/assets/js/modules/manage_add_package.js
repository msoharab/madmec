function controlManageSvn() {
    var mgsvn = {};
    var v2 = null;
    var gymid = $(DGYM_ID).attr("name");
    this.__construct = function (pack) {
        mgsvn = pack;
        initializepack_type();
        $(mgsvn.pack_type).on('change', function () {
            v2 = $(mgsvn.pack_type + ' :selected').val();
        });
        $(mgsvn.packsaveBtn).bind('click', function () {
            $("#package_msg").hide();
            var att = validpackagedata();
            if (att) {
                $.ajax({
                    url: window.location.href,
                    type: 'POST',
                    data: {
                        autoloader: 'true',
                        action: 'addPackage',
                        id: gymid,
                        type: 'slave',
                        gymid: gymid,
                        pack_type: v2,
                        numof: att.nfs,
                        prize: att.prize
                    },
                    success: function (data) {
                        data = $.trim(data);
                        if (data == 'logout')
                            window.location.href = URL;
                        else if (data === 'success') {
                            $("#package_msg").show();
                            $("#package_msg").html('<h3 class="text-danger">Package Added</h3>');
                            $(mgsvn.form).get(0).reset();
                            v2 = null;
                        }
                        if (data === 'duplicate') {
                            $("#package_msg").show();
                            $("#package_msg").html('<h3 class="text-danger">Package Already exists</h3>');
                        }
                    },
                    error: function () {
                        $(OUTPUT).html(INET_ERROR);
                    },
                    complete: function (xhr, textStatus) {
                        /*console.log(xhr.status);*/
                    }
                });
            }
        });
    }
    function validpackagedata() {
        $("#package_msg").hide();
        var flag = false;
        var price_reg = /^[0-9]{1,}$/;
        if (v2 != null) {
            flag = true;
            $(mgsvn.typemsg).html(VALIDNOT);
        } else {
            flag = false;
            $(mgsvn.typemsg).html('<strong class="text-danger">Select Package Type.</strong>');
            $('html, body').animate({
                scrollTop: Number($(mgsvn.typemsg).offset().top) - 55
            }, "slow");
            $(mgsvn.typemsg).focus();
            return;
        }
        /*number of session type*/
        if ($(mgsvn.numofsession).val().match(price_reg) && $(mgsvn.numofsession).val() > 0) {
            flag = true;
            $(mgsvn.nfsmsg).html(VALIDNOT);
        } else {
            flag = false;
            $(mgsvn.nfsmsg).html(INVALIDNOT);
            $('html, body').animate({
                scrollTop: Number($(mgsvn.nfsmsg).offset().top) - 55
            }, "slow");
            return;
        }
        /* prize  */
        if ($(mgsvn.prize).val().match(price_reg)) {
            flag = true;
            $(mgsvn.prizemsg).html(VALIDNOT);
        } else {
            flag = false;
            $(mgsvn.prizemsg).html(INVALIDNOT);
            $('html, body').animate({
                scrollTop: Number($(mgsvn.prizemsg).offset().top) - 55
            }, "slow");
            $(mgsvn.prizemsg).focus();
            return;
        }
        var attr = {
            type: v2,
            nfs: $(mgsvn.numofsession).val(),
            prize: $(mgsvn.prize).val(),
        };
        if (flag) {
            return attr;
        } else
            return false;
    }
    function initializepack_type() {
        $.ajax({
            url: window.location.href,
            type: 'POST',
            data: {
                autoloader: 'true',
                action: 'showpack_type',
                id: gymid,
                type: 'slave',
                gymid: gymid
            },
            success: function (data) {
                if (data == 'logout')
                    window.location.href = URL;
                else {
                    $(mgsvn.pack_type).html(data);
                }
            },
            error: function () {
                $(OUTPUT).html(INET_ERROR);
            },
            complete: function (xhr, textStatus) {
                /*console.log(xhr.status);*/
            }
        });
    }
}
;
