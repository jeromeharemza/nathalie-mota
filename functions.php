<?php
/**
 * Thème enfant OceanWP — Nathalie Mota
 */


defined('ABSPATH') || exit;

add_action('after_setup_theme', function () {
  add_theme_support('custom-logo');
  register_nav_menus([
    'primary_child' => __('Main Menu', 'nathalie-mota-child'),
    'footer'        => __('Footer Menu', 'nathalie-mota-child'),
  ]);
});

add_action('wp_enqueue_scripts', function () {
  wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
  wp_enqueue_style('nm-main', get_stylesheet_directory_uri() . '/assets/css/main.css', ['parent-style'], '1.0.0');
  wp_enqueue_script('nm-menu', get_stylesheet_directory_uri() . '/assets/js/menu.js', [], '1.0.0', true);
});
