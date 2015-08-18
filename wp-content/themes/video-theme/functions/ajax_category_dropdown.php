<?php

require( "../../../../wp-load.php");

/* get post type with AAJX in Widget */
$post_type = $_REQUEST['post_type'];
$taxonomies = get_object_taxonomies( (object) array( 'post_type' => $post_type,'public'   => true, '_builtin' => true ));
$var ='';
$terms_obj = get_terms( $taxonomies[0], $args );
foreach($terms_obj as $terms)
{
	if(@$terms->term_id != ''){

	$var .="<option value='".$terms->term_id."' '".$selected."'>".$terms->name."</option>";
	} 
}
echo $var;
?>