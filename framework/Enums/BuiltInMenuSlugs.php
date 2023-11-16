<?php

namespace Whodunit\Framework\Enums;

use Whodunit\Framework\Enums\Concerns\EnumTrait;

/**
 * The built-in menu slugs of WordPress
 *
 * @link https://developer.wordpress.org/reference/functions/add_menu_page/#menu-structure
 */
enum BuiltInMenuSlugs : string {
    use EnumTrait;

    case DASHBOARD        = 'index.php';
    case POSTS            = 'edit.php';
    case MEDIA            = 'upload.php';
    case PAGES            = 'edit.php?post_type=page';
    case COMMENTS         = 'edit-comments.php';
    case APPEARANCE       = 'themes.php';
    case PLUGINS          = 'plugins.php';
    case USERS            = 'users.php';
    case TOOLS            = 'tools.php';
    case SETTINGS         = 'options-general.php';
    case NETWORK_SETTINGS = 'settings.php';
}
