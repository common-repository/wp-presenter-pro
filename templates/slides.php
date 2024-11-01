<?php
/**
 * Output slide content for single slide.
 *
 * @package   WP_Presenter_Pro
 */

wp_enqueue_script( 'wp-presenter-head-js', WP_PRESENTER_PRO_URL . '/assets/reveal/lib/js/head.min.js', array(), WP_PRESENTER_PRO_VERSION, false );
wp_enqueue_script( 'wp-presenter-classlist', WP_PRESENTER_PRO_URL . '/assets/reveal/lib/js/classList.js', array(), WP_PRESENTER_PRO_VERSION, false );
wp_enqueue_script( 'wp-presenter-core-js', WP_PRESENTER_PRO_URL . '/assets/reveal/js/reveal.js', array( 'wp-presenter-classlist' ), WP_PRESENTER_PRO_VERSION, false );
wp_enqueue_script( 'html5shiv', WP_PRESENTER_PRO_URL . '/js/html5shiv.js', array(), WP_PRESENTER_PRO_VERSION, false );
wp_enqueue_style( 'wp-presenter-core', WP_PRESENTER_PRO_URL . '/assets/reveal/css/reveal.css', array(), WP_PRESENTER_PRO_VERSION, 'all' );
wp_enqueue_style( 'wp-presenter-monokai', WP_PRESENTER_PRO_URL . '/assets/reveal/lib/css/monokai.css', array(), WP_PRESENTER_PRO_VERSION, 'all' );
wp_enqueue_style(
	'wp-presenter-pro-front-end-css', // Handle.
	WP_PRESENTER_PRO_URL . 'dist/blocks.style.build.css',
	array( 'wp-editor' ),
	WP_PRESENTER_PRO_VERSION,
	'all'
);
// Add support for the typekit plugin.
if ( class_exists( 'Custom_Typekit_Fonts_Render' ) ) {
	$typekit_instance = Custom_Typekit_Fonts_Render::get_instance();
	$typekit_instance->typekit_embed_css();
}
// Allow others to hook into the header.
do_action( 'wp_presenter_pro_slide_head' );
// Get object ID and enqueue assets.
$wppp_id     = get_queried_object_id();
$maybe_theme = get_post_meta( $wppp_id, 'slides-theme', true );
$theme       = $maybe_theme ? $maybe_theme : 'black';
wp_register_style( 'wp-presenter-display-theme', WP_PRESENTER_PRO_URL . '/assets/reveal/css/theme/' . $theme . '.css', array(), WP_PRESENTER_PRO_VERSION );

$show_admin_bar_meta   = get_post_meta( $wppp_id, 'slides-show-admin-bar', true );
$show_admin_bar_helper = '__return_false';
if ( 'true' === $show_admin_bar_meta ) {
	$show_admin_bar_helper = '__return_true';
}
add_filter( 'show_admin_bar', $show_admin_bar_helper );
?>
<?php
/**
 * The template for displaying the header.
 *
 * @package WP Presenter
 */
?>
<!DOCTYPE html>
<html lang="en" style="margin: 0 !important;">
<head>
	<meta charset="utf-8">

	<meta name="apple-mobile-web-app-capable" content="yes"/>
	<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php
	do_action( 'wp_head' );
	if ( apply_filters( 'wp_presenter_pro_display_theme', true ) ) {
		wp_print_styles( array( 'wp-presenter-display-theme' ) );
	}
	?>
	<style type="text/css">
	/* 1. Style header/footer <div> so they are positioned as desired. */
	#header-left {
		position: absolute;
		top: 0%;
		left: 0%;
		padding: 20px;
	}
	#header-right {
		position: absolute;
		top: 0%;
		right: 0%;
		padding: 20px;
	}
	#footer-left {
		position: absolute;
		bottom: 0%;
		left: 0%;
		padding: 20px;
	}
	#footer-right {
		position: absolute;
		bottom: 0%;
		right: 10%;
	}
	</style>

</head>
<body>
<div id="hidden" style="display:none;">
	<div id="header">
		<div id="header-wrapper">
			<div id="header-left"><?php echo wp_kses_post( get_post_meta( $wppp_id, 'slides-header-left', true ) ); ?></div>
			<div id="header-right"><?php echo wp_kses_post( get_post_meta( $wppp_id, 'slides-header-right', true ) ); ?></div>
			<div id="footer-left"><?php echo wp_kses_post( get_post_meta( $wppp_id, 'slides-footer-left', true ) ); ?></div>
			<div id="footer-right"><?php echo wp_kses_post( get_post_meta( $wppp_id, 'slides-footer-right', true ) ); ?></div>
		</div>
	</div>
</div>
<div class="reveal">
	<?php
	if ( have_posts() ) {
		while ( have_posts() ) {
			global $post;
			the_post();
			?>
			<div class="slides">
			<?php
			$blocks = parse_blocks( $post->post_content );
			wp_presenter_pro_render_blocks( $blocks );
			?>
			</div>
			<?php
		}
	}
	?>
</div>
<?php
do_action( 'wp_footer' );
$preview_link = filter_var( get_post_meta( $wppp_id, 'slides-no-link-previews', true ), FILTER_VALIDATE_BOOLEAN );
$center_view  = filter_var( get_post_meta( $wppp_id, 'slides-no-center-view', true ), FILTER_VALIDATE_BOOLEAN );
?>
<script>
// Full list of configuration options available here:
// https://github.com/hakimel/reveal.js#configuration
Reveal.initialize( {
			width : <?php echo esc_html( get_post_meta( $wppp_id, 'slides-slide-width', true ) ? get_post_meta( $wppp_id, 'slides-slide-width', true ) : '960' ); ?>,
			height : <?php echo esc_html( get_post_meta( $wppp_id, 'slides-slide-height', true ) ? get_post_meta( $wppp_id, 'slides-slide-height', true ) : '700' ); ?>,
			margin : <?php echo esc_html( get_post_meta( $wppp_id, 'slides-slide-margin', true ) ? get_post_meta( $wppp_id, 'slides-slide-margin', true ) : '0.1' ); ?>,
			maxScale : <?php echo esc_html( get_post_meta( $wppp_id, 'slides-max-scale', true ) ? get_post_meta( $wppp_id, 'slides-max-scale', true ) : '1.5' ); ?>,
			minScale : <?php echo esc_html( get_post_meta( $wppp_id, 'slides-min-scale', true ) ? get_post_meta( $wppp_id, 'slides-min-scale', true ) : '0.2' ); ?>,
			controls : <?php echo esc_html( get_post_meta( $wppp_id, 'slides-display-controls', true ) ? get_post_meta( $wppp_id, 'slides-display-controls', true ) : 'true' ); ?>,
			progress : <?php echo esc_html( get_post_meta( $wppp_id, 'slides-progress-bar', true ) ? get_post_meta( $wppp_id, 'slides-progress-bar', true ) : 'true' ); ?>,
			slideNumber : <?php echo esc_html( get_post_meta( $wppp_id, 'slides-slide-number', true ) ? get_post_meta( $wppp_id, 'slides-slide-number', true ) : 'false' ); ?>,
			history : <?php echo esc_html( get_post_meta( $wppp_id, 'slides-push-history', true ) ? get_post_meta( $wppp_id, 'slides-push-history', true ) : 'true' ); ?>,
			keyboard : <?php echo esc_html( get_post_meta( $wppp_id, 'slides-keyboard-shortcuts', true ) ? get_post_meta( $wppp_id, 'slides-keyboard-shortcuts', true ) : 'true' ); ?>,
			overview : true,
			center : <?php echo esc_html( $center_view ? 'false' : 'true' ); ?>,
			touch : true,
			loop :<?php echo esc_html( get_post_meta( $wppp_id, 'slides-loop-slides', true ) ? get_post_meta( $wppp_id, 'slides-loop-slides', true ) : 'false' ); ?>,
			rtl : <?php echo esc_html( get_post_meta( $wppp_id, 'slides-right-to-left', true ) ? get_post_meta( $wppp_id, 'slides-right-to-left', true ) : 'false' ); ?>,
			embedded : false,
			mouseWheel : <?php echo esc_html( get_post_meta( $wppp_id, 'slides-mouse-wheel-navigation', true ) ? get_post_meta( $wppp_id, 'slides-mouse-wheel-navigation', true ) : 'true' ); ?>,
			hideAddressBar : true,
			previewLinks : <?php echo esc_html( $preview_link ? 'false' : 'true' ); ?>,

			// Optional libraries used to extend on reveal.js
			dependencies : [
				<?php
				echo implode( ",\n", apply_filters( 'reveal_default_dependencies', array( // phpcs:ignore
					'classList' => "{ src: '" . WP_PRESENTER_PRO_URL . "/assets/reveal/lib/js/classList.js', condition: function() { return !document.body.classList; } }",
					'highlight' => "{ src: '" . WP_PRESENTER_PRO_URL . "/assets/reveal/plugin/highlight/highlight.js', async: true, callback: function() { hljs.initHighlightingOnLoad(); } }",
					'zoom'      => "{ src: '" . WP_PRESENTER_PRO_URL . "/assets/reveal/plugin/zoom-js/zoom.js', async: true, condition: function() { return !!document.body.classList; } }",
					'notes'     => "{ src: '" . WP_PRESENTER_PRO_URL . "/assets/reveal/plugin/notes/notes.js', async: true, condition: function() { return !!document.body.classList; } }",
				) ) ); // phpcs:ignore
				?>
			]
		} );
		</script>
		<?php
		do_action( 'wp_presenter_pro_slide_footer' );
		do_action( 'wp_footer' );
		?>
		<script>
		Reveal.addEventListener( 'slidechanged', function( event ) {
			if ( Reveal.isFirstSlide() || Reveal.isLastSlide() ) {
				jQuery( 'div.reveal' ).find( '#header-wrapper' ).remove();
			}
			if ( ! Reveal.isFirstSlide() && ! Reveal.isLastSlide() && ! jQuery( 'div.reveal' ).find( '#header-left' ).length > 0 ) {
				var header = jQuery('#header').html();
				jQuery('div.reveal').append(header);
			}
		} );
		</script>
</body>
</html>
