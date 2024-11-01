<?php
/**
 * Add a slide block.
 *
 * @package   WP_Presenter_Pro
 */

namespace WP_Presenter_Pro\Blocks;

/**
 * Class Slide - Find your power animal.
 */
class Vertical_Slide {

	/**
	 * Initialize the Admin component.
	 */
	public function init() {
	}

	/**
	 * Register any hooks that this component needs.
	 */
	public function register_hooks() {
		add_action( 'init', array( $this, 'register_block' ) );
	}

	/**
	 * Registers an Avatar Block.
	 */
	public function register_block() {
		if ( ! function_exists( 'register_block_type' ) ) {
			return;
		}
		register_block_type(
			'wppp/vertical-slide',
			array(
				'attributes'      => array(
					'backgroundType'         => array(
						'type'    => 'string',
						'default' => 'background',
					),
					'backgroundVideo'        => array(
						'type'    => 'string',
						'default' => '',
					),
					'backgroundImg'          => array(
						'type'    => 'string',
						'default' => '',
					),
					'backgroundImageOptions' => array(
						'type'    => 'string',
						'default' => 'cover',
					),
					'backgroundColor'        => array(
						'type'    => 'string',
						'default' => 'inherit',
					),
					'textColor'              => array(
						'type'    => 'string',
						'default' => 'inherit',
					),
					'transition'             => array(
						'type'    => 'string',
						'default' => 'slide',
					),
					'backgroundTransition'   => array(
						'type'    => 'string',
						'default' => 'none',
					),
					'iframeUrl'              => array(
						'type'    => 'string',
						'default' => '',
					),
					'speakerNotes'           => array(
						'type'    => 'string',
						'default' => '',
					),
					'backgroundGradient'     => array(
						'type'    => 'string',
						'default' => '',
					),
					'videoType'              => array(
						'type'    => 'string',
						'default' => 'url',
					),
					'muteVideo'              => array(
						'type'    => 'boolean',
						'default' => true,
					),
					'loopVideo'              => array(
						'type'    => 'boolean',
						'default' => false,
					),
					'align'                  => array(
						'type'    => 'string',
						'default' => 'full',
					),
					'preview'                => array(
						'type'    => 'boolean',
						'default' => false,
					),
				),
				'render_callback' => array( $this, 'frontend' ),
			)
		);
	}

	/**
	 * Outputs the block content on the front-end
	 *
	 * @param array $attributes Array of attributes.
	 */
	public function frontend( $attributes ) {
		if ( is_admin() ) {
			return;
		}
		ob_start();
		?>


		<?php
		return ob_get_clean();
	}
}
