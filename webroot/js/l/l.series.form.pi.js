//================CREATION AND DISPLAY OF THE FORM AND DATA STARTS==============
var nSeriesactivityDetails = {
    init: function(mineral_url, grade_url, tabType, mineralData, mineralForgd, contryUrl, registrationCodeUrl, unit_url) {
        this.mineralUrl = mineral_url;
        this.gradeUrl = grade_url;
        this.tabType = tabType;
        this.contryUrl = contryUrl;
        this.unitUrl = unit_url;
        this.registrationCodeUrl = registrationCodeUrl;
        this.mineralObject = json_parse(mineralData);
        this.gradeObject = json_parse(mineralForgd);
        if (this.mineralObject.length > 0)
            this.check_mineral_name = this.mineralObject[0].ID;
        else
            this.check_mineral_name = "";

        if (this.tabType == 2)
        {
            this.despatchValue = 'country';
            this.SearchMessage = 'Search Country Name';
        } else
{
            this.despatchValue = 'regNo';
            this.SearchMessage = 'Search Registration Number';
        }
        //================get id from table and Hidden fields ============================
        this.fType = $("#fType").val();
        this.traditionTable = $("#activityDetials");
        this.mineralCount = $("#mineralCount");
        this.gradeCount = $("#");
        this.supplierCount = $("#supplierCount");
        this.importQuantityCount = $("#importQuantityCount");
        this.buyerRegNoCount = $("#buyerRegNoCount");
        this.imagepath = $("#imagePath").val();
        Utilities.ajaxBlockUI();
        this.getEmpData(tabType);
        this.addMoreMineral();
        this.gradeMineral();
    },
    getEmpData: function(tabType) {
        var _this = this;
        //============== Fetch Mineral data from DIR_MCP_MINERAL table using AJAX =======================
        $.ajax({
            url: _this.mineralUrl,
            type: 'GET',
            async: false,
            success: function(response) {
				
                _this.mineral = json_parse(response);
                //================Use code for fill and update data=====================================================           
                _this.check_mineralNo = _this.check_mineral_name;
                //_this.data.mineralNo = "";
                if (_this.check_mineralNo == "") {
                    var input_hidden_mineral = $(document.createElement('input'));
                    input_hidden_mineral.attr("type", "hidden");
                    input_hidden_mineral.attr("id", "mineral_cnt");
                    input_hidden_mineral.attr("name", "mineral_cnt");
                    input_hidden_mineral.attr("value", 1);
                    _this.traditionTable.append(input_hidden_mineral);

                    _this.defineNullValue();
                    _this.mineralCount.value = 1
                    _this.supplierCount.value = 1
                    _this.importQuantityCount.value = 1
                    _this.buyerRegNoCount.value = 1
                    _this.createMineralBox(1, 1);
                    _this.addMoreGrade(_this.gradeCount.value);
                    _this.addMoreSupplierBox();
                    _this.addMoreImportBox(tabType);
                    _this.addMoreBuyerBox(tabType);
                    activityDetailsValidation.fieldValidation(_this.tabType);
                    activityDetailsValidation.countryOnQuantityCheck();
                } else {
                    _this.task = 'edit';
                    var input_hidden_mineral = $(document.createElement('input'));
                    input_hidden_mineral.attr("type", "hidden");
                    input_hidden_mineral.attr("id", "mineral_cnt");
                    input_hidden_mineral.attr("name", "mineral_cnt");
                    input_hidden_mineral.attr("value", 1);
                    _this.traditionTable.append(input_hidden_mineral);
                    //_this.fillData(tabType);
                    activityDetailsValidation.fieldValidation(_this.tabType);
                    activityDetailsValidation.countryOnQuantityCheck();
                }                
            }
        });
		if(_this.task == 'edit'){
			_this.fillData(tabType);
		}
		_this.autocomplete(tabType);
        _this.registrationCodeAutocomplete();
    },
    // mineralNo , gradeNo
    createMineralBox: function(mineralNo, gradeNo) {
        var _this = this;
        var row = $(document.createElement('tr'));
        row.attr("id", "mineralForRow_" + mineralNo + '_' + gradeNo);
        row.addClass("mineralMenu_" + mineralNo + " " + "mineralSubMenu_" + mineralNo + '_' + gradeNo);
        this.traditionTable.append(row);

        var input_hidden_grade = $(document.createElement('input'));
        input_hidden_grade.attr("type", "hidden");
        input_hidden_grade.attr("id", "grade_cnt_" + mineralNo);
        input_hidden_grade.attr("name", "grade_cnt_" + mineralNo);
        input_hidden_grade.attr("value", 1);
        _this.traditionTable.append(input_hidden_grade);

        //Start Mineral box TD
        var select_box_mineral = $(document.createElement('td'));
        select_box_mineral.attr("align", "center");
        select_box_mineral.attr("rowspan", "3");
        select_box_mineral.attr("valign", "middle");
        row.append(select_box_mineral);

        var mineral_select = $(document.createElement('select'));
        mineral_select.attr("id", "mineral_" + mineralNo);
        mineral_select.attr("name", "mineral_" + mineralNo);
        mineral_select.addClass("h-selectbox mineral tab_index_" + this.tabType);
        mineral_select.css("width", "120px");
        select_box_mineral.append(mineral_select);
        var options = $(document.createElement('option'));
        options.html('--- Select mineral ---');
        options.val('');
        mineral_select.append(options);

        $.each(_this.mineral.returnValue, function(index, item) {
            var options = $(document.createElement('option'));
            options.html(item);
            options.val(index);
            mineral_select.append(options);
        });

        // ADDED BY UDAY... FOR ADDING THE NIL OPTION IN THE DROP DOWN
        // IF THE NO OF FILED IS ONE THEN ONLY ADD THE NIL IN THE OPTIONS LIST ELSE NOT REQUIRED
        var countMineralField = $(".mineral").length;
        if (countMineralField == 1) {
            var optionNil = $(document.createElement('option'));
            optionNil.html('NIL');
            optionNil.val('NIL');
            mineral_select.append(optionNil);
        }

        if (_this.mineral_name != "")
            mineral_select.val(_this.mineral_name);
        //========================= Call createGradeBox function to shows grade data ==================================================
        //row : Parent row Object
        //elem_no=> Mineral No , gradeNo=>grade no , counterNo=>Counter for Supplier,Import and Buyer
        var counterNo = 1;
        _this.createGradeBox(row, mineralNo, gradeNo, counterNo, 0, 0);
        _this.gradeMineral();
    },
    checkMineralForNilAndEmpty: function(checkingFirstMineralForNullOrNil, checkingFirstMineralForNullOrNilLength, event) {
        // ADDED BY UDAY ... TO REMOVE THE NIL FROM THE DROP DOWN .. SO THAT IT CAN'T BE SELECTED AFTER SELECTING MULTIPLE MINERALS ON ADD MORE
        //    console.log(checkingFirstMineralForNullOrNilLength)

        if (checkingFirstMineralForNullOrNil == '') {
            alert("Kindly Select Mineral First and then only you can use Add More");
            event.preventDefault();
        }
        else if (checkingFirstMineralForNullOrNil == 'NIL') {
            alert("Sorry... You can't use Add More while selecting NIL in the Mineral.")
            event.preventDefault();
        }

    },
    addMoreMineral: function() {
        var _this = this;
        //============get add_more_mineral id to increase... when visitor click add more Mineral button===========
        $("#add_more_mineral").live("click", function(event) {

            var checkingFirstMineralForNullOrNil = $("#mineral_1").val();
            var checkingFirstMineralForNullOrNilLength = $("#mineral_1").length;
            if (checkingFirstMineralForNullOrNilLength == 1 && (checkingFirstMineralForNullOrNil == '' || checkingFirstMineralForNullOrNil == 'NIL')) {
                _this.checkMineralForNilAndEmpty(checkingFirstMineralForNullOrNil, checkingFirstMineralForNullOrNilLength, event);
            }
            else {
                $("#mineral_1").find('option[value=NIL]').remove(); // REMOVING THE NIL FROM THE MINERAL DROP DOWN IF COUNT IS GREATER THEN 0 AS COUNT STARTS FROM 0 HERE

                var prev_mineral_count = _this.mineralCount.value; // get the Previous mineral counter
                var inc_mineral_count = parseInt(prev_mineral_count) + 1;
                _this.mineralCount.value = inc_mineral_count;
                var minralForgradeNo = 1;
                var No = 1;
                _this.defineNullValue();
                _this.createMineralBox(inc_mineral_count, minralForgradeNo, No, prev_mineral_count);
                $("#mineral_cnt").val(inc_mineral_count);
                activityDetailsValidation.countryOnQuantityCheck();
                _this.registrationCodeAutocomplete();
                _this.autocomplete(2);
            }
        });
    },
    //================
    addMoreGrade: function(gradeCount, tabType) {
        var _this = this;
        //show data 
        $(".grade_add_more").unbind("click");
        $(".grade_add_more").live("click", function(event) {


            var checkingFirstMineralForNullOrNil = $("#mineral_1").val();
            var checkingFirstMineralForNullOrNilLength = $("#mineral_1").length;
            if (checkingFirstMineralForNullOrNilLength == 1 && (checkingFirstMineralForNullOrNil == '' || checkingFirstMineralForNullOrNil == 'NIL')) {
                _this.checkMineralForNilAndEmpty(checkingFirstMineralForNullOrNil, checkingFirstMineralForNullOrNilLength, event);
            }
            else {

                var gradeId = $(this).attr("id");
                var mineralNo = $(this).attr("alt");
                var gradeForMineralId = 'grade_select_' + mineralNo;
                var gradeForMineral = $("." + gradeForMineralId);
                var gradeForMineralCount = $("." + gradeForMineralId).length;
                var prev_grade_count = gradeForMineralCount;
                var gradeNo = parseInt(prev_grade_count) + 1;
                _this.gradeCount.value = gradeNo;
                var counterNo = 1;
                var row = $(document.createElement('tr'));
                row.attr("id", "mineralForRow_" + mineralNo + '_' + gradeNo);
                row.addClass("mineralMenu_" + mineralNo + " " + "mineralSubMenu_" + mineralNo + '_' + gradeNo);
                _this.traditionTable.append(row);
                _this.defineNullValue();
                _this.createGradeBox(row, mineralNo, gradeNo, counterNo, prev_grade_count, 1);
                $("#grade_cnt_" + mineralNo).val(gradeNo);

                var mineralValue = $("#mineral_" + mineralNo).val();
                if (mineralValue != "")
                {
                    Utilities.ajaxBlockUI();
                    $.ajax({
                        url: _this.gradeUrl,
                        type: "POST",
						async: false,
                        data: ({
                            value: mineralValue
                        }),
                        success: function(data) {
                            $("#grade_" + mineralNo + '_' + gradeNo)
                            .find('option')
                            .remove();
                            var mySelect = $("#grade_" + mineralNo + '_' + gradeNo);
                            var myOptions = json_parse(data);
                            mySelect.append(
                                $('<option></option>').val('').html("--- Select Grade ---")
                                );
                            $.each(myOptions.gradeData, function(val, text) {
                                mySelect.append(
                                    $('<option></option>').val(val).html(text));
                            });
                        }
                    });
                }
                _this.autocomplete(tabType); // ADDED BY UDAY... AS EARLIER THE COUNTRY NAME AUTOCOMPLETE WAS NOT WORKING AS IT'S NOT CALLING THE AUTOCOMPLETE TO APPEND COUNTRIES NAME
                _this.registrationCodeAutocomplete();
                activityDetailsValidation.countryOnQuantityCheck();
            }
        });
    },
    defineNullValue: function()
    {
        var _this = this;
        _this.mineral_name = "";
        this.grade_code = "";
        _this.opening_stock = "";
        _this.closing_stock = "";
        this.supllierCount = "";
        _this.supplier_reg_no = "";
        _this.supplier_quantity = "";
        _this.supplier_value = "";
        this.importCount = "";
        _this.import_country = "";
        _this.import_quantity = "";
        _this.import_value = "";
        this.despatchCount = "";
        _this.buyer_reg_no = "";
        _this.buyer_quantity = "";
        _this.buyer_value = "";
        this.consume_quantity = "";
        this.consume_value = "";
    },
    addMoreSupplierBox: function() {
        var _this = this;
        $(".supplier_add_more").live("click", function(event) {
            var checkingFirstMineralForNullOrNil = $("#mineral_1").val();
            var checkingFirstMineralForNullOrNilLength = $("#mineral_1").length;
            if (checkingFirstMineralForNullOrNilLength == 1 && (checkingFirstMineralForNullOrNil == '' || checkingFirstMineralForNullOrNil == 'NIL')) {
                _this.checkMineralForNilAndEmpty(checkingFirstMineralForNullOrNil, checkingFirstMineralForNullOrNilLength, event);
            }
            else {
                var supplierId = $(this).attr("id");
                var splitForMingrade = supplierId.split("_");
                _this.supplierTable = $("#supplier_table_" + supplierId.substr(18));
                var supplierCountperMineral = $(".supplier_valueClass_" + splitForMingrade[3] + '_' + splitForMingrade[4]);
                var prev_supplier_count = supplierCountperMineral.length;
                var inc_supplier_count = parseInt(prev_supplier_count) + 1;
                var minralForgradeNo = splitForMingrade[4];
                var minralNo = splitForMingrade[3];
                $("#purchase_cnt_" + minralNo + '_' + minralForgradeNo).val(inc_supplier_count);//pradip
                _this.supplier_reg_no = "";
                _this.supplier_quantity = "";
                _this.supplier_value = "";
                _this.createRegSupplierBox(minralNo, minralForgradeNo, inc_supplier_count);
                _this.registrationCodeAutocomplete();
            }
        });
    },
    addMoreImportBox: function(tabType) {
        var _this = this;
        $(".import_add_more").live("click", function(event) {

            var checkingFirstMineralForNullOrNil = $("#mineral_1").val();
            var checkingFirstMineralForNullOrNilLength = $("#mineral_1").length;
            if (checkingFirstMineralForNullOrNilLength == 1 && (checkingFirstMineralForNullOrNil == '' || checkingFirstMineralForNullOrNil == 'NIL')) {
                _this.checkMineralForNilAndEmpty(checkingFirstMineralForNullOrNil, checkingFirstMineralForNullOrNilLength, event);
            }
            else {
                //      console.log("import add more clicked")
                Utilities.ajaxBlockUI();
                var importQuanlityId = $(this).attr("id");
                var splitImportForMingrade = importQuanlityId.split("_");
                //add_more_import_1_1_1
                _this.importQuantityTable = $("#import_table_" + importQuanlityId.substr(16));
                var importCountperMineral = $(".import_value_" + splitImportForMingrade[3] + '_' + splitImportForMingrade[4]);
                var prev_importQuantity_count = importCountperMineral.length;
                var inc_importQuantity_count = parseInt(prev_importQuantity_count) + 1;
                var minralForgradeNo = splitImportForMingrade[4];
                var minralNo = splitImportForMingrade[3];
                $("#import_cnt_" + minralNo + '_' + minralForgradeNo).val(inc_importQuantity_count);
                _this.import_country = "";
                _this.import_quantity = "";
                _this.import_value = "";
                _this.createminImportBox(minralNo, minralForgradeNo, inc_importQuantity_count);
                _this.autocomplete(tabType); // ADDED BY UDAY SHANKAR SINGH FOR AUTOCOMPLETE ADDING ON CLIKC ON ADD MORE OF IMPORT
                //                _this.registrationCodeAutocomplete();
                activityDetailsValidation.countryOnQuantityCheck();
            }
        });
    },
    addMoreBuyerBox: function(tabType) {
        var _this = this;
        $(".add_more_buyer_btn").live("click", function(event) {
            var checkingFirstMineralForNullOrNil = $("#mineral_1").val();
            var checkingFirstMineralForNullOrNilLength = $("#mineral_1").length;
            if (checkingFirstMineralForNullOrNilLength == 1 && (checkingFirstMineralForNullOrNil == '' || checkingFirstMineralForNullOrNil == 'NIL')) {
                _this.checkMineralForNilAndEmpty(checkingFirstMineralForNullOrNil, checkingFirstMineralForNullOrNilLength, event);
            }
            else {
                var buyerId = $(this).attr("id");
                var splitDespForMingrade = buyerId.split("_");
                _this.buyerTable = $("#buyer_table_" + buyerId.substr(15));
                var desptchCountperMineral = $(".buyer_valueClass_" + splitDespForMingrade[3] + '_' + splitDespForMingrade[4]);
                var prev_buyerRegNo_count = desptchCountperMineral.length;
                var inc_buyerRegNo_count = parseInt(prev_buyerRegNo_count) + 1;
                _this.buyerRegNoCount.value = inc_buyerRegNo_count;
                var minralForgradeNo = splitDespForMingrade[4];
                var minralNo = splitDespForMingrade[3];
                $("#despatch_cnt_" + minralNo + '_' + minralForgradeNo).val(inc_buyerRegNo_count);
                _this.buyer_reg_no = "";
                _this.buyer_quantity = "";
                _this.buyer_value = "";
                _this.createminBuyerBox(minralNo, minralForgradeNo, inc_buyerRegNo_count);
                var formName = $("#exportOfOreFrm").val();
                if (formName == 'exportOfOre')
                    _this.autocomplete(2);
                else
                    _this.registrationCodeAutocomplete();
            }
        });
    },
    renameMineralBoxes: function(mineralNo, gradeNo, checkName) {
        var mineral = $(".mineral");
        //In for loop count is Mineral No and grade_count is Grade No
        var mineralCount = 0
        for (var i = 0; i < mineral.length; i++) {
            var count = i + 1;
            $(mineral[i]).attr('name', 'mineral_' + count);
            $(mineral[i]).attr('id', 'mineral_' + count);

            if (mineralNo == count && checkName == 'mineral') {
                mineralCount = count + 1;
            } else if (mineralCount != 0 && checkName == 'mineral') {
                mineralCount = mineralCount + 1;
            } else {
                mineralCount = count;
            }
            var grade = $(".grade_select_" + mineralCount);
            var grade = $(".grade_select_" + mineralCount);
            var opening_stock = $(".opening_stock_quantity_" + mineralCount);
            var closing_stock = $(".closing_stock_" + mineralCount);
            if (this.fType == 'O') {
                var import_country = $(".import_quantityClass_" + mineralCount);
                var import_value = $(".import_value_" + mineralCount);
            }

            var add_grade_btn = $("#add_grade_" + mineralCount);
            var classCountForgrade = 0;

            for (var j = 0; j < grade.length; j++) {
                var grade_count = j + 1;
                $(grade[j]).attr('name', 'grade_' + count + '_' + grade_count);
                $(grade[j]).attr('id', 'grade_' + count + '_' + grade_count);
                $(grade[j]).attr('class', 'h-selectbox grade grade_select_' + count);

                $(opening_stock[j]).attr('name', 'opening_stock_quantity_' + count + '_' + grade_count);
                $(opening_stock[j]).attr('id', 'opening_stock_quantity_' + count + '_' + grade_count);
                $(opening_stock[j]).attr('class', 'text-fields opening_stock_quantity opening_stock_quantity_' + count);

                if (this.fType == 'O') {
                    $(import_country[j]).attr('name', 'import_quantity_' + count + '_' + grade_count);
                    $(import_country[j]).attr('id', 'import_quantity_' + count + '_' + grade_count);
                    $(import_country[j]).attr('class', 'text-fields import_quantity import_quantityClass_' + count);

                    $(import_value[j]).attr('name', 'import_value_' + count + '_' + grade_count);
                    $(import_value[j]).attr('id', 'import_value_' + count + '_' + grade_count);
                    $(import_value[j]).attr('class', 'text-fields import_value import_value_' + count);
                }

                //for add more grade button
                $(add_grade_btn).attr('id', 'add_grade_' + count);
                $(add_grade_btn).attr('alt', count);

                if (mineralNo == count && gradeNo == grade_count && checkName == 'grade') {
                    classCountForgrade = grade_count + 1;
                } else if (mineralNo == count && classCountForgrade != 0 && checkName == 'grade') {
                    classCountForgrade = classCountForgrade + 1;
                } else {
                    classCountForgrade = grade_count;
                }
                //add mineral id and mineral class ,grade class
                if (checkName == 'mineral')
                {
                    var minealRow = $("#mineralForRow_" + mineralCount + '_' + classCountForgrade);
                    var mineralForgradeRow = $("#mineralForgradeRow_" + mineralCount + '_' + classCountForgrade);
                    var supplierForRow = $("#supplierForRow_" + mineralCount + '_' + classCountForgrade);
                    $(supplierForRow).attr('id', 'supplierForRow_' + count + '_' + grade_count);
                    $(supplierForRow).attr('class', "mineralMenu_" + count + " " + "mineralSubMenu_" + count + '_' + grade_count);
                } else {
                    var minealRow = $("#mineralForRow_" + mineralCount + '_' + classCountForgrade);
                    var mineralForgradeRow = $("#mineralForgradeRow_" + mineralCount + '_' + classCountForgrade);
                }

                $(minealRow).attr('id', 'mineralForRow_' + count + '_' + grade_count);
                $(minealRow).attr('class', "mineralMenu_" + count + " " + "mineralSubMenu_" + count + '_' + grade_count);
                $(mineralForgradeRow).attr('id', 'mineralForgradeRow_' + count + '_' + grade_count);
                $(mineralForgradeRow).attr('class', "mineralMenu_" + count + " " + "mineralSubMenu_" + count + '_' + grade_count);

                // ADDED BY UDAY... FOR ADDING THE NIL OPTION IN THE DROP DOWN
                // IF THE NO OF FILED IS ONE THEN ONLY ADD THE NIL IN THE OPTIONS LIST ELSE NOT REQUIRED
                var countMineralField = $(".mineral").length;
                if (countMineralField == 1) {
                    $("#mineral_1").append(
                        $('<option></option').val('NIL').html('NIL')
                        );
                }

                //code for delete icon. whe visitor click on mineral or grade delete icon
                var deleteRowicon = $("#deleteIcon_" + mineralCount + '_' + classCountForgrade);
                $(deleteRowicon).attr('id', 'deleteIcon_' + count + '_' + grade_count);
                $(deleteRowicon).attr('alt', count);
                $(deleteRowicon).attr('lang', grade_count);

                //code the change id of the purchase , import and buyerer table
                var supplierRow = $("#supplier_table_" + mineralCount + '_' + classCountForgrade + '_1');
                var importRow = $("#import_table_" + mineralCount + '_' + classCountForgrade + '_1');
                var buyerRow = $("#buyer_table_" + mineralCount + '_' + classCountForgrade + '_1');

                $(supplierRow).attr('id', 'supplier_table_' + count + '_' + grade_count + '_1');
                $(importRow).attr('id', 'import_table_' + count + '_' + grade_count + '_1');
                $(buyerRow).attr('id', 'buyer_table_' + count + '_' + grade_count + '_1');

                //button for supplier ,import and buyer
                var supplierBtn = $("#add_more_supplier_" + mineralCount + '_' + classCountForgrade + '_1');
                var importBtn = $("#add_more_import_" + mineralCount + '_' + classCountForgrade + '_1');
                var buyerBtn = $("#add_more_buyer_" + mineralCount + '_' + classCountForgrade + '_1');

                $(supplierBtn).attr('id', 'add_more_supplier_' + count + '_' + grade_count + '_1');
                $(importBtn).attr('id', 'add_more_import_' + count + '_' + grade_count + '_1');
                $(buyerBtn).attr('id', 'add_more_buyer_' + count + '_' + grade_count + '_1');

                var supplier_reg_no = $(".supplier_reg_noClass_" + mineralCount + '_' + classCountForgrade);
                var supplier_quantity = $(".supplier_quantityClass_" + mineralCount + '_' + classCountForgrade);
                var supplier_value = $(".supplier_valueClass_" + mineralCount + '_' + classCountForgrade);

                var import_country = $(".import_countryClass_" + mineralCount + '_' + classCountForgrade);
                var import_quantity = $(".import_quantityClass_" + mineralCount + '_' + classCountForgrade);
                var import_value = $(".import_value_" + mineralCount + '_' + classCountForgrade);

                for (var k = 0; k < supplier_value.length; k++) {
                    var pCount = k + 1;
                    $(supplier_reg_no[k]).attr('name', 'reg_no_' + count + '_' + grade_count + '_' + pCount);
                    $(supplier_reg_no[k]).attr('id', 'reg_no_' + count + '_' + grade_count + '_' + pCount);
                    $(supplier_reg_no[k]).attr('class', 'text-fields supplier_registration supplier_reg_noClass_' + count + '_' + grade_count);

                    $(supplier_quantity[k]).attr('name', 'supplier_quantity_' + count + '_' + grade_count + '_' + pCount);
                    $(supplier_quantity[k]).attr('id', 'supplier_quantity_' + count + '_' + grade_count + '_' + pCount);
                    $(supplier_quantity[k]).attr('class', 'text-fields supplier_quantity supplier_quantityClass_' + count + '_' + grade_count);

                    $(supplier_value[k]).attr('name', 'supplier_value_' + count + '_' + grade_count + '_' + pCount);
                    $(supplier_value[k]).attr('id', 'supplier_value_' + count + '_' + grade_count + '_' + pCount);
                    $(supplier_value[k]).attr('class', 'text-fields supplier_value supplier_valueClass_' + count + '_' + grade_count);
                }
                if (this.fType == 'N') {
                    for (var m = 0; m < import_value.length; m++) {
                        var icount = m + 1;
                        $(import_country[m]).attr('name', 'import_country_' + count + '_' + grade_count + '_' + icount);
                        $(import_country[m]).attr('id', 'import_country_' + count + '_' + grade_count + '_' + icount);
                        $(import_country[m]).attr('class', 'text-fields import_country import_countryClass_' + count + '_' + grade_count);

                        $(import_quantity[m]).attr('name', 'import_quantity_' + count + '_' + grade_count + '_' + icount);
                        $(import_quantity[m]).attr('id', 'import_quantity_' + count + '_' + grade_count + '_' + icount);
                        $(import_quantity[m]).attr('class', 'text-fields import_quantity import_quantityClass_' + count + '_' + grade_count);

                        $(import_value[m]).attr('name', 'import_value_' + count + '_' + grade_count + '_' + icount);
                        $(import_value[m]).attr('id', 'import_value_' + count + '_' + grade_count + '_' + icount);
                        $(import_value[m]).attr('class', 'text-fields import_value import_value_' + count + '_' + grade_count);
                    }
                }
                //Code for the consume section
                if (this.tabType == 3)
                {
                    var consume_quantity = $(".consume_quantity_" + mineralCount);
                    var consume_value = $(".consume_value_" + mineralCount);

                    $(consume_quantity[j]).attr('name', 'consumeQuantity_' + count + '_' + grade_count);
                    $(consume_quantity[j]).attr('id', 'consumeQuantity_' + count + '_' + grade_count);
                    $(consume_quantity[j]).attr('class', 'text-fields consume_quantity consume_quantity_' + count);

                    $(consume_value[j]).attr('name', 'consumeValue_' + count + '_' + grade_count);
                    $(consume_value[j]).attr('id', 'consumeValue_' + count + '_' + grade_count);
                    $(consume_value[j]).attr('class', 'text-fields consume_value consume_value_' + count);
                }

                var buyer_regNo = $(".buyer_regNoClass_" + mineralCount + '_' + classCountForgrade);
                var buyer_quantity = $(".buyer_quantityClass_" + mineralCount + '_' + classCountForgrade);
                var buyer_value = $(".buyer_valueClass_" + mineralCount + '_' + classCountForgrade);

                for (var n = 0; n < buyer_value.length; n++) {
                    var ncount = n + 1;
                    $(buyer_regNo[n]).attr('name', 'buyer_' + this.despatchValue + '_' + count + '_' + grade_count + '_' + ncount);
                    $(buyer_regNo[n]).attr('id', 'buyer_regNo_' + count + '_' + grade_count + '_' + ncount);
                    $(buyer_regNo[n]).attr('class', 'text-fields buyer_registration buyer_regNoClass_' + count + '_' + grade_count);

                    $(buyer_quantity[n]).attr('name', 'buyer_quantity_' + count + '_' + grade_count + '_' + ncount);
                    $(buyer_quantity[n]).attr('id', 'buyer_quantity_' + count + '_' + grade_count + '_' + ncount);
                    $(buyer_quantity[n]).attr('class', 'text-fields buyer_quantity buyer_quantityClass_' + count + '_' + grade_count);

                    $(buyer_value[n]).attr('name', 'buyer_value_' + count + '_' + grade_count + '_' + ncount);
                    $(buyer_value[n]).attr('id', 'buyer_value_' + count + '_' + grade_count + '_' + ncount);
                    $(buyer_value[n]).attr('class', 'text-fields buyer_value buyer_valueClass_' + count + '_' + grade_count);
                }
                $(closing_stock[j]).attr('name', 'closing_stock_' + count + '_' + grade_count);
                $(closing_stock[j]).attr('id', 'closing_stock_' + count + '_' + grade_count);
                $(closing_stock[j]).attr('class', 'text-fields closing_stock closing_stock_' + count);
                this.mineralCount.value = count;
            }
        }
    },
    renameSupplierBoxes: function(mineralNo, gradeNo) {
        var supplier_reg_no = $(".supplier_reg_noClass_" + mineralNo + '_' + gradeNo);
        var supplier_quantity = $(".supplier_quantityClass_" + mineralNo + '_' + gradeNo);
        var supplier_value = $(".supplier_valueClass_" + mineralNo + '_' + gradeNo);
        for (var j = 0; j < supplier_value.length; j++) {
            var count = j + 1;
            $(supplier_reg_no[j]).attr('name', 'reg_no_' + mineralNo + '_' + gradeNo + '_' + count);
            $(supplier_reg_no[j]).attr('id', 'reg_no_' + mineralNo + '_' + gradeNo + '_' + count);

            $(supplier_quantity[j]).attr('name', 'supplier_quantity_' + mineralNo + '_' + gradeNo + '_' + count);
            $(supplier_quantity[j]).attr('id', 'supplier_quantity_' + mineralNo + '_' + gradeNo + '_' + count);

            $(supplier_value[j]).attr('name', 'supplier_value_' + mineralNo + '_' + gradeNo + '_' + count);
            $(supplier_value[j]).attr('id', 'supplier_value_' + mineralNo + '_' + gradeNo + '_' + count);
        }
    },
    renameImportBoxes: function(mineralNo, gradeNo) {
        var import_country = $(".import_countryClass_" + mineralNo + '_' + gradeNo);
        var import_quantity = $(".import_quantityClass_" + mineralNo + '_' + gradeNo);
        var import_value = $(".import_value_" + mineralNo + '_' + gradeNo);
        for (var j = 0; j < import_value.length; j++) {
            var count = j + 1;
            $(import_country[j]).attr('name', 'import_country_' + mineralNo + '_' + gradeNo + '_' + count);
            $(import_country[j]).attr('id', 'import_country_' + mineralNo + '_' + gradeNo + '_' + count);

            $(import_quantity[j]).attr('name', 'import_quantity_' + mineralNo + '_' + gradeNo + '_' + count);
            $(import_quantity[j]).attr('id', 'import_quantity_' + mineralNo + '_' + gradeNo + '_' + count);

            $(import_value[j]).attr('name', 'import_value_' + mineralNo + '_' + gradeNo + '_' + count);
            $(import_value[j]).attr('id', 'import_value_' + mineralNo + '_' + gradeNo + '_' + count);
        }
    },
    renamebuyerBoxes: function(mineralNo, gradeNo) {
        var buyer_regNo = $(".buyer_regNoClass_" + mineralNo + '_' + gradeNo);
        var buyer_quantity = $(".buyer_quantityClass_" + mineralNo + '_' + gradeNo);
        var buyer_value = $(".buyer_valueClass_" + mineralNo + '_' + gradeNo);
        for (var j = 0; j < buyer_value.length; j++) {
            var count = j + 1;
            $(buyer_regNo[j]).attr('name', 'buyer_' + this.despatchValue + '_' + mineralNo + '_' + gradeNo + '_' + count);
            $(buyer_regNo[j]).attr('id', 'buyer_regNo_' + mineralNo + '_' + gradeNo + '_' + count);

            $(buyer_quantity[j]).attr('name', 'buyer_quantity_' + mineralNo + '_' + gradeNo + '_' + count);
            $(buyer_quantity[j]).attr('id', 'buyer_quantity_' + mineralNo + '_' + gradeNo + '_' + count);

            $(buyer_value[j]).attr('name', 'buyer_value_' + mineralNo + '_' + gradeNo + '_' + count);
            $(buyer_value[j]).attr('id', 'buyer_value_' + mineralNo + '_' + gradeNo + '_' + count);
        }
    },
    fillData: function(tabType) {
        // Initiliaing the total_mineral count to 1 as one row will always be there
        var total_mineral = this.mineralObject.length;
        //        console.log(this.mineralObject)
        //        console.log("this.mineralObject")


        var row = $(document.createElement('tr'));

        var mineralList = [];

        var grdNo = 0;
        var elem_no = 0;

        for (var i = 0; i < total_mineral; i++) {
            this.startValue = i;
            this.supllierCount = this.gradeObject[i].supplier.supplierCount;
            this.importCount = this.gradeObject[i].importData.importCount;
            this.despatchCount = this.gradeObject[i].despatch.despatchCount;
            this.mineral_name = this.mineralObject[i].LOCAL_MINERAL_CODE;
            this.grade_code = this.mineralObject[i].LOCAL_GRADE_CODE;

            this.consume_quantity = this.gradeObject[i].consumeData['QUANTITY'];
            this.consume_value = this.gradeObject[i].consumeData['VALUE'];
            //this.gradeObject[parseInt(this.startValue)].importData['QUANTITY_'+ impData];
            if (this.fType == 'O') {
                this.import_quantity = this.gradeObject[i].importData['QUANTITY_1'];
                this.import_value = this.gradeObject[i].importData['VALUE_1'];
            }

            this.opening_stock = this.mineralObject[i].OPENING_STOCK;
            this.closing_stock = this.mineralObject[i].CLOSING_STOCK;
            this.mineralUnit = this.mineralObject[i].MINERAL_UNIT;
            if (jQuery.inArray(this.mineralObject[i].LOCAL_MINERAL_CODE, mineralList) == -1)
            {
                var elem_no = elem_no + 1;
                grdNo = 1;
                this.createMineralBox(elem_no, grdNo);
                $("#grade_cnt_" + elem_no).val(grdNo);
            } else
{
                grdNo++;
                var row = $(document.createElement('tr'));
                row.attr("id", "mineralForRow_" + elem_no + '_' + grdNo);
                row.addClass("mineralMenu_" + elem_no + " " + "mineralSubMenu_" + elem_no + '_' + grdNo);
                this.traditionTable.append(row);
                var counterNo = 1;
                this.createGradeBox(row, elem_no, grdNo, counterNo, 0, 1);
                $("#grade_cnt_" + elem_no).val(grdNo);
            }

            if (jQuery.inArray(this.mineralObject[i].LOCAL_MINERAL_CODE, mineralList) == -1)
            {
                mineralList.push(this.mineralObject[i].LOCAL_MINERAL_CODE);
            }

            $.ajax({
                url: this.gradeUrl,
                type: "POST",
				async: false,
                data: ({
                    value: this.mineralObject[i].LOCAL_MINERAL_CODE
                }),
                async: false,
                success: function(data) {

                    $("#grade_" + elem_no + "_" + grdNo)
                    .find('option')
                    .remove();
                    var mySelect = $("#grade_" + elem_no + "_" + grdNo);
                    var myOptions = json_parse(data);
                    // ADDED BY UDAY... FOR ADDING THE NIL OPTION IN THE DROP DOWN
                    // IF THE NO OF FILED IS ONE THEN ONLY ADD THE NIL IN THE OPTIONS LIST ELSE NOT REQUIRED
                    var countMineralField = $(".mineral").length;
                    if (countMineralField == 1) {
                        var optionNil = $(document.createElement('option'));
                        optionNil.html('NIL');
                        optionNil.val(201);
                        mySelect.append(optionNil);
                    }

                    $.each(myOptions.gradeData, function(val, text) {
                        mySelect.append(
                            $('<option></option>').val(val).html(text));
                    });
                }
            });
            this.mineralCount.value = elem_no;
            $("#mineral_cnt").val(elem_no);
            $("#grade_" + elem_no + "_" + grdNo).val(this.grade_code);
            
            $("<span id='unitSpan_mineral_" + elem_no + "'><b>" + this.mineralUnit + "</b></span>").insertAfter($("#mineral_" + elem_no));
        }
        //console.log(mineralList)
        this.addMoreGrade('', tabType);
        this.addMoreSupplierBox();
        //    if(this.fType == 'N')  NEED TO CHECK THE USER OF THIS CONDITION --- UDAY SHANKAR SINGH
        this.addMoreImportBox(tabType);
        this.addMoreBuyerBox();
        /**
         * @author: Uday Shankar Singh
         * CHECKING HERE AGAIN THE SAME CONDITION CHECKED IN AJAX CALL ...
         * DOING THIS AS THE FUNCTION CAN'T BE CALLED FROM INSIDE THE AJAX 
         **/
        var countMineralField = $(".mineral").length;
        if (countMineralField == 1) {
            var getElementVal = $(".mineral").val();
            if (getElementVal == 'NIL') {
                this.hideForNil(false);
            }
        }

    },
    createminBuyerBox: function(mineralNo, gradeNo, counterNo) {
        var _this = this;
        //elem_no=>Mineral no ,gradeNo=>grade no ,OreNo=> Counter for the Supplier ,Import and Buyer section
        var buyer_regNo_container_tr = $(document.createElement('tr'));
        _this.buyerTable.append(buyer_regNo_container_tr);
        //buyered Registration No
        var buyer_regNo_container_td = $(document.createElement('td'));
        buyer_regNo_container_td.css("width", "48");
        buyer_regNo_container_tr.append(buyer_regNo_container_td);

        var input_buyer_regNo = $(document.createElement('input'));
        input_buyer_regNo.attr("id", "buyer_regNo_" + mineralNo + '_' + gradeNo + '_' + counterNo);
        input_buyer_regNo.attr("name", "buyer_" + _this.despatchValue + "_" + mineralNo + '_' + gradeNo + '_' + counterNo);
        input_buyer_regNo.addClass("text-fields buyer_registration buyer_regNoClass_" + mineralNo + "_" + gradeNo);
        input_buyer_regNo.css("width", "80px");
        buyer_regNo_container_td.append(input_buyer_regNo);
        if (_this.buyer_reg_no != "")
            input_buyer_regNo.val(_this.buyer_reg_no);

        var select_box_container_regSearchNo = $(document.createElement('td'));
        select_box_container_regSearchNo.css("padding", "0px");
        buyer_regNo_container_tr.append(select_box_container_regSearchNo);

        var img = $(document.createElement("img"));
        img.attr("src", this.imagepath + "search.jpg");
        img.attr("title", _this.SearchMessage);
        img.attr("alt", _this.SearchMessage);
        img.attr("border", "0");
        img.attr("id", "buyer_regSearchNo_" + mineralNo + "_" + gradeNo + "_" + counterNo);
        img.addClass('Serarch_img_td');
        select_box_container_regSearchNo.append(img)

        //buyered Quantity
        var buyer_quantity_container = $(document.createElement('td'));
        buyer_quantity_container.attr("align", "center");
        buyer_quantity_container.addClass("class", "lable-text");
        buyer_regNo_container_tr.append(buyer_quantity_container);

        var input_buyer_quantity = $(document.createElement('input'));
        input_buyer_quantity.attr("id", "buyer_quantity_" + mineralNo + '_' + gradeNo + '_' + counterNo);
        input_buyer_quantity.attr("name", "buyer_quantity_" + mineralNo + '_' + gradeNo + '_' + counterNo);
        input_buyer_quantity.addClass("right text-fields buyer_quantity buyer_quantityClass_" + mineralNo + "_" + gradeNo);
        input_buyer_quantity.css("width", "110px");
        buyer_quantity_container.append(input_buyer_quantity);
        if (_this.buyer_quantity != "")
            input_buyer_quantity.val(_this.buyer_quantity);

        //buyered Value
        var buyer_value_container = $(document.createElement('td'));
        buyer_value_container.attr("align", "center");
        buyer_value_container.attr("class", "lable-text");
        buyer_regNo_container_tr.append(buyer_value_container);

        var input_buyer_value = $(document.createElement('input'));
        input_buyer_value.attr("id", "buyer_value_" + mineralNo + '_' + gradeNo + '_' + counterNo);
        input_buyer_value.attr("name", "buyer_value_" + mineralNo + '_' + gradeNo + '_' + counterNo);
        input_buyer_value.addClass("right text-fields buyer_value buyer_valueClass_" + mineralNo + "_" + gradeNo);
        input_buyer_value.css("width", "100px");
        buyer_value_container.append(input_buyer_value);
        if (_this.buyer_value != "")
            input_buyer_value.val(_this.buyer_value);

        if (counterNo > 1)
        {
            var close_td = $(document.createElement('td'));
            close_td.addClass("h-close-icon");
            close_td.bind('click', function() {
                $(this).parent().remove();
                _this.renamebuyerBoxes(mineralNo, gradeNo);
                var imp_cnt = $("#despatch_cnt_" + mineralNo + '_' + gradeNo).val();
                $("#despatch_cnt_" + mineralNo + '_' + gradeNo).val(parseInt(imp_cnt) - 1);
            });
            buyer_regNo_container_tr.append(close_td)
        }
    //        console.log("1")
    //        _this.autocomplete(_this.tabType);
    },
    createminImportBox: function(mineralNo, gradeNo, OreNo) {
        var _this = this;

        //elem_no=>Mineral no ,gradeNo=>grade no ,OreNo=> Counter for the Supplier ,Import and Buyer section

        var import_country_container_tr = $(document.createElement('tr'));
        _this.importQuantityTable.append(import_country_container_tr);

        //Country
        var import_country_container_td = $(document.createElement('td'));
        import_country_container_td.css("width", "48");
        import_country_container_tr.append(import_country_container_td);

        var input_import_country = $(document.createElement('input'));
        input_import_country.attr("id", "import_country_" + mineralNo + "_" + gradeNo + "_" + OreNo);
        input_import_country.attr("name", "import_country_" + mineralNo + "_" + gradeNo + "_" + OreNo);
        input_import_country.addClass("text-fields import_country import_countryClass_" + mineralNo + "_" + gradeNo);
        input_import_country.css("width", "80px");
        import_country_container_td.append(input_import_country);
        if (_this.import_country != null)
            input_import_country.val(_this.import_country);

        var select_box_container_regSearchNo = $(document.createElement('td'));
        select_box_container_regSearchNo.css("padding", "0px");
        import_country_container_tr.append(select_box_container_regSearchNo);

        var img = $(document.createElement("img"));
        img.attr("src", this.imagepath + "search.jpg");
        img.attr("title", "Search Country Name");
        img.attr("alt", "Search Country Name");
        img.attr("border", "0");
        img.attr("id", "import_regSearchNo_" + mineralNo + "_" + gradeNo + "_" + OreNo);
        img.addClass('Serarch_img_td');
        select_box_container_regSearchNo.append(img);

        //Quantity
        var import_quantity_container = $(document.createElement('td'));
        import_quantity_container.attr("align", "center");
        import_quantity_container.attr("class", "lable-text");
        import_country_container_tr.append(import_quantity_container);

        var input_import_quantity = $(document.createElement('input'));
        input_import_quantity.attr("id", "import_quantity_" + mineralNo + "_" + gradeNo + "_" + OreNo);
        input_import_quantity.attr("name", "import_quantity_" + mineralNo + "_" + gradeNo + "_" + OreNo);
        input_import_quantity.addClass("right text-fields import_quantity import_quantityClass_" + mineralNo + "_" + gradeNo);
        input_import_quantity.css("width", "110px");
        //input_import_quantity.attr("title","Format: 000.000");
        import_quantity_container.append(input_import_quantity);
        if (_this.import_quantity != null)
            input_import_quantity.val(_this.import_quantity);
        //Values
        var import_value_container = $(document.createElement('td'));
        import_value_container.attr("align", "center");
        import_value_container.attr("class", "lable-text");
        import_country_container_tr.append(import_value_container);

        var input_import_value = $(document.createElement('input'));
        input_import_value.attr("id", "import_value_" + mineralNo + "_" + gradeNo + "_" + OreNo);
        input_import_value.attr("name", "import_value_" + mineralNo + "_" + gradeNo + "_" + OreNo);
        input_import_value.addClass("right text-fields import_value import_value_" + mineralNo + "_" + gradeNo);
        input_import_value.css("width", "100px");
        import_value_container.append(input_import_value);
        if (_this.import_value != null)
            input_import_value.val(_this.import_value);
        if (OreNo > 1)
        {
            var close_td = $(document.createElement('td'));
            close_td.addClass("h-close-icon");
            close_td.bind('click', function() {
                $(this).parent().remove();
                _this.renameImportBoxes(mineralNo, gradeNo);
                var imp_cnt = $("#import_cnt_" + mineralNo + '_' + gradeNo).val();
                $("#import_cnt_" + mineralNo + '_' + gradeNo).val(parseInt(imp_cnt) - 1);
            });
            import_country_container_tr.append(close_td)
        }
    //        console.log("2")
    //        _this.autocomplete(_this.tabType);
    },
    createRegSupplierBox: function(mineralNo, gradeNo, OreNo) {
        var _this = this;
        //elem_no=>Mineral no ,gradeNo=>grade no ,OreNo=> Counter for the Supplier ,Import and Buyer section
        var select_box_container_reg_no_tr = $(document.createElement('tr'));
        _this.supplierTable.append(select_box_container_reg_no_tr);
        //Registration Number
        var select_box_container_reg_no_td = $(document.createElement('td'));
        select_box_container_reg_no_td.css("width", "48");
        select_box_container_reg_no_tr.append(select_box_container_reg_no_td);

        var select_box_input_reg_no = $(document.createElement('input'));
        select_box_input_reg_no.attr("id", "reg_no_" + mineralNo + "_" + gradeNo + "_" + OreNo);
        select_box_input_reg_no.attr("name", "reg_no_" + mineralNo + "_" + gradeNo + "_" + OreNo);
        select_box_input_reg_no.addClass("right text-fields supplier_registration supplier_reg_noClass_" + mineralNo + "_" + gradeNo);
        select_box_input_reg_no.css("width", "80px");
        select_box_container_reg_no_td.append(select_box_input_reg_no);

        if (_this.supplier_reg_no != "")
            select_box_input_reg_no.val(_this.supplier_reg_no);

        var select_box_container_regSearchNo = $(document.createElement('td'));
        select_box_container_regSearchNo.css("padding", "0px");

        select_box_container_reg_no_tr.append(select_box_container_regSearchNo);
        var img = $(document.createElement("img"));
        img.attr("src", this.imagepath + "search.jpg");
        img.attr("title", "Search Registration Number");
        img.attr("alt", "Search Registration Number");
        img.attr("border", "0");
        img.attr("id", "supplier_regSearch1111No_" + mineralNo + "_" + gradeNo + "_" + OreNo);
        img.addClass('Serarch_img_td');

        select_box_container_regSearchNo.append(img)

        //Quantity
        var supplier_quantity_container = $(document.createElement('td'));
        supplier_quantity_container.attr("align", "center");
        supplier_quantity_container.attr("class", "lable-text");
        select_box_container_reg_no_tr.append(supplier_quantity_container);

        var input_supplier_quantity = $(document.createElement('input'));
        input_supplier_quantity.attr("id", "supplier_quantity_" + mineralNo + "_" + gradeNo + "_" + OreNo);
        input_supplier_quantity.attr("name", "supplier_quantity_" + mineralNo + "_" + gradeNo + "_" + OreNo);
        input_supplier_quantity.addClass("right text-fields supplier_quantity supplier_quantityClass_" + mineralNo + "_" + gradeNo);
        input_supplier_quantity.css("width", "110px");
        //input_supplier_quantity.attr("title","Format: 000.000");
        supplier_quantity_container.append(input_supplier_quantity);
        if (_this.supplier_quantity != "")
            input_supplier_quantity.val(_this.supplier_quantity);
        //Value
        var supplier_value_container = $(document.createElement('td'));
        supplier_value_container.attr("align", "center");
        supplier_value_container.attr("class", "lable-text");
        select_box_container_reg_no_tr.append(supplier_value_container);

        var input_supplier_value = $(document.createElement('input'));
        input_supplier_value.attr("id", "supplier_value_" + mineralNo + "_" + gradeNo + "_" + OreNo);
        input_supplier_value.attr("name", "supplier_value_" + mineralNo + "_" + gradeNo + "_" + OreNo);
        input_supplier_value.addClass("right text-fields supplier_value supplier_valueClass_" + mineralNo + "_" + gradeNo);
        input_supplier_value.css("width", "100px");
        //input_supplier_value.attr("title","Format: 000.000");
        if (_this.supplier_value != "")
            input_supplier_value.val(_this.supplier_value);
        supplier_value_container.append(input_supplier_value);
        if (OreNo > 1)
        {
            var close_td = $(document.createElement('td'));
            close_td.addClass("h-close-icon");
            close_td.bind('click', function() {
                $(this).parent().remove();
                _this.renameSupplierBoxes(mineralNo, gradeNo);
                var supp_cnt = $("#purchase_cnt_" + mineralNo + '_' + gradeNo).val();
                $("#purchase_cnt_" + mineralNo + '_' + gradeNo).val(parseInt(supp_cnt) - 1);
            });
            select_box_container_reg_no_tr.append(close_td);
        }
    },
    createconsumeImportBox: function(row, mineralNo, gradeNo, OreNo) {
        var _this = this;
        //mineralNo=>Mineral no ,gradeNo=>grade no ,OreNo=> Counter for the consumed seaction
        var select_consume_quantity_td = $(document.createElement('td'));
        select_consume_quantity_td.attr("align", "center");
        select_consume_quantity_td.attr("rowspan", "2");
        row.append(select_consume_quantity_td);

        var select_box_input_quantity = $(document.createElement('input'));
        select_box_input_quantity.attr("id", "consumeQuantity_" + mineralNo + "_" + gradeNo);
        select_box_input_quantity.attr("name", "consumeQuantity_" + mineralNo + "_" + gradeNo);
        select_box_input_quantity.addClass("right text-fields consume_quantity consume_quantity_" + mineralNo);
        select_box_input_quantity.css("width", "110px");
        select_consume_quantity_td.append(select_box_input_quantity);
        if (this.consume_quantity != "" && typeof(this.consume_quantity) != 'undefined')
            select_box_input_quantity.val(this.consume_quantity);

        var select_consume_value_td = $(document.createElement('td'));
        select_consume_value_td.attr("align", "center");
        select_consume_value_td.attr("rowspan", "2");
        row.append(select_consume_value_td);

        var select_box_input_value = $(document.createElement('input'));
        select_box_input_value.attr("id", "consumeValue_" + mineralNo + "_" + gradeNo);
        select_box_input_value.attr("name", "consumeValue_" + mineralNo + "_" + gradeNo);
        select_box_input_value.addClass("right text-fields consume_value consume_value_" + mineralNo);
        select_box_input_value.css("width", "110px");
        select_consume_value_td.append(select_box_input_value);
        if (this.consume_value != "" && typeof(this.consume_value) != 'undefined')
            select_box_input_value.val(this.consume_value);
    },
    createGradeBox: function(row, mineralNo, gradeNo, counterNo, pregradeNo, filterCounter) {
        var _this = this;
        //filterCounter 0 => Click from Add More ( Mineral )
        //filterCounter 1 => Click from Add More ( Grade )
        //row =>Current row Object , mineralNo=>Mineral no ,gradeNo=>grade no ,pregradeNo=> Previous grade Counter
        if (filterCounter == 1)
        {
            var rowspan = "2";
            var select_box_mineral = $(document.createElement('td'));
            select_box_mineral.attr('align', 'center');
            select_box_mineral.attr('rowspan', "2");
            row.append(select_box_mineral);
        } else
            var rowspan = "3";

        //Start grade select box
        var select_box_container_grade = $(document.createElement('td'));
        select_box_container_grade.attr('align', 'center');
        select_box_container_grade.attr('valign', 'middle');
        select_box_container_grade.attr('rowspan', '2');
        row.append(select_box_container_grade);

        var select_box_grade = $(document.createElement('select'));
        select_box_grade.attr("id", 'grade_' + mineralNo + '_' + gradeNo);
        select_box_grade.attr("name", 'grade_' + mineralNo + '_' + gradeNo);
        select_box_grade.addClass("h-selectbox grade grade_select_" + mineralNo);
        select_box_grade.css("width", '120px');
        select_box_container_grade.append(select_box_grade);

        var options = $(document.createElement('option'));
        options.html('--- Select grade ---');
        options.val('');
        select_box_grade.append(options);
        /*
         $.each( _this.data.gradeData, function( index, item ) {
         var options = $(document.createElement('option'));
         options.html(item);
         options.val(index);
         select_box_grade.append(options);
         }); 
         
         
         if(this.grade_code != "" && this.grade_code != "undefined")
         select_box_grade.val(this.grade_code);
         */
        //Start Opening stack TD
        var select_box_container_opening_stock = $(document.createElement('td'));
        select_box_container_opening_stock.attr('align', 'center');
        select_box_container_opening_stock.attr('class', 'lable-text');
        select_box_container_opening_stock.attr('rowspan', '2');
        select_box_container_opening_stock.attr('valign', 'middle');
        row.append(select_box_container_opening_stock);

        var select_box_opening_stock = $(document.createElement('input'));
        select_box_opening_stock.attr("id", 'opening_stock_quantity_' + mineralNo + '_' + gradeNo);
        select_box_opening_stock.attr("name", 'opening_stock_quantity_' + mineralNo + '_' + gradeNo);
        select_box_opening_stock.addClass('right text-fields opening_stock_quantity opening_stock_quantity_' + mineralNo);
        select_box_opening_stock.css("width", '110px');
        select_box_container_opening_stock.append(select_box_opening_stock);
        if (_this.opening_stock != "" && typeof(_this.opening_stock) != 'undefined')
            select_box_opening_stock.val(_this.opening_stock);

        //Start supplier During the Month
        var select_box_container_reg_no = $(document.createElement('td'));
        select_box_container_reg_no.attr("align", "center");
        select_box_container_reg_no.attr("class", "lable-text");
        select_box_container_reg_no.attr("colspan", "3");
        row.append(select_box_container_reg_no);

        var select_box_container_reg_no_table = $(document.createElement('table'));
        select_box_container_reg_no_table.attr("cellpadding", "4");
        select_box_container_reg_no_table.attr("cellspacing", "0");
        select_box_container_reg_no_table.attr("width", "100%");
        select_box_container_reg_no_table.attr("border", "1");
        select_box_container_reg_no_table.attr("bordercolor", "#E5D0BD");
        select_box_container_reg_no_table.attr('style', 'border-collapse:collapse;');
        select_box_container_reg_no_table.attr("id", "supplier_table_" + mineralNo + '_' + gradeNo + '_' + counterNo);
        select_box_container_reg_no.append(select_box_container_reg_no_table);

        var select_box_container_reg_no_tr = $(document.createElement('tr'));
        select_box_container_reg_no_table.append(select_box_container_reg_no_tr);
        if (this.supllierCount == "")
        {
            _this.supplierTable = $('#supplier_table_' + mineralNo + '_' + gradeNo + '_' + counterNo);
            _this.createRegSupplierBox(mineralNo, gradeNo, counterNo);
            var supplier_cnt = 1;
        } else
{
            for (var supData = 1; supData <= this.supllierCount; supData++)
            {
                _this.supplier_reg_no = this.gradeObject[parseInt(this.startValue)].supplier['REGISTRATION_NO_' + supData];
                _this.supplier_quantity = this.gradeObject[parseInt(this.startValue)].supplier['QUANTITY_' + supData];
                _this.supplier_value = this.gradeObject[parseInt(this.startValue)].supplier['VALUE_' + supData];
                _this.supplierTable = $('#supplier_table_' + mineralNo + '_' + gradeNo + '_' + counterNo);
                _this.createRegSupplierBox(mineralNo, gradeNo, supData);
            }
            var supplier_cnt = this.supllierCount;
        }
        var input_hidden_purchase = $(document.createElement('input'));
        input_hidden_purchase.attr("type", "hidden");
        input_hidden_purchase.attr("id", "purchase_cnt_" + mineralNo + "_" + gradeNo);
        input_hidden_purchase.attr("name", "purchase_cnt_" + mineralNo + "_" + gradeNo);
        input_hidden_purchase.attr("value", supplier_cnt);
        select_box_container_reg_no.append(input_hidden_purchase);
        //======= Call createminImportBox function for the Ore imported during the Month===============================      

        //Start ORE Imported During The Month
        var import_country_container = $(document.createElement('td'));
        import_country_container.attr("align", "center");
        import_country_container.attr("class", "lable-text");
        import_country_container.attr("colspan", "3");
        row.append(import_country_container);

        var import_country_container_table = $(document.createElement('table'));
        import_country_container_table.attr("id", "import_table_" + mineralNo + '_' + gradeNo + '_' + counterNo);
        import_country_container_table.attr("cellpadding", "4");
        import_country_container_table.attr("cellspacing", "0");
        import_country_container_table.attr("border", "1");
        import_country_container_table.attr("bordercolor", "#E5D0BD");
        import_country_container_table.attr('style', 'border-collapse:collapse;');
        import_country_container.append(import_country_container_table);

        var import_country_container_tr = $(document.createElement('tr'));
        import_country_container_table.append(import_country_container_tr);

        if (this.importCount == "")
        {
            _this.importQuantityTable = $('#import_table_' + mineralNo + '_' + gradeNo + '_' + counterNo);
            _this.createminImportBox(mineralNo, gradeNo, counterNo);
            var import_count = 1;
        } else
{
            for (var impData = 1; impData <= this.importCount; impData++)
            {
                _this.import_country = this.gradeObject[parseInt(this.startValue)].importData['COUNTRY_NAME_' + impData];
                _this.import_quantity = this.gradeObject[parseInt(this.startValue)].importData['QUANTITY_' + impData];
                _this.import_value = this.gradeObject[parseInt(this.startValue)].importData['VALUE_' + impData];
                _this.importQuantityTable = $('#import_table_' + mineralNo + '_' + gradeNo + '_' + counterNo);
                _this.createminImportBox(mineralNo, gradeNo, impData);
            }
            var import_count = this.importCount;
        }
        var input_hidden_import = $(document.createElement('input'));
        input_hidden_import.attr("type", "hidden");
        input_hidden_import.attr("id", "import_cnt_" + mineralNo + "_" + gradeNo);
        input_hidden_import.attr("name", "import_cnt_" + mineralNo + "_" + gradeNo);
        input_hidden_import.attr("value", import_count);
        import_country_container_table.append(input_hidden_import);

        //=========Call createconsumeImportBox function for the Ore consumed during the month============================
        //         if(_this.tabType == 3)
        //            _this.createconsumeImportBox(row,mineralNo, gradeNo,counterNo);
        var setcolspan = 12
        if (_this.tabType == 3)
        {
            _this.createconsumeImportBox(row, mineralNo, gradeNo, counterNo);
            setcolspan = 14;
        }

        //Start ORE Dispatched during the month
        var buyer_country_container = $(document.createElement('td'));
        buyer_country_container.attr("align", "center");
        buyer_country_container.attr("class", "lable-text");
        buyer_country_container.attr("colspan", "3");
        row.append(buyer_country_container);

        var buyer_regNo_container_table = $(document.createElement('table'));
        buyer_regNo_container_table.attr("id", "buyer_table_" + mineralNo + '_' + gradeNo + '_' + counterNo);
        buyer_regNo_container_table.attr("cellpadding", "4");
        buyer_regNo_container_table.attr("cellspacing", "0");
        buyer_regNo_container_table.attr("border", "1");
        buyer_regNo_container_table.attr("bordercolor", "#E5D0BD");
        buyer_regNo_container_table.attr('style', 'border-collapse:collapse;');
        buyer_country_container.append(buyer_regNo_container_table);

        var buyer_regNo_container_tr = $(document.createElement('tr'));
        buyer_regNo_container_table.append(buyer_regNo_container_tr);

        //======= Call createminBuyerBox function for the Ore imported during the Month===============================
        if (this.despatchCount == "")
        {
            _this.buyerTable = $('#buyer_table_' + mineralNo + '_' + gradeNo + '_' + counterNo);
            _this.createminBuyerBox(mineralNo, gradeNo, counterNo);
            var dispatch_cnt = 1;
        } else
{
            for (var buyerData = 1; buyerData <= this.despatchCount; buyerData++)
            {
                if (_this.tabType == 2)
                    _this.buyer_reg_no = this.gradeObject[parseInt(this.startValue)].despatch['COUNTRY_NAME_' + buyerData];
                else
                    _this.buyer_reg_no = this.gradeObject[parseInt(this.startValue)].despatch['REGISTRATION_NO_' + buyerData];

                _this.buyer_quantity = this.gradeObject[parseInt(this.startValue)].despatch['QUANTITY_' + buyerData];
                _this.buyer_value = this.gradeObject[parseInt(this.startValue)].despatch['VALUE_' + buyerData];
                _this.buyerTable = $('#buyer_table_' + mineralNo + '_' + gradeNo + '_' + counterNo);
                _this.createminBuyerBox(mineralNo, gradeNo, buyerData);
            }
            var dispatch_cnt = this.despatchCount;
        }
        var input_hidden_despatch = $(document.createElement('input'));
        input_hidden_despatch.attr("type", "hidden");
        input_hidden_despatch.attr("id", "despatch_cnt_" + mineralNo + "_" + gradeNo);
        input_hidden_despatch.attr("name", "despatch_cnt_" + mineralNo + "_" + gradeNo);
        input_hidden_despatch.attr("value", dispatch_cnt);
        buyer_regNo_container_table.append(input_hidden_despatch);

        //Start Closing Stock TD
        var closing_stock_container = $(document.createElement('td'));
        closing_stock_container.attr('align', 'center');
        closing_stock_container.attr('class', 'lable-text');
        closing_stock_container.attr('rowspan', '2');
        closing_stock_container.attr('valign', 'middle');
        row.append(closing_stock_container);

        var input_closing_stock = $(document.createElement('input'));
        input_closing_stock.attr("id", 'closing_stock_' + mineralNo + '_' + gradeNo);
        input_closing_stock.attr("name", 'closing_stock_' + mineralNo + '_' + gradeNo);
        input_closing_stock.addClass("right text-fields closing_stock closing_stock_" + mineralNo);
        input_closing_stock.css("width", '100px');
        closing_stock_container.append(input_closing_stock);
        if (_this.closing_stock != "" && typeof(_this.closing_stock) != 'undefined')
            input_closing_stock.val(_this.closing_stock);

        //code for the Add more (Supplier)
        var rowSuppierMore = $(document.createElement('tr'));
        rowSuppierMore.attr("id", "mineralForgradeRow_" + mineralNo + '_' + gradeNo);
        rowSuppierMore.addClass("mineralMenu_" + mineralNo + " " + "mineralSubMenu_" + mineralNo + '_' + gradeNo);
        this.traditionTable.append(rowSuppierMore);

        var add_supplier_container12 = $(document.createElement('td'));
        add_supplier_container12.attr('colspan', '3');
        add_supplier_container12.attr('align', 'left');
        rowSuppierMore.append(add_supplier_container12);

        var divTag12 = $(document.createElement('div'));
        divTag12.attr("id", "add_more_supplier_" + mineralNo + "_" + gradeNo + "_" + counterNo);
        divTag12.attr('class', "h-add-more-btn supplier_add_more");
        divTag12.html('Add more (Supplier)');
        divTag12.css("width", "115px");
        add_supplier_container12.append(divTag12);


        //code for the Add more 
        var add_more_container = $(document.createElement('td'));
        add_more_container.attr('align', 'left');
        add_more_container.attr("colspan", "3");
        rowSuppierMore.append(add_more_container);

        var divTag = $(document.createElement('div'));
        divTag.attr('id', 'add_more_import_' + mineralNo + "_" + gradeNo + "_" + counterNo);
        divTag.attr('class', 'h-add-more-btn import_add_more');
        divTag.html('Add more');
        divTag.css("width", "70px");
        add_more_container.append(divTag);

        //Code for the Add more (Buyer)
        var add_buyer_container = $(document.createElement('td'));
        add_buyer_container.attr('colspan', '3');
        add_buyer_container.attr('align', 'left');
        rowSuppierMore.append(add_buyer_container);
        if (_this.tabType == 4)
        {
            var more_buyer_btn = 'Add more (Person/Company)';
            var buyerWidth = '180px';
        }
        else {
            var more_buyer_btn = 'Add more (Buyer)';
            var buyerWidth = '110px';
        }
        var divTag = $(document.createElement('div'));
        divTag.attr('id', 'add_more_buyer_' + mineralNo + "_" + gradeNo + "_" + counterNo);
        divTag.attr('class', 'h-add-more-btn add_more_buyer_btn');
        divTag.html(more_buyer_btn);
        divTag.css("width", buyerWidth);
        add_buyer_container.append(divTag);

        if (filterCounter == 1)
        {
            var title = 'grade';
            if (gradeNo > 2)
                $("#mineralForgradeRow_" + mineralNo + '_' + pregradeNo).after(row);
            else
                $("#supplierForRow_" + mineralNo + '_' + pregradeNo).after(row);

            $("#mineralForRow_" + mineralNo + '_' + gradeNo).after(rowSuppierMore);
        }
        else {
            var title = 'mineral';
            //Code for the Add more ( Grade )
            var rowMore2 = $(document.createElement('tr'));
            rowMore2.attr("id", "supplierForRow_" + mineralNo + '_' + gradeNo)
            rowMore2.addClass("mineralMenu_" + mineralNo + " " + "mineralSubMenu_" + mineralNo + '_' + gradeNo);
            this.traditionTable.append(rowMore2);
            var add_mineral_container2 = $(document.createElement('td'));
            add_mineral_container2.attr("colspan", setcolspan);
            add_mineral_container2.attr("align", "left");
            rowMore2.append(add_mineral_container2);
            //
            var divTag = $(document.createElement('div'));
            divTag.attr('id', "add_grade_" + mineralNo);
            divTag.attr('alt', mineralNo);
            divTag.attr('class', "h-add-more-btn grade_add_more");
            divTag.html("Add More (Grade)");
            divTag.css("width", "110px");
            add_mineral_container2.append(divTag);
        }
        if ((mineralNo > 1) || (gradeNo > 1)) {
            var close_td = $(document.createElement('td'));
            close_td.addClass("h-close-icon");
            close_td.attr("title", title);
            close_td.attr("id", "deleteIcon_" + mineralNo + '_' + gradeNo);
            close_td.attr("alt", mineralNo);
            close_td.attr("lang", gradeNo);
            close_td.attr("rowspan", rowspan);
            close_td.bind('click', function() {
                var getMineralNo = $(this).attr("alt");
                var getgradeNo = $(this).attr("lang");
                var getactivityTitle = $(this).attr("title");
                if (confirm('Are you sure you want to delete?'))
                {
                    if (getactivityTitle == 'mineral')
                    {
                        $(".mineralMenu_" + getMineralNo).remove();
                        var mineral_cnt_value = $("#mineral_cnt").val();
                        $("#mineral_cnt").val(parseInt(mineral_cnt_value) - 1);
                        $("#grade_cnt_" + getMineralNo).remove();

                    }
                    else {

                        $(".mineralSubMenu_" + getMineralNo + '_' + getgradeNo).remove();
                        var grade_cnt_value = $("#grade_cnt_" + getMineralNo).val();
                        $("#grade_cnt_" + getMineralNo).val(parseInt(grade_cnt_value) - 1);
                    }
                    _this.renameMineralBoxes(getMineralNo, getgradeNo, getactivityTitle);
                }
            });
            row.append(close_td);
        }
    },
    gradeMineral: function() {
        var _this = this;
        $(".mineral").unbind('change');
        $('.mineral').change(function() {
            var mineral_id = $(this).attr("id");
            //      console.log(mineral_id)
            var mineralValue = $(this).val();
            //      console.log(mineralValue)
            var splitForMingrade = mineral_id.split("_");

            /**
             * THIS WHOLE NIL FUCNITONALITY ADDED BY UDAY SHANKAR SINGH
             * THIS IS THE NEW ADDITION REPORTED BY AMOD SIR... ON  4th JUNE 2013
             **/
            if (mineralValue == 'NIL') {
                _this.hideForNil(splitForMingrade);    // MAKING THE FIRST ROW READ ONLY AND DISABLE ALL ADD MORE
            }
            else {
                var mineralRowCount = $(".mineral").length;
                if (mineralRowCount == 1)
                    _this.toggleForNil(); // FOR MAKING THE FIRST ROW BACK TO NORMAL

                // ADDED BY UDAY... 
                // TO MAKE THE FOCUS OUT AFTER MINERAL CHANGE SO THAT SAME MINERAL SELECTION VALIDATION WILL VERIFY THE MINERAL NAME
                // AND IF THE MINERAL NAME IS BEING TRING TO SELECT AGAIN ... NO NEED TO MAKE THE AJAX CALL ... SIMPLE SHOW ALERT WITH ERROR
                $("#grade_" + splitForMingrade[1] + '_1').focus();
                var checkDuplicateMineralSel = $("#checkMineralDuplicasy").val();
                // IF MINERAL IS NOT DUPLICATED THEN DO THE FOLLOWING
                if (checkDuplicateMineralSel == 0) {
                    Utilities.ajaxBlockUI();
                    $.ajax({
                        url: _this.gradeUrl,
                        type: "POST",
						async: false,
                        data: ({
                            value: mineralValue
                        }),
                        success: function(data) {
                            $(".grade_select_" + splitForMingrade[1])
                            .find('option')
                            .remove();
                            var mySelect = $(".grade_select_" + splitForMingrade[1]);
                            var myOptions = json_parse(data);
                            //              console.log(myOptions)
                            mySelect.append(
                                $('<option></option>').val('').html('--- Select grade ---') // ADDED BY UDAY AS SELECT GRADE IS COMING AT THE BOTTOM IF 
                                );                                                            // SEND FROM THE CODE AFTER json_parse

                            //              mySelect.append(
                            //                $('<option></option>').val('NIL').html('NIL') // ADDED BY UDAY.. FOR NIL OPTIONS
                            //                );
                            // SEND FROM THE CODE AFTER json_parse
                            $.each(myOptions.gradeData, function(val, text) {
                                mySelect.append(
                                    $('<option></option>').val(val).html(text)
                                    );
                            });
                        }
                    });
                }
            }
            //            console.log(mineral_id)
            //            console.log(mineralValue)
            nSeriesactivityDetails.mineralUnitNew(mineral_id, mineralValue);
            $(this).focus();
        });
    //        $('.mineral').focusout(function() {
    //            var elementId = $(this).attr("id");
    //            $("#unitSpan_" + elementId).remove();
    //        });
    },
    autocomplete: function(counter) {
        //    console.log("in")
        $.ajax({
            url: this.contryUrl,
            type: "POST",
			async: false,
            success: function(resp) {
                var myOptions = json_parse(resp);
                // console.log(myOptions);

                if (counter == 2)
                {
                    //            console.log(counter);
                    //            console.log("counter");

                    //            console.log("singh")
                    //            console.log(source)
                    var formName = $("#exportOfOreFrm").val();
                    if (formName == 'exportOfOre') {
                        $(".buyer_registration").autocomplete({
                            source: myOptions
                        });
                    }
                    $(".import_country").autocomplete({
                        source: myOptions
                    });
                } else
{
                    $(".import_country").autocomplete({
                        source: myOptions
                    });
                }
            }
        });

    },
    registrationCodeAutocomplete: function() {
        $.ajax({
            url: this.registrationCodeUrl,
            type: "POST",
			async: false,
            success: function(response) {
                //           console.log("uday")
                var data = json_parse(response);
                //           console.log(data)
                //           console.log("data")
                var formName = $("#exportOfOreFrm").val();
                if (formName != 'exportOfOre') {
                    $(".buyer_registration").autocomplete({
                        source: data
                    });
                }
                //                $(".import_registration").autocomplete({
                //                    source: data
                //                });
                $(".supplier_registration").autocomplete({
                    source: data
                });
            }
        });
    },
    /**
     * @author: Uday Shankar Singh
     * MAKES THE FIRST ROW READ ONLY IN CASE OF NIL SELECTED IN THE MINERAL
     **/
    hideForNil: function(splitForMingrade) {

        $(".grade_select_" + splitForMingrade[1])
        .find('option')
        .remove();

        // ALL THE BELOW CODE IN IF AND ELSE CONDITION IS ADDED BY UDAY .. DATED 4TH AND 5TH JUNE FOR THE REQUIREMENET CHANGE SEND
        $(".grade_select_" + splitForMingrade[1]).append(
            $('<option></option>').val(0).html('NIL') // ADDED BY UDAY.. FOR NIL OPTIONS
            );

        $("#grade_1_1").val(0).attr('readonly', true).css("background-color", "#E5E5E5");
        $("#opening_stock_quantity_1_1").val(0).attr('readonly', true).css("background-color", "#E5E5E5");
        //    $("#opening_stock_quantity_1_1").val(0).attr('disabled', 'readonly').css("background-color", "#E5E5E5");
        $("#reg_no_1_1_1").val(0).attr('readonly', true).css("background-color", "#E5E5E5");
        $("#supplier_quantity_1_1_1").val(0).attr('readonly', true).css("background-color", "#E5E5E5");
        $("#supplier_value_1_1_1").val(0).attr('readonly', true).css("background-color", "#E5E5E5");
        $("#import_country_1_1_1").val('NIL').attr('readonly', true).css("background-color", "#E5E5E5");
        $("#import_quantity_1_1_1").val(0).attr('readonly', true).css("background-color", "#E5E5E5");
        $("#import_value_1_1_1").val(0).attr('readonly', true).css("background-color", "#E5E5E5");
        $("#buyer_regNo_1_1_1").val(0).attr('readonly', true).css("background-color", "#E5E5E5");
        $("#buyer_quantity_1_1_1").val(0).attr('readonly', true).css("background-color", "#E5E5E5");
        $("#buyer_value_1_1_1").val(0).attr('readonly', true).css("background-color", "#E5E5E5");
        $("#closing_stock_1_1").val(0).attr('readonly', true).css("background-color", "#E5E5E5");

        $("#consumeQuantity_1_1").val(0).attr('readonly', true).css("background-color", "#E5E5E5");
        $("#consumeValue_1_1").val(0).attr('readonly', true).css("background-color", "#E5E5E5");



        // HIDING ALL ADD MORE BUTTONS and AT THE MINERAL CLICK WE ARE ALSO HANDLING THE CLICK DONE AFTER MAKING THE HIDE BLOCK FROM FIRE BUG
        $("#add_more_mineral").hide();
        $(".grade_add_more").hide();
        $(".supplier_add_more").hide();
        $(".import_add_more").hide();
        $(".add_more_buyer_btn").hide();

    },
    /**
     * @author: Uday Shankar Singh
     * UNDO THE CHANGES DONE BY hideForNil function
     * 
     * THIS FUNCTIONALITY IS CURRENTLY AVAILABLE ONLY FOR FIRST ROW....
     * IF NEEDED EASILY CAN BE DONE BY GETTING THE IF OF THE CURRENT ELEMENT 
     * AND THEN CALLING IT FROM ADD MORE FUNCTION
     * 
     * AND BECAUSE OF THIS I HAVE CREATED THIS SEPERATE FUNCTION
     **/
    toggleForNil: function() {

        $("#add_more_mineral").show();
        $(".grade_add_more").show();
        $(".supplier_add_more").show();
        $(".import_add_more").show();
        $(".add_more_buyer_btn").show();


        // RESETING VALUE 
        $("#grade_1_1").val('').attr('readonly', false).css("background-color", "");
        $("#opening_stock_quantity_1_1").val('').attr('readonly', false).css("background-color", "");
        $("#reg_no_1_1_1").val('').attr('readonly', false).css("background-color", "");
        $("#supplier_quantity_1_1_1").val('').attr('readonly', false).css("background-color", "");
        $("#supplier_value_1_1_1").val('').attr('readonly', false).css("background-color", "");
        $("#import_country_1_1_1").val('').attr('readonly', false).css("background-color", "");
        $("#import_quantity_1_1_1").val('').attr('readonly', false).css("background-color", "");
        $("#import_value_1_1_1").val('').attr('readonly', false).css("background-color", "");
        $("#buyer_regNo_1_1_1").val('').attr('readonly', false).css("background-color", "");
        $("#buyer_quantity_1_1_1").val('').attr('readonly', false).css("background-color", "");
        $("#buyer_value_1_1_1").val('').attr('readonly', false).css("background-color", "");
        $("#closing_stock_1_1").val('').attr('readonly', false).css("background-color", "");

        //        $("#consumeQuantity_1_1").val(0).attr('readonly', false).css("background-color", "");
        //        $("#consumeValue_1_1").val(0).attr('readonly', false).css("background-color", "");
        /**
         * @author Uday Shankar Singh
         * THE BELOW TWO LINE WERE SAME AS ABOVE TWO LINES BUT IT CAUSES PROBLEM
         * ON RESELECTING THE MINERAL AND PUT 0 VALUE.
         * 
         * SO, REMOVING IT ... IF NEEDED CAN BE REVERTED.....
         */
        $("#consumeQuantity_1_1").val("").attr('readonly', false).css("background-color", "");
        $("#consumeValue_1_1").val("").attr('readonly', false).css("background-color", "");

    },
    mineralUnitNew: function(mineral_id, mineralValue) {
        var _this = this;
        //==============APPENDING UNIT TO THE MINERAL STARTS================
        var elementId = mineral_id;
        var elementVal = mineralValue;
        $("#unitSpan_" + elementId).remove();
        if (elementVal != "NIL" && elementVal != "") {
            //            console.log("--------")
            console.log(elementId)
            //            console.log(elementVal)
            Utilities.ajaxBlockUI();
            $.ajax({
                url: _this.unitUrl,
                type: 'POST',
				async: false,
                data: ({
                    value: elementVal
                }),
                success: function(response) {

                    var mineralUnit = json_parse(response);
                    $("<span id='unitSpan_" + elementId + "'><b>" + mineralUnit.unit + "</b></span>").insertAfter($("#" + elementId));
                }
            });
        }
    //==============APPENDING UNIT TO THE MINERAL ENDS==================

    }
}
//==============================================================================
var nFinalValidation = {
    nFinalSubmit: function(nSubmitActionUrl, successRedirectUrl) {

        //    Utilities.ajaxBlockUI();
        $.ajax({
            url: nSubmitActionUrl,
			async: false,
            success: function(finalSubmitActionResponse) {

                //=========CHECKING FOR NO ERROR FOUND, AND REDIRECTING THE PAGE========
                if (finalSubmitActionResponse == "" || finalSubmitActionResponse == null) {
                    window.location = successRedirectUrl;
                    return;
                }

                //====IF MULTIPLE ERROR, THEN SPLIT THE ERRORS AND THEN DISPLAY THEM====
				/* update response object condition to resolve the csrf token issue of final submit, Done by Pravin Bhakare 22-03-2021 */
				if(nSubmitActionUrl.includes("oFinalSubmit")){
					var finalActionResponse = json_parse(finalSubmitActionResponse);
					finalSubmitActionResponse = finalActionResponse.error;
					
				}
				
                var data = finalSubmitActionResponse.split('|');
                var finalSubmitArray = new Array();
                finalSubmitArray += "<tr> <td style='height:5px'>&nbsp</td></tr>";
                for (var i = 0; i < data.length; i++) {
                    finalSubmitArray += "<tr><td align='left' style='text-align:left; color:#f00'>" + data[i] + "</td></tr>";
                }
                $("#final-submit-error").html(finalSubmitArray);
            }
        });

    }
}
//==============================================================================
var activityDetailsValidation = {
    fieldValidation: function() {
        $("#frmactivityDetails").validate({
            onkeyup: false,
            onsubmit: true
        });


        $.validator.addMethod("bMaxlength", $.validator.methods.maxlength,
            $.validator.format("Max. length allowed is {0} digits"));
        $.validator.addMethod("bNumber", $.validator.methods.number,
            $.validator.format("Please enter numeric digits only"));
        $.validator.addMethod("bDigits", $.validator.methods.digits,
            $.validator.format("Decimal digits are not allowed"));
        $.validator.addClassRules("supplier_registration", {
            bMaxlength: 15,
            bNumber: true,
            bDigits: true
        });

        //========================Mineral Valition==============
        $.validator.addMethod('Required', $.validator.methods.required,
            $.validator.format("Field is required."));

        $.validator.addMethod("checkMineral", function(value, element) {
            $("#checkMineralDuplicasy").val(0);
            var elementId = element.id
            var splittedId = elementId.split("_");
            var elementNo = splittedId[1];
            var mineralArray = new Array();
            mineralArray = $(".mineral");

            for (var i = 0; i < mineralArray.length; i++) {
                var mineralElement = mineralArray[i].value;
                var mineralId = mineralArray[i].id;
                var splittedMineralId = mineralId.split("_");
                var mineralNo = splittedMineralId[1];
                var counter = 1;
                if (elementNo != mineralNo) {
                    if (value == mineralElement) {
                        alert("This mineral name has been already selected");
                        $('#' + elementId).val('');
                        $("#checkMineralDuplicasy").val(1);
                    }
                }
            }
            return true;
        }, ""
        );
        $.validator.addClassRules("mineral", {
            Required: true,
            checkMineral: true
        });

        //=========================Grade Validation=====================
        $.validator.addMethod('gradeRequired', $.validator.methods.required,
            $.validator.format("Field is required."));
        $.validator.addMethod("checkgrade", function(value, element) {
            var elementId = element.id
            var splittedId = elementId.split("_");
            var mineralNo = splittedId[1];
            var gradeNo = splittedId[2];
            var gradeArray = new Array();
            var gradeValue = [];
            gradeArray = $(".grade_select_" + mineralNo);
            var gradeElementCountValue = gradeArray[parseInt(gradeArray.length) - 1].value;
            for (var j = 0; j < gradeArray.length; j++) {
                var mineralgradeElement = gradeArray[j].value;
                /*var mineralgradeId         = gradeArray[j].id;
                 var splittedgradeId = mineralgradeId.split("_");
                 var splitmineralNo         = splittedgradeId[1];
                 var splitgradeNo         = splittedgradeId[2];
                 if(splitmineralNo == mineralNo) {
                 if(gradeArray.length != splitgradeNo) { 
                 if(gradeElementCountValue == mineralgradeElement) {
                 alert("This mineral grade name has been already selected");
                 $('#'+elementId).val('');
                 }
                 }
                 }*/
                if (mineralgradeElement != '') {
                    if (jQuery.inArray(mineralgradeElement, gradeValue) == -1)
                    {
                        gradeValue.push(mineralgradeElement);
                    } else
                    {
                        alert("This mineral grade name has been already selected");
                        $('#' + elementId).val('');
                    }
                }
            }
            return true;
        }, ""
        );
        $.validator.addClassRules("grade", {
            gradeRequired: true,
            checkgrade: true
        });
        //=======================Opening Stock Quantity=================================
        $.validator.addMethod("openStNumber", $.validator.methods.number,
            $.validator.format("Please enter numeric digits only"));

        $.validator.addMethod("openStRequired", $.validator.methods.required,
            "Field is required");

        $.validator.addMethod("openStMax", $.validator.methods.max,
            $.validator.format("Max. value allowed is 999999999999999.999"));

        $.validator.addMethod("openStMaxlength", $.validator.methods.maxlength,
            $.validator.format("Max. length allowed is 15,3 digits including decimal"));

        $.validator.addMethod('openStDecimal', function(value, element) {
            return this.optional(element) || /^\d+(\.\d{0,3})?$/.test(value);
        }, "Please enter only 3 decimal points");

        $.validator.addClassRules("opening_stock_quantity", {
            openStRequired: true,
            openStNumber: true,
            openStDecimal: true,
            openStMax: 999999999999999.999,
            openStMaxlength: 19
        });

        //=======================Purchase Registration=================================
        $.validator.addMethod("rRequired", $.validator.methods.required,
            $.validator.format("Supplier not registered with IBM, may be informed to register by using Form M"));

        $.validator.addClassRules("supplier_registration", {
            rRequired: true
        });
        //  buyer_registration
        //=======================Purchase Quantity=================================
        $.validator.addMethod("puNumber", $.validator.methods.number,
            $.validator.format("Please enter numeric digits only"));

        $.validator.addMethod("puRequired", $.validator.methods.required,
            "Field is required");

        $.validator.addMethod("puMax", $.validator.methods.max,
            $.validator.format("Max. value allowed is 999999999999999.999"));

        $.validator.addMethod("puMaxlength", $.validator.methods.maxlength,
            $.validator.format("Max. length allowed is 15,3 digits including decimal"));

        $.validator.addMethod('puDecimal', function(value, element) {
            return this.optional(element) || /^\d+(\.\d{0,3})?$/.test(value);
        }, "Please enter only 3 decimal points");


        $.validator.addClassRules("supplier_quantity", {
            puNumber: true,
            puRequired: true,
            puDecimal: true,
            puMax: 999999999999999.999,
            puMaxlength: 19
        });
        //=======================Purchase Value=================================
        //        $.validator.addMethod("purcvRequired", $.validator.methods.required,
        //                "Field is required");

        $.validator.addMethod("purcvNumber", $.validator.methods.number,
            $.validator.format("Please enter numeric digits only"));

        $.validator.addMethod("purcvMax", $.validator.methods.max,
            $.validator.format("Max. value allowed is 15,2 digits"));

        $.validator.addMethod('purcvDecimal2', function(value, element) {
            return this.optional(element) || /^\d+(\.\d{0,2})?$/.test(value);
        }, "Please enter only 2 decimal points");

        $.validator.addClassRules("supplier_value", {
            required: {
                depends: function() {
                    var valueElementId = $(this).attr("id");
                    var valueElementValue = $(this).val();
                    var quantityElementId = valueElementId.replace("value", "quantity");
                    console.log(valueElementValue)
                    if ($('#' + quantityElementId).val() > 0) {
                        if (valueElementValue == 0 || valueElementValue == '') {
                            $(this).val("");
                            return true;
                        }
                        else
                            return false;
                    }
                }
            }
            ,
            purcvNumber: true,
            purcvDecimal2: true,
            purcvMax: 999999999999999.99
        });

        /**
         * ADDED BY UDAY SHANKAR SINGH
         * IMPORT COUNTRY SHOULD BE REQUIRED FIELD IF IMPORT QUANTITY IS THERE... AS 
         * PER THE REQUIREMENT ON 4th JUNE 2013
         */
        // THIS IS SERVER SIDE     
        $.validator.addClassRules("import_country", {
            required: {
                depends: function() {
                    var countryElementId = $(this).attr("id");
                    var quantityElementId = countryElementId.replace("country", "quantity");
                    if ($('#' + quantityElementId).val() > 0) {
                        return true;
                    }
                    else {
                        return false;
                    }
                }
            }
        });


        //=======================Import Quantity=================================
        $.validator.addMethod("imNumber", $.validator.methods.number,
            $.validator.format("Please enter numeric digits only"));

        $.validator.addMethod("imRequired", $.validator.methods.required,
            "Field is required");

        $.validator.addMethod("imMax", $.validator.methods.max,
            $.validator.format("Max. value allowed is 999999999999999.999"));

        $.validator.addMethod("imMaxlength", $.validator.methods.maxlength,
            $.validator.format("Max. length allowed is 15,3 digits including decimal"));

        $.validator.addMethod('imDecimal', function(value, element) {
            return this.optional(element) || /^\d+(\.\d{0,3})?$/.test(value);
        }, "Please enter only 3 decimal points");

        $.validator.addClassRules("import_quantity", {
            imNumber: true,
            imRequired: true,
            imDecimal: true,
            imMax: 999999999999999.999,
            imMaxlength: 19
        });
        //=======================Import Value=================================
        $.validator.addMethod("imvRequired", $.validator.methods.required,
            "Field is required");

        $.validator.addMethod("imvNumber", $.validator.methods.number,
            $.validator.format("Please enter numeric digits only"));

        $.validator.addMethod("imvMax", $.validator.methods.max,
            $.validator.format("Max. value allowed is 15,2 digits"));

        $.validator.addMethod('imvDecimal2', function(value, element) {
            return this.optional(element) || /^\d+(\.\d{0,2})?$/.test(value);
        }, "Please enter only 2 decimal points");

        $.validator.addClassRules("import_value", {
            //            imvRequired: true,
            required: {
                depends: function() {
                    var valueElementId = $(this).attr("id");
                    var valueElementValue = $(this).val();
                    var quantityElementId = valueElementId.replace("value", "quantity");
                    console.log(valueElementValue)
                    if ($('#' + quantityElementId).val() > 0) {
                        if (valueElementValue == 0 || valueElementValue == '') {
                            $(this).val("");
                            return true;
                        }
                        else
                            return false;
                    }
                }
            },
            imvNumber: true,
            imvDecimal2: true,
            imvMax: 999999999999999.99
        });
        //=======================buyer Registration=================================
        var fmType = $("#fType").val();
        var uType = $("#uType").val();

        if (uType != 2)
        {
            $.validator.addMethod("dRequired", $.validator.methods.required,
                "Buyer not registerd with IBM, may be informed to register by using Form M");

            $.validator.addClassRules("buyer_registration", {
                dRequired: true
            });
        }
        if (fmType == 'N' && uType == 2)
        {
            $.validator.addMethod("dRequired", $.validator.methods.required,
                "Field is required");

            $.validator.addClassRules("buyer_registration", {
                dRequired: true
            });
        }


        //=======================buyer Quantity=================================
        $.validator.addMethod("buNumber", $.validator.methods.number,
            $.validator.format("Please enter numeric digits only"));

        $.validator.addMethod("buRequired", $.validator.methods.required,
            "Field is required");

        $.validator.addMethod("buMax", $.validator.methods.max,
            $.validator.format("Max. value allowed is 999999999999999.999"));

        $.validator.addMethod("buMaxlength", $.validator.methods.maxlength,
            $.validator.format("Max. length allowed is 15,3 digits including decimal"));

        $.validator.addMethod('buDecimal', function(value, element) {
            return this.optional(element) || /^\d+(\.\d{0,3})?$/.test(value);
        }, "Please enter only 3 decimal points");

        $.validator.addMethod("validateBuyer", function(value, element) {


            var elementId = element.id;
            var splittedId = elementId.split("_");
            var mineralNo = splittedId[2];
            var gradeNo = splittedId[3];
            var OpenStock_value = 0;
            var supplier_value = 0;
            var import_value = 0;
            var buyer_value = 0;

            OpenStock_value = $("#opening_stock_quantity_" + mineralNo + "_" + gradeNo).val();
            ;
            $(".supplier_quantityClass_" + mineralNo + "_" + gradeNo).each(function() {
                supplier_value += +this.value
            });
            $(".import_quantityClass_" + mineralNo + "_" + gradeNo).each(function() {
                import_value += +this.value
            });
            var calculateValue = ((parseFloat(OpenStock_value) + parseFloat(supplier_value) + parseFloat(import_value))).toFixed(3);
            var value1 = parseFloat(value).toFixed(3);

            if (parseFloat(value1) > calculateValue)
            {
                alert("Despatches value cannot be more than opening stock + purchases + imported value.");
                $('#' + elementId).focus();

                return false;
            }
            return true;


        }, ''
        );

        $.validator.addClassRules("buyer_quantity", {
            buNumber: true,
            buRequired: true,
            buDecimal: true,
            validateBuyer: true,
            buMax: 999999999999999.999,
            buMaxlength: 19
        });


        //=======================buyer Value=================================
        $.validator.addMethod("buvRequired", $.validator.methods.required,
            "Field is required");

        $.validator.addMethod("buvNumber", $.validator.methods.number,
            $.validator.format("Please enter numeric digits only"));

        $.validator.addMethod("buvMax", $.validator.methods.max,
            $.validator.format("Max. value allowed is 15,2 digits"));

        $.validator.addMethod('buvDecimal2', function(value, element) {
            return this.optional(element) || /^\d+(\.\d{0,2})?$/.test(value);
        }, "Please enter only 2 decimal points");

        $.validator.addClassRules("buyer_value", {
            //            buvRequired: true,
            buvRequired: {
                depends: function() {
                    var valueElementId = $(this).attr("id");
                    var valueElementValue = $(this).val();
                    var quantityElementId = valueElementId.replace("value", "quantity");
                    if ($('#' + quantityElementId).val() > 0) {
                        if (valueElementValue == 0 || valueElementValue == '') {
                            $(this).val("");
                            return true;
                        }
                        else
                            return false;
                    }
                }
            },
            buvNumber: true,
            buvDecimal2: true,
            buvMax: 999999999999999.99
        });

        //=======================Closing Stock Quantity=================================
        $.validator.addMethod("closeRequired", $.validator.methods.required,
            "Field is required");

        $.validator.addMethod("clNumber", $.validator.methods.number,
            $.validator.format("Please enter numeric digits only"));

        $.validator.addMethod("closeMax", $.validator.methods.max,
            $.validator.format("Max. value allowed is 15,3 digits"));

        $.validator.addMethod('clDecimal2', function(value, element) {
            return this.optional(element) || /^\d+(\.\d{0,3})?$/.test(value);
        }, "Please enter only 3 decimal points");

        $.validator.addMethod("checkCloseQuantity", function(value, element) {
            // ADDED BY UDAY... THIS IF CONDITION IS ONLY FOR THE endUserMIneralBasedActivity FORM...
            // AS THE CALCULATION FORMULA IS DIFFERENT FOR THIS FORM ONLY REPORTED ON 4TH JUNE 2013 BY AMOD SIR ... MAIL
            var checkForEndUserFormOnly = $("#checkForEndUserFormOnly").val();
            //      if(!isNaN(checkForEndUserFormOnly)){
            //        console.log("right in");
            //      
            //        
            //      }else{
            //        alert("shit place");
            var className = $(".mineral").attr("class").split(" ");

            var tabName1 = className[2].split('_');
            //      console.log(className)
            //      console.log("className") // NEED TO REMOVE AFTER 5th JUNE 2013 METTING
            //      console.log(tabName1)

            switch (tabName1[2])
            {
                case '1':
                    var Message1 = "Closing stock value not equal to (opening stock + purchased + imported) - dispatches.";
                    break;
                case '2':
                    var Message1 = "Closing stock value not equal to (opening stock + procured + imported) - dispatches.";
                    break;
                case '3':
                    var Message1 = "Closing stock value not equal to (opening stock + purchased + imported) - (consumed + sold).";
                    break;
                case '4':
                    var Message1 = "Closing stock value not equal to opening (stock + received + imported) - despatches.";
                    break;
            }
            var elementId = element.id;
            var splittedId = elementId.split("_");
            var mineralNo = splittedId[2];
            var gradeNo = splittedId[3];
            var supplier_value = 0;
            var import_value = 0;
            var buyer_value = 0;

            $(".supplier_quantityClass_" + mineralNo + "_" + gradeNo).each(function() {
                supplier_value += +this.value
            });
            $(".import_quantityClass_" + mineralNo + "_" + gradeNo).each(function() {
                import_value += +this.value
            });
            $(".buyer_quantityClass_" + mineralNo + "_" + gradeNo).each(function() {
                buyer_value += +this.value
            });
            var opening_stock = $("#opening_stock_quantity_" + mineralNo + "_" + gradeNo).val();
            if (tabName1[2] == '3') {
                var Consume_qty = $("#consumeQuantity_" + mineralNo + "_" + gradeNo).val();
            }
            //      console.log(opening_stock)
            //      console.log("opening_stock")
            //      console.log(supplier_value)
            //      console.log("supplier_value") //ALL THIS NEED TO BE REMOVED AFTER MEETING OF 5th JUNE 2013
            //      console.log(import_value)
            //      console.log("import_value")
            //      console.log(Consume_qty)
            //      console.log("consume_qty")
            //      console.log(buyer_value)
            //      console.log("buyer_value")
            if (tabName1[2] == '3') {
                // MODIFIED BY UDAY SHANKAR SINGH... AS PER THE REQUIREMENT GIVEN BY AMOD SIR..DATED 4th JUNE 2013
                var calculateValue = ((parseFloat(opening_stock) + parseFloat(supplier_value) + parseFloat(import_value)) - ((parseFloat(Consume_qty)) + parseFloat(buyer_value))).toFixed(3);
            }
            else
                var calculateValue = ((parseFloat(opening_stock) + parseFloat(supplier_value) + parseFloat(import_value)) - parseFloat(buyer_value)).toFixed(3);
            var value1 = parseFloat(value).toFixed(3);
            if (parseFloat(value1) != calculateValue)
            {
                alert(Message1);
                $('#' + elementId).focus();
                return false;
            }
            return true;
        //      }
        }, "");
        $.validator.addClassRules("closing_stock", {
            closeRequired: true,
            clNumber: true,
            clDecimal2: true,
            closeMax: 999999999999999.999,
            checkCloseQuantity: true
        });


        //===============CONSUME VALUE===========================
        $.validator.addClassRules("consume_value", {
            //            buvRequired: true,
            buvRequired: {
                depends: function() {
                    var valueElementId = $(this).attr("id");
                    var valueElementValue = $(this).val();
                    var quantityElementId = valueElementId.replace("Value", "Quantity");
                    if ($('#' + quantityElementId).val() > 0) {
                        if (valueElementValue == 0 || valueElementValue == '') {
                            $(this).val("");
                            return true;
                        }
                        else
                            return false;
                    }
                }
            },
            buvNumber: true,
            buvDecimal2: true,
            buvMax: 999999999999999.99
        });

    },
    countryOnQuantityCheck: function() {
        // THIS IS CLIEND SIDE OF THE ABOVE 
        $("#frmActivityDetails").on('focusout', '.import_quantity', function() {
            var quantityElementId = $(this).attr("id");
            var quantityElementVal = $(this).val();
            var countryElementId = quantityElementId.replace("quantity", "country");
            var countryElementVal = $("#" + countryElementId).val();

            if (quantityElementVal > 0) {
                if (!countryElementVal)
                    alert("Kindly Enter the country for this import");
            }

        });

    }
}



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
					async: false,
                    data: ({
                        value: checkValue
                    }),
                    success: function(response) {
                        _this.data = json_parse(response);
                        //                        console.log(_this.data)
                        if (_this.data != "") {
                            //                            if (_this.data['returnType'] == 'MONTHLY') {
                            _this.pendingReturns(_this.data);
                        //                            }
                        //                            else if (_this.data['returnType'] == 'ANNUAL') {
                        //                                _this.pendingReturnsAnnual(_this.data);
                        //                            }
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
            
            $("#tableTr").append("<td colspan='2' align='center' id='mineName'>Pending Returns For Financial Year " + financialYear + " (Month Wise) TOTAL -> " + displayData['dataCount'] + "</td>");
            //========================CREATING DATA FIELDS==========================

            //            var arrayLength = displayData['mineCodeKey'].length;
            //            for (var i = 0; i < arrayLength; i++) {
            var yearArray = [
            "April_"+checkValue,
            "May_"+checkValue,
            "June_"+checkValue,
            "July_"+checkValue,
            "Aug_"+checkValue,
            "Sept_"+checkValue,
            "Oct_"+checkValue,
            "Nov_"+checkValue,
            "Dec_"+checkValue,
            "Jan_"+(parseInt(checkValue) + 1),
            "Feb_"+(parseInt(checkValue) + 1),
            "March_"+(parseInt(checkValue) + 1)
            ];
            //            console.log(yearArray)
            
            //            var yearCount = 0;
            $.each(yearArray, function(key1, value1) {
                //            $.each(displayData, function(key, value) {
                //                console.log(yearArray[yearCount])
                //console.log(key1)
                if(key1 < displayData['dataArrayCount']){
                    var uday = displayData['pending'][value1]['data'];
                    //                console.log(key[value1]['data'])
                    //                console.log(value)

                    //                var mineCodeKey = displayData['mineCodeKey'][i];
                    //                var dataLength = displayData['mineCodeDataWithKey'][mineCodeKey].length;

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
                    tableTrTd.html("FOR THE MONTH OF " + value1.replace("_", " "));
                    tableTrMonth.append(tableTrTd);

                    var tableTrMonth1 = $(document.createElement('tr'));
                    tableTrMonth1.addClass("form-table-title");
                    tableTrMonth1.colspan = "2";
                    tableElement.append(tableTrMonth1);

                    var tableTrTd1 = $(document.createElement('td'));
                    tableTrTd1.html("Mine Name");
                    tableTrMonth1.append(tableTrTd1)
                    //                var tableTrTd2 = $(document.createElement('td'));
                    //                tableTrTd2.html("Mine Code");
                    //                tableTrMonth1.append(tableTrTd2)

                    $.each(uday, function(key2, value2){
                        var tableTr = $(document.createElement('tr'));
                        tableElement.append(tableTr);
                        var tableTd1 = $(document.createElement('td'));
                        tableTd1.css("width", "50%");
                        tableTd1.html(value2);
                        tableTr.append(tableTd1);
                    //                    var tableTd2 = $(document.createElement('td'));
                    //                    tableTd2.css("width", "50%");
                    //                    tableTd2.html(displayData['mineCodeDataWithKey'][mineCodeKey][j]['mineCode']);
                    //                    tableTr.append(tableTd2);
                    //                }
                    //yearCount++;
                    });
                }
            //            });
            });
        //            }
        } else {
            $("#tableTr").append("<td colspan='2' align='center' id='mineName'>Pending Returns For Financial Year " + financialYear + " (Month Wise) TOTAL -> 0 </td>");
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
					async: false,
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
						async: false,
                        data: ({
                            value: checkValue
                        }),
                        success: function(response) {
                            _this.data = json_parse(response);
                            if (_this.data != "") {
                                //              if(_this.data['returnType'] == 'MONTHLY'){
                                _this.pendingReturnsMonth(_this.data, checkValue);
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
    pendingReturnsMonth: function(returnData, returnYear) {
        var tableId = $("#pendingMinesDetails").attr('id');
        //======================CREATING HEADER FOR TABLE=======================
        $("#" + tableId).append("<tr id='tableTr' class='form-table-title'></tr>");

        if (returnData['count'][returnYear] > 0) {
            $("#tableTr").append("<td colspan='2' align='center' id='mineName'>Month Name List For Which Monthly Returns Are  Pending (Total -> "+ returnData['count'][returnYear] +" )</td>");
            //========================CREATING DATA FIELDS==========================

            $.each(returnData['data'][returnYear], function(key, value) {
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
                tableTrTd.html(value.replace("_", " "));
                tableTrMonth.append(tableTrTd);
            });
        } else {
            $("#tableTr").append("<td colspan='2' align='center' id='mineName'>No Monthly Pending Returns For This Financial Year </td>");
        }
    }
}