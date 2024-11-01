<?php
/**
 * Enqueue necessary scripts and styles.
 *
 * @package   WP_Presenter_Pro
 */

namespace WP_Presenter_Pro\Admin;

/**
 * Class Admin
 */
class Enqueue {

	/**
	 * Initialize the Admin component.
	 */
	public function init() {

	}

	/**
	 * Register any hooks that this component needs.
	 */
	public function register_hooks() {
		add_action( 'admin_enqueue_scripts', array( $this, 'add_scripts' ) );
		add_action( 'wp_ajax_wppp_save_gradients', array( $this, 'ajax_save_gradients' ) );
	}

	/**
	 * Enqueue the admin JS.
	 *
	 * @param string $hook Admin hook slug.
	 */
	public function add_scripts( $hook ) {
		if ( 'wppp_page_wp-presenter-pro-options' !== $hook ) {
			return;
		}

		// Scripts.
		wp_enqueue_script(
			'wp-presenter-pro-gradients',
			WP_PRESENTER_PRO_URL . 'js/gradientselector.js',
			array( 'jquery' ),
			WP_PRESENTER_PRO_VERSION,
			true
		);
		wp_localize_script(
			'wp-presenter-pro-gradients',
			'wp_presenter_gradients',
			array(
				'saving' => __( 'Saving...', 'wp-presenter-pro' ),
				'saved'  => __( 'Saved', 'wp-presenter-pro' ),
			)
		);

		// Scripts.
		wp_enqueue_style(
			'wp-presenter-pro-gradients-css',
			WP_PRESENTER_PRO_URL . 'css/gradients.css',
			array(),
			WP_PRESENTER_PRO_VERSION,
			'all'
		);
	}

	/**
	 * Save Gradients via Ajax.
	 */
	public function ajax_save_gradients() {
		if ( ! wp_verify_nonce( $_REQUEST['nonce'], 'save_wppp_gradients' ) ) { // phpcs:ignore
			wp_send_json_error();
		}
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error();
		}

		$gradients = wp_unslash( filter_input( INPUT_POST, 'gradients', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY ) );
		if ( ! is_array( $gradients ) || empty( $gradients ) ) {
			update_option( 'wppp_gradients', array() );
			wp_send_json_error();
		}
		foreach ( $gradients as $key => &$data ) {
			$key               = sanitize_text_field( $key );
			$data['name']      = sanitize_text_field( $data['name'] );
			$data['gradient']  = sanitize_text_field( $data['gradient'] );
			$data['slug']      = $key;
			$gradients[ $key ] = $data;
		}
		update_option( 'wppp_gradients', $gradients );
		wp_send_json_success();
		die( '' );
	}
}
