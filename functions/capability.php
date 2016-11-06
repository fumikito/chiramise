<?php


/**
 * Get capability for chiramise content
 *
 * @param null|int|WP_Post $post
 *
 * @return string
 */
function chiramise_capability( $post = null ) {
	$post = get_post( $post );
	/**
	 * Change capability for chiramise content.
	 *
	 * @filter chiramise_capability
	 * @param string  $capability Default 'read'
	 * @param WP_Post $post
	 */
	$capability = apply_filters( 'chiramise_capability', 'read', $post );
	return $capability;
}
