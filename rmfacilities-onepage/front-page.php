<?php
/**
 * Pagina inicial one-page.
 *
 * @package RMFacilitiesOnePage
 */

get_header();
?>

<section class="hero section" id="inicio">
	<div class="container">
		<p class="kicker"><?php esc_html_e( 'Facilities e terceirizacao de servicos', 'rmfacilities-onepage' ); ?></p>
		<h1><?php esc_html_e( 'Solucoes completas para operacao e manutencao da sua empresa', 'rmfacilities-onepage' ); ?></h1>
		<p><?php esc_html_e( 'Todos os nossos servicos sao prestados por profissionais capacitados, com rigoroso processo de selecao e treinamento.', 'rmfacilities-onepage' ); ?></p>
		<div class="hero-actions">
			<a class="btn btn-primary" href="#contato"><?php esc_html_e( 'Solicitar orcamento', 'rmfacilities-onepage' ); ?></a>
			<a class="btn btn-outline" href="#servicos"><?php esc_html_e( 'Conhecer servicos', 'rmfacilities-onepage' ); ?></a>
		</div>
	</div>
</section>

<section class="section" id="sobre">
	<div class="container two-col">
		<div>
			<p class="kicker"><?php esc_html_e( 'Quem somos', 'rmfacilities-onepage' ); ?></p>
			<h2><?php esc_html_e( 'RM Facilities', 'rmfacilities-onepage' ); ?></h2>
			<p><?php esc_html_e( 'Atuamos com foco em qualidade, seguranca e produtividade, ajudando empresas a manter ambientes funcionais e organizados.', 'rmfacilities-onepage' ); ?></p>
		</div>
		<div class="highlight-box">
			<h3><?php esc_html_e( 'Diferenciais', 'rmfacilities-onepage' ); ?></h3>
			<ul>
				<li><?php esc_html_e( 'Equipe selecionada e treinada', 'rmfacilities-onepage' ); ?></li>
				<li><?php esc_html_e( 'Padrao operacional consistente', 'rmfacilities-onepage' ); ?></li>
				<li><?php esc_html_e( 'Atendimento personalizado', 'rmfacilities-onepage' ); ?></li>
			</ul>
		</div>
	</div>
</section>

<section class="section section-alt" id="servicos">
	<div class="container">
		<p class="kicker"><?php esc_html_e( 'Nossos servicos', 'rmfacilities-onepage' ); ?></p>
		<h2><?php esc_html_e( 'Solucoes sob medida para seu negocio', 'rmfacilities-onepage' ); ?></h2>
		<div class="cards">
			<article class="card">
				<h3><?php esc_html_e( 'Servicos de limpeza', 'rmfacilities-onepage' ); ?></h3>
				<p><?php esc_html_e( 'Rotinas de limpeza profissional com controle de qualidade e equipes preparadas para diferentes tipos de ambiente.', 'rmfacilities-onepage' ); ?></p>
			</article>
			<article class="card">
				<h3><?php esc_html_e( 'Gestao de escritorios e instalacoes', 'rmfacilities-onepage' ); ?></h3>
				<p><?php esc_html_e( 'Gestao operacional de espacos corporativos para melhorar fluxo, organizacao e eficiencia no dia a dia.', 'rmfacilities-onepage' ); ?></p>
			</article>
			<article class="card">
				<h3><?php esc_html_e( 'Apoio operacional', 'rmfacilities-onepage' ); ?></h3>
				<p><?php esc_html_e( 'Terceirizacao de atividades de suporte para que sua equipe foque no que realmente importa: o core do negocio.', 'rmfacilities-onepage' ); ?></p>
			</article>
		</div>
	</div>
</section>

<section class="section" id="contato">
	<div class="container two-col">
		<div>
			<p class="kicker"><?php esc_html_e( 'Fale conosco', 'rmfacilities-onepage' ); ?></p>
			<h2><?php esc_html_e( 'Fique a vontade para entrar em contato', 'rmfacilities-onepage' ); ?></h2>
			<p><?php esc_html_e( 'Utilize nossos canais para solicitar um orcamento.', 'rmfacilities-onepage' ); ?></p>
			<p><strong><?php esc_html_e( 'Telefone 1:', 'rmfacilities-onepage' ); ?></strong> <?php echo esc_html( get_theme_mod( 'rmf_company_phone_1' ) ); ?></p>
			<p><strong><?php esc_html_e( 'Telefone 2:', 'rmfacilities-onepage' ); ?></strong> <?php echo esc_html( get_theme_mod( 'rmf_company_phone_2' ) ); ?></p>
			<p><strong><?php esc_html_e( 'E-mail:', 'rmfacilities-onepage' ); ?></strong> <a href="mailto:<?php echo esc_attr( get_theme_mod( 'rmf_company_email' ) ); ?>"><?php echo esc_html( get_theme_mod( 'rmf_company_email' ) ); ?></a></p>
		</div>
		<div class="highlight-box">
			<h3><?php esc_html_e( 'Trabalhe conosco', 'rmfacilities-onepage' ); ?></h3>
			<p><?php esc_html_e( 'Envie seu curriculo para:', 'rmfacilities-onepage' ); ?></p>
			<p><a href="mailto:<?php echo esc_attr( get_theme_mod( 'rmf_company_careers' ) ); ?>"><?php echo esc_html( get_theme_mod( 'rmf_company_careers' ) ); ?></a></p>
			<p><?php echo esc_html( get_theme_mod( 'rmf_company_address' ) ); ?></p>
		</div>
	</div>
</section>

<section class="section section-alt" id="blog">
	<div class="container">
		<p class="kicker"><?php esc_html_e( 'Artigos e novidades', 'rmfacilities-onepage' ); ?></p>
		<h2><?php esc_html_e( 'Conteudo recente', 'rmfacilities-onepage' ); ?></h2>

		<div class="cards">
			<?php
			$rmf_recent = new WP_Query(
				array(
					'post_type'      => 'post',
					'posts_per_page' => 3,
				)
			);

			if ( $rmf_recent->have_posts() ) {
				while ( $rmf_recent->have_posts() ) {
					$rmf_recent->the_post();
					?>
					<article class="card post-card">
						<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
						<p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 20 ) ); ?></p>
						<a class="text-link" href="<?php the_permalink(); ?>"><?php esc_html_e( 'Ler artigo', 'rmfacilities-onepage' ); ?></a>
					</article>
					<?php
				}
				wp_reset_postdata();
			} else {
				?>
				<article class="card post-card">
					<h3><?php esc_html_e( 'Sem artigos publicados ainda', 'rmfacilities-onepage' ); ?></h3>
					<p><?php esc_html_e( 'Publique o primeiro artigo para exibir conteudo nesta secao.', 'rmfacilities-onepage' ); ?></p>
				</article>
				<?php
			}
			?>
		</div>

		<p class="blog-link-wrap"><a class="btn btn-outline" href="<?php echo esc_url( get_permalink( get_option( 'page_for_posts' ) ) ?: home_url( '/blog/' ) ); ?>"><?php esc_html_e( 'Ver todos os artigos', 'rmfacilities-onepage' ); ?></a></p>
	</div>
</section>

<?php
get_footer();
