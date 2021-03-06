<?php
/*
 * edit the payment gateway option
 */
global $wpdb;
if($_POST)
{
	$paymentupdsql = "select option_value from $wpdb->options where option_id='".$_GET['id']."'";
	$paymentupdinfo = $wpdb->get_results($paymentupdsql);
	if($paymentupdinfo)
	{
		foreach($paymentupdinfo as $paymentupdinfoObj)
		{
			$option_value = unserialize($paymentupdinfoObj->option_value);
			$payment_method = trim($_POST['payment_method']);
			$display_order = trim($_POST['display_order']);
			$paymet_isactive = $_POST['paymet_isactive'];
			$paymet_mode = $_POST['paypal_mode'];
			
			if($payment_method)
			{
				$option_value['name'] = $payment_method;
			}
			$option_value['display_order'] = $display_order;
			$option_value['isactive'] = $paymet_isactive;
			$option_value['paypal_mode'] = $paymet_mode;
			
			$paymentOpts = $option_value['payOpts'];
			for($o=0;$o<count($paymentOpts);$o++)
			{
				$paymentOpts[$o]['value'] = $_POST[$paymentOpts[$o]['fieldname']];
			}
			$option_value['payOpts'] = $paymentOpts;
			$option_value_str = serialize($option_value);
		}
	}
	$updatestatus = "update $wpdb->options set option_value= '$option_value_str' where option_id='".$_GET['id']."'";
	$wpdb->query($updatestatus);
	$location = site_url()."/wp-admin/admin.php";
	echo '<form method=get name="payment_setting_frm" acton="'.$location.'">
	<input type="hidden" name="id" value="'.$_GET['id'].'"><input type="hidden" name="page" value="monetization"><input type="hidden" name="tab" value="payment_options"><input type="hidden" name="msg" value="success"></form>
	<script>document.payment_setting_frm.submit();</script>
	';
	
}
if(isset($_GET['status']) && $_GET['status']!= '')
{
	$option_value['isactive'] = $_GET['status'];
}
	$paymentupdsql = "select option_value from $wpdb->options where option_id='".$_GET['id']."'";
	$paymentupdinfo = $wpdb->get_results($paymentupdsql);
	if($paymentupdinfo)
	{
		foreach($paymentupdinfo as $paymentupdinfoObj)
		{
			$option_value = unserialize($paymentupdinfoObj->option_value);
			$paymentOpts = $option_value['payOpts'];
		}
	}
?>
<div class="wrap">
<h2><?php echo sprintf(__('%s Settings','templatic-admin'),$option_value['name']); ?> 
<a class="add-new-h2" href="<?php echo site_url();?>/wp-admin/admin.php?page=monetization&tab=payment_options" name="btnviewlisting"  title="<?php echo __('Back to Payment Options List','templatic-admin');?>"/><?php echo __('Back to Payment Options List','templatic-admin'); ?></a>
</h2>
 <?php if(isset($_GET['msg']) && $_GET['msg']!=''){ ?>
  <div class="updated fade below-h2" id="message" style="padding:5px; font-size:12px;" >
    <?php echo __('Updated Successfully','templatic-admin'); ?>
  </div>
<?php }?>
<form action="<?php echo site_url();?>/wp-admin/admin.php?page=monetization&payact=setting&id=<?php echo $_GET['id'];?>&tab=payment_options" method="post" name="payoptsetting_frm" enctype="multipart/form-data">
	<table style="width:60%"  class="form-table">
	<thead>
		<tr>
			<th colspan="2"><?php echo __('Edit the payment option settings. Double check the values you enter here to avoid payment related problems.','templatic-admin');?></th>
		</tr>
	</thead>
	<tbody>
	<tr>
	<th><?php echo __('Payment method name','templatic-admin'); ?></th>
	<td> <input type="text" name="payment_method" id="payment_method" value="<?php echo $option_value['name'];?>" size="50" /><p class="description"><?php echo __('It will act as a name (label) of your payment method on your site','templatic-admin');?></p></td>
	</tr>
	
	<tr>
	<th><?php echo __('Default Status','templatic-admin'); ?></th>
	<td>  <select name="paymet_isactive" id="paymet_isactive">
            <option value="1" <?php if($option_value['isactive']==1){?> selected="selected" <?php }?>><?php echo __('Activate','templatic-admin');?></option>
            <option value="0" <?php if($option_value['isactive']=='0' || $option_value['isactive']==''){?> selected="selected" <?php }?>><?php echo __('Deactivate','templatic-admin');?></option>
          </select><p class="description"><?php echo __('Active status will show this payment method on your site','templatic-admin');?></p>
	</td>
    <?php if($option_value['key'] == 'paypal')
	{?>
	<tr>
		<th><?php echo __('Use in test mode?','templatic-admin');?></th>
		<td>
			<input type="checkbox" name="paypal_mode" id="paypal_mode" value="1" <?php if($option_value['paypal_mode'] == 1){echo 'checked';}?>> 
			<p class="description"><?php echo __('Check this if you want to use paypal in test mode.','templatic-admin'); ?></p>
		</td>
		</tr>
	</tr>
    <?php } ?>
	<tr>
		<th><?php echo __('Position (Display order)','templatic-admin'); ?></th>
		<td> <input type="text" name="display_order" id="display_order" value="<?php echo $option_value['display_order'];?>" size="50"  />		
		 <p class="description"><?php echo __('This is a numeric value that determines the position of this payment option in the list. e.g. 5','templatic-admin'); ?></p></td>
	</tr>
	
  
    <?php
	for($i=0;$i<count($paymentOpts);$i++)
	{
		$payOpts = $paymentOpts[$i];
	?>
		<tr>
		<th><?php echo sprintf(__('%1$s','templatic-admin'),__($payOpts['title'],'templatic-admin'));?></th>
		<td>
			<?php if(@$payOpts['type']=="" || $payOpts['type']=="text")
				  {
			?>
					<input type="text" name="<?php echo $payOpts['fieldname'];?>" id="<?php echo $payOpts['fieldname'];?>" value="<?php echo $payOpts['value'];?>" size="50"  />
			<?php }
				  elseif(@$payOpts['type']!="" && $payOpts['type']=="checkbox")
				  {
			?>
					<input type="checkbox" name="<?php echo $payOpts['fieldname'];?>" id="<?php echo $payOpts['fieldname'];?>" value="1" <?php if($payOpts['value']!="" && $payOpts['value']=="1"){echo "checked='checked'";};?>  />
			<?php }
				  elseif(@$payOpts['type']!="" && $payOpts['type']=="radio")
				  {
					if(isset($payOpts['options']) && !empty($payOpts['options'])){
						foreach($payOpts['options'] as $values){
				?>
							<label><input type="radio" name="<?php echo $payOpts['fieldname'];?>" id="<?php echo $payOpts['fieldname'];?>"  <?php if($payOpts['value']!="" && $payOpts['value']==$values){echo "checked='checked'";};?> value="<?php echo $values;?>"  /> <?php echo $values;?></label>
				<?php 	}
					}else{
						echo "<i>".__("Please add 'options' parameter to your plugin's install.php file to use radio button feature.",'templatic-admin')." <br/>
							  <code>
								<b>	eg: 'options'		=>	array('Male','Female'),	</b>
							  </code></i>";
					}
				  }
				 ?> 
		  <p class="description"><?php echo __($payOpts['description'],'templatic-admin');?></p>
		</td>
		</tr> <!-- #end -->
	<?php
	}
	?>
	<?php if(strtolower($option_value['name']) == strtolower('Pre Bank Transfer') ){ ?>	
		<tr>
			<td colspan="2">
				<?php echo __('To further edit the information that displays on the Pre Bank success page <a href="'.admin_url().'admin.php?page=templatic_settings&tab=email" title="" target="_blank"> Click here</a> and change Payment via bank transfer success notification message.','templatic-admin'); ?>
			</td>
		</tr>
	<?php } ?>	
	<tr><td colspan="2">
	<input type="submit" name="submit" value="<?php echo __('Save all changes','templatic-admin'); ?>" onclick="return chk_form();" class=" button-primary button button-hero" />
	</td></tr>
	</tbody>	
	</table>
</form>
</div>
<script>
function chk_form()
{
	if(document.getElementById('payment_method').value == '')
	{
		
		alert('<?php echo __('Please enter Payment Method','templatic-admin');?>');
		document.getElementById('payment_method').focus();
		return false;
	}
	return true;
}
</script>
