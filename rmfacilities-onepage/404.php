<?php
/**
 * Template 404.
 *
 * @package RMFacilitiesOnePage
 */

get_header();
?>

<section class="section">
	<div class="container not-found">
		<p class="kicker">404</p>
		<h1><?php esc_html_e( 'Pagina nao encontrada', 'rmfacilities-onepage' ); ?></h1>
		<p><?php esc_html_e( 'O conteudo solicitado nao existe ou foi movido.', 'rmfacilities-onepage' ); ?></p>
		<p><a class="btn btn-primary" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Voltar para inicio', 'rmfacilities-onepage' ); ?></a></p>
	</div>
</section>

<?php
get_footer();
