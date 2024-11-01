<?php
/**
 * Add HTML.
 *
 * @package   WP_Presenter_Pro
 */

namespace WP_Presenter_Pro\Blocks;

/**
 * Class HTML
 */
class HTML extends Block {

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
			'wppp/html',
			array(
				'attributes'      => array(
					'content'                 => array(
						'type'    => 'string',
						'default' => '',
					),
					'transitions'             => array(
						'type'    => 'string',
						'default' => '',
					),
					'titleCapitalization'     => array(
						'type'    => 'boolean',
						'default' => false,
					),
					'padding'                 => array(
						'type'    => 'integer',
						'default' => 0,
					),
					'radius'                  => array(
						'type'    => 'integer',
						'default' => 0,
					),
					'backgroundColor'         => array(
						'type'    => 'string',
						'default' => 'inherit',
					),
					'textColor'               => array(
						'type'    => 'string',
						'default' => '#000000',
					),
					'font'                    => array(
						'type'    => 'string',
						'default' => 'open-sans',
					),
					'fontSize'                => array(
						'type'    => 'integer',
						'default' => '64',
					),
					'transitions'             => array(
						'type'    => 'string',
						'default' => '',
					),
					'opacity'                 => array(
						'type'    => 'number',
						'default' => 1,
					),
					'backgroundGradient'      => array(
						'type'    => 'string',
						'default' => '',
					),
					'backgroundGradientHover' => array(
						'type'    => 'string',
						'default' => '',
					),
					'backgroundType'          => array(
						'type'    => 'string',
						'default' => 'background',
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
		ob_start()
		?>
		<div class="wp-presenter-pro-html-editor
		<?php
		if ( isset( $attributes['transitions'] ) && '' !== $attributes['transitions'] && 'none' !== $attributes['transitions'] ) {
			echo esc_html( $attributes['transitions'] );
			echo ' ';
			echo 'fragment';
		}
		?>
		">
		<?php add_filter( 'safe_style_css', array( $this, 'safe_css' ) ); ?>
		<?php echo wp_kses_post( $attributes['content'] ); ?>
		<?php remove_filter( 'safe_style_css', array( $this, 'safe_css' ) ); ?>
		<?php
		return ob_get_clean();
	}

	/**
	 * Adds CSS attributes for use.
	 *
	 * @param array $css Safe CSS attributes to use.
	 */
	public function safe_css( $css = array() ) {
		$args = array(
			'position',
			'display',
			'top',
			'left',
			'right',
			'bottom',
			'border',
			'padding',
			'background-image',
			'background',
			'justify-content',
			'align-items',
			'flex-wrap',
			'font',
			'font-size',
			'margin',
		);
		/**
		 * Add your own CSS attributes.
		 *
		 * @since 3.1.1
		 *
		 * @param array $args Array of safe css attributes.
		 */
		$args = apply_filters( 'wppp_html_safe_css', $args );
		return array_merge( $css, $args );
	}
}
