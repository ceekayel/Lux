<?php 

/*	Created Widget areas for header,content, and footer START	*/
if(function_exists('register_sidebars')){
	
	register_sidebars(1,array('id' => 'header_advertisement', 'name' => 'Header Advertisement', 'description' => 'Display advertisement widget in header.', 'before_widget' => '<div class="widget">', 'after_widget' => '</div>', 				    'before_title' => '<h3>', 'after_title' => '</h3>'));
	register_sidebars(1,array('id' => 'header_right', 'name' => 'Header right area', 'description' => 'Display widget in header right.', 'before_widget' => '<div class="widget">', 'after_widget' => '</div>','before_title' => '<h3>', 'after_title' => '</h3>'));
	register_sidebars(1,array('id' => 'catalog_home_content_widget_area', 'name' => 'Home Page Content', 'description' => 'Display widgets in home page content area', 'before_widget' => '<div class="widget">', 'after_widget' => '</div>', 				    'before_title' => '<h3>', 'after_title' => '</h3>'));
	register_sidebars(1,array('id' => 'home-page-slider-widget', 'name' => 'Home Page Slider', 'description' => 'Display Widgets in home page header area', 'before_widget' => '<div class="widget">', 'after_widget' => '</div>', 				    'before_title' => '<h3>', 'after_title' => '</h3>'));
	register_sidebars(1,array('id'=>'footer1','name'=>'Footer 1','description'=>'Display wigets in footer column 1','before_widget'=>'<div class="widget">','after_widget'=>'</div>','before_title'=>'<h3>','after_title'=>'</h3>'));
	register_sidebars(1,array('id'=>'footer2','name'=>'Footer 2','description'=>'Display wigets in footer column 2','before_widget'=>'<div class="widget">','after_widget'=>'</div>','before_title'=>'<h3>','after_title'=>'</h3>'));
	register_sidebars(1,array('id'=>'footer3','name'=>'Footer 3','description'=>'Display wigets in footer column 3','before_widget'=>'<div class="widget">','after_widget'=>'</div>','before_title'=>'<h3>','after_title'=>'</h3>'));
}

add_action('widgets_init','un_register_widget_callback',15);
function un_register_widget_callback(){
	unregister_sidebar('header_search');
	register_sidebars(1,array('id'=>'header_search','name'=>'Header Search','description'=>'Display Social Media widget besides menu','before_widget'=>'<div class="widget">','after_widget'=>'</div>','before_title'=>'<h3>','after_title'=>'</h3>'));
}

/*	Created Widget areas for header,content, and footer START	*/


/* =============================== Feedburner Subscribe widget START ====================================== */
if(!class_exists('subscribewidget')){
	class subscribewidget extends WP_Widget {
		function subscribewidget() {
		//Constructor
			$widget_ops = array('classname' => 'widget Newsletter Subscribe', 'description' => __('Display Newsletter Subscribe Widget. Best use in "footer1" widget area.',CATALOG_DOMAIN) );		
			$this->WP_Widget('widget_subscribewidget', __('T &rarr; Newsletter Subscribe',CATALOG_DOMAIN), $widget_ops);
		}
		function widget($args, $instance) {
		// prints the widget
		extract($args, EXTR_SKIP);
		$id = empty($instance['id']) ? '' : apply_filters('widget_id', $instance['id']);
		$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
		$text = empty($instance['text']) ? '' : apply_filters('widget_text', $instance['text']);
	 ?>
	 <div class="widget subscribe" >
		<div class="subscribe_wall">
        	<div class="subscribe_cont">
    		<?php if($title){?><h3 class="widget-title"><?php echo $title; ?></h3><?php }?>
    		<?php if($text){?><p><?php echo $text; ?></p><?php }?>
            <form action="http://feedburner.google.com/fb/a/mailverify" method="post" target="popupwindow" onsubmit="window.open('http://feedburner.google.com/fb/a/mailverify?uri=<?php echo $id; ?>', 'popupwindow', 'scrollbars=yes,width=550,height=520');return true" >
              <input type="text" name="name" value="Your Name" class="field" onfocus="if (this.value == 'Your Name') {this.value = '';}" onblur="if (this.value == '') {this.value = 'Your Name';}"  />
              <input type="text" name="email" value="Your Email Address" class="field" onfocus="if (this.value == 'Your Email Address') {this.value = '';}" onblur="if (this.value == '') {this.value = 'Your Email Address';}"  />
              <input type="hidden" value="<?php echo $id; ?>" name="uri"   />
              <input type="hidden" value="<?php bloginfo('name'); ?>" name="title" />
              <input type="hidden" name="loc" value="en_US"/>
              <input class="replace" type="submit" name="submit" value="<?php _e('Subscribe','templatic');?>" />
            </form>
            </div>
		</div>
	  </div>
	<?php
		}
		function update($new_instance, $old_instance) {
		//save the widget
			$instance = $old_instance;		
			$instance['id'] = strip_tags($new_instance['id']);
			$instance['title'] = strip_tags($new_instance['title']);
			$instance['text'] = strip_tags($new_instance['text']);
		
			
			return $instance;
		}
		function form($instance) {
		//widgetform in backend
			$instance = wp_parse_args( (array) $instance, array( 'id' => '', 'title' => 'Subscribe', 'text' => 'Stay updated with all our latest news enter your e-mail address here', 'name' => '') );		
			$id = strip_tags($instance['id']);
			$title = strip_tags($instance['title']);
			$text = strip_tags($instance['text']);
			
	?>
			<p>
			  <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:','templatic');?>
			  <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
			  </label>
			</p>
			<p>
			  <label for="<?php echo $this->get_field_id('text'); ?>"><?php _e('Text Under Title:','templatic');?>
			  <input class="widefat" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>" type="text" value="<?php echo esc_attr($text); ?>" />
			  </label>
			</p>
			<p>
			  <label for="<?php echo $this->get_field_id('id'); ?>"><?php _e('Feedburner ID:','templatic');?>
			  <input class="widefat" id="<?php echo $this->get_field_id('id'); ?>" name="<?php echo $this->get_field_name('id'); ?>" type="text" value="<?php echo esc_attr($id); ?>" />
			  </label>
			</p>


	<?php
		}
	}
	register_widget('subscribewidget');
}
/* =============================== Feedburner Subscribe widget END ====================================== */


/* =============================== Text widget START ====================================== */
if(!class_exists('text_widget')){
	class text_widget extends WP_Widget {
		function text_widget() {
		//Constructor
			$widget_ops = array('classname' => 'text_widget', 'description' => __('Displays simple text widget with read more link. Best use in sidebar or footer widget areas',CATALOG_DOMAIN) );		
			$this->WP_Widget('text_widget', __('T &rarr; Text Widget',CATALOG_DOMAIN), $widget_ops);
		}
		function widget($args, $instance) {
		// prints the widget
			extract($args, EXTR_SKIP);
			$title1 = empty($instance['title1']) ? 'About Us' : apply_filters('widget_title', $instance['title1']);
			$desc1 = empty($instance['desc1']) ? '' : apply_filters('widget_desc1', $instance['desc1']);
			$read_more_text1 = empty($instance['read_more_text1']) ? '' : apply_filters('widget_read_more_text', $instance['read_more_text1']);
			$read_more_link1 = empty($instance['read_more_link1']) ? '' : apply_filters('widget_read_more_link', $instance['read_more_link1']);
			
			?>
			<div class="widget">
				<div class="widget_title1">
					<h3 class="widget-title"><?php echo $title1; ?> </h3>
					<p>
						<?php echo $desc1;?>
						<a href="<?php echo $read_more_link1;?>" title="<?php echo $read_more_text1;?>" style="font-weight:bold;"><?php echo $read_more_text1."&nbsp;&raquo;";?></a>
					</p>
				</div>
			</div>	
			
	<?php
		}
		function update($new_instance, $old_instance) {
		//save the widget
			$instance = $old_instance;		
			$instance['title1'] = strip_tags($new_instance['title1']);
			$instance['desc1'] = ($new_instance['desc1']);
			$instance['read_more_text1'] = ($new_instance['read_more_text1']);
			$instance['read_more_link1'] = ($new_instance['read_more_link1']);
			
			return $instance;
		}
		function form($instance) {
		//widgetform in backend
			$instance = wp_parse_args( (array) $instance, array( 'title1' => '', 'desc1' => '', 'read_more_text1' => '','read_more_link1'=>'','title2' => '', 'desc2' => '', 'read_more_text2' => '','read_more_link2'=>'' ) );
			$title1 = strip_tags($instance['title1']);
			$desc1 = ($instance['desc1']);
			$read_more_text1 = ($instance['read_more_text1']);
			$read_more_link1 = ($instance['read_more_link1']);
			
			
	?>
			<p>
			  <label for="<?php echo $this->get_field_id('title1'); ?>"><?php _e('Title1','templatic');?>
			  <input class="widefat" id="<?php echo $this->get_field_id('title1'); ?>" name="<?php echo $this->get_field_name('title1'); ?>" type="text" value="<?php echo esc_attr($title1); ?>" />
			  </label>
			</p>
			<p>
			  <label for="<?php echo $this->get_field_id('desc1'); ?>"><?php _e('Description1','templatic');?>
			  <textarea class="widefat" rows="6" cols="20" id="<?php echo $this->get_field_id('desc1'); ?>" name="<?php echo $this->get_field_name('desc1'); ?>"><?php echo esc_attr($desc1); ?></textarea>
			  </label>
			</p>
			<p>
			  <label for="<?php echo $this->get_field_id('read_more_text1'); ?>"><?php _e('Read more text1',CATALOG_DOMAIN);?>
			  <input class="widefat" id="<?php echo $this->get_field_id('read_more_text1'); ?>" name="<?php echo $this->get_field_name('read_more_text1'); ?>" type="text" value="<?php echo esc_attr($read_more_text1); ?>" />
			  </label>
			</p>
			<p>
			  <label for="<?php echo $this->get_field_id('read_more_link1'); ?>"><?php _e('Read more link1',CATALOG_DOMAIN);?>
			  <input class="widefat" id="<?php echo $this->get_field_id('read_more_link1'); ?>" name="<?php echo $this->get_field_name('read_more_link1'); ?>" type="text" value="<?php echo esc_attr($read_more_link1); ?>" />
			  </label>
			</p>
			
	<?php
		}
	}
	register_widget('text_widget');
}
/* =============================== Text widget END ====================================== */


/* =============================== Social widget START ====================================== */
if(!class_exists('social_media')){
	class social_media extends WP_Widget {
		function social_media() {
		//Constructor
			$widget_ops = array('classname' => 'widget Social Media', 'description' => 'Widget Display Social Media Links. Best use in sidebar and footer widget areas.' );		
			$this->WP_Widget('social_media', 'T &rarr; Social Media', $widget_ops);
		}
		function widget($args, $instance) {
		// prints the widget
			extract($args, EXTR_SKIP);
			$title = empty($instance['title']) ? 'Social Media' : apply_filters('widget_title', $instance['title']);
			$twitter = empty($instance['twitter']) ? '' : apply_filters('widget_twitter', $instance['twitter']);
			$facebook = empty($instance['facebook']) ? '' : apply_filters('widget_facebook', $instance['facebook']);
			$linkedin = empty($instance['linkedin']) ? '' : apply_filters('widget_linkedin', $instance['linkedin']);
			$rss = empty($instance['rss']) ? '' : apply_filters('widget_rss', $instance['rss']);
			 ?>						

			<div class="widget social_media">
			   <?php if($title){?> <h3 class="widget-title"><?php echo $title; ?> </h3><?php }?>
			   <ul class="social_media_list">
				 <?php if ( $twitter <> "" ) { ?>	
					<li><a href="<?php echo $twitter; ?>" class="twitter" ><span><?php _e("Twitter","templatic");?></span></a>  </li>
				 <?php } ?>
				 
				 <?php if ( $facebook <> "" ) { ?>	
					<li> <a href="<?php echo $facebook; ?>" class="facebook" ><span><?php _e("Facebook","templatic");?></span></a> </li>
				 <?php } ?>
				 
				 <?php if ( $linkedin <> "" ) { ?>	
					<li> <a href="<?php echo $linkedin; ?>" class="linkedin" ><span><?php _e("Linked in","templatic");?></span></a>   </li>
				 <?php } ?>
				 
				 <?php if ( $rss <> "" ) { ?>	
					<li> <a href="<?php echo $rss; ?>" class="rssfeed" ><span><?php _e("RSS Feed","templatic");?></span></a></li>
				 <?php } ?>
				</ul>
			</div> <!-- widget #end -->
				
				
		<?php
		}
		function update($new_instance, $old_instance) {
		//save the widget
			$instance = $old_instance;		
			$instance['title'] = strip_tags($new_instance['title']);
			$instance['twitter'] = ($new_instance['twitter']);
			$instance['facebook'] = ($new_instance['facebook']);
			$instance['linkedin'] = ($new_instance['linkedin']);
			$instance['rss'] = ($new_instance['rss']);
			return $instance;
		}
		function form($instance) {
		//widgetform in backend
			$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'twitter' => '', 'facebook' => '', 'linkedin' => '','rss' => '' ) );		
			$title = strip_tags($instance['title']);
			$twitter = ($instance['twitter']);
			$facebook = ($instance['facebook']);
			$linkedin = ($instance['linkedin']);		
			$rss = ($instance['rss']);
	?>
		   <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e("Widget Title:","templatic");?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>
		   <p><label for="<?php echo $this->get_field_id('twitter'); ?>"><?php _e("Twitter Full URL:","templatic");?> <input class="widefat" id="<?php echo $this->get_field_id('twitter'); ?>" name="<?php echo $this->get_field_name('twitter'); ?>" type="text" value="<?php echo esc_attr($twitter); ?>" /></label></p>
		   <p><label for="<?php echo $this->get_field_id('facebook'); ?>"><?php _e("Facebook Full URL:","templatic");?> <input class="widefat" id="<?php echo $this->get_field_id('facebook'); ?>" name="<?php echo $this->get_field_name('facebook'); ?>" type="text" value="<?php echo esc_attr($facebook); ?>" /></label></p>
		   <p><label for="<?php echo $this->get_field_id('linkedin'); ?>"><?php _e("Linkedin Full URL:","templatic");?> <input class="widefat" id="<?php echo $this->get_field_id('linkedin'); ?>" name="<?php echo $this->get_field_name('linkedin'); ?>" type="text" value="<?php echo esc_attr($linkedin); ?>" /></label></p>
		   <p><label for="<?php echo $this->get_field_id('rss'); ?>"><?php _e("Rss Full URL:","templatic");?> <input class="widefat" id="<?php echo $this->get_field_id('rss'); ?>" name="<?php echo $this->get_field_name('rss'); ?>" type="text" value="<?php echo esc_attr($rss); ?>" /></label></p>

	<?php
		}
	}
	register_widget('social_media');
}
/* =============================== Social widget START ====================================== */


/* =============================== WooCommerce shopping cart widget START ====================================== */
if(!class_exists('woo_shopping_cart_info')){
	class woo_shopping_cart_info extends WP_Widget {
		function woo_shopping_cart_info() {
		//Constructor
			$widget_ops = array('classname' => 'widget WooCommerce shopping cart info', 'description' => __('Display Cart Informations with automatic cart update. Best to use it in "Header right area" widget are',CATALOG_DOMAIN));
			$this->WP_Widget('woo_shopping_cart_info', __('T &rarr; WooCommerce Shopping Cart',CATALOG_DOMAIN), $widget_ops);
		}

		function widget($args, $instance) {
			// prints the widget
			global $woocommerce;
			extract($args, EXTR_SKIP);?>
			<div class="widget templatic_shooping  widget_shopping_cart">
			<?php if($before_title=='' || $after_title=='')
			{
				$before_title=='<h4>';
				$after_title=='</h4>';
			}
			?>
			
			<div  id="woo_shoppingcart_box" class="shoppingcart_box" style="cursor:pointer;width:200px;height:60px;">
				<div class="shoppingcart_box_bg">
					<div class="cart_items" onclick="show_hide_cart_items();">
						<?php 
							_e('Items In Shopping Cart','templatic');
						?>
						<span class="plus_minus" style="float:right;">
							<img id="plus_minus_img" src="<?php echo get_stylesheet_directory_uri().'/images/btn_plus_hov.png'?>" title = "Click to expand"/>
						</span>
					</div>
					<div id="woo_shopping_cart" style="display:none">
						<div class="widget_shopping_cart_content">
						<?php 
							echo '<ul class="cart_list product_list_widget ';
							if ($hide_if_empty) echo 'hide_cart_widget_if_empty';
							echo '">';
							if ( sizeof( $woocommerce->cart->get_cart() ) > 0 ) {
								foreach ( $woocommerce->cart->get_cart() as $cart_item_key => $cart_item ) {
									$_product = $cart_item['data'];
									if ( $_product->exists() && $cart_item['quantity'] > 0 ) {
										echo '<li><a href="'.get_permalink($cart_item['product_id']).'">';
										echo $_product->get_image(). '</a><a href="'.get_permalink($cart_item['product_id']).'">';
										echo apply_filters('woocommerce_cart_widget_product_title', $_product->get_title(), $_product)."</a>";
										$product_price = get_option('woocommerce_display_cart_prices_excluding_tax') == 'yes' || $woocommerce->customer->is_vat_exempt() ? $_product->get_price_excluding_tax() : $_product->get_price();
										$product_price = apply_filters('woocommerce_cart_item_price_html', woocommerce_price( $product_price ), $cart_item, $cart_item_key ); 		
										echo '<span class="quantity">' . $cart_item['quantity'] . ' &times; ' . $product_price . '</span></li>';
									}
								}
							}
							echo '</ul>';
						?>	
					</div>	
					</div>
					<?php 	
						echo '<p class="cart_checkout">';
						do_action( 'woocommerce_widget_shopping_cart_before_buttons' );
						echo '<a  href="' . $woocommerce->cart->get_cart_url() . '" class="button">' . __('Checkout', 'templatic') . '</a></p>';
					
					?>
					<div class="clearfix"></div>
				</div>
			</div>
			
			
			<script type="text/javascript">
				function show_hide_cart_items(){
					var dis = document.getElementById('woo_shopping_cart').style.display;
					if(dis == 'none'){
						document.getElementById('plus_minus_img').src = "<?php echo get_stylesheet_directory_uri().'/images/btn_minus_hov.png'?>";
						document.getElementById('plus_minus_img').title = "Click to collepse";
						jQuery('#woo_shopping_cart').show('slow');
					}else{
						document.getElementById('plus_minus_img').src = "<?php echo get_stylesheet_directory_uri().'/images/btn_plus_hov.png'?>";
						document.getElementById('plus_minus_img').title = "Click to expand";
						jQuery('#woo_shopping_cart').hide('slow');
					}
				}
			</script>
		</div>
			<?php 
		}
		function update($new_instance, $old_instance) {
		//save the widget
			$instance = $old_instance;
			return $instance;
		}
		function form($instance) {
		//widgetform in backend
			$instance = wp_parse_args( (array) $instance, array( '' => ' ' ) );
		}
	}
	if(is_plugin_active('woocommerce/woocommerce.php')){
	// || is_plugin_active('jigoshop/jigoshop.php')
		register_widget('woo_shopping_cart_info'); 
	}
}

if(!class_exists('jigoshop_shooping_cart')){
	class jigoshop_shooping_cart extends WP_Widget {
		private $jigoshop_options;
		
		/**
		 * Constructor
		 *
		 * Setup the widget with the available options
		 * Add actions to clear the cache whenever a post is saved|deleted or a theme is switched
		 */
		public function __construct() {
			$options = array(
				'classname'		=> 'jigoshop_shooping_cart',
				'description'	=> __( 'Display Cart Informations with automatic cart update. Best to use it in "Header right area" widget are.', 'jigoshop' )
			);

			// Create the widget
			parent::__construct( 'jigoshop_shooping_cart', __( 'T &rarr; Jigoshop Shopping Cart', 'jigoshop' ), $options );
			
			$this->jigoshop_options = Jigoshop_Base::get_options();
		}

		/**
		 * Widget
		 *
		 * Display the widget in the sidebar
		 * Save output to the cache if empty
		 *
		 * @param	array	sidebar arguments
		 * @param	array	instance
		 */
		public function widget( $args, $instance ) {

			// Hide widget if page is the cart
			if ( is_cart() )
				return false;

			extract( $args );

			// Set the widget title
			$title = apply_filters(
				'widget_title',
				( $instance['title'] ) ? $instance['title'] : __( 'Cart', 'jigoshop' ),
				$instance,
				$this->id_base
			);

			// Print the widget wrapper & title
			?>
			<div class="widget templatic_shooping  widget_shopping_cart">	
				<?php 
				echo $before_title . $title . $after_title;

				// Get the contents of the cart
				$cart_contents = jigoshop_cart::$cart_contents;
				?>
				<div id="woo_shoppingcart_box" class="shoppingcart_box" style="cursor:pointer;width:200px;height:60px;">
					<div class="shoppingcart_box_bg">
							<div class="cart_items" onclick="show_hide_jigo_cart_items();">
								<?php
									if ( ! empty( $cart_contents ) ) {
										$jigo_cart_items = 0;
										foreach ( $cart_contents as $cnt_key => $cnt_value ) {
											$cnt_product = $cnt_value['data'];
											if ( $cnt_product->exists() && $cnt_value['quantity'] > 0 ) {
												$jigo_cart_items += $cnt_value['quantity'];
											}
										}
										if($jigo_cart_items == 1){
											$jigo_items = "item";
										}else{
											$jigo_items = "items";
										}
										_e($jigo_cart_items." ".$jigo_items." in your cart","templatic");
									}else{
										_e("No items in your cart","templatic");
									}
								?>
								<span class="plus_minus" style="float:right;">
									<img id="jigo_plus_minus_img" src="<?php echo get_stylesheet_directory_uri().'/images/btn_plus_hov.png'?>" title = "Click to expand"/>
								</span>
							</div>
							<div id="jigo_shopping_cart" style="display:none">
							<?php	
									// If there are items in the cart print out a list of products
									if ( ! empty( $cart_contents ) ) {

										// Open the list
										echo '<ul class="cart_list product_list_widget ">';

										foreach ( $cart_contents as $key => $value ) {

											// Get product instance
											$_product = $value['data'];

											if ( $_product->exists() && $value['quantity'] > 0 ) {
											echo '<li>';
												// Print the product image & title with a link to the permalink
												echo '<a href="' . esc_attr( get_permalink( $_product->id ) ) . '" title="' . esc_attr( $_product->get_title() ) . '">';

												// Print the product thumbnail image if exists else display placeholder
												echo (has_post_thumbnail( $_product->id ) )
														? get_the_post_thumbnail( $_product->id, 'shop_tiny' )
														: jigoshop_get_image_placeholder( 'shop_tiny' );

												// Print the product title
												echo '<span class="js_widget_product_title">' . $_product->get_title() . '</span>';
												echo '</a>';

												// Displays variations and cart item meta
												echo jigoshop_cart::get_item_data($value);
												
												// Print the quantity & price per product
												echo '<span class="js_widget_product_price">' . $value['quantity'].' &times; '. $_product->get_price_html() . '</span>';
											echo '</li>';
											}
										}

										echo '</ul>'; // Close the list
									}
									// Print closing widget wrapper
									//echo $after_widget;
								?>
							</div>	
							<?php
								// Print the cart total
										echo '<p class="cart_checkout"><b>';
										echo jigoshop_cart::get_cart_total().'</b> ';
										do_action( 'jigoshop_widget_cart_before_buttons' );
										// Print view cart & checkout buttons
										$view_cart_button_label	= isset($instance['view_cart_button'])	? $instance['view_cart_button']	: __( 'View Cart &rarr;', 'jigoshop' );
										$checkout_button_label	= isset($instance['checkout_button'])	? $instance['checkout_button']	: __( 'Checkout;', 'jigoshop' );
										echo '<a href="' . esc_attr( jigoshop_cart::get_checkout_url() ) . '" class="button">' . __( $checkout_button_label, 'jigoshop' ) . '</a>';
										echo '</p>';	
							?>
                            <div class="clearfix"></div>
					</div>	
				</div>
				<script type="text/javascript">
					function show_hide_jigo_cart_items(){
						var dis = document.getElementById('jigo_shopping_cart').style.display;
						if(dis == 'none'){
							document.getElementById('jigo_plus_minus_img').src = "<?php echo get_stylesheet_directory_uri().'/images/btn_minus_hov.png'?>";
							document.getElementById('jigo_plus_minus_img').title = "Click to collepse";
							jQuery('#jigo_shopping_cart').show('slow');
						}else{
							document.getElementById('jigo_plus_minus_img').src = "<?php echo get_stylesheet_directory_uri().'/images/btn_plus_hov.png'?>";
							document.getElementById('jigo_plus_minus_img').title = "Click to expand";
							jQuery('#jigo_shopping_cart').hide('slow');
						}
					}
				</script>
			</div>	
			
		<?php 	
		}

		/**
		 * Update
		 *
		 * Handles the processing of information entered in the wordpress admin
		 * Flushes the cache & removes entry from options array
		 *
		 * @param	array	new instance
		 * @param	array	old instance
		 * @return	array	instance
		 */
		public function update( $new_instance, $old_instance ) {
			$instance = $old_instance;

			// Save the new values
			$instance['title']				= strip_tags( $new_instance['title'] );
			$instance['view_cart_button']	= strip_tags( $new_instance['view_cart_button'] );
			$instance['checkout_button']	= strip_tags( $new_instance['checkout_button'] );

			return $instance;
		}

		/**
		 * Form
		 *
		 * Displays the form for the wordpress admin
		 *
		 * @param	array	instance
		 */
		public function form( $instance ) {

			// Get instance data
			$title				= isset( $instance['title'] )				? esc_attr( $instance['title'] ) : null;
			$view_cart_button	= isset( $instance['view_cart_button'] )	? esc_attr( $instance['view_cart_button'] ) : 'View Cart &rarr;';
			$checkout_button	= isset( $instance['checkout_button'] )		? esc_attr( $instance['checkout_button'] ) : 'Checkout &rarr;';

			// Widget Title
			echo "
			<p>
				<label for='{$this->get_field_id( 'title' )}'>" . __( 'Title:', 'jigoshop' ) . "</label>
				<input class='widefat' id='{$this->get_field_id( 'title' )}' name='{$this->get_field_name( 'title' )}' type='text' value='{$title}' />
			</p>";
			
			// View cart button label
			//echo "
			//<p>
				//<label for='{$this->get_field_id( 'view_cart_button' )}'>" . __( 'View cart button:', 'jigoshop' ) . "</label>
				//<input class='widefat' id='{$this->get_field_id( 'view_cart_button' )}' name='{$this->get_field_name( 'view_cart_button' )}' type='text' value='{$view_cart_button}' />
			//</p>";
			
			// Checkout button label
			echo "
			<p>
				<label for='{$this->get_field_id( 'checkout_button' )}'>" . __( 'Checkout button:', 'jigoshop' ) . "</label>
				<input class='widefat' id='{$this->get_field_id( 'checkout_button' )}' name='{$this->get_field_name( 'checkout_button' )}' type='text' value='{$checkout_button}' />
			</p>";
		}

	}
	if(is_plugin_active('jigoshop/jigoshop.php')){
		register_widget('jigoshop_shooping_cart');
	}
}

/* =============================== WooCommerce shopping cart widget END ====================================== */

/* =============================== Advertisement widget START ====================================== */

if(!class_exists('banner_widget')){
	class banner_widget extends WP_Widget {
		function banner_widget() {
		//Constructor
			$widget_ops = array('classname' => 'widget_advertisement', 'description' => __('Set Advertisement either banner or Google Ad Sence Code. Best Use in "Header Advertisement" Widget area',CATALOG_DOMAIN) );
			$this->WP_Widget('widget_advertisement', __('T &rarr; Set Advertisement',CATALOG_DOMAIN), $widget_ops);
		}

		function widget($args, $instance) {
			// prints the widget
				extract($args, EXTR_SKIP);
				$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
				$advertisement = empty($instance['advertisement']) ? '' : apply_filters('widget_ads', $instance['advertisement']);
				?>						
			   <div class="widget advt_widget">
					<?php if ( $title <> "" ) { ?><h3 class="widget-title"><?php _e($title,'templatic');?></h3> <?php } ?>
					<?php echo $advertisement; ?> 
				</div>        
			<?php
			}

		function update($new_instance, $old_instance) {
			//save the widget
				$instance = $old_instance;		
				$instance['title'] = strip_tags($new_instance['title']);
				$instance['advertisement'] = ($new_instance['advertisement']);
				return $instance;
			}
		function form($instance) {
		//widgetform in backend
			$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'advertisement' => '') );		
			$title = strip_tags($instance['title']);
			$advertisement = ($instance['advertisement']);
	?>
			<p>
			  <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title',CATALOG_DOMAIN);?> :</label>
			  <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
			</p>
			<p>
			  <label for="<?php echo $this->get_field_id('advertisement'); ?>"><?php _e('Advertisement:<small>(eg:google adsense code)</small>',CATALOG_DOMAIN);?> </label>
			  <textarea id="<?php echo $this->get_field_id('advertisement'); ?>" name="<?php echo $this->get_field_name('advertisement'); ?>" cols="35" rows="4" ><?php echo esc_attr($advertisement); ?></textarea>
			</p>
	<?php
		}

	}
	register_widget('banner_widget');
}
/* =============================== Advertisement widget END ====================================== */

/* =============================== Discount Products listing widget START ====================================== */
	/*	
		Lists products which are in discount scheme. 
		It will display all the products which we 
		are selected for discount when creating 
		coupons.
	*/
//remove_action('posts_where','templatic_searching_filter_where');

	if(!class_exists('discount_products_widget')){
		class discount_products_widget extends WP_Widget{
			/*	Widget constructor	*/
			function discount_products_widget(){
				$widget_opts = array('classname' => 'discount_products_widget', 'description' => __('Display discounted products. Best used inside sidebar areas',"templatic"));
				$this->WP_Widget('discount_products_widget',__('T &rarr; Discount Products Widget',"templatic"),$widget_opts);
			}
			/*	Display widget form in backend	*/
			function form($instance){
				$instance = wp_parse_args( (array) $instance, array('coupon_title'=>'','coupon_code'=>'discount','number_posts'=>''));
				$coupon_title = $instance['coupon_title'];
				$coupon_code = $instance['coupon_code'];
				$number_posts = $instance['number_posts'];
	?>
				<p>
					<label for="<?php echo $this->get_field_id("coupon_title");?>"><?php _e("Discount Coupon Title:","templatic");?></label>
					<input class="widefat" id="<?php echo $this->get_field_id("coupon_title");?>" name="<?php echo $this->get_field_name("coupon_title");?>" type="text" value="<?php echo esc_attr($coupon_title);?>"/>
				</p>
				<p>
					<label for="<?php echo $this->get_field_id("coupon_code");?>"><?php _e("Coupon Code:<small><b>(Must exactly match with coupon codes you stored)</b></small>","templatic");?></label>
					<input class="widefat" id="<?php echo $this->get_field_id("coupon_code");?>" name="<?php echo $this->get_field_name("coupon_code");?>" type="text" value="<?php echo esc_attr($coupon_code);?>"/>
				</p>
				<p>
					<label for="<?php echo $this->get_field_id("number_posts");?>"><?php _e("Number of posts:","templatic");?></label>
					<input class="widefat" id="<?php echo $this->get_field_id("number_posts");?>" name="<?php echo $this->get_field_name("number_posts");?>" type="text" value="<?php echo esc_attr($number_posts);?>"/>
				</p>
	<?php	
			}
			
			/*	save the widget values	*/
			function update($new_instance,$old_instance){
				$instance = $old_instance;
				$instance['coupon_title'] = $new_instance['coupon_title'];
				$instance['coupon_code'] = $new_instance['coupon_code'];
				$instance['number_posts'] = $new_instance['number_posts'];
				return $instance;
			}
			
			/*	Prints the widget in frontend	*/
			function widget($args,$instance){
				extract($args, EXTR_SKIP);
				$coupon_title = empty($instance['coupon_title']) ? 'Discount Products' : $instance['coupon_title'];
				$coupon_code = empty($instance['coupon_code']) ? '' : $instance['coupon_code'];
				$number_posts = empty($instance['number_posts']) ? '8' : $instance['number_posts'];
				
				global $wpdb;
				$sql_query = "SELECT ID FROM $wpdb->posts WHERE post_title!='' AND post_title like '$coupon_code' AND post_type='shop_coupon' and post_status='publish'" ;
				$get_post_id_by_title = $wpdb->get_var($sql_query);
				$discount_products_ids="";
				$id = array();
				if(is_plugin_active('woocommerce/woocommerce.php')){
					$discount_products_ids = get_post_meta($get_post_id_by_title,'product_ids',true);
					$id = explode(',',$discount_products_ids);
				}elseif(is_plugin_active('jigoshop/jigoshop.php')){
					$discount_products_ids = get_post_meta($get_post_id_by_title,'include_products',true);
					$id = $discount_products_ids;
				}else{
					$discount_products_ids = "";
				}
				$ids = array();
				
				
				for($i=0;$i<$number_posts;$i++){
					if(isset($id[$i]) && $id[$i]!=""){
						$ids[] = $id[$i];
					}
				}
				
	?>		
				<div class="widget">
					<h3 class="widget-title"><?php echo $coupon_title;?></h3>
					<ul class="discount_products">
					<?php 
							if(isset($ids) && $ids!=""){
								$discount_products = new WP_Query(array('post_type' => 'product', 'posts_per_page' => $number_posts, 'post__in' => $ids, 'orderby' => 'rand', 'post_status' => 'publish' ));
								if( $discount_products->have_posts()){
									while ( $discount_products->have_posts() ) : $discount_products->the_post();
										global $post;
										$images = bdw_get_images_with_info($post->ID,'discount_thumbs');
										if($images!="" && !empty($images)){
											$images = $images[0]['file'];
										}else{
											$images = get_stylesheet_directory_uri()."/images/noimage_50x50.jpg";
										}
							?>
										<li>
											<a href="<?php the_permalink();?>"><img src="<?php echo $images;?>" title="<?php the_title();?>" alt="<?php the_title();?>" height="50" width="50"/></a>
										</li>			
							<?php	endwhile;wp_reset_query();
								}
							}else{
								echo "<span style='margin-left:20px;'>No products available</span>";
							}	
					?>
					</ul>
				</div>
	<?php
			}
		}
		if(is_plugin_active('woocommerce/woocommerce.php') || is_plugin_active('jigoshop/jigoshop.php')){
			register_widget('discount_products_widget');
		}
	}

/* =============================== Discount Products listing widget END ====================================== */

/* =============================== Category wise products listing widget START ====================================== */
	/*
		Displays list of prodcuts which are 
		in particular category.
		[ex: display all cars products in cars category ]
	*/
	if(!class_exists('category_wise_product_listing')){
		class category_wise_product_listing extends WP_Widget {
		
			function category_wise_product_listing() {
			//Constructor
				global $thumb_url;
					$widget_ops = array('classname' => 'widget special', 'description' => __('Display products with advanced sorting options. Best used inside "Home Page Content" widget area.','templatic') );
					$this->WP_Widget('category_wise_product_listing',__('T &rarr; Category Wise Product Listing','templatic'), $widget_ops);
				}
			 
				function widget($args, $instance) {
				// prints the widget
					
					extract($args, EXTR_SKIP);
			 
					echo $before_widget;
					$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
					$category = empty($instance['category']) ? '' : apply_filters('widget_category', $instance['category']);
					$number = empty($instance['number']) ? '15' : apply_filters('widget_number', $instance['number']);
					$my_post_type = empty($instance['post_type']) ? 'product' : apply_filters('widget_post_type', $instance['post_type']);
					$link = empty($instance['link']) ? '' : apply_filters('widget_link', $instance['link']);
					$text = empty($instance['text']) ? 'Browse More' : apply_filters('widget_text', $instance['text']);
					$orderby = empty($instance['orderby']) ? '' : $instance['orderby'];
					$order = empty($instance['order']) ? '' : $instance['order'];
					global $post,$wpdb;
					$post_widget_count = 1;

					$args=array('product_cat' => $category,
					  'post_type' => $my_post_type,
					  'posts_per_page' => $number,
					  'orderby' => $orderby,
					  'order' => $order,
					  'ignore_sticky_posts'=> 1);
					$my_query = null;
					$my_query = new WP_Query($args);
					if( $my_query->have_posts() ) {
						 ?>
							
					<div id="loop" class="grid clear">	
						<?php if($title){?> 
							<h3 class="widget-title"><span><?php _e($title,'templatic');?></span>
							<?php if($link){?><a href="<?php _e($link,'templatic');?>" class="more" ><?php _e($text,'templatic');?></a><?php }?>
				 
							</h3> <?php }?>
							<ul class="products">
					<?php   while ($my_query->have_posts()) : $my_query->the_post();
								global $post;	
								$post_images =  bdw_get_images_with_info($post->ID,'small_slider_thumbs');   
								$attachment_id = $post_images[0]['id']; ?>	
								<li class="post-content product">
									<?php  global $woocommerce,$product;
									$alt = get_post_meta($attachment_id, '_wp_attachment_image_alt', true);
									$attach_data = get_post($attachment_id);
									$title = $attach_data->post_title;
									$width = get_option('thumbnail_size_w');
									$height = get_option('thumbnail_size_h');
									$is_crop = get_option('thumbnail_crop');
									if($is_crop == 1){ $is_crop = 'true'; }else{ $is_crop = 'false'; }
									if($title ==''){ $title = $post->post_title; }
									if($alt ==''){ $alt = $post->post_title; }
						?>
									<a class="post_img" href="<?php the_permalink(); ?>">
										<?php
											if(function_exists("woo_jigo_sale_image")){
												echo woo_jigo_sale_image();
											}
											if($post_images[0]['file']!=""){?>
												<img src="<?php echo $post_images[0]['file']; ?>" alt="<?php the_title(); ?>"  title="<?php the_title(); ?>" width="220" height="220"/>
                                        <?php   
											} else {?>
												<img  src="<?php echo TEMPLATE_CHILD_DIRECTORY_URL.'images/noimage_220x220.jpg';?>" alt="<?php $alt; ?>" title="<?php echo $title; ?>" width="220" height="220" />
										<?php   
											} 
										?>
									</a>
									<div class="post_content">
										<span><a class="widget-title" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></span>
										<span><?php if(function_exists("woo_jigo_product_price")){echo woo_jigo_product_price();}?></span>
										<?php woo_jigo_add_to_cart_button($post);?>
									</div>
									<div class="clearfix"></div>
								</li>
				  <?php  
								if($post_widget_count == '3') {
									echo '<div class="hr clearfix"></div>';
									$post_widget_count = 0;
								}
								
							$post_widget_count++;
						endwhile; wp_reset_query(); ?>
						</ul>	
					</div>
			<?php }else{
					echo "No products are available to make widget working.";
				  }	
			
			 echo $after_widget;
				}
				function update($new_instance, $old_instance) {
				//save the widget
					$instance = $old_instance;
					$instance['title'] = strip_tags($new_instance['title']);
					$instance['category'] = strip_tags($new_instance['category']);
					$instance['number'] = strip_tags($new_instance['number']);
					$instance['post_type'] = strip_tags($new_instance['post_type']);
					$instance['link'] = strip_tags($new_instance['link']);
					$instance['text'] = strip_tags($new_instance['text']);
					$instance['orderby'] = strip_tags($new_instance['orderby']);
					$instance['order'] = strip_tags($new_instance['order']);
					return $instance;
				}
			 
				function form($instance) {
				//widgetform in backend
					$instance = wp_parse_args( (array) $instance, array(  'title' => '',  'category' => '', 'number' => '', 'post_type'=>'', 'link'=>'', 'text'=>'', 'orderby'=>'', 'order'=>'' ) );
					$title = strip_tags($instance['title']);
					$category = strip_tags($instance['category']);
					$number = strip_tags($instance['number']);
					$my_post_type = strip_tags($instance['post_type']);
					$link = strip_tags($instance['link']);
					$text = strip_tags($instance['text']);
					$orderby = strip_tags($instance['orderby']);
					$order = strip_tags($instance['order']);
			?>
					<p>
						<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:','templatic');?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>
						<p><label for="<?php echo $this->get_field_id('text'); ?>"><?php _e('View All Text :','templatic');?> <input class="widefat" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>" type="text" value="<?php echo esc_attr($text); ?>" /></label></p>
						<p><label for="<?php echo $this->get_field_id('link'); ?>"><?php _e('View All Link URL (ex.http://templatic.com/events):','templatic');?> <input class="widefat" id="<?php echo $this->get_field_id('link'); ?>" name="<?php echo $this->get_field_name('link'); ?>" type="text" value="<?php echo esc_attr($link); ?>" /></label>
					</p>
					<p>
					  <label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of posts:','templatic');?>
					  <input class="widefat" id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo esc_attr($number); ?>" />
					  </label>
					</p>
					<p>
						<label for="<?php echo $this->get_field_id('post_type'); ?>"><?php _e('Post Type:','templatic');?>
						
						<select id="<?php echo $this->get_field_id('post_type'); ?>" name="<?php echo $this->get_field_name('post_type'); ?>">
								<option value="<?php _e("product","templatic");?>"><?php _e("Product","templatic");?></option>
						</select>
						</label>
					</p>
					<p>
					  <label for="<?php echo $this->get_field_id('category'); ?>"><?php _e('Categories (<code>SLUGs</code> separated by commas):','templatic');?>
					  <input class="widefat" id="<?php echo $this->get_field_id('category'); ?>" name="<?php echo $this->get_field_name('category'); ?>" type="text" value="<?php echo esc_attr($category); ?>" />
					  </label>
					</p>
					<p>
					  <label for="<?php echo $this->get_field_id('orderby'); ?>"><?php _e('Order By:','templatic');?>
						
						<select id="<?php echo $this->get_field_id('orderby'); ?>" name="<?php echo $this->get_field_name('orderby'); ?>">
							<option value="date" <?php if($orderby=='date'){?> selected="selected"<?php }?> ><?php _e("Date","templatic");?></option>
							<option value="rand" <?php if($orderby=='rand'){?> selected="selected"<?php }?> ><?php _e("Random","templatic");?></option>
							<option value="title" <?php if($orderby=='title'){?> selected="selected"<?php }?> ><?php _e("Title","templatic");?></option>
						</select>
						</label>
					</p>
					<p>
					  <label for="<?php echo $this->get_field_id('order'); ?>"><?php _e('Order:','templatic');?>
						
						<select id="<?php echo $this->get_field_id('order'); ?>" name="<?php echo $this->get_field_name('order'); ?>">
							<option value="ASC" <?php if($order=='ASC'){?> selected="selected"<?php }?> ><?php _e("Ascending","templatic");?></option>
							<option value="DESC" <?php if($order=='DESC'){?> selected="selected"<?php }?> ><?php _e("Descending","templatic");?></option>
						</select>
						</label>
					</p>
			<?php
				}
			}
		if(is_plugin_active('woocommerce/woocommerce.php') || is_plugin_active('jigoshop/jigoshop.php')){
			register_widget('category_wise_product_listing'); 
		}

	}

/* =============================== Category wise products listing widget END ====================================== */


/* =============================== Small home page product slider widget START ====================================== */
	if(!class_exists('home_small_slider')){
		class home_small_slider extends WP_Widget {
			function home_small_slider() {
			//Constructor
				$widget_ops = array('classname' => 'widget home_small_slider', 'description' => 'List products from a particular category.Use it in "Home Page Slider" widget area' );
				$this->WP_Widget('home_small_slider', 'T &rarr; Catalog Home Products Slider', $widget_ops);
			}

			function widget($args, $instance) {
			// prints the widget
				global $General;
				extract($args, EXTR_SKIP);
				echo $before_widget;
				$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
				$category = empty($instance['category']) ? '' : apply_filters('widget_category', $instance['category']);
				$post_number = empty($instance['post_number']) ? '9' : apply_filters('widget_post_number', $instance['post_number']);
				$orderby = empty($instance['orderby']) ? '' : $instance['orderby'];
				$order = empty($instance['order']) ? '' : $instance['order'];

				if ( !empty( $title ) ) { echo $before_title . $title . $after_title; };?>
			  <script type="text/javascript">
					 var $small_m = jQuery.noConflict();
					 $small_m(window).load(function(){
					  $small_m('.flex-flexslider').flexslider({
						namespace: "flex-flexslider",             //{NEW} String: Prefix string attached to the class of every element generated by the plugin
						selector: ".flex-slides > li",
						animation: "slide",
						slideshow: false,
						slideshowSpeed: 700,
						direction: "horizontal",
						reverse: false,
						animationSpeed: 400,
						animationLoop: false,
						startAt: 0,
						smoothHeight: true,
						easing: "swing",
						pauseOnHover: true,
						controlNav: true, 
						directionNav: true,
						prevText: "Previous",
						nextText: "Next",
						useCSS: false,
						
						// Carousel Slider Options
						itemWidth: 220,                   //{NEW} Integer: Box-model width of individual carousel items, including horizontal borders and padding.
						itemMargin: 0,                 //{NEW} Integer: Margin between carousel items.
						minItems: 4,                    //{NEW} Integer: Minimum number of carousel items that should be visible. Items will resize fluidly when below this.
						maxItems: 4,                    //{NEW} Integer: Maxmimum number of carousel items that should be visible. Items will resize fluidly when above this limit.
						move: 1,                        //{NEW} Integer: Number of carousel items that should move on animation. If 0, slider will move all visible items.
						// Callback API
						start: function(slider){	//Callback: function(slider) - Fires when the slider loads the first slide
						  $small_m('body').removeClass('loading');
						},
						before: function(){},           //Callback: function(slider) - Fires asynchronously with each slider animation
						after: function(){},            //Callback: function(slider) - Fires after each slider animation completes
						end: function(){},              //Callback: function(slider) - Fires when the slider reaches the last slide (asynchronous)
						added: function(){},            //{NEW} Callback: function(slider) - Fires after a slide is added
						removed: function(){}           //{NEW} Callback: function(slider) - Fires after a slide is removed
					  });
					});
					//FlexSlider: Default Settings
				</script>	
			  <div class="flex-flexslider">
				<?php 
					$popular_post_type = "product";
					global $post,$wpdb,$Product;
					$args=array('product_cat' => $category,
							  'post_type' => $popular_post_type,
							  'orderby' => $orderby,
							  'order' => $order,
							  'posts_per_page' => $post_number,
							  'ignore_sticky_posts'=> 1);
					$catalog_products = null;
					$catalog_products = new WP_Query($args);
					if( $catalog_products->have_posts() ) {
				?>
					<div class="slides_container">	
					<ul class="flex-slides">

						   <?php
								while ($catalog_products->have_posts()) : $catalog_products->the_post();
									global $post, $product;
								
							?>
							 <li>
										  
						   <?php /*do_action('woocommerce_before_shop_loop_item_title'); */  
								$post_images =  bdw_get_images_with_info($post->ID,'small_slider_thumbs'); ?>
								<a href="<?php the_permalink() ?>" class="product_thumb">
									<?php 
										if(function_exists("woo_jigo_sale_image")){
											echo woo_jigo_sale_image();
										}
										if($post_images[0]['file']!=""){ 
									?>
                                            <img src="<?php echo $post_images[0]['file']; ?>" alt="<?php the_title(); ?>"  title="<?php the_title(); ?>" width="220" height="220"/>
                                    <?php    
										}else{
									?>
											<img src="<?php echo get_stylesheet_directory_uri()."/images/noimage_220x220.jpg" ?>" alt="<?php the_title(); ?>"  title="<?php the_title(); ?>"  width="220" height="220"/>
                                    <?php 
										}
									?>
								</a>
								<p class="post_content">
									
									<span><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></span> 
									<span><?php if(function_exists("woo_jigo_product_price")){echo woo_jigo_product_price();}?></span>
									<?php woo_jigo_add_to_cart_button($post);?>
								</p> 
							</li>
					  
					  
						 <?php endwhile; ?>
							<?php

					echo '</ul>';
					echo '<div class="clearfix"></div>';	
					echo "</div>";
				}else{
					echo "No products are available to make widget working.";
				}
	echo '</div>';
	echo '<div class="clearfix"></div>';
				echo $after_widget;
			}

			function update($new_instance, $old_instance) {
			//save the widget
				$instance = $old_instance;
				$instance['title'] = strip_tags($new_instance['title']);
				$instance['category'] = strip_tags($new_instance['category']);
				$instance['post_number'] = strip_tags($new_instance['post_number']);
				$instance['orderby'] = strip_tags($new_instance['orderby']);
				$instance['order'] = strip_tags($new_instance['order']);
				return $instance;

			}

			function form($instance) {
			//widgetform in backend
				$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'category' => '', 'post_number' => '', 'orderby' => '', 'order' => '' ) );
				$title = strip_tags($instance['title']);
				$category = strip_tags($instance['category']);
				$post_number = strip_tags($instance['post_number']);
				$order = strip_tags($instance['order']);
				$orderby = strip_tags($instance['orderby']);

		?>
				<p>
					<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Widget Title:','templatic'); ?>
					  <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
					</label>
				</p>
				<p>
				  <label for="<?php echo $this->get_field_id('category'); ?>"><?php _e("Categories (<code>slug</code> separated by commas):","templatic");?>
					<input class="widefat" id="<?php echo $this->get_field_id('category'); ?>" name="<?php echo $this->get_field_name('category'); ?>" type="text" value="<?php echo esc_attr($category); ?>" />
				  </label>
				</p>
				<p>
				  <label for="<?php echo $this->get_field_id('post_number'); ?>"><?php _e("Number of posts:","templatic");?>
					<input class="widefat" id="<?php echo $this->get_field_id('post_number'); ?>" name="<?php echo $this->get_field_name('post_number'); ?>" type="text" value="<?php echo esc_attr($post_number); ?>" />
				  </label>
				</p>
				<p>
				  <label for="<?php echo $this->get_field_id('orderby'); ?>"><?php _e('Order By:','templatic');?>
					
					<select id="<?php echo $this->get_field_id('orderby'); ?>" name="<?php echo $this->get_field_name('orderby'); ?>">
						<option value="date" <?php if($orderby=='date'){?> selected="selected"<?php }?> ><?php _e("Date","templatic");?></option>
						<option value="rand" <?php if($orderby=='rand'){?> selected="selected"<?php }?> ><?php _e("Random","templatic");?></option>
						<option value="title" <?php if($orderby=='title'){?> selected="selected"<?php }?> ><?php _e("Title","templatic");?></option>
					</select>
					</label>
				</p>
				<p>
				  <label for="<?php echo $this->get_field_id('order'); ?>"><?php _e('Order:','templatic');?>
					
					<select id="<?php echo $this->get_field_id('order'); ?>" name="<?php echo $this->get_field_name('order'); ?>">
						<option value="ASC" <?php if($order=='ASC'){?> selected="selected"<?php }?> ><?php _e("Ascending","templatic");?></option>
						<option value="DESC" <?php if($order=='DESC'){?> selected="selected"<?php }?> ><?php _e("Descending","templatic");?></option>
					</select>
					</label>
				</p>
		<?php
			}

		}
	if(is_plugin_active('woocommerce/woocommerce.php') || is_plugin_active('jigoshop/jigoshop.php')){
		register_widget('home_small_slider'); }
	}

/* =============================== Small home page product slider widget END ====================================== */

/* =============================== Home page main slider widget START ====================================== */
add_action('wp_footer','add_nivoslider_js');
	if(!class_exists('home_main_slider')){
		class home_main_slider extends WP_Widget {
			function home_main_slider() {
				//Constructor
				global $thumb_url;
				$widget_ops = array('classname' => 'widget special', 'description' => __('Slider widget with the option to show products or custom images. Use inside "Home Page Slider" area','templatic') );
				$this->WP_Widget('home_main_slider',__('T &rarr; Homepage Main Slider','templatic'), $widget_ops);
			}
			function widget($args, $instance) {
				// prints the widget
				extract($args, EXTR_SKIP);
				//echo $before_widget;
				$custom_banner = empty($instance['custom_banner']) ? '' : $instance['custom_banner'];
				$category = empty($instance['category']) ? '' : apply_filters('widget_category', $instance['category']);
		
				$s1 = empty($instance['s1']) ? '' : apply_filters('widget_s1', $instance['s1']);
				$s1link = empty($instance['s1link']) ? '' : apply_filters('widget_s1', $instance['s1link']);
				$s2 = empty($instance['s2']) ? '' : apply_filters('widget_s2', $instance['s2']);
				$s2link = empty($instance['s2link']) ? '' : apply_filters('widget_s2link', $instance['s2link']);
				$s3 = empty($instance['s3']) ? '' : apply_filters('widget_s3', $instance['s3']);
				$s3link = empty($instance['s3link']) ? '' : apply_filters('widget_s3link', $instance['s3link']);
				$s4 = empty($instance['s4']) ? '' : apply_filters('widget_s4', $instance['s4']);
				$s4link = empty($instance['s4link']) ? '' : apply_filters('widget_s4link', $instance['s4link']);
				$s5 = empty($instance['s5']) ? '' : apply_filters('widget_s5', $instance['s5']);
				$s5link = empty($instance['s5link']) ? '' : apply_filters('widget_s5link', $instance['s5link']);
				$s6 = empty($instance['s6']) ? '' : apply_filters('widget_s6', $instance['s6']);
				$s6link = empty($instance['s6link']) ? '' : apply_filters('widget_s6link', $instance['s6link']);
				$s7 = empty($instance['s7']) ? '' : apply_filters('widget_s7', $instance['s7']);
				$s7link = empty($instance['s7link']) ? '' : apply_filters('widget_s7link', $instance['s7link']);
				$s8 = empty($instance['s8']) ? '' : apply_filters('widget_s8', $instance['s8']);
				$s8link = empty($instance['s8link']) ? '' : apply_filters('widget_s8link', $instance['s8link']);
				$s9 = empty($instance['s9']) ? '' : apply_filters('widget_s9', $instance['s9']);
				$s9link = empty($instance['s9link']) ? '' : apply_filters('widget_s9link', $instance['s9link']);
				$s10 = empty($instance['s10']) ? '' : apply_filters('widget_s10', $instance['s10']);
				$s10link = empty($instance['s10link']) ? '' : apply_filters('widget_s10link', $instance['s10link']);
				
				$animation = empty($instance['animation']) ? 'slide' : apply_filters('widget_number', $instance['animation']);
				$number = empty($instance['number']) ? '5' : apply_filters('widget_number', $instance['number']);
				$height = empty($instance['height']) ? '' : apply_filters('widget_height', $instance['height']);
				$autoplay = empty($instance['autoplay']) ? '' : apply_filters('widget_autoplay', $instance['autoplay']);
				$slideshowSpeed = $instance['slideshowSpeed'];
				$sliding_direction = empty($instance['sliding_direction']) ? 'horizontal' : $instance['sliding_direction'];
				$reverse = empty($instance['reverse']) ? 'false' : $instance['reverse'];
				$animation_speed = empty($instance['animation_speed']) ? '2000' : $instance['animation_speed'];
				
				
				// Carousel Slider Settings
				$is_Carousel = empty($instance['is_Carousel']) ? '' : $instance['is_Carousel'];
				$item_width = empty($instance['item_width']) ? '0' : $instance['item_width'];
				//$item_margin = empty($instance['item_margin']) ? '0' : $instance['item_margin'];
				$min_item = empty($instance['min_item']) ? '0' : $instance['min_item'];
				$max_items = empty($instance['max_items']) ? '0' : $instance['max_items'];
				$item_move = empty($instance['item_move']) ? '0' : $instance['item_move'];
				
				if($item_width==''){
					$item_width=0;
				}
				// if($item_margin==''){
					// $item_margin=0;
				// }
				if($min_item==''){
					$min_item=0;
				}
				if($max_items==''){
					$max_items=0;
				}
				if($item_move==''){
					$item_move=0;
				}
				if($autoplay==''){ $autoplay='false'; }
				if($slideshowSpeed==''){$slideshowSpeed='3000';}
				if($animation_speed==''){$animation_speed='2000';}
				if($autoplay=='false'){ $animation_speed='300000'; }
	?>
				<script type="text/javascript">
					 var $m = jQuery.noConflict();
					 $m(window).load(function(){
					  $m('.flexslider').flexslider({
						animation: "<?php echo $animation;?>",
						slideshow: <?php echo $autoplay;?>,
						slideshowSpeed: <?php echo $slideshowSpeed;?>,
						direction: "<?php echo $sliding_direction;?>",
						reverse: <?php echo $reverse;?>,
						animationSpeed: <?php echo $animation_speed;?>,
						animationLoop: true,
						startAt: 0,
						smoothHeight: true,
						easing: "swing",
						pauseOnHover: true,
						video: true,
						controlNav: true, 
						directionNav: true,
						prevText: "Previous",
						nextText: "Next",
						useCSS: false,
						
						// Carousel Slider Options
						itemWidth: <?php echo $item_width;?>,                   //{NEW} Integer: Box-model width of individual carousel items, including horizontal borders and padding.
						itemMargin: 0, <?php //echo $item_margin;?>                  //{NEW} Integer: Margin between carousel items.
						minItems: <?php echo $min_item;?>,                    //{NEW} Integer: Minimum number of carousel items that should be visible. Items will resize fluidly when below this.
						maxItems: <?php echo $max_items;?>,                    //{NEW} Integer: Maxmimum number of carousel items that should be visible. Items will resize fluidly when above this limit.
						move: <?php echo $item_move;?>,                        //{NEW} Integer: Number of carousel items that should move on animation. If 0, slider will move all visible items.
						// Callback API
						start: function(slider){	//Callback: function(slider) - Fires when the slider loads the first slide
						  $m('body').removeClass('loading');
						},
						before: function(){},           //Callback: function(slider) - Fires asynchronously with each slider animation
						after: function(){},            //Callback: function(slider) - Fires after each slider animation completes
						end: function(){},              //Callback: function(slider) - Fires when the slider reaches the last slide (asynchronous)
						added: function(){},            //{NEW} Callback: function(slider) - Fires after a slide is added
						removed: function(){}           //{NEW} Callback: function(slider) - Fires after a slide is removed
					  });
					});
					//FlexSlider: Default Settings
				</script>
				<?php 
					if(isset($instance['custom_banner']) && $instance['custom_banner'] == 1){
				?>
						<div class="flexslider">
							<div class="slides_container">
								<ul class="slides">
									<?php if ( $s1 <> "" ) { ?><li><a class="" href="<?php echo $s1link; ?>"><img src="<?php echo $s1; ?>"  alt="" width="980" height="425" /></a></li><?php } ?>
									<?php if ( $s2 <> "" ) { ?><li><a  class="" href="<?php echo $s2link; ?>"><img src="<?php echo $s2; ?>" alt="" width="980" height="425" /></a></li><?php } ?>
									<?php if ( $s3 <> "" ) { ?><li><a  class="" href="<?php echo $s3link; ?>"><img src="<?php echo $s3; ?>" alt="" width="980" height="425" /></a></li><?php } ?>
									<?php if ( $s4 <> "" ) { ?><li><a  class="" href="<?php echo $s4link; ?>"><img src="<?php echo $s4; ?>"  alt=""  width="980" height="425"  /></a></li><?php } ?>
									<?php if ( $s5 <> "" ) { ?><li><a  class="" href="<?php echo $s5link; ?>"><img src="<?php echo $s5; ?>" alt=""   width="980" height="425" /></a></li><?php } ?>
									<?php if ( $s6 <> "" ) { ?><li><a class="" href="<?php echo $s6link; ?>"><img src="<?php echo $s6; ?>" alt=""  width="980" height="425" /></a></li><?php } ?>
									<?php if ( $s7 <> "" ) { ?><li><a class="" href="<?php echo $s7link; ?>"><img src="<?php echo $s7; ?>"  alt=""  width="980" height="425"  /></a></li><?php } ?>
									<?php if ( $s8 <> "" ) { ?><li><a class="" href="<?php echo $s8link; ?>"><img src="<?php echo $s8; ?>" alt=""  width="980" height="425" /></a></li><?php } ?>
									<?php if ( $s9 <> "" ) { ?><li><a style="display:block;" class="" href="<?php echo $s9link; ?>"><img src="<?php echo $s9; ?>" alt="" width="980" height="425"  /></a></li><?php } ?>
									<?php if ( $s10 <> "" ) { ?><li><a class="" href="<?php echo $s10link; ?>"><img src="<?php echo $s10; ?>"  alt=""  width="980" height="425"  /></a></li><?php } ?>
								</ul>
								<div class="clearfix"></div>
							</div>
						</div>
						<div class="clearfix"></div>
						
				<?php }else{ ?>
							<div class="flexslider">
								  <div class="slides_container">
								  <ul class="slides">
									<?php
										global $post,$wpdb;
										$counter=0;
										$postperslide = 1;
										$args=array('product_cat' => $category,
										  'post_type' => 'product',
										  'posts_per_page' => $number,
										  'ignore_sticky_posts'=> 1);
										$slide = null;
										$slide = new WP_Query($args);
										if( $slide->have_posts() ) {
											while ($slide->have_posts()) : $slide->the_post();
												global $post;
												$post_images =  bdw_get_images_with_info($post->ID,'home_slider');  
												if($counter=='0' || $counter%$postperslide==0){ echo "<li>";}
											?>
												
												<div class="post_list">
												  <div class="post_img">
													 <a href="<?php the_permalink(); ?>"> 
														<?php if($post_images != "" && !empty($post_images)){?>
																<img  src="<?php echo $post_images[0]['file'];?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" width="875" height="400" />
														<?php }else{?>
																<img  src="<?php echo get_stylesheet_directory_uri()."/images/noimage_980x425.jpg" ?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" width="875" height="400" />
														<?php }?>
													</a>
												 </div>
												 <?php 
												 ?>
												  
												</div>
											   <?php
												$counter++; 
												if($counter%$postperslide==0){ echo "</li>"; }
											endwhile;
										}
									?>

								  </ul>
									<div class="clearfix"></div>
								   </div>
								</div>
								<div class="clearfix"></div>
				
			<?php 
					}
			}
			function update($new_instance, $old_instance) {
				//save the widget
					/* $instance = $old_instance;
					// Widget Get Posts settings
					$instance['custom_banner'] = strip_tags($new_instance['custom_banner']);
					$instance['category'] = strip_tags($new_instance['category']);
					$instance['number'] = strip_tags($new_instance['number']);
					
					// Slider Basic Settings
					$instance['slideshowSpeed'] = strip_tags($new_instance['slideshowSpeed']);
					$instance['autoplay'] = strip_tags($new_instance['autoplay']);
					$instance['animation'] = strip_tags($new_instance['animation']);
					$instance['sliding_direction'] = strip_tags($new_instance['sliding_direction']);
					$instance['reverse'] = strip_tags($new_instance['reverse']);
					$instance['animation_speed'] = strip_tags($new_instance['animation_speed']);
					
					// Carousel Slider Settings
					$instance['is_Carousel'] = strip_tags($new_instance['is_Carousel']);
					$instance['item_width'] = strip_tags($new_instance['item_width']);
					//$instance['item_margin'] = strip_tags($new_instance['item_margin']);
					$instance['min_item'] = strip_tags($new_instance['min_item']);
					$instance['max_items'] = strip_tags($new_instance['max_items']);
					$instance['item_move'] = strip_tags($new_instance['item_move']);
					
					//  If Custom Banner Slider (Settings)
					$instance['s1'] = $new_instance['s1'];
					$instance['s1link'] = $new_instance['s1link'];
					$instance['s2'] = $new_instance['s2'];
					$instance['s2link'] = $new_instance['s2link'];
					$instance['s3'] = $new_instance['s3'];
					$instance['s3link'] = $new_instance['s3link'];
					$instance['s4'] = $new_instance['s4'];
					$instance['s4link'] = $new_instance['s4link'];
					$instance['s5'] = $new_instance['s5'];
					$instance['s5link'] = $new_instance['s5link'];
					$instance['s6'] = $new_instance['s6'];
					$instance['s6link'] = $new_instance['s6link'];
					$instance['s7'] = $new_instance['s7'];
					$instance['s7link'] = $new_instance['s7link'];
					$instance['s8'] = $new_instance['s8'];
					$instance['s8link'] = $new_instance['s8link'];
					$instance['s9'] = $new_instance['s9'];
					$instance['s9link'] = $new_instance['s9link'];
					$instance['s10'] = $new_instance['s10'];
					$instance['s10link'] = $new_instance['s10link']; */
					return $new_instance;
			}
			function form($instance) {
				//widgetform in backend
				$instance = wp_parse_args( (array) $instance, array( 'category' => '', 'number' => '', 'animation'=>'', 'slideshowSpeed'=>'', 'animation_speed'=>'', 'sliding_direction'=>'', 'reverse'=>'', 'item_width'=>'','is_Carousel'=>'',  'min_item'=>'', 'max_items'=>'', 'item_move'=>'', 'custom_banner'=>'','s1' => '','s2' => '','s3' => '','s4' => '','s5' => '','s6' => '','s7' => '','s8' => '','s9' => '','s10' => '','s1link' => '','s2link' => '','s3link' => '','s4link' => '','s5link' => '','s6link' => '','s7link' => '','s8link' => '','s9link' => '','s10link' => '' ) );
				
				// Widget Get Posts settings
				$custom_banner = strip_tags($instance['custom_banner']);
				$category = strip_tags($instance['category']);
				$number = strip_tags($instance['number']);
				
				// Slider Basic Settings
				$autoplay = strip_tags($instance['autoplay']);
				$animation = strip_tags($instance['animation']);
				$slideshowSpeed = strip_tags($instance['slideshowSpeed']);
				$sliding_direction = strip_tags($instance['sliding_direction']);
				$reverse = strip_tags($instance['reverse']);
				$animation_speed = strip_tags($instance['animation_speed']);
				
				// Carousel Slider Settings
				$is_Carousel = strip_tags($instance['is_Carousel']);
				$item_width = strip_tags($instance['item_width']);
				//$item_margin = strip_tags($instance['item_margin']);
				$min_item = strip_tags($instance['min_item']);
				$max_items = strip_tags($instance['max_items']);
				$item_move = strip_tags($instance['item_move']);
				
				//  If Custom Banner Slider (Settings)
				$s1 =  $instance['s1'];
				$s1link = $instance['s1link'];
				$s2 = $instance['s2'];
				$s2link = $instance['s2link'];
				$s3 = $instance['s3'];
				$s3link = $instance['s3link'];
				$s4 = $instance['s4'];
				$s4link = $instance['s4link'];
				$s5 = $instance['s5'];
				$s5link = $instance['s5link'];
				$s6 = $instance['s6'];
				$s6link = $instance['s6link'];
				$s7 = $instance['s7'];
				$s7link = $instance['s7link'];
				$s8 = $instance['s8'];
				$s8link = $instance['s8link'];
				$s9 = $instance['s9'];
				$s9link = $instance['s9link'];
				$s10 = $instance['s10'];
				$s10link = $instance['s10link'];
			?>
				<script type="text/javascript">
					function use_custom_image(id,div_def,div_custom)
					{
						var checked=id.checked;
						jQuery('#'+div_def).slideToggle('slow');
						jQuery('#'+div_custom).slideToggle('slow');
					}
					function use_jcarousel(id,div_id)
					{
						var checked=id.checked;						
						jQuery('#'+div_id).slideToggle('slow');						
					}
				</script>
				<p>
				  <label for="<?php echo $this->get_field_id('animation'); ?>"><?php _e('Animation','templatic'); ?>:
					<select class="widefat" name="<?php echo $this->get_field_name('animation'); ?>" id="<?php echo $this->get_field_id('animation'); ?>">
					  <option <?php if(esc_attr($animation)=='fade'){?> selected="selected"<?php }?> value="fade"><?php _e("Fade","templatic");?></option>
					  <option <?php if(esc_attr($animation)=='slide'){?> selected="selected"<?php }?> value="slide"><?php _e("Slide","templatic");?></option>
					</select>
				  </label>
				</p>
				<p>
				  <label for="<?php echo $this->get_field_id('autoplay'); ?>"><?php _e('Auto Play','templatic'); ?>:
					<select class="widefat" name="<?php echo $this->get_field_name('autoplay'); ?>" id="<?php echo $this->get_field_id('autoplay'); ?>">
					  <option <?php if(esc_attr($autoplay)=='true'){?> selected="selected"<?php }?> value="true"><?php _e("Yes","templatic");?></option>
					  <option <?php if(esc_attr($autoplay)=='false'){?> selected="selected"<?php }?> value="false"><?php _e("No","templatic");?></option>
					</select>
				  </label>
				</p>
				<p>
				  <label for="<?php echo $this->get_field_id('sliding_direction'); ?>"><?php _e('Sliding Direction','templatic'); ?>:
					<select class="widefat" name="<?php echo $this->get_field_name('sliding_direction'); ?>" id="<?php echo $this->get_field_id('sliding_direction'); ?>">
					  <option <?php if(esc_attr($sliding_direction)=='horizontal'){?> selected="selected"<?php }?> value="horizontal"><?php _e("Horizontal","templatic");?></option>
					  <option <?php if(esc_attr($sliding_direction)=='vertical'){?> selected="selected"<?php }?> value="vertical"><?php _e("Vertical","templatic");?></option>
					</select>
				  </label>
				</p>
				<p>
				  <label for="<?php echo $this->get_field_id('reverse'); ?>"><?php _e('Reverse Animation Direction','templatic'); ?>:
					<select class="widefat" name="<?php echo $this->get_field_name('reverse'); ?>" id="<?php echo $this->get_field_id('reverse'); ?>">
					  <option <?php if(esc_attr($reverse)=='false'){?> selected="selected"<?php }?> value="false"><?php _e("False","templatic");?></option>
					  <option <?php if(esc_attr($reverse)=='true'){?> selected="selected"<?php }?> value="true"><?php _e("True","templatic");?></option>
					</select>
				  </label>
				</p>
				<p>
				  <label for="<?php echo $this->get_field_id('slideshowSpeed'); ?>"><?php _e('Slide Show Speed','templatic'); ?>:
					<input class="widefat" id="<?php echo $this->get_field_id('slideshowSpeed'); ?>" name="<?php echo $this->get_field_name('slideshowSpeed'); ?>" type="text" value="<?php echo esc_attr($slideshowSpeed); ?>" />
				  </label>
				</p>
				<p>
				  <label for="<?php echo $this->get_field_id('animation_speed'); ?>"><?php _e('Animation Speed','templatic'); ?>:
					<input class="widefat" id="<?php echo $this->get_field_id('animation_speed'); ?>" name="<?php echo $this->get_field_name('animation_speed'); ?>" type="text" value="<?php echo esc_attr($animation_speed); ?>" />
				  </label>
				</p>
				<p><br/>
					<label for="<?php echo $this->get_field_id('is_Carousel'); ?>">
						<input id="<?php echo $this->get_field_id('is_Carousel'); ?>" name="<?php echo $this->get_field_name('is_Carousel'); ?>" type="checkbox" value="1" <?php if($is_Carousel =='1'){ ?>checked=checked<?php } 
?>style="width:10px;" onclick="use_jcarousel(this,'<?php echo $this->get_field_id('home_slide_carousel'); ?>');"/> <?php _e("<b>Settings for Carousel slider option?</b>",
"templatic");?>	
					</label>
				</p>
				<div id="<?php echo $this->get_field_id('home_slide_carousel'); ?>" style="<?php if($is_Carousel =='1'){ ?>display:block;<?php }else{?>display:none;<?php }?>">
					<p><?php _e("<small><b>This options are only works if Animation type is Slide</b></small>",CATALOG_DOMAIN);?></p>
					<p>
					  <label for="<?php echo $this->get_field_id('item_width'); ?>"><?php _e('Item Width: <br/><small>(Box-model width of individual items, including horizontal borders and padding.)</small>','templatic'); ?>:
						<input class="widefat" id="<?php echo $this->get_field_id('item_width'); ?>" name="<?php echo $this->get_field_name('item_width'); ?>" type="text" value="<?php echo esc_attr($item_width); ?>" />
					  </label>
					</p>
					<p>
					  <label for="<?php echo $this->get_field_id('min_item'); ?>"><?php _e('Min Item <br/><small>(Minimum number of items that should be visible. Items will resize fluidly when below this.)</small>','templatic'); ?>
						<input class="widefat" id="<?php echo $this->get_field_id('min_item'); ?>" name="<?php echo $this->get_field_name('min_item'); ?>" type="text" value="<?php echo esc_attr($min_item); ?>" />
					  </label>
					</p>
					<p>
					  <label for="<?php echo $this->get_field_id('max_items'); ?>"><?php _e('Max Item <br/><small>(Maxmimum number of items that should be visible. Items will resize fluidly when above this limit.)</small>','templatic'); ?>
						<input class="widefat" id="<?php echo $this->get_field_id('max_items'); ?>" name="<?php echo $this->get_field_name('max_items'); ?>" type="text" value="<?php echo esc_attr($max_items); ?>" />
					  </label>
					</p>
					<p>
					  <label for="<?php echo $this->get_field_id('item_move'); ?>"><?php _e('Items Move <br/><small>(Number of items that should move on animation. If 0, slider will move all visible items.)</small>','templatic'); ?>
						<input class="widefat" id="<?php echo $this->get_field_id('item_move'); ?>" name="<?php echo $this->get_field_name('item_move'); ?>" type="text" value="<?php echo esc_attr($item_move); ?>" />
					  </label>
					</p>
				</div>
				<p><br/>
				  <label for="<?php echo $this->get_field_id('custom_banner'); ?>">
					<input id="<?php echo $this->get_field_id('custom_banner'); ?>" name="<?php echo $this->get_field_name('custom_banner'); ?>" type="checkbox" value="1" <?php if($custom_banner =='1'){ ?>checked=checked<?php } ?>style="width:10px;" onclick="use_custom_image(this,'<?php echo $this->get_field_id('home_slide_default'); ?>','<?php echo $this->get_field_id('home_slide_custom'); ?>');"  /> <?php _e('<b>Use custom images?</b>','templatic');?>	<br/> 
				  </label><br/>
				</p>
				
				<div id="<?php echo $this->get_field_id('home_slide_default'); ?>" style="<?php if($custom_banner =='1'){ ?>display:none;<?php }else{?>display:block;<?php }?>">
					<p>
					  <label for="<?php echo $this->get_field_id('category'); ?>">
						<?php _e('Categories (<code>slug</code> separated by commas):','templatic');?>

						<input class="widefat" id="<?php echo $this->get_field_id('category'); ?>" name="<?php echo $this->get_field_name('category'); ?>" type="text" value="<?php echo esc_attr($category); ?>" />
					  </label>
					</p>
					<p>
					  <label for="<?php echo $this->get_field_id('number'); ?>">
						<?php _e('Number of posts:','templatic');?>
						<input class="widefat" id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo esc_attr($number); ?>" />
					  </label>
					</p>
				</div>
				<div id="<?php echo $this->get_field_id('home_slide_custom'); ?>" style="<?php if($custom_banner =='1'){ ?>display:block;<?php }else{?>display:none;<?php }?>">
					<p><label for="<?php echo $this->get_field_id('s1'); ?>"><?php _e('Banner Slider Image 1 full URL <small>(ex.http://templatic.com/images/banner1.png, Image size 980x425 )</small>  :',CATALOG_DOMAIN);?> 
					<input type="text" class="widefat" id="<?php echo $this->get_field_id('s1'); ?>" name="<?php echo $this->get_field_name('s1'); ?>" value="<?php echo esc_attr($s1); ?>"></label>
					</p> 
					<p><label for="<?php echo $this->get_field_id('s1link'); ?>"><?php _e('Banner Slider Image 1 Link <small>(ex.http://templatic.com)</small>  :',CATALOG_DOMAIN);?> 
					<input type="text" class="widefat" id="<?php echo $this->get_field_id('s1link'); ?>" name="<?php echo $this->get_field_name('s1link'); ?>" value="<?php echo esc_attr($s1link); ?>"></label>
					</p>
					<p><label for="<?php echo $this->get_field_id('s2'); ?>"><?php _e('Banner Slider Image 2 full URL :',CATALOG_DOMAIN);?> 
					<input type="text" class="widefat" id="<?php echo $this->get_field_id('s2'); ?>" name="<?php echo $this->get_field_name('s2'); ?>" value="<?php echo esc_attr($s2); ?>"></label>
					</p> 
					<p><label for="<?php echo $this->get_field_id('s2link'); ?>"><?php _e('Banner Slider Image 2 Link :',CATALOG_DOMAIN);?>
					<input type="text" class="widefat" id="<?php echo $this->get_field_id('s2link'); ?>" name="<?php echo $this->get_field_name('s2link'); ?>" value="<?php echo esc_attr($s2link); ?>"></label>
					</p>
					<p><label for="<?php echo $this->get_field_id('s3'); ?>"><?php _e('Banner Slider Image 3 full URL :',CATALOG_DOMAIN);?> 
					<input type="text" class="widefat" id="<?php echo $this->get_field_id('s3'); ?>" name="<?php echo $this->get_field_name('s3'); ?>" value="<?php echo esc_attr($s3); ?>"></label>
					</p> 
					<p><label for="<?php echo $this->get_field_id('s3link'); ?>"><?php _e('Banner Slider Image 3 Link  :',CATALOG_DOMAIN);?>
					<input type="text" class="widefat" id="<?php echo $this->get_field_id('s3link'); ?>" name="<?php echo $this->get_field_name('s3link'); ?>" value="<?php echo esc_attr($s3link); ?>"></label>
					</p>
					<p><label for="<?php echo $this->get_field_id('s4'); ?>"><?php _e('Banner Slider Image 4 full URL :',CATALOG_DOMAIN);?> 
					<input type="text" class="widefat" id="<?php echo $this->get_field_id('s4'); ?>" name="<?php echo $this->get_field_name('s4'); ?>" value="<?php echo esc_attr($s4); ?>"></label>
					</p> 
					<p><label for="<?php echo $this->get_field_id('s4link'); ?>"><?php _e('Banner Slider Image 4 Link :',CATALOG_DOMAIN);?> 
					<input type="text" class="widefat" id="<?php echo $this->get_field_id('s4link'); ?>" name="<?php echo $this->get_field_name('s4link'); ?>" value="<?php echo esc_attr($s4link); ?>"></label>
					</p>
					<p><label for="<?php echo $this->get_field_id('s5'); ?>"><?php _e('Banner Slider Image 5 full URL :',CATALOG_DOMAIN);?> 
					<input type="text" class="widefat" id="<?php echo $this->get_field_id('s5'); ?>" name="<?php echo $this->get_field_name('s5'); ?>" value="<?php echo esc_attr($s5); ?>"></label>
					</p> 
					<p><label for="<?php echo $this->get_field_id('s5link'); ?>"><?php _e('Banner Slider Image 5 Link :',CATALOG_DOMAIN);?> 
					<input type="text" class="widefat" id="<?php echo $this->get_field_id('s5link'); ?>" name="<?php echo $this->get_field_name('s5link'); ?>" value="<?php echo esc_attr($s5link); ?>"></label>
					</p>
					<p><label for="<?php echo $this->get_field_id('s6'); ?>"><?php _e('Banner Slider Image 6 full URL :',CATALOG_DOMAIN);?> 
					<input type="text" class="widefat" id="<?php echo $this->get_field_id('s6'); ?>" name="<?php echo $this->get_field_name('s6'); ?>" value="<?php echo esc_attr($s6); ?>"></label>
					</p> 
					<p><label for="<?php echo $this->get_field_id('s6link'); ?>"><?php _e('Banner Slider Image 6 Link  :',CATALOG_DOMAIN);?>
					<input type="text" class="widefat" id="<?php echo $this->get_field_id('s6link'); ?>" name="<?php echo $this->get_field_name('s6link'); ?>" value="<?php echo esc_attr($s6link); ?>"></label>
					</p>
					<p><label for="<?php echo $this->get_field_id('s7'); ?>"><?php _e('Banner Slider Image 7 full URL :',CATALOG_DOMAIN);?> 
					<input type="text" class="widefat" id="<?php echo $this->get_field_id('s7'); ?>" name="<?php echo $this->get_field_name('s7'); ?>" value="<?php echo esc_attr($s7); ?>"></label>
					</p> 
					<p><label for="<?php echo $this->get_field_id('s7link'); ?>"><?php _e('Banner Slider Image 7 Link :',CATALOG_DOMAIN);?> 
					<input type="text" class="widefat" id="<?php echo $this->get_field_id('s7link'); ?>" name="<?php echo $this->get_field_name('s7link'); ?>" value="<?php echo esc_attr($s7link); ?>"></label>
					</p>
					<p><label for="<?php echo $this->get_field_id('s8'); ?>"><?php _e('Banner Slider Image 8 full URL :',CATALOG_DOMAIN);?> 
					<input type="text" class="widefat" id="<?php echo $this->get_field_id('s8'); ?>" name="<?php echo $this->get_field_name('s8'); ?>" value="<?php echo esc_attr($s8); ?>"></label>
					</p> 
					<p><label for="<?php echo $this->get_field_id('s8link'); ?>"><?php _e('Banner Slider Image 8 Link :',CATALOG_DOMAIN);?> 
					<input type="text" class="widefat" id="<?php echo $this->get_field_id('s8link'); ?>" name="<?php echo $this->get_field_name('s8link'); ?>" value="<?php echo esc_attr($s8link); ?>"></label>
					</p>
					<p><label for="<?php echo $this->get_field_id('s9'); ?>"><?php _e('Banner Slider Image 9 full URL :',CATALOG_DOMAIN);?> 
					<input type="text" class="widefat" id="<?php echo $this->get_field_id('s9'); ?>" name="<?php echo $this->get_field_name('s9'); ?>" value="<?php echo esc_attr($s9); ?>"></label>
					</p> 
					<p><label for="<?php echo $this->get_field_id('s9link'); ?>"><?php _e('Banner Slider Image 9 Link :',CATALOG_DOMAIN);?> 
					<input type="text" class="widefat" id="<?php echo $this->get_field_id('s9link'); ?>" name="<?php echo $this->get_field_name('s9link'); ?>" value="<?php echo esc_attr($s9link); ?>"></label>
					</p>
					<p><label for="<?php echo $this->get_field_id('s10'); ?>"><?php _e('Banner Slider Image 10 full URL :',CATALOG_DOMAIN);?> 
					<input type="text" class="widefat" id="<?php echo $this->get_field_id('s10'); ?>" name="<?php echo $this->get_field_name('s10'); ?>" value="<?php echo esc_attr($s10); ?>"></label>
					</p> 
					<p><label for="<?php echo $this->get_field_id('s10link'); ?>"><?php _e('Banner Slider Image 10 Link :',CATALOG_DOMAIN);?> 
					<input type="text" class="widefat" id="<?php echo $this->get_field_id('s10link'); ?>" name="<?php echo $this->get_field_name('s10link'); ?>" value="<?php echo esc_attr($s10link); ?>"></label>
					</p>
				</div>	
		<?php
			}
		}
		if(is_plugin_active('woocommerce/woocommerce.php') || is_plugin_active('jigoshop/jigoshop.php')){
			register_widget('home_main_slider');
		}	
	}

/* =============================== Home page main slider widget END ====================================== */

/* =============================== Category listing widget START ====================================== */
	if(!class_exists('browse_by_categories')){
		class browse_by_categories extends WP_Widget {
				function browse_by_categories() {
				//Constructor
					$widget_ops = array('classname' => 'widget browse_by_cats', 'description' => __('Display all product categories. Use it in sidebar areas',CATALOG_DOMAIN) );
					$this->WP_Widget('browse_by_cats', __('T &rarr; Browse By Categories',CATALOG_DOMAIN), $widget_ops);
				}
			
				function widget($args, $instance) {
				// prints the widget
					extract($args, EXTR_SKIP);
					echo $before_widget;
					$title = empty($instance['title']) ? '&nbsp;' : apply_filters('widget_category', $instance['title']);
					$show_count = empty($instance['show_count']) ? 0 : apply_filters('widget_show_count', $instance['show_count']);
					if($before_title=='' || $after_title=='')
					{
						$before_title=='<h3>';
						$after_title=='</h3>';
					}
						$post_category_type = "product_cat";
					if ( !empty( $title ) ) { echo $before_title . $title . $after_title; };
					?>
					 <script type="text/javascript">
						var img_url_plus = "<?php echo get_stylesheet_directory_uri().'/images/btn_plus_hov.png'; ?>";
						var img_url_minus = "<?php echo get_stylesheet_directory_uri().'/images/btn_minus_hov.png'; ?>";
					 </script>	
					 <script type="text/javascript" src="<?php echo get_stylesheet_directory_uri(); ?>/js/jquery_essential.js"></script>
					  <ul class="browse_by_category">
						<?php 
						$args = array(
									  'orderby' => 'name',
									  'show_count' => $show_count,
									  'pad_counts' => '',
									  'hierarchical' => true,
									  'hide_empty'         => 0,
									  'taxonomy' => $post_category_type,
									  'title_li' => ''
									);
						wp_list_categories($args);
						?>
					  </ul>
			
				<?php
					echo $after_widget;
				}
			
				function update($new_instance, $old_instance) {
				//save the widget
					$instance = $old_instance;
					$instance['title'] = strip_tags($new_instance['title']);
					$instance['show_count'] = strip_tags($new_instance['show_count']);
					return $instance;
			
				}
			
				function form($instance) {
				//widgetform in backend
					$instance = wp_parse_args( (array) $instance, array( 'title' => 'Categories', 'category' => '' ) );
					$title = strip_tags($instance['title']);
					$show_count = strip_tags($instance['show_count']);
			?>
					<p>
					  <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title','templatic');?> :
					  <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
					  </label>
					</p>

					<p>
					  <label for="<?php echo $this->get_field_id('show_count'); ?>"><?php _e('Show post count with category ',CATALOG_DOMAIN);?>:
						<select id="<?php echo $this->get_field_id('show_count'); ?>" name="<?php echo $this->get_field_name('show_count'); ?>" style="width:50%;">
							<option value="1" <?php if(esc_attr($show_count)==1){ echo 'selected="selected"';}?>><?php _e('Yes','templatic'); ?></option>
							<option value="0" <?php if(esc_attr($show_count)==0){ echo 'selected="selected"';}?>><?php _e('No','templatic'); ?></option>
								  
						</select>
					</p>
			
			<?php
				}
			}
		if(is_plugin_active('woocommerce/woocommerce.php') || is_plugin_active('jigoshop/jigoshop.php')){	
			register_widget('browse_by_categories');
		}
	}
/* =============================== Category listing widget END ====================================== */			

?>