<?php
/**
 * Template part for displaying posts
 *
 * @package Electronic Supermarket
 * @subpackage electronic_supermarket
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="box-info">
        <?php $blog_archive_ordering = get_theme_mod('blog_meta_order', array('date', 'author', 'comment'));
        foreach ($blog_archive_ordering as $blog_data_order) : 
            if ('date' === $blog_data_order) : ?>
              <i class="far fa-calendar-alt"></i><span class="entry-date"><?php echo get_the_date('j F, Y'); ?></span>
            <?php elseif ('author' === $blog_data_order) : ?>
              <i class="fas fa-user"></i><span class="entry-author"><?php the_author(); ?></span>
            <?php elseif ('comment' === $blog_data_order) : ?>
              <i class="fas fa-comments"></i><span class="entry-comments"><?php comments_number(__('0 Comments', 'electronic-supermarket'), __('0 Comments', 'electronic-supermarket'), __('% Comments', 'electronic-supermarket')); ?></span>
            <?php endif;
        endforeach; ?>
    </div>
    <hr>
    <div class="box-content">
        <?php the_content(); ?>
        <?php if(get_theme_mod('electronic_supermarket_remove_tags',true) != ''){ 
            $tags = get_the_tags(); // Retrieve the post's tags
             custom_output_tags(); 
        }?>
        <?php
        // If comments are open or we have at least one comment, load up the comment template
        if ( comments_open() || '0' != get_comments_number() )
        comments_template();

        if ( is_singular( 'attachment' ) ) {
            // Parent post navigation.
            the_post_navigation( array(
                'prev_text' => _x( '<span class="meta-nav">Published in</span><span class="post-title">%title</span>', 'Parent post link', 'electronic-supermarket' ),
            ) );
        } elseif ( is_singular( 'post' ) ) {
            // Previous/next post navigation.
            the_post_navigation( array(
                'next_text' => '<span class="meta-nav" aria-hidden="true">' . __( 'Next:', 'electronic-supermarket' ) . '</span> ' .
                    '<span class="post-title">%title</span>',
                'prev_text' => '<span class="meta-nav" aria-hidden="true">' . __( 'Previous:', 'electronic-supermarket' ) . '</span> ' .
                    '<span class="post-title">%title</span>',
            ) );
        } ?>
        <div class="clearfix"></div>
    </div>
    <div class="mt-5"><?php get_template_part( 'template-parts/post/related-post'); ?></div>
</article>