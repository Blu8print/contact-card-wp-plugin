<?php
/**
 * Admin coordinator class
 *
 * @package ContactCard
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Contact_Card_Admin Class
 *
 * Handles all admin-related functionality
 */
class Contact_Card_Admin {

    /**
     * Settings instance
     *
     * @var Contact_Card_Settings
     */
    private $settings;

    /**
     * Constructor
     *
     * @param Contact_Card_Settings $settings Settings instance
     */
    public function __construct($settings) {
        $this->settings = $settings;
    }

    /**
     * Initialize admin functionality
     */
    public function init() {
        // Add admin menu
        add_action('admin_menu', array($this, 'add_admin_menu'));

        // Register settings
        add_action('admin_init', array($this, 'register_settings'));

        // Enqueue admin assets
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_assets'));
    }

    /**
     * Add admin menu page
     */
    public function add_admin_menu() {
        add_options_page(
            'Contact Card Settings',
            'Contact Card',
            'manage_options',
            'contact-card-settings',
            array($this, 'render_settings_page')
        );
    }

    /**
     * Register plugin settings
     */
    public function register_settings() {
        register_setting(
            'contact_card_settings_group',
            'contact_card_settings',
            array($this->settings, 'sanitize')
        );
    }

    /**
     * Enqueue admin styles and scripts
     *
     * @param string $hook Current admin page hook
     */
    public function enqueue_admin_assets($hook) {
        // Only load on our settings page
        if ($hook !== 'settings_page_contact-card-settings') {
            return;
        }

        // Enqueue WordPress color picker
        wp_enqueue_style('wp-color-picker');

        // Enqueue WordPress media library
        wp_enqueue_media();

        // Enqueue admin CSS
        wp_enqueue_style(
            'contact-card-admin',
            CONTACT_CARD_PLUGIN_URL . 'admin/css/admin-style.css',
            array('wp-color-picker'),
            CONTACT_CARD_VERSION
        );

        // Enqueue admin JS
        wp_enqueue_script(
            'contact-card-admin',
            CONTACT_CARD_PLUGIN_URL . 'admin/js/admin-script.js',
            array('jquery', 'wp-color-picker'),
            CONTACT_CARD_VERSION,
            true
        );
    }

    /**
     * Render settings page
     */
    public function render_settings_page() {
        // Check user capabilities
        if (!current_user_can('manage_options')) {
            wp_die('You do not have sufficient permissions to access this page.');
        }

        // Load settings page template
        require_once CONTACT_CARD_PLUGIN_DIR . 'admin/class-settings-page.php';
        $settings_page = new Contact_Card_Settings_Page($this->settings);
        $settings_page->render();
    }
}
