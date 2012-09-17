=== Simple Razoo Donations ===
Contributors: wiredimpact 
Tags: razoo, donation, shortcode, donate, forms
Requires at least: 2.8
Tested up to: 3.4.2
Stable tag: trunk

Easily add the [Razoo Donation Widget](http://www.razoo.com/p/donationWidget Razoo Donation Widget) to your website by filling out your settings and adding the donation form via a button in the WordPress editor.


== Description ==

Easily add the [Razoo Donation Widget](http://www.razoo.com/p/donationWidget Razoo Donation Widget) to your website by filling out your settings and adding the Razoo donation form via a button in the WordPress editor.  The button will place the shortcode directly in the editor.

The [Razoo Donation Widget](http://www.razoo.com/p/donationWidget Razoo Donation Widget) typically works by copying and pasting code from the Razoo website.  Unfortunately, that code doesn't work when placed within the WordPress editor.  This plugin allows you to  customize the Razoo donation form, then add the Razoo donation form via a shortcode right into your post or page.

The settings page allows you to set defaults which you can use throughout your website and also provides instructions on how to add the Razoo donation form to your website.  If you'd like some donation forms to use different settings than the defaults, you can use shortcode attributes to customize each donation form.  See the FAQs for specifics on how to do this.

**Thanks**

A special thanks to [Zaus](http://profiles.wordpress.org/zaus/) and [AtlanticBT](http://profiles.wordpress.org/atlanticbt/) for providing the foundation for this plugin.

**Clearing Up Confusion About "Widget"**

We also want to clear up any confusion about the name given to the donation form by Razoo.  The name "Razoo Donation Widget" includes the word widget, but that does not refer to a WordPress widget.  There is no widget functionality included with this plugin.


== Installation ==

1. Download the Simple Razoo Donations plugin and unzip the files
1. Upload the simple-razoo-donations folder to the /wp-content/plugins/ directory
1. Activate the Simple Razoo Donations plugin through the "Plugins" menu in WordPress
1. Configure your donation form settings by going to Settings >> Simple Razoo Donations in the WordPress backend
1. Place your cursor within the WordPress editor's text where you want the Razoo donation form to be added.
1. Click the Razoo icon in the WordPress editor toolbar (looks like a globe broken into pieces). The Razoo shortcode reading "[razoo_donation_form]" will be added in the editor.
1. Click the blue "Publish" or "Update" button to save your changes and add the Razoo donation form to your live website.


== Frequently Asked Questions ==

= How do I customize the donation form for different pages? =
If you want to put different versions of the donation form on different pages of your website, you can use shortcode attributes to override the default options you used on the settings page.  You only need to include attributes for the defaults you wish to override.  For example, if every donation should go to the same organization, you will never need to use the "id" attribute.  An example shortcode with all attributes looks like this:

`[razoo_donation_form id="United-Way-of-America" title="Support United Way" short_description="Help us help the community" long_description="United Way has been supporting communities since the late 1800s and now supports communities in countries around the world." color="#000000" image="true" donation_options="20=Donor|30=Sponsor|50=All Star Contributor"]`

Here is a breakdown of how to use each attribute:

* id:  The ID for your organization according to Razoo. When on your organization's landing page it's the text that comes right after "/story/". For example, the United Way of America's ID is "United-Way-Of-America". You can view their ID at [http://www.razoo.com/story/United-Way-Of-America](http://www.razoo.com/story/United-Way-Of-America).
* title: The title will show up in big letters at the top of the donation widget.
* short_description: A short description of your organization or an ask for people to donate. This text shows up just below the title.
* long_description: The more info section can be much longer, describing more about your organization and where the donors money will go. This text shows up when users click the "More info" link on the donation widget.
* color: Provide the color you want for the donation form in [hexadecimal format (#000000)](http://www.w3schools.com/html/html_colors.asp). You should match this closely to your website's colors.
* image: use "true" to show the main image for your organization on the donation widget
* donation_options: Add the donation options you want to offer potential donors with in a pipe (|) separated list of values and labels

= How do I use the shortcode in a template file? =

To add the shortcode directly to a template file use the code:

`<?php echo do_shortcode('[razoo_donation_form]'); ?>`


== Screenshots ==

1. Razoo donation form outputted on a website
2. Settings page for your organization's defaults
3. WordPress editor button to add the donation form
4. Shortcode appears after you click the Razoo button on the editor


== Changelog ==

= 0.1 =
* Initial release