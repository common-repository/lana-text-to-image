=== Lana Text to Image ===
Contributors: lanacodes
Donate link: https://www.paypal.com/donate/?hosted_button_id=F34PNECNYHSA4
Tags: text to image, privacy, security, shortcode
Requires at least: 4.0
Tested up to: 6.2
Stable tag: 1.1.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Easy to use text to image shortcode

== Description ==

Lana Text to Image is a useful privacy plugin, whose primary purpose is to hide the email address from bots.

Optical Character Recognition (OCR) can recognize the content of text in an image. But it requires a special resource.

= Shortcodes list: =

**Text to Image shortcode**
`[lana_text_to_image text="info@lana.codes" class="lana-email" alt="protected email" color="#000000" font_size="13px"]`

**Text to Img shortcode**
`[lana_text_to_img text="info@lana.codes" class="lana-email" alt="protected email" color="#000000" font_size="13px"]`

Both shortcodes are the same, `[lana_text_to_img]` is an alternative shorter name.

= Examples: =

Email address as text:
`[lana_text_to_image text="info@lana.codes"]`

Only the @ from the email address as text:
info`[lana_text_to_image text="@" alt="@"]`lana.codes

You can specify the `'alt'` parameter and the text image will be copiable.

= Lana Codes =
[Lana Shortcodes](https://lana.codes/product/lana-text-to-image/)

== Installation ==

= Requires =
* WordPress at least 4.0
* PHP at least 5.3

= Instalation steps =

1. Upload the plugin files to the `/wp-content/plugins/lana-text-to-image` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress

= How to use it =
* in `Posts > Edit`, you can manually add the shortcode to the selected post, for example add the `[lana_text_to_image text="info@lana.codes"]` shortcode to the post content.
* in `Pages > Edit`, you can manually add the shortcode to the selected page, for example add the `[lana_text_to_image text="info@lana.codes"]` shortcode to the page content.

== Frequently Asked Questions ==

Do you have questions or issues with Lana Shortcodes?
Use these support channels appropriately.

= Lana Codes =
[Support](https://lana.codes/contact/)

= WordPress Forum =
[Support Forum](http://wordpress.org/support/plugin/lana-text-to-image)

== Screenshots ==

1. screenshot-1.jpg
2. screenshot-2.jpg

== Changelog ==

= 1.1.0 =
* security: fixed stored XSS vulnerability
* change tinymce shortcode button add in 'admin_init' hook

= 1.0.0 =
* Added Lana Text to Image

== Upgrade Notice ==

= 1.1.0 =
This version fixes a security vulnerability. Upgrade recommended.