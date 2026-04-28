<?php
/**
 * Template de comentarios.
 *
 * @package RMFacilitiesOnePage
 */

if ( post_password_required() ) {
	return;
}
?>

<section class="comments-area">
	<?php if ( have_comments() ) : ?>
		<h2 class="comments-title">
			<?php
			printf(
				/* translators: %d: total comments */
				esc_html( _n( '%d comentario', '%d comentarios', get_comments_number(), 'rmfacilities-onepage' ) ),
				intval( get_comments_number() )
			);
			?>
		</h2>

		<ol class="comment-list">
			<?php
			wp_list_comments(
				array(
					'style'      => 'ol',
					'short_ping' => true,
				)
			);
			?>
		</ol>

		<?php the_comments_pagination(); ?>
	<?php endif; ?>

	<?php comment_form(); ?>
</section>
