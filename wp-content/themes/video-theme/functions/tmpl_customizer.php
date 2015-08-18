<?php
/*=========================== Load theme customization options ===========================================*/
global $prefix;
$prefix = 'templatic';
/* Load custom control classes. */
add_action( 'customize_register', 'templatic_customize_controls', 1 );
/* Register custom sections, settings, and controls. */
add_action( 'customize_register', 'tmpl_customize_register' );
/* Add the footer content Ajax to the correct hooks. */
add_action( 'wp_ajax_tmpl_customize_footer_content', 'tmpl_customize_footer_content_ajax' );
add_action( 'wp_ajax_nopriv_tmpl_customize_footer_content', 'tmpl_customize_footer_content_ajax' );

/**
Name :tmpl_default_theme_settings
Description : get theme default settings
 */
function tmpl_default_theme_settings() {
	/* Set up some default variables. */
	$settings = array();
	$prefix = 'templatic';
	/* Get theme-supported meta boxes for the settings page. */

	$settings['footer_insert'] =  '<p class="credit">' . __( '<a href="http://templatic.com/">Video</a> theme designed by <a href="http://templatic.com/">Templatic</a>.', 'templatic' ) . '</p>';
	
	/* Return the $settings array and provide a hook for overwriting the default settings. */
	return apply_filters( "{$prefix}_default_theme_settings", $settings );
}

/**
 * Registers custom sections, settings, and controls for the $wp_customize instance.
 *
 */
function tmpl_customize_register( $wp_customize ) {
	/* Get supported theme settings. */
	$supports = get_theme_support( 'templatic-core-theme-settings' );
	/* Get the theme prefix. */
	$prefix = 'templatic';
	/* Get the default theme settings. */
	$default_settings = tmpl_default_theme_settings();
	/* Add the footer section, setting, and control if theme supports the 'footer' setting. */

		/* Add the footer section. */
		$wp_customize->add_section(
			'tmpl-core-footer',
			array(
				'title' => 		esc_html__( 'Footer', 'templatic' ),
				'priority' => 	200,
				'capability' => 	'edit_theme_options'
			)
		);
		/* Add the 'footer_insert' setting. */
		$wp_customize->add_setting(
			"{$prefix}_theme_settings[footer_insert]",
			array(
				'label' => 		' HTML tags allow, enter whatever you want to display in footer section.',
				'default' => 		@$default_settings['footer_insert'],
				'type' => 			'option',
				'capability' => 		'edit_theme_options',
				'sanitize_callback' => 	'tmpl_customize_sanitize',
				'sanitize_js_callback' => 	'tmpl_customize_sanitize',
				'transport' => 		'postMessage',
			)
		);
		/* Add the textarea control for the 'footer_insert' setting. */
		$wp_customize->add_control(
			new Hybrid_Customize_Control_Textarea(
				$wp_customize,
				'tmpl-core-footer',
				array(
					'label' => 	 __('Footer', 'templatic' ),
					'section' => 	'tmpl-core-footer',
					'settings' => 	"{$prefix}_theme_settings[footer_insert]",
				)
			)
		);
	/* If viewing the customize preview screen, add a script to show a live preview. */
		if ( $wp_customize->is_preview() && !is_admin() )
			add_action( 'wp_footer', 'templatic_customize_preview_script', 21 );
	
}
/**
 * Sanitizes the footer content on the customize screen.  Users with the 'unfiltered_html' cap can post 
 * anything.  For other users, wp_filter_post_kses() is ran over the setting.
 * @param mixed $setting The current setting passed to sanitize.
 * @param object $object The setting object passed via WP_Customize_Setting.
 * @return mixed $setting
 */
function tmpl_customize_sanitize( $setting, $object ) {
	/* Get the theme prefix. */
	$prefix = 'templatic';
	/* Make sure we kill evil scripts from users without the 'unfiltered_html' cap. */
	if ( "{$prefix}_theme_settings[footer_insert]" == $object->id && !current_user_can( 'unfiltered_html' )  )
		$setting = stripslashes( wp_filter_post_kses( addslashes( $setting ) ) );
	/* Return the sanitized setting and apply filters. */
	return apply_filters( "{$prefix}_customize_sanitize", $setting, $object );
}
/**
 * Runs the footer content posted via Ajax through the do_shortcode() function.  This makes sure the 
 * shortcodes are output correctly in the live preview.
 */
function tmpl_customize_footer_content_ajax() {
	/* Check the AJAX nonce to make sure this is a valid request. */
	check_ajax_referer( 'tmpl_customize_footer_content_nonce' );
	/* If footer content has been posted, run it through the do_shortcode() function. */
	if ( isset( $_POST['footer_content'] ) )
		echo do_shortcode( wp_kses_stripslashes( $_POST['footer_content'] ) );
	/* Always die() when handling Ajax. */
	die();
}
/**
 * Handles changing settings for the live preview of the theme.	
 */
function templatic_customize_preview_script() {
	/* Create a nonce for the Ajax. */
	$nonce = wp_create_nonce( 'tmpl_customize_footer_content_nonce' );
	?>
<script type="text/javascript">
	wp.customize(
		'<?php echo $prefix; ?>_theme_settings[footer_insert]',
		function( value ) {
			value.bind(
				function( to ) {
					jQuery.post( 
					'<?php echo admin_url( 'admin-ajax.php' ); ?>', 
					{ 
						action: 'tmpl_customize_footer_content',
						_ajax_nonce: '<?php echo $nonce; ?>',
						footer_content: to
					},
					function( response ) {
						jQuery( '.footer-content' ).html( response );
					}
					);
				}
			);
		}
	);
	</script>
<?php
}
/*
	@Theme Customizer settings for Wordpress customizer.
*/	
global $pagenow;
if(is_admin() && 'admin.php' == $pagenow){
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this section.','templatic' ) );
	}
}
/*	Add Action for Customizer   START	*/
	add_action( 'customize_register',  'templatic_register_customizer_settings');
/*	Add Action for Customizer   END	*/

/*	Function to create sections, settings, controls for wordpress customizer START.  */

/*
Name : templatic_register_customizer_settings
Description : register customizer settings option , it returns the options for theme->customizer.php
*/
function templatic_register_customizer_settings( $wp_customize ){

		$prefix ='templatic';
		/* add section for different controls in customizer start
		site title section settings start */
		$wp_customize->get_section('title_tagline')->priority = 5;
		/* site title section settings end
		add site logo section start */
		$wp_customize->add_section('templatic_logo_settings', array(
			'title' => 'Site Logo',
			'priority'=> 6
		));
		/* add site logo section finish
		add site bckground image section start */
		$wp_customize->add_section('templatic_background_settings', array(
			'title' => 'Background Images',
			'priority'=> 8
		));
		/* add site bckground image section finish */
		$wp_customize->add_section('templatic_google_font_settings', array(
			'title' => 'Typography',
			'priority'=> 9
		));
		/* color section settings start*/
		$wp_customize->get_section('colors')->title = __( 'Colors ' ,'templatic');
		$wp_customize->get_section('colors')->priority = 7;
		/* color section settings end header image section settings start */
		$wp_customize->get_section('header_image')->priority = 10;
		/* header image section settings end navigation menu section settings start */
		$wp_customize->get_section('nav')->priority = 11;
		/* navigation menu section settings end background section settings start */
		$wp_customize->get_section('background_image')->title = __( 'Background Settings','templatic' );
		$wp_customize->get_section('background_image')->priority = 12;
		/* background section settings end static front page section settings start */
		$wp_customize->get_section('static_front_page')->priority = 13;
		/* static front page section settings end
		supreme core footer section settings start */
		//$wp_customize->get_section('tmpl-core-footer')->priority = 17;
		/* supreme core footer section settings end */
		
	/* add section for different controls in customizer finish */
			
	/*	Add Settings START */
		
		//add settings for site logo start
		//CALLBACK FUNCTION: templatic_customize_tmpl_logo_url
		$wp_customize->add_setting($prefix.'_theme_settings[tmpl_logo_url]',array(
			'default' => '',
			'type' => 'option',
			'capabilities' => 'edit_theme_options',
			'sanitize_callback' => 	"templatic_customize_tmpl_logo_url",
			'sanitize_js_callback' => 	"templatic_customize_tmpl_logo_url",
			//'transport' => 'postMessage',
		));
		//add settings for site logo finish
		
		//add settings for favicon icon start
		//callback function: templatic_customize_tmpl_favicon_icon
		$wp_customize->add_setting($prefix.'_theme_settings[tmpl_favicon_icon]',array(
			'default' => '',
			'type' => 'option',
			'capabilities' => 'edit_theme_options',
			'sanitize_callback' => 	"templatic_customize_tmpl_favicon_icon",
			'sanitize_js_callback' => 	"templatic_customize_tmpl_favicon_icon",
			//'transport' => 'postMessage',
		));
		//ADD SETTINGS FOR FAVICON ICON FINISH
		
		
		//callback function: templatic_customize_tmpl_header_background_image_url
		$wp_customize->add_setting($prefix.'_theme_settings[tmpl_header_background_image_url]',array(
			'default' => '',
			'type' => 'option',
			'capabilities' => 'edit_theme_options',
			'sanitize_callback' => 	"templatic_customize_tmpl_header_background_image_url",
			'sanitize_js_callback' => 	"templatic_customize_tmpl_header_background_image_url"
		));
		//add settings for header background image finish
		
		//add settings for favicon icon start
		//CALLBACK FUNCTION: templatic_customize_tmpl_body_background_image_url
		$wp_customize->add_setting($prefix.'_theme_settings[tmpl_body_background_image_url]',array(
			'default' => '',
			'type' => 'option',
			'capabilities' => 'edit_theme_options',
			'sanitize_callback' => 	"templatic_customize_tmpl_body_background_image_url",
			'sanitize_js_callback' => 	"templatic_customize_tmpl_body_background_image_url"
		));
		//add settings for body background image finish
		
		$wp_customize->add_setting($prefix.'_theme_settings[tmpl_google_fonts]',array(
			'default' => '',
			'type' => 'option',
			'capabilities' => 'edit_theme_options',
			'sanitize_callback' => 	"templatic_customize_tmpl_google_fonts",
			'sanitize_js_callback' => 	"templatic_customize_tmpl_google_fonts",
			//'transport' => 'postMessage',
		));
		
		$wp_customize->add_setting($prefix.'_theme_settings[tmpl_fonts_size]',array(
			'default' => '',
			'type' => 'option',
			'capabilities' => 'edit_theme_options',
			'sanitize_callback' => 	"templatic_customize_tmpl_fonts_size",
			'sanitize_js_callback' => 	"templatic_customize_tmpl_fonts_size",
			//'transport' => 'postMessage',
		));
		
		//add settings for hide/show site description start
		//callback function: templatic_customize_theme_site_description
		$wp_customize->add_setting($prefix.'_theme_settings[theme_site_description]',array(
			'default' => '',
			'type' => 'option',
			'capabilities' => 'edit_theme_options',
			'sanitize_callback' => 	'templatic_customize_theme_site_description',
			'sanitize_js_callback' => 	'templatic_customize_theme_site_description',
			
			//'transport' => 'postMessage',
		));
		//add settings for hide/show site description finish
			
		$wp_customize->add_setting($prefix.'_theme_settings[footer_lbl]', array(
	        'default' => '',
		));
		// added custom label control finish
		
		//color settings start.
		$wp_customize->add_setting($prefix.'_theme_settings[color_picker_color1]',array(
				'default' => '',
				'type' => 'option',
				'capabilities' => 'edit_theme_options',
				'sanitize_callback' => 	"templatic_customize_theme_color1",
				'sanitize_js_callback' => 	"templatic_customize_theme_color1",
				//'transport' => 'postMessage',
			));
			
			$wp_customize->add_setting($prefix.'_theme_settings[color_picker_color2]',array(
				'default' => '',
				'type' => 'option',
				'capabilities' => 'edit_theme_options',
				'sanitize_callback' => 	"templatic_customize_theme_color2",
				'sanitize_js_callback' => 	"templatic_customize_theme_color2",
				//'transport' => 'postMessage',
			));
			
			$wp_customize->add_setting($prefix.'_theme_settings[color_picker_color3]',array(
				'default' => '',
				'type' => 'option',
				'capabilities' => 'edit_theme_options',
				'sanitize_callback' => 	"templatic_customize_theme_color3",
				'sanitize_js_callback' => 	"templatic_customize_theme_color3",
				//'transport' => 'postMessage',
			));
			
			$wp_customize->add_setting($prefix.'_theme_settings[color_picker_color4]',array(
				'default' => '',
				'type' => 'option',
				'capabilities' => 'edit_theme_options',
				'sanitize_callback' => 	"templatic_customize_theme_color4",
				'sanitize_js_callback' => 	"templatic_customize_theme_color4",
				//'transport' => 'postMessage',
			));
			
			$wp_customize->add_setting($prefix.'_theme_settings[color_picker_color5]',array(
				'default' => '',
				'type' => 'option',
				'capabilities' => 'edit_theme_options',
				'sanitize_callback' => 	"templatic_customize_theme_color5",
				'sanitize_js_callback' => 	"templatic_customize_theme_color5",
				//'transport' => 'postMessage',
			));
			
			
		//color settings finish.
		
		//texture settings start.
		$wp_customize->add_setting($prefix.'_theme_settings[templatic_texture1]',array(
				'default' => '',
				'type' => 'option',
				'capabilities' => 'edit_theme_options',
				'sanitize_callback' => 	"templatic_customize_templatic_texture1",
				'sanitize_js_callback' => 	"templatic_customize_templatic_texture1",
				//'transport' => 'postMessage',
		));
		
		$wp_customize->add_setting($prefix.'_theme_settings[alternate_of_texture]',array(
			'default' => '',
			'type' => 'option',
			'capabilities' => 'edit_theme_options',
			'sanitize_callback' => 	"templatic_customize_alternate_of_texture",
			'sanitize_js_callback' => 	"templatic_customize_alternate_of_texture",
			//'transport' => 'postMessage',
		));
		//texture settings finish.
				
		//add settings for background header image start
		//callback function: templatic_customize_supreme_header_background_image
		$wp_customize->add_setting( 'header_image', array(
			'default'        => get_theme_support( 'custom-header', 'default-image' ),
			'theme_supports' => 'custom-header',
		) );
		
		$wp_customize->add_setting($prefix.'_theme_settings[header_image_display]',array(
			'default' => 'after_nav',
			'type' => 'option',
			'capabilities' => 'edit_theme_options',
			'sanitize_callback' => 	"templatic_customize_header_image_display",
			'sanitize_js_callback' => 	"templatic_customize_header_image_display",
			//'transport' => 'postMessage',
		));
		//ADD SETTINGS FOR BACKGROUND HEADER IMAGE FINISH
		
		//Add settings for hide/show header text start
		$wp_customize->add_setting($prefix.'_theme_settings[display_header_text]',array(
			'default' => 1,
			'type' => 'option',
			'capabilities' => 'edit_theme_options',
			'sanitize_callback' => 	"templatic_customize_display_header_text",
			'sanitize_js_callback' => 	"templatic_customize_display_header_text",
			//'transport' => 'postMessage',
		));
		//Add settings for hide/show header text end
		
	/*	Add Settings END */
		
	/*	Add Control START */
		
		/* ADDED SITE LOGO CONTROL START
		//ARGS USAGES
		//label   : Text which you want to display for which this control is to be used. 
		//section : In which section you want to display this control
		//settings: Define the settings to call callback function */
		$wp_customize->add_control( new WP_Customize_Image_Control($wp_customize, $prefix.'_theme_settings[tmpl_logo_url]', array(
			'label' => __(' Upload image for logo','templatic'),
			'section' => 'templatic_logo_settings',
			'settings' => $prefix.'_theme_settings[tmpl_logo_url]',
		)));
		//added site logo control finish
		
		/* added site favicon icon control start
		//args usages
		//label   : Text which you want to display for which this control is to be used. 
		//section : In which section you want to display this control
		//settings: Define the settings to call callback function */
		$wp_customize->add_control( new WP_Customize_Image_Control($wp_customize, $prefix.'_theme_settings[tmpl_favicon_icon]', array(
			'label' => __(' Upload favicon icon','templatic'),
			'section' => 'templatic_logo_settings',
			'settings' => $prefix.'_theme_settings[tmpl_favicon_icon]',
		)));
		//ADDED SITE FAVICON ICON CONTROL FINISH
		$google_fonts = array(
						''	 => '',
						'Cantarell' => 'Cantarell',
						'Cardo' => 'Cardo',
						'Crimson+Text' => 'Crimson Text',
						'Droid+Sans' => 'Droid Sans',
						'Droid+Sans+Mono' => 'Droid Sans Mono',
						'Droid+Serif' => 'Droid Serif',
						'IM+Fell+DW+Pica' => 'IM Fell DW Pica',
						'Inconsolata' => 'Inconsolata',
						'Josefin+Sans' => 'Josefin Sans',
						'Josefin+Slab' => 'Josefin Slab',
						'Lobster' => 'Lobster',
						'Molengo' => 'Molengo',
						'Nobile' => 'Nobile',
						'OFL+Sorts+Mill+Goudy+TT' => 'OFL Sorts Mill Goudy TT',
						'Old+Standard+TT' => 'Old Standard TT',
						'Reenie+Beanie' => 'Reenie Beanie',
						'Tangerine' => 'Tangerine',
						'Vollkorn' => 'Vollkorn',
						'Yanone+Kaffeesatz' => 'Yanone Kaffeesatz',
						'Cuprum' => 'Cuprum',
						'Neucha' => 'Neucha',
						'Neuton' => 'Neuton',
						'PT+Sans' => 'PT Sans',
						'PT+Sans+Caption' => 'PT Sans Caption',
						'PT+Sans+Narrow' => 'PT Sans Narrow',
						'Philosopher' => 'Philosopher',
						'Allerta' => 'Allerta',
						'Allerta+Stencil' => 'Allerta Stencil',
						'Arimo' => 'Arimo',
						'Arvo' => 'Arvo',
						'Bentham' => 'Bentham',
						'Coda' => 'Coda',
						'Cousine' => 'Cousine',
						'Covered+By+Your+Grace' => 'Covered By Your Grace',
						'Geo' => 'Geo',
						'Just+Me+Again+Down+Here' => 'Just Me Again Down Here',
						'Puritan' => 'Puritan',
						'Raleway' => 'Raleway',
						'Tinos' => 'Tinos',
						'UnifrakturCook' => 'UnifrakturCook',
						'UnifrakturMaguntia' => 'UnifrakturMaguntia',
						'Mountains+of+Christmas' => 'Mountains of Christmas',
						'Lato' => 'Lato',
						'Orbitron' => 'Orbitron',
						'Allan' => 'Allan',
						'Anonymous+Pro' => 'Anonymous Pro',
						'Copse' => 'Copse',
						'Kenia' => 'Kenia',
						'Ubuntu' => 'Ubuntu',
						'Vibur' => 'Vibur',
						'Sniglet' => 'Sniglet',
						'Syncopate' => 'Syncopate',
						'Cabin' => 'Cabin',
						'Merriweather' => 'Merriweather',
						'Maiden+Orange' => 'Maiden Orange',
						'Just+Another+Hand' => 'Just Another Hand',
						'Kristi' => 'Kristi',
						'Corben' => 'Corben',
						'Gruppo' => 'Gruppo',
						'Buda' => 'Buda',
						'Lekton' => 'Lekton',
						'Luckiest+Guy' => 'Luckiest Guy',
						'Crushed' => 'Crushed',
						'Chewy' => 'Chewy',
						'Coming Soon' => 'Coming Soon',
						'Crafty+Girls' => 'Crafty Girls',
						'Fontdiner+Swanky' => 'Fontdiner Swanky',
						'Permanent+Marker' => 'Permanent Marker',
						'Rock+Salt' => 'Rock Salt',
						'Sunshiney' => 'Sunshiney',
						'Unkempt' => 'Unkempt',
						'Calligraffitti' => 'Calligraffitti',
						'Cherry+Cream+Soda' => 'Cherry Cream Soda',
						'Homemade+Apple' => 'Homemade Apple',
						'Irish+Growler' => 'Irish Growler',
						'Kranky' => 'Kranky',
						'Schoolbell' => 'Schoolbell',
						'Slackey' => 'Slackey',
						'Walter+Turncoat' => 'Walter Turncoat',
						'Radley' => 'Radley',
						'Meddon' => 'Meddon',
						'Kreon' => 'Kreon',
						'Dancing+Script' => 'Dancing Script',
						'Goudy+Bookletter+1911' => 'Goudy Bookletter 1911',
						'PT+Serif+Caption' => 'PT Serif Caption',
						'PT+Serif' => 'PT Serif',
						'Astloch' => 'Astloch',
						'Bevan' => 'Bevan',
						'Anton' => 'Anton',
						'Expletus+Sans' => 'Expletus Sans',
						'VT323' => 'VT323',
						'Pacifico' => 'Pacifico',
						'Candal' => 'Candal',
						'Architects+Daughter' => 'Architects Daughter',
						'Indie+Flower' => 'Indie Flower',
						'League+Script' => 'League Script',
						'Quattrocento' => 'Quattrocento',
						'Amaranth' => 'Amaranth',
						'Irish+Grover' => 'Irish Grover',
						'Oswald' => 'Oswald',
						'EB+Garamond' => 'EB Garamond',
						'Nova+Round' => 'Nova Round',
						'Nova+Slim' => 'Nova Slim',
						'Nova+Script' => 'Nova Script',
						'Nova+Cut' => 'Nova Cut',
						'Nova+Mono' => 'Nova Mono',
						'Nova+Oval' => 'Nova Oval',
						'Nova+Flat' => 'Nova Flat',
						'Terminal+Dosis+Light' => 'Terminal Dosis Light',
						'Michroma' => 'Michroma',
						'Miltonian' => 'Miltonian',
						'Miltonian+Tattoo' => 'Miltonian Tattoo',
						'Annie+Use+Your+Telescope' => 'Annie Use Your Telescope',
						'Dawning+of+a+New+Day' => 'Dawning of a New Day',
						'Sue+Ellen+Francisco' => 'Sue Ellen Francisco',
						'Waiting+for+the+Sunrise' => 'Waiting for the Sunrise',
						'Special+Elite' => 'Special Elite',
						'Quattrocento+Sans' => 'Quattrocento Sans',
						'Smythe' => 'Smythe',
						'The+Girl+Next+Door' => 'The Girl Next Door',
						'Aclonica' => 'Aclonica',
						'News+Cycle' => 'News Cycle',
						'Damion' => 'Damion',
						'Wallpoet' => 'Wallpoet',
						'Over+the+Rainbow' => 'Over the Rainbow',
						'MedievalSharp' => 'MedievalSharp',
						'Six+Caps' => 'Six Caps',
						'Swanky+and+Moo+Moo' => 'Swanky and Moo Moo',
						'Bigshot+One' => 'Bigshot One',
						'Francois+One' => 'Francois One',
						'Sigmar+One' => 'Sigmar One',
						'Carter+One' => 'Carter One',
						'Holtwood+One+SC' => 'Holtwood One SC',
						'Paytone+One' => 'Paytone One',
						'Monofett' => 'Monofett',
						'Rokkitt' => 'Rokkitt',
						'Megrim' => 'Megrim',
						'Judson' => 'Judson',
						'Didact+Gothic' => 'Didact Gothic',
						'Play' => 'Play',
						'Ultra' => 'Ultra',
						'Metrophobic' => 'Metrophobic',
						'Mako' => 'Mako',
						'Shanti' => 'Shanti',
						'Caudex' => 'Caudex',
						'Jura' => 'Jura',
						'Ruslan+Display' => 'Ruslan Display',
						'Brawler' => 'Brawler',
						'Nunito' => 'Nunito',
						'Wire+One' => 'Wire One',
						'Podkova' => 'Podkova',
						'Muli' => 'Muli',
						'Maven+Pro' => 'Maven Pro',
						'Tenor+Sans' => 'Tenor Sans',
						'Limelight' => 'Limelight',
						'Playfair+Display' => 'Playfair Display',
						'Artifika' => 'Artifika',
						'Lora' => 'Lora',
						'Kameron' => 'Kameron',
						'Cedarville+Cursive' => 'Cedarville Cursive',
						'Zeyada' => 'Zeyada',
						'La+Belle+Aurore' => 'La Belle Aurore',
						'Shadows+Into+Light' => 'Shadows Into Light',
						'Lobster+Two' => 'Lobster Two',
						'Nixie+One' => 'Nixie One',
						'Redressed' => 'Redressed',
						'Bangers' => 'Bangers',
						'Open+Sans+Condensed' => 'Open Sans Condensed',
						'Open+Sans' => 'Open Sans',
						'Varela' => 'Varela',
						'Goblin+One' => 'Goblin One',
						'Asset' => 'Asset',
						'Gravitas+One' => 'Gravitas One',
						'Hammersmith+One' => 'Hammersmith One',
						'Stardos+Stencil' => 'Stardos Stencil',
						'Love+Ya+Like+A+Sister' => 'Love+Ya+Like+A+Sister',
						'Loved+by+the+King' => 'Loved by the King',
						'Bowlby+One+SC' => 'Bowlby One SC',
						'Forum' => 'Forum',
						'Patrick+Hand' => 'Patrick Hand',
						'Varela+Round' => 'Varela Round',
						'Yeseva+One' => 'Yeseva One',
						'Give+You+Glory' => 'Give You Glory',
						'Modern+Antiqua' => 'Modern Antiqua',
						'Bowlby+One' => 'Bowlby One',
						'Tienne' => 'Tienne',
						'Istok+Web' => 'Istok Web',
						'Yellowtail' => 'Yellowtail',
						'Pompiere' => 'Pompiere',
						'Unna' => 'Unna',
						'Rosario' => 'Rosario',
						'Leckerli+One' => 'Leckerli One',
						'Snippet' => 'Snippet',
						'Ovo' => 'Ovo',
						'IM+Fell+English' => 'IM Fell English',
						'IM+Fell+English+SC' => 'IM Fell English SC',
						'Gloria+Hallelujah' => 'Gloria Hallelujah',
						'Kelly+Slab' => 'Kelly Slab',
						'Black+Ops+One' => 'Black Ops One',
						'Carme' => 'Carme',
						'Aubrey' => 'Aubrey',
						'Federo' => 'Federo',
						'Delius' => 'Delius',
						'Rochester' => 'Rochester',
						'Rationale' => 'Rationale',
						'Abel' => 'Abel',
						'Marvel' => 'Marvel',
						'Actor' => 'Actor',
						'Delius+Swash+Caps' => 'Delius Swash Caps',
						'Smokum' => 'Smokum',
						'Tulpen+One' => 'Tulpen One',
						'Coustard' => 'Coustard',
						'Andika' => 'Andika',
						'Alice' => 'Alice',
						'Questrial' => 'Questrial',
						'Comfortaa' => 'Comfortaa',
						'Geostar' => 'Geostar',
						'Geostar+Fill' => 'Geostar Fill',
						'Volkhov' => 'Volkhov',
						'Voltaire' => 'Voltaire',
						'Montez' => 'Montez',
						'Short+Stack' => 'Short Stack',
						'Vidaloka' => 'Vidaloka',
						'Aldrich' => 'Aldrich',
						'Numans' => 'Numans',
						'Days+One' => 'Days One',
						'Gentium+Book+Basic' => 'Gentium Book Basic',
						'Monoton' => 'Monoton',
						'Alike' => 'Alike',
						'Delius+Unicase' => 'Delius Unicase',
						'Abril+Fatface' => 'Abril Fatface',
						'Dorsa' => 'Dorsa',
						'Antic' => 'Antic',
						'Passero+One' => 'Passero One',
						'Merienda+One' => 'Merienda One',
						'Changa+One' => 'Changa One',
						'Julee' => 'Julee',
						'Prata' => 'Prata',
						'Adamina' => 'Adamina',
						'Sorts+Mill+Goudy' => 'Sorts Mill Goudy',
						'Terminal+Dosis' => 'Terminal Dosis',
						'Sansita+One' => 'Sansita One',
						'Chivo' => 'Chivo',
						'Spinnaker' => 'Spinnaker',
						'Poller+One' => 'Poller One',
						'Alike+Angular' => 'Alike Angular',
						'Gochi+Hand' => 'Gochi Hand',
						'Poly' => 'Poly',
						'Andada' => 'Andada',
						'Federant' => 'Federant',
						'Ubuntu+Condensed' => 'Ubuntu Condensed',
						'Ubuntu+Mono' => 'Ubuntu Mono',
						'Sancreek' => 'Sancreek',
						'Coda' => 'Coda',
						'Rancho' => 'Rancho',
						'Satisfy' => 'Satisfy',
						'Pinyon+Script' => 'Pinyon Script',
						'Vast+Shadow' => 'Vast Shadow',
						'Marck+Script' => 'Marck Script',
						'Salsa' => 'Salsa',
						'Amatic+SC' => 'Amatic SC',
						'Quicksand' => 'Quicksand',
						'Linden+Hill' => 'Linden Hill',
						'Corben' => 'Corben',
						'Creepster+Caps' => 'Creepster Caps',
						'Butcherman+Caps' => 'Butcherman Caps',
						'Eater+Caps' => 'Eater Caps',
						'Nosifer+Caps' => 'Nosifer Caps',
						'Atomic+Age' => 'Atomic Age',
						'Contrail+One' => 'Contrail One',
						'Jockey+One' => 'Jockey One',
						'Cabin+Sketch' => 'Cabin Sketch',
						'Cabin+Condensed' => 'Cabin Condensed',
						'Fjord+One' => 'Fjord One',
						'Rametto+One' => 'Rametto One',
						'Mate' => 'Mate',
						'Mate+SC' => 'Mate SC',
						'Arapey' => 'Arapey',
						'Supermercado+One' => 'Supermercado One',
						'Petrona' => 'Petrona',
						'Lancelot' => 'Lancelot',
						'Convergence' => 'Convergence',
						'Cutive' => 'Cutive',
						'Karla' => 'Karla',
						'Bitter' => 'Bitter',
						'Asap' => 'Asap',
						'Bree+Serif' => 'Bree Serif'
					);
		asort($google_fonts);
		foreach ($google_fonts as $key => $val) {
			$google_fonts_array[$key] = $val;
		}		
		$wp_customize->add_control(
				'example_select_box',
				array(
					'settings' => $prefix.'_theme_settings[tmpl_google_fonts]',
					'type' => 'select',
					'label' => 'Google Fonts',
					'section' => 'templatic_google_font_settings',
					'choices' => $google_fonts_array,
				)
			);
		
		
		$wp_customize->add_control(
				'font_select_box',
				array(
					'settings' => $prefix.'_theme_settings[tmpl_fonts_size]',
					'type' => 'select',
					'label' => 'Font Size',
					'section' => 'templatic_google_font_settings',
					'choices' => array(
						''	 => '',
						'10' => '10 px',
						'11' => '11 px',
						'12' => '12 px',
						'13' => '13 px',
						'14' => '14 px',
						'15' => '15 px',
						'16' => '16 px',
						'17' => '17 px',
						'18' => '18 px',
						'19' => '19 px',
						'20' => '20 px'
					),
				)
			);
		
		
		/* settings: Define the settings to call callback function */
		$wp_customize->add_control( new WP_Customize_Image_Control($wp_customize, $prefix.'_theme_settings[tmpl_header_background_image_url]', array(
			'label' => __(' Upload header background image','templatic'),
			'section' => 'templatic_background_settings',
			'settings' => $prefix.'_theme_settings[tmpl_header_background_image_url]',
		)));
		/* added site logo control finish */
		
		/* added site favicon icon control start
		//args usages
		//label   : Text which you want to display for which this control is to be used. 
		//section : In which section you want to display this control
		//settings: Define the settings to call callback function */
		$wp_customize->add_control( new WP_Customize_Image_Control($wp_customize, $prefix.'_theme_settings[tmpl_body_background_image_url]', array(
			'label' => __(' Upload body background image','templatic'),
			'section' => 'templatic_background_settings',
			'settings' => $prefix.'_theme_settings[tmpl_body_background_image_url]',
		)));
		
		
		
		
		/* added show/hide site description control start
		//args usages
		//label   : text which you want to display for which this control is to be used. 
		//section : In which section you want to display this control
		//settings: Define the settings to call callback function */
		//type    : Type of control you want to use
		$wp_customize->add_control( 'theme_site_description', array(
			'label' => __('Display Tagline','templatic'),
			'section' => 'title_tagline',
			'settings' => $prefix.'_theme_settings[theme_site_description]',
			'type' => 'checkbox',
			'priority' => 106
		));
		/* added show/hide site description control finish */
		
		$wp_customize->add_control( new templatic_custom_lable_control($wp_customize, $prefix.'_theme_settings[footer_lbl]', array(
			'label' => __('We would appreciate a link back. But you may change footer credit from here if you wish to','templatic'),
			'section' => 'tmpl-core-footer',
			'priority' => 1,
		)));
		
		/* Color Settings Control Start */
		/*
			Primary: 	 Effect on buttons, links and main headings.
			Secondary: 	 Effect on sub-headings.
			Content: 	 Effect on content.
			Sub-text: 	 Effect on sub-texts.
			Background:  Effect on body & menu background. 
		
		*/
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'color_picker_color1', array(
			'label'   => __( 'Body Background Color', 'templatic' ),
			'section' => 'colors',
			'settings'   => $prefix.'_theme_settings[color_picker_color1]',
			'priority' => 1,
		) ) );
		
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'color_picker_color2', array(
			'label'   => __( 'Content Color', 'templatic' ),
			'section' => 'colors',
			'settings'   => $prefix.'_theme_settings[color_picker_color2]',
			'priority' => 2,	
		) ) );
		
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'color_picker_color3', array(
			'label'   => __( 'Primary color', 'templatic' ),
			'section' => 'colors',
			'settings'   => $prefix.'_theme_settings[color_picker_color3]',
			'priority' => 3,
		) ) );
		
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'color_picker_color4', array(
			'label'   => __( 'Secondary Color', 'templatic' ),
			'section' => 'colors',
			'settings'   => $prefix.'_theme_settings[color_picker_color4]',
			'priority' => 4,
		) ) );
		
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'color_picker_color5', array(
			'label'   => __( 'Title Color', 'templatic' ),
			'section' => 'colors',
			'settings'   => $prefix.'_theme_settings[color_picker_color5]',
			'priority' => 5,
		) ) );
		
		
		/* remove wordpress default control start. */
		$wp_customize->remove_control('background_color');
		/* remove wordpress default control finish.
		color settings control end */
		
		$wp_customize->add_control( $prefix.'_theme_settings[alternate_of_texture]', array(
			'label' => __('OR Enter Your Custom Texture','templatic'),
			'section' => 'background_image',
			'settings' => $prefix.'_theme_settings[alternate_of_texture]',
			'type' => 'text',
		));
		
		/* add control for texture settings finish.
		//added header background image control start
		//args usages
		//label   : Text which you want to display for which this control is to be used. 
		//section : In which section you want to display this control
		//settings: Define the settings to call callback function */
		$wp_customize->add_control( new WP_Customize_Header_Image_Control( $wp_customize ) );
		
		$wp_customize->add_control( $prefix.'_theme_settings[header_image_display]', array(
			'label' => __('Display Header Image ( Go in Appearance -> Header to set/change the image )','templatic'),
			'section' => 'header_image',
			'settings' => $prefix.'_theme_settings[header_image_display]',
			'type' => 'select',
			'choices' => array(
								'before_nav' 	=> 'Before Secondary Menu',	
								'after_nav' 	=> 'After Secondary Menu',	
							  ),
		));
		
		/* added display header text control start
		//args usages
		//label   : Text which you want to display for which this control is to be used. 
		//section : In which section you want to display this control
		//settings: Define the settings to call callback function */
		$wp_customize->add_control( $prefix.'_theme_settings[display_header_text]', array(
			'label' => __('Display Site Title','templatic'),
			'section' => 'title_tagline',
			'settings' => $prefix.'_theme_settings[display_header_text]',
			'type' => 'checkbox',
			'priority' => 105,
		));
		
		/* added header background image control finish */
		$wp_customize->remove_control('header_textcolor');
		$wp_customize->remove_control('display_header_text');
	/*	Add Control END */
}
/*	Function to create sections, settings, controls for wordpress customizer END.  */
/*  Handles changing settings for the live preview of the theme START.  */	
	
	function templatic_customize_tmpl_logo_url( $setting, $object ) {
		$prefix ='templatic';
		/* Make sure we kill evil scripts from users without the 'unfiltered_html' cap. */
		if ( $prefix."_theme_settings[tmpl_logo_url]" == $object->id && !current_user_can( 'unfiltered_html' )  )
			$setting = stripslashes( wp_filter_post_kses( addslashes( $setting ) ) );
		/* Return the sanitized setting and apply filters. */
		return apply_filters( "templatic_customize_tmpl_logo_url", $setting, $object );
	}
	
	function templatic_customize_tmpl_favicon_icon( $setting, $object ) {
		$prefix ='templatic';
		/* Make sure we kill evil scripts from users without the 'unfiltered_html' cap. */
		if ( $prefix."_theme_settings[tmpl_favicon_icon]" == $object->id && !current_user_can( 'unfiltered_html' )  )
			$setting = stripslashes( wp_filter_post_kses( addslashes( $setting ) ) );
		/* Return the sanitized setting and apply filters. */
		return apply_filters( "templatic_customize_tmpl_favicon_icon", $setting, $object );
	}
	
	function templatic_customize_tmpl_google_fonts( $setting, $object ) {
		$prefix ='templatic';
		/* Make sure we kill evil scripts from users without the 'unfiltered_html' cap. */
		if ( $prefix."_theme_settings[tmpl_google_fonts]" == $object->id && !current_user_can( 'unfiltered_html' )  )
			$setting = stripslashes( wp_filter_post_kses( addslashes( $setting ) ) );
		/* Return the sanitized setting and apply filters. */
		return apply_filters( "templatic_customize_tmpl_google_fonts", $setting, $object );
	}
	
	function templatic_customize_tmpl_fonts_size( $setting, $object ) {
		$prefix ='templatic';
		/* Make sure we kill evil scripts from users without the 'unfiltered_html' cap. */
		if ( $prefix."_theme_settings[tmpl_fonts_size]" == $object->id && !current_user_can( 'unfiltered_html' )  )
			$setting = stripslashes( wp_filter_post_kses( addslashes( $setting ) ) );
		/* Return the sanitized setting and apply filters. */
		return apply_filters( "templatic_customize_tmpl_fonts_size", $setting, $object );
	}
	
	function templatic_customize_tmpl_header_background_image_url( $setting, $object ) {
		$prefix ='templatic';
		/* Make sure we kill evil scripts from users without the 'unfiltered_html' cap. */
		if ( $prefix."_theme_settings[tmpl_header_background_image_url]" == $object->id && !current_user_can( 'unfiltered_html' )  )
			$setting = stripslashes( wp_filter_post_kses( addslashes( $setting ) ) );
		/* Return the sanitized setting and apply filters. */
		return apply_filters( "templatic_customize_tmpl_header_background_image_url", $setting, $object );
	}
	
	function templatic_customize_tmpl_body_background_image_url( $setting, $object ) {
		$prefix ='templatic';
		/* Make sure we kill evil scripts from users without the 'unfiltered_html' cap. */
		if ( $prefix."_theme_settings[tmpl_body_background_image_url]" == $object->id && !current_user_can( 'unfiltered_html' )  )
			$setting = stripslashes( wp_filter_post_kses( addslashes( $setting ) ) );
		/* Return the sanitized setting and apply filters. */
		return apply_filters( "templatic_customize_tmpl_body_background_image_url", $setting, $object );
	}
	
	
	function templatic_customize_theme_site_description( $setting, $object ) {
		$prefix ='templatic';
		/* Make sure we kill evil scripts from users without the 'unfiltered_html' cap. */
		if ( $prefix."_theme_settings[theme_site_description]" == $object->id && !current_user_can( 'unfiltered_html' )  )
			$setting = stripslashes( wp_filter_post_kses( addslashes( $setting ) ) );
		/* Return the sanitized setting and apply filters. */
		return apply_filters( "templatic_customize_theme_site_description", $setting, $object );
	}
	function templatic_customize_theme_color1( $setting, $object ) {
		$prefix ='templatic';
		/* Make sure we kill evil scripts from users without the 'unfiltered_html' cap. */
		if ( $prefix."_theme_settings[color_picker_color1]" == $object->id && !current_user_can( 'unfiltered_html' )  )
			$setting = stripslashes( wp_filter_post_kses( addslashes( $setting ) ) );
		/* Return the sanitized setting and apply filters. */
		return apply_filters( "templatic_customize_theme_color1", $setting, $object );
	}
	
	function templatic_customize_theme_color2( $setting, $object ) {
		$prefix ='templatic';
		/* Make sure we kill evil scripts from users without the 'unfiltered_html' cap. */
		if ( $prefix."_theme_settings[color_picker_color2]" == $object->id && !current_user_can( 'unfiltered_html' )  )
			$setting = stripslashes( wp_filter_post_kses( addslashes( $setting ) ) );
		/* Return the sanitized setting and apply filters. */
		return apply_filters( "templatic_customize_theme_color2", $setting, $object );
	}
	
	function templatic_customize_theme_color3( $setting, $object ) {
		$prefix ='templatic';
		/* Make sure we kill evil scripts from users without the 'unfiltered_html' cap. */
		if ( $prefix."_theme_settings[color_picker_color3]" == $object->id && !current_user_can( 'unfiltered_html' )  )
			$setting = stripslashes( wp_filter_post_kses( addslashes( $setting ) ) );
		/* Return the sanitized setting and apply filters. */
		return apply_filters( "templatic_customize_theme_color3", $setting, $object );
	}
	
	function templatic_customize_theme_color4( $setting, $object ) {
		$prefix ='templatic';
		/* Make sure we kill evil scripts from users without the 'unfiltered_html' cap. */
		if ( $prefix."_theme_settings[color_picker_color4]" == $object->id && !current_user_can( 'unfiltered_html' )  )
			$setting = stripslashes( wp_filter_post_kses( addslashes( $setting ) ) );
		/* Return the sanitized setting and apply filters. */
		return apply_filters( "templatic_customize_theme_color4", $setting, $object );
	}
	
	function templatic_customize_theme_color5( $setting, $object ) {
		$prefix ='templatic';
		/* Make sure we kill evil scripts from users without the 'unfiltered_html' cap. */
		if ( $prefix."_theme_settings[color_picker_color5]" == $object->id && !current_user_can( 'unfiltered_html' )  )
			$setting = stripslashes( wp_filter_post_kses( addslashes( $setting ) ) );
		/* Return the sanitized setting and apply filters. */
		return apply_filters( "templatic_customize_theme_color5", $setting, $object );
	}
	
	
	
	/* texture settings start. */
	function templatic_customize_templatic_texture1( $setting, $object ) {
		/* Make sure we kill evil scripts from users without the 'unfiltered_html' cap. */
		$prefix ='templatic';
		if ( $prefix."_theme_settings[templatic_texture1]" == $object->id && !current_user_can( 'unfiltered_html' )  )
			$setting = stripslashes( wp_filter_post_kses( addslashes( $setting ) ) );
		/* Return the sanitized setting and apply filters. */
		return apply_filters( "templatic_customize_templatic_texture1", $setting, $object );
	}
	
	function templatic_customize_alternate_of_texture( $setting, $object ) {
		$prefix ='templatic';
		/* Make sure we kill evil scripts from users without the 'unfiltered_html' cap. */
		if ( $prefix."_theme_settings[alternate_of_texture]" == $object->id && !current_user_can( 'unfiltered_html' )  )
			$setting = stripslashes( wp_filter_post_kses( addslashes( $setting ) ) );
		/* Return the sanitized setting and apply filters. */
		return apply_filters( "templatic_customize_alternate_of_texture", $setting, $object );
	}
	//texture settings finish.
	
	/* background header image function start */
	function templatic_customize_header_image_display( $setting, $object ) {
		$prefix ='templatic';
		/* Make sure we kill evil scripts from users without the 'unfiltered_html' cap. */
		if ( $prefix."_theme_settings[header_image_display]" == $object->id && !current_user_can( 'unfiltered_html' )  )
			$setting = stripslashes( wp_filter_post_kses( addslashes( $setting ) ) );
		/* Return the sanitized setting and apply filters. */
		return apply_filters( "templatic_customize_header_image_display", $setting, $object );
	}
	/* background header image function end */
	
	/* Display header text FUNCTION START */
	function templatic_customize_display_header_text( $setting, $object ) {
		$prefix ='templatic';
		/* Make sure we kill evil scripts from users without the 'unfiltered_html' cap. */
		if ( $prefix."_theme_settings[display_header_text]" == $object->id && !current_user_can( 'unfiltered_html' )  )
			$setting = stripslashes( wp_filter_post_kses( addslashes( $setting ) ) );
		/* Return the sanitized setting and apply filters. */
		return apply_filters( "templatic_customize_display_header_text", $setting, $object );
	}
	//Display header text FUNCTION END
	
/*  Handles changing settings for the live preview of the theme END.  */	
/**
 * Loads framework-specific customize control classes.  Customize control classes extend the WordPress 
 * WP_Customize_Control class to create unique classes that can be used within the framework.
 */
function templatic_customize_controls() {
	 /*
	 * Custom label customize control class.
	 */
	if(class_exists('WP_Customize_Control')){
		class templatic_custom_lable_control extends WP_Customize_Control{
			  public function render_content(){
	?>
<label> <span><?php echo esc_html( $this->label ); ?></span> </label>
<?php
			 }
		}
	}
	/**
	 * Textarea customize control class.
	 */
	if(class_exists('WP_Customize_Control')){
		class Hybrid_Customize_Control_Textarea extends WP_Customize_Control {
			public $type = 'textarea';
			public function __construct( $manager, $id, $args = array() ) {
				parent::__construct( $manager, $id, $args );
			}
			public function render_content() { ?>
			<label>
			<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			<div class="customize-control-content">
			  <textarea cols="25" rows="5" <?php $this->link(); ?>><?php echo esc_textarea( $this->value() ); ?></textarea>
			</div>
			</label>
			<?php }
					}
	}
}
?>
