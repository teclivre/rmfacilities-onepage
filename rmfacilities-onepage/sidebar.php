<?php
/**
 * Sidebar.
 *
 * @package RMFacilitiesOnePage
 */

$rmf_wpp_url = function_exists( 'rmf_get_whatsapp_url' ) ? rmf_get_whatsapp_url() : 'https://wa.me/551230421799';
?>

<aside class="sidebar-area">

	<div class="sidebar-cta">
		<p class="kicker"><?php esc_html_e( 'Fale com um especialista', 'rmfacilities-onepage' ); ?></p>
		<h3><?php esc_html_e( 'Solicite um orcamento sem compromisso', 'rmfacilities-onepage' ); ?></h3>
		<p><?php esc_html_e( 'Reducao de custos, conformidade trabalhista e qualidade garantida no seu negocio.', 'rmfacilities-onepage' ); ?></p>
		<a class="btn btn-primary" href="<?php echo esc_url( home_url( '/#contato' ) ); ?>">
			<?php esc_html_e( 'Solicitar orcamento', 'rmfacilities-onepage' ); ?>
		</a>
		<a class="btn btn-outline sidebar-wpp" href="<?php echo esc_url( $rmf_wpp_url ); ?>" target="_blank" rel="noopener noreferrer">
			<?php esc_html_e( 'Falar no WhatsApp', 'rmfacilities-onepage' ); ?>
		</a>
	</div>

	<div class="sidebar-services">
		<p class="kicker"><?php esc_html_e( 'Nossos servicos', 'rmfacilities-onepage' ); ?></p>
		<ul>
			<li><a href="<?php echo esc_url( home_url( '/portaria-sao-jose-dos-campos/' ) ); ?>"><?php esc_html_e( 'Portaria', 'rmfacilities-onepage' ); ?></a></li>
			<li><a href="<?php echo esc_url( home_url( '/limpeza-sao-jose-dos-campos/' ) ); ?>"><?php esc_html_e( 'Limpeza', 'rmfacilities-onepage' ); ?></a></li>
			<li><a href="<?php echo esc_url( home_url( '/recepcao-sao-jose-dos-campos/' ) ); ?>"><?php esc_html_e( 'Recepcao', 'rmfacilities-onepage' ); ?></a></li>
			<li><a href="<?php echo esc_url( home_url( '/#servicos' ) ); ?>"><?php esc_html_e( 'Ver todos os servicos', 'rmfacilities-onepage' ); ?></a></li>
		</ul>
	</div>

</aside>
