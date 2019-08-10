function dashController() {
    var members = {};
	var totalSales = 0;
    this.__constructor = function (para) {
        members = para;
    };
    this.__productSaleList = function () {
        saleList({source: members.SaleList, fields: members.SaleList.fields, index: 0});
    };
    function saleList(attr) {
        var prod = attr.source;
        var fields = attr.fields;
        var datatable = {};
        window.setTimeout(function () {
            datatable = $('#' + fields[0]).DataTable({
                processing: true,
                serverSide: true,
				pageLength: 10,
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
						//autoPrint: false,
						customize: function ( win ) {
							$(win.document.body)
								.css( 'font-size', '10pt' )
								.prepend(
									'<center><h4>Total Sales </h4></center>'
								);
								
							$(win.document.body).find( 'table' )
								.addClass( 'compact' )
								.css( 'font-size', 'inherit' );
								
						$(win.document.body).find( 'table' )
							.append('<center><h4>Total Sales = Rs  '+totalSales +'/-</h4></center>');
						},
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
					{
						text: 'Reload',
						action: function ( e, dt, node, config ) {
							datatable.ajax.reload();
						}
					},
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
						//LogMessages(listusers);
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
                },
                columns: [
                    {data: '#', searchable: true, orderable: true},
                    {data: 'Reference', searchable: true, orderable: true},
                    {data: 'Total Items', searchable: true, orderable: true},
                    {data: 'Total Amount', searchable: true, orderable: true},
                    {data: 'Date', searchable: true, orderable: true},
                ],
				bDestroy: true,
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
						.column( 3 )
						.data()
						.reduce( function (a, b) {
							return Number(intVal(a) + intVal(b)).toFixed(2);
						}, 0 );
					// Total over this page
					pageTotal = api
						.column( 3, { page: 'current'} )
						.data()
						.reduce( function (a, b) {
							return Number(intVal(a) + intVal(b)).toFixed(2);
						}, 0 );
		 
					// Update footer
					$( api.column( 2 ).footer() ).html(
						'Rs  '+pageTotal +' ( Total Rs  '+ total +' total)'
					);
					totalSales = total;
				}
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
    }
    ;
}
$(document).ready(function () {
	var this_js_script = $("script[src$='Dashboard.js']");
	if (this_js_script) {
		var flag = this_js_script.attr('data-autoloader');
		if (flag === 'true') {
			LogMessages('I am In Dashboard');
			var para = getJSONIds({
				autoloader: true,
				action: 'getIdHolders',
				url: EGPCSURL + 'Dashboard/getIdHolders',
				type: 'POST',
				dataType: 'JSON'
			}).shop.dashbord;
			var obj = new dashController();
			obj.__constructor(para);
			obj.__productSaleList();
		}
		else {
			LogMessages('I am Out Sales');
		}
	}
});
