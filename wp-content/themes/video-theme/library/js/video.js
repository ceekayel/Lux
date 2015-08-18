/*
 * This script include for video submition form
 * for video submit page accordian and form validation related funcations
 */
jQuery( document ).ready(function() {
	var submit_form_button = 0;
	/* Submit form using jquery submit */	
	jQuery("#submit_form_button").click(function(e){
		/*Get the wp_editor content and append in submit form to get the wp_editor data on submit page */
		jQuery('.wp-editor-container textarea').each(function(){
			var name=jQuery(this).attr('id');
			jQuery('<input>').attr({
				type: 'hidden',
				id: name,
				name: name,
				value: tinyMCE.get(name).getContent()
			}).appendTo('#submit_form');
		});
		/* submit form after payment gateway condition is satisfied*/
		jQuery('#submit_form').submit();
		return false;
	});
	finishStep = [];
	currentStep = 'post';
	function addFinishStep(step) {
		if (typeof finishStep === 'undefined') {
			finishStep = [];
		}
		finishStep.push(step);
	}
	function goToByScroll(id){
		  // Reove "link" from the ID
		id = id.replace("link", "");
		  // Scroll
	   jQuery('html,body').animate({
			scrollTop: jQuery("body").offset().top},
			'slow');
	}
	function showNextStep()
	{
		var next = 'post',
		view = this;
		jQuery('.step-wrapper').removeClass('current');
		jQuery('.content').slideUp(500, function() {
			// current step is post
			if (currentStep == 'post') {
				if (parseInt(jQuery('#step-auth').length) === 0)
				{
					user_login = true;
				}
				else
				{
					user_login = false;
				}
				if (user_login) {
					 goToByScroll('step-auth');
					next = 'payment';
				}
				else
				{
					next = 'auth';
				}
			}
			
			// show next step
			jQuery('.step-' + next + '  .content').slideDown(10).end();
			jQuery('.step-' + next).addClass('current');
		});
	}
	/*jQuery("#continue_submit_from").click(function(){
		jQuery("#auth").addClass('active');
		jQuery("#post").removeClass('active');
	});*/
	jQuery('#continue_submit_from').bind('click',function(event){
		event.preventDefault();
		var $target = jQuery(event.currentTarget),
		$ul = $target.closest('ul'),
		view = this;
		currentStep = 'post';
		jQuery('div#step-post').addClass('complete');		
		if(parseInt(jQuery('#step-auth').length) !== 0 && can_submit_form == 1 )
		{
			addFinishStep('step-post');
			showNextStep();
		  // Call the scroll function	
		}else if(can_submit_form == 1)
		{
			jQuery('#submit_form_button').trigger('click');
		}
	});
	/*jQuery('.submit-video').bind('click',function(event){
		jQuery('#step-post').css('display','block');
		jQuery('#step-auth').css('display','none');
	});*/
	
	// Perform AJAX login on form submit
	jQuery('form#submit_form #submit_form_login').bind('click', function(e){
		jQuery('.wp-editor-container textarea').each(function(){
			var name=jQuery(this).attr('id');
			jQuery('<input>').attr({
				type: 'hidden',
				id: name,
				name: name,
				value: tinyMCE.get(name).getContent()
			}).appendTo('#submit_form');
		});
		var submit_from = jQuery('form#submit_form').serialize();
		var username=jQuery('form#submit_form #user_login').val(); 
		var password= jQuery('form#submit_form #user_pass').val();
		var security= jQuery('form#submit_form #security').val() ;
		var pkg_id = jQuery('form#submit_form #pkg_id').val();
		jQuery.ajax({
			type: 'POST',
			dataType: 'json',
			url: ajaxUrl,
			data:'action=ajaxlogin&username='+username+'&password='+password+'&security='+ security+'&pkg_id='+pkg_id+'&'+submit_from,			
			success: function(data){
				if(data.loggedin)
				{					
					user_login = true;
					currentStep = 'auth';
					jQuery('div#step-auth').addClass('complete');
					submit_form_button = 1;
					jQuery('p.status').css('display','block');
					jQuery('p.status').text(data.message);
					jQuery('#common_error,.common_error_not_login').html('');
					
					jQuery('#loginform').css('display','none');
					jQuery( "#login_user_meta" ).remove();
				}
				else
				{
					jQuery('p.status').css('display','block');
					jQuery('p.status').css('color','red');
					jQuery('p.status').text(data.message);
				}
				if(submit_form_button == 1)
				{
					jQuery('#submit_form_button').trigger('click');
				}
			}
		});
		e.preventDefault();
	});
        
    /*jquery to go to next step while registration on submit form*/
    jQuery('form#submit_form #register_form').bind('click',function(){
        reg_name = jQuery('#user_fname_already_exist').val();
        reg_email = jQuery('#user_email_already_exist').val();
	if(reg_name==1 && reg_email==1){
            user_login = true;
            currentStep = 'auth';
            jQuery('div#step-auth').addClass('complete');
            jQuery('#submit_form').submit();
		
	}
    });
    
    /*jquery to go to next step while registration on submit form*/
    jQuery('.step_enter_detail').bind('click',function(){
        
        jQuery('#post').css("display", "block");
        if(parseInt(jQuery('#step-auth').length) !== 0 ){
            jQuery('#auth').css("display", "none");
        }
    });
    
    
    /* Get the selected category id from input checkbox type*/
    jQuery("#submit_form input[name^='category']").change(function(){
            var a = jQuery("#submit_form input[name='category[]']");
            if(a.length == a.filter(":checked").length){
                    jQuery("#submit_form #selectall").prop('checked', true);
            }else{
                    jQuery("#submit_form #selectall").prop('checked', false);
            }
    });
});
/* Display select all category function on submit page */
function displaychk(){ 
	dml=document.forms['submit_form'];
	chk = document.getElementsByName('category[]');
	len = chk.length;
	if(document.getElementById("selectall").checked  == true) {
		for (i = 0; i < len; i++)
			chk[i].checked = true ;
		
		jQuery('#category_error').html("");
		jQuery('#category_error').removeClass('message_error2');	
	} else {
		for (i = 0; i < len; i++)
		chk[i].checked = false ;
	}
}


/*User Login/register related script */
jQuery.noConflict();
var checkclick = false;
var reg_email= 0;
var reg_name = 0;
var chkemailRequest=null;
var chknameRequest=null;
function chkemail(e)
{        
    e = 'submit_form';
    if (jQuery("#" + e + " #user_email").val()) {
        var t = jQuery("#" + e + " #user_email").val()
    }
    jQuery("#" + e + " .user_email_spin").remove();
    jQuery("#" + e + " input#user_email").css("display", "inline");
    jQuery("#" + e + " input#user_email").after("<i class='fa fa-circle-o-notch fa-spin user_email_spin ajax-fa-spin'></i>");
    chkemailRequest = jQuery.ajax({
        url: ajaxUrl,
        type: "POST",
        async: true,
        data: "action=tmpl_video_ajax_check_user_email&user_email=" + t,
        beforeSend: function() {
            if (chkemailRequest != null) {
                chkemailRequest.abort()
            }
        },
        success: function(t) {
            var n = t.split(",");
            if (n[1] == "email") {
                if (n[0] > 0) {
                    jQuery("#" + e + " #user_email_error").html(user_email_error);
                    jQuery("#" + e + " #user_email_already_exist").val(0);
                    jQuery("#" + e + " #user_email_error").removeClass("available_tick");
                    jQuery("#" + e + " #user_email_error").addClass("message_error2");
                    reg_email = 0
                } else {
                    jQuery("#" + e + " #user_email_error").html(user_email_verified);
                    jQuery("#" + e + " #user_email_already_exist").val(1);
                    jQuery("#" + e + " #user_email_error").addClass("available_tick");
                    jQuery("#" + e + " #user_email_error").removeClass("message_error2");
                    reg_email = 1
                }
            }
            jQuery("#" + e + " .user_email_spin").remove()
        }
    });
    return true
}
function chkname(e){
    if (jQuery("#" + e + " #user_fname").val()) {
        var t = jQuery("#" + e + " #user_fname").val()
    }
    jQuery("#" + e + " .user_fname_spin").remove();
    jQuery("#" + e + " input#user_fname").css("display", "inline");
    jQuery("#" + e + " input#user_fname").after("<i class='fa fa-circle-o-notch fa-spin user_fname_spin ajax-fa-spin'></i>");
    chknameRequest = jQuery.ajax({
        url: ajaxUrl,
        type: "POST",
        async: true,
        data: "action=tmpl_video_ajax_check_user_email&user_fname=" + t,
        beforeSend: function() {
            if (chknameRequest != null) {
                chknameRequest.abort()
            }
        },
        success: function(t) {
            var n = t.split(",");
            if (n[1] == "fname") {
                if (n[0] > 0) {
                    jQuery("#" + e + " #user_fname_error").html(user_fname_error);
                    jQuery("#" + e + " #user_fname_already_exist").val(0);
                    jQuery("#" + e + " #user_fname_error").addClass("message_error2");
                    jQuery("#" + e + " #user_fname_error").removeClass("available_tick");
                    reg_name = 0
                } else {
                    jQuery("#" + e + " #user_fname_error").html(user_fname_verified);
                    jQuery("#" + e + " #user_fname_already_exist").val(1);
                    jQuery("#" + e + " #user_fname_error").removeClass("message_error2");
                    jQuery("#" + e + " #user_fname_error").addClass("available_tick");
                    if (jQuery("" + e + " #userform div").size() == 2 && checkclick) {
                        document.userform.submit()
                    }
                    reg_name = 1
                }
            }
            jQuery("#" + e + " .user_fname_spin").remove()
        }
    });
    return true
}


function set_login_registration_frm(val)
{
	if(val=='existing_user')
	{
		document.getElementById('login_user_meta').style.display = 'none';
		document.getElementById('login_user_frm_id').style.display = '';
		document.getElementById('login_type').value = val;
	}else  //new_user
	{
		document.getElementById('login_user_meta').style.display = 'block';
		document.getElementById('login_user_frm_id').style.display = 'none';
		document.getElementById('login_type').value = val;
	}
}