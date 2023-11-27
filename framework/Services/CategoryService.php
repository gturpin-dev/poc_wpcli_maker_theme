<?php

namespace Whodunit\Framework\Services;

/**
 * Service to manage the builtin category
 */
final class CategoryService {
    /**
     * Enable or not the category related to the posts
     *
     * @param boolean $enabled Enable or not the category
     */
    public static function enable( bool $enabled ) : void {
        // Bail if enabled because it's the default behavior
        if ( $enabled === true ) return;

        add_action( 'init', [ __CLASS__, 'disable_category' ] );
    }

    /**
     * Disable the category related to the posts
     */
    public static function disable_category() : void {
        unregister_taxonomy_for_object_type( 'category', 'post' );
    }
}
