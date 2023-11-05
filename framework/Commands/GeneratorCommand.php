<?php

namespace Whodunit\Framework\Commands;

use Whodunit\Framework\Commands\BaseCommand;

/**
 * The base class for all generator commands. eg: make:command
 * A generator command is a command that creates a file from a stub file
 */
abstract class GeneratorCommand extends BaseCommand {

	/**
	 * The Object to create without suffix
	 *
	 * @var string
	 */
	protected string $object_to_create;

	/**
	 * The class suffix to add to the class name
	 * To define in the child class
	 *
	 * @var string
	 */
	protected string $class_suffix = '';

	/**
	 * The class to create with suffix
	 *
	 * @var string
	 */
	protected string $class_to_create;

	/**
	 * The source file full path and name to copy
	 *
	 * @var string
	 */
	protected string $source_file;

	/**
	 * The destination path
	 *
	 * @var string
	 */
	protected string $destination_path;

	/**
	 * The destination file full path and name
	 *
	 * @var string
	 */
	protected string $destination_file;

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
		// We need an Object name to create a class
		$object_to_create = ucfirst( $args[0] ?? '' );
		
		if ( empty( $object_to_create ) ) {
			throw new \InvalidArgumentException( 'You must provide a post type name !' );
		}

		// Set the properties for the command
		$this->set_object_to_create( $object_to_create );
		$this->set_class_to_create();
		$this->set_source_file();
		$this->set_destination_path();
		$this->set_destination_file();

		if ( ! isset( $this->object_to_create, $this->class_to_create, $this->source_file, $this->destination_path, $this->destination_file ) ) {
			throw new \InvalidArgumentException( 'You must set all the properties for the command !' );
		}

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
	 * @throws \InvalidArgumentException If the destination file already exists
	 *
	 * @return void
	 */
	protected function check_destination_file_exists() : void {
		if ( file_exists( $this->destination_file ) ) {
			throw new \InvalidArgumentException( sprintf( 'The "%s" file already exists at "%s" !', $this->object_to_create, $this->destination_file ) );
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
	abstract protected function replace_stubs_in_destination() : void;
	
	/**
	 * Display a success message when everything is done
	 *
	 * @return void
	 */
	abstract protected function display_success_message() : void;

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
	abstract protected function set_source_file() : void;

	/**
	 * Set the destination path for the generator command
	 *
	 * @return void
	 */
	abstract protected function set_destination_path() : void;

	/**
	 * Set the destination file for the generator command
	 *
	 * @return void
	 */
	protected function set_destination_file() : void {
		$this->destination_file = $this->destination_path . $this->class_to_create . '.php';
	}
}