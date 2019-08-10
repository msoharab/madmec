    /* GLOBAL CONSTANTS */
	var URL = 'http://local.tamboola.com/';
    // var URL = 'http://f2.madmec.com/';
    var LAND_PAGE		= "Tamboola";
    var INC = "inc/";
    var ADMIN = "admin/";
    var USER = "user/";
    var TRAINER = "trainer/";
    var DOWNLOADS = "downloads/";
    var UPLOADS = "uploads/";
    var ASSET_DIR = "assets/";
    var ASSET_JSF = "assets/js/";
    var ASSET_JS_USER = "a.user/";
    var ASSET_JS_TRAINER = "a.trainer/";
    var ASSET_JS_MANAGE = "a.manage/";
    var ASSET_JS_REPORT = "a.reports/";
    var ASSET_JS_STATS = "a.stats/";
    var ASSET_JS_ACCOUNTS = "a.accounts/";
    var ASSET_CSS = "assets/css/";
    var ASSET_IMG = "assets/images/";
    var ICON_THEME = "set1/";
    var ICON_THEME2 = "set2/";
    var LOADER_ONE 		= '<img class="img-circle" src="'+URL+ASSET_IMG+'loader1.gif" border="0" width="60" height="60" />';
    var LOADER_TWO 		= '<img class="img-circle" src="'+URL+ASSET_IMG+'loader2.gif" border="0" width="25" height="25" />';
    var LOADER_THR 		= '<img class="img-circle" src="'+URL+ASSET_IMG+'loader3.gif" border="0" width="25" height="25" />';
    var LOADER_FUR 		= '<img class="img-circle" src="'+URL+ASSET_IMG+'loader4.gif" border="0" />';
    var LOADER_FIV 		= '<img class="img-circle" src="'+URL+ASSET_IMG+'loader5.gif" border="0" width="60" height="60" />';
    var INET_ERROR		= '<span class="text-danger"><i class="fa fa-bomb fa-5x"/></i></span><span class="text-danger">Error in internet connection !!!</span>';
    var LOGN_ERROR		= '<span class="text-danger"><i class="fa fa-bomb fa-5x"/></i></span><span class="text-danger">Error in login credentials !!!</span>';
    var VALIDNOT		= '<strong class="text-success">Valid</strong>';
    var INVALIDNOT		= '<strong class="text-danger">Not Valid</strong>';
    var nm_reg = /^[A-Z_a-z\.\'\-]{3,100}$/;
    var number_reg = /[0-9]{1,20}$/;
    var name_reg = /^[A-Z_a-z\.\'\- 0-9]{3,100}$/;
    var email_reg = /^[A-Z_a-z0-9-]+(\.[A-Z_a-z0-9-]+)*@[A-Za-z0-9-]+(\.[A-Za-z0-9]{2,4})*(\.[A-Za-z]{2,4})$/;
    var pass_reg = /.{6,100}$/;
    var cell_reg = /[0-9]{10,20}$/;
    var ZIP_reg=/[1-9]{6,10}$/;
	var ccod_reg = /[0-9]{2,15}$/;
	var tele_reg = /[0-9]{4,20}$/;
	var id_reg 	 = /[1-9]{1,20}$/;
	var ind_reg	 = /[0-9]{1,20}$/;
	var addline_reg = /.{3,200}$/;
	var st_city_dist_cont_reg = /.{3,100}$/;
	var prov_reg = /.{3,150}$/;
	var url_reg = '^(http[s]?:\\/\\/(www\\.)?|ftp:\\/\\/(www\\.)?|www\\.){1}([0-9A-Za-z-\\.@:%_\+~#=]+)+((\\.[a-zA-Z]{2,3})+)(/(.)*)?(\\?(.)*)?';
    var DGYM_ID =	"#printrs";
    var GYMNAME = "F2";
    var REG_FEE = 500;
    var START_DATE = "2014-02-03";
    var ST_PER = 0.1236;
    var CURRENCY_SYM_2X = "<i class='fa fa-inr fa-2x'></i>";
    var CURRENCY_SYM_3X = "<i class='fa fa-inr fa-3x'></i>";
    var CURRENCY_SYM_4X = "<i class='fa fa-inr fa-4x'></i>";
    var CURRENCY_SYM_5X = "<i class='fa fa-inr fa-5x'></i>";
    var GYM_LOGO = URL.ASSET_IMG+"short-logo.jpg";
    /* Customer constraints */
    var Customer = URL+ASSET_IMG+ICON_THEME2+"anonymous.png";
    /* Admin constraints */
    var Administrator = URL+ASSET_IMG+ICON_THEME2+"administrator.png";
    /* Trainer constraints */
    var Trainer = URL+ASSET_IMG+ICON_THEME2+"trainer.png";
    $.fn.center = function () {
        this.css("position","absolute");
        this.css("top", Math.max(0, (($(window).height() - $(this).outerHeight()) / 2) +
                                                    $(window).scrollTop()) + "px");
        this.css("left", Math.max(0, (($(window).width() - $(this).outerWidth()) / 2) +
                                                    $(window).scrollLeft()) + "px");
        return this;
    }
    function BindScrollEvents(){
        //Make button appear only when scrolled below 100px
        $(window).scroll(function(){
            if ($(this).scrollTop() > 100) {
                $('.toTopNav').show(300);
            }
            if ($(this).scrollTop() < 100) {
                $('.toTopNav').hide(400);
            }
            var scrollbartop = $(window).scrollTop();
            // var sidebartop = $('#sidebar').css('top');
            if(scrollbartop == 0){
                $('#sidebar').css('top','0px');
            }
            else if(scrollbartop > 52){
                $('#sidebar').css('top',Number(scrollbartop * 0.010)+'px')
            }
        });
    }
  	function loginAdmin(para){
		console.log("I am here");
		location.replace(LAND_PAGE);
	}
	function logoutAdmin(para){
		location.replace(URL);
	}
	function auto_fit_screen(){
        // $("#nav-top").css("position","fixed");
        // $("#nav-top").css("width",$(window).width());
        // $(".container").css({top:Number($("#nav-top").innerHeight()),position:"relative",width:$(window).width()});
        // console.log(Number($("#wrapper").innerHeight()));
        // $('#wrapper').css("height",(Number($("#wrapper").innerHeight()) - Number($("#nav-top").innerHeight())));
        // console.log(Number($("#wrapper").innerHeight()));
        // $(".container").css({top:nav_hegit,position:"relative",width:win_width});
        // width:Number(win_width) - (Number(win_width) * 0.2),
        // height:Number(win_heigt) - (Number(win_heigt) * 0.35),
        var nav_hegit = $("#nav-top").innerHeight();
        var win_width = $(window).width();
        var win_heigt = $(window).height();
        if($(window).width() < 750){
            // console.log(' style is removed '+$(window).width());
            $("#nav-top").removeAttr("style");
            $(".container").removeAttr("style");
            $("#prep").remove();
        }
        else{
            $('#nav-top').css({
                position:"fixed",
                width:$(window).width()
            });
            $(".container").css({
                top:nav_hegit,
                position:"relative",
                width:win_width,
                marginLeft:'0px',
                paddingLeft:'0px',
                marginRight:'0px'
            });
            $(".container").prepend('<div id="prep" class="row"><div class="col-lg-12">&nbsp;</div></div>');
        }
        if ( $( "#light_box" ).length ) {
            $("#light_box").css({
                top:'5px',
                position:"fixed",
                width:Number(win_width),
                height:Number(win_heigt),
                paddingLeft:'10px',
                paddingRight:'10px'
            });
            $(document).bind('keydown',function(event){
                if(event.keyCode === 13){
                    $('#light_box').remove();
                }
            });
            $('#light_box').find('div').each(function(){
                if($(this).hasClass( "col-lg-8" )){
                    $(this).css({
                        width:Number(win_width) - (Number(win_width) * 0.1)
                    });
                }
            })
        }
    }
    $(document).ready(function(){
        $('document,body').show();
        $('#page-loader').hide();
        $("html, body").animate({scrollTop: 0}, "slow");

    });
