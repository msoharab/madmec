	function controller() {
		var ctrl = {};
		this.__construct = function(ctrll) {
			ctrl = ctrll;
			if (localStorage.getItem("user") == "admin") {
				$(ctrl.sponsorous.addspons).show();
			} else {
				$(ctrl.sponsorous.addspons).hide();
			}
			if (localStorage.getItem("verified") == "verified") {
				$(ctrl.LOGINBUT).hide();
			} else {
				$(ctrl.LOGINBUT).show();
			};
			// if (isMobile.any()) {
				// $('#mobile-version').html('<label>Select Photo</label><div><button class="btn btn-info" id="upload-newsimg-gallery" data-role="button" name="ajax/upload.php" >Upload from Gallery</button> &nbsp; &nbsp;<button class="btn btn-info" id="upload-newsimg-camera" name="ajax/upload.php" data-role="button" >Upload from Camera</button> </div>');
				// $('#mobile-version0').html('<label>Select Photo</label><div><button class="btn btn-info" id="upload-newsimg-gallery0" data-role="button" name="ajax/upload0.php" >Upload from Gallery</button> &nbsp; &nbsp;<button class="btn btn-info" id="upload-newsimg-camera0" name="ajax/upload0.php" data-role="button" >Upload from Camera</button> </div>');
				// $('#mobile-version1').html('<label>Select Photo</label><div><button class="btn btn-info" id="upload-newsimg-gallery1" data-role="button" name="ajax/upload1.php" >Upload from Gallery</button> &nbsp; &nbsp;<button class="btn btn-info" id="upload-newsimg-camera1" name="ajax/upload1.php" data-role="button" >Upload from Camera</button> </div>');
			// } else {
				// $('#desktop-version').html('<label>Upload image</label><input type="file" name="newspic" id="newspic" /><input  type="file"  id="patientphoto" name="patientphoto" style="display:none;" > <p class="help-block" id="patientphotomsg"></p>');
				// $('#desktop-version0').html('<label>Upload image</label><input type="file" name="bussinessimg" id="bussinessimg" ><input  type="file"  id="patientphoto0" name="patientphoto0" style="display:none;" ><p class="help-block" id="patientphoto0msg"></p>');
				// $('#desktop-version1').html('<label>Upload image</label><input type="file"  name="sponimg" id="sponimg"/><input  type="file"  id="patientphoto1" name="patientphoto1" style="display:none;" ><p class="help-block" id="patientphoto0msg"></p>');
			// }
			$('#mobile-version').html('<label>Upload image</label><input type="file" name="newspic" id="newspic" /><input  type="file"  id="patientphoto" name="patientphoto" style="display:none;" > <p class="help-block" id="patientphotomsg"></p><label>Select Photo</label><div><button class="btn btn-info" id="upload-newsimg-gallery" data-role="button" name="ajax/upload.php" >Upload from Gallery</button> &nbsp; &nbsp;<button class="btn btn-info" id="upload-newsimg-camera" name="ajax/upload.php" data-role="button" >Upload from Camera</button> </div>');
			$('#mobile-version0').html('<label>Upload image</label><input type="file" name="bussinessimg" id="bussinessimg" ><input  type="file"  id="patientphoto0" name="patientphoto0" style="display:none;" ><p class="help-block" id="patientphoto0msg"></p><label>Select Photo</label><div><button class="btn btn-info" id="upload-newsimg-gallery0" data-role="button" name="ajax/upload0.php" >Upload from Gallery</button> &nbsp; &nbsp;<button class="btn btn-info" id="upload-newsimg-camera0" name="ajax/upload0.php" data-role="button" >Upload from Camera</button> </div>');
			$('#mobile-version1').html('<label>Upload image</label><input type="file"  name="sponimg" id="sponimg"/><input  type="file"  id="patientphoto1" name="patientphoto1" style="display:none;" ><p class="help-block" id="patientphoto0msg"></p><label>Select Photo</label><div><button class="btn btn-info" id="upload-newsimg-gallery1" data-role="button" name="ajax/upload1.php" >Upload from Gallery</button> &nbsp; &nbsp;<button class="btn btn-info" id="upload-newsimg-camera1" name="ajax/upload1.php" data-role="button" >Upload from Camera</button> </div>');
			$(ctrl.divs.registerdiv).hide();
			$(ctrl.signin.newacc).click(function() {
				$(ctrl.divs.registerdiv).show();
				$(ctrl.divs.signdiv).hide();
			})
			$(ctrl.signup.signacc).click(function() {
				$(ctrl.divs.registerdiv).hide();
				$(ctrl.divs.signdiv).show();
			})
			$(ctrl.sponsorous.addsponsers).hide();
			$(ctrl.sponsorous.addspons).on('click', function() {
				$(ctrl.sponsorous.addsponsers).show();
				$(ctrl.sponsorous.displaysopnsopers).hide();
			});
			$(ctrl.signin.form).submit(function(evt) {
				evt.preventDefault();
				$.post(AJAX, $(this).serialize() + '&action=verifyuser', function(result) {
					result = $.trim(result);
					var details = $.parseJSON(result);
					if (details.status == "success") {
						localStorage.setItem("verified", "verified");
						if (Number(details.usertype) == 2) {
							localStorage.setItem("user", "admin");
						} else {
							localStorage.setItem("user", "user");
						}
						window.location.href = "index.html";
					} else {
						alert("Invalid Credentials")
					}
				});
			});
			$(ctrl.news.newsmenubut).on('click', function() {
				fetchNEWS();
			});
			$(ctrl.business.newsmenubut).on('click', function() {
				fetchNEWS();
			});
			$(ctrl.news.viewnews).on('click', function() {
				fetchNEWS();
			});
			$(ctrl.news.addnewsbut).click(function() {
				addnews();
			});
			$(ctrl.business.addbusinessbut).on('click', function() {
				addBusiness();
			});
			$(ctrl.business.viewbuzz).click(function() {
				fetchBusiness();
			})
			/*on chnage to automatically upload images once selected */
			window.setTimeout(function() {
				$(ctrl.news.newspic).change(function() {
					var count = 0;
					var img = '';
					var val = $.trim($((ctrl.news.newspic)).val());
					if (val == '') {
						count = 1;
					}
					if (count == 0) {
						for (var i = 0; i < $(ctrl.news.newspic).get(0).files.length; ++i) {
							img = $(ctrl.news.newspic).get(0).files[i].name;
							var extension = img.split('.').pop().toUpperCase();
							if (extension != "PNG" && extension != "JPG" && extension != "GIF" && extension != "JPEG") {
								count = count + 1
							}
						}
					}
					if (count == 0) {
						$(ctrl.news.form).ajaxForm({}).submit();
					}
				})
				$(ctrl.business.bussinessimg).change(function() {
					var count = 0;
					var img = '';
					var val = $.trim($((ctrl.business.bussinessimg)).val());
					if (val == '') {
						//count= 1;
					}
					if (count == 0) {
						for (var i = 0; i < $(ctrl.business.bussinessimg).get(0).files.length; ++i) {
							img = $(ctrl.business.bussinessimg).get(0).files[i].name;
							var extension = img.split('.').pop().toUpperCase();
							if (extension != "PNG" && extension != "JPG" && extension != "GIF" && extension != "JPEG") {
								count = count + 1
							}
						}
					}
					if (count == 0) {
						$(ctrl.business.form).ajaxForm({}).submit();
					}
				})
				$(ctrl.sponsorous.sponimg).change(function() {
					var count = 0;
					var img = '';
					var val = $.trim($((ctrl.sponsorous.sponimg)).val());
					if (val == '') {
						count = 1;
					}
					if (count == 0) {
						for (var i = 0; i < $(ctrl.sponsorous.sponimg).get(0).files.length; ++i) {
							img = $(ctrl.sponsorous.sponimg).get(0).files[i].name;
							var extension = img.split('.').pop().toUpperCase();
							if (extension != "PNG" && extension != "JPG" && extension != "GIF" && extension != "JPEG") {
								count = count + 1
							}
						}
					}
					if (count == 0) {
						$(ctrl.sponsorous.form).ajaxForm({}).submit();
					}
				});
			}, 900);
			$(ctrl.signup.regemail).change(function() {
				$.post(AJAX, {
					email: $(ctrl.signup.regemail).val(),
					action: 'checkemail'
				}, function(res) {
					if (Number(res)) {
						alert("Email is Already Exist");
						ctrl.signup.emailcheck = res;
					} else {
						ctrl.signup.emailcheck = res;
					}
				});
			})
			$(ctrl.signup.form).submit(function(evt) {
				evt.preventDefault();
				if (ctrl.signup.emailcheck == 0) {
					alert("Email is Already Exist");
				}
				if ($(ctrl.signup.regpass).val() == $(ctrl.signup.regcpass).val()) {
					$.post(AJAX, $(this).serialize(), function(res) {
						if (res) {
							alert("Account has been Successfully Created");
							$(ctrl.signup.form).get(0).reset();
							$(ctrl.divs.registerdiv).hide();
							$(ctrl.divs.signdiv).show();
						}
					});
				} else {
					alert("Comfirm Password not match");
				}
			});
			$(ctrl.sponsorous.addsponbut).click(function() {
				var flag = false;
				if ($(ctrl.sponsorous.spomurl).val() == "") {
					flag = false;
					$(ctrl.sponsorous.spomurl).focus();
					return;
				} {
					flag = true;
				}
				if (flag) {
					$.post(AJAX, {
						action: 'addspon',
						imgurl: $(ctrl.sponsorous.spomurl).val()
					}, function(res) {
						if (res) {
							alert("SPONSORS has been Added Successfully");
							$(ctrl.sponsorous.form).get(0).reset();
							$(ctrl.sponsorous.addsponsers).hide();
							$(ctrl.sponsorous.displaysopnsopers).show();
							fetchSponsorous();
						}
					});
				}
			});
			$('#upload-newsimg-camera,#upload-newsimg-camera0,#upload-newsimg-camera1').on('click', function(evt) {
				var fille = $(this).attr('name');
				evt.preventDefault();
				if (isMobile.any()) {
					document.addEventListener("deviceready", function() {
						window.setTimeout(function() {
							navigator.camera.getPicture(function(imageURI) {
								uploadPhoto(imageURI, {
									file: fille
								});
							}, function(message) {
								alert(message + ' Get picture failed');
							}, {
								quality: 50,
								destinationType: navigator.camera.DestinationType.FILE_URI
								// destinationType: navigator.camera.DestinationType.DATA_URL 
							});
						}, 2500);
					}, true);
				}
			});
			$('#upload-newsimg-gallery,#upload-newsimg-gallery0,#upload-newsimg-gallery1').on('click', function(evt) {
				var fille = $(this).attr('name');
				evt.preventDefault();
				if (isMobile.any()) {
					document.addEventListener("deviceready", function() {
						window.setTimeout(function() {
							navigator.camera.getPicture(function(imageURI) {
								uploadPhoto(imageURI, {
									file: fille
								});
							}, function(message) {
								alert(message + ' Get picture failed');
							}, {
								quality: 50,
								destinationType: navigator.camera.DestinationType.FILE_URI,
								sourceType: navigator.camera.PictureSourceType.PHOTOLIBRARY
							});
						}, 2500);
					}, true);
				}
			});
			$(ctrl.news.disnews).html(LOADER_ONE);
			window.setTimeout(function() {
				fetchNEWS();
				fetchBusiness();
				fetchSponsorous();
			}, 5000);
		};
		this.fetnews = function() {
			fetchNEWS();
		};
		this.fetbusiness = function() {
			fetchBusiness();
		};
		this.fetsponsopous = function() {
			fetchSponsorous();
		};
		function win(r) {
			alert("successfully uploaded photo");
			console.log("Code = " + r.responseCode);
			console.log("Response = " + r.response);
			console.log("Sent = " + r.bytesSent);
		}
		function fail(error) {
			alert("photo An error has occurred: Code = " + error.code);
			console.log("upload error source " + error.source);
			console.log("upload error target " + error.target);
		}
		function uploadPhoto(imageURI, file) {
			window.setTimeout(function() {
				var options = new FileUploadOptions();
				options.fileKey = "patientphoto";
				options.fileName = imageURI.substr(imageURI.lastIndexOf('/') + 1) + '.jpg';
				options.mimeType = "text/plain";
				options.params = new Object();
				var ft = new FileTransfer();
				ft.upload(imageURI, encodeURI(URL + file.file), win, fail, options);
			}, 1500);
		}
		function uploadFromCamera0() {
			navigator.camera.getPicture(uploadPhoto0,
				function(message) {
					alert('get picture failed');
				}, {
					quality: 50,
					destinationType: navigator.camera.DestinationType.FILE_URI
				}
			);
		}
		function uploadFromGallery0() {
			// Retrieve image file location from specified source
			navigator.camera.getPicture(uploadPhoto0,
				function(message) {
					alert('get picture failed');
				}, {
					quality: 50,
					destinationType: navigator.camera.DestinationType.FILE_URI,
					sourceType: navigator.camera.PictureSourceType.PHOTOLIBRARY
				}
			);
		}
		function uploadPhoto0(imageURI) {
			var options = new FileUploadOptions();
			options.fileKey = "patientphoto0";
			options.fileName = imageURI.substr(imageURI.lastIndexOf('/') + 1) + '.jpg';
			options.mimeType = "text/plain";
			var params = new Object();
			options.params = params;
			var ft = new FileTransfer();
			ft.upload(imageURI, encodeURI("http://cnews.madmec.com/ajax/upload0.php"), win0, fail0, options);
		}
		function win0(r) {
			alert("successfullt uploaded photo");
			console.log("Code = " + r.responseCode);
			console.log("Response = " + r.response);
			console.log("Sent = " + r.bytesSent);
		}
		function fail0(error) {
			alert("photo An error has occurred: Code = " + error.code);
			console.log("upload error source " + error.source);
			console.log("upload error target " + error.target);
		}
		function fetchNEWS() {
			$(ctrl.news.disnews).html(LOADER_ONE);
			$.ajax({
				url: ctrl.url,
				type: 'POST',
				data: {
					action: 'fetchnews'
				},
				success: function(data, textStatus, xhr) {
					data = $.trim(data);
					var det = $.parseJSON(data);
					if (det.status == "success") {
						$(ctrl.news.disnews).html(det.data);
						window.setTimeout(function() {
							for (i = 0; i < det.newsid.length; i++) {
								$('#delnews_' + det.newsid[i]).bind('click', {
									tbid: det.newsid[i]
								}, function(event) {
									var bid = event.data.tbid;
									if (confirm("Are you sure to Delete this Post?")) {
										deleteNEWSPost(bid);
									}
								});
							}
						}, 400)
					} else {
						$(ctrl.news.disnews).html('<span class="text-danger"><strong>no records</strong></span>');
					}
				},
				error: function() {
					alert("NO INTERNET CONNECTION!!! please connect to internet.");
					$(ctrl.news.disnews).html("NO INTERNET CONNECTION!!! please connect to internet.");
				},
				complete: function(xhr, textStatus) {}
			});
		};
		function addnews() {
			var flag = false;
			if ($(ctrl.news.newsheading).val() == "") {
				$(ctrl.news.newsheading).focus();
				flag = false;
				return
			} else {
				flag = true;
			}
			if ($(ctrl.news.newsdescb).val() == "") {
				$(ctrl.news.newsdescb).focus();
				flag = false;
				return
			} else {
				flag = true;
			}
			if (flag) {
				var attr = {
					heading: $(ctrl.news.newsheading).val(),
					descb: $(ctrl.news.newsdescb).val()
				}
				$.ajax({
					url: ctrl.url,
					type: 'POST',
					data: {
						action: 'addnews',
						details: attr,
					},
					success: function(data, textStatus, xhr) {
						console.log(textStatus);
						data = $.trim(data);
						var det = $.parseJSON(data);
						if (det) {
							alert("NEWS has been Successfully Added");
							$(ctrl.news.form).get(0).reset();
							$(ctrl.news.viewnews).trigger('click');
						}
					},
					error: function() {
						alert("NO INTERNET CONNECTION!!! please connect to internet.");
					},
					complete: function(xhr, textStatus) {}
				});
			}
		}
		function addBusiness() {
			var flag = false;
			if ($(ctrl.business.bussinessname).val() == "") {
				$(ctrl.business.bussinessname).focus();
				flag = false;
				return;
			} else {
				flag = true;
			}
			if ($(ctrl.business.busdescripttion).val() == "") {
				$(ctrl.business.busdescripttion).focus();
				flag = false;
				return;
			} else {
				flag = true;
			}
			if ($(ctrl.business.bussinessphone).val() == "" || !$(ctrl.business.bussinessphone).val().match(numbs)) {
				$(ctrl.business.bussinessphone).focus();
				flag = false;
				return;
			} else {
				flag = true;
			}
			if ($(ctrl.business.bussinessemail).val() == "" || !$(ctrl.business.bussinessemail).val().match(email_reg)) {
				$(ctrl.business.bussinessemail).focus();
				flag = false;
				return;
			} else {
				flag = true;
			}
			if ($(ctrl.business.bussinessdesc).val() == "") {
				$(ctrl.business.bussinessdesc).focus();
				flag = false;
				return;
			} else {
				flag = true;
			}
			if (flag) {
				var attr = {
					businame: $(ctrl.business.bussinessname).val(),
					addr: $(ctrl.business.busdescripttion).val(),
					mobile: $(ctrl.business.bussinessphone).val(),
					email: $(ctrl.business.bussinessemail).val(),
					descb: $(ctrl.business.bussinessdesc).val()
				}
				$.ajax({
					url: ctrl.url,
					type: 'POST',
					data: {
						action: 'addbusiness',
						details: attr,
					},
					success: function(data, textStatus, xhr) {
						console.log(textStatus);
						data = $.trim(data);
						var det = $.parseJSON(data);
						if (det) {
							alert("Business has been Successfully Added");
							$(ctrl.business.form).get(0).reset();
							$(ctrl.business.viewbuzz).trigger('click');
						}
					},
					error: function() {
						alert("NO INTERNET CONNECTION!!! please connect to internet.");
					},
					complete: function(xhr, textStatus) {}
				});
			}
		};
		function fetchBusiness() {
			$.ajax({
				url: ctrl.url,
				type: 'POST',
				data: {
					action: 'fetchbusiness'
				},
				success: function(data, textStatus, xhr) {
					data = $.trim(data);
					var det = $.parseJSON(data);
					if (det.status == "success") {
						$(ctrl.business.displaybusiness).html(det.data);
						window.setTimeout(function() {
							for (i = 0; i < det.buzzids.length; i++) {
								$('#delbuzz_' + det.buzzids[i]).bind('click', {
									tbid: det.buzzids[i]
								}, function(event) {
									var bid = event.data.tbid;
									if (confirm("Are you sure to Delete this Post?")) {
										deleteBusinessPost(bid);
									}
								});
							}
						}, 400)
					} else {
						$(ctrl.business.displaybusiness).html('<span class="text-danger"><strong>no records</strong></span>');
					}
				},
				error: function() {
					alert("NO INTERNET CONNECTION!!! please connect to internet.");
				},
				complete: function(xhr, textStatus) {}
			});
		};
		function fetchSponsorous() {
			$.ajax({
				url: ctrl.url,
				type: 'POST',
				data: {
					action: 'fetchspons'
				},
				success: function(data, textStatus, xhr) {
					data = $.trim(data);
					var det = $.parseJSON(data);
					if (det.status == "success") {
						$(ctrl.sponsorous.displaysopnsopers).html(det.data);
						window.setTimeout(function() {
							for (i = 0; i < det.sponids.length; i++) {
								$('#delsponz_' + det.sponids[i]).bind('click', {
									tbid: det.sponids[i]
								}, function(event) {
									var bid = event.data.tbid;
									if (confirm("Are you sure to Delete this Post?")) {
										deleteSponsorusPost(bid);
									}
								});
							}
						}, 400)
					} else {
						$(ctrl.sponsorous.displaysopnsopers).html('<span class="text-danger"><strong>no records</strong></span>');
					}
				},
				error: function() {
					alert("NO INTERNET CONNECTION!!! please connect to internet.");
				},
				complete: function(xhr, textStatus) {}
			});
		};
		function deleteBusinessPost(bid) {
			$.post(AJAX, {
				bid: bid,
				action: 'deletebuzz'
			}, function(res) {
				if (res) {
					alert("Post has been Successfully Deleted");
					fetchBusiness();
				}
			});
		}
		function deleteNEWSPost(bid) {
			$.post(AJAX, {
				bid: bid,
				action: 'deletenews'
			}, function(res) {
				if (res) {
					alert("Post has been Successfully Deleted");
					fetchNEWS();
				}
			});
		}
		function deleteSponsorusPost(bid) {
			$.post(AJAX, {
				bid: bid,
				action: 'deletsponz'
			}, function(res) {
				if (res) {
					alert("Post has been Successfully Deleted");
					fetchSponsorous();
				}
			});
		}
	};