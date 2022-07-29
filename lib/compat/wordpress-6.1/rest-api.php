<?php
/**
 * Overrides Core's wp-includes/rest-api.php and registers the new endpoint for WP 6.0.
 *
 * @package gutenberg
 */

/**
 * Update `wp_template` and `wp_template-part` post types to use
 * Gutenberg's REST controller.
 *
 * @param array  $args Array of arguments for registering a post type.
 * @param string $post_type Post type key.
 */
function gutenberg_update_templates_template_parts_rest_controller( $args, $post_type ) {
	if ( in_array( $post_type, array( 'wp_template', 'wp_template-part' ), true ) ) {
		$args['rest_controller_class'] = 'Gutenberg_REST_Templates_Controller';
	}
	return $args;
}
add_filter( 'register_post_type_args', 'gutenberg_update_templates_template_parts_rest_controller', 10, 2 );


/**
 * Add the post type's `icon`(menu_icon) in the response.
 * When we backport this change we will need to add the
 * `icon` to WP_REST_Post_Types_Controller schema.
 *
 * @param WP_REST_Response $response  The response object.
 * @param WP_Post_Type     $post_type The original post type object.
 */
function gutenberg_update_post_types_rest_response( $response, $post_type ) {
	$response->data['icon'] = $post_type->menu_icon;
	return $response;
}
add_filter( 'rest_prepare_post_type', 'gutenberg_update_post_types_rest_response', 10, 2 );

/**
 * Registers the block patterns REST API routes.
 */
function gutenberg_register_gutenberg_rest_block_patterns() {
	$block_patterns = new Gutenberg_REST_Block_Patterns_Controller();
	$block_patterns->register_routes();
}
add_action( 'rest_api_init', 'gutenberg_register_gutenberg_rest_block_patterns', 100 );



function gutenberg_update_navigation_rest_controller( $args, $post_type ) {
	if ( in_array( $post_type, array( 'wp_navigation' ), true ) ) {
		// Original set in
		// https://github.com/WordPress/wordpress-develop/blob/6cbed78c94b9d8c6a9b4c8b472b88ee0cd56528c/src/wp-includes/post.php#L528.
		$args['rest_controller_class'] = 'Gutenberg_REST_Navigation_Controller';
	}
	return $args;
}
add_filter( 'register_post_type_args', 'gutenberg_update_navigation_rest_controller', 10, 2 );




/**
 * Modify `id` in post schema for `wp_navigation` posts (only) to conform
 * to string-based slug identifier.
 *
 * @param array $schema the post schema data.
 * @return array the filtered post schema data.
 */
function gutenberg_update_navigation_rest_schema( $schema ) {

	$schema['properties']['id']['type']        = 'string';
	$schema['properties']['id']['description'] = __( 'The slug identifier for a Navigation', 'gutenberg' );

	return $schema;
}
add_filter( 'rest_wp_navigation_item_schema', 'gutenberg_update_navigation_rest_schema', 10, 1 );
