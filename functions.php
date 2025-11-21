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

// Styles et scripts généraux
add_action('wp_enqueue_scripts', function () {
    wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
    wp_enqueue_style('nm-main', get_stylesheet_directory_uri() . '/assets/css/main.css', ['parent-style'], '1.0.0');
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css', [], '6.4.0');
    wp_enqueue_script('nm-menu', get_stylesheet_directory_uri() . '/assets/js/menu.js', [], '1.0.0', true);
    wp_enqueue_script('nm-modal', get_stylesheet_directory_uri() . '/assets/js/scripts.js', [], '1.0.0', true);
});

// Scripts et styles pour single-photo
add_action('wp_enqueue_scripts', function () {
    if (is_singular('photo')) {
        $single_css_path = get_stylesheet_directory() . '/assets/css/single-photo.css';
        if (file_exists($single_css_path)) {
            wp_enqueue_style(
                'nm-single-css',
                get_stylesheet_directory_uri() . '/assets/css/single-photo.css',
                ['nm-main'],
                filemtime($single_css_path)
            );
        }
        $single_js_path = get_stylesheet_directory() . '/assets/js/single-photo.js';
        if (file_exists($single_js_path)) {
            wp_enqueue_script(
                'nm-single-js',
                get_stylesheet_directory_uri() . '/assets/js/single-photo.js',
                ['jquery'],
                filemtime($single_js_path),
                true
            );
        }
    }
});

// Script JS Lightbox
function nm_enqueue_lightbox() {
    wp_enqueue_script(
        'nm-lightbox-js',
        get_stylesheet_directory_uri() . '/assets/js/lightbox.js',
        array(),
        '1.0.0',
        true
    );
}
add_action('wp_enqueue_scripts', 'nm_enqueue_lightbox');

// AJAX : Enregistrement script filters.js
add_action('wp_enqueue_scripts', function () {
    if (is_front_page()) {
        wp_enqueue_script(
            'nm-filters-ajax',
            get_stylesheet_directory_uri() . '/assets/js/filters.js',
            ['jquery'],
            '1.0.0',
            true
        );
        wp_localize_script('nm-filters-ajax', 'nmAjax', [
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('nm_filter_nonce')
        ]);
    }
});

// Enregistrement script AJAX Charger plus
add_action('wp_enqueue_scripts', function () {
    if (is_front_page()) {
        wp_enqueue_script(
            'nm-loadmore',
            get_stylesheet_directory_uri() . '/assets/js/nm-loadmore.js',
            ['jquery'],
            '1.0.0',
            true
        );
        wp_localize_script('nm-loadmore', 'nmLoadmore', [
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('nm_loadmore_nonce'),
        ]);
    }
});

// AJAX : Hooks pour les filtres
add_action('wp_ajax_nm_filter_photos', 'nm_filter_photos_ajax');
add_action('wp_ajax_nopriv_nm_filter_photos', 'nm_filter_photos_ajax');

// AJAX : Fonction de filtrage
function nm_filter_photos_ajax() {
    check_ajax_referer('nm_filter_nonce', 'nonce');
    $category = isset($_POST['category']) ? sanitize_text_field($_POST['category']) : '';
    $format = isset($_POST['format']) ? sanitize_text_field($_POST['format']) : '';
    $order = isset($_POST['order']) ? sanitize_text_field($_POST['order']) : 'date_desc';
    $args = [
        'post_type' => 'photo',
        'posts_per_page' => 8,
        'orderby' => 'date',
        'order' => 'DESC'
    ];
    if ($order === 'date_asc') {
        $args['order'] = 'ASC';
    } elseif ($order === 'date_desc') {
        $args['order'] = 'DESC';
    }
    $tax_query = [];
    if (!empty($category)) {
        $tax_query[] = [
            'taxonomy' => 'category',
            'field' => 'slug',
            'terms' => $category,
        ];
    }
    if (!empty($format)) {
        $tax_query[] = [
            'taxonomy' => 'format',
            'field' => 'slug',
            'terms' => $format,
        ];
    }
    if (!empty($tax_query)) {
        $args['tax_query'] = $tax_query;
    }
    $query = new WP_Query($args);
    ob_start();
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            get_template_part('template-parts/photo_bloc');
        }
        wp_reset_postdata();
    } else {
        echo '<p>Aucune photo trouvée</p>';
    }
    $html = ob_get_clean();
    wp_send_json_success(['html' => $html]);
}

// AJAX : Hooks pour le bouton Charger plus
add_action('wp_ajax_nm_loadmore_photos', 'nm_loadmore_photos_ajax');
add_action('wp_ajax_nopriv_nm_loadmore_photos', 'nm_loadmore_photos_ajax');

// AJAX : Fonction pour le bouton "Charger plus"
function nm_loadmore_photos_ajax() {
    check_ajax_referer('nm_loadmore_nonce', 'nonce');
    $paged = isset($_POST['paged']) ? intval($_POST['paged']) : 1;
    $category = isset($_POST['category']) ? sanitize_text_field($_POST['category']) : '';
    $format = isset($_POST['format']) ? sanitize_text_field($_POST['format']) : '';
    $order = isset($_POST['order']) ? sanitize_text_field($_POST['order']) : 'date_desc';
    $args = [
        'post_type' => 'photo',
        'posts_per_page' => 8,
        'paged' => $paged,
        'orderby' => 'date',
        'order' => ($order === 'date_asc') ? 'ASC' : 'DESC',
    ];
    $tax_query = [];
    if (!empty($category)) {
        $tax_query[] = [
            'taxonomy' => 'category',
            'field' => 'slug',
            'terms' => $category,
        ];
    }
    if (!empty($format)) {
        $tax_query[] = [
            'taxonomy' => 'format',
            'field' => 'slug',
            'terms' => $format,
        ];
    }
    if (!empty($tax_query)) {
        $args['tax_query'] = $tax_query;
    }
    $query = new WP_Query($args);
    ob_start();
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            get_template_part('template-parts/photo_bloc');
        }
        wp_reset_postdata();
    }
    $output = ob_get_clean();
    wp_send_json_success([
        'html' => $output,
        'max_pages' => $query->max_num_pages
    ]);
}
