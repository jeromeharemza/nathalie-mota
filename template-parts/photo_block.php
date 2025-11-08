<?php
/*
 * Template Part : Bloc photo
 */
?>
<div class="nm-related__item">
    <a href="<?php the_permalink(); ?>">
        <?php if (has_post_thumbnail()) : ?>
            <?php the_post_thumbnail('large', [
                'class' => 'nm-related__img',
                'alt' => get_the_title(),
                'loading' => 'lazy',
                'style' => 'object-fit: cover;'
            ]); ?>
        <?php endif; ?>
        <div class="nm-related__overlay">
            <span class="nm-related__title"><?php the_title(); ?></span>
        </div>
    </a>
</div>
