	function UploadPicture(){
		/* Members variables */
		var JsonID = {}; /* User name & pk should be saved as json */
		var AjaxLoader = '<img class="img-circle" src="'+URL+ASSET_IMG+'spinner_grey_120.gif" border="0" width="60" height="60" />';
		var HowMany = false;
		var ToWhom = false;
		var num_reg = /^[0-9]{1,10}$/;
		var name_reg = /^[A-Z_a-z\.\'\- 0-9]{3,100}$/;
		var UploadIds = {};
		/* Constructor */
		this.__constructor = function(para){
			UploadIds = {
				LoaderIMG:'<img class="img-circle" src="'+URL+ASSET_IMG+'spinner_grey_120.gif" border="0" width="60" height="60" />',
				PrintInvoice:"#print_invoice",
				TabLoader:".photo_loader",
				PageLoader:"#output",
				ParentDiv:"#photo_upload",
				ParentMenuDiv:{HardDiskLink:"#action_upload",
							  CameraLink:"#action_capture",
							  PrintInvoiceLink:"#action_print"
				},
				HardDiskDiv:{ParentDiv:"#upload_photo",
							FormID:"#uploadphoto",
							FormURL:"",
							BrowseButton:"#imgfile",
							TableUploadPhoto:"#table_upload_photo",
							PbarParent:"#progress",
							Pbar:"#bar",
							PbarPercent:"#percent",
							PbarStatus:"#status"
				},
				CameraDiv:{ParentDiv:"#capture_photo",
							FormID:"#capturephoto",
							FormURL:"",
							TableCapturePhoto:"#table_capture_photo",
							CatpureLayout:"#catpure_layout",
							TakeSnapshot:"#take-snapshot",
							WebcamConfigure:"#webcam-configure",
							ProgressBar:"#upload_results"
				},
				CropDiv:{ParentDiv:"#crop_photo",
						JCropIMG:"#cropbox",
						JCropIMGW:400,
						JCropIMGH:400,
						PreviewIMG:"#preview",
						PreviewParent:"#preview-parent",
						PreviewIMGW:100,
						PreviewIMGH:100,
						FormID:"#cropphoto",
						FormURL:"",
						Left:"#x",
						Top:"#y",
						Right:"#x2",
						Bottom:"#y2",
						Width:"#w",
						Height:"#h",
						JcropHolder:".jcrop-holder",
						JcropTracker:".jcrop-tracker",
						RotatePic:"#rotatephoto",
						CropDone:"#checkcoords",
						Done:"#doneupload"
				}
			};
			HowMany = para.HowMany;
			ToWhom = para.ToWhom;
			UploadIds.ParentDiv = para.ParentDiv;
			switch(ToWhom){
				case "User":
					UploadIds.HardDiskDiv.FormURL = URL+ADMIN+USER+"upload_user_photo.php";
					UploadIds.CameraDiv.FormURL = URL+ADMIN+USER+"capture_user_photo.php";
					UploadIds.CropDiv.FormURL = URL+ADMIN+USER+"upload_user_photo.php";
				break;
				case "Trainer":
					UploadIds.HardDiskDiv.FormURL = URL+ADMIN+TRAINER+"upload_trainer_photo.php";
					UploadIds.CameraDiv.FormURL = URL+ADMIN+TRAINER+"capture_trainer_photo.php";
					UploadIds.CropDiv.FormURL = URL+ADMIN+TRAINER+"upload_trainer_photo.php";
				break;
				case "Admin":
					UploadIds.HardDiskDiv.FormURL = URL+ADMIN+"upload_admin_photo.php";
					UploadIds.CameraDiv.FormURL = URL+ADMIN+"capture_admin_photo.php";
					UploadIds.CropDiv.FormURL = URL+ADMIN+"upload_admin_photo.php";
				break;
				case "Club":
					UploadIds.HardDiskDiv.FormURL = URL+ADMIN+"upload_club_photo.php";
					UploadIds.CameraDiv.FormURL = URL+ADMIN+"capture_club_photo.php";
					UploadIds.CropDiv.FormURL = URL+ADMIN+"upload_club_photo.php";
				break;
			}
			IntializeJSON();
		};
		/* Members methods */
		function IntializeJSON(){
			$(UploadIds.PageLoader).html(UploadIds.LoaderIMG);
			$.ajax({
				url:window.location.href,
				type:'POST',
				data:{autoloader:'true',action:'IntializeJSON',HowMany:HowMany},
				success: function(data){
					$(UploadIds.PageLoader).fadeOut(300);
					JsonID = $.parseJSON(data);
					var name = "";
					var id = "";
					switch(HowMany){
						case "Individual":
							if(JsonID.name.match(name_reg) && JsonID.id.match(num_reg)){
								name = JsonID.name;
								id = JsonID.id;
							}
						break;
						case "Group":
							if(JsonID.name[0].match(name_reg) && JsonID.id[0].match(num_reg)){
								name = JsonID.name[0];
								id = JsonID.id[0];
								JsonID.name.shift();
								JsonID.id.shift();
							}
						break;
					}
					InstallHTML(id,name);
				},
				error: function(data){
					alert('Check your internet connection !!! Error :- ' + data);
				}
			});
		};
		function InstallHTML(id,name){
			$(UploadIds.PageLoader).show(300);
			$.ajax({
				url:window.location.href,
				type:'POST',
				async:false,
				data:{autoloader:'true',
					action:'InstallHTML',
					id:id,
					name:name},
				success: function(data){
					$(UploadIds.PageLoader).fadeOut(300);
					$(UploadIds.ParentDiv).html(data);
					window.setTimeout(function(){
						$(UploadIds.ParentMenuDiv.HardDiskLink).on("click",function(){
							ConfigureHardDisk();
						});
						$(UploadIds.ParentMenuDiv.CameraLink).on("click",function(){
							ConfigureCamera();
						});
						// $(UploadIds.ParentMenuDiv.PrintInvoiceLink).on("click",function(){
							// printInvoice();
						// });
						ConfigureHardDisk();
						ConfigureCamera();
						$(UploadIds.TabLoader).each(function(){
							$(UploadIds.TabLoader).hide().html(UploadIds.LoaderIMG);
						});
						$(UploadIds.ParentDiv).show(300);
						$(UploadIds.HardDiskDiv.ParentDiv).show(500);
					},400);
				},
				error: function(data){
					alert('Check your internet connection !!! Error :- ' + data);
				}
			});
		};
		function ConfigureHardDisk(){
			$(UploadIds.CameraDiv.ParentDiv).hide();
			$(UploadIds.CropDiv.ParentDiv).hide();
			var bar = $(UploadIds.HardDiskDiv.Pbar);
			var percent = $(UploadIds.HardDiskDiv.PbarPercent);
			var status = $(UploadIds.HardDiskDiv.PbarStatus);
			$(UploadIds.HardDiskDiv.FormID).attr("action",UploadIds.HardDiskDiv.FormURL);
			$(UploadIds.HardDiskDiv.FormID).ajaxForm({
				beforeSend: function() {
					status.empty();
					var percentVal = '0%';
					bar.width(percentVal)
					percent.html(percentVal);
					if($(UploadIds.HardDiskDiv.BrowseButton).val().length == 0)
						return;
				},
				uploadProgress: function(event, position, total, percentComplete) {
					var percentVal = percentComplete + '%';
					bar.width(percentVal)
					percent.html(percentVal);
				},
				success: function(data) {
					if(data == 'logout')
						window.location.href = URL;
					else{
						window.setTimeout(function(){
							var percentVal = '100%';
							bar.width(percentVal);
							percent.html(percentVal);
							/* Load the crop plug in */
							CropPicture(data);
						},500);
					}
				},
				complete: function(xhr) {
					var percentVal = '0%';
					if(xhr.responseText.length == 0){
						bar.width(percentVal);
						percent.html(percentVal);
					}
					// status.html(xhr.responseText);
				}
			});
			$(UploadIds.HardDiskDiv.ParentDiv).show(500);
		};
		function ConfigureCamera(){
			$(UploadIds.HardDiskDiv.ParentDiv).hide();
			$(UploadIds.CropDiv.ParentDiv).hide();
			$(UploadIds.CameraDiv.WebcamConfigure).bind("click",function(){
				webcam.configure();
			});
			$(UploadIds.CameraDiv.TakeSnapshot).bind("click",function(){
				TakeSnapShot();
			});
			$(UploadIds.CameraDiv.ParentDiv).show(500);
		};
		function TakeSnapShot(){
			$(UploadIds.CameraDiv.ProgressBar).html('<h3>Uploading...</h3>');
			webcam.set_swf_url(URL+ASSET_JSF+'jpegcam/webcam.swf');
			webcam.set_api_url(UploadIds.CameraDiv.FormURL);
			webcam.set_quality(90);
			webcam.set_shutter_sound( true ,URL+ASSET_JSF+'jpegcam/shutter.mp3');
			webcam.set_stealth(false);
			$(UploadIds.CameraDiv.CatpureLayout).html(webcam.get_html(320, 240, 640, 480));
			webcam.set_hook('onComplete', 'CompleteSnapShot',false);
			webcam.snap(UploadIds.CameraDiv.FormURL,'CompleteSnapShot',false);
		};
		function CompleteSnapShot(){
			/* extract URL out of PHP output */
			if(msg == 'logout')
				window.location.href = URL;
			else if (msg.length > 0){
				$(UploadIds.CameraDiv.ProgressBar).html('Done');
				/* reset camera for another shot */
				webcam.reset();
				/* Load the crop plug in */
				window.setTimeout(function(){
					CropPicture(msg);
				},500);
			}
			else
				alert("PHP Error: " + msg);
		};
		function CropPicture(imgurl){
			$(UploadIds.CameraDiv.ParentDiv).hide();
			$(UploadIds.HardDiskDiv.ParentDiv).hide();
			$(UploadIds.CropDiv.PreviewIMG).attr("src",imgurl);
			$(UploadIds.CropDiv.PreviewParent).css({
				width:UploadIds.CropDiv.PreviewIMGW,
				height:UploadIds.CropDiv.PreviewIMGH,
				overflow:"hidden",
				marginLeft:"5",
				transform:"rotate(0deg)"
			});
			$(UploadIds.CropDiv.JCropIMG).attr("src",imgurl).attr("width",UploadIds.CropDiv.JCropIMGW).attr("height",UploadIds.CropDiv.JCropIMGH).attr('style','transform: rotate(0deg);position:absolute;').Jcrop({aspectRatio: 1,onChange: showPreview,onSelect: showPreview,onSelect: updateCoords});
			window.setTimeout(function(){
				$(UploadIds.CropDiv.JcropHolder).find('img').each(function(){
					$(this).attr("src",$(UploadIds.CropDiv.JCropIMG).attr("src"));
				});
				$(UploadIds.CropDiv.JcropTracker).find('img').each(function(){
					$(this).attr("src",$(UploadIds.CropDiv.JCropIMG).attr("src"));
				});
			},100);
			$(UploadIds.CameraDiv.ProgressBar).hide();
			$(UploadIds.CropDiv.RotatePic).on("click",function(){
				rotatePhoto();
			});
			$(UploadIds.CropDiv.CropDone).on("click",function(){
				UploadPicture();
			});
			$(UploadIds.CropDiv.Done).on("click",function(){
				UploadPicture();
			});
			$(UploadIds.CropDiv.ParentDiv).show(500);
		};
		function updateCoords(c){
			$(UploadIds.CropDiv.Left).val(c.x);
			$(UploadIds.CropDiv.Top).val(c.y);
			$(UploadIds.CropDiv.Right).val(c.x2);
			$(UploadIds.CropDiv.Bottom).val(c.y2);
			$(UploadIds.CropDiv.Width).val(c.w);
			$(UploadIds.CropDiv.Height).val(c.h);
			$(UploadIds.CropDiv.CropDone).show();
			$(UploadIds.CropDiv.Done).hide();
		};
		function showPreview(coords){
			var rx = 100 / coords.w;
			var ry = 100 / coords.h;
			$(UploadIds.CropDiv.PreviewIMG).css({
				width: Math.round(rx * 500) + 'px',
				height: Math.round(ry * 370) + 'px',
				marginLeft: '-' + Math.round(rx * coords.x) + 'px',
				marginTop: '-' + Math.round(ry * coords.y) + 'px'
			});
			$(UploadIds.CropDiv.JcropHolder,UploadIds.CropDiv.JcropTracker).find('img').each(function(){
				if($(this).attr("src") != $(UploadIds.CropDiv.JCropIMG).attr("src")){
					$(this).attr("src",$(UploadIds.CropDiv.JCropIMG).attr("src"));
				}
			});
		};
		function showCoords(c){
			$(UploadIds.CropDiv.Left).val(c.x);
			$(UploadIds.CropDiv.Top).val(c.y);
			$(UploadIds.CropDiv.Right).val(c.x2);
			$(UploadIds.CropDiv.Bottom).val(c.y2);
			$(UploadIds.CropDiv.Width).val(c.w);
			$(UploadIds.CropDiv.Height).val(c.h);
		};
		function UploadPicture(){
			var fields = {};
			if($('#x').val() > 0 && $('#y').val() > 0 && $('#x2').val() > 0 && $('#y2').val() > 0){
				fields = {crop:'yes',
							left:$(UploadIds.CropDiv.Left).val(),
							top:$(UploadIds.CropDiv.Top).val(),
							right:$(UploadIds.CropDiv.Right).val(),
							bottom:$(UploadIds.CropDiv.Bottom).val(),
							width:$(UploadIds.CropDiv.Width).val(),
							height:$(UploadIds.CropDiv.Height).val()
				};
			}
			else{
				fields = {crop:'no',left:10,top:10,right:10,bottom:10,width:0,height:0};
			}
			$.ajax({
				url:UploadIds.HardDiskDiv.FormURL,
				type:'POST',
				data:fields,
				success: function(data){
					var flag = true;
					var name = "";
					var id = "";
					switch(HowMany){
						case "Individual":
							/* do nothing */ 
						break;
						case "Group":
							if(JsonID.name[0].match(name_reg) && JsonID.id[0].match(num_reg)){
								name = JsonID.name[0];
								id = JsonID.id[0];
								JsonID.name.shift();
								JsonID.id.shift();
								flag = false;
								InstallHTML(id,name);
							}
						break;
					}
					if(flag){
						$(UploadIds.CropDiv.ParentDiv).hide(200);
						$(UploadIds.CameraDiv.ParentDiv).html('<div class="col-lg-12"><img src="'+data+'" border="0" width="150" height="150" /><div>');
						$(UploadIds.HardDiskDiv.ParentDiv).html('<div class="col-lg-12"><img src="'+data+'" border="0" width="150" height="150" /><div>');
						$(UploadIds.CameraDiv.ParentDiv).show(100);
						$(UploadIds.HardDiskDiv.ParentDiv).show(200);
						$(UploadIds.ParentMenuDiv.HardDiskLink).unbind("click");
						$(UploadIds.ParentMenuDiv.CameraLink).unbind("click");
						printInvoice();
					}
				},
				error: function(data){
					alert('Check your internet connection !!! Error :- ' + data);
				}
			});
			setTimeout(function(){
				HideAjaxCall();
			},500);
		};
		function HideAjaxCall(){
			$.ajax({
				url:URL+'Admin/user/upload_user_photo.php',
				type:'POST',
				data:{crop:'no',left:0,top:0,right:0,bottom:0},
				success: function(data){
					$(UploadIds.CropDiv.JCropIMG).attr('src',data);
				},
				error: function(data){
					alert('Check your internet connection !!! Error :- ' + data);
				}
			});
		};
		function rotatePhoto(){
			$.ajax({
				url:UploadIds.HardDiskDiv.FormURL,
				type:'POST',
				data:{crop:'no',left:0,top:0,right:0,bottom:0,rotate:'yes'},
				success:function(data){
					if(data == 'logout')
						window.location.href = URL;
					window.setTimeout(function(){
						$(UploadIds.CropDiv.JcropHolder).find('img').each(function(){
							$(this).rotate(-parseInt(data));
						});
						$(UploadIds.CropDiv.JcropTracker).find('img').each(function(){
							$(this).rotate(-parseInt(data));
						});
					},100);
					$(UploadIds.CropDiv.JcropHolder,UploadIds.CropDiv.JcropTracker).find('img').each(function(){
						$(this).rotate(-parseInt(data));
						$(UploadIds.CropDiv.JCropIMG).rotate(-parseInt(data));
					});
					$(UploadIds.CropDiv.PreviewIMG).rotate(-parseInt(data));
				},
				error: function(data){
					alert('Check your internet connection !!! Error :- ' + data);
				}
			});
		}
		function printInvoice(){
			$(UploadIds.PrintInvoice).html(UploadIds.LoaderIMG);
			$(UploadIds.ParentMenuDiv.PrintInvoiceLink).trigger("click");
			$.ajax({
				url:window.location.href,
				type:'POST',
				data:{autoloader:'true',action:'PrintInvoice'},
				success: function(data){
					$(UploadIds.PrintInvoice).html(data);
				}
			});
		}
	}