<?php

namespace Whodunit\Framework\Commands;

use Whodunit\Framework\Commands\BaseCommand;

/**
 * The base class for all generator commands. eg: make:command
 * A generator command is a command that creates a file from a stub file
 */
abstract class GeneratorCommand extends BaseCommand {}