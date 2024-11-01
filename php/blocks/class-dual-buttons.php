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
class Dual_Buttons extends Block {

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
			'wppp/dual-buttons',
			array(
				'attributes'      => array(
					'contentButtonOne'              => array(
						'type'    => 'string',
						'default' => 'Button 1',
					),
					'buttonUrlButtonOne'            => array(
						'type'    => 'string',
						'default' => '',
					),
					'contentButtonTwo'              => array(
						'type'    => 'string',
						'default' => 'Button 2',
					),
					'buttonUrlButtonTwo'            => array(
						'type'    => 'string',
						'default' => '',
					),
					'transitions'                   => array(
						'type'    => 'string',
						'default' => '',
					),
					'backgroundColorButtonOne'      => array(
						'type'    => 'string',
						'default' => '#cf2e2e',
					),
					'backgroundColorHoverButtonOne' => array(
						'type'    => 'string',
						'default' => '#cf2e2e',
					),
					'textColorButtonOne'            => array(
						'type'    => 'string',
						'default' => '#FFFFFF',
					),
					'textColorHoverButtonOne'       => array(
						'type'    => 'string',
						'default' => '#FFFFFF',
					),
					'backgroundColorButtonTwo'      => array(
						'type'    => 'string',
						'default' => '#cf2e2e',
					),
					'backgroundColorHoverButtonTwo' => array(
						'type'    => 'string',
						'default' => '#cf2e2e',
					),
					'textColorButtonTwo'            => array(
						'type'    => 'string',
						'default' => '#FFFFFF',
					),
					'textColorHoverButtonTwo'       => array(
						'type'    => 'string',
						'default' => '#FFFFFF',
					),
					'font'                          => array(
						'type'    => 'string',
						'default' => 'open-sans',
					),
					'fontSize'                      => array(
						'type'    => 'integer',
						'default' => '24',
					),
					'paddingLR'                     => array(
						'type'    => 'integer',
						'default' => 20,
					),
					'paddingTB'                     => array(
						'type'    => 'integer',
						'default' => 10,
					),
					'borderWidth'                   => array(
						'type'    => 'integer',
						'default' => 0,
					),
					'borderColorButtonOne'          => array(
						'type'    => 'string',
						'default' => '',
					),
					'radius'                        => array(
						'type'    => 'integer',
						'default' => 0,
					),
					'borderColorButtonTwo'          => array(
						'type'    => 'string',
						'default' => '',
					),
					'newWindow'                     => array(
						'type'    => 'boolean',
						'default' => true,
					),
					'noFollow'                      => array(
						'type'    => 'boolean',
						'default' => false,
					),
					'btnClassNameButtonOne'         => array(
						'type'    => 'string',
						'default' => 'wppp-dual-button',
					),
					'btnClassNameButtonTwo'         => array(
						'type'    => 'string',
						'default' => 'wppp-dual-button-2',
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
		?>
		<style>
			.<?php echo esc_html( $attributes['btnClassNameButtonOne'] ); ?>.wp-presenter-pro-button.button:hover {
				background-color: <?php echo esc_html( $attributes['backgroundColorHoverButtonOne'] ); ?> !important;
				color: <?php echo esc_html( $attributes['textColorHoverButtonOne'] ); ?> !important;
			}
			.<?php echo esc_html( $attributes['btnClassNameButtonTwo'] ); ?>.wp-presenter-pro-button.button:hover {
				background-color: <?php echo esc_html( $attributes['backgroundColorHoverButtonTwo'] ); ?> !important;
				color: <?php echo esc_html( $attributes['textColorHoverButtonTwo'] ); ?> !important;
			}
		</style>
		<div class="wp-presenter-pro-dual-buttons">
			<a <?php echo $target ? 'target="_blank"' : ''; ?> <?php echo $no_follow ? 'rel="nofollow"' : ''; ?> class="wp-presenter-pro-button button <?php echo esc_html( $attributes['btnClassNameButtonOne'] ); ?>
			<?php
			if ( isset( $attributes['transitions'] ) && '' !== $attributes['transitions'] && 'none' !== $attributes['transitions'] ) {
				echo esc_html( $attributes['transitions'] );
				echo ' ';
				echo 'fragment';
			}
			?>
			" style="text-decoration: none; color: <?php echo isset( $attributes['textColorButtonOne'] ) ? esc_html( $attributes['textColorButtonOne'] ) : 'inherit'; ?>;<?php echo ( isset( $attributes['backgroundColorButtonOne'] ) ) ? esc_html( 'background-color: ' . $attributes['backgroundColorButtonOne'] ) . ';' : 'inherit'; ?> padding: <?php echo absint( $attributes['paddingTB'] ) . 'px ' . absint( $attributes['paddingLR'] ) . 'px;'; ?>; border-radius: <?php echo isset( $attributes['radius'] ) ? absint( $attributes['radius'] ) . 'px' : '0px'; ?>;
			border-width: <?php echo absint( $attributes['borderWidth'] ) . 'px;'; ?>
			border-color: <?php echo esc_html( $attributes['borderColorButtonOne'] ) . ';'; ?>
			font-family: <?php echo isset( $attributes['font'] ) ? esc_html( $attributes['font'] ) : esc_html( $this->font_family ); ?>; font-size: <?php echo absint( $attributes['fontSize'] ) . 'px'; ?>" href="<?php echo esc_url( $attributes['buttonUrlButtonOne'] ); ?>">
				<?php echo wp_kses_post( $attributes['contentButtonOne'] ); ?>
			</a>
			<a <?php echo $target ? 'target="_blank"' : ''; ?> <?php echo $no_follow ? 'rel="nofollow"' : ''; ?> class="wp-presenter-pro-button button <?php echo esc_html( $attributes['btnClassNameButtonTwo'] ); ?>
			<?php
			if ( isset( $attributes['transitions'] ) && '' !== $attributes['transitions'] && 'none' !== $attributes['transitions'] ) {
				echo esc_html( $attributes['transitions'] );
				echo ' ';
				echo 'fragment';
			}
			?>
			" style="text-decoration: none; color: <?php echo isset( $attributes['textColorButtonTwo'] ) ? esc_html( $attributes['textColorButtonTwo'] ) : 'inherit'; ?>;<?php echo ( isset( $attributes['backgroundColorButtonTwo'] ) ) ? esc_html( 'background-color: ' . $attributes['backgroundColorButtonTwo'] ) . ';' : 'inherit'; ?> padding: <?php echo absint( $attributes['paddingTB'] ) . 'px ' . absint( $attributes['paddingLR'] ) . 'px;'; ?>; border-radius: <?php echo isset( $attributes['radius'] ) ? absint( $attributes['radius'] ) . 'px' : '0px'; ?>;
			border-width: <?php echo absint( $attributes['borderWidth'] ) . 'px;'; ?>
			border-color: <?php echo esc_html( $attributes['borderColorButtonTwo'] ) . ';'; ?>
			font-family: <?php echo isset( $attributes['font'] ) ? esc_html( $attributes['font'] ) : esc_html( $this->font_family ); ?>; font-size: <?php echo absint( $attributes['fontSize'] ) . 'px'; ?>" href="<?php echo esc_url( $attributes['buttonUrlButtonTwo'] ); ?>">
				<?php echo wp_kses_post( $attributes['contentButtonTwo'] ); ?>
			</a>
		</div>
		<?php
		return ob_get_clean();
	}
}
