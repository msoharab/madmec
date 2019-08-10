$(document).ready(function (){
   $("#helpdeskmenuBut").click(function (){
        showUserModuleDescp();
   });
   $('#usermodulesnap').click(function (){
       showUserModuleDescp();
   });
   $('#stockmodulesnap').click(function (){
        showStockModuleDescp()
   });
   $('#momodulesnap').click(function (){
        showMOModuleDescp();
   });
   $('#projectmodulesnap').click(function (){
        showProjectModuleDescp()
   });
   $('#accountsmodulesnap').click(function (){
        showAccountModuleDescp();
   });
   $('#reportmodulesnap').click(function (){
        showReportModuleDescp();
   });
    $('#logoutmodulesnap').click(function (){
        showLogoutModuleDescp();
   });
   $('#adduser_lightGallery').lightGallery(); 
   $('#listuser_lightGallery').lightGallery(); 
   $('#addstockitem_lightGallery').lightGallery();
   $('#addstock_lightGallery').lightGallery(); 
   $('#viewstock_lightGallery').lightGallery();
   $('#createmo_lightGallery').lightGallery(); 
   $('#additemmo_lightGallery').lightGallery();
   $('#viewmo_lightGallery').lightGallery(); 
   $('#itemsupplied_lightGallery').lightGallery(); 
   $('#requirement_lightGallery').lightGallery();
   $('#addquotation_lightGallery').lightGallery();
   $('#addcpo_lightGallery').lightGallery();
   $('#createpp_lightGallery').lightGallery();
   $('#createpcc_lightGallery').lightGallery();
   $('#listdrawing_lightGallery').lightGallery();
   $('#addinvoice_lightGallery').lightGallery();
   $('#addcollections_lightGallery').lightGallery();
   $('#addprojectpayments_lightGallery').lightGallery();
   $('#Listcollection_lightGallery').lightGallery();
   $('#addpayments_lightGallery').lightGallery();
   $('#listpayments_lightGallery').lightGallery();
   $('#listpettycash_lightGallery').lightGallery();
   $('#addpettycash_lightGallery').lightGallery(); 
   $('#listdue_lightGallery').lightGallery(); 
   $('#currentfollowupslightGallery').lightGallery(); 
   $('#pending_followupsslightGallery').lightGallery(); 
   $('#expiredfollowupslightGallery').lightGallery(); 
   $('#reportslightGallery').lightGallery(); 
   $('#signoutlightGallery').lightGallery(); 
   
   
    function showUserModuleDescp()
    {
    $('#usermoduledesp').show();
    $('#stockmoduledesp').hide();
    $('#momoduledesp').hide();
    $('#projectmoduledesp').hide();
    $('#accountmoduledesp').hide();
    $('#reportmoduledesp').hide();
    $('#signoutmoduledesp').hide();
    }
    function showStockModuleDescp(){
    $('#usermoduledesp').hide();
    $('#stockmoduledesp').show();
    $('#momoduledesp').hide();
    $('#projectmoduledesp').hide();
    $('#accountmoduledesp').hide();
    $('#reportmoduledesp').hide();
    $('#signoutmoduledesp').hide();
    }
    function showMOModuleDescp(){
    $('#usermoduledesp').hide();
    $('#stockmoduledesp').hide();
    $('#momoduledesp').show();
    $('#projectmoduledesp').hide();
    $('#accountmoduledesp').hide();
    $('#reportmoduledesp').hide();
    $('#signoutmoduledesp').hide();
    }
    function showProjectModuleDescp(){
    $('#usermoduledesp').hide();
    $('#stockmoduledesp').hide();
    $('#momoduledesp').hide();
    $('#projectmoduledesp').show();
    $('#accountmoduledesp').hide();
    $('#reportmoduledesp').hide();
    $('#signoutmoduledesp').hide();
    }
    function showAccountModuleDescp(){
    $('#usermoduledesp').hide();
    $('#stockmoduledesp').hide();
    $('#momoduledesp').hide();
    $('#projectmoduledesp').hide();
    $('#accountmoduledesp').show();
    $('#reportmoduledesp').hide();
    $('#signoutmoduledesp').hide();
    }
    function showReportModuleDescp(){
    $('#usermoduledesp').hide();
    $('#stockmoduledesp').hide();
    $('#momoduledesp').hide();
    $('#projectmoduledesp').hide();
    $('#accountmoduledesp').hide();
    $('#reportmoduledesp').show();
    $('#signoutmoduledesp').hide();
    }
    function showLogoutModuleDescp(){
    $('#usermoduledesp').hide();
    $('#stockmoduledesp').hide();
    $('#momoduledesp').hide();
    $('#projectmoduledesp').hide();
    $('#accountmoduledesp').hide();
    $('#reportmoduledesp').hide();
    $('#signoutmoduledesp').show();
    }
});


