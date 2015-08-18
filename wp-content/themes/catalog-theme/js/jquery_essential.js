jQuery.noConflict();

jQuery(document).ready(function() { 

jQuery('ul.browse_by_category li:has(> ul)').addClass('hasChildren');
jQuery('#content ul.thumb_view li:nth-child(3n+3)').addClass('last_thumb');
jQuery('#content ul.thumb_view li:nth-child(3n+3)').after('<div class="clearfix"></div>');
//jQuery('#content ul.realated_products .clearfix').remove();
//jQuery('ul.browse_by_category li').css({'background':'url('+img_url_plus+')','background-repeat': 'no-repeat'});
jQuery('ul.browse_by_category li.hasChildren').mouseenter(function () {

	jQuery(this).addClass('heyHover').children('ul').slideDown('fast');	
	//jQuery(this).css({'background':'url('+img_url_minus+')','background-repeat': 'no-repeat'});
	
	return false;

});
jQuery('ul.browse_by_category li.hasChildren:not(:has(> ul > li.current-cat))').mouseleave(function () {

	jQuery(this).removeClass('heyHover').children('ul').slideUp('fast');	
	//jQuery(this).css({'background':'url('+img_url_plus+')','background-repeat': 'no-repeat'});
	return false;

});
jQuery('ul.browse_by_category li ul:has(> li.current-cat)').css({'display':'block'});
jQuery('ul.browse_by_category li:has(> ul li.current-cat)').addClass('heyHover');

// Tabs code on registration page
jQuery('.active_tab').fadeIn();
jQuery('.tab_link').live('click', function(event){

	event.preventDefault();
	
	jQuery('.tab_link_selected').removeClass('tab_link_selected');
	
	jQuery(this).addClass('tab_link_selected');

	var container_id = jQuery(this).attr('title');
	
	jQuery('.active_tab').animate({ 
		
		opacity : 'toggle' 
		
	},function(){
	
		jQuery(this).removeClass('active_tab');
		
		jQuery(container_id).addClass('active_tab');
		
		jQuery('.active_tab').animate({
		   
			opacity : 'toggle'
			
		});
	});
	
});

});
