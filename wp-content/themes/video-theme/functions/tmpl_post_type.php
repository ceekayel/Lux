<?php
/* 
Custom post type
*/

// let's create the function for the custom type

define('CUSTOM_POST_TYPE','videos');
define('CUSTOM_CATEGORY_SLUG','videoscategory');
define('CUSTOM_TAG_SLUG','videostags');

function tmpl_custom_post_type() { 
	// creating (registering) the custom type 
	register_post_type( CUSTOM_POST_TYPE, /* (http://codex.wordpress.org/Function_Reference/register_post_type) */
	 	// let's now add all the options for this post type
			array('label'=>__('Videos','templatic'),
			'labels' => array('name' => __('Video','templatic'),
							'singular_name' 		=> __('Video','templatic'),
							'add_new' 				=> __('Add Video','templatic'),
							'all_items' 			=> __('All Videos', 'templatic'), /* the all items menu item */
							'add_new_item' 			=> __('Add New Video','templatic'),
							'edit' 					=> __('Edit','templatic'),
							'edit_item' 			=> __('Edit Video','templatic'),
							'new_item' 				=> __('New Video','templatic'),
							'view_item'				=> __('View Video','templatic'),
							'search_items' 			=> __('Search Videos','templatic'),
							'not_found' 			=> __('No Videos found','templatic'),
							'not_found_in_trash' 	=> __('No Videos found in trash','templatic'),
							'parent_item_colon' => ''), /* end of arrays */
			'description' => __( 'This is the description of this section', 'templatic' ), /* Custom Type Description */
			'public' => true,
			'publicly_queryable' => true,
			'exclude_from_search' => false,
			'show_ui' => true,
			'query_var' => true,
			'menu_position' => 8, /* this is what order you want it to appear in on the left hand side menu */ 
			'menu_icon' => 'dashicons-video-alt3', /* the icon for the custom post type menu */
			'rewrite'	=> array( 'slug' => 'videos', 'with_front' => false ), /* you can specify its url slug */
			'has_archive' => 'videos', /* you can rename the slug here */
			'capability_type' => 'post',
			'hierarchical' => false,
			/* the next one is important, it tells what's enabled in the post editor */
			'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'trackbacks', 'custom-fields', 'comments', 'revisions', 'sticky')
	 	) /* end of options */
	); /* end of register post type */
	
	/* this adds your post categories to your custom post type */
	/* register_taxonomy_for_object_type('category', 'custom_type'); */ 
	/* this adds your post tags to your custom post type */
	/* register_taxonomy_for_object_type('post_tag', 'custom_type'); */
	
} 

	// adding the function to the Wordpress init
	add_action( 'init', 'tmpl_custom_post_type');
	
	/*
	for more information on taxonomies, go here:
	http://codex.wordpress.org/Function_Reference/register_taxonomy
	*/
	
	// now let's add custom categories (these act like categories)
    register_taxonomy( CUSTOM_CATEGORY_SLUG, 
    	array('videos'), /* if you change the name of register_post_type( 'custom_type', then you have to change this */
    	array('hierarchical' => true,     /* if this is true, it acts like categories */  
			  'label'=> __('Tags','templatic'),
    		  'labels' => array(
    		  'name' 				=> __('Video Category','templatic'),
				'singular_name' 	=> __('Category','templatic'),
				'search_items' 		=> __('Search Category','templatic'),
				'popular_items' 	=> __('Popular Category','templatic'),
				'all_items' 		=> __('All Category','templatic'),
				'parent_item' 		=> __('Parent Category','templatic'),
				'parent_item_colon' => __('Parent Category:','templatic'),
				'edit_item' 		=> __('Edit Category','templatic'),
				'update_item'		=> __('Update Category','templatic'),
				'add_new_item' 		=> __('Add New Category','templatic'),
				'new_item_name' 	=> __('New Make Category','templatic'),
				'rewrite' => array( 'slug' => CUSTOM_CATEGORY_SLUG )),
				'show_admin_column' => true, 
				'show_ui' => true,
				'query_var' => true,
    	) 
	);   
    
	// now let's add custom tags (these act like categories)
    register_taxonomy( CUSTOM_TAG_SLUG, 
    	array('videos'), /* if you change the name of register_post_type( 'custom_type', then you have to change this */
    	array('hierarchical' => false,    /* if this is false, it acts like tags */                
    		'labels' =>array('name' => __('Tags','templatic'),
				'singular_name' 	=> __('Tags','templatic'),
				'search_items' 		=> __('Video Tags','templatic'),
				'popular_items' 	=> __('Popular Video Tags','templatic'),
				'all_items' 		=> __('All Video Tags','templatic'),
				'parent_item' 		=> __('Parent Video Tags','templatic'),
				'parent_item_colon' => __('Parent Video Tags:','templatic'),
				'edit_item' 		=> __('Edit Video Tags','templatic'),
				'update_item'		=> __('Update Video Tags','templatic'),
				'add_new_item' 		=> __('Add New Video Tags','templatic'),
				'new_item_name' 	=> __('New Video Tags Name','templatic')	),  
    		'show_admin_column' => true,
    		'show_ui' => true,
    		'query_var' => true,
    		'rewrite' => array( 'slug' => CUSTOM_TAG_SLUG ),
    	)
    ); 
?>
