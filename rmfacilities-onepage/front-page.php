<?php
/**
 * Pagina inicial one-page.
 *
 * @package RMFacilitiesOnePage
 */

get_header();

$rmf_whatsapp_raw = get_theme_mod( 'rmf_company_phone_1', '+55 (12) 3042-1795' );
$rmf_whatsapp_num = preg_replace( '/\D+/', '', (string) $rmf_whatsapp_raw );
$rmf_whatsapp_url = $rmf_whatsapp_num ? 'https://wa.me/' . $rmf_whatsapp_num : '#contato';
?>

<section class="hero section" id="inicio">
	<div class="container">
		<p class="kicker" data-hero-reveal="1"><?php esc_html_e( 'Terceirizacao de servicos profissionais', 'rmfacilities-onepage' ); ?></p>
		<h1 data-hero-reveal="2"><?php esc_html_e( 'Portaria, limpeza, jardinagem e recepcao para a sua empresa', 'rmfacilities-onepage' ); ?></h1>
		<p data-hero-reveal="3"><?php esc_html_e( 'Todos os nossos servicos sao prestados por profissionais capacitados, com rigoroso processo de selecao e treinamento continuo.', 'rmfacilities-onepage' ); ?></p>
		<div class="hero-actions" data-hero-reveal="4">
			<a class="btn btn-primary" href="#contato"><?php esc_html_e( 'Solicitar orcamento', 'rmfacilities-onepage' ); ?></a>
			<a class="btn btn-outline" href="<?php echo esc_url( $rmf_whatsapp_url ); ?>" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'Falar no WhatsApp', 'rmfacilities-onepage' ); ?></a>
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

<section class="section trust-strip" id="resultados">
	<div class="container">
		<p class="kicker"><?php esc_html_e( 'Resultados e confianca', 'rmfacilities-onepage' ); ?></p>
		<div class="trust-grid">
			<article class="trust-item">
				<strong>+120</strong>
				<span><?php esc_html_e( 'postos de trabalho ativos', 'rmfacilities-onepage' ); ?></span>
			</article>
			<article class="trust-item">
				<strong>98%</strong>
				<span><?php esc_html_e( 'indice medio de satisfacao', 'rmfacilities-onepage' ); ?></span>
			</article>
			<article class="trust-item">
				<strong>24/7</strong>
				<span><?php esc_html_e( 'suporte operacional e supervisao', 'rmfacilities-onepage' ); ?></span>
			</article>
			<article class="trust-item">
				<strong>+10</strong>
				<span><?php esc_html_e( 'anos de atuacao em facilities', 'rmfacilities-onepage' ); ?></span>
			</article>
		</div>

		<div class="logo-wall" aria-label="<?php esc_attr_e( 'Empresas atendidas', 'rmfacilities-onepage' ); ?>">
			<span><?php esc_html_e( 'Condominios', 'rmfacilities-onepage' ); ?></span>
			<span><?php esc_html_e( 'Centros Empresariais', 'rmfacilities-onepage' ); ?></span>
			<span><?php esc_html_e( 'Instituicoes de Ensino', 'rmfacilities-onepage' ); ?></span>
			<span><?php esc_html_e( 'Clinicas e Hospitais', 'rmfacilities-onepage' ); ?></span>
			<span><?php esc_html_e( 'Industria', 'rmfacilities-onepage' ); ?></span>
		</div>
	</div>
</section>

<section class="section section-alt" id="servicos">
	<div class="container">
		<p class="kicker"><?php esc_html_e( 'Nossos servicos', 'rmfacilities-onepage' ); ?></p>
		<h2><?php esc_html_e( 'Solucoes sob medida para o seu negocio', 'rmfacilities-onepage' ); ?></h2>
		<div class="cards cards-4">
			<article class="card">
				<span class="card-icon">🏢</span>
				<h3><?php esc_html_e( 'Portaria', 'rmfacilities-onepage' ); ?></h3>
				<p><?php esc_html_e( 'Controle de acesso e seguranca patrimonial com profissionais treinados e postura adequada para representar sua empresa.', 'rmfacilities-onepage' ); ?></p>
			</article>
			<article class="card">
				<span class="card-icon">🧹</span>
				<h3><?php esc_html_e( 'Limpeza', 'rmfacilities-onepage' ); ?></h3>
				<p><?php esc_html_e( 'Rotinas de limpeza profissional com controle de qualidade e equipes preparadas para diferentes tipos de ambiente.', 'rmfacilities-onepage' ); ?></p>
			</article>
			<article class="card">
				<span class="card-icon">🌿</span>
				<h3><?php esc_html_e( 'Jardinagem', 'rmfacilities-onepage' ); ?></h3>
				<p><?php esc_html_e( 'Manutencao e cuidado de areas verdes internas e externas, valorizando o ambiente da sua empresa.', 'rmfacilities-onepage' ); ?></p>
			</article>
			<article class="card">
				<span class="card-icon">🤝</span>
				<h3><?php esc_html_e( 'Recepcao', 'rmfacilities-onepage' ); ?></h3>
				<p><?php esc_html_e( 'Atendimento receptivo e profissional para clientes e visitantes, transmitindo a imagem da sua empresa desde a entrada.', 'rmfacilities-onepage' ); ?></p>
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

<section class="section section-alt" id="depoimentos">
	<div class="container">
		<p class="kicker"><?php esc_html_e( 'Depoimentos', 'rmfacilities-onepage' ); ?></p>
		<h2><?php esc_html_e( 'O que nossos clientes dizem', 'rmfacilities-onepage' ); ?></h2>

		<div class="testimonial-grid">
			<article class="testimonial-card">
				<div class="testimonial-head">
					<span class="testimonial-avatar" aria-hidden="true">AC</span>
					<div>
						<h3><?php esc_html_e( 'Ana Carvalho', 'rmfacilities-onepage' ); ?></h3>
						<p class="testimonial-role"><?php esc_html_e( 'SindicA profissional, condominio empresarial', 'rmfacilities-onepage' ); ?></p>
					</div>
				</div>
				<p><?php esc_html_e( 'A equipe da RM Facilities LTDA elevou o padrao de atendimento da nossa portaria e trouxe mais seguranca para moradores e visitantes.', 'rmfacilities-onepage' ); ?></p>
			</article>

			<article class="testimonial-card">
				<div class="testimonial-head">
					<span class="testimonial-avatar" aria-hidden="true">RF</span>
					<div>
						<h3><?php esc_html_e( 'Rafael Freitas', 'rmfacilities-onepage' ); ?></h3>
						<p class="testimonial-role"><?php esc_html_e( 'Gerente administrativo, centro logistico', 'rmfacilities-onepage' ); ?></p>
					</div>
				</div>
				<p><?php esc_html_e( 'Conseguimos padronizar limpeza e recepcao com indicadores claros. O acompanhamento operacional e muito proximo.', 'rmfacilities-onepage' ); ?></p>
			</article>

			<article class="testimonial-card">
				<div class="testimonial-head">
					<span class="testimonial-avatar" aria-hidden="true">ML</span>
					<div>
						<h3><?php esc_html_e( 'Mariana Lopes', 'rmfacilities-onepage' ); ?></h3>
						<p class="testimonial-role"><?php esc_html_e( 'Diretora operacional, instituicao de ensino', 'rmfacilities-onepage' ); ?></p>
					</div>
				</div>
				<p><?php esc_html_e( 'A terceirizacao com a RM Facilities LTDA trouxe mais previsibilidade e qualidade no dia a dia da operacao.', 'rmfacilities-onepage' ); ?></p>
			</article>
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
