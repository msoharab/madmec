function send_email(){
    
    $("#load_box").show();
    var flag = false;
    var name = $("#name").val();
    var address = $("#address").val(); 
    var city = $("#city").val(); 
    var pin = $("#pin").val(); 
    var mobile = $("#mobile").val(); 
    var email = $("#email").val(); 
    var time = $("#time").val(); 
    var cat = $("#cat").val(); 
    var msg = $("#msg").val();
    if(name.length > 2 ){
        flag = true
    }
    else{
        flag = false;
        alert("please enter Your Name before submitting");
    }
    if(mobile.length >= 10 ){
        flag = true
    }
    else{
        flag = false;
        alert("please enter 10 Digit mobile number before submitting");
    }
    if(flag){
        $.ajax({
            url: URL+'ajax/email.php',
            type: 'POST',
            data: { 
                action:'send_email',
                name:name,
                address:address,
                city:city,
                pin:pin,
                mobile:mobile,
                email:email,
                time:time,
                cat:cat,
                msg:msg
            },
            success: function(data) {
                alert(data);
                window.location = URL+'ws/contact.html'; 
                

            }
        });
    }
    else{
        $("#load_box").hide();
    }
        
}

$(document).ready(function(){
    if($(window).width() > 600){
        $('#mainmenu .li_link').show();
        $('#menuToggle').hide();
    }
    else{
        $('#mainmenu .li_link').hide();
        $('#menuToggle').show();
    }
});
function toggle_menu(){
    if( $('#mainmenu .li_link').css('display') == 'none')
    {
      $('#mainmenu .li_link').show();
    }
    else{
        $('#mainmenu .li_link').hide();
    }
}