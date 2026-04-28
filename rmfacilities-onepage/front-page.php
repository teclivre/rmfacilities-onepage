<?php
/**
 * Pagina inicial one-page.
 *
 * @package RMFacilitiesOnePage
 */

get_header();

$rmf_wpp_url = function_exists( 'rmf_get_whatsapp_url' ) ? rmf_get_whatsapp_url() : '#contato';
?>

<section class="hero section" id="inicio">
	<div class="container">
		<p class="kicker" data-hero-reveal="1"><?php esc_html_e( 'Terceirizacao de servicos profissionais', 'rmfacilities-onepage' ); ?></p>
		<h1 data-hero-reveal="2"><?php esc_html_e( 'Portaria, limpeza, jardinagem e recepcao para a sua empresa', 'rmfacilities-onepage' ); ?></h1>
		<p data-hero-reveal="3"><?php esc_html_e( 'Todos os nossos servicos sao prestados por profissionais capacitados, com rigoroso processo de selecao e treinamento continuo.', 'rmfacilities-onepage' ); ?></p>
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
			<p><?php esc_html_e( 'Ha mais de 10 anos ajudamos empresas, condominios e instituicoes a manter ambientes funcionais e organizados, reduzindo custos operacionais e eliminando passivos trabalhistas.', 'rmfacilities-onepage' ); ?></p>
		</div>
		<div class="highlight-box">
			<h3><?php esc_html_e( 'Por que terceirizar com a RM Facilities LTDA', 'rmfacilities-onepage' ); ?></h3>
			<ul>
				<li><?php esc_html_e( 'Selecao e treinamento continuo dos colaboradores', 'rmfacilities-onepage' ); ?></li>
				<li><?php esc_html_e( 'Supervisao presencial e indicadores de qualidade', 'rmfacilities-onepage' ); ?></li>
				<li><?php esc_html_e( 'Plano de contingencia e cobertura garantida', 'rmfacilities-onepage' ); ?></li>
				<li><?php esc_html_e( 'Conformidade trabalhista e sem passivo juridico', 'rmfacilities-onepage' ); ?></li>
				<li><?php esc_html_e( 'Gestor de conta dedicado ao seu negocio', 'rmfacilities-onepage' ); ?></li>
			</ul>
		</div>
	</div>
</section>

<section class="section trust-strip" id="resultados">
	<div class="container">
		<p class="kicker"><?php esc_html_e( 'Resultados e confianca', 'rmfacilities-onepage' ); ?></p>
		<div class="trust-grid">
			<article class="trust-item">
				<strong>80</strong>
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
				<strong>6+</strong>
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

<section class="section" id="porque">
	<div class="container">
		<p class="kicker"><?php esc_html_e( 'Por que a RM Facilities LTDA', 'rmfacilities-onepage' ); ?></p>
		<h2><?php esc_html_e( 'Terceirizacao com responsabilidade, supervisao e resultado', 'rmfacilities-onepage' ); ?></h2>
		<div class="why-grid">
			<article class="why-item">
				<span class="why-icon" aria-hidden="true">🎓</span>
				<h3><?php esc_html_e( 'Equipe treinada e certificada', 'rmfacilities-onepage' ); ?></h3>
				<p><?php esc_html_e( 'Todos os colaboradores passam por processo seletivo rigoroso, treinamento especifico por funcao e reciclagens periodicas.', 'rmfacilities-onepage' ); ?></p>
			</article>
			<article class="why-item">
				<span class="why-icon" aria-hidden="true">📊</span>
				<h3><?php esc_html_e( 'Indicadores e relatorios periodicos', 'rmfacilities-onepage' ); ?></h3>
				<p><?php esc_html_e( 'Fornecemos relatorios de desempenho operacional para que voce acompanhe os resultados de perto.', 'rmfacilities-onepage' ); ?></p>
			</article>
			<article class="why-item">
				<span class="why-icon" aria-hidden="true">⚖️</span>
				<h3><?php esc_html_e( 'Conformidade trabalhista total', 'rmfacilities-onepage' ); ?></h3>
				<p><?php esc_html_e( 'Eliminamos seu passivo juridico: gestao completa de folha, ferias, encargos e obrigacoes acessorias.', 'rmfacilities-onepage' ); ?></p>
			</article>
			<article class="why-item">
				<span class="why-icon" aria-hidden="true">🛡️</span>
				<h3><?php esc_html_e( 'Plano de contingencia e cobertura', 'rmfacilities-onepage' ); ?></h3>
				<p><?php esc_html_e( 'Mantemos banco de reservas treinados para garantir cobertura imediata em faltas ou imprevistos.', 'rmfacilities-onepage' ); ?></p>
			</article>
			<article class="why-item">
				<span class="why-icon" aria-hidden="true">🤝</span>
				<h3><?php esc_html_e( 'Gestor de conta dedicado', 'rmfacilities-onepage' ); ?></h3>
				<p><?php esc_html_e( 'Voce tem um ponto de contato unico para demandas operacionais, garantindo agilidade e atendimento personalizado.', 'rmfacilities-onepage' ); ?></p>
			</article>
			<article class="why-item">
				<span class="why-icon" aria-hidden="true">📍</span>
				<h3><?php esc_html_e( 'Atuacao em Sao Jose dos Campos e regiao', 'rmfacilities-onepage' ); ?></h3>
				<p><?php esc_html_e( 'Com sede em SJC, atendemos com agilidade empresas, condominios e instituicoes no Vale do Paraiba.', 'rmfacilities-onepage' ); ?></p>
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
	<div class="container">
		<div class="contact-layout">
			<div class="contact-info">
				<p class="kicker"><?php esc_html_e( 'Fale conosco', 'rmfacilities-onepage' ); ?></p>
				<h2><?php esc_html_e( 'Solicite um orcamento sem compromisso', 'rmfacilities-onepage' ); ?></h2>
				<p><?php esc_html_e( 'Preencha o formulario ou use um de nossos canais diretos. Retornamos em ate 1 dia util.', 'rmfacilities-onepage' ); ?></p>
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
				<form class="rmf-contact-form" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post" novalidate>
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

<section class="section" id="faq">
	<div class="container">
		<p class="kicker"><?php esc_html_e( 'Duvidas frequentes', 'rmfacilities-onepage' ); ?></p>
		<h2><?php esc_html_e( 'Perguntas frequentes sobre terceirizacao de facilities', 'rmfacilities-onepage' ); ?></h2>
		<dl class="faq-list">
			<div class="faq-item">
				<dt class="faq-question"><?php esc_html_e( 'Quais servicos a RM Facilities LTDA oferece?', 'rmfacilities-onepage' ); ?></dt>
				<dd class="faq-answer"><?php esc_html_e( 'Oferecemos portaria e controle de acesso, limpeza e conservacao, jardinagem e areas verdes, e recepcao profissional. Podemos combinar servicos em um pacote personalizado para sua empresa.', 'rmfacilities-onepage' ); ?></dd>
			</div>
			<div class="faq-item">
				<dt class="faq-question"><?php esc_html_e( 'Em quais cidades voces atendem?', 'rmfacilities-onepage' ); ?></dt>
				<dd class="faq-answer"><?php esc_html_e( 'Temos sede em Sao Jose dos Campos – SP e atendemos empresas e condominios no Vale do Paraiba e regiao metropolitana. Consulte-nos para verificar disponibilidade na sua cidade.', 'rmfacilities-onepage' ); ?></dd>
			</div>
			<div class="faq-item">
				<dt class="faq-question"><?php esc_html_e( 'Como funciona o processo de contratacao?', 'rmfacilities-onepage' ); ?></dt>
				<dd class="faq-answer"><?php esc_html_e( 'Apos o contato inicial, realizamos um levantamento das suas necessidades, elaboramos uma proposta personalizada e, apos aprovacao, iniciamos o processo de selecao e alocacao dos profissionais. O prazo medio do primeiro ao inicio e de 7 a 15 dias uteis.', 'rmfacilities-onepage' ); ?></dd>
			</div>
			<div class="faq-item">
				<dt class="faq-question"><?php esc_html_e( 'A empresa assume as obrigacoes trabalhistas dos colaboradores?', 'rmfacilities-onepage' ); ?></dt>
				<dd class="faq-answer"><?php esc_html_e( 'Sim. A RM Facilities LTDA e empregadora de todos os colaboradores alocados. Gerenciamos admissao, folha de pagamento, ferias, 13o salario, encargos e desligamento, eliminando passivos juridicos para o contratante.', 'rmfacilities-onepage' ); ?></dd>
			</div>
			<div class="faq-item">
				<dt class="faq-question"><?php esc_html_e( 'O que acontece se um colaborador faltar?', 'rmfacilities-onepage' ); ?></dt>
				<dd class="faq-answer"><?php esc_html_e( 'Mantemos um banco de profissionais treinados e disponiveis para cobertura imediata. Nosso plano de contingencia garante que seu servico nao seja interrompido por falta ou imprevistos.', 'rmfacilities-onepage' ); ?></dd>
			</div>
			<div class="faq-item">
				<dt class="faq-question"><?php esc_html_e( 'Como e feito o acompanhamento da qualidade?', 'rmfacilities-onepage' ); ?></dt>
				<dd class="faq-answer"><?php esc_html_e( 'Realizamos supervisao presencial periodica, coletamos indicadores de satisfacao e enviamos relatorios de desempenho ao contratante. Cada cliente tem um gestor de conta dedicado para comunicacao direta.', 'rmfacilities-onepage' ); ?></dd>
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
