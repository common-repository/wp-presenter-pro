<?php
/**
 * Add a ordered list item block.
 *
 * @package   WP_Presenter_Pro
 */

namespace WP_Presenter_Pro\Blocks;

/**
 * Class Ordered List
 */
class Ordered_List extends Block {

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
			'wppp/ordered-list',
			array(
				'attributes'      => array(
					'content'         => array(
						'type'    => 'string',
						'default' => '',
					),
					'padding'         => array(
						'type'    => 'integer',
						'default' => 0,
					),
					'radius'          => array(
						'type'    => 'integer',
						'default' => 0,
					),
					'backgroundColor' => array(
						'type'    => 'string',
						'default' => 'inherit',
					),
					'textColor'       => array(
						'type'    => 'string',
						'default' => '#000000',
					),
					'font'            => array(
						'type'    => 'string',
						'default' => 'open-sans',
					),
					'transitions'     => array(
						'type'    => 'string',
						'default' => '',
					),
					'opacity'         => array(
						'type'    => 'number',
						'default' => 1,
					),
					'fragments'       => array(
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
		<div class="wp-presenter-pro-ordered-list
		<?php
		if ( isset( $attributes['transitions'] ) && '' !== $attributes['transitions'] && 'none' !== $attributes['transitions'] ) {
			echo esc_html( $attributes['transitions'] );
			echo ' ';
			echo 'fragment';
		}
		$background_hex     = isset( $attributes['backgroundColor'] ) ? $attributes['backgroundColor'] : 'inherit';
		$background_opacity = isset( $attributes['opacity'] ) ? $attributes['opacity'] : '1';
		if ( 'inherit' !== $background_hex ) {
			$background_color = wppp_hex2rgba( $background_hex, $background_opacity );
		} else {
			$background_color = $background_hex;
		}
		?>
		" style="color: <?php echo isset( $attributes['textColor'] ) ? esc_html( $attributes['textColor'] ) : 'inherit'; ?>; border-radius: <?php echo isset( $attributes['radius'] ) ? absint( $attributes['radius'] ) . 'px' : '0px'; ?>; background-color: <?php echo esc_html( $background_color ); ?>; padding: <?php echo isset( $attributes['padding'] ) ? absint( $attributes['padding'] ) . 'px' : 'inherit'; ?>;
		font-family: <?php echo isset( $attributes['font'] ) ? esc_html( $attributes['font'] ) : esc_html( $this->font_family ); ?>;">
		<?php
		if ( isset( $attributes['fragments'] ) && filter_var( $attributes['fragments'], FILTER_VALIDATE_BOOLEAN ) ) {
			echo '<ol>' . wp_kses_post( str_replace( '<li>', '<li class="fragment">', $attributes['content'] ) ) . '</ol>';
		} else {
			echo '<ol>' . wp_kses_post( $attributes['content'] ) . '</ol>';
		}
		?>
		</div>
		<?php
		return ob_get_clean();
	}
}
