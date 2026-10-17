<?php
/**
 * Ajustes do Rank Math específicos da RM Facilities.
 *
 * @package RMFacilitiesOnePage
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_filter(
	'rank_math/frontend/title',
	function ( $title ) {
		return is_front_page() ? 'RM Facilities | Terceirização de serviços em São José dos Campos' : $title;
	}
);

add_filter(
	'rank_math/frontend/description',
	function ( $description ) {
		if ( ! is_front_page() ) {
			return $description;
		}

		return 'A RM Facilities oferece portaria, limpeza, jardinagem e recepção para empresas e condomínios em São José dos Campos. Solicite um orçamento.';
	}
);

/**
 * Corrige a entidade da empresa e remove o tipo Article indevido da página inicial.
 *
 * @param mixed $node Nó de dados estruturados.
 * @return mixed
 */
function rmf_clean_rank_math_schema_node( $node ) {
	if ( ! is_array( $node ) ) {
		return $node;
	}

	$types = isset( $node['@type'] ) ? (array) $node['@type'] : array();

	if ( in_array( 'Article', $types, true ) ) {
		return null;
	}

	if ( in_array( 'Person', $types, true ) && ! in_array( 'Organization', $types, true ) ) {
		return null;
	}

	if ( in_array( 'Organization', $types, true ) ) {
		$node['name'] = 'RM Facilities LTDA';

		if ( in_array( 'Person', $types, true ) ) {
			$node['@type'] = 'Organization';
			$node['@id']   = home_url( '/#organization' );
		}
	}

	if ( in_array( 'WebSite', $types, true ) ) {
		$node['name'] = 'RM Facilities LTDA';
	}

	if ( isset( $node['sameAs'] ) ) {
		$profiles = array_filter(
			(array) $node['sameAs'],
			function ( $url ) {
				if ( ! is_string( $url ) ) {
					return false;
				}

				$path = wp_parse_url( $url, PHP_URL_PATH );
				return is_string( $path ) && '' !== trim( $path, '/' );
			}
		);

		if ( $profiles ) {
			$node['sameAs'] = array_values( $profiles );
		} else {
			unset( $node['sameAs'] );
		}
	}

	foreach ( $node as $key => $value ) {
		if ( is_array( $value ) ) {
			$cleaned = rmf_clean_rank_math_schema_node( $value );

			if ( null === $cleaned ) {
				unset( $node[ $key ] );
			} else {
				$node[ $key ] = $cleaned;
			}
		} elseif ( '@id' === $key && home_url( '/#person' ) === $value ) {
			$node[ $key ] = home_url( '/#organization' );
		}
	}

	return $node;
}

/**
 * Mantém o schema do Rank Math alinhado à empresa e ao conteúdo da página inicial.
 *
 * @param mixed $data Dados estruturados do Rank Math.
 * @return mixed
 */
function rmf_filter_rank_math_json_ld( $data ) {
	if ( ! is_front_page() || ! is_array( $data ) ) {
		return $data;
	}

	foreach ( $data as $key => $value ) {
		$cleaned = rmf_clean_rank_math_schema_node( $value );

		if ( null === $cleaned ) {
			unset( $data[ $key ] );
		} else {
			$data[ $key ] = $cleaned;
		}
	}

	return $data;
}
add_filter( 'rank_math/json_ld', 'rmf_filter_rank_math_json_ld', 99 );
