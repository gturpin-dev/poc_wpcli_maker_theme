<?php

namespace App\Models;

use Whodunit\Framework\Concerns\PostType;

/**
 * The model for the built-in Post post type
 */
final class PostPostType implements PostType {
    /**
     * The slug of the post type
     */
    public const SLUG = 'post';

    /**
     * Not needed for built-in post types
     */
    public static function register() : void {}
}
