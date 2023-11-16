<?php

namespace Whodunit\Framework\Services;

use Whodunit\Framework\Commands\BaseCommand;
use Whodunit\Framework\Commands\Exceptions\UndefinedCommandNameException;
use Whodunit\Framework\Concerns\OptionPage;
use Whodunit\Framework\Concerns\PostType;
use Whodunit\Framework\Concerns\Taxonomy;

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
     * @param string $file The path to the config file
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
            'commands'     => add_action( 'cli_init', fn () => self::load_commands( $file ) ),
            'post_types'   => self::load_post_types( $file ),
            'taxonomies'   => self::load_taxonomies( $file ),
            'option_pages' => self::load_option_pages( $file ),
            default        => null,
        };
    }

    /**
     * Load the commands config file
     *
     * @param string $file The path to the config file
     */
    private static function load_commands( string $file ) : void {
        // Bail if not in a WP_CLI context
        if ( ! defined( 'WP_CLI' ) || ! WP_CLI ) {
            return;
        }

        $commands_to_load = require_once $file;
        foreach ( $commands_to_load as $command ) {
            if ( ! is_subclass_of( $command, BaseCommand::class ) ) {
                throw new \TypeError( sprintf( 'The Command "%s" must be a valid Command', strval( $command ) ) );
            }

            if ( is_null( $command::$_COMMAND_NAME ) || empty( $command::$_COMMAND_NAME ) ) {
                throw new UndefinedCommandNameException( sprintf( 'The Command "%s" must have a valid name', strval( $command ) ) );
            }

            // Assert to ensure that the static property is not null
            /** @psalm-var non-empty-string */
            $command_name = $command::$_COMMAND_NAME;

            \WP_CLI::add_command( $command_name, $command );
        }
    }

    /**
     * Load the post types config file
     *
     * @param string $file The path to the config file
     */
    private static function load_post_types( string $file ) : void {
        $post_types_to_load = require_once $file;

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
        $taxonomies_to_load = require_once $file;

        foreach ( $taxonomies_to_load as $taxonomy ) {
            if ( ! is_subclass_of( $taxonomy, Taxonomy::class ) ) {
                throw new \TypeError( sprintf( 'The Taxonomy "%s" must be a valid Taxonomy', $taxonomy ) );
            }

            $taxonomy::register();
        }
    }

    /**
     * Load the option pages config file
     *
     * @param string $file The path to the config file
     */
    private static function load_option_pages( string $file ) : void {
        $option_pages_to_load = require_once $file;

        foreach ( $option_pages_to_load as $option_page ) {
            if ( ! is_subclass_of( $option_page, OptionPage::class ) ) {
                throw new \TypeError( sprintf( 'The Option Page "%s" must be a valid Option Page', $option_page ) );
            }

            $option_page::register();
        }
    }
}
