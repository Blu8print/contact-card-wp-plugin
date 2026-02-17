<?php
/**
 * Settings management class
 *
 * @package ContactCard
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Contact_Card_Settings Class
 *
 * Centralized settings management with getter/setter methods
 */
class Contact_Card_Settings {

    /**
     * Option name in WordPress options table
     *
     * @var string
     */
    private $option_name = 'contact_card_settings';

    /**
     * Settings cache
     *
     * @var array
     */
    private $settings = null;

    /**
     * Get all settings
     *
     * @return array
     */
    public function get_all() {
        if ($this->settings === null) {
            $this->settings = get_option($this->option_name, $this->get_defaults());
        }
        return $this->settings;
    }

    /**
     * Get specific setting value
     *
     * @param string $key Setting key (supports dot notation, e.g., 'contact.name')
     * @param mixed $default Default value if setting doesn't exist
     * @return mixed
     */
    public function get($key, $default = null) {
        $settings = $this->get_all();
        $keys = explode('.', $key);

        foreach ($keys as $k) {
            if (isset($settings[$k])) {
                $settings = $settings[$k];
            } else {
                return $default;
            }
        }

        return $settings;
    }

    /**
     * Update settings
     *
     * @param array $new_settings New settings array
     * @return bool
     */
    public function update($new_settings) {
        $sanitized = $this->sanitize($new_settings);
        $result = update_option($this->option_name, $sanitized);

        // Clear cache
        $this->settings = null;

        return $result;
    }

    /**
     * Sanitize settings before saving
     *
     * @param array $settings Settings to sanitize
     * @return array
     */
    public function sanitize($settings) {
        // Get existing settings to merge with
        $existing = $this->get_all();
        $clean = $existing;

        // Sanitize contact information
        if (isset($settings['contact'])) {
            $clean['contact'] = array(
                'name' => sanitize_text_field($settings['contact']['name'] ?? ''),
                'first_name' => sanitize_text_field($settings['contact']['first_name'] ?? ''),
                'middle_name' => sanitize_text_field($settings['contact']['middle_name'] ?? ''),
                'last_name' => sanitize_text_field($settings['contact']['last_name'] ?? ''),
                'job_title' => sanitize_text_field($settings['contact']['job_title'] ?? ''),
                'company' => sanitize_text_field($settings['contact']['company'] ?? ''),
                'phone' => sanitize_text_field($settings['contact']['phone'] ?? ''),
                'email' => sanitize_email($settings['contact']['email'] ?? ''),
                'website' => sanitize_text_field($settings['contact']['website'] ?? ''),
                'website_url' => esc_url_raw($settings['contact']['website_url'] ?? ''),
                'address' => array(
                    'street' => sanitize_text_field($settings['contact']['address']['street'] ?? ''),
                    'city' => sanitize_text_field($settings['contact']['address']['city'] ?? ''),
                    'state' => sanitize_text_field($settings['contact']['address']['state'] ?? ''),
                    'zip' => sanitize_text_field($settings['contact']['address']['zip'] ?? ''),
                    'country' => sanitize_text_field($settings['contact']['address']['country'] ?? '')
                ),
                'social' => array(
                    'facebook' => esc_url_raw($settings['contact']['social']['facebook'] ?? ''),
                    'linkedin' => esc_url_raw($settings['contact']['social']['linkedin'] ?? ''),
                    'instagram' => esc_url_raw($settings['contact']['social']['instagram'] ?? ''),
                    'twitter' => esc_url_raw($settings['contact']['social']['twitter'] ?? '')
                )
            );
        }

        // Sanitize logo settings
        if (isset($settings['logo'])) {
            $clean['logo'] = array(
                'attachment_id' => absint($settings['logo']['attachment_id'] ?? 0),
                'url' => esc_url_raw($settings['logo']['url'] ?? ''),
                'fallback_text' => sanitize_text_field($settings['logo']['fallback_text'] ?? 'LOGO')
            );
        }

        // Sanitize theme settings
        if (isset($settings['theme'])) {
            $clean['theme'] = array(
                'primary_color' => $this->sanitize_hex_color($settings['theme']['primary_color'] ?? '#ffd700'),
                'secondary_color' => $this->sanitize_hex_color($settings['theme']['secondary_color'] ?? '#121212'),
                'accent_color' => $this->sanitize_hex_color($settings['theme']['accent_color'] ?? '#1a1a1a'),
                'text_color' => $this->sanitize_hex_color($settings['theme']['text_color'] ?? '#ffffff'),
                'font_family' => sanitize_text_field($settings['theme']['font_family'] ?? 'Arial, sans-serif'),
                'border_radius' => sanitize_text_field($settings['theme']['border_radius'] ?? '10px')
            );
        }

        // Sanitize display settings
        if (isset($settings['display'])) {
            $clean['display'] = array(
                'show_qr' => !empty($settings['display']['show_qr']),
                'show_vcard_button' => !empty($settings['display']['show_vcard_button']),
                'show_logo' => !empty($settings['display']['show_logo']),
                'show_social_links' => !empty($settings['display']['show_social_links'])
            );
        }

        return $clean;
    }

    /**
     * Sanitize hex color
     *
     * @param string $color Hex color to sanitize
     * @return string
     */
    private function sanitize_hex_color($color) {
        // Remove any whitespace
        $color = trim($color);

        // Check if valid hex color
        if (preg_match('/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/', $color)) {
            return $color;
        }

        // Return default if invalid
        return '#ffd700';
    }

    /**
     * Get default settings
     *
     * @return array
     */
    public function get_defaults() {
        return array(
            'contact' => array(
                'name' => '',
                'first_name' => '',
                'middle_name' => '',
                'last_name' => '',
                'job_title' => '',
                'company' => '',
                'phone' => '',
                'email' => '',
                'website' => '',
                'website_url' => '',
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
    }

    /**
     * Reset to defaults
     *
     * @return bool
     */
    public function reset() {
        $this->settings = null;
        return update_option($this->option_name, $this->get_defaults());
    }
}
