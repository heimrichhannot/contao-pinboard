<?php

$arrDca = &$GLOBALS['TL_DCA']['tl_news'];

/**
 * Palettes
 */
$arrDca['palettes']['default'] = str_replace('{title_legend}', '{title_legend},type', $arrDca['palettes']['default']);

$arrDca['palettes']['pinboard'] = '{title_legend},type,headline,alias,useMemberAuthor,author,memberAuthor;'
                                  . '{date_legend},date,time;{teaser_legend},teaser;{media_type_legend},mediaType;'
                                  . '{enclosure_legend:hide},addEnclosure;{expert_legend:hide},cssClass,noComments,featured;{publish_legend},published';

/**
 * Subpalettes
 */
$arrDca['palettes']['__selector__'][]     = 'type';
$arrDca['palettes']['__selector__'][]     = 'mediaType';
$arrDca['subpalettes']['mediaType_image'] = 'pinBoardImage';
$arrDca['subpalettes']['mediaType_video'] = 'pinBoardYouTube';

/**
 * Callbacks
 */
$arrDca['config']['onload_callback'][]   = ['HeimrichHannot\PinBoard\Backend\News', 'modifyPalette'];
$arrDca['config']['onsubmit_callback'][] = ['HeimrichHannot\PinBoard\Backend\News', 'generateAlias'];

/**
 * Fields
 */
$arrFields = [
    'type'            => [
        'label'     => &$GLOBALS['TL_LANG']['tl_news']['type'],
        'exclude'   => true,
        'filter'    => true,
        'inputType' => 'select',
        'default'   => 'default',
        'options'   => ['default', 'pinboard'],
        'reference' => $GLOBALS['TL_LANG']['tl_news']['type'],
        'eval'      => ['submitOnChange' => true, 'tl_class' => 'w50'],
        'sql'       => "varchar(255) NOT NULL default 'default'"
    ],
    'mediaType'       => [
        'label'     => &$GLOBALS['TL_LANG']['tl_news']['mediaType'],
        'exclude'   => true,
        'filter'    => true,
        'inputType' => 'select',
        'options'   => ['image', 'video'],
        'default'   => 'image',
        'reference' => &$GLOBALS['TL_LANG']['tl_news']['mediaType'],
        'eval'      => ['submitOnChange' => true],
        'sql'       => "varchar(12) NOT NULL default ''"
    ],
    'pinBoardImage'   => [
        'label'     => &$GLOBALS['TL_LANG']['tl_news']['pinBoardImage'],
        'exclude'   => true,
        'inputType' => 'multifileupload',
        'eval'      => [
            'tl_class'       => 'clr',
            'filesOnly'      => true,
            'fieldType'      => 'radio',
            'extensions'     => \Config::get('validImageTypes'),
            'maxUploadSize'  => '10M',
            'addRemoveLinks' => true,
            'uploadFolder'   => 'files/uploads'
        ],
        'sql'       => "blob NULL",
    ],
    'pinBoardYouTube' => $GLOBALS['TL_DCA']['tl_news']['fields']['youtube']
];

$arrDca['fields'] += $arrFields;

$arrDca['fields']['pinBoardYouTube']['sql']       = "varchar(255) NOT NULL default ''";
$arrDca['fields']['headline']['eval']['tl_class'] = 'w50 clr';