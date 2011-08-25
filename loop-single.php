<?php
/**
 * The loop that displays a single post.
 *
 * @package WordPress
 * @subpackage Yawn
 */
?>

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
  <div id="nav-above" class="navigation">
    <div class="nav-previous"><?php previous_post_link( '%link', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link', 'twentyten' ) . '</span> %title' ); ?></div>
    <div class="nav-next"><?php next_post_link( '%link', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next post link', 'twentyten' ) . '</span>' ); ?></div>
  </div><!-- #nav-above -->

  <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <h1 class="entry-title"><?php the_title(); ?></h1>
    <div class="entry-meta">
      <?php twentyten_posted_on(); ?>
    </div><!-- .entry-meta -->
    <div class="entry-content">
      <?php the_content(); ?>
      <?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'twentyten' ), 'after' => '</div>' ) ); ?>
    </div><!-- .entry-content -->

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

  <div id="nav-below" class="navigation">
    <div class="nav-previous"><?php previous_post_link( '%link', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link', 'twentyten' ) . '</span> %title' ); ?></div>
    <div class="nav-next"><?php next_post_link( '%link', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next post link', 'twentyten' ) . '</span>' ); ?></div>
  </div><!-- #nav-below -->

  <?php 
  //  disable this for now (work in progress)
  if (false): ?>
  <div id="digg_searches">
    <?php foreach (get_the_category(get_the_ID()) as $category): ?>
      <?php $digg_related_stories = yawn_digg_search($category->name); ?>
      <?php if (!empty($digg_related_stories)) :?>
          <?php foreach ($digg_related_stories as $story): ?>
          <div id="post-<?php the_ID()?>-digg-stories" class="post-<?php the_ID() ?> post type-post status-publish format-standard hentry">
            <h2 class="entry-title">
              <a href="<?php echo $story->link ?>" rel="bookmark">
                <?php echo $story->title ?>
              </a>
            </h2>
            <div class="entry-content">
              <?php echo $story->description; echo yawn_auto_excerpt_more('') ?>
            </div> <!-- .entry-content -->
          </div>
          <?php endforeach ?>
      <?php endif;
    endforeach; ?>
  </div>
  <?php endif; ?>

  <?php comments_template( '', true ); ?>

<?php endwhile; // end of the loop. ?>