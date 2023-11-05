<?php

namespace Whodunit\Framework\Concerns;

/**
 * Interface to be implemented by all post types
 * used by the framework
 */
interface PostType {

	/**
	 * Register the post type
	 */
	public static function register() : void;
}