<?php
/**
 * Add a slide block.
 *
 * @package   WP_Presenter_Pro
 */

namespace WP_Presenter_Pro\Blocks;

/**
 * Class Admin
 */
class Slide_Title extends Block {

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
			'wppp/slide-title',
			array(
				'attributes'      => array(
					'title'               => array(
						'type'    => 'string',
						'default' => '',
					),
					'titleCapitalization' => array(
						'type'    => 'boolean',
						'default' => false,
					),
					'padding'             => array(
						'type'    => 'integer',
						'default' => 0,
					),
					'radius'              => array(
						'type'    => 'integer',
						'default' => 0,
					),
					'backgroundColor'     => array(
						'type'    => 'string',
						'default' => 'inherit',
					),
					'textColor'           => array(
						'type'    => 'string',
						'default' => '#000000',
					),
					'font'                => array(
						'type'    => 'string',
						'default' => 'open-sans',
					),
					'fontSize'            => array(
						'type'    => 'integer',
						'default' => '64',
					),
					'transitions'         => array(
						'type'    => 'string',
						'default' => '',
					),
					'opacity'             => array(
						'type'    => 'number',
						'default' => 1,
					),
					'slideTitleAlign'     => array(
						'type'    => 'string',
						'default' => 'center',
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
		<div class="wp-presenter-pro-slide-title
		<?php
		if ( isset( $attributes['slideTitleAlign'] ) ) {
			echo esc_html( ' ' . $attributes['slideTitleAlign'] . ' ' );
		}
		if ( isset( $attributes['transitions'] ) && '' !== $attributes['transitions'] && 'none' !== $attributes['transitions'] ) {
			echo esc_html( $attributes['transitions'] );
			echo ' ';
			echo 'fragment';
		}
		if ( isset( $attributes['titleCapitalization'] ) && true === $attributes['titleCapitalization'] ) {
			echo ' slide-title-capitalized';
		}
		$background_hex     = isset( $attributes['backgroundColor'] ) ? $attributes['backgroundColor'] : 'inherit';
		$background_opacity = isset( $attributes['opacity'] ) ? $attributes['opacity'] : '1';
		if ( 'inherit' !== $background_hex ) {
			$background_color = wppp_hex2rgba( $background_hex, $background_opacity );
		} else {
			$background_color = $background_hex;
		}
		?>
		" style="color: <?php echo isset( $attributes['textColor'] ) ? esc_html( $attributes['textColor'] ) : '#000000'; ?>; background-color: <?php echo esc_html( $background_color ); ?>; border-radius: <?php echo isset( $attributes['radius'] ) ? absint( $attributes['radius'] ) . 'px' : '0px'; ?>; padding: <?php echo isset( $attributes['padding'] ) ? absint( $attributes['padding'] ) . 'px' : 0; ?>;
		font-family: <?php echo isset( $attributes['font'] ) ? esc_html( $attributes['font'] ) : esc_html( $this->font_family ); ?>; font-size: <?php echo isset( $attributes['fontSize'] ) ? absint( $attributes['fontSize'] ) . 'px' : absint( $this->title_font_size ) . 'px'; ?>">
		<?php echo wp_kses_post( $attributes['title'] ); ?>
		</div>
		<?php
		return ob_get_clean();
	}
}
