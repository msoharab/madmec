$(document).ready(function (){
   var sponsorous={
       spnosmenubut     : '#spnosmenubut',
       
       
   };
   var news={
       form             : '#addnewform',
       newsmenubut      : '#newsmenubut',
       viewnews         : '#view_news',
       newspic          : '#newspic',
       newsheading      : '#newsheading',
       newsdescb        : '#newsdescb',
       add_news         : '#add_news',
       
       addnewsbut       : '#addnewsbut',
       disnews          : '#disnews',
       
       
   };
   var business={
       form             : '#addbussform',
       displaybusiness  : '#displaybusiness',
      businessmenubut   : '#businessmenubut',
      bussinessimg      : '#bussinessimg',
      bussinessname     : '#bussinessname',
      busdescripttion   : '#busdescripttion',
      bussinessphone    : '#bussinessphone',
      bussinessemail    : '#bussinessemail',
      viewbuzz          : '#view_buzz',
      bussinessdesc     : '#bussinessdesc',
      addbusinessbut    : '#addbusinessbut',
      
   };
   
   var controll={
       sponsorous : sponsorous,
       news       : news,
       business   : business,
       url        : AJAX
       
   };
   obj=new controller();
   obj.__construct(controll);
   
})

