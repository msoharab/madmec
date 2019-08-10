function controlManageThr() {
    var mgthr = {};
    var v1 = null;
    var v2 = null;
    var id = $(DGYM_ID).attr("name");
    this.__construct = function (manage) {
        mgthr = manage;
        initializefacility();
        initializeduration();
        $(mgthr.of_fact).on('change', function () {
            v1 = $(mgthr.of_fact + ' :selected').val();
        });
        $(mgthr.of_duration).on('change', function () {
            v2 = $(mgthr.of_duration + ' :selected').val();
            if (v2 != 'null') {
                var temp = $(mgthr.of_duration + ' :selected').text();
                $(mgthr.of_day).val(temp.split("-")[1]);
            }
        });
        $(mgthr.offerADbtn).click(function (evt) {
            evt.preventDefault();
            var attr = validateOfferFiels();
            if (attr) {
                $.ajax({
                    url: window.location.href,
                    type: 'POST',
                    data: {
                        autoloader: 'true',
                        action: 'addnewoffer',
                        id: id,
                        type: 'slave',
                        gymid: id,
                        ofdata: attr
                    },
                    success: function (data) {
                        if (data == 'logout')
                            window.location.href = URL;
                        else {
                            $("#myModal_paybody").html("Offer Successfully Added ");
                            $("#myModal_paybtn").click();
                            $(mgthr.form).get(0).reset();
                        }
                    },
                    error: function () {
                        $(OUTPUT).html(INET_ERROR);
                    },
                    complete: function (xhr, textStatus) {
                        /*console.log(xhr.status);*/
                    }
                });
                $(loader).hide();
            }
        });
    };
    function initializeduration() {
        var dur = ($('#of_eduration :Selected').val());
        $.ajax({
            url: window.location.href,
            type: 'POST',
            data: {
                autoloader: 'true',
                action: 'getallduration',
                id: id,
                type: 'slave',
                gymid: id,
                dura: dur
            },
            success: function (data) {
                if (data == 'logout')
                    window.location.href = URL;
                else {
                    $(mgthr.of_duration).html(data);
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
    function initializefacility() {
        $.ajax({
            url: window.location.href,
            type: 'POST',
            data: {
                autoloader: 'true',
                action: 'getallfact',
                id: id,
                type: 'slave',
                gymid: id
            },
            success: function (data) {
                if (data == 'logout')
                    window.location.href = URL;
                else {
                    $(mgthr.of_fact).html(data);
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
    function validateOfferFiels() {
        var flag = false;
        var num_reg = /^[0-9]{1,3}$/;
        var of_num = $(mgthr.of_day).val();
        var price_reg = /^[1-9][0-9]{1,}$/;
        var no_reg = /^[1-9][0-9]*$/;
        var of_prize = $(mgthr.of_price).val();
        /* name */
        if ($(mgthr.of_name).val().match(nm_reg)) {
            flag = true;
            $(mgthr.valid_nm).html(VALIDNOT);
        } else {
            flag = false;
            $(mgthr.valid_nm).html(INVALIDNOT);
            $('html, body').animate({
                scrollTop: Number($(mgthr.valid_nm).offset().top) - 55
            }, "slow");
            $(mgthr.of_name).focus();
            return;
        }
        /* duartion */
        if (v2 != null) {
            flag = true;
            $(mgthr.valid_duration).html(VALIDNOT);
        } else {
            flag = false;
            $(mgthr.valid_duration).html(INVALIDNOT);
            $('html, body').animate({
                scrollTop: Number($(mgthr.valid_duration).offset().top) - 55
            }, "slow");
            $(mgthr.of_duration).focus();
            return;
        }
        /* no of days */
        if ($(mgthr.of_day).val().match(no_reg)) {
            flag = true;
            $(mgthr.valid_num).html(VALIDNOT);
        } else {
            flag = false;
            $(mgthr.valid_num).html(INVALIDNOT);
            $('html, body').animate({
                scrollTop: Number($(mgthr.valid_num).offset().top) - 55
            }, "slow");
            $(mgthr.of_day).focus();
            return;
        }
        /* facility type */
        if (v1 != null) {
            flag = true;
            $(mgthr.valid_fact).html(VALIDNOT);
        } else {
            flag = false;
            $(mgthr.valid_fact).html(INVALIDNOT);
            $('html, body').animate({
                scrollTop: Number($(mgthr.valid_fact).offset().top) - 55
            }, "slow");
            $(mgthr.of_fact).focus();
            return;
        }
        /* prizing */
        if ($(mgthr.of_price).val().match(price_reg)) {
            flag = true;
            $(mgthr.valid_price).html(VALIDNOT);
        } else {
            flag = false;
            $(mgthr.valid_price).html(INVALIDNOT);
            $('html, body').animate({
                scrollTop: Number($(mgthr.valid_price).offset().top) - 55
            }, "slow");
            $(mgthr.of_price).focus();
            return;
        }
        var attr = {
            name: $(mgthr.of_name).val(),
            duration: v2,
            days: $(mgthr.of_day).val(),
            facility: v1,
            prizing: $(mgthr.of_price).val(),
            member: $(mgthr.of_mem).val(),
            description: $(mgthr.of_desc).val(),
        };
        return attr;
    }
    ;
}
;
