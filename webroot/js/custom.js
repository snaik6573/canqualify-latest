jQuery(document).ready(function() {
    /* search arrow icon change */
    /* search arrow icon change */
    jQuery(".collapse.show").each(function() {
        jQuery(this)
            .prev(".card-header")
            .find(".fa")
            .addClass("fa-angle-down")
            .removeClass("fa-angle-right");
    });
    jQuery(".collapse")
        .on("show.bs.collapse", function() {
            jQuery(this)
                .prev(".card-header")
                .find(".fa")
                .removeClass("fa-angle-right")
                .addClass("fa-angle-down");
        })
        .on("hide.bs.collapse", function() {
            jQuery(this)
                .prev(".card-header")
                .find(".fa")
                .removeClass("fa-angle-down")
                .addClass("fa-angle-right");
        });

    /* Categories Year Based */
    var parent_cat = jQuery(".parent-cat option:selected").text();
    if (parent_cat.length != '') {
        checkParentCat(parent_cat);
    }
    jQuery('.parent-cat').on('change', function() {
        var parent_cat = jQuery(".parent-cat option:selected").text();
        checkParentCat(parent_cat);
    });

    function checkParentCat(parent_cat) {
        if (parent_cat == 'SafetyQUAL') {
            jQuery(".from-to").show();
        } else {
            jQuery(".from-to").hide();
            jQuery(".from-year,.to-year ").val('');
        }
    }

    /* Contractor Feedback */
    /* jQuery('.star').click(function () {
         var rating_value = jQuery(this).data('value');
            if(rating_value > 3){
                  jQuery(".questionDiv").show();
                  jQuery(".thanksMsgDiv").hide();
            }else{
              jQuery(".questionDiv").hide();
               jQuery(".thanksMsgDiv").show();
            }

     });*/
    jQuery('.parantQue input[type=radio]').change(function() {
        var currentObj = jQuery(this);
        var dataValue = currentObj.val();
        if (dataValue == "Yes") {
            jQuery(".depQue").show();
            //}else if(dataValue == "Other"){
            // jQuery('.answer_others').show();
        } else {
            jQuery(".depQue").hide();
            //jQuery('.answer_others').hide();
        }
    });

    if (jQuery(".has_email").is(":checked")) {
        jQuery(".use-email").val('');
        jQuery(".login-cls").hide();
    } else {
        jQuery(".login-cls").show();
    }
    jQuery('.has_email').change(function() {
        if (jQuery(this).is(":checked")) {
            jQuery(".use-email").val('');
            jQuery(".login-cls").hide();
        } else {
            jQuery(".login-cls").show();
        }
    });
    //jQuery(".feedback_ans").change(function() {
    jQuery(".feedback_ans").each(function() { //alert(jQuery(this).val());
        if (jQuery(this).val() == 'Other') {
            jQuery(this).parents().next('.answer_others').show();
        } else {
            jQuery(this).parents().siblings('.answer_others').hide();
        }
    });
    /* End Contractor Feedback */

    /* Onload Selected Answers shows warning */
    jQuery('.ques-ans').each(function() {
        jQuery(this).find('.checkbox input:checked, .radio input:checked').each(function() {
            var chkID = jQuery(this).parents('.checkbox,.radio').attr('data-index');
            var alertbox = jQuery(this).parents('.ques-ans').find('.data-attribute-section');
            if (jQuery(this).is(':checked')) {
                var chked = jQuery(this).parents('.ques-ans').find('.data-attribute-section li');
                if (chked.eq(chkID).text()) {
                    chked.eq(chkID).css('display', 'block');
                    alertbox.addClass('alert alert-warning');
                }
            } else {
                if (chked.eq(chkID).text()) {
                    chked.eq(chkID).css('display', 'none');
                    alertbox.removeClass('alert alert-warning');
                }
            }
        });

    });

    /* clear textbox value After submitting data */
    jQuery(".emp-exp").val("");
    jQuery(".docName").val("");
    jQuery(".setDate").datepicker({ dateFormat: 'yy/mm/dd' });

    /*  display help popOver */
    jQuery('[data-toggle="popover"]').popover({
        html: true
    });

    /*  redirect to another div in same page on button click */
    jQuery(".addButton").on('click', function(e) {
        e.preventDefault();
        jQuery("#user-username").focus();
    });
    /*jQuery(".addButton").on('click',function(){
    		var url = window.location.href;
    		window.location = url+"#addNew";});*/
    /*if(jQuery('#user-username').val()) {jQuery('#user-username').focus();}*/

    if (jQuery('.category-link').length > 0) {
        var url = window.location.href;
        var parts = url.split("/");
        var first_part = parts[parts.length - 4];
        var last_part = parts[parts.length - 1];
        jQuery('#main-menu').find('li.' + first_part + '-' + last_part).addClass('show');
        jQuery('#main-menu').find('li.' + first_part + '-' + last_part).children('ul.sub-menu').addClass('show');
    }

    jQuery(document).on("change", "input[type=file]", function(e) {
        e.preventDefault();
        var selector = jQuery(this);
        var skill_assess = jQuery(this).attr('data-assessment');

        if (!selector.parent().hasClass("uploadWraper")) {
            console.log('webroot file upload');
            return false;
        }
        console.log('s3 file upload');
        jQuery('#overlay').show();
        jQuery("#overlay").addClass("loading-vd");
        var files = e.target.files[0];
        var data = new FormData();
        data.append('files', files);
        if (selector.parents(".uploadWraper").find('.filenmHandle').length) {
            var filenmHandle = selector.parents(".uploadWraper").find('.filenmHandle').val();
            data.append('filenmHandle', filenmHandle);
        }
        if (selector.prev('.documentName').attr('name') == 'profile_photo' || selector.prev('.documentName').attr('name') == 'user[profile_photo]') {
            data.append('profile_photo', 1);
        }
        if (selector.prev('.documentName').attr('data-assess') == 'skillAssessments' || selector.prev('.documentName').attr('data-assess') == 'skillAssessments') {
            data.append('skillAssessments', 1);
        }

        jQuery.ajax({
            headers: { 'X-CSRF-TOKEN': csrfToken },
            type: "POST",
            url: '/uploads/uploadFile',
            data: data,
            async: true,
            cache: false,
            contentType: false,
            processData: false,
            success: function(data) {
                selector.prev('.documentName').val(jQuery(data).filter('.uploadUrl').attr('data-file'));
                selector.hide();
                selector.next(".uploadResponse").html(data);
                jQuery('#overlay').hide();
                jQuery("#overlay").addClass("loading-vd");
            }
        });
        return false;
    });

    jQuery(document).on("click", ".ajaxfileDelete", function(e) {
        e.preventDefault();
        var selector = jQuery(this);
        jQuery.ajax({
            headers: { 'X-CSRF-TOKEN': csrfToken },
            type: "POST",
            cache: false,
            url: selector.attr("href"),
            success: function(data) {
                selector.parents(".uploadWraper").find("input[type=file]").val("").show();
                selector.parents(".uploadWraper").find('.documentName').val("");
                selector.parents(".uploadResponse").html("");
            },
            error: function(error) {
                //alert('error; ' + JSON.stringify(error));
            }
        });
        return false;
    });

    jQuery(document).on("click", ".ajaxfileChange", function(e) {
        e.preventDefault();
        var selector = jQuery(this);

        selector.parents(".uploadWraper").find("input[type=file]").val("").show().click();
        selector.parents(".uploadWraper").find('.documentName').val("");
        //selector.parents(".uploadResponse").html("");

        return false;
    });


    jQuery(document).on("submit", ".saveAjax", function(e) {
        e.preventDefault();
        var $form = jQuery(this);
        var formData = new FormData(jQuery(this)[0]);
        jQuery.ajax({
            headers: { 'X-CSRF-TOKEN': csrfToken },
            type: "POST",
            url: $form.attr("action"),
            data: formData, //$form.serialize(),
            async: true,
            cache: false,
            contentType: false,
            processData: false,
            success: function(data) {
                if ($form.attr('data-responce') !== undefined) {
                    jQuery($form.attr('data-responce')).html(data);
                    if (typeof $form.attr('data-sendrequest') !== 'undefined' && RequestBtn != '') {
                        RequestBtn.hide();
                        RequestBtn.parent().html('<span class="">Request Sent</span>');
                    }

                    if (jQuery(data).find('.error-message').length == 0 && $form.hasClass('reloadpage')) {
                        setTimeout(function() { location.reload(); }, 3000);
                    }

                    /*if($form.attr('data-responce') == '.invoice-responce' ) {
					//alert(emploeeQualSelected);
					if(emploeeQualSelected) {
						jQuery('.EmployeeSlot').show();
					}else{
						jQuery('.EmployeeSlot').hide();
					}
			 	}*/
                } else {
                    jQuery("body").html(data);
                }

            }
        });
        return false;
    });

    jQuery(document).on("click", ".ajaxClick", function() {
        var selector = jQuery(this);
        selector.parents('form').submit();
    });

    jQuery(document).on("change", ".ajaxChangeOrder", function() {
        var selector = jQuery(this);
        selector.parents('form').submit();
    });

    jQuery(document).on("change", ".ajaxChange", function(e) {
        e.preventDefault();
        var selector = jQuery(this);
        var url = selector.data('url') + '/' + selector.val();
        jQuery.ajax({
            headers: { 'X-CSRF-TOKEN': csrfToken },
            type: "GET",
            url: url,
            contentType: false,
            success: function(data) {
                if (selector.data('responce') !== undefined) {
                    jQuery(selector.data('responce')).html(data);
                }
            }
        });
    });

    // client question add / manage

    jQuery('.child-question input[type=checkbox]').click(function() {
        var currentObj = jQuery(this);
        if (currentObj.is(":checked")) {
            checkParentQuestion(currentObj); //alert(currentObj);
        }
    });

    function checkParentQuestion(currentObj) {
        var parentQid = currentObj.parent().data('parentqid');
        var parentQDiv = jQuery('[data-questionid=' + parentQid + ']');
        var parentQues = parentQDiv.find('input[type=checkbox]');
        parentQues.prop('checked', true);

        if (parentQDiv.hasClass('child-question')) {
            checkParentQuestion(parentQues);
        }
    }

    jQuery('.root-question input[type=checkbox]').click(function() {
        var currentObj = jQuery(this);
        if (currentObj.is(":checked")) {} else {
            unckeckChildQuestion(currentObj);
        }
    });

    function unckeckChildQuestion(currentObj) {
        var currentQid = currentObj.parent().data('questionid');
        var parentQDiv = jQuery('[data-parentqid=' + currentQid + ']');
        var parentQues = parentQDiv.find('input[type=checkbox]');
        parentQues.prop('checked', false);

        jQuery('.child-question[data-parentqid=' + currentQid + ']').each(function() {
            var currentData = jQuery(this).find('input[type=checkbox]');
            var parentDiv = jQuery('[data-parentqid=' + currentData.val() + ']');
            var parentQue = parentDiv.find('input[type=checkbox]');
            parentQue.prop('checked', false);
            if (parentDiv.hasClass('root-question')) {
                unckeckChildQuestion(parentQues);
            }
        });
    }

    // leads module
    // view page hightlight edited fields
    if (jQuery('.hightlight_lead').length > 0) {
        var selected = jQuery('.hightlight_lead');
        var classes = selected.attr('class').split(' ');
        classes.pop(); // removes table class from array

        jQuery.each(classes, function(key, value) {
            if (selected.find('td.' + value).length) {
                selected.find('td.' + value).addClass('bg-flat-color-6');
            }
        });
    }

    jQuery(document).on("change", ".updateLeadStatus", function() {
        var selector = jQuery(this);
        var url = selector.attr('url');
        console.log(url);
        if (selector.val() == 3) {
            jQuery('#scrollmodal').modal('show').find('.modal-body').load(url);
        }
        /*else {
        	selector.parents('form').submit();
        }*/
    });
    jQuery(document).on("change", ".update_email_count", function() {
        var selector = jQuery(this);
        selector.parents('form').submit();
    });
    jQuery(document).on("change", ".update_phone_count", function() {
        var selector = jQuery(this);
        selector.parents('form').submit();
    });

    jQuery(document).on("submit", ".searchAjax", function(e) {
        e.preventDefault();
        var frm = jQuery(this);
        jQuery.ajax({
            type: "POST",
            url: frm.attr("action"),
            data: frm.serialize(),
            success: function(data) {
                jQuery("body").html(data);
            }
        });
        return false;
    });

    jQuery('#captchacode').addClass('form-control').removeAttr('required');

    jQuery('.creload').on('click', function() {
        var mySrc = jQuery(this).prev().attr('src');
        var glue = '?';
        if (mySrc.indexOf('?') != -1) {
            glue = '&';
        }
        jQuery(this).prev().attr('src', mySrc + glue + new Date().getTime());
        return false;
    });
    if (jQuery('#register').find('.form-error').length) {
        jQuery('a[data-target="#register"]').trigger('click');
    }

    jQuery('.tree-toggler').click(function() {
        jQuery(this).parent().children('ul.tree').toggle(200);
    });

    jQuery('.cattoggle').click(function() {
        jQuery(this).parent().children('ul.catList').toggle(200);
    });

    jQuery('.addUploadBox').click(function(event) {
        var optionCount = jQuery('.appendDiv').size();
        var upfieldname = jQuery(this).attr('data-fieldname');
        var showto = jQuery(this).attr('data-showto');
        var showtoemployees = jQuery(this).attr('data-showto-employees')
        var show_to_label = showto.replace(/_/g, ' ');
        var show_to_employees_label = showtoemployees.replace(/_/g, ' ')
        var inputHtml = '<div class="row appendDiv"><div class="col-lg-3"><div class="form-group"><label for="' + upfieldname + '-' + optionCount + '-name">Document Name</label><input type="text" name="' + upfieldname + '[' + optionCount + '][name]" class="form-control" maxlength="45" id="' + upfieldname + '-' + optionCount + '-name" required="required"></div></div><div class="col-lg-3"><div class="form-group uploadWraper"><label class="col-form-label" for="document">Document</label><br><input type="hidden" name="' + upfieldname + '[' + optionCount + '][document]" class="documentName" id="' + upfieldname + '-' + optionCount + '-document"><input type="file" name="' + upfieldname + '[' + optionCount + '][uploadFile]" required="required"><div class="uploadResponse"></div></div>	</div><div class="col-lg-2"><div class="form-group"><label class="col-form-label" for="show-to-contractor">' + show_to_label + '</label><br><div class="input checkbox"><input type="hidden" name="' + upfieldname + '[' + optionCount + '][show_to_contractor]" value="0"><input type="checkbox" name="' + upfieldname + '[' + optionCount + '][' + showto + ']" value="1" id="' + upfieldname + '-' + optionCount + '-' + showto + '"></div></div></div><div class="col-lg-2"><div class="form-group"><label class="col-form-label" for="show-to-employees">' + show_to_employees_label + '</label><br><div class="input checkbox"><input type="hidden" name="' + upfieldname + '[' + optionCount + '][show_to_employees]" value="0"><input type="checkbox" name="' + upfieldname + '[' + optionCount + '][' + showtoemployees + ']" value="1" id="' + upfieldname + '-' + optionCount + '-' + showtoemployees + '"></div></div></div><div class="col-lg-2"><button type="button" class="removeDiv btn btn-danger" style="margin-top:25px;"><i class="fa fa-times"></i></button></div></div>';
        jQuery('.appendDiv:last').after(inputHtml);
        event.preventDefault();
    });
    jQuery(document).on("click", ".removeDiv", function(event) {
        jQuery(this).parents(".appendDiv").remove();
    });

    /* Employee Craft Certification */
    jQuery('.addUploadBoxEmp').click(function(event) {
        var optionCount = jQuery('.appendDivClass').size();
        var upfieldname = jQuery(this).attr('data-fieldname');
        //var showto = jQuery(this).attr('data-showto');
        //var show_to_label = showto.replace(/_/g, ' ');
        var doctypes = [];
        var j = 0;
        var i = 0;
        var inputHtml = '<div class="row appendDivClass"><div class="col-sm-2 main-class"><div class="form-group"><label for="' + upfieldname + '-' + optionCount + '-document-type-id">Document Type</label><select name="' + upfieldname + '[' + optionCount + '][document_type_id]" class="form-control main-doc-type" required="required" id="' + upfieldname + '-' + optionCount + '-document-type-id">'
        jQuery('.appendDivClass #employeeexplanations-0-document-type-id option').each(function(i) {
            doctypes[i] = jQuery(this).text();
            doctext = doctypes[i].replace(/"/g, '');
            j = jQuery(this).val();
            inputHtml += '<option value=' + j + '>' + doctext + '</option>'
            i++;
            // j++;
            //if (i >= 15) { return false; }
        });
        inputHtml += '</select></div></div><div class="col-sm-2 docname" style="display: none" ><div class="form-group"><label for="' + upfieldname + '-' + optionCount + '-name">Document Name</label><input type="text" name="' + upfieldname + '[' + optionCount + '][name]" class="form-control docName doc-value" maxlength="45" id="' + upfieldname + '-' + optionCount + '-name"></div></div><div class="col-sm-2"><div class="form-group uploadWraper"><label class="col-form-label" for="document">Document</label><br><input type="hidden" name="' + upfieldname + '[' + optionCount + '][document]" class="documentName" id="' + upfieldname + '-' + optionCount + '-document"><input type="file" name="' + upfieldname + '[' + optionCount + '][uploadFile]" required="required"><div class="uploadResponse"></div></div>	</div><div class="col-sm-2"><div class="form-group"><label for="' + upfieldname + '-' + optionCount + '-training-date">Training date</label><input type="text" name="' + upfieldname + '[' + optionCount + '][training_date]" class="form-control setDate"  id="' + upfieldname + '-' + optionCount + '-training-date" placeholder="Training date"></div></div><div class="col-sm-2"><div class="form-group"><label for="' + upfieldname + '-' + optionCount + '-expiration-date">Expiration date</label><input type="text" name="' + upfieldname + '[' + optionCount + '][expiration_date]" class="form-control setDate"  id="' + upfieldname + '-' + optionCount + '-expiration-date" placeholder="Expiration date" ></div></div><div class="col-sm-2"><button type="button" class="removeDiv btn btn-danger" style="margin-top:25px;"><i class="fa fa-times"></i></button></div></div>';
        jQuery('.appendDivClass:last').after(inputHtml);
        jQuery('.setDate').datepicker({ dateFormat: 'yy/mm/dd' });
        event.preventDefault();

        jQuery(".main-doc-type").change(function() {
            var chkDocType;
            checkDocTypes(jQuery(this));
        });
    });

    jQuery(document).on("click", ".removeDiv", function(event) {
        jQuery(this).parents(".appendDivClass").remove();
    });

    if (jQuery(".selectwithcheckbox").length) {
        jQuery(".selectwithcheckbox").multiselect({
            header: ['checkAll', 'uncheckAll']
        }).multiselectfilter({ searchGroups: true });
    }

    jQuery(".main-doc-type").change(function() {
        var chkDocType;
        checkDocTypes(jQuery(this));
        //var docType= jQuery(".main-doc-type option:selected").text();
        // var docType = jQuery(this).children("option:selected").text();

        //    if(docType === 'Other') {
        //       jQuery(this).parents('.main-class').next('div .docname').show();
        //    }
        //    else {
        //    	 jQuery(this).parents('.main-class').next().find('.doc-value').val("");
        //    	jQuery(this).parents('.main-class').next('div .docname').hide();

        //    }
    });

    function checkDocTypes(chkDocType) {
        var docType = chkDocType.children("option:selected").text();
        if (docType == 'Other') {
            chkDocType.parents('.main-class').next('div .docname').show();
            chkDocType.parents('.main-class').next().find('.doc-value').attr("required", true);
        } else {
            chkDocType.parents('.main-class').next().find('.doc-value').val("");
            chkDocType.parents('.main-class').next('div .docname').hide();
            chkDocType.parents('.main-class').next().find('.doc-value').removeAttr("required", true);
        }
    }
    /* End Employee Craft Certification */
    //  Add Contractor Site
    if (jQuery(".siteAddchk").length) {
        jQuery(".siteAddchk").multiselect({
            /*click: function(event, ui){
                jQuery(this).val(ui.value);
                //var data = ui.value;
                jQuery(this).parents('form').submit();
            }   */
            beforeopen: function(){
                jQuery(".ui-multiselect-all").hide();
                jQuery(".ui-multiselect-none").hide();
            },
            open: function(){
                jQuery(".ui-multiselect-all").hide();
                jQuery(".ui-multiselect-none").hide();
            },
        }).multiselectfilter({
            searchGroups: true
        });
    }

    // Add Client(Manage Client)
    if (jQuery(".clientAddchk").length) {
        jQuery(".clientAddchk").multiselect({
            click: function(event, ui) {
                jQuery(this).val(ui.value);
                //var data = ui.value;
                jQuery(this).parents('form').submit();
            },
            beforeopen: function(){
                jQuery(".ui-multiselect-all").hide();
                jQuery(".ui-multiselect-none").hide();
            },
            open: function(){
                jQuery(".ui-multiselect-all").hide();
                jQuery(".ui-multiselect-none").hide();
            },
        }).multiselectfilter({
            searchGroups: true
        });
    }

    //  save Employee Slot
    jQuery(document).on("change", ".emp_slot", function() {
        jQuery.ajax({
            url: '/ContractorSites/addSlot',
            data: "emp_slot=" + jQuery(this).val(),
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': csrfToken },
            success: function(data) {
                jQuery('.invoice-responce').html(data);
            }
        });
    });

    var $el = jQuery('#optgroup option:selected');
    $el.each(function() {
        groupName = jQuery(this).data('optgroup'),
            $parent = jQuery(this).parent(),
            $label = jQuery(this).parent().attr("label"),
            $optgroup = jQuery('#optgroup_to').find('optgroup[label="' + groupName + '"]');

        if (!$optgroup.length)
            $optgroup = jQuery('<optgroup label="' + $label + '" />').appendTo(jQuery('#optgroup_to'));
        jQuery(this).appendTo($optgroup);
        if (!$parent.children().length) $parent.remove();
    });

    var RequestBtn = '';
    jQuery(document).on("click", ".ajaxmodal", function(event) {
        RequestBtn = jQuery(this);
        loadAjax(jQuery(this).attr('href'), jQuery(this).attr('data-target') + ' .modal-body');
    });

    if (typeof customersByCname != 'undefined' && customersByCname) {
        jQuery("#company-name").autocomplete({
            source: customersByCname
        });
    }
    if (typeof industrytype != 'undefined' && industrytype) {
        jQuery("#industry-type").autocomplete({
            source: industrytype
        });
    }

    jQuery(document).on('click', function(e) {
        var
            $popover,
            $target = jQuery(e.target);

        //do nothing if there was a click on popover content
        if ($target.hasClass('popover') || $target.closest('.popover').length) {
            return;
        }

        jQuery('[data-toggle="popover"]').each(function() {
            $popover = jQuery(this);
            if (!$popover.is(e.target) && $popover.has(e.target).length === 0 && jQuery('.popover').has(e.target).length === 0) {
                $popover.popover('hide');
            } else {
                $popover.popover('toggle');
            }
        });
    });

    if (jQuery("#notes, .note").length) {
        jQuery('#notes, .note').summernote({
            height: 120,
            tabsize: 2
        });
    }
    if (jQuery(".datepicker").length) {
        jQuery(".datepicker").datepicker();
    }

    if (jQuery(".searchSelect").length) {
        jQuery(".searchSelect").select2();
    }

    // notes read more / read less
    jQuery(document).on("click", ".read_more", function(e) {
        e.preventDefault();
        jQuery(this).parent().next().show();
        jQuery(this).parent().hide();
    });
    jQuery(document).on("click", ".read_less", function(e) {
        e.preventDefault();
        jQuery(this).parent().prev().show();
        jQuery(this).parent().hide();
    });

    /* Employee add email  hide & show */
    jQuery('#uname').hide();
    jQuery("#isLoginEnabled").click(function() {
        if (jQuery(this).is(":checked")) {
            jQuery('#username').attr("required", true);
            jQuery('#uname').show();

        } else {
            jQuery('#username').removeAttr("required", true);
            jQuery("#uname").hide();
        }

    });


    /* Employee add and edit adresses  hide & show */
    if (jQuery("#isaddressEnabled").length) {
        jQuery("#isaddressEnabled").click(function() {
            if (jQuery(this).is(":checked")) {
                jQuery('#empAddress').removeClass('show');

            } else {
                jQuery("#empAddress").addClass('show');
            }
        });
    }

    /* contractor Answer */
    if (jQuery(".contractoeAnswer").length) {
        jQuery.validator.addClassRules('float_only', {
            required: true,
            number: true,
            range: [0.08, 20.09]
        });
        jQuery(".contractoeAnswer").validate();
    }

    jQuery(".other_textfield").change(function() {
        if (jQuery(this).val() === 'Other') {
            jQuery(this).next('.answer_others').show();
        } else {
            jQuery(this).next('.answer_others').hide();
        }
    });

    jQuery('.sub-question').hide();
    jQuery('.parent-question').each(function() {
        var currentObj = jQuery(this).find("input[type='radio']:checked");

        var dataParentqId = currentObj.parents('.parent-question').data("questionid");
        var dataParent = dataParentqId + '-' + currentObj.val();

        toggleSubQuestion(dataParentqId, dataParent);
    });
    jQuery('.parent-question input[type=radio]').change(function() {
        var currentObj = jQuery(this);

        var dataParentqId = currentObj.parents('.parent-question').data("questionid");
        var dataParent = dataParentqId + '-' + currentObj.val();

        toggleSubQuestion(dataParentqId, dataParent);
    });
    jQuery('.parent-question input[type=checkbox]').click(function() {
        var currentObj = jQuery(this);
        var dataParentqId = currentObj.parents('.parent-question').data("questionid");
        var dataParent = dataParentqId + '-' + currentObj.val();
        toggleSubQuestion(dataParentqId, dataParent);
    });

    function toggleSubQuestion(dataParentqId, dataParent) {
        jQuery('.sub-question[data-parentqid=' + dataParentqId + ']').hide();
        jQuery('.sub-question[data-parent=' + dataParent + ']').show();

        jQuery('.parent-question[data-parentqid=' + dataParentqId + ']').each(function() {
            var currentObj = jQuery(this).find("input[type='radio']:checked");

            var dataSubParentqId = jQuery(this).data("questionid");
            var dataSubParent = dataSubParentqId + '-' + currentObj.val();
            //alert(dataSubParent);
            if (jQuery(this).is(":visible")) {
                jQuery('.sub-question[data-parentqid=' + dataSubParentqId + ']').removeClass('hideElement');

                toggleSubQuestion(dataSubParentqId, dataSubParent);
            } else {
                jQuery('.sub-question[data-parentqid=' + dataSubParentqId + ']').addClass('hideElement');
            }
        });
    }

    /* mobile no. multiple add */
    jQuery(document).on("keypress", ".bootstrap-tagsinput  ", function(e) {
        var inputId = jQuery(this).next('input').attr('id');
        var inputClass = false;
        inputClass = jQuery(this).next('input').hasClass('txtPh');
        if (inputId == "txtPh" || inputClass == true) {
            var regexp = (/[0-9]/);
            var expression = String.fromCharCode(e.keyCode);
            if (regexp.test(expression)) {
                var x = e.target.value.replace(/\D/g, '').match(/(\d{0,3})(\d{0,3})(\d{0,3})/);
                e.target.value = !x[2] ? x[1] : '(' + x[1] + ') ' + x[2] + (x[3] ? '-' + x[3] : '');
            } else {
                e.preventDefault();
            }
        }
    });

    jQuery('#txtPhone, #txtPhone1').on('keyup', function(e) {
        console.log(e.key);
        var x = e.target.value.replace(/\D/g, '').match(/(\d{0,3})(\d{0,3})(\d{0,4})/);
        e.target.value = !x[2] ? x[1] : '(' + x[1] + ') ' + x[2] + (x[3] ? '-' + x[3] : '');
    });

    //jQuery(".datepicker").datepicker("option", "dateFormat", 'yy-mm-dd');
    jQuery('#genPassword').click(function() {
        var generate = (
                length = 7,
                wishlist = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz~!@-#$"
            ) => Array(length)
            .fill('') // fill an empty will reduce memory usage
            .map(() => wishlist[Math.floor(crypto.getRandomValues(new Uint32Array(1))[0] / (0xffffffff + 1) * wishlist.length)])
            .join('');

        var gPass = generate();
        jQuery("#password").val(gPass);
    });

    //	 Contractor_site/manage_site
    jQuery(document).on("click", ".siteDelete", function(e) {
        e.preventDefault();
        var selector = jQuery(this);
        var frm = jQuery(this).parent('form');
        jQuery.ajax({
            headers: { 'X-CSRF-TOKEN': csrfToken },
            type: 'POST',
            data: frm.serialize(),
            url: '/ContractorSites/checkSiteCount',
            //data: { client_id: client_id },
            success: function(clientSiteCnt) {
                if (clientSiteCnt == 1) {
                    var x = confirm("Client will be unassociated...! Are you sure you want to delete the site? ");
                    if (x) {
                        selector.parents('form').submit();
                    }
                } else {
                    var x = confirm("Are you sure you want to delete the site?");
                    if (x) {
                        selector.parents('form').submit();
                    }
                }
            }
        });
    });
    //lead-notes Note Type Selection
    jQuery(document).ready(function($) {
        if ($(".noteTypeSelection").val() == "5") {
            $(".statusedit").show();
            if ($(".statusSeledit").val() == "6") {
                $(".contSeledit").show();
            }
        } else if ($(".noteTypeSelection").val() == "2") {
            $(".Follow_upedit").show();
        }
        $('.noteTypeSelection').on('change', function() {
            if (this.value == "2") {
                $(".status").hide();
                $(".Follow_up").show();
                $(".contSelect").hide();
            } else if (this.value == "5") {
                $(".Follow_up").hide();
                $(".status").show();

                if ($(".statusSelection").val() == "6") {
                    $(".contSelect").show();
                }

            } else {
                $(".Follow_up").hide();
                $(".status").hide();
                $(".contSelect").hide();
            }
        });
    });
    /* Edit Employee Craft Certification */
    jQuery(document).ready(function($) {
        var docType = $(".main-doc-type option:selected").text();
        if (docType === 'Other') {
            $(".docname").show();
        } else {
            $(".docname").hide();
        }
    });
    /* End  Employee Craft Certification */
    //lead-notes status Selection
    jQuery(document).ready(function($) {
        $('.statusSelection').on('change', function() {
            if (this.value == "6") {
                $(".contSelect").show();
            } else {
                $('.contSelect').find('select').val("").change();
                $(".contSelect").hide();
            }
        })
    });

    /* Other country Selection */
    jQuery('.otherCountrySelection').on('change', function() {
        if (this.value == "0") {
            jQuery(".userEnterCountry").show();
            jQuery(".statelist").hide();
        } else {
            jQuery(".userEnterCountry").hide();
            jQuery(".statelist").show();
        }
    });
    /* when country selected then set state */
    jQuery('.otherCountrySelection').each(function() {
        var c_id = jQuery(this).find(':selected').val();
        var last = localStorage.getItem('lastSelect');

        if (c_id) {
            jQuery.ajax({
                headers: { "X-CSRF-TOKEN": csrfToken },
                type: "POST",
                url: "/countries/getStates/true/" + c_id,
                success: function(data) {
                    console.log(data);
                    jQuery('.ajax-responce').html(data);
                    jQuery('.searchSelect.i-store').val(last); // Select the option with a value of '1'
                    jQuery('.searchSelect.i-store').trigger('change'); // Notify any JS components that the value changed
                },
            });
        }

    });
    jQuery(document.body).on("change", "#state-id", function() {
        var vl = jQuery(this).val();
        localStorage.setItem("lastSelect", vl);
    });
    /*--------------------------------------*/
    /* Email signature selection */
    jQuery(document).ready(function() {
        jQuery('#myselection').on('change', function() {
            var demovalue = jQuery(this).val();
            console.log(demovalue);
            jQuery("div.myDiv").hide();
            jQuery("#show" + demovalue).show();
        });
        var selected = jQuery('#myselection :selected').val();
        // console.log(selected);
        if (selected) {
            jQuery("div.myDiv").hide();
            jQuery("#show" + selected).show();
        }

    });
    /* typed data show in preview in signature*/
    jQuery('#inputs input,textarea').keyup(function() {
        var input = jQuery(this).attr('id');
        var val = jQuery(this).val();
        jQuery('.' + input).html(val);
        var link = jQuery('.uploadResponse img').attr('src');
        jQuery('.profile_photo').attr('src', link);

    });
    /* onload the signature data */
    jQuery(document).ready(function() {
        jQuery('#inputs input,#inputs textarea').each(function() {
            var input = jQuery(this).attr('id');
            // console.log(input);
            var val = jQuery(this).val();
            jQuery('.' + input).html(val);
            var link = jQuery('.uploadResponse img').attr('src');
            jQuery('.profile_photo').attr('src', link);

        });

    });
    // var prepare = jQuery('#inputs button');
    // console.log(prepare);
    // var download = jQuery('.template-data');

    // prepare.addEventListener('click', prepareHTML);
    jQuery('.signatue-save').hide();
    jQuery(".signatue-generate").on("click", function(e) {
        e.preventDefault();
        prepareHTML();
        jQuery('.signatue-generate').hide();
        jQuery('.signatue-save').show();
    });
    /* add attachment box */

    jQuery('.addAttachBox').click(function(event) {
        var optionCount = jQuery('.appendDiv').size();
        var upfieldname = jQuery(this).attr('data-fieldname');
        var inputHtml = '<div class="col-sm-3 appendDiv"><div class="form-group uploadWraper"><label class="col-form-label" for="document">Attachment</label><br><input type="hidden" name="' + upfieldname + '[' + optionCount + '][document]" class="documentName" id="' + upfieldname + '-' + optionCount + '-document"><input type="file" name="' + upfieldname + '[' + optionCount + '][uploadFile]" required="required"><div class="uploadResponse"></div></div><button type="button" class="removeDiv btn btn-danger btn-sm" style="/*margin-top:25px;*/"><i class="fa fa-times"></i></button></div>';
        jQuery('.appendDiv:last').after(inputHtml);
        event.preventDefault();
    });

    /*---------------------------------------*/
});
// Notifications  Calls
jQuery(document).ready(function() {
    var contractor_id = jQuery("input[name=contractor_id]").val();
    jQuery.ajax({
        url: '/Notifications/getAllNotifymsg/' + contractor_id,
        data: "id=" + contractor_id,
        type: 'post',
        headers: { 'X-CSRF-TOKEN': csrfToken },
        success: function(list) {
            //console.log(list);
            for (var i = 0; i < list.length; i++) {
                var id = list[i].id;
                if (list[i].notification_type_id == 2) {
                    jQuery('li[data-id=' + id + ']').addClass("bgtype_2");
                    jQuery('li[data-id=' + id + ']').find('i').addClass("menu-icon fa fa-usd");
                } else if (list[i].notification_type_id == 3) {
                    jQuery('li[data-id=' + id + ']').addClass("bgtype_3");
                    jQuery('li[data-id=' + id + ']').find('i').addClass("menu-icon fa fa-trash-o");
                } else if (list[i].notification_type_id == 4) {
                    jQuery('li[data-id=' + id + ']').addClass("bgtype_4");
                    jQuery('li[data-id=' + id + ']').find('i').addClass("menu-icon fa fa-arrow-circle-o-right");
                } else if (list[i].notification_type_id == 5) {
                    jQuery('li[data-id=' + id + ']').addClass("bgtype_5");
                    jQuery('li[data-id=' + id + ']').find('i').addClass("menu-icon fa fa-circle");
                } else if (list[i].notification_type_id == 6) {
                    jQuery('li[data-id=' + id + ']').addClass("bgtype_6");
                    jQuery('li[data-id=' + id + ']').find('i').addClass("menu-icon fa  fa-arrow-circle-o-up mr");
                } else if (list[i].notification_type_id == 7) {
                    jQuery('li[data-id=' + id + ']').addClass("bgtype_7");
                    jQuery('li[data-id=' + id + ']').find('i').addClass("menu-icon fa  fa-calendar mr");
                }

            }
        }
    });


    jQuery('#notification').click(function() {
        var count = document.getElementById('noti_count').innerHTML;

        jQuery(document).on("click", ".subject", function(e) {
            e.preventDefault();

            var selector = jQuery(this).data("value");
            /*var grandParent = jQuery(this).parent().parent();
            if(grandParent.hasClass('list-read') == true) {
            jQuery('li[data-id='+selector+']').removeClass("list-read");
            count--;
            	if(count>=0){
            	document.getElementById('noti_count').innerHTML = count;
            	}
            }*/
            jQuery.ajax({
                url: '/Notifications/isRead/' + selector,
                data: "id=" + selector,
                type: 'get',
                headers: { 'X-CSRF-TOKEN': csrfToken },
                success: function(data) {
                    jQuery('li[data-id=' + selector + ']').removeClass("list-read");
                },
                error: function(error) {
                    console.log('error; ' + JSON.stringify(error));
                }
            });
            return false;
        });
    });

    jQuery('.table tbody').on('click', '.subject', function() {
        var currow = jQuery(this).closest('tr');
        var selector = currow.find('td:eq(0)').text();
        jQuery.ajax({
            url: '/Notifications/isRead/' + selector,
        });
        return false;
    });
});

// Payment - save card functionality
/*jQuery("#ccnumber").on("keydown", function(e) {
	    var cursor = this.selectionStart;
	    if (this.selectionEnd != cursor) return;
	    if (e.which == 46) {
	        if (this.value[cursor] == " ") this.selectionStart++;
	    } else if (e.which == 8) {
	        if (cursor && this.value[cursor - 1] == " ") this.selectionEnd--;
	    }
	}).on("input", function() {
	    var value = this.value;
	    var cursor = this.selectionStart;
	    var matches = value.substring(0, cursor).match(/[^0-9]/g);
	    if (matches) cursor -= matches.length;
	    value = value.replace(/[^0-9]/g, "").substring(0, 16);
	    var formatted = "";
	    for (var i=0, n=value.length; i<n; i++) {
	        if (i && i % 4 == 0) {
	            if (formatted.length <= cursor) cursor++;
	            formatted += " ";
	        }
	        formatted += value[i];
	    }
	    if (formatted == this.value) return;
	    this.value = formatted;
	    this.selectionEnd = cursor;
	});
	jQuery("#chkPayment").click(function () {
		if (jQuery(this).is(":checked")) {
			jQuery('#dvpayment').show();
		} else {
			 jQuery("#dvpayment").hide();
		}
	});
	jQuery("#card-chk-2").click(function () {
		jQuery('#blankform').show();
		jQuery('#card_unchk1').removeClass('d-none');
		jQuery('#card-details').hide();
	});
	jQuery('#card_unchk1, #card_unchk2').click(function () {
		jQuery('#blankform').hide();
		jQuery('#card_unchk1').addClass('d-none');
		jQuery('#card-details').show();
	});
	jQuery(".card_details").change(function() {
		jQuery(this).parents('#card-details').find(".select_cccvv").attr('disabled', 'disabled');
		jQuery(this).parents('#card-details').find('.card-row').removeClass('active');
		if (jQuery(this).is(':checked')) {
			jQuery(this).parents('.card-row').addClass('active');
			jQuery(this).parents('.card-row').find(".select_cccvv").removeAttr('disabled');
		}
	});*/





/*function checkSiteCount(id,client_id){
	//var selector = jQuery(this);
	jQuery.ajax({
		headers: {'X-CSRF-TOKEN': csrfToken },
		type: 'GET',
		url:  '/ContractorSites/checkSiteCount/'+client_id,
		//data: { client_id: client_id },
		success: function(clientSiteCnt)
		{
			if (clientSiteCnt == 1)
			{
				var x =  confirm("Are you sure you want to delete..?");
				if (x){
					  alert("Hiii");
				      return true;
				  }else{
				    return false;
				}}
		}
	});
	//return false;
}*/



function loadAjax(url, ajaxDiv) {
    jQuery.ajax({
        type: 'GET',
        url: url,
        success: function(data) {
            jQuery(ajaxDiv).html(data);
            jQuery("body").on("click", ".datetimepicker", function() {
                jQuery(this).datetimepicker();
                //jQuery(this).datepicker("option", "dateFormat", 'yy-mm-dd');
                jQuery(this).datetimepicker("show");
            });
            jQuery('.note').summernote({
                height: 150,
                tabsize: 2
            });
        }
    });
}
if (jQuery(".datetimepicker").length) {
    jQuery('.datetimepicker').datetimepicker();
}
jQuery(function() {
    var dateFormat = "mm/dd/yy",
        from = jQuery(".from_date").datepicker({
            defaultDate: "+1w",
            changeMonth: true,
            numberOfMonths: 1
        })
        .on("change", function() {
            to.datepicker("option", "minDate", getDate(this));
        }),
        to = jQuery(".to_date").datepicker({
            defaultDate: "+1w",
            changeMonth: true,
            numberOfMonths: 1
        })
        .on("change", function() {
            from.datepicker("option", "maxDate", getDate(this));
        });

    function getDate(element) {
        var date;
        try {
            date = jQuery.datepicker.parseDate(dateFormat, element.value);
        } catch (error) {
            //alert(error);
            date = null;
        }
        return date;
    }
});

// if(document.getElementById('txtPhone')!=null) {
// document.getElementById('txtPhone').addEventListener('input', function (e) {
// 	 var x = e.target.value.replace(/\D/g, '').match(/(\d{0,3})(\d{0,3})(\d{0,4})/);
// 		e.target.value = !x[2] ? x[1] : '(' + x[1] + ') ' + x[2] + (x[3] ? '-' + x[3] : '');
// });
// }

if (document.getElementById('txtTIN') != null) {
    document.getElementById('txtTIN').addEventListener('input', function(e) {
        var x = e.target.value.replace(/\D/g, '').match(/(\d{0,2})(\d{0,7})/);
        e.target.value = !x[2] ? x[1] : '' + x[1] + '-' + x[2] + (x[3] ? '-' + x[3] : '');
    });
    var tinVal = document.getElementById('txtTIN').value;
    var x = tinVal.replace(/\D/g, '').match(/(\d{0,2})(\d{0,7})/);
    document.getElementById('txtTIN').value = !x[2] ? x[1] : '' + x[1] + '-' + x[2] + (x[3] ? '-' + x[3] : '');
}


/* Payment on change overlay */
jQuery(document).on("click", ".overlayChange", function() {
    jQuery('#overlay').show();
    jQuery("#overlay").addClass("loading");
});

/* Copy Login Url for Developer Role */
jQuery(document).on("click", "#copyButton", function() {
    const copy = document.getElementById("copyButton");
    const selection = window.getSelection();
    const range = document.createRange();
    const login_url = document.getElementById("login_url");
    copy.addEventListener('click', function(e) {
        range.selectNodeContents(login_url);
        selection.removeAllRanges();
        selection.addRange(range);
        const successful = document.execCommand('copy');
        window.getSelection().removeAllRanges();
    });
});




/* Evalaute Question and Answer given Answer */
jQuery('.sendData,.evaluate-all').on('click', function() {
    var val = [];
    var data_index = [];
    var data_qid = [];
    var data_ans = [];
    var text;
    var chkb;
    var rd;
    // console.log(typeof val);
    var c = jQuery(this).parents('.form-group').find('.checkbox input,.radio input,.text input').attr('type');
    console.log(c);
    var formWrapper = jQuery(this).parents('.form-group');
    if (c == 'radio') {
        rd = formWrapper.find("input[type=radio]:checked").val();
        console.log("rd= " + rd);
        val.push(formWrapper.find("input[type=radio]:checked").val());

        var qid = jQuery(this).parent().prevUntil('col-sm-9').find('input[type=hidden]').eq(0).val()
    } else if (c == 'checkbox') {
        chkb = formWrapper.find("input[type=checkbox]:checked").val();
        jQuery.each(formWrapper.find('input[type=checkbox]:checked'), function(i) {
            data_index[i] = jQuery(this).parents('.checkbox').attr('data-index');
            data_ans[i] = jQuery(this).parents('.ques-ans').attr('data-ans');
            val.push(jQuery(this).val());

        });
        var qid = jQuery(this).parent().prevUntil('col-sm-9').find('input[type=hidden]').eq(1).val()
    } else {
        text = formWrapper.find("input[type=text]").val();
        console.log("Text= " + text);
        val.push(text);

        var qid = jQuery(this).parent().prevUntil('col-sm-9').find('input[type=hidden]').eq(0).val()
    }


    /*Save Answer When Evaluate button Click */
    /*jQuery.ajax({
            headers: {'X-CSRF-TOKEN': csrfToken },
            type: "POST",
            url: '/TrainingAnswers/saveAns',
            data: {
                qid:qid,
                answer:val
            },
            success: function( data ) {
			// console.log(data);
            }
        });*/
    var selector = jQuery(this).parents('.ques-ans');
    console.log(selector);
    evaluateAns(selector);
    return false;

});

function evaluateAns(selector) {
    var correct_ans = selector.attr('data-ans');
    var qid = selector.attr('data-qid');
    var options = [];
    var answers = [];
    answers = correct_ans.split(',');
    selector.find('.check-ans').remove();
    selector.find('input[type=checkbox],input[type=radio]').each(function(i) {
        if (answers != '') {
            if (jQuery.inArray(JSON.stringify(i), answers) > -1) {
                jQuery(this).parent().append('<span class="check-ans m-3 text-success"><span class="fa fa-check-circle"></span></span>');
            } else {
                jQuery(this).parent().append('<span class="check-ans m-3 text-danger"><span class="fa fa-times-circle"></span></span>');
            }
        }
    });
}


/* Answer option shows warnings */
jQuery('body').on('change', '.checkbox input', function() {
    var sel;
    var chkWarnings;
    var id = jQuery(this).parents('.checkbox').attr('data-index');
    if (jQuery(this).is(':checked')) {
        console.log(id + ' checked !!');
        checkWarnings(jQuery(this), id);
    } else {
        console.log(id + ' unchecked !!');
        uncheckWarnings(jQuery(this), id);
    }

});

function checkWarnings(chkWarnings, id) {
    chkWarnings.parents('.ques-ans').find('.data-attribute-section').each(function() {
        var currentChk = jQuery(this).find('li').eq(id).text().length;
        var sibling = jQuery(this).find('li').eq(id).siblings().text().length;
        if (currentChk > 0) {
            jQuery(this).find('li').eq(id).css('display', 'block');
            jQuery(this).addClass('alert alert-warning');
        }
    });
}

function uncheckWarnings(chkWarnings, id) {
    var flag = 0;

    chkWarnings.parents('.ques-ans').find('.data-attribute-section').each(function() {
        var currentChk = jQuery(this).find('li').eq(id).text().length;
        var sibling = jQuery(this).find('li').eq(id).siblings().text().length;
        if (currentChk > 0) {
            jQuery(this).find('li').eq(id).css('display', 'none');
        }
        if (sibling == 0) {
            jQuery(this).removeClass('alert alert-warning');
        }
        var counter = 0;
        jQuery(this).children().each(function() {
            if (jQuery(this).attr('style') === 'display: block;') {
                counter++;
            }
        });
        console.log("counter " + counter);
        if (counter == 0) {
            jQuery(this).removeClass('alert alert-warning');
        }
    });
}

/* Radio check  */
jQuery('body').on('change', '.radio input', function() {
    var id = jQuery(this).parents('.radio').attr('data-index');
    var rdchk = jQuery(this).parents('.ques-ans').find('.data-attribute-section li');
    var alertbox = jQuery(this).parents('.ques-ans').find('.data-attribute-section');
    if (id == 0) { //  true --0
        // console.log(rdchk.text());
        if (rdchk.text()) {
            rdchk.eq(id).css('display', 'inline-block');
        }
        rdchk.eq(1).css('display', 'none');
    } else { // false -- 1
        if (rdchk.text()) {
            rdchk.eq(id).css('display', 'inline-block');
        }
        rdchk.eq(0).css('display', 'none');
        // console.log("false");
    }
    if (id) {
        if (rdchk.eq(id).text().length != 0) {
            alertbox.addClass('alert alert-warning');
            alertbox.addClass('custom-bullets');
        } else {
            alertbox.removeClass('alert alert-warning');
            alertbox.removeClass('custom-bullets');
        }
    }

});

/* video status */
var video = document.getElementById("video");

var timeStarted = -1;
var timePlayed = 0;
var duration = 0;
// If video metadata is laoded get duration
if (video != null) {
    if (video.readyState > 0) {
        getDuration.call(video);
    }
    //If metadata not loaded, use event to get it
    else {
        video.addEventListener('loadedmetadata', getDuration);
    }
    // remember time user started the video
    function videoStartedPlaying() {
        timeStarted = new Date().getTime() / 1000;

        if (event.type == "playing" || event.type == "play") {
            document.getElementById("status").className = "complete";
            jQuery('.isComplete').val('Complete')
            q_id = jQuery('.isVideo').val();
            answer = "complete";//jQuery('#status').attr('class');
            //console.log(q_id);
            //console.log(answer);
            jQuery.ajax({
                headers: { 'X-CSRF-TOKEN': csrfToken },
                type: "POST",
                url: '/TrainingAnswers/setvideoStatus',
                data: { answer, q_id },
                success: function(data) {
                    console.log(data);

                }
            });
        }
    }

    function videoStoppedPlaying(event) {
        // Start time less then zero means stop event was fired vidout start event
        if (timeStarted > 0) {
            var playedFor = new Date().getTime() / 1000 - timeStarted;
            timeStarted = -1;
            // add the new ammount of seconds played
            timePlayed += playedFor;
        }



        document.getElementById("played").innerHTML = Math.round(timePlayed) + "";

        if (event.type == "ended") {
            location.reload(true);
        }
        // Count as complete only if end of video was reached
        /*if(Math.round(timePlayed)>=Math.round(duration) && event.type=="ended") {
        	      document.getElementById("status").className="complete";
            jQuery('#training-answers-0-answer').val('Complete')
            q_id  = jQuery('#training-answers-0-training-questions-id').val();
            answer = jQuery('#status').attr('class');
            jQuery.ajax({
        			headers: {'X-CSRF-TOKEN': csrfToken },
        			type: "POST",
        			url: '/TrainingAnswers/setvideoStatus',
        			data: {answer,q_id},
        			success: function( data ) {
        				console.log(data);
        				location.reload(true);
        			}
        		});
          		}*/
    }

    function getDuration() {
        duration = video.duration;
        document.getElementById("duration").appendChild(new Text(Math.round(duration) + ""));
        // console.log("Duration: ", duration);
    }

    video.addEventListener("play", videoStartedPlaying);
    vid.onplaying = function() {
        videoStartedPlaying();
    };
    video.addEventListener("playing", videoStartedPlaying);

   // video.addEventListener("ended", videoStoppedPlaying);
    //video.addEventListener("pause", videoStoppedPlaying);

    var player = videojs('video');
    var time = localStorage.getItem('videojs-resume:1923212');
    // console.log(time);
    var randomnumber = Math.floor(Math.random() * 16) + 5;

    // console.log(randomnumber);
    player.Resume({
        uuid: randomnumber
    });
}

/* Email signature set to hidden field */
function prepareHTML() {
    var html = jQuery("#signature_container")[0].innerHTML;
    jQuery("#template").val(html);
}

/* Preview the Email */
jQuery(document).ready(function() {
    jQuery("#btn-preview").on("click", function(e) {
        var content = jQuery("#template-content").val();
        var sign = jQuery("#sign-content").val();
        var fullname = jQuery("#to-mail-content").val();

        if (content !== "") {
            jQuery("#mail-content").empty();
            jQuery("#mail-content").html(content);
        }
        if (sign !== "") {
            jQuery("#signature-content").empty();
            jQuery("#signature-content").html(sign);
        }
        if (fullname !== "") {
            jQuery("#exampleModalCenter").find("#pri_contact_fname").empty();
            jQuery("#exampleModalCenter").find("#pri_contact_lname").empty();
            jQuery("#exampleModalCenter")
                .find("#pri_contact_lname")
                .html(fullname);
        }
    });
});
/* ----------------- */

/* submit selected records for email */
jQuery(document).ready(function() {
    jQuery('.c-list').on('click', function() {
        var form = jQuery('#createList');
        var selected = new Array();

        var chks = jQuery("#bootstrap-data-table").find("input[name='contractor_id']");
        // console.log(chks);
        for (var i = 0; i < chks.length; i++) {
            //console.log("i",i);
            if (chks[i].checked) {
                //console.log("chcked....");
                selected.push(chks[i].value);
            }
        }
        for (var i = 0; i < selected.length; i++) {
            // console.log(selected[i]);
        }
        // Display the selected CheckBox values.
         if (selected.length == 0) {
            //alert("Please check record atlest one.")
            return;
         }
        if (selected.length > 0) {
            // console.log("Selected values: " + selected.join(","));
            jQuery(form).append(
                jQuery("<input>")
                .attr("type", "hidden")
                .attr("name", "suppliers_ids[]")
                .val(selected.join(","))
            );
            // if one or more checkbox checked then modal open
            jQuery('#exampleModal').modal('toggle');


        }
    });

});

/*------------------------------------*/

/* quill editor code */
Quill.register("modules/placeholder", PlaceholderModule.default(Quill));

var quill = new Quill("#editor", {
    modules: {
        toolbar: { container: '#toolbar' },
        placeholder: {
            placeholders: [
                { id: "pri_contact_fname", label: "pri_contact_fname" },
                { id: "pri_contact_lname", label: "pri_contact_lname" },
                { id: "supplier_name", label: "supplier_name" },
                { id: "client_company_name", label: "client_company_name" },
            ],
        },
    },
    placeholder: "Compose an here...",
    theme: "snow", // or 'bubble'
});

/* Email tempalte selection */
jQuery(document).ready(function() {
    jQuery("#selectTemplate").on("change", function() {
        var demovalue = jQuery(this).val();
        // console.log(demovalue);
        jQuery.ajax({
            headers: { "X-CSRF-TOKEN": csrfToken },
            type: "POST",
            url: "/EmailWizards/getTemplateData",
            data: {
                id: demovalue,
            },
            success: function(data) {
                quill.setContents(JSON.parse(data));
            },
        });
    });
    /* onload edit quill editor fill data */
    jQuery('#selectTemplate').each(function() {
        var selectedId = jQuery(this).find(':selected').val();
        jQuery.ajax({
            headers: { "X-CSRF-TOKEN": csrfToken },
            type: "POST",
            url: "/EmailWizards/getTemplateData",
            data: {
                id: selectedId,
            },
            success: function(data) {
                quill.setContents(JSON.parse(data));
            },
        });

    });

    jQuery("#selectSignature").on("change", function() {
        var demovalue = jQuery(this).val();
        jQuery("#sign-content").val(demovalue);
    });
    var fileName = jQuery('.documentName').val();
    if (fileName) {
        jQuery('.newFile').hide();
    }
    jQuery('.del-btn').on('click', function() {
        var id = jQuery('#email-campaign-id').val();
        var fileName = jQuery('.documentName').val();
        jQuery.ajax({
            headers: { "X-CSRF-TOKEN": csrfToken },
            type: "POST",
            url: "/EmailWizards/deleteAttachment",
            data: {
                id: id,
                name: fileName
            },
            success: function(data) {
                console.log(data);
            },
        });
        jQuery('.newFile').show();
    });

});
/* save template */
jQuery(document).on("click", "#save-temp", function() {
    var templateName = prompt("Please enter template name");
    if (templateName != null) {
        var templateContent = jQuery('#template-content').val();
        var deltaCode = jQuery('#delta-code').val();
    }
    jQuery.ajax({
        headers: { "X-CSRF-TOKEN": csrfToken },
        type: "POST",
        url: "/EmailWizards/createTemplate",
        data: {
            name: templateName,
            template_content: templateContent,
            quill_delta: deltaCode
        },
        success: function(data) {
            console.log(data);
        },
    });

});
/*-----------------*/
function getID() {
    var id = jQuery("#select-id").find(":selected").val();
    jQuery.ajax({
        headers: { "X-CSRF-TOKEN": csrfToken },
        type: "POST",
        url: "/EmailWizards/getContractorInfo/" + id,
        success: function(data) {
            var d = JSON.parse(data);
            jQuery("#to-mail-content").val(
                d.pri_contact_fn + " " + d.pri_contact_ln
            );
        },
    });
}

/*-------------------------------------*/
quill.on("text-change", function() {
    var delta = quill.getContents();
    var text = quill.getText();
    var justHtml = quill.root.innerHTML;
    // console.log(justHtml);
    jQuery("#template-content").val(justHtml);
    jQuery("#delta-code").val(JSON.stringify(delta));
});

var contents = jQuery("#delta-code").val();
if (contents) {
    quill.setContents(JSON.parse(contents));
}
