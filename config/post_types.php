<?php

use App\Models\PagePostType;
use App\Models\PostPostType;

/**
 * Put your custom post types classnames here to be loaded by the framework
 * All Post types must be stored in Models folder
 */
return [
	PostPostType::class,
	PagePostType::class,
];