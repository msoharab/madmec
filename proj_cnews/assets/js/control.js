$(document).ready(function (){                
   var sponsorous={
       spnosmenubut     : '#spnosmenubut',
       displaysopnsopers : '#displaysopnsopers',
       addsponsers      : '#addsponsers',
       sponform         : '#sponform',
       sponimg          : '#sponimg',
       spomurl          : '#spomurl',
       addsponbut       : '#addsponbut',
       addspons         : '#addspons',
       form             : '#sponform',
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
   
   var divs={
      validatedetails   : '#validatedetails',
      signdetails       : '#signdetails',
      loginmenu         : '#loginmenu',
      menudet           : '#menudet',
      signdiv           : '#signdiv',
      registerdiv       : '#registerdiv',
   };
   
   var signin={
      form              : '#signform',
      username          : '#username',
      password          : '#password',
      signbut           : '#signbut',
      newacc            : '#newacc',
   
    };
    
    var signup={
      form          : '#regform',
      name          : '#name',
      regemobile    : '#regemobile',
      regemail      : '#regemail',
      regpass       : '#regpass',
      regcpass      : '#regcpass',
      signacc       : '#signacc',
      emailcheck    : 0
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
       LOGINBUT   : '#LOGINBUT',
       HOMEBUT   : '#HOMEBUT',
       news       : news,
       business   : business,
       divs       : divs,
       signin     : signin,
       signup     : signup,
       bnewshome  : '#bnewshome',
       bnewshome1 : '#breakingnewshome',
       url        : AJAX
   };
   obj=new controller();
   obj.__construct(controll);
   
})

