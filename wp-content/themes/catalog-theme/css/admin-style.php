<?php ob_start();
	$file = dirname(__FILE__);
	$file = substr($file,0,stripos($file, "wp-content"));
	require($file . "/wp-load.php");
	global $wpdb;
	if(function_exists('hybrid_get_setting')){
		$color1 = hybrid_get_setting( 'color_picker_color1' );
		$color2 = hybrid_get_setting( 'color_picker_color2' );
		$color3 = hybrid_get_setting( 'color_picker_color3' );
		$color4 = hybrid_get_setting( 'color_picker_color4' );
		$color5 = hybrid_get_setting( 'color_picker_color5' );
		$color6 = hybrid_get_setting( 'color_picker_color6' );
	}else{
		$supreme_theme_settings = get_option('supreme_theme_settings');
		$color1 = $supreme_theme_settings[ 'color_picker_color1' ];
		$color2 = $supreme_theme_settings[ 'color_picker_color2' ];
		$color3 = $supreme_theme_settings[ 'color_picker_color3' ];
		$color4 = $supreme_theme_settings[ 'color_picker_color4' ];
		$color5 = $supreme_theme_settings[ 'color_picker_color5' ];
		$color6 = $supreme_theme_settings[ 'color_picker_color6' ];
	}

if($color1 != "#" || $color1 != ""){?>
    
	.cart_checkout .button, a.checkout-button, .subscribe_cont .replace, .checkout-button, 
	button:hover, input[type="reset"]:hover, input[type="submit"]:hover, input[type="button"]:hover, .button:hover, .checkout-button:hover, .pagination .current, .comment-pagination .current, .bbp-pagination .current, .loop-nav span.previous:hover, .loop-nav span.next:hover, .pagination .page-numbers:hover, .comment-pagination .page-numbers:hover, .bbp-pagination .page-numbers:hover, .social_media_list li a:hover {
	    background: <?php echo $color1;?>;
	}
	.nav_bg, .variations_button button, .cart button, .quantity input.plus, .quantity input.minus, .product-content .woocommerce_tabs ul.tabs li a:hover, .product-content .woocommerce_tabs ul.tabs li.active a {
	    background-color: <?php echo $color1;?>;
	}
	a:hover {
	    color: <?php echo $color1;?>;
	}
  
    
<?php }



if($color2 != "#" || $color2 != ""){?>

	button, input[type="reset"], input[type="submit"], input[type="button"], .button, .product-content .woocommerce_tabs ul.tabs li a, .loop-nav span.previous, .loop-nav span.next, .pagination .page-numbers, .comment-pagination .page-numbers, .bbp-pagination .page-numbers, .social_media_list li a, .sidebar .bbp_widget_login .bbp-logged-in .logout-link, .quantity input.plus, .quantity input.minus,
	div#menu-secondary .menu li li a:hover, div#menu-subsidiary .menu li li a:hover, div#menu-secondary .menu li li.current-menu-item li a:hover, div#menu-subsidiary .menu li li.current-menu-item li a:hover, div#menu-secondary .menu li li.current-menu-item a, div#menu-subsidiary .menu li li.current-menu-item a {
	    background: <?php echo $color2;?>;
	}
	.variations_button button:hover, .cart_checkout .button:hover {
	    background-color: <?php echo $color2;?>;
	}
	a {
	    color: <?php echo $color2;?>;
	}

<?php }

 
if($color3 != "#" || $color3 != ""){?>

 	.footerbg { background-color: <?php echo $color3;?>; }

<?php }




if($color4 != "#" || $color4 != ""){?>

	body, 
	.header_bg a,
	h1, h2, h3, h4, h5, h6,
	.mega-menu ul.mega li a:hover, .mega-menu ul.mega li:hover a
	    { color: <?php echo $color4;?> !important; }

<?php }


if($color5 != "#" || $color5 != ""){?>

    body,
    .sidebar a, 
    .header_bg a,
    #container a,
    .mega-menu ul.mega li a:hover,
    .mega-menu ul.mega li:hover a,
    .flex-slides .post_content span a,
    #container ul.products li.product h3 a.post_img
    { color: <?php echo $color5;?> !important; }

<?php }



$color_data = ob_get_contents();
ob_clean();
if(isset($color_data) && $color_data !=''){?>
	<style type="text/css">
		<?php echo $color_data;?>
	</style>
<?php 
}
?>