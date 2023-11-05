<?php

namespace Whodunit\Framework\Services;

use Whodunit\Framework\Concerns\PostType;
use Whodunit\Framework\Concerns\Taxonomy;
use Whodunit\Framework\Commands\BaseCommand;

/**
 * Load the config files
 */
final class ConfigLoader {

	/**
	 * Load all config files
	 */
	public static function load() : void {
		$path  = get_template_directory() . '/config';
		$files = glob( $path . '/*.php' );

		foreach ( $files as $file ) {
			self::load_config_file( $file );
		}
	}

	/**
	 * Load a config file
	 *
	 * @param string $file
	 */
	private static function load_config_file( string $file ) : void {
		// Get the filename without the extension
		$filename = basename( $file, '.php' );

		// Bail if the filename is not valid
		if ( ! $filename ) {
			return;
		}

		// Load the config file based on the filename
		match ( $filename ) {
			'commands'   => add_action( 'cli_init', fn () => self::load_commands( $file ) ),
			'post_types' => self::load_post_types( $file ),
			'taxonomies' => self::load_taxonomies( $file ),
			default      => null,
		};
	}

	/**
	 * Load the commands config file
	 *
	 * @param string $file The path to the config file
	 */
	private static function load_commands( string $file ) : void {
		// Bail if not in a WP_CLI context
		if ( ! defined( 'WP_CLI' ) || ! WP_CLI ) return;
		
		// Ensure that all commands are commands
		$commands_to_load = require_once $file ?? [];
		$commands_to_load = array_filter( $commands_to_load, fn ( $command ) => is_subclass_of( $command, BaseCommand::class ) );

		foreach ( $commands_to_load as $command ) {
			\WP_CLI::add_command( $command::$_COMMAND_NAME, $command );
		}
	}

	/**
	 * Load the post types config file
	 *
	 * @param string $file The path to the config file
	 */
	private static function load_post_types( string $file ) : void {
		$post_types_to_load = require_once $file ?? [];

		foreach ( $post_types_to_load as $post_type ) {
			if ( ! is_subclass_of( $post_type, PostType::class ) ) {
				throw new \TypeError( sprintf( 'The Post Type "%s" must be a valid Post Type', $post_type ) );
			}
			
			$post_type::register();
		}
	}

	/**
	 * Load the taxonomies config file
	 *
	 * @param string $file The path to the config file
	 */
	private static function load_taxonomies( string $file ) : void {
		$taxonomies_to_load = require_once $file ?? [];

		foreach ( $taxonomies_to_load as $taxonomy ) {
			if ( ! is_subclass_of( $taxonomy, Taxonomy::class ) ) {
				throw new \TypeError( sprintf( 'The Taxonomy "%s" must be a valid Taxonomy', $taxonomy ) );
			}
			
			$taxonomy::register();
		}
	}
}