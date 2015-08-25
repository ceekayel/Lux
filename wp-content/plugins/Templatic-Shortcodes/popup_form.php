<?php


// loads the shortcodes class, wordpress is loaded with it
require_once( 'create_html_class.php' );

// get popup type
$popup = trim( $_GET['code'] );
$templ_shortcode = new templ_shortcodes( $popup );
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head></head>
<body>
<div class="wrap" id="templ_popup_form" style="">
	<h3><?php echo $templ_shortcode->popup_title; ?></h3>
	<form method="post" id="templ_shortcode_form">
		<table class="form-table" id="templ_form_table">
		<?php echo $templ_shortcode->output; ?>
		</table>
		<p class="submit" style="width:90%;">
			<a href="#" class="button-primary" id="code-insert" style="float:right;"><?php _e('Insert Shortcode',TSC_DOMAIN); ?></a>
		</p>
	</form>
</div>
</body>
</html>
<style>
.form-table{

	width:97%;
}
input.button-primary, button.button-primary, a.button-primary {
    background: url("../images/button-grad.png") repeat-x scroll left top #21759B;
    border-color: #298CBA;
    color: #FFFFFF !important;
    text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.3);

	margin-bottom: 10px;
}
</style>