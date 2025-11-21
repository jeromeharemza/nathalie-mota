<?php /* Footer — Nathalie Mota */ ?>
</main><!-- #content -->

<footer id="site-footer" class="site-footer" role="contentinfo">
  <div class="footer-bar" aria-label="<?php esc_attr_e('Footer links','nathalie-mota-child'); ?>">
    <?php
    wp_nav_menu([
      'theme_location' => 'footer',
      'container'      => false,
      'menu_class'     => 'footer-menu',
      'depth'          => 1,
    ]);
    ?>
  </div>
</footer>

<?php get_template_part('template-parts/modal', 'contact'); ?>

<!-- Lightbox -->
<div id="lightbox-modal" class="lightbox-modal" style="display: none;">
  <span class="lightbox-close">&times;</span>
  <span class="lightbox-prev">← Précédente</span>
  <span class="lightbox-next">Suivante →</span>
  <div class="lightbox-overlay"></div>
  <div class="lightbox-content-wrapper">
    <img src="" alt="" class="lightbox-image">
    <div class="lightbox-info">
      <div class="lightbox-left">
        <span class="lightbox-reference"></span>
      </div>
      <div class="lightbox-right">
        <span class="lightbox-category"></span>
      </div>
    </div>
  </div>
</div>

<?php wp_footer(); ?>
</body>
</html>
