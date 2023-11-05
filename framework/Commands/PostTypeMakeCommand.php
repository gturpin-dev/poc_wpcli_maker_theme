<?php

namespace Whodunit\Framework\Commands;

use Whodunit\Framework\Commands\GeneratorCommand;

/**
 * The command responsible for creating a new post type in the right place
 */
final class PostTypeMakeCommand extends GeneratorCommand {

	/**
	 * @inheritDoc
	 * 
	 * @var string|null
	 */
	public static ?string $_COMMAND_NAME = 'whodunit make:post-type';

	/**
	 * The code called when the command is executed
	 * 
	 * @param array $args The list of arguments
	 * @param array $assoc_args The list of associative arguments
	 * 
	 * @link https://make.wordpress.org/cli/handbook/guides/commands-cookbook/#accepting-arguments
	 *
	 * @return void
	 */
	protected function handle( array $args, array $assoc_args ) : void {
		// The command class must redeclare the source_file property and set it to the source stub file
		// The command class must redeclare the target_file property and set it to the destination file
		// Rename the stub file to the destination file
		// Replace all namespace placeholders "dummy" in the destination file with the namespace
		// Replace all class name placeholders "Dummy" in the destination file with the class name
		// Set a message to be displayed in the console to tell the user to enqueue the new PostType

		// We need a post type name to create a post type
		$post_type_to_create = $args[0] ?? null;

		if ( ! $post_type_to_create ) {
			\WP_CLI::error( 'You must provide a post type name !' );
		}

		// Get the stub file and the destination file
		$source_file           = $this->get_source_file();
		$destination_path      = $this->get_destination_path();
		$destination_classname = $this->get_destination_classname( $post_type_to_create );
		$destination_file      = $destination_path . $destination_classname . '.php';

		// If destination folder does not exist, create it
		if ( ! file_exists( $destination_path ) ) {
			mkdir( $destination_path, 0777, true );
		}

		// If destination file already exists, throw an error
		if ( file_exists( $destination_file ) ) {
			\WP_CLI::error( sprintf( 'Post type "%s" already exists !', $post_type_to_create ) );
		}
		
		// Copy the stub file to the destination file
		copy( $source_file, $destination_file );

		// Replace the Dummy stubs with the actual class name based strings
		$destination_file_content = file_get_contents( $destination_file );
		$destination_file_content = preg_replace( '/\bDummyPostType\b/', $destination_classname, $destination_file_content );
		$destination_file_content = preg_replace( '/\bDummy\b/', $post_type_to_create, $destination_file_content );
		$destination_file_content = preg_replace( '/\bdummy\b/', strtolower( $post_type_to_create ), $destination_file_content );
		$destination_file_content = preg_replace( '/\bDummyPluralName\b/', $post_type_to_create . 'PluralName', $destination_file_content );
		$destination_file_content = preg_replace( '/\bDummySingularName\b/', $post_type_to_create . 'SingularName', $destination_file_content );
		file_put_contents( $destination_file, $destination_file_content );
		
		$display_path = str_replace( \get_template_directory(), '', $destination_file );
		$display_path = ltrim( $display_path, '/' );
		\WP_CLI::success( sprintf( 'Post type "%s" created successfully at "%s" !', $post_type_to_create, $display_path ) );
	}

	/**
	 * Get the source file
	 *
	 * @return string The source file
	 */
	protected function get_source_file() : string {
		return __DIR__ . '/stubs/PostType.stub';
	}

	/**
	 * Get the destination path
	 *
	 * @return string The destination path
	 */
	protected function get_destination_path() : string {
		return \get_template_directory() . '/app/Models/';
	}

	/**
	 * Get the destination classname
	 *
	 * @param string $post_type_to_create The post type to create
	 * 
	 * @return string The destination classname
	 */
	protected function get_destination_classname( string $post_type_to_create ) : string {
		return ucfirst( $post_type_to_create ) . 'PostType';
	}
}