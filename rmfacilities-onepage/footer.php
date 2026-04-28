<?php
/**
 * Footer do tema.
 *
 * @package RMFacilitiesOnePage
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$rmf_whatsapp_url = function_exists( 'rmf_get_whatsapp_url' ) ? rmf_get_whatsapp_url() : '#contato';
$rmf_phone_1     = get_theme_mod( 'rmf_company_phone_1', '+55 (12) 3042-1795' );
$rmf_phone_2     = get_theme_mod( 'rmf_company_phone_2', '+55 (12) 3042-1799' );
$rmf_email       = get_theme_mod( 'rmf_company_email', 'contato@rmfacilities.com.br' );
$rmf_careers     = get_theme_mod( 'rmf_company_careers', 'trabalheconosco@rmfacilities.com.br' );
$rmf_address     = get_theme_mod( 'rmf_company_address', 'Avenida Ilidio Meinberg Porto, 199, Sala 6 Jardim Sao Vicente, Sao Jose dos Campos - SP - CEP 12224-310' );
$rmf_cnpj        = get_theme_mod( 'rmf_company_cnpj', '39.416.796/0001-01' );
?>

</main>

<footer class="site-footer" id="rodape">
	<div class="container footer-grid">
		<div>
			<h3><?php esc_html_e( 'RM Facilities LTDA', 'rmfacilities-onepage' ); ?></h3>
			<p><?php esc_html_e( 'CNPJ', 'rmfacilities-onepage' ); ?>: <?php echo esc_html( $rmf_cnpj ); ?></p>
			<p><?php echo esc_html( $rmf_address ); ?></p>
		</div>

		<div>
			<h3><?php esc_html_e( 'Contato', 'rmfacilities-onepage' ); ?></h3>
			<p><strong><?php esc_html_e( 'Telefone 1', 'rmfacilities-onepage' ); ?>:</strong> <a href="tel:+551230421795"><?php echo esc_html( $rmf_phone_1 ); ?></a></p>
			<p><strong><?php esc_html_e( 'Telefone 2', 'rmfacilities-onepage' ); ?>:</strong> <a href="tel:+551230421799"><?php echo esc_html( $rmf_phone_2 ); ?></a></p>
			<p><strong>WhatsApp:</strong> <a href="<?php echo esc_url( $rmf_whatsapp_url ); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html( get_theme_mod( 'rmf_whatsapp_phone', '+55 (12) 3042-1799' ) ); ?></a></p>
			<p><strong>E-mail:</strong> <a href="mailto:<?php echo esc_attr( $rmf_email ); ?>"><?php echo esc_html( $rmf_email ); ?></a></p>
			<p><strong><?php esc_html_e( 'Trabalhe conosco', 'rmfacilities-onepage' ); ?>:</strong> <a href="mailto:<?php echo esc_attr( $rmf_careers ); ?>"><?php echo esc_html( $rmf_careers ); ?></a></p>
		</div>

		<div>
			<h3><?php esc_html_e( 'Navegacao', 'rmfacilities-onepage' ); ?></h3>
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'footer',
					'container'      => false,
					'menu_class'     => 'footer-menu',
					'fallback_cb'    => 'rmf_primary_menu_fallback',
				)
			);
			?>
		</div>
	</div>

	<div class="container footer-bottom">
			<p>&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> RM Facilities LTDA. Todos os direitos reservados.</p>
	</div>
</footer>

<a class="whatsapp-float" href="<?php echo esc_url( $rmf_whatsapp_url ); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php esc_attr_e( 'Falar com a RM Facilities LTDA no WhatsApp', 'rmfacilities-onepage' ); ?>">
	<svg viewBox="0 0 32 32" fill="currentColor" aria-hidden="true" focusable="false">
		<path d="M16 3C8.82 3 3 8.82 3 16c0 2.58.75 5.08 2.17 7.23L3.44 29l5.92-1.68A12.95 12.95 0 0 0 16 29c7.18 0 13-5.82 13-13S23.18 3 16 3zm0 23.62c-2.08 0-4.12-.56-5.9-1.61l-.42-.25-3.52 1 .94-3.43-.28-.44A10.6 10.6 0 0 1 5.38 16C5.38 10.15 10.15 5.38 16 5.38S26.62 10.15 26.62 16 21.85 26.62 16 26.62zm5.83-7.95c-.32-.16-1.9-.94-2.2-1.05-.29-.11-.5-.16-.71.16-.21.32-.81 1.05-.99 1.27-.18.21-.36.24-.67.08-.32-.16-1.34-.49-2.55-1.55-.94-.84-1.58-1.88-1.76-2.2-.18-.32-.02-.49.14-.65.14-.14.32-.36.47-.54.16-.18.21-.32.32-.53.11-.21.05-.4-.03-.55-.08-.16-.71-1.7-.97-2.33-.25-.6-.5-.52-.71-.53h-.6c-.21 0-.55.08-.84.4-.29.32-1.1 1.08-1.1 2.64s1.13 3.06 1.29 3.27c.16.21 2.22 3.38 5.38 4.74.75.32 1.34.51 1.8.65.76.24 1.45.21 2 .13.61-.09 1.9-.78 2.17-1.54.27-.76.27-1.41.19-1.54-.08-.13-.29-.21-.61-.36z"/>
	</svg>
	<span><?php esc_html_e( 'WhatsApp', 'rmfacilities-onepage' ); ?></span>
</a>

<?php wp_footer(); ?>
</body>
</html>
