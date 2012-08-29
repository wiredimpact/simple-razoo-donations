=== Razoo Donation Widget ===
Contributors: atlanticbt, zaus
Donate link: http://atlanticbt.com/
Tags: ecommerce, donation, widget, razoo
Requires at least: 2.8
Tested up to: 3.2.1
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
		id="Mynonprofit"
		title="My Non Profit"
		short_description="Please let us know how much you want to donate:"
		color="#f1a632"
		donation_options="5=Friend|25=Benefactor|100=Benefactor|500=Sponsor"
		]
	{ long_description }
	[/razoo_widget]

where

* __id__: (required) the donation account id
* __title__: shown on widget first tab
* __short_description__: shown on tab with donation amounts
* __color__: the border/theme
* __donation_options__: a url-formatted string, or more safely a pipe (|) separated list of values and labels
* __long_description__: a bigger description, either given as an attribute or as the shortcode content.  If given as an attribute, you don't need the closing `[/razoo_widget]`

= How to put shortcode in widget? =

Use a filter to apply shortcode processing to widgets.

[Filter](http://digwp.com/2010/03/shortcodes-in-widgets/): `<?php add_filter('widget_text', 'do_shortcode'); ?>`


== Screenshots ==

1. Customized shortcode with full options
2. Basic shortcode with minimal options
3. Example of embedded, rendered razoo widget

== Changelog ==

= 0.9 =
* submitting to WP repository, readme, screenshots

= 0.5 =
* created as plugin

= 0.1 =
* Direct embed code

== Upgrade Notice ==

= 0.9 =
First added to repository.

== About Razoo ==

[Read more](http://www.razoo.com/p/overview) about the Razoo platform.  The following is copied from that link.

= What is Razoo? =

**More than a Website**

Razoo is a movement of people who want to make generosity a part of everyday life.

**Living Generously**

Generosity is win-win. Not only does it make the world a better place, it also makes us happy and fulfilled - especially when we give to the people and causes we care about most.

= What Can I Do on Razoo? =

**Donate**

Search for and donate to 1 million officially registered nonprofit organizations.

**Fundraise**

Set up a fundraiser for a charity of your choice. There are no setup fees and no monthly subscription fees.

**Collaborate**

Raise money as a team on Razoo. Or simply help others spread the word about their cause.

**Go Mobile!**

Razoo's new iPhone app lets you monitor fundraising status, post updates and thank your donors.