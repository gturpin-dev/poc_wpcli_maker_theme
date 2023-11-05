<?php

namespace Whodunit\Framework\Commands;

use Whodunit\Framework\Commands\GeneratorCommand;

/**
 * The command responsible for creating a new Option Page in the right place
 */
final class OptionPageMakeCommand extends GeneratorCommand {

	/**
	 * @inheritDoc
	 */
	public static ?string $_COMMAND_NAME = 'whostarter make:option-page';

	/**
	 * @inheritDoc
	 */
	protected string $class_suffix = 'OptionPage';

	/**
	 * @inheritDoc
	 */
	protected function replace_stubs_in_destination() : void {
		$should_enable_acf = filter_var( $this->assoc_args['acf'] ?? true, FILTER_VALIDATE_BOOLEAN );
		
		$destination_file_content = file_get_contents( $this->destination_file );
		$destination_file_content = preg_replace( '/\bDummyOptionPage\b/', $this->class_to_create, $destination_file_content );
		$destination_file_content = preg_replace( '/\bDummy\b/', $this->object_to_create, $destination_file_content );
		$destination_file_content = preg_replace( '/\bdummy\b/', strtolower( $this->object_to_create ), $destination_file_content );
		$destination_file_content = preg_replace( '/\bdummy_use_acf\b/', $should_enable_acf ? 'true' : 'false', $destination_file_content );
		file_put_contents( $this->destination_file, $destination_file_content );
	}

	/**
	 * @inheritDoc
	 */
	protected function display_success_message() : void {
		$display_path = str_replace( \get_template_directory() . '/', '', $this->destination_file );

		\WP_CLI::success( sprintf( 'Option Page "%s" created successfully at "%s" !', $this->object_to_create, $display_path ) );
		\WP_CLI::log( sprintf( 'You must now enqueue the newly created option page "%s" in the "config/option_pages.php" file !', $this->object_to_create ) );
	}

	/**
	 * @inheritDoc
	 */
	protected function set_source_file() : void {
		$this->source_file = \get_template_directory() . '/framework/stubs/OptionPage.stub';
	}

	/**
	 * @inheritDoc
	 */
	protected function set_destination_path() : void {
		$this->destination_path = \get_template_directory() . '/app/OptionPages/';
	}
}