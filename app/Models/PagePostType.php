<?php

namespace App\Models;

use Whodunit\Framework\Concerns\PostType;

/**
 * The model for the built-in Page post type
 */
final class PagePostType implements PostType {

	/**
	 * The slug of the post type
	 */
	public const SLUG = 'page';

	/**
	 * Not needed for built-in post types
	 *
	 * @return void
	 */
	public static function register() : void {}
}