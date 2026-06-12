<?php
/**
 * Template Name: Obrigado
 * Página exibida após envio do formulário de contato.
 *
 * @package rmfacilities-onepage
 */

get_header();
?>
<main id="main" class="site-main obrigado-page">
	<section class="obrigado-hero">
		<div class="container">
			<div class="obrigado-card">
				<div class="obrigado-icon" aria-hidden="true">✅</div>
				<h1><?php esc_html_e( 'Mensagem recebida!', 'rmfacilities-onepage' ); ?></h1>
				<p class="obrigado-lead">
					<?php esc_html_e( 'Obrigado pelo seu contato. Nossa equipe vai analisar sua solicitação e retornará em até 1 dia útil.', 'rmfacilities-onepage' ); ?>
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
					<?php
					$whatsapp = get_theme_mod( 'rmf_whatsapp_number', '5512930421799' );
					$wpp_url  = 'https://wa.me/' . preg_replace( '/\D/', '', $whatsapp ) . '?text=' . rawurlencode( 'Olá! Acabei de enviar um contato pelo site e gostaria de mais informações.' );
					?>
					<a href="<?php echo esc_url( $wpp_url ); ?>" class="btn btn-whatsapp" target="_blank" rel="noopener noreferrer">
						💬 <?php esc_html_e( 'Falar pelo WhatsApp', 'rmfacilities-onepage' ); ?>
					</a>
				</div>

				<p class="obrigado-contato-direto">
					Prefere contato direto?
					<a href="tel:+551230421799">(12) 3042-1799</a> |
					<a href="mailto:<?php echo esc_attr( get_theme_mod( 'rmf_company_email', 'contato@rmfacilities.com.br' ) ); ?>">
						<?php echo esc_html( get_theme_mod( 'rmf_company_email', 'contato@rmfacilities.com.br' ) ); ?>
					</a>
				</p>
			</div>
		</div>
	</section>
</main>
<?php get_footer(); ?>
