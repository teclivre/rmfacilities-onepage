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

	// Fonte carregada via preload + noscript no wp_head para não bloquear render
	// (ver rmf_add_preload_hints)
	wp_enqueue_style( 'rmf-style', get_stylesheet_uri(), array(), $version );
	wp_enqueue_style( 'rmf-main', get_template_directory_uri() . '/assets/css/main.css', array( 'rmf-style' ), $version );
	wp_enqueue_script( 'rmf-theme', get_template_directory_uri() . '/assets/js/theme.js', array(), $version, true );
}
add_action( 'wp_enqueue_scripts', 'rmf_enqueue_assets' );

/**
 * Remove scripts de plugins que nao sao necessarios em todas as paginas.
 * Contact Form 7 e dk-pdf so devem carregar onde sao usados.
 */
function rmf_dequeue_unnecessary_scripts() {
	global $post;
	$is_contact_page = is_page( array( 'contato', 'vagas', 'cadastro-candidato' ) );
	$has_cf7 = is_a( $post, 'WP_Post' ) && (
		has_shortcode( $post->post_content, 'contact-form-7' ) ||
		has_shortcode( $post->post_content, 'wpcf7' )
	);

	if ( ! $is_contact_page && ! $has_cf7 ) {
		wp_dequeue_script( 'contact-form-7' );
		wp_dequeue_script( 'swv' );
		wp_dequeue_style( 'contact-form-7' );
		wp_dequeue_style( 'contact-form-7-rtl' );
	}

	// dk-pdf so e necessario em posts/paginas que tenham o shortcode
	if ( ! is_singular() || ( is_a( $post, 'WP_Post' ) && ! has_shortcode( $post->post_content, 'dkpdf-button' ) ) ) {
		wp_dequeue_script( 'dkpdf-frontend' );
		wp_dequeue_style( 'dkpdf-frontend' );
	}

	// UAG (Ultimate Addons for Gutenberg) - só em páginas com blocos UAG
	if ( ! is_singular() || ( is_a( $post, 'WP_Post' ) && strpos( $post->post_content, 'uagb' ) === false ) ) {
		wp_dequeue_style( 'zip-ai-sidebar-build' );
		wp_dequeue_style( 'zip-ai-sidebar-font' );
	}
}
add_action( 'wp_enqueue_scripts', 'rmf_dequeue_unnecessary_scripts', 100 );

/**
 * Preconnect e preload correto para fontes do Google.
 */
function rmf_add_preload_hints() {
	// Preload do CSS de fontes - informa ao browser para buscar cedo
	echo '<link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;600;700;800&family=Sora:wght@700;800&display=swap" onload="this.onload=null;this.rel=\'stylesheet\'" crossorigin>' . "\n";
	// Noscript fallback
	echo '<noscript><link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;600;700;800&family=Sora:wght@700;800&display=swap"></noscript>' . "\n";
	// Link para sitemap no head (sinal de indexação)
	echo '<link rel="sitemap" type="application/xml" title="Sitemap" href="' . esc_url( home_url( '/sitemap_index.xml' ) ) . '">' . "\n";
	// Preload do logo (LCP element) com alta prioridade
	$logo_id = get_theme_mod( 'custom_logo' );
	if ( $logo_id ) {
		$logo_url = wp_get_attachment_image_url( $logo_id, 'full' );
		if ( $logo_url ) {
			echo '<link rel="preload" as="image" href="' . esc_url( $logo_url ) . '" fetchpriority="high">' . "\n";
		}
	}
}
add_action( 'wp_head', 'rmf_add_preload_hints', 1 );

/**
 * Remove o jQuery Migrate e move jQuery para o rodapé (não-bloqueante).
 * jQuery no rodapé reduz o render-blocking time em ~400-800ms no mobile.
 */
function rmf_remove_jquery_migrate( $scripts ) {
	if ( ! is_admin() && isset( $scripts->registered['jquery'] ) ) {
		$script = $scripts->registered['jquery'];
		if ( $script->deps ) {
			$script->deps = array_diff( $script->deps, array( 'jquery-migrate' ) );
		}
	}
}
add_filter( 'wp_default_scripts', 'rmf_remove_jquery_migrate' );

/**
 * Move jQuery core para o rodapé (group=1) para não bloquear o render.
 * Só aplica no front-end; admin continua no head.
 */
function rmf_jquery_to_footer() {
	if ( is_admin() ) {
		return;
	}
	wp_scripts()->add_data( 'jquery', 'group', 1 );
	wp_scripts()->add_data( 'jquery-core', 'group', 1 );
}
add_action( 'wp_enqueue_scripts', 'rmf_jquery_to_footer', 1 );

/**
 * Remove numero de versao do WP de scripts e styles (segurança + cache).
 */
function rmf_remove_wp_version_from_assets( $src ) {
	if ( strpos( $src, 'ver=' ) ) {
		$src = remove_query_arg( 'ver', $src );
	}
	return $src;
}
add_filter( 'style_loader_src', 'rmf_remove_wp_version_from_assets', 9999 );
add_filter( 'script_loader_src', 'rmf_remove_wp_version_from_assets', 9999 );

/**
 * Remove o generator meta tag (nao expõe versao do WP).
 */
remove_action( 'wp_head', 'wp_generator' );

/**
 * Desativa emojis do WordPress (economiza requests e JS desnecessario).
 */
function rmf_disable_emojis() {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
	add_filter( 'tiny_mce_plugins', function( $plugins ) {
		return is_array( $plugins ) ? array_diff( $plugins, array( 'wpemoji' ) ) : array();
	} );
	add_filter( 'wp_resource_hints', function( $urls, $relation_type ) {
		if ( 'dns-prefetch' === $relation_type ) {
			$emoji_url = 'https://s.w.org/images/core/emoji/2/svg/';
			$urls = array_diff( $urls, array( $emoji_url ) );
		}
		return $urls;
	}, 10, 2 );
}
add_action( 'init', 'rmf_disable_emojis' );

/**
 * Desativa oEmbed / WordPress Embeds (remove request extra).
 */
function rmf_disable_embeds() {
	// Remove endpoint REST de oEmbed
	remove_action( 'rest_api_init', 'wp_oembed_register_route' );
	// Remove filtro de descoberta de oEmbed
	remove_filter( 'oembed_dataparse', 'wp_filter_oembed_result', 10 );
	// Remove link no head
	remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
	remove_action( 'wp_head', 'wp_oembed_add_host_js' );
	// Desregistra scripts de embed
	add_action( 'wp_enqueue_scripts', function() {
		wp_deregister_script( 'wp-embed' );
	} );
}
add_action( 'init', 'rmf_disable_embeds' );

/**
 * Desativa XML-RPC (nao usado, melhora segurança e performance).
 */
add_filter( 'xmlrpc_enabled', '__return_false' );

/**
 * Desativa CSS de plugins admin que nao sao necessarios no front-end.
 */
function rmf_dequeue_admin_styles() {
	if ( is_admin_bar_showing() ) return; // Só remove se não há admin bar
	// WP Mail SMTP admin bar CSS
	wp_dequeue_style( 'wp-mail-smtp-admin-bar' );
	// WPForms admin bar
	wp_dequeue_style( 'wpforms-admin-bar' );
	// Rank Math analytics CSS
	wp_dequeue_style( 'rank-math-pro-analytics' );
	wp_dequeue_style( 'rank-math-analytics' );
}
add_action( 'wp_enqueue_scripts', 'rmf_dequeue_admin_styles', 200 );

/**
 * Remove WPForms JS/CSS de páginas sem formulário.
 * Remove também fontes duplicadas e Font Awesome bloqueante.
 */
function rmf_dequeue_wpforms() {
	global $post;
	if ( is_singular() && is_a( $post, 'WP_Post' ) ) {
		$has_form = has_shortcode( $post->post_content, 'wpforms' )
			|| has_block( 'wpforms/form-selector', $post );
		if ( $has_form ) {
			wp_dequeue_style( 'rmf-fonts' );   // remove duplicata - já carregamos via preload
			return;
		}
	}
	wp_dequeue_script( 'wpforms' );
	wp_dequeue_script( 'wpforms-gutenberg-form-selector' );
	wp_dequeue_style( 'wpforms-full' );
	wp_dequeue_style( 'wpforms-base' );

	// Remove fontes duplicadas (carregamos via preload em rmf_add_preload_hints)
	wp_dequeue_style( 'rmf-fonts' );

	// Font Awesome do maxcdn é render-blocking; carrega via preload async
	wp_dequeue_style( 'font-awesome' );
}
add_action( 'wp_enqueue_scripts', 'rmf_dequeue_wpforms', 100 );

/**
 * Recarrega Font Awesome de forma não-bloqueante (preload + noscript).
 * Usa HTTPS para evitar mixed-content warning (Best Practices).
 */
function rmf_preload_font_awesome() {
	echo '<link rel="preload" as="style" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" onload="this.onload=null;this.rel=\'stylesheet\'">' . "\n";
	echo '<noscript><link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css"></noscript>' . "\n";
}
add_action( 'wp_head', 'rmf_preload_font_awesome', 5 );

function rmf_resource_hints( $urls, $relation_type ) {
	// Limit preconnect to 2 most critical origins (PageSpeed warns about > 4)
	if ( 'preconnect' === $relation_type ) {
		$urls[] = array( 'href' => 'https://fonts.googleapis.com' );
		$urls[] = array( 'href' => 'https://fonts.gstatic.com', 'crossorigin' => 'anonymous' );
	}
	// DNS-prefetch para terceiros (mais leve que preconnect)
	if ( 'dns-prefetch' === $relation_type ) {
		$urls[] = 'https://www.google-analytics.com';
		$urls[] = 'https://connect.facebook.net';
	}
	return $urls;
}
add_filter( 'wp_resource_hints', 'rmf_resource_hints', 10, 2 );

/**
 * Adiciona defer/async em scripts de plugins não críticos para reduzir TBT.
 * Scripts do tema e admin não são afetados.
 */
function rmf_defer_scripts( $tag, $handle, $src ) {
	// Scripts que podem carregar com defer (não são críticos para render inicial)
	$defer_scripts = array(
		'wpforms',
		'wpforms-gutenberg-form-selector',
		'cookie-law-info',
		'cookie-law-info-ccpa',
		'joinchat',
		'joinchat-lite',
		'ad-inserter',
		'disqus-embed',
		'disqusloader',
		'google-tag-manager',
		'gtag',
		'ga',
	);

	if ( in_array( $handle, $defer_scripts, true ) ) {
		// Adiciona defer somente se ainda não tiver defer ou async
		if ( false === strpos( $tag, ' defer' ) && false === strpos( $tag, ' async' ) ) {
			$tag = str_replace( ' src=', ' defer src=', $tag );
		}
	}
	return $tag;
}
add_filter( 'script_loader_tag', 'rmf_defer_scripts', 10, 3 );

/**
 * Mantém apenas o CSS essencial do Cookie Law Info (banner e botões).
 * Remove apenas folhas redundantes de GDPR/CCPA que não são usadas.
 */
function rmf_dequeue_cli_css() {
	wp_dequeue_style( 'cookie-law-info-gdpr' );
	wp_deregister_style( 'cookie-law-info-gdpr' );
}
add_action( 'wp_enqueue_scripts', 'rmf_dequeue_cli_css', 9999 );

/**
 * Força o EWWW Image Optimizer a servir WebP quando suportado.
 * Também ativa lazy load nativo nos tamanhos grandes.
 */
add_filter( 'ewww_image_optimizer_webp', '__return_true' );
add_filter( 'ewww_image_optimizer_lazy_load', '__return_true' );

/**
 * Remove assets do Elementor, UAG e Premium Addons no front-end.
 * Estes plugins estão instalados mas o Elementor não é o tema ativo.
 */
function rmf_dequeue_elementor_assets() {
	// Elementor frontend
	wp_dequeue_style( 'elementor-frontend' );
	wp_deregister_style( 'elementor-frontend' );
	wp_dequeue_style( 'elementor-post-' . get_the_ID() );
	wp_dequeue_style( 'elementor-animations' );
	wp_deregister_style( 'elementor-animations' );
	wp_dequeue_style( 'elementor-icons' );
	wp_deregister_style( 'elementor-icons' );
	wp_dequeue_script( 'elementor-frontend' );
	wp_deregister_script( 'elementor-frontend' );
	// UAG / Brainstorm Force assets
	wp_dequeue_style( 'uagb-style' );
	wp_dequeue_style( 'uagb-select2-style' );
	wp_dequeue_style( 'uae-styles' );
	wp_dequeue_script( 'uagb-script' );
	// Premium Addons for Elementor
	wp_dequeue_style( 'pa-general-style' );
	wp_dequeue_style( 'pa-modules-style' );
	wp_dequeue_script( 'pa-general-script' );
}
add_action( 'wp_enqueue_scripts', 'rmf_dequeue_elementor_assets', 9999 );

/**
 * Remove scripts de terceiros que entram fora do pipeline de enqueue normal.
 * ob_start removido — conflitava com plugins de cache.
 */
function rmf_send_cache_headers() {
	if ( is_admin() || is_user_logged_in() ) {
		return;
	}

	if ( function_exists( 'header_remove' ) ) {
		header_remove( 'Cache-Control' );
		header_remove( 'Pragma' );
		header_remove( 'Expires' );
	}

	header( 'Cache-Control: public, max-age=300, s-maxage=3600' );
	header( 'Vary: Accept-Encoding' );
}
add_action( 'send_headers', 'rmf_send_cache_headers', 9999 );

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
	echo '<li><a href="' . esc_url( home_url( '/#porque' ) ) . '">' . esc_html__( 'Diferenciais', 'rmfacilities-onepage' ) . '</a></li>';
	echo '<li><a href="' . esc_url( home_url( '/#servicos' ) ) . '">' . esc_html__( 'Servicos', 'rmfacilities-onepage' ) . '</a></li>';
	echo '<li><a href="' . esc_url( home_url( '/#contato' ) ) . '">' . esc_html__( 'Contato', 'rmfacilities-onepage' ) . '</a></li>';
	echo '<li><a href="' . esc_url( home_url( '/#faq' ) ) . '">' . esc_html__( 'FAQ', 'rmfacilities-onepage' ) . '</a></li>';
	echo '<li><a href="' . esc_url( home_url( '/#blog' ) ) . '">' . esc_html__( 'Artigos', 'rmfacilities-onepage' ) . '</a></li>';
	echo '</ul>';
}

function rmf_get_whatsapp_number() {
	$whatsapp = get_theme_mod( 'rmf_whatsapp_phone', '+55 (12) 3042-1799' );
	$digits   = preg_replace( '/\D+/', '', (string) $whatsapp );

	if ( empty( $digits ) ) {
		$fallback = get_theme_mod( 'rmf_company_phone_2', '+55 (12) 3042-1799' );
		$digits   = preg_replace( '/\D+/', '', (string) $fallback );
	}

	return (string) $digits;
}

function rmf_get_whatsapp_url() {
	$digits = rmf_get_whatsapp_number();
	return ! empty( $digits ) ? 'https://wa.me/' . $digits : '#contato';
}

function rmf_customize_register( $wp_customize ) {
	$wp_customize->add_section(
		'rmf_company_data',
		array(
			'title'       => __( 'Dados da Empresa', 'rmfacilities-onepage' ),
			'description' => __( 'RM Facilities LTDA - Ajuste rápido dos dados institucionais exibidos no tema.', 'rmfacilities-onepage' ),
			'priority'    => 30,
		)
	);

	$fields = array(
		'rmf_company_address' => 'Avenida Ilidio Meinberg Porto, 199, Sala 6, Jardim Sao Vicente, Sao Jose dos Campos - SP - CEP 12224310',
		'rmf_company_phone_1' => '+55 (12) 3042-1795',
		'rmf_company_phone_2' => '+55 (12) 3042-1799',
		'rmf_whatsapp_phone'  => '+55 (12) 3042-1799',
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
 * @param string $content Conteudo da pagina.
 * @return int ID da pagina.
 */
function rmf_get_or_create_page( $title, $slug, $content = '' ) {
	$existing_page = get_page_by_path( $slug );

	if ( $existing_page instanceof WP_Post ) {
		return (int) $existing_page->ID;
	}

	// Substituicao de get_page_by_title() removida no WP 6.7
	$pages = get_posts(
		array(
			'post_type'              => 'page',
			'title'                  => $title,
			'posts_per_page'         => 1,
			'no_found_rows'          => true,
			'ignore_sticky_posts'    => true,
			'update_post_term_cache' => false,
			'update_post_meta_cache' => false,
		)
	);

	if ( ! empty( $pages ) && $pages[0] instanceof WP_Post ) {
		return (int) $pages[0]->ID;
	}

	$page_id = wp_insert_post(
		array(
			'post_title'   => $title,
			'post_name'    => $slug,
			'post_status'  => 'publish',
			'post_type'    => 'page',
			'post_content' => $content,
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
	$thanks_id    = rmf_get_or_create_page( 'Obrigado', 'obrigado', 'Obrigado pelo contato. Nossa equipe retornara em breve com uma proposta personalizada.' );
	$privacy_id   = rmf_get_or_create_page( 'Politica de Privacidade', 'politica-de-privacidade', 'Esta pagina deve descrever como dados sao tratados pela RM Facilities LTDA, em conformidade com a LGPD.' );

	$service_pages = array(
		array(
			'title'   => 'Portaria em Sao Jose dos Campos',
			'slug'    => 'portaria-sao-jose-dos-campos',
			'content' => 'Servico de portaria com controle de acesso, postura profissional e apoio operacional para empresas em Sao Jose dos Campos.',
		),
		array(
			'title'   => 'Limpeza em Sao Jose dos Campos',
			'slug'    => 'limpeza-sao-jose-dos-campos',
			'content' => 'Rotinas de limpeza profissional para ambientes corporativos, com padrao de qualidade, seguranca e produtividade.',
		),
		array(
			'title'   => 'Jardinagem em Sao Jose dos Campos',
			'slug'    => 'jardinagem-sao-jose-dos-campos',
			'content' => 'Manutencao de areas verdes e paisagismo funcional para valorizar empreendimentos empresariais.',
		),
		array(
			'title'   => 'Recepcao em Sao Jose dos Campos',
			'slug'    => 'recepcao-sao-jose-dos-campos',
			'content' => 'Recepcao corporativa com atendimento cordial e processos padronizados para reforcar a imagem da sua empresa.',
		),
	);

	foreach ( $service_pages as $service_page ) {
		rmf_get_or_create_page( $service_page['title'], $service_page['slug'], $service_page['content'] );
	}

	if ( $home_page_id > 0 ) {
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $home_page_id );
	}

	if ( $blog_page_id > 0 ) {
		update_option( 'page_for_posts', $blog_page_id );
	}

	if ( $thanks_id > 0 ) {
		update_option( 'rmf_thanks_page_id', $thanks_id );
	}

	if ( $privacy_id > 0 ) {
		update_option( 'wp_page_for_privacy_policy', $privacy_id );
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
					'title' => 'Diferenciais',
					'url'   => home_url( '/#porque' ),
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
					'title' => 'FAQ',
					'url'   => home_url( '/#faq' ),
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

function rmf_handle_contact_form_submission() {
	if ( ! isset( $_POST['rmf_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['rmf_nonce'] ) ), 'rmf_contact_nonce' ) ) {
		wp_safe_redirect( home_url( '/#contato?status=erro' ) );
		exit;
	}

	$fields = array(
		'nome'     => isset( $_POST['rmf_nome'] ) ? sanitize_text_field( wp_unslash( $_POST['rmf_nome'] ) ) : '',
		'empresa'  => isset( $_POST['rmf_empresa'] ) ? sanitize_text_field( wp_unslash( $_POST['rmf_empresa'] ) ) : '',
		'email'    => isset( $_POST['rmf_email'] ) ? sanitize_email( wp_unslash( $_POST['rmf_email'] ) ) : '',
		'telefone' => isset( $_POST['rmf_telefone'] ) ? sanitize_text_field( wp_unslash( $_POST['rmf_telefone'] ) ) : '',
		'servico'  => isset( $_POST['rmf_servico'] ) ? sanitize_text_field( wp_unslash( $_POST['rmf_servico'] ) ) : '',
		'metragem' => isset( $_POST['rmf_metragem'] ) ? sanitize_text_field( wp_unslash( $_POST['rmf_metragem'] ) ) : '',
		'cidade'   => isset( $_POST['rmf_cidade'] ) ? sanitize_text_field( wp_unslash( $_POST['rmf_cidade'] ) ) : '',
		'urgencia' => isset( $_POST['rmf_urgencia'] ) ? sanitize_text_field( wp_unslash( $_POST['rmf_urgencia'] ) ) : '',
		'mensagem' => isset( $_POST['rmf_mensagem'] ) ? sanitize_textarea_field( wp_unslash( $_POST['rmf_mensagem'] ) ) : '',
	);

	if ( empty( $fields['nome'] ) || empty( $fields['email'] ) || empty( $fields['servico'] ) ) {
		wp_safe_redirect( home_url( '/#contato?status=erro' ) );
		exit;
	}

	$to      = get_theme_mod( 'rmf_company_email', get_option( 'admin_email' ) );
	$subject = 'Novo lead do site RM Facilities LTDA';
	$message = "Nome: {$fields['nome']}\n";
	$message .= "Empresa: {$fields['empresa']}\n";
	$message .= "E-mail: {$fields['email']}\n";
	$message .= "Telefone: {$fields['telefone']}\n";
	$message .= "Servico: {$fields['servico']}\n";
	$message .= "Metragem: {$fields['metragem']}\n";
	$message .= "Cidade: {$fields['cidade']}\n";
	$message .= "Urgencia: {$fields['urgencia']}\n";
	$message .= "Mensagem: {$fields['mensagem']}\n";

	$headers = array( 'Reply-To: ' . $fields['nome'] . ' <' . $fields['email'] . '>' );

	$sent = wp_mail( $to, $subject, $message, $headers );

	// Envia cópia de confirmação para o lead
	if ( $sent && ! empty( $fields['email'] ) ) {
		$confirm_subject = 'Recebemos seu contato — RM Facilities';
		$confirm_message = "Olá, {$fields['nome']}!\n\nRecebemos sua solicitação e entraremos em contato em até 1 dia útil.\n\nServiço de interesse: {$fields['servico']}\n\nAtenciosamente,\nEquipe RM Facilities\ncontato@rmfacilities.com.br | (12) 3042-1799";
		wp_mail( $fields['email'], $confirm_subject, $confirm_message );
	}

	$thanks_url = home_url( '/obrigado/' );

	wp_safe_redirect( $thanks_url );
	exit;
}
add_action( 'admin_post_nopriv_rmf_submit_contact', 'rmf_handle_contact_form_submission' );
add_action( 'admin_post_rmf_submit_contact', 'rmf_handle_contact_form_submission' );

function rmf_output_structured_data() {
	if ( ! is_front_page() ) {
		return;
	}

	$faq = array(
		array(
			'question' => 'Como funciona a implantacao de um novo posto?',
			'answer'   => 'Realizamos diagnostico inicial, definicao de escopo, alocacao da equipe e acompanhamento supervisionado nos primeiros dias.',
		),
		array(
			'question' => 'A RM Facilities LTDA atende quais cidades?',
			'answer'   => 'Atendemos Sao Jose dos Campos, Vale do Paraiba, Regiao Bragantina e Sul de Minas, com possibilidade de expansao conforme o perfil da operacao.',
		),
		array(
			'question' => 'Quais servicos podem ser contratados?',
			'answer'   => 'Portaria, limpeza, jardinagem e recepcao com planos personalizados para empresas e condominios.',
		),
	);

	$faq_entities = array();
	foreach ( $faq as $item ) {
		$faq_entities[] = array(
			'@type'          => 'Question',
			'name'           => $item['question'],
			'acceptedAnswer' => array(
				'@type' => 'Answer',
				'text'  => $item['answer'],
			),
		);
	}

	$business_schema = array(
		'@context'   => 'https://schema.org',
		'@type'      => 'LocalBusiness',
		'name'       => 'RM FACILITIES LTDA',
		'url'        => home_url( '/' ),
		'telephone'  => get_theme_mod( 'rmf_company_phone_2', '+55 (12) 3042-1799' ),
		'email'      => get_theme_mod( 'rmf_company_email', '' ),
		'identifier' => get_theme_mod( 'rmf_company_cnpj', '' ),
		'address'    => array(
			'@type'           => 'PostalAddress',
			'streetAddress'   => get_theme_mod( 'rmf_company_address', '' ),
			'addressLocality' => 'Sao Jose dos Campos',
			'addressRegion'   => 'SP',
			'addressCountry'  => 'BR',
		),
		'areaServed' => array(
			'Sao Jose dos Campos',
			'Vale do Paraiba',
			'Regiao Bragantina',
			'Sul de Minas',
		),
		'sameAs'      => array_filter(
			array(
				get_theme_mod( 'rmf_instagram_url', '' ),
				get_theme_mod( 'rmf_facebook_url', '' ),
			)
		),
	);

	$faq_schema = array(
		'@context'   => 'https://schema.org',
		'@type'      => 'FAQPage',
		'mainEntity' => $faq_entities,
	);

	echo '<script type="application/ld+json">' . wp_json_encode( $business_schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>';
	echo '<script type="application/ld+json">' . wp_json_encode( $faq_schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>';
}
add_action( 'wp_head', 'rmf_output_structured_data', 20 );

/**
 * SEO: title tag, meta description, canonical, Open Graph e Twitter Card.
 */
function rmf_output_seo_meta() {
	$site_name    = 'RM Facilities LTDA';
	$city         = 'Sao Jose dos Campos';
	$services     = 'Portaria, Limpeza, Jardinagem e Recepcao';
	$canonical    = esc_url( home_url( '/' ) );
	$og_image     = esc_url( get_theme_mod( 'rmf_og_image', 'https://rmfacilities.com.br/wp-content/uploads/2023/08/logo-rm-facilities-1.png' ) );

	if ( is_front_page() || is_home() ) {
		$title       = $site_name . ' | ' . $services . ' em ' . $city . ' - SP';
		$description = 'A ' . $site_name . ' oferece servicos terceirizados de ' . strtolower( $services ) . ' em ' . $city . ' e regiao. Equipe treinada, supervisao presencial e conformidade trabalhista. Solicite seu orcamento!';
	} elseif ( is_singular() ) {
		$title       = get_the_title() . ' | ' . $site_name;
		$description = has_excerpt() ? wp_strip_all_tags( get_the_excerpt() ) : wp_trim_words( wp_strip_all_tags( get_the_content() ), 30, '...' );
		$canonical   = esc_url( get_permalink() );
		if ( has_post_thumbnail() ) {
			$og_image = esc_url( get_the_post_thumbnail_url( null, 'large' ) );
		}
	} elseif ( is_archive() || is_category() || is_tag() ) {
		$title       = single_term_title( '', false ) . ' | Blog ' . $site_name;
		$description = 'Artigos e novidades sobre facilities, limpeza, portaria e terceirizacao de servicos. Blog ' . $site_name . '.';
		$canonical   = esc_url( get_term_link( get_queried_object() ) );
	} else {
		$title       = get_bloginfo( 'name' ) . ' | ' . get_bloginfo( 'description' );
		$description = get_bloginfo( 'description' );
	}

	$title       = esc_attr( wp_strip_all_tags( $title ) );
	$description = esc_attr( wp_strip_all_tags( wp_trim_words( $description, 30, '...' ) ) );

	?>
	<!-- SEO Meta -->
	<meta name="description" content="<?php echo $description; ?>">
	<meta name="robots" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1">
	<link rel="canonical" href="<?php echo $canonical; ?>">

	<!-- Open Graph -->
	<meta property="og:type" content="website">
	<meta property="og:site_name" content="<?php echo esc_attr( $site_name ); ?>">
	<meta property="og:title" content="<?php echo $title; ?>">
	<meta property="og:description" content="<?php echo $description; ?>">
	<meta property="og:url" content="<?php echo $canonical; ?>">
	<meta property="og:image" content="<?php echo $og_image; ?>">
	<meta property="og:image:width" content="1200">
	<meta property="og:image:height" content="630">
	<meta property="og:locale" content="pt_BR">

	<!-- Twitter Card -->
	<meta name="twitter:card" content="summary_large_image">
	<meta name="twitter:title" content="<?php echo $title; ?>">
	<meta name="twitter:description" content="<?php echo $description; ?>">
	<meta name="twitter:image" content="<?php echo $og_image; ?>">
	<?php
}
add_action( 'wp_head', 'rmf_output_seo_meta', 5 );

/**
 * Filtrar o title tag gerado pelo WordPress.
 */
function rmf_filter_document_title( $title_parts ) {
	if ( is_front_page() ) {
		$title_parts['title']   = 'RM Facilities LTDA | Portaria, Limpeza, Jardinagem e Recepcao';
		$title_parts['tagline'] = 'Sao Jose dos Campos - SP';
		unset( $title_parts['site'] );
	}
	return $title_parts;
}
add_filter( 'document_title_parts', 'rmf_filter_document_title', 10, 1 );
