<?php
/**
 * Template padrao de paginas.
 *
 * @package RMFacilitiesOnePage
 */

get_header();
?>

<section class="section">
	<div class="container content-grid">
		<div>
			<?php while ( have_posts() ) : the_post(); ?>
				<article <?php post_class( 'page-content' ); ?> id="post-<?php the_ID(); ?>">
					<h1><?php the_title(); ?></h1>
					<?php the_content(); ?>
				</article>
				<?php comments_template(); ?>
			<?php endwhile; ?>
		</div>
		<?php get_sidebar(); ?>
	</div>
</section>

<?php
get_footer();
