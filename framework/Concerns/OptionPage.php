<?php

namespace Whodunit\Framework\Concerns;

/**
 * Interface to be implemented by all option pages
 * used by the framework
 */
interface OptionPage {

	/**
	 * Register the option page
	 */
	public static function register() : void;
}