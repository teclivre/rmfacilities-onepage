<?php
/**
 * Funcoes do tema RM Facilities OnePage.
 *
 * @package RMFacilitiesOnePage
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function rmf_theme_setup() {
	load_theme_textdomain( 'rmfacilities-onepage', get_template_directory() . '/languages' );

	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);
	add_theme_support( 'custom-logo', array( 'height' => 60, 'width' => 240, 'flex-width' => true ) );

	register_nav_menus(
		array(
			'primary' => __( 'Menu Principal', 'rmfacilities-onepage' ),
			'footer'  => __( 'Menu Rodape', 'rmfacilities-onepage' ),
		)
	);
}
add_action( 'after_setup_theme', 'rmf_theme_setup' );

function rmf_enqueue_assets() {
	$version = wp_get_theme()->get( 'Version' );

	wp_enqueue_style( 'rmf-style', get_stylesheet_uri(), array(), $version );
	wp_enqueue_style( 'rmf-main', get_template_directory_uri() . '/assets/css/main.css', array( 'rmf-style' ), $version );
	wp_enqueue_script( 'rmf-theme', get_template_directory_uri() . '/assets/js/theme.js', array(), $version, true );
}
add_action( 'wp_enqueue_scripts', 'rmf_enqueue_assets' );

function rmf_register_sidebar() {
	register_sidebar(
		array(
			'name'          => __( 'Barra Lateral', 'rmfacilities-onepage' ),
			'id'            => 'sidebar-1',
			'description'   => __( 'Widgets para blog e paginas internas.', 'rmfacilities-onepage' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);
}
add_action( 'widgets_init', 'rmf_register_sidebar' );

function rmf_primary_menu_fallback() {
	echo '<ul id="primary-menu" class="menu">';
	echo '<li><a href="' . esc_url( home_url( '/#inicio' ) ) . '">' . esc_html__( 'Inicio', 'rmfacilities-onepage' ) . '</a></li>';
	echo '<li><a href="' . esc_url( home_url( '/#sobre' ) ) . '">' . esc_html__( 'Sobre', 'rmfacilities-onepage' ) . '</a></li>';
	echo '<li><a href="' . esc_url( home_url( '/#servicos' ) ) . '">' . esc_html__( 'Servicos', 'rmfacilities-onepage' ) . '</a></li>';
	echo '<li><a href="' . esc_url( home_url( '/#contato' ) ) . '">' . esc_html__( 'Contato', 'rmfacilities-onepage' ) . '</a></li>';
	echo '<li><a href="' . esc_url( home_url( '/#blog' ) ) . '">' . esc_html__( 'Artigos', 'rmfacilities-onepage' ) . '</a></li>';
	echo '</ul>';
}

function rmf_customize_register( $wp_customize ) {
	$wp_customize->add_section(
		'rmf_company_data',
		array(
			'title'       => __( 'Dados da Empresa', 'rmfacilities-onepage' ),
			'description' => __( 'Ajuste rapido dos dados institucionais exibidos no tema.', 'rmfacilities-onepage' ),
			'priority'    => 30,
		)
	);

	$fields = array(
		'rmf_company_address' => 'Avenida Ilidio Meinberg Porto, 199, Sala 6, Jardim Sao Vicente, Sao Jose dos Campos - SP - CEP 12224310',
		'rmf_company_phone_1' => '+55 (12) 3042-1795',
		'rmf_company_phone_2' => '+55 (12) 3042-1799',
		'rmf_company_cnpj'    => '39.416.796/0001-01',
		'rmf_company_email'   => 'contato@rmfacilities.com.br',
		'rmf_company_careers' => 'trabalheconosco@rmfacilities.com.br',
		'rmf_instagram_url'   => 'https://www.instagram.com/',
		'rmf_facebook_url'    => 'https://www.facebook.com/',
	);

	foreach ( $fields as $setting_id => $default_value ) {
		$wp_customize->add_setting(
			$setting_id,
			array(
				'default'           => $default_value,
				'sanitize_callback' => 'sanitize_text_field',
			)
		);

		$wp_customize->add_control(
			$setting_id,
			array(
				'label'   => ucwords( str_replace( array( 'rmf_', '_' ), array( '', ' ' ), $setting_id ) ),
				'section' => 'rmf_company_data',
				'type'    => 'text',
			)
		);
	}
}
add_action( 'customize_register', 'rmf_customize_register' );

/**
 * Cria uma pagina se ela ainda nao existir.
 *
 * @param string $title Titulo da pagina.
 * @param string $slug  Slug da pagina.
 * @return int ID da pagina.
 */
function rmf_get_or_create_page( $title, $slug ) {
	$existing_page = get_page_by_path( $slug );

	if ( $existing_page instanceof WP_Post ) {
		return (int) $existing_page->ID;
	}

	$existing_page = get_page_by_title( $title );

	if ( $existing_page instanceof WP_Post ) {
		return (int) $existing_page->ID;
	}

	$page_id = wp_insert_post(
		array(
			'post_title'   => $title,
			'post_name'    => $slug,
			'post_status'  => 'publish',
			'post_type'    => 'page',
			'post_content' => '',
		)
	);

	if ( is_wp_error( $page_id ) ) {
		return 0;
	}

	return (int) $page_id;
}

/**
 * Configuracao inicial do tema ao ativar.
 */
function rmf_after_switch_theme_setup() {
	$home_page_id = rmf_get_or_create_page( 'Inicio', 'inicio' );
	$blog_page_id = rmf_get_or_create_page( 'Blog', 'blog' );

	if ( $home_page_id > 0 ) {
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $home_page_id );
	}

	if ( $blog_page_id > 0 ) {
		update_option( 'page_for_posts', $blog_page_id );
	}

	$menu_name = 'Menu Principal RM Facilities';
	$menu_obj  = wp_get_nav_menu_object( $menu_name );
	$menu_id   = $menu_obj ? (int) $menu_obj->term_id : (int) wp_create_nav_menu( $menu_name );

	if ( $menu_id > 0 ) {
		$menu_items = wp_get_nav_menu_items( $menu_id );

		if ( empty( $menu_items ) ) {
			$links = array(
				array(
					'title' => 'Inicio',
					'url'   => home_url( '/#inicio' ),
				),
				array(
					'title' => 'Sobre',
					'url'   => home_url( '/#sobre' ),
				),
				array(
					'title' => 'Servicos',
					'url'   => home_url( '/#servicos' ),
				),
				array(
					'title' => 'Contato',
					'url'   => home_url( '/#contato' ),
				),
				array(
					'title' => 'Artigos',
					'url'   => home_url( '/#blog' ),
				),
			);

			foreach ( $links as $link ) {
				wp_update_nav_menu_item(
					$menu_id,
					0,
					array(
						'menu-item-title'  => $link['title'],
						'menu-item-url'    => $link['url'],
						'menu-item-status' => 'publish',
						'menu-item-type'   => 'custom',
					)
				);
			}
		}

		$locations             = get_theme_mod( 'nav_menu_locations', array() );
		$locations['primary']  = $menu_id;
		$locations['footer']   = $menu_id;
		set_theme_mod( 'nav_menu_locations', $locations );
	}
}
add_action( 'after_switch_theme', 'rmf_after_switch_theme_setup' );
