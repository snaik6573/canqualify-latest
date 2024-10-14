/*function acc_type(account_type)
{	
	if(account_type == 2) {
		jQuery('#div_sites').show();
		jQuery('#div_corporate').hide();		
	}
	else if(account_type == 3) {
		jQuery('#div_corporate').show();
		jQuery('#div_sites').show();
	}
	else {
		jQuery('#div_sites').show();
		jQuery('#div_corporate').hide();
	}
}*/
jQuery(document).ready(function () {	
	/*jQuery('#account-type-id').on('change', function() {
		var account_type = jQuery(this).val();
		acc_type(account_type);
	});
	acc_type(jQuery('#account-type-id').val());*/


	jQuery('.ajaxDelete').removeAttr("onclick");
	jQuery(document).on("click",".add_sites",function(e) {
		e.preventDefault();
		jQuery('#form_sites').toggle();
	});
	jQuery(document).on("click",".add_regions",function(e) {
		e.preventDefault();
		jQuery('#form_regions').toggle();
	});
	jQuery(document).on("submit",".ajaxSubmit",function(e) {	
		e.preventDefault();
		var $form = jQuery(this);
		jQuery.ajax({
			type: "POST",
			url:$form.attr("action"),
			data: $form.serialize(),
			success: function( data )
			{
				$form[0].reset();			
				if($form.attr('data-responce') !== undefined) {
					jQuery($form.attr('data-responce')).html(data);
				}
				else {
					$form.next(".ajaxresponse").html(data);
				}
				setTimeout(function(){
                jQuery(".tags").tagsinput('removeAll');
                $form.find('[type="submit"] span').text("Add Site"); }, 3000);
				jQuery('.ajaxDelete').removeAttr("onclick");	
                			
			}
		});
	});	
	
	
	jQuery(document).on("click",".ajaxDelete",function(e) {
     confirm('Are you sure you want to delete ?');
		e.preventDefault();
		var selector = jQuery(this);
		var prvfrm = jQuery(this).prev();	
		jQuery.ajax({
			type: "POST",
			cache: false,
			url:prvfrm.attr("action"),
			data: prvfrm.serialize(),
			success: function( data ) {				
				selector.parents("tr").remove();
				selector.parents("li").remove();
			}
		});
		return false;
	});

	jQuery(".select_all").click(function() {
		var checkvalue =jQuery(this).data("check");		
		checkBoxes =jQuery(this).parents('form').find('input.'+checkvalue);
		if (jQuery(this).is(':checked')) {
			checkBoxes.prop("checked", true);
		}
		else {
			checkBoxes.prop("checked", false);
		}
   	});

	// step wiazard
	if(jQuery('.stepwizard').length) {
		var url = window.location.href;    
		url = url.split("add-client/");
		var urlparam = url[1].split("/");
		var addurl =url[0]+"add-client";
		if(urlparam[0] == 'undefined' || urlparam[0] == '') { urlparam[0] = 1 }
		if(typeof(urlparam[1]) === 'undefined' || urlparam[1] == '') { urlparam[1] = '' }
		var step = urlparam[0];
		var cId= urlparam[1];

		var navListItems = jQuery('div.setup-panel div a'),
		allWells = jQuery('.setup-content'),
		allNextBtn = jQuery('.nextBtn');
		allWells.hide();

		jQuery('div.setup-panel').find('a').removeClass("btn-primary");
		jQuery('div.setup-panel').find('a[href="#step-'+step+'"]').addClass("btn-primary").removeAttr('disabled');
		jQuery('#step-'+step).show();

		navListItems.click(function (e) {
			e.preventDefault();
			var $item = jQuery(this);
			var $target = jQuery($item.attr('href'));
			var setstep = $item.data('step');		
			var rediurl = addurl+"/"+setstep+"/"+cId;
			//history.pushState(null, null, rediurl);	
			//alert(rediurl);		
			window.location.href = rediurl;

			if (!$item.hasClass('disabled')) {
				navListItems.removeClass('btn-primary').addClass('btn-default');
				$item.addClass('btn-primary');
				allWells.hide();
				$target.show();
				$target.find('input:eq(0)').focus();
			}
		});

		allNextBtn.click(function(){
			var curStep = jQuery(this).closest(".setup-content");
			//var curStepBtn = curStep.attr("id");
			//var nextStepWizard = jQuery('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().next().children("a");
			if(jQuery(this).hasClass('stepsave')) {
				curStep.find('.clients_add').submit();
				//alert(nextStepWizard);
			}
		});
		//jQuery('div.setup-panel div a.btn-primary').trigger('click');
	}    
});
   
