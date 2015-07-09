<?php
/**
 * Template part for displaying posts.
 *
 * This is used when posts are displayed in a list. For example, the main blog
 * page.
 *
 * @package wp-devangelist
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php the_title( sprintf( '<h1 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h1>' ); ?>
		<?php if( "post" == get_post_type()): ?>
			<div class="entry-meta"><?php wp_devangelist_posted_on(); ?></div>
		<?php endif; ?>
		<?php if( 1==0 ):/*has_post_thumbnail()):*/ ?>
			<div class="wp-post-image-wrapper">
				<?php the_post_thumbnail(); ?>
			</div>
		<?php endif; ?>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php
			/* translators: %s: Name of current post */
			//the_content( sprintf(
				//wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', '_s' ), array( 'span' => array( 'class' => array() ) ) ),
				//the_title( '<span class="screen-reader-text">"', '"</span>', false )
			//) );
			the_content();
		?>

		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', '_s' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->
	<footer class="entry-footer">
		<?php comments_popup_link("Leave a comment", "1 comment", "% comments",
		"comment", "comments disabled"); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->
