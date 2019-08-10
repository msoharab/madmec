/*function dis_receipts(val){
 $('#load_box').show();
 $.ajax({
 url:window.location.href,
 type:'POST',
 data:{action:'dis_receipts','val':val},
 success:function(data){
 //alert(data);
 $('#rec_screen').html(data);
 $('#load_box').hide();
 }
 });
 } */

function dis_receipts(val) {
    $('#load_box').removeClass("load_box");
    $('#rec_screen_app').remove();
    $('#load_box').show();
    $.ajax({
        url: window.location.href,
        type: 'POST',
        data: {action: 'dis_receipts', 'val': val},
        success: function (data) {
            //alert(data);
            $('#rec_screen').html(data);
            $('#load_box').hide();
            $('#rec_screen_app').hide();
        }
    });

}
function check_pre_name(name) {
    if (name.value == ('Mr.'))
        $('#sex').val('Male');
    else if (name.value == ('Mrs.') || ('Miss.')) {
        $('#sex').val('Female');
    }
    else if (name.value == ('Dr.') || ('The')) {
        $('#sex').val('Male');
    }
}

function dis_receipts_scroll(val) {
    $('#load_box').addClass("load_box");
    $('.load_box').show();
    $('<div />', {id: 'rec_screen_app', }).appendTo('#page-inner');

    $.ajax({
        url: window.location.href,
        type: 'POST',
        data: {action: 'dis_receipts_scroll'},
        success: function (data) {
            //alert(data);
            $('#rec_screen').html(data);
            $('.load_box').hide();

        }
    });
    var flag = true;
    $(window).scroll(function (event) {
        if (($(document).height() - ($(window).height() + $(window).scrollTop())) < 10) {
            if (flag) {
                flag = false;
                dis_receipts_scroll_append();
                flag = true;
            }
        }
        else
            $('#load_box').hide();

    });

}
function dis_receipts_scroll_append(val) {
    $('.load_box').show();
    $.ajax({
        url: window.location.href,
        type: 'POST',
        async: false,
        data: {action: 'dis_receipts_scroll_append', 'val': 'append'},
        success: function (data) {
            //alert(data);
            $('#rec_screen_app').append(data);
            $('.load_box').hide();

        }
    });
}


function make_receipt() {
    $("#make_receipt_btn").hide();
    var flag = true;
    var pre_name = $('#pre_name').val();
    var name = $('#name').val();
    var user_type = $('#user_type').val();
    var loc = $('#loc').val();
    var mobile = $("#mobile").val();
    var email = $("#email").val();
    var dob = $('#dob').val();
    var bloodgroup = $('#bloodgroup').val();
    var sex = $('#sex').val();
    var allergies = $('#allergies').val();
    var dis = $('#dis').val();

    //Display the email id validation
    var emailreg = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    if (email.length > 0)
        if (emailreg.test(email))
        {  //allow_email()
            $('#err_email').hide();
        } else {
            //allow_email()
            $('#err_email').show();
            flag = false;
        }


    var num = /^\d+$/;
    if (name.length > 0) {
        $('#err_name').hide();
    } else {
        $('#err_name').show();
        flag = false;
    }
    if (mobile.length < 9) {
        $('#err_mobile').show();
        flag = false;
    }
    else {
        $('#err_mobile').hide();
    }
    if (allergies.length < 2) {
        $('#err_allergies').show();
        flag = false;
    }
    else {
        $('#err_allergies').hide();
    }
    if (dis.length < 2) {
        $('#err_dis').show();
        flag = false;
    }
    else {
        $('#err_dis').hide();
    }
    if (flag) {
        var data = {
            action: 'make_receipt',
            'pre_name': pre_name,
            'name': name,
            'user_type': user_type,
            'mobile': mobile,
            'email': email,
            'loc': loc,
            'dob': dob,
            'bloodgroup': bloodgroup,
            'sex': sex,
            'allergies': allergies,
            'dis': dis
        };

        $('#load_box').show();
        $.ajax({
            url: window.location.href,
            type: 'POST',
            data: data,
            success: function (data) {
                if (data == 0)
                    $('#rec_screen').html("Error!!!");
                else
                    $('#rec_screen').html(data);
                $('#load_box').hide();
                $('input[type=file]').simpleFilePreview();
                load_tar_session();
                load_all_receipts();
            }
        });
    }
    else {
        alert("Please fill the mandatory fields");
        $("#make_receipt_btn").show();
    }
}
function upload(val, tar_id, img_id) {
    $('#' + val).html(IMG_LOADER);
    var file_data = $("#" + img_id).prop('files')[0];
    var form_data = new FormData();
    form_data.append('file', file_data);
    $.ajax({
        url: 'profile_upload.php', // point to server-side PHP script 
        dataType: 'text', // what to expect back from the PHP script, if anything
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        async: false,
        success: function (php_script_response) {
            $.ajax({
                url: window.location.href,
                type: 'POST',
                data: {action: 'upload_image', 'val': val, 'tar_id': tar_id},
                success: function (data) {
                    $('#' + val).html("<h3>Images successfully uploaded</h3>");
                }
            });
        }
    });


}
function uploadprofile(val, tar_id, img_id) {
    $('#' + val).html(IMG_LOADER);
    var file_data = $("#" + img_id).prop('files')[0];
    var form_data = new FormData();
    form_data.append('file', file_data);
    $.ajax({
        url: 'profile_upload.php', // point to server-side PHP script 
        dataType: 'text', // what to expect back from the PHP script, if anything
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        async: false,
        success: function (php_script_response) {
            $.ajax({
                url: window.location.href,
                type: 'POST',
                data: {action: 'uploadpro_image', 'val': val, 'tar_id': tar_id},
                success: function (data) {
                    $('#' + val).html("<h3>Image successfully updated</h3>");
                }
            });
        }
    });


}
function check_name_exist(name) {
    var id = 0;
    $.ajax({
        async: false,
        url: window.location.href,
        type: 'POST',
        data: {action: 'check_name_exist', 'name': name},
        success: function (data) {
            id = data;
        }
    });
    return id;
}
function auto_fill(name) {
    $('#load_box').show();
    $.ajax({
        url: window.location.href,
        type: 'POST',
        dataType: 'json',
        data: {action: 'auto_fill', 'name': name},
        success: function (data) {
            $('#load_box').hide();
            $('#user_details').show();
            $("#email").val(data["email"]);
            $("#mobile").val(data["phone"]);
            $("#loc").val(data["address"]);
            $("#err_name").html('ERROR!! User Name alreay exist try again with different name.');
            $("#err_name").show();
            setTimeout($("#name").val(data["tar_name"]), 500);

        },
        error: function (data) {
            $('#load_box').hide();
            $('#user_details').show();
        }
    });
}
function load_tar_session() {
    $.ajax({
        url: window.location.href,
        type: 'POST',
        data: {action: 'load_tar_session'},
        success: function (data) {
            //alert(data);
            //alert(data);
        }
    });
}

function load_all_receipts() {
    $.ajax({
        url: window.location.href,
        type: 'POST',
        data: {action: 'load_all_receipts'},
        success: function (data) {
            //alert(data);
        }
    });
}
function critical_action(id, val) {
    $('#load_box').removeClass("load_box");
    $('#rec_screen_app').remove();
    if (val == 'edit') {
        $('#load_box').show();
        $.ajax({
            url: window.location.href,
            type: 'POST',
            data: {action: 'critical_action', 'val': val, 'id': id},
            success: function (data) {
                //alert(data);
                $('#load_box').hide();
                $('#rec_screen').html(data);
                $('#rec_screen_app').hide();

                $('#propic').click(function () {

                    $('#profiledata').hide();
                    $('#profilenewdata').show();

                });

                $('#imgcancle').click(function () {

                    $('#profilenewdata').hide();
                    $('#profiledata').show();

                });
                $('input[type=file]').simpleFilePreview();
            }
        });
    }
    else if (val == 'delete') {
        var flag = confirm("Are you sure you want to delete this appointment");
        if (flag) {
            $('#load_box').show();
            $.ajax({
                url: window.location.href,
                type: 'POST',
                data: {action: 'critical_action', 'val': val, 'id': id},
                success: function (data) {
                    view_all_receipts();
                    //load_all_receipts();
                    //alert(data);
                    //dis_receipts('view');
                }
            });
        }

    }
}
function view_treatment(id) {
    window.location.href = URL + PHP + DENTAL + 'treatment.php?action=dis_treatment&id=' + id;
}

function update_patient(id) {
    $("#make_receipt_btn").hide();
    var flag = true;
    var pre_name = $('#pre_name').val();
    var name = $('#name').val();
    var user_type = $("#user_type").val();
    var sex = $('#sex').val();
    var bloodgroup = $('#bloodgroup').val();
    var dob = $("#altdob").val();
    var email = $('#email').val();
    var mobile = $('#mobile').val();
    var allergies = $("#allergies").val();
    var address = $("#address").val();
    if (flag) {
        var data = {
            action: 'update_patient',
            'id': id,
            'pre_name': pre_name,
            'name': name,
            'user_type': user_type,
            'sex': sex,
            'bloodgroup': bloodgroup,
            'dob': dob,
            'email': email,
            'mobile': mobile,
            'allergies': allergies,
            'address': address
        };
        $('#load_box').show();
        $.ajax({
            url: window.location.href,
            type: 'POST',
            data: data,
            success: function (data) {
                //alert(data);
                if (data == 0)
                    $('#rec_screen').html("Error!!!");
                else
                    $('#rec_screen').html(data);
                $('#load_box').hide();
                load_tar_session();
                load_all_receipts();
                alert(data);
                dis_receipts_scroll('view');
            }
        });
    }
    else {
        alert("Please fill the mandatory fields");
        $("#make_receipt_btn").show();
    }
}
$(document).ready(function () {


    load_tar_session();
    dis_receipts('create');
    load_all_receipts();




});


//Display the function for Search a Patient
/*
 function search_pai(){
 var name1 =  ($('#name1').val().length) ? $('#name1').val() : "";
 var mobile1 =  ($('#mobile').val().length) ? $('#mobile').val() : "";	
 var email1 =  ($('#email').val().length) ? $('#email').val() : "";
 
 
 console.log(name1);
 $.ajax({
 
 url:window.location.href,
 type:'POST',
 data:{action:'load_all_receipts',pname:name1,pmobile:mobile1,pemail:email1},
 success:function(data){
 //alert(data);
 //dis_receipts_scroll_append();
 
 dis_receipts_scroll();
 $('#target_screen').html(data);
 $('#load_box').hide();
 $('#rec_screen_app').hide();
 }
 });
 } */


//
function search_receipt_name(sname) {
    if (sname.length >= 2) {
        $.ajax({
            url: window.location.href,
            type: 'POST',
            data: {action: 'load_all_receipts', 'name': sname},
            success: function (data) {
                //alert(data);
                //dis_receipts_scroll_append();
                dis_receipts_scroll();
                dis_receipts_scroll_append();
                $('#target_screen').html(data);
                $('#load_box').hide();
                $('#rec_screen_app').show();
            }
        });
    }
}
/*function search_receipt_mobile(smobile){
 if (smobile.length >= 2) {		
 $.ajax({
 url:window.location.href,
 type:'POST',
 data:{action:'load_all_receipts','mobile':smobile},
 success:function(data){
 //alert(data);
 //dis_receipts_scroll_append();
 dis_receipts_scroll();
 $('#target_screen').html(data);
 $('#load_box').hide();
 $('#rec_screen_app').hide();
 }
 });
 }
 }
 function search_receipt_email(semail){
 if (semail.length >= 2) {	
 $.ajax({
 url:window.location.href,
 type:'POST',
 data:{action:'load_all_receipts','email':semail},
 success:function(data){
 //alert(data);
 //dis_receipts_scroll_append();
 dis_receipts_scroll();
 $('#target_screen').html(data);
 $('#load_box').hide();
 $('#rec_screen_app').hide();
 }
 });
 }
 }
 */
//
function view_all_receipts() {

    $.ajax({
        url: window.location.href,
        type: 'POST',
        data: {action: 'load_all_receipts'},
        success: function (data) {
            //alert(data);
            dis_receipts_scroll();
            $('#target_screen').html(data);
            $('#load_box').hide();
        }
    });
}
//Display the mobile number 
function number_allow() {

    $("#mobile").keypress(function (e) {

        //if the letter is not digit then display error and don't type anything
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
            //display error message
            $("#err_mobile").html("Digits Only").show().fadeOut("slow");
            return false;
        }
    });
}


















