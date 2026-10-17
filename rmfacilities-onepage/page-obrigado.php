<?php
/**
 * Template Name: Obrigado
 * Página exibida após envio do formulário de contato.
 *
 * @package rmfacilities-onepage
 */

get_header();
$rmf_whatsapp_phone = get_theme_mod( 'rmf_whatsapp_phone', '+55 (12) 3042-1799' );
$rmf_whatsapp_url   = function_exists( 'rmf_get_whatsapp_url' ) ? rmf_get_whatsapp_url() : '#contato';
$rmf_company_phone  = get_theme_mod( 'rmf_company_phone_2', '+55 (12) 3042-1799' );
$rmf_company_digits = preg_replace( '/\D+/', '', (string) $rmf_company_phone );
?>
<div class="obrigado-page">
	<section class="obrigado-hero">
		<div class="container">
			<div class="obrigado-card">
				<div class="obrigado-icon" aria-hidden="true">✅</div>
				<h1><?php esc_html_e( 'Mensagem recebida!', 'rmfacilities-onepage' ); ?></h1>
				<p class="obrigado-lead">
					<?php esc_html_e( 'Obrigado pelo seu contato. Nossa equipe vai analisar sua solicitação e entrará em contato.', 'rmfacilities-onepage' ); ?>
				</p>

				<ul class="obrigado-proximos">
					<li>📋 Analisamos o serviço de interesse informado</li>
					<li>📞 Entraremos em contato por telefone ou WhatsApp</li>
					<li>📄 Elaboramos uma proposta personalizada para você</li>
				</ul>

				<div class="obrigado-actions">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn-primary">
						<?php esc_html_e( 'Voltar ao início', 'rmfacilities-onepage' ); ?>
					</a>
					<a href="<?php echo esc_url( $rmf_whatsapp_url ); ?>" class="btn btn-whatsapp" target="_blank" rel="noopener noreferrer">
						💬 <?php esc_html_e( 'Falar pelo WhatsApp', 'rmfacilities-onepage' ); ?>
					</a>
				</div>

				<p class="obrigado-contato-direto">
					Prefere contato direto?
					<a href="<?php echo esc_attr( 'tel:+' . $rmf_company_digits ); ?>"><?php echo esc_html( $rmf_company_phone ); ?></a> |
					<a href="mailto:<?php echo esc_attr( get_theme_mod( 'rmf_company_email', 'contato@rmfacilities.com.br' ) ); ?>">
						<?php echo esc_html( get_theme_mod( 'rmf_company_email', 'contato@rmfacilities.com.br' ) ); ?>
					</a>
				</p>
			</div>
		</div>
	</section>
<?php get_footer(); ?>
