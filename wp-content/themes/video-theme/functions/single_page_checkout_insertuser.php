<?php
session_start();
if($_POST['user_email'] != ''){
	if (  $_POST['user_email'] == '' )
	{
		get_header();
		echo "<div class=error_msg>".__('Email for Contact Details is Empty. Please enter Email, your all information will sent to your Email.','templatic')."</div>";	
		echo '<h6><b><a href="'.get_permalink($_POST['cur_post_id']).'/?backandedit=1">Return to '.__(SUBMIT_POST_TEXT).'</a></b></h6>';
		get_footer();
		exit;
	}
	
	if(isset($_REQUEST['action']) && $_REQUEST['action']!='frontend_edit_submit_data'){
		require( 'wp-load.php' );
		require(ABSPATH.'wp-includes/registration.php');
	}

	global $wpdb;
	$errors = new WP_Error();
	
	$user_email = $_POST['user_email'];
	$user_login = $_POST['user_fname'];
	$user_login = sanitize_user( $user_login );
	$user_email = apply_filters( 'user_registration_email', $user_email );
	
	// Check the username
	if ( $user_login == '' )
		$errors->add('empty_username', __('ERROR: Please enter a username.'));
	elseif ( !validate_username( $user_login ) ) {
		$errors->add('invalid_username', __('<strong>ERROR</strong>: This username is invalid.  Please enter a valid username.'));
		$user_login = '';
	} elseif ( username_exists( $user_login ) )
		$errors->add('username_exists', __('<strong>ERROR</strong>: '.$user_email.' This username is already registered, please choose another one.'));
	// Check the e-mail address
	if ($user_email == '') {
		$errors->add('empty_email', __('<strong>ERROR</strong>: Please type your e-mail address.'));
	} elseif ( !is_email( $user_email ) ) {
		$errors->add('invalid_email', __('<strong>ERROR</strong>: The email address isn&#8217;t correct.'));
		$user_email = '';
	} elseif ( email_exists( $user_email ) )
		$errors->add('email_exists', __('<strong>ERROR</strong>: '.$user_email.' This email is already registered, please choose another one.'));
	do_action('register_post', $user_login, $user_email, $errors);	
	
	if($errors)
	{
		foreach($errors as $errorsObj)
		{
			foreach($errorsObj as $key=>$val)
			{
				for($i=0;$i<count($val);$i++)
				{
					echo "<div class=error_msg>".$val[$i].'</div>';	
				}
			} 
		}		
	}	
	if ( $errors->get_error_code() )
	{
		echo '<h6><b><a href="'.get_permalink($_SESSION['custom_fields']['cur_post_id']).'/?backandedit=1">Return to '.__(SUBMIT_POST_TEXT).'</a></b></h6>';
		get_footer();
		exit;
	}
		
	$user_pass = wp_generate_password(12,false);
	$user_id = wp_create_user( $user_login, $user_pass, $user_email );
	$crd = array();
	$crd['user_login'] = $user_login;
	$crd['user_password'] = $user_pass;
	$crd['remember'] = $_POST['remember'];
		if ( !empty($crd['remember']) ):
			$crd['remember'] = true;
		else:
			$crd['remember'] = false;
		endif;
		
		
	$user = wp_signon($crd, true );
	if ( !$user_id ) {
		$errors->add('registerfail', sprintf(__('<strong>ERROR</strong>: Couldn&#8217;t register you... please contact the <a href="mailto:%s">webmaster</a> !','templatic'), get_option('admin_email')));
		exit;
	}
	
	if ( $user_id) 
	{		
		/* set session for check is new user submit post in success page */
                $_SESSION['new_user_register'] = 1;
                
                ///////REGISTRATION EMAIL START//////
		$fromEmail = get_option('admin_email');
		$fromEmailName = stripslashes(get_option('blogname'));
		$store_name = '<a href="'.site_url().'">'.get_option('blogname').'</a>';
		$user_fname = $_POST['user_fname'];

                $subject = "Thank you for registering!";
                 
                $message = "<p>Dear $user_fname</p>";
                $message .= '<p><b>Your login Information :</b></p>';
                $message .= '<p>' . sprintf(__('Username: %s', 'templatic'), $user_login) . "</p>";
                $message .= '<p>' . sprintf(__('Password: %s', 'templatic'), $user_pass) . "</p>";
                $message .= '<p>You can login to : <a href="' . site_url() . '/?ptype=login' . "\">Login</a> or the URL is :  " . site_url() . "/?ptype=login</p>";
                $message .= '<p>Thank You,<br> ' . get_option('blogname') . '</p>';
                
                $to[] = sprintf( '%s <%s>', $user_fname, $user_email );

                $headers  = 'MIME-Version: 1.0' . "\r\n";
                $headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";

                // Additional headers
                $headers .= 'From: '.$fromEmailName.' <'.$fromEmail.'>' . "\r\n";

                $subject = apply_filters('templ_send_email_subject', $subject);
                $message = apply_filters('templ_send_email_content', $message);
                $headers = apply_filters('templ_send_email_headers', $headers);

                wp_mail($to, $subject, $message, $headers);
                //////REGISTRATION EMAIL END////////
	}
	
	return $user_id;
}
?>
