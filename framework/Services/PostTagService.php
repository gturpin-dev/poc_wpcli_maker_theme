<?php

namespace Whodunit\Framework\Services;

/**
 * Service to manage the builtin post tags
 */
final class PostTagService {
    /**
     * Enable or not the post tags related to the posts
     *
     * @param boolean $enabled Enable or not the post tags
     */
    public static function enable( bool $enabled ) : void {
        // Bail if enabled because it's the default behavior
        if ( $enabled === true ) return;

        add_action( 'init', [ __CLASS__, 'disable_post_tag' ] );
    }

    /**
     * Disable the post tags related to the posts
     */
    public static function disable_post_tag() : void {
        unregister_taxonomy_for_object_type( 'post_tag', 'post' );
    }
}
