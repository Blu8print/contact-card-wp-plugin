<?php
/**
 * Block registration and management
 *
 * @package ContactCard
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Contact_Card_Blocks Class
 *
 * Handles Gutenberg block registration
 */
class Contact_Card_Blocks {

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
     * Initialize blocks
     */
    public function init() {
        add_action('init', array($this, 'register_blocks'));
    }

    /**
     * Register all blocks
     */
    public function register_blocks() {
        // Register block with PHP
        register_block_type(
            CONTACT_CARD_PLUGIN_DIR . 'blocks/contact-card-block',
            array(
                'render_callback' => array($this, 'render_contact_card_block'),
                'attributes' => array(
                    'showLogo' => array(
                        'type' => 'boolean',
                        'default' => true
                    ),
                    'showQR' => array(
                        'type' => 'boolean',
                        'default' => true
                    ),
                    'showVCardButton' => array(
                        'type' => 'boolean',
                        'default' => true
                    ),
                    'showSocialLinks' => array(
                        'type' => 'boolean',
                        'default' => false
                    )
                )
            )
        );
    }

    /**
     * Render contact card block
     *
     * @param array $attributes Block attributes
     * @return string HTML output
     */
    public function render_contact_card_block($attributes) {
        // Override display settings with block attributes
        $settings = $this->settings->get_all();

        // Temporarily override display settings based on block attributes
        $settings['display']['show_logo'] = $attributes['showLogo'] ?? true;
        $settings['display']['show_qr'] = $attributes['showQR'] ?? true;
        $settings['display']['show_vcard_button'] = $attributes['showVCardButton'] ?? true;
        $settings['display']['show_social_links'] = $attributes['showSocialLinks'] ?? false;

        // Create a temporary settings object with overridden values
        $temp_settings = new Contact_Card_Settings();
        $temp_settings->update($settings);

        // Load renderer
        require_once CONTACT_CARD_PLUGIN_DIR . 'public/class-renderer.php';

        // Render with temporary settings
        $renderer = new Contact_Card_Renderer($temp_settings);
        return $renderer->render();
    }
}
