<?php
/**
 * The loop that displays a single post.
 *
 * @package WordPress
 * @subpackage Yawn
 */
?>

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

  <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    
    <?php
    // Above post space for widgets
    if ( is_active_sidebar( 'above-post-widget-area' ) ) : ?>
      <div id="ad-container-above-post">
        <?php dynamic_sidebar( 'above-post-widget-area' ); ?>
      </div><!-- #ad-container-above-post -->
    <?php endif; ?>
    
    <h1 class="entry-title"><?php the_title(); ?></h1>
    <div class="entry-meta">
      <?php yawn_posted_on(); ?>
    </div><!-- .entry-meta -->
    
    <?php
    // Above post content space for widgets
    if ( is_active_sidebar( 'above-post-content-widget-area' ) ) : ?>
      <div id="ad-container-above-post-content">
        <?php dynamic_sidebar( 'above-post-content-widget-area' ); ?>
      </div><!-- #ad-container-above-post-content -->
    <?php endif; ?>
    
    <div class="entry-content">
      <?php the_content(); ?>
      <?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'twentyten' ), 'after' => '</div>' ) ); ?>
    </div><!-- .entry-content -->
    
    <?php
    // Below post space for widgets
    if ( is_active_sidebar( 'below-post-widget-area' ) ) : ?>
      <div id="ad-container-below-post">
        <?php dynamic_sidebar( 'below-post-widget-area' ); ?>
      </div><!-- #ad-container-below-post -->
    <?php endif; ?>

    <?php if ( get_the_author_meta( 'description' ) ) : // If a user has filled out their description, show a bio on their entries  ?>
    <div id="entry-author-info">
      <div id="author-avatar">
        <?php echo get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'twentyten_author_bio_avatar_size', 60 ) ); ?>
      </div><!-- #author-avatar -->
      <div id="author-description">
        <h2><?php printf( esc_attr__( 'About %s', 'twentyten' ), get_the_author() ); ?></h2>
        <?php the_author_meta( 'description' ); ?>
        <div id="author-link">
          <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>">
            <?php printf( __( 'View all posts by %s <span class="meta-nav">&rarr;</span>', 'twentyten' ), get_the_author() ); ?>
          </a>
        </div><!-- #author-link	-->
      </div><!-- #author-description -->
    </div><!-- #entry-author-info -->
    <?php endif; ?>

    <div class="entry-utility">
      <?php twentyten_posted_in(); ?>
      <?php edit_post_link( __( 'Edit', 'twentyten' ), '<span class="edit-link">', '</span>' ); ?>
    </div><!-- .entry-utility -->
  </div><!-- #post-## -->

  <?php comments_template( '', true ); ?>

<?php endwhile; // end of the loop. ?>