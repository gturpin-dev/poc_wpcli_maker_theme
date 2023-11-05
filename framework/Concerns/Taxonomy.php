<?php

namespace Whodunit\Framework\Concerns;

/**
 * Interface to be implemented by all taxonomies
 * used by the framework
 */
interface Taxonomy {

	/**
	 * Register the post type
	 */
	public static function register() : void;
}