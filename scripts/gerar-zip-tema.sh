#!/usr/bin/env bash
set -euo pipefail

repo_dir="$(cd -- "$(dirname -- "${BASH_SOURCE[0]}")/.." && pwd)"
theme_dir="$repo_dir/rmfacilities-onepage"
style_file="$theme_dir/style.css"
archive_file="$repo_dir/rmfacilities-onepage.zip"

if [[ ! -f "$style_file" ]]; then
	printf 'Erro: arquivo de tema nao encontrado: %s\n' "$style_file" >&2
	exit 1
fi

version="$(sed -n 's/^Version:[[:space:]]*//p' "$style_file")"
if [[ ! "$version" =~ ^([0-9]+)\.([0-9]+)\.([0-9]+)$ ]]; then
	printf 'Erro: versao SemVer X.Y.Z invalida no cabecalho de %s\n' "$style_file" >&2
	exit 1
fi

next_version="${BASH_REMATCH[1]}.${BASH_REMATCH[2]}.$((${BASH_REMATCH[3]} + 1))"
temporary_dir="$(mktemp -d)"
trap 'rm -rf -- "$temporary_dir"' EXIT

staged_theme="$temporary_dir/rmfacilities-onepage"
mkdir -p "$staged_theme"
cp -a "$theme_dir/." "$staged_theme/"

awk -v next_version="$next_version" '
	/^Version:[[:space:]]*/ {
		print "Version: " next_version
		next
	}
	{ print }
' "$style_file" > "$staged_theme/style.css"

(
	cd "$temporary_dir"
	zip -qr "$temporary_dir/rmfacilities-onepage.zip" rmfacilities-onepage \
		-x 'rmfacilities-onepage/.git*' \
		-x 'rmfacilities-onepage/.git*/*' \
		-x 'rmfacilities-onepage/node_modules/*'
)

cp "$staged_theme/style.css" "$style_file"
mv "$temporary_dir/rmfacilities-onepage.zip" "$archive_file"

printf 'Tema atualizado para a versao %s.\n' "$next_version"
printf 'Arquivo pronto para instalar: %s\n' "$archive_file"
