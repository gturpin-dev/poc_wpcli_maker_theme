<?php

namespace Whodunit\Framework\Commands;

use InvalidArgumentException;
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
	public static ?string $_COMMAND_NAME = 'whostarter make:post-type';

	/**
	 * The Object to create without suffix
	 *
	 * @var string|null
	 */
	protected ?string $object_to_create = null;

	/**
	 * The class to create with suffix
	 *
	 * @var string|null
	 */
	protected ?string $class_to_create = null;

	/**
	 * The class suffix to add to the class name
	 *
	 * @var string
	 */
	protected string $class_suffix = 'PostType';

	/**
	 * The source file full path and name to copy
	 *
	 * @var string|null
	 */
	protected ?string $source_file = null;

	/**
	 * The destination path
	 *
	 * @var string|null
	 */
	protected ?string $destination_path = null;

	/**
	 * The destination file full path and name
	 *
	 * @var string|null
	 */
	protected ?string $destination_file = null;

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
		// We need a post type name to create a post type
		$post_type_to_create = ucfirst( $args[0] ?? '' );
		
		if ( empty( $post_type_to_create ) ) {
			throw new \InvalidArgumentException( 'You must provide a post type name !' );
		}

		// Set the properties for the command
		$this->object_to_create = $post_type_to_create;
		// $this->class_to_create  = $post_type_to_create . $this->class_suffix;
		$this->set_object_to_create( $post_type_to_create );
		$this->set_class_to_create();
		$this->set_source_file();
		$this->set_destination_path();
		$this->set_destination_file();

		// Create the Object based on the stub file
		$this->maybe_create_destination_folder();
		$this->check_destination_file_exists();
		$this->copy_stub_to_destination();
		$this->replace_stubs_in_destination();
		$this->display_success_message();
	}

	/**
	 * Maybe create the destination folder if it does not exist
	 *
	 * @return void
	 */
	protected function maybe_create_destination_folder() : void {
		if ( ! file_exists( $this->destination_path ) ) {
			mkdir( $this->destination_path, 0777, true );
		}
	}

	/**
	 * Check if the destination file already exists and throw an error if it does
	 *
	 * @throws InvalidArgumentException If the destination file already exists
	 *
	 * @return void
	 */
	protected function check_destination_file_exists() : void {
		if ( file_exists( $this->destination_file ) ) {
			throw new \InvalidArgumentException( sprintf( 'Post type "%s" already exists !', $this->object_to_create ) );
		}
	}

	/**
	 * Copy the stub file to the destination file
	 * 
	 * @throws Exception If the copy is not successful
	 *
	 * @return void
	 */
	protected function copy_stub_to_destination() : void {
		$is_successful = copy( $this->source_file, $this->destination_file );

		if ( ! $is_successful ) {
			throw new \Exception( sprintf( 'Could not copy the stub file "%s" to the destination file "%s" !', $this->source_file, $this->destination_file ) );
		}
	}

	/**
	 * Replace the Dummy stubs with the actual class name based strings
	 *
	 * @return void
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
	 * Display a success message when everything is done
	 *
	 * @return void
	 */
	protected function display_success_message() : void {
		$display_path = str_replace( \get_template_directory() . '/', '', $this->destination_file );

		\WP_CLI::success( sprintf( 'Post type "%s" created successfully at "%s" !', $this->object_to_create, $display_path ) );
		\WP_CLI::log( sprintf( 'You must now enqueue the newly created post type "%s" in the "config/post_types.php" file !', $this->object_to_create ) );
	}
	
	/**
	 * Set the object to create
	 *
	 * @param string $object_to_create The object name to create
	 *
	 * @return void
	 */
	protected function set_object_to_create( string $object_to_create ) : void {
		$this->object_to_create = $object_to_create;
	}
	
	/**
	 * Set the full class name to create
	 *
	 * @return void
	 */
	protected function set_class_to_create() : void {
		$this->class_to_create = $this->object_to_create . $this->class_suffix;
	}

	/**
	 * Set the source file for the generator command
	 *
	 * @return void
	 */
	protected function set_source_file() : void {
		$this->source_file = \get_template_directory() . '/framework/stubs/PostType.stub';
	}

	/**
	 * Set the destination path for the generator command
	 *
	 * @return void
	 */
	protected function set_destination_path() : void {
		$this->destination_path = \get_template_directory() . '/app/Models/';
	}

	/**
	 * Set the destination file for the generator command
	 *
	 * @return void
	 */
	protected function set_destination_file() : void {
		$this->destination_file = $this->destination_path . $this->class_to_create . '.php';
	}
}