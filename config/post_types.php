<?php

use App\Models\PagePostType;
use App\Models\PostPostType;

/**
 * Put your custom post types classnames here to be loaded by the framework
 * All Post types must be stored in app/Models folder
 * All Post types must extend the Whodunit\Framework\PostType class
 */
return [
	PostPostType::class,
	PagePostType::class,
];