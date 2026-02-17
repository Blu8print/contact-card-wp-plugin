<?php
/**
 * Settings page UI class
 *
 * @package ContactCard
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Contact_Card_Settings_Page Class
 *
 * Renders the settings page with tabbed interface
 */
class Contact_Card_Settings_Page {

    /**
     * Settings instance
     *
     * @var Contact_Card_Settings
     */
    private $settings;

    /**
     * Current active tab
     *
     * @var string
     */
    private $active_tab;

    /**
     * Constructor
     *
     * @param Contact_Card_Settings $settings Settings instance
     */
    public function __construct($settings) {
        $this->settings = $settings;
        $this->active_tab = isset($_GET['tab']) ? sanitize_text_field($_GET['tab']) : 'contact';
    }

    /**
     * Render the settings page
     */
    public function render() {
        // Get all settings
        $options = $this->settings->get_all();

        ?>
        <div class="wrap">
            <h1><?php echo esc_html(get_admin_page_title()); ?></h1>

            <?php settings_errors(); ?>

            <h2 class="nav-tab-wrapper">
                <a href="?page=contact-card-settings&tab=contact" class="nav-tab <?php echo $this->active_tab === 'contact' ? 'nav-tab-active' : ''; ?>">
                    Contact Information
                </a>
                <a href="?page=contact-card-settings&tab=logo" class="nav-tab <?php echo $this->active_tab === 'logo' ? 'nav-tab-active' : ''; ?>">
                    Logo
                </a>
                <a href="?page=contact-card-settings&tab=theme" class="nav-tab <?php echo $this->active_tab === 'theme' ? 'nav-tab-active' : ''; ?>">
                    Theme
                </a>
                <a href="?page=contact-card-settings&tab=display" class="nav-tab <?php echo $this->active_tab === 'display' ? 'nav-tab-active' : ''; ?>">
                    Display Options
                </a>
            </h2>

            <form method="post" action="options.php">
                <?php
                settings_fields('contact_card_settings_group');
                ?>

                <input type="hidden" name="contact_card_active_tab" value="<?php echo esc_attr($this->active_tab); ?>">

                <?php
                // Render active tab
                switch ($this->active_tab) {
                    case 'contact':
                        $this->render_contact_tab($options);
                        break;
                    case 'logo':
                        $this->render_logo_tab($options);
                        break;
                    case 'theme':
                        $this->render_theme_tab($options);
                        break;
                    case 'display':
                        $this->render_display_tab($options);
                        break;
                }

                submit_button();
                ?>
            </form>
        </div>
        <?php
    }

    /**
     * Render Contact Information tab
     *
     * @param array $options Current settings
     */
    private function render_contact_tab($options) {
        $contact = $options['contact'];
        ?>
        <table class="form-table">
            <tr>
                <th scope="row">
                    <label for="contact_name">Full Name</label>
                </th>
                <td>
                    <input type="text" id="contact_name" name="contact_card_settings[contact][name]"
                           value="<?php echo esc_attr($contact['name']); ?>" class="regular-text">
                    <p class="description">The full name of the contact person</p>
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <label for="contact_first_name">First Name</label>
                </th>
                <td>
                    <input type="text" id="contact_first_name" name="contact_card_settings[contact][first_name]"
                           value="<?php echo esc_attr($contact['first_name']); ?>" class="regular-text">
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <label for="contact_middle_name">Middle Name</label>
                </th>
                <td>
                    <input type="text" id="contact_middle_name" name="contact_card_settings[contact][middle_name]"
                           value="<?php echo esc_attr($contact['middle_name']); ?>" class="regular-text">
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <label for="contact_last_name">Last Name</label>
                </th>
                <td>
                    <input type="text" id="contact_last_name" name="contact_card_settings[contact][last_name]"
                           value="<?php echo esc_attr($contact['last_name']); ?>" class="regular-text">
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <label for="contact_job_title">Job Title</label>
                </th>
                <td>
                    <input type="text" id="contact_job_title" name="contact_card_settings[contact][job_title]"
                           value="<?php echo esc_attr($contact['job_title']); ?>" class="regular-text">
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <label for="contact_company">Company</label>
                </th>
                <td>
                    <input type="text" id="contact_company" name="contact_card_settings[contact][company]"
                           value="<?php echo esc_attr($contact['company']); ?>" class="regular-text">
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <label for="contact_phone">Phone</label>
                </th>
                <td>
                    <input type="tel" id="contact_phone" name="contact_card_settings[contact][phone]"
                           value="<?php echo esc_attr($contact['phone']); ?>" class="regular-text">
                    <p class="description">Include country code (e.g., +48502122799)</p>
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <label for="contact_email">Email</label>
                </th>
                <td>
                    <input type="email" id="contact_email" name="contact_card_settings[contact][email]"
                           value="<?php echo esc_attr($contact['email']); ?>" class="regular-text">
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <label for="contact_website">Website Display</label>
                </th>
                <td>
                    <input type="text" id="contact_website" name="contact_card_settings[contact][website]"
                           value="<?php echo esc_attr($contact['website']); ?>" class="regular-text">
                    <p class="description">How the website should be displayed (e.g., www.example.com)</p>
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <label for="contact_website_url">Website URL</label>
                </th>
                <td>
                    <input type="url" id="contact_website_url" name="contact_card_settings[contact][website_url]"
                           value="<?php echo esc_attr($contact['website_url']); ?>" class="regular-text">
                    <p class="description">Full URL including http:// or https://</p>
                </td>
            </tr>

            <tr>
                <th scope="row">Address</th>
                <td>
                    <fieldset>
                        <p>
                            <input type="text" name="contact_card_settings[contact][address][street]"
                                   value="<?php echo esc_attr($contact['address']['street']); ?>"
                                   class="regular-text" placeholder="Street Address">
                        </p>
                        <p>
                            <input type="text" name="contact_card_settings[contact][address][city]"
                                   value="<?php echo esc_attr($contact['address']['city']); ?>"
                                   class="regular-text" placeholder="City">
                        </p>
                        <p>
                            <input type="text" name="contact_card_settings[contact][address][state]"
                                   value="<?php echo esc_attr($contact['address']['state']); ?>"
                                   class="regular-text" placeholder="State/Province">
                        </p>
                        <p>
                            <input type="text" name="contact_card_settings[contact][address][zip]"
                                   value="<?php echo esc_attr($contact['address']['zip']); ?>"
                                   class="regular-text" placeholder="ZIP/Postal Code">
                        </p>
                        <p>
                            <input type="text" name="contact_card_settings[contact][address][country]"
                                   value="<?php echo esc_attr($contact['address']['country']); ?>"
                                   class="regular-text" placeholder="Country">
                        </p>
                    </fieldset>
                </td>
            </tr>

            <tr>
                <th scope="row">Social Media</th>
                <td>
                    <fieldset>
                        <p>
                            <label for="contact_facebook">Facebook URL</label><br>
                            <input type="url" id="contact_facebook" name="contact_card_settings[contact][social][facebook]"
                                   value="<?php echo esc_attr($contact['social']['facebook']); ?>" class="regular-text">
                        </p>
                        <p>
                            <label for="contact_linkedin">LinkedIn URL</label><br>
                            <input type="url" id="contact_linkedin" name="contact_card_settings[contact][social][linkedin]"
                                   value="<?php echo esc_attr($contact['social']['linkedin']); ?>" class="regular-text">
                        </p>
                        <p>
                            <label for="contact_instagram">Instagram URL</label><br>
                            <input type="url" id="contact_instagram" name="contact_card_settings[contact][social][instagram]"
                                   value="<?php echo esc_attr($contact['social']['instagram']); ?>" class="regular-text">
                        </p>
                        <p>
                            <label for="contact_twitter">Twitter URL</label><br>
                            <input type="url" id="contact_twitter" name="contact_card_settings[contact][social][twitter]"
                                   value="<?php echo esc_attr($contact['social']['twitter']); ?>" class="regular-text">
                        </p>
                    </fieldset>
                </td>
            </tr>
        </table>
        <?php
    }

    /**
     * Render Logo tab
     *
     * @param array $options Current settings
     */
    private function render_logo_tab($options) {
        $logo = $options['logo'];
        ?>
        <table class="form-table">
            <tr>
                <th scope="row">
                    <label>Logo Image</label>
                </th>
                <td>
                    <div class="contact-card-logo-upload">
                        <input type="hidden" id="logo_attachment_id"
                               name="contact_card_settings[logo][attachment_id]"
                               value="<?php echo esc_attr($logo['attachment_id']); ?>">
                        <input type="hidden" id="logo_url"
                               name="contact_card_settings[logo][url]"
                               value="<?php echo esc_attr($logo['url']); ?>">

                        <div class="logo-preview">
                            <?php if (!empty($logo['url'])): ?>
                                <img src="<?php echo esc_url($logo['url']); ?>" alt="Logo" style="max-width: 150px; height: auto; border-radius: 50%;">
                            <?php else: ?>
                                <div class="no-logo" style="width: 150px; height: 150px; border: 2px dashed #ccc; display: flex; align-items: center; justify-content: center; border-radius: 50%;">
                                    <span>No Logo</span>
                                </div>
                            <?php endif; ?>
                        </div>

                        <p>
                            <button type="button" class="button" id="upload_logo_button">
                                <?php echo !empty($logo['url']) ? 'Change Logo' : 'Upload Logo'; ?>
                            </button>
                            <?php if (!empty($logo['url'])): ?>
                                <button type="button" class="button" id="remove_logo_button">Remove Logo</button>
                            <?php endif; ?>
                        </p>
                        <p class="description">Recommended: Square image, minimum 150x150 pixels</p>
                    </div>
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <label for="logo_fallback_text">Fallback Text</label>
                </th>
                <td>
                    <input type="text" id="logo_fallback_text"
                           name="contact_card_settings[logo][fallback_text]"
                           value="<?php echo esc_attr($logo['fallback_text']); ?>"
                           class="regular-text">
                    <p class="description">Text to display when no logo is uploaded</p>
                </td>
            </tr>
        </table>
        <?php
    }

    /**
     * Render Theme tab
     *
     * @param array $options Current settings
     */
    private function render_theme_tab($options) {
        $theme = $options['theme'];
        ?>
        <table class="form-table">
            <tr>
                <th scope="row">
                    <label for="theme_primary_color">Primary Color</label>
                </th>
                <td>
                    <input type="text" id="theme_primary_color"
                           name="contact_card_settings[theme][primary_color]"
                           value="<?php echo esc_attr($theme['primary_color']); ?>"
                           class="contact-card-color-picker">
                    <p class="description">Main accent color (default: #ffd700 - Gold)</p>
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <label for="theme_secondary_color">Secondary Color</label>
                </th>
                <td>
                    <input type="text" id="theme_secondary_color"
                           name="contact_card_settings[theme][secondary_color]"
                           value="<?php echo esc_attr($theme['secondary_color']); ?>"
                           class="contact-card-color-picker">
                    <p class="description">Background color (default: #121212 - Dark)</p>
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <label for="theme_accent_color">Accent Color</label>
                </th>
                <td>
                    <input type="text" id="theme_accent_color"
                           name="contact_card_settings[theme][accent_color]"
                           value="<?php echo esc_attr($theme['accent_color']); ?>"
                           class="contact-card-color-picker">
                    <p class="description">Card background color (default: #1a1a1a)</p>
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <label for="theme_text_color">Text Color</label>
                </th>
                <td>
                    <input type="text" id="theme_text_color"
                           name="contact_card_settings[theme][text_color]"
                           value="<?php echo esc_attr($theme['text_color']); ?>"
                           class="contact-card-color-picker">
                    <p class="description">Main text color (default: #ffffff - White)</p>
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <label for="theme_font_family">Font Family</label>
                </th>
                <td>
                    <select id="theme_font_family" name="contact_card_settings[theme][font_family]" class="regular-text">
                        <option value="Arial, sans-serif" <?php selected($theme['font_family'], 'Arial, sans-serif'); ?>>Arial</option>
                        <option value="Georgia, serif" <?php selected($theme['font_family'], 'Georgia, serif'); ?>>Georgia</option>
                        <option value="'Times New Roman', serif" <?php selected($theme['font_family'], "'Times New Roman', serif"); ?>>Times New Roman</option>
                        <option value="'Courier New', monospace" <?php selected($theme['font_family'], "'Courier New', monospace"); ?>>Courier New</option>
                        <option value="Verdana, sans-serif" <?php selected($theme['font_family'], 'Verdana, sans-serif'); ?>>Verdana</option>
                        <option value="Helvetica, sans-serif" <?php selected($theme['font_family'], 'Helvetica, sans-serif'); ?>>Helvetica</option>
                    </select>
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <label for="theme_border_radius">Border Radius</label>
                </th>
                <td>
                    <input type="text" id="theme_border_radius"
                           name="contact_card_settings[theme][border_radius]"
                           value="<?php echo esc_attr($theme['border_radius']); ?>"
                           class="small-text">
                    <p class="description">Border radius for card (e.g., 10px, 5px, 0px)</p>
                </td>
            </tr>
        </table>
        <?php
    }

    /**
     * Render Display Options tab
     *
     * @param array $options Current settings
     */
    private function render_display_tab($options) {
        $display = $options['display'];
        ?>
        <table class="form-table">
            <tr>
                <th scope="row">Display Elements</th>
                <td>
                    <fieldset>
                        <label>
                            <input type="checkbox" name="contact_card_settings[display][show_logo]"
                                   value="1" <?php checked($display['show_logo'], true); ?>>
                            Show Logo
                        </label>
                        <br>
                        <label>
                            <input type="checkbox" name="contact_card_settings[display][show_qr]"
                                   value="1" <?php checked($display['show_qr'], true); ?>>
                            Show QR Code
                        </label>
                        <br>
                        <label>
                            <input type="checkbox" name="contact_card_settings[display][show_vcard_button]"
                                   value="1" <?php checked($display['show_vcard_button'], true); ?>>
                            Show vCard Download Button
                        </label>
                        <br>
                        <label>
                            <input type="checkbox" name="contact_card_settings[display][show_social_links]"
                                   value="1" <?php checked($display['show_social_links'], true); ?>>
                            Show Social Media Links
                        </label>
                    </fieldset>
                </td>
            </tr>
        </table>
        <?php
    }
}
