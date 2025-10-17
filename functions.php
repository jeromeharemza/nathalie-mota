<?php
/**
 * Thème child OceanWP — Nathalie Mota
 */

defined('ABSPATH') || exit;

// Charger les styles du parent + enfant
add_action('wp_enqueue_scripts', function() {
   
    wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');

    wp_enqueue_style(
        'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        ['parent-style'],
        '1.0.0'
    );
});
