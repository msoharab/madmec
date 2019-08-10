	function requirementController() {
	    var Requi = {};
	    var units = '';
	    var ethno = {};
	    var client = {};
	    var cperson = {};
	    var particulars = [];
	    var par = {};
	    var del = {};
	    var painting = [];
	    var paint = {};
	    var block = {};
	    var floor = {};
	    var pdesc = {};
	    var list = {};
	    this.__construct = function(reqctrl) {
	        Requi = reqctrl;
	        paint = Requi.paint;
	        block = Requi.paint.block;
	        floor = Requi.paint.floor;
	        pdesc = Requi.paint.desc;
	        par = Requi.add.part;
	        del = Requi.add.dein;
	        list = Requi.list;
	        $(Requi.msgDiv).html('');
	        fetchUnits();
	        $(par.plus).unbind();
	        $(list.menuBut).click(function() {
	            listDoc();
	        });
	        $(par.plus).click(function(evt) {
	            evt.stopPropagation();
	            evt.preventDefault();
	            $(this).hide();
	            addMultiplePart();
	        });
	        $(block.plus).on('click', function(evt) {
	            evt.stopPropagation();
	            evt.preventDefault();
	            $(block.parentDiv).html('');
	            $(this).hide();
	            addMultipleBlock();
	        });
	        /* Ethnographer Project */
	        fetchUsers({
	            type: [1, 2, 4, 5, 6, 9],
	            para1: {
	                ob: Requi.add,
	                parentDiv: Requi.add.ethno,
	                id: Requi.add.ethno_type,
	                msg: Requi.add.ethno_msg,
	                text: 'Select Ethnographer'
	            },
	            para2: false
	        });
	        /* Client / Customer Project */
	        fetchUsers({
	            type: [14],
	            para1: {
	                ob: Requi.add,
	                parentDiv: Requi.add.client,
	                id: Requi.add.client_type,
	                msg: Requi.add.client_msg,
	                text: 'Select Client'
	            },
	            para2: {
	                ob: Requi.add,
	                parentDiv: Requi.add.cperson,
	                id: Requi.add.cperson_type,
	                msg: Requi.add.cperson_msg,
	                text: 'Select Representative'
	            }
	        });
	        $(Requi.add.doe).datepicker({
	            dateFormat: 'yy-mm-dd',
	            changeYear: true,
	            changeMonth: true
	        });
	        $(Requi.add.but).click(function(evt) {
	            evt.stopPropagation();
	            evt.preventDefault();
	            addRequirements();
	        });
	    };

	    function fetchUnits() {
	        var htm = '';
	        $.ajax({
	            type: 'POST',
	            url: Requi.add.url,
	            data: {
	                autoloader: true,
	                action: 'fetchUnits'
	            },
	            success: function(data, textStatus, xhr) {
	                data = $.trim(data);
	                switch (data) {
	                    case 'logout':
	                        logoutAdmin({});
	                        break;
	                    case 'login':
	                        loginAdmin({});
	                        break;
	                    default:
	                        units = $.parseJSON(data);
	                        if (units != null) {
	                            for (i = 0; i < units.length; i++) {
	                                htm += units[i]["html"];
	                            }
	                            units = htm;
	                        }
	                        break;
	                }
	            },
	            error: function() {
	                $(Requi.outputDiv).html(INET_ERROR);
	            },
	            complete: function(xhr, textStatus) {
	                console.log(xhr.status);
	            }
	        });
	    };

	    function addMultiplePart() {
	        if (par.num == -1) $(par.parentDiv).html('');
	        par.num++;
	        particulars.push({
	            num: par.num,
	            form: par.form + par.num,
	            bankname: par.bankname + par.num,
	            nmsg: par.nmsg + par.num,
	            accno: par.accno + par.num,
	            nomsg: par.nomsg + par.num,
	            braname: par.braname + par.num,
	            bnmsg: par.bnmsg + par.num,
	            deliinstarr: [],
	            plus: par.plus + par.num,
	            minus: par.minus + par.num
	        });
	        var html = '<div id="' + par.form + par.num + '">' +
	            '<div class="row">' +
	            '<div class="col-lg-12">' +
	            '<div class="panel panel-warning">' +
	            '<div class="panel-heading">' +
	            '<strong>Particulars ' + Number(par.num + 1) + '</strong>&nbsp;' +
	            '<button class="btn btn-danger  btn-md" id="' + par.minus + par.num + '"><i class="fa fa-minus fa-fw fa-x2"></i></button>&nbsp;' +
	            '<button class="btn btn-success  btn-md" id="' + par.plus + par.num + '"><i class="fa fa-plus fa-fw fa-x2"></i></button>' +
	            '</div>' +
	            '<div class="panel-body">' +
	            '<div class="row">' +
	            '<div class="col-lg-12">' +
	            '<div class="col-lg-4">' +
	            '<div class="col-lg-12">' +
	            '<strong><span class="text-warning"><i class="fa fa-star fa-fw"></i></span> Particular </strong>' +
	            '</div>' +
	            '<div class="col-lg-12">' +
	            '<textarea class="form-control" placeholder="Particular" name="' + par.bankname + par.num + '" id="' + par.bankname + par.num + '"></textarea>' +
	            '<p class="help-block" id="' + par.nmsg + par.num + '">Enter / Select</p>' +
	            '</div>' +
	            '</div>' +
	            '<div class="col-lg-4">' +
	            '<div class="col-lg-12">' +
	            '<strong><span class="text-warning"><i class="fa fa-star fa-fw"></i></span> Quantity </strong>' +
	            '</div>' +
	            '<div class="col-lg-12">' +
	            '<input class="form-control" placeholder="Quantity" name="' + par.accno + par.num + '" type="text" id="' + par.accno + par.num + '" maxlength="100" value="0" />' +
	            '<p class="help-block" id="' + par.nomsg + par.num + '">Enter / Select</p>' +
	            '</div>' +
	            '</div>' +
	            '<div class="col-lg-4">' +
	            '<div class="col-lg-12">' +
	            '<strong><span class="text-warning"><i class="fa fa-star fa-fw"></i></span> Unit </strong>' +
	            '</div>' +
	            '<div class="col-lg-12">' +
	            '<select class="form-control" name="' + par.braname + par.num + '" id="' + par.braname + par.num + '">' + units + '</select>' +
	            '<p class="help-block" id="' + par.bnmsg + par.num + '">Enter / Select</p>' +
	            '</div>' +
	            '</div>' +
	            '</div>' +
	            '<!-- row -->' +
	            '</div>' +
	            '<div class="row">' +
	            '<!-- Delivery & Installation -->' +
	            '<div class="col-lg-12">' +
	            '<div class="row">' +
	            '<div class="col-lg-12"> <strong><span class="text-danger"><i class="fa fa-star fa-fw"></i></span> Delivery & Installation </strong>&nbsp;' +
	            '<button class="text-primary btn btn-success  btn-md" name="' + par.num + '" id="' + del.plus + par.num + '"><i class="fa fa-plus fa-fw fa-x2"></i></button>&nbsp; ' +
	            '</div>' +
	            '<div class="col-lg-12" id="' + del.parentDiv + par.num + '">' +
	            '</div>' +
	            '</div>' +
	            '</div>' +
	            '<!-- Delivery & Installation -->' +
	            '</div>' +
	            '<!-- panel-body -->' +
	            '</div>' +
	            '<!-- panel-warning -->' +
	            '</div>' +
	            '<!-- col-lg-12 -->' +
	            '</div>' +
	            '<!-- row -->' +
	            '</div>' +
	            '<!-- parentDiv -->' +
	            '</div>';
	        $(html).appendTo($(par.parentDiv));
	        $(document.getElementById(par.minus + par.num)).click(function(evt) {
	            evt.stopPropagation();
	            evt.preventDefault();
	            $(document.getElementById(par.form + par.num)).remove();
	            par.num--;
	            if (par.num == -1) {
	                $(par.plus).show();
	                $(par.parentDiv).html('');
	                particulars = [];
	            } else {
	                $(document.getElementById(par.plus + par.num)).show();
	                $(document.getElementById(par.minus + par.num)).show();
	                particulars.pop();
	            }
	        });
	        $(document.getElementById(par.plus + par.num)).click(function(evt) {
	            evt.stopPropagation();
	            evt.preventDefault();
	            $(document.getElementById(par.plus + par.num)).hide();
	            $(document.getElementById(par.minus + par.num)).hide();
	            addMultiplePart();
	        });
	        window.setTimeout(function() {
	            // $(document.getElementById(del.plus+par.num)).click(function(event) {
	            // $(this).hide();
	            // addMultipleDelivi({pind:$(this).prop('name'),index:-1});
	            // });
	            $(document.getElementById(del.plus + par.num)).hide();
	            addMultipleDelivi({
	                pind: $(document.getElementById(del.plus + par.num)).prop('name'),
	                index: -1
	            });
	        }, 400);
	    };

	    function addMultipleDelivi(ind) {
	        var index = ind.index;
	        var pind = ind.pind;
	        console.log(pind);
	        if (index == -1) {
	            index = 0;
	            $(document.getElementById(del.parentDiv + pind)).html('');
	        } else {
	            index = Number(index + 1);
	        }
	        particulars[pind].deliinstarr[index] = {
	            parentDiv: del.parentDiv + pind + '_' + index,
	            num: index,
	            pind: pind,
	            form: del.form + pind + '_' + index,
	            bankname: del.bankname + pind + '_' + index,
	            nmsg: del.nmsg + pind + '_' + index,
	            accno: del.accno + pind + '_' + index,
	            nomsg: del.nomsg + pind + '_' + index,
	            plus: del.plus + pind + '_' + index,
	            minus: del.minus + pind + '_' + index
	        };
	        var html = '<div id="' + del.form + pind + '_' + index + '">' +
	            '<div class="col-lg-6">' +
	            '<div class="panel panel-info">' +
	            '<div class="panel-heading">' +
	            '<strong>Supply /  Installation ' + Number(index + 1) + '</strong>&nbsp;' +
	            '<button class="btn btn-danger btn-md" style="display:none;" id="' + del.minus + pind + '_' + index + '"><i class="fa fa-minus fa-fw fa-x2"></i></button>&nbsp;' +
	            '<button class="btn btn-success btn-md" style="display:none;" name="' + pind + '" id="' + del.plus + pind + '_' + index + '"><i class="fa fa-plus fa-fw fa-x2"></i></button>' +
	            '</div>' +
	            '<div class="panel-body">' +
	            '<div class="row">' +
	            '<div class="col-lg-6">' +
	            '<div class="col-lg-12">' +
	            '<strong><span class="text-warning"><i class="fa fa-star fa-fw"></i></span> Supply </strong>' +
	            '</div>' +
	            '<div class="col-lg-12">';
	        if (index % 2 == 0)
	            html += '<input class="form-control" placeholder="Supply" name="' + del.bankname + pind + '_' + index + '" type="text" id="' + del.bankname + pind + '_' + index + '" maxlength="100" value="0" />';
	        else
	            html += '<input class="form-control" placeholder="Supply" name="' + del.bankname + pind + '_' + index + '" type="text" id="' + del.bankname + pind + '_' + index + '" maxlength="100" readonly="" value="0" />';
	        html += '<p class="help-block" id="' + del.nmsg + pind + '_' + index + '">Enter / Select</p>' +
	            '</div>' +
	            '</div>' +
	            '<div class="col-lg-6">' +
	            '<div class="col-lg-12">' +
	            '<strong><span class="text-warning"><i class="fa fa-star fa-fw"></i></span> Installation </strong>' +
	            '</div>' +
	            '<div class="col-lg-12">';
	        if (index % 2 == 0)
	            html += '<input class="form-control" placeholder="Installation" name="' + del.accno + pind + '_' + index + '" type="text" id="' + del.accno + pind + '_' + index + '" maxlength="100" value="0"/>';
	        else
	            html += '<input class="form-control" placeholder="Installation" name="' + del.accno + pind + '_' + index + '" type="text" id="' + del.accno + pind + '_' + index + '" readonly="" maxlength="100" value="0"/>';
	        html += '<p class="help-block" id="' + del.nomsg + pind + '_' + index + '">Enter / Select</p>' +
	            '</div>' +
	            '</div>' +
	            '</div>' +
	            '</div>' +
	            '</div>' +
	            '</div>' +
	            '</div>';
	        $(html).appendTo($(document.getElementById(del.parentDiv + pind)));
	        $(document.getElementById(del.minus + pind + '_' + index)).click(function(evt) {
	            evt.stopPropagation();
	            evt.preventDefault();
	            $(document.getElementById(del.form + pind + '_' + index)).remove();
	            particulars[pind].deliinstarr[index].num--;
	            var num = particulars[pind].deliinstarr[index].num;
	            if (num == -1) {
	                $(document.getElementById(del.plus + pind)).show();
	                $(document.getElementById(del.parentDiv)).html('');
	                particulars[pind].deliinstarr = [];
	            } else {
	                $(document.getElementById(del.plus + pind + '_' + num)).show();
	                $(document.getElementById(del.minus + pind + '_' + num)).show();
	                particulars[pind].deliinstarr.pop();
	            }
	        });
	        $(document.getElementById(del.plus + pind + '_' + index)).click(function(evt) {
	            evt.stopPropagation();
	            evt.preventDefault();
	            // var pind = $(this).prop('name');
	            $(document.getElementById(del.plus + pind + '_' + index)).hide();
	            $(document.getElementById(del.minus + pind + '_' + index)).hide();
	            addMultipleDelivi({
	                pind: pind,
	                index: index
	            });
	        });
	        window.setTimeout(function() {
	            if (Number(index) < 1) {
	                $(document.getElementById(del.bankname + pind + '_' + index)).on('keyup', function() {
	                    var qty = Number($(document.getElementById(par.accno + pind)).val()) < 0 ? 0 : Number($(document.getElementById(par.accno + pind)).val());
	                    var val = Number($(this).val()) < 0 ? 0 : Number($(this).val());
	                    $(this).val(val);
	                    var tot = Number(qty * val);
	                    $(document.getElementById(del.bankname + pind + '_' + Number(index + 1))).val(tot);
	                });
	                $(document.getElementById(del.accno + pind + '_' + index)).on('keyup', function() {
	                    var qty = Number($(document.getElementById(par.accno + pind)).val()) < 0 ? 0 : Number($(document.getElementById(par.accno + pind)).val());
	                    var val = Number($(this).val()) < 0 ? 0 : Number($(this).val());
	                    $(this).val(val);
	                    var tot = Number(qty * val);
	                    $(document.getElementById(del.accno + pind + '_' + Number(index + 1))).val(tot);
	                });
	                $(document.getElementById(par.accno + pind)).on('keyup', function() {
	                    var qty0 = Number($(document.getElementById(par.accno + pind)).val()) < 0 ? 0 : Number($(document.getElementById(par.accno + pind)).val());
	                    $(document.getElementById(par.accno + pind)).val(qty0);
	                    var val0 = Number($(document.getElementById(del.bankname + pind + '_' + index)).val()) < 0 ? 0 : Number($(document.getElementById(del.bankname + pind + '_' + index)).val());
	                    $(document.getElementById(del.bankname + pind + '_' + index)).val(val0);
	                    var tot0 = Number(qty0 * val0);
	                    $(document.getElementById(del.bankname + pind + '_' + Number(index + 1))).val(tot0);
	                    var val1 = Number($(document.getElementById(del.accno + pind + '_' + index)).val()) < 0 ? 0 : Number($(document.getElementById(del.accno + pind + '_' + index)).val());
	                    $(document.getElementById(del.accno + pind + '_' + index)).val(val1);
	                    var tot1 = Number(qty0 * val1);
	                    $(document.getElementById(del.accno + pind + '_' + Number(index + 1))).val(tot1);
	                });
	                addMultipleDelivi({
	                    pind: pind,
	                    index: index
	                });
	            } else {
	                return;
	            }
	            // $(document.getElementById(del.parentDiv+pind)).find('input').each(function(){
	            // $(this).on('focus',function(event){
	            // $(this).val('');
	            // });
	            // });
	        }, 800);
	    };

	    function addMultipleBlock() {
	        if (block.num == -1) $(block.parentDiv).html('');
	        block.num++;
	        painting.push({
	            num: block.num,
	            form: block.form + block.num,
	            bankname: block.bankname + block.num,
	            nmsg: block.nmsg + block.num,
	            floorarr: [],
	            plus: block.plus + block.num,
	            minus: block.minus + block.num
	        });
	        var html = '';
	        html = '<!-- Block -->' +
	            '<div id="' + block.form + block.num + '">' +
	            '<div class="panel panel-default">' +
	            '<div class="panel-heading">' +
	            '<strong>Block ' + Number(block.num + 1) + '</strong>&nbsp;' +
	            '<button class="btn btn-danger  btn-md" id="' + block.minus + block.num + '"><i class="fa fa-minus fa-fw fa-x2"></i></button>&nbsp;' +
	            '<button class="btn btn-success  btn-md" id="' + block.plus + block.num + '"><i class="fa fa-plus fa-fw fa-x2"></i></button>' +
	            '</div>' +
	            '<div class="panel-body">' +
	            '<div class="row">' +
	            '<div class="col-lg-12">' +
	            '<input class="form-control" name="crname" type="text" id="' + block.bankname + block.num + '" maxlength="100" value="Block ' + Number(block.num + 1) + '"/>' +
	            '<p class="help-block" id="' + block.nmsg + block.num + '">Enter / Select</p>' +
	            '</div>' +
	            '</div>' +
	            '<!-- Floor -->' +
	            '<div class="row">' +
	            '<div class="col-lg-12"> <strong><span class="text-danger"><i class="fa fa-star fa-fw"></i></span> Floor </strong>&nbsp;' +
	            '<button class="text-primary btn btn-success  btn-md" name="' + block.num + '" id="' + floor.plus + block.num + '"><i class="fa fa-plus fa-fw fa-x2"></i></button>&nbsp; ' +
	            '</div>' +
	            '<div class="col-lg-12" id="' + floor.parentDiv + block.num + '">' +
	            '</div>' +
	            '</div>' +
	            '<!-- Floor -->' +
	            '</div>' +
	            '</div>' +
	            '</div>' +
	            '</div>' +
	            '<!-- Block -->';
	        $(html).appendTo($(block.parentDiv));
	        // window.setTimeout(function() {
	        $(document.getElementById(floor.plus + block.num)).click(function(evt) {
	            evt.stopPropagation();
	            evt.preventDefault();
	            $(this).hide();
	            addMultipleFloor({
	                pind: $(this).prop('name'),
	                index: -1
	            });
	        });
	        $(document.getElementById(block.minus + block.num)).click(function(evt) {
	            evt.stopPropagation();
	            evt.preventDefault();
	            $(document.getElementById(block.form + block.num)).remove();
	            block.num--;
	            if (block.num == -1) {
	                $(block.plus).show();
	                $(block.parentDiv).html('');
	                painting = [];
	            } else {
	                $(document.getElementById(block.plus + block.num)).show();
	                $(document.getElementById(block.minus + block.num)).show();
	                painting.pop();
	            }
	        });
	        $(document.getElementById(block.plus + block.num)).click(function(evt) {
	            evt.stopPropagation();
	            evt.preventDefault();
	            $(this).unbind();
	            $(document.getElementById(block.plus + block.num)).hide();
	            $(document.getElementById(block.minus + block.num)).hide();
	            addMultipleBlock();
	        });
	        // }, 200);
	    };

	    function addMultipleFloor(ind) {
	        var index = ind.index;
	        var pind = ind.pind;
	        if (index == -1) {
	            index = 0;
	            $(document.getElementById(floor.parentDiv + pind)).html('');
	        } else {
	            index = Number(index + 1);
	        }
	        painting[pind].floorarr[index] = {
	            parentDiv: floor.parentDiv + pind + '_' + index,
	            num: index,
	            pind: pind,
	            form: floor.form + pind + '_' + index,
	            bankname: floor.bankname + pind + '_' + index,
	            nmsg: floor.nmsg + pind + '_' + index,
	            descarr: [],
	            plus: floor.plus + pind + '_' + index,
	            minus: floor.minus + pind + '_' + index
	        };
	        var html = '<!-- Floor -->' +
	            '<div id="' + floor.form + pind + '_' + index + '">' +
	            '<div class="panel panel-danger">' +
	            '<div class="panel-heading">' +
	            '<strong>Floor ' + Number(index + 1) + '</strong>&nbsp;' +
	            '<button class="btn btn-danger  btn-md" name="' + pind + '" id="' + floor.minus + pind + '_' + index + '"><i class="fa fa-minus fa-fw fa-x2"></i></button>&nbsp;' +
	            '<button class="btn btn-success  btn-md" name="' + pind + '" id="' + floor.plus + pind + '_' + index + '"><i class="fa fa-plus fa-fw fa-x2"></i></button>' +
	            '</div>' +
	            '<div class="panel-body">' +
	            '<div class="row">' +
	            '<div class="col-lg-12">' +
	            '<input class="form-control" placeholder="Name of the Company Representative" name="crname" type="text" id="' + floor.bankname + pind + '_' + index + '" maxlength="100" value="Floor ' + Number(index + 1) + '"/>' +
	            '<p class="help-block" id="' + floor.nmsg + pind + '_' + index + '">Enter / Select</p>' +
	            '</div>' +
	            '</div>' +
	            '<!-- Desc -->' +
	            '<div class="row">' +
	            '<div class="col-lg-12"> <strong><span class="text-danger"><i class="fa fa-star fa-fw"></i></span> Description </strong>&nbsp;' +
	            '<button class="text-primary btn btn-success  btn-md" name="' + index + '" id="' + pdesc.plus + pind + '_' + index + '"><i class="fa fa-plus fa-fw fa-x2"></i></button>&nbsp; ' +
	            '</div>' +
	            '<div class="col-lg-12" id="' + pdesc.parentDiv + pind + '_' + index + '">' +
	            '</div>' +
	            '</div>' +
	            '<!-- Desc -->' +
	            '</div>' +
	            '</div>' +
	            '</div>' +
	            '</div>' +
	            '<!-- Floor -->';
	        $(html).appendTo($(document.getElementById(floor.parentDiv + pind)));
	        // window.setTimeout(function() {
	        $($(document.getElementById(pdesc.plus + pind + '_' + index))).click(function(evt) {
	            evt.stopPropagation();
	            evt.preventDefault();
	            $(this).hide();
	            addMultipleBFDesc({
	                ppind: pind,
	                pind: $(this).prop('name'),
	                index: -1
	            });
	        });
	        $(document.getElementById(floor.minus + pind + '_' + index)).click(function(evt) {
	            evt.stopPropagation();
	            evt.preventDefault();
	            $(document.getElementById(floor.form + pind + '_' + index)).remove();
	            painting[pind].floorarr[index].num--;
	            var num = painting[pind].floorarr[index].num;
	            if (num == -1) {
	                $(document.getElementById(floor.plus + pind)).show();
	                $(document.getElementById(floor.parentDiv + pind)).html('');
	                painting[pind].floorarr = [];
	            } else {
	                $(document.getElementById(floor.plus + pind + '_' + num)).show();
	                $(document.getElementById(floor.minus + pind + '_' + num)).show();
	                painting[pind].floorarr.pop();
	            }
	        });
	        $(document.getElementById(floor.plus + pind + '_' + index)).click(function(evt) {
	            evt.stopPropagation();
	            evt.preventDefault();
	            var pind = $(this).prop('name');
	            $(document.getElementById(floor.plus + pind + '_' + index)).hide();
	            $(document.getElementById(floor.minus + pind + '_' + index)).hide();
	            addMultipleFloor({
	                pind: pind,
	                index: index
	            });
	        });
	        // }, 400);
	    };

	    function addMultipleBFDesc(ind) {
	        var index = ind.index;
	        if (index == -1) {
	            index = 0;
	            $(document.getElementById(pdesc.parentDiv + ind.ppind + '_' + ind.pind)).html('');
	        } else {
	            index = Number(index + 1);
	        }
	        painting[ind.ppind].floorarr[ind.pind].descarr[index] = {
	            parentDiv: pdesc.parentDiv + ind.ppind + '_' + ind.pind + '_' + index,
	            num: index,
	            ppind: ind.ppind,
	            pind: ind.pind,
	            form: pdesc.form + ind.ppind + '_' + ind.pind + '_' + index,
	            bankname: pdesc.bankname + ind.ppind + '_' + ind.pind + '_' + index,
	            nmsg: pdesc.nmsg + ind.ppind + '_' + ind.pind + '_' + index,
	            accno: pdesc.accno + ind.ppind + '_' + ind.pind + '_' + index,
	            nomsg: pdesc.nomsg + ind.ppind + '_' + ind.pind + '_' + index,
	            braname: pdesc.braname + ind.ppind + '_' + ind.pind + '_' + index,
	            bnmsg: pdesc.bnmsg + ind.ppind + '_' + ind.pind + '_' + index,
	            bracode: pdesc.bracode + ind.ppind + '_' + ind.pind + '_' + index,
	            bcmsg: pdesc.bcmsg + ind.ppind + '_' + ind.pind + '_' + index,
	            IFSC: pdesc.IFSC + ind.ppind + '_' + ind.pind + '_' + index,
	            IFSCmsg: pdesc.IFSCmsg + ind.ppind + '_' + ind.pind + '_' + index,
	            IFSC1: pdesc.IFSC1 + ind.ppind + '_' + ind.pind + '_' + index,
	            IFSC1msg: pdesc.IFSC1msg + ind.ppind + '_' + ind.pind + '_' + index,
	            plus: pdesc.plus + ind.ppind + '_' + ind.pind + '_' + index,
	            minus: pdesc.minus + ind.ppind + '_' + ind.pind + '_' + index
	        };
	        var html = '<div id="' + pdesc.form + ind.ppind + '_' + ind.pind + '_' + index + '">' +
	            '<div class="col-lg-6">' +
	            '<div class="panel panel-warning">' +
	            '<div class="panel-heading">' +
	            '<strong>Description ' + Number(index + 1) + '</strong>&nbsp;' +
	            '<button class="btn btn-danger  btn-md" id="' + pdesc.minus + ind.ppind + '_' + ind.pind + '_' + index + '"><i class="fa fa-minus fa-fw fa-x2"></i></button>&nbsp;' +
	            '<button class="btn btn-success  btn-md" id="' + pdesc.plus + ind.ppind + '_' + ind.pind + '_' + index + '"><i class="fa fa-plus fa-fw fa-x2"></i></button>' +
	            '</div>' +
	            '<div class="panel-body">' +
	            '<div class="row">' +
	            '<div class="col-lg-4">' +
	            '<div class="col-lg-12">' +
	            '<strong><span class="text-warning"><i class="fa fa-star fa-fw"></i></span> Location </strong>' +
	            '</div>' +
	            '<div class="col-lg-12">' +
	            '<input class="form-control" placeholder="Location" name="Location" type="text" id="' + pdesc.bankname + ind.ppind + '_' + ind.pind + '_' + index + '" maxlength="100"/>' +
	            '<p class="help-block" id="' + pdesc.nmsg + ind.ppind + '_' + ind.pind + '_' + index + '">Enter / Select</p>' +
	            '</div>' +
	            '</div>' +
	            '<div class="col-lg-4">' +
	            '<div class="col-lg-12">' +
	            '<strong><span class="text-warning"><i class="fa fa-star fa-fw"></i></span> Rate </strong>' +
	            '</div>' +
	            '<div class="col-lg-12">' +
	            '<input class="form-control rate" name="IFSC" type="text" id="' + pdesc.IFSC + ind.ppind + '_' + ind.pind + '_' + index + '" maxlength="100" value="0"/>' +
	            '<p class="help-block" id="' + pdesc.IFSCmsg + ind.ppind + '_' + ind.pind + '_' + index + '">Enter / Select</p>' +
	            '</div>' +
	            '</div>' +
	            '<div class="col-lg-4">' +
	            '<div class="col-lg-12">' +
	            '<strong><span class="text-warning"><i class="fa fa-star fa-fw"></i></span> Amount </strong>' +
	            '</div>' +
	            '<div class="col-lg-12">' +
	            '<input class="form-control amount" name="IFSC" type="text" id="' + pdesc.IFSC1 + ind.ppind + '_' + ind.pind + '_' + index + '" maxlength="100" value="0" readonly="readonly"/>' +
	            '<p class="help-block" id="' + pdesc.IFSC1msg + ind.ppind + '_' + ind.pind + '_' + index + '">Enter / Select</p>' +
	            '</div>' +
	            '</div>' +
	            '</div>' +
	            '<div class="row">' +
	            '<div class="col-lg-4">' +
	            '<div class="col-lg-12">' +
	            '<strong><span class="text-warning"><i class="fa fa-star fa-fw"></i></span> Breadth </strong>' +
	            '</div>' +
	            '<div class="col-lg-12">' +
	            '<input class="form-control breadth" name="accno" type="text" id="' + pdesc.accno + ind.ppind + '_' + ind.pind + '_' + index + '" maxlength="100" value="0"/>' +
	            '<p class="help-block" id="' + pdesc.nomsg + ind.ppind + '_' + ind.pind + '_' + index + '">Enter / Select</p>' +
	            '</div>' +
	            '</div>' +
	            '<div class="col-lg-4">' +
	            '<div class="col-lg-12">' +
	            '<strong><span class="text-warning"><i class="fa fa-star fa-fw"></i></span> Height </strong>' +
	            '</div>' +
	            '<div class="col-lg-12">' +
	            '<input class="form-control height" name="braname" type="text" id="' + pdesc.braname + ind.ppind + '_' + ind.pind + '_' + index + '" maxlength="100" value="0"/>' +
	            '<p class="help-block" id="' + pdesc.bnmsg + ind.ppind + '_' + ind.pind + '_' + index + '">Enter / Select</p>' +
	            '</div>' +
	            '</div>' +
	            '<div class="col-lg-4">' +
	            '<div class="col-lg-12">' +
	            '<strong><span class="text-warning"><i class="fa fa-star fa-fw"></i></span> Area </strong>' +
	            '</div>' +
	            '<div class="col-lg-12">' +
	            '<input class="form-control area" name="bracode" type="text" id="' + pdesc.bracode + ind.ppind + '_' + ind.pind + '_' + index + '" maxlength="100" value="0" readonly="readonly"/>' +
	            '<p class="help-block" id="' + pdesc.bcmsg + ind.ppind + '_' + ind.pind + '_' + index + '">Enter / Select</p>' +
	            '</div>' +
	            '</div>' +
	            '</div>' +
	            '</div>' +
	            '</div>' +
	            '</div>' +
	            '</div>';
	        $(html).appendTo($(document.getElementById(pdesc.parentDiv + ind.ppind + '_' + ind.pind)));
	        // window.setTimeout(function() {
	        // $(document.getElementById(pdesc.parentDiv+ind.ppind+'_'+ind.pind)).find('input').each(function(){
	        // $(this).on('focus',function(event){
	        // $(this).val('');
	        // });
	        // });
	        $(document.getElementById(pdesc.parentDiv + ind.ppind + '_' + ind.pind)).find('input').each(function() {
	            if ($(this).hasClass('breadth') || $(this).hasClass('height') || $(this).hasClass('rate')) {
	                $(this).on('keyup', function(event) {
	                    for (i = 0; i <= index; i++) {
	                        if ($(this).attr('id') == pdesc.accno + ind.ppind + '_' + ind.pind + '_' + i || $(this).attr('id') == pdesc.braname + ind.ppind + '_' + ind.pind + '_' + i) {
	                            var len = Number($(document.getElementById(pdesc.accno + ind.ppind + '_' + ind.pind + '_' + i)).val());
	                            $(document.getElementById(pdesc.accno + ind.ppind + '_' + ind.pind + '_' + i)).val(len);
	                            var bred = Number($(document.getElementById(pdesc.braname + ind.ppind + '_' + ind.pind + '_' + i)).val());
	                            $(document.getElementById(pdesc.braname + ind.ppind + '_' + ind.pind + '_' + i)).val(bred);
	                            var area = Number(Number($(document.getElementById(pdesc.accno + ind.ppind + '_' + ind.pind + '_' + i)).val()) * Number($(document.getElementById(pdesc.braname + ind.ppind + '_' + ind.pind + '_' + i)).val()));
	                            area = area < 0 ? 0 : area;
	                            $(document.getElementById(pdesc.bracode + ind.ppind + '_' + ind.pind + '_' + i)).val(area);
	                            var rate = Number($(document.getElementById(pdesc.IFSC + ind.ppind + '_' + ind.pind + '_' + i)).val()) < 0 ? 0 : Number($(document.getElementById(pdesc.IFSC + ind.ppind + '_' + ind.pind + '_' + i)).val());
	                            $(document.getElementById(pdesc.IFSC + ind.ppind + '_' + ind.pind + '_' + i)).val(rate);
	                            $(document.getElementById(pdesc.IFSC1 + ind.ppind + '_' + ind.pind + '_' + i)).val(Number(rate) * Number($(document.getElementById(pdesc.bracode + ind.ppind + '_' + ind.pind + '_' + i)).val()));
	                            break;
	                        }
	                        // if($(this).attr('id') == pdesc.IFSC+ind.ppind+'_'+ind.pind+'_' + i){
	                        // var rate = Number($(document.getElementById(pdesc.IFSC+ind.ppind+'_'+ind.pind+'_' + i)).val()) < 0 ? 0 : Number($(document.getElementById(pdesc.IFSC+ind.ppind+'_'+ind.pind+'_' + i)).val());
	                        // $(document.getElementById(pdesc.IFSC+ind.ppind+'_'+ind.pind+'_' + i)).val(rate);
	                        // $(document.getElementById(pdesc.IFSC1+ind.ppind+'_'+ind.pind+'_' + i)).val(Number(rate) * Number($(document.getElementById(pdesc.bracode+ind.ppind+'_'+ind.pind+'_' + i)).val()));
	                        // break;
	                        // }
	                    }
	                });
	            }
	            if ($(this).hasClass('rate')) {
	                $(this).on('keyup', function(event) {
	                    for (i = 0; i <= index; i++) {
	                        if ($(this).attr('id') == pdesc.IFSC + ind.ppind + '_' + ind.pind + '_' + i) {
	                            var rate = Number($(document.getElementById(pdesc.IFSC + ind.ppind + '_' + ind.pind + '_' + i)).val()) < 0 ? 0 : Number($(document.getElementById(pdesc.IFSC + ind.ppind + '_' + ind.pind + '_' + i)).val());
	                            $(document.getElementById(pdesc.IFSC + ind.ppind + '_' + ind.pind + '_' + i)).val(rate);
	                            $(document.getElementById(pdesc.IFSC1 + ind.ppind + '_' + ind.pind + '_' + i)).val(Number(rate) * Number($(document.getElementById(pdesc.bracode + ind.ppind + '_' + ind.pind + '_' + i)).val()));
	                            break;
	                        }
	                    }
	                });
	            }
	        });
	        $(document.getElementById(pdesc.minus + ind.ppind + '_' + ind.pind + '_' + index)).click(function(evt) {
	            evt.stopPropagation();
	            evt.preventDefault();
	            $(document.getElementById(pdesc.form + ind.ppind + '_' + ind.pind + '_' + index)).remove();
	            painting[ind.ppind].floorarr[ind.pind].descarr[index].num--;
	            var num = painting[ind.ppind].floorarr[ind.pind].descarr[index].num;
	            if (num == -1) {
	                $(document.getElementById(pdesc.plus + ind.ppind + '_' + ind.pind)).show();
	                $(document.getElementById(pdesc.parentDiv + ind.ppind + '_' + ind.pind)).html('');
	                painting[ind.ppind].floorarr[ind.pind].descarr = [];
	            } else {
	                $(document.getElementById(pdesc.plus + ind.ppind + '_' + ind.pind + '_' + num)).show();
	                $(document.getElementById(pdesc.minus + ind.ppind + '_' + ind.pind + '_' + num)).show();
	                painting[ind.ppind].floorarr[ind.pind].descarr.pop();
	            }
	        });
	        $(document.getElementById(pdesc.plus + ind.ppind + '_' + ind.pind + '_' + index)).click({
	            ind: {
	                ppind: ind.ppind,
	                pind: ind.pind,
	                index: index
	            }
	        }, function(event) {
	            event.stopPropagation();
	            event.preventDefault();
	            var ind = event.data.ind;
	            $(document.getElementById(pdesc.plus + ind.ppind + '_' + ind.pind + '_' + ind.index)).hide();
	            $(document.getElementById(pdesc.minus + ind.ppind + '_' + ind.pind + '_' + ind.index)).hide();
	            addMultipleBFDesc(ind);
	        });
	        // }, 400);
	    };

	    function fetchUsers(obj) {
	        var htm = '';
	        var htm1 = '';
	        var list = {};
	        $(obj.para1.parentDiv).html('');
	        $.ajax({
	            type: 'POST',
	            url: obj.para1.ob.url,
	            data: {
	                autoloader: true,
	                action: 'fetchUsers',
	                utyp: obj.type
	            },
	            success: function(data, textStatus, xhr) {
	                switch (data) {
	                    case 'logout':
	                        logoutAdmin({});
	                        break;
	                    case 'login':
	                        loginAdmin({});
	                        break;
	                    default:
	                        if (!obj.para2) {
	                            ethno = list;
	                        } else {
	                            client = list;
	                        }
	                        list = $.parseJSON($.trim(data));
	                        if (list != null) {
	                            for (i = 0; i < list.length; i++) {
	                                htm += list[i]["html"];
	                            }
	                            $(obj.para1.parentDiv).html('<select class="form-control" id="' + obj.para1.id + '"><option value="NULL" selected>' + obj.para1.text + '</option>' + htm + '</select><p class="help-block" id="' + obj.para1.msg + '">Enter / Select</p>');
	                            window.setTimeout(function() {
	                                $('#' + obj.para1.id).change(function() {
	                                    var id = $(this).select().val();
	                                    if (id != 'NULL') {
	                                        if (obj.para2 == false) {
	                                            obj.para1.ob.ethid = id;
	                                        } else {
	                                            obj.para1.ob.cliid = id;
	                                            window.setTimeout(function() {
	                                                htm1 = '';
	                                                for (i = 0; i < list.length; i++) {
	                                                    for (j = 0; j < list[i]["rephtml"].length; j++) {
	                                                        if (list[i]["rephtml"][j]["uid"] == id) {
	                                                            htm1 += list[i]["rephtml"][j]["html"];
	                                                        }
	                                                    }
	                                                }
	                                                $(obj.para2.parentDiv).html('<select class="form-control" id="' + obj.para2.id + '"><option value="NULL" selected>' + obj.para2.text + '</option>' + htm1 + '</select><p class="help-block" id="' + obj.para2.msg + '">Enter / Select</p>');
	                                                $('#' + obj.para2.id).change(function() {
	                                                    var id = $(this).select().val();
	                                                    if (id != 'NULL') {
	                                                        obj.para1.ob.cpnid = id;
	                                                    }
	                                                });
	                                            });
	                                        }
	                                    }
	                                });
	                            }, 300);
	                        }
	                        break;
	                }
	            },
	            error: function() {
	                $(Requi.outputDiv).html(INET_ERROR);
	            },
	            complete: function(xhr, textStatus) {
	                console.log(xhr.status);
	            }
	        });
	    };

	    function addRequirements() {
	        var flag = false;
	        var part = [];
	        var paint = [];
	        /* Project Name */
	        if ($(Requi.add.pname).val().match(name_reg)) {
	            flag = true;
	            $(Requi.add.pnmsg).html(VALIDNOT);
	        } else {
	            flag = false;
	            $(Requi.add.pnmsg).html(INVALIDNOT);
	            $('html, body').animate({
	                scrollTop: Number($(Requi.add.pnmsg).offset().top) - 95
	            }, 'slow');
	            $(Requi.add.pname).focus();
	            return;
	        }
	        /* Ethonographer */
	        if (Requi.add.ethid > 0) {
	            flag = true;
	            $('#' + Requi.add.ethno_msg).html(VALIDNOT);
	        } else {
	            flag = false;
	            $('#' + Requi.add.ethno_msg).html(INVALIDNOT);
	            $('html, body').animate({
	                scrollTop: Number($('#' + Requi.add.ethno_msg).offset().top) - 95
	            }, 'slow');
	            $('#' + Requi.add.ethno_type).focus();
	            return;
	        }
	        /* Client / Customer */
	        if (Requi.add.cliid > 0) {
	            flag = true;
	            $('#' + Requi.add.client_msg).html(VALIDNOT);
	        } else {
	            flag = false;
	            $('#' + Requi.add.client_msg).html(INVALIDNOT);
	            $('html, body').animate({
	                scrollTop: Number($('#' + Requi.add.client_msg).offset().top) - 95
	            }, 'slow');
	            $('#' + Requi.add.client_type).focus();
	            return;
	        }
	        /* Company Representative */
	        if (Requi.add.cpnid > 0) {
	            flag = true;
	            $('#' + Requi.add.cperson_msg).html(VALIDNOT);
	        } else {
	            // flag = false;
	            // $('#'+Requi.add.cperson_msg).html(INVALIDNOT);
	            // $('html, body').animate({
	            // scrollTop: Number($('#'+Requi.add.cperson_msg).offset().top) - 95
	            // }, 'slow');
	            // $('#'+Requi.add.cperson_type).focus();
	            // return;
	        }
	        /* Date of Ethno */
	        if ($(Requi.add.doe).val().match(/(\d{4})-(\d{2})-(\d{2})/)) {
	            flag = true;
	            $(Requi.add.doemsg).html(VALIDNOT);
	        } else {
	            flag = false;
	            $(Requi.add.doemsg).html(INVALIDNOT);
	            $('html, body').animate({
	                scrollTop: Number($(Requi.add.doemsg).offset().top) - 95
	            }, 'slow');
	            $(Requi.add.doe).focus();
	            return;
	        }
	        /* Particulars */
	        if (particulars.length > 0) {
	            for (i = 0; i < particulars.length; i++) {
	                var par = particulars[i];
	                if ($(document.getElementById(par.bankname)).val().length > 0) {
	                    flag = true;
	                    $(document.getElementById(par.nmsg)).html(VALIDNOT);
	                } else {
	                    flag = false;
	                    $(document.getElementById(par.nmsg)).html(INVALIDNOT);
	                    $('html, body').animate({
	                        scrollTop: Number($(document.getElementById(par.nmsg)).offset().top) - 95
	                    }, 'slow');
	                    $(document.getElementById(par.bankname)).focus();
	                    return;
	                }
	                if ($(document.getElementById(par.accno)).val().match(ind_reg)) {
	                    flag = true;
	                    $(document.getElementById(par.nomsg)).html(VALIDNOT);
	                } else {
	                    flag = false;
	                    $(document.getElementById(par.nomsg)).html(INVALIDNOT);
	                    $('html, body').animate({
	                        scrollTop: Number($(document.getElementById(par.nomsg)).offset().top) - 95
	                    }, 'slow');
	                    $(document.getElementById(par.accno)).focus();
	                    return;
	                }
	                if ($(document.getElementById(par.braname)).select().val().match(ind_reg)) {
	                    flag = true;
	                    $(document.getElementById(par.bnmsg)).html(VALIDNOT);
	                } else {
	                    flag = false;
	                    $(document.getElementById(par.bnmsg)).html(INVALIDNOT);
	                    $('html, body').animate({
	                        scrollTop: Number($(document.getElementById(par.bnmsg)).offset().top) - 95
	                    }, 'slow');
	                    $(document.getElementById(par.braname)).focus();
	                    return;
	                }
	                if (flag) {
	                    part.push({
	                        parti: $(document.getElementById(par.bankname)).val(),
	                        qty: $(document.getElementById(par.accno)).val(),
	                        unit: $(document.getElementById(par.braname)).val(),
	                        deliinst: []
	                    });
	                }
	                /* Supply / Installation */
	                if (par.deliinstarr.length > -1) {
	                    for (j = 0; j < par.deliinstarr.length; j++) {
	                        var del = par.deliinstarr[j];
	                        if ($(document.getElementById(del.bankname)).val().match(ind_reg)) {
	                            flag = true;
	                            $(document.getElementById(del.nmsg)).html(VALIDNOT);
	                        } else {
	                            flag = false;
	                            $(document.getElementById(del.nmsg)).html(INVALIDNOT);
	                            $('html, body').animate({
	                                scrollTop: Number($(document.getElementById(del.nmsg)).offset().top) - 95
	                            }, 'slow');
	                            $(document.getElementById(del.bankname)).focus();
	                            return;
	                        }
	                        if ($(document.getElementById(del.accno)).val().match(ind_reg)) {
	                            flag = true;
	                            $(document.getElementById(del.nomsg)).html(VALIDNOT);
	                        } else {
	                            flag = false;
	                            $(document.getElementById(del.nomsg)).html(INVALIDNOT);
	                            $('html, body').animate({
	                                scrollTop: Number($(document.getElementById(del.nomsg)).offset().top) - 95
	                            }, 'slow');
	                            $(document.getElementById(del.accno)).focus();
	                            return;
	                        }
	                        if (flag) {
	                            part[i].deliinst.push({
	                                supply: $(document.getElementById(del.bankname)).val(),
	                                instal: $(document.getElementById(del.accno)).val()
	                            });
	                        }
	                    }
	                }
	            }
	        }
	        /* Block / Floor  / Description */
	        if (painting.length > -1) {
	            for (i = 0; i < painting.length; i++) {
	                var block = painting[i];
	                /* Block Name */
	                if ($(document.getElementById(block.bankname)).val().match(name_reg)) {
	                    flag = true;
	                    $(document.getElementById(block.nmsg)).html(VALIDNOT);
	                } else {
	                    flag = false;
	                    $(document.getElementById(block.nmsg)).html(INVALIDNOT);
	                    $('html, body').animate({
	                        scrollTop: Number($(document.getElementById(block.nmsg)).offset().top) - 95
	                    }, 'slow');
	                    $(document.getElementById(block.bankname)).focus();
	                    return;
	                }
	                if (flag) {
	                    paint.push({
	                        blockname: $(document.getElementById(block.bankname)).val(),
	                        floor: []
	                    });
	                }
	                if (block.floorarr.length > -1) {
	                    for (j = 0; j < block.floorarr.length; j++) {
	                        var flor = block.floorarr[j];
	                        /* Floor Name */
	                        if ($(document.getElementById(flor.bankname)).val().match(name_reg)) {
	                            flag = true;
	                            $(document.getElementById(flor.nmsg)).html(VALIDNOT);
	                        } else {
	                            flag = false;
	                            $(document.getElementById(flor.nmsg)).html(INVALIDNOT);
	                            $('html, body').animate({
	                                scrollTop: Number($(document.getElementById(flor.nmsg)).offset().top) - 95
	                            }, 'slow');
	                            $(document.getElementById(flor.bankname)).focus();
	                            return;
	                        }
	                        if (flag) {
	                            paint[i].floor.push({
	                                floorname: $(document.getElementById(flor.bankname)).val(),
	                                desc: []
	                            });
	                        }
	                        if (block.floorarr[j].descarr.length > -1) {
	                            for (k = 0; k < flor.descarr.length; k++) {
	                                var desc = flor.descarr[k];
	                                /* Location */
	                                if ($(document.getElementById(desc.bankname)).val().match(name_reg)) {
	                                    flag = true;
	                                    $(document.getElementById(desc.nmsg)).html(VALIDNOT);
	                                } else {
	                                    flag = false;
	                                    $(document.getElementById(desc.nmsg)).html(INVALIDNOT);
	                                    $('html, body').animate({
	                                        scrollTop: Number($(document.getElementById(desc.nmsg)).offset().top) - 95
	                                    }, 'slow');
	                                    $(document.getElementById(desc.bankname)).focus();
	                                    return;
	                                }
	                                /* Breadth */
	                                if ($(document.getElementById(desc.accno)).val().match(ind_reg)) {
	                                    flag = true;
	                                    $(document.getElementById(desc.nomsg)).html(VALIDNOT);
	                                } else {
	                                    flag = false;
	                                    $(document.getElementById(desc.nomsg)).html(INVALIDNOT);
	                                    $('html, body').animate({
	                                        scrollTop: Number($(document.getElementById(desc.nomsg)).offset().top) - 95
	                                    }, 'slow');
	                                    $(document.getElementById(desc.accno)).focus();
	                                    return;
	                                }
	                                /* Height */
	                                if ($(document.getElementById(desc.braname)).val().match(ind_reg)) {
	                                    flag = true;
	                                    $(document.getElementById(desc.bnmsg)).html(VALIDNOT);
	                                } else {
	                                    flag = false;
	                                    $(document.getElementById(desc.bnmsg)).html(INVALIDNOT);
	                                    $('html, body').animate({
	                                        scrollTop: Number($(document.getElementById(desc.bnmsg)).offset().top) - 95
	                                    }, 'slow');
	                                    $(document.getElementById(desc.braname)).focus();
	                                    return;
	                                }
	                                /* Area */
	                                if ($(document.getElementById(desc.bracode)).val().match(ind_reg)) {
	                                    flag = true;
	                                    $(document.getElementById(desc.bcmsg)).html(VALIDNOT);
	                                    $('html, body').animate({
	                                        scrollTop: Number($(document.getElementById(desc.bcmsg)).offset().top) - 95
	                                    }, 'slow');
	                                } else {
	                                    flag = false;
	                                    $(document.getElementById(desc.bcmsg)).html(INVALIDNOT);
	                                    $('html, body').animate({
	                                        scrollTop: Number($(document.getElementById(desc.bcmsg)).offset().top) - 95
	                                    }, 'slow');
	                                    $(document.getElementById(desc.bracode)).focus();
	                                    return;
	                                }
	                                /* Rate */
	                                if ($(document.getElementById(desc.IFSC)).val().match(ind_reg)) {
	                                    flag = true;
	                                    $(document.getElementById(desc.IFSCmsg)).html(VALIDNOT);
	                                } else {
	                                    flag = false;
	                                    $(document.getElementById(desc.IFSCmsg)).html(INVALIDNOT);
	                                    $('html, body').animate({
	                                        scrollTop: Number($(document.getElementById(desc.IFSCmsg)).offset().top) - 95
	                                    }, 'slow');
	                                    $(document.getElementById(desc.IFSC)).focus();
	                                    return;
	                                }
	                                /* Total Amount */
	                                if ($(document.getElementById(desc.IFSC1)).val().match(id_reg)) {
	                                    flag = true;
	                                    $(document.getElementById(desc.IFSC1msg)).html(VALIDNOT);
	                                } else {
	                                    flag = false;
	                                    $(document.getElementById(desc.IFSC1msg)).html(INVALIDNOT);
	                                    $('html, body').animate({
	                                        scrollTop: Number($(document.getElementById(desc.IFSC1msg)).offset().top) - 95
	                                    }, 'slow');
	                                    $(document.getElementById(desc.IFSC1)).focus();
	                                    return;
	                                }
	                                if (flag) {
	                                    paint[i].floor[j].desc.push({
	                                        location: $(document.getElementById(desc.bankname)).val(),
	                                        breadth: $(document.getElementById(desc.accno)).val(),
	                                        height: $(document.getElementById(desc.braname)).val(),
	                                        area: $(document.getElementById(desc.bracode)).val(),
	                                        rate: $(document.getElementById(desc.IFSC)).val(),
	                                        amount: $(document.getElementById(desc.IFSC1)).val()
	                                    });
	                                }
	                            }
	                        }
	                    }
	                }
	            }
	        }
	        var attr = {
	            prj_name: $(Requi.add.pname).val(),
	            cliid: Requi.add.cliid,
	            ethid: Requi.add.ethid,
	            cpnid: Requi.add.cpnid,
	            doe: $(Requi.add.doe).val(),
	            part: part,
	            paint: paint
	        };
	        if (flag) {
	            // $(Requi.add.but).prop('disabled', 'disabled');
	            $(Requi.msgDiv).html('');
	            $.ajax({
	                url: Requi.add.url,
	                type: 'POST',
	                data: {
	                    autoloader: true,
	                    action: 'addRequirements',
	                    reqadd: attr
	                },
	                success: function(data, textStatus, xhr) {
	                    console.log(data);
	                    data = $.trim(data);
	                    switch (data) {
	                        case 'logout':
	                            logoutAdmin({});
	                            break;
	                        case 'login':
	                            loginAdmin({});
	                            break;
	                        default:
	                            $(Requi.msgDiv).html('<h2>Requirement added to database</h2>');
	                            $('html, body').animate({
	                                scrollTop: Number($(Requi.msgDiv).offset().top) - 95
	                            }, 'slow');
	                            // $(Requi.add.form).get(0).reset();
	                            break;
	                    }
	                },
	                error: function() {
	                    $(Requi.outputDiv).html(INET_ERROR);
	                },
	                complete: function(xhr, textStatus) {
	                    console.log(xhr.status);
	                    $(Requi.add.but).removeAttr('disabled');
	                }
	            });
	        } else {
	            $(Requi.add.but).removeAttr('disabled');
	        }
	    };

	    function listDoc() {
	        $(Requi.list.listDiv).html(LOADER_FIV);
	        var htm = '';
	        $.ajax({
	            url: Requi.list.url,
	            type: 'POST',
	            data: {
	                autoloader: true,
	                action: Requi.list.action,
	                display: Requi.list.display,
	                what: Requi.list.what
	            },
	            success: function(data, textStatus, xhr) {
	                data = $.trim(data);
	                switch (data) {
	                    case 'logout':
	                        logoutAdmin({});
	                        break;
	                    case 'login':
	                        loginAdmin({});
	                        break;
	                    default:
	                        var lists = $.parseJSON(data);
	                        if (lists != null) {
	                            for (i = 0; i < lists.length; i++) {
	                                htm += lists[i].html;
	                            }
	                        }
	                        var header = '<div class="col-md-12">' +
	                            '<div class="panel panel-default">' +
	                            '<div class="panel-heading">  List of ' + Requi.list.what + ' </div>' +
	                            '<div class="panel-body">' +
	                            '<table class="table table-striped table-bordered table-hover dataTable no-footer" id="list_what_' + Requi.list.what + '">' +
	                            '<thead><tr><th>#</th><th>Name</th><th>Date</th><th>Location</th></tr></thead>' +
	                            '<tbody>';
	                        var footer = '</tbody></table></div></div></div>';
	                        $(Requi.list.listDiv).html(header + htm + footer);
	                        window.setTimeout(function() {
	                            $('#list_what_' + Requi.list.what).dataTable();
	                        }, 300);
	                        break;
	                }
	            },
	            error: function() {
	                $(Requi.outputDiv).html(INET_ERROR);
	            },
	            complete: function(xhr, textStatus) {
	                console.log(xhr.status);
	            }
	        });
	    }
	}
