/* 
 * This file holds the code of O-Form creation and its validation
 * 
 */
var MineralBasedIndustries = {
    init: function()
    {
      var _this = this;
      _this.MineralBasedIndustriesValidate();
  
    },
    selectindustry: function(indName) {
  
      if (indName == 'other')
        $("#other_industry_name").removeAttr("disabled");
      else
        $("#other_industry_name").attr("disabled", "disabled");
    },
    selectState: function(state_code) {
      Utilities.ajaxBlockUI();
      $.ajax({
        url: 'getDistricts',
        data: 'state=' + state_code,
        type: 'POST',
        success: function(response) {
          var data = json_parse(response);
          $('#district_code').find('option').remove();
          var district = $('#district_code');
          var option = $(document.createElement('option'));
          option.html('-Please Select District-');
          option.val('');
          district.append(option);
          for (var i = 0; i < data.length; i++) {
            var option = $(document.createElement('option'));
            option.html(data[i]['district']);
            option.val(data[i]['id']);
            district.append(option);
          }
          $('#district_code').val(0);
        }
      });
    },
    MineralBasedIndustriesValidate: function()
    {
  
  
      $("#mineralBasedIndustries").submit(function(event) {
        var industryValue = $("#industry_name").val();
        if (industryValue == "") {
          alert("Please select industry name.");
          event.preventDefault();
        }
      });
    //        $("#mineralBasedIndustries").validate({
    //            onkeyup: false,
    //            onSubmit: true,
    //            rules: {
    //                industry_name: {
    //                    required: true
    //                },
    ////                location: {
    ////                    required: true
    ////                },
    ////                other_industry_name: {
    ////                    required: {
    ////                        depends: function() {
    ////                            if ($('#industry_name').val() == 'Other') {
    ////                                return true;
    ////                            }
    ////                            else {
    ////                                return false;
    ////                            }
    ////
    ////                        }
    ////                    }
    ////                }
    //            },
    //            messages: {
    //                industry_name: {
    //                    required: "Please enter Plant Name"
    //                },
    ////                location: {
    ////                    required: "Please enter Location"
    ////                },
    ////                other_industry_name: {
    ////                    required: "Please specify others"
    ////                }
    //            }
    //        })
    //        $.validator.addMethod("checkOtherEmpty",function(){
    //            //other_industry_name industry_name
    //            
    //            alert($('#industry_name').val());
    //            return false;
    //            
    //        })
    //        
    //        $.validator.addClassRules("other_industry_name",{
    //            checkOtherEmpty:true
    //            
    //        },"")//
    }
  }
  
  var ProductManufactureDetails = {
    fineshedProductAddMore: function(table1, table2, table3, table4, id1, id2, id3, id4, count1) {
  
      var benchTr1 = $(document.createElement('tr'));
      benchTr1.attr('id', id1 + "_tr");
      var benchTd1 = $(document.createElement('td'));
      var benchOreInput1 = $(document.createElement('input'));
      benchOreInput1.attr('id', id1);
      benchOreInput1.attr('name', id1);
      benchOreInput1.css('width', "110px");
      benchOreInput1.addClass("products right");
      benchTd1.append(benchOreInput1);
      benchTr1.append(benchTd1);
      $("#" + table1).append(benchTr1);
  
  
  
      var benchTr2 = $(document.createElement('tr'));
      benchTr2.attr('id', id2 + "_tr");
      var benchTd2 = $(document.createElement('td'));
  
      var benchOreInput2 = $(document.createElement('input'));
  
      benchOreInput2.attr('id', id2)
  
      benchOreInput2.attr('name', id2);
  
      benchOreInput2.css('width', '110px');
  
      benchOreInput2.addClass("products_1 right");
  
      benchTd2.append(benchOreInput2);
  
      benchTr2.append(benchTd2);
  
  
      $("#" + table2).append(benchTr2);
  
  
      var benchTr3 = $(document.createElement('tr'));
      benchTr3.attr('id', id3 + "_tr");
      var benchTd3 = $(document.createElement('td'));
      var benchOreInput3 = $(document.createElement('input'));
      benchOreInput3.attr('id', id3);
      benchOreInput3.attr('name', id3);
      benchOreInput3.css('width', '110px');
      benchOreInput3.addClass("products_1 right");
      benchTd3.append(benchOreInput3);
      benchTr3.append(benchTd3);
      $("#" + table3).append(benchTr3);
  
      var benchTr4 = $(document.createElement('tr'));
      benchTr4.attr('id', id4 + "_tr");
      var benchTd4 = $(document.createElement('td'));
      var benchOreInput4 = $(document.createElement('input'));
      benchOreInput4.attr('id', id4);
      benchOreInput4.attr('name', id4);
      benchOreInput4.css('width', '110px');
      benchOreInput4.addClass("products_1 right");
      benchTd4.append(benchOreInput4);
      benchTr4.append(benchTd4);
  
      if (count1 > 1) {
  
        var removeBtnTd = $(document.createElement('td'));
        removeBtnTd.addClass("h-close-icon");
        removeBtnTd.attr('id', "deleteRow");
        removeBtnTd.bind('click', function() {
  
  
          var tr_id = $(this).closest('tr').attr('id');
          var str_sp = tr_id.split('_');
  
          $("#" + str_sp[0] + "_Product_" + str_sp[2] + "_tr").remove();
          $("#" + str_sp[0] + "_Capacity_" + str_sp[2] + "_tr").remove();
          $("#" + str_sp[0] + "_Previous_" + str_sp[2] + "_tr").remove();
          $("#" + str_sp[0] + "_Present_" + str_sp[2] + "_tr").remove();
  
  
          var indx = parseInt(str_sp[2]) + 1;
  
  
          for (i = indx; i <= $('#' + str_sp[0] + '_Product_Count').val(); i++)
          {
  
            var intval = i - 1;
  
            $('#' + str_sp[0] + "_Product_" + i).attr('name', str_sp[0] + "_Product_" + intval);
            $('#' + str_sp[0] + "_Product_" + i).attr('id', str_sp[0] + "_Product_" + intval);
            $('#' + str_sp[0] + "_Capacity_" + i).attr('name', str_sp[0] + "_Capacity_" + intval);
            $('#' + str_sp[0] + "_Capacity_" + i).attr('id', str_sp[0] + "_Capacity_" + intval);
            $('#' + str_sp[0] + "_Previous_" + i).attr('name', str_sp[0] + "_Previous_" + intval);
            $('#' + str_sp[0] + "_Previous_" + i).attr('id', str_sp[0] + "_Previous_" + intval);
            $('#' + str_sp[0] + "_Present_" + i).attr('name', str_sp[0] + "_Present_" + intval);
            $('#' + str_sp[0] + "_Present_" + i).attr('id', str_sp[0] + "_Present_" + intval);
  
            $('#' + str_sp[0] + "_Product_" + i + "_tr").attr('id', str_sp[0] + "_Product_" + intval + "_tr");
            $('#' + str_sp[0] + "_Capacity_" + i + "_tr").attr('id', str_sp[0] + "_Capacity_" + intval + "_tr");
            $('#' + str_sp[0] + "_Previous_" + i + "_tr").attr('id', str_sp[0] + "_Previous_" + intval + "_tr");
            $('#' + str_sp[0] + "_Present_" + i + "_tr").attr('id', str_sp[0] + "_Present_" + intval + "_tr");
  
  
          }
          $('#' + str_sp[0] + '_Product_Count').val($('#' + str_sp[0] + '_Product_Count').val() - 1)
  
        });
        benchTr4.append(removeBtnTd);
      }
      $('#' + table4).append(benchTr4);
  
  
  
  
    },
    addMore: function() {
  
      var _this = this;
      _this.fineshedProductAddMore('finished_Product_table', 'finished_Capacity_table', 'finished_Previous_table', 'finished_Present_table', 'finished_Product_1', 'finished_Capacity_1', 'finished_Previous_1', 'finished_Present_1', '1');
      $("#finished_Product_Count").val('1');
      _this.fineshedProductAddMore('intermediate_Product_table', 'intermediate_Capacity_table', 'intermediate_Previous_table', 'intermediate_Present_table', 'intermediate_Product_1', 'intermediate_Capacity_1', 'intermediate_Previous_1', 'intermediate_Present_1', '1');
      $("#intermediate_Product_Count").val('1');
      _this.fineshedProductAddMore('byProducts_Product_table', 'byProducts_Capacity_table', 'byProducts_Previous_table', 'byProducts_Present_table', 'byProducts_Product_1', 'byProducts_Capacity_1', 'byProducts_Previous_1', 'byProducts_Present_1', '1');
      $("#byProducts_Product_Count").val('1');
  
      $('#finished_Product_AddMore').click(function() {
        var fineshProduct_Count = $("#finished_Product_Count").val();
        var newfineshProduct_Count = (parseInt(fineshProduct_Count) + 1);
        $("#finished_Product_Count").val(newfineshProduct_Count);
  
        _this.fineshedProductAddMore('finished_Product_table', 'finished_Capacity_table', 'finished_Previous_table', 'finished_Present_table', 'finished_Product_' + newfineshProduct_Count, 'finished_Capacity_' + newfineshProduct_Count, 'finished_Previous_' + newfineshProduct_Count, 'finished_Present_' + newfineshProduct_Count, newfineshProduct_Count);
      });
  
      $('#intermediate_Product_AddMore').click(function() {
        var intermediateProduct_Count = $("#intermediate_Product_Count").val();
        var intermediateProduct_Count = (parseInt(intermediateProduct_Count) + 1);
        $("#intermediate_Product_Count").val(intermediateProduct_Count);
  
        _this.fineshedProductAddMore('intermediate_Product_table', 'intermediate_Capacity_table', 'intermediate_Previous_table', 'intermediate_Present_table', 'intermediate_Product_' + intermediateProduct_Count, 'intermediate_Capacity_' + intermediateProduct_Count, 'intermediate_Previous_' + intermediateProduct_Count, 'intermediate_Present_' + intermediateProduct_Count, intermediateProduct_Count);
      });
  
      $('#byProducts_Product_AddMore').click(function() {
  
        var fineshProduct_Count = $("#byProducts_Product_Count").val();
        var intermediateProduct_Count = (parseInt(fineshProduct_Count) + 1);
        $("#byProducts_Product_Count").val(intermediateProduct_Count);
  
        _this.fineshedProductAddMore('byProducts_Product_table', 'byProducts_Capacity_table', 'byProducts_Previous_table', 'byProducts_Present_table', 'byProducts_Product_' + intermediateProduct_Count, 'byProducts_Capacity_' + intermediateProduct_Count, 'byProducts_Previous_' + intermediateProduct_Count, 'byProducts_Present_' + intermediateProduct_Count, intermediateProduct_Count);
      });
  
    },
    initMBI: function(data_url) {
      ProductManufactureDetails.ProductManufactureDetailsvalidation();
      this.dataUrl = data_url;
      this.getProdManufData();
  
  
    },
    getProdManufData: function() {
  
      $.ajax({
        url: ProductManufactureDetails.dataUrl,
        type: 'GET',
        success: function(resp_data) {
          ProductManufactureDetails.data = json_parse(resp_data);
          if (ProductManufactureDetails.data.returnDetails != "") {
            ProductManufactureDetails.fillProdManufData(resp_data);
          }
        }
      });
  
    },
    fillProdManufData: function(resp_data) {
  
  
      //          var count1=1;
      //          var count2=1;
      //          var count3=1;
  
      $.each(ProductManufactureDetails.data, function(key, item) {
        var _this = this;
  
        if (key == 'prod_type1')
        {
  
          for (var $i = 2; $i <= item; $i++)
          {
            ProductManufactureDetails.fineshedProductAddMore('finished_Product_table', 'finished_Capacity_table', 'finished_Previous_table', 'finished_Present_table', 'finished_Product_' + $i, 'finished_Capacity_' + $i, 'finished_Previous_' + $i, 'finished_Present_' + $i, $i);
  
          }
          $("#finished_Product_Count").val(item);
        }
        if (key == 'prod_type2')
        {
  
          for (var $i = 2; $i <= item; $i++)
          {
            ProductManufactureDetails.fineshedProductAddMore('intermediate_Product_table', 'intermediate_Capacity_table', 'intermediate_Previous_table', 'intermediate_Present_table', 'intermediate_Product_' + $i, 'intermediate_Capacity_' + $i, 'intermediate_Previous_' + $i, 'intermediate_Present_' + $i, $i);
  
          }
          $("#intermediate_Product_Count").val(item);
        }
        if (key == 'prod_type3')
        {
  
          for (var $i = 2; $i <= item; $i++)
          {
            ProductManufactureDetails.fineshedProductAddMore('byProducts_Product_table', 'byProducts_Capacity_table', 'byProducts_Previous_table', 'byProducts_Present_table', 'byProducts_Product_' + $i, 'byProducts_Capacity_' + $i, 'byProducts_Previous_' + $i, 'byProducts_Present_' + $i, $i);
  
          }
          $("#byProducts_Product_Count").val(item);
        }
  
        $('#' + key).val(item);
      });
  
    },
    ProductManufactureDetailsvalidation: function() {
  
  
      $("#productManufactureDetails").validate({
        onkeyup: false
      });
  
      $.validator.addMethod("eMaxlength", $.validator.methods.maxlength,
        $.validator.format("Max. length allowed is {0} characters"));
      $.validator.addMethod("eDigits", $.validator.methods.digits,
        $.validator.format("Decimal digits are not allowed"));
  
      $.validator.addClassRules("products", {
        eMaxlength: 50
  
      });
  
      //        $.validator.addMethod("cRequired", $.validator.methods.required,
      //      "Field is required");
      $.validator.addMethod("cNumber", $.validator.methods.number,
        $.validator.format("Please enter numeric digits only"));
      $.validator.addMethod("cMax", $.validator.methods.max,
        $.validator.format("Max. value allowed is {0}"));
      $.validator.addMethod("cMaxlength", $.validator.methods.maxlength,
        $.validator.format("Max. length allowed is 5,3 digits including decimal"));
      $.validator.addMethod('Decimal', function(value, element) {
        return this.optional(element) || /^\d+(\.\d{0,3})?$/.test(value);
      }, "Please enter only 3 decimal points");
  
      $.validator.addClassRules("products_1", {
        cNumber: true,
        Decimal: true,
        cMax: 999999999999.999,
        cMaxlength: 16
  
  
      });
  
      $.validator.addMethod("expMaxlength", $.validator.methods.maxlength,
        $.validator.format("Max. length allowed is {0} characters"));
  
  
      $.validator.addClassRules("expansion1", {
        expMaxlength: 500
  
  
      });
  
  
    }
  
  
  
  
  }
  
  var SourceOfSupply = {
    init: function(data_url, country_url, mode_url, rawMineral_url, metal_url, district_url, unit_url, mine_code_url) {
      this.countryUrl = country_url;
      this.modeUrl = mode_url;
      this.rawMineralUrl = rawMineral_url;
      this.metalUrl = metal_url;
      this.districtUrl = district_url;
      SourceOfSupply.addMore();
      SourceOfSupply.validateSource();
      this.dataUrl = data_url;
      this.unitUrl = unit_url;
      this.mineCodeUrl = mine_code_url;
  
    },
    getSourceData: function() {
      $.ajax({
        url: SourceOfSupply.dataUrl,
        type: 'GET',
        //      async: false,
        success: function(resp_data) {
          SourceOfSupply.data = json_parse(resp_data);
          if (SourceOfSupply.data.totalCount != 0) {
            SourceOfSupply.fillData();
          }
          //================CHECKING WHETHER TO PUT NIL IN DD OR NOT==================
          SourceOfSupply.nilFill();
  
        }
      });
    },
    fillData: function() {
      _this = this;
      //==========UDAY SHANKAR SINGH===================
      //====SETTING TYPE VALUE TO NIL IF TYPE SELETECTED IS NILL STARTS=======
      if (SourceOfSupply.data.sour_indus_1 == 'NIL')
        $("#checkNilRow").val("1");
      //======SETTING TYPE VALUE TO NIL IF TYPE SELETECTED IS NILL ENDS=======
  
      //===================FILLING VALUE IN THE FORM STARTS===================
      $.each(SourceOfSupply.data, function(key, item) {
        if (key == 'totalCount') {
          for (var i = 2; i <= item; i++) {
            SourceOfSupply.createFields(i);
          }
          $('#source_of_supply_count').val(item)
        }
        $('#' + key).val(item);
      });
  
      //===================MAKING IMPORTED AND INDIGENOUS DISABLE BASED ON THE VALUE  STARTS===================
      var totalRowCount = SourceOfSupply.data.totalCount;
      for (var i = 1; i <= totalRowCount; i++) {
        var typeId = "#sour_indus_" + i;
        var typeValue = $(typeId).val();
        if (typeValue == 'imported') {
          _this.importedChange(i);
        }
        else if (typeValue == 'indigenous') {
          _this.indigenousChange(i);
        }
        $("<span id='unitSpan_sour_mineral_" + i + "'><b>" + SourceOfSupply['data']["mineral_unit_" + i] + "</b></span>").insertAfter($("#sour_mineral_" + i));
  
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
      Utilities.ajaxBlockUI();
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
                          SourceOfSupply.getMineCode();
                          SourceOfSupply.formSaveAction();
  
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
        SourceOfSupply.getMineCode();
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
          SourceOfSupply.nilFill();
  
        });
        benchTr1.append(removeBtnTd);
  
      }
      $('#source_of_supply_table').append(benchTr1);
    },
    nilFill: function() {
      var _this = this;
      var countTotalRows = $(".sourceType").length;
      if (this.dataRawMineral == 'NIL') {
        console.log(this.dataRawMineral)
  
        // console.log(SourceOfSupply.data)
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
            if (SourceOfSupply.data.sour_indus_1 != 'NIL') {
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
  
      $(".sourceType").unbind("change");
      $(".sourceType").change(function() {
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
        //                $(".makeNilDD").val("");
        //                $(".makeNilChar").val("");
        //                $(".makeNilInt").val("");
  
        }
      //================HANDLING NIL TYPE CONDITION ENDS==============
  
  
      });
  
  
      //==============CODE FOR PUTTING THE UNIT OF MESUREMENT OF THE MINERAL======
      $(".putUnit").unbind("change");
      $(".putUnit").change(function() {
        var elementId = $(this).attr("id");
        var elementVal = $(this).val();
        $("#unitSpan_" + elementId).remove();
        //      $("#" + elementId).next().remove();
  
        if (elementVal != "NIL" && elementVal != "") {
          Utilities.ajaxBlockUI();
          $.ajax({
            url: _this.unitUrl,
            type: 'POST',
            data: ({
              value: elementVal
            }),
            success: function(response) {
              var mineralUnit = json_parse(response);
              $("<td><span id='unitSpan_" + elementId + "'><b>" + mineralUnit + "</b></span></td>").insertAfter($("#" + elementId));
            }
          });
        }
      });
    },
    importedChange: function(elementNo) {
      var classToDisable = ".indigenous_" + elementNo;
      var classToEnable = ".imported_" + elementNo;
  
      $(classToDisable).val("");
      $(classToDisable).attr('disabled', true);
      $(classToEnable).removeAttr('disabled');
  
      $(classToDisable).css('background-color', '#D1D0CE');
      $(classToEnable).css('background-color', '');
  
    },
    indigenousChange: function(elementNo) {
      var classToDisable = ".imported_" + elementNo;
      var classToEnable = ".indigenous_" + elementNo;
      $(classToDisable).val("");
      $(classToDisable).attr('disabled', true);
      $(classToEnable).removeAttr('disabled');
  
      $(classToDisable).css('background-color', '#D1D0CE');
      $(classToEnable).css('background-color', '');
  
    },
    getMineCode: function() {
      $(".mineCode").autocomplete({
        source: function(request, response) {
          $.ajax({
            url: SourceOfSupply.mineCodeUrl,
            dataType: "json",
            data: {
              term: request.term,
            },
            success: function(data) {
              response(data);
            }
          });
        },
        minLength: 3
      });
    },
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
  
        var mineralNameArray = SourceOfSupply.dataRawMineral; // this array contains the mineral coming from source of supply
  
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
  
  var RawMaterialConsumed = {
    init: function(data_url, industries_url, metal_url, unit_url) {
      this.industriesUrl = industries_url;
      this.metalUrl = metal_url;
      RawMaterialConsumed.addMore();
      RawMaterialConsumed.validateForm();
      this.dataUrl = data_url;
      this.unitUrl = unit_url;
    },
    getRawMaterialData: function() {
      $.ajax({
        url: RawMaterialConsumed.dataUrl,
        type: 'GET',
        async: false,
        success: function(resp_data) {
          RawMaterialConsumed.data = json_parse(resp_data);
          if (RawMaterialConsumed.data.totalCount != 0) {
            RawMaterialConsumed.fillData();
          }
        }
      });
      //================CHECKING WHETHER TO PUT NIL IN DD OR NOT==================
      RawMaterialConsumed.nilFill();
    },
    fillData: function() {
      if (RawMaterialConsumed.data.raw_mineral_1 == 'NIL')
        $("#checkNilRow").val("1");
  
      $.each(RawMaterialConsumed.data, function(key, item) {
        if (key == 'totalCount') {
          for (var i = 2; i <= item; i++) {
            RawMaterialConsumed.createForm(i);
          }
  
          $('#raw_material_consumed_count').val(item);
        }
        $('#' + key).val(item);
  
      });
  
      for (var rawCount = 1; rawCount <= RawMaterialConsumed.data.totalCount; rawCount++) {
        $("<span id='unitSpan_raw_mineral_" + rawCount + "'><b>" + RawMaterialConsumed['data']["mineral_unit_" + rawCount] + "</b></span>").insertAfter($("#raw_mineral_" + rawCount));
      }
  
  
    },
    validateForm: function() {
      $("#rawMaterialConsumed").validate({
        onkeyup: false,
        onSubmit: true
      });
  
      $.validator.addClassRules("MakeRequired", {
        required: true
      });
  
      $.validator.addMethod("speeMaxlength", $.validator.methods.maxlength,
        $.validator.format("Max. length allowed is {0} characters"));
  
      $.validator.addClassRules("Specification", {
        speeMaxlength: 100
  
      });
  
  
  
      $.validator.addMethod("yNumber", $.validator.methods.number,
        $.validator.format("Please enter numeric digits only"));
      $.validator.addMethod("ycMax", $.validator.methods.max,
        $.validator.format("Max. value allowed is 999999999999999.999"));
      $.validator.addMethod("ycMaxlength", $.validator.methods.maxlength,
        $.validator.format("Max. length allowed is 15,3 digits including decimal"));
      $.validator.addMethod('yDecimal', function(value, element) {
        return this.optional(element) || /^\d+(\.\d{0,3})?$/.test(value);
      }, "Please enter only 3 decimal points");
  
  
      $.validator.addClassRules("year", {
        yNumber: true,
        yDecimal: true,
        ycMax: 999999999999999.999,
        ycMaxlength: 19
  
      });
  
  
    },
    addMore: function() {
      var _this = this;
      Utilities.ajaxBlockUI();
      //        $.ajax({
      //            url: _this.industriesUrl,
      //            type: 'GET',
      //            success: function(resps) {
      //                _this.dataIndustries = json_parse(resps);
      /**
           * ADDED BY UDAY.... 
           * FOR ADDING THE METAL DROP DOWN IN THE FORM... 
           * AS PER THE REQUIREMENT DATED 4TH JUNE 2013
           */
      $.ajax({
        url: _this.metalUrl,
        type: 'GET',
        //                    async: false,
        success: function(response) {
          _this.metalArray = json_parse(response);
          _this.createForm('1');
          $('#raw_material_consumed_count').val('1');
          _this.getRawMaterialData();
        }
      });
      //==========================================================================
      //            }
      //        });
  
      $('#raw_material_consumed_AddMore').unbind("click");
      $('#raw_material_consumed_AddMore').click(function(event) {
        var checkIndustryFirstDDForNil = $("#raw_mineral_1").val();
        if (checkIndustryFirstDDForNil == "NIL") {
          alert("Sorry... You can't add more rows while selecting NIL in Raw Material Drop Box.");
          event.preventDefault();
        }
        else if (checkIndustryFirstDDForNil == "") {
          alert("Kindly Select the Industries first.");
          event.preventDefault();
        }
        else {
  
          $("#raw_mineral_1").find('option[value=NIL]').remove();
  
          var fineshProduct_Count = $("#raw_material_consumed_count").val();
          var newfineshProduct_Count = (parseInt(fineshProduct_Count) + 1);
          $("#raw_material_consumed_count").val(newfineshProduct_Count);
  
          _this.createForm(newfineshProduct_Count);
          _this.nilFill();
        }
  
      });
  
    },
    createForm: function(counter) {
      var benchTr1 = $(document.createElement('tr'));
      benchTr1.attr('id', "raw_material_tr_" + counter);
      /**
           * @author: Uday Shankar Singh
           * THIS CODE IS REMOVED AS NAME OF INDUCTRIES HAS BEEN REMOVED FROM THE SCENE AS SAID BY ME DIVISION DATED: 28th June 2013
           */
      //        var benchTd1 = $(document.createElement('td'));
      //        benchTd1.attr('align', "center");
      //        benchTd1.attr('vAlign', "top");
      //        benchTr1.append(benchTd1);
      //        var benchSelectIndustry = $(document.createElement('select'));
      //        benchSelectIndustry.attr('id', "rawmat_indus_" + counter);
      //        benchSelectIndustry.attr('name', "rawmat_indus_" + counter);
      //        benchSelectIndustry.attr('class', 'MakeRequired fillNil');
      //        benchSelectIndustry.css('width', '80px');
      //        benchTd1.append(benchSelectIndustry);
      //        //benchSelect.className = fieldName1 + "_select" + " selectbox-small";
      //        //==================CREATING THE SELECT BOX OPTIONS=========================
      //        var SelectOptionIndustry = $(document.createElement('option'));
      //        SelectOptionIndustry.html("--Select---");
      //        SelectOptionIndustry.val("");
      //        benchSelectIndustry.append(SelectOptionIndustry);
      //        $.each(this.dataIndustries, function(index, item) {
      //            var options = $(document.createElement('option'));
      //            options.html(item);
      //            options.val(item);
      //            benchSelectIndustry.append(options);
      //        });
  
  
  
      /**
           * @author: UDAY SHANKAR SINGH
           * COMMENTED THIS CODE AS PER THE REQUIREMENT SENT ON 11TH JUN 2013..
           * SO MAY BE REMOVED LATER ONCE THEY APPROVED THIS FUNCTIONALITY
           **/
      //    //==================================raw material===================================   
      //    var benchTd15 = $(document.createElement('td'));
      //    benchTd15.attr('align',"center");
      //    benchTd15.attr('vAlign',"top");
      //    var table1=$(document.createElement('table'));
      //    table1.attr('vAlign','top');
      //    var benchTr2 = $(document.createElement('tr'));
      //    var benchTd21 = $(document.createElement('td'));
      //    var benchOreInput11 = $(document.createElement('input'));
      //    benchOreInput11.attr('id',"rawmat_ser_"+counter);
      //    benchOreInput11.attr('name',"rawmat_ser_"+counter);
      //    benchOreInput11.attr('class','MakeRequired');
      //    benchOreInput11.css('width','80px');
      //    benchOreInput11.addClass("text-fields");
      //    benchTd21.append(benchOreInput11);
      //    benchTr2.append(benchTd21);
  
      var benchTd15 = $(document.createElement('td'));
      benchTd15.attr('align', "center");
      benchTd15.attr('vAlign', "top");
      var table1 = $(document.createElement('table'));
      table1.attr('vAlign', 'top');
      var benchTr2 = $(document.createElement('tr'));
      //===============mineral ore metal select box=================================
      var benchTd22 = $(document.createElement('td'));
      benchTd22.attr('align', "center");
      benchTd22.attr('vAlign', "top");
      benchTr1.append(benchTd22);
      var benchSelectMetal = $(document.createElement('select'));
      benchSelectMetal.attr('id', "raw_mineral_" + counter);
      benchSelectMetal.attr('name', "raw_mineral_" + counter);
      benchSelectMetal.attr('class', 'MakeRequired putUnit fillNil');
      benchSelectMetal.css("width", "80px");
      benchTd22.append(benchSelectMetal);
      //==================CREATING THE SELECT BOX OPTIONS=========================
      var SelectOptionMetal = $(document.createElement('option'));
      SelectOptionMetal.html("--Select---");
      SelectOptionMetal.val("");
      benchSelectMetal.append(SelectOptionMetal);
      $.each(this.metalArray.returnValue, function(index, item) {
        var options = $(document.createElement('option'));
        options.html(item);
        options.val(item);
        benchSelectMetal.append(options);
      });
      benchTr2.append(benchTd22);
  
      var benchTd23 = $(document.createElement('td'));
  
      var benchOreInput13 = $(document.createElement('input'));
      benchOreInput13.attr('id', "rawmat_physpe_" + counter);
      benchOreInput13.attr('value', "Phy Spec");
      benchOreInput13.attr('name', "rawmat_physpe_" + counter);
      benchOreInput13.attr('class', 'MakeRequired makeNilChar');
      benchOreInput13.css('width', '80px');
      benchOreInput13.addClass("text-fields Specification");
      benchTd23.append(benchOreInput13);
      benchTr2.append(benchTd23);
  
  
  
      var benchTd24 = $(document.createElement('td'));
  
      var benchOreInput14 = $(document.createElement('input'));
      benchOreInput14.attr('id', "rawmat_chespe_" + counter);
      benchOreInput14.attr('name', "rawmat_chespe_" + counter);
      benchOreInput14.attr('class', 'MakeRequired makeNilChar');
      benchOreInput14.attr('value', "Chem Spec");
      benchOreInput14.css('width', '80px');
      benchOreInput14.addClass("text-fields Specification");
      benchTd24.append(benchOreInput14);
      benchTr2.append(benchTd24);
      table1.append(benchTr2);
      benchTd15.append(table1);
      benchTr1.append(benchTd15);
  
      $('#raw_Material_Consumed_table').append(benchTr1);
  
      //=======================Previous financial Indigenous==================== 
      var benchTd1 = $(document.createElement('td'));
      benchTd1.attr('align', "center");
      benchTd1.attr('vAlign', "top");
      var benchOreInput1 = $(document.createElement('input'));
      benchOreInput1.attr('id', "rawmat_prv_ind_" + counter);
      benchOreInput1.attr('name', "rawmat_prv_ind_" + counter);
      benchOreInput1.attr('class', 'MakeRequired makeNil right');
      benchOreInput1.css('width', '80px');
      benchOreInput1.addClass("text-fields year");
      benchTd1.append(benchOreInput1);
      benchTr1.append(benchTd1);
  
      //=======================Previous financial Imported==================== 
      var benchTd1 = $(document.createElement('td'));
      benchTd1.attr('align', "center");
      benchTd1.attr('vAlign', "top");
      var benchOreInput1 = $(document.createElement('input'));
      benchOreInput1.attr('id', "rawmat_prv_imp_" + counter);
      benchOreInput1.attr('name', "rawmat_prv_imp_" + counter);
      benchOreInput1.attr('class', 'MakeRequired makeNil right');
      benchOreInput1.css('width', '80px');
      benchOreInput1.addClass("text-fields year");
      benchTd1.append(benchOreInput1);
      benchTr1.append(benchTd1);
  
      //=======================Present financial Indigenous==================== 
      var benchTd1 = $(document.createElement('td'));
      benchTd1.attr('align', "center");
      benchTd1.attr('vAlign', "top");
      var benchOreInput1 = $(document.createElement('input'));
      benchOreInput1.attr('id', "rawmat_pre_ind_" + counter);
      benchOreInput1.attr('name', "rawmat_pre_ind_" + counter);
      benchOreInput1.attr('class', 'MakeRequired makeNil right');
      benchOreInput1.css('width', '80px');
      benchOreInput1.addClass("text-fields year");
      benchTd1.append(benchOreInput1);
      benchTr1.append(benchTd1);
  
  
      //=======================Present financial Imported==================== 
      var benchTd1 = $(document.createElement('td'));
      benchTd1.attr('align', "center");
      benchTd1.attr('vAlign', "top");
      var benchOreInput1 = $(document.createElement('input'));
      benchOreInput1.attr('id', "rawmat_pre_imp_" + counter);
      benchOreInput1.attr('name', "rawmat_pre_imp_" + counter);
      benchOreInput1.attr('class', 'MakeRequired makeNil right');
      benchOreInput1.css('width', "80px");
      benchOreInput1.addClass("text-fields year");
      benchTd1.append(benchOreInput1);
      benchTr1.append(benchTd1);
  
      //=======================Next financial year==================== 
      var benchTd1 = $(document.createElement('td'));
      benchTd1.attr('align', "center");
      benchTd1.attr('vAlign', "top");
      var benchOreInput1 = $(document.createElement('input'));
      benchOreInput1.attr('id', "rawmat_nex_fin_yr_" + counter);
      benchOreInput1.attr('name', "rawmat_nex_fin_yr_" + counter);
      benchOreInput1.attr('class', 'MakeRequired makeNil right');
      benchOreInput1.css('width', "80px");
      benchOreInput1.addClass("text-fields year");
      benchTd1.append(benchOreInput1);
      benchTr1.append(benchTd1);
  
  
      //=======================Next to Next financial year==================== 
      var benchTd1 = $(document.createElement('td'));
      benchTd1.attr('align', "center");
      benchTd1.attr('vAlign', "top");
      var benchOreInput1 = $(document.createElement('input'));
      benchOreInput1.attr('id', "rawmat_nextonex_fin_yr_" + counter);
      benchOreInput1.attr('name', "rawmat_nextonex_fin_yr_" + counter);
      benchOreInput1.attr('class', 'MakeRequired makeNil right');
      benchOreInput1.css("width", "80px");
      benchOreInput1.addClass("text-fields year");
      benchTd1.append(benchOreInput1);
      benchTr1.append(benchTd1);
  
      //     raw_material_tr_ rawmat_ser_ rawmat_physpe_  rawmat_chespe_ rawmat_prv_ind_   rawmat_prv_imp_  rawmat_pre_ind_ 
      //        rawmat_pre_imp_ rawmat_nex_fin_yr_ rawmat_nextonex_fin_yr_    
  
  
      if (counter > 1) {
  
        var removeBtnTd = $(document.createElement('td'));
        removeBtnTd.addClass("h-close-icon");
        removeBtnTd.attr('id', "deleteRow");
        removeBtnTd.bind('click', function() {
  
          var tr_id = $(this).closest('tr').attr('id');
          var str_sp = tr_id.split('_');
  
          $('#' + tr_id).remove();
          var indx = parseInt(str_sp[3]) + 1;
  
  
          for (i = indx; i <= $('#raw_material_consumed_count').val(); i++)
          {
  
            var intval = i - 1;
  
            $('#raw_material_tr_' + i).attr('id', 'source_supply_tr_' + intval);
  
            //                    $('#rawmat_indus_' + i).attr('name', 'rawmat_indus_' + intval);
            $('#rawmat_ser_' + i).attr('name', 'rawmat_ser_' + intval);
            $('#rawmat_physpe_' + i).attr('name', 'rawmat_physpe_' + intval);
            $('#rawmat_chespe_' + i).attr('name', 'rawmat_chespe_' + intval);
            $('#rawmat_prv_ind_' + i).attr('name', 'rawmat_prv_ind_' + intval);
            $('#rawmat_prv_imp_' + i).attr('name', 'rawmat_prv_imp_' + intval);
            $('#rawmat_pre_ind_' + i).attr('name', 'rawmat_pre_ind_' + intval);
            $('#rawmat_pre_imp_' + i).attr('name', 'rawmat_pre_imp_' + intval);
            $('#rawmat_nex_fin_yr_' + i).attr('name', 'rawmat_nex_fin_yr_' + intval);
            $('#rawmat_nextonex_fin_yr_' + i).attr('name', 'rawmat_nextonex_fin_yr_' + intval);
  
  
            //                    $('#rawmat_indus_' + i).attr('id', 'rawmat_indus_' + intval);
            $('#rawmat_ser_' + i).attr('id', 'rawmat_ser_' + intval);
            $('#rawmat_physpe_' + i).attr('id', 'rawmat_physpe_' + intval);
            $('#rawmat_chespe_' + i).attr('id', 'rawmat_chespe_' + intval);
            $('#rawmat_prv_ind_' + i).attr('id', 'rawmat_prv_ind_' + intval);
            $('#rawmat_prv_imp_' + i).attr('id', 'rawmat_prv_imp_' + intval);
            $('#rawmat_pre_ind_' + i).attr('id', 'rawmat_pre_ind_' + intval);
  
            $('#rawmat_pre_imp_' + i).attr('id', 'rawmat_pre_imp_' + intval);
            $('#rawmat_nex_fin_yr_' + i).attr('id', 'rawmat_nex_fin_yr_' + intval);
            $('#rawmat_nextonex_fin_yr_' + i).attr('id', 'rawmat_nextonex_fin_yr_' + intval);
  
          }
  
          $('#raw_material_consumed_count').val($('#raw_material_consumed_count').val() - 1)
  
          //=========ADD NIL TO FIRST ELEMENT IF THE NUMBER OF ROWS ID ONE========
          RawMaterialConsumed.nilFill();
  
        });
        benchTr1.append(removeBtnTd);
  
      }
      $('#raw_Material_Consumed_table').append(benchTr1);
    },
    /**
       * 
       * @returns {undefined}
       */
    nilFill: function() {
  
      var _this = this;
      var countTotalRows = $(".fillNil").length;
  
      //===========APPENDING NIL IF COUNT OF MINERAL ROWS IS 1 STARTS=========
      if (countTotalRows == 1) {
        var DDNilOption = $(document.createElement('option'));
        DDNilOption.html("NIL").val("NIL");
        $("#raw_mineral_1").append(DDNilOption); // ADDING ONLY FOR FIRST ONE...
  
        if ($("#checkNilRow").val() == 1) {
          $("#raw_mineral_1").val("NIL");
  
        }
      }
      //===========APPENDING NIL IF COUNT OF MINERAL ROWS IS 1 ENDS===========
  
      //==========CODE FOR PUTTING THE UNIT OF MESUREMENT OF THE MINERAL======
      $(".putUnit").unbind("change");
      $(".putUnit").change(function() {
        var elementId = $(this).attr("id");
  
        //==============HANDLING NIL CONDITION STARTS HERE==================
        if (elementId == 'raw_mineral_1') {
          var selectedElement = $(this).val();
          if (selectedElement == "NIL") {
            var confirmAction = window.confirm("Selecting NIL in the 'Raw Material' Drop box will automatically fill 0 and NA in corespoding fields. Are you still want to continue ? ");
            if (confirmAction == true) {
              $(".makeNilChar").val("NA");
              $(".makeNil").val(0);
            }
            else {
              $(this).val("");
            }
          }
          else {
            $(".makeNilChar").val("");
            $(".makeNil").val("");
          }
        }
        //==============HANDLING NIL CONDITION ENDS HERE====================
        //==============APPENDING UNIT TO THE MINERAL STARTS================
        var elementVal = $(this).val();
        $("#unitSpan_" + elementId).remove();
  
        if (elementVal != "NIL" && elementVal != "") {
          Utilities.ajaxBlockUI();
          $.ajax({
            url: _this.unitUrl,
            type: 'POST',
            data: ({
              value: elementVal
            }),
            success: function(response) {
              var mineralUnit = json_parse(response);
              $("<span id='unitSpan_" + elementId + "'><b>" + mineralUnit.unit + "</b></span>").insertAfter($("#" + elementId).parent());
            }
          });
        }
      //==============APPENDING UNIT TO THE MINERAL ENDS==================
      });
    }
  }
  
  
  var OIronSteelIndustry = {
    init: function(data_url) {
  
      this.dataUrl = data_url;
      this.getIndustryData();
      OIronSteelIndustry.validateForm();
    },
    getIndustryData: function() {
      Utilities.ajaxBlockUI();
      $.ajax({
        url: OIronSteelIndustry.dataUrl,
        type: 'GET',
        success: function(resp_data) {
  
          OIronSteelIndustry.data = json_parse(resp_data);
          if (OIronSteelIndustry.data.returnDetails != "") {
            OIronSteelIndustry.fillData();
          }
        }
      });
    },
    fillData: function() {
      $.each(OIronSteelIndustry.data, function(key, item) {
        $('#' + key).val(item);
      });
    },
    validateForm: function() {
  
      $("#ironIndustryForm").validate({
        //  onkeyup:false,
        onsubmit: true
      });
  
      $.validator.addMethod("aMax", $.validator.methods.max,
        $.validator.format("Max. value allowed can be 999999999999999.999"));
      $.validator.addMethod('aNumber', $.validator.methods.number,
        $.validator.format("Please enter numeric digits only"));
      $.validator.addMethod("decimalCheck", function(value, element) {
        return this.optional(element) || (/^[0-9,]+(\.\d{0,3})?$/).test(value);
      }, "Please enter number only to 3 decimal places");
  
  
  
      $.validator.addClassRules("prodCapacity", {
        aNumber: true,
        aMax: 999999999999999.999,
        decimalCheck: true
      });
  
      $.validator.addMethod("a1Max", $.validator.methods.max,
        $.validator.format("Max. value allowed can be 999999999999999.999"));
      $.validator.addMethod('a1Number', $.validator.methods.number,
        $.validator.format("Please enter numeric digits only"));
      $.validator.addMethod("decimalCheck1", function(value, element) {
        return this.optional(element) || (/^[0-9,]+(\.\d{0,3})?$/).test(value);
      }, "Please enter number only to 3 decimal places");
  
  
  
      $.validator.addClassRules("prevYear", {
        a1Number: true,
        a1Max: 999999999999999.999,
        decimalCheck1: true
      });
  
      $.validator.addMethod("a2Max", $.validator.methods.max,
        $.validator.format("Max. value allowed can be 999999999999999.999"));
      $.validator.addMethod('a2Number', $.validator.methods.number,
        $.validator.format("Please enter numeric digits only"));
      $.validator.addMethod("decimalCheck2", function(value, element) {
        return this.optional(element) || (/^[0-9,]+(\.\d{0,3})?$/).test(value);
      }, "Please enter number only to 3 decimal places");
  
  
  
      $.validator.addClassRules("presYear", {
        a2Number: true,
        a2Max: 999999999999999.999,
        decimalCheck2: true
      });
  
  
  
      $.validator.addMethod("aMaxlength3", $.validator.methods.maxlength,
        $.validator.format("Max. length allowed is {0} characters"));
  
      $.validator.addClassRules("prodRemark", {
        aMaxlength3: 100
      });
      $.validator.addMethod("aMaxlength4", $.validator.methods.maxlength,
        $.validator.format("Max. length allowed is {0} characters"));
  
      $.validator.addClassRules("prodProg", {
        aMaxlength4: 500
      });
      $.validator.addMethod("aMaxlength5", $.validator.methods.maxlength,
        $.validator.format("Max. length allowed is {0} characters"));
  
      $.validator.addClassRules("prodName", {
        aMaxlength5: 50
      });
    }
  }
  
  var oFinalValidation = {
    oFinalSubmit: function(oSubmitActionUrl, successRedirectUrl, event) {
      var _this = this;
      $.ajax({
        url: oSubmitActionUrl,
        data: ({
          value: 'optionalItemCheck'
        }),
        type: 'POST',
        async: false,
        success: function(response) {
          var result = json_parse(response)
          
           /* update response object condition to resolve the csrf token issue of final submit, Done by Pravin Bhakare 22-03-2021 */
          if (result.formInvalid == true) { 
            _this.checkFalse = 1;
          }
        }
      });
      if(_this.checkFalse == 1){
        var proceedConfirm1 = window.confirm("Either 'End-Use mineral based activity-II' or 'Iron and Steel industry' or both must be filled. Currently both of them are empty. Without filling either one of them or both you can't proceed.")
        if (proceedConfirm1 == true || proceedConfirm1 == false) {
          return false;
        }
      }
      $.ajax({
        url: oSubmitActionUrl,
        data: ({
          value: 'checkRawVsSource'
        }),
        type: 'POST',
        async: false,
        success: function(resp) {
            
          var result1 = json_parse(resp);
          
          /* update response object condition to resolve the csrf token issue of final submit, Done by Pravin Bhakare 22-03-2021 */
          if (result1.formInvalid == true) {
            //          var proceedConfirm = window.confirm("Number of Minerals Selected in 'Raw Metarial Consumed in Production' should be selected in 'Source of Supply', Which is currently not . Are you still want to continue ?")
            var proceedConfirm = window.confirm("Either one of form 'Raw Metarial Consumed in Production' OR 'Source of Supply' not filled. Kindly fill both of them or none of them then proceed.");
              if (proceedConfirm == true || proceedConfirm == false) {
                return false;
            //            oFinalValidation.finalSubmit(oSubmitActionUrl, successRedirectUrl)
            }
          }
          else {
            oFinalValidation.finalSubmit(oSubmitActionUrl, successRedirectUrl)
          }
        }
      }); 
  
  
    },
    finalSubmit: function(oSubmitActionUrl, successRedirectUrl) {
      $.ajax({
        url: oSubmitActionUrl,
        async: false,
        success: function(finalSubmitActionResponse) {
          //=========CHECKING FOR NO ERROR FOUND, AND REDIRECTING THE PAGE========
                  if (finalSubmitActionResponse == "" || finalSubmitActionResponse == null) {
                      window.location = successRedirectUrl;
                      return;
                  }
  
          //====IF MULTIPLE ERROR, THEN SPLIT THE ERRORS AND THEN DISPLAY THEM====
          /* update response object condition to resolve the csrf token issue of final submit, Done by Pravin Bhakare 22-03-2021 */
          var finalActionResponse = json_parse(finalSubmitActionResponse);
          finalSubmitActionResponse = finalActionResponse.error;
          var data = finalSubmitActionResponse[0].split('|');
  
          //===========THIS TABLE IS ALREADY CREATED IN THE SUCCESS FILE==========
          var table = document.getElementById('final-submit-error');
          $(table).empty();
  
          var empty_tr1 = document.createElement('tr');
          empty_tr1.innerHTML = "&nbsp;";
          table.appendChild(empty_tr1);
          var empty_tr2 = document.createElement('tr');
          empty_tr2.innerHTML = "&nbsp;";
          table.appendChild(empty_tr2);
  
          for (var i = 0; i < data.length; i++) {
            var tr = document.createElement('tr');
            table.appendChild(tr);
  
            var td = document.createElement('td');
            td.align = "center";
            $(td).css('text-align', 'left');
            $(td).css('color', '#f00');
            td.innerHTML = data[i];
            tr.appendChild(td);
          }
        }
      });
    }
  
  }