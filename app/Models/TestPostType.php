<?php

namespace App\Models;

/**
 * The model for the Test post type
 */
final class TestPostType {

	/**
	 * The slug of the post type
	 */
	public const SLUG = 'test';
	
	/**
	 * The dashicon for the post type
	 * @link https://developer.wordpress.org/resource/dashicons/
	 */
	protected const DASHICON = 'dashicons-admin-generic';

	/**
	 * Register the post type hooks
	 *
	 * @return void
	 */
	public static function register() : void {
		add_action( 'init', [ self::class, 'register_post_type' ] );
	}

	/**
	 * Defines the labels for the post type
	 * 
	 * @link https://developer.wordpress.org/reference/functions/get_post_type_labels/
	 *
	 * @return array<string, string> The labels
	 */
	protected static function labels() : array {
		return [
			'name'               => _x( 'TestPluralName', 'Post type general name', 'dummy_textdomain' ),
			'singular_name'      => _x( 'TestSingularName', 'Post type singular name', 'dummy_textdomain' ),
			'menu_name'          => _x( 'TestPluralName', 'Admin Menu text', 'dummy_textdomain' ),
			'name_admin_bar'     => _x( 'TestSingularName', 'Add New on Toolbar', 'dummy_textdomain' ),
			'all_items'          => __( 'TestPluralName', 'dummy_textdomain' ),
			'add_new'            => __( 'Add New', 'dummy_textdomain' ),
			'add_new_item'       => __( 'Add New TestSingularName', 'dummy_textdomain' ),
			'edit_item'          => __( 'Edit TestSingularName', 'dummy_textdomain' ),
			'new_item'           => __( 'New TestSingularName', 'dummy_textdomain' ),
			'view_item'          => __( 'View TestSingularName', 'dummy_textdomain' ),
			'view_items'         => __( 'View TestPluralName', 'dummy_textdomain' ),
			'search_items'       => __( 'Search TestPluralName', 'dummy_textdomain' ),
			'not_found'          => __( 'No TestPluralName found.', 'dummy_textdomain' ),
			'not_found_in_trash' => __( 'No TestPluralName found in Trash.', 'dummy_textdomain' ),
			'parent_item_colon'  => __( 'Parent TestSingularName:', 'dummy_textdomain' ),
		];
	}

	/**
	 * Defines the options for the post type
	 * 
	 * @link https://developer.wordpress.org/reference/functions/register_post_type/#parameters
	 *
	 * @return array<string, mixed> The options
	 */
	protected static function options() : array {
		return [
			'labels'  => self::labels(),
			'public'  => true,
			'rewrite' => [
				'slug' => self::SLUG,
			],
			'menu_position'   => 6,
			'capability_type' => 'post',
			'has_archive'     => true,
			'hierarchical'    => false,
			'menu_icon'       => self::DASHICON,
			'show_in_rest'    => true,
			'supports'        => [
				'title',
				'editor',
				'thumbnail',
				'excerpt',
				'revisions'
			],
		];
	}
	
	/**
	 * Register the post type
	 *
	 * @return void
	 */
	public static function register_post_type() : void {
		\register_post_type( self::SLUG, self::options() );
	}
}