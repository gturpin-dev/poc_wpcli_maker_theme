<?php

namespace Whodunit\Framework\Commands;

/**
 * Class to be extended by all custom WP CLI commands
 * The command must be binded to the child class
 * This one will route the call to the handle method
 * So the child class must implement the handle method to be executed
 *
 * @link https://make.wordpress.org/cli/handbook/guides/commands-cookbook/
 */
abstract class BaseCommand extends \WP_CLI_Command {
    /**
     * Must be redeclared in the child class
     *
     * @var string|null The name of the command to be called in the console
     *
     * @example "whodunit make:command" to be called with "wp whodunit make:command"
     */
    public static ?string $_COMMAND_NAME = null;

    /**
     * The code called when the command is executed
     *
     * @param array $args       The list of arguments
     * @param array $assoc_args The list of associative arguments
     *
     * @link https://make.wordpress.org/cli/handbook/guides/commands-cookbook/#accepting-arguments
     */
    abstract protected function handle( array $args, array $assoc_args ) : void;

    /**
     * Called automatically when the command is executed
     * Route to the handle method
     *
     * @param array $args       The list of arguments
     * @param array $assoc_args The list of associative arguments
     *
     * @link https://make.wordpress.org/cli/handbook/guides/commands-cookbook/#accepting-arguments
     */
    public function __invoke( array $args, array $assoc_args ) : void {
        try {
            $this->handle( $args, $assoc_args );
        } catch ( \Exception $e ) {
            \WP_CLI::error( get_class( $e ) . ' : ' . $e->getMessage() );
            exit;
        }
    }
}
