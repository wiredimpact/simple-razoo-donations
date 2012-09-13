=== Razoo Donation Widget ===
Contributors: atlanticbt, zaus
Donate link: http://wiredimpact.com/
Tags: ecommerce, donation, widget, razoo
Requires at least: 2.8
Tested up to: 3.4.2
Stable tag: trunk

Simple shortcode wrapper to embed a customized Razoo donation widget.  See http://www.razoo.com/p/donationWidget for more detail.

== Description ==

Razoo is a free donation platform for non-profits to easily accept donations.  They provide an embeddable widget for your site.  This plugin exposes this form as a shortcode for you to drop in your pages and posts. See also [Razoo Widget Creator](http://www.razoo.com/p/donationWidget).

Actually based on the "share" widget creator (from the "embed this on your site" link on the widget) to customize the options + basic appearance.

== Installation ==

1. Upload the plugin folder to your plugins directory `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Use the shortcode `[razoo_widget]` _(with options)_ anywhere you can use shortcodes.
4. If you want to put the widget (shortcode) in a Widget, you'll need to allow shortcodes in widgets

== Frequently Asked Questions ==

= Shortcode usage? =
Long version, with attributes + content:

  [razoo_widget
    id="United-Way-of-America"
    title="Support United Way"
    short_description="This is a short description"
    long_description="United Way has been supporting communities since the late 1800s and now supports communities in countries around the world.  This is an example of a long description."
    color="#000000"
    image="true"
    donation_options="20=Donor|30=Sponsor|50=True Contributor"
  ]

where

* __id__: (required) the donation account id
* __title__: shown on widget first tab
* __short_description__: shown on tab with donation amounts
* __long_description__: a bigger description
* __color__: the border/theme
* __image__: use "true" to show the organization's image
* __donation_options__: a url-formatted string, or more safely a pipe (|) separated list of values and labels

= How to put shortcode in widget? =

Use a filter to apply shortcode processing to widgets.

[Filter](http://digwp.com/2010/03/shortcodes-in-widgets/): `<?php add_filter('widget_text', 'do_shortcode'); ?>`


== Screenshots ==

1. Customized shortcode with full options
2. Basic shortcode with minimal options
3. Example of embedded, rendered razoo widget

== Changelog ==

= 0.1 =
* First release to WordPress plugin repository