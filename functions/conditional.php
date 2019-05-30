<?php
/**
 * Conditional functions.
 *
 * @package chiramise
 */

/**
 * Detect if Chiramise supports this post type.
 *
 * @param string $post_type
 *
 * @return bool
 */
function chiramise_supported( $post_type ) {
	$post_types = (array) get_option( 'chiramise_support_post_type', [] );
	return false !== array_search( $post_type, $post_types );
}

/**
 * Detect if current user can read post.
 *
 * @param null|int|WP_Post $post     Current post if not set.
 * @param null|int         $user_id  Current user if null.
 * @return bool
 */
function chiramise_can_read( $post = null, $user_id = null ) {
	$post = get_post( $post );
	if ( is_null( $user_id ) ) {
		$user_id = get_current_user_id();
	}
	if ( chiramise_always_filter() ) {
		return false;
	}
	if ( ! chiramise_supported( $post->post_type ) ) {
		return true;
	}
	if ( ! ( $user = get_userdata( $user_id ) ) ) {
		return false;
	}
	return user_can( $user, chiramise_capability( $post ), $post->ID );
}

/**
 * Check if post should be check capability
 *
 * @param null|int|WP_Post $post
 *
 * @return bool
 */
function chiramise_should_check( $post = null ) {
	$post = get_post( $post );
	if ( ! chiramise_supported( $post->post_type ) ) {
		return false;
	}
	foreach ( chiramise_get_splitters( $post ) as $splitter ) {
		if ( false !== strpos( $post->post_content, $splitter ) ) {
			return true;
		}
	}
	return false;
}


/**
 * Detect if contents should be always filtered.
 *
 * @since 1.1.0
 * @return bool
 */
function chiramise_always_filter() {
	$should_always_filter = defined( 'CHIRAMISE_ALWAYS_FILTER' ) && CHIRAMISE_ALWAYS_FILTER;
	/**
	 * Detect if always filter if user is logged-in or not.
	 *
	 * @param bool $should_always_filter
	 * @return bool
	 */
	return apply_filters( 'chiramise_always_filter', $should_always_filter );
}
