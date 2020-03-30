<?php

# Script constants
const PARENT_STYLE = 'divi-style';

# Overwrite Divi styles
add_action('wp_enqueue_scripts', 'enqueue_styles');

# Remove unnecessary stuff
add_action('wp_enqueue_scripts', 'check_for_admin');
add_action('wp_enqueue_scripts', 'check_for_recaptcha');

function enqueue_styles()
{
    wp_enqueue_style(PARENT_STYLE, get_template_directory_uri() . '/style.css');
}

function check_for_recaptcha()
{
    // Check if the Recaptcha is enabled
    $enabled = isset(get_option('et_google_api_settings')['api_key']);
    // Remove the script if not enabled
    if (!$enabled) {
        wp_dequeue_script('recaptcha-v3');
        wp_dequeue_script('et-core-api-spam-recaptcha');
        wp_dequeue_script('es6-promise');
    }
}

function check_for_admin()
{
    // Check if the Recaptcha is enabled
    $logged_in = wp_get_current_user()->exists();
    // Remove the script if not enabled
    if (!$logged_in) {
        wp_deregister_style('wp-block-library');
        wp_deregister_style('dashicons');
        wp_deregister_style('divi-customizer');
        wp_dequeue_script('divi-customizer');
    }
}