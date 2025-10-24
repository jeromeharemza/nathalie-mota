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

<?php wp_footer(); ?>
</body>
</html>
