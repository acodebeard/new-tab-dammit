<?php
/**
 * Plugin Name: New Tab Dammit
 * Description: Opens WordPress admin-bar Visit Site links in a new browser tab on admin screens.
 * Author: @acodebeard
 * Version: 1.0.0
 * License: Unlicense
 * License URI: https://unlicense.org/
 */

declare(strict_types=1);

if (! function_exists('new_tab_dammit')) {
    /**
     * Opens the admin-bar site links in a new tab while preserving core node data.
     *
     * @param WP_Admin_Bar $wp_admin_bar WordPress admin-bar instance.
     */
    function new_tab_dammit(WP_Admin_Bar $wp_admin_bar): void
    {
        if (! is_admin()) {
            return;
        }

        foreach (['site-name', 'view-site'] as $node_id) {
            $node = $wp_admin_bar->get_node($node_id);

            if (! $node) {
                continue;
            }

            $meta = array_merge(is_array($node->meta) ? $node->meta : [], [
                'target' => '_blank',
                'rel' => 'noopener noreferrer',
            ]);

            $wp_admin_bar->add_node([
                'id' => $node_id,
                'meta' => $meta,
            ]);
        }
    }
}
add_action('admin_bar_menu', 'new_tab_dammit', 100);
