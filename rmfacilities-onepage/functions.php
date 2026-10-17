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
 * Preconnect e preload correto para fontes do Google.
 */
function rmf_add_preload_hints() {
	// Preload do CSS de fontes - informa ao browser para buscar cedo
	echo '<link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;600;700;800&family=Sora:wght@700;800&display=swap" onload="this.onload=null;this.rel=\'stylesheet\'" crossorigin>' . "\n";
	// Noscript fallback
	echo '<noscript><link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;600;700;800&family=Sora:wght@700;800&display=swap"></noscript>' . "\n";
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
	if ( is_admin_bar_showing() ) return;
	wp_dequeue_style( 'wp-mail-smtp-admin-bar' );
	wp_dequeue_style( 'rank-math-pro-analytics' );
	wp_dequeue_style( 'rank-math-analytics' );
}
add_action( 'wp_enqueue_scripts', 'rmf_dequeue_admin_styles', 200 );

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

function rmf_primary_menu_fallback( $args = array() ) {
	$menu_id    = is_object( $args ) && ! empty( $args->menu_id ) ? $args->menu_id : 'primary-menu';
	$menu_class = is_object( $args ) && ! empty( $args->menu_class ) ? $args->menu_class : 'menu';

	echo '<ul id="' . esc_attr( $menu_id ) . '" class="' . esc_attr( $menu_class ) . '">';
	echo '<li><a href="' . esc_url( home_url( '/#inicio' ) ) . '">' . esc_html__( 'Inicio', 'rmfacilities-onepage' ) . '</a></li>';
	echo '<li><a href="' . esc_url( home_url( '/#sobre' ) ) . '">' . esc_html__( 'Sobre', 'rmfacilities-onepage' ) . '</a></li>';
	echo '<li><a href="' . esc_url( home_url( '/#porque' ) ) . '">' . esc_html__( 'Diferenciais', 'rmfacilities-onepage' ) . '</a></li>';
	echo '<li><a href="' . esc_url( home_url( '/#servicos' ) ) . '">' . esc_html__( 'Servicos', 'rmfacilities-onepage' ) . '</a></li>';
	echo '<li><a href="' . esc_url( home_url( '/#contato' ) ) . '">' . esc_html__( 'Contato', 'rmfacilities-onepage' ) . '</a></li>';
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
		'rmf_instagram_url'   => '',
		'rmf_facebook_url'    => '',
	);

	foreach ( $fields as $setting_id => $default_value ) {
		$wp_customize->add_setting(
			$setting_id,
			array(
				'default'           => $default_value,
				'sanitize_callback' => in_array( $setting_id, array( 'rmf_instagram_url', 'rmf_facebook_url' ), true ) ? 'esc_url_raw' : 'sanitize_text_field',
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
 * Conteúdo inicial das páginas de serviço criadas pelo tema.
 *
 * @return array<string, array<string, string>>
 */
function rmf_service_pages() {
	return array(
		'portaria-sao-jose-dos-campos' => array(
			'title'   => 'Portaria em São José dos Campos',
			'content' => '<p>Serviço de portaria e controle de acesso para empresas e condomínios em São José dos Campos. A operação é definida conforme os acessos, horários e rotinas de cada local.</p><h2>Como podemos ajudar</h2><ul><li>Controle de entrada e saída de pessoas e prestadores.</li><li>Atendimento a moradores, visitantes e equipes.</li><li>Rotinas alinhadas às orientações do contratante.</li></ul><h2>Solicite uma proposta</h2><p>Conte sobre o local, os horários e a necessidade de cobertura para receber uma proposta adequada.</p><p><a href="' . esc_url( home_url( '/#contato' ) ) . '">Solicitar orçamento de portaria</a></p>',
			'legacy_title' => 'Portaria em Sao Jose dos Campos',
			'legacy'  => 'Servico de portaria com controle de acesso, postura profissional e apoio operacional para empresas em Sao Jose dos Campos.',
		),
		'limpeza-sao-jose-dos-campos' => array(
			'title'   => 'Limpeza profissional em São José dos Campos',
			'content' => '<p>Serviços de limpeza e conservação para ambientes corporativos em São José dos Campos. O escopo é planejado de acordo com as áreas, os horários e as necessidades de cada operação.</p><h2>Escopo sob medida</h2><ul><li>Definição das rotinas e frequências de limpeza.</li><li>Organização das atividades conforme o fluxo do ambiente.</li><li>Acompanhamento do serviço de acordo com o escopo contratado.</li></ul><h2>Solicite uma proposta</h2><p>Informe o tipo de ambiente, a metragem aproximada e a frequência desejada.</p><p><a href="' . esc_url( home_url( '/#contato' ) ) . '">Solicitar orçamento de limpeza</a></p>',
			'legacy_title' => 'Limpeza em Sao Jose dos Campos',
			'legacy'  => 'Rotinas de limpeza profissional para ambientes corporativos, com padrao de qualidade, seguranca e produtividade.',
		),
		'jardinagem-sao-jose-dos-campos' => array(
			'title'   => 'Jardinagem em São José dos Campos',
			'content' => '<p>Serviços de jardinagem e manutenção de áreas verdes em São José dos Campos para empresas e condomínios. As atividades são definidas conforme as características e a necessidade do espaço.</p><h2>Cuidados com áreas verdes</h2><ul><li>Planejamento das rotinas de manutenção.</li><li>Cuidado de áreas verdes internas e externas.</li><li>Organização do serviço conforme o espaço e o escopo contratado.</li></ul><h2>Solicite uma proposta</h2><p>Descreva a área, as atividades necessárias e a frequência desejada.</p><p><a href="' . esc_url( home_url( '/#contato' ) ) . '">Solicitar orçamento de jardinagem</a></p>',
			'legacy_title' => 'Jardinagem em Sao Jose dos Campos',
			'legacy'  => 'Manutencao de areas verdes e paisagismo funcional para valorizar empreendimentos empresariais.',
		),
		'recepcao-sao-jose-dos-campos' => array(
			'title'   => 'Recepção corporativa em São José dos Campos',
			'content' => '<p>Serviço de recepção para empresas em São José dos Campos, com atendimento a visitantes e apoio às rotinas de entrada. Os procedimentos são alinhados com cada contratante.</p><h2>Atendimento alinhado à sua empresa</h2><ul><li>Recepção e orientação de visitantes.</li><li>Rotinas organizadas conforme os processos do local.</li><li>Atendimento compatível com o perfil do ambiente.</li></ul><h2>Solicite uma proposta</h2><p>Conte sobre o espaço, o horário de atendimento e as rotinas da recepção.</p><p><a href="' . esc_url( home_url( '/#contato' ) ) . '">Solicitar orçamento de recepção</a></p>',
			'legacy_title' => 'Recepcao em Sao Jose dos Campos',
			'legacy'  => 'Recepcao corporativa com atendimento cordial e processos padronizados para reforcar a imagem da sua empresa.',
		),
	);
}

/**
 * Atualiza apenas páginas de serviço que ainda preservam o conteúdo inicial do tema.
 */
function rmf_migrate_service_pages() {
	if ( get_option( 'rmf_service_pages_content_version' ) ) {
		return;
	}

	foreach ( rmf_service_pages() as $slug => $service_page ) {
		$page = get_page_by_path( $slug );
		if ( ! $page instanceof WP_Post || trim( $page->post_content ) !== $service_page['legacy'] || $page->post_title !== $service_page['legacy_title'] ) {
			continue;
		}

		$updated = wp_update_post(
			array(
				'ID'           => $page->ID,
				'post_title'   => $service_page['title'],
				'post_content' => $service_page['content'],
			),
			true
		);

		if ( is_wp_error( $updated ) ) {
			error_log( 'RM Facilities: não foi possível atualizar a página de serviço "' . $slug . '": ' . $updated->get_error_message() );
			return;
		}
	}

	update_option( 'rmf_service_pages_content_version', 1 );
}
add_action( 'admin_init', 'rmf_migrate_service_pages' );

/**
 * Configuracao inicial do tema ao ativar.
 */
function rmf_after_switch_theme_setup() {
	$home_page_id = rmf_get_or_create_page( 'Inicio', 'inicio' );
	$blog_page_id = rmf_get_or_create_page( 'Blog', 'blog' );
	$thanks_id    = rmf_get_or_create_page( 'Obrigado', 'obrigado', 'Obrigado pelo contato. Nossa equipe retornara em breve com uma proposta personalizada.' );
	$privacy_id   = rmf_get_or_create_page( 'Politica de Privacidade', 'politica-de-privacidade', 'Esta pagina deve descrever como dados sao tratados pela RM Facilities LTDA, em conformidade com a LGPD.' );

	foreach ( rmf_service_pages() as $slug => $service_page ) {
		rmf_get_or_create_page( $service_page['title'], $slug, $service_page['content'] );
	}
	rmf_migrate_service_pages();

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

function rmf_redirect_contact_form( $status = 'erro' ) {
	$redirect_url = add_query_arg( 'status', sanitize_key( $status ), home_url( '/' ) );
	wp_safe_redirect( $redirect_url . '#contato' );
	exit;
}

function rmf_contact_rate_limit_reached() {
	if ( empty( $_SERVER['REMOTE_ADDR'] ) ) {
		return false;
	}

	$remote_addr = sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) );
	$client_addr = $remote_addr;

	if ( ! empty( $_SERVER['HTTP_CF_CONNECTING_IP'] ) && ! empty( $_SERVER['HTTP_CF_RAY'] ) ) {
		$cloudflare_client = sanitize_text_field( wp_unslash( $_SERVER['HTTP_CF_CONNECTING_IP'] ) );
		if ( false !== filter_var( $cloudflare_client, FILTER_VALIDATE_IP ) ) {
			$client_addr = $cloudflare_client;
		}
	}

	if ( false === filter_var( $client_addr, FILTER_VALIDATE_IP ) ) {
		return false;
	}

	$transient   = 'rmf_contact_rate_' . hash_hmac( 'sha256', $client_addr, wp_salt( 'auth' ) );
	$submissions = (int) get_transient( $transient );

	if ( $submissions >= 5 ) {
		return true;
	}

	set_transient( $transient, $submissions + 1, HOUR_IN_SECONDS );
	return false;
}

function rmf_handle_contact_form_submission() {
	if ( ! isset( $_POST['rmf_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['rmf_nonce'] ) ), 'rmf_contact_nonce' ) ) {
		rmf_redirect_contact_form();
	}

	$honeypot = isset( $_POST['rmf_website'] ) ? sanitize_text_field( wp_unslash( $_POST['rmf_website'] ) ) : '';
	$started  = isset( $_POST['rmf_form_started'] ) ? absint( $_POST['rmf_form_started'] ) : 0;
	if ( '' !== $honeypot || ( $started > 0 && time() - $started < 3 ) ) {
		rmf_redirect_contact_form();
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

	if ( empty( $fields['nome'] ) || ! is_email( $fields['email'] ) || empty( $fields['servico'] ) ) {
		rmf_redirect_contact_form();
	}

	if ( rmf_contact_rate_limit_reached() ) {
		rmf_redirect_contact_form( 'limite' );
	}

	// Destinatário fixo — garante entrega mesmo se theme_mod estiver vazio
	$to      = 'contato@rmfacilities.com.br';
	$subject = '[Site] Novo contato: ' . $fields['nome'] . ' — ' . $fields['servico'];

	$headers = array(
		'Content-Type: text/html; charset=UTF-8',
		'Reply-To: ' . $fields['nome'] . ' <' . $fields['email'] . '>',
	);

	$message  = '<html><body style="font-family:Arial,sans-serif;font-size:15px;color:#222">';
	$message .= '<h2 style="color:#1a4b7a">📋 Novo lead — RM Facilities</h2>';
	$message .= '<table cellpadding="6" cellspacing="0" style="border-collapse:collapse;width:100%;max-width:520px">';
	foreach ( array(
		'Nome'     => $fields['nome'],
		'Empresa'  => $fields['empresa'],
		'E-mail'   => $fields['email'],
		'Telefone' => $fields['telefone'],
		'Serviço'  => $fields['servico'],
		'Metragem' => $fields['metragem'],
		'Cidade'   => $fields['cidade'],
		'Urgência' => $fields['urgencia'],
		'Mensagem' => nl2br( esc_html( $fields['mensagem'] ) ),
	) as $label => $value ) {
		if ( empty( $value ) ) continue;
		$message .= '<tr><td style="background:#f0f4f8;font-weight:bold;padding:6px 10px;border:1px solid #ddd;width:110px">' . esc_html( $label ) . '</td>';
		$message .= '<td style="padding:6px 10px;border:1px solid #ddd">' . $value . '</td></tr>';
	}
	$message .= '</table></body></html>';

	$sent = wp_mail( $to, $subject, $message, $headers );

	// Confirmação para o lead
	if ( ! empty( $fields['email'] ) ) {
		$confirm_headers  = array( 'Content-Type: text/html; charset=UTF-8' );
		$confirm_subject  = 'Recebemos seu contato — RM Facilities';
		$whatsapp_url     = function_exists( 'rmf_get_whatsapp_url' ) ? rmf_get_whatsapp_url() : home_url( '/#contato' );
		$whatsapp_phone   = get_theme_mod( 'rmf_whatsapp_phone', '+55 (12) 3042-1799' );
		$confirm_message  = '<html><body style="font-family:Arial,sans-serif;font-size:15px;color:#222">';
		$confirm_message .= '<h2 style="color:#1a4b7a">Olá, ' . esc_html( $fields['nome'] ) . '!</h2>';
		$confirm_message .= '<p>Recebemos sua solicitação sobre <strong>' . esc_html( $fields['servico'] ) . '</strong>. Nossa equipe analisará as informações e entrará em contato.</p>';
		$confirm_message .= '<p>Se preferir, fale conosco pelo WhatsApp: <a href="' . esc_url( $whatsapp_url ) . '">' . esc_html( $whatsapp_phone ) . '</a></p>';
		$confirm_message .= '<p style="color:#666;font-size:13px">Atenciosamente,<br><strong>Equipe RM Facilities</strong><br>' . esc_html( get_theme_mod( 'rmf_company_email', 'contato@rmfacilities.com.br' ) ) . ' | ' . esc_html( get_theme_mod( 'rmf_company_phone_1', '+55 (12) 3042-1795' ) ) . '</p>';
		$confirm_message .= '</body></html>';
		wp_mail( $fields['email'], $confirm_subject, $confirm_message, $confirm_headers );
	}

	$thanks_url = home_url( '/obrigado/' );

	wp_safe_redirect( $thanks_url );
	exit;
}
add_action( 'admin_post_nopriv_rmf_submit_contact', 'rmf_handle_contact_form_submission' );
add_action( 'admin_post_rmf_submit_contact', 'rmf_handle_contact_form_submission' );

function rmf_output_structured_data() {
	if ( ! is_front_page() || rmf_has_seo_plugin() ) {
		return;
	}

	$social_profiles = array_filter(
		array(
			get_theme_mod( 'rmf_instagram_url', '' ),
			get_theme_mod( 'rmf_facebook_url', '' ),
		)
	);
	$social_profiles = array_values(
		array_filter(
			$social_profiles,
			function ( $url ) {
				$path = wp_parse_url( $url, PHP_URL_PATH );
				return is_string( $path ) && '' !== trim( $path, '/' );
			}
		)
	);

	$business_schema = array(
		'@context'   => 'https://schema.org',
		'@type'      => 'LocalBusiness',
		'name'       => 'RM Facilities LTDA',
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
		'sameAs'      => $social_profiles,
	);

	echo '<script type="application/ld+json">' . wp_json_encode( $business_schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>';
}
add_action( 'wp_head', 'rmf_output_structured_data', 20 );

/**
 * Detecta se um plugin de SEO já gera metadados e dados estruturados.
 *
 * @return bool
 */
function rmf_has_seo_plugin() {
	return defined( 'RANK_MATH_VERSION' ) || function_exists( 'rank_math_the_breadcrumbs' ) || defined( 'WPSEO_VERSION' ) || class_exists( 'WPSEO_Options' );
}

/**
 * SEO: title tag, meta description, canonical, Open Graph e Twitter Card.
 */
function rmf_output_seo_meta() {
	if ( rmf_has_seo_plugin() ) {
		return;
	}

	$site_name    = 'RM Facilities LTDA';
	$canonical    = esc_url( home_url( '/' ) );
	$og_image     = esc_url( get_theme_mod( 'rmf_og_image', 'https://rmfacilities.com.br/wp-content/uploads/2023/08/logo-rm-facilities-1.png' ) );

	if ( is_front_page() ) {
		$title       = 'RM Facilities | Terceirização de serviços em São José dos Campos';
		$description = 'Serviços de portaria, limpeza, jardinagem e recepção para empresas e condomínios em São José dos Campos. Solicite um orçamento.';
	} elseif ( is_home() ) {
		$title       = 'Artigos e novidades | ' . $site_name;
		$description = 'Artigos e informações sobre portaria, limpeza, jardinagem, recepção e terceirização de serviços.';
		$posts_page  = (int) get_option( 'page_for_posts' );
		if ( $posts_page ) {
			$canonical = esc_url( get_permalink( $posts_page ) );
		}
	} elseif ( is_singular() ) {
		$title       = get_the_title() . ' | ' . $site_name;
		$description = has_excerpt() ? wp_strip_all_tags( get_the_excerpt() ) : wp_trim_words( wp_strip_all_tags( get_the_content() ), 30, '...' );
		$canonical   = esc_url( get_permalink() );
		if ( has_post_thumbnail() ) {
			$og_image = esc_url( get_the_post_thumbnail_url( null, 'large' ) );
		}
	} elseif ( is_category() || is_tag() || is_tax() ) {
		$title       = single_term_title( '', false ) . ' | Blog ' . $site_name;
		$description = 'Artigos e novidades sobre facilities, limpeza, portaria e terceirizacao de servicos. Blog ' . $site_name . '.';
		$term_link   = get_term_link( get_queried_object() );
		if ( ! is_wp_error( $term_link ) ) {
			$canonical = esc_url( $term_link );
		}
	} elseif ( is_archive() ) {
		$title       = post_type_archive_title( '', false ) . ' | Blog ' . $site_name;
		$description = 'Artigos e novidades sobre facilities e terceirização de serviços. Blog ' . $site_name . '.';
	} else {
		$title       = get_bloginfo( 'name' ) . ' | ' . get_bloginfo( 'description' );
		$description = get_bloginfo( 'description' );
	}

	$title       = esc_attr( wp_strip_all_tags( $title ) );
	$description = esc_attr( wp_strip_all_tags( wp_trim_words( $description, 30, '...' ) ) );

	?>
	<!-- SEO Meta -->
	<meta name="description" content="<?php echo $description; ?>">
	<link rel="canonical" href="<?php echo $canonical; ?>">

	<!-- Open Graph -->
	<meta property="og:type" content="<?php echo esc_attr( is_singular( 'post' ) ? 'article' : 'website' ); ?>">
	<meta property="og:site_name" content="<?php echo esc_attr( $site_name ); ?>">
	<meta property="og:title" content="<?php echo $title; ?>">
	<meta property="og:description" content="<?php echo $description; ?>">
	<meta property="og:url" content="<?php echo $canonical; ?>">
	<meta property="og:image" content="<?php echo $og_image; ?>">
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
		$title_parts['title'] = 'RM Facilities | Terceirização de serviços em São José dos Campos';
		unset( $title_parts['site'] );
		unset( $title_parts['tagline'] );
	}
	return $title_parts;
}
add_filter( 'document_title_parts', 'rmf_filter_document_title', 10, 1 );
