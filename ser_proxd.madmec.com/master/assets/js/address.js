	function Address(){
		this.addata = {
			url 			: null,
			outputDiv 		: null,
			country 		: null,
			countryCode             : null,
			province 		: null,
			provinceCode            : null,
			district 		: null,
			districtCode            : null,
			city_town 		: null,
			city_townCode           : null,
			st_loc 			: null,
			st_locCode 		: null,
			zipcode 		: null,
			lat 			: null,
			lon 			: null,
			codep 			: null,
			PCR_reg 		: null,
			countryId 		: null,
			provinceId 		: null,
			districtId 		: null,
			city_townId             : null,
			st_locId 		: null,
			timezone 		: null
		};
		var ipdata = {};
		var dccode = '91';
		var dpcode = '080';
		var url = '';
		var outputDiv = '';
		this.__construct = function(para){
			if(para.url != '' || para.url != null){
				url = para.url;
			}else{
				url = URL+MASTER+'address.php';
			}
			if(para.outputDiv != '' || para.outputDiv != null){
				outputDiv = para.outputDiv;
			}else{
				outputDiv = '#output';
			}
		};
		this.getIPData = function(usr){
			$.ajax({
				type:'POST',
				url:url,
				async:false,
				data:{autoloader:true,action:'getIPData'},
				success:function(data, textStatus, xhr){
					data = $.trim(data);
					console.log(xhr.status);
					switch(data){
						case 'logout':
							logoutAdmin({});
							break;
						case 'login':
							loginAdmin({});
							break;
						default:
							ipdata = $.parseJSON(data);
						break;
					}
				},
				error:function(){
					$(outputDiv).html(INET_ERROR);
				},
				complete: function(xhr, textStatus) {
					console.log(xhr.status);
				}
			});
			this.addata.country 		= ipdata.country;
			this.addata.countryCode 	= ipdata.countryCode;
			this.addata.PCR_reg 		= '';
			this.addata.province 		= ipdata.province;
			this.addata.provinceCode 	= ipdata.provinceCode;
			this.addata.district 		= ipdata.district;
			this.addata.districtCode 	= ipdata.districtCode;
			this.addata.city_town 		= ipdata.city_town;
			this.addata.city_townCode 	= ipdata.city_townCode;
			this.addata.lat 		= ipdata.lat;
			this.addata.lon 		= ipdata.lon;
			this.addata.timezone 		= ipdata.timezone;
			return ipdata;
		};
		this.fillAddressFields = function(usr){
			/* $(usr.add.address.country).val(ipdata.country);  */
			/* $(usr.add.address.province).val(ipdata.regionName);  */
			/* $(usr.add.address.district).val(ipdata.city);  */
			/* $(usr.add.address.city_town).val(ipdata.city);  */
			/* $(usr.add.address.zipcode).val(ipdata.zip);  */
			/* $(usr.add.address.pcode).val(dpcode);  */
			/* usr.add.address.countryCode = ipdata.countryCode;  */
			/* usr.add.address.provinceCode = ipdata.region;  */
			/* usr.add.address.lat = ipdata.lat;  */
			/* usr.add.address.lon = ipdata.lon;  */
			/* usr.add.address.timezone = ipdata.timezone;  */
			/* usr.add.address.cnumber.codep = dccode;  */
			/* usr.add.address.pcode = dpcode;  */
			/* usr.add.address.PCR_reg = ipdata.PCR; */
		};
		this.getCountry = function(){
			var cont = '';
			$.ajax({
				type:'POST',
				url:url,
				async:false,
				data:{autoloader:true,action:'getCountry'},
				success:function(data, textStatus, xhr){
					data = $.trim(data);
					console.log(xhr.status);
					switch(data){
						case 'logout':
							logoutAdmin({});
							break;
						case 'login':
							loginAdmin({});
							break;
						default:
							cont = $.parseJSON(data);
						break;
					}
				},
				error:function(){
					$(outputDiv).html(INET_ERROR);
				},
				complete: function(xhr, textStatus) {
					console.log(xhr.status);
				}
			});
			return cont;
		};
		this.getState = function(){
			var cont = '';
			$.ajax({
				type:'POST',
				url:url,
				async:false,
				data:{autoloader:true,action:'getState',addata:this.addata},
				success:function(data, textStatus, xhr){
					data = $.trim(data);
					console.log(xhr.status);
					switch(data){
						case 'logout':
							logoutAdmin({});
							break;
						case 'login':
							loginAdmin({});
							break;
						default:
							cont = $.parseJSON(data);
						break;
					}
				},
				error:function(){
					$(outputDiv).html(INET_ERROR);
				},
				complete: function(xhr, textStatus) {
					console.log(xhr.status);
				}
			});
			return cont;
		};
		this.getDistrict = function(){
			var cont = '';
			$.ajax({
				type:'POST',
				url:url,
				async:false,
				data:{autoloader:true,action:'getDistrict',addata:this.addata},
				success:function(data, textStatus, xhr){
					data = $.trim(data);
					console.log(xhr.status);
					switch(data){
						case 'logout':
							logoutAdmin({});
							break;
						case 'login':
							loginAdmin({});
							break;
						default:
							cont = $.parseJSON(data);
						break;
					}
				},
				error:function(){
					$(outputDiv).html(INET_ERROR);
				},
				complete: function(xhr, textStatus) {
					console.log(xhr.status);
				}
			});
			return cont;
		};
		this.getCity = function(){
			var cont = '';
			$.ajax({
				type:'POST',
				url:url,
				async:false,
				data:{autoloader:true,action:'getCity',addata:this.addata},
				success:function(data, textStatus, xhr){
					data = $.trim(data);
					console.log(xhr.status);
					switch(data){
						case 'logout':
							logoutAdmin({});
							break;
						case 'login':
							loginAdmin({});
							break;
						default:
							cont = $.parseJSON(data);
						break;
					}
				},
				error:function(){
					$(outputDiv).html(INET_ERROR);
				},
				complete: function(xhr, textStatus) {
					console.log(xhr.status);
				}
			});
			return cont;
		};
		this.getLocality = function(){
			var cont = '';
			$.ajax({
				type:'POST',
				url:url,
				async:false,
				data:{autoloader:true,action:'getLocality',addata:this.addata},
				success:function(data, textStatus, xhr){
					data = $.trim(data);
					console.log(xhr.status);
					switch(data){
						case 'logout':
							logoutAdmin({});
							break;
						case 'login':
							loginAdmin({});
							break;
						default:
							cont = $.parseJSON(data);
						break;
					}
				},
				error:function(){
					$(outputDiv).html(INET_ERROR);
				},
				complete: function(xhr, textStatus) {
					console.log(xhr.status);
				}
			});
			return cont;
		};
		this.setCountry = function(para){
			this.addata.country = para.Country;
			this.addata.countryCode = para.countryCode;
			this.addata.PCR_reg = para.PCR;
			this.addata.codep = para.Phone;
			$.ajax({
				type:'POST',
				url:url,
				async:false,
				data:{autoloader:true,action:'setCountry',addata:this.addata},
				success:function(data, textStatus, xhr){
					data = $.trim(data);
					console.log(xhr.status);
					switch(data){
						case 'logout':
							logoutAdmin({});
							break;
						case 'login':
							loginAdmin({});
							break;
						default:
							// set the session variables
						break;
					}
				},
				error:function(){
					$(outputDiv).html(INET_ERROR);
				},
				complete: function(xhr, textStatus) {
					console.log(xhr.status);
				}
			});
		};
		this.setState = function(para){
			this.addata.province = para.province;
			this.addata.provinceCode = para.provinceCode;
			this.addata.lat = para.lat;
			this.addata.lon = para.lon;
			this.addata.timezone = para.timezone;
			$.ajax({
				type:'POST',
				url:url,
				async:false,
				data:{autoloader:true,action:'setState',addata:this.addata},
				success:function(data, textStatus, xhr){
					console.log(xhr.status);
					switch(data){
						case 'logout':
							logoutAdmin({});
							break;
						case 'login':
							loginAdmin({});
							break;
						default:
							// set the session variables
						break;
					}
				},
				error:function(){
					$(outputDiv).html(INET_ERROR);
				},
				complete: function(xhr, textStatus) {
					console.log(xhr.status);
				}
			});
		};
		this.setDistrict = function(para){
			this.addata.district = para.district;
			this.addata.districtCode = para.districtCode;
			this.addata.lat = para.lat;
			this.addata.lon = para.lon;
			this.addata.timezone = para.timezone;
			$.ajax({
				type:'POST',
				url:url,
				async:false,
				data:{autoloader:true,action:'setDistrict',addata:this.addata},
				success:function(data, textStatus, xhr){
					console.log(xhr.status);
					switch(data){
						case 'logout':
							logoutAdmin({});
							break;
						case 'login':
							loginAdmin({});
							break;
						default:
							// set the session variables
						break;
					}
				},
				error:function(){
					$(outputDiv).html(INET_ERROR);
				},
				complete: function(xhr, textStatus) {
					console.log(xhr.status);
				}
			});
		};
		this.setCity = function(para){
			this.addata.city_town = para.city_town;
			this.addata.city_townCode = para.city_townCode;
			this.addata.lat = para.lat;
			this.addata.lon = para.lon;
			this.addata.timezone = para.timezone;
			$.ajax({
				type:'POST',
				url:url,
				async:false,
				data:{autoloader:true,action:'setCity',addata:this.addata},
				success:function(data, textStatus, xhr){
					console.log(xhr.status);
					switch(data){
						case 'logout':
							logoutAdmin({});
							break;
						case 'login':
							loginAdmin({});
							break;
						default:
							// set the session variables
						break;
					}
				},
				error:function(){
					$(outputDiv).html(INET_ERROR);
				},
				complete: function(xhr, textStatus) {
					console.log(xhr.status);
				}
			});
		};
		this.setLocality = function(para){
			this.addata.st_loc = para.city_town;
			this.addata.st_locCode = para.city_townCode;
			this.addata.lat = para.lat;
			this.addata.lon = para.lon;
			this.addata.timezone = para.timezone;
			$.ajax({
				type:'POST',
				url:url,
				async:false,
				data:{autoloader:true,action:'setLocality',addata:this.addata},
				success:function(data, textStatus, xhr){
					console.log(xhr.status);
					switch(data){
						case 'logout':
							logoutAdmin({});
							break;
						case 'login':
							loginAdmin({});
							break;
						default:
							// set the session variables
						break;
					}
				},
				error:function(){
					$(outputDiv).html(INET_ERROR);
				},
				complete: function(xhr, textStatus) {
					console.log(xhr.status);
				}
			});
		};
	}
	$(document).ready(function(){
	});