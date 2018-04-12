<?php
/**
 * AMP Travel blocks class.
 *
 * @package WPAMPTheme
 */

/**
 * Class AMP_Travel_Blocks.
 *
 * @package WPAMPTheme
 */
class AMP_Travel_Blocks {

	/**
	 * Init Travel Blocks.
	 */
	public function init() {
		if ( function_exists( 'gutenberg_init' ) ) {
			add_action( 'enqueue_block_editor_assets', array( $this, 'enqueue_editor_scripts' ) );
			add_filter( 'the_content', array( $this, 'filter_the_content_amp_atts' ), 10, 1 );
			add_filter( 'wp_kses_allowed_html', array( $this, 'filter_wp_kses_allowed_html' ), 10, 2 );
			add_filter( 'rest_pre_echo_response', array( $this, 'filter_rest_pre_echo_response' ), 10, 3 );
			add_action( 'pre_get_posts', array( $this, 'filter_pre_get_posts' ), 10, 1 );
		}
	}

	/**
	 * Filters search to search adventures by from and to date.
	 *
	 * @param WP_Query $query Query.
	 */
	public function filter_pre_get_posts( $query ) {

		if ( ! is_admin() && is_search() ) {
			$meta_query  = array();
			$start_query = array();
			$end_query   = array();

			if ( ! empty( $_GET['start'] ) && ! empty( $_GET['end'] ) ) {
				$start       = esc_attr( $_GET['start'] );
				$end         = esc_attr( $_GET['end'] );
				$start_query = array(
					'relation' => 'OR',
					array(
						'relation' => 'AND',
						array(
							'relation' => 'OR',
							array(
								'key'     => 'amp_travel_end_date',
								'value'   => $start,
								'compare' => '>=',
							),
							array(
								'key'     => 'amp_travel_end_date',
								'value'   => '',
								'compare' => '=',
							),
						),
						array(
							'key'     => 'amp_travel_start_date',
							'value'   => $end,
							'compare' => '<=',
						),
					),
					array(
						'relation' => 'AND',
						array(
							'key'     => 'amp_travel_start_date',
							'value'   => '',
							'compare' => '=',
						),
						array(
							'key'     => 'amp_travel_end_date',
							'value'   => $start,
							'compare' => '>=',
						),
					),
				);

				// If we only have start date, only the end date is relevant.
			} elseif ( ! empty( $_GET['start'] ) ) {
				$start       = esc_attr( $_GET['start'] );
				$start_query = array(
					'relation' => 'OR',
					array(
						'key'     => 'amp_travel_end_date',
						'value'   => '',
						'compare' => '=',
					),
					array(
						'key'     => 'amp_travel_end_date',
						'value'   => $start,
						'compare' => '>=',
					),
				);
			} elseif ( ! empty( $_GET['end'] ) ) {
				$end       = esc_attr( $_GET['end'] );
				$end_query = array(
					'relation' => 'OR',
					array(
						'relation' => 'AND',
						array(
							'relation' => 'OR',
							array(
								'key'     => 'amp_travel_start_date',
								'value'   => '',
								'compare' => '=',
							),
							array(
								'key'     => 'amp_travel_end_date',
								'value'   => $end,
								'compare' => '<=',
							),
						),
						array(
							'key'     => 'amp_travel_start_date',
							'value'   => $end,
							'compare' => '<=',
						),
					),
					array(
						'relation' => 'AND',
						array(
							'key'     => 'amp_travel_end_date',
							'value'   => $end,
							'compare' => '<=',
						),
						array(
							'key'     => 'amp_travel_end_date',
							'value'   => '',
							'compare' => '!=',
						),
					),
				);
			}

			if ( ! empty( $end_query ) && ! empty( $start_query ) ) {
				$meta_query = array(
					'relation' => 'AND',
					$start_query,
					$end_query,
				);
			} elseif ( ! empty( $start_query ) ) {
				$meta_query = $start_query;
			} elseif ( ! empty( $end_query ) ) {
				$meta_query = $end_query;
			}
		}
		if ( ! empty( $meta_query ) ) {
			$query->set( 'meta_query', $meta_query );
		}
	}

	/**
	 * Filters the rest_pre_echo_response for amp-list adventures.
	 *
	 * @param array           $result  Response data to send to the client.
	 * @param WP_REST_Server  $server  Server instance.
	 * @param WP_REST_Request $request Request used to generate the response.
	 * @return array
	 */
	public function filter_rest_pre_echo_response( $result, $server, $request ) {

		// Amp-list is processing JSON in a specific way, also requires items array.
		if ( false !== strpos( $request->get_route(), 'adventures' ) ) {
			$items = array(
				'items' => array(
					array(
						'adventures' => $result,
					),
				),
			);
			return $items;
		}
		return $result;
	}

	/**
	 * Replaces data-amp-bind-* with [*].
	 * This is a workaround for React considering some AMP attributes (e.g. [src]) invalid.
	 *
	 * @param string $content Content.
	 * @return mixed
	 */
	public function filter_the_content_amp_atts( $content ) {
		return preg_replace( '/\sdata-amp-bind-(.+?)=/', ' [$1]=', $content );
	}

	/**
	 * Enqueue editor scripts.
	 */
	public function enqueue_editor_scripts() {

		// Enqueue JS bundled file.
		wp_enqueue_script(
			'travel-editor-blocks-js',
			get_template_directory_uri() . '/assets/js/editor-blocks.js',
			array( 'wp-i18n', 'wp-element', 'wp-blocks', 'wp-components', 'wp-api' )
		);

		wp_localize_script(
			'travel-editor-blocks-js',
			'travelGlobals',
			array(
				'themeUrl' => esc_url( get_template_directory_uri() ),
				'apiUrl'   => get_rest_url(),
				'siteUrl'  => site_url(),
			)
		);

		// This file's content is directly copied from the Travel theme static template.
		// @todo Use only style that's actually needed within the editor.
		wp_enqueue_style(
			'travel-editor-blocks-css',
			get_template_directory_uri() . '/assets/css/editor-blocks.css',
			array( 'wp-blocks' )
		);
	}

	/**
	 * Add the amp-specific html tags required by theme to allowed tags.
	 *
	 * @param array  $allowed_tags Allowed tags.
	 * @param string $context Context.
	 * @return array Modified tags.
	 */
	public function filter_wp_kses_allowed_html( $allowed_tags, $context ) {
		if ( 'post' === $context ) {
			$amp_tags = array(
				'amp-img'  => array_merge( $allowed_tags['img'], array(
					'attribution' => true,
					'class'       => true,
					'fallback'    => true,
					'heights'     => true,
					'media'       => true,
					'noloading'   => true,
					'on'          => true,
					'placeholder' => true,
					'srcset'      => true,
					'sizes'       => true,
					'layout'      => true,
				) ),
				'amp-list' => array(
					'class'            => true,
					'credentials'      => true,
					'placeholder'      => true,
					'noloading'        => true,
					'on'               => true,
					'items'            => true,
					'max-items'        => true,
					'single-item'      => true,
					'reset-on-refresh' => true,
					'src'              => true,
					'[src]'            => true,
					'width'            => true,
					'height'           => true,
					'layout'           => true,
					'fallback'         => true,
				),
			);

			$allowed_tags = array_merge( $allowed_tags, $amp_tags );
		}
		return $allowed_tags;
	}
}
