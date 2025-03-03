=== Lexicata ===
Contributors: lexicata, One-400.com
Tags: contact form, CRM, Lexicata, law firm, lawyer, contact, lead tracking, wordpress, plugin
Requires at least: 3.9
Tested up to: 4.7.4
Stable tag: 1.3.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

The Lexicata plugin for Wordpress enables law firms who use Lexicata to automatically capture leads from their website or blog into the Lexicata CRM.

== Description ==
Lexicata is a law firm CRM and client intake software. It helps law firms keep track of all their potential clients, and intake them with ease using powerful online tools to collect information and e-sign documents.

The Lexicata plugin for Wordpress enables law firms who use Lexicata to automatically capture leads from their website or blog into the Lexicata CRM system. Visit https://lexicata.com for more information. 

== Installation ==
Installing the Lexicata plugin can be done either by searching for Lexicata via the Plugins > Add New screen in your WordPress dashboard, or by using the following steps:

1. Download the plugin via WordPress.org
1. Upload the ZIP file through the Plugins > Add New > Upload screen in your WordPress dashboard
1. Activate the plugin through the Plugins menu in WordPress

== Frequently Asked Questions ==
= How does this plugin work? =
This plugin replaces the contact form on your Wordpress website or blog. When a web visitor fills out the form, the data is automatically submitted to your Inbox in the Lexicata law firm CRM. The purpose is to make it easier to track and manage incoming leads, and help you convert them into new clients. For more information, visit https://lexicata.com

= Who is this plugin for? =
Lexicata is built exclusively for law firms, and this plugin is intended to be used solely by customers of the Lexicata CRM and client intake software. 

= Can I use this plugin without using Lexicata? =
No, you must be a Lexicata user to use the plugin.

== Changelog ==
= 1.0.16 =
* 2018-01-08
* Updated URL for POST requests to be https://app.lexicata.com/inbox_leads

= 1.0.15 =
* 2017-07-18
* Bugfix: fixed issue with older PHP versions

= 1.0.14 =
* 2017-05-30
* Bugfix: fixed issue with missing default field labels

= 1.0.13 =
* 2017-05-19
* Bugfix: fixed issue affecting only older versions of PHP

= 1.0.12 =
* 2017-05-16
* Bugfix: fixed issue where phone placeholder was not showing up

= 1.0.11 =
* 2017-05-15
* Bugfix: fixed issue where shortcode and form preview sections were not being shown
* Update: made both field labels and placeholder text for form fields configurable
* Update: moved field css ids out of input tag and into containing p tag
* Update: added optional disclaimer requirement to form config


= 1.0.10 =
* 2016-11-29
* Added settings option to redirect to permalink or url on successful submit
* Added settings option for blacklisting email domains
* Added settings option for custom css

= 1.0.9 =
* 2016-03-29
* Added additional reCaptcha logging

= 1.0.8 =
* 2016-03-16
* Added Google reCAPTCHA option to kill bots dead

= 1.0.7 =
* 2015-12-29
* Added Google Analytics event tracking for successful form submission

= 1.0.6 =
* 2015-11-18
* Fixed several bugs; main one being single quotes were being double escaped

= 1.0.5 =
* 2015-10-26
* Switched from curl to the wordpress HTTP API class for better compatability

= 1.0.4 =
* 2015-10-03
* Added rudimentary bot detection

= 1.0.3 =
* 2015-09-17
* Updated and relocated cacert.pem

= 1.0.2 =
* 2015-09-16
* Added a root certification authority cert so curl can authenticate with lexicata api

= 1.0.1 =
* 2015-09-15
* Added error logging code to help track down some elusive errors. Usage: Lexicata_Form::log_error("foo");

= 1.0 =
* 2015-09-09
* Initial release

== Upgrade Notice ==
= 1.0 =
* 2015-09-09
* Initial release
