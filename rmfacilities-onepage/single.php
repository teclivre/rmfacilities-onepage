<?php
/**
 * Template de artigo individual.
 *
 * @package RMFacilitiesOnePage
 */

get_header();
?>

<section class="section">
	<div class="container content-grid">
		<div>
			<?php while ( have_posts() ) : the_post(); ?>
				<article <?php post_class( 'post-single' ); ?> id="post-<?php the_ID(); ?>">
					<header>
						<p class="post-meta"><?php echo esc_html( get_the_date() ); ?> | <?php the_category( ', ' ); ?></p>
						<h1><?php the_title(); ?></h1>
					</header>

					<?php if ( has_post_thumbnail() ) : ?>
						<div class="post-thumb"><?php the_post_thumbnail( 'large' ); ?></div>
					<?php endif; ?>

					<div class="post-content">
						<?php the_content(); ?>
					</div>

					<footer class="post-footer">
						<?php the_tags( '<p><strong>Tags:</strong> ', ', ', '</p>' ); ?>
					</footer>
				</article>

				<?php comments_template(); ?>
			<?php endwhile; ?>
		</div>
		<?php get_sidebar(); ?>
	</div>
</section>

<?php
get_footer();
