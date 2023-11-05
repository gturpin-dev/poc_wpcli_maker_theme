<?php

use Whodunit\Framework\Services\ConfigLoader;

// Load autoloader
if ( file_exists( __DIR__ . '/vendor/autoload.php' ) ) {
	require_once __DIR__ . '/vendor/autoload.php';
}

// load all config files
ConfigLoader::load();