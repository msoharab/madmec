$(document).ready(function (){
	$("#helpdeskmenuBut").click(function (){
    $('#enquirymoduledesp').show();
    $('#customermoduledesp').hide();
    $('#trainermoduledesp').hide();
    $('#accountmoduledesp').hide(); 
    $('#managemoduledesp').hide(); 
    $('#statmoduledesp').hide(); 
    $('#reportsmoduledesp').hide();
    $('#crmmoduledesp').hide();
    $('#signoutmoduledesp').hide();    
   });
   $('#enquirymodulesnap').click(function (){
    $('#enquirymoduledesp').show();
    $('#customermoduledesp').hide();
    $('#trainermoduledesp').hide();
    $('#accountmoduledesp').hide();
    $('#managemoduledesp').hide();
    $('#statmoduledesp').hide();
    $('#reportsmoduledesp').hide();
	$('#crmmoduledesp').hide();
    $('#signoutmoduledesp').hide();
   });
   $('#customermodulesnap').click(function (){
    $('#enquirymoduledesp').hide();
    $('#customermoduledesp').show();
    $('#trainermoduledesp').hide();
    $('#accountmoduledesp').hide();
    $('#managemoduledesp').hide();
    $('#statmoduledesp').hide();
    $('#reportsmoduledesp').hide();
    $('#crmmoduledesp').hide();
    $('#signoutmoduledesp').hide();
   });
   $('#trainermodulesnap').click(function (){
    $('#enquirymoduledesp').hide();
    $('#customermoduledesp').hide();
    $('#trainermoduledesp').show();
    $('#accountmoduledesp').hide();
	$('#managemoduledesp').hide();
	$('#statmoduledesp').hide();
	$('#reportsmoduledesp').hide();
	$('#crmmoduledesp').hide();
    $('#signoutmoduledesp').hide();
   });
   $('#accountmodulesnap').click(function (){
    $('#enquirymoduledesp').hide();
    $('#customermoduledesp').hide();
    $('#trainermoduledesp').hide();
    $('#accountmoduledesp').show();
    $('#statmoduledesp').hide();
    $('#reportsmoduledesp').hide();
    $('#crmmoduledesp').hide();
    $('#signoutmoduledesp').hide();
   }); 
   $('#managemodulesnap').click(function (){
    $('#enquirymoduledesp').hide();
    $('#customermoduledesp').hide();
    $('#trainermoduledesp').hide();
    $('#accountmoduledesp').hide();
    $('#managemoduledesp').show();
    $('#statmoduledesp').hide();
    $('#reportsmoduledesp').hide();
    $('#crmmoduledesp').hide();
    $('#signoutmoduledesp').hide();
   });
    $('#statmodulesnap').click(function (){
    $('#enquirymoduledesp').hide();
    $('#customermoduledesp').hide();
    $('#trainermoduledesp').hide();
    $('#accountmoduledesp').hide();
    $('#managemoduledesp').hide();
    $('#statmoduledesp').show();
    $('#reportsmoduledesp').hide();
    $('#crmmoduledesp').hide();
    $('#signoutmoduledesp').hide();
   }); 
    $('#reportsmodulesnap').click(function (){
    $('#enquirymoduledesp').hide();
    $('#customermoduledesp').hide();
    $('#trainermoduledesp').hide();
    $('#accountmoduledesp').hide();
    $('#managemoduledesp').hide();
    $('#statmoduledesp').hide();
    $('#reportsmoduledesp').show();
    $('#crmmoduledesp').hide();
    $('#signoutmoduledesp').hide();
   }); 
    $('#crmmodulesnap').click(function (){
    $('#enquirymoduledesp').hide();
    $('#customermoduledesp').hide();
    $('#trainermoduledesp').hide();
    $('#accountmoduledesp').hide();
    $('#managemoduledesp').hide();
    $('#statmoduledesp').hide();
    $('#reportsmoduledesp').hide();
    $('#crmmoduledesp').show();
    $('#signoutmoduledesp').hide();
   }); 
   
   $('#signoutmodulesnap').click(function (){
    $('#enquirymoduledesp').hide();
    $('#customermoduledesp').hide();
    $('#trainermoduledesp').hide();
    $('#accountmoduledesp').hide();
     $('#managemoduledesp').hide();
    $('#statmoduledesp').hide();
    $('#reportsmoduledesp').hide();
    $('#crmmoduledesp').hide();
    $('#signoutmoduledesp').show();
   });
   
   //enquiry
   $('#enquiry_add_lightGallery').lightGallery(); 
   $('#enquiry_follow1_lightGallery').lightGallery();
   $('#enquiry_follow2_lightGallery').lightGallery();
   $('#enquiry_follow3_lightGallery').lightGallery();
   $('#enquiry_list_lightGallery').lightGallery();
   
   //Customer 
   $('#add_cust_lightGallery').lightGallery();
   $('#list_cust_lightGallery').lightGallery();
   $('#import_cust_lightGallery').lightGallery();
//   $('#enquiry_list_lightGallery').lightGallery();
//   $('#enquiry_list_lightGallery').lightGallery();
   
   //employee
   $('#employee_add_lightGallery').lightGallery();
   $('#employee_list_lightGallery').lightGallery();
   $('#employee_delete_lightGallery').lightGallery();
   $('#employee_flag_lightGallery').lightGallery();
   $('#employee_unflag_lightGallery').lightGallery();
   $('#employee_edit_lightGallery').lightGallery();
   $('#employee_excel_sheet_lightGallery').lightGallery();
   $('#employee_import_lightGallery').lightGallery();
  //account
   $('#acc_fee_lightGallery').lightGallery();
   $('#acc_package_lightGallery').lightGallery();
   $('#acc_due_lightGallery').lightGallery();
   $('#acc_club_expence_lightGallery').lightGallery();
   $('#acc_staff_pay_lightGallery').lightGallery();
   //stats
   $('#stats_acc_lightGallery').lightGallery();
   $('#stats_reg_lightGallery').lightGallery();
   $('#stats_cust_lightGallery').lightGallery();
   $('#stats_emp_lightGallery').lightGallery();
   //crm
   $('#crm_mobile_lightGallery').lightGallery();
   $('#crm_mobile_sent_lightGallery').lightGallery();
   $('#crm_email_lightGallery').lightGallery();
   $('#crm_email_sent_lightGallery').lightGallery();
   $('#crm_sms_lightGallery').lightGallery();
   $('#crm_sms_sent_lightGallery').lightGallery();
   $('#crm_feed_lightGallery').lightGallery();
   $('#crm_feed_stats_lightGallery').lightGallery();
   //report
   $('#report_Club_lightGallery').lightGallery();
   $('#report_gymfee_lightGallery').lightGallery();
   $('#report_package_lightGallery').lightGallery();
   $('#report_registration_lightGallery').lightGallery();
   $('#rep_customer_registration_lightGallery').lightGallery();
   $('#report_payments_lightGallery').lightGallery();
   $('#rep_payments_lightGallery').lightGallery();
   $('#report_expences_lightGallery').lightGallery();
   $('#rep_expences_lightGallery').lightGallery();
   $('#report_balancesheet_lightGallery').lightGallery();
   $('#rep_balancesheet_lightGallery').lightGallery();
   $('#report_customer_lightGallery').lightGallery();
   $('#rep_customer_lightGallery').lightGallery();
   $('#report_employee_lightGallery').lightGallery();
   $('#rep_trainer_lightGallery').lightGallery();
   $('#report_receipt_lightGallery').lightGallery();
   $('#report_rec_lightGallery').lightGallery();
  
});


