function saleController() {
    var members = {};
    var price = {};
    var slaesListItems = new Array();
    var slaesListItemsDT = null;
	var cKGPrd = {};
	var cUNPrd = {};
	var totalSales = 0;
    var rowId = Number(slaesListItems.length);
    //var slaesListItemsDB = new Array();
    this.__constructor = function (para) {
        members = para;
    };
    this.__productSaleKg = function () {
        bindProductInKgEvents();
        productSearch({source: members.ProductKg.searchProduct, fields: members.ProductKg.fields, index: 0});
    };
    this.__productSaleUnit = function () {
        bindProductInUnitEvents();
        productSearch({source: members.ProductUnit.searchProduct, fields: members.ProductUnit.fields, index: 0});
    };
    this.__productSaleList = function () {
        //saleList({source: members.SaleList, fields: members.SaleList.fields, index: 0});
    };
    function bindProductInKgEvents() {
        var mem = members.ProductKg;
        var fields = members.ProductKg.fields;
        var params = {debug: false, rules: {}, messages: {}};
        var form = $('#' + mem.form);
        var checkusr = 0;
        form.on('keyup', function (e) {
            var code = Number(e.keyCode || e.which);
            if (code === 13) {
                e.preventDefault();
                return false;
            }
        });
        for (i = 0; i < fields.length; i++) {
            var field = $('#' + fields[i]).attr("name");
            var rules = $('#' + field).attr("data-rules");
            var messages = $('#' + field).attr("data-messages");
            if (rules.length > 0 && messages.length > 0) {
                rules = $.parseJSON(rules);
                messages = $.parseJSON(messages);
                params['rules'][field] = rules;
                params['messages'][field] = messages;
            }
        }
        params['submitHandler'] = function () {
            checkusr = 1;
        }
        ;
        params['invalidHandler'] = function () {
            checkusr = 0;
        };
        $(form).validate(params);
        $('#' + fields[1]).bind('click, keyup', function () {
            var kg = Number($(this).val());
			if (kg < 0) {
				kg = 0;
			}
            $(this).val(kg);
        });
        $('#' + fields[2]).bind('click, keyup', function () {
            var gm = Number($.trim($(this).val()));
            if (typeof gm == 'number') {
                if (gm > 999) {
                    gm = 0;
                }
                else if (gm < 0) {
                    gm = 0;
                }
            }
            $(this).val(gm);
        });
        $(form).submit(function (e) {
            if (checkusr) {
                var kg = Number($.trim($('#' + fields[1]).val()));
                var gm = Number($.trim($('#' + fields[2]).val()));
                var cost = Number(cKGPrd.cost).toFixed(2);
				var cgm = Number(gm / 1000).toFixed(3);
				LogMessages('grams = '+ cgm);
				var ckg = Number(kg) + Number(cgm);
				LogMessages('total = '+ ckg);
                var amt = Number(ckg * cost).toFixed(2);
                if ((kg > 0) || (gm > 0 && gm < 1000)) {
                    rowId += 1;
					var idDB = Number($('#' + fields[0]).val());
                    slaesListItems.push({
                        "No": rowId,
                        "Name": cKGPrd.name,
                        "Cost": cost+'/-',
                        "Quantity": kg + ' Kgs, ' + gm + ' Grams.',
                        "Amount": amt+'/-',
                        //"Delete": '<a href="javascript:void(0);" data-delProductID="' + rowId + '" id="delProductID_' + rowId + ' target="_self" class="btn btn-block btn-danger delProductID">Delete<a>',
                        "idDB": idDB,
                        "amtDB": amt,
                        "ctDB": cost,
                        "wtDB": ckg,
                        "kgDB": kg,
                        "gramsDB": gm,
                        "btnid": '#delProductID_' + rowId,
                    });
                    $(form).get(0).reset();
                    createDataTable({source: members.SaleList, fields: members.SaleList.fields, index: 0});
                }
            }
            else {
                alert('Please correct the credentials..');
            }
        });
    }
    ;
    function bindProductInUnitEvents() {
        var mem = members.ProductUnit;
        var fields = members.ProductUnit.fields;
        var params = {debug: false, rules: {}, messages: {}};
        var form = $('#' + mem.form);
        var checkusr = 0;
        form.on('keyup', function (e) {
            var code = Number(e.keyCode || e.which);
            if (code === 13) {
                e.preventDefault();
                return false;
            }
        });
        for (i = 0; i < fields.length; i++) {
            var field = $('#' + fields[i]).attr("name");
            var rules = $('#' + field).attr("data-rules");
            var messages = $('#' + field).attr("data-messages");
            if (rules.length > 0 && messages.length > 0) {
                rules = $.parseJSON(rules);
                messages = $.parseJSON(messages);
                params['rules'][field] = rules;
                params['messages'][field] = messages;
            }
        }
        params['submitHandler'] = function () {
            checkusr = 1;
        }
        ;
        params['invalidHandler'] = function () {
            checkusr = 0;
            alert('Please correct the credentials..');
        };
        $(form).validate(params);
        $('#' + fields[1]).bind('click, keyup', function () {
            var un = Number($.trim($(this).val()));
            $(this).val(un);
        });
        $(form).submit(function (e) {
            if (checkusr) {
                var un = Number($.trim($('#' + fields[1]).val()));
                var cost = Number(cUNPrd.cost).toFixed(2);
                var amt = Number(un * cost).toFixed(2);
                if (un > 0) {
                    rowId += 1;
					var idDB = Number($('#' + fields[0]).val());
                    slaesListItems.push({
                        "No": rowId,
                        "Name": cUNPrd.name,
                        "Cost": cost+'/-',
                        "Quantity": un + ' Units.',
                        "Amount": amt+'/-',
                        //"Delete": '<a href="javascript:void(0);" data-delProductID="' + rowId + '" id="delProductID_' + rowId + ' target="_self" class="btn btn-block btn-danger delProductID">Delete<a>',
                        "idDB": idDB,
                        "wtDB": un,
                        "amtDB": amt,
                        "ctDB": cost,
                        "btnid": '#delProductID_' + rowId,
                    });
                    $(form).get(0).reset();
                    createDataTable({source: members.SaleList, fields: members.SaleList.fields, index: 0});
                }
            }
        });
    }
    ;
    function createDataTable(attr) {
        var prod = attr.source;
        var fields = attr.fields;
		var rid = generateRandomString();
        slaesListItemsDT = $('#' + fields[0]).DataTable({
            aaData: slaesListItems,
			pageLength: -1,
			scrollY:480,
			scrollX:false,
			deferRender:true,
			scroller:true,
			//responsive:true,
			//stateSave: true,
			dom: 'Bf<"top"ip>rt<"clear">',
			lengthMenu: [
				[ 10, 25, 50, -1 ],
				[ '10 item', '25 item', '50 item', 'Show all' ],
			],
			buttons: [
				{
					extend: 'print',
					exportOptions: {
						columns: ':visible'
					},
					key: {
						key: 'p',
						altKey: true
					},
					customize: function ( win ) {
						$(win.document.body)
							.css( 'font-size', '10pt' )
							.prepend(
								'<center><h4>Estimated Bill - '+ rid +'</h4></center>'
							);
							
						$(win.document.body).find( 'table' )
							.addClass( 'compact' )
							.css( 'font-size', 'inherit' );
							
						$(win.document.body).append('<center><h4>Total = Rs  '+totalSales +'/-</h4></center>');
					},
					//autoPrint: false,
				},
				{
					text: 'Save',
					action: function ( e, dt, node, config ) {
						if(slaesListItems.length > 0 && rid.length > 0){
							slaesListItems.push({RID:rid});
							slaesListItems.push({Amount:totalSales});
							AddDB({jsonattr: members.BillGenerate, attr: {attr:slaesListItems}});
							/* Reset */
							//slaesListItemsDT.destroy();
							slaesListItemsDT.clear().draw();
							slaesListItems = new Array();
							rowId = totalSales = 0;
						}
					}
				},
				{
					text: 'Delete Row',
					action: function ( e, dt, node, config ) {
						var index = slaesListItemsDT.row('.selected').index();
						slaesListItems.splice(index, 1);
						slaesListItemsDT.row('.selected').remove().draw(false);
						for(i=0,j=1;i<slaesListItems.length;i++,j++){
							slaesListItems[i].No = j;
						}
						rowId = slaesListItems.length;
						createDataTable({
							source: prod, 
							fields: prod.fields, 
							index: 0,
						});
						return;
					}
				},
				{
					extend: 'colvis',
					text: 'Columns',
					postfixButtons: [ 'colvisRestore' ],
				},
				{
					extend: 'pageLength',
					text: 'Rows',
				},
			],
			/*
				{
					extend: 'collection',
					text: 'Export Table',
					autoClose: true,
					buttons: [
						{
							extend: 'print',
							exportOptions: {
								columns: ':visible'
							},
							key: {
								key: 'p',
								altKey: true
							},
						},
						{
							extend: 'pdfFlash',
							exportOptions: {
								columns: ':visible'
							},
						},
						{
							extend: 'csvFlash',
							exportOptions: {
								columns: ':visible'
							},
						},
						{
							extend: 'excelFlash',
							exportOptions: {
								columns: ':visible'
							},
						},
						{
							extend: 'copyFlash',
							exportOptions: {
								columns: ':visible'
							},
						},
					],
				},
			*/
            columns: [
                {data: 'No', searchable: true, orderable: true},
                {data: 'Name', searchable: true, orderable: true},
                {data: 'Cost', searchable: true, orderable: true},
                {data: 'Quantity', searchable: true, orderable: true},
                {data: 'Amount', searchable: true, orderable: true},
                //{data: 'Delete', searchable: false, orderable: false},
            ],
            bDestroy: true,
			initComplete: function (settings, json) {
				$('#' + fields[0] +' tbody').children('tr').each(function(){
					$(this).click(function(evt){
						$(this).addClass('selected');
						$(this).css({backgroundColor:'#ff0000'});
						$(this).siblings('tr').each(function(){
							$(this).removeClass('selected');
							$(this).css({backgroundColor:'#ffffff'});
						});
					});
				});
			},
			createdRow: function (row, data, dataIndex) {
				if (data) {
					//LogMessages(data);
				}
			},
			footerCallback: function ( row, data, start, end, display ) {
				var api = this.api(), data;
				// Remove the formatting to get integer data for summation
				var intVal = function ( i ) {
					return typeof i === 'string' ?
						i.replace('/-', '')*1 :
						typeof i === 'number' ?
							i : 0;
				};
				// Total over all pages
				total = api
					.column( 4 )
					.data()
					.reduce( function (a, b) {
						return Number(intVal(a) + intVal(b)).toFixed(2);
					}, 0 );
				// Total over this page
				pageTotal = api
					.column( 4, { page: 'current'} )
					.data()
					.reduce( function (a, b) {
						return Number(intVal(a) + intVal(b)).toFixed(2);
					}, 0 );
	 
				// Update footer
				$( api.column( 2 ).footer() ).html(
					//'Rs  '+total +' ( Total Rs  '+ total +' total)'
					'Rs  '+total +'/- total)'
				);
				totalSales = total;
			}
        });
		/*
		window.setTimeout(function(){
			$('.delProductID').each(function(){
				if($(this).hasClass('binded') == false){
					$(this).addClass('binded');
					$(this).click(function (evt) {
						evt.preventDefault();
						var id = Number($(this).attr('data-delProductID'));
						var index = 0;
						for(i=0;i<slaesListItems.length;i++){
							if(id == i){
								index = i;
								break;
							}
						}
						slaesListItems.splice(index, 1);
						rowId -= 1;
						createDataTable({
							source: prod, 
							fields: prod.fields, 
							index: 0,
						});
						return;
					});
				}
			});
		},1000);
		*/
    }
    ;
    function AddDB(jdata) {
        var mem = jdata.jsonattr;
        var attr = jdata.attr;
        var form = $('#' + mem.form);
        var obj = {};
        $.ajax({
            url: mem.url,
            type: mem.type,
            dataType: mem.dataType,
            //processData: mem.processData,
            //contentType: mem.contentType,
            data: attr,
			async:false,
            success: function (data, textStatus, xhr) {
                if (typeof data === 'object') {
                    obj = data;
                }
                else {
                    obj = $.parseJSON($.trim(data));
                }
                if (obj.status === "success") {
					alert('Bill saved');
                }
                else if (obj.status === "alreadyexist") {
                    alert('Not Added, Enter diferent entries');
                }
                else if (obj.status === "error") {
                    alert('Wrong Entries');
                }
            },
            error: function () {
            },
            complete: function (xhr, textStatus) {
            }
        });
    }
    ;
    function saleList(attr) {
        var prod = attr.source;
        var fields = attr.fields;
        var datatable = {};
        window.setTimeout(function () {
            datatable = $('#' + fields[0]).DataTable({
                processing: true,
                serverSide: true,
                dom: 'Bfliptr',
                scrollY: '50vh',
                buttons: [
                    {
                        extend: 'print',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    'colvis'
                ],
                columnDefs: [{
                        targets: 0,
                        visible: true
                    }
                ],
                ajax: {
                    url: prod.url,
                    dataType: prod.dataType,
                    type: prod.type,
                    //processData: users.processData,
                    //contentType: users.contentType,
                    data: function (d) {
                        d.autoloader = true;
                        d.action = prod.url;
                    },
                },
                createdRow: function (row, data, dataIndex) {
                    if (data) {
                        var listusers = data;
//                        LogMessages(listusers);
                    }
                },
                initComplete: function (settings, json) {
                    var data = json.data;
                    if (data) {
                        switch (data) {
                            case 'logout':
                                logoutAdmin({});
                                break;
                            case 'login':
                                loginAdmin({});
                                break;
                            default:
                                $('#' + fields[0]).css('width', '100%');
                                break;
                        }
                    }
                    else {
                        alert('Unable to list Products.');
                    }
                },
                preDrawCallback: function (settings) {
                    $('#' + fields[0]).css('width', '100%');
                },
                drawCallback: function (settings) {
                    $('#' + fields[0]).css('width', '100%');
                    $(".deactivate").each(function () {
                        $(this).click(function (evt) {
                            evt.preventDefault();
                            var id = $(this).attr("data-delProduct");
                            chageFOPStatus({jsonattr: prod.deactivate, attr: {fopid: id, stat: 6}});
                            datatable.ajax.reload(null, false);
                        });
                    });
                },
                columns: [
                    {data: '#', searchable: true, orderable: true},
                    {data: 'Name', searchable: true, orderable: true},
                    {data: 'Cost', searchable: true, orderable: true},
                    {data: 'Quantity', searchable: true, orderable: true},
                    {data: 'Amount', searchable: true, orderable: true},
                    {data: 'Delete', searchable: false, orderable: false}
                ]
            });
            $(".dataTables_filter input").each(function () {
                var attr = $(this).attr("aria-controls");
                if (attr === fields[0]) {
                    $(this).attr("placeholder", "Enter search terms here");
                    var id = fields[0] + "_cont1";
                    //aria-controls="fieldCurr1"
                    $(this).attr("id", id);
                    $('#' + id).bind("input", {
                        dtable: $('#' + fields[0]).dataTable().api()
                    }, function (e) {
                        var dtable = e.data.dtable;
                        if (this.value.length >= 2 || e.keyCode == 13) {
                            dtable.search(this.value).draw();
                        }
                        if (this.value == "") {
                            dtable.search("").draw();
                        }
                        return;
                    });
                    return;
                }
            });
        }, 600);
        $('#' + prod.btnDiv).click(function () {
            datatable.ajax.reload(null, false);
        });
    }
    ;
    function productSearch(attr) {
        var prod = attr.source;
        var fields = attr.fields;
		var productList = {};
        $('#' + fields[attr.index]).select2({
            ajax: {
                url: prod.url,
                dataType: prod.dataType,
                type: prod.type,
                delay: 250,
                data: function (params) {
                    return {
                        autoloader: prod.autoloader,
                        action: prod.action,
                        q: params.term,
                        page: params.page,
                        listtype: prod.listtype,
                        loadProd: prod.loadProd,
                    };
                },
                processResults: function (data, params) {
					productList = data.items;
                    params.page = params.page || 1;
                    return {
                        results: data.items,
                        pagination: {
                            more: (params.page * 30) < data.total_count
                        }
                    };
                },
                cache: true,
            },
            escapeMarkup: function (markup) {
                return markup;
            },
            maximumSelectionLength: -1,
            placeholder: "Search your Products - " + prod.loadProd,
            allowClear: true,
            minimumInputLength: 1,
            templateResult: formatRepo,
            templateSelection: formatRepoSelection,
            width: '100%',
        });
		var $eventSelect = $('#' + fields[attr.index]);
		$eventSelect.on("change", function (e) {
			$eventSelect.select2("close");
			if (prod.loadProd == "Per Unit") {
				$('#' + fields[attr.index]).each(function (i, selected) {
					for(i=0;i<productList.length;i++){
						if(Number($('#' + fields[attr.index]).val()) == Number(productList[i].id)){
							cUNPrd = productList[i];
							break;
						}
					}
					return;
				});
			}
			if (prod.loadProd == "Per Kg") {
				$('#' + fields[attr.index]).each(function (i, selected) {
					for(i=0;i<productList.length;i++){
						if(Number($('#' + fields[attr.index]).val()) == Number(productList[i].id)){
							cKGPrd = productList[i];
							break;
						}
					}
					return;
				});
			}
		});
    }
    ;
    function formatRepo(repo) {
        if (repo.loading)
            return repo.text;
        var markup = '<ul class="products-list product-list-in-box" id="listitem_' + repo.id + '">' +
                '<li class="item">' +
                '<div class="product-info">' +
                '<a class="product-title" href="javascript::;">' + repo.name + ' ' + repo.cost + '<span class="label label-warning pull-right">' + repo.cost + '/- </span></a>' +
                '</div>' +
                '</li>' +
                '</ul>' +
                '';
        return markup;
    }
    ;
    function formatRepoSelection(repo) {
        return repo.full_name || repo.text;
    }
    ;
}
$(document).ready(function () {
	var this_js_script = $("script[src$='Sales.js']");
	if (this_js_script) {
		var flag = this_js_script.attr('data-autoloader');
		if (flag === 'true') {
			LogMessages('I am In Sales');
			var para = getJSONIds({
				autoloader: true,
				action: 'getIdHolders',
				url: EGPCSURL + 'Sales/getIdHolders',
				type: 'POST',
				dataType: 'JSON'
			}).shop.sales;
			var obj = new saleController();
			obj.__constructor(para);
			obj.__productSaleKg();
			obj.__productSaleUnit();
		}
		else {
			LogMessages('I am Out Sales');
		}
	}
});
