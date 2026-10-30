#!/usr/bin/env python3
"""
Insere links internos contextuais em posts do WordPress via REST API.

Execucao:
  python3 scripts/inserir_links_internos.py --user roberiofig --dry-run
  python3 scripts/inserir_links_internos.py --user roberiofig --apply

O Application Password sera solicitado sem aparecer na tela, a menos que seja
informado com --app-pass.
"""

import argparse
import getpass
import json
import re
import subprocess
import sys
import time
from base64 import b64encode
from html import unescape
from urllib.parse import urlencode

BASE_URL = "https://rmfacilities.com.br/wp-json/wp/v2"
SITE_URL = "https://rmfacilities.com.br"

MARKER_START = "<!-- rmf-internal-links:start -->"
MARKER_END = "<!-- rmf-internal-links:end -->"

TARGET_SLUGS = [
    "10-tendencias-e-inovacoes-no-setor-de-limpeza",
    "empresa-de-limpeza-em-taubate-sp",
    "indicadores-de-limpeza-que-toda-empresa-deve-acompanhar",
    "como-criar-um-plano-de-negocios-para-uma-empresa-de-limpeza",
    "inteligencia-artificial-limpeza-profissional-facilities",
]

LINKS = {
    "cleaning_trends": {
        "slug": "10-tendencias-e-inovacoes-no-setor-de-limpeza",
        "anchor": "tendencias e inovacoes no setor de limpeza",
        "note": "acompanhe tecnologias, processos e mudancas que impactam a limpeza profissional.",
    },
    "taubate_company": {
        "slug": "empresa-de-limpeza-em-taubate-sp",
        "anchor": "empresa de limpeza em Taubate",
        "note": "veja criterios para contratar servicos de limpeza na cidade.",
    },
    "cleaning_business_plan": {
        "slug": "como-criar-um-plano-de-negocios-para-uma-empresa-de-limpeza",
        "anchor": "plano de negocios para empresa de limpeza",
        "note": "organize mercado, operacao, custos e posicionamento do servico.",
    },
    "ai_cleaning": {
        "slug": "inteligencia-artificial-limpeza-profissional-facilities",
        "anchor": "inteligencia artificial na limpeza profissional",
        "note": "entenda como a IA melhora controle, produtividade e previsao de demandas.",
    },
    "cleaning_indicators_main": {
        "slug": "indicadores-de-limpeza-que-toda-empresa-deve-acompanhar",
        "anchor": "indicadores de limpeza",
        "note": "veja quais metricas acompanhar para manter padrao e eficiencia.",
    },
    "cleaning_indicators_predial": {
        "slug": "indicadores-limpeza-predial-avaliar-resultados",
        "anchor": "indicadores de limpeza predial",
        "note": "acompanhe resultados por checklist, retrabalho e satisfacao.",
    },
    "quality_inspection": {
        "slug": "inspecao-qualidade-servicos-limpeza-roteiro",
        "anchor": "inspecao de qualidade em servicos de limpeza",
        "note": "organize auditorias praticas para validar a entrega da equipe.",
    },
    "cleaning_audit": {
        "slug": "qualidade-limpeza-diferenca-inspecao-auditoria",
        "anchor": "qualidade de limpeza",
        "note": "compare inspecao de rotina e auditoria de desempenho.",
    },
    "facilities_report": {
        "slug": "relatorio-mensal-facilities-informacoes-gestao",
        "anchor": "relatorio mensal de facilities",
        "note": "transforme dados da operacao em acompanhamento gerencial.",
    },
    "digital_checklists": {
        "slug": "checklists-digitais-equipes-facilities",
        "anchor": "checklists digitais para equipes de facilities",
        "note": "padronize execucao e registro das atividades em campo.",
    },
    "facilities_innovation": {
        "slug": "inovacao-facilities-tecnologias-gestao-predial",
        "anchor": "inovacao em facilities",
        "note": "conheca tecnologias que estao transformando a gestao predial.",
    },
    "facilities_technology": {
        "slug": "tecnologia-facilities-avaliar-ferramentas-gestao",
        "anchor": "tecnologia em facilities",
        "note": "avalie ferramentas de gestao antes de implantar na operacao.",
    },
    "taubate_services": {
        "slug": "portaria-limpeza-taubate-planejamento-servicos",
        "anchor": "portaria e limpeza em Taubate",
        "note": "planeje servicos terceirizados com foco na realidade regional.",
    },
    "sjc_cleaning": {
        "slug": "selecionar-empresa-limpeza-sao-jose-dos-campos",
        "anchor": "como selecionar uma empresa de limpeza",
        "note": "compare estrutura, escopo, documentos e capacidade de atendimento.",
    },
    "cleaning_contract": {
        "slug": "contrato-limpeza-terceirizada-clausulas-responsabilidades",
        "anchor": "contrato de limpeza terceirizada",
        "note": "confira clausulas essenciais, responsabilidades e criterios de aceite.",
    },
    "cleaning_responsibilities": {
        "slug": "terceirizacao-limpeza-responsabilidades-contratante-prestadora",
        "anchor": "responsabilidades na terceirizacao de limpeza",
        "note": "entenda limites de atuacao entre contratante e prestadora.",
    },
    "proposal_cleaning": {
        "slug": "avaliar-proposta-limpeza-terceirizada",
        "anchor": "como avaliar proposta de limpeza terceirizada",
        "note": "compare preco, escopo, equipe, insumos e supervisao.",
    },
    "cleaning_contract_old": {
        "slug": "contrato-prestacao-servicos-limpeza-clausulas-essenciais",
        "anchor": "contrato de prestacao de servicos de limpeza",
        "note": "veja pontos indispensaveis para contratar com mais seguranca.",
    },
    "cleaning_team_size": {
        "slug": "dimensionamento-equipe-limpeza-fatores-planejamento",
        "anchor": "dimensionamento de equipe de limpeza",
        "note": "calcule postos e rotinas conforme area, fluxo e frequencia.",
    },
    "cleaning_terms": {
        "slug": "termo-referencia-servicos-limpeza-elaborar",
        "anchor": "termo de referencia para servicos de limpeza",
        "note": "estruture requisitos antes de pedir orcamentos.",
    },
    "own_vs_outsource_cleaning": {
        "slug": "terceirizar-limpeza-ou-contratar-equipe-propria",
        "anchor": "terceirizar limpeza ou contratar equipe propria",
        "note": "compare custos, riscos e controle operacional.",
    },
    "sustainable_cleaning": {
        "slug": "limpeza-sustentavel-empresas-praticas-higiene",
        "anchor": "limpeza sustentavel em empresas",
        "note": "reduza desperdicios sem comprometer a higiene.",
    },
    "portaria_outsource": {
        "slug": "terceirizacao-portaria-sindicos-gestores-2025",
        "anchor": "terceirizacao de portaria",
        "note": "entenda custos, riscos e pontos de controle do contrato.",
    },
    "access_control": {
        "slug": "controle-acesso-condominios-tecnologias-2025",
        "anchor": "controle de acesso em condominios",
        "note": "veja tecnologias e boas praticas para seguranca operacional.",
    },
    "facilities_sla": {
        "slug": "sla-contratos-facilities-niveis-servico-mensuraveis",
        "anchor": "SLA em contratos de facilities",
        "note": "defina niveis de servico objetivos para medir a prestadora.",
    },
    "facilities_kpis": {
        "slug": "indicadores-facilities-kpis-qualidade-servicos",
        "anchor": "indicadores de facilities",
        "note": "monitore qualidade, prazos, ocorrencias e satisfacao.",
    },
}

TARGET_LINKS = {
    "10-tendencias-e-inovacoes-no-setor-de-limpeza": [
        "ai_cleaning",
        "cleaning_indicators_main",
        "facilities_innovation",
        "facilities_technology",
        "sustainable_cleaning",
    ],
    "empresa-de-limpeza-em-taubate-sp": [
        "taubate_services",
        "cleaning_business_plan",
        "cleaning_indicators_main",
        "cleaning_trends",
        "sjc_cleaning",
        "cleaning_contract",
        "cleaning_responsibilities",
        "proposal_cleaning",
    ],
    "indicadores-de-limpeza-que-toda-empresa-deve-acompanhar": [
        "ai_cleaning",
        "cleaning_trends",
        "cleaning_business_plan",
        "cleaning_indicators_predial",
        "quality_inspection",
        "cleaning_audit",
        "facilities_report",
        "digital_checklists",
    ],
    "como-criar-um-plano-de-negocios-para-uma-empresa-de-limpeza": [
        "taubate_company",
        "cleaning_indicators_main",
        "cleaning_trends",
        "proposal_cleaning",
        "cleaning_contract_old",
        "cleaning_team_size",
        "cleaning_terms",
        "own_vs_outsource_cleaning",
    ],
    "inteligencia-artificial-limpeza-profissional-facilities": [
        "cleaning_trends",
        "cleaning_indicators_main",
        "cleaning_business_plan",
        "facilities_technology",
        "digital_checklists",
        "facilities_innovation",
        "sustainable_cleaning",
    ],
}

TOPIC_LINKS = [
    (("taubate",), ["taubate_services", "cleaning_contract", "cleaning_indicators_predial"]),
    (("limpeza", "higiene", "sanitario", "vidro", "piso", "carpete"), ["cleaning_indicators_predial", "quality_inspection", "cleaning_contract"]),
    (("portaria", "porteiro", "acesso", "condominio"), ["portaria_outsource", "access_control", "facilities_sla"]),
    (("recepcao", "atendimento", "visitante"), ["facilities_kpis", "facilities_sla", "digital_checklists"]),
    (("facilities", "contrato", "prestadora", "terceirizacao"), ["facilities_kpis", "facilities_sla", "facilities_report"]),
    (("tecnologia", "digital", "ia", "inovacao"), ["facilities_technology", "digital_checklists", "cleaning_indicators_main"]),
]

FALLBACK_LINKS = ["facilities_kpis", "facilities_sla", "facilities_report"]
PUBLISHED_FALLBACK_LINKS = [
    "cleaning_trends",
    "ai_cleaning",
    "cleaning_indicators_main",
    "cleaning_business_plan",
    "taubate_company",
]


def get_auth_header(user: str, app_pass: str) -> str:
    app_pass = "".join(app_pass.split())
    token = b64encode(f"{user}:{app_pass}".encode()).decode()
    return f"Basic {token}"


def curl_json(method: str, url: str, auth: str, payload: dict | None = None):
    cmd = [
        "curl",
        "-s",
        "-X",
        method,
        url,
        "-H",
        f"Authorization: {auth}",
        "-H",
        "Accept: application/json",
        "-w",
        "\n%{http_code}",
    ]
    if payload is not None:
        cmd.extend(["-H", "Content-Type: application/json", "-d", json.dumps(payload)])
    last_error = None
    for attempt in range(1, 4):
        result = subprocess.run(cmd, capture_output=True, text=True, timeout=60)
        if result.returncode != 0:
            message = (result.stderr + result.stdout).strip()
            last_error = message[:500] or f"curl retornou codigo {result.returncode}"
        else:
            raw = result.stdout.strip()
            if not raw:
                return None
            body, _, status = raw.rpartition("\n")
            status_code = int(status) if status.isdigit() else 0
            if 200 <= status_code < 300:
                return json.loads(body) if body.strip() else None
            summary = body.strip().replace("\n", " ")[:500]
            last_error = f"HTTP {status_code}: {summary}"
            if status_code not in {500, 502, 503, 504, 522, 524}:
                break
        if attempt < 3:
            time.sleep(15 * attempt)
    raise RuntimeError(last_error or "Erro desconhecido na requisicao")


def list_posts(auth: str, status: str = "any") -> list[dict]:
    posts = []
    page = 1
    per_page = 20 if status == "publish" else 100
    while True:
        query = urlencode(
            {
                "status": status,
                "context": "edit",
                "per_page": per_page,
                "page": page,
                "_fields": "id,slug,status,title,link,date,content",
            }
        )
        batch = curl_json("GET", f"{BASE_URL}/posts?{query}", auth)
        if not isinstance(batch, list):
            raise RuntimeError("Resposta inesperada ao listar posts")
        posts.extend(batch)
        if len(batch) < per_page:
            return posts
        page += 1


def title_text(post: dict) -> str:
    return unescape(post.get("title", {}).get("rendered", "")).strip()


def post_content(post: dict) -> str:
    content = post.get("content", {})
    return content.get("raw") or content.get("rendered") or ""


def link_url(slug: str) -> str:
    return f"{SITE_URL}/{slug}/"


def build_block(link_keys: list[str], current_slug: str) -> str:
    seen = set()
    items = []
    for key in link_keys:
        link = LINKS[key]
        slug = link["slug"]
        if slug == current_slug or slug in seen:
            continue
        seen.add(slug)
        items.append(
            "<li><a href=\"{url}\">{anchor}</a>: {note}</li>".format(
                url=link_url(slug),
                anchor=link["anchor"],
                note=link["note"],
            )
        )
    if not items:
        return ""
    return "\n".join(
        [
            MARKER_START,
            '<!-- wp:group {"className":"rmf-internal-links"} -->',
            '<div class="wp-block-group rmf-internal-links">',
            '<!-- wp:heading -->',
            "<h2>Leia tambem</h2>",
            "<!-- /wp:heading -->",
            "<!-- wp:list -->",
            "<ul>",
            *items,
            "</ul>",
            "<!-- /wp:list -->",
            "</div>",
            "<!-- /wp:group -->",
            MARKER_END,
        ]
    )


def strip_existing_block(content: str) -> str:
    pattern = re.compile(
        rf"\s*{re.escape(MARKER_START)}.*?{re.escape(MARKER_END)}\s*",
        flags=re.DOTALL,
    )
    return pattern.sub("\n\n", content).strip()


def insertion_index(content: str) -> int:
    patterns = [
        r"<!-- wp:heading[^>]*-->\s*<h2[^>]*>Perguntas frequentes",
        r"<!-- wp:heading[^>]*-->\s*<h2[^>]*>Considera[cç][oõ]es finais",
        r"<h2[^>]*>Perguntas frequentes",
        r"<h2[^>]*>Considera[cç][oõ]es finais",
    ]
    for pattern in patterns:
        match = re.search(pattern, content, flags=re.IGNORECASE)
        if match:
            return match.start()
    return len(content)


def insert_block(content: str, block: str) -> str:
    cleaned = strip_existing_block(content)
    index = insertion_index(cleaned)
    before = cleaned[:index].rstrip()
    after = cleaned[index:].lstrip()
    if after:
        return f"{before}\n\n{block}\n\n{after}"
    return f"{before}\n\n{block}".strip()


def links_for_post(post: dict) -> list[str]:
    slug = post.get("slug", "")
    if slug in TARGET_LINKS:
        return TARGET_LINKS[slug]

    haystack = f"{slug} {title_text(post)}".lower()
    selected = []
    for keywords, keys in TOPIC_LINKS:
        if any(keyword in haystack for keyword in keywords):
            selected.extend(keys)
    selected.extend(FALLBACK_LINKS)

    result = []
    for key in selected:
        if key not in result and LINKS[key]["slug"] != slug:
            result.append(key)
        if len(result) >= 4:
            break
    return result


def available_link_keys(keys: list[str], post: dict, statuses: dict[str, str]) -> list[str]:
    source_status = post.get("status")
    current_slug = post.get("slug", "")
    candidates = list(keys)
    if source_status == "publish":
        candidates.extend(PUBLISHED_FALLBACK_LINKS)
    else:
        candidates.extend(FALLBACK_LINKS)

    result = []
    for key in candidates:
        if key in result:
            continue
        slug = LINKS[key]["slug"]
        target_status = statuses.get(slug)
        if slug == current_slug or target_status is None:
            continue
        if source_status == "publish" and target_status != "publish":
            continue
        result.append(key)
        if len(result) >= 5:
            break
    return result


def filter_posts(posts: list[dict], include_future: bool, include_published: bool) -> list[dict]:
    selected = [post for post in posts if post.get("slug") in TARGET_SLUGS]
    if include_published:
        target_ids = {post["id"] for post in selected}
        selected.extend(
            post
            for post in posts
            if post.get("status") == "publish" and post.get("id") not in target_ids
        )
    if include_future:
        target_ids = {post["id"] for post in selected}
        selected.extend(
            post
            for post in posts
            if post.get("status") == "future" and post.get("id") not in target_ids
        )
    return selected


def main() -> int:
    parser = argparse.ArgumentParser(description="Insere links internos em posts do WordPress")
    parser.add_argument("--user", required=True, help="Username do WordPress")
    parser.add_argument("--app-pass", help="Application Password")
    parser.add_argument("--apply", action="store_true", help="Grava alteracoes no WordPress")
    parser.add_argument("--dry-run", action="store_true", help="Mostra o que seria alterado")
    parser.add_argument("--include-future", action="store_true", default=True, help="Inclui posts agendados")
    parser.add_argument("--include-published", action="store_true", help="Inclui todos os posts publicados")
    parser.add_argument("--skip-future", action="store_true", help="Nao inclui posts agendados")
    parser.add_argument("--targets-only", action="store_true", help="Edita somente os 5 posts informados")
    parser.add_argument("--limit", type=int, help="Limita a quantidade de posts atualizados")
    parser.add_argument("--quiet", action="store_true", help="Mostra apenas resumo e erros")
    parser.add_argument("--delay", type=float, default=0, help="Pausa em segundos entre atualizacoes")
    args = parser.parse_args()

    if args.apply == args.dry_run:
        parser.error("Use exatamente uma opcao: --dry-run ou --apply")

    app_pass = args.app_pass or getpass.getpass("Application Password do WordPress: ")
    auth = get_auth_header(args.user, app_pass)

    print("Verificando autenticacao...")
    me = curl_json("GET", f"{BASE_URL}/users/me", auth)
    print(f"  Autenticado como: {me.get('name', me.get('slug', '?'))}")

    only_published = args.include_published and args.skip_future and not args.targets_only
    if only_published:
        print("Buscando posts publicados...")
        posts = list_posts(auth, "publish")
    else:
        print("Buscando posts publicados e agendados...")
        posts = list_posts(auth, "any")
    statuses = {post.get("slug"): post.get("status") for post in posts}
    selected = filter_posts(
        posts,
        include_future=not args.targets_only and args.include_future and not args.skip_future,
        include_published=not args.targets_only and args.include_published,
    )
    if args.limit:
        selected = selected[: args.limit]

    if not selected:
        print("Nenhum post encontrado para atualizar.")
        return 0

    changed = 0
    for post in selected:
        content = post_content(post)
        link_keys = available_link_keys(links_for_post(post), post, statuses)
        block = build_block(link_keys, post["slug"])
        if not content or not block:
            print(f"  - ignorado: {post.get('slug')} (sem conteudo ou links)")
            continue

        updated = insert_block(content, block)
        if updated == content:
            if not args.quiet:
                print(f"  - sem mudanca: {post.get('slug')}")
            continue

        changed += 1
        label = f"{post.get('status')} | {post.get('slug')} | {title_text(post)}"
        if args.dry_run:
            if not args.quiet:
                print(f"  ~ alteraria: {label}")
            continue

        curl_json("POST", f"{BASE_URL}/posts/{post['id']}", auth, {"content": updated})
        if not args.quiet:
            print(f"  ✓ atualizado: {label}")
        if args.delay:
            time.sleep(args.delay)

    mode = "alterados" if args.apply else "previstos"
    print(f"\nConcluido: {changed} posts {mode}.")
    return 0


if __name__ == "__main__":
    try:
        raise SystemExit(main())
    except (RuntimeError, ValueError, KeyError, TypeError) as exc:
        print(f"Erro: {exc}", file=sys.stderr)
        raise SystemExit(1)
