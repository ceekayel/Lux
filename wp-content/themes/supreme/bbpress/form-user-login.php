<?php

/**
 * User Login Form
 *
 * @package bbPress
 * @subpackage Theme
 */

?>

	<form method="post" action="<?php bbp_wp_login_action( array( 'context' => 'login_post' ) ); ?>" class="bbp-login-form">
		<div class="bbp-form">
			<h3><?php _e( 'Log In', 'supreme' ); ?></h3>

			<p class="bbp-username">
				<label for="user_login"><?php _e( 'Username', 'supreme' ); ?>: </label><br>
				<input type="text" name="log" value="<?php bbp_sanitize_val( 'user_login', 'text' ); ?>" size="20" id="user_login" tabindex="<?php bbp_tab_index(); ?>" />
			</p>

			<p class="bbp-password">
				<label for="user_pass"><?php _e( 'Password', 'supreme' ); ?>: </label><br>
				<input type="password" name="pwd" value="<?php bbp_sanitize_val( 'user_pass', 'password' ); ?>" size="20" id="user_pass" tabindex="<?php bbp_tab_index(); ?>" />
			</p>

			<p class="bbp-remember-me">
				<input type="checkbox" name="rememberme" value="forever" <?php checked( bbp_get_sanitize_val( 'rememberme', 'checkbox' ) ); ?> id="rememberme" tabindex="<?php bbp_tab_index(); ?>" />
				<label for="rememberme"><?php _e( 'Keep me signed in', 'supreme' ); ?></label>
			</p>

			<div class="bbp-submit-wrapper">
				<?php do_action( 'login_form' ); ?>
				<input type="submit" name="user-submit" value="<?php _e( 'Log In', 'supreme' ); ?>" tabindex="<?php bbp_tab_index(); ?>" class="user-submit" />
				<?php bbp_user_login_fields(); ?>
			</div>
		</div>
	</form>