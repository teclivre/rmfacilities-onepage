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
	$font_url = 'https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Sora:wght@600;700;800&display=swap';

	wp_enqueue_style( 'rmf-fonts', $font_url, array(), null );
	wp_enqueue_style( 'rmf-style', get_stylesheet_uri(), array(), $version );
	wp_enqueue_style( 'rmf-main', get_template_directory_uri() . '/assets/css/main.css', array( 'rmf-fonts', 'rmf-style' ), $version );
	wp_enqueue_script( 'rmf-theme', get_template_directory_uri() . '/assets/js/theme.js', array(), $version, true );
}
add_action( 'wp_enqueue_scripts', 'rmf_enqueue_assets' );

function rmf_resource_hints( $urls, $relation_type ) {
	if ( 'preconnect' === $relation_type ) {
		$urls[] = 'https://fonts.googleapis.com';
		$urls[] = array(
			'href'        => 'https://fonts.gstatic.com',
			'crossorigin' => 'anonymous',
		);
	}

	return $urls;
}
add_filter( 'wp_resource_hints', 'rmf_resource_hints', 10, 2 );

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
	if ( ! isset( $_POST['rmf_contact_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['rmf_contact_nonce'] ) ), 'rmf_contact_submit' ) ) {
		wp_safe_redirect( home_url( '/#contato' ) );
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
		wp_safe_redirect( home_url( '/#contato' ) );
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

	wp_mail( $to, $subject, $message, $headers );

	$thanks_page_id = (int) get_option( 'rmf_thanks_page_id' );
	$thanks_url     = $thanks_page_id > 0 ? get_permalink( $thanks_page_id ) : home_url( '/obrigado/' );

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
