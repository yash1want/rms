
$(document).ready(function() {
    ssUpRwCount();
});

var SourceOfSupplyNew = {
    init: function(data_url, country_url, mode_url, rawMineral_url, metal_url, district_url, unit_url, mine_code_url) {
        this.countryUrl = country_url;
        this.modeUrl = mode_url;
        this.rawMineralUrl = rawMineral_url;
        this.metalUrl = metal_url;
        this.districtUrl = district_url;
        SourceOfSupplyNew.addMore();
        SourceOfSupplyNew.validateSource();
        this.dataUrl = data_url;
        this.unitUrl = unit_url;
        this.mineCodeUrl = mine_code_url;

    },
    getSourceData: function() {
        $.ajax({
        url: SourceOfSupplyNew.dataUrl,
        type: 'GET',
        //      async: false,
        success: function(resp_data) {
            SourceOfSupplyNew.data = json_parse(resp_data);
            if (SourceOfSupplyNew.data.totalCount != 0) {
            SourceOfSupplyNew.fillData();
            }
            //================CHECKING WHETHER TO PUT NIL IN DD OR NOT==================
            SourceOfSupplyNew.nilFill();

        }
        });
    },
    fillData: function() {
        _this = this;
        //==========UDAY SHANKAR SINGH===================
        //====SETTING TYPE VALUE TO NIL IF TYPE SELETECTED IS NILL STARTS=======
        if (SourceOfSupplyNew.data.sour_indus_1 == 'NIL')
        $("#checkNilRow").val("1");
        //======SETTING TYPE VALUE TO NIL IF TYPE SELETECTED IS NILL ENDS=======

        //===================FILLING VALUE IN THE FORM STARTS===================
        $.each(SourceOfSupplyNew.data, function(key, item) {
        if (key == 'totalCount') {
            for (var i = 2; i <= item; i++) {
            SourceOfSupplyNew.createFields(i);
            }
            $('#source_of_supply_count').val(item)
        }
        $('#' + key).val(item);
        });

        //===================MAKING IMPORTED AND INDIGENOUS DISABLE BASED ON THE VALUE  STARTS===================
        var totalRowCount = SourceOfSupplyNew.data.totalCount;
        for (var i = 1; i <= totalRowCount; i++) {
        var typeId = "#sour_indus_" + i;
        var typeValue = $(typeId).val();
        if (typeValue == 'imported') {
            _this.importedChange(i);
        }
        else if (typeValue == 'indigenous') {
            _this.indigenousChange(i);
        }
        $("<span id='unitSpan_sour_mineral_" + i + "'><b>" + SourceOfSupplyNew['data']["mineral_unit_" + i] + "</b></span>").insertAfter($("#sour_mineral_" + i));

        }
        //===================MAKING IMPORTED AND INDIGENOUS DISABLE BASED ON THE VALUE  ENDS===================




        //===================FILLING VALUE IN THE FORM ENDS=====================
    },
    validateSource: function() {

        $("#sourceOfSupply").validate({
        onkeyup: false,
        onSubmit: true
        });

        $.validator.addClassRules("MakeRequired", {
        required: true
        });

        $.validator.addMethod("eMaxlength", $.validator.methods.maxlength,
        $.validator.format("Max. length allowed is {0} characters"));

        $.validator.addClassRules("address", {
        eMaxlength: 100

        });

        $.validator.addMethod("pricNumber", $.validator.methods.number,
        $.validator.format("Please enter numeric digits only"));
        $.validator.addMethod("priccMax", $.validator.methods.max,
        $.validator.format("Max. value allowed is 999999999.99"));
        $.validator.addMethod("priccMaxlength", $.validator.methods.maxlength,
        $.validator.format("Max. length allowed is 9,2 digits including decimal"));
        $.validator.addMethod('pricDecimal', function(value, element) {
        return this.optional(element) || /^\d+(\.\d{0,2})?$/.test(value);
        }, "Please enter only 2 decimal points");


        $.validator.addClassRules("price", {
        pricNumber: true,
        pricDecimal: true,
        priccMax: 999999999.99,
        priccMaxlength: 12

        });

        $.validator.addMethod("qtyNumber", $.validator.methods.number,
        $.validator.format("Please enter numeric digits only"));
        $.validator.addMethod("qtycMax", $.validator.methods.max,
        $.validator.format("Max. value allowed is 999999999999999.999"));
        $.validator.addMethod("qtycMaxlength", $.validator.methods.maxlength,
        $.validator.format("Max. length allowed is 15,3 digits including decimal"));
        $.validator.addMethod('qtyDecimal', function(value, element) {
        return this.optional(element) || /^\d+(\.\d{0,3})?$/.test(value);
        }, "Please enter only 3 decimal points");


        $.validator.addClassRules("qty", {
        qtyNumber: true,
        qtyDecimal: true,
        qtycMax: 999999999999999.999,
        qtycMaxlength: 19

        });

        $.validator.addMethod("disNumber", $.validator.methods.number,
        $.validator.format("Please enter numeric digits only"));
        $.validator.addMethod("discMax", $.validator.methods.max,
        $.validator.format("Max. value allowed is 9999.999"));
        $.validator.addMethod("discMaxlength", $.validator.methods.maxlength,
        $.validator.format("Max. length allowed is 4,3 digits including decimal"));
        $.validator.addMethod('disDecimal', function(value, element) {
        return this.optional(element) || /^\d+(\.\d{0,3})?$/.test(value);
        }, "Please enter only 3 decimal points");


        $.validator.addClassRules("distance", {
        disNumber: true,
        disDecimal: true,
        discMax: 9999.999,
        discMaxlength: 8

        });

        $.validator.addMethod("costNumber", $.validator.methods.number,
        $.validator.format("Please enter numeric digits only"));
        $.validator.addMethod("costcMax", $.validator.methods.max,
        $.validator.format("Max. value allowed is {0}"));
        $.validator.addMethod("costcMaxlength", $.validator.methods.maxlength,
        $.validator.format("Max. length allowed is 5,2 digits including decimal"));
        $.validator.addMethod('costDecimal', function(value, element) {
        return this.optional(element) || /^\d+(\.\d{0,2})?$/.test(value);
        }, "Please enter only 2 decimal points");


        $.validator.addClassRules("cost", {
        costNumber: true,
        costDecimal: true,
        costcMax: 99999.99,
        costcMaxlength: 8

        });

    },
    addMore: function() {
        // Utilities.ajaxBlockUI();
        var _this = this;
        $.ajax({
        url: _this.countryUrl,
        type: 'GET',
        success: function(response) {
            _this.dataCountry = json_parse(response);
            $.ajax({
            url: _this.modeUrl,
            type: 'GET',
            success: function(resp) {
                _this.dataMode = json_parse(resp);
                $.ajax({
                url: _this.rawMineralUrl,
                type: 'GET',
                success: function(resps) {
                    _this.dataRawMineral = json_parse(resps);
                    $.ajax({
                    url: _this.metalUrl,
                    type: 'GET',
                    success: function(resp) {
                        _this.dataMetal = json_parse(resp);
                        $.ajax({
                        url: _this.districtUrl,
                        type: 'GET',
                        success: function(resp) {
                            _this.dataDistrict = json_parse(resp);
                            _this.getSourceData();
                            _this.createFields('1');
                            $('#source_of_supply_count').val('1')
                             SourceOfSupplyNew.getMineCode();
                            SourceOfSupplyNew.formSaveAction();

                        }
                        });
                    }
                    });
                }
                });
            }
            });
        }
        });
        $('#source_of_supply_AddMore').click(function(event) {
        var checkIndustryFirstDDForNil = $("#sour_indus_1").val();
        if (checkIndustryFirstDDForNil == "NIL") {
            alert("Sorry... You can't add more rows while selecting NIL in the Industries Drop Box.");
            event.preventDefault();
        }
        else if (checkIndustryFirstDDForNil == "") {
            alert("Kindly Select the Type first.");
            event.preventDefault();
        }
        else {

            var fineshProduct_Count = $("#source_of_supply_count").val();
            var newfineshProduct_Count = (parseInt(fineshProduct_Count) + 1);
            $("#source_of_supply_count").val(newfineshProduct_Count);

            _this.createFields(newfineshProduct_Count);
            // REMOVING NIL FROM THE LIST AS NO OF ROWS ARE NOW MORE THAN 1
            $("#sour_indus_1").find('option[value=NIL]').remove();
            _this.nilFill();
        }
        SourceOfSupplyNew.getMineCode();
        });

    },
    createFields: function(counter) {

        var benchTr1 = $(document.createElement('tr'));
        benchTr1.attr('id', "source_supply_tr_" + counter);
        var benchTd1 = $(document.createElement('td'));
        benchTd1.attr('align', "center");
        benchTd1.attr('vAlign', "top");
        benchTr1.append(benchTd1);

        /**
             * @author: Uday Shankar Singh
             * 
             * EARLIER THIS IS USED FOR INDUSTRIES DROP DOWN... 
             * NOW NOT USING 
             * 
             * REMOVE IT WHEN ME DIVISION CONFIRM THE CHANGE
             */
        //        var benchSelectIndustry = $(document.createElement('select'));
        //        benchSelectIndustry.attr('id', "sour_indus_" + counter);
        //        benchSelectIndustry.attr('name', "sour_indus_" + counter);
        //        benchSelectIndustry.attr('class', 'MakeRequired fillNil');
        //        benchSelectIndustry.css('width', "80px");
        //        benchTd1.append(benchSelectIndustry);
        //        //benchSelect.className = fieldName1 + "_select" + " selectbox-small";
        //        //==================CREATING THE SELECT BOX OPTIONS=========================
        //        var SelectOptionIndustry = $(document.createElement('option'));
        //        SelectOptionIndustry.html("--Select---");
        //        SelectOptionIndustry.val("");
        //        benchSelectIndustry.append(SelectOptionIndustry);
        ////        console.log(this.dataIndustries)
        //        $.each(this.dataIndustries, function(index, item) {
        //            var options = $(document.createElement('option'));
        //            options.html(item);
        //            options.val(item);
        //            benchSelectIndustry.append(options);
        //        });

        //==============CREATING DROP DOWN TO SELECT SOURCE OF TYPE START======

        var benchSelectIndustry = $(document.createElement('select'));
        benchSelectIndustry.attr('id', "sour_indus_" + counter);
        benchSelectIndustry.attr('name', "sour_indus_" + counter);
        benchSelectIndustry.attr('class', 'MakeRequired fillNil sourceType');
        benchSelectIndustry.css('width', "80px");
        benchTd1.append(benchSelectIndustry);
        //benchSelect.className = fieldName1 + "_select" + " selectbox-small";
        //===============   ===CREATING THE SELECT BOX OPTIONS=========================
        var SelectOptionIndustry = $(document.createElement('option'));
        SelectOptionIndustry.html("--Select---");
        SelectOptionIndustry.val("");
        benchSelectIndustry.append(SelectOptionIndustry);

        var SelectOptionIndustry = $(document.createElement('option'));
        SelectOptionIndustry.html("Indigenous");
        SelectOptionIndustry.val("indigenous");
        benchSelectIndustry.append(SelectOptionIndustry);

        var SelectOptionIndustry = $(document.createElement('option'));
        SelectOptionIndustry.html("Imported");
        SelectOptionIndustry.val("imported");
        benchSelectIndustry.append(SelectOptionIndustry);
        //================CREATING DROP DOWN TO SELECT SOURCE OF TYPE==========

        //===============mineral ore metal select box=================================
        var benchTd1 = $(document.createElement('td'));
        benchTd1.attr('align', "center");
        benchTd1.attr('vAlign', "top");
        benchTr1.append(benchTd1);
        var benchSelectMetal = $(document.createElement('select'));
        benchSelectMetal.attr('id', "sour_mineral_" + counter);
        benchSelectMetal.attr('name', "sour_mineral_" + counter);
        benchSelectMetal.attr('class', 'MakeRequired makeNilDD putUnit');
        benchSelectMetal.css("width", "80px");
        benchTd1.append(benchSelectMetal);
        //==================CREATING THE SELECT BOX OPTIONS=========================
        var SelectOptionMetal = $(document.createElement('option'));
        SelectOptionMetal.html("--Select---");
        SelectOptionMetal.val("");
        benchSelectMetal.append(SelectOptionMetal);
        $.each(this.dataRawMineral, function(index, item) {
        var options = $(document.createElement('option'));
        options.html(item);
        options.val(item);
        benchSelectMetal.append(options);
        });
        //======================name & address of suuplier========================== 
        var benchTd1 = $(document.createElement('td'));
        benchTd1.attr('align', "center");
        benchTd1.attr('vAlign', "top");

        var benchOreInput1 = $(document.createElement('input'));
        benchOreInput1.attr('type', "text");
        benchOreInput1.attr('id', "sour_name_add_" + counter);
        benchOreInput1.attr('name', "sour_name_add_" + counter);
        benchOreInput1.attr('class', 'MakeRequired makeNilChar indigenous indigenous_' + counter);
        benchOreInput1.css("width", "200px");
        benchOreInput1.addClass("text-fields address");
        benchTd1.append(benchOreInput1);
        benchTr1.append(benchTd1);
        //=============== Source Of Supply==========================================

        var benchTd1 = $(document.createElement('td'));
        benchTd1.attr('align', "center");
        benchTd1.attr('vAlign', "top");
        benchTr1.append(benchTd1);
        var table1 = $(document.createElement('table'));
        benchTd1.append(table1);
        var benchTr2 = $(document.createElement('tr'));
        table1.append(benchTr2);
        var benchTd2 = $(document.createElement('td'));
        benchTr2.append(benchTd2);
        var benchOreInput1 = $(document.createElement('input'));
        benchOreInput1.attr('id', "sour_mine_area_" + counter);
        benchOreInput1.attr('name', "sour_mine_area_" + counter);
        benchOreInput1.attr('class', 'MakeRequired makeNilChar indigenous mineCode indigenous_' + counter);
        benchOreInput1.css("width", "80px");
        benchOreInput1.addClass("text-fields address");
        benchTd2.append(benchOreInput1);
        benchTr2.append(benchTd2);
        var benchTd2 = $(document.createElement('td'));
        var img = $(document.createElement('img'));
        img.attr('src', $("#imagePath").val() + "search.jpg");
        img.attr('alt', "Search Registration Number");
        img.addClass('Serarch_img_td');
        benchTd2.append(img);
        benchTr2.append(benchTd2);

        var benchTdDis = $(document.createElement('td'));
        benchTr2.append(benchTdDis);
        var benchSelectDistrict = $(document.createElement('select'));
        benchSelectDistrict.attr('id', "sour_mine_area_dist_" + counter);
        benchSelectDistrict.attr('name', "sour_mine_area_dist_" + counter);
        benchSelectDistrict.attr('class', 'MakeRequired makeNilDD indigenous indigenous_' + counter);
        benchSelectDistrict.css("width", "80px");
        benchTdDis.append(benchSelectDistrict);
        //benchSelect.className = fieldName1 + "_select" + " selectbox-small";
        //==================CREATING THE SELECT BOX OPTIONS=========================

        $.each(this.dataDistrict, function(index, item) {
        var options = $(document.createElement('option'));
        if (index == "") {
            options.html(item);
            options.val("");
        }
        else {
            options.html(item);
            options.val(item);
        }
        benchSelectDistrict.append(options);
        });

        //================== Indiacate the distance=================================== 

        var benchTd1 = $(document.createElement('td'));
        benchTd1.attr('align', "center");
        benchTd1.attr('vAlign', "top");
        var benchOreInput1 = $(document.createElement('input'));
        benchOreInput1.attr('id', "sour_ind_dis_" + counter);
        benchOreInput1.attr('name', "sour_ind_dis_" + counter);
        benchOreInput1.attr('class', 'MakeRequired makeNilInt right indigenous indigenous_' + counter);
        benchOreInput1.css("width", "40px");
        benchOreInput1.addClass("text-fields distance");
        benchTd1.append(benchOreInput1);
        benchTr1.append(benchTd1);

        //=========================    Mode====================================== 

        var benchTd1 = $(document.createElement('td'));
        benchTd1.attr("align", "center");
        benchTd1.attr("vAlign", "top");
        benchTr1.append(benchTd1);
        var benchModeSelect = $(document.createElement('select'));
        benchModeSelect.attr('id', "sour_tran_mode_" + counter);
        benchModeSelect.attr('name', "sour_tran_mode_" + counter);
        benchModeSelect.attr('class', 'MakeRequired makeNilDD indigenous indigenous_' + counter);
        benchModeSelect.css('width', "80px");
        benchTd1.append(benchModeSelect);
        //==================CREATING THE SELECT BOX OPTIONS=========================        
        var SelectOptionMode = $(document.createElement('option'));
        SelectOptionMode.html("--Select---");
        SelectOptionMode.val("");
        benchModeSelect.append(SelectOptionMode);
        $.each(this.dataMode, function(index, item) {
        var options = $(document.createElement('option'));
        options.html(item);
        options.val(item);
        benchModeSelect.append(options);
        });
        //===========cost per tone===============================================

        var benchTd1 = $(document.createElement('td'));
        benchTd1.attr('align', "center");
        benchTd1.attr('vAlign', "top");
        var benchSelect = $(document.createElement('input'));
        benchSelect.attr('id', "sour_tran_cost_" + counter);
        benchSelect.attr('name', "sour_tran_cost_" + counter);
        benchSelect.attr('class', 'MakeRequired makeNilInt right indigenous indigenous_' + counter);
        benchSelect.css('width', "80px");
        benchSelect.addClass("cost");
        benchTd1.append(benchSelect);
        benchTr1.append(benchTd1);

        //=============Quanatity==============================================

        var benchTd1 = $(document.createElement('td'));
        benchTd1.attr('align', "center");
        benchTd1.attr('vAlign', "top");
        var benchSelect = $(document.createElement('input'));
        benchSelect.attr('id', "sour_qty_" + counter);
        benchSelect.attr('name', "sour_qty_" + counter);
        benchSelect.attr('class', 'MakeRequired makeNilInt right indigenous indigenous_' + counter);
        benchSelect.addClass('qty');
        benchSelect.css('width', "80px");
        benchTd1.append(benchSelect);
        benchTr1.append(benchTd1);

        //=====================================price per metric==================

        var benchTd1 = $(document.createElement('td'));
        benchTd1.attr('align', "center");
        benchTd1.attr('vAlign', "top");
        var benchSelect = $(document.createElement('input'));
        benchSelect.attr('id', "sour_price_" + counter);
        benchSelect.attr('name', "sour_price_" + counter);
        benchSelect.attr('class', 'MakeRequired makeNilInt right indigenous indigenous_' + counter);
        benchSelect.css("width", "80px");
        benchSelect.addClass("price")
        benchTd1.append(benchSelect);
        benchTr1.append(benchTd1);


        //=====================================Address==================

        var benchTd1 = $(document.createElement('td'));
        benchTd1.attr('align', "center");
        benchTd1.attr('vAlign', "top");
        var benchSelect = $(document.createElement('input'));
        benchSelect.attr('type', "text");
        benchSelect.attr('id', "sour_supplier_add_" + counter);
        benchSelect.attr('name', "sour_supplier_add_" + counter);
        benchSelect.attr('class', 'MakeRequired makeNilChar imported imported_' + counter);
        benchSelect.addClass("text-fields address");
        benchSelect.css('width', '200px');
        benchTd1.append(benchSelect);
        benchTr1.append(benchTd1);

        //============Supplier Country===========================================    

        var benchTd1 = $(document.createElement('td'));
        benchTd1.attr('align', "center");
        benchTd1.attr('vAlign', "top");
        benchTr1.append(benchTd1);
        var benchSelectCountry = $(document.createElement('select'));
        benchSelectCountry.attr('id', "sour_supplier_country_" + counter);
        benchSelectCountry.attr('name', "sour_supplier_country_" + counter);
        benchSelectCountry.attr('class', 'MakeRequired makeNilDD imported imported_' + counter);
        benchSelectCountry.css("width", "80px");
        benchTd1.append(benchSelectCountry);
        //==================CREATING THE SELECT BOX OPTIONS=========================  
        var SelectOption = $(document.createElement('option'));
        SelectOption.html("--Select---");
        SelectOption.val("");
        benchSelectCountry.append(SelectOption);
        $.each(this.dataCountry, function(index, item) {
        var options = $(document.createElement('option'));
        options.html(item);
        options.val(item);
        benchSelectCountry.append(options);
        });

        //============Supplier Country===========================================
        var benchTd1 = $(document.createElement('td'));
        benchTd1.attr('align', "center");
        benchTd1.attr('vAlign', "top");
        var benchSelect = $(document.createElement('input'));
        benchSelect.attr('id', "sour_qty_purch_" + counter);
        benchSelect.attr('name', "sour_qty_purch_" + counter);
        benchSelect.attr('class', 'MakeRequired makeNilInt right imported imported_' + counter);
        benchSelect.css("width", "80px");
        benchSelect.addClass('qty');
        benchTd1.append(benchSelect);
        benchTr1.append(benchTd1);


        //============Supplier Country===========================================


        var benchTd1 = $(document.createElement('td'));
        benchTd1.attr('align', "center");
        benchTd1.attr('vAlign', "top");
        var benchSelect = $(document.createElement('input'));
        benchSelect.attr('id', "sour_cost_metric_" + counter);
        benchSelect.attr('name', "sour_cost_metric_" + counter);
        benchSelect.attr('class', 'MakeRequired makeNilInt right imported imported_' + counter);
        benchSelect.css("width", "80px");
        benchSelect.addClass('price');
        benchTd1.append(benchSelect);
        benchTr1.append(benchTd1);

        if (counter > 1) {

        var removeBtnTd = $(document.createElement('td'));
        removeBtnTd.addClass("h-close-icon");
        removeBtnTd.attr('id', "deleteRow");
        removeBtnTd.bind('click', function() {
            var tr_id = $(this).closest('tr').attr('id');
            var str_sp = tr_id.split('_');
            $('#' + tr_id).remove();
            var indx = parseInt(str_sp[3]) + 1;
            for (i = indx; i <= $('#source_of_supply_count').val(); i++)
            {
            var intval = i - 1;
            $('#source_supply_tr_' + i).attr('id', 'source_supply_tr_' + intval);

            $('#sour_indus_' + i).attr('name', 'sour_indus_' + intval);
            $('#sour_mineral_' + i).attr('name', 'sour_mineral_' + intval);
            $('#sour_name_add_' + i).attr('name', 'sour_name_add_' + intval);
            $('#sour_mine_area_' + i).attr('name', 'sour_mine_area_' + intval);
            $('#sour_mine_area_dist_' + i).attr('name', 'sour_mine_area_dist_' + intval);
            $('#sour_ind_dis_' + i).attr('name', 'sour_ind_dis_' + intval);
            $('#sour_tran_mode_' + i).attr('name', 'sour_tran_mode_' + intval);

            $('#sour_tran_cost_' + i).attr('name', 'sour_tran_cost_' + intval);
            $('#sour_qty_' + i).attr('name', 'sour_qty_' + intval);
            $('#sour_price_' + i).attr('name', 'sour_price_' + intval);
            $('#sour_supplier_add_' + i).attr('name', 'sour_supplier_add_' + intval);
            $('#sour_supplier_country_' + i).attr('name', 'sour_supplier_country_' + intval);
            $('#sour_qty_purch_' + i).attr('name', 'sour_qty_purch_' + intval);
            $('#sour_cost_metric_' + i).attr('name', 'sour_cost_metric_' + intval);

            $('#sour_indus_' + i).attr('id', 'sour_indus_' + intval);
            $('#sour_mineral_' + i).attr('id', 'sour_mineral_' + intval);
            $('#sour_name_add_' + i).attr('id', 'sour_name_add_' + intval);
            $('#sour_mine_area_' + i).attr('id', 'sour_mine_area_' + intval);
            $('#sour_mine_area_dist_' + i).attr('id', 'sour_mine_area_dist_' + intval);
            $('#sour_ind_dis_' + i).attr('id', 'sour_ind_dis_' + intval);
            $('#sour_tran_mode_' + i).attr('id', 'sour_tran_mode_' + intval);

            $('#sour_tran_cost_' + i).attr('id', 'sour_tran_cost_' + intval);
            $('#sour_qty_' + i).attr('id', 'sour_qty_' + intval);
            $('#sour_price_' + i).attr('id', 'sour_price_' + intval);
            $('#sour_supplier_add_' + i).attr('id', 'sour_supplier_add_' + intval);
            $('#sour_supplier_country_' + i).attr('id', 'sour_supplier_country_' + intval);
            $('#sour_qty_purch_' + i).attr('id', 'sour_qty_purch_' + intval);
            $('#sour_cost_metric_' + i).attr('id', 'sour_cost_metric_' + intval);

            }
            $('#source_of_supply_count').val($('#source_of_supply_count').val() - 1);

            //=========ADD NIL TO FIRST ELEMENT IF THE NUMBER OF ROWS ID ONE========
            SourceOfSupplyNew.nilFill();

        });
        benchTr1.append(removeBtnTd);

        }
        $('#source_of_supply_table').append(benchTr1);
    },
    nilFill: function() {
        var _this = this;
        var countTotalRows = $("#sourceOfSupply .sourceType").length;
        if (this.dataRawMineral == 'NIL') {

            // console.log(SourceOfSupplyNew.data)
            // $("#sour_indus_1").append($("<option></option>").html("uday").val("NIL"));
            // $("#sour_indus_1").val('NIL');
            // $("#sour_indus_1").val("indigenous").remove();
            $(".makeNilDD").val("NIL");
            $(".makeNilChar").val("NA");
            $(".makeNilInt").val(0);

            $('#sour_indus_1 option:eq(1)').remove();
            $('#sour_indus_1 option:eq(1)').remove();
            $('#unitSpan_sour_mineral_1').remove();

            //            $(".sourceType").attr('readonly', true);
            $(".putUnit").attr('disabled', true);
            $(".indigenous").attr('disabled', true);
            $(".imported").attr('disabled', true);
            //            $(".sourceType").css('background-color', '#D1D0CE');
            $(".putUnit").css('background-color', '#D1D0CE');
            $(".indigenous").css('background-color', '#D1D0CE');
            $(".imported").css('background-color', '#D1D0CE');
            $("#source_of_supply_AddMore").remove();
            if (countTotalRows == 1) {
                var DDNilOption = $(document.createElement('option'));
                DDNilOption.html("NIL").val("NIL");

                $("#sour_indus_1").append(DDNilOption); // ADDING ONLY FOR FIRST ONE...



                if ($("#checkNilRow").val() == 1) {
                var DDNilOption = $(document.createElement('option'));
                DDNilOption.html("NIL").val("NIL");
                $("#sour_mineral_1").append(DDNilOption); // ADDING ONLY FOR FIRST ONE...
                $("#sour_mine_area_dist_1").append(DDNilOption); // ADDING ONLY FOR FIRST ONE...
                $("#sour_supplier_country_1").append(DDNilOption); // ADDING ONLY FOR FIRST ONE...
                $("#sour_tran_mode_1").append(DDNilOption); // ADDING ONLY FOR FIRST ONE...
                if (SourceOfSupplyNew.data.sour_indus_1 != 'NIL') {
                    $("#sour_indus_1").val("");
                }
                else {
                    $("#sour_indus_1").val("NIL");
                }
                $("#sour_mineral_1").val("NIL");
                $("#sour_mine_area_dist_1").val("NIL");
                $("#sour_supplier_country_1").val("NIL");
                $("#sour_tran_mode_1").val("NIL");

                }

            }
        }

        $("#sourceOfSupply .sourceType").off("change");
        $("#sourceOfSupply").on('change', '.sourceType', function() {
            var elementId = $(this).attr("id");
            var elementValue = $(this).val();
            //==============HANDLING NIL TYPE CONDITION STARTS==============
            if (elementId == 'sour_indus_1' && elementValue == 'NIL') {
                $(".makeNilDD").find('option[value=NIL]').remove();


                $(".indigenous").attr('disabled', true);
                $(".imported").attr('disabled', true);
                $(".indigenous").css('background-color', '#D1D0CE');
                $(".imported").css('background-color', '#D1D0CE');

                var confirmAction = window.confirm("Selecting NIL in the Industries Drop box will automatically fill 0 and NA in corespoding fields. Are you still want to continue ? ");
                if (confirmAction == true) {
                $(".makeNilDD").append($("<option></option>").html("NIL").val("NIL"));
                $(".makeNilDD").val("NIL");
                $(".makeNilChar").val("NA");
                $(".makeNilInt").val(0);
                }
                else {
                $(this).val("");
                }
            }
            else {
                //var elementNo = elementId.substr(-1);
                var elementNoTemp = elementId.split("_");
                var elementNo = elementNoTemp[2];
                // console.log(elementNoTemp)
                // console.log(elementId)
                // console.log(elementNo)
                if (elementValue == 'imported') {
                    _this.importedChange(elementNo);
                }
                else if (elementValue == 'indigenous') {
                    _this.indigenousChange(elementNo);
                }
                // $(".makeNilDD").val("");
                // $(".makeNilChar").val("");
                // $(".makeNilInt").val("");

            }
            //================HANDLING NIL TYPE CONDITION ENDS==============


        });


        //==============CODE FOR PUTTING THE UNIT OF MESUREMENT OF THE MINERAL======
        $("#sourceOfSupply .putUnit").off("change");
        $("#sourceOfSupply").on('change', '.putUnit', function() {
            var elementVal = $(this).val();

            var trEl = $(this).closest('tr').attr('id');
            $("#sourceOfSupply #unitSpan_" + trEl).text('');
            getRawMatMetUnitUrl = $('#get_raw_meterial_metals_unit').val();

            if (elementVal != "NIL" && elementVal != "") {
                // Utilities.ajaxBlockUI();
                $.ajax({
                    url: getRawMatMetUnitUrl,
                    type: 'POST',
                    data: ({
                        value: elementVal
                    }),
                    beforeSend: function (xhr) {
                        xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
                    },
                    success: function(response) {
                        $("#sourceOfSupply #unitSpan_" + trEl).text(response);
                    }
                });
            }
        });
    },
    importedChange: function(elementNo) {
        var classToDisable = "#sourceOfSupply .indigenous_" + elementNo;
        var classToEnable = "#sourceOfSupply .imported_" + elementNo;

        $(classToDisable).val("");
        $(classToDisable).attr('disabled', true);
        $(classToEnable).removeAttr('disabled');

        $(classToDisable).css('background-color', '#D1D0CE');
        $(classToEnable).css('background-color', '');

    },
    indigenousChange: function(elementNo) {
        var classToDisable = "#sourceOfSupply .imported_" + elementNo;
        var classToEnable = "#sourceOfSupply .indigenous_" + elementNo;
        $(classToDisable).val("");
        $(classToDisable).attr('disabled', true);
        $(classToEnable).removeAttr('disabled');

        $(classToDisable).css('background-color', '#D1D0CE');
        $(classToEnable).css('background-color', '');

    },
    //Get Mine Code by shalini date :12/01/2022 
    getMineCode: function() {
        $('#sourceOfSupply').on('keyup', '.mineCode', function(){
            var curEl = $(this).attr('id');
            var curElArr = curEl.split('_');
            
            var numRw = curElArr[3];
            var app_id = $(this).val();
            var appUrl = $('#mine_code_url').val();
            if (app_id !=="") {
                $.ajax({
                    url:appUrl,
                    type:"POST",
                    cache:false,
                    beforeSend: function (xhr) {
                        xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
                    },
                    data:{'app_id':app_id},
                    success:function(data){
                        $("#suggestion_box_"+numRw).html(data);
                        $("#suggestion_box_"+numRw).fadeIn();
                    }  
                });
            }else{
                $("#suggestion_box_"+numRw).html("");  
                $("#suggestion_box_"+numRw).fadeOut();
            }
        });
    }, //end
    formSaveAction: function() {
        $("#sourceOfSupply").submit(function(event) {
        var filledMineral = $(".putUnit");
        var filledMineralArray = new Array();
        var sourceOfSupplyTypeValWithMineralArray = new Array();

        for (var i = 0; i < filledMineral.length; i++) {
            var mineralrowId = filledMineral[i].id;
            var sourceOfSupplyTypeId = mineralrowId.replace("mineral", "indus");
            var sourceOfSupplyTypeVal = $("#" + sourceOfSupplyTypeId).val();
            var sourceOfSupplyTypeValWithMineral = sourceOfSupplyTypeVal + "-" + filledMineral[i].value;

            //                filledRowIdArray.push(filledMineral[i].id);  ARRAY OF ID IS NOT REQUIRED CURRENTLY MAY BE USED LATER IF NEEDED
            // CREATING THE ARRAY OF SELECTED MINERAL VALUES BUT THEY MUST HAVE TO BBE UNIQUE AS THE MINERAL COMING FROM RAW ARE UNIQUE
            if ($.inArray(filledMineral[i].value, filledMineralArray) == -1) {
            filledMineralArray.push(filledMineral[i].value);
            }

            // HERE WE ARE JUST PUSING WHATEVER HE HAS SELECTED IN WHOLE FOME AS WE WILL RUN A LOOP N THIS ARRAY TO COUNT THIS UNIQUE ID 
            // IF IT'S GREATD THAN 1 IT MEANS HE HAS ENTER COMBINATION OF TYPE AND MINERAL TWICE SO WE WILL POP A ALERT
            sourceOfSupplyTypeValWithMineralArray.push(sourceOfSupplyTypeValWithMineral);
        }

        var mineralNameArray = SourceOfSupplyNew.dataRawMineral; // this array contains the mineral coming from source of supply

        //=================BELOW CODE WILL RETURN THE MINERAL DIFF IN ARRAY FORMAT STARTS HERE===========
        var mineralDiffArray = [];
        var i = 0;
        $.grep(mineralNameArray, function(el) {
            if ($.inArray(el, filledMineralArray) == -1)
            mineralDiffArray.push(el);
            i++;
        });
        //=================ABOVE CODE WILL RETURN THE MINERAL DIFF IN ARRAY FORMAT ENDS HERE===========
        //============BELOW LINE WILL GIVE THE ALERT IF ANY OF THE MINERAL IS LEFT FOR SELECTION==========
        if (mineralDiffArray.length != 0) {
            alert("Data for all the minerals coming in the 'Mineral/Ore/Metal/Ferro-Alloy' Drop down box are needed to be filled, as you have selected these mineral in 'Raw materials consumed in production' form OR remove that mineral record from 'Raw materials consumed in production' form.");
            event.preventDefault();
        }
        //===============BELOW LINE CODE CHECKS IF THERE IS SAME COMBINATION OF TYPE AND MINERAL IS SELECTED TWICE STARTS==========
        var errorCountFlag = 0;
        $(sourceOfSupplyTypeValWithMineralArray).each(function(key1, value1) {
            var mineralCount = 0;
            $(sourceOfSupplyTypeValWithMineralArray).each(function(key1, value2) {
            if (value1 == value2) {
                mineralCount++;
            }
            });
            if (mineralCount > 1) {
            errorCountFlag = 1;
            }
        });
        // COMMENTING THESE AS NOT REQUIRED NOW MAY BE USED LATER
        if (errorCountFlag == 1) {
        //                alert("Sorry... You can't select same combination of 'Type' and 'Mineral/Ore/Metal/Ferro-Alloy' twice.");
        //                event.preventDefault();
        }
        //===============BELOW LINE CODE CHECKS IF THERE IS SAME COMBINATION OF TYPE AND MINERAL IS SELECTED TWICE ENDS==========
        });
    }
};


$(document).ready(function() {

    SourceOfSupplyNew.nilFill();
    SourceOfSupplyNew.validateSource();
    SourceOfSupplyNew.getMineCode();
    upIndImpField();
    ssUpRemBtn();
     //Mine Code By shalini date :12/01/2022 
    $(document).on("click",".sugg-box ul li", function(){
        var sugBoxId = $(this).closest('.sugg-box').attr('id');
        var curBx = sugBoxId.split('_');
        var boxRw = curBx[2];
        $('#sour_mine_area_'+boxRw).val($(this).text());
        $('#suggestion_box_'+boxRw).fadeOut("fast");
    });//end
    
	$(document).on('click', '#ss_add_more_btn', function(event) {
        
        var checkIndustryFirstDDForNil = $("#sourceOfSupply #sour_indus_1").val();
        if (checkIndustryFirstDDForNil == "NIL") {
            alert("Sorry... You can't add more rows while selecting NIL in the Industries Drop Box.");
            event.preventDefault();
        }
        else if (checkIndustryFirstDDForNil == "") {
            alert("Kindly Select the Type first.");
            event.preventDefault();
        }
        else {

            ssAddMoreRow();
            // REMOVING NIL FROM THE LIST AS NO OF ROWS ARE NOW MORE THAN 1
            $("#sourceOfSupply #sour_indus_1").find('option[value=NIL]').remove();

        }

	});

	$(document).on('click', '.ss_remove_btn_btn', function() {
		var trId = $(this).closest('tr').attr('id');
		ssRemRow(trId);
	});

    // var data_url = "<?php echo url_for('oSeries/getSourceSupplyDetails'); ?>";
    // var country_url = "<?php echo url_for('oSeries/getSourceSupplyCountries'); ?>";
    // var mode_url = "<?php echo url_for('oSeries/getSourceSupplyModes'); ?>";
    // // var industries_url = "<?php // echo url_for('oSeries/getSourceSupplyIndustries');    ?>";
    // var rawMineral_url = "<?php echo url_for('oSeries/getSourceSupplyMineralBasedOnRaw'); ?>";
    // var metal_url = "<?php echo url_for('oSeries/getSourceSupplyMetals'); ?>";
    // // var metal_url = "<?php // echo url_for('oSeries/getRawMaterialMetals');    ?>";
    // var district_url = "<?php echo url_for('oSeries/getSourceSupplyDistricts'); ?>";
    // var unit_url = "<?php echo url_for('oSeries/getRawMaterialMetalsUnit'); ?>";
    // var mine_code_url = "<?php echo url_for("oSeries/getMineCodes"); ?>";
    // SourceOfSupplyNew.init(data_url, country_url, mode_url, rawMineral_url, metal_url, district_url, unit_url, mine_code_url);

});


function ssAddMoreRow(){

	var currentRow = $('#source_of_supply_table tbody tr:last').attr('id');
	var extractId = currentRow.split('-');
	var incRow = parseInt(extractId[1]) + parseInt(1);
	var valueBlank = "";
	
    var rowContainer = "<tr id='trow-"+incRow+"'>";
	rowContainer += $('#trow-1').html();
	rowContainer = rowContainer.replace(/\=\"sour_indus_1\"/g, '\=\"sour_indus_'+incRow+'\"');
	rowContainer = rowContainer.replace(/\=\"sour_mineral_1\"/g, '\=\"sour_mineral_'+incRow+'\"');
	// rowContainer = rowContainer.replace(/\=\"unitSpan_trow-1\"/g, '\=\"unitSpan_trow-'+incRow+'\"');
	rowContainer = rowContainer.replace(/id\=\"unitSpan_trow-1\"\>(.*?)\</g, 'id\=\"unitSpan_trow-'+incRow+'"\>\<');
	rowContainer = rowContainer.replace(/\=\"sour_name_add_1\"/g, '\=\"sour_name_add_'+incRow+'\"');
	rowContainer = rowContainer.replace(/indigenous indigenous_1/g, 'indigenous indigenous_'+incRow);
	rowContainer = rowContainer.replace(/\=\"sour_mine_area_1\"/g, '\=\"sour_mine_area_'+incRow+'\"');

    rowContainer = rowContainer.replace(/\=\"suggestion_box_1\"/g, '\=\"suggestion_box_'+incRow+'\"'); // line added by shalini date : 12/01/22

	rowContainer = rowContainer.replace(/mineCode indigenous_1/g, 'mineCode indigenous_'+incRow);
	rowContainer = rowContainer.replace(/\=\"sour_mine_area_dist_1\"/g, '\=\"sour_mine_area_dist_'+incRow+'\"');
	rowContainer = rowContainer.replace(/\=\"sour_ind_dis_1\"/g, '\=\"sour_ind_dis_'+incRow+'\"');
	rowContainer = rowContainer.replace(/\=\"sour_tran_mode_1\"/g, '\=\"sour_tran_mode_'+incRow+'\"');
	rowContainer = rowContainer.replace(/\=\"sour_tran_cost_1\"/g, '\=\"sour_tran_cost_'+incRow+'\"');
	rowContainer = rowContainer.replace(/\=\"sour_qty_1\"/g, '\=\"sour_qty_'+incRow+'\"');
	rowContainer = rowContainer.replace(/\=\"sour_price_1\"/g, '\=\"sour_price_'+incRow+'\"');
	rowContainer = rowContainer.replace(/\=\"sour_supplier_add_1\"/g, '\=\"sour_supplier_add_'+incRow+'\"');
	rowContainer = rowContainer.replace(/imported imported_1/g, 'imported imported_'+incRow);
	rowContainer = rowContainer.replace(/\=\"sour_supplier_country_1\"/g, '\=\"sour_supplier_country_'+incRow+'\"');
	rowContainer = rowContainer.replace(/\=\"sour_qty_purch_1\"/g, '\=\"sour_qty_purch_'+incRow+'\"');
	rowContainer = rowContainer.replace(/\=\"sour_cost_metric_1\"/g, '\=\"sour_cost_metric_'+incRow+'\"');
	rowContainer = rowContainer.replace(/\" value\=\"(.*?)\"/g, '\" value\=\"'+valueBlank+'\"');
	rowContainer = rowContainer.replace(/ selected\=\"selected\"/g, '');
	rowContainer = rowContainer.replace(/ disabled\=\"disabled\"/g, '');
	rowContainer = rowContainer.replace(/class\=\"remove_btn\"\>(.*?)\</g, 'class\=\"remove_btn\"\>\<button type\=\"button\" class\=\"btn btn\-sm ss\_remove\_btn\_btn\" \><i class\=\"fa fa\-times\"\>\<\/\i\>\<\/button\>\<');
	rowContainer += "</tr>";


	
	$('#source_of_supply_table tbody').append(rowContainer);
	ssUpRemBtn();
    ssUpRwCount();
	
}

function ssUpRemBtn(){

	var totalRows = $('#source_of_supply_table tbody tr').length;
	if(totalRows == 2){
		$('#source_of_supply_table tbody tr .ss_remove_btn_btn').removeAttr('disabled');
	} else if(totalRows == 1) {
		$('#source_of_supply_table tbody tr:first .ss_remove_btn_btn').attr('disabled','true');
	}

}

function ssRemRow(tId){
	
	$('#source_of_supply_table #' + tId).remove();
    ssUpIds();
	ssUpRemBtn();
    ssUpRwCount();
	
}

function ssUpIds() {

	var totRows = $('#source_of_supply_table tbody tr').length;
	// var rId = parseInt(extractId[1]);
    for (var n=0; n < totRows; n++) {
        var cEl = $('#source_of_supply_table tbody tr').eq(n);
        var cIdRw = cEl.attr('id');
        var cIdArr = cIdRw.split('-');
        var cId = cIdArr[1];
        var nId = parseInt(n) + 1;
        cEl.find('#sour_indus_'+cId).attr({'name':'sour_indus_'+nId, 'id':'sour_indus_'+nId});
        cEl.find('#sour_mineral_'+cId).attr({'name':'sour_mineral_'+nId, 'id':'sour_mineral_'+nId});
        cEl.find('#sour_name_add_'+cId).attr({'name':'sour_name_add_'+nId, 'id':'sour_name_add_'+nId, 'class':'form-control form-control-sm m_w_70 MakeRequired makeNilChar indigenous indigenous_'+nId+' text-fields address'});
        cEl.find('#sour_mine_area_'+cId).attr({'name':'sour_mine_area_'+nId, 'id':'sour_mine_area_'+nId, 'class':'form-control form-control-sm m_w_70 MakeRequired makeNilChar indigenous mineCode indigenous_'+nId+' text-fields address ui-autocomplete-input'});
        cEl.find('#sour_mine_area_dist_'+cId).attr({'name':'sour_mine_area_dist_'+nId, 'id':'sour_mine_area_dist_'+nId, 'class':'form-control form-control-sm m_w_70 MakeRequired makeNilDD indigenous indigenous_'+nId});
        cEl.find('#sour_ind_dis_'+cId).attr({'name':'sour_ind_dis_'+nId, 'id':'sour_ind_dis_'+nId, 'class':'form-control form-control-sm m_w_70 MakeRequired makeNilInt right indigenous indigenous_'+nId+' text-fields distance'});
        cEl.find('#sour_tran_mode_'+cId).attr({'name':'sour_tran_mode_'+nId, 'id':'sour_tran_mode_'+nId, 'class':'form-control form-control-sm m_w_70 MakeRequired makeNilDD indigenous indigenous_'+nId});
        cEl.find('#sour_tran_cost_'+cId).attr({'name':'sour_tran_cost_'+nId, 'id':'sour_tran_cost_'+nId, 'class':'form-control form-control-sm m_w_70 MakeRequired makeNilInt right indigenous indigenous_'+nId+' cost'});
        cEl.find('#sour_qty_'+cId).attr({'name':'sour_qty_'+nId, 'id':'sour_qty_'+nId, 'class':'form-control form-control-sm m_w_70 MakeRequired makeNilInt right indigenous indigenous_'+nId+' qty'});
        cEl.find('#sour_price_'+cId).attr({'name':'sour_price_'+nId, 'id':'sour_price_'+nId, 'class':'form-control form-control-sm m_w_70 MakeRequired makeNilInt right indigenous indigenous_'+nId+' price'});
        cEl.find('#sour_supplier_add_'+cId).attr({'name':'sour_supplier_add_'+nId, 'id':'sour_supplier_add_'+nId, 'class':'form-control form-control-sm m_w_70 MakeRequired makeNilChar imported imported_'+nId+' text-fields address'});
        cEl.find('#sour_supplier_country_'+cId).attr({'name':'sour_supplier_country_'+nId, 'id':'sour_supplier_country_'+nId, 'class':'form-control form-control-sm m_w_70 MakeRequired makeNilDD imported imported_'+nId});
        cEl.find('#sour_qty_purch_'+cId).attr({'name':'sour_qty_purch_'+nId, 'id':'sour_qty_purch_'+nId, 'class':'form-control form-control-sm m_w_70 MakeRequired makeNilInt right imported imported_'+nId+' qty'});
        cEl.find('#sour_cost_metric_'+cId).attr({'name':'sour_cost_metric_'+nId, 'id':'sour_cost_metric_'+nId, 'class':'form-control form-control-sm m_w_70 MakeRequired makeNilInt right imported imported_'+nId+' price'});
        cEl.attr('id', 'trow-'+nId);
        
    }

}

function ssUpRwCount() {

	var totRows = $('#source_of_supply_table tbody tr').length;
    $('#source_of_supply_count').val(totRows);

}

function upIndImpField() {

	var totRows = $('#source_of_supply_table tbody tr').length;
    for (var n=1; n <= totRows; n++) {
        
        var sourceType = $('#source_of_supply_table tbody tr:nth-child('+n+') .sourceType').val();
        if (sourceType == 'imported') {
            SourceOfSupplyNew.importedChange(n);
        } else if (sourceType == 'indigenous') {
            SourceOfSupplyNew.indigenousChange(n);
        }

    }

}

// below comment button by ganesh satav as per the discuss with ibm person 
// added by ganesh satav dated 3 Sep 2014
// function printForm()
// {
//     var container = document.getElementById("source_of_supply_div");
//     myWindow = window.open('', '_blank', 'location=no, scrollbars=yes');
//     var css_file_path = document.getElementById("css_file_path").value;
//     var image_file_path = document.getElementById("image_file_path").value;
//     var print_data = "<link rel='stylesheet' href=" + css_file_path + "style.css type='text/css'>";
//     print_data += "<img src=" + image_file_path + "mail-header.jpg" + " alt='Header Image' border='0' title='Header Image'>";
//     print_data += container.innerHTML;
//     myWindow.document.write(print_data);

//     var text_inp = new Array();
//     var inp = myWindow.document.getElementsByTagName('input');

//     for (var i = 0; i < inp.length; i++) {
//         if (inp[i].type == 'text')
//             text_inp.push(inp[i].id);
//     }

//     for (var i = 0; i < text_inp.length; i++) {

//         var text_box = myWindow.document.getElementById(text_inp[i]);
//         var tb_value = text_box.value;
//         text_box.parentNode.innerHTML = $('#' + text_inp[i]).val();
//     }
//     var select_inp = new Array();
//     var sel = myWindow.document.getElementsByTagName('select');
//     for (var i = 0; i < sel.length; i++) {

//         select_inp.push(sel[i].id);
//     }
//     for (var i = 0; i < select_inp.length; i++) {

//         var select_box = myWindow.document.getElementById(select_inp[i]);

//         var sel_option = $('#' + select_inp[i] + " option:selected").text()
//         if ((sel_option == '--Select---') || (sel_option == '-Plase Select District-'))
//             select_box.parentNode.innerHTML = " ";
//         else
//             select_box.parentNode.innerHTML = sel_option;
//     }
//     $(myWindow.document).find('.h-add-more-btn').html("");
//     $(myWindow.document).find('.Serarch_img_td').remove();
//     $(myWindow.document).find('.h-close-icon').removeClass('h-close-icon');

//     myWindow.document.close();
//     myWindow.focus();
//     myWindow.print();

//     return true;
// }

$(document).ready(function(){

    $(document).on('click',function(){
        $('.sugg-box').hide();
    });

});