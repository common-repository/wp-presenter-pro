<?php
/**
 * Add a code.
 *
 * @package   WP_Presenter_Pro
 */

namespace WP_Presenter_Pro\Blocks;

/**
 * Class Code
 */
class Code extends Block {

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
			'wppp/code',
			array(
				'attributes'      => array(
					'content'         => array(
						'type'    => 'string',
						'default' => '',
					),
					'transitions'     => array(
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
					'fontSize'        => array(
						'type'    => 'integer',
						'default' => '24',
					),
					'opacity'         => array(
						'type'    => 'number',
						'default' => 1,
					),
					'align'           => array(
						'type'    => 'string',
						'default' => 'full',
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
		<div class="wp-presenter-pro-code-editor
		<?php
		if ( isset( $attributes['transitions'] ) && '' !== $attributes['transitions'] && 'none' !== $attributes['transitions'] ) {
			echo esc_html( $attributes['transitions'] );
			echo ' ';
			echo 'fragment';
		}
		$font_size = false;
		if ( isset( $attributes['fontSize'] ) ) {
			$font_size = absint( $attributes['fontSize'] );
		}
		?>
		">
<pre><code data-trim data-noescape class="hljs" style="<?php echo $font_size ? 'font-size: ' . absint( $font_size ) . 'px;' : ''; ?>">
<?php echo esc_html( $attributes['content'] ); // phpcs:ignore ?>
</code></pre>
		<?php
		return ob_get_clean();
	}
}
