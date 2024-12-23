<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Load translations from the MO file.
 */
function stratum_load_textdomain() {
    load_plugin_textdomain( 'stratum', false, plugin_basename( STRATUM_PLUGIN_DIR ) . '/languages/' );
}

add_action( 'init', 'stratum_load_textdomain' );


/*
 * Retrieve post ID in current language.
 * @param int $post_id
 * @return int
 */
function stratum_translate_post( $post_id ) {

	if ( has_filter( 'wpml_object_id' ) ) {

		$post_type = get_post_type( $post_id );
		$post_id = apply_filters( 'wpml_object_id', $post_id, $post_type , TRUE  );
	}

	return $post_id;
}

/*
 * Retrieve URL in current language.
 * @param string $url
 * @return string
 */
function stratum_translate_url( $url ) {

	if ( has_filter( 'wpml_permalink' ) ) {

		$url = apply_filters( 'wpml_permalink', $url );
	}

	return $url;
}
