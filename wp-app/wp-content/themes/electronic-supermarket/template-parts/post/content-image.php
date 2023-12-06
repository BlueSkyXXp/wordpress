<?php
/**
 * Template part for displaying posts
 *
 * @package Electronic Supermarket
 * @subpackage electronic_supermarket
 */

?>
<?php $electronic_supermarket_column_layout = get_theme_mod( 'electronic_supermarket_sidebar_post_layout');
if($electronic_supermarket_column_layout == 'four-column' || $electronic_supermarket_column_layout == 'three-column' ){ ?>
  <div id="category-post">
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
      <div class="page-box">
         <?php
          // Get the post content
          $post_content = apply_filters('the_content', get_the_content());

          // Create a DOMDocument to parse the HTML content
          $dom = new DOMDocument();
          @$dom->loadHTML($post_content);

          // Find and display the first image in the post content
          $images = $dom->getElementsByTagName('img');

          echo ($images->length > 0)
              ? '<img src="' . esc_url($images->item(0)->getAttribute('src')) . '">'
              : '';
          ?>
          <div class="box-content">
              <h4><a href="<?php echo esc_url( get_permalink() ); ?>" title="<?php the_title_attribute(); ?>"><?php the_title();?></a></h4>
                  <div class="box-info">
                <?php 
              $blog_archive_ordering = get_theme_mod('blog_meta_order', array('date', 'author', 'comment'));
              foreach ($blog_archive_ordering as $blog_data_order) :
                  if ('date' === $blog_data_order) :?>
                      <i class="far fa-calendar-alt mb-1"></i><span class="entry-date"><?php echo get_the_date('j F, Y'); ?></span>
              <?php elseif ('author' === $blog_data_order) :?>
                      <i class="fas fa-user mb-1"></i><span class="entry-author"><?php the_author(); ?></span>
              <?php elseif ('comment' === $blog_data_order) :?>
                      <i class="fas fa-comments mb-1"></i><span class="entry-comments"><?php comments_number(__('0 Comments', 'electronic-supermarket'), __('0 Comments', 'electronic-supermarket'), __('% Comments', 'electronic-supermarket')); ?></span>
              <?php
                  endif;
              endforeach;
              ?>
                </div>
              <p><?php echo wp_trim_words(get_the_content(), get_theme_mod('electronic_supermarket_excerpt_count',35) );?></p>
              <?php if(get_theme_mod('electronic_supermarket_remove_read_button',true) != ''){ ?>
                  <div class="readmore-btn">
                      <a href="<?php echo esc_url( get_permalink() );?>" class="blogbutton-small" title="<?php esc_attr_e( 'Read More', 'electronic-supermarket' ); ?>"><?php echo esc_html(get_theme_mod('electronic_supermarket_read_more_text',__('Read More','electronic-supermarket')));?></a>
                  </div>
              <?php }?>
          </div>
          <div class="clearfix"></div>
      </div>
    </article>
  </div>
<?php } else{ ?>
<div id="category-post">
  <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="page-box row">
        <div class="col-lg-6 col-md-12">
          <?php
            // Get the post content
            $post_content = apply_filters('the_content', get_the_content());

            // Create a DOMDocument to parse the HTML content
            $dom = new DOMDocument();
            @$dom->loadHTML($post_content);

            // Find and display the first image in the post content
            $images = $dom->getElementsByTagName('img');

            echo ($images->length > 0)
                ? '<img src="' . esc_url($images->item(0)->getAttribute('src')) . '">'
                : '';
            ?>
        </div>
        <div class="box-content col-lg-6 col-md-12">
            <h4><a href="<?php echo esc_url( get_permalink() ); ?>" title="<?php the_title_attribute(); ?>"><?php the_title();?></a></h4>
            <div class="box-info">
              <?php $blog_archive_ordering = get_theme_mod('blog_meta_order', array('date', 'author', 'comment'));
              foreach ($blog_archive_ordering as $blog_data_order) : 
                  if ('date' === $blog_data_order) : ?>
                    <i class="far fa-calendar-alt mb-1"></i><span class="entry-date"><?php echo get_the_date('j F, Y'); ?></span>
                  <?php elseif ('author' === $blog_data_order) : ?>
                    <i class="fas fa-user mb-1"></i><span class="entry-author"><?php the_author(); ?></span>
                  <?php elseif ('comment' === $blog_data_order) : ?>
                    <i class="fas fa-comments mb-1"></i><span class="entry-comments"><?php comments_number(__('0 Comments', 'electronic-supermarket'), __('0 Comments', 'electronic-supermarket'), __('% Comments', 'electronic-supermarket')); ?></span>
                  <?php endif;
              endforeach; ?>
            </div>
            <p><?php echo wp_trim_words(get_the_content(), get_theme_mod('electronic_supermarket_excerpt_count',35) );?></p>
            <?php if(get_theme_mod('electronic_supermarket_remove_read_button',true) != ''){ ?>
                <div class="readmore-btn">
                    <a href="<?php echo esc_url( get_permalink() );?>" class="blogbutton-small" title="<?php esc_attr_e( 'Read More', 'electronic-supermarket' ); ?>"><?php echo esc_html(get_theme_mod('electronic_supermarket_read_more_text',__('Read More','electronic-supermarket')));?></a>
                </div>
            <?php }?>
        </div>
        <div class="clearfix"></div>
    </div>
  </article>
</div>
<?php } ?>