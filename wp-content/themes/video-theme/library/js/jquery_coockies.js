// JavaScript Document
/**
 * Cookie plugin
 *
 * Copyright (c) 2006 Klaus Hartl (stilbuero.de)
 * Dual licensed under the MIT and GPL licenses:
 * http://www.opensource.org/licenses/mit-license.php
 * http://www.gnu.org/licenses/gpl.html
 *
 */
/**
 * Create a cookie with the given name and value and other optional parameters.
 *
 * @name $.cookie
 * @cat Plugins/Cookie
 * @author Klaus Hartl/klaus.hartl@stilbuero.de
 */
jQuery.cookie = function(name, value, options) {
    if (typeof value != 'undefined') { // name and value given, set cookie
        options = options || {};
        if (value === null) {
            value = '';
            options.expires = -1;
        }
        var expires = '';
        if (options.expires && (typeof options.expires == 'number' || options.expires.toUTCString)) {
            var date;
            if (typeof options.expires == 'number') {
                date = new Date();
                date.setTime(date.getTime() + (options.expires * 24 * 60 * 60 * 1000));
            } else {
                date = options.expires;
            }
            expires = '; expires=' + date.toUTCString(); // use expires attribute, max-age is not supported by IE
        }
        // CAUTION: Needed to parenthesize options.path and options.domain
        // in the following expressions, otherwise they evaluate to undefined
        // in the packed version for some reason...
        var path = options.path ? '; path=' + (options.path) : '';
        var domain = options.domain ? '; domain=' + (options.domain) : '';
        var secure = options.secure ? '; secure' : '';
        document.cookie = [name, '=', encodeURIComponent(value), expires, path, domain, secure].join('');
    } else { // only name given, get cookie
        var cookieValue = null;
        if (document.cookie && document.cookie != '') {
            var cookies = document.cookie.split(';');
            for (var i = 0; i < cookies.length; i++) {
                var cookie = jQuery.trim(cookies[i]);
                // Does this cookie string begin with the name we want?
                if (cookie.substring(0, name.length + 1) == (name + '=')) {
                    cookieValue = decodeURIComponent(cookie.substring(name.length + 1));
                    break;
                }
            }
        }
        return cookieValue;
    }
};
jQuery(function() {
	var cc = jQuery.cookie('display_view');	

	if (cc == 'grid') {	
		jQuery('#video-cat-content').removeClass('list');
		jQuery('#video-cat-content').addClass('grid');
		jQuery('#video-cat-content').css('display','block');

		jQuery("#gridview").addClass("active button");
		
	}else if(cc == 'list'){		
		jQuery('#video-cat-content').removeClass('grid');
		jQuery('#video-cat-content').addClass('list');
		jQuery('#video-cat-content').css('display','block');
		
		jQuery("#listview").addClass("active button");
		jQuery("#gridview").removeClass("active");
		
	}
});
jQuery(document).ready(function() {
	
	jQuery('.viewsbox a#listview').click(function(e){
		e.preventDefault();	
		jQuery('#video-cat-content').removeClass('grid');
		jQuery('#video-cat-content').addClass('list');
	
		jQuery('.viewsbox a').attr('class','');
		jQuery(this).attr('class','active');
		
		jQuery('.viewsbox a.gridview').attr('class','');
		jQuery.cookie("display_view", "list",{ path: '/' });
		jQuery("#listview").addClass("button");
		jQuery("#gridview").addClass("button");
		
	});
	jQuery('.viewsbox a#gridview').click(function(e){	
		e.preventDefault();		
		
		jQuery('#video-cat-content').removeClass('list');
		jQuery('#video-cat-content').addClass('grid');
		
		
		
		jQuery('.viewsbox a').attr('class','');
		jQuery(this).attr('class','active');
		
		jQuery('.viewsbox .listview a').attr('class','');
		jQuery.cookie("display_view", "grid",{ path: '/' });
		jQuery("#listview").addClass("button");
		jQuery("#gridview").addClass("button");
	});
	
});
/*Start sorting option script */
