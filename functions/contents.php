<?php

/**
 * Get chiramise splitter
 *
 * @param null|int|WP_Post $post
 *
 * @return mixed|void
 */
function chiramise_get_splitters( $post = null ) {
	$post = get_post( $post );
	$splitters = [
		'<!--more-->',
		'<!--nextpage-->',
	    '[Chiramise]',
	];
	/**
	 * Filter for contents splitters.
	 *
	 * @filter chiramise_splitters
	 * @param array   $splitters Default is more tag, nextpage tag, Chiramise short code.
	 * @param WP_Post $post      Post to split
	 * @return array
	 */
	return apply_filters( 'chiramise_splitters', $splitters, $post );
}

/**
 * Get segment.
 *
 * @param null|int|WP_Post $post
 *
 * @return string
 */
function chiramise_split( $post = null ) {
	$post = get_post( $post );
	$content = $post->post_content;
	$splitters = chiramise_get_splitters( $post );
	foreach ( $splitters as $splitter ) {
		$parsed  = explode( $splitter, $content );
		$content = $parsed[0];
	}
	return $content;
}

/**
 * Get content filter function
 *
 * @param null|int|WP_Post $post
 *
 * @return callable
 */
function chiramise_filter_content_function( $post = null ) {
	$post = get_post( $post );
	/**
	 * Content filter function for Chiramise
	 *
	 * @filter chiramise_default_content_filter
	 * @see chiramise_filter_content()
	 * @param callable $function Default 'chiramise_filter_content'
	 * @param WP_Post  $post
	 * @return callable
	 */
	return apply_filters( 'chiramise_default_content_filter', 'chiramise_filter_content', $post );
}

/**
 * Filter the_content
 *
 * @param string $content
 *
 * @return string
 */
function chiramise_filter_content( $content ) {
	$post = get_post();
	if ( ! chiramise_should_check( $post ) ) {
		return $content;
	}
	if ( chiramise_can_read( $post ) ) {
		return $content;
	}
	return chiramise_split( $post );
}
