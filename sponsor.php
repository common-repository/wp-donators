<?php 
/**
 * Main Sponsors Box
 *
 * @param string $item_number
 * @param string $type
 * @return Sponsors Box html tabs section
 */
function sponsor_box_unit($item_number, $type) { 
	switch ($type) {
		case 'post' : 
			$input_size = "60";
			$help_page = true;
			$sponsoed_table_name = __ ( 'The Page SPONSORED BY', 'wp-donators' );
			$donate_table_name = __ ( 'Become SPONSOR Now', 'wp-donators' );
			break;
		case 'sidebar' :
			$input_size = "25";
			$help_page = false;
			$sponsoed_table_name = __ ( 'SPONSORED', 'wp-donators' );
			$donate_table_name = __ ( 'Donate', 'wp-donators' );
			break;
	}
			
	$replace = donate_form($item_number,$input_size,false);
	if (get_option ( "text_paypal_promote" ) && $type !== 'sidebar') $replace .= paypal_promote_text ();
	if (get_option ( "image_paypal_promote" ) && $type != 'sidebar') $replace .= paypal_promote_image (); 
	elseif ($type != 'sidebar') {$replace .= google_ads('468*60');}
	$show_sponsor = show_sponsor ( $item_number,false );
	$sponsor_box = '<div class="sponsor_box" id="sponsor_box_' . $item_number . '">
            <ul>
                <li><a href="#sponsor_cloud_' . $item_number . '"><span>' .$sponsoed_table_name. '</span></a></li>
                <li><a href="#sponsor_pay_' . $item_number . '"><span>' . $donate_table_name . '</span></a></li>';
	if ($help_page) $sponsor_box .= '<li><a href="#sponsor_help_' . $item_number . '"><span>' . __ ( 'HELP', 'wp-donators' ) . '</span></a></li>';
    $sponsor_box .= '</ul>';
	$help = __ ( 'This a wordpress plugin', 'wp-donators' ) . " <a href='http://wordpress.org/extend/plugins/wp-donators/'>Wp-Donators</a>." . __ ( 'It provides a smart donation function to autoleave the sponsor information in this container after payment. People can donate and submit name/URL or TextLink AD. The information of the latest donors are displayed in the cloud. The more a person donates, the bigger their link will be.It\'s will support most popular payment interface in future. ParPal Just the first one.', 'wp-donators' ) . "<a href='http://www.ericbess.com/ericblog/?p=258'> More..</a><br/>";
	$sponsor_help = '<div id="sponsor_help_' . $item_number . '">' . $help . google_ads ( '728*15' ) . '</div>';
	$replace = $sponsor_box . $show_sponsor . '<div id="sponsor_pay_' . $item_number . '">' . $replace . '</div>';
	if ($help_page) $replace .= $sponsor_help;
	$replace .= '<div class="sponsor_mask"><em>Powered By:<a href="http://www.ericbess.com/ericblog/?p=258" title="Version:'.WD_VERSION.'">WP-DONATORS</a></em></div>';
	$replace .= '</div>';
	return $replace;
}

function textads_form($item_number,$echo=true){
	global $post,$wpdb;
	if ($item_number == 't000') $item_name = 'Blog: ' . get_bloginfo ( 'name' ) . ' Text Link ADs:';
	if (substr(trim($item_number), 0, 2) == "tp") $item_name = 'Text Link Ads - Page:' . $post->post_title;
	$payee_currency = get_option ( "payee_currency" );
	$paypal_sandbox = get_option ( "paypal_sandbox" );
	$cny_payee_mail = get_option ("cny_payee_mail");
	$paypal_mail = get_option ( "paypal_mail" );
	if ($item_number != 't000') $text_price = get_post_meta($post->ID, 'textads_price', true);
	if (! $text_price) $text_price = get_option ( "text_price" );	
	if ($item_number != 't000') $text_unit = get_post_meta($post->ID, 'textads_unit', true);
	if (! $text_unit) $text_unit = get_option ( "text_unit" );
	if ($paypal_sandbox) $paypal_debug = true;
	$dialog_id = 'text_link_dialog';
	if ($item_number == 't000') {$dialog_id .= '_global';}
	$replace = '<div id="'.$dialog_id.'" title="'.__('Buy This Text ADs Link!','wp-donators').'">';
		if ($paypal_sandbox) {
		$replace .= '<form class="sponsor_form" action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">';
	} else {
		$replace .= '<form class="sponsor_form" action="https://www.paypal.com/cgi-bin/webscr" method="post">';
	}
	$replace.='<label>'.__('Your AD Link Name','wp-donators').'</label><input type="text" name="on0" size="50" maxlength="64"/>';
	$replace.='<label>'.__('Your AD Link URL','wp-donators').'</label><input type="text" name="os0" value="http://" size="50" />';
	$replace.='<label>'.__('Your AD Description','wp-donators').'</label><input type="text" name="custom" size="50" maxlength="64" />';	
	$replace.='<label>'.__('Amount','wp-donators').'</label><input type="text" name="amount" value="" size="3" maxlength="10" />';
	$replace.='<span class="pay_flag"></span>';
	$replace .= '<select name="currency_code">
					<option value="USD" '; if ($payee_currency =='USD') $replace .= 'selected="selected"'; $replace.= '>'.__("USD","wp-donators").'</option>
					<option value="CNY" '; if ($cny_payee_mail =='CNY') $replace .= 'selected="selected"'; $replace.= '>'.__("RMB","wp-donators").'</option>
					<option value="AUD" '; if ($payee_currency =='AUD') $replace .= 'selected="selected"'; $replace.= '>'.__("AUD","wp-donators").'</option>
					<option value="GBP" '; if ($payee_currency =='GBP') $replace .= 'selected="selected"'; $replace.= '>'.__("GBP","wp-donators").'</option>
					<option value="CAD" '; if ($payee_currency =='CAD') $replace .= 'selected="selected"'; $replace.= '>'.__("CAD","wp-donators").'</option>
					<option value="CZK" '; if ($payee_currency =='CZK') $replace .= 'selected="selected"'; $replace.= '>'.__("CZK","wp-donators").'</option>
					<option value="DKK" '; if ($payee_currency =='DKK') $replace .= 'selected="selected"'; $replace.= '>'.__("DKK","wp-donators").'</option>
					<option value="EUR" '; if ($payee_currency =='EUR') $replace .= 'selected="selected"'; $replace.= '>'.__("EUR","wp-donators").'</option>
					<option value="HKD" '; if ($payee_currency =='HKD') $replace .= 'selected="selected"'; $replace.= '>'.__("HKD","wp-donators").'</option>
					<option value="HUF" '; if ($payee_currency =='HUF') $replace .= 'selected="selected"'; $replace.= '>'.__("HUF","wp-donators").'</option>
					<option value="JPY" '; if ($payee_currency =='JPY') $replace .= 'selected="selected"'; $replace.= '>'.__("JPY","wp-donators").'</option>
					<option value="MXN" '; if ($payee_currency =='MXN') $replace .= 'selected="selected"'; $replace.= '>'.__("MXN","wp-donators").'</option>
					<option value="NZD" '; if ($payee_currency =='NZD') $replace .= 'selected="selected"'; $replace.= '>'.__("NZD","wp-donators").'</option>
					<option value="NOK" '; if ($payee_currency =='NOK') $replace .= 'selected="selected"'; $replace.= '>'.__("NOK","wp-donators").'</option>
					<option value="PLN" '; if ($payee_currency =='PLN') $replace .= 'selected="selected"'; $replace.= '>'.__("PLN","wp-donators").'</option>
					<option value="SGD" '; if ($payee_currency =='SGD') $replace .= 'selected="selected"'; $replace.= '>'.__("SGD","wp-donators").'</option>
					<option value="SEK" '; if ($payee_currency =='SEK') $replace .= 'selected="selected"'; $replace.= '>'.__("SEK","wp-donators").'</option>
					<option value="CHF" '; if ($payee_currency =='CHF') $replace .= 'selected="selected"'; $replace.= '>'.__("CHF","wp-donators").'</option>
					<option value="TWD" '; if ($payee_currency =='TWD') $replace .= 'selected="selected"'; $replace.= '>'.__("TWD","wp-donators").'</option>
					<option value="THB" '; if ($payee_currency =='THB') $replace .= 'selected="selected"'; $replace.= '>'.__("THB","wp-donators").'</option>
					<option value="PHP" '; if ($payee_currency =='PHP') $replace .= 'selected="selected"'; $replace.= '>'.__("PHP","wp-donators").'</option>	
					<option value="CNY" '; if ($cny_payee_mail =='CNY') $replace .= 'selected="selected"'; $replace.= '>'.__("RMB","wp-donators").'</option>
				</select>';
	$replace .= '<input type="hidden" name="cmd" value="_xclick" />';
	$replace .= '<input type="hidden" name="charset" value="' . get_bloginfo ( 'charset' ) . '" />';
	$replace .= '<input type="hidden" name="business" value="' . $paypal_mail . '" />';
	$replace .= '<input type="hidden" name="item_name" value="' . $item_name . '" />';
	$replace .= '<input type="hidden" name="item_number" value="' . $item_number . '" />';
	$replace .='<input type="hidden" name="cmd" value="_xclick" />';
	$replace .= '<input type="hidden" name="notify_url" value="' . WD_PLUGINDIR_URL . 'paypal.php?action=ipn" />';
	if ($paypal_debug)
		$replace .= '<input type="hidden" name="return" value="' . WD_PLUGINDIR_URL . 'paypal.php?action=success" />';
	else
		$replace .= '<input type="hidden" name="return" value="' . get_self_url () . '" />';
	$replace .= '<input type="hidden" name="rm" value="2" />';
	$replace .= '<input type="image" src="http://www.guru4.net/img/btn-paypal.gif" name="submit" alt="Pay Now!PayPal,fast free and secure!" /> ';
	$replace .= '<span class="s_currency" style="display:none">'.$text_price.'</span>'.'(<span class="currency">'.$text_price.'</span> '.__('dollars','wp-donators').'/'.$text_unit.__('days','wp-donators').')';
	$replace .= '<br/>'.__("Fill out the form, click \"PayPal\" button, you're on your way!",'wp-donators');
	$replace .= '</form>';
	if (get_option ( "text_paypal_promote" )) $replace .= paypal_promote_text ();
	if (get_option ( "image_paypal_promote" )) $replace .= paypal_promote_image (); else {$replace .= google_ads('468*60');}
	$replace .= '<div class="dialog_mask"><em>Powered By:<a href="http://www.ericbess.com/ericblog/?p=258" title="Version:'.WD_VERSION.'">WP-DONATORS</a></em></div>';
	$replace .= '</div>';

	if ($echo)
		echo $replace;
	else
		return $replace;	
}
	
/**
 * Donate Form
 *
 * @param string $item_number
 * @param string $input_size
 * @param bool $echo
 * @return if ($echo) print Donate Form else return Form HTML
 */
function donate_form($item_number,$input_size='40',$echo=true){
	global $post,$wpdb;
	if ($echo == true && strtolower($item_number) == "global") $item_number = '000';
	if ($echo == true && strtolower($item_number) == "post") $item_number = 'p'.$post->ID;
	
	if ($item_number == '000') $item_name = 'Support Blog:' . get_bloginfo ( 'name' );
	if (substr(trim($item_number), 0, 1) == "p") $item_name = 'Support this page:' . $post->post_title;

	$payee_currency = get_option ( "payee_currency" );
	$paypal_sandbox = get_option ( "paypal_sandbox" );
	$cny_payee_mail = get_option ("cny_payee_mail");
	$paypal_mail = get_option ( "paypal_mail" );
	if ($paypal_sandbox) $paypal_debug = true;

	if ($paypal_sandbox) {
		$replace = '<form class="sponsor_form" action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">';
	} else {
		$replace = '<form class="sponsor_form" action="https://www.paypal.com/cgi-bin/webscr" method="post">';
	}
	
	$replace .= '<input type="image" src="' . WD_PLUGINDIR_URL . 'images/textads.png" />';
	$replace .= __ ( 'Name Or TextAds:', 'wp-donators' ) . '<input name="on0" type="text" size="'.$input_size.'" maxlength="' . get_option ( "link_size" ) . '" /><br/>';
	$replace .= '<input type="image" src="' . WD_PLUGINDIR_URL . 'images/www.png" />';
	$replace .= __ ( 'Your URL:', 'wp-donators' ) . '<input name="os0" type="text" size="'.$input_size.'" maxlength="200" value="http://"/><br/> ';
	$replace .= '<input type="image" src="' . WD_PLUGINDIR_URL . 'images/amount.png" />';
	$replace .= __ ( 'Amount:', 'wp-donators' );
	$replace .= '<input name="amount" type="text" size="3" maxlength="10" />';
	$replace .= '<span class="pay_flag"></span>';
	$replace .= '<select name="currency_code">
					<option value="USD" '; if ($payee_currency =='USD') $replace .= 'selected="selected"'; $replace.= '>'.__("USD","wp-donators").'</option>
					<option value="AUD" '; if ($payee_currency =='AUD') $replace .= 'selected="selected"'; $replace.= '>'.__("AUD","wp-donators").'</option>
					<option value="GBP" '; if ($payee_currency =='GBP') $replace .= 'selected="selected"'; $replace.= '>'.__("GBP","wp-donators").'</option>
					<option value="CAD" '; if ($payee_currency =='CAD') $replace .= 'selected="selected"'; $replace.= '>'.__("CAD","wp-donators").'</option>
					<option value="CZK" '; if ($payee_currency =='CZK') $replace .= 'selected="selected"'; $replace.= '>'.__("CZK","wp-donators").'</option>
					<option value="DKK" '; if ($payee_currency =='DKK') $replace .= 'selected="selected"'; $replace.= '>'.__("DKK","wp-donators").'</option>
					<option value="EUR" '; if ($payee_currency =='EUR') $replace .= 'selected="selected"'; $replace.= '>'.__("EUR","wp-donators").'</option>
					<option value="HKD" '; if ($payee_currency =='HKD') $replace .= 'selected="selected"'; $replace.= '>'.__("HKD","wp-donators").'</option>
					<option value="HUF" '; if ($payee_currency =='HUF') $replace .= 'selected="selected"'; $replace.= '>'.__("HUF","wp-donators").'</option>
					<option value="JPY" '; if ($payee_currency =='JPY') $replace .= 'selected="selected"'; $replace.= '>'.__("JPY","wp-donators").'</option>
					<option value="MXN" '; if ($payee_currency =='MXN') $replace .= 'selected="selected"'; $replace.= '>'.__("MXN","wp-donators").'</option>
					<option value="NZD" '; if ($payee_currency =='NZD') $replace .= 'selected="selected"'; $replace.= '>'.__("NZD","wp-donators").'</option>
					<option value="NOK" '; if ($payee_currency =='NOK') $replace .= 'selected="selected"'; $replace.= '>'.__("NOK","wp-donators").'</option>
					<option value="PLN" '; if ($payee_currency =='PLN') $replace .= 'selected="selected"'; $replace.= '>'.__("PLN","wp-donators").'</option>
					<option value="SGD" '; if ($payee_currency =='SGD') $replace .= 'selected="selected"'; $replace.= '>'.__("SGD","wp-donators").'</option>
					<option value="SEK" '; if ($payee_currency =='SEK') $replace .= 'selected="selected"'; $replace.= '>'.__("SEK","wp-donators").'</option>
					<option value="CHF" '; if ($payee_currency =='CHF') $replace .= 'selected="selected"'; $replace.= '>'.__("CHF","wp-donators").'</option>
					<option value="TWD" '; if ($payee_currency =='TWD') $replace .= 'selected="selected"'; $replace.= '>'.__("TWD","wp-donators").'</option>
					<option value="THB" '; if ($payee_currency =='THB') $replace .= 'selected="selected"'; $replace.= '>'.__("THB","wp-donators").'</option>
					<option value="PHP" '; if ($payee_currency =='PHP') $replace .= 'selected="selected"'; $replace.= '>'.__("PHP","wp-donators").'</option>	
					<option value="CNY" '; if ($cny_payee_mail =='CNY') $replace .= 'selected="selected"'; $replace.= '>'.__("RMB","wp-donators").'</option>
				</select>';
	$replace .= '<input type="hidden" name="cmd" value="_xclick" />';
	$replace .= '<input type="hidden" name="charset" value="' . get_bloginfo ( 'charset' ) . '" />';
	$replace .= '<input type="hidden" name="business" value="' . $paypal_mail . '" />';
	$replace .= '<input type="hidden" name="item_name" value="' . $item_name . '" />';
	$replace .= '<input type="hidden" name="item_number" value="' . $item_number . '" />';
//	if (get_option ( "response_agent" ))
//		$replace .= '<input type="hidden" name="notify_url" value="http://www.ericbess.com/lib/wp-donators/paypal.php?action=ipn" />';
//	else
		$replace .= '<input type="hidden" name="notify_url" value="' . WD_PLUGINDIR_URL . 'paypal.php?action=ipn" />';
	if ($paypal_debug)
		$replace .= '<input type="hidden" name="return" value="' . WD_PLUGINDIR_URL . 'paypal.php?action=success" />';
	else
		$replace .= '<input type="hidden" name="return" value="' . get_self_url () . '" />';
	$replace .= '<input type="hidden" name="rm" value="2" />';
//	$replace .= '<input type="submit" name="submit" value="Donate" /> ' 
	$replace .= '<input type="image" src="http://www.guru4.net/img/btn-paypal.gif" name="submit" alt="Pay Now!PayPal,fast free and secure!" /> '
			 .'<span class="s_currency" style="display:none">'. get_option ( "min_link_amount" ) .'</span>'.'<span class="currency">'. get_option ( "min_link_amount" ) .'</span>'. __ ( ' dollar donations or more will appear in the Sponsored cloud. More donations, bigger Link!There is the option of having your name link to a site of your choosing. Simply fill out the form, click the PayPal button and you\'re on your way!', 'wp-donators' ) . '<br/>';
	$replace .= '</form>';
	if ($echo)
		echo $replace;
	else
		return $replace;
}

/**
 * Sponsors cloude
 *
 * @param bool $echo
 * @param string $item_number
 * @return if ($echo) print Cloud else return Cloud HTML
 */
function show_sponsor($item_number,$echo=true) {
	global $post,$wpdb;
//	if (get_option ( "response_agent" )) $cloud = "<div id='sponsor_cloud_" . $item_number . "'></div>";
//	else {
		if ($echo == true && strtolower($item_number) == "global") $item_number = '000';
		if ($echo == true && strtolower($item_number) == "post") $item_number = 'p'.$post->ID;
		
		$table_name = $wpdb->prefix . "payments";
		$timelimit = date ( 'Y-m-d H:i:s', time () - ( int ) get_option ( "link_days" ) * 24 * 3600 );
		$sql = "SELECT date,payment_gross,mc_gross,mc_currency,exchange_rate,donation_website,donation_linktext FROM $table_name 
				WHERE (mc_gross * exchange_rate) >= base_amount AND itemnumber = '$item_number' AND date > '$timelimit'
				ORDER BY donation_linktext ASC";
		$donations = $wpdb->get_results ( $sql );
		
		if (is_array ( $donations ) && $donations) {
			$sizefunc = create_function ( '$x', 'return ' . get_option ( "link_function" ) . ';' );
			foreach ( $donations as $donation ) {
				$date = date ( 'Y/m/d', strtotime ( $donation->date ) );
				if (( int ) $donation->payment_gross != 0)
					$amount = sprintf ( "%01.2f", $donation->payment_gross );
				else {
					$amount = (( float ) $donation->mc_gross) * (( float ) $donation->exchange_rate);
					$amount = sprintf ( "%01.2f", $amount );
				}
				$cloud [] = "<a style='font-size:" . ($sizefunc ( $amount ) / 1) . "px;'" . (get_option ( "nofollow_links" ) == 'true' ? " rel='nofollow'" : '') . " title='" . $donation->mc_gross . " " . $donation->mc_currency . ", $date' href='{$donation->donation_website}'>{$donation->donation_linktext}</a>";
			}
			$cloud = "<div id='sponsor_cloud_" . $item_number . "'>" . implode ( ' ', $cloud ) . "</div>";
		} else
			$cloud = "<div id='sponsor_cloud_" . $item_number . "'>" . __ ( "No donations within the last ", 'wp-donators') . ( int ) get_option ( "link_days" ) . __ ( " days.Who make donation will leave message at here.", 'wp-donators') . "<a onclick=\"$('#sponsor_box_$item_number').tabs('select', 1);\" >" . __ ( "Donate Now", 'wp-donators' ) . ".</a></div>";
//	}
	if ($echo)
		echo $cloud;
	else
		return $cloud;
}

function textads_list ($item_number,$echo=true) {
	global $wpdb;
	$dialog_link_id = 'text_dialog_link';
	if ($item_number == 't000') {$dialog_link_id .= '_global';}
	$table_name = $wpdb->prefix . "payments";
	$sql = "SELECT donation_website,donation_linktext,custom FROM $table_name 
				WHERE TO_DAYS(NOW()) - TO_DAYS(date)<= (mc_gross * exchange_rate*base_days/base_amount) AND itemnumber = '$item_number'
				ORDER BY date ASC";
	$textads_list = $wpdb->get_results ( $sql );
	$text_list = "<ul>";
	if (is_array ( $textads_list ) && $textads_list) {
		foreach ($textads_list as $textads){
			 $text_list .= "<li>";
			 $text_list .= "<a href='$textads->donation_website'>$textads->donation_linktext</a>:$textads->custom";
			 $text_list .= "</li>";
		}

	} else $text_list .= "<li>".__ ( 'No Text AD Link within the last days, you can buy the advertising link!', 'wp-donators' )."</li>";
	$text_list .= '<li><a href="#" id="'.$dialog_link_id.'"  class="ui-state-default ui-corner-all"><span class="dialog_link"><span class="ui-icon ui-icon-newwin"></span>'.__('Buy The AD link','wp-donators').'</span></a></li></ul>';
	if ($echo)
		echo $text_list;
	else
		return $text_list;
}

function mytarget_form($item_number,$echo=true){
	global $post,$wpdb;
	if ($item_number == 'mt000') $item_name = 'Support Target - Blog: ' . get_bloginfo ( 'name' );
		else  $item_name = 'Support Target - Page:' . $post->post_title;
	if (substr(trim($item_number), 0, 2) == "tp") $item_name = 'Text Link Ads - Page:' . $post->post_title;
	$payee_currency = get_option ( "payee_currency" );
	$paypal_sandbox = get_option ( "paypal_sandbox" );
	$cny_payee_mail = get_option ("cny_payee_mail");
	$paypal_mail = get_option ( "paypal_mail" );
	$value = mytarget_value($item_number);
	if ($item_number != 'mt000') $target_price = get_post_meta($post->ID, 'target_price', true);
	if (! $target_price) $target_price = get_option ( "target_price" );	
	if ($paypal_sandbox) $paypal_debug = true;
	$dialog_id = 'target_dialog';
	if ($item_number == 'mt000') {$dialog_id .= '_global';}
	$replace = '<div id="'.$dialog_id.'" title="'.__('Support This Target!','wp-donators').'">';
	//$replace .= mytarget_process($item_number,false,false);
	if ($paypal_sandbox) {
		$replace .= '<form class="sponsor_form" action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">';
	} else {
		$replace .= '<form class="sponsor_form" action="https://www.paypal.com/cgi-bin/webscr" method="post">';
	}
	$replace.='<label>'.__('Sponsor Name','wp-donators').'</label><input type="text" name="on0" size="50" maxlength="64"/>';
	$replace.='<label>'.__('Sponsor URL','wp-donators').'</label><input type="text" name="os0" value="http://" size="50" />';
	$replace.='<label>'.__('Sponsor Comment','wp-donators').'</label><input type="text" name="custom" size="50" maxlength="64" />';	
	$replace.='<label>'.__('Amount','wp-donators').'</label><input type="text" name="amount" value="" size="3" maxlength="10" />';
	$replace.='<span class="pay_flag"></span>';
	$replace .= '<select name="currency_code">
					<option value="USD" '; if ($payee_currency =='USD') $replace .= 'selected="selected"'; $replace.= '>'.__("USD","wp-donators").'</option>
					<option value="AUD" '; if ($payee_currency =='AUD') $replace .= 'selected="selected"'; $replace.= '>'.__("AUD","wp-donators").'</option>
					<option value="GBP" '; if ($payee_currency =='GBP') $replace .= 'selected="selected"'; $replace.= '>'.__("GBP","wp-donators").'</option>
					<option value="CAD" '; if ($payee_currency =='CAD') $replace .= 'selected="selected"'; $replace.= '>'.__("CAD","wp-donators").'</option>
					<option value="CZK" '; if ($payee_currency =='CZK') $replace .= 'selected="selected"'; $replace.= '>'.__("CZK","wp-donators").'</option>
					<option value="DKK" '; if ($payee_currency =='DKK') $replace .= 'selected="selected"'; $replace.= '>'.__("DKK","wp-donators").'</option>
					<option value="EUR" '; if ($payee_currency =='EUR') $replace .= 'selected="selected"'; $replace.= '>'.__("EUR","wp-donators").'</option>
					<option value="HKD" '; if ($payee_currency =='HKD') $replace .= 'selected="selected"'; $replace.= '>'.__("HKD","wp-donators").'</option>
					<option value="HUF" '; if ($payee_currency =='HUF') $replace .= 'selected="selected"'; $replace.= '>'.__("HUF","wp-donators").'</option>
					<option value="JPY" '; if ($payee_currency =='JPY') $replace .= 'selected="selected"'; $replace.= '>'.__("JPY","wp-donators").'</option>
					<option value="MXN" '; if ($payee_currency =='MXN') $replace .= 'selected="selected"'; $replace.= '>'.__("MXN","wp-donators").'</option>
					<option value="NZD" '; if ($payee_currency =='NZD') $replace .= 'selected="selected"'; $replace.= '>'.__("NZD","wp-donators").'</option>
					<option value="NOK" '; if ($payee_currency =='NOK') $replace .= 'selected="selected"'; $replace.= '>'.__("NOK","wp-donators").'</option>
					<option value="PLN" '; if ($payee_currency =='PLN') $replace .= 'selected="selected"'; $replace.= '>'.__("PLN","wp-donators").'</option>
					<option value="SGD" '; if ($payee_currency =='SGD') $replace .= 'selected="selected"'; $replace.= '>'.__("SGD","wp-donators").'</option>
					<option value="SEK" '; if ($payee_currency =='SEK') $replace .= 'selected="selected"'; $replace.= '>'.__("SEK","wp-donators").'</option>
					<option value="CHF" '; if ($payee_currency =='CHF') $replace .= 'selected="selected"'; $replace.= '>'.__("CHF","wp-donators").'</option>
					<option value="TWD" '; if ($payee_currency =='TWD') $replace .= 'selected="selected"'; $replace.= '>'.__("TWD","wp-donators").'</option>
					<option value="THB" '; if ($payee_currency =='THB') $replace .= 'selected="selected"'; $replace.= '>'.__("THB","wp-donators").'</option>
					<option value="PHP" '; if ($payee_currency =='PHP') $replace .= 'selected="selected"'; $replace.= '>'.__("PHP","wp-donators").'</option>	
					<option value="CNY" '; if ($cny_payee_mail =='CNY') $replace .= 'selected="selected"'; $replace.= '>'.__("RMB","wp-donators").'</option>
				</select>';
	$replace .= '<input type="hidden" name="cmd" value="_xclick" />';
	$replace .= '<input type="hidden" name="charset" value="' . get_bloginfo ( 'charset' ) . '" />';
	$replace .= '<input type="hidden" name="business" value="' . $paypal_mail . '" />';
	$replace .= '<input type="hidden" name="item_name" value="' . $item_name . '" />';
	$replace .= '<input type="hidden" name="item_number" value="' . $item_number . '" />';
	$replace .='<input type="hidden" name="cmd" value="_xclick" />';
	$replace .= '<input type="hidden" name="notify_url" value="' . WD_PLUGINDIR_URL . 'paypal.php?action=ipn" />';
	if ($paypal_debug)
		$replace .= '<input type="hidden" name="return" value="' . WD_PLUGINDIR_URL . 'paypal.php?action=success" />';
	else
		$replace .= '<input type="hidden" name="return" value="' . get_self_url () . '" />';
	$replace .= '<input type="hidden" name="rm" value="2" />';
	$replace .= '<input type="image" src="http://www.guru4.net/img/btn-paypal.gif" name="submit" alt="Pay Now!PayPal,fast free and secure!" /> <br/>';
	$replace .= '<span class="s_currency" style="display:none">'.$target_price.'</span>'.__('(My Target','wp-donators') .':<span class="currency">'.$target_price.'</span>'.__(' dollars/','wp-donators').$value.__('% completed)','wp-donators');
	$replace .= '<br/>'.__("Fill out the form, click \"PayPal\" button, you're on your way!",'wp-donators');
	$replace .= '</form>';
	if (get_option ( "text_paypal_promote" )) $replace .= paypal_promote_text ();
	if (get_option ( "image_paypal_promote" )) $replace .= paypal_promote_image (); else {$replace .= google_ads('468*60');}
	$replace .= '<div class="dialog_mask"><em>Powered By:<a href="http://www.ericbess.com/ericblog/?p=258" title="Version:'.WD_VERSION.'">WP-DONATORS</a></em></div>';
	$replace .= '</div>';

	if ($echo)
		echo $replace;
	else
		return $replace;	
}

function mytarget_process ($item_number,$echo=true,$is_link=true) {
	global $post;
	$dialog_link_id = 'target_link';
	$target_class = 'target_progress';
	$value = mytarget_value($item_number);
	if ($item_number != 'mt000') $target_price = get_post_meta($post->ID, 'target_price', true);
	if (! $target_price) $target_price = get_option ( "target_price" );	
	if ($item_number == 'mt000') {
		$dialog_link_id .= '_global';
		$target_class .= '_global';
	}

	$target_process = '<div id="'.$target_class.'"></div>';
	if ($is_link) $target_process .= '<div align="center"><a href="#" id="'.$dialog_link_id.'"  class="ui-state-default ui-corner-all"><span class="dialog_link"><span class="ui-icon ui-icon-newwin"></span>'.__('Support My Target (','wp-donators').$target_price.__(' Dollars Needed/','wp-donators').$value.__('% Completed)','wp-donators').'</span></a></div>';
	
	if ($echo)
		echo $target_process;
	else
		return $target_process;
}

function mytarget_value($item_number){
	global $wpdb,$post;
	if ($item_number != 'mt000') $item_number = 'mt' . $post->ID;
	$table_name = $wpdb->prefix . "payments";
	$sql = "SELECT mc_gross ,exchange_rate FROM $table_name	WHERE itemnumber = '$item_number' ";
	$mytarget_list = $wpdb->get_results ( $sql );
	if ($item_number != 'mt000') $value = get_post_meta($post->ID, 'target_initial_value', true);
	if (! $value) $value = 0;	
	if (is_array ( $mytarget_list ) && $mytarget_list) {
		foreach ($mytarget_list as $mytarget){
			$value = $value + ($mytarget->mc_gross * $mytarget->exchange_rate);
		}
	} 
	if ($item_number != 'mt000') $target_price = get_post_meta($post->ID, 'target_price', true);
	if (! $target_price) $target_price = get_option ( "target_price" );	
	
	$value = round(($value / $target_price) * 100);
	return $value;
}
?>