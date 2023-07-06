
var RawMaterialConsumedNew = {
    init: function(data_url, industries_url, metal_url, unit_url) {
      this.industriesUrl = industries_url;
      this.metalUrl = metal_url;
      RawMaterialConsumedNew.addMore();
      RawMaterialConsumedNew.validateForm();
      this.dataUrl = data_url;
      this.unitUrl = unit_url;
    },
    getRawMaterialData: function() {
      $.ajax({
        url: RawMaterialConsumedNew.dataUrl,
        type: 'GET',
        async: false,
        success: function(resp_data) {
          RawMaterialConsumedNew.data = json_parse(resp_data);
          if (RawMaterialConsumedNew.data.totalCount != 0) {
            RawMaterialConsumedNew.fillData();
          }
        }
      });
      //================CHECKING WHETHER TO PUT NIL IN DD OR NOT==================
      RawMaterialConsumedNew.nilFill();
    },
    fillData: function() {
      if (RawMaterialConsumedNew.data.raw_mineral_1 == 'NIL')
        $("#checkNilRow").val("1");
  
      $.each(RawMaterialConsumedNew.data, function(key, item) {
        if (key == 'totalCount') {
          for (var i = 2; i <= item; i++) {
            RawMaterialConsumedNew.createForm(i);
          }
  
          $('#raw_material_consumed_count').val(item);
        }
        $('#' + key).val(item);
  
      });
  
      for (var rawCount = 1; rawCount <= RawMaterialConsumedNew.data.totalCount; rawCount++) {
        $("<span id='unitSpan_raw_mineral_" + rawCount + "'><b>" + RawMaterialConsumedNew['data']["mineral_unit_" + rawCount] + "</b></span>").insertAfter($("#raw_mineral_" + rawCount));
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
    addMoreRule: function() {
        
        $('#rawMaterialConsumed').on('click', '#add_more', function(event) {

            var firstDD = $("#rawMaterialConsumed #table_1 .table_body tr").eq(0).find('.putUnit');
            var checkIndustryFirstDDForNil = $("#rawMaterialConsumed #table_1 .table_body tr").eq(0).find('.putUnit').val();
            if (checkIndustryFirstDDForNil == "NIL") {
                alert("Sorry... You can't add more rows while selecting NIL in Raw Material Drop Box.");
                event.preventDefault();
            }
            else if (checkIndustryFirstDDForNil == "") {
                alert("Kindly Select the Industries first.");
                event.preventDefault();
            }
            else {
    
                firstDD.find('option[value="NIL"]').remove();
        
                // var fineshProduct_Count = $("#raw_material_consumed_count").val();
                // var newfineshProduct_Count = (parseInt(fineshProduct_Count) + 1);
                // $("#raw_material_consumed_count").val(newfineshProduct_Count);
        
                // _this.createForm(newfineshProduct_Count);
                // _this.nilFill();

            }

            RawMaterialConsumedNew.maintainNill();
    
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
          RawMaterialConsumedNew.nilFill();
  
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
        var countTotalRows = $("#rawMaterialConsumed .fillNil").length;
  
        //===========APPENDING NIL IF COUNT OF MINERAL ROWS IS 1 STARTS=========
        if (countTotalRows == 1) {
            var DDNilOption = $(document.createElement('option'));
            DDNilOption.html("NIL").val("NIL");
            // $("#raw_mineral_1").append(DDNilOption); // ADDING ONLY FOR FIRST ONE...
            $("#rawMaterialConsumed #table_1 .table_body tr").eq(0).find('.putUnit').append(DDNilOption); // ADDING ONLY FOR FIRST ONE...
    
            if ($("#checkNilRow").val() == 1) {
                // $("#raw_mineral_1").val("NIL");
                $("#rawMaterialConsumed #table_1 .table_body tr").eq(0).find('.putUnit').val("NIL");
            }
        }
        //===========APPENDING NIL IF COUNT OF MINERAL ROWS IS 1 ENDS===========
  
        //==========CODE FOR PUTTING THE UNIT OF MESUREMENT OF THE MINERAL======
        // $("#rawMaterialConsumed .putUnit").unbind("change");
        $("#rawMaterialConsumed").on('change', '.putUnit',function() {
            // var elementId = $(this).attr("id");

            var trEl = $(this).closest('tr').attr('id');
    
            //==============HANDLING NIL CONDITION STARTS HERE==================
            // if (elementId == 'raw_mineral_1') {
                var selectedElement = $(this).val();
                if (selectedElement == "NIL") {
                    var confirmAction = window.confirm("Selecting NIL in the 'Raw Material' Drop box will automatically fill 0 and NA in corespoding fields. Are you still want to continue ? ");
                    if (confirmAction == true) {
                        $(".makeNilChar").val("NA");
                        $(".makeNil").val(0);
                        $("#add_more").hide();
                    }
                    else {
                        $(this).val("");
                        $("#add_more").show();
                    }
                }
                else {
                    $("#"+trEl+" .makeNilChar").val("");
                    $("#"+trEl+" .makeNil").val("");
                    $("#add_more").show();
                }
            // }
            //==============HANDLING NIL CONDITION ENDS HERE====================
            //==============APPENDING UNIT TO THE MINERAL STARTS================
            var elementVal = $(this).val();
            $("#rawMaterialConsumed #unitSpan_" + trEl).remove();
            getRawMatMetUnitUrl = $('#get_raw_meterial_metals_unit').val();
    
            if (elementVal != "NIL" && elementVal != "") {
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
                        $("#rawMaterialConsumed #unitSpan_" + trEl).remove();
                        $("<span id='unitSpan_" + trEl + "'><b>" + response + "</b></span>").insertAfter($("#" + trEl + " .putUnit"));
                    }
                });
            }
        //==============APPENDING UNIT TO THE MINERAL ENDS==================
        });
    },
    maintainNill: function() {

        $(this).delay(1000).queue(function() {
            var metalLen = $('#rawMaterialConsumed .table_body .putUnit').length;
            if (metalLen > 1) {
                if($('#rawMaterialConsumed').find(".putUnit option[value='NIL']").length != 0){
                    $('#rawMaterialConsumed').find(".putUnit option[value='NIL']").remove();
                }
            } else {
                if($('#rawMaterialConsumed .table_body tr').eq(0).find(".putUnit option[value='NIL']").length == 0){
                    $('#rawMaterialConsumed .table_body tr').eq(0).find(".putUnit").append($('<option></option>').attr('value','NIL').text('NIL'));
                }
            }

            $(this).dequeue();
        });

    },
    firstLoad: function() {

        $(this).delay(1000).queue(function() {
            var minWithUnit = $('#minWithUnit').val();
            minWithUnit = $.parseJSON(minWithUnit);
            var metalLen = $('#rawMaterialConsumed .table_body .putUnit').length;
            for (var n=0; n < metalLen; n++) {
                var metal = $('#rawMaterialConsumed .table_body tr').eq(n).find('.putUnit').val();
                
                if (metal == 'NIL') {
                    $('#add_more').hide();
                }

                $.each(minWithUnit, function(ind, elem) {
                    if (ind == metal) {
                        var trEl = $('#rawMaterialConsumed .table_body tr').eq(n).attr('id');
                        var unitEl = '<span id="unitSpan_'+trEl+'">'+elem+'</span>';
                        $(unitEl).insertAfter($('#rawMaterialConsumed .table_body tr').eq(n).find('.putUnit'));
                    }
                });
            }
            
            $(this).dequeue();
        });

    }
}


$(document).ready(function() {

    RawMaterialConsumedNew.addMoreRule();
    RawMaterialConsumedNew.validateForm();
    RawMaterialConsumedNew.nilFill();
    RawMaterialConsumedNew.maintainNill();
    RawMaterialConsumedNew.firstLoad();

    $('#rawMaterialConsumed').on('click', '.remove_btn_btn', function() {
        RawMaterialConsumedNew.maintainNill();
    });

});
