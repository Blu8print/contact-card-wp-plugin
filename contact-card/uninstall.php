<?php
/**
 * Uninstall script
 * Fired when the plugin is uninstalled
 *
 * @package ContactCard
 */

// Exit if accessed directly
if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}

// Delete plugin options
delete_option('contact_card_settings');

// For multisite installations
if (is_multisite()) {
    global $wpdb;

    // Get all blog IDs
    $blog_ids = $wpdb->get_col("SELECT blog_id FROM $wpdb->blogs");

    foreach ($blog_ids as $blog_id) {
        switch_to_blog($blog_id);
        delete_option('contact_card_settings');
        restore_current_blog();
    }
}

// Clear any cached data
wp_cache_flush();
