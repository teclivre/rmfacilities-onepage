<?php
/**
 * Pagina de artigos.
 *
 * @package RMFacilitiesOnePage
 */

get_header();
?>

<section class="section page-head">
	<div class="container">
		<p class="kicker"><?php esc_html_e( 'Blog RM Facilities', 'rmfacilities-onepage' ); ?></p>
		<h1><?php esc_html_e( 'Artigos e conteudos', 'rmfacilities-onepage' ); ?></h1>
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
