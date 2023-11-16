<?php

namespace Whodunit\Framework\Concerns;

/**
 * Interface to be implemented by all taxonomies
 * used by the framework
 */
interface Taxonomy {
    /**
     * Register the taxonomy
     */
    public static function register() : void;
}
