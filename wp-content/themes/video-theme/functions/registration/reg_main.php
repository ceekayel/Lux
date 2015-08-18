<?php
/******************************************************************
=======  PLEASE DO NOT CHANGE BELOW CODE  =====
You can add in below code but don't remove original code.
This code to include registration, login and edit profile page.
This file is included in functions.php of theme root at very last php coding line.

You can call registration, login and edit profile page  by the link 
registration : http://mydomain.com/?ptype=register => echo site_url().'/?ptype=register';
login : http://mydomain.com/?ptype=login => echo site_url().'/?ptype=login';
logout : http://mydomain.com/?ptype=login&action=logout => echo site_url().'/?ptype=login&action=logout';
********************************************************************/

define('TEMPL_REGISTRATION_FOLDER',get_template_directory()."/functions/registration/");
define('TEMPL_REGISTRATION_URI',get_template_directory_uri()."/functions/registration/");

//registration.php
define('FORGOT_PW_TEXT',__('Forgot Password?'));
define('USERNAME_EMAIL_TEXT',__('E-mail'));
define('USERNAME_TEXT',__('Username'));
define('PASSWORD_TEXT',__('Password'));
define('REMEMBER_ON_COMPUTER_TEXT',__('Remember me on this computer'));
define('GET_NEW_PW_TEXT',__('Get New Password'));
define('INDICATES_MANDATORY_FIELDS_TEXT',__('Indicates mandatory fields'));
define('REGISTRATION_NOW_TEXT',__('Sign Up Now'));
define('PERSONAL_INFO_TEXT',__('Personal Information'));
define('EMAIL_TEXT',__('E-mail'));
define('FIRST_NAME_TEXT',__('Full Name'));
define('REGISTRATION_MESSAGE',__('(Note: A password will be e-mailed to you for future reference.)'));
define('REGISTER_NOW_TEXT',__('Register Now'));
define('REGISTER_BUTTON',__('Register'));
define('SIGN_IN_BUTTON',__('Sign In'));
define('SIGN_IN_PAGE_TITLE',__('Sign In'));
define('INVALID_USER_PW_MSG',__('Invalid Username/Password.'));
define('REG_COMPLETE_MSG',__('Registration complete. Please check your e-mail for login details.'));
define('NEW_PW_EMAIL_MSG',__('We just sent you a new password. Kindly check your e-mail now.'));
define('EMAIL_CONFIRM_LINK_MSG',__('A confirmation link has been sent to you via email. Kindly check your e-mail now.'));
define('USER_REG_NOT_ALLOW_MSG',__('User registration has been disabled by the admin.'));
define('YOU_ARE_LOGED_OUT_MSG',__('You are now logged out.'));
define('ENTER_USER_EMAIL_NEW_PW_MSG',__('Please enter your e-mail address as username. You will receive a new password via e-mail.'));
define('INVALID_USER_FPW_MSG',__('Invalid Email, please check'));
define('PW_SEND_CONFIRM_MSG',__('Check your e-mail for your new password.'));

//profile.php
define('EDIT_PROFILE_TITLE',__('Edit Profile'));
define('CONFIRM_PASSWORD_TEXT',__('Confirm Password'));
define('EDIT_BUTTON',__('Edit'));
define('EDIT_PROFILE_SUCCESS_MSG',__('Profile edited successfully.'));
define('EMPTY_EMAIL_MSG',__('Please enter Email.'));
define('ALREADY_EXIST_MSG',__('Email already exists, please choose another.'));
define('PW_NO_MATCH_MSG',__('Profile edited successfully.'));


////////filter to retrive the page HTML from the url.
add_filter('templ_add_template_page_filter','templ_add_template_reg_page');
function templ_add_template_reg_page($template)
{
	if(isset($_REQUEST['ptype']) && ($_REQUEST['ptype'] == 'register' || $_REQUEST['ptype'] == 'login'))
	{
		$template =  TEMPL_REGISTRATION_FOLDER . "registration.php";
	}
	return $template;
}

function get_user_nice_name($fname,$lname='')
{
	global $wpdb;
	if($lname)
	{
		$uname = $fname.'-'.$lname;
	}else
	{
		$uname = $fname;
	}
	$nicename = strtolower(str_replace(array("'",'"',"?",".","!","@","#","$","%","^","&","*","(",")","-","+","+"," "),array('','','','-','','-','-','','','','','','','','','','-','-',''),$uname));
	$nicenamecount = $wpdb->get_var("select count(user_nicename) from $wpdb->users where user_nicename like \"$nicename\"");
	if($nicenamecount=='0')
	{
		return trim($nicename);
	}else
	{
		$lastuid = $wpdb->get_var("select max(ID) from $wpdb->users");
		return $nicename.'-'.$lastuid;
	}
}
?>
