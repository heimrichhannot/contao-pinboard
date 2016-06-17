<?php

$arrDca = &$GLOBALS['TL_DCA']['tl_module'];

/**
 * Palettes
 */
$arrPalettes = array(
	\HeimrichHannot\PinBoard\PinBoard::MODULE_PINBOARD => '{title_legend},name,headline,type;' .
		'{list_legend},numberOfItems,perPage,addAjaxPagination,skipFirst,skipInstances,showItemCount,emptyText,' .
		'addCreateButton,jumpToDetails,addEditCol,addPublishCol,addDeleteCol;' .
		'{filter_legend},hideFilter,filterHeadline,customFilterFields,filterArchives,addUpdateDeleteConditions,formHybridAddDefaultValues,' .
		'additionalSelectSql,additionalSql;{misc_legend},imgSize,useDummyImage,useModal;' .
		'{template_legend:hide},formHybridTemplate,formHybridCustomSubTemplates,itemTemplate,customTpl;' .
		'{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space',
	\HeimrichHannot\PinBoard\PinBoard::MODULE_PINBOARD_EDITOR => '{title_legend},name,headline,type;' .
		'{entity_legend},formHybridEditable;{security_legend},addUpdateDeleteConditions;' .
		'{email_legend},formHybridSendSubmissionViaEmail;' .
		'{redirect_legend},jumpToSuccess;{misc_legend},defaultArchive,formHybridAddDefaultValues,setPageTitle;' .
		'{template_legend},formHybridTemplate,itemTemplate,modalTpl,customTpl;{protected_legend:hide},protected;' .
		'{expert_legend:hide},guests,cssID,space',
	\HeimrichHannot\PinBoard\PinBoard::MODULE_PINBOARD_READER => '{title_legend},name,headline,type;' .
		'{security_legend},addShowConditions;{misc_legend},imgSize,useDummyImage,setPageTitle;' .
		'{template_legend},itemTemplate,modalTpl,customTpl;{comment_legend:hide},com_template;' .
		'{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space'
);

$arrDca['palettes'] += $arrPalettes;

/**
 * Callbacks
 */
$arrDca['config']['onload_callback'][] = array('tl_module_pinboard', 'modifyPalette');

class tl_module_pinboard {

	public function modifyPalette()
	{
		$objModule = \ModuleModel::findByPk(\Input::get('id'));
		$arrDca = &$GLOBALS['TL_DCA']['tl_module'];

		if (\HeimrichHannot\Haste\Util\Module::isSubModuleOf(
			$objModule->type, 'HeimrichHannot\PinBoard\ModulePinBoard'))
		{
			$objModule->formHybridDataContainer = 'tl_news';
			$objModule->formHybridPalette = 'pinboard';
			$objModule->showInitialResults = true;
			$objModule->addDetailsCol = true;
			$objModule->sortingMode = OPTION_FORMHYBRID_SORTINGMODE_FIELD;

			if (!$objModule->itemSorting)
				$objModule->itemSorting = 'date_desc';

			if (!$objModule->updateDeleteConditions)
			{
				$objModule->updateDeleteConditions = deserialize(array(
					array(
						'field' => 'memberAuthor',
						'value' => '{{user::id}}'
					)
				));
			}

			if (!$objModule->additionalWhereSql)
				$objModule->additionalWhereSql = '(tl_news.published=1 OR tl_news.memberAuthor="{{user::id}}")';

			$objModule->save();

			$arrDca['fields']['jumpToCreate']['eval']['tl_class'] = 'w50 clr';
			$arrDca['fields']['createMemberGroups']['eval']['tl_class'] = 'w50 clr';

			$arrDca['fields']['jumpToEdit']['eval']['tl_class'] = 'w50';
		}

		if (\HeimrichHannot\Haste\Util\Module::isSubModuleOf(
			$objModule->type, 'HeimrichHannot\PinBoard\ModulePinBoardEditor'))
		{
			$objModule->formHybridDataContainer = 'tl_news';
			$objModule->formHybridPalette = 'pinboard';

			if (!$objModule->updateDeleteConditions)
			{
				$objModule->updateDeleteConditions = serialize(array(
					array(
						'field' => 'memberAuthor',
						'value' => '{{user::id}}'
					)
				));
			}

			if (!$objModule->formHybridDefaultValues)
			{
				$objModule->formHybridDefaultValues = serialize(array(
					array(
						'field' => 'date',
						'value' => '{{date::U}}',
						'label' => ''
					),
					array(
						'field' => 'time',
						'value' => '{{date::U}}',
						'label' => ''
					),
					array(
						'field' => 'source',
						'value' => 'default',
						'label' => ''
					),
					array(
						'field' => 'type',
						'value' => 'pinboard',
						'label' => ''
					),
					array(
						'field' => 'memberAuthor',
						'value' => '{{user::id}}',
						'label' => ''
					),
					array(
						'field' => 'useMemberAuthor',
						'value' => true,
						'label' => ''
					)
				));
			}

			$objModule->save();

			$arrDca['fields']['setPageTitle']['eval']['tl_class'] = 'w50 clr';
		}

		if (\HeimrichHannot\Haste\Util\Module::isSubModuleOf(
			$objModule->type, 'HeimrichHannot\PinBoard\ModulePinBoardReader'))
		{
			$objModule->formHybridDataContainer = 'tl_news';
			$objModule->formHybridPalette = 'pinboard';
			
			if (!$objModule->itemTemplate)
				$objModule->itemTemplate = 'formhybrid_reader_pinboard';

			$objModule->save();
		}
	}

}