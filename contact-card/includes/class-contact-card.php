<?php
/**
 * Main plugin orchestration class
 *
 * @package ContactCard
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Contact_Card Class
 *
 * Orchestrates plugin initialization and loads all components
 */
class Contact_Card {

    /**
     * Plugin version
     *
     * @var string
     */
    private $version = CONTACT_CARD_VERSION;

    /**
     * Settings instance
     *
     * @var Contact_Card_Settings
     */
    private $settings;

    /**
     * Constructor
     */
    public function __construct() {
        $this->load_dependencies();
    }

    /**
     * Load required dependencies
     */
    private function load_dependencies() {
        // Load settings class
        require_once CONTACT_CARD_PLUGIN_DIR . 'includes/class-settings.php';

        // Initialize settings
        $this->settings = new Contact_Card_Settings();
    }

    /**
     * Initialize the plugin
     */
    public function init() {
        // Load text domain for translations
        add_action('init', array($this, 'load_textdomain'));

        // Load admin components
        if (is_admin()) {
            $this->load_admin();
        }

        // Load public components
        $this->load_public();
    }

    /**
     * Load plugin text domain for translations
     */
    public function load_textdomain() {
        load_plugin_textdomain(
            'contact-card',
            false,
            dirname(CONTACT_CARD_PLUGIN_BASENAME) . '/languages'
        );
    }

    /**
     * Load admin-specific components
     */
    private function load_admin() {
        require_once CONTACT_CARD_PLUGIN_DIR . 'admin/class-admin.php';
        $admin = new Contact_Card_Admin($this->settings);
        $admin->init();
    }

    /**
     * Load public-facing components
     */
    private function load_public() {
        // Load renderer
        require_once CONTACT_CARD_PLUGIN_DIR . 'public/class-renderer.php';

        // Load shortcode
        require_once CONTACT_CARD_PLUGIN_DIR . 'public/class-shortcode.php';
        $shortcode = new Contact_Card_Shortcode($this->settings);
        $shortcode->init();

        // Load widget
        require_once CONTACT_CARD_PLUGIN_DIR . 'public/class-widget.php';
        add_action('widgets_init', function() {
            register_widget('Contact_Card_Widget');
        });

        // Load blocks
        require_once CONTACT_CARD_PLUGIN_DIR . 'blocks/class-blocks.php';
        $blocks = new Contact_Card_Blocks($this->settings);
        $blocks->init();
    }

    /**
     * Get plugin version
     *
     * @return string
     */
    public function get_version() {
        return $this->version;
    }
}
