<?php

namespace Whodunit\Framework\Commands;

use Whodunit\Framework\Commands\GeneratorCommand;

/**
 * The command responsible for creating a new post type in the right place
 */
final class PostTypeMakeCommand extends GeneratorCommand {

	/**
	 * @inheritDoc
	 */
	public static ?string $_COMMAND_NAME = 'whostarter make:post-type';

	/**
	 * @inheritDoc
	 */
	protected string $class_suffix = 'PostType';

	/**
	 * @inheritDoc
	 */
	protected function replace_stubs_in_destination() : void {
		$destination_file_content = file_get_contents( $this->destination_file );
		$destination_file_content = preg_replace( '/\bDummyPostType\b/', $this->class_to_create, $destination_file_content );
		$destination_file_content = preg_replace( '/\bDummy\b/', $this->object_to_create, $destination_file_content );
		$destination_file_content = preg_replace( '/\bdummy\b/', strtolower( $this->object_to_create ), $destination_file_content );
		$destination_file_content = preg_replace( '/\bDummyPluralName\b/', $this->object_to_create . 'PluralName', $destination_file_content );
		$destination_file_content = preg_replace( '/\bDummySingularName\b/', $this->object_to_create . 'SingularName', $destination_file_content );
		file_put_contents( $this->destination_file, $destination_file_content );
	}

	/**
	 * @inheritDoc
	 */
	protected function display_success_message() : void {
		$display_path = str_replace( \get_template_directory() . '/', '', $this->destination_file );

		\WP_CLI::success( sprintf( 'Post type "%s" created successfully at "%s" !', $this->object_to_create, $display_path ) );
		\WP_CLI::log( sprintf( 'You must now enqueue the newly created post type "%s" in the "config/post_types.php" file !', $this->object_to_create ) );
	}

	/**
	 * @inheritDoc
	 */
	protected function set_source_file() : void {
		$this->source_file = \get_template_directory() . '/framework/stubs/PostType.stub';
	}

	/**
	 * @inheritDoc
	 */
	protected function set_destination_path() : void {
		$this->destination_path = \get_template_directory() . '/app/Models/';
	}
}