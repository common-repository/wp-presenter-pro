<?php
/**
 * Primary plugin file.
 *
 * @package   WP_Presenter_Pro
 */

namespace WP_Presenter_Pro;

/**
 * Class Plugin
 */
class Plugin extends Plugin_Abstract {
	/**
	 * Execute this once plugins are loaded.
	 */
	public function plugin_loaded() {

		// Enqueue scripts.
		$this->block_enqueue = new Blocks\Enqueue();
		$this->block_enqueue->register_hooks();

		// Block for main slide.
		$this->block_slide = new Blocks\Slide();
		$this->block_slide->register_hooks();

		// Block for main slide title.
		$this->block_slide_title = new Blocks\Slide_Title();
		$this->block_slide_title->register_hooks();

		// Block for text box.
		$this->block_text_box = new Blocks\Text_Box();
		$this->block_text_box->register_hooks();

		// Block for code box.
		$this->block_code = new Blocks\Code();
		$this->block_code->register_hooks();

		// List Item Block.
		$this->block_list = new Blocks\List_Item();
		$this->block_list->register_hooks();

		// Ordered List Block.
		$this->block_ordered_list = new Blocks\Ordered_List();
		$this->block_ordered_list->register_hooks();

		// Image Block.
		$this->block_image = new Blocks\Image();
		$this->block_image->register_hooks();

		// Button Block.
		$this->button = new Blocks\Button();
		$this->button->register_hooks();

		// Button Block Dual.
		$this->button_dual = new Blocks\Dual_Buttons();
		$this->button_dual->register_hooks();

		// Spacer Block.
		$this->block_spacer = new Blocks\Spacer();
		$this->block_spacer->register_hooks();

		// Show Content Image Block.
		$this->block_content_image = new Blocks\Content_Image();
		$this->block_content_image->register_hooks();

		// Show Content Block.
		$this->block_content = new Blocks\Content();
		$this->block_content->register_hooks();

		// Show Content Block.
		$this->block_content_two_columns = new Blocks\Content_Two_Columns();
		$this->block_content_two_columns->register_hooks();

		// Vertical Slides Block.
		$this->block_vertical_slide = new Blocks\Vertical_Slide();
		$this->block_vertical_slide->register_hooks();

		// Blockquote block.
		$this->blockquote = new Blocks\Blockquote();
		$this->blockquote->register_hooks();

		// Transition Slides Block.
		$this->block_transition = new Blocks\Transition();
		$this->block_transition->register_hooks();

		// HTML Slides Block.
		$this->block_html = new Blocks\HTML();
		$this->block_html->register_hooks();

		// Register post type actions and filters.
		$this->post_type = new Admin\Post_Type();
		$this->post_type->register_hooks();

		// Register options for WP PResenter Pro.
		$this->admin_options = new Admin\Options();
		$this->admin_options->register_hooks();

		// Register get avatar REST API.
		$this->avatar = new Rest\Rest_Get_Avatar();
		$this->avatar->register_hooks();

		// Register gradient enqueue.
		$this->admin_enqueue = new Admin\Enqueue();
		$this->admin_enqueue->register_hooks();
	}
}
