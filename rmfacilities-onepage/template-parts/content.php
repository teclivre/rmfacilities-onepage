<?php
/**
 * Cartao padrao de conteudo.
 *
 * @package RMFacilitiesOnePage
 */
?>

<article <?php post_class( 'post-card-list' ); ?> id="post-<?php the_ID(); ?>">
	<header>
		<p class="post-meta"><?php echo esc_html( get_the_date() ); ?></p>
		<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
	</header>

	<?php if ( has_post_thumbnail() ) : ?>
		<a class="post-thumb" href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'medium_large' ); ?></a>
	<?php endif; ?>

	<div class="entry-summary">
		<?php the_excerpt(); ?>
	</div>

	<p><a class="text-link" href="<?php the_permalink(); ?>"><?php esc_html_e( 'Continuar lendo', 'rmfacilities-onepage' ); ?></a></p>
</article>
