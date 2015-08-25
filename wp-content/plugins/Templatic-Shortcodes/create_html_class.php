<?php
$absolute_path = __FILE__;
$path_to_file = explode( 'wp-content', $absolute_path );
$path_to_wp = $path_to_file[0];

// Access WordPress
require_once( $path_to_wp . '/wp-load.php' );

class templ_shortcodes
{
	
	
	var	$opt;
	var	$popup;
	var	$params;
	var	$post_id;
	var	$templ_shortcode;
	var $cparams;
	var $cshortcode;
	var $popup_title;
	var $no_preview;
	var $has_child;
	var	$output;
	var	$errors;
	
	function __construct( $popup )
	{
		if( file_exists( dirname(__FILE__) . '/shortcode_options.php' ) )
		{
			$this->opt = dirname(__FILE__) . '/shortcode_options.php';
			$this->code = $popup;
			
			$this->formate_shortcode();
		}
	}
	function formate_shortcode()
	{
		// get option file
		require_once( $this->opt );
		
		if( isset( $shortcodesES[$this->code]['child_shortcode'] ) )
			$this->has_child = true;
		
		if( isset( $shortcodesES ) && is_array( $shortcodesES ) )
		{
			// get shortcode options stuff
			$this->params = $shortcodesES[$this->code]['params'];
			$this->templ_shortcode = $shortcodesES[$this->code]['templ_shortcode'];
			$this->popup_title = $shortcodesES[$this->code]['popup_title'];
			
			// adds stuff for js use			
			$this->append_output( "\n" . '<div id="templ_shortcode" class="hidden">' . $this->templ_shortcode . '</div>' );
			$this->append_output( "\n" . '<div id="templ_popup" class="hidden">' . $this->code . '</div>' );
			
			// filters and excutes params
			foreach( $this->params as $pkey => $param )
			{
				// prefix the fields names and ids with templ_
				$pkey = 'templ_' . $pkey;
				
				// popup form row start
				$row_start .= '<tr class="form-field">' . "\n";
				$row_start  = '<th>' . "\n";
				$row_start .= '<label>' . $param['label'] . '</label>' . "\n";
				$row_start .= '<td>' . "\n";
				
				// popup form row end
				$row_end   .= '</th>' . "\n";
				$row_end   .= '</td>' . "\n";
				$row_end   .= '</tr>' . "\n";
				
				switch( $param['type'] )
				{
					case 'text' :
						
						// prepare
						$output  = $row_start;
						$output .= '<input type="text" class="templ-form-text templ_input" name="' . $pkey . '" id="' . $pkey . '" value="' . $param['std'] . '" />' . "\n";
						$output	.= '<p class="description">' . $param['desc'] . '</p>' . "\n";
						$output .= $row_end;
						
						// append
						$this->append_output( $output );
						
						break;
						
					case 'textarea' :
						
						// prepare
						$output  = $row_start;
						$output .= '<textarea rows="10" cols="30" name="' . $pkey . '" id="' . $pkey . '" class="templ-form-textarea templ_input">' . $param['std'] . '</textarea>' . "\n";
						$output	.= '<p class="description">' . $param['desc'] . '</p>' . "\n";
						$output .= $row_end;
						
						// append
						$this->append_output( $output );
						
						break;
						
					case 'select' :
						
						// prepare
						$output  = $row_start;
						$output .= '<select name="' . $pkey . '" id="' . $pkey . '" class="templ-form-select templ_input">' . "\n";
						
						foreach( $param['options'] as $value => $option )
						{
							$output .= '<option value="' . $value . '">' . $option . '</option>' . "\n";
						}
						
						$output .= '</select>' . "\n";
						$output	.= '<p class="description">' . $param['desc'] . '</p>' . "\n";
						$output .= $row_end;
						
						// append
						$this->append_output( $output );
						
						break;
						
					case 'checkbox' :
						
						// prepare
						$output  = $row_start;
						$output .= '<label for="' . $pkey . '" class="templ-form-checkbox">' . "\n";
						$output .= '<input type="checkbox" class="templ_input" name="' . $pkey . '" id="' . $pkey . '" ' . ( $param['std'] ? 'checked' : '' ) . ' />' . "\n";
						$output .= ' ' . $param['checkbox_text'] . '</label>' . "\n";
						$output	.= '<p class="description">' . $param['desc'] . '</p>' . "\n";
						$output .= $row_end;
						
						// append
						$this->append_output( $output );
						
						break;
					case 'texteditor' :
							// prepare
							$coutput  = $row_start;
							$coutput .= '<textarea rows="10" cols="30" name="' . $cpkey . '" class="mce" id="' . $cpkey . '" class="templ-form-textarea templ_child_input">' . $cparam['std'] . '</textarea>' . "\n";
							$output	.= '<p class="description">' . $param['desc'] . '</p>' . "\n";
							$coutput .= $row_end;
							
							// append
							$this->append_output( $coutput );
							
							break;
				}
			} 
			// checks if has a child shortcode
			if( isset( $shortcodesES[$this->code]['child_shortcode'] ) )
			{
				// set child shortcode
				$this->cparams = $shortcodesES[$this->code]['child_shortcode']['params'];
				$this->cshortcode = $shortcodesES[$this->code]['child_shortcode']['shortcode'];
			
				// popup parent form row start
				$prow_start .= '<tr class="form-field">' . "\n";
				if($this->code == 'icons')
				{
					$prow_start .= '<td colspan="2">' . "\n";
				}
				else
				{
					$prow_start .= '<td>' ."\n";
				}
				
				$prow_start .= '<table class="form-table" id="templ_child_clone">' . "\n";
				
				// for js use
				$prow_start .= '<div id="templ_child_shortcode" class="hidden">' . $this->cshortcode . '</div>' . "\n";
				
				// start the default row
				$prow_start .= '<tbody id="child-clone-row">' . "\n";
				
				// add $prow_start to output
				$this->append_output( $prow_start );
				
				foreach( $this->cparams as $cpkey => $cparam )
				{
				
					// prefix the fields names and ids with templ_
					$cpkey = 'templ_' . $cpkey;
					
					// popup form row start
					$crow_start .= '<tr class="form-field" id="form_field">' . "\n";
					$crow_start  = '<th>' . "\n";
					$crow_start .= '<label>' . $cparam['label'] . '</label>' . "\n";
					$crow_start .= '<td>' . "\n";
					
					// popup form row end
					$crow_end   .= '</th>' . "\n";
					$crow_end   .= '</td>' . "\n";
					$crow_end   .= '</tr>' . "\n";
					
					switch( $cparam['type'] )
					{
						case 'text' :
							
							// prepare
							$coutput  = $crow_start;
							$coutput .= '<input type="text" class="templ-form-text templ_child_input" name="' . $cpkey . '[]" id="' . $cpkey . '" value="' . $cparam['std'] . '" />' . "\n";
							$coutput	  .= '<p class="description">' . $cparam['desc'] . '</p>' . "\n";
							$coutput .= $crow_end;
							
							// append
							$this->append_output( $coutput );
							
							break;
							
						case 'textarea' :
							
							// prepare
							$coutput  = $crow_start;
							$coutput .= '<textarea rows="10" cols="30" name="' . $cpkey . '[]" id="' . $cpkey . '" class="templ-form-textarea templ_child_input">' . $cparam['std'] . '</textarea>' . "\n";
							$coutput	  .= '<p class="description">' . $cparam['desc'] . '</p>' . "\n";
							$coutput .= $crow_end;
							
							// append
							$this->append_output( $coutput );
							
							break;
							
						case 'select' :
							
							// prepare
							$coutput  = $crow_start;
							$coutput .= '<select name="' . $cpkey . '" id="' . $cpkey . '" class="templ-form-select templ_child_input">' . "\n";
							
							foreach( $cparam['options'] as $value => $option )
							{
								$coutput .= '<option value="' . $value . '">' . $option . '</option>' . "\n";
							}
							
							$coutput .= '</select>' . "\n";
							$coutput	  .= '<p class="description">' . $cparam['desc'] . '</p>' . "\n";
							$coutput .= $crow_end;
							
							// append
							$this->append_output( $coutput );
							
							break;
							
						case 'checkbox' :
							
							// prepare
							$coutput  = $crow_start;
							$coutput .= '<label for="' . $cpkey . '" class="templ-form-checkbox">' . "\n";
							$coutput .= '<input type="checkbox" class="templ_child_input" name="' . $cpkey . '" id="' . $cpkey . '" ' . ( $cparam['std'] ? 'checked' : '' ) . ' />' . "\n";
							$coutput .= ' ' . $cparam['checkbox_text'] . '</label>' . "\n";
							$coutput .= '<p class="description">' . $cparam['desc'] . '</p>' . "\n";
							$coutput .= $crow_end;
							
							// append
							$this->append_output( $coutput );
							
							break;
						case 'texteditor' :
							// prepare
							$coutput  = $crow_start;
							$coutput .= '<textarea rows="10" cols="30" name="' . $cpkey . '" class="mce" id="' . $cpkey . '" class="templ-form-textarea templ_child_input">' . $cparam['std'] . '</textarea>' . "\n";
							$coutput .= '<p class="description">' . $cparam['desc'] . '</p>' . "\n";
							$coutput .= $crow_end;
							
							// append
							$this->append_output( $coutput );
							
							break;
					}
				}
				
				// popup parent form row end
				$prow_end   .= '</tbody>' . "\n";
				$prow_end   .= '</table>' . "\n";
				$prow_end   .= '</td>' . "\n";
				$prow_end   .= '</tr>' . "\n";
				$prow_end   .= '<tr id="add_tab_button">' . "\n";
				$prow_end   .= '<td colspan="2"><a href="#" class="submitdelete deletion">'.__('Remove',TSC_DOMAIN).'</a>' . "\n";
				$prow_end   .= '<a href="#" id="form-child-add" class="button-secondary" style="float:right;">' . $shortcodesES[$this->code]['child_shortcode']['clone_button'] . '</a>' . "\n";
				$prow_end   .= '</td></tr>' . "\n";
				
				// add $prow_end to output
				$this->append_output( $prow_end );
			}			
		}
	}
	
	function append_output( $output )
	{
		$this->output = $this->output . "\n" . $output;		
	}
	
	function reset_output( $output )
	{
		$this->output = '';
	}
	
	function append_error( $error )
	{
		$this->errors = $this->errors . "\n" . $error;
	}
}
?>