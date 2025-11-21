<?php
if (!defined('ABSPATH')) exit;
get_header();

while (have_posts()) : the_post();
  $post_id = get_the_ID();
  $reference = get_post_meta($post_id, 'reference', true);
  $type = get_post_meta($post_id, 'type', true);
  $categorie_terms = get_the_terms($post_id, 'categorie');
  $format_terms = get_the_terms($post_id, 'format');
  $annee = get_the_date('Y');
  $cat_ids = $categorie_terms && !is_wp_error($categorie_terms) 
    ? wp_list_pluck($categorie_terms, 'term_id') 
    : [];
?>

<main id="primary" class="nm-single-photo">
  <article <?php post_class('nm-photo'); ?>>
    
    <div class="nm-photo__grid">
      <!-- Colonne gauche : Informations -->
      <div class="nm-photo__left">
        <h1 class="nm-photo__title"><?php the_title(); ?></h1>
        
        <ul class="nm-photo__meta">
          <?php if ($reference) : ?>
            <li>
              <span class="nm-meta__label">Référence :</span> 
              <span class="nm-meta__value"><?php echo esc_html($reference); ?></span>
            </li>
          <?php endif; ?>
          
          <?php if ($categorie_terms && !is_wp_error($categorie_terms)) : ?>
            <li>
              <span class="nm-meta__label">Catégorie :</span> 
              <span class="nm-meta__value">
                <?php echo esc_html(strtoupper(wp_list_pluck($categorie_terms, 'name')[0])); ?>
              </span>
            </li>
          <?php endif; ?>
          
          <?php if ($format_terms && !is_wp_error($format_terms)) : ?>
            <li>
              <span class="nm-meta__label">Format :</span> 
              <span class="nm-meta__value">
                <?php echo esc_html(strtoupper(wp_list_pluck($format_terms, 'name')[0])); ?>
              </span>
            </li>
          <?php endif; ?>
          
          <?php if ($type) : ?>
            <li>
              <span class="nm-meta__label">Type :</span> 
              <span class="nm-meta__value"><?php echo esc_html(strtoupper($type)); ?></span>
            </li>
          <?php endif; ?>
          
          <li>
            <span class="nm-meta__label">Année :</span> 
            <span class="nm-meta__value"><?php echo esc_html($annee); ?></span>
          </li>
        </ul>
      </div>
      
      <!-- Colonne droite : Image principale -->
      <div class="nm-photo__right">
        <?php if (has_post_thumbnail()) : ?>
          <?php the_post_thumbnail('large', [
            'class' => 'nm-photo__img',
            'alt' => get_the_title(),
            'loading' => 'eager'
          ]); ?>
        <?php endif; ?>
      </div>
      
      <!-- Bloc CTA Contact -->
<div class="nm-photo__cta">
  <div class="nm-photo__cta-row">
    <span>Cette photo vous intéresse ?</span>
    <button class="nm-btn nm-open-contact" data-photo-ref="<?php echo esc_attr($reference); ?>">
      Contact
    </button>
    <div class="nm-nav__preview">
      <?php
      $next_post = get_next_post(true, '', 'categorie');
      if ($next_post && has_post_thumbnail($next_post->ID)) : ?>
        <img src="<?php echo get_the_post_thumbnail_url($next_post->ID, 'thumbnail'); ?>"
             alt="Aperçu photo suivante">
      <?php endif; ?>
    </div>
  </div>
  <div class="nm-photo__navigation">
    <div class="nm-nav__arrows">
      <?php
      $prev_post = get_previous_post(true, '', 'categorie');
      if ($prev_post) : ?>
        <a href="<?php echo get_permalink($prev_post); ?>" class="nm-nav__link">←</a>
      <?php endif; ?>
      <?php
      $next_post = get_next_post(true, '', 'categorie');
      if ($next_post) : ?>
        <a href="<?php echo get_permalink($next_post); ?>" class="nm-nav__link">→</a>
      <?php endif; ?>
    </div>
  </div>
  <div class="nm-photo__cta-divider"></div>
</div>
</div>

</div>
    
  </article>
  
  <!-- Section "Vous aimerez aussi" -->
  <section class="nm-related" aria-labelledby="nm-related-title">
    <h2 id="nm-related-title">Vous aimerez aussi</h2>
    
    <?php
    $related_args = [
      'post_type' => 'photo',
      'posts_per_page' => 2,
      'post__not_in' => [$post_id],
      'orderby' => 'rand',
      'no_found_rows' => true,
    ];
    
    if (!empty($cat_ids)) {
      $related_args['tax_query'] = [[
        'taxonomy' => 'categorie',
        'field' => 'term_id',
        'terms' => $cat_ids,
      ]];
    }
    
    $related_query = new WP_Query($related_args);
    
    if ($related_query->have_posts()) : ?>
      <div class="nm-related__grid">
        <?php while ($related_query->have_posts()) : $related_query->the_post(); ?>
          <?php get_template_part('template-parts/photo_bloc'); ?>
        <?php endwhile; ?>
      </div>
    <?php endif;
    wp_reset_postdata();
    ?>
  </section>
  
</main>

<?php
endwhile;
get_footer(); ?>
