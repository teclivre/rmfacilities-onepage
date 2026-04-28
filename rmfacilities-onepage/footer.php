<?php
/**
 * Footer do tema.
 *
 * @package RMFacilitiesOnePage
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

</main>

<footer class="site-footer" id="rodape">
	<div class="container footer-grid">
		<div>
			<h3><?php bloginfo( 'name' ); ?></h3>
			<p><?php echo esc_html( get_theme_mod( 'rmf_company_address' ) ); ?></p>
			<p><?php echo esc_html( get_theme_mod( 'rmf_company_phone_1' ) ); ?></p>
			<p><?php echo esc_html( get_theme_mod( 'rmf_company_phone_2' ) ); ?></p>
			<p>CNPJ: <?php echo esc_html( get_theme_mod( 'rmf_company_cnpj' ) ); ?></p>
		</div>

		<div>
			<h3><?php esc_html_e( 'Contato', 'rmfacilities-onepage' ); ?></h3>
			<p><a href="mailto:<?php echo esc_attr( get_theme_mod( 'rmf_company_email' ) ); ?>"><?php echo esc_html( get_theme_mod( 'rmf_company_email' ) ); ?></a></p>
			<p><a href="mailto:<?php echo esc_attr( get_theme_mod( 'rmf_company_careers' ) ); ?>"><?php echo esc_html( get_theme_mod( 'rmf_company_careers' ) ); ?></a></p>
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
		<p>&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?>. <?php esc_html_e( 'Todos os direitos reservados.', 'rmfacilities-onepage' ); ?></p>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
