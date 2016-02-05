<?php
/**
 * A single post's meta data
 *
 * @brief Displays a single post's published date
 *
 * @package luigi
 */

if ( get_post_type() == 'post' ) : ?>
<div class="entry-meta">
    <time class="entry-date published updated" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
        <?php the_date(); ?>
    </time>
</div>
<?php endif;
