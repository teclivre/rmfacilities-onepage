<?php
/**
 * Header do tema.
 *
 * @package RMFacilitiesOnePage
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="skip-link" href="#conteudo"><?php esc_html_e( 'Pular para o conteudo', 'rmfacilities-onepage' ); ?></a>

<header class="site-header" id="topo">
	<div class="container header-inner">
		<div class="site-branding">
			<?php
			if ( has_custom_logo() ) {
				the_custom_logo();
			} else {
				?>
				<a class="site-title" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a>
				<?php
			}
			?>
		</div>

		<button class="menu-toggle" aria-expanded="false" aria-controls="primary-navigation">
			<span></span><span></span><span></span>
		</button>

		<nav id="primary-navigation" class="main-navigation" aria-label="<?php esc_attr_e( 'Menu principal', 'rmfacilities-onepage' ); ?>">
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'primary',
					'container'      => false,
					'menu_class'     => 'menu',
					'fallback_cb'    => 'rmf_primary_menu_fallback',
				)
			);
			?>
		</nav>
	</div>
</header>

<main id="conteudo" class="site-main">
