=== Contact Card ===
Contributors: yourusername
Tags: contact, vcard, qr code, business card, contact card
Requires at least: 5.8
Tested up to: 6.7
Requires PHP: 7.4
Stable tag: 1.0.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Display customizable contact cards with QR codes and vCard downloads via shortcode, widget, or Gutenberg block.

== Description ==

Contact Card is a powerful yet simple WordPress plugin that allows you to display professional contact cards on your website. Perfect for personal websites, business sites, or any page where you want to make it easy for visitors to save your contact information.

**Key Features:**

* **Three Display Methods:** Shortcode `[contact_card]`, WordPress Widget, and Gutenberg Block
* **QR Code Generation:** Automatically generates QR codes for quick mobile scanning
* **vCard Download:** One-click download to add contact to phone or email client
* **Fully Customizable:** Control colors, fonts, and display options
* **Logo Upload:** Add your personal or business logo via WordPress Media Library
* **Responsive Design:** Works perfectly on desktop, tablet, and mobile devices
* **Multilingual Ready:** Includes Polish translation, easily extensible to other languages
* **Privacy Focused:** All QR code generation happens locally - no external services

**Perfect For:**

* Freelancers and consultants
* Small business owners
* Real estate agents
* Sales representatives
* Anyone who wants to share contact information easily

**Contact Information Fields:**

* Full name (with first, middle, last name breakdown)
* Job title and company
* Phone number
* Email address
* Website
* Full address (street, city, state, ZIP, country)
* Social media links (Facebook, LinkedIn, Instagram, Twitter)

**Theme Customization:**

* Primary, secondary, and accent colors
* Text color
* Font family selection
* Border radius adjustment

**Display Options:**

* Toggle logo display
* Toggle QR code display
* Toggle vCard button display
* Toggle social media links display

== Installation ==

1. Upload the `contact-card` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Go to Settings > Contact Card to configure your contact information
4. Use the shortcode `[contact_card]`, add the widget to a sidebar, or insert the Gutenberg block

== Frequently Asked Questions ==

= How do I display the contact card? =

You have three options:
1. **Shortcode:** Add `[contact_card]` to any page or post
2. **Widget:** Go to Appearance > Widgets and add the "Contact Card" widget to a sidebar
3. **Gutenberg Block:** In the block editor, add the "Contact Card" block

= Can I customize the colors? =

Yes! Go to Settings > Contact Card > Theme tab and customize the primary, secondary, accent, and text colors using the color pickers.

= How do I add my logo? =

Go to Settings > Contact Card > Logo tab and click "Upload Logo" to choose an image from your WordPress Media Library.

= Does the QR code work on all phones? =

Yes! The QR code follows the vCard 3.0 standard and works with all modern smartphones.

= Is my data sent to external services? =

No! The QR code is generated locally using JavaScript. No data is sent to external servers.

= Can I translate the plugin to my language? =

Yes! The plugin is translation-ready. You can use tools like Poedit or Loco Translate to create translations.

= How do I remove all plugin data when uninstalling? =

Simply delete the plugin through the WordPress Plugins page. All settings will be automatically removed.

== Screenshots ==

1. Contact Card frontend display with QR code
2. Settings page - Contact Information tab
3. Settings page - Logo Upload tab
4. Settings page - Theme Customization tab
5. Settings page - Display Options tab
6. Gutenberg block in the editor
7. Widget configuration

== Changelog ==

= 1.0.0 =
* Initial release
* Shortcode support
* WordPress Widget
* Gutenberg Block
* QR code generation
* vCard download
* Logo upload
* Theme customization
* Display options
* Polish translation

== Upgrade Notice ==

= 1.0.0 =
Initial release of Contact Card plugin.

== Development ==

**Building the Gutenberg Block:**

If you're developing or modifying the plugin, you'll need to build the JavaScript assets:

1. Navigate to the `blocks/` directory
2. Run `npm install` to install dependencies
3. Run `npm run build` to compile the block

**Requirements:**

* Node.js 14+ and npm
* WordPress 5.8+
* PHP 7.4+

== Privacy Policy ==

Contact Card does not collect, store, or transmit any user data to external services. All QR code generation happens locally in the browser using JavaScript. Contact information is stored in your WordPress database and is only displayed on pages where you've added the contact card.

== Support ==

For support, feature requests, or bug reports, please visit:
https://github.com/yourusername/contact-card/issues
