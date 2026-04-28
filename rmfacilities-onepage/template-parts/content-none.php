<?php
/**
 * Estado sem conteudo.
 *
 * @package RMFacilitiesOnePage
 */
?>

<article class="no-results not-found">
	<h2><?php esc_html_e( 'Nenhum conteudo encontrado', 'rmfacilities-onepage' ); ?></h2>
	<p><?php esc_html_e( 'Tente outra busca ou volte para a pagina inicial.', 'rmfacilities-onepage' ); ?></p>
	<?php get_search_form(); ?>
</article>
