<?php
/**
 * Plugin Name: Contact Card
 * Plugin URI: https://github.com/yourusername/contact-card
 * Description: Display customizable contact cards with QR codes via shortcode, widget, or Gutenberg block
 * Version: 1.0.0
 * Author: Your Name
 * Author URI: https://yourwebsite.com
 * Text Domain: contact-card
 * Domain Path: /languages
 * Requires at least: 5.8
 * Requires PHP: 7.4
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Plugin constants
define('CONTACT_CARD_VERSION', '1.0.0');
define('CONTACT_CARD_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('CONTACT_CARD_PLUGIN_URL', plugin_dir_url(__FILE__));
define('CONTACT_CARD_PLUGIN_BASENAME', plugin_basename(__FILE__));

/**
 * Plugin activation hook
 * Sets up default settings on first activation
 */
function contact_card_activate() {
    // Check if settings already exist
    if (false === get_option('contact_card_settings')) {
        // Default settings based on existing template
        $defaults = array(
            'contact' => array(
                'name' => 'Tomasz Maria Falkowski',
                'first_name' => 'Tomasz',
                'middle_name' => 'Maria',
                'last_name' => 'Falkowski',
                'job_title' => '',
                'company' => '',
                'phone' => '+48502122799',
                'email' => 'tomasz@hipnodentysta.com',
                'website' => 'www.hipnodentysta.com',
                'website_url' => 'http://www.hipnodentysta.com',
                'address' => array(
                    'street' => '',
                    'city' => '',
                    'state' => '',
                    'zip' => '',
                    'country' => ''
                ),
                'social' => array(
                    'facebook' => '',
                    'linkedin' => '',
                    'instagram' => '',
                    'twitter' => ''
                )
            ),
            'logo' => array(
                'attachment_id' => 0,
                'url' => '',
                'fallback_text' => 'LOGO'
            ),
            'theme' => array(
                'primary_color' => '#ffd700',
                'secondary_color' => '#121212',
                'accent_color' => '#1a1a1a',
                'text_color' => '#ffffff',
                'font_family' => 'Arial, sans-serif',
                'border_radius' => '10px'
            ),
            'display' => array(
                'show_qr' => true,
                'show_vcard_button' => true,
                'show_logo' => true,
                'show_social_links' => false
            )
        );

        add_option('contact_card_settings', $defaults);
    }

    // Flush rewrite rules for any custom endpoints
    flush_rewrite_rules();
}
register_activation_hook(__FILE__, 'contact_card_activate');

/**
 * Plugin deactivation hook
 */
function contact_card_deactivate() {
    flush_rewrite_rules();
}
register_deactivation_hook(__FILE__, 'contact_card_deactivate');

/**
 * Load plugin classes
 */
require_once CONTACT_CARD_PLUGIN_DIR . 'includes/class-contact-card.php';

/**
 * Initialize the plugin
 */
function contact_card_init() {
    $plugin = new Contact_Card();
    $plugin->init();
}
add_action('plugins_loaded', 'contact_card_init');
