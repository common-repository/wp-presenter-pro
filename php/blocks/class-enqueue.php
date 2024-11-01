<?php
/**
 * Enqueue necessary scripts and styles.
 *
 * @package   WP_Presenter_Pro
 */

namespace WP_Presenter_Pro\Blocks;

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
		add_action( 'enqueue_block_assets', array( $this, 'frontend_css' ) );
		add_action( 'enqueue_block_editor_assets', array( $this, 'block_js' ) );
	}

	/**
	 * Enqueue the block JS.
	 */
	public function block_js() {

		if ( 'wppp' !== get_post_type() ) {
			return;
		}

		// Get Intermedia Image Sizes for use in components.
		$intermediate_sizes = get_intermediate_image_sizes();
		$js_format_sizes    = array();
		foreach ( $intermediate_sizes as $size ) {
			$js_format_sizes[ $size ] = $size;
		}
		$js_format_sizes['full'] = 'Full';

		// Scripts.
		wp_enqueue_script(
			'wp-presenter-pro-js',
			WP_PRESENTER_PRO_URL . 'dist/blocks.build.js',
			array( 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor', 'wp-plugins', 'wp-edit-post', 'wp-data' ),
			WP_PRESENTER_PRO_VERSION,
			true
		);
		$pro_fonts = array(
			'bubblebum'       => _x( 'Bubblegum', 'Font Name', 'wp-presenter-pro' ),
			'dosis'           => _x( 'Dosis', 'Font Name', 'wp-presenter-pro' ),
			'encode'          => _x( 'Encode', 'Font Name', 'wp-presenter-pro' ),
			'lato'            => _x( 'Lato', 'Font Name', 'wp-presenter-pro' ),
			'league'          => _x( 'League', 'Font Name', 'wp-presenter-pro' ),
			'merriweather'    => _x( 'Merriweather', 'Font Name', 'wp-presenter-pro' ),
			'montserrat'      => _x( 'Monstserrat', 'Font Name', 'wp-presenter-pro' ),
			'news-cycle'      => _x( 'News Cycle', 'Font Name', 'wp-presenter-pro' ),
			'open-sans'       => _x( 'Libre Baskerville', 'Font Name', 'wp-presenter-pro' ),
			'quicksand'       => _x( 'Quicksand', 'Font Name', 'wp-presenter-pro' ),
			'sinkins-sans'    => _x( 'Sinkins Sans', 'Font Name', 'wp-presenter-pro' ),
			'source-sans-pro' => _x( 'Source Sans Pro', 'Font Name', 'wp-presenter-pro' ),
			'ubuntu'          => _x( 'Ubuntu', 'Font Name', 'wp-presenter-pro' ),
		);

		// Add Typekit Fonts.
		if ( defined( 'CUSTOM_TYPEKIT_FONTS_FILE' ) ) {
			$fonts = get_option( 'custom-typekit-fonts', array() );
			if ( isset( $fonts['custom-typekit-font-details'] ) ) {
				foreach ( $fonts['custom-typekit-font-details'] as $font_name => $font_details ) {
					$pro_fonts[ $font_details['slug'] ] = $font_details['family'];
				}
			}
		}

		// Allowing others to add fonts.
		$pro_fonts = apply_filters( 'wp_presenter_pro_fonts', $pro_fonts );

		// Allow others to add blocks.
		$allowed_blocks = array(
			'core/image',
			'core/cover',
			'core/quote',
			'wppp/content',
			'wppp/content-image',
			'wppp/spacer',
			'wppp/text-box',
			'wppp/slide-title',
			'wppp/transition',
			'wppp/code',
			'wppp/html',
			'wppp/list-item',
			'wppp/image',
			'wppp/content-two-columns',
			'wppp/blockquote',
			'wppp/ordered-list',
			'wppp/button',
			'wppp/dual-buttons',
			'coblocks/alert',
			'coblocks/click-to-tweet',
			'coblocks/dynamic-separator',
			'coblocks/gif',
			'coblocks/share',
			'coblocks/icon',
			'coblocks/gists',
			'coblock/features',
			'atomic-blocks/ab-columns',
			'atomic-blocks/ab-spacer',
			'atomic-blocks/ab-cta',
			'atomic-blocks/ab-sharing',
			'atomic-blocks/ab-pricing-table',
			'atomic-blocks/ab-pricing-table-title',
			'atomic-blocks/ab-pricing-table-price',
			'atomic-blocks/ab-pricing-table-button',
			'atomic-blocks/ab-pricing-table-features',
			'atomic-blocks/ab-notice',
			'atomic-blocks/ab-button',
			'atomic-blocks/ab-testimonial',
			'atomic-blocks/atomic-blocks/ab-columns',
			'uagb/advanced-heading',
			'uagb/buttons',
			'uagb/info-box',
			'uagb/testimonial',
			'uagb/team',
			'uagb/social-share',
			'uagb/google-map',
			'uagb/icon-list',
			'uagb/call-to-action',
			'uagb/cf7-styler',
			'uagb/gf-styler',
			'uagb/blockquote',
			'uagb/marketing-button',
			'uagb/section',
		);
		$allowed_blocks = apply_filters( 'wp_presenter_pro_allowed_blocks', $allowed_blocks );
		$options        = wp_presenter_pro()->admin_options->get_options();
		wp_localize_script(
			'wp-presenter-pro-js',
			'wp_presenter_pro',
			array(
				'rest_url'          => get_rest_url(),
				'rest_nonce'        => wp_create_nonce( 'wp_rest' ),
				'image_sizes'       => $js_format_sizes,
				'mathjax'           => WP_PRESENTER_PRO_URL . 'js/mathjax.js',
				'fonts'             => $pro_fonts,
				'allowed_blocks'    => $allowed_blocks,
				'block_options'     => $options['blocks'],
				'list_item_preview' => WP_PRESENTER_PRO_URL . 'images/list-item-preview.jpg',
				'slide_preview'     => WP_PRESENTER_PRO_URL . 'images/slide-preview.jpg',
			)
		);
		wp_set_script_translations( 'wp-presenter-pro-js', 'wp-presenter-pro' );

		// Styles.
		wp_enqueue_style(
			'wp-presenter-pro-editor', // Handle.
			WP_PRESENTER_PRO_URL . 'dist/blocks.editor.build.css',
			array(),
			WP_PRESENTER_PRO_VERSION,
			'all'
		);
	}

	/**
	 * Enqueue the front-end CSS.
	 */
	public function frontend_css() {
		if ( 'wppp' !== get_post_type() ) {
			return;
		}
		wp_enqueue_style(
			'wp-presenter-pro-front-end-css', // Handle.
			WP_PRESENTER_PRO_URL . 'dist/blocks.style.build.css',
			array( 'wp-editor' ),
			WP_PRESENTER_PRO_VERSION,
			'all'
		);
	}
}
