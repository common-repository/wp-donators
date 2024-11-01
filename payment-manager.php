<?php
global $WpVersion;
$WpVersion = floatval ( get_bloginfo ( 'version' ) );
if (! current_user_can ( 'manage_options' )) {
	?>
<div class="wrap">
<h2>WP-Donators (V<?php
	print ( WD_VERSION );
	?>) <?php
	_e ( 'Configuration', 'wp-donators' );
	?></h2>
<br />
<div style="color: #770000;"><?php
	_e ( "You are not Options Manager &amp; hence you cannot configure <strong>WP-DONATORS</strong>. If you are admin, then please Logout &amp; Login again.", 'wp-donators' );
	?></div>
<br />
</div>
<?php
	die ( __ ( 'Access Denied', 'wp-donators' ) );
}
if (! get_option ( "container_id" )) {
	update_option ( 'container_id', "1" );
}
if (! get_option ( "target_price" )) {
	update_option ( 'target_price', "100" );
}

if (! get_option ( "payee_default_setting" )) {
	update_option ( 'payee_default_setting', "1" );
	delete_option ( 'paypal_sandbox' );
	update_option ( 'paypal_mail', "" );
	delete_option ( 'payee_admin_status' );
	update_option ( 'payee_admin_mail', get_bloginfo ( 'admin_email' ) );
	update_option ( 'payee_currency', 'USD' );
	delete_option ( 'cny_payee_mail' );
	
	update_option ( 'min_link_amount', "5" );
	update_option ( 'link_days', "60" );
	update_option ( 'text_price', "5" );
	update_option ( 'target_price', "100" );
	update_option ( 'text_unit', "60" );	
	update_option ( 'link_function', 'round( pow($x,1/2.5), 2)*5+1' );
	update_option ( 'link_size', "30" );
	delete_option ( 'nofollow_links' );
	update_option ( 'image_paypal_promote', "1" );
	update_option ( 'text_paypal_promote', "1" );
//	delete_option ( 'respones_agent' );	
}

//update the fesh option into the DB
if ($_POST ['payee_stage'] == 'process') {
	update_option ( 'paypal_sandbox', $_POST ['paypal_sandbox'] );
	update_option ( 'paypal_mail', $_POST ['paypal_mail'] );
	update_option ( 'payee_admin_status', $_POST ['payee_admin_status'] );
	update_option ( 'payee_admin_mail', $_POST ['payee_admin_mail'] );
	update_option ( 'payee_currency', $_POST ['payee_currency'] );
	update_option ( 'cny_payee_mail', $_POST ['cny_payee_mail'] );
	
	update_option ( 'min_link_amount', $_POST ['min_link_amount'] );
	update_option ( 'link_days', $_POST ['link_days'] );
	update_option ( 'text_price', $_POST ['text_price'] );
	update_option ( 'target_price', $_POST ['target_price'] );
	update_option ( 'text_unit', $_POST ['text_unit'] );
	update_option ( 'link_function', $_POST ['link_function'] );
	update_option ( 'link_size', $_POST ['link_size'] );
	update_option ( 'nofollow_links', $_POST ['nofollow_links'] );
	update_option ( 'image_paypal_promote', $_POST ['image_paypal_promote'] );
	update_option ( 'text_paypal_promote', $_POST ['text_paypal_promote'] );
	$payeeERR = "Successfully Saved Settings";
}

//get freshed option from DB
$paypal_sandbox = get_option ( "paypal_sandbox" );
$paypal_mail = get_option ( "paypal_mail" );
$payee_admin_status = get_option ( "payee_admin_status" );
$payee_admin_mail = get_option ( "payee_admin_mail" );
$payee_currency = get_option ( "payee_currency" );
$cny_payee_mail = get_option ( "cny_payee_mail" );

$min_link_amount = get_option ( "min_link_amount" );
$link_days = get_option ( "link_days" );
$text_price = get_option ( "text_price" );
$target_price = get_option ( "target_price" );
$text_unit = get_option ( "text_unit" );
$link_function = get_option ( "link_function" );
$link_size = get_option ( "link_size" );
$nofollow_links = get_option ( "nofollow_links" );
$image_paypal_promote = get_option ( "image_paypal_promote" );
$text_paypal_promote = get_option ( "text_paypal_promote" );
if (! empty ( $payeeERR )) {
	if ($WpVersion < 2) {
		$payeeErrAttributes = " class=\"updated\"";
	} else {
		$payeeErrAttributes = " id=\"message\" class=\"updated fade\"";
	}
	?>
<div <?php
	print ( $payeeErrAttributes );
	?>><br />
<strong><?php
	_e ( $payeeERR );
	?></strong><br />
&nbsp;</div>
<?php
}
?>
<div class="wrap">

<fieldset>
<h2><legend><?php
_e ( "WP-Donators-Configuration", 'wp-donators' );
?></legend></h2>
<table width="100%">
	<tr>
		<td width="85%">
    	<?php
					_e ( "You can configure <strong>WP-Donators</strong> here. It's easy to configure payment setting.<br/>Since the plugin is developing, in the future it will support more payment features and most popular payment interface.<br/>If you find this plugin really useful and would like to contribute to the further development of this plugin, please do donate.All donators will get a link on the <strong><a href=\"http://www.ericbess.com/ericblog/?p=258\">WP-Donators Page</a></strong> and its daily 200 - 500 unique visitors.", 'wp-donators' );
					?>
    	</td>
		<td width="15%">
		<form action="https://www.paypal.com/cgi-bin/webscr" method="post"><input
			type="hidden" name="cmd" value="_donations"> <input type="hidden"
			name="business" value="eric.wzy@gmail.com"> <input type="hidden"
			name="item_name"
			value="Support Wp-Donators, thanks a lot."> <input
			type="hidden" name="item_number" value="p258"> <input type="hidden"
			name="no_shipping" value="0"> <input type="hidden" name="logo_custom"
			value="http://www.ericbess.com/ericblog/wp-content/gallery/illustration/paypal.jpg">
		<input type="hidden" name="no_note" value="1"> <input type="hidden"
			name="currency_code" value="USD"> <input type="hidden" name="tax"
			value="0"> <input type="hidden" name="lc" value="C2"> <input
			type="hidden" name="bn" value="PP-DonationsBF"> <input type="hidden"
			name="notify_url"
			value="http://www.ericbess.com/ericblog/wp-content/plugins/wp-donators/paypal.php?action=ipn" />
		<input type="hidden" name="return"
			value="http://www.ericbess.com/ericblog/?p=258" /> <input
			type="image"
			src="http://www.ericbess.com/ericblog/wp-content/gallery/illustration/paypal.jpg"
			border="0" name="submit" alt="PayPal,fast free and secure!��������"> <img
			alt="" border="0" src="https://www.paypal.com/zh_XC/i/scr/pixel.gif"
			width="1" height="1"></form>
		</td>
	</tr>
</table>
</fieldset>

<form method="post" action="<?php
echo $_SERVER ['REQUEST_URI'];
?>"><input type="hidden" name="payee_stage" value="process" />

<fieldset>

<h3><legend><?php
_e ( 'System Depend On', 'wp-donators' );
?></legend></h3>
<table width="96%" align="center" id="options">
	<tr>
		<td>
<?php
$fp = @fsockopen ( 'ssl://www.paypal.com', "443", $err_num, $err_str, 60 );
if (! $fp) {
	?>
	<div style="color: #770000;"><?php
	_e ( "fsockopen PayPal connection Error No. $err_num: $err_str", 'wp-donators' );
	?></div>
<?php
} else{
	fclose ( $fp );
	_e ( "fsockopen PayPal connection success!", 'wp-donators' );}
?>
		</td>
	</tr>
</table>

<h3><legend><?php
_e ( 'General Option', 'wp-donators' );
?></legend></h3>
<table width="96%" align="center" id="options">
	<tr>
		<td width="60%"><input type="text" name="payee_admin_mail"
			value="<?php
			echo stripslashes ( $payee_admin_mail );
			?>"
			size="50" /> <?php
			_e ( 'Admin Email.', 'wp-donators' );
			?><br />
		<span class="help"><?php
		_e ( 'WP-DONATIONS administrator email,System payment status log receiver mail.', 'wp-donators' );
		?></span></td>

		<td><input type="checkbox" name="payee_admin_status"
			<?php
			if ($payee_admin_status)
				echo "checked=\"1\"";
			?> /><?php
			_e ( 'Send payment log to admin.', 'wp-donators' );
			?><br />
		<span class="help"><?php
		_e ( 'When the payment happened, send the status log to admin mailbox.', 'wp-donators' );
		?>  </span></td>
	</tr>
</table>

<h3><legend><?php
_e ( 'Your PayPal Account', 'wp-donators' );
?></legend></h3>
<table width="96%" align="center" id="ppaccount">
	<tr>
		<td width="60%"><input name="paypal_mail" type="text"
			value="<?php
			echo stripslashes ( $paypal_mail );
			?>"
			size="45" maxlength="100" /> 
				<?php
				_e ( 'PayPal Account Mail.', 'wp-donators' );
				?><br />
		<span class="help"><?php
		_e ( 'Your PayPal Account(mail address).If your haven\'t the paypal account so far.Please register paypal account here:', 'wp-donators' );
		?><a href="https://www.paypal.com/row/mrb/pal=BV4AUWAD94GZG"
			target="_blank"><?php
			_e ( 'PayPal Registration', 'wp-donators' );
			?></a>.</span></td>
		<td><input type="checkbox" name="paypal_sandbox"
			<?php
			if ($paypal_sandbox)
				echo "checked=\"1\"";
			?> /><?php
			_e ( 'Use PayPal Sandbox.' , 'wp-donators');
			?><br />
		<span class="help"><?php
		_e ( 'It\'s sandbox account. You can apply a suit of sandbox accounts on <a href="https://developer.paypal.com/" target="_blank">Developer.PayPal</a> to test the plugin.', 'wp-donators' );
		?>  </span></td>
	</tr>
	<tr>
		<td><input type="text" name="cny_payee_mail"
			value="<?php echo stripslashes($cny_payee_mail); ?>" size="50" /> <?php _e('CNY(RMB) Account.','wp-donators'); ?><br />
		<a href="https://www.paypal.com/cn/mrb/pal=FGQNERFLGMEPN"
			target="_blank"><?php
			_e ( 'China PayPal Registration', 'wp-donators' );
			?></a>. <span class="help"><?php _e('CHINA ACCOUNT, for CNYang(RMB) receive.<br/>If you havn\'t, please consider this opportunity to be donated to author(Keep Blank).','wp-donators'); ?></span>
		</td>

		<td><select name="payee_currency">
			<option value="USD"
				<?php if(($payee_currency=="USD")) { _e(" selected"); } ?>><?php _e('U.S. Dollars','wp-donators'); ?></option>
			<option value="AUD"
				<?php if(($payee_currency=="AUD")) { _e(" selected"); } ?>><?php _e('Australian Dollars','wp-donators'); ?></option>
			<option value="GBP"
				<?php if(($payee_currency=="GBP")) { _e(" selected"); } ?>><?php _e('British Pounds','wp-donators'); ?></option>
			<option value="CAD"
				<?php if(($payee_currency=="CAD")) { _e(" selected"); } ?>><?php _e('Canadian Dollars','wp-donators'); ?></option>
			<option value="CZK"
				<?php if(($payee_currency=="CZK")) { _e(" selected"); } ?>><?php _e('Czech Koruna','wp-donators'); ?></option>
			<option value="DKK"
				<?php if(($payee_currency=="DKK")) { _e(" selected"); } ?>><?php _e('Danish Kroner','wp-donators'); ?></option>
			<option value="EUR"
				<?php if(($payee_currency=="EUR")) { _e(" selected"); } ?>><?php _e('Euro','wp-donators'); ?></option>
			<option value="HKD"
				<?php if(($payee_currency=="HKD")) { _e(" selected"); } ?>><?php _e('Hong Kong Dollars','wp-donators'); ?></option>
			<option value="HUF"
				<?php if(($payee_currency=="HUF")) { _e(" selected"); } ?>><?php _e('Hungarian Forint','wp-donators'); ?></option>
			<option value="JPY"
				<?php if(($payee_currency=="JPY")) { _e(" selected"); } ?>><?php _e('Japanese Yen','wp-donators'); ?></option>
			<option value="MXN"
				<?php if(($payee_currency=="MXN")) { _e(" selected"); } ?>><?php _e('Mexican Peso','wp-donators'); ?></option>
			<option value="NZD"
				<?php if(($payee_currency=="NZD")) { _e(" selected"); } ?>><?php _e('New Zealand Dollars','wp-donators'); ?></option>
			<option value="NOK"
				<?php if(($payee_currency=="NOK")) { _e(" selected"); } ?>><?php _e('Norwegian Kroner','wp-donators'); ?></option>
			<option value="PLN"
				<?php if(($payee_currency=="PLN")) { _e(" selected"); } ?>><?php _e('Polish Zlotych','wp-donators'); ?></option>
			<option value="SGD"
				<?php if(($payee_currency=="SGD")) { _e(" selected"); } ?>><?php _e('Singapore Dollars','wp-donators'); ?></option>
			<option value="SEK"
				<?php if(($payee_currency=="SEK")) { _e(" selected"); } ?>><?php _e('Swedish Kronor','wp-donators'); ?></option>
			<option value="CHF"
				<?php if(($payee_currency=="CHF")) { _e(" selected"); } ?>><?php _e('Swiss Franc','wp-donators'); ?></option>
			<option value="CHF"
				<?php if(($payee_currency=="TWD")) { _e(" selected"); } ?>><?php _e('Taiwan Dollar','wp-donators'); ?></option>
			<option value="CHF"
				<?php if(($payee_currency=="THB")) { _e(" selected"); } ?>><?php _e('Thai Baht','wp-donators'); ?></option>
			<option value="CHF"
				<?php if(($payee_currency=="PHP")) { _e(" selected"); } ?>><?php _e('Philippine Peso','wp-donators'); ?></option>
		</select> <?php _e('Primary Currency.','wp-donators'); ?> <br />
		<span class="help"><?php _e('Let you receive money, without opening a currency balance.','wp-donators'); ?><a
			href="https://cms.paypal.com/us/cgi-bin/?cmd=_render-content&content_ID=developer/howto_admin_setup"
			target="_blank"><?php
			_e ( 'Learn More', 'wp-donators' );
			?></a>.</span></td>
	</tr>
</table>
</fieldset>

<fieldset>
<h3><legend><?php
_e ( 'Sponsor Option', 'wp-donators' );
?></legend></h3>
<table width="96%" align="center" id="options">
	<tr>
		<td width="60%"><input type="text" name="min_link_amount"
			value="<?php
			echo stripslashes ( $min_link_amount );
			?>"
			size="6" /> <?php
			_e ( 'Minimum amount for a donation.', 'wp-donators' );
			?><br />
		<span class="help"><?php
		_e ( 'The minimum amount for a donation to get displayed.Set to a reasonable value for your currency and your website.', 'wp-donators' );
		?></span></td>
		<td><input type="text" name="link_days"
			value="<?php
			echo stripslashes ( $link_days );
			?>" size="6" /> <?php
			_e ( 'Sponsor link days.', 'wp-donators' );
			?><br />
		<span class="help"><?php
		_e ( 'How many days will a link be displayed.', 'wp-donators' );
		?></span></td>
	</tr>
	<tr>
		<td width="60%"><input type="text" name="link_function"
			value='<?php
			echo stripslashes ( $link_function );
			?>'
			size="40" /> <?php
			_e ( 'LinkSize_Function.', 'wp-donators' );
			?><br />
		<span class="help"><?php
		_e ( 'This function calculates the link size in relation to the donation amount $x.It ensures that donations are not too tiny or large.Use it with the syntax of a PHP expression.', 'wp-donators' );
		?></span></td>
		<td><input type="text" name="link_size"
			value="<?php
			echo stripslashes ( $link_size );
			?>" size="6" /> <?php
			_e ( 'Sponsor link text size (max 64).', 'wp-donators' );
			?><br />
		<span class="help"><?php
		_e ( 'The maximum Sponsor link text words size.', 'wp-donators' );
		?></span></td>
	</tr>

	<tr>
		<td width="60%"><input type="checkbox" name="nofollow_links"
			<?php
			if ($nofollow_links)
				echo "checked=\"1\"";
			?> /><?php
			_e ( 'Nofollow Link.', 'wp-donators' );
			?><br />
		<span class="help"><?php
		_e ( 'If you are afraid of Google punishment, set this to "checked",if you apprechiate donations, do not.', 'wp-donators' );
		?>  </span></td>

		<td><input type="checkbox" name="image_paypal_promote"
			<?php
			if ($image_paypal_promote)
				echo "checked=\"1\"";
			?> /><?php
			_e ( 'Image Promotion', 'wp-donators');
			?>
				<input type="checkbox" name="text_paypal_promote"
			<?php
			if ($text_paypal_promote)
				echo "checked=\"1\"";
			?> /><?php
			_e ( 'Text Promotion', 'wp-donators');
			?><br />
		<span class="help"><?php
		_e ( 'Recommend people to register paypal account on your payment form.It will promote your earning.', 'wp-donators');
		?>  </span></td>
	</tr>
</table>
</fieldset>

<fieldset>
<h3><legend><?php
_e ( 'Text AD Link Option', 'wp-donators' );
?></legend></h3>
<table width="96%" align="center" id="options">
	<tr>
		<td width="60%"><input type="text" name="text_price"
			value="<?php
			echo stripslashes ( $text_price );
			?>"
			size="6" /> <?php
			_e ( 'Unit Price.', 'wp-donators' );
			?><br />
		<span class="help"><?php
		_e ( 'Default Text AD link unit price.', 'wp-donators' );
		?></span></td>
		<td><input type="text" name="text_unit"
			value="<?php
			echo stripslashes ( $text_unit );
			?>" size="6" /> <?php
			_e ( 'Display days /unit.', 'wp-donators' );
			?><br />
		<span class="help"><?php
		_e ( 'Default Text AD link display days per unit.', 'wp-donators' );
		?></span></td>
	</tr>
</table>
</fieldset>

<fieldset>
<h3><legend><?php
_e ( 'My Target Option', 'wp-donators' );
?></legend></h3>
<table width="96%" align="center" id="options">
	<tr>
		<td width="60%"><input type="text" name="target_price"
			value="<?php
			echo stripslashes ( $target_price );
			?>"
			size="6" /> <?php
			_e ( 'My Target Price.', 'wp-donators' );
			?><br />
		<span class="help"><?php
		_e ( 'Default My Target price.', 'wp-donators' );
		?></span></td>
	</tr>
</table>
</fieldset>

<fieldset class="submit">
<h3><legend><?php
_e ( 'Configuration Complete', 'wp-donators' );
?></legend></h3>
<div align="center"><input type="submit"
	value="<?php
	_e ( 'Update Options', 'wp-donators' );
	?>" /> &nbsp; <input name="reset" type="reset"
	value="<?php
	_e ( 'Reset', 'wp-donators' );
	?>" /></div>
</fieldset>

</form>
</div>

