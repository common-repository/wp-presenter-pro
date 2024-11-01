<?php
/**
 * Set up the REST API for getting an Avatar.
 *
 * @package   WP_Presenter_Pro
 */

namespace WP_Presenter_Pro\Rest;

/**
 * Class Admin
 */
class Rest_Get_Avatar {

	/**
	 * Initialize the Admin component.
	 */
	public function init() {

	}

	/**
	 * Register any hooks that this component needs.
	 */
	public function register_hooks() {

		// Rest API.
		add_action( 'rest_api_init', array( $this, 'register_rest' ) );
	}

	/**
	 * Registers a REST call for the avatar.
	 */
	public function register_rest() {
		register_rest_route(
			'wppp/v1',
			'/get_avatar/',
			array(
				'methods'  => 'POST',
				'callback' => array( $this, 'get_avatar' ),
			)
		);
	}

	/**
	 * Retrieves an Avatar for a user via the REST API.
	 *
	 * @param array $request Request for the avatar.
	 *
	 * @return array Avatar information.
	 */
	public function get_avatar( $request ) {
		$attachment_id = absint( isset( $request['image_id'] ) ? $request['image_id'] : 0 );
		$size          = sanitize_text_field( $request['size'] );

		// Get Image.
		$image_arr = wp_get_attachment_image_src( $attachment_id, $size );
		$image_url = $image_arr[0];

		// Begin to return.
		$return = array(
			'src' => $image_url,
		);
		return $return;
	}
}
