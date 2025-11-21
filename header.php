<?php /* Header — Nathalie Mota */ ?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="skip-link screen-reader-text" href="#content">Aller au contenu</a>

<header id="site-header" class="site-header">
  <div class="container header-inner">
    <div class="branding">
      <?php
      if (function_exists('the_custom_logo') && has_custom_logo()) {
        the_custom_logo();
      } else {
        echo '<a class="site-title" href="' . esc_url(home_url('/')) . '">Nathalie Mota</a>';
      }
      ?>
    </div>
    <nav id="site-navigation" class="main-navigation" aria-label="<?php esc_attr_e('Navigation principale','nathalie-mota-child'); ?>">
      <?php
        wp_nav_menu([
          'theme_location' => 'primary_child',
          'menu_id'        => 'primary-menu',
          'container'      => false,
          'fallback_cb'    => false,
        ]);
      ?>
    </nav>
    <button id="menu-toggle" class="menu-toggle"
            aria-label="Ouvrir le menu" aria-controls="primary-menu" aria-expanded="false">
      <span class="menu-toggle-bar"></span>
      <span class="menu-toggle-bar"></span>
      <span class="menu-toggle-bar"></span>
    </button>
  </div>
</header>

<main id="content" class="site-content">



