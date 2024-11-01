<?php
/*
Plugin Name: WP-Donators
Plugin URI: http://www.ericbess.com/ericblog/?p=258
Description: A lot of features to monetize your blog! Support: Sponsors Box,Text Link ADs,My Target, etc.
Author: Eric Wang
Version: 1.1.16
Author URI: http://www.ericbess.com/ericblog/
*/

/**
 * WordPress Plugin WP-Donators Main File
 *
 * It provides smart accepting money feature for your blog! 
 * It'll autoleave the sponsor information in a container after payment, support popular feature and interface in future. 
 * ParPal Just the first one.
 * 
 * @author Eric.Wang <eric.wzy@gmail.com>
 * @version 1.1.16
 * @copyright Copyright (c) 2008, EricBess.com
 * @copyright under the terms of the Creative Commons Attribution-No Derivative License.http://creativecommons.org/licenses/by-nd/3.0/
 */

define ( 'WD_PLUGINDIR_URL', get_bloginfo ( 'wpurl' ) . '/wp-content/plugins/wp-donators/' );
define ( 'WD_VERSION', "1.1.16" );

/**
 * Create Text Domain For Translations
 * 
 */
add_action ( 'init', 'wp_donators_textdomain' );
function wp_donators_textdomain() {
	if (! function_exists ( 'wp_print_styles' )) {
		load_plugin_textdomain ( 'wp-donators', 'wp-content/plugins/donators' );
	} else {
		load_plugin_textdomain ( 'wp-donators', false, 'wp-donators' );
	}
}

include_once ('function.php');
include_once ('main.php');
include_once ('sponsor.php');

register_activation_hook ( __FILE__, 'pm_table_install' );
add_action ( 'admin_menu', 'donators_menu' );

add_action('wp_print_scripts', 'wp_donators_ScriptsAction');
function wp_donators_ScriptsAction ()
{
    if (! is_admin()) {
        wp_enqueue_script('jquery');
        wp_enqueue_script('jquery-ui', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.1/jquery-ui.min.js', array('jquery'),'1.7.1');
		wp_enqueue_script('wp-donators', WD_PLUGINDIR_URL . 'js/wp-donators.js',array('jquery','jquery-ui'),'0.1');
        wp_localize_script('wp-donators', 'WPDONATORS', array(
        	'cny_payee_mail' => get_option('cny_payee_mail'),
        	'paypal_sandbox' => get_option('paypal_sandbox'),
        	'wd_plugindir_url' => WD_PLUGINDIR_URL,
        	'target_value' => mytarget_value(''),
        	'target_value_global' =>  mytarget_value('mt000')
		));
    }
}

add_action('wp_print_styles','wp_donators_StylesAction');
function wp_donators_StylesAction(){
    if (! is_admin()) {
        wp_enqueue_style('jquery-ui', WD_PLUGINDIR_URL . 'css/jquery-ui.css',array(), '0.1');
        wp_enqueue_style('wp-donators', WD_PLUGINDIR_URL . 'css/wp-donators.css',array(), '0.1');
    }    
}


add_action ( 'wp_head', 'WD_header' , 999);
/**
 * Adds an action link to the plugins page
 */
add_action('plugin_action_links_' . plugin_basename(__FILE__), 'wp_donators_plugin_actions');
function wp_donators_plugin_actions ($links)
{
    $new_links = array();
    $new_links[] = '<a href="options-general.php?page=wp-donators/payment-manager.php">' . __('Settings', 'wp-donators') . '</a>';
    return array_merge($new_links, $links);
}
/**
 * Add FAQ and support information
 */
add_filter('plugin_row_meta', 'wp_donators_plugin_links', 10, 2);
function wp_donators_plugin_links ($links, $file)
{
    if ($file == plugin_basename(__FILE__)) {
        $links[] = '<a href="http://www.ericbess.com/paypal/paypal.php">' . __('Donate', 'wp-donators') . '</a>';
    }
    return $links;
}

/**
 * SponsorBox for Posts
 *
 */
function post_sponsor_box() {
	global $post;
	echo sponsor_box_unit( 'p' . $post->ID, 'post' );
}


function sponsor_box(){
	echo sponsor_box_sc();
}

function sponsor_box_sc(){
	global $post;
	if (is_single() || is_page()) return  sponsor_box_unit( 'p' . $post->ID, 'post' );
}

add_shortcode('sponsorbox', 'sponsor_box_sc');

//TestLinkADs
function sidebar_textads(){
	textads_form( 't000' );
	textads_list( 't000' );
}

function textads(){
	echo textads_sc();
}

function textads_sc(){
	global $post;
	if (is_single() || is_page()) {
		$output = textads_form( 'tp' . $post->ID,false);
		$output .= textads_list( 'tp' . $post->ID,false);
	}
	return $output;
}
add_shortcode('textads', 'textads_sc');

//MyTarget
function sidebar_mytarget(){
	mytarget_form( 'mt000' );
	mytarget_process( 'mt000' );
}

function mytarget(){
	echo mytarget_sc();
}

function mytarget_sc(){
	global $post;
	if (is_single() || is_page()) {
		$output = mytarget_form( 'mt' . $post->ID,false);
		$output .= mytarget_process( 'mt' . $post->ID,false);
	}
	return $output;
}
add_shortcode('mytarget','mytarget_sc');

//Function: Widget
/**
 * Widget initialize
 */
add_action ( 'widgets_init', 'sponsor_widget_init' );
function sponsor_widget_init() {
	if (! function_exists ( 'register_sidebar_widget' ))
		return;
	register_sidebar_widget ( 'Sponsors Cloud', 'sponsors_cloud_widget' );
}

/**
 * Widget configuration
 *
 * @param unknown_type $args
 */
function sponsors_cloud_widget($args) {
	if (is_array ( $args ))
		extract ( $args );
	echo $before_widget . sponsor_box_unit ( '000', 'sidebar' ) . $after_widget;
}

function sidebar_sponsor_box(){
	echo sponsor_box_unit( '000', 'sidebar' );
}
?>