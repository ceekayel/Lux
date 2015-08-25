<?php 
	require_once('../../../wp-load.php');
	require_once('../../../wp-admin/includes/admin.php');
	do_action('admin_init');
 
	if ( ! is_user_logged_in() )
		die('You must be logged in to access this script.');
 
	if(!isset($shortcodesES))
		$shortcodesES = new TemplaticShortcodes();
 
	global $shortcode_tags,$post;
	$ordered_sct = array_keys($shortcode_tags);
	sort($ordered_sct);
	
?>
 
jQuery(document).ready(function($) {

    tinymce.PluginManager.add('<?php echo $shortcodesES->buttonName; ?>', function( editor,url ) {
		
		var DOM = tinymce.DOM, wpAdvButton, modKey, style;
		
		editor.on('init', function(edtr,url) {
				editor.addCommand( 'openPopup', function( a, params ) {
					var code = params.title;
					var post_id = <?php echo $_GET['post']; ?>
					tb_show("Insert the Shortcode", "<?php echo plugin_dir_url( __FILE__ ); ?>popup_form.php?code=" + code +"&amp;post_id=" +post_id);
				});
				
				
			});
		
        editor.addButton( '<?php echo $shortcodesES->buttonName; ?>', {
            text: 'Shortcodes',
            type: 'listbox',
            icon: false,
            onselect: function(e) {
				editor.execCommand( 'openPopup', false ,{
							title: this.value(),
							});
			},
			values: 
			[
				{text: 'Buttons', value: 'buttons'},
				{text: 'Labels & Badges', value: 'label'},
				{text: 'Content Box', value: 'content_box'},
				{text: 'Small Content Box', value: 'small_content_box'},
				{text: 'Message Box', value: 'msg_box'},
				{text: 'Tabs', value: 'tabs'},
				{text: 'Accordion', value: 'accordion'},
				{text: 'Tooltip', value: 'tooltip'},
				{text: 'Popover', value: 'popover'},
				{text: 'Modal', value: 'modal'},
				{text: 'Scroll', value: 'scroll'},
				{text: 'Dropcaps', value: 'dropcap'},
				{text: 'Column', value: 'column'},
				{text: 'Icons', value: 'icons'},
				{text: 'Progress Bar', value: 'progressbar'},
				{text: 'A Menties List', value: 'mentieslist'},
			],
 
        
        });

        
    });

});
