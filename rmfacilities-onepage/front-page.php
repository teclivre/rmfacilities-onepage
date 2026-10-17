<?php
/**
 * Pagina inicial one-page.
 *
 * @package RMFacilitiesOnePage
 */

get_header();

$rmf_wpp_url = function_exists( 'rmf_get_whatsapp_url' ) ? rmf_get_whatsapp_url() : '#contato';
$rmf_service_links = array();
foreach ( array_keys( rmf_service_pages() ) as $rmf_service_slug ) {
	$rmf_service_page                  = get_page_by_path( $rmf_service_slug );
	$rmf_service_links[ $rmf_service_slug ] = $rmf_service_page ? get_permalink( $rmf_service_page ) : '#contato';
}
?>

<section class="hero section" id="inicio">
	<div class="container">
		<p class="kicker" data-hero-reveal="1"><?php esc_html_e( 'Terceirização de serviços profissionais', 'rmfacilities-onepage' ); ?></p>
		<h1 data-hero-reveal="2"><?php esc_html_e( 'Portaria, limpeza, jardinagem e recepção em São José dos Campos', 'rmfacilities-onepage' ); ?></h1>
		<p data-hero-reveal="3"><?php esc_html_e( 'Conheça soluções de facilities para empresas e condomínios, com escopo definido conforme as necessidades de cada operação.', 'rmfacilities-onepage' ); ?></p>
		<div class="hero-actions" data-hero-reveal="4">
			<a class="btn btn-primary" href="#contato"><?php esc_html_e( 'Solicitar orcamento', 'rmfacilities-onepage' ); ?></a>
			<a class="btn btn-outline" href="<?php echo esc_url( $rmf_wpp_url ); ?>" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'Falar no WhatsApp', 'rmfacilities-onepage' ); ?></a>
		</div>
	</div>
</section>

<section class="section" id="sobre">
	<div class="container two-col">
		<div>
			<p class="kicker"><?php esc_html_e( 'Quem somos', 'rmfacilities-onepage' ); ?></p>
			<h2><?php esc_html_e( 'RM Facilities LTDA', 'rmfacilities-onepage' ); ?></h2>
			<p><?php esc_html_e( 'A RM Facilities LTDA oferece terceirização de serviços de portaria, limpeza, jardinagem e recepção para empresas, condomínios e instituições em São José dos Campos, Vale do Paraíba, Região Bragantina e Sul de Minas. O escopo é definido de acordo com as necessidades de cada operação.', 'rmfacilities-onepage' ); ?></p>
		</div>
		<div class="highlight-box">
			<h3><?php esc_html_e( 'Por que terceirizar com a RM Facilities LTDA', 'rmfacilities-onepage' ); ?></h3>
			<ul>
				<li><?php esc_html_e( 'Equipe orientada para as rotinas do serviço contratado', 'rmfacilities-onepage' ); ?></li>
				<li><?php esc_html_e( 'Acompanhamento definido conforme o escopo contratado', 'rmfacilities-onepage' ); ?></li>
				<li><?php esc_html_e( 'Planejamento de cobertura operacional', 'rmfacilities-onepage' ); ?></li>
				<li><?php esc_html_e( 'Gestão das obrigações trabalhistas do vínculo empregatício', 'rmfacilities-onepage' ); ?></li>
				<li><?php esc_html_e( 'Comunicação alinhada às necessidades da operação', 'rmfacilities-onepage' ); ?></li>
			</ul>
		</div>
	</div>
</section>

<section class="section trust-strip" id="como-trabalhamos">
	<div class="container">
		<p class="kicker"><?php esc_html_e( 'Do primeiro contato ao início do serviço', 'rmfacilities-onepage' ); ?></p>
		<h2><?php esc_html_e( 'Um processo claro para entender sua operação', 'rmfacilities-onepage' ); ?></h2>
		<div class="cards cards-4">
			<article class="card">
				<h3><?php esc_html_e( '1. Levantamento', 'rmfacilities-onepage' ); ?></h3>
				<p><?php esc_html_e( 'Entendemos o ambiente, as rotinas, os horários e o serviço que sua empresa precisa.', 'rmfacilities-onepage' ); ?></p>
			</article>
			<article class="card">
				<h3><?php esc_html_e( '2. Proposta', 'rmfacilities-onepage' ); ?></h3>
				<p><?php esc_html_e( 'Definimos o escopo do atendimento e preparamos uma proposta para sua avaliação.', 'rmfacilities-onepage' ); ?></p>
			</article>
			<article class="card">
				<h3><?php esc_html_e( '3. Planejamento', 'rmfacilities-onepage' ); ?></h3>
				<p><?php esc_html_e( 'Com a proposta aprovada, alinhamos os detalhes necessários para iniciar a operação.', 'rmfacilities-onepage' ); ?></p>
			</article>
			<article class="card">
				<h3><?php esc_html_e( '4. Acompanhamento', 'rmfacilities-onepage' ); ?></h3>
				<p><?php esc_html_e( 'Acompanhamos o serviço conforme as rotinas e os critérios definidos com sua empresa.', 'rmfacilities-onepage' ); ?></p>
			</article>
		</div>
	</div>
</section>

<section class="section" id="porque">
	<div class="container">
		<p class="kicker"><?php esc_html_e( 'Por que a RM Facilities LTDA', 'rmfacilities-onepage' ); ?></p>
		<h2><?php esc_html_e( 'Terceirização com responsabilidade e acompanhamento', 'rmfacilities-onepage' ); ?></h2>
		<div class="why-grid">
			<article class="why-item">
				<span class="why-icon" aria-hidden="true">🎓</span>
				<h3><?php esc_html_e( 'Equipe orientada para cada função', 'rmfacilities-onepage' ); ?></h3>
				<p><?php esc_html_e( 'As rotinas e responsabilidades são alinhadas conforme a função e o ambiente de trabalho.', 'rmfacilities-onepage' ); ?></p>
			</article>
			<article class="why-item">
				<span class="why-icon" aria-hidden="true">📊</span>
				<h3><?php esc_html_e( 'Indicadores e relatorios periodicos', 'rmfacilities-onepage' ); ?></h3>
				<p><?php esc_html_e( 'Fornecemos relatorios de desempenho operacional para que voce acompanhe os resultados de perto.', 'rmfacilities-onepage' ); ?></p>
			</article>
			<article class="why-item">
				<span class="why-icon" aria-hidden="true">⚖️</span>
				<h3><?php esc_html_e( 'Gestão das obrigações trabalhistas', 'rmfacilities-onepage' ); ?></h3>
				<p><?php esc_html_e( 'A administração das obrigações relacionadas aos colaboradores é realizada pela empresa empregadora, conforme a legislação e o contrato.', 'rmfacilities-onepage' ); ?></p>
			</article>
			<article class="why-item">
				<span class="why-icon" aria-hidden="true">🛡️</span>
				<h3><?php esc_html_e( 'Plano de contingencia e cobertura', 'rmfacilities-onepage' ); ?></h3>
				<p><?php esc_html_e( 'O planejamento para ausências e imprevistos é definido conforme o serviço e as condições contratadas.', 'rmfacilities-onepage' ); ?></p>
			</article>
			<article class="why-item">
				<span class="why-icon" aria-hidden="true">🤝</span>
				<h3><?php esc_html_e( 'Comunicação com a equipe', 'rmfacilities-onepage' ); ?></h3>
				<p><?php esc_html_e( 'Alinhamos os canais de comunicação e o acompanhamento operacional conforme as necessidades do contrato.', 'rmfacilities-onepage' ); ?></p>
			</article>
			<article class="why-item">
				<span class="why-icon" aria-hidden="true">📍</span>
				<h3><?php esc_html_e( 'Atuacao regional com base em SJC', 'rmfacilities-onepage' ); ?></h3>
				<p><?php esc_html_e( 'Com sede em São José dos Campos, atendemos empresas, condomínios e instituições no Vale do Paraíba, Região Bragantina e Sul de Minas. Consulte a disponibilidade para sua cidade.', 'rmfacilities-onepage' ); ?></p>
			</article>
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
				<h3><a href="<?php echo esc_url( $rmf_service_links['portaria-sao-jose-dos-campos'] ); ?>"><?php esc_html_e( 'Portaria em São José dos Campos', 'rmfacilities-onepage' ); ?></a></h3>
				<p><?php esc_html_e( 'Controle de acesso e rotinas de portaria definidas conforme as necessidades da sua empresa.', 'rmfacilities-onepage' ); ?></p>
				<a class="text-link" href="<?php echo esc_url( $rmf_service_links['portaria-sao-jose-dos-campos'] ); ?>"><?php esc_html_e( 'Conheça o serviço de portaria', 'rmfacilities-onepage' ); ?></a>
			</article>
			<article class="card">
				<span class="card-icon">🧹</span>
				<h3><a href="<?php echo esc_url( $rmf_service_links['limpeza-sao-jose-dos-campos'] ); ?>"><?php esc_html_e( 'Limpeza em São José dos Campos', 'rmfacilities-onepage' ); ?></a></h3>
				<p><?php esc_html_e( 'Rotinas de limpeza e conservação planejadas conforme o tipo e o fluxo do ambiente.', 'rmfacilities-onepage' ); ?></p>
				<a class="text-link" href="<?php echo esc_url( $rmf_service_links['limpeza-sao-jose-dos-campos'] ); ?>"><?php esc_html_e( 'Conheça o serviço de limpeza', 'rmfacilities-onepage' ); ?></a>
			</article>
			<article class="card">
				<span class="card-icon">🌿</span>
				<h3><a href="<?php echo esc_url( $rmf_service_links['jardinagem-sao-jose-dos-campos'] ); ?>"><?php esc_html_e( 'Jardinagem em São José dos Campos', 'rmfacilities-onepage' ); ?></a></h3>
				<p><?php esc_html_e( 'Manutencao e cuidado de areas verdes internas e externas, valorizando o ambiente da sua empresa.', 'rmfacilities-onepage' ); ?></p>
				<a class="text-link" href="<?php echo esc_url( $rmf_service_links['jardinagem-sao-jose-dos-campos'] ); ?>"><?php esc_html_e( 'Conheça o serviço de jardinagem', 'rmfacilities-onepage' ); ?></a>
			</article>
			<article class="card">
				<span class="card-icon">🤝</span>
				<h3><a href="<?php echo esc_url( $rmf_service_links['recepcao-sao-jose-dos-campos'] ); ?>"><?php esc_html_e( 'Recepção em São José dos Campos', 'rmfacilities-onepage' ); ?></a></h3>
				<p><?php esc_html_e( 'Recepção e orientação de visitantes de acordo com os processos da sua empresa.', 'rmfacilities-onepage' ); ?></p>
				<a class="text-link" href="<?php echo esc_url( $rmf_service_links['recepcao-sao-jose-dos-campos'] ); ?>"><?php esc_html_e( 'Conheça o serviço de recepção', 'rmfacilities-onepage' ); ?></a>
			</article>
		</div>
	</div>
</section>

<section class="section" id="contato">
	<div class="container">
		<div class="contact-layout">
			<div class="contact-info">
				<p class="kicker"><?php esc_html_e( 'Fale conosco', 'rmfacilities-onepage' ); ?></p>
				<h2><?php esc_html_e( 'Solicite um orcamento sem compromisso', 'rmfacilities-onepage' ); ?></h2>
				<p><?php esc_html_e( 'Preencha o formulário ou use um de nossos canais diretos para solicitar uma proposta.', 'rmfacilities-onepage' ); ?></p>
				<ul class="contact-list">
					<li>
						<span class="contact-icon" aria-hidden="true">📞</span>
						<a href="tel:+551230421795"><?php echo esc_html( get_theme_mod( 'rmf_company_phone_1', '+55 (12) 3042-1795' ) ); ?></a>
					</li>
					<li>
						<span class="contact-icon" aria-hidden="true">📱</span>
						<a href="<?php echo esc_url( $rmf_wpp_url ); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html( get_theme_mod( 'rmf_whatsapp_phone', '+55 (12) 3042-1799' ) ); ?> (WhatsApp)</a>
					</li>
					<li>
						<span class="contact-icon" aria-hidden="true">✉️</span>
						<a href="mailto:<?php echo esc_attr( get_theme_mod( 'rmf_company_email', 'contato@rmfacilities.com.br' ) ); ?>"><?php echo esc_html( get_theme_mod( 'rmf_company_email', 'contato@rmfacilities.com.br' ) ); ?></a>
					</li>
					<li>
						<span class="contact-icon" aria-hidden="true">📍</span>
						<span><?php esc_html_e( 'Av. Ilidio Meinberg Porto, 199, Sala 6 — Jardim Sao Vicente, Sao Jose dos Campos – SP – CEP 12224-310', 'rmfacilities-onepage' ); ?></span>
					</li>
				</ul>
			</div>

			<div class="contact-form-wrap">
				<?php
				$rmf_status = isset( $_GET['status'] ) ? sanitize_key( $_GET['status'] ) : ''; // phpcs:ignore WordPress.Security.NonceVerification
				if ( 'enviado' === $rmf_status ) : ?>
					<div class="rmf-form-notice rmf-form-notice--success" role="status">
						✅ <strong>Mensagem enviada!</strong> Sua solicitação foi recebida.
					</div>
				<?php elseif ( 'erro' === $rmf_status ) : ?>
					<div class="rmf-form-notice rmf-form-notice--error" role="alert">
						⚠️ <strong>Ops!</strong> Ocorreu um erro. Tente novamente ou fale pelo WhatsApp.
					</div>
				<?php endif; ?>
				<form class="rmf-contact-form" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post">
					<?php wp_nonce_field( 'rmf_contact_nonce', 'rmf_nonce' ); ?>
					<input type="hidden" name="action" value="rmf_submit_contact">

					<div class="form-row form-row-2">
						<div class="form-field">
							<label for="rmf-nome"><?php esc_html_e( 'Seu nome *', 'rmfacilities-onepage' ); ?></label>
							<input type="text" id="rmf-nome" name="rmf_nome" placeholder="Nome completo" required>
						</div>
						<div class="form-field">
							<label for="rmf-empresa"><?php esc_html_e( 'Empresa', 'rmfacilities-onepage' ); ?></label>
							<input type="text" id="rmf-empresa" name="rmf_empresa" placeholder="Nome da empresa">
						</div>
					</div>

					<div class="form-row form-row-2">
						<div class="form-field">
							<label for="rmf-email"><?php esc_html_e( 'E-mail *', 'rmfacilities-onepage' ); ?></label>
							<input type="email" id="rmf-email" name="rmf_email" placeholder="seu@email.com.br" required>
						</div>
						<div class="form-field">
							<label for="rmf-telefone"><?php esc_html_e( 'Telefone / WhatsApp *', 'rmfacilities-onepage' ); ?></label>
							<input type="tel" id="rmf-telefone" name="rmf_telefone" placeholder="(12) 9XXXX-XXXX" required>
						</div>
					</div>

					<div class="form-row form-row-2">
						<div class="form-field">
							<label for="rmf-servico"><?php esc_html_e( 'Servico de interesse *', 'rmfacilities-onepage' ); ?></label>
							<select id="rmf-servico" name="rmf_servico" required>
								<option value=""><?php esc_html_e( 'Selecione...', 'rmfacilities-onepage' ); ?></option>
								<option value="portaria"><?php esc_html_e( 'Portaria / Controle de acesso', 'rmfacilities-onepage' ); ?></option>
								<option value="limpeza"><?php esc_html_e( 'Limpeza e conservacao', 'rmfacilities-onepage' ); ?></option>
								<option value="jardinagem"><?php esc_html_e( 'Jardinagem', 'rmfacilities-onepage' ); ?></option>
								<option value="recepcao"><?php esc_html_e( 'Recepcao', 'rmfacilities-onepage' ); ?></option>
								<option value="pacote"><?php esc_html_e( 'Pacote de servicos', 'rmfacilities-onepage' ); ?></option>
							</select>
						</div>
						<div class="form-field">
							<label for="rmf-urgencia"><?php esc_html_e( 'Urgencia', 'rmfacilities-onepage' ); ?></label>
							<select id="rmf-urgencia" name="rmf_urgencia">
								<option value=""><?php esc_html_e( 'Quando precisar?', 'rmfacilities-onepage' ); ?></option>
								<option value="imediato"><?php esc_html_e( 'Imediato (esta semana)', 'rmfacilities-onepage' ); ?></option>
								<option value="em30dias"><?php esc_html_e( 'Em ate 30 dias', 'rmfacilities-onepage' ); ?></option>
								<option value="planejando"><?php esc_html_e( 'Estou planejando', 'rmfacilities-onepage' ); ?></option>
							</select>
						</div>
					</div>

					<div class="form-row form-row-2">
						<div class="form-field">
							<label for="rmf-cidade"><?php esc_html_e( 'Cidade', 'rmfacilities-onepage' ); ?></label>
							<input type="text" id="rmf-cidade" name="rmf_cidade" placeholder="Cidade / UF">
						</div>
						<div class="form-field">
							<label for="rmf-metragem"><?php esc_html_e( 'Metragem aproximada (m²)', 'rmfacilities-onepage' ); ?></label>
							<input type="text" id="rmf-metragem" name="rmf_metragem" placeholder="Ex: 500 m²">
						</div>
					</div>

					<div class="form-row">
						<div class="form-field">
							<label for="rmf-mensagem"><?php esc_html_e( 'Mensagem', 'rmfacilities-onepage' ); ?></label>
							<textarea id="rmf-mensagem" name="rmf_mensagem" rows="4" placeholder="<?php esc_attr_e( 'Descreva sua necessidade ou deixe uma observacao...', 'rmfacilities-onepage' ); ?>"></textarea>
						</div>
					</div>

					<p class="form-privacy-note"><?php esc_html_e( 'Seus dados sao protegidos conforme a LGPD. Usamos somente para responder ao seu contato.', 'rmfacilities-onepage' ); ?></p>
					<button class="btn btn-primary" type="submit"><?php esc_html_e( 'Enviar solicitacao', 'rmfacilities-onepage' ); ?></button>
				</form>
			</div>
		</div>
	</div>
</section>

<section class="section" id="faq">
	<div class="container">
		<p class="kicker"><?php esc_html_e( 'Duvidas frequentes', 'rmfacilities-onepage' ); ?></p>
		<h2><?php esc_html_e( 'Perguntas frequentes sobre terceirizacao de facilities', 'rmfacilities-onepage' ); ?></h2>
		<dl class="faq-list">
			<div class="faq-item">
				<dt><button class="faq-question" type="button" aria-expanded="false" aria-controls="faq-answer-1"><?php esc_html_e( 'Quais serviços a RM Facilities LTDA oferece?', 'rmfacilities-onepage' ); ?></button></dt>
				<dd class="faq-answer" id="faq-answer-1" hidden><?php esc_html_e( 'Oferecemos portaria e controle de acesso, limpeza e conservação, jardinagem e áreas verdes, e recepção profissional. Podemos combinar serviços em um pacote personalizado para sua empresa.', 'rmfacilities-onepage' ); ?></dd>
			</div>
			<div class="faq-item">
				<dt><button class="faq-question" type="button" aria-expanded="false" aria-controls="faq-answer-2"><?php esc_html_e( 'Em quais cidades vocês atendem?', 'rmfacilities-onepage' ); ?></button></dt>
				<dd class="faq-answer" id="faq-answer-2" hidden><?php esc_html_e( 'Temos sede em São José dos Campos – SP e atendemos empresas e condomínios no Vale do Paraíba, Região Bragantina e Sul de Minas. Consulte-nos para verificar disponibilidade na sua cidade.', 'rmfacilities-onepage' ); ?></dd>
			</div>
			<div class="faq-item">
				<dt><button class="faq-question" type="button" aria-expanded="false" aria-controls="faq-answer-3"><?php esc_html_e( 'Como funciona o processo de contratação?', 'rmfacilities-onepage' ); ?></button></dt>
				<dd class="faq-answer" id="faq-answer-3" hidden><?php esc_html_e( 'Após o contato inicial, realizamos um levantamento das suas necessidades, elaboramos uma proposta personalizada e, após aprovação, alinhamos os detalhes para iniciar o serviço.', 'rmfacilities-onepage' ); ?></dd>
			</div>
			<div class="faq-item">
				<dt><button class="faq-question" type="button" aria-expanded="false" aria-controls="faq-answer-4"><?php esc_html_e( 'A empresa assume as obrigações trabalhistas dos colaboradores?', 'rmfacilities-onepage' ); ?></button></dt>
				<dd class="faq-answer" id="faq-answer-4" hidden><?php esc_html_e( 'A RM Facilities LTDA é empregadora dos colaboradores alocados e administra as obrigações trabalhistas correspondentes ao vínculo de emprego.', 'rmfacilities-onepage' ); ?></dd>
			</div>
			<div class="faq-item">
				<dt><button class="faq-question" type="button" aria-expanded="false" aria-controls="faq-answer-5"><?php esc_html_e( 'O que acontece se um colaborador faltar?', 'rmfacilities-onepage' ); ?></button></dt>
				<dd class="faq-answer" id="faq-answer-5" hidden><?php esc_html_e( 'A cobertura de ausências é tratada conforme o plano de contingência e as condições definidas na proposta contratada.', 'rmfacilities-onepage' ); ?></dd>
			</div>
			<div class="faq-item">
				<dt><button class="faq-question" type="button" aria-expanded="false" aria-controls="faq-answer-6"><?php esc_html_e( 'Como é feito o acompanhamento da qualidade?', 'rmfacilities-onepage' ); ?></button></dt>
				<dd class="faq-answer" id="faq-answer-6" hidden><?php esc_html_e( 'Os critérios de acompanhamento e a rotina de comunicação são alinhados com o contratante conforme o serviço e a proposta.', 'rmfacilities-onepage' ); ?></dd>
			</div>
		</dl>
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
