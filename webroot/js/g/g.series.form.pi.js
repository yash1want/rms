/**
 * This file holds the code of H-Form creation and its validation
 */

//================CREATION AND DISPLAY OF THE FORM AND DATA STARTS==============
var H1EmploymentWages = {
    init: function(reasons_url, data_url) {
        this.reasonsUrl = reasons_url;
        this.dataUrl = data_url;
        this.reasonsTable = $("#reasons_table");
        this.reasonCount = $("#reason_count");
        Utilities.ajaxBlockUI();
        this.getEmpData();
        this.addMoreReason();
        /**
         * ADDING THE BELOW FUNCTION FOR CHECKING THE REASON AT THE TIME OF SAVE AND NEXT
         * AND NOT ALLOWING HIM/HER TO GO FORWARD UNTIL THE USER FILL THE VALUE FOR THE 
         * SELECTED REASON
         * @author Uday Shankar Singh
         * @version 14th Feb 2014
         * 
         **/ 
        EmploymentWages.employmentWagesIPostValidation();
    },
    getEmpData: function() {
        var _this = this;

        //get data
        $.ajax({
            url: _this.reasonsUrl,
            type: 'GET',
            success: function(response) {
                _this.reasons = json_parse(response);
                //get data
                $.ajax({
                    url: _this.dataUrl,
                    type: 'GET',
                    success: function(resp_data) {
                        _this.data = json_parse(resp_data);
                        if (_this.data.returnDetails == "") {
                            _this.createReasonBox(1);
                            _this.reasonCount.value = 1;
                            EmploymentWages.fieldValidation();
                        //_this.getStaffTotal();
                        } else {
                            _this.fillData();
                            EmploymentWages.fieldValidation();
                        //_this.getStaffTotal();
                        }
                    }
                });
            }
        });
    },
    createReasonBox: function(elem_no, reason_value, no_of_days_value) {
        var _this = this;
        var row = $(document.createElement('tr'));
        this.reasonsTable.append(row);

        var select_box_container = $(document.createElement('td'));
        row.append(select_box_container);

        //reasons - select box
        var select_box = $(document.createElement('select'));
        select_box.attr("id", "reason_" + elem_no);
        select_box.attr("name", "reason_" + elem_no);
        select_box.addClass("h-selectbox select_reason");
        select_box_container.append(select_box);

        //        $("#F_CLIENT_TYPE").append(
        //                $("<option></option>").html("NIL").val("NIL")
        //                );
        //        var stoppageReason = new Array();
        //        stoppageReason = "-Select Reason-";
        //        stoppageReason = this.reasons;
        //        console.log(stoppageReason)

        var optionsSelect = $(document.createElement('option'));
        optionsSelect.html("Select Reason");
        optionsSelect.attr("value", '');
        //        if (reason_value == index)
        //            options.attr("selected", "selected");
        select_box.append(optionsSelect);

        $.each(this.reasons, function(index, item) {
            //            console.log(item)
            //            console.log(index)
            var options = $(document.createElement('option'));
            options.html(item);
            options.attr("value", index);
            //            console.log(reason_value)
            //            console.log(index)
            //options.val(index);
            if (reason_value == index)
                options.attr("selected", "selected");
            select_box.append(options);
        });


        var no_of_days_container = $(document.createElement('td'));
        row.append(no_of_days_container);
        //no. of days - input box
        var no_of_days = $(document.createElement('input'));
        no_of_days.attr("id", "no_of_days_" + elem_no);
        no_of_days.attr("name", "no_of_days_" + elem_no);
        no_of_days.addClass("no_of_days number-fields");
        no_of_days.css("width", "70px");
        no_of_days_container.append(no_of_days);

        if (no_of_days_value == 0)
            no_of_days_value = "";
        if (no_of_days_value != null)
            no_of_days.attr("value", no_of_days_value);

        if (elem_no > 1) {
            //close button
            var close_td = $(document.createElement('td'));
            close_td.addClass("h-close-icon");
            close_td.bind('click', function() {
                $(this).parent().remove();
                //rename the id and name for the other text and select boxes
                _this.renameReasonBoxes();

                //hidden metal count
                var prev_reason_count = _this.reasonCount.value;
                var dec_reason_count = parseInt(prev_reason_count) - 1;
                _this.reasonCount.value = dec_reason_count;
            });
            row.append(close_td);
        }
    },
    addMoreReason: function() {
        var _this = this;
        var btn = document.getElementById("add_reason");

        btn.onclick = function() {
            //hidden metal count
            var prev_reason_count = _this.reasonCount.value;
            if (prev_reason_count == 5) {
                alert("Sorry! You can't add more than 5 records");
                return;
            }
            var inc_reason_count = parseInt(prev_reason_count) + 1;
            _this.reasonCount.value = inc_reason_count;

            _this.createReasonBox(inc_reason_count);
        }
    },
    renameReasonBoxes: function() {
        var reason_boxes = $(".h-selectbox");
        var no_of_days_boxes = $(".no_of_days");

        for (var j = 0; j < reason_boxes.length; j++) {
            var count = j + 1;
            $(reason_boxes[j]).attr('name', 'reason_' + count);
            $(reason_boxes[j]).attr('id', 'reason_' + count);

            $(no_of_days_boxes[j]).attr('name', 'no_of_days_' + count);
            $(no_of_days_boxes[j]).attr('id', 'no_of_days_' + count);
        }
    },
    fillData: function() {
        //        console.log("this.data.returnDetails")
        //        console.log(this.data.returnDetails)
        //fill return details
        $.each(this.data.returnDetails, function(key, item) {
            $('#' + key).attr("value", item);
        //$('#' + key).val(item);
        });

        //fill working details
        var workingDetails = this.data.workStoppageDetails;
        var total_reasons = 0;
        for (var i = 1; i <= 5; i++) {
            if (workingDetails['STOPPAGE_SN_' + i] != null)
                total_reasons++;
        }

        this.reasonCount.value = total_reasons;

        for (var i = 0; i < total_reasons; i++) {
            var elem_no = i + 1;
            var reason = workingDetails['STOPPAGE_SN_' + elem_no];
            var no_of_days = workingDetails['NO_DAYS_' + elem_no];
            this.createReasonBox(elem_no, reason, no_of_days);
        }

    //fill employment details
    /*$.each(this.data.empDetails, function(key, item){
         $('#' + key).val(item);
         });*/
    },
    getStaffTotal: function() {
        var whollyTotal = 0;
        var partlyTotal = 0;
        $(".wholly-emp-tot").focusout(function() {
            $('.wholly-emp-tot').each(function() {
                whollyTotal = parseFloat(whollyTotal) + parseFloat($(this).val());
            });
            $('#TOTAL_WHOLLY').val(whollyTotal);
            whollyTotal = 0;
        })

        $(".partly-emp-tot").focusout(function() {
            $('.partly-emp-tot').each(function() {
                partlyTotal = parseFloat(partlyTotal) + parseFloat($(this).val());
            });
            $('#TOTAL_PARTLY').val(partlyTotal);
            partlyTotal = 0;
        })
    }
}

var H1EmploymentWagesPart2 = {
    init: function(reasons_url, data_url) {
        this.reasonsUrl = reasons_url;
        this.dataUrl = data_url;
        this.reasonsTable = $("#reasons_table");
        this.reasonCount = $("#reason_count");
        Utilities.ajaxBlockUI();
        this.getEmpData();
        EmploymentWagesPart2.validateBigFormula();
    },
    getEmpData: function() {
        var _this = this;

        //get data
        $.ajax({
            url: _this.reasonsUrl,
            type: 'GET',
            success: function(response) {
                _this.reasons = json_parse(response);
                //get data
                $.ajax({
                    url: _this.dataUrl,
                    type: 'GET',
                    success: function(resp_data) {
                        _this.data = json_parse(resp_data);
                        if (_this.data.returnDetails == "") {
                            EmploymentWagesPart2.fieldValidation();
                        } else {
                            _this.fillData();
                            EmploymentWagesPart2.fieldValidation();
                        }
                    }
                });
            }
        });
    },
    fillData: function() {

        //fill return details
        $.each(this.data.returnDetails, function(key, item) {
            //$('#' + key).val(item);
            $('#' + key).attr("value", item);
        });

        //fill employment details
        $.each(this.data.empDetails, function(key, item) {
            $('#' + key).attr("value", item);
        //$('#' + key).val(item);
        });
    }
}

var H1MaterialConsumption = {
    init: function() {
    },
    fillConQtyData: function(qty_url) {
        Utilities.ajaxBlockUI();
        var _this = this;

        $.ajax({
            url: qty_url,
            type: 'GET',
            success: function(resp_data) {
                _this.data = json_parse(resp_data);

                $.each(_this.data, function(key, item) {
                    //$('#' + key).val(item);
                    $('#' + key).attr("value", item);
                });
            }
        });
    },
    fillConRoyaltyData: function(qty_url, depreciationTotal) {
        Utilities.ajaxBlockUI();
        var _this = this;

        $.ajax({
            url: qty_url,
            type: 'GET',
            success: function(resp_data) {
                _this.data = json_parse(resp_data);

                if (_this.data != "") {
                    $.each(_this.data, function(key, item) {
                        var elementKey = ('#' + key);
                        if (elementKey == '#DEPRECIATION') {
                            if (!isNaN(parseInt(item))) {
                                $(elementKey).attr("value", item)
                            //$(elementKey).val(item)
                            }
                            else {
                                //$(elementKey).val(depreciationTotal)
                                $(elementKey).attr("value", depreciationTotal)
                            }
                        }
                        else {
                            $(elementKey).attr("value", item)
                        }
                    });
                }
                else {
                    _this.fillDepreciationFromCapitalStruc(depreciationTotal);
                }
            }
        });
    },
    fillConTaxData: function(qty_url) {
        Utilities.ajaxBlockUI();
        var _this = this;

        $.ajax({
            url: qty_url,
            type: 'GET',
            success: function(resp_data) {
                _this.data = json_parse(resp_data);

                $.each(_this.data, function(key, item) {
                    //$('#' + key).val(item);
                    $('#' + key).attr("value", item);
                });
            }
        });
    },
    fillDepreciationFromCapitalStruc: function(depreciationTotal) {

        if (!isNaN(parseInt(depreciationTotal))) {
            $("#DEPRECIATION").val(depreciationTotal);
        }
    }
}

var H1Particulars = {
    init: function(data_url, prev_data_url) {
        Utilities.ajaxBlockUI();
        this.dataUrl = data_url;
        this.dataUrl2 = prev_data_url;
        this.leaseTable = $("#lease_table");
        this.addBtn = $("#add_table_btn");
        this.particularTableContainer = $("#particulars-table-container");
        this.getParticularsData();
    },
    getParticularsData: function() {
        var _this = this;
		var dataUrlResult = 'false';
        //get data
        $.ajax({
            url: _this.dataUrl,
            type: 'GET',
			async: false,
            success: function(response) {
                _this.data = json_parse(response);				
                dataUrlResult = 'true';
            }
        });
		
		if(dataUrlResult == 'true'){
			if (Object.keys(_this.data).length == 1) {
						
				$.ajax({
					url: _this.dataUrl2,
					type: 'GET',
					async: false,
					success: function(response) {
						_this.data = json_parse(response);
						if (Object.keys(_this.data).length == 1) {
							_this.renderParticularsTable(1, false);
						} else {
							//fill data
							$('#lease_no').val(_this.data[0]['lease_no']);

							var total_tables = Object.keys(_this.data).length;
							for (var i = 1; i <= total_tables; i++) {
								_this.renderParticularsTable(i, true);
							}

							$('#table_count').val(total_tables);
							_this.fillLeaseInfo();
						}
					}
				})
			} else {
				
				//fill data
				$('#lease_no').val(_this.data[0]['lease_no']);
				$('#add_info_lease').val(_this.data[0]['lease_info']);

				var total_tables = Object.keys(_this.data).length - 1;
				for (var i = 1; i <= total_tables; i++) {
					_this.renderParticularsTable(i, true);
				}

				$('#table_count').val(total_tables);
				_this.fillLeaseInfo();
			}

			_this.addTableBtn();
			Particular.fieldValidation();
		}	
    },
    renderParticularsTable: function(table_no, is_fill_data) {  
        var table = $(document.createElement('table'));
        table.attr('width', '90%');
        table.attr('cellpadding', '4');
        table.attr('bordercolor', '#E5D0BD');
        table.attr('border', '1');
        table.attr('style', 'border-collapse:collapse;margin-top:10px;');
        this.particularTableContainer.append(table);

        //lease no
        var lease_no_tr = $(document.createElement('tr'));
        table.append(lease_no_tr);

        var lease_no_label = $(document.createElement('td'));
        lease_no_label.attr("align", "left");
        lease_no_label.addClass("lable-text");
        lease_no_label.html("Lease No. Alloted by State Govt.");
        lease_no_tr.append(lease_no_label);

        var lease_no_box = $(document.createElement('td'));
        lease_no_box.attr("align", "left");
        lease_no_tr.append(lease_no_box);

        var lease_no = $(document.createElement('input'));
        lease_no.attr("id", 'lease_no_' + table_no);
        lease_no.attr("name", 'lease_no_' + table_no);
        lease_no.addClass('number-fields lease_no');
        lease_no.attr('style', 'width:200px;');
        lease_no_box.append(lease_no);
        if (is_fill_data == true)
            lease_no.attr("value", this.data[table_no - 1]['lease_no']);

        if (table_no > 1) {
            var close_btn = $(document.createElement('span'));
            close_btn.attr("id", "p_close_btn_" + table_no);
            close_btn.addClass("particulars-close-btn");
            lease_no_box.append(close_btn);

            close_btn.bind('click', function() {
                //remove the table
                $(this).parent().parent().parent().remove();

                //hidden table count
                var table_count = document.getElementById("table_count");
                var prev_table_count = table_count.value;
                var dec_table_count = parseInt(prev_table_count) - 1;
                table_count.value = dec_table_count;

                if (dec_table_count > 1) {
                    var prev_close_btn = document.getElementById('p_close_btn_' + dec_table_count)
                    prev_close_btn.className = "particulars-close-btn";
                }
            });
        }

        //area under lease label
        var area_lease_label_tr = $(document.createElement('tr'));
        table.append(area_lease_label_tr);

        var area_lease_label = $(document.createElement('td'));
        area_lease_label.attr("align", "left");
        area_lease_label.addClass("welcome-page-name");
        area_lease_label.html("(i) Area under lease");
        area_lease_label.attr("colspan", "2");
        area_lease_label_tr.append(area_lease_label);

        //under forest
        var under_forest_tr = $(document.createElement('tr'));
        table.append(under_forest_tr);

        var under_forest_label = $(document.createElement('td'));
        under_forest_label.attr("align", "left");
        under_forest_label.addClass("lable-text h-medium-label");
        under_forest_label.html("Under Forest");
        under_forest_label.attr('width', '50%');
        under_forest_tr.append(under_forest_label);

        var under_forest_box = $(document.createElement('td'));
        under_forest_box.attr("align", "left");
        under_forest_box.attr('width', '50%');
        under_forest_tr.append(under_forest_box);

        var under_forest = $(document.createElement('input'));
        under_forest.attr("id", 'under_forest_' + table_no);
        under_forest.attr("name", 'under_forest_' + table_no);
        under_forest.addClass('number-fields under_lease');
        under_forest.attr('style', 'width:110px;');
        under_forest_box.append(under_forest);
        if (is_fill_data == true)
            under_forest.attr("value", this.data[table_no - 1]['under_forest']);

        this.createUnit(under_forest_box, 'hectares');

        //outside forest
        var outside_forest_tr = $(document.createElement('tr'));
        table.append(outside_forest_tr);

        var outside_forest_label = $(document.createElement('td'));
        outside_forest_label.attr("align", "left");
        outside_forest_label.addClass("lable-text h-medium-label");
        outside_forest_label.html("Outside Forest");
        outside_forest_label.attr('width', '50%');
        outside_forest_tr.append(outside_forest_label);

        var outside_forest_box = $(document.createElement('td'));
        outside_forest_box.attr("align", "left");
        outside_forest_box.attr('width', '50%');
        outside_forest_tr.append(outside_forest_box);

        var outside_forest = $(document.createElement('input'));
        outside_forest.attr("id", 'outside_forest_' + table_no);
        outside_forest.attr("name", 'outside_forest_' + table_no);
        outside_forest.addClass('number-fields under_lease');
        outside_forest.attr('style', 'width:110px;');
        outside_forest_box.append(outside_forest);
        if (is_fill_data == true)
            outside_forest.attr("value", this.data[table_no - 1]['outside_forest']);

        this.createUnit(outside_forest_box, 'hectares');

        //total
        var total_tr = $(document.createElement('tr'));
        table.append(total_tr);

        var total_label = $(document.createElement('td'));
        total_label.attr("align", "left");
        total_label.addClass("lable-text h-medium-label");
        total_label.html("Total");
        total_label.attr('width', '50%');
        total_tr.append(total_label);

        var total_box = $(document.createElement('td'));
        total_box.attr("align", "left");
        total_box.attr('width', '50%');
        total_tr.append(total_box);

        var total = $(document.createElement('input'));
        total.attr("id", 'total_' + table_no);
        total.attr("name", 'total_' + table_no);
        total.addClass('number-fields total_under_lease');
        total.attr('style', 'width:110px;');
        total_box.append(total);
        if (is_fill_data == true)
            total.attr("value", this.data[table_no - 1]['total']);

        this.createUnit(total_box, 'hectares');

        //date of execution
        var execution_date_tr = $(document.createElement('tr'));
        table.append(execution_date_tr);

        var execution_date_label = $(document.createElement('td'));
        execution_date_label.attr("align", "left");
        execution_date_label.addClass("lable-text");
        execution_date_label.html("(ii) Date of execution of mining lease deed");
        execution_date_label.attr('width', '50%');
        execution_date_tr.append(execution_date_label);

        var execution_date_box = $(document.createElement('td'));
        execution_date_box.attr("align", "left");
        execution_date_box.attr('width', '50%');
        execution_date_tr.append(execution_date_box);

        var execution_date = $(document.createElement('input'));
        execution_date.attr("id", 'execution_date_' + table_no);
        execution_date.attr("name", 'execution_date_' + table_no);
        execution_date.addClass('number-fields execution_date');
        execution_date.attr('style', 'width:110px;');
        execution_date_box.append(execution_date);
        if (is_fill_data == true)
            execution_date.attr("value", this.data[table_no - 1]['execution_date']);

        //period of lease
        var lease_period_tr = $(document.createElement('tr'));
        table.append(lease_period_tr);

        var lease_period_label = $(document.createElement('td'));
        lease_period_label.attr("align", "left");
        lease_period_label.addClass("lable-text");
        lease_period_label.html("(iii) Period of lease");
        lease_period_label.attr('width', '50%');
        lease_period_tr.append(lease_period_label);

        var lease_period_box = $(document.createElement('td'));
        lease_period_box.attr("align", "left");
        lease_period_box.attr('width', '50%');
        lease_period_tr.append(lease_period_box);

        var lease_period = $(document.createElement('input'));
        lease_period.attr("id", 'lease_period_' + table_no);
        lease_period.attr("name", 'lease_period_' + table_no);
        lease_period.addClass('number-fields  leasePeriod');
        lease_period.attr('style', 'width:110px;');
        lease_period_box.append(lease_period);
        if (is_fill_data == true)
            lease_period.attr("value", this.data[table_no - 1]['lease_period']);

        //surface area rights
        var surface_rights_tr = $(document.createElement('tr'));
        table.append(surface_rights_tr);

        var surface_rights_label = $(document.createElement('td'));
        surface_rights_label.attr("align", "left");
        surface_rights_label.addClass("lable-text");
        surface_rights_label.html("(iv) Area for which surface rights are held");
        surface_rights_label.attr('width', '50%');
        surface_rights_tr.append(surface_rights_label);

        var surface_rights_box = $(document.createElement('td'));
        surface_rights_box.attr("align", "left");
        surface_rights_box.attr('width', '50%');
        surface_rights_tr.append(surface_rights_box);

        var surface_rights = $(document.createElement('input'));
        surface_rights.attr("id", 'surface_rights_' + table_no);
        surface_rights.attr("name", 'surface_rights_' + table_no);
        surface_rights.addClass('number-fields under_lease');
        surface_rights.attr('style', 'width:110px;');
        surface_rights_box.append(surface_rights);
        if (is_fill_data == true)
            surface_rights.attr("value", this.data[table_no - 1]['surface_rights']);

        this.createUnit(surface_rights_box, 'hectares');

        //renewal date
        var renewal_date_tr = $(document.createElement('tr'));
        table.append(renewal_date_tr);

        var renewal_date_label = $(document.createElement('td'));
        renewal_date_label.attr("align", "left");
        renewal_date_label.addClass("lable-text");
        renewal_date_label.html("(v) (a) Date of renewal (if applicable)");
        renewal_date_label.attr('width', '50%');
        renewal_date_tr.append(renewal_date_label);

        var renewal_date_box = $(document.createElement('td'));
        renewal_date_box.attr("align", "left");
        renewal_date_box.attr('width', '50%');
        renewal_date_tr.append(renewal_date_box);

        var renewal_date = $(document.createElement('input'));
        renewal_date.attr("id", 'renewal_date_' + table_no);
        renewal_date.attr("name", 'renewal_date_' + table_no);
        renewal_date.addClass('number-fields renewal_date');
        renewal_date.attr('style', 'width:110px;');
        renewal_date_box.append(renewal_date);
        if (is_fill_data == true)
            renewal_date.attr("value", this.data[table_no - 1]['renewal_date']);


        //renewal period
        var renewal_period_tr = $(document.createElement('tr'));
        table.append(renewal_period_tr);

        var renewal_period_label = $(document.createElement('td'));
        renewal_period_label.attr("align", "left");
        renewal_period_label.addClass("lable-text h-medium-label");
        renewal_period_label.html("(b) Period of renewal (if applicable)");
        renewal_period_label.attr('width', '50%');
        renewal_period_tr.append(renewal_period_label);

        var renewal_period_box = $(document.createElement('td'));
        renewal_period_box.attr("align", "left");
        renewal_period_box.attr('width', '50%');
        renewal_period_tr.append(renewal_period_box);

        var renewal_period = $(document.createElement('input'));
        renewal_period.attr("id", 'renewal_period_' + table_no);
        renewal_period.attr("name", 'renewal_period_' + table_no);
        renewal_period.addClass('number-fields period');
        renewal_period.attr('style', 'width:110px;');
        renewal_period_box.append(renewal_period);
        if (is_fill_data == true)
            renewal_period.attr("value", this.data[table_no - 1]['renewal_period']);


        Utilities.datePickerWithSlash(".renewal_date", 1900);
        Utilities.datePickerWithSlash(".execution_date", 1900);

        Particular.fieldValidation();
        Particular.renewalDateAlert();

    },
    createUnit: function(parent, text) {
        var unit = $(document.createElement('span'));
        unit.html(text);
        unit.attr('style', 'font-weight:bold;padding-left:5px;');
        parent.append(unit);
    },
    addTableBtn: function() {
        var _this = this;

        this.addBtn.bind('click', function() {
            //hidden table count
            var table_count = document.getElementById("table_count");
            var prev_table_count = table_count.value;

            if (table_count.value == 5) {
                alert("Sorry! You can't add more than 5 records");
                return;
            }
            var inc_table_count = parseInt(prev_table_count) + 1;
            table_count.value = inc_table_count;

            _this.renderParticularsTable(inc_table_count, false);
            Utilities.datePicker(".date");

            //hide the close btn for the previous table, so that we could avoid the rename function
            if (prev_table_count > 1) {
                var prev_close_btn = document.getElementById('p_close_btn_' + prev_table_count)
                prev_close_btn.className = "";
            }
        });
    },
    fillLeaseInfo: function() {
        var _this = this;
        //FOR SELECTING THE MULTIPLE BOX
        var leaseInfo = parseInt(_this.data[0]['lease_info']);
        if (!isNaN(leaseInfo)) {
            $.each(leaseInfo, function(key, item) {
                $('#add_info_lease[value=' + item + ']').attr('selected', true);
            });
        }
    }
}

var H1ExplosiveConsumption = {
    fillExplosiveConsumptionData: function(explosive_url) {
        Utilities.ajaxBlockUI();
        var _this = this;
        $.ajax({
            url: explosive_url,
            type: 'GET',
            success: function(resp_data) {
                _this.data = json_parse(resp_data);
                $.each(_this.data, function(key, item) {
                    $('#' + key).attr("value", item);
                //$('#' + key).val(item);
                });
            }
        });
    },
    fillExplosiveReturnData: function(expReturnUrl) {
        var _this = this;

        $.ajax({
            url: expReturnUrl,
            type: 'GET',
            success: function(resp_data) {
                _this.data = json_parse(resp_data);

                $.each(_this.data, function(key, item) {
                    //$("#"+ key).val(item);
                    $('#' + key).attr("value", item);
                });
            }
        });
    }
}
var H1GeologyPart1 = {
    init: function(data_url, sizeRangeUrl) {
        Utilities.ajaxBlockUI();
        this.oreTypes = new Array('Lump', 'Fines', 'Friable', 'Granular', 'Platy', 'Fibrous', 'Other-ore');
        this.dataUrl = data_url;
        this.sizeRangeDataUrl = sizeRangeUrl;
        this.getPart1Data();
        GeologyPart1.fieldValidation();
    },
    getPart1Data: function() {
        var _this = this;
        Utilities.ajaxBlockUI();
        $.ajax({
            url: _this.dataUrl,
            async: false,
            success: function(response) {
                $.ajax({
                    url: _this.sizeRangeDataUrl,
                    async: false,
                    success: function(sizeRangeResponse) {
                        _this.sizeRange = json_parse(sizeRangeResponse)
                    }
                });
				
                _this.data = json_parse(response);
                _this.associateMins = _this.data.assoMin;
                _this.constituents = _this.data.constituents;
                _this.nmiGrades = new Array('Select', 'Lump High Grade', 'Lump Medium Grade', 'Lump Low Grade');
                _this.formData = _this.data.form_data;

                if (_this.formData.min_worked != null) { 
                    Utilities.ajaxBlockUI(); 
                    _this.checkValEdit = 0;
                    $.ajax({
                        async: false,
                        success: function(res) {
							//alert(res);
                            _this.renderQualityEditForm(_this.sizeRange);							
                        }
                    });
					
                    _this.renderQualityBox();
                //          $("#geology-qualityid").after(_this.constituentTable);
                } else {
					
                    _this.createQualityForm(false, _this.sizeRange);
                }
            }
        });
    },
    createQualityForm: function(is_fill_data, sizeRange) { 
        var _this = this;
        $("#other_ore_type_text").keyup(function() { // CHANGED THE FUNCTION FROM BLUR TO KEY UP AS SOME NONSENSE WAS GOING ON  @uday shankar singh @14FEB2014
            
			var otherOreName = htmlEntities($("#other_ore_type_text").val(),'other_ore_type_text');


            var ore_type = $("#other_ore_type").val();
            var hidden_total_ores = $("#total_ores");
            var prev_total_ore = hidden_total_ores.val();
            _this.checkVal = prev_total_ore;
            _this.checkValEdit = prev_total_ore;
            $("#other_ore_type_text").focus(function() {

                });

            if (otherOreName) { 

                if ($("#other_ore_type").is(':checked') == false) {
                    $("#other_ore_type").prop('checked', true);
                    var other_ore = htmlEntities($('#other_ore_type_text').val(),'other_ore_type_text');
                    _this.oreTypes.push(other_ore); 
                    //increase the total ore count
                    hidden_total_ores.val(parseInt(prev_total_ore) + 1);
                    _this.createConstituentBox(ore_type, 1, is_fill_data, sizeRange);
                } else {
                    var other_ore = htmlEntities($('#other_ore_type_text').val(),'other_ore_type_text');
                    var removedElement = _this.oreTypes.pop();
                    _this.oreTypes.push(other_ore);
                    $("#otherOreId").empty().text("for " + other_ore);
                }

            } else { 
                $("#other_ore_type").prop('checked', false);
                _this.oreTypes.pop();
                //decrease the total count
                hidden_total_ores.val(parseInt(prev_total_ore) - 1);

                $(".typeOfOre" + ore_type).remove();
                $(".quality-table-container-" + ore_type).remove();
                $("#constituent_table_add_more_btn_" + ore_type).remove();
                if ($("input[class=ore-box]:checked").length == 0)
                {
                    $(".getwholecoutclass").val(1);
                    $("#geology-qualityid").remove();
                    $("#grade_percent_table").remove();

                }
            }

        });

        $('.ore-box').click(function() { 
            var ore_type = $(this).val();
            var hidden_total_ores = $("#total_ores");
            var prev_total_ore = hidden_total_ores.val();
            _this.checkVal = prev_total_ore;
            _this.checkValEdit = prev_total_ore;
            if ($(this).is(':checked')) {
                if (ore_type == 7) {
                    var other_ore = htmlEntities($('#other_ore_type_text').val(),'other_ore_type_text');
                    if (other_ore == "") {
                        $(this).attr('checked', false);
                        alert('Please enter the text first!');
                        return;
                    }
                    _this.oreTypes.push(other_ore);
                }
                //increase the total ore count

                hidden_total_ores.val(parseInt(prev_total_ore) + 1);

                _this.createConstituentBox(ore_type, 1, is_fill_data, sizeRange);
            } else { 
                if (ore_type == 7) {
					// clear the other_ore_type_text box value of unselect of other ore type // Done by Pravin Bhakare, 25-03-2021
                    var other_ore = htmlEntities($('#other_ore_type_text').val(),'other_ore_type_text');
                    $('#other_ore_type_text').val("");
                    _this.oreTypes.pop();
                }
                //decrease the total count
                hidden_total_ores.val(parseInt(prev_total_ore) - 1);

                $(".typeOfOre" + ore_type).remove();
                $(".quality-table-container-" + ore_type).remove();
                $("#constituent_table_add_more_btn_" + ore_type).remove();
                if ($("input[class=ore-box]:checked").length == 0)
                {
                    $(".getwholecoutclass").val(1);
                    $("#geology-qualityid").remove();
                    $("#grade_percent_table").remove();

                }
            }

        });
		
    },
    createConstituentBox: function(ore_type, elem_no, is_fill_data, sizeRange) { 

        if (is_fill_data == false) { 

            /********** TABLE & HEADER *************/
            this.createConstituentHeader(ore_type, elem_no, 0);

            /********** SIZE RANGE *************/
            this.createSizeRangeBox(ore_type, elem_no, is_fill_data, sizeRange);

            /********** PRINCIPAL CONSTITUENT *************/
            this.createPrincipalConstBox(ore_type, elem_no, is_fill_data);

            //render subsidiary rows
            this.createSubsidiaryRow(this.constituentTable, ore_type, elem_no, 1, false);

            /********** INITIALIZE ADD BTN *************/
            this.addConstituentBox(this.constituentTable, ore_type, elem_no, 0, sizeRange);

            /********** INITIALIZE THE HIDDEN SUBSDIRARY ROW COUNT *************/
            //<<<<<<< .mine
            //      if(this.formData.min_worked != null)
            //      {
            //        var subs_row_count = $(document.createElement('input'));
            //        subs_row_count.attr("type","hidden");
            //        subs_row_count.attr("id","subs_row_count_" + ore_type + "_" + elem_no);
            //        subs_row_count.attr("name","subs_row_count_" + ore_type + "_" + elem_no);
            //        subs_row_count.attr("value",1);
            //        this.constituentTable.append(subs_row_count);
            //      } 
            //=======

            var subs_row_count = $(document.createElement('input'));
            subs_row_count.attr("type", "hidden");
            subs_row_count.attr("id", "subs_row_count_" + ore_type + "_" + elem_no);
            subs_row_count.attr("name", "subs_row_count_" + ore_type + "_" + elem_no);
            subs_row_count.attr("value", 1);
            this.principal_tr.append(subs_row_count);

            //>>>>>>> .r6611

            /********** CREATE QUALITY PART 2 *************/
//console.log(this.checkVal)
/**
 * COMMENTED THE BELOW IF CONDITION AS AS PER ME THIS IS USELESS AND ALSO THIS
 * IS THE REASON AS PER ME THAT WAS CAUSING THE FORM KEEP ON LOADING IN SOME OF
 * THE CASES AS THE QUANTITY BOX WAS NOT GETTING ADDED IN SOME OF THE CASES
 * 
 * CAN BE UNDO IF IT CAUSES SOME PROBLEM
 * 
 * @author Uday Shankar Singh <usingh@ubicsindia.com,  udayshankar1306@gmail.com>
 * @version 17th FEB 2014
 **/
//            if (this.checkVal == 0)
//            {
                this.createQualityPart2(this.qualityTableContainer, ore_type, is_fill_data);
                this.createGradePercentBox(this.qualityTableContainer, ore_type, elem_no, is_fill_data);
//            }
        //this.createGradePercentBox(this.qualityTableContainer, ore_type, elem_no, is_fill_data);

        /********** HIDDEN GRADE PERCENT ROW COUNT *************/

        } else { 
            var total_const_tables = this.formData.const_details[ore_type]['total_const_tables'];
            for (var k = 1; k <= total_const_tables; k++) {
                this.createConstituentHeader(ore_type, k, 0);
                this.createSizeRangeBox(ore_type, k, is_fill_data, sizeRange);
                this.createPrincipalConstBox(ore_type, k, is_fill_data);

                //<<<<<<< .mine
                //        var total_subsidiary_rows = this.formData.const_details[ore_type][k]['subsidiary_const'].length;
                //        /********** CREATE HIDDEN SUBSDIRARY ROW COUNT *************/
                //        var subs_row_count = $(document.createElement('input'));
                //        subs_row_count.attr("type","hidden");
                //        subs_row_count.attr("id","subs_row_count_" + ore_type + "_" + k);
                //        subs_row_count.attr("name","subs_row_count_" + ore_type + "_" + k);
                //        subs_row_count.attr("value",total_subsidiary_rows);
                //        this.constituentTable.append(subs_row_count);
                //=======
                var total_subsidiary_rows = this.formData.const_details[ore_type][k]['subsidiary_const'].length;
                /********** CREATE HIDDEN SUBSDIRARY ROW COUNT *************/

                //>>>>>>> .r6611

                for (var i = 1; i <= total_subsidiary_rows; i++)
                    this.createSubsidiaryRow(this.constituentTable, ore_type, k, i, is_fill_data);

                this.addConstituentBox(this.constituentTable, ore_type, elem_no, 0, sizeRange);
                /********** HIDDEN GRADE PERCENT ROW COUNT *************/
                var subs_row_count = $(document.createElement('input'));
                subs_row_count.attr("type", "hidden");
                subs_row_count.attr("id", "subs_row_count_" + ore_type + "_" + k);
                subs_row_count.attr("name", "subs_row_count_" + ore_type + "_" + k);
                subs_row_count.attr("value", total_subsidiary_rows);
                this.principal_tr.append(subs_row_count);
            }
        }
    },
    createSubsidiaryRow: function(table_obj, ore_type, table_count, elem_no, is_fill_data) { 
        var _this = this;

        var subs_tr = $(document.createElement('tr'));
        table_obj.append(subs_tr);

        var subs_label_td = $(document.createElement('td'));
        if (elem_no == 1)
            subs_label_td.html("(ii) Subsidiary Constituent");
        else
            subs_label_td.html("");
        subs_label_td.attr("align", "left");
        subs_label_td.addClass("lable-text");
        subs_tr.append(subs_label_td);

        var subs_box_td = $(document.createElement('td'));
        subs_label_td.attr("align", "left");
        subs_tr.append(subs_box_td);

        var subs_select_box = $(document.createElement('select'));
        subs_select_box.attr("id", "subs_const_" + ore_type + "_" + table_count + "_" + elem_no);
        subs_select_box.attr("name", "subs_const_" + ore_type + "_" + table_count + "_" + elem_no);
        subs_select_box.addClass("subs_const_mine_select h-selectbox subs-constituent-" + ore_type + "-" + table_count);
        subs_box_td.append(subs_select_box);

        $.each(this.constituents, function(index, item) {
            var subs_options = $(document.createElement('option'));
            subs_options.html(item);
            if (item == "Select")
                subs_options.val('');
            else
                subs_options.val(item);
            subs_select_box.append(subs_options);
        });


        if (is_fill_data == true)
            subs_select_box.attr("value", this.formData.const_details[ore_type][table_count]['subsidiary_const'][elem_no - 1]);

        var subs_grade_td = $(document.createElement('td'));
        subs_grade_td.attr("align", "left");
        subs_tr.append(subs_grade_td);

        var subs_grade_txtbox = $(document.createElement('input'));
        subs_grade_txtbox.attr("id", "subs_grade_" + ore_type + "_" + table_count + "_" + elem_no);
        subs_grade_txtbox.attr("name", "subs_grade_" + ore_type + "_" + table_count + "_" + elem_no);
        subs_grade_txtbox.addClass("subs_mine_grade subs-grade-" + ore_type + "-" + table_count);
        subs_grade_txtbox.css("width", "80px");
        subs_grade_td.append(subs_grade_txtbox);

        if (is_fill_data == true)
            subs_grade_txtbox.attr("value", this.formData.const_details[ore_type][table_count]['subsidiary_const_grade'][elem_no - 1]);

        if (elem_no == 1) {
            var subs_add_td = $(document.createElement('td'));
            subs_add_td.html("Add More");
            subs_add_td.addClass("h-add-more-btn subs-add-btn");
            subs_tr.append(subs_add_td);
            subs_add_td.bind('click', function() {
                //hidden metal count
                var subsidiaryCount = document.getElementById('subs_row_count_' + ore_type + "_" + table_count);
                var prev_subs_count = subsidiaryCount.value;
                var inc_subs_count = parseInt(prev_subs_count) + 1;
                subsidiaryCount.value = inc_subs_count;
                _this.createSubsidiaryRow(table_obj, ore_type, table_count, inc_subs_count, false);
            });
        } else {
            //close button
            var close_td = $(document.createElement('td'));
            close_td.addClass("h-close-icon subs-close-icon");
            close_td.bind('click', function() {
                $(this).parent().remove();
                //rename the id and name for the other text and select boxes
                _this.renameSubsidiaryBoxes(ore_type, table_count);
                //hidden metal count
                var subsidiaryCount = document.getElementById('subs_row_count_' + ore_type + "_" + table_count);
                var prev_subs_count = subsidiaryCount.value;
                var dec_subs_count = parseInt(prev_subs_count) - 1;
                subsidiaryCount.value = dec_subs_count;
            });
            subs_tr.append(close_td);
        }
    },
    createSizeRangeBox: function(ore_type, elem_no, is_fill_data, sizeRange) {
        var size_tr = $(document.createElement('tr'));
        this.constituentTable.append(size_tr);

        var size_label_td = $(document.createElement('td'));
        size_label_td.html("(i) Size Range");
        size_label_td.css("align", "left");
        size_label_td.addClass("lable-text");
        size_tr.append(size_label_td);

        var size_box_td = $(document.createElement('td'));
        size_label_td.attr("align", "left");
        size_tr.append(size_box_td);

        var size_select_box = $(document.createElement('select'));
        size_select_box.attr("id", "size_range_" + ore_type + "_" + elem_no);
        size_select_box.attr("name", "size_range_" + ore_type + "_" + elem_no);
        size_select_box.addClass("size_range_mine_select h-selectbox size-range-selectbox");
        size_box_td.append(size_select_box);

        //    console.log(sizeRange)
        //    var size_option_array = new Array('Select', 5, 4, 3);
        var size_option_array = sizeRange;
        $.each(size_option_array, function(index, item) {
            var size_options = $(document.createElement('option'));
            size_options.html(item);
            if (item == 'Select')
                size_options.val('');
            else
                size_options.val(item);
            size_select_box.append(size_options);
        });

        if (is_fill_data == true)
            size_select_box.attr("value", this.formData.const_details[ore_type][elem_no]['size_range']);

		 

    },
    createPrincipalConstBox: function(ore_type, elem_no, is_fill_data) {  
        this.principal_tr = $(document.createElement('tr'));
        this.constituentTable.append(this.principal_tr);

        var principal_label_td = $(document.createElement('td'));
        principal_label_td.html("(ii) Principal Constituent");
        principal_label_td.attr("align", "left");
        principal_label_td.addClass("lable-text");
        this.principal_tr.append(principal_label_td);

        var principal_box_td = $(document.createElement('td'));
        principal_label_td.attr("align", "left");
        this.principal_tr.append(principal_box_td);

        var principal_select_box = $(document.createElement('select'));
        principal_select_box.attr("id", "principal_const_" + ore_type + "_" + elem_no);
        principal_select_box.attr("name", "principal_const_" + ore_type + "_" + elem_no);
        principal_select_box.addClass("principal_const_mine_select h-selectbox principal-selectbox");
        principal_box_td.append(principal_select_box);

        $.each(this.constituents, function(index, item) {
            var principal_options = $(document.createElement('option'));
            principal_options.html(item);
            if (item == 'Select')
                principal_options.val('');
            else
                principal_options.val(item);
            principal_select_box.append(principal_options);
        });

        if (is_fill_data == true)
            principal_select_box.attr("value", this.formData.const_details[ore_type][elem_no]['principal_const']);

        var principal_grade_td = $(document.createElement('td'));
        principal_grade_td.attr("align", "left");
        principal_grade_td.attr("colspan", 2);
        this.principal_tr.append(principal_grade_td);

        var principal_grade_txtbox = $(document.createElement('input'));
        principal_grade_txtbox.attr("id", "principal_grade_" + ore_type + "_" + elem_no);
        principal_grade_txtbox.attr("name", "principal_grade_" + ore_type + "_" + elem_no);
        principal_grade_txtbox.addClass("principal_mine_grade principal-textbox");
        principal_grade_txtbox.css("width", "80px");
        principal_grade_td.append(principal_grade_txtbox);

        if (is_fill_data == true)
            principal_grade_txtbox.attr("value", this.formData.const_details[ore_type][elem_no]['principal_const_grade']);
    },
    renameSubsidiaryBoxes: function(ore_type, table_count) { 
        var subs_select_boxes = $(".subs-constituent-" + ore_type + "-" + table_count);
        var subs_text_boxes = $(".subs-grade-" + ore_type + "-" + table_count);

        for (var j = 0; j < subs_select_boxes.length; j++) {
            var elem_count = j + 1;
            $(subs_select_boxes[j]).attr('name', 'subs_const_' + ore_type + "_" + table_count + '_' + elem_count);
            $(subs_select_boxes[j]).attr('id', 'subs_const_' + ore_type + "_" + table_count + '_' + elem_count);

            $(subs_text_boxes[j]).attr('name', 'subs_grade_' + ore_type + "_" + table_count + '_' + elem_count);
            $(subs_text_boxes[j]).attr('id', 'subs_grade_' + ore_type + "_" + table_count + '_' + elem_count);
        }
    },
    createConstituentHeader: function(ore_type, table_count, cnt) { 

        if (this.oreTypes[ore_type - 1] == 'Other-ore') {
            if (this.formData.min_worked != null)
                this.oreTypes[ore_type - 1] = this.formData.min_worked['ore_other'];
            else {
                var otherValue = $("#other_ore_type_text").val();
                this.oreTypes[ore_type - 1] = otherValue;
            }
        }
        var _this = this;
        var oreTableContainer = $('#ore_type_table_container');
        this.qualityTableContainer = $('#quality-table-container-' + ore_type);

        if (table_count == 1) {

            this.qualityTableContainer = $(document.createElement('div'));
            this.qualityTableContainer.attr("id", 'quality-table-container-' + ore_type);
            this.qualityTableContainer.addClass('belowmineralInfo quality-table-container-' + ore_type);
        }

        this.constituentTable = $(document.createElement('table'));
        this.constituentTable.attr("id", "constituent_table_" + ore_type + "_" + table_count);
        this.constituentTable.addClass("constituent-table typeOfOre" + ore_type);
        this.constituentTable.attr("cellpadding", "4");
        this.constituentTable.attr("border", "1");
        this.constituentTable.attr("bordercolor", "#E5D0BD");
        this.qualityTableContainer.append(this.constituentTable);
        if (cnt == 0)
        {
            oreTableContainer.append(this.qualityTableContainer);
        } else
		{
            var pre_date = table_count - 1;
            $("#constituent_table_" + ore_type + "_" + pre_date).append(this.constituentTable);
        }
        if (table_count == 1) {
            var dummy_tr = $(document.createElement('tr'));
            dummy_tr.html("&nbsp;");
            this.constituentTable.append(dummy_tr);

            if (ore_type == 1)
                var nameMineral = "<span style='color: #0000FF'>for " + this.oreTypes[ore_type - 1] + "</span>";
            if (ore_type == 2)
                var nameMineral = "<span style='color: #FF0000'>for " + this.oreTypes[ore_type - 1] + "</span>";
            if (ore_type == 3)
                var nameMineral = "<span style='color: #006400'>for " + this.oreTypes[ore_type - 1] + "</span>";
            if (ore_type == 4)
                var nameMineral = "<span style='color: #800000'>for " + this.oreTypes[ore_type - 1] + "</span>";
            if (ore_type == 5)
                var nameMineral = "<span style='color: #C71585'>for " + this.oreTypes[ore_type - 1] + "</span>";
            if (ore_type == 6)
                var nameMineral = "<span style='color: #008080'>for " + this.oreTypes[ore_type - 1] + "</span>";
            if (ore_type == 7)
                var nameMineral = "<span id='otherOreId' style='color: #008080'>for " + $("#other_ore_type_text").val() + "</span>";

            var quality_header_row = $(document.createElement('tr'));
            this.constituentTable.append(quality_header_row);
            var quality_header_td = $(document.createElement('td'));
            // var nameMineral = "<span style='color: #FF0000'>for " + this.oreTypes[ore_type-1] + "</span>";
            quality_header_td.html("(c) Quality: Chemical Analysis of Typical Grades Produced " + nameMineral);
            quality_header_td.addClass("lable-text");
            quality_header_td.attr('colspan', 5);
            quality_header_row.append(quality_header_td);
        }
        var header_row = $(document.createElement('tr'));
        this.constituentTable.append(header_row);

        var const_header = $(document.createElement('th'));
        const_header.html("Constituent");
        const_header.addClass("form-table-title");
        header_row.append(const_header);

        var empty_header = $(document.createElement('th'));
        empty_header.html("&nbsp;");
        empty_header.addClass("form-table-title");
        header_row.append(empty_header);

        var grade_header = $(document.createElement('th'));
        grade_header.html("Grade %");
        grade_header.addClass("form-table-title");
        header_row.append(grade_header);

        //create the const_table_count hidden field
        var constTableCount = $("#const_table_count_" + ore_type);
        if (_this.formData.min_worked != null) {
            $("#const_table_count_" + ore_type).remove();
            // var getTotalVal2 = $("#getWholeCnt_"+ore_type).val();

            var constTableCount = $(document.createElement('input'));
            constTableCount.attr("type", 'hidden');
            constTableCount.attr("id", 'const_table_count_' + ore_type);
            constTableCount.attr("name", 'const_table_count_' + ore_type);
            constTableCount.attr("value", table_count);
            this.constituentTable.append(constTableCount);
        } else
		{
            if (table_count == 1)
            {
                var constTableCount = $(document.createElement('input'));
                constTableCount.attr("type", 'hidden');
                constTableCount.attr("id", 'const_table_count_' + ore_type);
                constTableCount.attr("name", 'const_table_count_' + ore_type);
                constTableCount.attr("value", '1');
                this.constituentTable.append(constTableCount);
            }
        }
        //<<<<<<< .mine
        //    if(_this.formData.min_worked == null){
        //      var subs_row_count = $(document.createElement('input'));
        //      subs_row_count.attr("type","hidden");
        //      subs_row_count.attr("id","subs_row_count_" + ore_type + "_" + table_count);
        //      subs_row_count.attr("name","subs_row_count_" + ore_type + "_" + table_count);
        //      subs_row_count.attr("value",1);
        //      _this.constituentTable.append(subs_row_count);
        //    }
        //=======
        //    
        //>>>>>>> .r6611
        if (table_count == 1)
            grade_header.attr("colspan", "2");
        else {

            //close button
            var close_td = $(document.createElement('td'));
            close_td.addClass("h-close-icon const-table-close-icon");
            close_td.bind('click', function() {

                //to avoid collation with subsidary row close icon
                if (close_td.attr("class") != "h-close-icon const-table-close-icon")
                    return;

                $(this).parent().parent().remove();


                /********** HIDDEN TABLE COUNT *************/
                // console.log("sdfsd")
                var constTableCount = $("#const_table_count_" + ore_type);
                var prev_const_table_count = constTableCount.val();
                var dec_const_table_count = parseInt(prev_const_table_count) - 1;
                constTableCount.val(dec_const_table_count);
                //show close icon
                var prev_table = $("#constituent_table_" + ore_type + "_" + dec_const_table_count)
                var temp = $(prev_table).children(':first-child').children();
                var close_icon = $(temp[0]).children(':last');
                $(close_icon).removeClass().addClass('h-close-icon const-table-close-icon');

                $(prev_table).find('table').remove();
            });
            header_row.append(close_td);
        }
		
    },
    addConstituentBox: function(table, ore_type, elem_no, addcnt, sizeRange) { 
        var _this = this;
        var add_btn_container = $(document.createElement('table'));
        var add_btn = $(document.createElement('tr'));
        var add_btn1 = $(document.createElement('td'));
        add_btn1.html('Add More');
        add_btn1.attr("id", 'constituent_table_add_more_btn_' + ore_type);
        add_btn1.addClass('h-add-more-btn');
        add_btn1.attr('align', 'left');
        add_btn1.attr('style', 'display:block;text-align:left; margin:5px;');
        add_btn.append(add_btn1);
        add_btn.attr('align', 'left');
        if (_this.formData.min_worked != null) {
            if (addcnt == 1)
            {
                $("#getWholeCnt_" + ore_type).val(1)
                add_btn_container.append(add_btn);
            }
            var constTableCount = $("#const_table_count_" + ore_type);
            var prev_const_table_count = constTableCount.val();
            var inc_const_table_count = parseInt(prev_const_table_count) + 1;
            var getTotalVal = $("#getWholeCnt_" + ore_type).val();
            if (getTotalVal > prev_const_table_count)
            {
                var prev_table = $("#constituent_table_" + ore_type + "_" + prev_const_table_count)
                var temp = $(prev_table).children(':first-child').children();
                var close_icon = $(temp[0]).children(':last');
                $(close_icon).removeClass().addClass('form-table-title');
            }
            if ((prev_const_table_count == 1) && (typeof(getTotalVal) == 'undefined'))
            {
                add_btn_container.append(add_btn);
            }
            if (getTotalVal == prev_const_table_count) {
                add_btn_container.append(add_btn);
            }
            if (addcnt == 1)
            {
                add_btn_container.append(add_btn);
            }

            if (_this.checkValEdit != 0)
            {
                add_btn_container.append(add_btn);
            }
        } else
{
            add_btn_container.append(add_btn);
        }
        add_btn_container.attr('width', '100%');
        add_btn.bind('click', function() {
            /********** HIDDEN TABLE COUNT *************/
            var constTableCount = $("#const_table_count_" + ore_type);
            var prev_const_table_count = constTableCount.val();
            var inc_const_table_count = parseInt(prev_const_table_count) + 1;
            constTableCount.val(inc_const_table_count);
            if (prev_const_table_count != 1) {
                var prev_table = $("#constituent_table_" + ore_type + "_" + prev_const_table_count)
                var temp = $(prev_table).children(':first-child').children();
                //var close_icon = temp[0];
                var close_icon = $(temp[0]).children(':last');
                $(close_icon).removeClass().addClass('form-table-title');

            }

            /********** TABLE & HEADER *************/
            _this.createConstituentHeader(ore_type, inc_const_table_count, 1);

            /********** SIZE RANGE *************/

            _this.createSizeRangeBox(ore_type, inc_const_table_count, false, sizeRange);

            /********** PRINCIPAL CONSTITUENT *************/
            _this.createPrincipalConstBox(ore_type, inc_const_table_count, false);
            if (inc_const_table_count != 1)
            {
                $("#constituent_table_" + ore_type + "_" + prev_const_table_count).after(_this.constituentTable);
            }
            /********** INITIALIZE THE HIDDEN SUBSDIRARY ROW COUNT *************/
            var subs_row_count = $(document.createElement('input'));
            subs_row_count.attr("type", "hidden");
            subs_row_count.attr("id", "subs_row_count_" + ore_type + "_" + inc_const_table_count);
            subs_row_count.attr("name", "subs_row_count_" + ore_type + "_" + inc_const_table_count);
            subs_row_count.attr("value", 1);
            _this.principal_tr.append(subs_row_count);
            /********** SUBSIDIARY CONSTITUENT *************/
            _this.createSubsidiaryRow(_this.constituentTable, ore_type, inc_const_table_count, 1, false);
            /********** INITIALIZE ADD BTN *************/
            _this.addConstituentBox(_this.constituentTable, ore_type, inc_const_table_count, 1, sizeRange);

            //remove the add button itself since a new button is creating again
            $(this).remove();
        });
        //<<<<<<< .mine
        //    $(table).append(add_btn_container);
        //    //FOR EDITING SECTION ONLY
        //    if(addcnt ==  1 && this.formData.min_worked != null)
        //    {
        //      var constTableCount1 = $("#const_table_count_" + ore_type);
        //      var prev_const_table_count1 = constTableCount1.val();
        //      var inc_const_table_count1 = parseInt(prev_const_table_count1) + 1;
        //      var subs_row_count = $(document.createElement('input'));
        //      subs_row_count.attr("type","hidden");
        //      subs_row_count.attr("id","subs_row_count_" + ore_type + "_" + inc_const_table_count1);
        //      subs_row_count.attr("name","subs_row_count_" + ore_type + "_" + inc_const_table_count1);
        //      subs_row_count.attr("value",1);
        //      _this.constituentTable.append(subs_row_count);
        //    }     
        //=======
        var constTableId = $("#const_table_count_" + ore_type);
        var prev_constVal = constTableId.val();
        $("#constituent_table_" + ore_type + "_" + prev_constVal).after(add_btn_container);



    //>>>>>>> .r6611
    },
    createQualityPart2: function(table_container, ore_type, is_fill_data) { 
        var isClassExists = $('table').hasClass('geology-quality-table');
        if (isClassExists == false) {

            this.div_table = $(document.createElement('div'));
            this.div_table.attr('id', 'geology-qualityid');
            var table = $(document.createElement('table'));
            table.addClass('geology-quality-table');
            table.attr('width', '100%');
            //table.attr('id','geology-qualityid');
            table.attr('border', '1');
            table.attr('bordercolor', '#E5D0BD');
            table.attr('style', 'border-collapse:collapse');

            this.div_table.append(table);
            //$(table_container).after(this.div_table);
            $('#ore_type_get_geology2').append(this.div_table);

            var grade_per_row_count = $(document.createElement('input'));
            grade_per_row_count.attr("type", "hidden");
            grade_per_row_count.attr("id", "grade_percent_count");
            grade_per_row_count.attr("name", "grade_percent_count");
            this.div_table.append(grade_per_row_count);
            grade_per_row_count.val(1);

            //rock name
            var rock_name_row = $(document.createElement('tr'));
            table.append(rock_name_row);

            var rock_name_index = $(document.createElement('td'));
            rock_name_index.html("2 (a)");
            rock_name_row.append(rock_name_index);

            var rock_name_label = $(document.createElement('td'));
            rock_name_label.html("Name of rock/mineral excavated and disposed as waste");
            rock_name_label.attr('align', 'left');
            rock_name_row.append(rock_name_label);

            var rock_name_container = $(document.createElement('td'));
            rock_name_row.append(rock_name_container);

            var rock_name_box = $(document.createElement('input'));
            rock_name_box.attr("id", "rock_name");
            rock_name_box.attr("name", "rock_name");
            rock_name_box.addClass("rock_name_text text-fields");
            rock_name_container.append(rock_name_box);

            if (is_fill_data == true && this.formData.qty_details)
                rock_name_box.attr("value", this.formData.qty_details['rock']);

            //min excavated
            var min_excavated_row = $(document.createElement('tr'));
            table.append(min_excavated_row);

            var min_excavated_index = $(document.createElement('td'));
            min_excavated_index.html("2 (b)");
            min_excavated_row.append(min_excavated_index);

            var min_excavated_label = $(document.createElement('td'));
            min_excavated_label.html("Name(s) of the ore/mineral excavated but not sold i.e, mineral rejects");
            min_excavated_label.attr('align', 'left');
            min_excavated_row.append(min_excavated_label);

            var min_excavated_container = $(document.createElement('td'));
            min_excavated_row.append(min_excavated_container);

            var min_excavated_box = $(document.createElement('input'));
            min_excavated_box.attr("id", "min_excavated");
            min_excavated_box.attr("name", "min_excavated");
            min_excavated_box.addClass("min_excavated_text text-fields");
            min_excavated_container.append(min_excavated_box);

            if (is_fill_data == true && this.formData.qty_details)
                min_excavated_box.attr("value", this.formData.qty_details['min_excavated']);

            //const analysis
            var const_analysis_row = $(document.createElement('tr'));
            table.append(const_analysis_row);

            var const_analysis_index = $(document.createElement('td'));
            const_analysis_index.html("2 (c)");
            const_analysis_row.append(const_analysis_index);

            var const_analysis_label = $(document.createElement('td'));
            //const_analysis_label.innerHTML = "Typical analysis of Constituent/sub-grade";
            const_analysis_label.html("Typical analysis of mineral rejects");
            const_analysis_label.attr('align', 'left');
            const_analysis_row.append(const_analysis_label);

            var const_analysis_container = $(document.createElement('td'));
            const_analysis_row.append(const_analysis_container);
        }

    },
    createGradePercentBox: function(table_container, ore_type, elem_no, is_fill_data) { 
        var isClassExist1 = $('table').hasClass('grade-percent-table');
        if (isClassExist1 == false) {

            var _this = this;
            var gradePerTable = $(document.createElement('table'));
            gradePerTable.attr("id", 'grade_percent_table');
            gradePerTable.addClass('grade-percent-table');
            gradePerTable.attr('width', '100%');
            gradePerTable.attr('border', '1');
            gradePerTable.attr('bordercolor', '#E5D0BD');
            gradePerTable.attr('style', 'border-collapse:collapse;');
            this.div_table.append(gradePerTable);

            var grade_header_row = $(document.createElement('tr'));
            grade_header_row.addClass("form-table-title");
            gradePerTable.append(grade_header_row);

            var const_header = $(document.createElement('td'));
            const_header.html("Constituent");
            const_header.attr('align', 'center');
            const_header.attr('width', '50%');
            grade_header_row.append(const_header);

            var grade_per_header = $(document.createElement('td'));
            grade_per_header.html("Grade %");
            grade_per_header.attr('align', 'center');
            grade_per_header.css('padding', '3px');
            grade_per_header.attr('colspan', '2');
            grade_header_row.append(grade_per_header);

            //console.log(this.formData.grade_details)
            //console.log("this.formData.grade_details")
            if (is_fill_data == true && this.formData.grade_details) {
                var total_grade_per_rows = this.formData.grade_details['const_analysis'].length;
                //                console.log("total_grade_per_rows")
                //                console.log(total_grade_per_rows)
                for (var i = 1; i <= total_grade_per_rows; i++)
                    this.createGradePercentRow(gradePerTable, ore_type, i, is_fill_data);
            } else {
                this.createGradePercentRow(gradePerTable, ore_type, elem_no, false);
            }
            //add button
            var add_more = $(document.createElement('div'));
            add_more.html("Add More");
            add_more.addClass("h-add-more-btn");
            add_more.attr("id", "add_more_btn_reject");
            add_more.css("padding", "5px");
            this.div_table.append(add_more);
            $("#add_more_btn_reject").live("click", function() {
                /********** HIDDEN TABLE COUNT *************/
                var gradePercentCount = document.getElementById('grade_percent_count');
                var prev_grade_table_count = gradePercentCount.value;
                var inc_grade_table_count = parseInt(prev_grade_table_count) + 1;
                gradePercentCount.value = inc_grade_table_count;

                _this.createGradePercentRow(gradePerTable, ore_type, inc_grade_table_count, false);
            });
        }
    },
    createGradePercentRow: function(gradePerTable, ore_type, elem_no, is_fill_data) { 
        var _this = this;
        var grade_per_tr = $(document.createElement('tr'));
        gradePerTable.append(grade_per_tr);

        var const_td = $(document.createElement('td'));
        const_td.attr('align', 'center');
        grade_per_tr.append(const_td);

        var const_select_box = $(document.createElement('select'));
        const_select_box.attr("id", "grade_per_const_" + elem_no);
        const_select_box.attr("name", "grade_per_const_" + elem_no);
        const_select_box.addClass("grade_per_select h-selectbox grade-percent-const");
        const_td.append(const_select_box);

        $.each(this.constituents, function(index, item) {
            var size_options = $(document.createElement('option'));
            size_options.html(item);
            if (item == 'Select')
                size_options.val('');
            else
                size_options.val(item);
            const_select_box.append(size_options);
        });
        //console.log(elem_no)
        //console.log("elem_no")
        if (is_fill_data == true && this.formData.grade_details)
            const_select_box.attr("value", this.formData.grade_details['const_analysis'][elem_no - 1]);

        var grade_td = $(document.createElement('td'));
        grade_td.attr('align', 'center');
        grade_per_tr.append(grade_td);

        var grade_textbox = $(document.createElement('input'));
        grade_textbox.attr("id", "grade_per_" + elem_no);
        grade_textbox.attr("name", "grade_per_" + elem_no);
        grade_textbox.addClass("mine_grade_percent grade-percent");
        grade_textbox.css("width", "80px");
        grade_td.append(grade_textbox);
        if (is_fill_data == true)
        {
            var gradePercentCount = document.getElementById('grade_percent_count');
            gradePercentCount.value = elem_no;
        }
        if (is_fill_data == true && this.formData.grade_details)
            grade_textbox.attr("value", this.formData.grade_details['grade_percent'][elem_no - 1]);

        if (elem_no == 1) {
            var dummy_td = $(document.createElement('td'));
            dummy_td.html("&nbsp;");
            grade_per_tr.append(dummy_td);
        } else {
            //close button
            var close_td = $(document.createElement('td'));
            close_td.addClass("h-close-icon grade-per-close-icon");
            close_td.bind('click', function() {
                $(this).parent().remove();
                //rename the id and name for the other text and select boxes
                _this.renameGradePercentBoxes(ore_type);
                var gradePercentCount = document.getElementById('grade_percent_count');
                var prev_grade_table_count = gradePercentCount.value;
                var dec_grade_table_count = parseInt(prev_grade_table_count) - 1;
                gradePercentCount.value = dec_grade_table_count;
            });
            grade_per_tr.append(close_td);
        }
    },
    renameGradePercentBoxes: function(ore_type) { 
        var grade_select_boxes = $(".grade-percent-const");
        var grade_text_boxes = $(".grade-percent");
        for (var j = 0; j < grade_select_boxes.length; j++) {
            var count = j + 1;
            $(grade_select_boxes[j]).attr('name', 'grade_per_const_' + count);
            $(grade_select_boxes[j]).attr('id', 'grade_per_const_' + count);

            $(grade_text_boxes[j]).attr('name', 'grade_per_' + count);
            $(grade_text_boxes[j]).attr('id', 'grade_per_' + count);
        }
    },
    renderQualityEditForm: function(sizeRange) { 
        var oreArray = new Array('ore_lump', 'ore_fines', 'ore_friable', 'ore_granular', 'ore_platy', 'ore_fibrous', 'ore_other');
        var _this = this;
        var total_ores = 0;

        $.each(this.formData.min_worked, function(key, item) {
            if (item == 1 || (key == 'ore_other' && item != '')) {
                $('#' + key).attr('checked', true);
                var selectedOre = jQuery.inArray(key, oreArray) + 1;
                //alert(_this.formData.const_details[selectedOre]['total_const_tables']);
                //add new code for Edit
                var frmGeologyPartEdit = $("#frmGeologyPart1");
                var constTableCountEdit = $(document.createElement('input'));
                constTableCountEdit.attr("type", 'hidden');
                constTableCountEdit.attr("id", 'getWholeCnt_' + selectedOre);
                constTableCountEdit.attr("name", 'getWholeCnt_' + selectedOre);
                constTableCountEdit.addClass('getwholecoutclass');
                constTableCountEdit.attr("value", _this.formData.const_details[selectedOre]['total_const_tables']);
                frmGeologyPartEdit.append(constTableCountEdit);

                if (key == 'ore_other' && item != '') {
                    $('#other_ore_type').attr('checked', true);
                    $('#other_ore_type_text').val(item);
                }
            }

            if (key == 'other_ore' && item != '') {
                $('#other_ore_type').attr('checked', true);
                $('#other_ore_type_text').val(item);
                selectedOre = 7;
            }

            //create box
            if (item == 1 || (key == 'ore_other' && item != '')) { 
                _this.createConstituentBox(selectedOre, 1, true, sizeRange);
                total_ores++;
            } 
        });

        //set the total ores hidden value
        var hidden_total_ores = document.getElementById('total_ores');
        hidden_total_ores.value = total_ores;



        //call the checkbox action
        this.createQualityForm(false, sizeRange); 
		
    // console.log('1');

    },
    renderQualityBox: function() { 

        var ores = this.formData.total_ores;
        for (var m = 0; m < ores.length; m++) {
            var maxLength = ores.length - 1;
            // console.log("#quality-table-container-" + ores[maxLength]);
            var n = m + 1;
            this.qualityTableContainer = $("#quality-table-container-" + ores[maxLength]);
            if (m == 0) {
                this.createQualityPart2(this.qualityTableContainer, ores[maxLength], true);
                this.createGradePercentBox(this.qualityTableContainer, ores[maxLength], n, true);
            }
        }

    }
}

var H1CapitalStructure = {
    capStrucAddMore: function() {
        var _this = this;
        _this.createsDynamicFirstRow(1);
    },
    createsDynamicFirstRow: function(count) {
        var _this = this;

        var mainFieldTable = $("#capStrucTable");

        var instituteLabelTr = $(document.createElement('tr'));

        var instituteTd = $(document.createElement('td'));
        instituteTd.css("textAlign", "center");
        instituteTd.attr("colSpan", "1");

        var instituteInput = $(document.createElement('input'));
        instituteInput.addClass("number-fields-small institution");
        instituteInput.attr("id", "institute_name_" + count);
        instituteInput.attr("name", "institute_name_" + count);
        instituteTd.append(instituteInput);
        instituteLabelTr.append(instituteTd);

        var loanAmountTd = $(document.createElement('td'));
        loanAmountTd.css("textAlign", "center");
        var loanAmountInput = $(document.createElement('input'));
        loanAmountInput.addClass("number-fields-small loan");
        loanAmountInput.attr("id", "loan_amount_" + count);
        loanAmountInput.attr("name", "loan_amount_" + count);
        loanAmountTd.append(loanAmountInput);
        instituteLabelTr.append(loanAmountTd);

        var interestRateTd = $(document.createElement('td'));
        interestRateTd.attr("colSpan", "2");
        interestRateTd.css("textAlign", "center");
        var interestRateInput = $(document.createElement('input'));
        interestRateInput.addClass("number-fields-small interest");
        interestRateInput.attr("id", "interest_rate_" + count);
        interestRateInput.attr("name", "interest_rate_" + count);
        interestRateTd.append(interestRateInput);
        instituteLabelTr.append(interestRateTd);

        if (count > 1) {
            var removeBtnTd = $(document.createElement('td'));
            removeBtnTd.addClass("h-close-icon");
            removeBtnTd.attr("id", "deleteRow");
            instituteLabelTr.append(removeBtnTd);
            _this.deleteField();
        }

        mainFieldTable.append(instituteLabelTr);
    },
    addMore: function()
    {
        var _this = this;
        $("#addMore").click(function() {
            var dynamicRow = $(".institution");
            var dynamicRowCount = dynamicRow.length;
            var newRowId = parseInt(dynamicRowCount) + 1;

            var currentInstiHiddenInc = $("#institutionCount").val();
            var incrementInstiHiddenInc = parseInt(currentInstiHiddenInc) + 1;
            $("#institutionCount").val(incrementInstiHiddenInc);

            _this.createsDynamicFirstRow(newRowId);
            _this.deleteField();
        });
    },
    deleteField: function() {
        var _this = this;
        $(".h-close-icon").unbind('click');
        $(".h-close-icon").click(function() {
            $(this).parent().remove();
            _this.renameFields();

            var currentInstiHiddenInc = $("#institutionCount").val();
            var incrementInstiHiddenInc = parseInt(currentInstiHiddenInc) - 1;
            $("#institutionCount").val(incrementInstiHiddenInc);
        });
    },
    renameFields: function() {
        // RENAMING THE INSTITUTION NAME FIELDS
        var institutionRow = $(".institution");
        var institutionRowCount = institutionRow.length;

        for (var i = 0; i < institutionRowCount; i++) {
            var institutionCount = parseInt(i) + 1;
            $(institutionRow[i]).attr('name', 'institute_name_' + institutionCount);
            $(institutionRow[i]).attr('id', 'institute_name_' + institutionCount);
        }

        // RENAMING THE LOAN AMOUNT FIELDS
        var loanRow = $(".loan");
        var loanRowCount = loanRow.length;

        for (var j = 0; j < loanRowCount; j++) {
            var loanCount = parseInt(j) + 1;
            $(loanRow[j]).attr('name', 'loan_amount_' + loanCount);
            $(loanRow[j]).attr('id', 'loan_amount_' + loanCount);
        }

        // RENAMING THE INTEREST RATE FIELDS
        var interestRow = $(".interest");
        var interestRowCount = interestRow.length;

        for (var k = 0; k < interestRowCount; k++) {
            var interestCount = parseInt(k) + 1;
            $(interestRow[k]).attr('name', 'interest_rate_' + interestCount);
            $(interestRow[k]).attr('id', 'interest_rate_' + interestCount);
        }
    },
    fillCapitalData: function(data_url) {
        Utilities.ajaxBlockUI();
        var _this = this;
        $.ajax({
            url: data_url,
            type: 'POST',
            success: function(responseData) {
                _this.data = json_parse(responseData);

                // FOR FIXED PART
                $.each(_this.data['fixed_result'], function(key, item) {
                    if (key == "assests_value") {
                        var fieldValue = _this.data['common_result']['total_close_bal'];
                        $('#' + key).attr("value", fieldValue);
                    //$('#' + key).val(fieldValue);
                    }
                    else {
                        if (key == 'selected_mine_code')
                        {
                            $('#' + key).val(item);
                        } else
						{
                            $('#' + key).attr("value", item);
                        }
                    }
                });

                //FOR SELECTING THE MULTIPLE BOX
                var selected_mines = parseInt(_this.data['fixed_result']['selected_mine_code']);
                if (selected_mines.length) {
                    $.each(selected_mines, function(key, item) {

                        $('#selected_mine_code[value=' + item + ']').attr('selected', true);
                    });
                }
                // FOR COMMON PART
                $.each(_this.data['common_result'], function(key, item) {
                    $('#' + key).attr("value", item);
                //$('#' + key).val(item);
                });

                // FOR DYNAMIC PART
                var dynamicRowCount = _this.data.dynamic_result.rowCount;
                if (dynamicRowCount > 0) {
                    $("#institutionCount").val(dynamicRowCount);
                }

                if (dynamicRowCount == 1) {
                    $.each(_this.data['dynamic_result'], function(key, item) {
                        $('#' + key).attr("value", item);
                    });
                } else if (dynamicRowCount > 1) {
                    for (var i = 1; i < dynamicRowCount; i++) {
                        var rowNo = (parseInt(i) + 1);
                        _this.createsDynamicFirstRow(rowNo);
                    }

                    // FILL THE VALUES ACCORGING TO THE ARRAY NO AND THE ID
                    $.each(_this.data['dynamic_result'], function(key, item) {
                        $('#' + key).attr("value", item);
                    // $('#' + key).val(item);
                    });
                }

                _this.deleteField();
                _this.renameFields();
            }
        });
    }
}

var H1GeologyMiningOperation = {
    //===================================FOR NEW PAGE=============================
    renderDynamicTable: function(tableNo, rowNo, userType) {
        var _this = this;
        /**
         * tableNo = 1 ------> bench
         * tableNo = 2 ------> height
         * tableNo = 3 ------> depth
         * rowNo ------> is the number for id of the fields
         */
        //==========================FOR NUMBER OF BENCHES===========================
        if (tableNo == 1 || tableNo == 0) {
            var tableName1 = $("#bench_ore");
            var tableName2 = $("#bench_waste");
            var fieldName1 = "bench_no_ore";
            var fieldName2 = "bench_no_waste";
            if (userType == 1) {
                _this.dynamicFieldCreation(tableName1, tableName2, fieldName1, fieldName2, rowNo);
            }
            else if (userType == 2) {
                _this.renderMMSForm(tableName1, tableName2, fieldName1, fieldName2, rowNo);
            }
        }
        //============================FOR AVERAGE HEIGHT============================
        if (tableNo == 2 || tableNo == 0) {
            var tableName3 = $("#avg_height_ore");
            var tableName4 = $("#avg_height_waste");
            var fieldName3 = "avg_height_ore";
            var fieldName4 = "avg_height_waste";

            if (userType == 1) {
                _this.dynamicFieldCreation(tableName3, tableName4, fieldName3, fieldName4, rowNo);
            }
            else if (userType == 2) {
                _this.renderMMSForm(tableName3, tableName4, fieldName3, fieldName4, rowNo);
            }
        }
        //=====================FOR DEPT OF THE DEEPEST WORKING======================
        if (tableNo == 3 || tableNo == 0) {
            var tableName5 = $("#deepest_working_ore");
            var tableName6 = $("#deepest_working_waste");
            var fieldName5 = "deepest_working_ore";
            var fieldName6 = "deepest_working_waste";

            if (userType == 1) {
                _this.dynamicFieldCreation(tableName5, tableName6, fieldName5, fieldName6, rowNo);
            }
            else if (userType == 2) {
                _this.renderMMSForm(tableName5, tableName6, fieldName5, fieldName6, rowNo);
            }
        }
    },
    dynamicFieldCreation: function(tableName1, tableName2, fieldName1, fieldName2, rowNo) {
        var _this = this;
        var benchTr = $(document.createElement('tr'));

        var benchTd = $(document.createElement('td'));
        benchTd.addClass("label-text");
        benchTd.attr("colspan", "1");
        benchTr.append(benchTd);
        tableName1.append(benchTr);

        //======================CREATING THE SELECT BOX=============================
        var benchSelect = $(document.createElement('select'));
        benchSelect.attr("id", fieldName1 + "_select_" + rowNo);
        benchSelect.attr("name", fieldName1 + "_select_" + rowNo);
        benchSelect.addClass(fieldName1 + "_select" + " selectbox-small");
        benchTd.append(benchSelect);

        //==================CREATING THE SELECT BOX OPTIONS=========================
        var benchSelectOption = $(document.createElement('option'));
        benchSelectOption.html("Select");
        benchSelectOption.attr("value", "");
        benchSelect.append(benchSelectOption);
        //   1 OPTION
        var benchSelectOption2 = $(document.createElement('option'));
        benchSelectOption2.html("Manual");
        benchSelectOption2.attr("value", "1");
        benchSelect.append(benchSelectOption2);
        //   2 OPTION
        var benchSelectOption1 = $(document.createElement('option'));
        benchSelectOption1.html("Mechanised");
        benchSelectOption1.attr("value", "2");
        benchSelect.append(benchSelectOption1);
        //===================CREATING THE INPUT FIELD FOR IN ORE====================
        var benchOreInputTd = $(document.createElement('td'));
        benchOreInputTd.addClass("label-text");
        benchOreInputTd.attr("colSpan", "1");

        var benchOreInput = $(document.createElement('input'));
        benchOreInput.attr("id", fieldName1 + "_input_" + rowNo);
        benchOreInput.attr("name", fieldName1 + "_input_" + rowNo);
        benchOreInput.addClass(fieldName1 + "_input" + " number-fields-small survivalDecimalThree");
        benchOreInputTd.append(benchOreInput);
        benchTr.append(benchOreInputTd);

        //============CREATING THE INPUT FIELD FOR THE OB/WASTE=====================
        var benchTr2 = $(document.createElement('tr'));
        var benchWasteInputTd = $(document.createElement('td'));
        benchWasteInputTd.addClass("label-text text-fields");
        benchWasteInputTd.css("width", "72px");
        benchWasteInputTd.attr("colspan", "1");

        var benchWasteInput = $(document.createElement('input'));
        benchWasteInput.attr("id", fieldName2 + "_input_" + rowNo);
        benchWasteInput.attr("name", fieldName2 + "_input_" + rowNo);
        benchWasteInput.addClass(fieldName2 + "_input" + " number-fields-small survivalDecimalThree");
        benchWasteInputTd.append(benchWasteInput);
        benchTr2.append(benchWasteInputTd);
        tableName2.append(benchTr2);

        //=========IF THE ADD MORE IS CLICKED THEN FOR REMOVE IMAGE BUTTON==========
        if (rowNo > 1) {
            var removeBtnTd = $(document.createElement('td'));
            removeBtnTd.addClass("h-close-icon");
            removeBtnTd.attr("alt", "lowerDelete");
            removeBtnTd.attr("id", "deleteRow");
            benchTr2.append(removeBtnTd);
            _this.removeField();

        }

    },
    addMore: function() {
        // HERE WE HAVE TO PASS THE TABLE NAME ALONG WITH THE ROWCOUNT AS THE 
        // FUNCTION NEEDED ALL OF THEM OTHERWISE IT WILL ADD FIELD IN ALL THE 
        // THREE OF THE DYNAMIC TABLE
        var userType = 1; // HARD CODED AS ONLY MINE USER CAN EDIT THE FORM WHILE MMS USER 
        //    CAN NOT EDIT THE FORM HE CAN ONLY SEE THE FORM
        var _this = this;
        $("#benchAddMore").click(function() {
            var benchRowCount = $("#bench_no_count").val();
            var newBenchRowCount = (parseInt(benchRowCount) + 1);
            $("#bench_no_count").val(newBenchRowCount);
            var tableNo = 1;
            _this.renderDynamicTable(tableNo, newBenchRowCount, userType);
        });

        $("#avgHeightAddMore").click(function() {
            var benchRowCount = $("#avg_height_count").val();
            var newBenchRowCount = (parseInt(benchRowCount) + 1);
            $("#avg_height_count").val(newBenchRowCount);
            var tableNo = 2;
            _this.renderDynamicTable(tableNo, newBenchRowCount, userType);
        });

        //===========CURRENTLY THIS ONE IS WORKING======= ONE ADD MORE TO ADD ALL===
        $("#depthWorkingAddMore").click(function() {
            var benchRowCount = $("#bench_no_count").val();
            var newBenchRowCount = (parseInt(benchRowCount) + 1);
            $("#bench_no_count").val(newBenchRowCount);
            var tableNo = 1;
            _this.renderDynamicTable(tableNo, newBenchRowCount, userType);
            //////////////////////////////////////////////////////////////
            var benchRowCount = $("#avg_height_count").val();
            var newBenchRowCount = (parseInt(benchRowCount) + 1);
            $("#avg_height_count").val(newBenchRowCount);
            var tableNo = 2;
            _this.renderDynamicTable(tableNo, newBenchRowCount, userType);

            //////////////////////////////////////////////////////////////////////////
            var benchRowCount = $("#deepest_working_count").val();
            var newBenchRowCount = (parseInt(benchRowCount) + 1);
            $("#deepest_working_count").val(newBenchRowCount);
            var tableNo = 3;
            _this.renderDynamicTable(tableNo, newBenchRowCount, userType);
        });
        //==========================================================================

        $("#drill_numberAddMore").click(function() {
            var drill_numberCount = $("#drill_numberCount").val();
            var newdrill_numberCount = (parseInt(drill_numberCount) + 1);
            $("#drill_numberCount").val(newdrill_numberCount);
            _this.explorationAddMore('drill_grid_table', 'drill_meter_table', 'drill_number_table', 'drill_grid_' + newdrill_numberCount, 'drill_meter_' + newdrill_numberCount, 'drill_number_' + newdrill_numberCount, newdrill_numberCount);
        });
        $("#trench_numberAddMore").click(function() {
            var trenching_numberCount = $("#trench_numberCount").val();
            var newtrenching_numberCount = (parseInt(trenching_numberCount) + 1);
            $("#trench_numberCount").val(newtrenching_numberCount);
            _this.explorationAddMore('trench_grid_table', 'trench_meter_table', 'trench_number_table', 'trench_grid_' + newtrenching_numberCount, 'trench_meter_' + newtrenching_numberCount, 'trench_number_' + newtrenching_numberCount, newtrenching_numberCount);
        });

        $("#pit_numberAddMore").click(function() {
            var pit_numberCount = $("#pit_numberCount").val();
            var newpit_numberCount = (parseInt(pit_numberCount) + 1);
            $("#pit_numberCount").val(newpit_numberCount);
            _this.explorationAddMore('pit_grid_table', 'pit_meter_table', 'pit_number_table', 'pit_grid_' + newpit_numberCount, 'pit_meter_' + newpit_numberCount, 'pit_number_' + newpit_numberCount, newpit_numberCount);
        });



    },
    explorationAddMore: function(tablename1, tablename2, tablename3, selectfiled1, textfield1, textfield2, rowNo)
    {

        var explorationTr = $(document.createElement('tr'));
        explorationTr.attr("id", selectfiled1 + "_tr");
        var explorationTd = $(document.createElement('td'));



        //======================CREATING THE SELECT BOX=============================
        var explorationSelect = $(document.createElement('select'));
        explorationSelect.attr("id", selectfiled1);
        explorationSelect.attr("name", selectfiled1);
        explorationSelect.addClass("selectbox-small exploration_select valid");


        //==================CREATING THE SELECT BOX OPTIONS=========================
        var explorationSelectOption = $(document.createElement('option'));
        explorationSelectOption.html("Select");
        explorationSelectOption.attr("value", "0");
        explorationSelect.append(explorationSelectOption);

        //   1 OPTION
        var explorationSelectOption2 = $(document.createElement('option'));
        explorationSelectOption2.html(">200");
        explorationSelectOption2.attr("value", "1");
        explorationSelect.append(explorationSelectOption2);

        //   2 OPTION
        var explorationSelectOption1 = $(document.createElement('option'));
        explorationSelectOption1.html("200x200");
        explorationSelectOption1.attr("value", "2");
        explorationSelect.append(explorationSelectOption1);


        var explorationSelectOption3 = $(document.createElement('option'));
        explorationSelectOption3.html("100x100");
        explorationSelectOption3.attr("value", "3");
        explorationSelect.append(explorationSelectOption3);

        var explorationSelectOption4 = $(document.createElement('option'));
        explorationSelectOption4.html("50x50");
        explorationSelectOption4.attr("value", "4");
        explorationSelect.append(explorationSelectOption4);


        var explorationSelectOption5 = $(document.createElement('option'));
        explorationSelectOption5.html("25x25");
        explorationSelectOption5.attr("value", "5");
        explorationSelect.append(explorationSelectOption5);


        var explorationSelectOption6 = $(document.createElement('option'));
        explorationSelectOption6.html("Not to Grid");
        explorationSelectOption6.attr("value", "6");
        explorationSelect.append(explorationSelectOption6);

        explorationTd.append(explorationSelect);
        explorationTr.append(explorationTd);
        $("#" + tablename1).append(explorationTr);

        //============CREATING THE INPUT FIELD FOR METERAGE=====================
        var explorationTr2 = $(document.createElement('tr'));
        explorationTr2.attr("id", textfield1 + "_tr");
        var explorationInputTd = $(document.createElement('td'));
        var explorationInput = $(document.createElement('input'));
        explorationInput.attr("id", textfield1);
        explorationInput.attr("name", textfield1);
        explorationInput.addClass("number-fields-small exploration");
        explorationInputTd.append(explorationInput);
        explorationTr2.append(explorationInputTd);
        $("#" + tablename2).append(explorationTr2);


        //============CREATING THE INPUT FIELD FOR NUMBER=====================

        var explorationTr2 = $(document.createElement('tr'));
        explorationTr2.attr("id", textfield2 + "_tr");
        var explorationInputTd = $(document.createElement('td'));
        var explorationInput = $(document.createElement('input'));
        explorationInput.attr("id", textfield2);
        explorationInput.attr("name", textfield2);
        explorationInput.addClass("number-fields-small exploration-number");
        explorationInputTd.append(explorationInput);
        explorationTr2.append(explorationInputTd);


        //=========IF THE ADD MORE IS CLICKED THEN FOR REMOVE IMAGE BUTTON==========
        if (rowNo > 1) {
            var removeBtnTd = $(document.createElement('td'));
            removeBtnTd.addClass("h-close-icon");
            removeBtnTd.attr("id", textfield2);
            removeBtnTd.attr("alt", "upperDelete");
            removeBtnTd.bind('click', function() {
                $('#' + selectfiled1 + "_tr").remove();
                $('#' + textfield1 + "_tr").remove();
                $('#' + textfield2 + "_tr").remove();
            });
            explorationTr2.append(removeBtnTd);
            $("#" + tablename3).append(explorationTr2);
        //_this.removeField();
        }


    },
    removeField: function() {
        var _this = this;

        $(".h-close-icon").unbind('click');
        $(".h-close-icon").click(function() {
            if ($(this).attr("alt") == 'upperDelete')
            {
                var split_grill_val = $(this).attr('id').split('_')
                if (split_grill_val[0] == 'drill')
                {
                    $('#drill_grid_' + split_grill_val[2] + '_tr').remove();
                    $('#drill_meter_' + split_grill_val[2] + '_tr').remove();
                    $('#drill_number_' + split_grill_val[2] + '_tr').remove();

                }
                if (split_grill_val[0] == 'trench')
                {
                    $('#trench_grid_' + split_grill_val[2] + '_tr').remove();
                    $('#trench_meter_' + split_grill_val[2] + '_tr').remove();
                    $('#trench_number_' + split_grill_val[2] + '_tr').remove();
                }
                if (split_grill_val[0] == 'pit')
                {
                    $('#pit_grid_' + split_grill_val[2] + '_tr').remove();
                    $('#pit_meter_' + split_grill_val[2] + '_tr').remove();
                    $('#pit_number_' + split_grill_val[2] + '_tr').remove();
                }
            }
            if ($(this).attr("alt") == 'lowerDelete')
            {

                //================GETTING THE FIELD NO FROM THE CURRENT FIELD=============
                var secondTableId = $(this).prev().children(':first-child').attr('id');
                //alert(secondTableId);
                var splittedData = secondTableId.split('_');
                //var fieldNo = secondTableId.substr(-1, 1);
                var fieldNo = splittedData[4]
                //alert(fieldNo);

                //=========================GETTING THE FIELD NAME=========================
                //      var splittedData = secondTableId.split('_');
                //      var part1 = splittedData[0];
                //      var part2 = splittedData[1];
                //      var fieldFullName = part1 + "_" + part2 + "_ore_select_" + fieldNo;
                var benchOreFild = "#bench_no_ore_select_" + fieldNo;
                var benchWasteFild = "#bench_no_waste_input_" + fieldNo;
                var avgOreHeight = "#avg_height_ore_select_" + fieldNo;
                var avgWasteHeight = "#avg_height_waste_input_" + fieldNo;
                var deepOreWorking = "#deepest_working_ore_select_" + fieldNo;
                var deepWasteWorking = "#deepest_working_waste_input_" + fieldNo;

                //===========================REMOVING ALL ITEMS===========================
                $(benchOreFild).closest('tr').remove();
                $(benchWasteFild).closest('tr').remove();
                $(avgOreHeight).closest('tr').remove();
                $(avgWasteHeight).closest('tr').remove();
                $(deepOreWorking).closest('tr').remove();
                $(deepWasteWorking).closest('tr').remove();

                var idArray = Array(3);
                idArray[0] = Array(2);
                idArray[0][0] = "bench";
                idArray[0][1] = "no";
                idArray[1] = Array(2);
                idArray[1][0] = "avg";
                idArray[1][1] = "height";
                idArray[2] = Array(2);
                idArray[2][0] = "deepest";
                idArray[2][1] = "working";

                //======GETTING THE FIELD USING THE ID ABOVE TAKEN AND DELETING IT========
                //      var firstTableField = $("#" + fieldFullName);
                //      $(firstTableField).closest('tr').remove();

                //================CHANGING THE HIDDEN COUNT FIELD VALUE===================
                for (var j = 0; j < 3; j++) {
                    var part1 = idArray[j][0];
                    var part2 = idArray[j][1];
                    var hiddenFieldId = part1 + "_" + part2 + "_count";
                    var hiddenFieldCount = $("#" + hiddenFieldId).val();
                    var newHiddenFieldValue = (parseInt(hiddenFieldCount) - 1);
                    $("#" + hiddenFieldId).attr("value", newHiddenFieldValue);
                    _this.renameField(part1, part2);
                }

            //===========CALLING THE RENAME FUNCTION FOR RENAMING THE FIELDS==========
            }
        });
    },
    renameField: function(fieldName1, fieldName2) {
        //========================RENAMIG SELECT BOX================================
        var fieldClassName1 = fieldName1 + "_" + fieldName2 + "_ore_select";
        var selectRow = $("." + fieldClassName1);
        var selectRowCount = selectRow.length;

        for (var i = 0; i < selectRowCount; i++) {
            var selectCount = parseInt(i) + 1;
            $(selectRow[i]).attr('name', fieldClassName1 + "_" + selectCount);
            $(selectRow[i]).attr('id', fieldClassName1 + "_" + selectCount);
        }
        //========================RENAMING ORE INPUT BOX============================
        var fieldClassName2 = fieldName1 + "_" + fieldName2 + "_ore_input";
        var oreRow = $("." + fieldClassName2);
        var oreRowCount = oreRow.length;

        for (var j = 0; j < oreRowCount; j++) {
            var oreCount = parseInt(j) + 1;
            $(oreRow[j]).attr('name', fieldClassName2 + "_" + oreCount);
            $(oreRow[j]).attr('id', fieldClassName2 + "_" + oreCount);
        }
        //=======================RENAMING WASTE INPUT BOX===========================
        var fieldClassName3 = fieldName1 + "_" + fieldName2 + "_waste_input";
        var wasteRow = $("." + fieldClassName3);
        var wasteRowCount = wasteRow.length;

        for (var k = 0; k < wasteRowCount; k++) {
            var wasteCount = parseInt(k) + 1;
            $(wasteRow[k]).attr('name', fieldClassName3 + "_" + wasteCount);
            $(wasteRow[k]).attr('id', fieldClassName3 + "_" + wasteCount);
        }
    },
    //===========================FOR EDIT FUNCTIONALITY===========================
    editInIt: function(dataUrl, userType) {
        Utilities.ajaxBlockUI();
        var _this = this;
        $.ajax({
            url: dataUrl,
            type: 'POST',
            success: function(resData) {
                _this.data = json_parse(resData);

                if (_this.data != "") {
                    if (userType == 1) {
                        _this.fillFormData();
                    }
                    else if (userType == 2) {
                        _this.fillMMSFormData()
                    }
                }
            }
        })
    },
    fillFormData: function() {
        var _this = this;
        //=====================FILLING DYNAMIC DATA STARTS==========================
        //=========================FILLING BENCH DATA===============================
        var benchCount = _this.data['bench']['bench_count'];

        //USER TYPE IS HARDCODED AS HERE THE USER TYPE WILL ALWAYS BE 1 i.e, MINE USER
        var userType = 1;
        if (benchCount) {
            for (var i = 2; i <= benchCount; i++) {
                var benchRowNo = i;
                _this.renderDynamicTable(1, benchRowNo, userType);
            }
            $.each(_this.data['bench'], function(key, item) {
                $("#" + key).attr("value", item);
            });

            $("#bench_no_count").attr("value", benchCount);
        }

        //=========================FILLING HEIGHT DATA==============================

        var heightCount = _this.data['height']['height_count'];

        if (heightCount) {
            for (var j = 2; j <= heightCount; j++) {
                var heightRowNo = j;
                _this.renderDynamicTable(2, heightRowNo, userType);
            }
            $.each(_this.data['height'], function(key, item) {
                $("#" + key).attr("value", item);
            })
            $("#avg_height_count").attr("value", heightCount);
        }

        //=========================FILLING DEPTH DATA===============================
        var depthCount = _this.data['depth']['depth_count'];

        if (depthCount) {
            for (var k = 2; k <= depthCount; k++) {
                var depthRowNo = k;
                _this.renderDynamicTable(3, depthRowNo, userType);
            }
            $.each(_this.data['depth'], function(key, item) {
                $("#" + key).attr("value", item);
            })
            $("#deepest_working_count").attr("value", depthCount);
        }
        //=========================FILLING EXPLORATION DRILL ===============================
        var DrillCount = _this.data['drill']['drill_count'];

        if (DrillCount) {
            for (var k = 2; k <= DrillCount; k++) {
                var DrillRowNo = k;
                _this.explorationAddMore('drill_grid_table', 'drill_meter_table', 'drill_number_table', 'drill_grid_' + DrillRowNo, 'drill_meter_' + DrillRowNo, 'drill_number_' + DrillRowNo, DrillRowNo);
            }
            $.each(_this.data['drill'], function(key, item) {


                $("#" + key).attr("value", item);


            })
            $("#drill_numberCount").attr("value", DrillCount);
        }

        //=========================FILLING EXPLORATION TRENCH ===============================
        var TrenchCount = _this.data['trench']['trench_count'];

        if (TrenchCount) {
            for (var k = 2; k <= TrenchCount; k++) {
                var TrenchRowNo = k;
                _this.explorationAddMore('trench_grid_table', 'trench_meter_table', 'trench_number_table', 'trench_grid_' + TrenchRowNo, 'trench_meter_' + TrenchRowNo, 'trench_number_' + TrenchRowNo, TrenchRowNo);
            }
            $.each(_this.data['trench'], function(key, item) {



                $("#" + key).attr("value", item);


            })
            $("#trench_numberCount").attr("value", TrenchCount);
        }


        //=========================FILLING EXPLORATION PITT===============================
        var PitCount = _this.data['pit']['pit_count'];

        if (PitCount) {
            for (var k = 2; k <= PitCount; k++) {
                var PitRowNo = k;
                _this.explorationAddMore('pit_grid_table', 'pit_meter_table', 'pit_number_table', 'pit_grid_' + PitRowNo, 'pit_meter_' + PitRowNo, 'pit_number_' + PitRowNo, PitRowNo);
            }
            $.each(_this.data['pit'], function(key, item) {



                $("#" + key).attr("value", item);


            })
            $("#pit_numberCount").attr("value", PitCount);
        }

        //=======================FILLING DYNAMIC DATA ENDS==========================

        //=========================FILLING STATIC DATA==============================
        $.each(_this.data['static'], function(key, item) {

            $("#" + key).attr("value", item);
        })


    },
    fillMMSFormData: function() {
        var _this = this;
        var gridMeter = new Array();
        gridMeter[1] = ">200";
        gridMeter[2] = "200x200";
        gridMeter[3] = "100x100";
        gridMeter[4] = "50x50";
        gridMeter[5] = "25x25";
        gridMeter[6] = "Not to Grid";
        var inOre = new Array();
        inOre[1] = "Manual";
        inOre[2] = "Mechanised";

        //console.log(_this.data)
        var userType = 2;
        //=====================FILLING DYNAMIC DATA STARTS==========================
        //=========================FILLING BENCH DATA===============================
        var benchCount = _this.data['bench']['bench_count'];
        var countOre1 = 1;
        var countOre2 = 1;
        var countOre3 = 1;
        for (var i = 1; i <= benchCount; i++) {
            var benchRowNo = i;
            _this.renderDynamicTable(1, benchRowNo, userType);
        }
        $.each(_this.data['bench'], function(key, item) {

            if ("bench_no_ore_select_" + countOre1 == key) {
                $("#" + key).text(inOre[item]);
                countOre1++;
            } else {
                $("#" + key).text(item);
            }
        });

        //=========================FILLING HEIGHT DATA==============================
        var heightCount = _this.data['height']['height_count'];

        for (var j = 1; j <= heightCount; j++) {
            var heightRowNo = j;
            _this.renderDynamicTable(2, heightRowNo, userType);
        }
        $.each(_this.data['height'], function(key, item) {

            if ("avg_height_ore_select_" + countOre2 == key) {
                $("#" + key).text(inOre[item]);
                countOre2++;
            } else {
                $("#" + key).text(item);
            }
        });

        //=========================FILLING DEPTH DATA===============================
        var depthCount = _this.data['depth']['depth_count'];

        for (var k = 1; k <= depthCount; k++) {
            var depthRowNo = k;
            _this.renderDynamicTable(3, depthRowNo, userType);
        }
        $.each(_this.data['depth'], function(key, item) {

            if ("deepest_working_ore_select_" + countOre3 == key) {
                $("#" + key).text(inOre[item]);
                countOre3++;
            } else {
                $("#" + key).text(item);
            }

        });
        //===============================EXPLORATION DRILL==========================
        var drillCount = _this.data['drill']['drill_count'];
        var count1 = 1;
        var count2 = 1;
        var count3 = 1;
        for (var k = 1; k <= drillCount; k++) {

            _this.MMSexplorationAddMore('drill_grid_table', 'drill_meter_table', 'drill_number_table', 'drill_grid_' + k, 'drill_meter_' + k, 'drill_number_' + k, k);
        }
        $.each(_this.data['drill'], function(key, item) {

            if ("drill_grid_" + count1 == key)
            {
                $("#" + key).text(gridMeter[item]);
                count1++;
            }
            else
            {
                $("#" + key).text(item);
            }

        });

        var trenchCount = _this.data['trench']['trench_count'];

        for (var k = 1; k <= trenchCount; k++) {

            _this.MMSexplorationAddMore('trench_grid_table', 'trench_meter_table', 'trench_number_table', 'trench_grid_' + k, 'trench_meter_' + k, 'trench_number_' + k, k);
        }
        $.each(_this.data['trench'], function(key, item) {

            if ("trench_grid_" + count2 == key)
            {
                $("#" + key).text(gridMeter[item]);
                count2++;
            }
            else
            {
                $("#" + key).text(item);
            }


        });

        var drillCount = _this.data['pit']['pit_count'];

        for (var k = 1; k <= drillCount; k++) {

            _this.MMSexplorationAddMore('pit_grid_table', 'pit_meter_table', 'pit_number_table', 'pit_grid_' + k, 'pit_meter_' + k, 'pit_number_' + k, k);
        }
        $.each(_this.data['pit'], function(key, item) {

            if ("pit_grid_" + count3 == key)
            {
                $("#" + key).text(gridMeter[item]);
                count3++;
            }
            else
            {
                $("#" + key).text(item);
            }

        });

        //=======================FILLING DYNAMIC DATA ENDS==========================
        //=========================FILLING STATIC DATA==============================
        $.each(_this.data['static'], function(key, item) {
            $("#" + key).text(item);
        });
    },
    renderMMSForm: function(tableName1, tableName2, fieldName1, fieldName2, rowNo) {
        var benchTr = $(document.createElement('tr'));

        var benchTd = $(document.createElement('td'));
        benchTd.attr("colspan", "1");
        benchTd.css("width", "80px");
        benchTr.append(benchTd);
        tableName1.append(benchTr);

        //======================CREATING THE SELECT BOX=============================
        var benchSelect = $(document.createElement('div'));
        benchSelect.attr("id", fieldName1 + "_select_" + rowNo);
        benchSelect.addClass("benches-detail-table");
        benchTd.append(benchSelect);

        //===================CREATING THE INPUT FIELD FOR IN ORE====================
        var benchOreInputTd = $(document.createElement('td'));
        benchOreInputTd.attr("colspan", "1");
        benchOreInputTd.css("width", "80px");

        var benchOreInput = $(document.createElement('div'));
        benchOreInput.attr("id", fieldName1 + "_input_" + rowNo);
        benchOreInput.addClass("benches-detail-table");
        benchOreInputTd.append(benchOreInput);
        benchTr.append(benchOreInputTd);

        //============CREATING THE INPUT FIELD FOR THE OB/WASTE=====================
        var benchTr2 = $(document.createElement('tr'));
        var benchWasteInputTd = $(document.createElement('td'));
        benchWasteInputTd.css("width", "80px");
        benchWasteInputTd.attr("colspan", "1");

        var benchWasteInput = $(document.createElement('div'));
        benchWasteInput.attr("id", fieldName2 + "_input_" + rowNo);
        benchWasteInput.addClass("benches-detail-table");
        benchWasteInputTd.append(benchWasteInput);
        benchTr2.append(benchWasteInputTd);
        tableName2.append(benchTr2);
    },
    MMSexplorationAddMore: function(tablename1, tablename2, tablename3, selectfiled1, textfield1, textfield2, rowNo)
    {

        var explorationTr = $(document.createElement('tr'));
        explorationTr.attr("id", selectfiled1 + "_tr");
        var explorationTd = $(document.createElement('td'));
        //======================CREATING THE SELECT BOX=============================
        var explorationSelectdiv = $(document.createElement('div'));
        explorationSelectdiv.attr("id", selectfiled1);
        explorationSelectdiv.attr("name", selectfiled1);
        explorationTd.append(explorationSelectdiv);
        explorationTr.append(explorationTd);
        $("#" + tablename1).append(explorationTr);

        //============CREATING THE INPUT FIELD FOR METERAGE=====================
        var explorationTr2 = $(document.createElement('tr'));
        explorationTr2.attr("id", textfield1 + "_tr");
        var explorationInputTd = $(document.createElement('td'));
        var explorationInputdiv = $(document.createElement('div'));
        explorationInputdiv.attr("id", textfield1);
        explorationInputdiv.attr("name", textfield1);
        explorationInputTd.append(explorationInputdiv);
        explorationTr2.append(explorationInputTd);
        $("#" + tablename2).append(explorationTr2);


        //============CREATING THE INPUT FIELD FOR NUMBER=====================

        var explorationTr2 = $(document.createElement('tr'));
        explorationTr2.attr("id", textfield2 + "_tr");
        var explorationInputTd = $(document.createElement('td'));
        var explorationInput = $(document.createElement('div'));
        explorationInput.attr("id", textfield2);
        explorationInput.attr("name", textfield2);
        explorationInputTd.append(explorationInput);
        explorationTr2.append(explorationInputTd);
        $("#" + tablename3).append(explorationTr2);
    }
}

var H1MineralRejects = {
    editMineral: function(dataUrl, userType) {
        Utilities.ajaxBlockUI();
        var _this = this;
        $.ajax({
            url: dataUrl,
            type: 'POST',
            success: function(resData) {
                _this.data = json_parse(resData);
                if (_this.data != "") {
                    if (userType == 1) {
                        _this.fillFormData();
                    }
                    else if (userType == 2) {
                        _this.fillMMSFormData();
                    }
                }
            }
        })
    },
    fillFormData: function() {
        var _this = this;
        //=========================FILLING STATIC DATA==============================
        $.each(_this.data['static'], function(key, item) {
            $("#" + key).val(item);
        })
    },
    fillMMSFormData: function() {
        var _this = this;

        var userType = 2;
        //=========================FILLING STATIC DATA==============================
        $.each(_this.data['static'], function(key, item) {
            $("#" + key).text(item);
            $("#" + key).text(item);
        });
    }
}

// var H1GeologyPart3 = {
//     //====================AGGREGATION DYNAMIC PART START==========================
//     aggregationDynamicRow: function(rowCount, dropDownList) {

//         var aggregationTable = $(document.getElementById('uday'));
//         //=======================FIELD ROW STARTS HERE==============================
//         var aggregationTr = $(document.createElement('tr'));
//         aggregationTable.append(aggregationTr);

//         //============================MACHINERY SELECT==============================
//         var machineTd = $(document.createElement('td'));
//         machineTd.css("textAlign", "center");
//         aggregationTr.append(machineTd);
//         var machineSelect = $(document.createElement('select'));
//         machineSelect.attr("id", "machine_select_" + rowCount);
//         machineSelect.addClass("machine_select selectbox-small");
//         machineSelect.attr("name", "machine_select_" + rowCount);
//         machineTd.append(machineSelect);

//         var machineOption = $(document.createElement('option'));
//         machineOption.attr("value", "");
//         machineOption.html("Select");
//         machineSelect.append(machineOption);

//         var dropDownOption = json_parse(dropDownList);
//         //        console.log(  dropDownOption)
//         for (var i = 0; i < dropDownOption.length; i++) {
//             var machineOption1 = $(document.createElement('option'));
//             var value = dropDownOption[i]['code'] + "-" + dropDownOption[i]['unit'];
//             machineOption1.attr("value", value);
//             machineOption1.html(dropDownOption[i]['name']);
//             machineSelect.append(machineOption1);
//         }

//         if (rowCount == 1) {
//             var machineNILOption = $(document.createElement('option'));
//             machineNILOption.attr("value", "NIL");
//             machineNILOption.html("NIL");
//             machineSelect.append(machineNILOption);
//         }
//         else {
//             $("#machine_select_1").find('option[value=NIL]').remove();
//         }
//         //============================CAPACITY BOX==================================
//         var capacityTd = $(document.createElement('td'));
//         capacityTd.attr("colspan", "2");
//         capacityTd.css("textAlign", "center");
//         aggregationTr.append(capacityTd);
//         var capacityInput = $(document.createElement('input'));
//         capacityInput.css("textAlign", "right");
//         capacityInput.attr("id", "capacity_box_" + rowCount);
//         capacityInput.addClass("capacity_box number-fields-small");
//         capacityInput.attr("name", "capacity_box_" + rowCount);
//         capacityTd.append(capacityInput);

//         var unitSpan = $(document.createElement('span'));
//         unitSpan.attr("id", "unit_" + rowCount);
//         capacityTd.append(unitSpan);

//         $('.machine_select').unbind('change'); // FOR STOPPING THE MULTIPLE ALERTS
//         $('.machine_select').change(function() {
//             var elementId = $(this).attr("id");
//             var elementValue = $(this).val();
//             var spliitedElementId = elementId.split('_');
//             var token = spliitedElementId[2];

//             if (elementValue == '') {
//                 H1GeologyPart3.undoMakeNil(token) // Only first one to disable
//                 $('#unit_' + token).html(' -');
//             }
//             else if (elementValue == 'NIL') {
//                 H1GeologyPart3.makeNil();
//             }
//             else {
//                 var spliitedElementValue = elementValue.split('-');
//                 var tokenValue = spliitedElementValue[1];
//                 H1GeologyPart3.undoMakeNil(token); // PASSING THE ELEMENT ID FOR REMOVING THE TEXT FROM TEXT BOX ON MINERAL CHANGE
//                 $('#unit_' + token).css('margin-left', '2px');
//                 $('#unit_' + token).html(tokenValue);

//             }

//         });



//         //=============================UNIT NUMBER==================================
//         var unitNoTd = $(document.createElement('td'));
//         unitNoTd.css("textAlign", "center");
//         aggregationTr.append(unitNoTd);
//         var unitNoInput = $(document.createElement('input'));
//         unitNoInput.css("textAlign", "right");
//         unitNoInput.attr("id", "unit_box_" + rowCount);
//         unitNoInput.addClass("unit_box number-fields-small");
//         unitNoInput.attr("name", "unit_box_" + rowCount);
//         unitNoTd.append(unitNoInput);

//         //=====================ELECTRICAL/NON-ELECTRICAL SELECT=====================
//         var electricalTd = $(document.createElement('td'));
//         electricalTd.css("textAlign", "center");
//         aggregationTr.append(electricalTd);
//         var electricalSelect = $(document.createElement('select'));
//         electricalSelect.attr("id", "electrical_select_" + rowCount);
//         electricalSelect.addClass("electrical_select selectbox-small");
//         electricalSelect.attr("name", "electrical_select_" + rowCount);
//         electricalTd.append(electricalSelect);

//         var electricalOption1 = $(document.createElement('option'));
//         electricalOption1.attr("value", "");
//         electricalOption1.html("Select");
//         electricalSelect.append(electricalOption1);

//         var electricalOption2 = $(document.createElement('option'));
//         electricalOption2.attr("value", "1");
//         electricalOption2.html("Electrical");
//         electricalSelect.append(electricalOption2);
//         var electricalOption3 = $(document.createElement('option'));
//         electricalOption3.attr("value", "2");
//         electricalOption3.html("Non Electrical");
//         electricalSelect.append(electricalOption3);

//         //var electricalOption4 = $(document.createElement('option'));
//         //electricalOption4.attr("value","3");
//         //electricalOption4.html("Both");
//         // electricalSelect.append(electricalOption4);
//         //=======================OPEN CAST/UNDERGROUND SELECT=======================
//         var openCastTd = $(document.createElement('td'));
//         openCastTd.css("textAlign", "center");
//         aggregationTr.append(openCastTd);
//         var openCastSelect = $(document.createElement('select'));
//         openCastSelect.attr("id", "opencast_select_" + rowCount);
//         openCastSelect.addClass("opencast_select selectbox-small");
//         openCastSelect.attr("name", "opencast_select_" + rowCount);
//         openCastTd.append(openCastSelect);

//         var openCastOption1 = $(document.createElement('option'));
//         openCastOption1.attr("value", "");
//         openCastOption1.html("Select");
//         openCastSelect.append(openCastOption1);

//         var openCastOption2 = $(document.createElement('option'));
//         openCastOption2.attr("value", "1");
//         openCastOption2.html("Opencast");
//         openCastSelect.append(openCastOption2);

//         var openCastOption3 = $(document.createElement('option'));
//         openCastOption3.attr("value", "2");
//         openCastOption3.html("Underground");
//         openCastSelect.append(openCastOption3);

//         var openCastOption4 = $(document.createElement('option'));
//         openCastOption4.attr("value", "3");
//         openCastOption4.html("Both");
//         openCastSelect.append(openCastOption4);
//         //=========================FIELD ROW ENDS HERE==============================

//         //========================CLOSE BUTTON CREATION=============================
//         if (rowCount > 1) {
//             var closeBtn = $(document.createElement('td'));
//             closeBtn.attr("id", "close_btn_" + rowCount);
//             closeBtn.addClass("h-close-icon");
//             aggregationTr.append(closeBtn);
//         }
//     },
//     aggregationAddMoreClick: function(machineryArray) {

//         var _this = this;
//         $("#aggregation_add_more").click(function() {
//             //==============INCREASING AGGREGATION HIDDEN FIELD VALUE=================
//             var aggregationHidden = $("#aggregation_hidden").val();
//             var newAggregation = parseInt(aggregationHidden) + 1;
//             $("#aggregation_hidden").val(newAggregation);

//             //=========CREATING AGGREGATION DYNAMIC FIELD ON ADD MORE CLICK===========
//             _this.aggregationDynamicRow(newAggregation, machineryArray);
//             _this.removeAggregation();
//         });
//     },
//     removeAggregation: function() {

//         var _this = this;
//         $(".h-close-icon").unbind("click");
//         $(".h-close-icon").click(function() {
//             //      var closeBtnId = $(this).attr('id');
//             //      var btnNo = closeBtnId.substr(-2,2);
//             //=======================REMOVING FIELD ON CLICK==========================
//             $(this).parent().remove();

//             var rowCount = $(".machine_select");
//             var newRowCount = rowCount.length;
//             //            console.log("slfjd")
//             if (newRowCount == 1) {
//                 $("#machine_select_1").append($('<option></option>').val("NIL").html('NIL'));
//             }

//             //=====================CREATING FORM FIELD ARRAY==========================
//             var fieldArray = new Array();
//             fieldArray[0] = "machine_select";
//             fieldArray[1] = "capacity_box";
//             fieldArray[2] = "unit_box";
//             fieldArray[3] = "electrical_select";
//             fieldArray[4] = "opencast_select";

//             //========================RENAMING FIELDS=================================
//             //_this.renameDynamicRow(fieldArray);  ///

//             //===============DECREASING AGGREGATION HIDDEN VLAUE======================
//             var aggregationCount = $("#aggregation_hidden").val();
//             var newAggregationCount = parseInt(aggregationCount) - 1;
//             $("#aggregation_hidden").val(newAggregationCount);
//         });

//     },
//     //====================AGGREGATION DYNAMIC PART ENDS===========================

//     //===========================FILLING FORM DATA================================
//     fillInit: function(part3Url, machineryArray) {
//         var _this = this;
//         $.ajax({
//             url: part3Url,
//             type: 'POST',
//             success: function(responseData) {
//                 _this.data = json_parse(responseData);
//                 if (_this.data != "") {
//                     _this.renderFieldWithData(machineryArray);
//                     //          _this.aggregationAddMoreClick(machineryArray);
//                     //          _this.yearlyDynamicRow()
//                     //          _this.yearlyAddMore()
//                     _this.removeAggregation();
//                 //          _this.yearlyRemove();
//                 }
//             }
//         })
//     },
//     renderFieldWithData: function(machineryArray) {
//         var _this = this;

//         //=========================RENDERING STATIC DATA============================
//         $.each(_this.data['static'], function(key, item) {
//             $("#" + key).attr("value", item);
//         });

//         //======================RENDERING AGGREGATION DATA==========================
//         var aggregationCount = _this.data['aggregation']['aggregation_count'];
//         /**
//          * STARTING FROM 2 AS 1 ROW WILL ALWAYS BE THERE
//          */
//         if (aggregationCount > 0) {
//             $("#aggregation_hidden").val(aggregationCount);
//             for (var i = 2; i <= aggregationCount; i++) {
//                 _this.aggregationDynamicRow(i, machineryArray);
//             }
//             var o = 1;
//             $.each(_this.data['aggregation'], function(key, item) {
//                 // console.log(key + "=>" + item)
//                 if (key == 'machine_select_1' && item == 'NIL') {
//                     H1GeologyPart3.makeNil();
//                 }
//                 var composedKey = "unit_" + o;
//                 if (key == composedKey) {
//                     content = "   " + item;
//                     $("#" + key).text(content);
//                     o++;
//                 }
//                 else {
//                     $("#" + key).attr("value", item);
//                 }
//             });
//         }

//     //========================RENDERING YEARLY DATA=============================
//     //=======COMMENTED AS ADD MORE FUNCTIONALITY REMOVED FROM THIS PART=========
//     //========================KEEPING IT FOR FUTURE=============================
//     //    var yearlyCount = _this.data['yearly']['yearly_count'];
//     //    
//     //    if(yearlyCount > 0){
//     //      $("#yearly_hidden").val(yearlyCount);
//     //      for(var j = 2; j <= yearlyCount; j++){
//     //        _this.yearlyDynamicRow(j);
//     //      }
//     //    
//     //      $.each(_this.data['yearly'], function(key, item){
//     //        $("#" + key).val(item);
//     //      });
//     //    }
//     },
//     makeNil: function() {
//         $(".capacity_box").val('0.000');
//         $(".unit_box").val(0);
//         $("#unit_1").hide();
//         $(".error").parent().find("div").remove();
//         $("#aggregation_add_more").hide();
//         $("#electrical_select_1").append(
//             $('<option></option>').val(0).html('NIL') // ADDED BY UDAY.. FOR NIL OPTIONS
//             );
//         $("#opencast_select_1").append(
//             $('<option></option>').val(0).html('NIL') // ADDED BY UDAY.. FOR NIL OPTIONS
//             );
//         $(".electrical_select").val(0);
//         $(".opencast_select").val(0);


//         $(".capacity_box").attr('readonly', true);
//         $(".unit_box").attr('readonly', true);
//         //==============DISABLING OTHER OPTIONS OF THE DROP DOWN================
//         $("#electrical_select_1 option[value='1']").attr('disabled', 'disabled');
//         $("#electrical_select_1 option[value='2']").attr('disabled', 'disabled');

//         $("#opencast_select_1 option[value='1']").attr('disabled', 'disabled');
//         $("#opencast_select_1 option[value='2']").attr('disabled', 'disabled');
//         $("#opencast_select_1 option[value='3']").attr('disabled', 'disabled');
//         //==============DISABLING OTHER OPTIONS OF THE DROP DOWN================

//         $(".capacity_box").css('background-color', '#D1D0CE');
//         $(".unit_box").css('background-color', '#D1D0CE');
//         $(".electrical_select_1").css('background-color', '#D1D0CE');
//         $(".opencast_select_1").css('background-color', '#D1D0CE');
//     },
//     undoMakeNil: function(elementIdNo) {
//         //        $(".capacity_box").val("");
//         //        $(".unit_box").val("");
//         $("#capacity_box_" + elementIdNo).val("");
//         $("#unit_box_" + elementIdNo).val("");

//         $("#unit_1").show();
//         $("#aggregation_add_more").show();
//         $("#electrical_select_" + elementIdNo).find('option[value=0]').remove();
//         $("#opencast_select_" + elementIdNo).find('option[value=0]').remove();
//         $("#electrical_select_" + elementIdNo).val("");
//         $("#opencast_select_" + elementIdNo).val("");

//         $(".capacity_box").attr('readonly', false);
//         $(".unit_box").attr('readonly', false);

//         //==============DISABLING OTHER OPTIONS OF THE DROP DOWN================
//         $("#electrical_select_1 option[value='1']").attr('disabled', false);
//         $("#electrical_select_1 option[value='2']").attr('disabled', false);

//         $("#opencast_select_1 option[value='1']").attr('disabled', false);
//         $("#opencast_select_1 option[value='2']").attr('disabled', false);
//         $("#opencast_select_1 option[value='3']").attr('disabled', false);
//         //==============DISABLING OTHER OPTIONS OF THE DROP DOWN================

//         $(".capacity_box").css('background-color', '#ffffff');
//         $(".unit_box").css('background-color', '#ffffff');
//         $(".electrical_select_1").css('background-color', '#ffffff');
//         $(".opencast_select_1").css('background-color', '#ffffff');
//     }
// }


var H1GeologyPart4 = {
    init: function(dataUrl) {
        //    this.getData();
        var _this = this;

        $.ajax({
            url: dataUrl,
            type: 'GET',
            success: function(responseData) {
                Utilities.ajaxBlockUI();
                _this.data = json_parse(responseData)
                if (_this.data != "") {
                    _this.createReservesForm();
                    _this.fillFormData();
                    GeologyPart4.fieldValidation();
                }
                else {
                    _this.createReservesForm();
                /*GeologyPart4.fieldValidation();*/
                }
            }
        })
    },
    createReservesForm: function() {
        var _this = this;

        var elem_no = 1;
        _this.reserveRowNames = new Array(
            'proved_min',
            'probable_first_min',
            'probable_second_min',
            'feasibility_min',
            'pre_feasibility_first_min',
            'pre_feasibility_second_min',
            'measured_min',
            'indicated_min',
            'inferred_min',
            'recon_min'
            );

        /**
         * ON PRINTING THE BELOW INDEX AND ITEM_NAME WE GETS THE ID AND THE NAME OF 
         * THE ABOVE ARRAY ELEMENT 
         * eg: index -> 0 and item_name -> proved_min
         **/
        _this.fieldCreationLoop(_this.reserveRowNames, elem_no);

    },
    createReserveQtyBox: function(table_name, elem_no) {
        var table = $("#" + table_name + "_qty_table");

        var tr = $(document.createElement('tr'));
        table.append(tr);

        var td = $(document.createElement('td'));
        tr.append(td);

        var qty_box = $(document.createElement('input'));
        qty_box.attr("id", table_name + "_qty_" + elem_no);
        qty_box.attr("name", table_name + "_qty_" + elem_no);
        qty_box.addClass(table_name + "_qty checkqty text-fields");
        qty_box.css("width", "80px");
        td.append(qty_box);
    },
    createReserveGradeBox: function(table_name, elem_no) {
        var _this = this;
        var table = $("#" + table_name + "_grade_table");

        _this.nmiGrades = Array(
            'Lump High Grade',
            'Lump Medium Grade',
            'Lump Low Grade',
            'Lump Unclassified Grade',
            'Fines High Grade',
            'Fines Medium Grade',
            'Fines Low Grade',
            'Fines Unclassified Grade'
            );

        var tr = $(document.createElement('tr'));
        table.append(tr);

        var grade_td = $(document.createElement('td'));
        tr.append(grade_td);

        var grade_box = $(document.createElement('select'));
        grade_box.attr("id", table_name + "_grade_" + elem_no);
        grade_box.attr("name", table_name + "_grade_" + elem_no);
        grade_box.addClass(table_name + "_grade checkGrade h-selectbox");
        grade_td.append(grade_box);

        var selectDefaultOption = $(document.createElement('option'));
        selectDefaultOption.html('Select');
        selectDefaultOption.val('');
        grade_box.append(selectDefaultOption);
        var optionCount = 0;
        $.each(_this.nmiGrades, function(index, item) {
            optionCount += 1;
            var grade_options = $(document.createElement('option'));
            grade_options.html(item);
            grade_options.val(optionCount);
            grade_box.append(grade_options);
        });

        if (elem_no > 1) {
            var close_td = $(document.createElement('td'));
            close_td.addClass("h-close-icon reserve-close-icon");
            close_td.bind('click', function() {
                //remove 
                $(this).parent().remove();
                var id = $(this).prev().children(':first-child').attr('id');
                var tmp = id.split('_');
                var deleted_elem_no = tmp[tmp.length - 1];
                var qtybox = document.getElementById(table_name + '_qty_' + deleted_elem_no);
                $(qtybox).parent().parent().remove();

                //rename the id and name for the other text and select boxes
                _this.renameReserveBoxes(table_name);

                //hidden count
                var reserveTableCount = document.getElementById(table_name + '_count');
                var prev_table_count = reserveTableCount.value;
                var dec_table_count = parseInt(prev_table_count) - 1;
                reserveTableCount.value = dec_table_count;
            });
            tr.append(close_td);
        }
    },
    renameReserveBoxes: function(table_name) {
        var qty_boxes = $('.' + table_name + '_qty');
        var grade_boxes = $('.' + table_name + '_grade');

        for (var j = 0; j < qty_boxes.length; j++) {
            var count = j + 1;
            $(qty_boxes[j]).attr('name', table_name + '_qty_' + count);
            $(qty_boxes[j]).attr('id', table_name + '_qty_' + count);

            $(grade_boxes[j]).attr('name', table_name + '_grade_' + count);
            $(grade_boxes[j]).attr('id', table_name + '_grade_' + count);
        }
    },
    fillFormData: function() {
        var _this = this;


        _this.createEditTableFields();
        // COMMENST TO BE REMOVED
        $.each(_this.data['data'], function(key, item) {
            $('#' + key).attr("value", item);
        });
    },
    fieldCreationLoop: function(rowNames, elem_no) {
        var _this = this;
        $.each(rowNames, function(index, item_name) {

            _this.createReserveQtyBox(item_name, elem_no);
            _this.createReserveGradeBox(item_name, elem_no);

            var add_btn = document.getElementById(item_name + "_add_btn");
            add_btn.onclick = function() {
                //hidden count
                var reserveTableCount = document.getElementById(item_name + '_count');
                var prev_table_count = reserveTableCount.value;
                var inc_table_count = parseInt(prev_table_count) + 1;
                reserveTableCount.value = inc_table_count;

                _this.createReserveQtyBox(item_name, inc_table_count);
                _this.createReserveGradeBox(item_name, inc_table_count);
            }
        });

    },
    createEditTableFields: function() {
        var _this = this;

        $.each(_this.data['count'], function(key, item) {
            var dataParse = parseInt(item);
            if (dataParse > 1) {
                for (var j = 2; j <= dataParse; j++) {
                    if (key == 'provedCount') {
                        _this.createReserveQtyBox('proved_min', j);
                        _this.createReserveGradeBox('proved_min', j);
                        var reserveTableCount = document.getElementById('proved_min_count');
                        var prev_table_count = reserveTableCount.value;
                        var inc_table_count = parseInt(prev_table_count) + 1;
                        reserveTableCount.value = inc_table_count;

                    }
                    if (key == 'probableFirstCount') {
                        _this.createReserveQtyBox('probable_first_min', j);
                        _this.createReserveGradeBox('probable_first_min', j);
                        var reserveTableCount = document.getElementById('probable_first_min_count');
                        var prev_table_count = reserveTableCount.value;
                        var inc_table_count = parseInt(prev_table_count) + 1;
                        reserveTableCount.value = inc_table_count;
                    }
                    if (key == 'probableSecondCount') {
                        _this.createReserveQtyBox('probable_second_min', j);
                        _this.createReserveGradeBox('probable_second_min', j);
                        var reserveTableCount = document.getElementById('probable_second_min_count');
                        var prev_table_count = reserveTableCount.value;
                        var inc_table_count = parseInt(prev_table_count) + 1;
                        reserveTableCount.value = inc_table_count;
                    }
                    if (key == 'feasibilityCount') {
                        _this.createReserveQtyBox('feasibility_min', j);
                        _this.createReserveGradeBox('feasibility_min', j);
                        var reserveTableCount = document.getElementById('feasibility_min_count');
                        var prev_table_count = reserveTableCount.value;
                        var inc_table_count = parseInt(prev_table_count) + 1;
                        reserveTableCount.value = inc_table_count;
                    }
                    if (key == 'preFeasiFirstCount') {
                        _this.createReserveQtyBox('pre_feasibility_first_min', j);
                        _this.createReserveGradeBox('pre_feasibility_first_min', j);
                        var reserveTableCount = document.getElementById('pre_feasibility_first_min_count');
                        var prev_table_count = reserveTableCount.value;
                        var inc_table_count = parseInt(prev_table_count) + 1;
                        reserveTableCount.value = inc_table_count;
                    }
                    if (key == 'preFeasiSecondCount') {
                        _this.createReserveQtyBox('pre_feasibility_second_min', j);
                        _this.createReserveGradeBox('pre_feasibility_second_min', j);
                        var reserveTableCount = document.getElementById('pre_feasibility_second_min_count');
                        var prev_table_count = reserveTableCount.value;
                        var inc_table_count = parseInt(prev_table_count) + 1;
                        reserveTableCount.value = inc_table_count;
                    }
                    if (key == 'measuredCount') {
                        _this.createReserveQtyBox('measured_min', j);
                        _this.createReserveGradeBox('measured_min', j);
                        var reserveTableCount = document.getElementById('measured_min_count');
                        var prev_table_count = reserveTableCount.value;
                        var inc_table_count = parseInt(prev_table_count) + 1;
                        reserveTableCount.value = inc_table_count;
                    }
                    if (key == 'indicatedCount') {
                        _this.createReserveQtyBox('indicated_min', j);
                        _this.createReserveGradeBox('indicated_min', j);
                        var reserveTableCount = document.getElementById('indicated_min_count');
                        var prev_table_count = reserveTableCount.value;
                        var inc_table_count = parseInt(prev_table_count) + 1;
                        reserveTableCount.value = inc_table_count;
					}
						// ADDED BY UDAY SHANKAR SINGH FOR SHOWING DYNAMIC COUNT
						// on 3rd Feb 2015
						if (key == 'inferredCount') {
                        _this.createReserveQtyBox('inferred_min', j);
                        _this.createReserveGradeBox('inferred_min', j);
                        var reserveTableCount = document.getElementById('inferred_min_count');
                        var prev_table_count = reserveTableCount.value;
                        var inc_table_count = parseInt(prev_table_count) + 1;
                        reserveTableCount.value = inc_table_count;
                    }
					// UPTO THIS POINT CODE ADDED 
                    if (key == 'reconCount') {
                        _this.createReserveQtyBox('recon_min', j);
                        _this.createReserveGradeBox('recon_min', j);
                        var reserveTableCount = document.getElementById('recon_min_count');
                        var prev_table_count = reserveTableCount.value;
                        var inc_table_count = parseInt(prev_table_count) + 1;
                        reserveTableCount.value = inc_table_count;
                    }
                }
            }
        });


    }
}

var H1GeologyPart6 = {
    fillInit: function(part6Url) {
        var _this = this;
        $.ajax({
            url: part6Url,
            type: 'POST',
            success: function(responseData) {
                _this.data = json_parse(responseData);
                if (_this.data != "") {
                    _this.renderFieldWithData();
                }
            }
        })
    },
    renderFieldWithData: function() {
        var _this = this;
        //=========================RENDERING STATIC DATA============================
        $.each(_this.data['static'], function(key, item) {
            $("#" + key).attr("value", item);
        });

    }

}
//================CREATION AND DISPLAY OF THE FORM AND DATA ENDS================

//============HANDELS THE FINAL SUBMISSION OF THE ANNUAL RETURN FORM============
/**
 * Takes two parameter:-
 * 1. finalSubmitActionUrl -> url of the action that will checks all the forms
 * 2.  successRedirectURl -> On no error on the form the page will redirect to this url
 */
var annualFinalValidation = {
    annualFinalSubmit: function(finalSubmitActionUrl, successRedirectUrl) {
        Utilities.ajaxBlockUI();

        //        $.ajax({
        //            url: finalSubmitActionUrl,
        //            type: "POST",
        //            async: false,
        //            data: ({
        //                check: 'romCheck'
        //            }),
        //            success: function(response) {
        //                console.log(response)
        //            }
        //        });
        $.ajax({
            url: finalSubmitActionUrl,
            success: function(finalSubmitActionResponse) {

                //=========CHECKING FOR NO ERROR FOUND, AND REDIRECTING THE PAGE========
                if (finalSubmitActionResponse == "" || finalSubmitActionResponse == null) {
                    window.location = successRedirectUrl;
                    return;
                }

                //                else if (finalSubmitActionResponse == "bothVary") {
                //                    window.location = successRedirectUrl;
                //                    return;
                //
                ////                    alert("Grade wise production total is different from ROM production total. Also, ROM production different from explosive consumption total production during the year. Please rectify the error before proceding.");
                //                }
                if (finalSubmitActionResponse == "singleVary") {
                    //                    window.location = successRedirectUrl;
                    //                    return;

                    alert("ROM production is different from 'Total production during the year' given at Part IV - item 2. Please verify the error before you submit.");
                //                    alert("ROM production does not match with same mentioned in part IV item 2. Please rectify.");
                }
                else {


                    //====IF MULTIPLE ERROR, THEN SPLIT THE ERRORS AND THEN DISPLAY THEM====
                    var data = finalSubmitActionResponse.split('|');

                    //===========THIS TABLE IS ALREADY CREATED IN THE SUCCESS FILE==========
                    /*
                     var table = document.getElementById('final-submit-error');
                     $(table).empty();
                     
                     var empty_tr1 = document.createElement('tr');
                     empty_tr1.innerHTML = "&nbsp;";
                     table.appendChild(empty_tr1);
                     var empty_tr2 = document.createElement('tr');
                     empty_tr2.innerHTML = "&nbsp;";
                     table.appendChild(empty_tr2);*/

                    var finalSubmitArray = new Array();
                    finalSubmitArray += "<tr> <td style='height:5px'>&nbsp</td></tr>";
                    for (var i = 0; i < data.length; i++) {
                        finalSubmitArray += "<tr><td align='left' style='text-align:left; color:#f00'>" + data[i] + "</td></tr>";
                    }
                    $("#final-submit-error").html(finalSubmitArray);
                }
            }
        });

    }
}

//=====================VALIDATION OF FORM AND DATA STARTS=======================

var MaterialCost = {
    fieldValidator: function() {
        var _this = this;
        //    jQuery.validator.addMethod("explValueEntered", function(value, element) {
        //      var explValue = $("#EXPLOSIVES_VALUE").val();
        //      if(explValue != "" && explValue > 0){
        //        alert("Quantity of explosives consumed to be given in Part IV.");
        //        return true;
        //      }
        //      else
        //        return true;
        //    },
        //    ""
        //    );

        $("#materialConsumptionQuantity").validate({
            onkeyup: false,
            //      onsubmit: false,
            rules: {
                COAL_QUANTITY: {
                    required: true,
                    maxlength: 10,
                    minlength: 1,
                    number: true,
                    digits: true
                },
                COAL_VALUE: {
                    required: true,
                    maxlength: 12,
                    minlength: 1,
                    number: true,
                    digits: true
                },
                DIESEL_QUANTITY: {
                    required: true,
                    maxlength: 10,
                    minlength: 1,
                    number: true,
                    digits: true
                },
                DIESEL_VALUE: {
                    required: true,
                    maxlength: 12,
                    minlength: 1,
                    number: true,
                    digits: true
                },
                PETROL_QUANTITY: {
                    required: true,
                    maxlength: 10,
                    minlength: 1,
                    number: true,
                    digits: true
                },
                PETROL_VALUE: {
                    required: true,
                    maxlength: 12,
                    minlength: 1,
                    number: true,
                    digits: true
                },
                KEROSENE_QUANTITY: {
                    required: true,
                    maxlength: 10,
                    minlength: 1,
                    number: true,
                    digits: true
                },
                KEROSENE_VALUE: {
                    required: true,
                    maxlength: 12,
                    minlength: 1,
                    number: true,
                    digits: true
                },
                GAS_QUANTITY: {
                    required: true,
                    maxlength: 10,
                    minlength: 1,
                    number: true,
                    digits: true
                },
                GAS_VALUE: {
                    required: true,
                    maxlength: 12,
                    minlength: 1,
                    number: true,
                    digits: true
                },
                LUBRICANT_QUANTITY: {
                    required: true,
                    maxlength: 10,
                    minlength: 1,
                    number: true,
                    digits: true
                },
                LUBRICANT_VALUE: {
                    required: true,
                    maxlength: 12,
                    minlength: 1,
                    number: true,
                    digits: true
                },
                GREASE_QUANTITY: {
                    required: true,
                    maxlength: 10,
                    minlength: 1,
                    number: true,
                    digits: true
                },
                GREASE_VALUE: {
                    required: true,
                    maxlength: 12,
                    minlength: 1,
                    number: true,
                    digits: true
                },
                CONSUMED_QUANTITY: {
                    required: true,
                    maxlength: 10,
                    minlength: 1,
                    number: true,
                    digits: true
                },
                CONSUMED_VALUE: {
                    required: true,
                    maxlength: 12,
                    minlength: 1,
                    number: true,
                    digits: true
                },
                GENERATED_QUANTITY: {
                    required: true,
                    maxlength: 10,
                    minlength: 1,
                    number: true,
                    digits: true
                },
                GENERATED_VALUE: {
                    required: true,
                    maxlength: 12,
                    minlength: 1,
                    number: true,
                    digits: true
                },
                SOLD_QUANTITY: {
                    required: true,
                    maxlength: 10,
                    minlength: 1,
                    number: true,
                    digits: true
                },
                SOLD_VALUE: {
                    required: true,
                    maxlength: 12,
                    minlength: 1,
                    number: true,
                    digits: true
                },
                TYRES_QUANTITY: {
                    required: true,
                    maxlength: 10,
                    minlength: 1,
                    number: true,
                    digits: true
                },
                TYRES_VALUE: {
                    required: true,
                    maxlength: 12,
                    minlength: 1,
                    number: true,
                    digits: true
                },
                EXPLOSIVES_VALUE: {
                    required: _this.explosivePart4ValueCheck,
                    maxlength: 12,
                    minlength: 1,
                    number: true,
                    digits: true,
                    min: 0
                //          explValueEntered: true
                },
                TIMBER_VALUE: {
                    required: false,
                    maxlength: 12,
                    minlength: 1,
                    number: true,
                    digits: true
                },
                DRILL_QUANTITY: {
                    required: true,
                    maxlength: 10,
                    minlength: 1,
                    number: true,
                    digits: true
                },
                DRILL_VALUE: {
                    required: true,
                    maxlength: 12,
                    minlength: 1,
                    number: true,
                    digits: true
                },
                OTHER_VALUE: {
                    required: false,
                    maxlength: 12,
                    minlength: 1,
                    number: true,
                    digits: true
                }
            },
            messages: {
                COAL_QUANTITY: {
                    required: "Please enter quantity",
                    maxlength: "Max length allowed is 10 digits",
                    minlength: "Min. length allowed is {0}",
                    number: "Please enter numeric digits only",
                    digits: "Decimal number are not allowed"
                },
                COAL_VALUE: {
                    required: "Please enter value",
                    maxlength: "Max length allowed is 12 digits",
                    minlength: "Min. length allowed is {0}",
                    number: "Please enter numeric digits only",
                    digits: "Decimal number are not allowed"
                },
                DIESEL_QUANTITY: {
                    required: "Please enter quantity",
                    maxlength: "Max length allowed is 10 digits",
                    minlength: "Min. length allowed is {0}",
                    number: "Please enter numeric digits only",
                    digits: "Decimal number are not allowed"
                },
                DIESEL_VALUE: {
                    required: "Please enter value",
                    maxlength: "Max length allowed is 12 digits",
                    minlength: "Min. length allowed is {0}",
                    number: "Please enter numeric digits only",
                    digits: "Decimal number are not allowed"
                },
                PETROL_QUANTITY: {
                    required: "Please enter quantity",
                    maxlength: "Max length allowed is 10 digits",
                    minlength: "Min. length allowed is {0}",
                    number: "Please enter numeric digits only",
                    digits: "Decimal number are not allowed"
                },
                PETROL_VALUE: {
                    required: "Please enter value",
                    maxlength: "Max length allowed is 12 digits",
                    minlength: "Min. length allowed is {0}",
                    number: "Please enter numeric digits only",
                    digits: "Decimal number are not allowed"
                },
                KEROSENE_QUANTITY: {
                    required: "Please enter quantity",
                    maxlength: "Max length allowed is 10 digits",
                    minlength: "Min. length allowed is {0}",
                    number: "Please enter numeric digits only",
                    digits: "Decimal number are not allowed"
                },
                KEROSENE_VALUE: {
                    required: "Please enter value",
                    maxlength: "Max length allowed is 12 digits without decimal",
                    minlength: "Min. length allowed is {0}",
                    number: "Please enter numeric digits only",
                    digits: "Decimal number are not allowed"
                },
                GAS_QUANTITY: {
                    required: "Please enter quantity",
                    maxlength: "Max length allowed is 10 digits",
                    minlength: "Min. length allowed is {0}",
                    number: "Please enter numeric digits only",
                    digits: "Decimal number are not allowed"
                },
                GAS_VALUE: {
                    required: "Please enter value",
                    maxlength: "Max length allowed is 12 digits",
                    minlength: "Min. length allowed is {0}",
                    number: "Please enter numeric digits only",
                    digits: "Decimal number are not allowed"
                },
                LUBRICANT_QUANTITY: {
                    required: "Please enter quantity",
                    maxlength: "Max length allowed is 10 digits",
                    minlength: "Min. length allowed is {0}",
                    number: "Please enter numeric digits only",
                    digits: "Decimal number are not allowed"
                },
                LUBRICANT_VALUE: {
                    required: "Please enter value",
                    maxlength: "Max length allowed is 12 digits",
                    minlength: "Min. length allowed is {0}",
                    number: "Please enter numeric digits only",
                    digits: "Decimal number are not allowed"
                },
                GREASE_QUANTITY: {
                    required: "Please enter quantity",
                    maxlength: "Max length allowed is 10 digits",
                    minlength: "Min. length allowed is {0}",
                    number: "Please enter numeric digits only",
                    digits: "Decimal number are not allowed"
                },
                GREASE_VALUE: {
                    required: "Please enter value",
                    maxlength: "Max length allowed is 12 digits",
                    minlength: "Min. length allowed is {0}",
                    number: "Please enter numeric digits only",
                    digits: "Decimal number are not allowed"
                },
                CONSUMED_QUANTITY: {
                    required: "Please enter quantity",
                    maxlength: "Max length allowed is 10 digits",
                    minlength: "Min. length allowed is {0}",
                    number: "Please enter numeric digits only",
                    digits: "Decimal number are not allowed"
                },
                CONSUMED_VALUE: {
                    required: "Please enter value",
                    maxlength: "Max length allowed is 12 digits",
                    minlength: "Min. length allowed is {0}",
                    number: "Please enter numeric digits only",
                    digits: "Decimal number are not allowed"
                },
                GENERATED_QUANTITY: {
                    required: "Please enter quantity",
                    maxlength: "Max length allowed is 10 digits",
                    minlength: "Min. length allowed is {0}",
                    number: "Please enter numeric digits only",
                    digits: "Decimal number are not allowed"
                },
                GENERATED_VALUE: {
                    required: "Please enter value",
                    maxlength: "Max length allowed is 12 digits",
                    minlength: "Please enter value",
                    number: "Please enter numeric digits only",
                    digits: "Decimal number are not allowed"
                },
                SOLD_QUANTITY: {
                    required: "Please enter quantity",
                    maxlength: "Max length allowed is 10 digits",
                    minlength: "Min. length allowed is {0}",
                    number: "Please enter numeric digits only",
                    digits: "Decimal number are not allowed"
                },
                SOLD_VALUE: {
                    required: "Please enter value",
                    maxlength: "Max length allowed is 12 digits",
                    minlength: "Min. length allowed is {0}",
                    number: "Please enter numeric digits only",
                    digits: "Decimal number are not allowed"
                },
                TYRES_QUANTITY: {
                    required: "Please enter quantity",
                    maxlength: "Max length allowed is 10 digits",
                    minlength: "Min. length allowed is {0}",
                    number: "Please enter numeric digits only",
                    digits: "Decimal number are not allowed"
                },
                TYRES_VALUE: {
                    required: "Please enter value",
                    maxlength: "Max length allowed is 12 digits",
                    minlength: "Min. length allowed is {0}",
                    number: "Please enter numeric digits only",
                    digits: "Decimal number are not allowed"
                },
                EXPLOSIVES_VALUE: {
                    required: "Please enter value",
                    maxlength: "Max length allowed is 12 digits",
                    minlength: "Min. length allowed is {0}",
                    number: "Please enter numeric digits only",
                    digits: "Decimal number are not allowed",
                    min: "This field is required now. Please enter valid value"
                },
                TIMBER_VALUE: {
                    //          required: "Please enter quantity",
                    maxlength: "Max length allowed is 12 digits",
                    minlength: "Min. length allowed is {0}",
                    number: "Please enter numeric digits only",
                    digits: "Decimal number are not allowed"
                },
                DRILL_QUANTITY: {
                    required: "Please enter quantity",
                    maxlength: "Max length allowed is 10 digits",
                    minlength: "Min. length allowed is {0}",
                    number: "Please enter numeric digits only",
                    digits: "Decimal number are not allowed"
                },
                DRILL_VALUE: {
                    required: "Please enter value",
                    maxlength: "Max length allowed is 12 digits",
                    minlength: "Min. length allowed is {0}",
                    number: "Please enter numeric digits only",
                    digits: "Decimal number are not allowed"
                },
                OTHER_VALUE: {
                    //          required: "Please enter quantity",
                    maxlength: "Max length allowed is 12 digits",
                    minlength: "Min. length allowed is {0}",
                    number: "Please enter numeric digits only",
                    digits: "Decimal number are not allowed"
                }
            }
        //      errorPlacement: function(error, element){
        //        var elementId = $(element).attr('id')
        //        if(elementId == 'EXPLOSIVES_VALUE'){
        //          console.log("still roaming")
        //        }
        //      }

        });
    },
    postFormValidation: function() {
        $("#materialConsumptionQuantity").submit(function(event) {

            //==GETTING ELEMENT BY CLASS NAME QUANTITY TO CHECK TH EMPTY VALUE FIELD==
            var quantityFields = $(".quantity");
            var fieldCount = quantityFields.length;

            var unitCalError = 0;
            for (var i = 0; i < fieldCount; i++) {
                var quantityId = quantityFields[i].id;
                var quantityValue = parseInt($("#" + quantityId).val());
                if (!isNaN(quantityValue) && quantityValue > 0) {
                    var splittedId = quantityId.split("_");
                    var valueFieldId = "#" + splittedId[0] + "_VALUE";
                    var valueFieldValue = parseInt($(valueFieldId).val());

                    if (valueFieldValue == 0 || isNaN(valueFieldValue)) {
                        unitCalError++
                    }
                }
            }
            if (unitCalError > 0) {
                alert("Please enter the values for entered quantity");
                event.preventDefault();
            }
        // THIS FUNCTIONALITY HAS BEEN COMMENTED TO AVOID DEAD LOCK WHILE FILING THE FORM
        // @author Uday Shankar Singh<usingh@ubicsindia.com, udayshankar1306@gmail.com>
        // @version 6th Feb 2014
        //            var explosiveCheckValue = $("#explosiveFieldsCheck").val();
        //            var enteredExplosiveValue = parseFloat($("#EXPLOSIVES_VALUE").val());
        //            if (parseInt(explosiveCheckValue) == 1 && enteredExplosiveValue == 0){
        //                alert("Enter the value in item- IV Explosive as you have entered data more than 0 in Part IV Explosive Consumption (item 1-9)");
        //                event.preventDefault();
        //            }



        });
    },
    /**
     * FUNCTION CHECKS THE HIDDEN EXPLOSIVE CONSUMPTION VALUE AND THEN MAKE THE 
     * FIELD REQUIRED ACCORDING TO THAT i.e, IF EXPLOSIVE CONSUMPTION FORM HAS
     * DATA THEN, MAKE THE THIS FIELD REQUIRED ELSE NOT REQUIRED
     **/
    explosivePart4ValueCheck: function() {
        var explosiveCheckValue = $("#explosiveFieldsCheck").val();
        if (parseInt(explosiveCheckValue) == 1)
            return true;
        else
            return false;
    },
    /**
     * PUTS THE ALERT AS PER THE VALUE OF THE EXPLOSIVE CONSUMPTION FORM AND AS 
     * PER THE VALUE ENTERED IN THE FIELD
     **/
    explosiveValueCheck: function() {
        $("#EXPLOSIVES_VALUE").focusout(function() {

            var filledValue = parseInt($(this).val());
            var explosiveCheckValue = $("#explosiveFieldsCheck").val();
            if (parseInt(explosiveCheckValue) == 1) {
                if (filledValue > 0)
                    alert("Kindly Furnish full details in Part IV, against quantity of explosives consumed.");
            }
            else
            if (filledValue > 0){
                alert("Quantity of explosives consumed to be given in Part IV.");
            }

        });

    },
    unitPriceAlert: function() {

        $(".value").focusout(function() {
            //===================GETTING THE ID AND VALUE OF THE VALUE FIELD==========
            var elementId = $(this).attr("id");
            var elementValue = parseInt($(this).val());

            /**
             * TAKING OUT THE STRING TO MAKE THE QUANTITY ID AND THEN GETTING THE 
             * QUANTITY VALUE
             **/

            var splittedString = elementId.split("_");
            var stringPart1 = splittedString[0];

            var quantityId = "#" + stringPart1 + "_QUANTITY";
            var quantityValue = parseInt($(quantityId).val());
            //=====================CHECKING THE QUANTITY VALUE FOR NULL===============
            if (!isNaN(quantityValue) && quantityValue != 0) {
                if (!isNaN(elementValue) && elementValue != 0) {
                    //var unitValue = (quantityValue / elementValue);
                    var unitValue = (elementValue / quantityValue);
                    var roundOffUnitValue = Utilities.roundOff3(unitValue);
                    alert("Unit Price = " + roundOffUnitValue);
                }
                else {
                    alert("Please enter valid value");
                    $("#" + elementId).val("");
                }
            }
            else if (elementValue > 0) {
                if (isNaN(quantityValue) || quantityValue == 0) {
                    alert("Please enter valid Quantity Value");
                    $(quantityId).val("");
                    $("#" + elementId).val("");
                }
            }
        });
    }

}

var Royality = {
    fieldValidation: function() {
        $("#materialConsumptionRoyalty").validate({
            rules: {
                ROYALTY_CURRENT: {
                    //required: true,
                    maxlength: 12,
                    minlength: 1,
                    number: true,
                    digits: true
                },
                ROYALTY_PAST: {
                    //required: true,
                    maxlength: 12,
                    minlength: 1,
                    number: true,
                    digits: true
                },
                DEAD_RENT_CURRENT: {
                    //required: true,
                    maxlength: 12,
                    minlength: 1,
                    number: true,
                    digits: true
                },
                DEAD_RENT_PAST: {
                    //required: true,
                    maxlength: 12,
                    minlength: 1,
                    number: true,
                    digits: true
                },
                SURFACE_RENT_CURRENT: {
                    //required: true,
                    maxlength: 12,
                    minlength: 1,
                    number: true,
                    digits: true
                },
                SURFACE_RENT_PAST: {
                    //required: true,
                    maxlength: 12,
                    minlength: 1,
                    number: true,
                    digits: true
                },
				
				
				/*
					In new form, four new extra fields are added. So add four new fields 
					"CURRENT_PAY_DMF", "PAST_PAY_DMF", "CURRENT_PAY_NMET", "PAST_PAY_NMET"
					Done by Pravin Bhakare, 18/8/2020
				 */
				CURRENT_PAY_DMF: {
                    //required: true,
                    maxlength: 12,
                    minlength: 1,
                    number: true,
                    digits: true
                },
				PAST_PAY_DMF: {
                    //required: true,
                    maxlength: 12,
                    minlength: 1,
                    number: true,
                    digits: true
                },
				CURRENT_PAY_NMET: {
                    //required: true,
                    maxlength: 12,
                    minlength: 1,
                    number: true,
                    digits: true
                },
				PAST_PAY_NMET: {
                    //required: true,
                    maxlength: 12,
                    minlength: 1,
                    number: true,
                    digits: true
                },
				
				
                TREE_COMPENSATION: {
                    //required: true,
                    maxlength: 12,
                    minlength: 1,
                    number: true,
                    digits: true
                },
                DEPRECIATION: {
                   // required: false,
                    maxlength: 12,
                    minlength: 1,
                    number: true,
                    digits: true
                }
            },
            messages: {
                ROYALTY_CURRENT: {
                    required: "Please enter data",
                    maxlength: "Max length allowed is 12 digits",
                    minlength: "Min length is 1",
                    number: "Please enter numeric digits only",
                    digits: "Decimal numbers are not allowed"
                },
                ROYALTY_PAST: {
                    required: "Please enter data",
                    maxlength: "Max length allowed is 12 digits",
                    minlength: "Min length is 1",
                    number: "Please enter numeric digits only",
                    digits: "Decimal numbers are not allowed"
                },
                DEAD_RENT_CURRENT: {
                    required: "Please enter data",
                    maxlength: "Max length allowed is 12 digits",
                    minlength: "Min length is 1",
                    number: "Please enter numeric digits only",
                    digits: "Decimal numbers are not allowed"
                },
                DEAD_RENT_PAST: {
                    required: "Please enter data",
                    maxlength: "Max length allowed is 12 digits",
                    minlength: "Min length is 1",
                    number: "Please enter numeric digits only",
                    digits: "Decimal numbers are not allowed"
                },
                SURFACE_RENT_CURRENT: {
                    required: "Please enter data",
                    maxlength: "Max length allowed is 12 digits",
                    minlength: "Min length is 1",
                    number: "Please enter numeric digits only",
                    digits: "Decimal numbers are not allowed"
                },
                SURFACE_RENT_PAST: {
                    required: "Please enter data",
                    maxlength: "Max length allowed is 12 digits",
                    minlength: "Min length is 1",
                    number: "Please enter numeric digits only",
                    digits: "Decimal numbers are not allowed"
                },
				
				/*
					In new form, four new extra fields are added. So add four new fields 
					"CURRENT_PAY_DMF", "PAST_PAY_DMF", "CURRENT_PAY_NMET", "PAST_PAY_NMET"
					Done by Pravin Bhakare, 18/8/2020
				 */
				CURRENT_PAY_DMF: {
                    required: "Please enter data",
                    maxlength: "Max length allowed is 12 digits",
                    minlength: "Min length is 1",
                    number: "Please enter numeric digits only",
                    digits: "Decimal numbers are not allowed"
                },
				PAST_PAY_DMF: {
                    required: "Please enter data",
                    maxlength: "Max length allowed is 12 digits",
                    minlength: "Min length is 1",
                    number: "Please enter numeric digits only",
                    digits: "Decimal numbers are not allowed"
                },
				CURRENT_PAY_NMET: {
                    required: "Please enter data",
                    maxlength: "Max length allowed is 12 digits",
                    minlength: "Min length is 1",
                    number: "Please enter numeric digits only",
                    digits: "Decimal numbers are not allowed"
                },
				PAST_PAY_NMET: {
                    required: "Please enter data",
                    maxlength: "Max length allowed is 12 digits",
                    minlength: "Min length is 1",
                    number: "Please enter numeric digits only",
                    digits: "Decimal numbers are not allowed"
                },
				
				
                TREE_COMPENSATION: {
                    required: "Please enter data",
                    maxlength: "Max length allowed is 12 digits",
                    minlength: "Min length is 1",
                    number: "Please enter numeric digits only",
                    digits: "Decimal numbers are not allowed"
                },
                DEPRECIATION: {
                    required: "Please enter data",
                    maxlength: "Max length allowed is 12 digits",
                    minlength: "Min length is 1",
                    number: "Please enter numeric digits only",
                    digits: "Decimal numbers are not allowed"
                }
            }
        });

        $("#DEPRECIATION").blur(function() {
            /**
             * GETTIN THE VALUE AND THEN CHECKING IT ELSE CURRENTLY THE ALERT IS 
             * COMING EVEN IF THE VALUE IS ENTERED IN THE TEXT FIELD
             * @author Uday Shankar Singh<usingh@ubicsindia.com, udayshankar1306@gmail.com>
             * @version 14th FEb 2014
             **/
            var elementValue = $(this).val();
            if(!elementValue.trim()){
                alert("Please fill Part-II A (Capital structure). Then the total value of depriciation will automatically be fetched from there.")
            //            alert("If not filed, the filled value gets automatically filled from Capital Structure depriciation during the year total.")
            }
        });

        $("#DEPRECIATION").focusout(function() {
            var depreciationCost = $('#depreciation_org').val();
            var depreciationVal = $("#DEPRECIATION").val();
            if (depreciationCost != depreciationVal) {
                alert("Depreciation entered is different from that reported in Column 5 of  Part-II A (Capital structure)");
            }
        });
    },
    monthlyAnnualAlert: function(royalityMonthlyTotal) {
        $("#ROYALTY_PAST").focusout(function() {
            var royalityCurrent = parseInt($("#ROYALTY_CURRENT").val());
            var royalityPast = parseInt($("#ROYALTY_PAST").val());
            if (!isNaN(royalityCurrent)) {
                if (!isNaN(royalityPast)) {
                    var annualTotal = (royalityCurrent + royalityPast)
                    if (annualTotal != royalityMonthlyTotal) {
                        var alertString = "Total as per monthly returns for Royalty is " + royalityMonthlyTotal +
                        " which is not equal to total of the amounts(Paid for current year + paid towards past arrears) entered in this return";
                        alert(alertString);
                    }
                }
            }
        });
    },
    postValidation: function(royalityMonthlyTotal) {
        $("#materialConsumptionRoyalty").submit(function(event) {
            $('#CURRENT_PAY_DMF').removeClass('is-invalid');
            $('#CURRENT_PAY_NMET').removeClass('is-invalid');
            $('#PAST_PAY_DMF').removeClass('is-invalid');
            $('#PAST_PAY_NMET').removeClass('is-invalid');
            var royalityCurrent = parseInt($("#ROYALTY_CURRENT").val());
            var royalityPast = parseInt($("#ROYALTY_PAST").val());
            var curntPayDMF = parseInt($("#CURRENT_PAY_DMF").val());
            var curntPayNMET = parseInt($("#CURRENT_PAY_NMET").val());
            var pastPayDMF = parseInt($("#PAST_PAY_DMF").val());
            var pastPayNMET = parseInt($("#PAST_PAY_NMET").val());
            if (curntPayDMF == '') {
                curntPayDMF = 0;
            }
            if (curntPayNMET == '') {
                curntPayNMET = 0;
            }
            if (pastPayDMF == '') {
                pastPayDMF = 0;
            }
            if (pastPayNMET == '') {
                pastPayNMET = 0;
            }

            if(royalityCurrent > 0 && (curntPayDMF == 0 || curntPayNMET == 0))
            {
                alert('Once Royalty is paid, DMF and NMET should not be 0');
                if (curntPayDMF == 0) {
                    $('#CURRENT_PAY_DMF').val('').addClass('is-invalid');
                }
                if (curntPayNMET == 0) {
                    $('#CURRENT_PAY_NMET').val('').addClass('is-invalid');
                }
                return false;
            }

            if(royalityPast > 0 && (pastPayDMF == 0 || pastPayNMET == 0))
            {
                alert('Once Royalty is paid, DMF and NMET should not be 0');
                if (pastPayDMF == 0) {
                    $('#PAST_PAY_DMF').val('').addClass('is-invalid');
                }
                if (pastPayNMET == 0) {
                    $('#PAST_PAY_NMET').val('').addClass('is-invalid');
                }
                return false;
            }



            if (!isNaN(royalityCurrent)) {
                if (!isNaN(royalityPast)) {
                    var annualTotal = (royalityCurrent + royalityPast)
                    if (annualTotal != royalityMonthlyTotal) {
                        var alertString = "Total as per monthly returns for Royalty is " + royalityMonthlyTotal +
                        " which is not equal to total of the amounts(Paid for current year + paid towards past arrears) entered in this return";
                        alert(alertString);
                    }
                }
            }
        });
    }
}


var OtherExpenses = {
    fieldValidation: function() {
        $("#materialConsumptionTax").validate({
            rules:
            {
                SALES_TAX_CENTRAL: {
                    required: false,
                    maxlength: 12,
                    minlength: 1,
                    number: true,
                    digits: true
                },
                SALES_TAX_STATE: {
                    required: false,
                    maxlength: 12,
                    minlength: 1,
                    number: true,
                    digits: true
                },
                WELFARE_TAX_CENTRAL: {
                    required: false,
                    maxlength: 12,
                    minlength: 1,
                    number: true,
                    digits: true
                },
                WELFARE_TAX_STATE: {
                    required: false,
                    maxlength: 12,
                    minlength: 1,
                    number: true,
                    digits: true
                },
                MIN_CESS_TAX_CENTRAL: {
                    required: false,
                    maxlength: 12,
                    minlength: 1,
                    number: true,
                    digits: true
                },
                MIN_CESS_TAX_STATE: {
                    required: false,
                    maxlength: 12,
                    minlength: 1,
                    number: true,
                    digits: true
                },
                DEAD_CESS_TAX_CENTRAL: {
                    required: false,
                    maxlength: 12,
                    minlength: 1,
                    number: true,
                    digits: true
                },
                OTHER_TAX: {
                    required: false,
                    maxlength: 100,
                    minlength: 1
                },
                OTHER_TAX_STATE: {
                    required: {
                        depends: function() {
                            if ($('#OTHER_TAX').val() != '' || $('#OTHER_TAX').val() != 0) {
                                return true;
                            }
                            else {
                                return false;
                            }
                        }
                    },
                    maxlength: 12,
                    minlength: 1,
                    number: true,
                    digits: true
                },
                OTHER_TAX_CENTRAL: {
                    required: {
                        depends: function() {
                            if ($('#OTHER_TAX').val() != '' || $('#OTHER_TAX').val() > 0) {
                                return true;
                            }
                            else {
                                return false;
                            }
                        }
                    },
                    maxlength: 12,
                    minlength: 1,
                    number: true,
                    digits: true
                },
                OVERHEADS: {
                    required: false,
                    maxlength: 12,
                    minlength: 1,
                    number: true,
                    digits: true
                },
                MAINTENANCE: {
                    required: false,
                    maxlength: 12,
                    minlength: 1,
                    number: true,
                    digits: true
                },
                WORKMEN_BENEFITS: {
                    required: false,
                    maxlength: 12,
                    minlength: 1,
                    number: true,
                    digits: true
                },
                PAYMENT_AGENCIES: {
                    required: false,
                    maxlength: 12,
                    minlength: 1,
                    number: true,
                    digits: true
                }
            },
            messages:
            {
                SALES_TAX_CENTRAL: {
                    required: "Field is required",
                    maxlength: "Max. length allowed is {0}",
                    minlength: "Min. length must be {0}",
                    number: "Please enter numeric digits only",
                    digits: "decimal numbers are not allowed"
                },
                SALES_TAX_STATE: {
                    required: "Field is required",
                    maxlength: "Max. length allowed is {0}",
                    minlength: "Min. length must be {0}",
                    number: "Please enter numeric digits only",
                    digits: "decimal numbers are not allowed"
                },
                WELFARE_TAX_CENTRAL: {
                    required: "Field is required",
                    maxlength: "Max. length allowed is {0}",
                    minlength: "Min. length must be {0}",
                    number: "Please enter numeric digits only",
                    digits: "decimal numbers are not allowed"
                },
                WELFARE_TAX_STATE: {
                    required: "Field is required",
                    maxlength: "Max. length allowed is {0}",
                    minlength: "Min. length must be {0}",
                    number: "Please enter numeric digits only",
                    digits: "decimal numbers are not allowed"
                },
                MIN_CESS_TAX_CENTRAL: {
                    required: "Field is required",
                    maxlength: "Max. length allowed is {0}",
                    minlength: "Min. length must be {0}",
                    number: "Please enter numeric digits only",
                    digits: "decimal numbers are not allowed"
                },
                MIN_CESS_TAX_STATE: {
                    required: "Field is required",
                    maxlength: "Max. length allowed is {0}",
                    minlength: "Min. length must be {0}",
                    number: "Please enter numeric digits only",
                    digits: "decimal numbers are not allowed"
                },
                DEAD_CESS_TAX_CENTRAL: {
                    required: "Field is required",
                    maxlength: "Max. length allowed is {0}",
                    minlength: "Min. length must be {0}",
                    number: "Please enter numeric digits only",
                    digits: "decimal numbers are not allowed"
                },
                OTHER_TAX_STATE: {
                    required: "Field is required",
                    maxlength: "Max. length allowed is {0}",
                    minlength: "Min. length must be {0}",
                    number: "Please enter numeric digits only",
                    digits: "decimal numbers are not allowed"
                },
                OTHER_TAX_CENTRAL: {
                    required: "Field is required",
                    maxlength: "Max. length allowed is {0}",
                    minlength: "Min. length must be {0}",
                    number: "Please enter numeric digits only",
                    digits: "decimal numbers are not allowed"
                },
                OTHER_TAX: {
                    required: "Field is required",
                    maxlength: "Max. length allowed is {0}",
                    minlength: "Min. length must be {0}"
                },
                OVERHEADS: {
                    required: "Field is required",
                    maxlength: "Max. length allowed is {0}",
                    minlength: "Min. length must be {0}",
                    number: "Please enter numeric digits only",
                    digits: "decimal numbers are not allowed"
                },
                MAINTENANCE: {
                    required: "Field is required",
                    maxlength: "Max. length allowed is {0}",
                    minlength: "Min. length must be {0}",
                    number: "Please enter numeric digits only",
                    digits: "decimal numbers are not allowed"
                },
                WORKMEN_BENEFITS: {
                    required: "Field is required",
                    maxlength: "Max. length allowed is {0}",
                    minlength: "Min. length must be {0}",
                    number: "Please enter numeric digits only",
                    digits: "decimal numbers are not allowed"
                },
                PAYMENT_AGENCIES: {
                    required: "Field is required",
                    maxlength: "Max. length allowed is {0}",
                    minlength: "Min. length must be {0}",
                    number: "Please enter numeric digits only",
                    digits: "decimal numbers are not allowed"
                }
            }
        });
    },
    taxPostValidation: function() {
        $("#materialConsumptionTax").submit(function(event) {
            var central = parseInt($("#OTHER_TAX_CENTRAL").val());
            var state = parseInt($("#OTHER_TAX_STATE").val());
            var other = $("#OTHER_TAX").val();
            if (!isNaN(central) && !isNaN(state)) {
                if (other == '' && central > 0 && state > 0) {
                    $("#otherID").show();
                    event.preventDefault();
                    return false;
                }
            }
            $("#otherID").hide();
        });
    }
}

var ProductionCost = {
    fieldRequiredCheck: function(overHeadField) {

        if (overHeadField > 0)
            return true;
        else
            return false;
    },
    checkAllFormFieldsForTotalRequired: function() {
        var fieldList = Array('TOTAL_DIRECT_COST', 'OVERHEAD_COST', 'DEPRECIATION_COST', 'INTEREST_COST', 'ROYALTY_COST', 'PAST_PAY_DMF', 'PAST_PAY_NMET', 'TAXES_COST', 'DEAD_RENT_COST', 'OTHERS_COST');
        var fieldCount = fieldList.length;
        var check = 0;
        for (var i = 0; i < fieldCount; i++) {
            var fieldValue = parseInt($("#" + fieldList[i]).val());
            if (!isNaN(fieldValue) && fieldValue > 0) {
                check = 1;
            }
        }

        if (check == 0) {
            return false;
        }
        else {
            return true;
        }
    },
    fieldValidation: function(overHeadField) {

        var _this = this;

        //====================roundOff to decimal 3 places==========================
        jQuery.validator.addMethod("fieldRoundOff", function(value, element) {
            return this.optional(element) || (/^[0-9,]+(\.\d{0,2})?$/).test(value);
        }, "Please enter number only to 2 decimal places");


        _this.fieldSum = 0;
        _this.fieldArray = new Array();
        
        $("#frmProductionCost").validate({
            onkeyup: false,
            rules:
            {
                TOTAL_DIRECT_COST: {
                    required: _this.fieldRequiredCheck(overHeadField),
                    maxlength: 8,
                    minlength: 1,
                    number: true,
                    fieldRoundOff: true,
                    //          totalCheck: true,
                    max: 99999.99
                },
                EXPLORATION_COST: {
                    required: _this.fieldRequiredCheck(overHeadField),
                    maxlength: 8,
                    minlength: 1,
                    number: true,
                    fieldRoundOff: true,
                    //totalCheck: true,
                    max: 99999.99
                },
                MINING_COST: {
                    required: _this.fieldRequiredCheck(overHeadField),
                    maxlength: 8,
                    minlength: 1,
                    number: true,
                    fieldRoundOff: true,
                    //totalCheck: true,
                    max: 99999.99
                },
                BENEFICIATION_COST: {
                    required: _this.fieldRequiredCheck(overHeadField),
                    maxlength: 8,
                    minlength: 1,
                    number: true,
                    fieldRoundOff: true,
                    //totalCheck: true,
                    max: 99999.99
                },
                OVERHEAD_COST: {
                    required: _this.fieldRequiredCheck(overHeadField),
                    maxlength: 8,
                    minlength: 1,
                    number: true,
                    fieldRoundOff: true,
                    //totalCheck: true,
                    max: 99999.99
                },
                DEPRECIATION_COST: {
                    required: _this.fieldRequiredCheck(overHeadField),
                    maxlength: 8,
                    minlength: 1,
                    number: true,
                    fieldRoundOff: true,
                    //totalCheck: true,
                    max: 99999.99
                },
                INTEREST_COST: {
                    required: _this.fieldRequiredCheck(overHeadField),
                    maxlength: 8,
                    minlength: 1,
                    number: true,
                    fieldRoundOff: true,
                    //totalCheck: true,
                    max: 99999.99
                },
                ROYALTY_COST: {
                    required: _this.fieldRequiredCheck(overHeadField),
                    maxlength: 8,
                    minlength: 1,
                    number: true,
                    fieldRoundOff: true,
                    //totalCheck: true,
                    max: 99999.99
                },
				PAST_PAY_DMF: {
                    required: _this.fieldRequiredCheck(overHeadField),
                    maxlength: 8,
                    minlength: 1,
                    number: true,
                    fieldRoundOff: true,
                    //totalCheck: true,
                    max: 99999.99
                },
				PAST_PAY_NMET: {
                    required: _this.fieldRequiredCheck(overHeadField),
                    maxlength: 8,
                    minlength: 1,
                    number: true,
                    fieldRoundOff: true,
                    //totalCheck: true,
                    max: 99999.99
                },
                TAXES_COST: {
                    required: _this.fieldRequiredCheck(overHeadField),
                    maxlength: 8,
                    minlength: 1,
                    number: true,
                    fieldRoundOff: true,
                    //totalCheck: true,
                    max: 99999.99
                },
                DEAD_RENT_COST: {
                    required: _this.fieldRequiredCheck(overHeadField),
                    maxlength: 8,
                    minlength: 1,
                    number: true,
                    fieldRoundOff: true,
                    //totalCheck: true,
                    max: 99999.99
                },
                OTHERS_COST: {
                    required: {
                        depends: function() {
                            if ($('#OTHERS_SPEC').val() != '' || $('#OTHERS_SPEC').val() != 0) {
                                return true;
                            }
                            else {
                                return false;
                            }
                        }
                    },
                    maxlength: 8,
                    minlength: 1,
                    number: true,
                    fieldRoundOff: true,
                    //totalCheck: true,
                    max: 99999.99
                },
                OTHERS_SPEC: {
                    //          required: _this.fieldRequiredCheck(overHeadField),
                    required: {
                        depends: function() {
                            if ($('#OTHERS_COST').val() != '' && $('#OTHERS_COST').val() > 0) {
                                return true;
                            }
                            else {
                                return false;
                            }
                        }
                    },
                    maxlength: 18,
                    minlength: 1
                //totalCheck: true
                },
                TOTAL_COST: {
                    required: _this.checkAllFormFieldsForTotalRequired(),
                    maxlength: 9,
                    minlength: 1,
                    number: true,
                    fieldRoundOff: true,
                    //totalCheck: true,
                    max: 99999.99
                }
            },
            messages:
            {
                TOTAL_DIRECT_COST: {
                    required: "Field is required",
                    maxlength: "Max. length allowed is {0} including decimal",
                    minlength: "Min. length must be {0}",
                    number: "Please enter numbers only",
                    max: "Max value allowed is 5,2 digits long"
                },
                EXPLORATION_COST: {
                    required: "Field is required",
                    maxlength: "Max. length allowed is {0} including decimal",
                    minlength: "Min. length must be {0}",
                    number: "Please enter numbers only",
                    max: "Max value allowed is 5,2 digits long"
                },
                MINING_COST: {
                    required: "Field is required",
                    maxlength: "Max. length allowed is {0} including decimal",
                    minlength: "Min. length must be {0}",
                    number: "Please enter numbers only",
                    max: "Max value allowed is 5,2 digits long"
                },
                BENEFICIATION_COST: {
                    required: "Field is required",
                    maxlength: "Max. length allowed is {0} including decimal",
                    minlength: "Min. length must be {0}",
                    number: "Please enter numbers only",
                    max: "Max value allowed is 5,2 digits long"
                },
                OVERHEAD_COST: {
                    required: "Field is required",
                    maxlength: "Max. length allowed is {0} including decimal",
                    minlength: "Min. length must be {0}",
                    number: "Please enter numbers only",
                    max: "Max value allowed is 5,2 digits long"
                },
                DEPRECIATION_COST: {
                    required: "Field is required",
                    maxlength: "Max. length allowed is {0} including decimal",
                    minlength: "Min. length must be {0}",
                    number: "Please enter numbers only",
                    max: "Max value allowed is 5,2 digits long"
                },
                INTEREST_COST: {
                    required: "Field is required",
                    maxlength: "Max. length allowed is {0} including decimal",
                    minlength: "Min. length must be {0}",
                    number: "Please enter numbers only",
                    max: "Max value allowed is 5,2 digits long"
                },
                ROYALTY_COST: {
                    required: "Field is required",
                    maxlength: "Max. length allowed is {0} including decimal",
                    minlength: "Min. length must be {0}",
                    number: "Please enter numbers only",
                    max: "Max value allowed is 5,2 digits long"
                },
				PAST_PAY_DMF: {
                    required: "Field is required",
                    maxlength: "Max. length allowed is {0} including decimal",
                    minlength: "Min. length must be {0}",
                    number: "Please enter numbers only",
                    max: "Max value allowed is 5,2 digits long"
                },
				PAST_PAY_NMET: {
                    required: "Field is required",
                    maxlength: "Max. length allowed is {0} including decimal",
                    minlength: "Min. length must be {0}",
                    number: "Please enter numbers only",
                    max: "Max value allowed is 5,2 digits long"
                },
                TAXES_COST: {
                    required: "Field is required",
                    maxlength: "Max. length allowed is {0} including decimal",
                    minlength: "Min. length must be {0}",
                    number: "Please enter numbers only",
                    max: "Max value allowed is 5,2 digits long"
                },
                DEAD_RENT_COST: {
                    required: "Field is required",
                    maxlength: "Max. length allowed is {0} including decimal",
                    minlength: "Min. length must be {0}",
                    number: "Please enter numbers only",
                    max: "Max value allowed is 5,2 digits long"
                },
                OTHERS_COST: {
                    required: "Field is required",
                    maxlength: "Max. length allowed is {0} including decimal",
                    minlength: "Min. length must be {0}",
                    number: "Please enter numbers only",
                    max: "Max value allowed is 5,2 digits long"
                },
                OTHERS_SPEC: {
                    required: "Field is required",
                    maxlength: "Max. length allowed is {0}",
                    minlength: "Min. length must be {0}",
                    number: "Please enter numbers only"
                },
                TOTAL_COST: {
                    required: "Field is required",
                    maxlength: "Max. length allowed is {0} including decimal",
                    minlength: "Min. length must be {0}",
                    number: "Please enter numbers only",
                    max: "Max value allowed is 5,2 digits long"
                }
            }
        });


    },
    //NOT IN USE RIGHT NOW ... NEED TO REMOVE LATER .... OR CAN BE USED LATER ---- UDAY
    totalCount: function(fieldArray) {

        var total = (fieldArray['BENEFICIATION_COST'] + fieldArray['DEAD_RENT_COST'] +
            fieldArray['DEPRECIATION_COST'] + fieldArray['EXPLORATION_COST'] +
            fieldArray['INTEREST_COST'] + fieldArray['MINING_COST'] + fieldArray['OTHERS_COST'] +
            fieldArray['OVERHEAD_COST'] + fieldArray['ROYALTY_COST'] + fieldArray['PAST_PAY_DMF']+ fieldArray['PAST_PAY_NMET']+ fieldArray['TAXES_COST'] +
            fieldArray['TOTAL_DIRECT_COST']);
        if (fieldArray['totalFieldData']) {
            if (parseFloat(total) != fieldArray['totalFieldData']) {
                $("#submitErrorCount").val(1);
                alert("Entered total is not equal to calculated total");
                $("#TOTAL_COST").val("");
            }
            else {
                if (parseFloat(total) == fieldArray['totalFieldData']) {
                    $("#submitErrorCount").val(0);
                }
            }
        }
    },
    valueCheck: function() {
        $(".prod_cost").focusout(function() {
            var inputValues = $(".prod_cost");
            var inputLength = inputValues.length;
            var total = 0;
            for (var i = 0; i < inputLength; i++) {
                var fieldId = $(inputValues[i]).attr('id');
                if (fieldId == 'TOTAL_COST') {
                    var enteredTotal = parseFloat($(inputValues[i]).val())
                }
                else {

                    var fieldValue = parseFloat($(inputValues[i]).val());
                    if (!isNaN(fieldValue) && (i != '1' && i != '2' && i != '3')) {

                        total += fieldValue;
                    }
                }
            }
            //total = Utilities.roundOff2(total);
			
			var totRounded = Utilities.roundOff2(total);
            var totArr = total.toString().split('.');
            var totTruncated = (totArr.length == 2) ? totArr[0] + '.' + totArr[1].toString().substr(0, 2) : total;
			
            if (!isNaN(enteredTotal)) {
				 // console.log('round '+totRounded);
				 // console.log('tran '+totTruncated);
				// console.log('tot '+total);
                //if (parseFloat(enteredTotal) != parseFloat(total)) {
				if (Number(enteredTotal) == Number(totRounded) || Number(enteredTotal) == Number(totTruncated)) {
                    //
                } else {
					alert("Entered total is not equal to the calculated total")
                    $("#TOTAL_COST").val("");
				}
            }
        });
    },
    postValidation: function() {
        $("#frmProductionCost").submit(function(checksum) {
            var explorationCost = $('#EXPLORATION_COST').val();
            var miningCost = $('#MINING_COST').val();
            var beneficialCost = $('#BENEFICIATION_COST').val();
            var directCost = parseFloat($('#TOTAL_DIRECT_COST').val());
            var royaltyCost = parseFloat($('#ROYALTY_COST').val());
            var pastPayDMF = $('#PAST_PAY_DMF').val();
            var pastPayNMET = $('#PAST_PAY_NMET').val();

            if (explorationCost == '') {
                explorationCost = 0;
            }
            if (miningCost == '') {
                miningCost = 0;
            }
            if (beneficialCost == '') {
                beneficialCost = 0;
            }
            if (pastPayDMF == '') {
                pastPayDMF = 0;
            }
            if (pastPayNMET == '') {
                pastPayNMET = 0;
            }

            var total = parseFloat(explorationCost) + parseFloat(miningCost) + parseFloat(beneficialCost);
            total = Utilities.roundOff2(total);
            if (directCost != total) {
                alert('Direct cost is not equal to the sum of Exploration,Mining and Beneficiation cost');
                $('#TOTAL_DIRECT_COST').val('');
                return false;
            }
            if(royaltyCost > 0 && pastPayDMF == 0  && pastPayNMET == 0)
            {
                alert('Once Royalty is paid, DMF and NMET should not be 0');
                $('#PAST_PAY_DMF').val('');
                $('#PAST_PAY_NMET').val('');
                return false;
            }
        });

        $("#frmProductionCost").submit(function(event) {
            var errorCount = $("#submitErrorCount").val();
            if (errorCount == 1) {
                alert("Please enter data");
                event.preventDefault();
            }
        });
    }
}

var ExplosiveConsumption = {
    fieldValidation: function() {
        $("#explosiveConsumption").validate({
            rules: {
                MAG_CAPACITY_EXP: {
                    //          required: true,
                    maxlength: 12,
                    minlength: 1,
                    number: true,
                    digits: true,
                    max: 999999999999
                },
                MAG_CAPACITY_DET: {
                    //          required: true,
                    maxlength: 12,
                    minlength: 1,
                    number: true,
                    digits: true,
                    max: 999999999999
                },
                MAG_CAPACITY_FUSE: {
                    //          required: true,
                    maxlength: 12,
                    minlength: 1,
                    number: true,
                    digits: true,
                    max: 999999999999
                },
                TOTAL_ROM_ORE: {
                    //          required: true,
                    maxlength: 19,
                    minlength: 1,
                    number: true,
                    max: 999999999999999.999
                },
                OB_BLASTING: {
                    //          required: true,
                    maxlength: 12,
                    minlength: 1,
                    number: true,
                    digits: true,
                    max: 999999999999
                },
                LARGE_CON_QTY: {
                    //          required: true,
                    maxlength: 12,
                    minlength: 1,
                    number: true,
                    digits: true,
                    max: 999999999999
                },
                LARGE_REQ_QTY: {
                    //          required: true,
                    maxlength: 12,
                    minlength: 1,
                    number: true,
                    digits: true,
                    max: 999999999999
                },
                SMALL_CON_QTY_1: {
                    //          required: true,
                    maxlength: 12,
                    minlength: 1,
                    number: true,
                    digits: true,
                    max: 999999999999
                },
                SMALL_CON_QTY_2: {
                    //          required: true,
                    maxlength: 12,
                    minlength: 1,
                    number: true,
                    digits: true,
                    max: 999999999999
                },
                SMALL_CON_QTY_3: {
                    //          required: true,
                    maxlength: 12,
                    minlength: 1,
                    number: true,
                    digits: true,
                    max: 999999999999
                },
                SMALL_CON_QTY_4: {
                    //          required: true,
                    maxlength: 12,
                    minlength: 1,
                    number: true,
                    digits: true,
                    max: 999999999999
                },
                SLURRY_TN: {
                    required: {
                        depends: function() {
                            var smallQty = $('#SMALL_CON_QTY_5').val();
                            var largeQty = $('#LARGE_CON_QTY_5').val();
                            if ((smallQty != '' && smallQty > 0) || (largeQty != '' && largeQty > 0)) {
                                return true;
                            }
                        }
                    }
                },
                SMALL_CON_QTY_5: {
                    required: {
                        depends: function() {
                            var slurryVal = $('#SLURRY_TN').val();
                            if (slurryVal != '') {
                                return true;
                            }
                        }
                    },
                    maxlength: 12,
                    minlength: 1,
                    number: true,
                    digits: true,
                    max: 999999999999
                },
                LARGE_CON_QTY_1: {
                    //          required: true,
                    maxlength: 12,
                    minlength: 1,
                    number: true,
                    digits: true,
                    max: 999999999999
                },
                LARGE_CON_QTY_2: {
                    //          required: true,
                    maxlength: 12,
                    minlength: 1,
                    number: true,
                    digits: true,
                    max: 999999999999
                },
                LARGE_CON_QTY_3: {
                    //          required: true,
                    maxlength: 12,
                    minlength: 1,
                    number: true,
                    digits: true,
                    max: 999999999999
                },
                LARGE_CON_QTY_4: {
                    //          required: true,
                    maxlength: 12,
                    minlength: 1,
                    number: true,
                    digits: true,
                    max: 999999999999
                },
                LARGE_CON_QTY_5: {
                    required: {
                        depends: function() {
                            var slurryVal = $('#SLURRY_TN').val();
                            if (slurryVal != '') {
                                return true;
                            }
                        }
                    },
                    maxlength: 12,
                    minlength: 1,
                    number: true,
                    digits: true,
                    max: 999999999999
                },
                SMALL_REQ_QTY_1: {
                    //          required: true,
                    maxlength: 12,
                    minlength: 1,
                    number: true,
                    digits: true,
                    max: 999999999999
                },
                SMALL_REQ_QTY_2: {
                    //          required: true,
                    maxlength: 12,
                    minlength: 1,
                    number: true,
                    digits: true,
                    max: 999999999999
                },
                SMALL_REQ_QTY_3: {
                    //          required: true,
                    maxlength: 12,
                    minlength: 1,
                    number: true,
                    digits: true,
                    max: 999999999999
                },
                SMALL_REQ_QTY_4: {
                    //          required: true,
                    maxlength: 12,
                    minlength: 1,
                    number: true,
                    digits: true,
                    max: 999999999999
                },
                SMALL_REQ_QTY_5: {
                    //          required: true,
                    maxlength: 12,
                    minlength: 1,
                    number: true,
                    digits: true,
                    max: 999999999999
                },
                LARGE_REQ_QTY_1: {
                    //          required: true,
                    maxlength: 12,
                    minlength: 1,
                    number: true,
                    digits: true,
                    max: 999999999999
                },
                LARGE_REQ_QTY_2: {
                    //          required: true,
                    maxlength: 12,
                    minlength: 1,
                    number: true,
                    digits: true,
                    max: 999999999999
                },
                LARGE_REQ_QTY_3: {
                    //          required: true,
                    maxlength: 12,
                    minlength: 1,
                    number: true,
                    digits: true,
                    max: 999999999999
                },
                LARGE_REQ_QTY_4: {
                    //          required: true,
                    maxlength: 12,
                    minlength: 1,
                    number: true,
                    digits: true,
                    max: 999999999999
                },
                LARGE_REQ_QTY_5: {
                    maxlength: 12,
                    minlength: 1,
                    number: true,
                    digits: true,
                    max: 999999999999
                },
                LARGE_CON_QTY_6: {
                    //          required: true,
                    maxlength: 12,
                    minlength: 1,
                    number: true,
                    digits: true
                },
                LARGE_REQ_QTY_6: {
                    //          required: true,
                    maxlength: 12,
                    minlength: 1,
                    number: true,
                    digits: true,
                    max: 999999999999
                },
                LARGE_CON_QTY_8: {
                    //          required: true,
                    maxlength: 12,
                    minlength: 1,
                    number: true,
                    digits: true,
                    max: 999999999999
                },
                LARGE_REQ_QTY_8: {
                    //          required: true,
                    maxlength: 12,
                    minlength: 1,
                    number: true,
                    digits: true,
                    max: 999999999999
                },
                LARGE_CON_QTY_9: {
                    //          required: true,
                    maxlength: 12,
                    minlength: 1,
                    number: true,
                    digits: true,
                    max: 999999999999
                },
                LARGE_REQ_QTY_9: {
                    //          required: true,
                    maxlength: 12,
                    minlength: 1,
                    number: true,
                    digits: true,
                    max: 999999999999
                },
                LARGE_CON_QTY_11: {
                    //          required: true,
                    maxlength: 12,
                    minlength: 1,
                    number: true,
                    digits: true,
                    max: 999999999999
                },
                LARGE_REQ_QTY_11: {
                    //          required: true,
                    maxlength: 12,
                    minlength: 1,
                    number: true,
                    digits: true,
                    max: 999999999999
                },
                LARGE_CON_QTY_12: {
                    //          required: true,
                    maxlength: 12,
                    minlength: 1,
                    number: true,
                    digits: true,
                    max: 999999999999
                },
                LARGE_REQ_QTY_12: {
                    //          required: true,
                    maxlength: 12,
                    minlength: 1,
                    number: true,
                    digits: true,
                    max: 999999999999
                },
                LARGE_CON_QTY_13: {
                    //          required: true,
                    maxlength: 12,
                    minlength: 1,
                    number: true,
                    digits: true,
                    max: 999999999999
                },
                LARGE_REQ_QTY_13: {
                    //          required: true,
                    maxlength: 12,
                    minlength: 1,
                    number: true,
                    digits: true,
                    max: 999999999999
                },
                OTHER_EXPLOSIVES: {
                    required: {
                        depends: function() {
                            var smallOtherQty = $('#LARGE_CON_QTY_14').val();
                            var largeOtherQty = $('#LARGE_REQ_QTY_14').val();
                            if (smallOtherQty != '' && smallOtherQty > 0) {
                                return true;
                            }
                        }
                    }
                },
                LARGE_CON_QTY_14: {
                    required: {
                        depends: function() {
                            var otherExpQty = $('#OTHER_EXPLOSIVES').val();
                            if (otherExpQty != '') {
                                return true;
                            }
                        }
                    },
                    maxlength: 12,
                    minlength: 1,
                    number: true,
                    digits: true,
                    max: 999999999999
                },
                LARGE_REQ_QTY_14: {
                    //          required: true,
                    maxlength: 12,
                    minlength: 1,
                    number: true,
                    digits: true,
                    max: 999999999999
                }
            },
            messages: {
                MAG_CAPACITY_EXP: {
                    required: "Please enter value",
                    maxlength: "Max. length allowed is {0}",
                    minlength: "Min. length must be entered is {1}",
                    number: "Please enter numbers only",
                    digits: "Decimal digits are not allowed"
                },
                MAG_CAPACITY_DET: {
                    required: "Please enter value",
                    maxlength: "Max. length allowed is {0}",
                    minlength: "Min. length must be entered is {0}",
                    number: "Please enter numbers only",
                    digits: "Decimal digits are not allowed"
                },
                MAG_CAPACITY_FUSE: {
                    required: "Please enter value",
                    maxlength: "Max. length allowed is {0}",
                    minlength: "Min. length must be entered is {0}",
                    number: "Please enter numbers only",
                    digits: "Decimal digits are not allowed"
                },
                TOTAL_ROM_ORE: {
                    required: "Please enter value",
                    maxlength: "Max. length allowed is 15,3 digits including decimal",
                    minlength: "Max. length allowed is 15,3 digits including decimal",
                    number: "Please enter numbers only",
                    max: "Max. length allowed is 15,3 digits including decimal"
                },
                OB_BLASTING: {
                    required: "Please enter value",
                    maxlength: "Max. length allowed is 12",
                    minlength: "Min. length must be entered is 1",
                    number: "Please enter numbers only",
                    digits: "Decimal digits are not allowed"
                },
                LARGE_CON_QTY: {
                    required: "Please enter value",
                    maxlength: "Max. length allowed is 12",
                    minlength: "Min. length must be entered is 1",
                    number: "Please enter numbers only",
                    digits: "Decimal digits are not allowed"
                },
                LARGE_REQ_QTY: {
                    required: "Please enter value",
                    maxlength: "Max. length allowed is 12",
                    minlength: "Min. length must be entered is 1",
                    number: "Please enter numbers only",
                    digits: "Decimal digits are not allowed"
                },
                SMALL_CON_QTY_1: {
                    required: "Please enter value",
                    maxlength: "Max. length allowed is 12",
                    minlength: "Min. length must be entered is 1",
                    number: "Please enter numbers only",
                    digits: "Decimal digits are not allowed"
                },
                SMALL_CON_QTY_2: {
                    required: "Please enter value",
                    maxlength: "Max. length allowed is 12",
                    minlength: "Min. length must be entered is 1",
                    number: "Please enter numbers only",
                    digits: "Decimal digits are not allowed"
                },
                SMALL_CON_QTY_3: {
                    required: "Please enter value",
                    maxlength: "Max. length allowed is 12",
                    minlength: "Min. length must be entered is 1",
                    number: "Please enter numbers only",
                    digits: "Decimal digits are not allowed"
                },
                SMALL_CON_QTY_4: {
                    required: "Please enter value",
                    maxlength: "Max. length allowed is 12",
                    minlength: "Min. length must be entered is 1",
                    number: "Please enter numbers only",
                    digits: "Decimal digits are not allowed"
                },
                SLURRY_TN: {
                    required: "Please specify trade names"
                },
                SMALL_CON_QTY_5: {
                    required: "Please enter value",
                    maxlength: "Max. length allowed is 12",
                    minlength: "Min. length must be entered is 1",
                    number: "Please enter numbers only",
                    digits: "Decimal digits are not allowed"
                },
                LARGE_CON_QTY_1: {
                    required: "Please enter value",
                    maxlength: "Max. length allowed is 12",
                    minlength: "Min. length must be entered is 1",
                    number: "Please enter numbers only",
                    digits: "Decimal digits are not allowed"
                },
                LARGE_CON_QTY_2: {
                    required: "Please enter value",
                    maxlength: "Max. length allowed is 12",
                    minlength: "Min. length must be entered is 1",
                    number: "Please enter numbers only",
                    digits: "Decimal digits are not allowed"
                },
                LARGE_CON_QTY_3: {
                    required: "Please enter value",
                    maxlength: "Max. length allowed is 12",
                    minlength: "Min. length must be entered is 1",
                    number: "Please enter numbers only",
                    digits: "Decimal digits are not allowed"
                },
                LARGE_CON_QTY_4: {
                    required: "Please enter value",
                    maxlength: "Max. length allowed is 12",
                    minlength: "Min. length must be entered is 1",
                    number: "Please enter numbers only",
                    digits: "Decimal digits are not allowed"
                },
                LARGE_CON_QTY_5: {
                    required: "Please enter value",
                    maxlength: "Max. length allowed is 12",
                    minlength: "Min. length must be entered is 1",
                    number: "Please enter numbers only",
                    digits: "Decimal digits are not allowed"
                },
                SMALL_REQ_QTY_1: {
                    required: "Please enter value",
                    maxlength: "Max. length allowed is 12",
                    minlength: "Min. length must be entered is 1",
                    number: "Please enter numbers only",
                    digits: "Decimal digits are not allowed"
                },
                SMALL_REQ_QTY_2: {
                    required: "Please enter value",
                    maxlength: "Max. length allowed is 12",
                    minlength: "Min. length must be entered is 1",
                    number: "Please enter numbers only",
                    digits: "Decimal digits are not allowed"
                },
                SMALL_REQ_QTY_3: {
                    required: "Please enter value",
                    maxlength: "Max. length allowed is 12",
                    minlength: "Min. length must be entered is 1",
                    number: "Please enter numbers only",
                    digits: "Decimal digits are not allowed"
                },
                SMALL_REQ_QTY_4: {
                    required: "Please enter value",
                    maxlength: "Max. length allowed is 12",
                    minlength: "Min. length must be entered is 1",
                    number: "Please enter numbers only",
                    digits: "Decimal digits are not allowed"
                },
                SMALL_REQ_QTY_5: {
                    required: "Please enter value",
                    maxlength: "Max. length allowed is 12",
                    minlength: "Min. length must be entered is 1",
                    number: "Please enter numbers only",
                    digits: "Decimal digits are not allowed"
                },
                LARGE_REQ_QTY_1: {
                    required: "Please enter value",
                    maxlength: "Max. length allowed is 12",
                    minlength: "Min. length must be entered is 1",
                    number: "Please enter numbers only",
                    digits: "Decimal digits are not allowed"
                },
                LARGE_REQ_QTY_2: {
                    required: "Please enter value",
                    maxlength: "Max. length allowed is 12",
                    minlength: "Min. length must be entered is 1",
                    number: "Please enter numbers only",
                    digits: "Decimal digits are not allowed"
                },
                LARGE_REQ_QTY_3: {
                    required: "Please enter value",
                    maxlength: "Max. length allowed is 12",
                    minlength: "Min. length must be entered is 1",
                    number: "Please enter numbers only",
                    digits: "Decimal digits are not allowed"
                },
                LARGE_REQ_QTY_4: {
                    required: "Please enter value",
                    maxlength: "Max. length allowed is 12",
                    minlength: "Min. length must be entered is 1",
                    number: "Please enter numbers only",
                    digits: "Decimal digits are not allowed"
                },
                LARGE_REQ_QTY_5: {
                    required: "Please enter value",
                    maxlength: "Max. length allowed is 12",
                    minlength: "Min. length must be entered is 1",
                    number: "Please enter numbers only",
                    digits: "Decimal digits are not allowed"
                },
                LARGE_CON_QTY_6: {
                    required: "Please enter value",
                    maxlength: "Max. length allowed is 12",
                    minlength: "Min. length must be entered is 1",
                    number: "Please enter numbers only",
                    digits: "Decimal digits are not allowed"
                },
                LARGE_REQ_QTY_6: {
                    required: "Please enter value",
                    maxlength: "Max. length allowed is 12",
                    minlength: "Min. length must be entered is 1",
                    number: "Please enter numbers only",
                    digits: "Decimal digits are not allowed"
                },
                LARGE_CON_QTY_8: {
                    required: "Please enter value",
                    maxlength: "Max. length allowed is 12",
                    minlength: "Min. length must be entered is 1",
                    number: "Please enter numbers only",
                    digits: "Decimal digits are not allowed"
                },
                LARGE_REQ_QTY_8: {
                    required: "Please enter value",
                    maxlength: "Max. length allowed is 12",
                    minlength: "Min. length must be entered is 1",
                    number: "Please enter numbers only",
                    digits: "Decimal digits are not allowed"
                },
                LARGE_CON_QTY_9: {
                    required: "Please enter value",
                    maxlength: "Max. length allowed is 12",
                    minlength: "Min. length must be entered is 1",
                    number: "Please enter numbers only",
                    digits: "Decimal digits are not allowed"
                },
                LARGE_REQ_QTY_9: {
                    required: "Please enter value",
                    maxlength: "Max. length allowed is 12",
                    minlength: "Min. length must be entered is 1",
                    number: "Please enter numbers only",
                    digits: "Decimal digits are not allowed"
                },
                LARGE_CON_QTY_11: {
                    required: "Please enter value",
                    maxlength: "Max. length allowed is 12",
                    minlength: "Min. length must be entered is 1",
                    number: "Please enter numbers only",
                    digits: "Decimal digits are not allowed"
                },
                LARGE_REQ_QTY_11: {
                    required: "Please enter value",
                    maxlength: "Max. length allowed is 12",
                    minlength: "Min. length must be entered is 1",
                    number: "Please enter numbers only",
                    digits: "Decimal digits are not allowed"
                },
                LARGE_CON_QTY_12: {
                    required: "Please enter value",
                    maxlength: "Max. length allowed is 12",
                    minlength: "Min. length must be entered is 1",
                    number: "Please enter numbers only",
                    digits: "Decimal digits are not allowed"
                },
                LARGE_REQ_QTY_12: {
                    required: "Please enter value",
                    maxlength: "Max. length allowed is 12",
                    minlength: "Min. length must be entered is 1",
                    number: "Please enter numbers only",
                    digits: "Decimal digits are not allowed"
                },
                LARGE_CON_QTY_13: {
                    required: "Please enter value",
                    maxlength: "Max. length allowed is 12",
                    minlength: "Min. length must be entered is 1",
                    number: "Please enter numbers only",
                    digits: "Decimal digits are not allowed"
                },
                LARGE_REQ_QTY_13: {
                    required: "Please enter value",
                    maxlength: "Max. length allowed is 12",
                    minlength: "Min. length must be entered is 1",
                    number: "Please enter numbers only",
                    digits: "Decimal digits are not allowed"
                },
                OTHER_EXPLOSIVES: {
                    required: "Please specify others"
                },
                LARGE_CON_QTY_14: {
                    required: "Please enter value",
                    maxlength: "Max. length allowed is 12",
                    minlength: "Min. length must be entered is 1",
                    number: "Please enter numbers only",
                    digits: "Decimal digits are not allowed"
                },
                LARGE_REQ_QTY_14: {
                    required: "Please enter value",
                    maxlength: "Max. length allowed is 12",
                    minlength: "Min. length must be entered is 1",
                    number: "Please enter numbers only",
                    digits: "Decimal digits are not allowed"
                }
            }
        });
    },
    postValidation: function(expConsumpPart4Value) {
        $("#explosiveConsumption").submit(function(event) {


            /**
             * 0 -----> DATA IS IN DB AND VALUE IS GREATER THEN 0 AND NOT NULL
             * 1 -----> VALUE ENTERED IS 0 OR EMPTY
             **/
            var expParsedValue = parseInt(expConsumpPart4Value);
            var qtyCheck = 0;
            $('.con_qty').each(function() {
                var conQtyVal = $(this).val();
                if (conQtyVal > 0) {
                    qtyCheck++;
                }
            });
            
            if (expParsedValue == 0) {
                var inputFieldData = document.getElementsByTagName('input');
                var fieldCheck = 0;
                for (var i = 5; i < inputFieldData.length; i++) {
                    var fieldValue = inputFieldData[i].value;
                    if (fieldValue > 0) {
                        fieldCheck++;
                    }
                /*else {
                     fieldCheck = 0;
                     break;
                     }*/
                }


                if (fieldCheck == 0 || qtyCheck == 0) {
                    alert("Please enter details of explosive consumed, as the explosive value is entered in Part III, item 1(iv)");
                    //alert("For entry against Explosives in part IV, entry expected against item 1(v) of Part III and vice versa");
                    event.preventDefault();
                }

            }
            else if (expConsumpPart4Value == 1 && qtyCheck > 0) {
                alert("Form can't be save as the explosive value is entered in Part III, item 1(iv) is either 0 or empty");
                event.preventDefault();
            }
        });
    }
}

var NameAndAddress = {
    fieldValidation: function() {

        $("#frmNameAddress").validate({
            rules: {
                "lessee_office_name": {
                    required: true,
                    maxlength: 250
                },
                "director_name": {
                    required: true,
                    maxlength: 40
                },
                "agent_name": {
                    required: true,
                    maxlength: 40
                },
                "manager_name": {
                    required: true,
                    maxlength: 40
                },
                "mining_engineer_name": {
                    required: true,
                    maxlength: 40
                },
                "geologist_name": {
                    required: true,
                    maxlength: 40
                },
                "previous_lessee_name": {
                    // required: false,
                    maxlength: 40
                }
            },
            messages: {
                "lessee_office_name": {
                    required: "Please enter data",
                    maxlength: "Max. length allowed is 250 Characters"
                },
                "director_name": {
                    required: "Please enter data",
                    maxlength: "Max. length allowed is 50 Characters"
                },
                "agent_name": {
                    required: "Please enter data",
                    maxlength: "Max. length allowed is 50 Characters"
                },
                "manager_name": {
                    required: "Please enter data",
                    maxlength: "Max. length allowed is 50 Characters"
                },
                "mining_engineer_name": {
                    required: "Please enter data",
                    maxlength: "Max. length allowed is 50 Characters"
                },
                "geologist_name": {
                    required: "Please enter data",
                    maxlength: "Max. length allowed is 50 Characters"
                },
                "previous_lessee_name": {
                    // required: "Please enter data",
                    maxlength: "Max. length allowed is 50 Characters"
                }
            }
        });

        // $("#date").click()
    }
}


var GeologyExploration = {
    fieldValidation: function() {

        $("#frmgeologyExploration").validate({
            rules: {
                "E[BEGIN_HOLES_DRILLING]": {
                    required: true,
                    digits: true,
                    maxlength: 15
                },
                "E[DURING_HOLES_DRILLING]": {
                    required: true,
                    digits: true,
                    maxlength: 15
                },
                "E[CUMU_HOLES_DRILLING]": {
                    required: true,
                    digits: true,
                    maxlength: 15
                },
                "E[GRIDE_HOLES_DRILLING]": {
                    required: true,
                    // digits: true,
                    maxlength: 15
                },
                "E[BEGIN_METRAGE_DRILLING]": {
                    required: true,
                    digits: true,
                    maxlength: 15
                },
                "E[DURING_METRAGE_DRILLING]": {
                    required: true,
                    digits: true,
                    maxlength: 15
                },
                "E[CUMU_METRAGE_DRILLING]": {
                    required: true,
                    digits: true,
                    maxlength: 15
                },
                "E[GRIDE_METRAGE_DRILLING]": {
                    required: true,
                    // digits: true,
                    maxlength: 15
                },
                "E[BEGIN_PITS_PITTING]": {
                    required: true,
                    digits: true,
                    maxlength: 15
                },
                "E[DURING_PITS_PITTING]": {
                    required: true,
                    digits: true,
                    maxlength: 15
                },
                "E[CUMU_PITS_PITTING]": {
                    required: true,
                    digits: true,
                    maxlength: 15
                },
                "E[GRIDE_PITS_PITTING]": {
                    required: true,
                    // digits: true,
                    maxlength: 15
                },
                "E[BEGIN_EXCAV_PITTING]": {
                    required: true,
                    digits: true,
                    maxlength: 15
                },
                "E[DURING_EXCAV_PITTING]": {
                    required: true,
                    digits: true,
                    maxlength: 15
                },
                "E[CUMU_EXCAV_PITTING]": {
                    required: true,
                    digits: true,
                    maxlength: 15
                },
                "E[GRIDE_EXCAV_PITTING]": {
                    required: true,
                    // digits: true,
                    maxlength: 15
                },
                "E[BEGIN_TRENCHES_TRENCH]": {
                    required: true,
                    digits: true,
                    maxlength: 15
                },
                "E[DURING_TRENCHES_TRENCH]": {
                    required: true,
                    digits: true,
                    maxlength: 15
                },
                "E[CUMU_TRENCHES_TRENCH]": {
                    required: true,
                    digits: true,
                    maxlength: 15
                },
                "E[GRIDE_TRENCHES_TRENCH]": {
                    required: true,
                    // digits: true,
                    maxlength: 15
                },
                "E[BEGIN_EXCAV_TRENCH]": {
                    required: true,
                    digits: true,
                    maxlength: 15
                },
                "E[DURING_EXCAV_TRENCH]": {
                    required: true,
                    digits: true,
                    maxlength: 15
                },
                "E[CUMU_EXCAV_TRENCH]": {
                    required: true,
                    digits: true,
                    maxlength: 15
                },
                "E[GRIDE_EXCAV_TRENCH]": {
                    required: true,
                    // digits: true,
                    maxlength: 15
                },
                "E[BEGIN_LENGTH_TRENCH]": {
                    required: true,
                    digits: true,
                    maxlength: 15
                },
                "E[DURING_LENGTH_TRENCH]": {
                    required: true,
                    digits: true,
                    maxlength: 15
                },
                "E[CUMU_LENGTH_TRENCH]": {
                    required: true,
                    digits: true,
                    maxlength: 15
                },
                "E[GRIDE_LENGTH_TRENCH]": {
                    required: true,
                    // digits: true,
                    maxlength: 15
                },
                "E[BEGIN_EXPENDITURE]": {
                    required: true,
                    digits: true,
                    maxlength: 15
                },
                "E[DURING_EXPENDITURE]": {
                    required: true,
                    digits: true,
                    maxlength: 15
                },
                "E[CUMU_EXPENDITURE]": {
                    required: true,
                    digits: true,
                    maxlength: 15
                },
                "E[GRIDE_EXPENDITURE]": {
                    required: true,
                    // digits: true,
                    maxlength: 15
                },
                "E[OTHER_EXPLOR_ACTIVITY]": {
                    required: true,
                    maxlength: 250
                }
            },
            messages: {
                "E[BEGIN_HOLES_DRILLING]": {
                    required: "Please enter data",
                    digits: "Enter valid number",
                    maxlength: "Max. length allowed is 15 Characters"
                },
                "E[DURING_HOLES_DRILLING]": {
                    required: "Please enter data",
                    digits: "Enter valid number",
                    maxlength: "Max. length allowed is 15 Characters"
                },
                "E[CUMU_HOLES_DRILLING]": {
                    required: "Please enter data",
                    digits: "Enter valid number",
                    maxlength: "Max. length allowed is 15 Characters"
                },
                "E[GRIDE_HOLES_DRILLING]": {
                    required: "Please enter data",
                    digits: "Enter valid number",
                    maxlength: "Max. length allowed is 15 Characters"
                },
                "E[BEGIN_METRAGE_DRILLING]": {
                    required: "Please enter data",
                    digits: "Enter valid number",
                    maxlength: "Max. length allowed is 15 Characters"
                },
                "E[DURING_METRAGE_DRILLING]": {
                    required: "Please enter data",
                    digits: "Enter valid number",
                    maxlength: "Max. length allowed is 15 Characters"
                },
                "E[CUMU_METRAGE_DRILLING]": {
                    required: "Please enter data",
                    digits: "Enter valid number",
                    maxlength: "Max. length allowed is 15 Characters"
                },
                "E[GRIDE_METRAGE_DRILLING]": {
                    required: "Please enter data",
                    digits: "Enter valid number",
                    maxlength: "Max. length allowed is 15 Characters"
                },
                "E[BEGIN_PITS_PITTING]": {
                    required: "Please enter data",
                    digits: "Enter valid number",
                    maxlength: "Max. length allowed is 15 Characters"
                },
                "E[DURING_PITS_PITTING]": {
                    required: "Please enter data",
                    digits: "Enter valid number",
                    maxlength: "Max. length allowed is 15 Characters"
                },
                "E[CUMU_PITS_PITTING]": {
                    required: "Please enter data",
                    digits: "Enter valid number",
                    maxlength: "Max. length allowed is 15 Characters"
                },
                "E[GRIDE_PITS_PITTING]": {
                    required: "Please enter data",
                    digits: "Enter valid number",
                    maxlength: "Max. length allowed is 15 Characters"
                },
                "E[BEGIN_EXCAV_PITTING]": {
                    required: "Please enter data",
                    digits: "Enter valid number",
                    maxlength: "Max. length allowed is 15 Characters"
                },
                "E[DURING_EXCAV_PITTING]": {
                    required: "Please enter data",
                    digits: "Enter valid number",
                    maxlength: "Max. length allowed is 15 Characters"
                },
                "E[CUMU_EXCAV_PITTING]": {
                    required: "Please enter data",
                    digits: "Enter valid number",
                    maxlength: "Max. length allowed is 15 Characters"
                },
                "E[GRIDE_EXCAV_PITTING]": {
                    required: "Please enter data",
                    digits: "Enter valid number",
                    maxlength: "Max. length allowed is 15 Characters"
                },
                "E[BEGIN_TRENCHES_TRENCH]": {
                    required: "Please enter data",
                    digits: "Enter valid number",
                    maxlength: "Max. length allowed is 15 Characters"
                },
                "E[DURING_TRENCHES_TRENCH]": {
                    required: "Please enter data",
                    digits: "Enter valid number",
                    maxlength: "Max. length allowed is 15 Characters"
                },
                "E[CUMU_TRENCHES_TRENCH]": {
                    required: "Please enter data",
                    digits: "Enter valid number",
                    maxlength: "Max. length allowed is 15 Characters"
                },
                "E[GRIDE_TRENCHES_TRENCH]": {
                    required: "Please enter data",
                    digits: "Enter valid number",
                    maxlength: "Max. length allowed is 15 Characters"
                },
                "E[BEGIN_EXCAV_TRENCH]": {
                    required: "Please enter data",
                    digits: "Enter valid number",
                    maxlength: "Max. length allowed is 15 Characters"
                },
                "E[DURING_EXCAV_TRENCH]": {
                    required: "Please enter data",
                    digits: "Enter valid number",
                    maxlength: "Max. length allowed is 15 Characters"
                },
                "E[CUMU_EXCAV_TRENCH]": {
                    required: "Please enter data",
                    digits: "Enter valid number",
                    maxlength: "Max. length allowed is 15 Characters"
                },
                "E[GRIDE_EXCAV_TRENCH]": {
                    required: "Please enter data",
                    digits: "Enter valid number",
                    maxlength: "Max. length allowed is 15 Characters"
                },
                "E[BEGIN_LENGTH_TRENCH]": {
                    required: "Please enter data",
                    digits: "Enter valid number",
                    maxlength: "Max. length allowed is 15 Characters"
                },
                "E[DURING_LENGTH_TRENCH]": {
                    required: "Please enter data",
                    digits: "Enter valid number",
                    maxlength: "Max. length allowed is 15 Characters"
                },
                "E[CUMU_LENGTH_TRENCH]": {
                    required: "Please enter data",
                    digits: "Enter valid number",
                    maxlength: "Max. length allowed is 15 Characters"
                },
                "E[GRIDE_LENGTH_TRENCH]": {
                    required: "Please enter data",
                    digits: "Enter valid number",
                    maxlength: "Max. length allowed is 15 Characters"
                },
                "E[BEGIN_EXPENDITURE]": {
                    required: "Please enter data",
                    digits: "Enter valid number",
                    maxlength: "Max. length allowed is 15 Characters"
                },
                "E[DURING_EXPENDITURE]": {
                    required: "Please enter data",
                    digits: "Enter valid number",
                    maxlength: "Max. length allowed is 15 Characters"
                },
                "E[CUMU_EXPENDITURE]": {
                    required: "Please enter data",
                    digits: "Enter valid number",
                    maxlength: "Max. length allowed is 15 Characters"
                },
                "E[GRIDE_EXPENDITURE]": {
                    required: "Please enter data",
                    digits: "Enter valid number",
                    maxlength: "Max. length allowed is 15 Characters"
                },
                "E[OTHER_EXPLOR_ACTIVITY]": {
                    required: "Please enter data",
                    maxlength: "Max. length allowed is 250 Characters"
                }
            }
        });

    }
}

var PartAreaUtil = {
    fieldValidation: function() {

        //====================roundOff to decimal 3 places==========================
        jQuery.validator.addMethod("areaRoundOff", function(value, element) {
            var temp = new Number(value);
            element.value = (temp).toFixed(3);
            return true;
        }, "");

        //======================ABANDONED TOTAL VALIDATION==========================
        jQuery.validator.addMethod("abanTotCal", function(value, element) {

            var forestAban = $("#FOREST_ABANDONED_AREA").val();
            var nonForestAban = $("#NON_FOREST_ABANDONED_AREA").val();
            var total = Utilities.roundOff3(parseFloat($("#TOTAL_ABANDONED_AREA").val()));
            //console.log(total);
            if (!isNaN(forestAban) && !isNaN(nonForestAban) && !isNaN(total)) {
                var dataTotal = Utilities.roundOff3(parseFloat(forestAban) + parseFloat(nonForestAban));
                //console.log(dataTotal);
                if (dataTotal != total) {
                    alert("Already exploited & abandoned by opencast (O/C) mining total is not equal the calculated total");
                    $("#TOTAL_ABANDONED_AREA").val("");
                }
            }
            return true
        },
        "");

        //===================CURRENT WORKING TOTAL VALIDATION=======================
        jQuery.validator.addMethod("workTotCal", function(value, element) {

            var underField = parseFloat($("#FOREST_WORKING_AREA").val());
            var outsideField = parseFloat($("#NON_FOREST_WORKING_AREA").val());
            var total = parseFloat($("#TOTAL_WORKING_AREA").val());

            if (!isNaN(underField) && !isNaN(outsideField) && !isNaN(total)) {
                var dataTotal = Utilities.roundOff3(parseFloat(underField) + parseFloat(outsideField));
                if (dataTotal != total) {
                    alert("Covered under current (O/C) Workings total is not equal the calculated total");
                    $("#TOTAL_WORKING_AREA").val("");
                }
            }
            return true
        },
        "");

        //======================RECLAIMED TOTAL VALIDATION==========================
        jQuery.validator.addMethod("recTotCal", function(value, element) {

            var underField = parseFloat($("#FOREST_RECLAIMED_AREA").val());
            var outsideField = parseFloat($("#NON_FOREST_RECLAIMED_AREA").val());
            var total = Utilities.roundOff3(parseFloat($("#TOTAL_RECLAIMED_AREA").val()));

            if (!isNaN(underField) && !isNaN(outsideField) && !isNaN(total)) {
                var dataTotal = Utilities.roundOff3(parseFloat(underField) + parseFloat(outsideField));
                if (dataTotal != total) {
                    alert("Reclaimed/Rehabilitated total is not equal the calculated total");
                    $("#TOTAL_RECLAIMED_AREA").val("");
                }
            }
            return true
        },
        "");

        //=====================USED FOR WASTE TOTAL VALIDATION======================
        jQuery.validator.addMethod("wasteTotCal", function(value, element) {

            var underField = parseFloat($("#FOREST_WASTE_AREA").val());
            var outsideField = parseFloat($("#NON_FOREST_WASTE_AREA").val());
            var total = parseFloat($("#TOTAL_WASTE_AREA").val());

            if (!isNaN(underField) && !isNaN(outsideField) && !isNaN(total)) {
                var dataTotal = Utilities.roundOff3(parseFloat(underField) + parseFloat(outsideField));
                //dataTotal = Utilities.roundOff3(dataTotal);
                if (dataTotal != total) {
                    alert("Used for waste disposal total is not equal the calculated total");
                    $("#TOTAL_WASTE_AREA").val("");
                }
            }
            return true
        },
        "");

        //===================OCCUPIED BY PLANT TOTAL VALIDATION=====================
        jQuery.validator.addMethod("buildTotCal", function(value, element) {

            var underField = parseFloat($("#FOREST_BUILDING_AREA").val());
            var outsideField = parseFloat($("#NON_FOREST_BUILDING_AREA").val());
            var total = parseFloat($("#TOTAL_BUILDING_AREA").val());

            if (!isNaN(underField) && !isNaN(outsideField) && !isNaN(total)) {
                var dataTotal = Utilities.roundOff3(parseFloat(underField) + parseFloat(outsideField));
                if (dataTotal != total) {
                    alert(" Occupied by plant, buildings, residential, welfare buildings & roads total is not equal the calculated total");
                    $("#TOTAL_BUILDING_AREA").val("");
                }
            }
            return true
        },
        "");

        //===============USED FOR OTHER PURPOSE TOTAL VALIDATION====================
        jQuery.validator.addMethod("otherTotCal", function(value, element) {

            var underField = Utilities.roundOff3(parseFloat($("#FOREST_OTHER_AREA").val()));
            var outsideField = Utilities.roundOff3(parseFloat($("#NON_FOREST_OTHER_AREA").val()));
            var total = Utilities.roundOff3(parseFloat($("#TOTAL_OTHER_AREA").val()));

            if (!isNaN(underField) && !isNaN(outsideField) && !isNaN(total)) {
                var dataTotal = Utilities.roundOff3(parseFloat(underField) + parseFloat(outsideField));
                if (dataTotal != total) {
                    alert("Used for any other purpose total is not equal the calculated total");
                    $("#TOTAL_OTHER_AREA").val("");
                }
            }
            return true
        },
        "");

        //===================PROGRESSIVE MINE TOTAL VALIDATION======================
        jQuery.validator.addMethod("progTotCal", function(value, element) {

            var underField = parseFloat($("#FOREST_PROGRESSIVE_AREA").val());
            var outsideField = parseFloat($("#NON_FOREST_PROGRESSIVE_AREA").val());
            var total = parseFloat($("#TOTAL_PROGRESSIVE_AREA").val());

            if (!isNaN(underField) && !isNaN(outsideField) && !isNaN(total)) {
                var dataTotal = Utilities.roundOff3(parseFloat(underField) + parseFloat(outsideField));
                if (parseFloat(dataTotal) != total) {
                    alert("Work done under progressive mine closure plan during the year total is not equal the calculated total");
                    $("#TOTAL_PROGRESSIVE_AREA").val("");
                }
            }
            return true
        },
        "");

        //=======================ALL FORM FIELD VALIDATION==========================
        $("#frmAreaUtilisation").validate({
            onkeyup: false,
            rules: {
                FOREST_ABANDONED_AREA: {
                    required: true,
                    maxlength: 9,
                    number: true,
                    max: 99999.999,
                    areaRoundOff: true,
                    abanTotCal: true
                },
                NON_FOREST_ABANDONED_AREA: {
                    required: true,
                    maxlength: 9,
                    number: true,
                    max: 99999.999,
                    areaRoundOff: true,
                    abanTotCal: true
                },
                TOTAL_ABANDONED_AREA: {
                    required: true,
                    maxlength: 9,
                    number: true,
                    areaRoundOff: true,
                    abanTotCal: true
                },
                FOREST_WORKING_AREA: {
                    required: true,
                    maxlength: 9,
                    number: true,
                    max: 99999.999,
                    areaRoundOff: true,
                    workTotCal: true
                },
                NON_FOREST_WORKING_AREA: {
                    required: true,
                    maxlength: 9,
                    number: true,
                    max: 99999.999,
                    areaRoundOff: true,
                    workTotCal: true
                },
                TOTAL_WORKING_AREA: {
                    required: true,
                    maxlength: 9,
                    number: true,
                    areaRoundOff: true,
                    workTotCal: true
                },
                FOREST_RECLAIMED_AREA: {
                    required: true,
                    maxlength: 9,
                    number: true,
                    max: 99999.999,
                    areaRoundOff: true,
                    recTotCal: true
                },
                NON_FOREST_RECLAIMED_AREA: {
                    required: true,
                    maxlength: 9,
                    number: true,
                    max: 99999.999,
                    areaRoundOff: true,
                    recTotCal: true
                },
                TOTAL_RECLAIMED_AREA: {
                    required: true,
                    maxlength: 9,
                    number: true,
                    areaRoundOff: true,
                    recTotCal: true
                },
                FOREST_WASTE_AREA: {
                    required: true,
                    maxlength: 9,
                    number: true,
                    max: 99999.999,
                    areaRoundOff: true,
                    wasteTotCal: true
                },
                NON_FOREST_WASTE_AREA: {
                    required: true,
                    maxlength: 9,
                    number: true,
                    max: 99999.999,
                    areaRoundOff: true,
                    wasteTotCal: true
                },
                TOTAL_WASTE_AREA: {
                    required: true,
                    maxlength: 9,
                    number: true,
                    areaRoundOff: true,
                    wasteTotCal: true
                },
                FOREST_BUILDING_AREA: {
                    required: true,
                    maxlength: 9,
                    number: true,
                    max: 99999.999,
                    areaRoundOff: true,
                    buildTotCal: true
                },
                NON_FOREST_BUILDING_AREA: {
                    required: true,
                    maxlength: 9,
                    number: true,
                    max: 99999.999,
                    areaRoundOff: true,
                    buildTotCal: true
                },
                TOTAL_BUILDING_AREA: {
                    required: true,
                    maxlength: 9,
                    number: true,
                    areaRoundOff: true,
                    buildTotCal: true
                },
                FOREST_OTHER_AREA: {
                    required: true,
                    maxlength: 9,
                    number: true,
                    max: 99999.999,
                    areaRoundOff: true,
                    otherTotCal: true
                },
                NON_FOREST_OTHER_AREA: {
                    required: true,
                    maxlength: 9,
                    number: true,
                    max: 99999.999,
                    areaRoundOff: true,
                    otherTotCal: true
                },
                TOTAL_OTHER_AREA: {
                    required: true,
                    maxlength: 9,
                    number: true,
                    areaRoundOff: true,
                    otherTotCal: true
                },
                FOREST_PROGRESSIVE_AREA: {
                    required: true,
                    maxlength: 9,
                    number: true,
                    max: 99999.999,
                    areaRoundOff: true,
                    progTotCal: true
                },
                NON_FOREST_PROGRESSIVE_AREA: {
                    required: true,
                    maxlength: 9,
                    number: true,
                    max: 99999.999,
                    areaRoundOff: true,
                    progTotCal: true
                },
                TOTAL_PROGRESSIVE_AREA: {
                    required: true,
                    maxlength: 9,
                    number: true,
                    areaRoundOff: true,
                    progTotCal: true
                },
                AGENCY: {
                    required: true
                },
                OTHER_PURPOSE: {
                    required: {
                        depends: function() {

                            var forestArea1 = $('#FOREST_OTHER_AREA').val();
                            var forestArea2 = $('#NON_FOREST_OTHER_AREA').val();
                            var forestArea3 = $('#TOTAL_OTHER_AREA').val();

                            if ((forestArea1 != '' && forestArea1 != '0.000') || (forestArea2 != '' && forestArea2 != '0.000') || (forestArea3 != '' && forestArea3 != '0.000')) {
                                return true;
                            }
                        }
                    }
                }
            },
            messages: {
                FOREST_ABANDONED_AREA: {
                    required: "Please enter data",
                    maxlength: "Max. length allowed is 9 including decimal",
                    number: "Please enter numeric digits only",
                    max: "Max. value allowed is 5,3 i.e, 99999.999"
                },
                NON_FOREST_ABANDONED_AREA: {
                    required: "Please enter data",
                    maxlength: "Max. length allowed is 9 including decimal",
                    number: "Please enter numeric digits only",
                    max: "Max. value allowed is 5,3 i.e, 99999.999"
                },
                TOTAL_ABANDONED_AREA: {
                    required: "Please enter data",
                    maxlength: "Max. length allowed is 9 including decimal",
                    number: "Please enter numeric digits only"
                },
                FOREST_WORKING_AREA: {
                    required: "Please enter data",
                    maxlength: "Max. length allowed is 9 including decimal",
                    number: "Please enter numeric digits only",
                    max: "Max. value allowed is 5,3 i.e, 99999.999"
                },
                NON_FOREST_WORKING_AREA: {
                    required: "Please enter data",
                    maxlength: "Max. length allowed is 9 including decimal",
                    number: "Please enter numeric digits only",
                    max: "Max. value allowed is 5,3 i.e, 99999.999"
                },
                TOTAL_WORKING_AREA: {
                    required: "Please enter data",
                    maxlength: "Max. length allowed is 9 including decimal",
                    number: "Please enter numeric digits only"
                },
                FOREST_RECLAIMED_AREA: {
                    required: "Please enter data",
                    maxlength: "Max. length allowed is 9 including decimal",
                    number: "Please enter numeric digits only",
                    max: "Max. value allowed is 5,3 i.e, 99999.999"
                },
                NON_FOREST_RECLAIMED_AREA: {
                    required: "Please enter data",
                    maxlength: "Max. length allowed is 9 including decimal",
                    number: "Please enter numeric digits only",
                    max: "Max. value allowed is 5,3 i.e, 99999.999"
                },
                TOTAL_RECLAIMED_AREA: {
                    required: "Please enter data",
                    maxlength: "Max. length allowed is 9 including decimal",
                    number: "Please enter numeric digits only"
                },
                FOREST_WASTE_AREA: {
                    required: "Please enter data",
                    maxlength: "Max. length allowed is 9 including decimal",
                    number: "Please enter numeric digits only",
                    max: "Max. value allowed is 5,3 i.e, 99999.999"
                },
                NON_FOREST_WASTE_AREA: {
                    required: "Please enter data",
                    maxlength: "Max. length allowed is 9 including decimal",
                    number: "Please enter numeric digits only",
                    max: "Max. value allowed is 5,3 i.e, 99999.999"
                },
                TOTAL_WASTE_AREA: {
                    required: "Please enter data",
                    maxlength: "Max. length allowed is 9 including decimal",
                    number: "Please enter numeric digits only"
                },
                FOREST_BUILDING_AREA: {
                    required: "Please enter data",
                    maxlength: "Max. length allowed is 9 including decimal",
                    number: "Please enter numeric digits only",
                    max: "Max. value allowed is 5,3 i.e, 99999.999"
                },
                NON_FOREST_BUILDING_AREA: {
                    required: "Please enter data",
                    maxlength: "Max. length allowed is 9 including decimal",
                    number: "Please enter numeric digits only",
                    max: "Max. value allowed is 5,3 i.e, 99999.999"
                },
                TOTAL_BUILDING_AREA: {
                    required: "Please enter data",
                    maxlength: "Max. length allowed is 9 including decimal",
                    number: "Please enter numeric digits only"
                },
                FOREST_OTHER_AREA: {
                    required: "Please enter data",
                    maxlength: "Max. length allowed is 9 including decimal",
                    number: "Please enter numeric digits only",
                    max: "Max. value allowed is 5,3 i.e, 99999.999"
                },
                NON_FOREST_OTHER_AREA: {
                    required: "Please enter data",
                    maxlength: "Max. length allowed is 9 including decimal",
                    number: "Please enter numeric digits only",
                    max: "Max. value allowed is 5,3 i.e, 99999.999"
                },
                TOTAL_OTHER_AREA: {
                    required: "Please enter data",
                    maxlength: "Max. length allowed is 9 including decimal",
                    number: "Please enter numeric digits only"
                },
                FOREST_PROGRESSIVE_AREA: {
                    required: "Please enter data",
                    maxlength: "Max. length allowed is 9 including decimal",
                    number: "Please enter numeric digits only",
                    max: "Max. value allowed is 5,3 i.e, 99999.999"
                },
                NON_FOREST_PROGRESSIVE_AREA: {
                    required: "Please enter data",
                    maxlength: "Max. length allowed is 9 including decimal",
                    number: "Please enter numeric digits only",
                    max: "Max. value allowed is 5,3 i.e, 99999.999"
                },
                TOTAL_PROGRESSIVE_AREA: {
                    required: "Please enter data",
                    maxlength: "Max. length allowed is 9 including decimal",
                    number: "Please enter numeric digits only"
                }
            }
        });
    }
}
var Particular = {
    fieldValidation: function() {

        //=====================VALIDATING THE STATIC FORM PART======================

        $("#frmParticulars").validate({
            onkeyup: false
        });

        /*$("#frmParticulars").validate({
         onkeyup: false,
         rules: {
         UNDER_FOREST_AREA:{
         required: true,
         maxlength: 9,
         minlength: 1,
         number: true,
         max: 99999.999
         },
         OUTSIDE_FOREST_AREA:{
         required: true,
         maxlength: 9,
         minlength: 1,
         number: true,
         max: 99999.999
         },
         TOTAL_AREA:{
         required: true,
         maxlength: 10,
         minlength: 1,
         number: true,
         totalForestArea: true
         },
         PERIOD_LEASE:{
         required: true,
         minlength: 1,
         number: true,
         digits: true,
         min: 1,
         max: 99
         },
         SURFACE_RIGHT_AREA:{
         required: true,
         minlength: 1,
         number: true,
         max: 99999.999
         },
         PERIOD_RENEWAL:{
         required: true,
         minlength: 1,
         number: true,
         digits: true,
         min: 1,
         max: 99
         
         },
         ADD_INFO_LEASE:{
         required: false,
         maxlength: 1000
         }
         },
         messages: {
         UNDER_FOREST_AREA:{
         required: "Field is required",
         maxlength: "Max. length allowed is {0} including decimal",
         minlength: "Min. length must be {0} digits",
         number: "Please enter numeric digits only",
         max: "Max. value allowed is {0}"
         },
         OUTSIDE_FOREST_AREA:{
         required: "Field is required",
         maxlength: "Max. length allowed is {0} including decimal",
         minlength: "Min. length must be {0} digits",
         number: "Please enter numeric digits only",
         max: "Max. value allowed is {0}"
         },
         TOTAL_AREA:{
         required: "Field is required",
         maxlength: "Max. length allowed is {0} including decimal",
         minlength: "Min. length must be {0} digits",
         number: "Please enter numeric digits only"
         },
         PERIOD_LEASE:{
         required: "Field is required",
         min: "Min. value allowed is {0}",
         max: "Max. value allowed is {0}",
         minlength: "Min. length must be {0} digits",
         number: "Please enter numeric digits only",
         digits: "Decimal numbers are not allowed"
         },
         SURFACE_RIGHT_AREA:{
         required: "Field is required",
         minlength: "Min. length must be {0} digits",
         number: "Please enter numeric digits only",
         max: "Max. value allowed is 5,3 digits long"
         },
         PERIOD_RENEWAL:{
         required: "Field is required",
         min: "Min. value allowed is {0}",
         max: "Max. value allowed is {0}",
         minlength: "Min. length must be {0} digits",
         number: "Please enter numeric digits only",
         digits: "Decimal numbers are not allowed"
         },
         ADD_INFO_LEASE:{
         required: "",
         maxlength: "Max. length allowed is {0} digits"
         }
         }
         });
         
         $(".date").rules("remove");
         
         //================FUNCTION FOR ERROR MESSAGES FOR DYNAMIC FIELDS============
         $.validator.addMethod("cRequired", $.validator.methods.required,
         "Field is required");
         $.validator.addMethod("cMaxlength", $.validator.methods.maxlength,
         $.validator.format("Max. length allowed is {0} digits"));
         $.validator.addMethod("cMinlength", $.validator.methods.minlength, 
         $.validator.format("Min. length must be {0} digits"));
         
         //=================ADDING RULES FOR VALIDATION OF DYNAMIC FORM==============
         $.validator.addClassRules("lease_box", {
         cRequired: true, 
         cMinlength: 1,
         cMaxlength: 10
         });
         */

        //===============================FOR LEASE NO===============================
        $.validator.addMethod("cRequired", $.validator.methods.required,
            "Field is required");
        $.validator.addMethod("cMaxlength", $.validator.methods.maxlength,
            $.validator.format("Max. length allowed is {0} digits"));

        $.validator.addMethod("leaseMaxlength", $.validator.methods.maxlength,
            $.validator.format("Max. length allowed is {0}"));

        $.validator.addClassRules("lease_no", {
            cRequired: true,
            leaseMaxlength: 100
        });

        $.validator.addClassRules("leasePeriod", {
            number: true,
            digits: true,
            max: 99
        });


        //=====================COMMON FOR FOREST AREA===============================
        //====================roundOff to decimal 3 places==========================
        jQuery.validator.addMethod("threeRoundOff", function(value, element) {
            var temp = new Number(value);
            element.value = (temp).toFixed(3);
            return true;
        }, "");

        jQuery.validator.addMethod("decimalCheck", function(value, element) {
            return this.optional(element) || (/^[0-9,]+(\.\d{0,3})?$/).test(value);
        }, "Please enter number only to 3 decimal places");


        $.validator.addMethod("forestArea", function(value, element) {
            var fieldValue = parseFloat(value);

            //=====GETTING UNDER AND OUTSIDE FOREST LEASE FIELD ID AND VALUE==========
            var elementId = element.id;
            var elementNo;
            var splittedId = elementId.split("_");
            if (splittedId.length == 2) {
                elementNo = splittedId[1];
            }
            else
            if (splittedId.length == 3) {
                elementNo = splittedId[2];
            }
            
            //area under lease
            var field1Id = "#under_forest_" + elementNo;
            var field2Id = "#outside_forest_" + elementNo;
            var totalId = "#total_" + elementNo;

            var underForestValue = parseFloat($(field1Id).val());
            var outSideForestValue = parseFloat($(field2Id).val());
            var totalValue = parseFloat($(totalId).val());

            if (!isNaN(totalValue)) {
                if (isNaN(underForestValue))
                    underForestValue = 0;
                else
                if (isNaN(outSideForestValue))
                    outSideForestValue = 0;

                var calculatedTotal = parseFloat(underForestValue + outSideForestValue);
                var enteredTotal = parseFloat(totalValue);
                if (enteredTotal != calculatedTotal.toFixed(3)) {
                    alert('Total area should be equal to area under forest + area outside forest');
                    $(totalId).val("");
                }
            }
            
            //area for surface rights
            var surfaceField1Id = "#surface_under_forest_" + elementNo;
            var surfaceField2Id = "#surface_outside_forest_" + elementNo;
            var surfaceTotalId = "#surface_total_" + elementNo;

            var surfaceUnderForestValue = parseFloat($(surfaceField1Id).val());
            var surfaceOutSideForestValue = parseFloat($(surfaceField2Id).val());
            var surfaceTotalValue = parseFloat($(surfaceTotalId).val());

            if (!isNaN(surfaceTotalValue)) {
                if (isNaN(surfaceUnderForestValue))
                    surfaceUnderForestValue = 0;
                else
                if (isNaN(surfaceOutSideForestValue))
                    surfaceOutSideForestValue = 0;

                var surfaceCalculatedTotal = parseFloat(surfaceUnderForestValue + surfaceOutSideForestValue);
                var surfaceEnteredTotal = parseFloat(surfaceTotalValue);
                if (surfaceEnteredTotal != surfaceCalculatedTotal.toFixed(3)) {
                    alert('Total area should be equal to area under forest + area outside forest');
                    $(surfaceTotalId).val("");
                }
            }

            return true;
        }, "");
        //=====================COMMON FOR FOREST AREA===============================

        //============================FOR AREA UNDER LEASE==========================
        $.validator.addMethod("cRequired", $.validator.methods.required,
            "Field is required");
        $.validator.addMethod("cNumber", $.validator.methods.number,
            $.validator.format("Please enter numeric digits only"));
        $.validator.addMethod("cMax", $.validator.methods.max,
            $.validator.format("Max. value allowed is {0}"));
        $.validator.addMethod("cMaxlength", $.validator.methods.maxlength,
            $.validator.format("Max. length allowed is 5,3 digits including decimal"));

        $.validator.addMethod("checkArea", function(value, element) {
            var elementId = element.id;
            var elementVal = value;
            var splittedId = elementId.split('_');
            var token = splittedId[2];
            var leaseArea = $('#total_' + token).val();
            if (parseFloat(elementVal) > parseFloat(leaseArea)) {
                alert('The surface right is more than lease area');
            }
            return true;
        }, "");

        $.validator.addClassRules("under_lease", {
            cRequired: true,
            cNumber: true,
            cMax: 99999.999,
            decimalCheck: true,
            threeRoundOff: true,
            checkArea: true,
            forestArea: true,
            cMaxlength: 9
        });

        //========================FOR TOTAL AREA UNDER LEASE========================
        $.validator.addMethod("cRequired", $.validator.methods.required,
            "Field is required");
        $.validator.addMethod("cNumber", $.validator.methods.number,
            $.validator.format("Please enter numeric digits only"));
        $.validator.addMethod("cMax", $.validator.methods.max,
            $.validator.format("Max. value allowed is {0}"));
        $.validator.addMethod("cMaxlength", $.validator.methods.maxlength,
            $.validator.format("Max. length allowed is 6,3 digits including decimal"));
        $.validator.addClassRules("total_under_lease", {
            cRequired: true,
            cNumber: true,
            decimalCheck: true,
            threeRoundOff: true,
            forestArea: true,
            cMax: 999999.999,
            cMaxlength: 9
        });

        //========================FOR PERIOD FIELDS========================
        $.validator.addMethod("cRequired", $.validator.methods.required,
            "Field is required");
        $.validator.addMethod("cNumber", $.validator.methods.number,
            $.validator.format("Please enter numeric digits only"));
        $.validator.addMethod("cDigits", $.validator.methods.digits,
            $.validator.format("Please enter numeric digits only"));
        $.validator.addMethod("cMax", $.validator.methods.max,
            $.validator.format("Max. value allowed is {0}"));
        $.validator.addMethod("cMaxlength", $.validator.methods.maxlength,
            $.validator.format("Max. length allowed is {0} digits including decimal"));

        $.validator.addMethod("periodFieldCheck", function(value, element) {
            var elementId = element.id;
            var splittedId = elementId.split("_");
            var field1Id = "#renewal_date_" + splittedId[2];
            var field2Id = "#renewal_period_" + splittedId[2];
            var field1Value = $(field1Id).val();
            var field2Value = parseInt($(field2Id).val());
            if (!isNaN(field2Value) && field2Value > 0) {
                if (field1Value == "") {
                    alert("Enter date of renewal");
                }
            }
            //      else 
            //      if(field1Value != ""){
            //        if(isNaN(field2Value) || field2Value == 0){
            //          alert("Enter period of renewal");
            //        }
            //      }
            return true
        }, "");

        $.validator.addClassRules("period", {
            cRequired: true,
            cNumber: true,
            cDigits: true,
            cMax: 99,
            periodFieldCheck: true,
            cMaxlength: 2
        });

        Utilities.datePickerWithSlash(".renewal_date", 1900);

    },
    renewalDateAlert: function() {
        $(".renewal_date").unbind("click");
        $(".renewal_date").blur(function() {
            var renewalFieldId = $(this).attr("id");

            var renewalFieldVal = $("#" + renewalFieldId).val();

            var splittedId = renewalFieldId.split("_");
            var renewalPeriodId = "#renewal_period_" + splittedId[2];

            var renewalPeriodVal = parseInt($(renewalPeriodId).val());

            if (isNaN(renewalPeriodVal) || renewalPeriodVal == 0) {
                alert("Enter period of renewal");
            }

        });
    }

}

var EmploymentWages = {
    fieldValidation: function() {

        var totalDaysInYear = parseInt($('#no_days').val());
		
        $("#employmentWages").validate({
            onkeyup: false,
            rules: {
                DAYS_MINE_WORKED: {
                    maxlength: 3,
                    max: totalDaysInYear,
                    number: true,
                    digits: true
                },
                NO_OF_SHIFTS: {
                    min: 0,
                    max: 9,
                    maxlength: 1,
                    number: true,
                    digits: true,
                    checkShifts: true
                }
            /*,
                 WORKING_BELOW_DATE: {
                 date: false
                 },
                 
                 WORKING_ALL_DATE: {
                 date: false
                 },
                 WORKING_BELOW_PER: {
                 max: 9999,
                 maxlength: 4,
                 number: true,
                 digits: true
                 },
                 WORKING_ALL_PER: {
                 max: 9999,
                 maxlength: 4,
                 number: true,
                 digits: true
                 },
                 TOTAL_SALARY: {
                 maxlength: 15,
                 number: true,
                 max: 999999999999.99
                 }*/
            },
            messages: {
                DAYS_MINE_WORKED: {
                    maxlength: "Max. length allowed is {0} digits",
                    max: "Max. value allowed is {0}",
                    number: "Please enter numeric digits only",
                    digits: "Decimal digits are not allowed"
                },
                NO_OF_SHIFTS: {
                    min: "Min. value allowed is {0}",
                    maxlength: "Max. length allowed is {0} digits",
                    max: "Max. value allowed is {0}",
                    number: "Please enter numeric digits only",
                    digits: "Decimal digits are not allowed"
                }
            /*,
                 WORKING_BELOW_DATE: {
                 date: ""
                 },
                 WORKING_ALL_DATE: {TOTAL_WAGES
                 date: ""
                 },
                 WORKING_BELOW_PER: {
                 maxlength: "Max. length allowed is {0} digits",
                 max: "Max. value allowed is {0}",
                 number: "Please enter numeric digits only",
                 digits: "Decimal digits are not allowed"
                 },
                 WORKING_ALL_PER: {
                 maxlength: "Max. length allowed is {0} digits",
                 max: "Max. value allowed is {0}",
                 number: "Please enter numeric digits only",
                 digits: "Decimal digits are not allowed"
                 },
                 TOTAL_SALARY: {
                 maxlength: "Max. length allowed is 15 including decimal",
                 max: "Max. value allowed can be 12,2 long",
                 number: "Please enter numeric digits only"
                 }*/
            }
        });

        //==================TECHNICAL STAFF(TOP TABLE) VALIDATION===================
        $.validator.addMethod("aMaxlength", $.validator.methods.maxlength,
            $.validator.format("Max. length allowed is {0} digits"));
        $.validator.addMethod("aNumber", $.validator.methods.number,
            $.validator.format("Please enter numeric digits only"));
        $.validator.addMethod("aDigits", $.validator.methods.digits,
            $.validator.format("Decimal digits are not allowed"));
        $.validator.addMethod("aMax", $.validator.methods.max,
            $.validator.format("Max. value allowed is {0}"));

        $.validator.addClassRules("staff-emp", {
            aMaxlength: 4,
            aNumber: true,
            aDigits: true,
            aMax: 9999
        });

        //===============TECHNICAL STAFF(TOP TABLE) TOTAL VALIDATION================
        $.validator.addMethod("bMaxlength", $.validator.methods.maxlength,
            $.validator.format("Max. length allowed is {0} digits"));
        $.validator.addMethod("bNumber", $.validator.methods.number,
            $.validator.format("Please enter numeric digits only"));
        $.validator.addMethod("bDigits", $.validator.methods.digits,
            $.validator.format("Decimal digits are not allowed"));
        $.validator.addMethod("bMax", $.validator.methods.max,
            $.validator.format("Max. value allowed is {0}"));

        $.validator.addClassRules("staff-emp-tot", {
            bMaxlength: 5,
            bNumber: true,
            bDigits: true,
            bMax: 99999
        });

        //====================ALL ENTER FIELD EXCEPT TOTALS VALIDATION==============
        $.validator.addMethod("cMaxlength12", $.validator.methods.maxlength,
            $.validator.format("Max. length allowed is {0} digits"));
        $.validator.addMethod("cNumber", $.validator.methods.number,
            $.validator.format("Please enter numeric digits only"));
        $.validator.addMethod("cDigits", $.validator.methods.digits,
            $.validator.format("Decimal digits are not allowed"));
        $.validator.addMethod("cMax", $.validator.methods.max,
            $.validator.format("Max. value allowed is {0}"));

        $.validator.addClassRules("per_emp", {
            // workDecimal:true,
            cMaxlength12: 8,
            cNumber: true,
            //cDigits: true,
            cMax: 99999999
        });

        //======================YEARLY EMPLOYMENT VALIDATION========================
        $.validator.addMethod("dMaxlength", $.validator.methods.maxlength,
            $.validator.format("Max. length allowed is {0} digits"));
        $.validator.addMethod("dNumber", $.validator.methods.number,
            $.validator.format("Please enter numeric digits only"));
        $.validator.addMethod("dDigits", $.validator.methods.digits,
            $.validator.format("Decimal digits are not allowed"));
        $.validator.addMethod("dMax", $.validator.methods.max,
            $.validator.format("Max. value allowed is {0}"));

        $.validator.addMethod("checkShifts", function(value, element) {
            if (value > 3) {
                alert('No. of shifts are greater than 3. Confirm');
            }
            return true;
        });

        /*$.validator.addMethod("calHoriSum",function(value, element){
         
         if(!isNaN(parseInt(value))){
         
         var elementId = element.id;
         var splittedId = elementId.split("_");
         var idArrayLength = splittedId.length;
         
         if(idArrayLength == 4){
         var idPart1 = splittedId['0'];
         var idPart2 = splittedId['1'];
         var field1Id;
         var field2Id;
         field1Id = "#" + idPart1 + "_" + idPart2 + "_" + "DIRECT";
         field2Id = "#" + idPart1 + "_" + idPart2 + "_" + "CONTRACT";
         }
         else if(idArrayLength == 2){
         var totalIdPart1 = splittedId['0'];
         field1Id = "#" + totalIdPart1 + "_" + "DIRECT";
         field2Id = "#" + totalIdPart1 + "_" + "CONTRACT";
         }
         
         var element1Val = parseInt($(field1Id).val());
         var element2Val = parseInt($(field2Id).val());
         
         if(!isNaN(element1Val) && !isNaN(element2Val)){
         var fieldTotal = element1Val + element2Val;
         if(value != fieldTotal){
         alert("Calculated total varies from entered total");
         element.value = "";
         }
         }
         else{
         alert("Please fill the direct and contract value first");
         element.value = "";
         }
         }
         return true;
         },
         ""
         );
         
         $.validator.addClassRules("sum", {
         dMaxlength: 9,
         dNumber: true,
         dDigits: true,
         dMax: 999999999,
         calHoriSum: true
         });
         
         //========================DAYS WORKED IN YEAR VALIDATION====================
         $.validator.addMethod("eMaxlength", $.validator.methods.maxlength,
         $.validator.format("Max. length allowed is {0} digits"));
         $.validator.addMethod("eNumber", $.validator.methods.number,
         $.validator.format("Please enter numeric digits only"));
         $.validator.addMethod("eDigits", $.validator.methods.digits,
         $.validator.format("Decimal digits are not allowed"));
         $.validator.addMethod("eMax", $.validator.methods.max,
         $.validator.format("Max. value allowed is {0}"));
         
         $.validator.addClassRules("days", {
         eMaxlength: 3,
         eMax: 365,
         eNumber: true,
         eDigits: true
         });
         
         //==============================WAGES VALIDATION============================
         $.validator.addMethod("fMaxlength", $.validator.methods.maxlength,
         $.validator.format("Max. length allowed is {0} including decimal"));
         $.validator.addMethod("fNumber", $.validator.methods.number,
         $.validator.format("Please enter numeric digits only"));
         $.validator.addMethod("fMax", $.validator.methods.max,
         $.validator.format("Max. value allowed is 12,2 digits long"));
         
         $.validator.addMethod("fTotalWages", function(value, element){
         var elementId  = element.id;
         var splittedId = elementId.split('_');
         
         var manTotalId  = '#'+splittedId[0]+'_'+splittedId[1]+'_MAN_TOT';
         var manTotalVal = $(manTotalId).val();
         if(value != 0 && manTotalVal != 0){
         //alert(value+'-'+manTotalVal);
         var wagesVal = parseFloat(value)/parseFloat(manTotalVal);
         if(wagesVal < 50){
         alert('Average daily wage or salary < Rs 50');
         }
         if(wagesVal > 2000){
         alert('Average daily wage or salary > Rs 2000');
         }
         }
         return true;
         });
         
         $.validator.addClassRules("wages", {
         fMaxlength: 15,
         fNumber: true,
         fMax: 999999999999.99,
         fTotalWages:true
         });
         
         //===========================TOTAL WAGES VALIDATION=========================
         $.validator.addMethod("gMaxlength", $.validator.methods.maxlength,
         $.validator.format("Max. length allowed is {0} including decimal"));
         $.validator.addMethod("gNumber", $.validator.methods.number,
         $.validator.format("Please enter numeric digits only"));
         $.validator.addMethod("gMax", $.validator.methods.max,
         $.validator.format("Max. value allowed is 12,2 digits long"));
         
         $.validator.addClassRules("tot-wages", {
         gMaxlength: 15,
         gNumber: true,
         gMax: 999999999999.99
         });
         
         //=====================DIRECT VERTICAL TOTAL VALIDATION=====================
         jQuery.validator.addMethod("directVerticalTotal", function(value, element){
         var directArray = new Array();
         directArray = $(".direct");
         var directTotal = 0;
         for(var i = 0; i < directArray.length; i++){
         var directElement = parseInt(directArray[i].value);
         if(!isNaN(directElement)){
         directTotal += parseInt(directArray[i].value);
         }
         }
         if(value != directTotal){
         alert("Calculated total varies from entered total");
         $("#TOTAL_DIRECT").val("");
         }
         return true
         });
         
         $("#TOTAL_DIRECT").rules("add", {
         maxlength: 9,
         number: true,
         digits: true,
         max: 999999999,
         directVerticalTotal: true,
         messages: {
         //        required: "Field is required",
         maxlength: "Max. length allowed is 9 digits",
         number: "Plese enter numeric digits only",
         max: "Max. value allowed can be 9 digits long",
         digits: "Decimal digits are not allowed"
         }
         });
         
         //===================CONTRACT VERTICAL TOTAL VALIDATION=====================
         jQuery.validator.addMethod("contractVerticalTotal", function(value, element){
         var directArray = new Array();
         directArray = $(".contract");
         var directTotal = 0;
         for(var i = 0; i < directArray.length; i++){
         var directElement = parseInt(directArray[i].value);
         if(!isNaN(directElement)){
         directTotal += parseInt(directArray[i].value);
         }
         }
         if(value != directTotal){
         alert("Calculated total varies from entered total");
         $("#TOTAL_CONTRACT").val("");
         }
         return true
         });
         
         $("#TOTAL_CONTRACT").rules("add", {
         maxlength: 9,
         number: true,
         digits: true,
         max: 999999999,
         contractVerticalTotal: true,
         messages: {
         //        required: "Field is required",
         maxlength: "Max. length allowed is 9 digits",
         number: "Plese enter numeric digits only",
         max: "Max. value allowed can be 9 digits long",
         digits: "Decimal digits are not allowed"
         }
         });
         
         //======================FIELD VALUE CHANGE TOTAL VALIDATION=================
         jQuery.validator.addMethod("totalCheck", function(value, element){
         
         var splittedId = element.id.split("_")
         var field1Id = "#" + splittedId[0] + "_" + splittedId[1] + "_" +"DIRECT";
         var field2Id = "#" + splittedId[0] + "_" + splittedId[1] + "_" +"CONTRACT";
         var field3Id = "#" + splittedId[0] + "_" + splittedId[1] + "_" +"MAN_TOT";
         
         var field1Value = parseInt($(field1Id).val());
         var field2Value = parseInt($(field2Id).val());
         var field3Value = parseInt($(field3Id).val());
         
         if(!isNaN(field3Value)){
         
         if((!isNaN(field1Value) && isNaN(field2Value))){
         if(field3Value != field1Value){
         if(field3Value > 0){
         alert("Calculated total of direct and contract is not equal to the entered total");
         }
         $(field3Id).val("");
         }
         }
         if(isNaN(field1Value) && !isNaN(field2Value)){
         if(field3Value != field2Value){
         if(field3Value > 0){
         alert("Calculated total of direct and contract is not equal to the entered total");
         }
         $(field3Id).val("");
         }
         }
         if(!isNaN(field1Value) && !isNaN(field2Value)){
         if(field3Value != (field1Value + field2Value)){
         if(field3Value > 0){
         alert("Calculated total of direct and contract is not equal to the entered total");
         }
         $(field3Id).val("");
         }
         }
         }
         return true
         },""
         
         //===================DIRECT FIELD VALUE CHANGE TOTAL VALIDATION=============
         );
         $.validator.addClassRules("direct", {
         totalCheck: true
         });
         
         //==================CONTRACT FIELD VALUE CHANGE TOTAL VALIDATION============
         $.validator.addClassRules("contract", {
         totalCheck: true
         });
         
         
         //=====================AVG. DAILY EMPLOYMENT VALIDATION=====================
         $.validator.addMethod("dMaxlength", $.validator.methods.maxlength,
         $.validator.format("Max. length allowed is {0} digits"));
         $.validator.addMethod("dNumber", $.validator.methods.number,
         $.validator.format("Please enter numeric digits only"));
         $.validator.addMethod("dDigits", $.validator.methods.digits,
         $.validator.format("Decimal digits are not allowed"));
         $.validator.addMethod("dMax", $.validator.methods.max,
         $.validator.format("Max. value allowed is {0}"));
         
         $.validator.addMethod("calHoriSum1",function(value, element){
         if(!isNaN(parseInt(value))){
         
         var elementId = element.id;
         var splittedId = elementId.split("_");
         var idArrayLength = splittedId.length;
         
         if(idArrayLength == 4){
         var idPart1 = splittedId['0'];
         var idPart2 = splittedId['1'];
         var field1Id;
         var field2Id;
         field1Id = "#" + idPart1 + "_" + idPart2 + "_" + "MALE";
         field2Id = "#" + idPart1 + "_" + idPart2 + "_" + "FEMALE";
         }
         else if(idArrayLength == 2){
         var totalIdPart1 = splittedId['0'];
         field1Id = "#" + totalIdPart1 + "_" + "MALE";
         field2Id = "#" + totalIdPart1 + "_" + "FEMALE";
         }
         
         var element1Val = parseInt($(field1Id).val());
         var element2Val = parseInt($(field2Id).val());
         
         if(!isNaN(element1Val) && !isNaN(element2Val)){
         var fieldTotal = element1Val + element2Val;
         if(value != fieldTotal){
         alert("Calculated total varies from entered total");
         element.value = "";
         }
         }
         else{
         alert("Please fill the average daily male and female employed value first");
         element.value = "";
         }
         }
         return true;
         },
         ""
         );
         
         $.validator.addClassRules("sum1", {
         dMaxlength: 9,
         dNumber: true,
         dDigits: true,
         dMax: 999999999,
         calHoriSum1: true
         });
         
         
         //================AVG. TOTAL FIELD VALUE CHANGE TOTAL VALIDATION============
         jQuery.validator.addMethod("avgTotalCheck", function(value, element){
         
         var splittedId = element.id.split("_")
         var field1Id = "#" + splittedId[0] + "_" + splittedId[1] + "_" +"MALE";
         var field2Id = "#" + splittedId[0] + "_" + splittedId[1] + "_" +"FEMALE";
         var field3Id = "#" + splittedId[0] + "_" + splittedId[1] + "_" +"PER_TOTAL";
         
         var field1Value = parseInt($(field1Id).val());
         var field2Value = parseInt($(field2Id).val());
         var field3Value = parseInt($(field3Id).val());
         
         if(!isNaN(field3Value)){
         
         if((!isNaN(field1Value) && isNaN(field2Value))){
         if(field3Value != field1Value){
         if(field3Value > 0){
         alert("Calculated total of average male and female employed is not equal to the entered total");
         }
         $(field3Id).val("");
         }
         }
         if(isNaN(field1Value) && !isNaN(field2Value)){
         if(field3Value != field2Value){
         if(field3Value > 0){
         alert("Calculated total of average male and female employed is not equal to the entered total");
         }
         $(field3Id).val("");
         }
         }
         if(!isNaN(field1Value) && !isNaN(field2Value)){
         if(field3Value != (field1Value + field2Value)){
         if(field3Value > 0){
         alert("Calculated total of average male and female employed is not equal to the entered total");
         }
         $(field3Id).val("");
         }
         }
         }
         return true
         },""
         
         //===================DIRECT FIELD VALUE CHANGE TOTAL VALIDATION=============
         );
         $.validator.addClassRules("male", {
         avgTotalCheck: true
         });
         
         //==================CONTRACT FIELD VALUE CHANGE TOTAL VALIDATION============
         $.validator.addClassRules("female", {
         avgTotalCheck: true
         });
         
         //=================AVG. DAILY MALE VERTICAL TOTAL VALIDATION================
         jQuery.validator.addMethod("maleVerticalTotal", function(value, element){
         var directArray = new Array();
         directArray = $(".male");
         var directTotal = 0;
         for(var i = 0; i < directArray.length; i++){
         var directElement = parseInt(directArray[i].value);
         if(!isNaN(directElement)){
         directTotal += parseInt(directArray[i].value);
         }
         }
         if(value != directTotal){
         alert("Calculated total varies from entered total");
         $("#TOTAL_MALE").val("");
         }
         return true
         });
         
         $.validator.addMethod('workDecimal', function(value, element) {
         return this.optional(element) || /^\d+(\.\d{0,1})?$/.test(value); 
         }, "Please enter only 1 decimal point");
         
         $("#TOTAL_MALE").rules("add", {
         maxlength: 9,
         number: true,
         //digits: true,workDecimal: true,
         max: 999999999,
         workDecimal: true,
         maleVerticalTotal: true,
         messages: {
         //        required: "Field is required",
         maxlength: "Max. length allowed is 9 digits",
         number: "Plese enter numeric digits only",
         max: "Max. value allowed can be 9 digits long"
         //digits: "Decimal digits are not allowed"
         }
         });
         
         //================AVG. DAILY FEMALE VERTICAL TOTAL VALIDATION===============
         jQuery.validator.addMethod("femaleVerticalTotal", function(value, element){
         var directArray = new Array();
         directArray = $(".female");
         var directTotal = 0;
         for(var i = 0; i < directArray.length; i++){
         var directElement = parseInt(directArray[i].value);
         if(!isNaN(directElement)){
         directTotal += parseInt(directArray[i].value);
         }
         }
         if(value != directTotal){
         alert("Calculated total varies from entered total");
         $("#TOTAL_FEMALE").val("");
         }
         return true
         });
         
         $("#TOTAL_FEMALE").rules("add", {
         maxlength: 9,
         number: true,
         //digits: true,
         workDecimal: true,
         max: 999999999,
         femaleVerticalTotal: true,
         messages: {
         //        required: "Field is required",
         maxlength: "Max. length allowed is 9 digits",
         number: "Plese enter numeric digits only",
         max: "Max. value allowed can be 9 digits long"
         //digits: "Decimal digits are not allowed"
         }
         });
         
         //================NO OF DAYS WORKED VERTICAL TOTAL VALIDATION===============
         jQuery.validator.addMethod("daysTotal", function(value, element){
         var directArray = new Array();
         directArray = $(".days");
         var directTotal = 0;
         for(var i = 0; i < directArray.length; i++){
         var directElement = parseInt(directArray[i].value);
         if(!isNaN(directElement)){
         directTotal += parseInt(directArray[i].value);
         }
         }
         if(value != directTotal){
         alert("Calculated total varies from entered total");
         $("#TOTAL_DAYS").val("");
         }
         return true
         });
         
         $("#TOTAL_DAYS").rules("add", {
         maxlength: 9,
         number: true,
         digits: true,
         max: 999999999,
         daysTotal: true,
         messages: {
         //        required: "Field is required",
         maxlength: "Max. length allowed is 9 digits",
         number: "Plese enter numeric digits only",
         max: "Max. value allowed can be 9 digits long",
         digits: "Decimal digits are not allowed"
         }
         });
         
         //======================WAGES VERTICAL TOTAL VALIDATION=====================
         jQuery.validator.addMethod("wagesTotal", function(value, element){
         var directArray = new Array();
         directArray = $(".wages");
         var directTotal = 0;
         for(var i = 0; i < directArray.length; i++){
         var directElement = parseInt(directArray[i].value);
         if(!isNaN(directElement)){
         directTotal += parseInt(directArray[i].value);
         }
         }
         if(value != directTotal){
         alert("Calculated total varies from entered total");
         $("#TOTAL_WAGES").val("");
         }
         return true
         });
         
         $("#TOTAL_WAGES").rules("add", {
         maxlength: 9,
         number: true,
         //digits: true,
         max: 999999999,
         wagesTotal: true,
         messages: {
         //        required: "Field is required",
         maxlength: "Max. length allowed is 9 digits",
         number: "Plese enter numeric digits only",
         max: "Max. value allowed can be 9 digits long"
         //digits: "Decimal digits are not allowed"
         }
         });*/

        jQuery.validator.addMethod("whollyTotal", function(value, element) {
            var directArray = new Array();
            directArray = $(".wholly-emp-tot");
            var directTotal = 0;
            for (var i = 0; i < directArray.length; i++) {
                var directElement = parseInt(directArray[i].value);
                if (!isNaN(directElement)) {
                    directTotal += parseInt(directArray[i].value);
                }
            }
            if (value != directTotal) {
                alert("Calculated total of wholly employeed staff varies from entered total");
                $("#TOTAL_WHOLLY").val("");
                return false;
            }
            return true;
        }, 'Please enter valid total');

        $("#TOTAL_WHOLLY").rules("add", {
            whollyTotal: true
        });

        jQuery.validator.addMethod("partlyTotal", function(value, element) {
            var directArray = new Array();
            directArray = $(".partly-emp-tot");
            var directTotal = 0;
            for (var i = 0; i < directArray.length; i++) {
                var directElement = parseInt(directArray[i].value);
                if (!isNaN(directElement)) {
                    directTotal += parseInt(directArray[i].value);
                }
            }
            if (value != directTotal) {
                alert("Calculated total of partly employeed staff varies from entered total");
                $("#TOTAL_PARTLY").val("");
                return false;
            }
            return true;
        }, 'Please enter valid total');


        $("#TOTAL_PARTLY").rules("add", {
            partlyTotal: true
        });


        //=========================DYNAMIC FIELD VAILDATION=========================
        $.validator.addMethod("iMaxlength", $.validator.methods.maxlength,
            $.validator.format("Max. length allowed is {0} including decimal"));
        $.validator.addMethod("iNumber", $.validator.methods.number,
            $.validator.format("Please enter numeric digits only"));
        $.validator.addMethod("iDigits", $.validator.methods.digits,
            $.validator.format("Decimal digits are not allowed"));
        $.validator.addMethod("iMax", $.validator.methods.max,
            $.validator.format("Max. value allowed is {0}"));
        $.validator.addMethod("checkSelect", function(value, element) {
            var elementId = element.id
            var splittedId = elementId.split("_");
            var elementNo = splittedId[3];

            var selectId = "#reason_" + elementNo

            var selectVal = $(selectId).val();
            if (selectVal == "") {
                alert("Please select the reason from the select box first");
                $("#" + elementId).val("");
                return false;
            }
            return true;
        }, ""
        );
        $.validator.addMethod("checkDays", function(value, element) {
            var elementId = element.id
            var elementVal = $('#' + elementId).val();

            var splittedId = elementId.split("_");
            var elementNo = splittedId[3];

            var inputEle = $(".no_of_days");
            var inputEleLength = inputEle.length;

            // GETTING THE TOTAL NUMBER OF DAYS MINE WORKED AND THEN COMPARE WITH THE NUMBER OF DAYS
            // MINES DIDN'T WORK... TO MAKE THE TOTAL EQUAL TO THE TOTAL NUMBER OF DAYS IN THE YEAR

            var totalNoOfDaysMineWorked = parseInt($("#DAYS_MINE_WORKED").val());
            if (isNaN(totalNoOfDaysMineWorked))
                totalNoOfDaysMineWorked = parseInt(0);
            var totalNoOfDaysMineNotWorked = parseInt(0);
            for (var i = 0; i < inputEleLength; i++) {
                totalNoOfDaysMineNotWorked = totalNoOfDaysMineNotWorked + parseInt(inputEle[i].value);
            }

            var totalDays = totalNoOfDaysMineWorked + totalNoOfDaysMineNotWorked;
            if (isNaN(totalDays))
                totalDays = parseInt(0);

            // CHECKING FOR LEAP YEAR
            var currentYear = new Date().getFullYear();

            // var leapYearCheck1 = parseInt(currentYear % 4);
            // var leapYearCheck2 = parseInt(currentYear % 100);
            // var leapYearCheck3 = parseInt(currentYear % 400);
            // Commented below line as it's getting stuck in leap year
            // Added dynamic total days through the controller method
            // Done on 22-03-2022 by AG.
            // var totalYearDays = 365;
            var totalYearDays = $('#no_days').val();
            var leapFlag = (totalYearDays > 365) ? 1 : false;
            // if (leapYearCheck3 == 0 || (leapYearCheck2 != 0 && leapYearCheck1 == 0)) {
            //     totalYearDays = 366;
            //     leapFlag = 1;
            // }

            if (totalDays > parseInt(totalYearDays)) {
                // ADDDED THE return FALSE TO AVOID GOING TO THE NEXT PAGE ON FALSE CONDITINO
                // @author Uday Shankar Singh<usingh@ubicsindia.com, udayshankar1306@gmail.com>
                // @version 6th Feb 2014
                if (leapFlag == 1){
                    alert("Total of 'work stoppage days' + 'Number of days mine worked' should not exceed "+totalYearDays+" (as it's Leap Year).")
                    return false;
                }
                else{
                    alert("Total of 'work stoppage days' + 'Number of days mine worked' should not exceed "+totalYearDays+".")
                    return false;
                }
            }
            //            console.log(totalDays)
            //            console.log(totalYearDays)
            if (totalDays < parseInt(totalYearDays)) {

                //                if (reasonVal != '' && (elementVal == '' || elementVal == 0)) {
                if (value > 0) {
                    var reasonId = '#reason_' + elementNo;
                    var reasonVal = $(reasonId).val();
                    if (reasonVal == "") {
                        alert("No of Days for work stoppage is greater than 0. Kindly select the reason for the same")
                        return false;
                    }
                }
                else {
                    alert("As the 'Total Number of days mine worked' + 'No of Days work stoppage' is not equal to total no of days in the year. You may enter reasons for work stoppage, if any.");

                }
            //                    return true;
            //                }
            //                else {
            //                    return true;
            //                }

            }
            return true
        }, ""
        );

        jQuery.validator.addMethod("checkTotalDays", function(value, element) {
            var daysArray = new Array();
            daysArray = $(".no_of_days");
            var daysTotal = 0;

            for (var i = 0; i < daysArray.length; i++) {
                var noOfDays = parseInt(daysArray[i].value);
                if (!isNaN(noOfDays)) {
                    daysTotal += parseInt(daysArray[i].value);
                }
            }
            var mineWorkedDays = $('#DAYS_MINE_WORKED').val();
            var totalWorkingDays = parseInt(mineWorkedDays) + parseInt(daysTotal);
            var totalDaysInYear = $('#no_days').val();
            if (totalWorkingDays > totalDaysInYear) {
                alert('Total no. of days mine worked + no. of days of work stoppage should not exceed the total no of days in the year');
                return false;
            }
            return true;
        }, ""
        );

        $.validator.addClassRules("no_of_days", {
            iMaxlength: 3,
            iNumber: true,
            iDigits: true,
            iMax: 366,
            checkDays: true,
        //            checkTotalDays: true,
        //            checkSelect: true
        });

        $.validator.addClassRules("wholly-emp-tot", {
            //iMaxlength: 3,
            iMax: 9999,
            iNumber: true
        });

        $.validator.addClassRules("partly-emp-tot", {
            //iMaxlength: 3,
            iMax: 9999,
            iNumber: true
        });

        $.validator.addMethod("checkReason", function(value, element) {
            var elementId = element.id
            var elementVal = $('#' + elementId).val();

            var splittedId = elementId.split("_");
            var elementNo = splittedId[1];

            var reasonArray = new Array();
            reasonArray = $(".select_reason");
            for (var i = 0; i < reasonArray.length; i++) {
                var reasonElement = reasonArray[i].value;
                var reasonId = reasonArray[i].id;
                var splittedReasonId = reasonId.split("_");
                var ReasonNo = splittedReasonId[1];
                if (elementNo != ReasonNo) {
                    if (elementVal == reasonElement) {
                        alert("This reason has been already selected");
                        $('#' + elementId).val('');
                    }
                }
            }
            return true;
        }, ""
        );



        $.validator.addClassRules("select_reason", {
            checkReason: true
        });
    },
    /**
     * ADDING THE BELOW FUNCTION FOR CHECKING THE REASON AT THE TIME OF SAVE AND NEXT
     * AND NOT ALLOWING HIM/HER TO GO FORWARD UNTIL THE USER FILL THE VALUE FOR THE 
     * SELECTED REASON
     * @author Uday Shankar Singh
     * @version 14th Feb 2014
     * 
     **/ 
    employmentWagesIPostValidation: function(){
        $("#employmentWages").submit(function(event){
            var allSelect = $(".no_of_days");
            var errorFlag2 = false;
            $.each(allSelect, function(index, elementValue){
                if(elementValue.value == '' || elementValue.value == 0){
                    errorFlag2 = true;
                }
            });

            // CHECKING FOR ANY SELECTION OF REASONS            
            var allSelect1 = $(".select_reason");
            var errorFlag1 = false;
            $.each(allSelect1, function(index, elementValue){
                if(elementValue.value != ''){
                    errorFlag1 = true;
                }
            });
			
			var errorFlag = false;
			if(errorFlag2 == true && errorFlag1 == true){
			errorFlag = true;
			}
			
             // Bewlow check condition check for the mine worked days value is 365 and 366 so below validation messgae not show and this form is save without select reason
        // added by ganesh satav dated by 22 july 2014
            var daysmineworked = $("#DAYS_MINE_WORKED").val();
            var daysmineworkedval = parseInt(daysmineworked);
            var totalNoDaysInYear = parseInt($('#no_days').val());
        // if(daysmineworkedval!=365 && daysmineworkedval != 366)
        if(daysmineworkedval != totalNoDaysInYear)
            {
            if(errorFlag == true){
                alert("Number of days of work stoppage is not entered for one or more reasons or it is entered 0. Kindly provide correct details before proceeding.");
                event.preventDefault();
            }
			else alert("Alert: Please check Total Number of days mine worked and No of Days of work stoppage during the year.");
            }
			
			// Bewlow check condition check for the mine worked days value is 365 and 366 so below validation messgae not show and this form is save without select reason
        // As per discuss with Tarun and saji sir this changes doing before this chnage some other message show now beloe message showing.
        // added by ganesh satav dated by 22 july 2014
          
        /*        if(daysmineworkedval<=364)
                    {
             alert("Alert Please check Total Number of days mine worked and No of Days of work stoppage during the year.");
                    }
					*/
          
		  
            var noOfDaysMineWork = $("#DAYS_MINE_WORKED").val();
            var noOfShift = $("#NO_OF_SHIFTS").val();
            if(noOfDaysMineWork > 0){
				if(noOfShift == '' || noOfShift == 0){
					alert(" No.of shifts per day can't be empty or 0. Kindly provide correct details before proceeding.");
					event.preventDefault();
				}
            }else{
                if(noOfShift == ''){
                    alert(" No.of shifts per day can't be empty. Kindly provide correct details before proceeding.");
                    event.preventDefault();
                }
            }
            
        });
    }
}

var CapStruc = {
    fieldValidation: function() {
        jQuery.validator.addMethod("roundOff2", function(value, element) {
            var temp = new Number(value);
            element.value = (temp).toFixed(2);
            return true;
        }, "");

        var _this = this;
        $("#capitalStructure").validate({
            onkeyup: false,
            rules: {
                interest_paid: {
                    required: true,
                    maxlength: 12,
                    number: true,
                    digits: true
                //          roundOff2: true
                },
                rent_paid: {
                    required: true,
                    maxlength: 12,
                    number: true,
                    digits: true
                }
            },
            messages: {
                interest_paid: {
                    required: "Please enter interest Paid",
                    maxlength: "Max. length allowed is {0} digits",
                    number: "Please enter numeric digits enter",
                    digits: "Decimal digits are not allowed"
                },
                rent_paid: {
                    required: "Please enter rent paid",
                    maxlength: "Max. length allowed is {0} digits",
                    number: "Please enter numeric digits enter",
                    digits: "Decimal digits are not allowed"
                }
            }
        });

        //==================ALL CAPITAL STRUCTURE COMMON FIELD VAIDATION============
        $.validator.addMethod('aMaxlength', $.validator.methods.maxlength,
            $.validator.format("Max. length allowed is {0} digits"));
        $.validator.addMethod('aNumber', $.validator.methods.number,
            $.validator.format("Please enter numeric digits only"));
        $.validator.addMethod('aDigits', $.validator.methods.digits,
            $.validator.format("Decimal digits are not allowed"));
        $.validator.addClassRules("cap_struc", {
            aMaxlength: 15,
            aNumber: true,
            aDigits: true
        });

        //========================DESCRIPTION TABLE VALIDATION======================
        $.validator.addMethod('qRequired', $.validator.methods.required,
            $.validator.format("Please enter Net Closing Balance"));
        $.validator.addMethod("closeBalCheck", function(value, element) {
            if (!isNaN(parseInt(value))) {
                var elementId = element.id;
                var splittedId = elementId.split("_");

                var fieldBegId = "#" + splittedId[0] + "_beg";
                var fieldAddtionId = "#" + splittedId[0] + "_addition";
                var fieldSoldId = "#" + splittedId[0] + "_sold";
                var fieldDepreciationId = "#" + splittedId[0] + "_depreciated";

                var fieldBegValue = parseInt($(fieldBegId).val());
                var fieldAdditionValue = parseInt($(fieldAddtionId).val());
                var fieldSoldValue = parseInt($(fieldSoldId).val());
                var fieldDepreciationValue = parseInt($(fieldDepreciationId).val());

                if (isNaN(fieldBegValue))
                    fieldBegValue = 0;
                if (isNaN(fieldAdditionValue))
                    fieldAdditionValue = 0;
                if (isNaN(fieldSoldValue))
                    fieldSoldValue = 0;
                if (isNaN(fieldDepreciationValue))
                    fieldDepreciationValue = 0;

                var calculation = (fieldBegValue + fieldAdditionValue) - (fieldSoldValue + fieldDepreciationValue)

                // console.log(calculation)
                // console.log(parseInt(value))
                if (parseInt(value) != calculation) {
                    alert("Net closing balance is not not equal to calculated total. Fields [(2+3)-(4+5)] value must be equal to field 6 value")
                    $("#" + elementId).val("");
                }
                if (parseInt(value) == parseInt(calculation)) {
                    if (value < 0) {
                        alert("Net Closing Balance cannot be negative. Kindly fill correct values");
                        $("#" + elementId).val("");
                    }
                }

            }
        }, ""
        );
        //    $.validator.addClassRules("closing_bal",{
        //      qRequired: true,
        //      closeBalCheck: true
        //    });


        /**
         * STEPS:
         * 1. ONBLUR JQUERY VALIDATOR WILL GET THE ID OF THE FIELD
         * 2. tableTotal METHOD WILL SPLIT THE ID AND GET THE PART OF THE ID THAT IS
         *    COMMON TO ALL VERTICAL FIELDS
         * 3. from tableTotal WE CALL descriptionTotalValidation METHOD WHICH CREATES
         *    THE CLASS NAME BASED ON THE COMMON PART WE GET ABOVE, THEN IT GETS ALL
         *    THE ELEMENTS OF THAT CLASS AND CHECK OUT THEIR VALUES
         */
        //======================DESCRIPTION TABLE TOTAL VALIDATION==================
        $.validator.addMethod("tableTotal", function(value, element) {
            var elementId = element.id;
            var splittedId = elementId.split("_");

            var partialId;
            if (splittedId.length == 2) {
                partialId = splittedId[1];
            }
            else if (splittedId.length == 3) {
                var temp1 = splittedId[1];
                var temp2 = splittedId[2];
                partialId = temp1 + "_" + temp2;
            }

            _this.descriptionTotalValidation(partialId);
            return true;
        }, "");

        //==============NOT USING ANYMORE===NEED TO USE OR REMOVE LATER=============
        $.validator.addMethod("formulaCheck", function(value, element) {
            var elementId = element.id;
            var splittedId = elementId.split("_");

            var partialId = splittedId[0];

            _this.formulaCheck(partialId, elementId);
            return true;
        }, "");
        //==========================================================================

        //======================CALLING METHOD ON TOTAL FIELD BY ID=================
        $.validator.addClassRules("at_year_beg", {
            tableTotal: true
        })
        $.validator.addClassRules("add_during_year", {
            tableTotal: true
        })
        $.validator.addClassRules("sold_during_year", {
            tableTotal: true
        })
        $.validator.addClassRules("dep_during_year", {
            tableTotal: true
        })
        $.validator.addClassRules("closing_bal", {
            tableTotal: true,
            formulaCheck: true
        })
        $.validator.addClassRules("estimated_value", {
            tableTotal: true
        })

        //=========================LOAN AMOUNT VALIDATION===========================
        $.validator.addMethod("lMaxlength", $.validator.methods.maxlength,
            $.validator.format("Max. length allowed is {0} digits"));
        $.validator.addMethod("lNumber", $.validator.methods.number,
            $.validator.format("Please enter numeric digits only"));
        $.validator.addMethod("lDigits", $.validator.methods.digits,
            $.validator.format("Decimal digits are not allowed"));
        $.validator.addClassRules("loan", {
            lMaxlength: 15,
            lNumber: true,
            lDigits: true
        });

        //========================INTEREST RATE VALIDATION==========================
        $.validator.addMethod("lMaxlength", $.validator.methods.maxlength,
            $.validator.format("Max. length allowed is {0} digits"));
        $.validator.addMethod("lNumber", $.validator.methods.number,
            $.validator.format("Please enter numeric digits only"));
        $.validator.addMethod("lMax", $.validator.methods.max,
            $.validator.format("Max. value allowed is 99.99"));
        $.validator.addMethod('Decimal', function(value, element) {
            return this.optional(element) || /^\d+(\.\d{0,2})?$/.test(value);
        }, "Please enter only 2 decimal points");

        $.validator.addClassRules("interest", {
            roundOff2: true,
            Decimal: true,
            lNumber: true,
            lMax: 99.99

        });


        //==================================BEGINNING=================================
        $.validator.addMethod("gRequired", $.validator.methods.required,
            $.validator.format("Please enter vertical total"));
        $.validator.addMethod("gCheckFields", $.validator.methods.required,
            $.validator.format("Please enter vertical total"));
        $.validator.addClassRules("beg_total", {
            gRequired: true,
            gCheckFields: true
        });

        //==================================ADDITION=================================
        $.validator.addMethod("gRequired", $.validator.methods.required,
            $.validator.format("Please enter vertical total"));
        $.validator.addClassRules("addition_total", {
            gRequired: true
        });

        //==================================SOLD=================================
        $.validator.addMethod("gRequired", $.validator.methods.required,
            $.validator.format("Please enter vertical total"));
        $.validator.addClassRules("sold_total", {
            gRequired: true
        });

        //==================================DEPRECIATED=================================
        $.validator.addMethod("gRequired", $.validator.methods.required,
            $.validator.format("Please enter vertical total"));
        $.validator.addClassRules("depreciated_total", {
            gRequired: true
        });

        //==================================CLOSE BALANCE=================================
        $.validator.addMethod("gRequired", $.validator.methods.required,
            $.validator.format("Please enter vertical total"));
        $.validator.addClassRules("close_total", {
            gRequired: true
        });

        //==================================ESTIMATED=================================
        $.validator.addMethod("gRequired", $.validator.methods.required,
            $.validator.format("Please enter vertical total"));
        $.validator.addClassRules("estimated_total", {
            gRequired: true
        });

        $("#assests_value").attr('readonly', 'readonly');
        $("#assests_value").css('backgroundColor', '#DCDCDC');
    },
    descriptionTotalValidation: function(partialId) {
        var className;
        if (partialId == "beg") {
            className = "at_year_beg";
        }
        else if (partialId == "addition") {
            className = "add_during_year";
        }
        else if (partialId == "sold") {
            className = "sold_during_year";
        }
        else if (partialId == "depreciated") {
            className = "dep_during_year";
        }
        else if (partialId == "close_bal") {
            className = "closing_bal";
        }
        else if (partialId == "estimated") {
            className = "estimated_value"
        }

        var classElement = $("." + className);

        var total = 0;
        for (var i = 0; i < 5; i++) {
            var elementValue = parseInt(classElement[i].value);
            if (!isNaN(elementValue)) {
                total += elementValue;
            }
        }

        var enteredTotalValue = parseInt(classElement[5].value);
        if (!isNaN(enteredTotalValue)) {
            if (enteredTotalValue != total) {
                var totalElementId = classElement[5].id;
                alert("Entered vertical total is not equal to the calculated vertical total");
                $("#" + totalElementId).val("");
            }
        }
    //====================DESCRIPTION TABLE VALIDATION ENDS HERE================
    },
    //======NOT USING ANY MORE NEED TO REOMVE LATER======OR USE LATER=============
    formulaCheck: function(partialId, elementId) {

        var field1Id = "#" + partialId + "_beg";
        var field2Id = "#" + partialId + "_addition";
        var field3Id = "#" + partialId + "_sold";
        var field4Id = "#" + partialId + "_depreciated";

        var field1Value = parseInt($(field1Id).val());
        var field2Value = parseInt($(field2Id).val());
        var field3Value = parseInt($(field3Id).val());
        var field4Value = parseInt($(field4Id).val());

        var formula = (field1Value + field2Value) - (field3Value + field4Value);
        // alert(formula);

        var enteredTotal = parseInt($("#" + elementId).val());

        if (isNaN(enteredTotal) || (formula != enteredTotal))
        {
            alert("Entered horizontal total is not equal to the calculated horizontal total. Fields (2+3)-(4+5) value must be equal to field 6 value");
            //      alert("Field can't be left empty please enter 0 if no data is present")
            $("#" + elementId).val("");
        }
        if (formula == enteredTotal) {
            if (formula < 0) {
                alert("Net Closing Balance cannot be negative. Kindly fill correct values");
                $("#" + elementId).val("");
            }
        }
    }
}

var SecFour = {
    fieldValidation: function() {
        //====================roundOff to decimal 3 places==========================
        // jQuery.validator.addMethod("secFournRoundOff", function(value, element) {
        //     var temp = new Number(value);
        //     element.value = (temp).toFixed(2);
        //     return true;
        // }, "");

        $.validator.addMethod('survivalDecimal', function(value, element) {
            return this.optional(element) || /^\d+(\.\d{0,2})?$/.test(value);
        }, "Please enter only 2 decimal point");


        // $.validator.addMethod('survivalDecimalThree', function(value, element) {
        //     return this.optional(element) || /^\d+(\.\d{0,3})?$/.test(value);
        // }, "Please enter only 3 decimal point");

        $("#geologyPart2").validate({
            rules: {
                "RS[PROVED_BEGIN]": {
                    required: true,
                    maxlength: 12,
                    survivalDecimal: true,
                    // secFournRoundOff: true
                    number: true,
                    digits: false
                },
                "RS[PROVED_ASSESSED_DURING]": {
                    required: true,
                    maxlength: 12,
                    survivalDecimal: true,
                    number: true,
                    digits: false
                },
                "RS[PROVED_DEPLETION]": {
                    required: true,
                    maxlength: 12,
                    survivalDecimal: true,
                    number: true,
                    digits: false
                },
                "RS[PROVED_BALANCE]": {
                    required: true,
                    maxlength: 12,
                    survivalDecimal: true,
                    number: true,
                    digits: false
                },
                "RS[PROBABLE_FIRST_BEGIN]": {
                    required: true,
                    maxlength: 12,
                    survivalDecimal: true,
                    number: true,
                    digits: false
                },
                "RS[PROBABLE_FIRST_ASSESSED_DURING]": {
                    required: true,
                    maxlength: 12,
                    survivalDecimal: true,
                    number: true,
                    digits: false
                },
                "RS[PROBABLE_FIRST_DEPLETION]": {
                    required: true,
                    maxlength: 12,
                    survivalDecimal: true,
                    number: true,
                    digits: false
                },
                "RS[PROBABLE_FIRST_BALANCE]": {
                    required: true,
                    maxlength: 12,
                    survivalDecimal: true,
                    number: true,
                    digits: false
                },
                "RS[PROBABLE_SEC_BEGIN]": {
                    required: true,
                    maxlength: 12,
                    survivalDecimal: true,
                    number: true,
                    digits: false
                },
                "RS[PROBABLE_SEC_ASSESSED_DURING]": {
                    required: true,
                    maxlength: 12,
                    survivalDecimal: true,
                    number: true,
                    digits: false
                },
                "RS[PROBABLE_SEC_DEPLETION]": {
                    required: true,
                    maxlength: 12,
                    survivalDecimal: true,
                    number: true,
                    digits: false
                },
                "RS[PROBABLE_SEC_BALANCE]": {
                    required: true,
                    maxlength: 12,
                    survivalDecimal: true,
                    number: true,
                    digits: false
                },
                "RS[FEASIBILITY_BEGIN]": {
                    required: true,
                    maxlength: 12,
                    survivalDecimal: true,
                    number: true,
                    digits: false
                },
                "RS[FEASIBILITY_ASSESSED_DURING]": {
                    required: true,
                    maxlength: 12,
                    survivalDecimal: true,
                    number: true,
                    digits: false
                },
                "RS[FEASIBILITY_DEPLETION]": {
                    required: true,
                    maxlength: 12,
                    survivalDecimal: true,
                    number: true,
                    digits: false
                },
                "RS[FEASIBILITY_BALANCE]": {
                    required: true,
                    maxlength: 12,
                    survivalDecimal: true,
                    number: true,
                    digits: false
                },
                "RS[PREFEASIBILITY_FIRST_BEGIN]": {
                    required: true,
                    maxlength: 12,
                    survivalDecimal: true,
                    number: true,
                    digits: false
                },
                "RS[PREFEASIBILITY_FIRST_ASSESSED_DURING]": {
                    required: true,
                    maxlength: 12,
                    survivalDecimal: true,
                    number: true,
                    digits: false
                },
                "RS[PREFEASIBILITY_FIRST_DEPLETION]": {
                    required: true,
                    maxlength: 12,
                    survivalDecimal: true,
                    number: true,
                    digits: false
                },
                "RS[PREFEASIBILITY_FIRST_BALANCE]": {
                    required: true,
                    maxlength: 12,
                    survivalDecimal: true,
                    number: true,
                    digits: false
                },
                "RS[PREFEASIBILITY_SEC_BEGIN]": {
                    required: true,
                    maxlength: 12,
                    survivalDecimal: true,
                    number: true,
                    digits: false
                },
                "RS[PREFEASIBILITY_SEC_ASSESSED_DURING]": {
                    required: true,
                    maxlength: 12,
                    survivalDecimal: true,
                    number: true,
                    digits: false
                },
                "RS[PREFEASIBILITY_SEC_DEPLETION]": {
                    required: true,
                    maxlength: 12,
                    survivalDecimal: true,
                    number: true,
                    digits: false
                },
                "RS[PREFEASIBILITY_SEC_BALANCE]": {
                    required: true,
                    maxlength: 12,
                    survivalDecimal: true,
                    number: true,
                    digits: false
                },
                "RS[MEASURED_BEGIN]": {
                    required: true,
                    maxlength: 12,
                    survivalDecimal: true,
                    number: true,
                    digits: false
                },
                "RS[MEASURED_ASSESSED_DURING]": {
                    required: true,
                    maxlength: 12,
                    survivalDecimal: true,
                    number: true,
                    digits: false
                },
                "RS[MEASURED_SEC_DEPLETION]": {
                    required: true,
                    maxlength: 12,
                    survivalDecimal: true,
                    number: true,
                    digits: false
                },
                "RS[MEASURED_SEC_BALANCE]": {
                    required: true,
                    maxlength: 12,
                    survivalDecimal: true,
                    number: true,
                    digits: false
                },
                "RS[INDICATED_BEGIN]": {
                    required: true,
                    maxlength: 12,
                    survivalDecimal: true,
                    number: true,
                    digits: false
                },
                "RS[INDICATED_ASSESSED_DURING]": {
                    required: true,
                    maxlength: 12,
                    survivalDecimal: true,
                    number: true,
                    digits: false
                },
                "RS[INDICATED_SEC_DEPLETION]": {
                    required: true,
                    maxlength: 12,
                    survivalDecimal: true,
                    number: true,
                    digits: false
                },
                "RS[INDICATED_SEC_BALANCE]": {
                    required: true,
                    maxlength: 12,
                    survivalDecimal: true,
                    number: true,
                    digits: false
                },
                "RS[INFERRED_BEGIN]": {
                    required: true,
                    maxlength: 12,
                    survivalDecimal: true,
                    number: true,
                    digits: false
                },
                "RS[INFERRED_ASSESSED_DURING]": {
                    required: true,
                    maxlength: 12,
                    survivalDecimal: true,
                    number: true,
                    digits: false
                },
                "RS[INFERRED_SEC_DEPLETION]": {
                    required: true,
                    maxlength: 12,
                    survivalDecimal: true,
                    number: true,
                    digits: false
                },
                "RS[INFERRED_SEC_BALANCE]": {
                    required: true,
                    maxlength: 12,
                    survivalDecimal: true,
                    number: true,
                    digits: false
                },
                "RS[RECONNAISSANCE_BEGIN]": {
                    required: true,
                    maxlength: 12,
                    survivalDecimal: true,
                    number: true,
                    digits: false
                },
                "RS[RECONNAISSANCE_ASSESSED_DURING]": {
                    required: true,
                    maxlength: 12,
                    survivalDecimal: true,
                    number: true,
                    digits: false
                },
                "RS[RECONNAISSANCE_SEC_DEPLETION]": {
                    required: true,
                    maxlength: 12,
                    survivalDecimal: true,
                    number: true,
                    digits: false
                },
                "RS[RECONNAISSANCE_SEC_BALANCE]": {
                    required: true,
                    maxlength: 12,
                    survivalDecimal: true,
                    number: true,
                    digits: false
                },
                "SMR[UNPROCESSED_BEGIN]": {
                    required: true,
                    maxlength: 12,
                    number: true,
                    survivalDecimal: true
                },
                "SMR[UNPROCESSED_GENERATED]": {
                    required: true,
                    maxlength: 12,
                    number: true,
                    survivalDecimal: true
                },
                "SMR[UNPROCESSED_DISPOSED]": {
                    required: true,
                    maxlength: 12,
                    number: true,
                    survivalDecimal: true
                },
                "SMR[UNPROCESSED_TOTAL]": {
                    required: true,
                    maxlength: 12,
                    number: true,
                    survivalDecimal: true
                },
                "SMR[UNPROCESSED_AVERAGE]": {
                    required: true,
                    maxlength: 12,
                    number: true,
                    survivalDecimal: true
                },
                "SMR[PROCESSED_BEGIN]": {
                    required: true,
                    maxlength: 12,
                    number: true,
                    survivalDecimal: true
                },
                "SMR[PROCESSED_GENERATED]": {
                    required: true,
                    maxlength: 12,
                    number: true,
                    survivalDecimal: true
                },
                "SMR[PROCESSED_DISPOSED]": {
                    required: true,
                    maxlength: 12,
                    number: true,
                    survivalDecimal: true
                },
                "SMR[PROCESSED_TOTAL]": {
                    required: true,
                    maxlength: 12,
                    number: true,
                    survivalDecimal: true
                },
                "SMR[PROCESSED_AVERAGE]": {
                    required: true,
                    maxlength: 12,
                    number: true,
                    survivalDecimal: true
                }
            },
            messages: {
                "RS[PROVED_BEGIN]": {
                    required: "Please enter data",
                    maxlength: "Max. length allowed is 12",
                    number: "Please enter numeric digits only",
                    digits: "Decimal places are not allowed"
                },
                "RS[PROVED_ASSESSED_DURING]": {
                    required: "Please enter data",
                    maxlength: "Max. length allowed is 12",
                    number: "Please enter numeric digits only",
                    digits: "Decimal places are not allowed"
                },
                "RS[PROVED_DEPLETION]": {
                    required: "Please enter data",
                    maxlength: "Max. length allowed is 12",
                    number: "Please enter numeric digits only",
                    digits: "Decimal places are not allowed"
                },
                "RS[PROVED_BALANCE]": {
                    required: "Please enter data",
                    maxlength: "Max. length allowed is 12",
                    number: "Please enter numeric digits only",
                    digits: "Decimal places are not allowed"
                },
                "RS[PROBABLE_FIRST_BEGIN]": {
                    required: "Please enter data",
                    maxlength: "Max. length allowed is 12",
                    number: "Please enter numeric digits only",
                    digits: "Decimal places are not allowed"
                },
                "RS[PROBABLE_FIRST_ASSESSED_DURING]": {
                    required: "Please enter data",
                    maxlength: "Max. length allowed is 12",
                    number: "Please enter numeric digits only",
                    digits: "Decimal places are not allowed"
                },
                "RS[PROBABLE_FIRST_DEPLETION]": {
                    required: "Please enter data",
                    maxlength: "Max. length allowed is 12",
                    number: "Please enter numeric digits only",
                    digits: "Decimal places are not allowed"
                },
                "RS[PROBABLE_FIRST_BALANCE]": {
                    required: "Please enter data",
                    maxlength: "Max. length allowed is 12",
                    number: "Please enter numeric digits only",
                    digits: "Decimal places are not allowed"
                },
                "RS[PROBABLE_SEC_BEGIN]": {
                    required: "Please enter data",
                    maxlength: "Max. length allowed is 12",
                    number: "Please enter numeric digits only",
                    digits: "Decimal places are not allowed"
                },
                "RS[PROBABLE_SEC_ASSESSED_DURING]": {
                    required: "Please enter data",
                    maxlength: "Max. length allowed is 12",
                    number: "Please enter numeric digits only",
                    digits: "Decimal places are not allowed"
                },
                "RS[PROBABLE_SEC_DEPLETION]": {
                    required: "Please enter data",
                    maxlength: "Max. length allowed is 12",
                    number: "Please enter numeric digits only",
                    digits: "Decimal places are not allowed"
                },
                "RS[PROBABLE_SEC_BALANCE]": {
                    required: "Please enter data",
                    maxlength: "Max. length allowed is 12",
                    number: "Please enter numeric digits only",
                    digits: "Decimal places are not allowed"
                },
                "RS[FEASIBILITY_BEGIN]": {
                    required: "Please enter data",
                    maxlength: "Max. length allowed is 12",
                    number: "Please enter numeric digits only",
                    digits: "Decimal places are not allowed"
                },
                "RS[FEASIBILITY_ASSESSED_DURING]": {
                    required: "Please enter data",
                    maxlength: "Max. length allowed is 12",
                    number: "Please enter numeric digits only",
                    digits: "Decimal places are not allowed"
                },
                "RS[FEASIBILITY_DEPLETION]": {
                    required: "Please enter data",
                    maxlength: "Max. length allowed is 12",
                    number: "Please enter numeric digits only",
                    digits: "Decimal places are not allowed"
                },
                "RS[FEASIBILITY_BALANCE]": {
                    required: "Please enter data",
                    maxlength: "Max. length allowed is 12",
                    number: "Please enter numeric digits only",
                    digits: "Decimal places are not allowed"
                },
                "RS[PREFEASIBILITY_FIRST_BEGIN]": {
                    required: "Please enter data",
                    maxlength: "Max. length allowed is 12",
                    number: "Please enter numeric digits only",
                    digits: "Decimal places are not allowed"
                },
                "RS[PREFEASIBILITY_FIRST_ASSESSED_DURING]": {
                    required: "Please enter data",
                    maxlength: "Max. length allowed is 12",
                    number: "Please enter numeric digits only",
                    digits: "Decimal places are not allowed"
                },
                "RS[PREFEASIBILITY_FIRST_DEPLETION]": {
                    required: "Please enter data",
                    maxlength: "Max. length allowed is 12",
                    number: "Please enter numeric digits only",
                    digits: "Decimal places are not allowed"
                },
                "RS[PREFEASIBILITY_FIRST_BALANCE]": {
                    required: "Please enter data",
                    maxlength: "Max. length allowed is 12",
                    number: "Please enter numeric digits only",
                    digits: "Decimal places are not allowed"
                },
                "RS[PREFEASIBILITY_SEC_BEGIN]": {
                    required: "Please enter data",
                    maxlength: "Max. length allowed is 12",
                    number: "Please enter numeric digits only",
                    digits: "Decimal places are not allowed"
                },
                "RS[PREFEASIBILITY_SEC_ASSESSED_DURING]": {
                    required: "Please enter data",
                    maxlength: "Max. length allowed is 12",
                    number: "Please enter numeric digits only",
                    digits: "Decimal places are not allowed"
                },
                "RS[PREFEASIBILITY_SEC_DEPLETION]": {
                    required: "Please enter data",
                    maxlength: "Max. length allowed is 12",
                    number: "Please enter numeric digits only",
                    digits: "Decimal places are not allowed"
                },
                "RS[PREFEASIBILITY_SEC_BALANCE]": {
                    required: "Please enter data",
                    maxlength: "Max. length allowed is 12",
                    number: "Please enter numeric digits only",
                    digits: "Decimal places are not allowed"
                },
                "RS[MEASURED_BEGIN]": {
                    required: "Please enter data",
                    maxlength: "Max. length allowed is 12",
                    number: "Please enter numeric digits only",
                    digits: "Decimal places are not allowed"
                },
                "RS[MEASURED_ASSESSED_DURING]": {
                    required: "Please enter data",
                    maxlength: "Max. length allowed is 12",
                    number: "Please enter numeric digits only",
                    digits: "Decimal places are not allowed"
                },
                "RS[MEASURED_SEC_DEPLETION]": {
                    required: "Please enter data",
                    maxlength: "Max. length allowed is 12",
                    number: "Please enter numeric digits only",
                    digits: "Decimal places are not allowed"
                },
                "RS[MEASURED_SEC_BALANCE]": {
                    required: "Please enter data",
                    maxlength: "Max. length allowed is 12",
                    number: "Please enter numeric digits only",
                    digits: "Decimal places are not allowed"
                },
                "RS[INDICATED_BEGIN]": {
                    required: "Please enter data",
                    maxlength: "Max. length allowed is 12",
                    number: "Please enter numeric digits only",
                    digits: "Decimal places are not allowed"
                },
                "RS[INDICATED_ASSESSED_DURING]": {
                    required: "Please enter data",
                    maxlength: "Max. length allowed is 12",
                    number: "Please enter numeric digits only",
                    digits: "Decimal places are not allowed"
                },
                "RS[INDICATED_SEC_DEPLETION]": {
                    required: "Please enter data",
                    maxlength: "Max. length allowed is 12",
                    number: "Please enter numeric digits only",
                    digits: "Decimal places are not allowed"
                },
                "RS[INDICATED_SEC_BALANCE]": {
                    required: "Please enter data",
                    maxlength: "Max. length allowed is 12",
                    number: "Please enter numeric digits only",
                    digits: "Decimal places are not allowed"
                },
                "RS[INFERRED_BEGIN]": {
                    required: "Please enter data",
                    maxlength: "Max. length allowed is 12",
                    number: "Please enter numeric digits only",
                    digits: "Decimal places are not allowed"
                },
                "RS[INFERRED_ASSESSED_DURING]": {
                    required: "Please enter data",
                    maxlength: "Max. length allowed is 12",
                    number: "Please enter numeric digits only",
                    digits: "Decimal places are not allowed"
                },
                "RS[INFERRED_SEC_DEPLETION]": {
                    required: "Please enter data",
                    maxlength: "Max. length allowed is 12",
                    number: "Please enter numeric digits only",
                    digits: "Decimal places are not allowed"
                },
                "RS[INFERRED_SEC_BALANCE]": {
                    required: "Please enter data",
                    maxlength: "Max. length allowed is 12",
                    number: "Please enter numeric digits only",
                    digits: "Decimal places are not allowed"
                },
                "RS[RECONNAISSANCE_BEGIN]": {
                    required: "Please enter data",
                    maxlength: "Max. length allowed is 12",
                    number: "Please enter numeric digits only",
                    digits: "Decimal places are not allowed"
                },
                "RS[RECONNAISSANCE_ASSESSED_DURING]": {
                    required: "Please enter data",
                    maxlength: "Max. length allowed is 12",
                    number: "Please enter numeric digits only",
                    digits: "Decimal places are not allowed"
                },
                "RS[RECONNAISSANCE_SEC_DEPLETION]": {
                    required: "Please enter data",
                    maxlength: "Max. length allowed is 12",
                    number: "Please enter numeric digits only",
                    digits: "Decimal places are not allowed"
                },
                "RS[RECONNAISSANCE_SEC_BALANCE]": {
                    required: "Please enter data",
                    maxlength: "Max. length allowed is 12",
                    number: "Please enter numeric digits only",
                    digits: "Decimal places are not allowed"
                },
                "SMR[UNPROCESSED_BEGIN]": {
                    required: "Please enter data",
                    maxlength: "Max. length allowed is 12",
                    number: "Please enter numeric digits only",
                    survivalDecimal: 'Decimal upto 2 digits allowed'
                },
                "SMR[UNPROCESSED_GENERATED]": {
                    required: "Please enter data",
                    maxlength: "Max. length allowed is 12",
                    number: "Please enter numeric digits only",
                    survivalDecimal: 'Decimal upto 2 digits allowed'
                },
                "SMR[UNPROCESSED_DISPOSED]": {
                    required: "Please enter data",
                    maxlength: "Max. length allowed is 12",
                    number: "Please enter numeric digits only",
                    survivalDecimal: 'Decimal upto 2 digits allowed'
                },
                "SMR[UNPROCESSED_TOTAL]": {
                    required: "Please enter data",
                    maxlength: "Max. length allowed is 12",
                    number: "Please enter numeric digits only",
                    survivalDecimal: 'Decimal upto 2 digits allowed'
                },
                "SMR[UNPROCESSED_AVERAGE]": {
                    required: "Please enter data",
                    maxlength: "Max. length allowed is 12",
                    number: "Please enter numeric digits only",
                    survivalDecimal: 'Decimal upto 2 digits allowed'
                },
                "SMR[PROCESSED_BEGIN]": {
                    required: "Please enter data",
                    maxlength: "Max. length allowed is 12",
                    number: "Please enter numeric digits only",
                    survivalDecimal: 'Decimal upto 2 digits allowed'
                },
                "SMR[PROCESSED_GENERATED]": {
                    required: "Please enter data",
                    maxlength: "Max. length allowed is 12",
                    number: "Please enter numeric digits only",
                    survivalDecimal: 'Decimal upto 2 digits allowed'
                },
                "SMR[PROCESSED_DISPOSED]": {
                    required: "Please enter data",
                    maxlength: "Max. length allowed is 12",
                    number: "Please enter numeric digits only",
                    survivalDecimal: 'Decimal upto 2 digits allowed'
                },
                "SMR[PROCESSED_TOTAL]": {
                    required: "Please enter data",
                    maxlength: "Max. length allowed is 12",
                    number: "Please enter numeric digits only",
                    survivalDecimal: 'Decimal upto 2 digits allowed'
                },
                "SMR[PROCESSED_AVERAGE]": {
                    required: "Please enter data",
                    maxlength: "Max. length allowed is 12",
                    number: "Please enter numeric digits only",
                    survivalDecimal: 'Decimal upto 2 digits allowed'
                }
            }
        });

        $.validator.addMethod("aMaxlength", $.validator.methods.maxlength,
            $.validator.format("Max. length allowed is {0} digits"));
        $.validator.addMethod("aNumber", $.validator.methods.number,
            $.validator.format("Please enter numeric digits only"));
        $.validator.addMethod("aDigits", $.validator.methods.digits,
            $.validator.format("Decimal numbers are not allowed"));

        $.validator.addClassRules("exploration", {
            aMaxlength: 10,
            aNumber: true,
            survivalDecimal: true
        });

        $.validator.addClassRules("exploration-number", {
            aMaxlength: 10,
            aNumber: true,
            digits: true
        });

        //====================VALIDATING FIELD WITH LENGTH 15 DIGITS================

        $.validator.addMethod("bMaxlength", $.validator.methods.maxlength,
            $.validator.format("Max. length allowed is {0} digits"));
        $.validator.addMethod("bNumber", $.validator.methods.number,
            $.validator.format("Please enter numeric digits only"));
        $.validator.addMethod("bDigits", $.validator.methods.digits,
            $.validator.format("Decimal digits are not allowed"));
        $.validator.addClassRules("big_length", {
            bMaxlength: 15,
            bNumber: true,
            bDigits: true
        });

        //====================VALIDATING FIELD WITH LENGTH 5 DIGITS================

        $.validator.addMethod("cMaxlength", $.validator.methods.maxlength,
            $.validator.format("Max. length allowed is {0} digits"));
        $.validator.addMethod("cNumber", $.validator.methods.number,
            $.validator.format("Please enter numeric digits only"));
        $.validator.addMethod("cDigits", $.validator.methods.digits,
            $.validator.format("Decimal digits are not allowed"));
        $.validator.addMethod("cMax", $.validator.methods.max,
            $.validator.format("Max. value allowed is {0}"));
        $.validator.addClassRules("under_field_five", {
            cMaxlength: 5,
            cNumber: true,
            cDigits: true,
            cMax: 99999
        });

        //====================VALIDATING FIELD WITH LENGTH 9 DIGITS================
        $.validator.addMethod("dMaxlength", $.validator.methods.maxlength,
            $.validator.format("Max. length allowed is {0} digits"));
        $.validator.addMethod("dNumber", $.validator.methods.number,
            $.validator.format("Please enter numeric digits only"));
        $.validator.addMethod("dDigits", $.validator.methods.digits,
            $.validator.format("Decimal digits are not allowed"));
        $.validator.addMethod("dMax", $.validator.methods.max,
            $.validator.format("Max. value allowed is {0}"));
        $.validator.addClassRules("under_field_nine", {
            dMaxlength: 9,
            dNumber: true,
            dDigits: true,
            dMax: 999999999
        });
        //====================VALIDATING BENCH NUMBER WITH 5 DIGITS=================
        $.validator.addMethod("eRequired", $.validator.methods.required,
            $.validator.format("Field is required"));

        $.validator.addMethod("hRequired", $.validator.methods.required,
            $.validator.format("Field is required"));
        $.validator.addMethod("sRequired", $.validator.methods.required,
            $.validator.format("Field is required"));

        $.validator.addClassRules("bench_no_ore_input", {
            eRequired: true
        });

        $.validator.addClassRules("bench_no_waste_input", {
            hRequired: true
        });
        $.validator.addClassRules("bench_no_ore_select", {
            sRequired: true
        });
        $.validator.addClassRules("avg_height_ore_select", {
            sRequired: true
        });

        $.validator.addClassRules("avg_height_ore_input", {
            eRequired: true
        });
        $.validator.addClassRules("avg_height_waste_input", {
            hRequired: true
        });
        $.validator.addClassRules("deepest_working_ore_select", {
            sRequired: true
        });

        $.validator.addClassRules("deepest_working_ore_input", {
            eRequired: true
        });
        $.validator.addClassRules("deepest_working_waste_input", {
            hRequired: true
        });

    }
}


var SecGreatThenFour = {
    fieldVaidation: function() {
        $("#GeologyPart3").validate({
            onkeyup: false,
            ignoreTitle: true,
            onsubmit: true,
            rules: {
                FUTURE_PLAN: {
                    maxlength: 1000
                }
            },
            messages: {
                FUTURE_PLAN: {
                    maxlength: "Max. length allowed is {0}"
                }
            }
        });

        // jQuery.validator.addMethod("machineryCheck", function(value, element) {
        //     var directArray = new Array();
        //     directArray = $(".direct");
        //     var directTotal = 0;
        //     for (var i = 0; i < directArray.length; i++) {
        //         var directElement = parseInt(directArray[i].value);
        //         if (!isNaN(directElement)) {
        //             directTotal += parseInt(directArray[i].value);
        //         }
        //     }
        //     if (value != directTotal) {
        //         alert("Calculated total varies from entered total");
        //         $("#TOTAL_DIRECT").val("");
        //     }
        //     return true
        // });

        //==========================CAPACITY BOX VALIDATION=========================
        $.validator.addMethod("aRequired", $.validator.methods.required,
            $.validator.format("Please enter quantity"));
        $.validator.addMethod("aMaxlength", $.validator.methods.maxlength,
            $.validator.format("Max. length allowed is {0} digits including decimals"));
        $.validator.addMethod("aNumber", $.validator.methods.number,
            $.validator.format("Please enter numeric digits only"));
        $.validator.addMethod("aMax", $.validator.methods.max,
            $.validator.format("Max. value allowed can be 6,3 digits long"));
        $.validator.addMethod("roundOffThree", function(value, element) {
            //      var temp = new Number (value);
            if (value > 0) {
                element.value = Utilities.roundOff3(value);
            }
            //      else{
            //        element.value = "";
            //      }
            return true;
        }, "");

        //    jQuery.validator.addMethod("checkCapacity", function(value, element){
        //      var machineId = element.id;
        //      var splittedId = machineId.split('_');
        //      var token = splittedId[2];
        //      var capacityId  = 'capacity_box_'+token;
        //      var capacityVal = $('#'+capacityId).val();
        //      if(capacityVal == '' && value!= '') {
        //        alert('Please enter capacity for selected machinery type');
        //      }
        //      return true;
        //    },'');


        $.validator.addClassRules("capacity_box", {
            "aRequired": true,
            "aMaxlength": 10,
            "aNumber": true,
            "aMax": 999999.999,
            "roundOffThree": true,
        });

        //    $.validator.addClassRules("machine_select",{
        //      checkCapacity:true
        //    });

        //============================UNIT BOX VALIDATION===========================
        $.validator.addMethod("bRequired", $.validator.methods.required,
            $.validator.format("Please enter unit"));
        $.validator.addMethod("bMaxlength", $.validator.methods.maxlength,
            $.validator.format("Max. length allowed is {0} digits"));
        $.validator.addMethod("bNumber", $.validator.methods.number,
            $.validator.format("Please enter numeric digits only"));
        $.validator.addMethod("bDigits", $.validator.methods.digits,
            $.validator.format("Decimal digits are not allowed"));

        $.validator.addClassRules("unit_box", {
            "bRequired": true,
            "bMaxlength": 4,
            "bNumber": true,
            "bDigits": true
        });

        //=========================ALL TEXT AREA VALIDATION=========================
        $.validator.addMethod("cMaxlength", $.validator.methods.maxlength,
            $.validator.format("Max. length allowed is {0} characters"));

        $.validator.addClassRules("text_area", {
            "cMaxlength": 1000
        });

        //=========================TONNAGE FIELD VALIDATION=========================
        $.validator.addMethod("dMaxlength", $.validator.methods.maxlength,
            $.validator.format("Max. length allowed is {0} characters"));
        $.validator.addMethod("dNumber", $.validator.methods.number,
            $.validator.format("Please enter numeric digits only"));
        $.validator.addMethod("dDigits", $.validator.methods.digits,
            $.validator.format("Decimals digits are not allowed"));

        $.validator.addClassRules("feed_tonnage", {
            "dMaxlength": 10,
            "dNumber": true,
            "dDigits": true
        });

        //=========================AVERAGE GRADE VALIDATION=========================
        $.validator.addMethod("eMaxlength", $.validator.methods.maxlength,
            $.validator.format("Max. length allowed is {0} characters"));

        $.validator.addClassRules("feed_avg_grade", {
            "eMaxlength": 100
        });

        $.validator.addMethod("fRequired", $.validator.methods.required,
            $.validator.format("Please select a option"));
        //        $.validator.addClassRules("unit_box", {
        //            required: {
        //                depends: function(event){
        //                 console.log($(this).id)
        //                 console.log($(this).val())
        //                 event.preventDefault();
        //                }
        //            }
        //        });
        $.validator.addClassRules("selectbox-small", {
            "fRequired": true
        });

    },
    textAlert: function() {
        $('.min_treatment').blur(function() {
            alert('Brief particulars to be mentioned, flow sheet and material balance to be submitted to the Regional Office of IBM');
        });

        $('#FURNISH_SURFACE').blur(function() {
            alert('Brief particulars to be mentioned. Surface and/or underground plans and sections as prepared and brought up to date (as required under rule 28 of MCDR)  to be submitted to the Regional Office of IBM');
        });
    },
    // postValidation: function() {
    //     $("#GeologyPart3").submit(function(event) {
    //         var selectBoxes = $(".machine_select");
    //         var selectCount = selectBoxes.length;
    //         var selectEmptyCount = 0;
    //         for (var i = 0; i < selectCount; i++) {
    //             var selectValue = selectBoxes[i].value;
    //             if (selectValue == "") {
    //                 selectEmptyCount = 1;
    //             }
    //         }

    //         // NOT IN USE RIGHT NOW BUT CAN BE USE LATER ... -----UDAY
    //         var capacityBoxes = $(".capacity_box");
    //         var capacityCount = capacityBoxes.length;
    //         var capacityEmptyCount = 0;
    //         for (var j = 0; j < capacityCount; j++) {
    //             var capacityValue = capacityBoxes[j].value;
    //             if (capacityValue == "") {
    //                 capacityEmptyCount = 1;
    //             }
    //         }
    //         if (selectEmptyCount == 1) {
    //             alert("Please select the Machinery Type");
    //             event.preventDefault();
    //         }
    //         else if (capacityEmptyCount == 1) {
    //             alert("Please select the Capacity for selected Machinery Type");
    //             event.preventDefault();

    //         }
    //     });
    // }
}

var GeologyPart4 = {
    fieldValidation: function() {
        $("#frmGeologyPart4").validate({
            onsubmit: false
        });

        $.validator.addMethod('aMaxlength', $.validator.methods.maxlength,
            $.validator.format("Max. length allowed is {0} digits"));
        $.validator.addMethod('aNumber', $.validator.methods.number,
            $.validator.format("Please enter numeric digits only"));
        $.validator.addMethod('aDigits', $.validator.methods.digits,
            $.validator.format("Decimal digits are not allowed"));
        $.validator.addClassRules("checkqty", {
            aMaxlength: 15,
            aNumber: true,
            aDigits: true,
            checkGrade: true
        });

        $.validator.addMethod("checkGrade", function(value, element) {
            var elementId = element.id;
            var QtyId = elementId.replace('grade', 'qty');

            var qtyVal = $("#" + QtyId).val();
            var selectVal = $("#" + elementId).val();
            if ((qtyVal == "" || qtyVal == 0) && selectVal != "") {
                //alert("Please enter quantity for selected grade");
                $("#" + QtyId + "_error").remove();
                $("#" + QtyId).after('<div id="' + QtyId + '_error" style="color:red;">Please enter quantity for selected grade</div>');
            }
            else {
                $("#" + QtyId + "_error").remove();
            }
            if ((qtyVal != "" && qtyVal != 0) && selectVal == "") {
                //alert("Please select the grade for the quantity");
                $("#" + elementId + "_error").remove();
                $("#" + elementId).after('<div id="' + elementId + '_error" style="color:red;">Please select the grade for the quantity</div>');

            }
            else {
                $("#" + elementId + "_error").remove();
            }

            if ((qtyVal != "" && qtyVal != 0) && selectVal != "") {
                $("#" + QtyId + "_error").remove();
                $("#" + elementId + "_error").remove();
            }
        }, ""
        );

        $.validator.addClassRules("min_qty", {
            checkGrade: true
        });

    }
}

var H1MineralRejectsValidation = {
    fieldValidation: function() {
        $("#mineralRejects").validate({
            onsubmit: false,
            rules: {
                OC_GRADE: {
                    maxlength: 100
                },
                UG_GRADE: {
                    maxlength: 100
                }
            }
        });

        $.validator.addMethod("aMaxlength", $.validator.methods.maxlength,
            $.validator.format("Max. length allowed is {0} digits"));
        $.validator.addMethod("aNumber", $.validator.methods.number,
            $.validator.format("Please enter numeric digits only"));
        $.validator.addMethod("aDigits", $.validator.methods.digits,
            $.validator.format("Decimal digits are not allowed"));
        $.validator.addClassRules("big_length", {
            aMaxlength: 15,
            aNumber: true,
            aDigits: true
        });
    }
}
var GeologyPart1 = {
    fieldValidation: function() {
        $.validator.addMethod('ore-box', function(value) {
            return $('.ore-box:checked').size() > 0;
        }, 'Please check at least one type of ore.');

        var checkboxes = $('.ore-box');
        var checkbox_names = $.map(checkboxes, function(e, i) {
            return $(e).attr("name")
        }).join(" ");

        $("#frmGeologyPart1").validate({
            //onsubmit: false
            rules: {
                other_ore_type_text: {
                    maxlength: 50
                }
            },
            messages: {
                other_ore_type_text: {
                    maxlength: "Maximum length allowed is {0} characters"
                }
            },
            groups: {
                checks: checkbox_names
            },
            errorPlacement: function(error, element) {
                if (element.attr("type") == "checkbox")
                    error.insertAfter($('#other_ore_type_text'));
                else
                    error.insertAfter(element);
            }

        });
        $.validator.addMethod('selectRequired', $.validator.methods.required,
            $.validator.format("Please select the selectbox."));

        $.validator.addMethod('gradeRequired', $.validator.methods.required,
            $.validator.format("Please enter the grade."));

        $.validator.addClassRules("size_range_mine_select", {
            selectRequired: true
        });

        $.validator.addClassRules("principal_const_mine_select", {
            selectRequired: true
        });

        $.validator.addClassRules("subs_const_mine_select", {
            selectRequired: true
        });

        $.validator.addMethod("gradeMax", $.validator.methods.max,
            $.validator.format("Max. value allowed can be 99.99"));
        $.validator.addMethod('gradeNumber', $.validator.methods.number,
            $.validator.format("Please enter numeric digits only"));
        $.validator.addMethod("gradeMaxlength", $.validator.methods.maxlength,
            $.validator.format("Max. length allowed is {0} characters"));

        jQuery.validator.addMethod("gradeDecimalCheck", function(value, element) {
            return this.optional(element) || (/^[0-9,]+(\.\d{0,2})?$/).test(value);
        }, "Please enter number only to 2 decimal places");

        $.validator.addClassRules("size_mine_grade", {
            gradeRequired: true,
            gradeMax: 99.99,
            gradeNumber: true,
            gradeDecimalCheck: true,
            gradeMaxlength: 5
        });

        $.validator.addClassRules("principal_mine_grade", {
            gradeRequired: true,
            gradeMax: 99.99,
            gradeNumber: true,
            gradeDecimalCheck: true,
            gradeMaxlength: 5
        });

        $.validator.addClassRules("subs_mine_grade", {
            gradeRequired: true,
            gradeMax: 99.99,
            gradeNumber: true,
            gradeDecimalCheck: true,
            gradeMaxlength: 5
        });

        $.validator.addClassRules("grade_per_select", {
            selectRequired: true
        });

        $.validator.addClassRules("mine_grade_percent", {
            gradeRequired: true,
            gradeMax: 99.99,
            gradeNumber: true,
            gradeDecimalCheck: true,
            gradeMaxlength: 5
        });

        $.validator.addMethod('geoRequired', $.validator.methods.required,
            $.validator.format("Please enter the value."));

        $.validator.addClassRules("rock_name_text", {
            geoRequired: true,
            gradeMaxlength: 200
        });

        $.validator.addClassRules("min_excavated_text", {
            geoRequired: true,
            gradeMaxlength: 200
        });

        $.validator.addClassRules("const_analysis_text", {
            geoRequired: true,
            gradeMaxlength: 200
        });
    }
}

var EmploymentWagesPart2 = {
    fieldValidation: function() {

        $("#employmentWagesPart2").validate({
            onkeyup: false,
            rules: {
                WORKING_BELOW_DATE: {
                    date: false
                },
                WORKING_ALL_DATE: {
                    date: false
                },
                WORKING_BELOW_PER: {
                    max: 9999,
                    maxlength: 4,
                    number: true,
                    digits: true
                },
                WORKING_ALL_PER: {
                    max: 9999,
                    maxlength: 4,
                    number: true,
                    digits: true
                },
                TOTAL_SALARY: {
                    number: true,
                    wagesDecimal: true,
                    max: 999999999999.99
                }
            },
            messages: {
                WORKING_BELOW_DATE: {
                    date: ""
                },
                WORKING_ALL_DATE: {
                    date: ""
                },
                WORKING_BELOW_PER: {
                    maxlength: "Max. length allowed is {0} digits",
                    max: "Max. value allowed is {0}",
                    number: "Please enter numeric digits only",
                    digits: "Decimal digits are not allowed"
                },
                WORKING_ALL_PER: {
                    maxlength: "Max. length allowed is {0} digits",
                    max: "Max. value allowed is {0}",
                    number: "Please enter numeric digits only",
                    digits: "Decimal digits are not allowed"
                },
                TOTAL_SALARY: {
                    max: "Max. value allowed can be 12,2 long",
                    number: "Please enter numeric digits only"
                }
            }
        });

        $.validator.addMethod("calHoriSum", function(value, element) {

            if (!isNaN(parseInt(value))) {

                var elementId = element.id;
                var splittedId = elementId.split("_");
                var idArrayLength = splittedId.length;

                if (idArrayLength == 4) {
                    var idPart1 = splittedId['0'];
                    var idPart2 = splittedId['1'];
                    var field1Id;
                    var field2Id;
                    field1Id = "#" + idPart1 + "_" + idPart2 + "_" + "DIRECT";
                    field2Id = "#" + idPart1 + "_" + idPart2 + "_" + "CONTRACT";
                }
                else if (idArrayLength == 2) {
                    var totalIdPart1 = splittedId['0'];
                    field1Id = "#" + totalIdPart1 + "_" + "DIRECT";
                    field2Id = "#" + totalIdPart1 + "_" + "CONTRACT";
                }

                var element1Val = parseFloat($(field1Id).val());
                var element2Val = parseFloat($(field2Id).val());

                if (!isNaN(element1Val) && !isNaN(element2Val)) {
                    var fieldTotal = element1Val + element2Val;
                    if (value != fieldTotal) {
                        alert("Calculated total varies from entered total");
                        element.value = "";
                    }
                }
                else {
                    alert("Please fill the direct and contract value first");
                    element.value = "";
                }
            }
            return true;
        },
        ""
        );

        /*$.validator.addClassRules("sum", {
         dMaxlength: 9,
         dNumber: true,
         dDigits: true,
         dMax: 999999999,
         calHoriSum: true
         });*/

        $(".sum").attr('readonly', 'readonly');
        $(".sum").css('backgroundColor', '#dcdcdc');

        //========================DAYS WORKED IN YEAR VALIDATION====================

        $.validator.addMethod("eMaxlength", $.validator.methods.maxlength,
            $.validator.format("Max. length allowed is {0} digits"));
        $.validator.addMethod("eNumber", $.validator.methods.number,
            $.validator.format("Please enter numeric digits only"));
        $.validator.addMethod("eDigits", $.validator.methods.digits,
            $.validator.format("Decimal digits are not allowed"));
        $.validator.addMethod("eMax", $.validator.methods.max,
            $.validator.format("Max. value allowed is {0}"));
        //code added by shalini to check leap year date: 13/01/2022
         var endDate = $('#end_date').val();
         var eDate = endDate.split('-');
         var eYY = eDate[0];
         var max_days = 365;
         if( (eYY % 4 == 0 ) && (eYY % 100 != 0 ) )
         {
            max_days = 366;
         }//end
        $.validator.addClassRules("days", {
            eMaxlength: 3,
            eMax: max_days,
            eNumber: true,
            eDigits: true
        });

        //==============================WAGES VALIDATION============================
        $.validator.addMethod("fMaxlength", $.validator.methods.maxlength,
            $.validator.format("Max. length allowed is {0} including decimal"));
        $.validator.addMethod("fNumber", $.validator.methods.number,
            $.validator.format("Please enter numeric digits only"));
        $.validator.addMethod("fMax", $.validator.methods.max,
            $.validator.format("Max. value allowed is 12,2 digits long"));

        $.validator.addMethod("fTotalWages", function(value, element) {
            var elementId = element.id;
            var splittedId = elementId.split('_');
            var alertMsg = '';
            if (splittedId[0] == 'BELOW') {
                if (splittedId[1] == 'FOREMAN') {
                    alertMsg = 'for Below Ground ';
                } else if (splittedId[1] == 'FACE') {
                    alertMsg = 'for Below Ground Face workers and loaders';
                } else if (splittedId[1] == 'OTHER') {
                    alertMsg = 'for Below Ground Others';
                }
            }
            if (splittedId[0] == 'OC') {
                if (splittedId[1] == 'FOREMAN') {
                    alertMsg = 'for Opencast Workings ';
                } else if (splittedId[1] == 'FACE') {
                    alertMsg = 'for Opencast Workings Face workers and loaders';
                } else if (splittedId[1] == 'OTHER') {
                    alertMsg = 'for Opencast Workings Others';
                }
            }
            if (splittedId[0] == 'ABOVE') {
                if (splittedId[1] == 'CLERICAL') {
                    alertMsg = 'for Above Ground ';
                } else if (splittedId[1] == 'ATTACHED') {
                    alertMsg = 'for Above Ground Workers in any Attached factory,Workshop or mineral dressing plant';
                } else if (splittedId[1] == 'OTHER') {
                    alertMsg = 'for Above Ground Others';
                }
            }

            var manTotalId = '#' + splittedId[0] + '_' + splittedId[1] + '_MAN_TOT';
            var manTotalVal = $(manTotalId).val();
            //            alert(value + "==" + manTotalVal);
            /**
             * ADDED TO SHOW THE ERROR STRING IF THE WAGES ENTER IS 0
             * @author Uday Shankar Singh<usigh@ubicsindia.com, udayshankar1306@gmail.com>
             * @version 30th Jan 2014
             * 
             **/
            if(value == 0 && manTotalVal !=0){
                var wagesZeroString = alertMsg + " total Wages/Salary bills for the year can't be zero, as Total number of man days worked during the year is greater then 0";
                alert(wagesZeroString);
                return true;
            }
            if (value != 0 && manTotalVal != 0) {
                //                alert(value+'-'+manTotalVal);
                var wagesVal = parseFloat(value) / parseFloat(manTotalVal);

                if (wagesVal < 50) {
                    alert('Average daily wage or salary < Rs 50 ' + alertMsg);
                }
                if (wagesVal > 2000) {

                    alert('Average daily wage or salary > Rs 2000 ' + alertMsg);
                }
            }
            else {
                // @author: Uday Shankar Singh <usingh@ubicsindia.com, udayshankar1306@gmail.com>
                // 
                // ADDED ON 12th Nov 2013 --- FOR HANDLING THE VALUE IN WAGES 
                // WHEN TOTAL NUMBER OF MAN DAYS WORKED IS 0 AND USER ENTER WAGES MORE THAN 0
                // SO SETTING WAGES TO 0.00 AS SOON AS USER ENTER VALUE GREATER THAN 0 IN THIS CASE
                $("#" + elementId).val("0.00");
            }
            return true;
        });

        $.validator.addClassRules("wages", {
            fMaxlength: 15,
            fNumber: true,
            fMax: 999999999999.99,
            fTotalWages: true
        });

        //===========================TOTAL WAGES VALIDATION=========================
        $.validator.addMethod("gMaxlength", $.validator.methods.maxlength,
            $.validator.format("Max. length allowed is {0} including decimal"));
        $.validator.addMethod("gNumber", $.validator.methods.number,
            $.validator.format("Please enter numeric digits only"));
        $.validator.addMethod("gMax", $.validator.methods.max,
            $.validator.format("Max. value allowed is 12,2 digits long"));

        $.validator.addClassRules("tot-wages", {
            gMaxlength: 15,
            gNumber: true,
            gMax: 999999999999.99
        });

        //=====================DIRECT VERTICAL TOTAL VALIDATION=====================
        jQuery.validator.addMethod("directVerticalTotal", function(value, element) {
            var directArray = new Array();
            directArray = $(".direct");
            var directTotal = 0;
            for (var i = 0; i < directArray.length; i++) {
                var directElement = parseInt(directArray[i].value);
                if (!isNaN(directElement)) {
                    directTotal += parseInt(directArray[i].value);
                }
            }
            if (value != directTotal) {
                alert("Calculated total varies from entered total");
                $("#TOTAL_DIRECT").val("");
            }
            return true
        });

        //    $("#TOTAL_DIRECT").rules("add", {
        //      maxlength: 9,
        //      number: true,
        //      digits: true,
        //      max: 999999999,
        //      directVerticalTotal: true,
        //      messages: {
        //        //        required: "Field is required",
        //        maxlength: "Max. length allowed is 9 digits",
        //        number: "Plese enter numeric digits only",
        //        max: "Max. value allowed can be 9 digits long",
        //        digits: "Decimal digits are not allowed"
        //      }
        //    });

        //===================CONTRACT VERTICAL TOTAL VALIDATION=====================
        jQuery.validator.addMethod("contractVerticalTotal", function(value, element) {
            var directArray = new Array();
            directArray = $(".contract");
            var directTotal = 0;
            for (var i = 0; i < directArray.length; i++) {
                var directElement = parseInt(directArray[i].value);
                if (!isNaN(directElement)) {
                    directTotal += parseInt(directArray[i].value);
                }
            }
            if (value != directTotal) {
                alert("Calculated total varies from entered total");
                $("#TOTAL_CONTRACT").val("");
            }
            return true
        });

        /*$("#TOTAL_CONTRACT").rules("add", {
         maxlength: 9,
         number: true,
         digits: true,
         max: 999999999,
         contractVerticalTotal: true,
         messages: {
         //        required: "Field is required",
         maxlength: "Max. length allowed is 9 digits",
         number: "Plese enter numeric digits only",
         max: "Max. value allowed can be 9 digits long",
         digits: "Decimal digits are not allowed"
         }
         });*/

        //======================FIELD VALUE CHANGE TOTAL VALIDATION=================
        jQuery.validator.addMethod("totalCheck", function(value, element) {

            var splittedId = element.id.split("_")
            var field1Id = "#" + splittedId[0] + "_" + splittedId[1] + "_" + "DIRECT";
            var field2Id = "#" + splittedId[0] + "_" + splittedId[1] + "_" + "CONTRACT";
            var field3Id = "#" + splittedId[0] + "_" + splittedId[1] + "_" + "MAN_TOT";

            var field1Value = parseInt($(field1Id).val());
            var field2Value = parseInt($(field2Id).val());
            var field3Value = parseInt($(field3Id).val());

            if (!isNaN(field3Value)) {

                if ((!isNaN(field1Value) && isNaN(field2Value))) {
                    if (field3Value != field1Value) {
                        if (field3Value > 0) {
                        //   alert("Calculated total of direct and contract is not equal to the entered total");
                        }
                        $(field3Id).val("");
                    }
                }
                if (isNaN(field1Value) && !isNaN(field2Value)) {
                    if (field3Value != field2Value) {
                        if (field3Value > 0) {
                        //   alert("Calculated total of direct and contract is not equal to the entered total");
                        }
                        $(field3Id).val("");
                    }
                }
                if (!isNaN(field1Value) && !isNaN(field2Value)) {
                    if (field3Value != (field1Value + field2Value)) {
                        if (field3Value > 0) {
                        //    alert("Calculated total of direct and contract is not equal to the entered total");
                        }
                        $(field3Id).val("");
                    }
                }
            }
            return true
        }, ""

        //===================DIRECT FIELD VALUE CHANGE TOTAL VALIDATION=============
        );
        $.validator.addClassRules("direct", {
            totalCheck: true
        });

        //==================CONTRACT FIELD VALUE CHANGE TOTAL VALIDATION============
        $.validator.addClassRules("contract", {
            totalCheck: true
        });


        //=====================AVG. DAILY EMPLOYMENT VALIDATION=====================
        $.validator.addMethod("dMaxlength", $.validator.methods.maxlength,
            $.validator.format("Max. length allowed is {0} digits"));
        $.validator.addMethod("dNumber", $.validator.methods.number,
            $.validator.format("Please enter numeric digits only"));
        $.validator.addMethod("dDigits", $.validator.methods.digits,
            $.validator.format("Decimal digits are not allowed"));
        $.validator.addMethod("dMax", $.validator.methods.max,
            $.validator.format("Max. value allowed is {0}"));

        $.validator.addMethod("calHoriSum1", function(value, element) {

            if (!isNaN(parseInt(value))) {

                var elementId = element.id;
                var splittedId = elementId.split("_");
                var idArrayLength = splittedId.length;

                if (idArrayLength == 4) {
                    var idPart1 = splittedId['0'];
                    var idPart2 = splittedId['1'];
                    var field1Id;
                    var field2Id;
                    field1Id = "#" + idPart1 + "_" + idPart2 + "_" + "MALE";
                    field2Id = "#" + idPart1 + "_" + idPart2 + "_" + "FEMALE";
                }
                else if (idArrayLength == 2) {
                    var totalIdPart1 = splittedId['0'];
                    field1Id = "#" + totalIdPart1 + "_" + "MALE";
                    field2Id = "#" + totalIdPart1 + "_" + "FEMALE";
                }

                var element1Val = parseFloat($(field1Id).val());
                var element2Val = parseFloat($(field2Id).val());

                if (!isNaN(element1Val) && !isNaN(element2Val)) {
                    var fieldTotal = parseFloat(element1Val) + parseFloat(element2Val);

                    //alert("v--->"+value);
                    //alert("f---->"+fieldTotal);

                    if (value != fieldTotal) {
                        alert("Calculated total varies from entered total");
                        element.value = "";
                    }
                }
                else {
                    alert("Please fill the average daily male and female employed value first");
                    element.value = "";
                }
            }
            return true;
        },
        ""
        );

        //    $.validator.addClassRules("sum1", {
        //      dMaxlength: 9,
        //      dNumber: true,
        //      workDecimal: true,
        //      dMax: 999999999,
        //      calHoriSum1: true
        //    });
        $('.sum1').attr('readonly', 'readonly');
        $('.sum1').css('backgroundColor', '#dcdcdc');

        $('.sum2').attr('readonly', 'readonly');
        $('.sum2').css('backgroundColor', '#dcdcdc');

        $('.sum3').attr('readonly', 'readonly');
        $('.sum3').css('backgroundColor', '#dcdcdc');

        $('.days_tot').attr('readonly', 'readonly');
        $('.days_tot').css('backgroundColor', '#dcdcdc');

        $('.wages_tot').attr('readonly', 'readonly');
        $('.wages_tot').css('backgroundColor', '#dcdcdc');

        //================AVG. TOTAL FIELD VALUE CHANGE TOTAL VALIDATION============
        jQuery.validator.addMethod("avgTotalCheck", function(value, element) {

            var splittedId = element.id.split("_")
            var field1Id = "#" + splittedId[0] + "_" + splittedId[1] + "_" + "MALE";
            var field2Id = "#" + splittedId[0] + "_" + splittedId[1] + "_" + "FEMALE";
            var field3Id = "#" + splittedId[0] + "_" + splittedId[1] + "_" + "PER_TOTAL";

            var field1Value = parseInt($(field1Id).val());
            var field2Value = parseInt($(field2Id).val());
            var field3Value = parseInt($(field3Id).val());

            if (!isNaN(field3Value)) {

                if ((!isNaN(field1Value) && isNaN(field2Value))) {
                    if (field3Value != field1Value) {
                        if (field3Value > 0) {
                        //  alert("Calculated total of average male and female employed is not equal to the entered total");
                        }
                        $(field3Id).val("");
                    }
                }
                if (isNaN(field1Value) && !isNaN(field2Value)) {
                    if (field3Value != field2Value) {
                        if (field3Value > 0) {
                        //   alert("Calculated total of average male and female employed is not equal to the entered total");
                        }
                        $(field3Id).val("");
                    }
                }
                if (!isNaN(field1Value) && !isNaN(field2Value)) {
                    if (field3Value != (field1Value + field2Value)) {
                        if (field3Value > 0) {
                        //  alert("Calculated total of average male and female employed is not equal to the entered total");
                        }
                        $(field3Id).val("");
                    }
                }
            }
            return true
        }, ""

        //===================DIRECT FIELD VALUE CHANGE TOTAL VALIDATION=============
        );
        $.validator.addClassRules("male", {
            avgTotalCheck: true
        });

        //==================CONTRACT FIELD VALUE CHANGE TOTAL VALIDATION============
        $.validator.addClassRules("female", {
            avgTotalCheck: true
        });

        //=================AVG. DAILY MALE VERTICAL TOTAL VALIDATION================
        jQuery.validator.addMethod("maleVerticalTotal", function(value, element) {

            var directArray = new Array();
            directArray = $(".male");
            var directTotal = 0;
            for (var i = 0; i < directArray.length; i++) {
                var directElement = parseFloat(directArray[i].value);
                if (!isNaN(directElement)) {
                    directTotal += parseFloat(directArray[i].value);
                }
            }
            if (value != directTotal) {
                alert("Calculated total varies from entered total");
                $("#TOTAL_MALE").val("");
            }
            return true
        });

        $.validator.addMethod('workDecimal', function(value, element) {
            return this.optional(element) || /^\d+(\.\d{0,1})?$/.test(value);
        }, "Please enter only 1 decimal point");

        /* $("#TOTAL_MALE").rules("add", {
         workDecimal: true,
         maxlength: 6,
         number: true,
         //digits: true,workDecimal: true,
         max: 999999999,
         maleVerticalTotal: true,
         messages: {
         //        required: "Field is required",
         //maxlength: "Max. length allowed is 6 digits",
         //number: "Plese enter numeric digits only",
         //max: "Max. value allowed can be 6 digits long"
         //digits: "Decimal digits are not allowed"
         }
         });*/

        //================AVG. DAILY FEMALE VERTICAL TOTAL VALIDATION===============
        jQuery.validator.addMethod("femaleVerticalTotal", function(value, element) {
            var directArray = new Array();
            directArray = $(".female");
            var directTotal = 0;
            for (var i = 0; i < directArray.length; i++) {
                var directElement = parseFloat(directArray[i].value);
                if (!isNaN(directElement)) {
                    directTotal += parseFloat(directArray[i].value);
                }
            }
            if (value != directTotal) {
                alert("Calculated total varies from entered total");
                $("#TOTAL_FEMALE").val("");
            }
            return true
        });

        /*$("#TOTAL_FEMALE").rules("add", {
         maxlength: 6,
         number: true,
         //digits: true,
         workDecimal: true,
         max: 999999999,
         femaleVerticalTotal: true,
         messages: {
         //        required: "Field is required",
         // maxlength: "Max. length allowed is 9 digits",
         // number: "Plese enter numeric digits only",
         //max: "Max. value allowed can be 9 digits long"
         //digits: "Decimal digits are not allowed"
         }
         });*/

        //================NO OF DAYS WORKED VERTICAL TOTAL VALIDATION===============
        jQuery.validator.addMethod("daysTotal", function(value, element) {

            var directArray = new Array();
            directArray = $(".days");
            var directTotal = 0;
            for (var i = 0; i < directArray.length; i++) {
                var directElement = parseInt(directArray[i].value);
                if (!isNaN(directElement)) {
                    directTotal += parseInt(directArray[i].value);
                }
            }
            if (value != directTotal) {
                alert("Calculated total varies from entered total");
                $("#TOTAL_DAYS").val("");
            }
            return true
        });

        /*$("#TOTAL_DAYS").rules("add", {
         maxlength: 9,
         number: true,
         digits: true,
         max: 999999999,
         daysTotal: true,
         daysVerticalTotal: true,
         messages: {
         //        required: "Field is required",
         maxlength: "Max. length allowed is 9 digits",
         number: "Plese enter numeric digits only",
         max: "Max. value allowed can be 9 digits long",
         digits: "Decimal digits are not allowed"
         }
         });*/

        //======================WAGES VERTICAL TOTAL VALIDATION=====================
        jQuery.validator.addMethod("wagesTotal", function(value, element) {
            var directArray = new Array();
            directArray = $(".wages");
            var directTotal = 0;
            for (var i = 0; i < directArray.length; i++) {
                var directElement = parseFloat(directArray[i].value);
                if (!isNaN(directElement)) {
                    directTotal += parseFloat(directArray[i].value);
                }
            }
            if (value != directTotal) {
                alert("Calculated total varies from entered total");
                $("#TOTAL_WAGES").val("");
            }
            return true
        });

        //=============================direct validation=========================
        $.validator.addMethod("cMaxlength", $.validator.methods.maxlength,
            $.validator.format("Max. length allowed is {0} digits"));
        $.validator.addMethod("cNumber", $.validator.methods.number,
            $.validator.format("Please enter numeric digits only"));
        $.validator.addMethod("cMax", $.validator.methods.max,
            $.validator.format("Max. value allowed is {0}"));
        /*$.validator.addMethod('workDecimal', function(value, element) {
         return this.optional(element) || /^\d+(\.\d{0,1})?$/.test(value); 
         }, "Please enter only 1 decimal point");*/
        $.validator.addMethod("cDigits", $.validator.methods.digits,
            $.validator.format("Decimal digits are not allowed"));

        $.validator.addClassRules("direct", {
            //workDecimal:true,
            cMaxlength: 8,
            cNumber: true,
            cDigits: true,
            cMax: 99999999
        });
        //==========================contract validation===========================
        $.validator.addMethod("cMaxlength", $.validator.methods.maxlength,
            $.validator.format("Max. length allowed is {0} digits"));
        $.validator.addMethod("cNumber", $.validator.methods.number,
            $.validator.format("Please enter numeric digits only"));
        $.validator.addMethod("cMax", $.validator.methods.max,
            $.validator.format("Max. value allowed is {0}"));
        /*$.validator.addMethod('workDecimal', function(value, element) {
         return this.optional(element) || /^\d+(\.\d{0,1})?$/.test(value); 
         }, "Please enter only 1 decimal point");*/
        $.validator.addMethod("cDigits", $.validator.methods.digits,
            $.validator.format("Decimal digits are not allowed"));

        $.validator.addClassRules("contract", {
            //workDecimal:true,
            cMaxlength: 8,
            cNumber: true,
            cDigits: true,
            cMax: 99999999
        });
        //==========================mail validation===============================

        $.validator.addMethod("cMaxlengthm", $.validator.methods.maxlength,
            $.validator.format("should accept 4 digits before decimals"));
        $.validator.addMethod("cNumberm", $.validator.methods.number,
            $.validator.format("Please enter numeric digits only"));
        $.validator.addMethod("cMaxm", $.validator.methods.max,
            $.validator.format("Max. value allowed is {0}"));
        $.validator.addMethod('workDecimalm', function(value, element) {
            return this.optional(element) || /^\d+(\.\d{0,1})?$/.test(value);
        }, "Please enter only 1 decimal point");


        $.validator.addClassRules("male", {
            cNumberm: true,
            workDecimal: true,
            cMaxlengthm: 6,
            cMaxm: 9999.9

        });

        //=============================female validation=========================== 
        $.validator.addMethod("cMaxlengthf", $.validator.methods.maxlength,
            $.validator.format("should accept 4 digits before decimals "));
        $.validator.addMethod("cNumberf", $.validator.methods.number,
            $.validator.format("Please enter numeric digits only"));
        $.validator.addMethod("cMaxf", $.validator.methods.max,
            $.validator.format("Max. value allowed is {0}"));
        $.validator.addMethod('workDecimalmf', function(value, element) {
            return this.optional(element) || /^\d+(\.\d{0,1})?$/.test(value);
        }, "Please enter only 1 decimal point");

        $.validator.addClassRules("female", {
            cNumber: true,
            workDecimal: true,
            cMaxlength: 6,
            cMax: 9999.9
        });

        //=========================================================================

        $.validator.addMethod("fMaxlength", $.validator.methods.maxlength,
            $.validator.format("Max. length allowed is {0} including decimal"));
        $.validator.addMethod("fNumber", $.validator.methods.number,
            $.validator.format("Please enter numeric digits only"));
        $.validator.addMethod("fMax", $.validator.methods.max,
            $.validator.format("Max. value allowed is 12,2 digits long"));
        /*$.validator.addMethod("fTotalWages", function(value, element){
         var elementId  = element.id;
         var splittedId = elementId.split('_');
         var alertMsg   = '';
         if(splittedId[0] == 'BELOW') {
         if(splittedId[1] == 'FOREMAN') {
         alertMsg = 'for Below Foreman and mining mates';  
         }else if(splittedId[1] == 'FACE') {
         alertMsg = 'for Below Face workers and loaders'; 
         }else if(splittedId[1] == 'OTHER') {
         alertMsg = 'for Below Others'; 
         } 
         }
         if(splittedId[0] == 'OC') {
         if(splittedId[1] == 'FOREMAN') {
         alertMsg = 'for OC Foreman and mining mates';  
         }else if(splittedId[1] == 'FACE') {
         alertMsg = 'for OC Face workers and loaders'; 
         }else if(splittedId[1] == 'OTHER') {
         alertMsg = 'for OC Others'; 
         }
         }
         if(splittedId[0] == 'ABOVE') {
         if(splittedId[1] == 'FOREMAN') {
         alertMsg = 'for ABOVE Foreman and mining mates';  
         }else if(splittedId[1] == 'FACE') {
         alertMsg = 'for ABOVE Face workers and loaders';
         }else if(splittedId[1] == 'OTHER') {
         alertMsg = 'for ABOVE Others'; 
         }
         }
         var manTotalId  = '#'+splittedId[0]+'_'+splittedId[1]+'_MAN_TOT';
         var manTotalVal = $(manTotalId).val();
         if(value != 0 && manTotalVal != 0){
         //alert(value+'-'+manTotalVal);
         var wagesVal = parseFloat(value)/parseFloat(manTotalVal);
         if(wagesVal < 50){
         alert('Average daily wage or salary < Rs 50 '+alertMsg);
         }
         if(wagesVal > 2000){
         alert('Average daily wage or salary > Rs 2000 '+alertMsg);
         }
         }
         return true;
         });*/

        $.validator.addMethod('wagesDecimal', function(value, element) {
            return this.optional(element) || /^\d+(\.\d{0,2})?$/.test(value);
        }, "Please enter only 2 decimal points");

        $.validator.addClassRules("wages", {
            fNumber: true,
            fMax: 999999999999.99,
            fTotalWages: true,
            wagesDecimal: true
        });

        $("#TOTAL_WAGES").rules("add", {
            maxlength: 15,
            number: true,
            //digits: true,
            max: 999999999999.99,
            //      wagesTotal: true,
            messages: {
                //        required: "Field is required",
                maxlength: "Max. length allowed is 15 digits",
                number: "Plese enter numeric digits only",
                max: "Max. value allowed can be 12,2 digits long"
            //digits: "Decimal digits are not allowed"
            }
        });
    },
    /**
     * FOR IMPLEMENTIG THE BIG FORMULA 2(C)/3 = 4(C)
     * @author Uday Shankar Singh <usingh@ubicsindia.com, udayshankar1306@gmail.com>
     * @version 5th Feb 2014
     */
     //function modify by shalini date : 11/01/2021
    validateBigFormula: function(){
        var formClassArr = new Array();
        formClassArr = ["direct", "contract", "man", "days", "male", "female", "per_tot", "wages"];
        var formFullLabelArr = {
            "BELOW_FOREMAN_MAN_TOT" : "A.Below Ground ",
            "BELOW_FACE_MAN_TOT" : "A.Below Ground Face workers and Loaders",
            "BELOW_OTHER_MAN_TOT" : "A.Below Ground Others",
            "OC_FOREMAN_MAN_TOT" : "B.Opencast workings ",
            "OC_FACE_MAN_TOT" : "B.Opencast workings Ground Face workers and Loaders",
            "OC_OTHER_MAN_TOT" : "B.Opencast workings Others",
            "ABOVE_CLERICAL_MAN_TOT" : "C.Above ground ",
            "ABOVE_ATTACHED_MAN_TOT" : "C.Above ground Workers in any Attached factory, Workshop or mineral dressing plant.",
            "ABOVE_OTHER_MAN_TOT" : "C.Above ground Others"
        };
        
        $.each(formClassArr, function(index, value){
            $("." + value).blur(function(event){
                var elementId = $(this).attr('id');
                var splitIdTemp = elementId.split("_");
               //console.log(elementId);
                // CREATING THE ELEMENT ID THAT ARE NEEDED TO CHECK THE FORMULA
                var twoCElementId = splitIdTemp[0] + "_" +splitIdTemp[1] + "_MAN_TOT";
                var threeElmenentId = splitIdTemp[0] + "_" +splitIdTemp[1] + "_DAYS";
                var fourCElementId = splitIdTemp[0] + "_" +splitIdTemp[1] + "_PER_TOTAL";
                var fourAElementId = splitIdTemp[0] + "_" +splitIdTemp[1] + "_MALE";
                var fourBElementId = splitIdTemp[0] + "_" +splitIdTemp[1] + "_FEMALE";
               
                /**
                 * ADDED THE BELOW THREE LINES FOR GETTING THE VALUES FROM THE FORM
                 * DOING IT AS EARLIER THE BELOW ALERT WAS COMING FOR EVERY BLUR OF THE TEXGT BOX
                 * @author Uday Shankar Singh
                 * @version 14th FEB 2014
                 * 
                 */
                // GETTING THE VALUES FOR THE ABOVE CREATED ID'S'
                var twoCElementVal = $("#" + twoCElementId).val();
                var threeElmenentVal = $("#" + threeElmenentId).val();
                var fourCElementVal = $("#" + fourCElementId).val();
                var fourAElementVal = $("#" + fourAElementId).val();
                var fourBElementVal = $("#" + fourBElementId).val();

               /* if(elementId==fourAElementId || elementId==fourBElementVal)
                {
                    $('.per_tot').click();
                }*/

                //console.log(twoCElementVal)
                //console.log(threeElmenentVal)
                //console.log(fourCElementVal)
               
                // CHECKING FOT NAN AND IF NOT THEN IMPLEMENTING THE FORMULA AND SHOWING THE ALERT
                if(!isNaN(twoCElementVal) && !isNaN(threeElmenentVal) && !isNaN(fourCElementVal) && !twoCElementVal.trim()== ''  && !threeElmenentVal.trim()== ''  && !fourCElementVal.trim()== '' ){
                    //                    console.log("uday")
                    if(fourCElementVal != '0.0' && fourCElementVal != '0'){
                        
                        /**
                     * ADDED THE BELOW THREE LINES FOR PARSING THE ROUNDING OFF THE VALUES THAT WE GOT FROM THE FORM
                     * DOING IT AS EARLIER THE BELOW ALERT WAS COMING FOR EVERY BLUR OF THE TEXGT BOX
                     * @author Uday Shankar Singh
                     * @version 14th FEB 2014
                     * 
                     */
                        twoCElementVal = Utilities.roundOff1(parseFloat($("#" + twoCElementId).val()));
                        threeElmenentVal = Utilities.roundOff1(parseFloat($("#" + threeElmenentId).val()));
                        fourCElementVal = Utilities.roundOff1(parseFloat($("#" + fourCElementId).val()));
                        // console.log(twoCElementVal)
                        // console.log(threeElmenentVal)
                        // console.log(fourCElementVal)
                        // CHECKING THE VALUES FOR NOT SHOWING THE ALERT WHEN 0 IS EVERY WHERE
                        // MODIFIED THE CONDITION FOR HANDLING THE 0 CONDITION by Uday Shankar Singhon 17th FEB 2014

                        // MODIFIED THE CONDITION for the show the pop up message by ganesh satav 29th MAY 2014
                    if(fourCElementVal != 0 && twoCElementVal != 0 && threeElmenentVal != 0){
                        var bigFormulaVal = Utilities.roundOff1(parseFloat(twoCElementVal/threeElmenentVal));
                        //console.log(bigFormulaVal);
                        var lowerLimit = Utilities.roundOff1(parseFloat(fourCElementVal) - 1);
                        var upperLimit = Utilities.roundOff1(parseFloat(fourCElementVal) + 1);
                        //console.log(lowerLimit);
                        //console.log(upperLimit);
                        if(parseFloat(bigFormulaVal) <= parseFloat(lowerLimit) || parseFloat(bigFormulaVal) >= parseFloat(upperLimit)){
                        // if(bigFormulaVal != fourCElementVal){
                            var errorFor = formFullLabelArr[twoCElementId];
                            var msgToDisplay = "For " + errorFor + " 2(C)/(3) = 4(C) is not validating. Kindly correct before proceeding";
                            alert(msgToDisplay);
                            $("#" + threeElmenentId).val('0');
                        }
                        }
                    }
                    else{
                        // MODIFIED THE CONDITION FOR HANDLING THE 0 CONDITION by Uday Shankar Singh on 17th FEB 2014
                        if(fourAElementVal =='' && fourBElementVal=='' &&  fourCElementVal==''){
                            var errorFor = formFullLabelArr[twoCElementId];
                            var msgToDisp = "For " + errorFor + " 4(C) can't be 0 as corresponding 'Total number of man days worked during the year' and 'No. of days worked during the year' are not 0. Kindly correct before proceding.";
                            alert(msgToDisp);
                            
                            $("#" + threeElmenentId).val('0');

                        }
                    }

                    
                }
            });
        });
    }
    
}


//Add the code by ganesh satav
// create function in the js file call ajax



//========================FOR PENDING RERTUNS ON DASHBOARD======================

var pendingRetunsDetails = {
    inIt: function(dataUrl) {
        var _this = this;
        $("#year").change(function() {
            $("#pendingMinesDetails").empty();
            Utilities.ajaxBlockUI();
            var checkValue = $("#year").val();
            if (checkValue != "") {
                $.ajax({
                    url: dataUrl,
                    type: "POST",
                    data: ({
                        value: checkValue
                    }),
                    success: function(response) {
                        _this.data = json_parse(response);
                        if (_this.data != "") {
                            if (_this.data['returnType'] == 'MONTHLY') {
                                _this.pendingReturns(_this.data);
                            }
                            else if (_this.data['returnType'] == 'ANNUAL') {
                                _this.pendingReturnsAnnual(_this.data);
                            }
                        }
                    }
                });
            }
        });
    },
    pendingReturns: function(displayData) {

        var tableId = $("#pendingMinesDetails").attr('id');
        //======================CREATING HEADER FOR TABLE=======================
        $("#" + tableId).append("<tr id='tableTr' class='form-table-title'></tr>");

        var checkValue = $("#year").val();

        var financialYear = checkValue + "-" + (parseInt(checkValue) + 1);

        if (displayData['dataCount']) {
            $("#tableTr").append("<td colspan='2' align='center' id='mineName'>Pending Returns For Financial Year " + financialYear + " (Month Wise) TOTAL - " + displayData['dataCount'] + "</td>");
            //========================CREATING DATA FIELDS==========================

            var arrayLength = displayData['mineCodeKey'].length;
            for (var i = 0; i < arrayLength; i++) {
                var mineCodeKey = displayData['mineCodeKey'][i];
                var dataLength = displayData['mineCodeDataWithKey'][mineCodeKey].length;

                var tableElement = $("#pendingMinesDetails");

                var tableTrMonth = $(document.createElement('tr'));
                tableTrMonth.colspan = "2";
                tableElement.append(tableTrMonth);

                var tableTrTd = $(document.createElement('td'));
                tableTrTd.attr("colspan", 2);
                tableTrTd.attr("align", "center");
                var cssObj = {
                    'background-color': '#ddd',
                    'color': '#FF0000',
                    'margin': '0 auto',
                    'font-weight': 'bold',
                    'font-size': '13px'
                };
                tableTrTd.css(cssObj);
                tableTrTd.html("FOR THE MONTH OF " + mineCodeKey);
                tableTrMonth.append(tableTrTd);

                var tableTrMonth1 = $(document.createElement('tr'));
                tableTrMonth1.addClass("form-table-title");
                tableTrMonth1.colspan = "2";
                tableElement.append(tableTrMonth1);

                var tableTrTd1 = $(document.createElement('td'));
                tableTrTd1.html("Mine Name");
                tableTrMonth1.append(tableTrTd1)
                var tableTrTd2 = $(document.createElement('td'));
                tableTrTd2.html("Mine Code");
                tableTrMonth1.append(tableTrTd2)

                for (var j = 0; j < dataLength; j++) {
                    var tableTr = $(document.createElement('tr'));
                    tableElement.append(tableTr);
                    var tableTd1 = $(document.createElement('td'));
                    tableTd1.css("width", "50%");
                    tableTd1.html(displayData['mineCodeDataWithKey'][mineCodeKey][j]['mineName']);
                    tableTr.append(tableTd1);
                    var tableTd2 = $(document.createElement('td'));
                    tableTd2.css("width", "50%");
                    tableTd2.html(displayData['mineCodeDataWithKey'][mineCodeKey][j]['mineCode']);
                    tableTr.append(tableTd2);
                }
            }
        } else {
            $("#tableTr").append("<td colspan='2' align='center' id='mineName'>Pending Returns For Financial Year " + financialYear + " (Month Wise) TOTAL - 0 </td>");
        }
    },
    inItAnnual: function(dataUrl) {
        var _this = this;
        $("#year").change(function() {
            $("#pendingMinesDetails").empty();
            Utilities.ajaxBlockUI();
            var checkValue = $("#year").val();
            if (checkValue != "") {
                $.ajax({
                    url: dataUrl,
                    type: "POST",
                    data: ({
                        value: checkValue
                    }),
                    success: function(response) {
                        _this.data = json_parse(response);
                        if (_this.data != "") {
                            _this.pendingReturns(_this.data);
                        }
                    }
                });
            }
        });
    },
    pendingReturnsAnnual: function(displayData) {

        var tableId = $("#pendingMinesDetails").attr('id');
        //======================CREATING HEADER FOR TABLE=======================
        $("#" + tableId).append("<tr id='tableTr' class='form-table-title'></tr>");

        var checkValue = $("#year").val();
        var financialYear = checkValue + "-" + (parseInt(checkValue) + 1);

        if (displayData['dataCount']) {
            $("#tableTr").append("<td colspan='2' align='center' id='mineName'>Pending Returns For Financial Year " + financialYear + " (Yearly) TOTAL - " + displayData['dataCount'] + "</td>");

            //========================CREATING DATA FIELDS==========================

            var tableElement = $("#pendingMinesDetails");

            var tableTrMonth1 = $(document.createElement('tr'));
            tableTrMonth1.addClass("form-table-title");
            tableTrMonth1.colspan = "2";
            tableElement.append(tableTrMonth1);

            var tableTrTd1 = $(document.createElement('td'));
            tableTrTd1.html("Mine Name");
            tableTrMonth1.append(tableTrTd1)
            var tableTrTd2 = $(document.createElement('td'));
            tableTrTd2.html("Mine Code");
            tableTrMonth1.append(tableTrTd2)

            // NOT IN USER RIGHT NOW BUT CAN BE USED LATER FOR LOOPING ---- UDAY SHANKAR SINGH
            //    $.each(displayData['yearlyMinesDetails'], function(key, value) {
            //      var tableElement  = $("#pendingMinesDetails");
            //      
            //      var tableTr = $(document.createElement('tr'));
            //      tableElement.append(tableTr);
            //      var tableTd1 = $(document.createElement('td'));
            //      tableTd1.css("width", "50%");
            //      tableTd1.html(value);
            //      tableTr.append(tableTd1);
            //      var tableTd2 = $(document.createElement('td'));
            //      tableTd2.css("width", "50%");
            //      tableTd2.html(key);
            //      tableTr.append(tableTd2);



            //    });


            var dataLength = displayData['yearlyMinesDetails'].length;
            for (var j = 0; j < dataLength; j++) {
                var tableTr = $(document.createElement('tr'));
                tableElement.append(tableTr);
                var tableTd1 = $(document.createElement('td'));
                tableTd1.css("width", "50%");
                tableTd1.html(displayData['yearlyMinesDetails'][j]['mineName']);
                tableTr.append(tableTd1);
                var tableTd2 = $(document.createElement('td'));
                tableTd2.css("width", "50%");
                tableTd2.html(displayData['yearlyMinesDetails'][j]['mineCode']);
                tableTr.append(tableTd2);
            }
        //    }else{
        //      $("#tableTr").append("<td colspan='2' align='center' id='mineName'>Pending Returns For Financial Year "+ financialYear +" (Month Wise) TOTAL - 0 </td>");
        }

    },
    inItMineUser: function(dataUrl) {
        var _this = this;
        $("#year").change(function() {
            $("#pendingMinesDetails").empty();
            var checkValue = $("#year").val();
            if (isNaN(checkValue) || checkValue == '') {
            // LEAVING EMPTY FOR NOT APPENDING ANYTHING TO THE DATA TABLE
            }
            else {
                Utilities.ajaxBlockUI();
                if (checkValue != "") {
                    $.ajax({
                        url: dataUrl,
                        type: "POST",
                        data: ({
                            value: checkValue
                        }),
                        success: function(response) {
                            _this.data = json_parse(response);
                            if (_this.data != "") {
                                //              if(_this.data['returnType'] == 'MONTHLY'){
                                _this.pendingReturnsMonth(_this.data);
                            //              }
                            //              else if(_this.data['returnType'] == 'ANNUAL'){
                            //                _this.pendingReturnsAnnual(_this.data);  
                            //              }
                            }
                        }
                    });
                }
            }
        });
    },
    // below added function add by ganesh satav because of this function use in the allocation details section
    // start code
    inItSupUser: function(dataUrl) {      
        var _this = this;
    $("#supuser").change(function() {        
            $("#pendingMinesDetails").empty();           
            var checkValue = $("#supuser").val();                       
            pendingRetunsDetails.getPrimaryUser(checkValue);
                
            
        });
    },
    inItSupPrimaryUser: function(dataUrl,primaryuser) {            
        var _this = this;       
                if (primaryuser != "") {
                    $.ajax({
                        url: dataUrl,
                        type: "POST",
                        data: ({
                            value: primaryuser
                        }),
                        success: function(response) {
                            
                            _this.data = json_parse(response);
                                                           
                            if (_this.data != "") {
                        
                                //              if(_this.data['returnType'] == 'MONTHLY'){
                                _this.supuser(_this.data);
                                //              }
                                //              else if(_this.data['returnType'] == 'ANNUAL'){
                                //                _this.pendingReturnsAnnual(_this.data);  
                                //              }
                            }
                        }
                    });
                }
    
    },
    // end code
    pendingReturnsMonth: function(returnData) {
        var tableId = $("#pendingMinesDetails").attr('id');
        //======================CREATING HEADER FOR TABLE=======================
        $("#" + tableId).append("<tr id='tableTr' class='form-table-title'></tr>");

        if (returnData['returnCount'] > 0) {
            $("#tableTr").append("<td colspan='2' align='center' id='mineName'>Month Name List For Which Monthly Returns Are  Pending </td>");
            //========================CREATING DATA FIELDS==========================

            var arrayLength = returnData['returnCount'];
            for (var i = 0; i < arrayLength; i++) {
                var mineCodeKey = returnData['returnMonth'][i];

                var tableElement = $("#pendingMinesDetails");

                var tableTrMonth = $(document.createElement('tr'));
                tableTrMonth.colspan = "2";
                tableElement.append(tableTrMonth);

                var tableTrTd = $(document.createElement('td'));
                tableTrTd.attr("colspan", 2);
                tableTrTd.attr("align", "center");
                var cssObj = {
                    'background-color': '#ddd',
                    'color': '#FF0000',
                    'margin': '0 auto',
                    'font-weight': 'bold',
                    'font-size': '13px'
                };
                tableTrTd.css(cssObj);
                tableTrTd.html(mineCodeKey);
                tableTrMonth.append(tableTrTd);

            }
        } else {
            $("#tableTr").append("<td colspan='2' align='center' id='mineName'>No Monthly Pending Returns For This Financial Year </td>");
        }
    },
    // below created function create by ganesh satav this function use in the allocation return section
    
    getPrimaryUser: function(SupUser) {  $("#supervisoryusersDetails").empty();
    $.ajax({
      url: 'getPrimaryUser',
      type: 'POST',
      data: "SupUser=" + SupUser,
      success: function(response) { 
        var data = json_parse(response);
        var primary = document.getElementById('primary');
        $(primary).empty();
        var i = 0;
        $.each(data, function(index, item) {
          var option = document.createElement('option');
          if (i == 0)
            option.value = "";
          else
           option.value = index;
           option.innerHTML = item;
           primary.appendChild(option);
          i++;
        });
    }
    });
}
}

function htmlEntities(str,id) {	
	var str = String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
	//$( '#'+id).val('');
	$( '#'+id).val(str);
    return str;
}


var GeologyOverburdenTrees = {
    fieldValidation: function() {
        //====================roundOff to decimal 3 places==========================
        // jQuery.validator.addMethod("secFournRoundOff", function(value, element) {
        //     var temp = new Number(value);
        //     element.value = (temp).toFixed(2);
        //     return true;
        // }, "");

        $.validator.addMethod('survivalDecimal', function(value, element) {
            return this.optional(element) || /^\d+(\.\d{0,2})?$/.test(value);
        }, "Please enter only 2 decimal point");

        // $.validator.addMethod('survivalDecimalThree', function(value, element) {
        //     return this.optional(element) || /^\d+(\.\d{0,3})?$/.test(value);
        // }, "Please enter only 3 decimal point");

        $("#frmGeologyOverburdenTrees").validate({
            rules: {
                "O[AT_BEGINING_YR]": {
                    required: true,
                    maxlength: 15,
                    survivalDecimal: true,
                    number: true
                },
                "O[GENERATED_DY]": {
                    required: true,
                    maxlength: 15,
                    survivalDecimal: true,
                    number: true
                },
                "O[DISPOSED_DY]": {
                    required: true,
                    maxlength: 15,
                    survivalDecimal: true,
                    number: true
                },
                "O[BACKFILLED_DY]": {
                    required: true,
                    maxlength: 15,
                    survivalDecimal: true,
                    number: true
                },
                "O[TOTAL_AT_EOY]": {
                    required: true,
                    maxlength: 15,
                    survivalDecimal: true,
                    number: true
                },
                "T[TREES_WI_LEASE]": {
                    required: true,
                    maxlength: 15,
                    number: true,
                    digits: true
                },
                "T[TREES_OS_LEASE]": {
                    required: true,
                    maxlength: 15,
                    number: true,
                    digits: true
                },
                "T[SURV_WI_LEASE]": {
                    required: true,
                    survivalDecimal: true,
                    number: true,
                    min: 0,
                    max: 100
                },
                "T[SURV_OS_LEASE]": {
                    required: true,
                    survivalDecimal: true,
                    number: true,
                    min: 0,
                    max: 100
                },
                "T[TTL_EOY_WI_LEASE]": {
                    required: true,
                    maxlength: 15,
                    number: true,
                    digits: true
                },
                "T[TTL_EOY_OS_LEASE]": {
                    required: true,
                    maxlength: 15,
                    number: true,
                    digits: true
                }
            },
            messages: {
                "O[AT_BEGINING_YR]": {
                    required: "Please enter data",
                    maxlength: "Max. length allowed is 15",
                    survivalDecimal: 'Decimal upto 2 digits allowed',
                    number: "Please enter numeric digits only"
                },
                "O[GENERATED_DY]": {
                    required: "Please enter data",
                    maxlength: "Max. length allowed is 15",
                    survivalDecimal: 'Decimal upto 2 digits allowed',
                    number: "Please enter numeric digits only"
                },
                "O[DISPOSED_DY]": {
                    required: "Please enter data",
                    maxlength: "Max. length allowed is 15",
                    survivalDecimal: 'Decimal upto 2 digits allowed',
                    number: "Please enter numeric digits only"
                },
                "O[BACKFILLED_DY]": {
                    required: "Please enter data",
                    maxlength: "Max. length allowed is 15",
                    survivalDecimal: 'Decimal upto 2 digits allowed',
                    number: "Please enter numeric digits only"
                },
                "O[TOTAL_AT_EOY]": {
                    required: "Please enter data",
                    maxlength: "Max. length allowed is 15",
                    survivalDecimal: 'Decimal upto 2 digits allowed',
                    number: "Please enter numeric digits only"
                },
                "T[TREES_WI_LEASE]": {
                    required: "Please enter data",
                    maxlength: "Max. length allowed is 15",
                    number: "Please enter numeric digits only",
                    digits: "Decimal number are not allowed"
                },
                "T[TREES_OS_LEASE]": {
                    required: "Please enter data",
                    maxlength: "Max. length allowed is 15",
                    number: "Please enter numeric digits only",
                    digits: "Decimal number are not allowed"
                },
                "T[SURV_WI_LEASE]": {
                    required: "Please enter data",
                    survivalDecimal: 'Decimal upto 2 digits allowed',
                    number: "Please enter numeric digits only",
                    min: "Please enter value greater than or equal to 0",
                    max: "Please enter value less than or equal to 100"
                },
                "T[SURV_OS_LEASE]": {
                    required: "Please enter data",
                    survivalDecimal: 'Decimal upto 2 digits allowed',
                    number: "Please enter numeric digits only",
                    min: "Please enter value greater than or equal to 0",
                    max: "Please enter value less than or equal to 100"
                },
                "T[TTL_EOY_WI_LEASE]": {
                    required: "Please enter data",
                    maxlength: "Max. length allowed is 15",
                    number: "Please enter numeric digits only",
                    digits: "Decimal number are not allowed"
                },
                "T[TTL_EOY_OS_LEASE]": {
                    required: "Please enter data",
                    maxlength: "Max. length allowed is 15",
                    number: "Please enter numeric digits only",
                    digits: "Decimal number are not allowed"
                }
            }
        });

    }
}