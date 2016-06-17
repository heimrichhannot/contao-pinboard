<?php

$arrDca = &$GLOBALS['TL_DCA']['tl_news'];

/**
 * Palettes
 */
$arrDca['palettes']['default'] = str_replace('{title_legend}', '{title_legend},type', $arrDca['palettes']['default']);

$arrDca['palettes']['pinboard'] =
	'{title_legend},type,headline,alias,useMemberAuthor,author,memberAuthor;' .
	'{date_legend},date,time;{teaser_legend},teaser;{media_type_legend},mediaType;' .
	'{enclosure_legend:hide},addEnclosure;{expert_legend:hide},cssClass,noComments,featured;{publish_legend},published';

/**
 * Subpalettes
 */
$arrDca['palettes']['__selector__'][] = 'type';
$arrDca['palettes']['__selector__'][] = 'mediaType';
$arrDca['subpalettes']['mediaType_image'] = 'pinBoardImage';
$arrDca['subpalettes']['mediaType_video'] = 'pinBoardYouTube';

/**
 * Callbacks
 */
$arrDca['config']['onload_callback'][] = array('tl_news_pinboard', 'modifyPalette');
$arrDca['config']['onsubmit_callback'][] = array('tl_news_pinboard', 'generateAlias');

/**
 * Fields
 */
$arrFields = array(
	'type' => array(
		'label'                   => &$GLOBALS['TL_LANG']['tl_news']['type'],
		'exclude'                 => true,
		'filter'                  => true,
		'inputType'               => 'select',
		'default'                 => 'default',
		'options'                 => array('default', 'pinboard'),
		'reference' => $GLOBALS['TL_LANG']['tl_news']['type'],
		'eval'                    => array('submitOnChange' => true, 'tl_class' => 'w50'),
		'sql'                     => "varchar(255) NOT NULL default 'default'"
	),
	'mediaType' => array
	(
		'label'     => &$GLOBALS['TL_LANG']['tl_news']['mediaType'],
		'exclude'   => true,
		'filter'    => true,
		'inputType' => 'select',
		'options'   => array('image', 'video'),
		'default'   => 'image',
		'reference' => &$GLOBALS['TL_LANG']['tl_news']['mediaType'],
		'eval'      => array('submitOnChange' => true),
		'sql'       => "varchar(12) NOT NULL default ''"
	),
	'pinBoardImage' => array(
		'label'     => &$GLOBALS['TL_LANG']['tl_news']['pinBoardImage'],
		'exclude'   => true,
		'inputType' => 'multifileupload',
		'eval'      => array(
			'tl_class'  => 'clr',
			'filesOnly' => true,
			'fieldType' => 'radio',
			'extensions' => \Config::get('validImageTypes'),
			'maxUploadSize' => 6,
			'addRemoveLinks' => true,
			'uploadFolder' => 'files/uploads'
		),
		'sql'       => "blob NULL",
	),
	'pinBoardYouTube' => $GLOBALS['TL_DCA']['tl_news']['fields']['youtube']
);

$arrDca['fields'] += $arrFields;

$arrDca['fields']['pinBoardYouTube']['sql'] = "varchar(255) NOT NULL default ''";
$arrDca['fields']['headline']['eval']['tl_class'] = 'w50 clr';

class tl_news_pinboard {

	public static function modifyPalette()
	{
		$arrDca = &$GLOBALS['TL_DCA']['tl_news'];

		if (($objNews = \NewsModel::findByPk(\Input::get('id'))) !== null && $objNews->useMemberAuthor)
		{
			$arrDca['palettes']['pinboard'] = str_replace(',author', ',', $arrDca['palettes']['pinboard']);
		}
		else
			$arrDca['palettes']['pinboard'] = str_replace(',memberAuthor', ',', $arrDca['palettes']['pinboard']);
	}

	public static function generateAlias()
	{
		if (TL_MODE == 'FE')
		{
			if (($objNews = \NewsModel::findByPk(\Input::get('id'))) !== null && $objNews->type == 'pinboard')
			{
				$objNews->alias = \HeimrichHannot\Haste\Dca\General::generateAlias($objNews->alias, $objNews->id, 'tl_news', $objNews->headline);
				$objNews->save();
			}
		}
	}

}