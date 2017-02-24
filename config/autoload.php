<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2017 Leo Feyer
 *
 * @license LGPL-3.0+
 */


/**
 * Register the namespaces
 */
ClassLoader::addNamespaces(
    [
	'HeimrichHannot',]
);


/**
 * Register the classes
 */
ClassLoader::addClasses(
    [
	// Modules
	'HeimrichHannot\PinBoard\ModulePinBoardEditor' => 'system/modules/pinboard/modules/ModulePinBoardEditor.php',
	'HeimrichHannot\PinBoard\ModulePinBoard'       => 'system/modules/pinboard/modules/ModulePinBoard.php',
	'HeimrichHannot\PinBoard\ModulePinBoardReader' => 'system/modules/pinboard/modules/ModulePinBoardReader.php',

	// Classes
	'HeimrichHannot\PinBoard\Backend\Module'       => 'system/modules/pinboard/classes/backend/Module.php',
	'HeimrichHannot\PinBoard\PinBoard'             => 'system/modules/pinboard/classes/PinBoard.php',]
);


/**
 * Register the templates
 */
TemplateLoader::addFiles(
    [
	'mod_pinboard'                    => 'system/modules/pinboard/templates',
	'frontendedit_list_item_pinboard' => 'system/modules/pinboard/templates',
	'j_pinboard'                      => 'system/modules/pinboard/templates',
	'formhybrid_reader_pinboard'      => 'system/modules/pinboard/templates',]
);
