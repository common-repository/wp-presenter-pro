<?php
/**
 * Add a button block
 *
 * @package   WP_Presenter_Pro
 */

namespace WP_Presenter_Pro\Blocks;

/**
 * Class Code
 */
class Button extends Block {

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
			'wppp/button',
			array(
				'attributes'      => array(
					'content'                 => array(
						'type'    => 'string',
						'default' => '',
					),
					'buttonUrl'               => array(
						'type'    => 'string',
						'default' => '',
					),
					'transitions'             => array(
						'type'    => 'string',
						'default' => '',
					),
					'backgroundColor'         => array(
						'type'    => 'string',
						'default' => '#cf2e2e',
					),
					'backgroundColorHover'    => array(
						'type'    => 'string',
						'default' => '#cf2e2e',
					),
					'textColor'               => array(
						'type'    => 'string',
						'default' => '#FFFFFF',
					),
					'textColorHover'          => array(
						'type'    => 'string',
						'default' => '#FFFFFF',
					),
					'font'                    => array(
						'type'    => 'string',
						'default' => 'open-sans',
					),
					'fontSize'                => array(
						'type'    => 'integer',
						'default' => '24',
					),
					'paddingLR'               => array(
						'type'    => 'integer',
						'default' => 20,
					),
					'paddingTB'               => array(
						'type'    => 'integer',
						'default' => 10,
					),
					'borderWidth'             => array(
						'type'    => 'integer',
						'default' => 0,
					),
					'borderColor'             => array(
						'type'    => 'string',
						'default' => '',
					),
					'radius'                  => array(
						'type'    => 'integer',
						'default' => 0,
					),
					'newWindow'               => array(
						'type'    => 'boolean',
						'default' => true,
					),
					'noFollow'                => array(
						'type'    => 'boolean',
						'default' => false,
					),
					'btnClassName'            => array(
						'type'    => 'string',
						'default' => 'wppp-button',
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
		$no_follow = filter_var( $attributes['noFollow'], FILTER_VALIDATE_BOOLEAN );
		$target    = filter_var( $attributes['newWindow'], FILTER_VALIDATE_BOOLEAN );
		ob_start();
		$gradient = false;
		if ( isset( $attributes['backgroundType'] ) ) {
			if ( 'gradient' === $attributes['backgroundType'] ) {
				$gradient = true;
			}
		}
		?>
		<style>
			.<?php echo esc_html( $attributes['btnClassName'] ); ?>.wp-presenter-pro-button.button:hover {
				background-color: <?php echo esc_html( $attributes['backgroundColorHover'] ); ?> !important;
				color: <?php echo esc_html( $attributes['textColorHover'] ); ?> !important;
				background-image: <?php echo isset( $attributes['backgroundGradientHover'] ) && $gradient ? esc_html( $attributes['backgroundGradientHover'] ) : 'inherit'; ?> !important;
			}
		</style>
		<a <?php echo $target ? 'target="_blank"' : ''; ?> <?php echo $no_follow ? 'rel="nofollow"' : ''; ?> class="wp-presenter-pro-button button <?php echo esc_html( $attributes['btnClassName'] ); ?>
		<?php
		if ( isset( $attributes['transitions'] ) && '' !== $attributes['transitions'] && 'none' !== $attributes['transitions'] ) {
			echo esc_html( $attributes['transitions'] );
			echo ' ';
			echo 'fragment';
		}
		?>
		" style="text-decoration: none; color: <?php echo isset( $attributes['textColor'] ) ? esc_html( $attributes['textColor'] ) : 'inherit'; ?>;<?php echo ( isset( $attributes['backgroundColor'] ) ) ? esc_html( 'background-color: ' . $attributes['backgroundColor'] ) . ';' : 'inherit'; ?> padding: <?php echo absint( $attributes['paddingTB'] ) . 'px ' . absint( $attributes['paddingLR'] ) . 'px;'; ?>; border-radius: <?php echo isset( $attributes['radius'] ) ? absint( $attributes['radius'] ) . 'px' : '0px'; ?>;
		border-style: solid;
		border-width: <?php echo absint( $attributes['borderWidth'] ) . 'px;'; ?>;
		border-color: <?php echo esc_html( $attributes['borderColor'] ) . ';'; ?>;
		background-image: <?php echo isset( $attributes['backgroundGradient'] ) && $gradient ? esc_html( $attributes['backgroundGradient'] ) : 'inherit'; ?>;
		font-family: <?php echo isset( $attributes['font'] ) ? esc_html( $attributes['font'] ) : esc_html( $this->font_family ); ?>; font-size: <?php echo absint( $attributes['fontSize'] ) . 'px'; ?>" href="<?php echo esc_url( $attributes['buttonUrl'] ); ?>">
			<?php echo wp_kses_post( $attributes['content'] ); ?>
		</a>
		<?php
		return ob_get_clean();
	}
}
