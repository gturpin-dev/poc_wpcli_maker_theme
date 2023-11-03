<?php

use Whodunit\Framework\Commands\BaseCommand;

// Load autoloader
if ( file_exists( __DIR__ . '/vendor/autoload.php' ) ) {
	require_once __DIR__ . '/vendor/autoload.php';
}

// Load all commands @TODO must be moved to a separate file in framework
add_action( 'cli_init', function() {
	// Bail if not in a WP_CLI context
	if ( ! defined( 'WP_CLI' ) || ! WP_CLI ) return;

	$commands_to_load = require_once __DIR__ . '/config/commands.php';
	
	// Ensure that all commands are in the right namespace
	$commands_to_load = array_filter( $commands_to_load, function ( $command ) {
		return is_subclass_of( $command, BaseCommand::class );
	} );
	
	foreach ( $commands_to_load as $command ) {
		\WP_CLI::add_command( $command::$_COMMAND_NAME, $command );
	}
} );
