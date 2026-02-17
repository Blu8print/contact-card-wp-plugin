<?php
/**
 * Contact card renderer class
 *
 * @package ContactCard
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Contact_Card_Renderer Class
 *
 * Centralized HTML rendering for all display methods
 */
class Contact_Card_Renderer {

    /**
     * Settings instance
     *
     * @var Contact_Card_Settings
     */
    private $settings;

    /**
     * Current settings cache
     *
     * @var array
     */
    private $options;

    /**
     * Constructor
     *
     * @param Contact_Card_Settings $settings Settings instance
     */
    public function __construct($settings) {
        $this->settings = $settings;
        $this->options = $settings->get_all();
    }

    /**
     * Enqueue frontend assets
     */
    public function enqueue_assets() {
        // Enqueue CSS
        wp_enqueue_style(
            'contact-card',
            CONTACT_CARD_PLUGIN_URL . 'public/css/contact-card.css',
            array(),
            CONTACT_CARD_VERSION
        );

        // Add inline CSS for theme customization
        wp_add_inline_style('contact-card', $this->get_dynamic_styles());

        // Enqueue QRCode library
        wp_enqueue_script(
            'contact-card-qrcode',
            CONTACT_CARD_PLUGIN_URL . 'public/js/qrcode.min.js',
            array(),
            CONTACT_CARD_VERSION,
            true
        );

        // Enqueue main JS
        wp_enqueue_script(
            'contact-card',
            CONTACT_CARD_PLUGIN_URL . 'public/js/contact-card.js',
            array('jquery', 'contact-card-qrcode'),
            CONTACT_CARD_VERSION,
            true
        );

        // Pass data to JavaScript
        $this->localize_script();
    }

    /**
     * Generate dynamic CSS from theme settings
     *
     * @return string CSS rules
     */
    private function get_dynamic_styles() {
        $theme = $this->options['theme'];

        $css = ":root {
            --cc-button: {$theme['button_color']};
            --cc-background: {$theme['background_color']};
            --cc-card-background: {$theme['card_background']};
            --cc-text: {$theme['text_color']};
            --cc-heading: {$theme['heading_color']};
            --cc-label: {$theme['label_color']};
            --cc-border: {$theme['border_color']};
            --cc-font-family: {$theme['font_family']};
            --cc-border-radius: {$theme['border_radius']};
        }";

        return $css;
    }

    /**
     * Localize script with contact data
     */
    private function localize_script() {
        // Generate vCard
        require_once CONTACT_CARD_PLUGIN_DIR . 'includes/class-vcard-generator.php';
        $vcard_generator = new Contact_Card_VCard_Generator($this->options['contact']);

        wp_localize_script('contact-card', 'contactCardData', array(
            'vcard' => $vcard_generator->generate(),
            'filename' => $vcard_generator->get_filename(),
            'showQR' => $this->options['display']['show_qr'],
            'qrSettings' => array(
                'width' => 200,
                'height' => 200,
                'colorDark' => '#000000',
                'colorLight' => '#ffffff'
            )
        ));
    }

    /**
     * Main render method
     *
     * @return string HTML output
     */
    public function render() {
        // Enqueue assets
        $this->enqueue_assets();

        $contact = $this->options['contact'];
        $display = $this->options['display'];

        ob_start();
        ?>
        <div class="contact-card-wrapper">
            <?php if ($display['show_logo']): ?>
                <?php echo $this->render_logo(); ?>
            <?php endif; ?>

            <div class="contact-card">
                <h1><?php echo esc_html__('Contact Information', 'contact-card'); ?></h1>

                <?php echo $this->render_contact_info(); ?>

                <?php if ($display['show_vcard_button']): ?>
                    <?php echo $this->render_vcard_button(); ?>
                <?php endif; ?>

                <?php if ($display['show_qr']): ?>
                    <?php echo $this->render_qr_code(); ?>
                <?php endif; ?>
            </div>

            <?php if ($display['show_social_links']): ?>
                <?php echo $this->render_social_links(); ?>
            <?php endif; ?>

            <?php echo $this->render_footer(); ?>
        </div>
        <?php
        return ob_get_clean();
    }

    /**
     * Render logo section
     *
     * @return string HTML output
     */
    private function render_logo() {
        $logo = $this->options['logo'];

        ob_start();
        ?>
        <div class="contact-card-logo-container">
            <div class="contact-card-logo-placeholder">
                <?php if (!empty($logo['url'])): ?>
                    <img src="<?php echo esc_url($logo['url']); ?>"
                         alt="<?php echo esc_attr($this->options['contact']['name']); ?>">
                <?php else: ?>
                    <span><?php echo esc_html($logo['fallback_text']); ?></span>
                <?php endif; ?>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }

    /**
     * Render contact information
     *
     * @return string HTML output
     */
    private function render_contact_info() {
        $contact = $this->options['contact'];

        ob_start();
        ?>
        <div class="contact-card-info">
            <?php if (!empty($contact['name'])): ?>
                <p>
                    <span class="contact-card-label"><?php echo esc_html__('Name', 'contact-card'); ?>:</span>
                    <?php echo esc_html($contact['name']); ?>
                </p>
            <?php endif; ?>

            <?php if (!empty($contact['job_title'])): ?>
                <p>
                    <span class="contact-card-label"><?php echo esc_html__('Title', 'contact-card'); ?>:</span>
                    <?php echo esc_html($contact['job_title']); ?>
                </p>
            <?php endif; ?>

            <?php if (!empty($contact['company'])): ?>
                <p>
                    <span class="contact-card-label"><?php echo esc_html__('Company', 'contact-card'); ?>:</span>
                    <?php echo esc_html($contact['company']); ?>
                </p>
            <?php endif; ?>

            <?php if (!empty($contact['phone'])): ?>
                <p>
                    <span class="contact-card-label"><?php echo esc_html__('Phone', 'contact-card'); ?>:</span>
                    <?php echo esc_html($contact['phone']); ?>
                </p>
            <?php endif; ?>

            <?php if (!empty($contact['email'])): ?>
                <p>
                    <span class="contact-card-label"><?php echo esc_html__('Email', 'contact-card'); ?>:</span>
                    <?php echo esc_html($contact['email']); ?>
                </p>
            <?php endif; ?>

            <?php if (!empty($contact['website'])): ?>
                <p>
                    <span class="contact-card-label"><?php echo esc_html__('Website', 'contact-card'); ?>:</span>
                    <a href="<?php echo esc_url($contact['website_url']); ?>" target="_blank">
                        <?php echo esc_html($contact['website']); ?>
                    </a>
                </p>
            <?php endif; ?>
        </div>
        <?php
        return ob_get_clean();
    }

    /**
     * Render vCard download button
     *
     * @return string HTML output
     */
    private function render_vcard_button() {
        ob_start();
        ?>
        <div class="contact-card-button-container">
            <a href="#" class="contact-card-button" id="contact-card-download-vcard">
                <?php echo esc_html__('Add to Contacts', 'contact-card'); ?>
            </a>
        </div>
        <?php
        return ob_get_clean();
    }

    /**
     * Render QR code section
     *
     * @return string HTML output
     */
    private function render_qr_code() {
        ob_start();
        ?>
        <div class="contact-card-qr-code">
            <h3><?php echo esc_html__('Scan this QR code with your phone', 'contact-card'); ?></h3>
            <div id="contact-card-qrcode"></div>
        </div>
        <?php
        return ob_get_clean();
    }

    /**
     * Render social media links
     *
     * @return string HTML output
     */
    private function render_social_links() {
        $social = $this->options['contact']['social'];

        // Check if any social links exist
        $has_links = false;
        foreach ($social as $url) {
            if (!empty($url)) {
                $has_links = true;
                break;
            }
        }

        if (!$has_links) {
            return '';
        }

        ob_start();
        ?>
        <div class="contact-card-social-links">
            <?php if (!empty($social['facebook'])): ?>
                <a href="<?php echo esc_url($social['facebook']); ?>" target="_blank" title="Facebook">
                    <span>Facebook</span>
                </a>
            <?php endif; ?>

            <?php if (!empty($social['linkedin'])): ?>
                <a href="<?php echo esc_url($social['linkedin']); ?>" target="_blank" title="LinkedIn">
                    <span>LinkedIn</span>
                </a>
            <?php endif; ?>

            <?php if (!empty($social['instagram'])): ?>
                <a href="<?php echo esc_url($social['instagram']); ?>" target="_blank" title="Instagram">
                    <span>Instagram</span>
                </a>
            <?php endif; ?>

            <?php if (!empty($social['twitter'])): ?>
                <a href="<?php echo esc_url($social['twitter']); ?>" target="_blank" title="Twitter">
                    <span>Twitter</span>
                </a>
            <?php endif; ?>
        </div>
        <?php
        return ob_get_clean();
    }

    /**
     * Render footer
     *
     * @return string HTML output
     */
    private function render_footer() {
        $contact = $this->options['contact'];

        ob_start();
        ?>
        <div class="contact-card-footer">
            <p>
                <?php
                printf(
                    esc_html__('This contact card was created for %s.', 'contact-card'),
                    esc_html($contact['name'])
                );
                ?>
            </p>
        </div>
        <?php
        return ob_get_clean();
    }
}
