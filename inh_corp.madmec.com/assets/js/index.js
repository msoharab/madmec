function loginform() {
    var loginformflag = false;
    $("#login-form").validate({
        rules: {
            username: {
                required: true,
            },
            password: {
                required: true,
                minlength: 4
            }
        },
        messages:
                {
                    username: {
                        name: "please enter your Username"
                    },
                    password: {
                        name: "please enter your password"
                    },
                },
        submitHandler: function() {
            loginformflag = true;
        }
    });

    $("#login-form").submit(function() {
        var formdata = $(this).serialize();
        if (loginformflag) {
            $('#submit').prop('disabled', 'disabled');

            $.ajax({
                url: AJAX_URL,
                type: 'post',
                data: formdata + '&action=signIn&autoloader=true',
                success: function(data, textStatus, xhr) {
                    console.log(data);
                    var data = $.trim(data);
                    if (data == "success") {
                        alert("You Have successfully logged in! ");
                        window.location.href = "dashboard.php";
                    }
                    else
                    {
                        alert("Username and Password Incorrect");
                        $("#login-form").get(0).reset();
                    }
                },
                error: function(data) {
                    alert("Internet Connection Error");
                },
                complete: function(data, textStatus, xhr) {
                    $('#submit').removeAttr('disabled');
                }
            });
        }
    });
}
function bindJobPost() {
    var jobFormflag = false;
    $("#jobPostForm").validate({
        rules: {
            title: {
                required: true,
            },
            industry: {
                required: true,
            },
            employeeType: {
                required: true,
            },
            experience: {
                required: true,
            },
            doj: {
                required: true,
            },
            responsibilities: {
                required: true,
            },
            skills: {
                required: true,
            },
            description: {
                required: true,
            },
        },
        messages:
                {
                    title: {
                        name: "please enter your title"
                    },
                    industry: {
                        name: "please enter industry"
                    },
                    employeeType: {
                        name: "please enter employeeType"
                    },
                    experience: {
                        name: "please enter your experience"
                    },
                    responsibilities: {
                        name: "please enter responsibilities"
                    },
                    doj: {
                        name: "please enter doj"
                    },
                    skills: {
                        name: "please enter skills"
                    },
                    description: {
                        name: "please enter description"
                    },
                },
        submitHandler: function() {
            jobFormflag = true;
        }
    });
    $("#jobPostForm").submit(function() {
        var formdata = $("#jobPostForm").serialize();
        console.log(formdata);
        if (jobFormflag)
        {
            $('#jobPostbtn').prop('disabled', 'disabled');
            $.ajax({
                url: AJAX_URL,
                type: 'POST',
                data: formdata + '&action=jobPost&autoloader=true',
                async: false,
                success: function(data, textStatus, xhr) {
                    console.log(data);
                    if (data == 1)
                    {
                        alert("error occured");
                        $("#jobPostForm").get(0).reset();
                    }
                    else
                    {
                        alert("Successfully Posted Job details...");
                        $("#jobPostForm").get(0).reset();
                    }

                },
                error: function(data) {
                    alert('Error in internet connection !!!');
                },
                complete: function(data, textStatus, xhr) {
                    $('#jobPostbtn').removeAttr('disabled');
                }
            });
        }
    });

}
function bindBlogPost() {
    var contactFormflag = false;
    var picedit = false;
    var picEditObj1 = {};
    picEditObj1 = $('#blogimage').picEdit({
        imageUpdated: function(_this) {
        },
        formError: function(res) {
            picedit = false;
        },
        formProgress: function(data) {
            $('#blogbtn').prop('disabled', 'disabled');
            var res = {};
            if (typeof data === 'object') {
                res = data;
            } else {
                res = $.parseJSON($.trim(data));
            }
            //LogMessages(res);
        },
        formSubmitted: function(data) {
            $('#blogbtn').removeAttr('disabled');
            var res = {};
            if (typeof data === 'object') {
                res = data;
            } else {
                res = $.parseJSON($.trim(data));
            }
            if (res.readyState && picEditObj1._formComplete()) {
                picedit = true;
            } else {
                alert('Error could not add image !!!.');
            }
        },
        FormObj: $('#blogform'),
        goFlag: true,
        picEditUpload: false,
        redirectUrl: false,
        defaultImage: IMG
    });
    $("#blogform").validate({
        rules: {
            blogtitle: {
                required: true,
            },
            blogimage: {
                required: true,
            },
            blogdesc: {
                required: true,
            },
        },
        messages: {
            blogtitle: {
                required: "please enter your title",
            },
            blogimage: {
                required: "please enter your Image",
            },
            blogdesc: {
                required: "please enter your Description",
            },
        },
        submitHandler: function() {
            contactFormflag = true;
        }
    });
    $("#blogform").submit(function() {
        var formdata = $("#blogform").serialize();
        console.log(formdata);
        if (contactFormflag)
        {
            $('#blogbtn').prop('disabled', 'disabled');
            $.ajax({
                url: AJAX_URL,
                type: 'POST',
                data: formdata + '&action=blogPost&autoloader=true',
                //data: 'action=messages&autoloader=true',
                async: false,
                success: function(data, textStatus, xhr) {
                    console.log(data);
                    var data = $.trim(data);
                    if (data == 1) {
                        alert("error occured");
                        $("#blogform").get(0).reset();
                    }
                    else
                    {
                        alert("Successfully posted blog...");
                        $("#blogform").get(0).reset();
                    }

                },
                error: function(data) {
                    alert('Error in internet connection !!!');
                },
                complete: function(data, textStatus, xhr) {
                    $('#blogbtn').removeAttr('disabled');
                }
            });
        }
    });

}
function bindContatForm() {
    var contactFormflag = false;
    var picedit = false;
    var picEditObj1 = {};
    picEditObj1 = $('#companyprofile').picEdit({
        imageUpdated: function(_this) {
        },
        formError: function(res) {
            picedit = false;
        },
        formProgress: function(data) {
            $('#messagebtn').prop('disabled', 'disabled');
            var res = {};
            if (typeof data === 'object') {
                res = data;
            } else {
                res = $.parseJSON($.trim(data));
            }
            //LogMessages(res);
        },
        formSubmitted: function(data) {
            $('#messagebtn').removeAttr('disabled');
            var res = {};
            if (typeof data === 'object') {
                res = data;
            } else {
                res = $.parseJSON($.trim(data));
            }
            if (res.readyState && picEditObj1._formComplete()) {
                picedit = true;
            } else {
                alert('Error could not add company profile !!!.');
            }
        },
        FormObj: $('#contactForm'),
        goFlag: true,
        picEditUpload: false,
        redirectUrl: false,
        defaultImage: IMG
    });
    $("#contactForm").validate({
        rules: {
            name: {
                required: true,
            },
            email: {
                required: true,
                email: true
            },
            phone: {
                required: true,
                number: true,
            },
            message: {
                required: true,
            },
        },
        submitHandler: function() {
            contactFormflag = true;
        }
    });
    $("#contactForm").submit(function() {
        var formdata = $("#contactForm").serialize();
        console.log(formdata);
        if (contactFormflag)
        {
            $('#messagebtn').prop('disabled', 'disabled');
            $.ajax({
                url: AJAX_URL,
                type: 'POST',
                data: formdata + '&action=messages&autoloader=true',
                //data: 'action=messages&autoloader=true',
                async: false,
                success: function(data, textStatus, xhr) {
                    console.log(data);
                    if (data == 1) {
                        alert("error occured");
                        $("#contactForm").get(0).reset();
                    }
                    else
                    {
                        alert("Successfully recieved your contact details  , Will get back to you soon");
                        $("#contactForm").get(0).reset();
                    }

                },
                error: function(data) {
                    alert('Error in internet connection !!!');
                },
                complete: function(data, textStatus, xhr) {
                    $('#messagebtn').removeAttr('disabled');
                }

            });
        }
    });
}
;
function listJob() {
    var header = '<table class="table table-bordered table-striped table-responsive" id="job"><thead><tr><th colspan="11">Job Posts</th></tr><tr><th>#</th><th>Job Title</th><th>Industry</th><th>Employment Type</th><th class="text-center">Experience</th><th class="text-center">Date of joining</th><th class="text-center">Date of post</th><th class="text-center">Action</th></tr></thead>';
    var footer = '</table>';

    $.ajax({
        type: 'POST',
        url: AJAX_URL,
        data: '&action=jobs&autoloader=true',
        success: function(data, textStatus, xhr) {
            /*                                        console.log(data);*/
            data = $.trim(data);
            switch (data) {
                case 'logout':
                    logoutAdmin({});
                    break;
                case 'login':
                    loginAdmin({});
                    break;
                default:
                    var type = $.parseJSON(data);
                    if (type.status == "success") {
                        $('#joblist').html(header + type.data + footer);
                        window.setTimeout(function() {
                            $('#job').dataTable();
                        }, 600);
                    } else {
                        $('#joblist').html('<h5><b><center>No records found</center></b></h5>');
                    }
                    break;
            }
        },
        error: function() {
            $(OUTPUT).html(INET_ERROR);
        },
        complete: function(xhr, textStatus) {
        }
    });
}
;

function listBlog() {
    $.ajax({
        type: 'POST',
        url: AJAX_URL,
        data: '&action=blogs&autoloader=true',
        success: function(data, textStatus, xhr) {
            /*                                        console.log(data);*/
            data = $.trim(data);
            switch (data) {
                case 'logout':
                    logoutAdmin({});
                    break;
                case 'login':
                    loginAdmin({});
                    break;
                default:
                    var type = $.parseJSON(data);
                    if (type.status == "success") {
                        var header = '<table class="table table-bordered table-striped table-responsive" id="blog"><thead><tr><th colspan="11"><center>Blog Posts</center></th></tr><tr><th>#</th><th>Blog Title</th><th>Description</th><th class="text-center">Action</th></tr></thead>';
                        var footer = '</table>';
                        $('#bloglist').html(header + type.data + footer);
                        window.setTimeout(function() {
                            $('#blog').dataTable();
                        }, 600);
                    } else {
                        $('#bloglist').html('<h5><b><center>No records found</center></b></h5>');
                    }
                    break;
            }
        },
        error: function() {
            $(OUTPUT).html(INET_ERROR);
        },
        complete: function(xhr, textStatus) {
        }
    });
}
;
function jobReply() {
    var jobReplyFormflag = false;
    var picedit = false;
    var picEditObj1 = {};
    picEditObj1 = $('#picture').picEdit({
        imageUpdated: function(_this) {
        },
        formError: function(res) {
            picedit = false;
        },
        formProgress: function(data) {
            $('#jobreply').prop('disabled', 'disabled');
            var res = {};
            if (typeof data === 'object') {
                res = data;
            } else {
                res = $.parseJSON($.trim(data));
            }
            //LogMessages(res);
        },
        formSubmitted: function(data) {
            $('#jobreply').removeAttr('disabled');
            var res = {};
            if (typeof data === 'object') {
                res = data;
            } else {
                res = $.parseJSON($.trim(data));
            }
            if (res.readyState && picEditObj1._formComplete()) {
                picedit = true;
            } else {
                alert('Error could not add company profile !!!.');
            }
        },
        FormObj: $('#jobreplyform'),
        goFlag: true,
        picEditUpload: false,
        redirectUrl: false,
        defaultImage: IMG
    });
    $("#jobreplyform").validate({
        rules: {
            name: {
                required: true
            },
            email: {
                required: true,
                email: true
            },
            phone: {
                required: true,
                number: true
            },
            title: {
                required: true
            }
        },
        submitHandler: function() {
            jobReplyFormflag = true;
        }
    });
    $("#jobreplyform").submit(function() {
        var formdata = $("#jobreplyform").serialize();
        //        console.log(formdata);
        if (jobReplyFormflag)
        {
            $('#jobreply').prop('disabled', 'disabled');
            $.ajax({
                url: AJAX_URL,
                type: 'POST',
                data: formdata + '&action=jobreply&autoloader=true',
                //data: 'action=messages&autoloader=true',
                async: false,
                success: function(data, textStatus, xhr) {
                    //                    console.log(data);
                    if (data == 1)
                    {
                        alert("error occured");
                        $("#jobreplyform").get(0).reset();
                    }
                    else
                    {
                        alert("Successfully replied, Will get back to you soon");
                        $("#jobreplyform").get(0).reset();
                    }

                },
                error: function(data) {
                    alert('Error in internet connection !!!');
                },
                complete: function(data, textStatus, xhr) {
                    $('#jobreply').removeAttr('disabled');
                }
            });
        }
    });
}
;
function blogreply() {
    var blogReplyFormflag = false;
    $("#blogreplyform").validate({
        rules: {
            name: {
                required: true
            },
            email: {
                required: true,
                email: true
            },
            message: {
                required: true
            }
        },
        submitHandler: function() {
            blogReplyFormflag = true;
        }
    });
    $("#blogreplyform").submit(function() {
        var formdata = $("#blogreplyform").serialize();
        console.log(formdata);
        if (blogReplyFormflag)
        {
            $('#blogreply').prop('disabled', 'disabled');
            $.ajax({
                url: AJAX_URL,
                type: 'POST',
                data: formdata + '&action=blogreply&autoloader=true',
                async: false,
                success: function(data, textStatus, xhr) {
                    console.log(data);
                    if (data == 1)
                    {
                        alert("error occured");
                        $("#blogreplyform").get(0).reset();

                    }
                    else
                    {
                        alert("Successfully replied, Will get back to you soon");
                        $("#blogreplyform").get(0).reset();
                    }

                },
                error: function(data) {
                    alert('Error in internet connection !!!');
                },
                complete: function(data, textStatus, xhr) {
                    $('#blogreply').removeAttr('disabled');
                }
            });
        }
    });
}
;
function jobReplyList() {
    $.ajax({
        type: 'POST',
        url: AJAX_URL,
        data: '&action=jobreplylist&autoloader=true',
        success: function(data, textStatus, xhr) {
            /*                                        console.log(data);*/
            data = $.trim(data);
            switch (data) {
                case 'logout':
                    logoutAdmin({});
                    break;
                case 'login':
                    loginAdmin({});
                    break;
                default:
                    var type = $.parseJSON(data);
                    if (type.status == "success") {
                        var header = '<table class="table table-bordered table-striped table-responsive" id="jobreplies"><thead><tr><th colspan="11"><center>Job Replies</center></th></tr><tr><th>#</th><th>Name</th><th>Email</th><th>Phone</th><th>Job Title</th><th class="text-center">Image</th><th>Message</th><th class="text-center">Date of Apply</th></tr></thead>';
                        var footer = '</table>';
                        $('#jobreplylist').html(header + type.data + footer);
                        window.setTimeout(function() {
                            $('#jobreplies').dataTable();
                        }, 600);
                    } else {
                        $('#jobreplylist').html('<h5><b><center>No records found</center></b></h5>');
                    }
                    break;
            }
        },
        error: function() {
            alert("error");
        },
        complete: function(xhr, textStatus) {
        }
    });
}
;
function blogReviewList() {
    $.ajax({
        type: 'POST',
        url: AJAX_URL,
        data: '&action=blogreviewlist&autoloader=true',
        success: function(data, textStatus, xhr) {
            /*                                        console.log(data);*/
            data = $.trim(data);
            switch (data) {
                case 'logout':
                    logoutAdmin({});
                    break;
                case 'login':
                    loginAdmin({});
                    break;
                default:
                    var type = $.parseJSON(data);
                    if (type.status == "success") {
                        var header = '<table class="table table-bordered table-striped table-responsive" id="blogreview"><thead><tr><th colspan="11"><center>Blog Reviews</center></th></tr><tr><th>#</th><th>User Name</th><th>Blog Title</th><th>Description</th><th class="text-center">Time of Reply</th></tr></thead>';
                        var footer = '</table>';
                        $('#blogreviewlist').html(header + type.data + footer);
                        window.setTimeout(function() {
                            $('#blogreview').dataTable();
                        }, 600);
                    } else {
                        $('#blogreviewlist').html('<h5><b><center>No records found</center></b></h5>');
                    }
                    break;
            }
        },
        error: function() {
            alert("error");
        },
        complete: function(xhr, textStatus) {
        }
    });
}
;
function dashboard() {
    loadHTML('dashboard.php');
}