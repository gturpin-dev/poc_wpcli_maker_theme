<?php

use Whodunit\Framework\Commands\OptionPageMakeCommand;
use Whodunit\Framework\Commands\PostTypeMakeCommand;
use Whodunit\Framework\Commands\TaxonomyMakeCommand;

/**
 * Put your commands classnames here to be loaded by the framework
 * All commands must extend the Whodunit\Framework\Commands\Command class
 */
return [
	PostTypeMakeCommand::class,
	TaxonomyMakeCommand::class,
	OptionPageMakeCommand::class,
];