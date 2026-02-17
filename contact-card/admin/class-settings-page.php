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

            <div class="notice notice-info" style="padding: 12px 15px;">
                <div>
                    <strong>💡 How to Display Your Contact Card:</strong>
                    <ul style="margin: 8px 0 0 0; list-style: none; padding: 0;">
                        <li style="margin: 8px 0;">
                            <strong>Shortcode:</strong>
                            <code class="contact-card-shortcode-box" title="Click to copy">[contact_card]</code>
                            <em style="color: #666; font-size: 12px; margin-left: 8px;">← Click to copy</em>
                        </li>
                        <li style="margin: 8px 0;">
                            <strong>Widget:</strong> Go to Appearance → Widgets and add "Contact Card" widget
                        </li>
                        <li style="margin: 8px 0;">
                            <strong>Gutenberg Block:</strong> Search for "Contact Card" in the block editor (+)
                        </li>
                    </ul>
                </div>
            </div>

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
                    <label for="theme_button_color">Button Color</label>
                </th>
                <td>
                    <input type="text" id="theme_button_color"
                           name="contact_card_settings[theme][button_color]"
                           value="<?php echo esc_attr($theme['button_color']); ?>">
                    <p class="description">Color for the "Add to Contacts" button (default: #2271b1 - Blue)</p>
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <label for="theme_background_color">Page Background</label>
                </th>
                <td>
                    <input type="text" id="theme_background_color"
                           name="contact_card_settings[theme][background_color]"
                           value="<?php echo esc_attr($theme['background_color']); ?>">
                    <p class="description">Background color around the card (default: #f0f0f1 - Light Gray)</p>
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <label for="theme_card_background">Card Background</label>
                </th>
                <td>
                    <input type="text" id="theme_card_background"
                           name="contact_card_settings[theme][card_background]"
                           value="<?php echo esc_attr($theme['card_background']); ?>">
                    <p class="description">Background color of the contact card itself (default: #ffffff - White)</p>
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <label for="theme_text_color">Text Color</label>
                </th>
                <td>
                    <input type="text" id="theme_text_color"
                           name="contact_card_settings[theme][text_color]"
                           value="<?php echo esc_attr($theme['text_color']); ?>">
                    <p class="description">Main body text color (default: #1d2327 - Dark Gray)</p>
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <label for="theme_heading_color">Heading Color</label>
                </th>
                <td>
                    <input type="text" id="theme_heading_color"
                           name="contact_card_settings[theme][heading_color]"
                           value="<?php echo esc_attr($theme['heading_color']); ?>">
                    <p class="description">Color for headings like "Contact Information" (default: #1d2327 - Dark Gray)</p>
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <label for="theme_label_color">Label Color</label>
                </th>
                <td>
                    <input type="text" id="theme_label_color"
                           name="contact_card_settings[theme][label_color]"
                           value="<?php echo esc_attr($theme['label_color']); ?>">
                    <p class="description">Color for field labels like "Name:", "Phone:" (default: #50575e - Medium Gray)</p>
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <label for="theme_border_color">Border Color</label>
                </th>
                <td>
                    <input type="text" id="theme_border_color"
                           name="contact_card_settings[theme][border_color]"
                           value="<?php echo esc_attr($theme['border_color']); ?>">
                    <p class="description">Border color around the card (default: #dcdcde - Light Gray)</p>
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
