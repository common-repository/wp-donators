<?php
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
	?><br />
</div>
<?php
	die ( 'Access Denied' );
}

if (file_exists ( '../wp-content/plugins/wp-donators/.ipn_results.log' )) {
	$html_content = '<h2>' . __ ( 'IPN LOG', 'wp-donators' ) . '</h2>';
	$html_content .= file_get_contents ( '../wp-content/plugins/wp-donators/.ipn_results.log' );
	$find [] = "\n";
	$replace [] = '<br/>';
	$html_content = str_replace ( $find, $replace, $html_content );
	echo $html_content;
} else {
	echo '<h3>' . __ ( 'NO LOG So Far', 'wp-donators' ) . '</h3>';
}
?>
</div>