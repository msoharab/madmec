function treatment(val){
    $('#load_box').show();
    $.ajax({
        url:window.location.href,
        type:'POST',
        data:{action:'treatment','val':val},
        success:function(data){
            //alert(data);
            $('#rec_screen').html(data);
            $('#rec_screen').slideDown(1500);
            $('#rec_screen_app').slideUp(1000);
            $('#load_box').hide();
            $('input[type=file]').simpleFilePreview();
        }
    });
}
function toggle_app_form(){
    if($("#next_app_check").prop("checked")){
        $("#next_app_form").show();
        $("#app_con").val('1');
    }
    else{
        $("#next_app_form").hide();
        $("#app_con").val('0');
    }
}
//function to add a treatment and first visit and next auto appointment(optional)
function add_treatment(){
    $('#load_box').show();
    var id = $('#id').val();
    var name = $('#name').val();
    var mobile = $('#phone').val();
    var dot = $('#alt_dot').val();
    var tre_name = $('#tre_name').val();
    var amount = $('#amount').val();
    var comp = $('#comp').val();
    var diag = $('#diag').val();
    var cas = $('#case').val(); 
    var amount_paid = $('#amount_paid').val();
    
        if($('#app_con').val() == 1){
            var app_date = $('#alt_app_date').val();
            var app_time = $('#from').val();
        }
        else{
            app_date = 0;
            app_time = 0;
        }
        /* if statement for optional treatment image
        if(){
            pre_tre_img = false;
            mid_tre_img = false;
            post_tre_img = false;
        }
        else{
            pre_tre_img = false;
            mid_tre_img = false;
            post_tre_img = false;
        }
     */
    $.ajax({
        url:window.location.href,
        type:'POST',
        data:{
            action:'add_treatment',
            'id':id,
            'name':name,
            'mobile':mobile,
            'dot':dot,
            'tre_name':tre_name,
            'amount':amount,
            'amount_paid':amount_paid,
            'comp':comp,
            'diag':diag,
            'cas':cas,
            'app_date':app_date,
            'app_time':app_time
        },
        success:function(data){
            $('#rec_screen').html(data);
            $('input[type=file]').simpleFilePreview();
            $('#load_box').hide();
        }
    });
}
function add_visit(id=false){
    var id = $('#id').val();
    var tre_id = $("#tre_id").val();
    var name = $('#name').val();
    var mobile = $('#phone').val();
    var dot = $('#alt_dot').val();
    var tre_name = $('#tre_name').val();
    var amount = $('#amount').val();
    var comp = $('#comp').val();
    var diag = $('#diag').val();
    var cas = $('#case').val(); 
    var amount_paid = $('#amount_paid').val();
        if($('#app_con').val() == 1){
            var app_date = $('#alt_app_date').val();
            var app_time = $('#from').val();
        }
        else{
            app_date = 0;
            app_time = 0;
        }
    $('#load_box').hide();
    $.ajax({
        url:window.location.href,
        type:'POST',
        data:{
            action:'add_visit',
            'id':id,
            'tre_id':tre_id,
            'name':name,
            'mobile':mobile,
            'dot':dot,
            'tre_name':tre_name,
            'amount':amount,
            'amount_paid':amount_paid,
            'comp':comp,
            'diag':diag,
            'cas':cas,
            'app_date':app_date,
            'app_time':app_time
        },
        success:function(data){
            //alert(data);
            $('#rec_screen').html(data);
            $('#rec_screen').slideDown(1500);
            $('#rec_screen_app').slideUp(1000);
            $('#load_box').hide();
			view_img(tre_id);	
        }
    });   
}
function caltime(){
	var hh = $("#hh").val();
	var mm = $("#mm").val();
	var meridiem = $("#meridiem").val();
	from = (meridiem == 'PM') ? parseInt(hh)+12 : hh;
	$("#from").val(from+':'+mm+':00');
}
function load_user_details(){
    $('#load_box').hide();
    $.ajax({
        url:window.location.href,
        type:'POST',
        data:{
            action:'load_user_details'
        },
        success:function(data){
            $('#rec_screen_user_details').html(data);
        }
    });   
}
function show_visit_form(id,tre_name,tre_amount,index,balance_rem){
    $('#load_box').hide();
    $.ajax({
        url:window.location.href,
        type:'POST',
        data:{
            action:'show_visit_form',
            'val':'create',
            'tre_name':tre_name,
            'tre_amount':tre_amount,
            'id':id,
            'index' : index,
            'balance_rem' : balance_rem,
        },
        success:function(data){
            $('#rec_screen').html(data);
            $('#rec_screen').slideDown(1500);
            $('#rec_screen_app').slideUp(1000);
            $('#load_box').hide();
        }
    });   
}
//function to add new visit using treatment ID//

function view_history(id){
    $('#load_box').hide();
    $.ajax({
        url:window.location.href,
        type:'POST',
        data:{
            action:'view_history','id':id
        },
        success:function(data){
            $('#rec_screen').html(data);
            $('#rec_screen').slideDown(1500);
            $('#rec_screen_app').slideUp(1000);
            
            $('#load_box').hide();
        }
    });
}

function view_img(id){
	$('#load_box').hide();
    htm='';
    var value={};
    $.ajax({
        url:window.location.href,
        type:'POST',
        data:{
            action:'view_img','id':id
        },
        success:function(data){
			data = $.parseJSON($.trim(data));
			$('#rec_screen_app').html(data.imgdata);
            $('#rec_screen').slideUp(1000);
            $('#rec_screen_app').slideDown(1500);
            $('#load_box').hide();
            $('#ex3pre').simpleFilePreview({
					existingFiles:data.pre_img
			});
			$('#ex1mid').simpleFilePreview({
					existingFiles:data.mid_img
			});
			$('#ex2post').simpleFilePreview({
					existingFiles:data.post_img
			});
			
        }
    });
}

function view_treatment(id,bal_amount=false){
    $('#load_box').hide();
    $.ajax({
        url:window.location.href,
        type:'POST',
        data:{
            action:'view_treatment','id':id,'bal_amount':bal_amount,
        },
        success:function(data){
            $('#rec_screen_app').html(data);
            $('#rec_screen').slideUp(1000);
            $('#rec_screen_app').slideDown(1500);
            $('#load_box').hide();
        }
    });
}
 function upload(val,tre_id,img_class) {
    $('#'+val).html(IMG_LOADER);
    var values = [];
    var fields = document.getElementsByName(img_class);
    console.log(fields.length);
    var count = (fields.length)-1;
    for(i=0;i<count;i++){
        console.log(fields[i].getAttribute('id'));
        var id = fields[i].getAttribute('id');
        var file_data = $("#"+id).prop('files')[0];   
        var form_data = new FormData();                  
        form_data.append('file', file_data);
        $.ajax({
                    url: 'upload.php', // point to server-side PHP script 
                    dataType: 'text',  // what to expect back from the PHP script, if anything
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: form_data,                         
                    type: 'post',
                    async:false,
                    success: function(php_script_response){
                        $.ajax({
                                url:window.location.href,
                                type:'POST',
                                data:{action:'upload_image','val':val,'tre_id':tre_id},
                                success:function(data){
                                    if(i == count ){
                                        $('#'+val).html("<h3>Images successfully uploaded</h3>");
                                    }
                                }
                        });
                    }
         });
    
     }
}
// function to calculate balance amount //
function cal_balance(){
    var amount = parseInt($("#amount").val());
    var amount_paid = parseInt($("#amount_paid").val());
    var balance = amount - amount_paid;
    $("#bal_amount").val(balance);
    if(balance < 0){
        $("#err_bal_amount").html("Balance Amount Incorrect");
        $("#err_bal_amount").show();
    }
    else{
        $("#err_bal_amount").hide();
    }
}

$(document).ready(function(){
    treatment('create');
    setTimeout(load_user_details,1000);
});
