<?php
/**
 * Add a code.
 *
 * @package   WP_Presenter_Pro
 */

namespace WP_Presenter_Pro\Blocks;

/**
 * Block code
 */
class Block {

	/**
	 * Title font size.
	 *
	 * @var string $title_font_size.
	 */
	private $title_font_size = '64';

	/**
	 * Default font family.
	 *
	 * @var string $title_font_size.
	 */
	private $font_family = 'open-sans';

	/**
	 * Default sub-title size.
	 *
	 * @var string $subtitle_size.
	 */
	private $sub_title_font_size = '32';

	/**
	 * Initialize the Admin component.
	 */
	public function __construct() {
	}
}
