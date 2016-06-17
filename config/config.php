<?php

/**
 * Frontend modules
 */
$GLOBALS['FE_MOD'][\HeimrichHannot\PinBoard\PinBoard::MODULE_GROUP_PINBOARD] = array(
	\HeimrichHannot\PinBoard\PinBoard::MODULE_PINBOARD => 'HeimrichHannot\PinBoard\ModulePinBoard',
	\HeimrichHannot\PinBoard\PinBoard::MODULE_PINBOARD_EDITOR => 'HeimrichHannot\PinBoard\ModulePinBoardEditor',
	\HeimrichHannot\PinBoard\PinBoard::MODULE_PINBOARD_READER => 'HeimrichHannot\PinBoard\ModulePinBoardReader',
);

/**
 * Assets
 */
if (TL_MODE == 'FE')
{
	// js
	$GLOBALS['TL_JAVASCRIPT']['pinboard_masonry'] = 'system/modules/pinboard/assets/vendor/masonry-4.1.0/dist/masonry.pkgd.min.js|static';
	$GLOBALS['TL_JAVASCRIPT']['pinboard_imagesloaded'] = 'system/modules/pinboard/assets/vendor/imagesloaded-4.1.0/imagesloaded.pkgd.min.js|static';
	$GLOBALS['TL_JAVASCRIPT']['pinboard'] = 'system/modules/pinboard/assets/js/jquery.pinboard.js';
}