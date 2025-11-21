<?php
/*
 * Template Part : Bloc photo
 */
$photo_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
$reference = get_post_meta(get_the_ID(), 'reference', true);
$categorie_terms = get_the_terms(get_the_ID(), 'categorie');
$categorie_name = $categorie_terms && !is_wp_error($categorie_terms) ? $categorie_terms[0]->name : '';
?>
<div class="nm-related__item">
  <div class="nm-related__wrapper">
    <!-- Image -->
    <a href="<?php the_permalink(); ?>" class="nm-related__link">
      <?php if (has_post_thumbnail()) : ?>
        <?php the_post_thumbnail('large', [
          'class' => 'nm-related__img',
          'alt' => get_the_title(),
          'loading' => 'lazy',
          'style' => 'object-fit: cover;'
        ]); ?>
      <?php endif; ?>
      <div class="nm-related__overlay"></div>
    </a>
    
    <!-- Icône œil-->
    <a href="<?php the_permalink(); ?>" class="nm-related__eye-link">
      <i class="fa-solid fa-eye nm-related__icon"></i>
    </a>
    
<!-- référence - catégorie - overlay -->
<div class="nm-related__info">
  <?php if ($reference) : ?>
    <span class="nm-related__reference"><?php echo esc_html(strtoupper($reference)); ?></span>
  <?php endif; ?>
  <?php if ($categorie_name) : ?>
    <span class="nm-related__category"><?php echo esc_html(strtoupper($categorie_name)); ?></span>
  <?php endif; ?>
</div>

    <!-- ouvre la lightbox -->
    <a href="<?php echo esc_url($photo_url); ?>" 
       class="lightbox-trigger nm-related__fullscreen-link"
       data-reference="<?php echo esc_attr($reference); ?>"
       data-category="<?php echo esc_attr($categorie_name); ?>"
       data-post-id="<?php echo get_the_ID(); ?>">
      <i class="fa-solid fa-expand nm-related__fullscreen-icon"></i>
    </a>
  </div>
</div>
