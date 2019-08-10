$(document).ready(function (){
   var tooldata='';
  tooldata +='<div class="col-lg-12">&nbsp;</div><div class="col-lg-12">';
  var j=0;
  var k=0;
  var toolnames=["Turning Tool Holder English Type","Eclipe Type Tool Bit Holder","German Type Tool Holder","Universal Tool Holders","Cutting-Off(Parting) Tool Holders",
      "Cutting-Off Side Tool Holders","Knurling Tool Holder (with english pattern holders)","spare krunl","Boring Bars","Revolving (LIVE) Centres","Revolving Tube(PIPE) Centres"
  ,"Dead (lathe) Centres","Morse Taper Drill Sleeves","Arbors for Drill Chucks Workshop Grade","A-Grade","Surface Guage (Fixed & Adjustable)",
  "Universal Surface Guage(Steel Base)","Lathe(Dogs) CARRIERS","Permanent Magnetic(Rectangular)","Permanent Magnetic CHUCKS(Circular)","Magnetic Bases","Magnetic Vee Blocks(SOFT)",
  "Adapter CHUCKS Blocks","Power Magnet","pocket Magnets","pot Magnets","Bar Magnets","Magnetic Separator","D-Magnetiser","Engineer's Try Squares","Try Square A-Grade","Graduated Try Squares (One SIde Graduated)",
  "Adjustable Try Square (Model no.414) with one blade","Tool Maker (Single PC.) Try Square Hardended & Ground Alloy Steel Accuracy - 0.1 mm","Centre Square (Alloy Steel)",
  "Marking Guages","Multi purpose Drill Guage","Callipers & Dividers Spring Callipers","Firm Joint Callipers","Firm Joint Jenny(HermaPhrodite) Callipers","Wing Compases (ARM Dividers)",
  "Depth Guage","Pocket Rule","Protector","Stainless Steel Scale","Screw Cutting Guage","Wire Guage(SWG)","Centre (Angle) Guage","Universal Guage","Tape Bore guage (inches & mm combined)",
  "Screw Pitch Guage","Radius Guage","Brass Vernier 4 inches","Drill Guage","InterChangable Leather Punch Set","Mini Tap Wrenches (Handle)","Tap Wrenches (Handle)","T-Handle Tap Wrenches "
  ,"Long Handled T-Tap Wrenches","Round Die handles","precision Machine vices","Tool Makers Grinding Vices","Drill Chunks Keys","Lathe Chunks Keys","Dog Chunks Keys (Heavy Duty)","Ejecting Drill Drifts",
  "Drill Stand (ALUMINUM)","Diamond Dressers","Emery Wheel Dressers & Cutters","Bearing Scrapers Flat and Half Round OR Triangular","Adjustable Hand Reamers(Workshop Grade)",
  "Adjustable Hand Reamers Sets(Workshop Grade)","Screws on Extension Pilots",
  "Fixed hand Reamers","Fixed hand Reamer Set","Valve Seat and Face Cutters Set",
  "Slot Mortice Drill Bits","Tool Maker's(Parallel) lamps","G-Clamps","Automatic Centre Punch","Dot Punch","Centre Punches","Pin Punches","Long Drive Pin Punches(8 Inches length)",
  "Nail Punches","Prick Punches","Letter Punch and Figure Punch Set","Pin Vices","Master Pin Vices","Pin Chuck Set","Engineer's Steel Scriber","Beam Trammels and Attachments",
  "Engineer's Straight Edges","Engineer's Steel Parallels","Sine Bars","Elongated Steel Vee Block(Hardened and Ground)","Tool Makers Steel Vee Block and Clamp","Cast Iron Cubes",
  "C.I Vee Blocks(With and Without Clamp)","Steel Vee Blocks With Clamps Hardened and Ground","C.I Angles Plates(Plain)","C.I Angles Plates(Sloted)","Machinist Jacks","Rubber Mallets",
  "Surface Hardening Powder","Iron Cement"];
   for(i=1;i<=98;i++)  
   {
       if(i==14 || i==27 || i==28 || i==35 || i==60 || i==69 || i==75 || i==78)
       {
         for(m=0;m<2;m++)  
         {
             ++j;
             var etn='';
             if(m==0)
             etn='a';
             else
             etn='b';    
           tooldata +=' <div class="col-lg-6"  class="gravida-left" style="border-right: 1px  solid lightsalmon">'+
                            '<div class="col-lg-5">'+
                                '<ul id="light-gallery'+k+'" class="gallery">'+
                                    '<li data-src="assets/images/iztools/png_images/'+i+'d'+etn+'.jpg">'+
                                            '<a href="javascript:void(0)">'+
                                                '<img src="assets/images/iztools/png_images/'+i+'d'+etn+'.jpg" class="img-responsive"/>'+
                                       ' </a>'+
                                    '</li>'+
                                '</ul>'+
                                '<h4><a href="javascript:void(0)">'+toolnames[k]+'</a></h4>'+
//                                '<p class="text-justify">Tool Description</p>'+
                            '</div>'+
                             '<div class="col-lg-7">'+
                                 '<ul id="light-galleryprice'+k+'" class="gallery">'+
                                    '<li data-src="assets/images/iztools/png_snaps/'+i+etn+'.jpg">'+
                                            '<a href="javascript:void(0)">'+
                                                '<img src="assets/images/iztools/png_snaps/'+i+etn+'.jpg" class="img-responsive"/>'+
                                        '</a>'+
                                    '</li>'+
                                '</ul>'+
                            '</div>'+
                       ' </div>';  
               k++;
            if(j%2==0)
            {
              tooldata +='</div';   
              tooldata +='<div class="col-lg-12">&nbsp;</div><div class="col-lg-12">';
            }
         }
       }
       else
       {
           ++j;
            tooldata +=' <div class="col-lg-6"  class="gravida-left" style="border-right: 1px  solid lightsalmon">'+
                    '<div class="col-lg-5">'+
                        '<ul id="light-gallery'+k+'" class="gallery">'+
                            '<li data-src="assets/images/iztools/png_images/'+i+'d.jpg">'+
                                    '<a href="javascript:void(0)">'+
                                        '<img src="assets/images/iztools/png_images/'+i+'d.jpg" class="img-responsive"/>'+
                               ' </a>'+
                            '</li>'+
                        '</ul>'+
                        '<h4><a href="javascript:void(0)">'+toolnames[k]+'</a></h4>'+
//                        '<p class="text-justify">Tool Description</p>'+
                    '</div>'+
                     '<div class="col-lg-7">'+
                         '<ul id="light-galleryprice'+k+'" class="gallery">'+
                            '<li data-src="assets/images/iztools/png_snaps/'+i+'.jpg">'+
                                    '<a href="javascript:void(0)">'+
                                        '<img src="assets/images/iztools/png_snaps/'+i+'.jpg" class="img-responsive"/>'+
                                '</a>'+
                            '</li>'+
                        '</ul>'+
                    '</div>'+
               ' </div>';
       k++;
            if(j%2==0)
            {
              tooldata +='</div';   
              tooldata +='<div class="col-lg-12">&nbsp;</div><div class="col-lg-12">';
            }
       }
    
   }
   $('#displaytools').html(tooldata);
});


