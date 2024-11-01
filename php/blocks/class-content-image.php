<?php
/**
 * Add a two column text box/image.
 *
 * @package   WP_Presenter_Pro
 */

namespace WP_Presenter_Pro\Blocks;

/**
 * Class Code
 */
class Content_Image extends Block {

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
			'wppp/content-image',
			array(
				'attributes'      => array(
					'content'         => array(
						'type'    => 'string',
						'default' => '',
					),
					'img'             => array(
						'type'    => 'string',
						'default' => 'http://placehold.it/250',
					),
					'transitions'     => array(
						'type'    => 'string',
						'default' => '',
					),
					'imgId'           => array(
						'type'    => 'integer',
						'default' => 0,
					),
					'imgSize'         => array(
						'type'    => 'string',
						'default' => 'full',
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
					'fontSize'        => array(
						'type'    => 'integer',
						'default' => '64',
					),
					'padding'         => array(
						'type'    => 'integer',
						'default' => 0,
					),
					'radius'          => array(
						'type'    => 'integer',
						'default' => 0,
					),
					'opacity'         => array(
						'type'    => 'number',
						'default' => 1,
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
		<div class="wp-presenter-pro-content-image
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
		" style="color: <?php echo isset( $attributes['textColor'] ) ? esc_html( $attributes['textColor'] ) : 'inherit'; ?>; background-color: <?php echo esc_html( $background_color ); ?>; padding: <?php echo isset( $attributes['padding'] ) ? absint( $attributes['padding'] ) . 'px' : '0px'; ?>; border-radius: <?php echo isset( $attributes['radius'] ) ? absint( $attributes['radius'] ) . 'px' : '0px'; ?>;
		font-family: <?php echo isset( $attributes['font'] ) ? esc_html( $attributes['font'] ) : esc_html( $this->font_family ); ?>; font-size: <?php echo isset( $attributes['fontSize'] ) ? absint( $attributes['fontSize'] ) . 'px' : absint( $this->sub_title_font_size ) . 'px'; ?>">
			<div class="col-1 text">
				<?php echo wp_kses_post( $attributes['content'] ); ?>
			</div>
			<div class="col-2 image">
			<?php
				echo wp_get_attachment_image( $attributes['imgId'], $attributes['imgSize'] );
			?>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}
}
