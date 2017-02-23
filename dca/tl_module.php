<?php

$arrDca = &$GLOBALS['TL_DCA']['tl_module'];

/**
 * Palettes
 */
$arrPalettes = [
    \HeimrichHannot\PinBoard\PinBoard::MODULE_PINBOARD        => '{title_legend},name,headline,type;'
                                                                 . '{list_legend},numberOfItems,perPage,addAjaxPagination,skipFirst,skipInstances,showItemCount,emptyText,'
                                                                 . 'addCreateButton,jumpToDetails,addEditCol,addPublishCol,addDeleteCol;'
                                                                 . '{filter_legend},hideFilter,filterHeadline,customFilterFields,filterArchives,addUpdateDeleteConditions,formHybridAddDefaultValues,'
                                                                 . 'additionalSelectSql,additionalSql;{misc_legend},imgSize,useDummyImage,useModal;'
                                                                 . '{template_legend:hide},formHybridTemplate,formHybridCustomSubTemplates,itemTemplate,customTpl;'
                                                                 . '{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space',
    \HeimrichHannot\PinBoard\PinBoard::MODULE_PINBOARD_EDITOR => '{title_legend},name,headline,type;'
                                                                 . '{entity_legend},formHybridEditable;{security_legend},addUpdateDeleteConditions;'
                                                                 . '{email_legend},formHybridSendSubmissionViaEmail;'
                                                                 . '{redirect_legend},jumpToSuccess;{misc_legend},defaultArchive,formHybridAddDefaultValues,setPageTitle;'
                                                                 . '{template_legend},formHybridTemplate,itemTemplate,modalTpl,customTpl;{protected_legend:hide},protected;'
                                                                 . '{expert_legend:hide},guests,cssID,space',
    \HeimrichHannot\PinBoard\PinBoard::MODULE_PINBOARD_READER => '{title_legend},name,headline,type;'
                                                                 . '{security_legend},addShowConditions;{misc_legend},imgSize,useDummyImage,setPageTitle;'
                                                                 . '{template_legend},itemTemplate,modalTpl,customTpl;{comment_legend:hide},com_template;'
                                                                 . '{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space'
];

$arrDca['palettes'] += $arrPalettes;

/**
 * Callbacks
 */
$arrDca['config']['onload_callback'][] = ['HeimrichHannot\PinBoard\Backend\Module', 'modifyDca'];
$arrDca['config']['onload_callback'][] = ['HeimrichHannot\PinBoard\Backend\Module', 'setDefaults'];