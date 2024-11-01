=== WP-DONATORS ===
Contributors: Eric.Wang
Donate link: http://www.ericbess.com/ericblog/?p=258
Tags: donation,ad,ads,widget,link,ajax,Post,widget,admin,posts,sidebar,links,paypal
Requires at least: 2.0
Tested up to: 2.8
Stable tag: 1.1.16

Monetize your blog!  A lot of features to monetize your blog! Support: Sponsors Box,Text Link ADs,My Target, etc.

== Description ==

Monetize your blog!  A lot of features to monetize your blog! Including: `Sponsors Box`,`Text Link ADs`,`My Target`, etc. Supporting  multi-Currency exchange. It's will support most popular payment interface in future. ParPal Just the first one.

= Prerequisites =

* If you haven't the paypal account so far.Please register paypal account at here:[PayPal Registration](https://www.paypal.com/row/mrb/pal=BV4AUWAD94GZG).Let your blog start accepting credit card payments with WP-DONATORS instantly and safely!
* PHP5, Openssl, fsock.

= Features =

* `Sponsors Box`: People donate and place `contextual links` and `text advertisements`. It displays latest donor information in a Cloud (like a Tag cloud). The more a donator pays, the bigger he/she link will be.
* `Text Link ADs`: After people buy the TextLink Advertising, s/he can leave a TextLink and description on the blog. The more a person payment, the longer their advertising will be.
* `My Target`: It will show what your target is, how much it's required. What's the progress so far, how much is outstanding. And if people decide to sponsor money to support the Target, it will provide convenient means of payment.

= Multi-Currency Support and Exchange =

U.S. Dollars,Australian Dollars,British Pounds,Canadian Dollars,Czech Koruna,Danish Kroner,Hong Kong Dollars,Hungarian Forint,
Japanese Yen,Mexican Peso,New Zealand Dollar,Norwegian Kroner,Polish Zlotych,Singapore Dollars,Swedish Kronor,Swiss Franc,Thai Baht,Taiwan Dollar,Philippine Peso,Chinese Yuan(RMB)

= Demo =

[Wp-DONATORS Demo](http://www.ericbess.com/ericblog?p=258#demo).

= About Author =
[Eric Wang](http://wordpress.org/extend/plugins/profile/ericbess)

== Installation ==

= System Depends On =
* If your haven't the paypal account so far.Please register paypal account at here:[PayPal Registration](https://www.paypal.com/row/mrb/pal=BV4AUWAD94GZG).
* PHP5, Openssl, fsock.

= Upgrade =

* Upgrade attention: after updated the new version must disactive and active the plugin.

= To Do =
1. Upload `WP-Donators.zip` to your Wordpress plugins directory, usually `wp-content/plugins/` and unzip the file.  It will create a `wp-content/plugins/wp-donators/` directory.
1. Activate the plugin through the 'Plugins' menu in WordPress.
1. Go to `{wp-admin}->Sponsors` set the default setting.
1. Go to the Widgets set the sidebar SponsorBox.
1. Edit the THEME, add the PHP function, refer to [Other Notes](http://wordpress.org/extend/plugins/wp-donators/other_notes/).

= Testing Account =
* You can apply sandbox accounts on [Developer.PayPal](https://developer.paypal.com/) to test the plugin.

== Frequently Asked Questions ==

* How do I change the Original string text or translate the plugin?

Open `wp-donations.po` file with [Poedit](http://www.poedit.net/download.php), create the `wp-donators-{WPLANG}.mo` file, you can define customization text or translate to your lang with poedit.

* How to ensure the authenticity of the payment transaction?

This plugin developed in strict accordance with the [PAYPAL IPN](https://www.paypal.com/ipn).

* After my payment,Why no my information/ad displayed on the blog?

WP-Doantors IPN RESPONSE PROCESS need wait the PAYPAL return a validation information, PAYPAL sometimes delay some minutes to send the IPN informantin since the server busy.

* How do I customize the css style?

This plugin display style base on [Jquery UI](http://jquery.com), you can edit the css style on [UI THEME](http://jqueryui.com/themeroller/),download it, replace the css and image files.

[Leave your FAQ](http://www.ericbess.com/ericblog/?p=258#respond)

== How To Use ==

Sponsors Box

* Sidebar(Global) SponsorBox:Go to the Widgets set the sidebar SponsorBox,or add the <code><?php if(function_exists('sidebar_sponsor_box')) { sidebar_sponsor_box(); }?></code> to `THEME->sidebar.php`.
* Per-Post/Page SponsorBox:Edit the `THEME->single.php/page.php`, Add the "<code><?php if(function_exists('sponsor_box')) { sponsor_box(); }?></code>" to correct place, or embed shortcode `[sponsorbox]` in post/page content.

Advanced Mode: Just display the simplye Donate Form/Sponsor Cloud, not any display style.

1. Display Donate Form: <code><?php if(function_exists('donate_form')) { donate_form("Type",[size]); }?></code>
1. Display Sponsor Cloud: <code><?php if(function_exists('show_sponsor')) { show_sponsor("Type"); }?></code>

* `Type` "global" or "post" applications range. "globel" Play a role in the whole site; "post" Play in The current post/page.
* `size` The form input width size,default is "40".

Text Link ADs

* Sidebar(Global) TextLinkADs:Edit the `THEME->sidebar.php`, Add the <code><h2>Text Link ADs</h2><?php if(function_exists('sidebar_textads')) { sidebar_textads(); }?></code> to correct place.
* Per-Post/Page TextLinkADs:Edit the `THEME->single.php/page.php`, Add the "<code><h2>Taxt Link ADs for This Page</h2><?php if(function_exists('textads')) { textads(); }?></code>" to correct place, or embed shortcode `[textads]` in post/page content.
* [Custom Fields](http://codex.wordpress.org/Using_Custom_Fields#Usage) in Post/Page:`textads_price`(Text Link ADs price /unit for this page).`textads_unit` (The days of one unit).

My Target

* Sidebar(Global) My Target:Edit the `THEME->sidebar.php`, Add the <code><h2>My Target</h2>{Target discription.}<?php if(function_exists('sidebar_mytarget')) { sidebar_mytarget(); }?></code> to correct place.
* Per-Post/Page My Target:Edit the `THEME->single.php/page.php`, Add the "<code><h2>My Target</h2>{Target discription.}<?php if(function_exists('mytarget')) { mytarget(); }?></code>" to correct place, or embed shortcode `[mytarget]` in post/page content.
* [Custom Fields](http://codex.wordpress.org/Using_Custom_Fields#Usage) in Post/Page:`target_price`(My Target price for this page).`target_initial_value`(initial My Target paid amount '< target_price' for this page)

== Release Notes ==

* 1.0: First internal release; 
* 1.0.6: IPN response reinforcement, L10n support;
* 1.0.8: Support Multi-currency;
* 1.1.0: New jquery ui,css;add textlinkads feature;
* 1.1.1: Add new feature:My Target;

== Need Your Help ==

* Bug Report
* Language package .mo .po

== Screenshots ==

1. Screenshot Admin Area.
2. Sponsors cloud.
3. Payment Page.
4. Payment dialog box.
5. MyTarget progress bar.