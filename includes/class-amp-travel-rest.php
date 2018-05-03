<?php
/**
 * Class for Travel Custom Post Type Rest Controller.
 *
 * @package WPAMPTheme
 */

/**
 * Class WP_REST_Adventure_Controller
 *
 * @package WPAMPTheme
 */
class WP_REST_Adventure_Controller extends WP_REST_Posts_Controller {

	/**
	 * Retrieves a collection of adventures.
	 *
	 * @param WP_REST_Request $request Full details about the request.
	 *
	 * @return WP_REST_Response|WP_Error Response object on success, or WP_Error object on failure.
	 */
	public function get_items( $request ) {
		$items = parent::get_items( $request );
		if ( is_wp_error( $items ) ) {
			return $items;
		}

		// @todo: Perhaps this should detect if it's an amp-list or not.
		// Move items under 'items' key for amp-list to be able to use it.
		$data = array(
			'items' => array(),
		);
		if ( ! empty( $request->get_param( 'search' ) ) ) {
			$data['items'] = array(
				'adventures' => $items->get_data(),
			);
		}
		$items->set_data( $data );

		return $items;
	}
}
