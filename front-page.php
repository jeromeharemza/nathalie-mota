<?php
/* Template Name: Front Page */
get_header(); ?>

<main>

<?php
// HERO IMAGE
$hero_image_id = get_post_meta(get_the_ID(), 'hero_image', true);
$image_url = $hero_image_id ? wp_get_attachment_url($hero_image_id) : '';
?>

<section class="nm-home-hero" style="<?php echo $image_url ? 'background-image: url(' . esc_url($image_url) . ');' : ''; ?>">
    <h1 class="nm-hero-title">PHOTOGRAPHE EVENT</h1>
</section>

<section class="nm-home-main">

  <!-- =======================
       FORMULAIRE DE FILTRES
  ======================== -->
  <form id="nm-filters" method="get" class="nm-home-filters">

    <div class="filters-taxonomy">

      <!-- FILTRE CATÉGORIE -->
      <div class="custom-select-wrapper">
        <div class="custom-select" data-name="category">
          <div class="custom-select-trigger">
            <span>Catégories</span>
            <div class="arrow"></div>
          </div>

          <div class="custom-options">
            <div class="custom-option" data-value="">Catégories</div>

            <?php
            $terms = get_terms([
              'taxonomy' => 'categorie',    
              'hide_empty' => true
            ]);

            if (!is_wp_error($terms)) {
              foreach($terms as $term) {
                echo '<div class="custom-option" data-value="' . esc_attr($term->slug) . '">' 
                      . esc_html($term->name) .
                     '</div>';
              }
            }
            ?>
          </div>
        </div>

        <input type="hidden" name="category" id="nm-category" value="">
      </div>


      <!-- FILTRE FORMAT -->
      <div class="custom-select-wrapper">
        <div class="custom-select" data-name="format">
          <div class="custom-select-trigger">
            <span>Formats</span>
            <div class="arrow"></div>
          </div>

          <div class="custom-options">
            <div class="custom-option" data-value="">Formats</div>

            <?php
            $formats = get_terms([
              'taxonomy' => 'format',
              'hide_empty' => true
            ]);

            if (!is_wp_error($formats)) {
              foreach($formats as $format) {
                echo '<div class="custom-option" data-value="' . esc_attr($format->slug) . '">' 
                      . esc_html($format->name) .
                     '</div>';
              }
            }
            ?>
          </div>
        </div>

        <input type="hidden" name="format" id="nm-format" value="">
      </div>

    </div>


    <!-- FILTRE TRI -->
    <div class="custom-select-wrapper">
      <div class="custom-select" data-name="order">
        <div class="custom-select-trigger">
          <span>Trier par</span>
          <div class="arrow"></div>
        </div>

        <div class="custom-options">
          <div class="custom-option" data-value="">Trier par</div>
          <div class="custom-option" data-value="date_desc">Plus récentes</div>
          <div class="custom-option" data-value="date_asc">Plus anciennes</div>
        </div>
      </div>

      <input type="hidden" name="order" id="nm-order" value="">
    </div>

  </form>

  <!-- =======================
       GALERIE DES PHOTOS
  ======================== -->

  <div class="nm-home-gallery" id="gallery">

    <?php
    // GET PARAMS
    $order    = isset($_GET['order']) ? sanitize_text_field($_GET['order']) : '';
    $category = isset($_GET['category']) ? sanitize_text_field($_GET['category']) : '';
    $format   = isset($_GET['format']) ? sanitize_text_field($_GET['format']) : '';

    // BASE WP_QUERY
    $args = [
      'post_type'      => 'photo',
      'posts_per_page' => 8,
      'orderby'        => 'date',
      'order'          => 'DESC',
    ];

    // TRI
    if ($order === 'date_asc')  $args['order'] = 'ASC';
    if ($order === 'date_desc') $args['order'] = 'DESC';

    // FILTRES TAXONOMIQUES
    $tax_query = [];

    if (!empty($category)) {
      $tax_query[] = [
        'taxonomy' => 'categorie', 
        'field'    => 'slug',
        'terms'    => $category,
      ];
    }

    if (!empty($format)) {
      $tax_query[] = [
        'taxonomy' => 'format',
        'field'    => 'slug',
        'terms'    => $format,
      ];
    }

    if (!empty($tax_query)) {
      $args['tax_query'] = $tax_query;
    }

    // LANCER LA REQUÊTE
    $query = new WP_Query($args);

    if ($query->have_posts()) :
      while ($query->have_posts()) :
        $query->the_post();
        get_template_part('template-parts/photo_bloc');
      endwhile;
      wp_reset_postdata();
    else :
      echo '<p>Aucune photo trouvée</p>';
    endif;
    ?>

  </div>


  <!-- BOUTON CHARGER PLUS -->
  <div class="nm-home-loadmore-wrap">
    <button class="nm-home-loadmore">Charger plus</button>
  </div>

</section>

</main>

<?php get_footer(); ?>
