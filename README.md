# RM Facilities

Tema WordPress institucional da RM Facilities LTDA, com página inicial, páginas de serviços, formulário de contato e área de artigos.

## Requisitos

- WordPress 6.0 ou superior.
- PHP 7.4 ou superior.
- HTTPS habilitado no domínio.
- Rank Math SEO recomendado para gerenciar títulos, descrições, sitemap e dados locais da empresa.

## Instalação e atualização

1. Faça backup dos arquivos e do banco de dados do WordPress.
2. Envie a pasta [`rmfacilities-onepage/`](./rmfacilities-onepage/) para `wp-content/themes/` ou instale um ZIP do tema pelo painel em **Aparência → Temas → Adicionar novo**.
3. Ative o tema em **Aparência → Temas**.
4. Confira **Configurações → Leitura** e confirme que a página inicial e a página de artigos são as corretas.
5. Em **Aparência → Personalizar → Dados da Empresa**, revise telefones, WhatsApp, e-mails, endereço e CNPJ.
6. Configure os menus principal e do rodapé em **Aparência → Menus**. Atribua-os às localizações correspondentes.

Na ativação, o tema cria páginas iniciais para início, blog, agradecimento, privacidade e serviços quando elas ainda não existem. As páginas de serviços usam URLs descritivas, como `/portaria-sao-jose-dos-campos/`. Ao abrir o painel após a atualização, o tema atualiza somente as páginas de serviço que ainda têm o título e o texto inicial exatos gerados por uma versão anterior. Conteúdo editado manualmente não é substituído.

A página de política de privacidade inicial é apenas um ponto de partida. Revise-a para refletir os dados coletados pelo formulário, os serviços de terceiros usados e os canais de atendimento antes de considerá-la uma política completa.

O painel de preferências do Cookie Law Info/CookieYes depende dos estilos do próprio plugin, que não devem ser removidos. O tema aplica a identidade visual do site e traduz os textos padrão em inglês para português; textos personalizados no plugin são mantidos. Revise no painel as categorias e as descrições para que correspondam aos cookies e serviços realmente usados.

O formulário combina um campo honeypot, uma verificação de tempo quando JavaScript está disponível e um limite de cinco envios por hora por visitante. Para ativar a verificação forte com Cloudflare Turnstile:

1. Crie um widget Turnstile no painel Cloudflare e autorize o domínio do site.
2. Copie as chaves do site e secreta para o `wp-config.php`, antes da linha de encerramento de edição, sem publicá-las no tema ou no Git:

   ```php
   define( 'RMF_TURNSTILE_SITE_KEY', 'SUA_CHAVE_DO_SITE' );
   define( 'RMF_TURNSTILE_SECRET_KEY', 'SUA_CHAVE_SECRETA' );
   ```

3. Limpe o cache do site e teste o envio do formulário. Quando as duas chaves estão definidas, a validação é obrigatória no servidor; token ausente, inválido, indisponibilidade do serviço ou domínio divergente impedem o envio.

O limite usa um hash do endereço do visitante; quando a requisição chega pelo Cloudflare, o tema também envia o IP validado pelo proxy à verificação. Sem as chaves do Turnstile, o honeypot, a validação de tempo e o limite continuam ativos, mas são proteções básicas e podem ser contornadas por bots mais avançados.

### Gerar ZIP para instalar uma atualização

Depois de alterar o tema, gere o pacote para enviar pelo WordPress executando na raiz do repositório:

```sh
./scripts/gerar-zip-tema.sh
```

O script incrementa automaticamente o número de correção da versão no cabeçalho `Version` de `rmfacilities-onepage/style.css` (por exemplo, `X.Y.4` para `X.Y.5`) e gera o pacote com a versão no nome, como `rmfacilities-onepage-vX.Y.5.zip`. Ele mantém o diretório do tema sincronizado e remove o antigo ZIP sem versão no nome para evitar confusão. Instale o ZIP recém-gerado em **Aparência → Temas → Adicionar novo → Enviar tema** e confirme a substituição/atualização quando solicitado. Inclua no commit os arquivos `style.css` e o ZIP versionado gerados.

## SEO e Google

### Rank Math

O tema evita emitir uma segunda cópia de description, canonical, robots, Open Graph e schema quando Rank Math ou Yoast SEO está ativo. O arquivo [`rank-math.php`](./rmfacilities-onepage/rank-math.php) complementa o Rank Math com o título e a descrição da página inicial e corrige o schema indevido encontrado no site publicado: o nome da organização é RM Facilities LTDA, a página inicial deixa de ser marcada como artigo e entidades de autor sem relação com ela são removidas.

Mantenha apenas um plugin de SEO ativo; Rank Math e Yoast juntos podem duplicar as próprias tags entre si.

Revise também as configurações do WordPress e do Rank Math:

1. Em **Configurações → Geral**, use o nome real da empresa como título do site e uma descrição institucional curta.
2. Em **Rank Math → Títulos e Meta → SEO local**, configure o tipo como empresa/organização e confira nome, endereço, telefone, e-mail e perfis sociais. Remova perfis sociais genéricos ou que não pertençam à empresa.
3. Na página inicial, confirme que há apenas um título, uma meta description e uma canonical no código-fonte. O título recomendado pelo tema é “RM Facilities | Terceirização de serviços em São José dos Campos”.
   Configure também uma imagem própria para compartilhamento social no Rank Math, com proporção horizontal adequada (por exemplo, 1200 × 630 px). Use arquivos e dimensões reais; não cadastre uma imagem genérica de outra empresa.
4. Nas páginas e nos artigos, escreva títulos e descrições próprios, fiéis ao conteúdo visível. Evite repetir palavras-chave ou criar páginas de cidades com texto praticamente igual.
5. Confirme que o sitemap enviado ao Google Search Console é o que está ativo no WordPress. Com Rank Math, o endereço normalmente é `/sitemap_index.xml`; o `robots.txt` deve apontar para esse mesmo sitemap.
6. Use a Inspeção de URL no Search Console e os relatórios de indexação para verificar acesso, canonical escolhida e eventuais erros. Reenvie páginas importantes à indexação após publicar alterações.

Sem plugin de SEO, o tema fornece metadados básicos e schema `LocalBusiness` na página inicial. O tema não gera schema de FAQ: o Google limita resultados avançados de FAQ a sites governamentais e de saúde conhecidos, portanto essa marcação não é uma promessa de destaque na busca.

### Conteúdo e páginas de serviço

As quatro páginas de serviço são criadas com conteúdo inicial específico e recebem links rastreáveis nos respectivos cartões da página inicial. Revise os textos para refletirem o escopo realmente oferecido, complete detalhes úteis para o cliente e inclua imagens próprias com texto alternativo descritivo. Não publique métricas, depoimentos, clientes, certificações ou áreas de atendimento que não possam ser comprovados.

O tema removeu números e depoimentos de exemplo que não tinham comprovação no código. Se a empresa quiser publicá-los, use dados atualizados e verificáveis e obtenha autorização para identificar clientes e autores.

### Navegação e acessibilidade

- Os links do menu usam destinos HTML normais; links para seções também funcionam sem JavaScript.
- O menu mobile informa seu estado a leitores de tela e pode ser fechado com `Escape`.
- As perguntas frequentes usam botões com estado acessível por teclado.
- Os links da página inicial levam às páginas individuais de serviços quando elas existem.
- Ao personalizar os menus, inclua páginas de serviços, artigos, contato e as páginas institucionais necessárias, mantendo rótulos claros.

### Desempenho

O tema não carrega mais a folha externa do Font Awesome, que não era usada, nem mantém o efeito de paralaxe fixo do fundo. As animações respeitam `prefers-reduced-motion`. Essas alterações reduzem trabalho e requisições, mas não substituem medição do site em produção.

Depois de publicar, teste as páginas inicial e de serviços no [PageSpeed Insights](https://pagespeed.web.dev/) e monitore LCP, INP e CLS em dados de campo quando disponíveis. Otimize imagens grandes, mantenha o cache e a hospedagem atualizados e reavalie scripts e plugins que bloqueiem a renderização.

## Desenvolvimento e validação

Os arquivos do tema ficam em [`rmfacilities-onepage/`](./rmfacilities-onepage/). Para validar sintaxe PHP e JavaScript antes do envio:

```sh
find rmfacilities-onepage -name '*.php' -print0 | xargs -0 -n1 php -l
node --check rmfacilities-onepage/assets/js/theme.js
```

Este repositório não inclui uma instalação WordPress nem uma suíte automatizada de testes de integração. Depois de instalar as alterações em homologação, confira manualmente:

- Menu principal e rodapé em desktop e celular, com teclado e leitor de tela.
- Cartões e páginas de cada serviço, formulário, FAQ e artigos.
- Código-fonte: um único conjunto de metadados SEO e schema coerente com os dados reais da empresa.
- `robots.txt`, sitemap e status HTTP 200 das páginas que devem ser indexadas.
- PageSpeed Insights e relatórios do Google Search Console.

SEO não tem nota universal “10/10” nem garantia de posição ou resultado avançado. O objetivo é manter páginas acessíveis, úteis, rápidas e tecnicamente consistentes, medindo os resultados com ferramentas reais.
