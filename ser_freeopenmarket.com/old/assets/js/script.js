$( document ).ready(function(){
	$("#NEWS").show();
        $("#SPONSORSBUT").bind('click',function (){
            goto("SPONSORS");
            
        });
        $("#NEWSBUT").bind('click',function (){
            goto("NEWS");
            
        });
        $("#BUSINESSBUT").bind('click',function (){
            goto("BUSINESS");
            
        });
        $("#LOGINBUT").bind('click',function (){
            goto("LOGIN");
            
        });
});

function goto(val){
    
    $(".main_sec").slideUp(500);
    $("#"+val).slideDown(1000);
    $(".gn-trigger").trigger('click');
    if(val=="NEWS")
    {
        var obj= new controller();
         obj.fetnews();
        
    }
}   
function view_news(){
    $("#news_screen").fadeIn();
    $("#news_form").fadeOut();

  var obj= new controller();
         obj.fetnews();
}
function add_news(){
    $("#news_screen").fadeOut();
    $("#news_form").fadeIn();
}
function view_buzz(){
    $("#buzz_screen").fadeIn();
    $("#buzz_form").fadeOut();
     var obj= new controller();
         obj.fetbusiness();
}
function add_buzz(){
    $("#buzz_screen").fadeOut();
    $("#buzz_form").fadeIn();
}