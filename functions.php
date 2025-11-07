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
  
  // Script du menu mobile
  wp_enqueue_script('nm-menu', get_stylesheet_directory_uri() . '/assets/js/menu.js', [], '1.0.0', true);

  // Script de la modale de contact
  wp_enqueue_script(
    'nm-modal',
    get_stylesheet_directory_uri() . '/assets/js/scripts.js',
    [],
    '1.0.0',
    true
  );

  // ➕CSS et JS spécifiques au single du CPT photo 
add_action('wp_enqueue_scripts', function () {
  if (is_singular('photo') || is_singular('photos')) {

    // Feuille de style du single (layout, design)
    wp_enqueue_style(
      'nm-single',
      get_stylesheet_directory_uri() . '/assets/css/single-photo.css',
      ['nm-main'], 
      filemtime(get_stylesheet_directory() . '/assets/css/single-photo.css')
    );

    // Script du single 
    $single_js_path = get_stylesheet_directory() . '/assets/js/single-photo.js';
    if (file_exists($single_js_path)) { //
      wp_enqueue_script(
        'nm-single',
        get_stylesheet_directory_uri() . '/assets/js/single-photo.js',
        ['jquery'],
        filemtime($single_js_path),
        true
      );
    }
  }
});

});