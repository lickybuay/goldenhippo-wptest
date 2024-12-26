<?php
/**
 * Plugin Name: Golden Hippo Form Plugin
 * Description: A Golden Hipoo WordPress plugin
 * Version: 1.0.0
 * Author: Sergio
 */

// Prevent direct access.
if (!defined('ABSPATH')) {
    exit;
}

if ( ! class_exists('GHippo_FormPlugin' ) ) {

    // if ( is_admin() ) {
        require_once __DIR__ . '/admin/class/ghippo.php';
        new GHippo_FormPlugin();
    // }

}