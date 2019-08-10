$( document ).ready(function(){
		$("#NEWS").show();
        $("#SPONSORSBUT").bind('click',function (){
            go_to("SPONSORS");
            
        });
        $("#NEWSBUT").bind('click',function (){
            go_to("NEWS");
            
        });
        $("#bnewshome").bind('click',function (){
            go_to("NEWS");
            
        });
        $("#breakingnewshome").bind('click',function (){
            go_to("NEWS");
            
        });
        
        $("#BUSINESSBUT").bind('click',function (){
            go_to("BUSINESS");
            
        });
        $("#LOGINBUT").bind('click',function (){
            go_to("LOGIN");
            
        });
});
function go_to(val){
    
    $(".main_sec").slideUp(500);
    $("#"+val).slideDown(1000);
    $('.navbar-toggle').trigger('click');
    if(val=="NEWS")
    {
        var obj= new controller();
         obj.fetnews();   
    }
    else if(val=="SPONSORS")
    {
        var obj= new controller();
        obj.fetsponsopous();
    }
    else
    {
     var obj= new controller();
        obj.fetbusiness(); 
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