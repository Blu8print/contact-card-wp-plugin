<?php
/**
 * Widget class
 *
 * @package ContactCard
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Contact_Card_Widget Class
 *
 * WordPress widget for displaying contact card in sidebars
 */
class Contact_Card_Widget extends WP_Widget {

    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct(
            'contact_card_widget',
            __('Contact Card', 'contact-card'),
            array(
                'description' => __('Display your contact card with QR code', 'contact-card'),
                'classname' => 'contact-card-widget'
            )
        );
    }

    /**
     * Front-end display of widget
     *
     * @param array $args Widget arguments
     * @param array $instance Saved values from database
     */
    public function widget($args, $instance) {
        echo $args['before_widget'];

        // Display widget title if provided
        if (!empty($instance['title'])) {
            echo $args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title'];
        }

        // Load settings and renderer
        require_once CONTACT_CARD_PLUGIN_DIR . 'includes/class-settings.php';
        require_once CONTACT_CARD_PLUGIN_DIR . 'public/class-renderer.php';

        $settings = new Contact_Card_Settings();
        $renderer = new Contact_Card_Renderer($settings);

        // Output contact card
        echo $renderer->render();

        echo $args['after_widget'];
    }

    /**
     * Back-end widget form
     *
     * @param array $instance Previously saved values from database
     */
    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : '';
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>">
                <?php esc_html_e('Title:', 'contact-card'); ?>
            </label>
            <input class="widefat"
                   id="<?php echo esc_attr($this->get_field_id('title')); ?>"
                   name="<?php echo esc_attr($this->get_field_name('title')); ?>"
                   type="text"
                   value="<?php echo esc_attr($title); ?>">
        </p>
        <p class="description">
            <?php esc_html_e('Configure contact information in Settings > Contact Card', 'contact-card'); ?>
        </p>
        <?php
    }

    /**
     * Sanitize widget form values as they are saved
     *
     * @param array $new_instance Values just sent to be saved
     * @param array $old_instance Previously saved values from database
     * @return array Updated safe values to be saved
     */
    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title']))
            ? sanitize_text_field($new_instance['title'])
            : '';

        return $instance;
    }
}
