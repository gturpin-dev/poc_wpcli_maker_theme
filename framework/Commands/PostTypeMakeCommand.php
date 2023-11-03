<?php

namespace Whodunit\Framework\Commands;

use Whodunit\Framework\Commands\GeneratorCommand;

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
		// to create a post type, we need a name
		// so we check if the first argument is set
		// if not, we throw an error

		// The command class must redeclare the source_file property and set it to the source stub file
		// The command class must redeclare the target_file property and set it to the destination file
		// Rename the stub file to the destination file
		// Replace all namespace placeholders "dummy" in the destination file with the namespace
		// Replace all class name placeholders "Dummy" in the destination file with the class name
		// Set a message to be displayed in the console to tell the user to enqueue the new PostType

		$post_type_to_create = $args[0] ?? null;
		
		\WP_CLI::success( sprintf( 'Post type "%s" created successfully !', $post_type_to_create ) );
	}
}