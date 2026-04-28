<?php
/**
 * Template de arquivo.
 *
 * @package RMFacilitiesOnePage
 */

get_header();
?>

<section class="section page-head">
	<div class="container">
		<p class="kicker"><?php esc_html_e( 'Arquivo', 'rmfacilities-onepage' ); ?></p>
		<h1><?php the_archive_title(); ?></h1>
		<?php the_archive_description( '<p>', '</p>' ); ?>
	</div>
</section>

<section class="section">
	<div class="container content-grid">
		<div>
			<?php if ( have_posts() ) : ?>
				<?php while ( have_posts() ) : the_post(); ?>
					<?php get_template_part( 'template-parts/content', get_post_type() ); ?>
				<?php endwhile; ?>
				<?php the_posts_pagination(); ?>
			<?php else : ?>
				<?php get_template_part( 'template-parts/content', 'none' ); ?>
			<?php endif; ?>
		</div>
		<?php get_sidebar(); ?>
	</div>
</section>

<?php
get_footer();
