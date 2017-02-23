<?php

/**
 * Frontend modules
 */
$GLOBALS['FE_MOD'][\HeimrichHannot\PinBoard\PinBoard::MODULE_GROUP_PINBOARD] = [
    \HeimrichHannot\PinBoard\PinBoard::MODULE_PINBOARD        => 'HeimrichHannot\PinBoard\ModulePinBoard',
    \HeimrichHannot\PinBoard\PinBoard::MODULE_PINBOARD_EDITOR => 'HeimrichHannot\PinBoard\ModulePinBoardEditor',
    \HeimrichHannot\PinBoard\PinBoard::MODULE_PINBOARD_READER => 'HeimrichHannot\PinBoard\ModulePinBoardReader',
];