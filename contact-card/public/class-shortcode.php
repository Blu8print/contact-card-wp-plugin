<?php
/**
 * Shortcode handler class
 *
 * @package ContactCard
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Contact_Card_Shortcode Class
 *
 * Handles [contact_card] shortcode registration and rendering
 */
class Contact_Card_Shortcode {

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
     * Initialize shortcode
     */
    public function init() {
        add_shortcode('contact_card', array($this, 'render'));
    }

    /**
     * Render shortcode
     *
     * @param array $atts Shortcode attributes
     * @return string HTML output
     */
    public function render($atts = array()) {
        // Parse attributes (for future extensibility)
        $atts = shortcode_atts(array(
            // Future attributes can be added here
        ), $atts, 'contact_card');

        // Load renderer
        require_once CONTACT_CARD_PLUGIN_DIR . 'public/class-renderer.php';

        // Create renderer and generate output
        $renderer = new Contact_Card_Renderer($this->settings);
        return $renderer->render();
    }
}
