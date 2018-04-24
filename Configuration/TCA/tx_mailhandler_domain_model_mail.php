<?php
defined('TYPO3_MODE') || die();

$coreLanguage = 'LLL:EXT:lang/Resources/Private/Language/locallang_tca.xlf:';
$llDb = 'LLL:EXT:mailhandler/Resources/Private/Language/locallang_db.xlf:';
$model = 'tx_mailhandler_domain_model_mail';

return [
    'ctrl' => [
        'title' => $llDb . $model,
        'label' => 'mail_subject',
        'hideAtCopy' => true,
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'versioningWS' => true,
        'origUid' => 't3_origuid',
        'editlock' => 'editlock',
        'dividers2tabs' => true,
        'languageField' => 'sys_language_uid',
        'transOrigPointerField' => 'l10n_parent',
        'transOrigDiffSourceField' => 'l10n_diffsource',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
        ],
        'searchFields' => 'mail_subject,mail_receiver,mail_sender',
        'iconfile' => 'EXT:mailhandler/Resources/Public/Icon/Backend/mailhandler_domain_model_mail.png',
    ],
    'interface' => [
        'showRecordFieldList' => 'cruser_id,pid,sys_language_uid,l10n_parent,l10n_diffsource,hidden,'
            . 'crdate,mail_subject,mail_body,mail_receiver,mail_sender,mail_receiver_cc,mail_return_path,mail_reply_to',
    ],
    'columns' => [
        'sys_language_uid' => [
            'exclude' => true,
            'label' => 'LLL:EXT:lang/Resources/Private/Language/locallang_general.xlf:LGL.language',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'sys_language',
                'foreign_table_where' => 'ORDER BY sys_language.title',
                'items' => [
                    [
                        'LLL:EXT:lang/Resources/Private/Language/locallang_general.xlf:LGL.allLanguages',
                        -1,
                        'flags-multiple',
                    ],
                ],
                'default' => 0,
            ],
        ],
        'l10n_parent' => [
            'displayCond' => 'FIELD:sys_language_uid:>:0',
            'exclude' => true,
            'label' => 'LLL:EXT:lang/Resources/Private/Language/locallang_general.xlf:LGL.l18n_parent',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['', 0],
                ],
                'foreign_table' => $model,
                'foreign_table_where' => 'AND ' . $model . '.pid=###CURRENT_PID### AND ' . $model . '.sys_language_uid IN (-1,0)',
                'default' => 0,
            ],
        ],
        'l10n_diffsource' => [
            'config' => [
                'type' => 'passthrough',
                'default' => '',
            ],
        ],
        'hidden' => [
            'exclude' => true,
            'label' => 'LLL:EXT:lang/Resources/Private/Language/locallang_general.xlf:LGL.hidden',
            'config' => [
                'type' => 'check',
                'default' => 0,
            ],
        ],
        'cruser_id' => [
            'label' => 'cruser_id',
            'config' => [
                'type' => 'passthrough',
            ],
        ],
        'pid' => [
            'label' => 'pid',
            'config' => [
                'type' => 'passthrough',
            ],
        ],
        'crdate' => [
            'label' => 'crdate',
            'config' => [
                'type' => 'passthrough',
            ],
        ],
        'tstamp' => [
            'label' => 'tstamp',
            'config' => [
                'type' => 'passthrough',
            ],
        ],
        'sorting' => [
            'label' => 'sorting',
            'config' => [
                'type' => 'passthrough',
            ],
        ],
        'editlock' => [
            'exclude' => true,
            'l10n_mode' => 'mergeIfNotBlank',
            'label' => '' . $coreLanguage . 'editlock',
            'config' => [
                'type' => 'check',
            ],
        ],
        'mail_subject' => [
            'exclude' => false,
            'l10n_mode' => 'prefixLangTitle',
            'label' => $llDb . $model . '.mail_subject',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,required',
            ],
        ],
        'mail_body' => [
            'exclude' => false,
            'l10n_mode' => 'noCopy',
            'label' => $llDb . $model . '.mail_body',
            'config' => [
                'type' => 'text',
                'cols' => 30,
                'rows' => 5,
                'softref' => 'rtehtmlarea_images,typolink_tag,images,email[subst],url',
                'wizards' => [
                    '_PADDING' => 2,
                    'RTE' => [
                        'notNewRecords' => 1,
                        'RTEonly' => 1,
                        'type' => 'script',
                        'title' => 'Full screen Rich Text Editing',
                        'icon' => 'actions-wizard-rte',
                        'module' => [
                            'name' => 'wizard_rte',
                        ],
                    ],
                ],
                'eval' => 'trim,required',
            ],
        ],
        'mail_receiver' => [
            'exclude' => true,
            'l10n_mode' => 'mergeIfNotBlank',
            'label' => $llDb . $model . '.mail_receiver',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'placeholder' => $llDb . $model . '.mail_receiver.placeholder',
                'eval' => 'trim',
            ],
        ],
        'mail_sender' => [
            'exclude' => true,
            'l10n_mode' => 'mergeIfNotBlank',
            'label' => $llDb . $model . '.mail_sender',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'placeholder' => $llDb . $model . '.mail_sender.placeholder',
                'eval' => 'trim',
            ],
        ],
        'mail_receiver_cc' => [
            'exclude' => false,
            'l10n_mode' => 'mergeIfNotBlank',
            'label' => $llDb . $model . '.mail_receiver_cc',
            'config' => [
                'type' => 'text',
                'cols' => 30,
                'rows' => 3,
                'wrap' => 'off',
                'placeholder' => $llDb . $model . '.mail_receiver_cc.placeholder',
                'eval' => 'trim',
            ],
        ],
        'mail_receiver_bcc' => [
            'exclude' => false,
            'l10n_mode' => 'mergeIfNotBlank',
            'label' => $llDb . $model . '.mail_receiver_bcc',
            'config' => [
                'type' => 'text',
                'cols' => 30,
                'rows' => 3,
                'wrap' => 'off',
                'placeholder' => $llDb . $model . '.mail_receiver_bcc.placeholder',
                'eval' => 'trim',
            ],
        ],
        'mail_return_path' => [
            'exclude' => false,
            'label' => $llDb . $model . '.mail_return_path',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'placeholder' => $llDb . $model . '.mail_return_path.placeholder',
                'eval' => 'trim,email',
            ],
        ],
        'mail_reply_to' => [
            'exclude' => false,
            'label' => $llDb . $model . '.mail_reply_to',
            'config' => [
                'type' => 'text',
                'cols' => 30,
                'rows' => 3,
                'wrap' => 'off',
                'placeholder' => $llDb . $model . '.mail_reply_to.placeholder',
                'eval' => 'trim',
            ],
        ],
        'mail_attachment' => [
            'exclude' => true,
            'l10n_mode' => 'mergeIfNotBlank',
            'label' => $llDb . $model . '.mail_attachment',
            'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
                'mail_attachment',
                [
                    'appearance' => [
                        'createNewRelationLinkTitle' => $llDb . $model . '.mail_attachment.add',
                        'showPossibleLocalizationRecords' => true,
                        'showRemovedLocalizationRecords' => true,
                        'showAllLocalizationLink' => true,
                        'showSynchronizationLink' => true,
                    ],
                    'foreign_match_fields' => [
                        'fieldname' => 'mail_attachment',
                        'tablenames' => $model,
                        'table_local' => 'sys_file',
                    ],
                    // custom configuration for displaying fields in the overlay/reference table
                    // to use the newsPalette and imageoverlayPalette instead of the basicoverlayPalette
                    'foreign_types' => [
                        '0' => [
                            'showitem' => '
						--palette--;' . $coreLanguage . 'sys_file_reference.imageoverlayPalette;imageoverlayPalette,
						--palette--;;filePalette',
                        ],
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_TEXT => [
                            'showitem' => '
						--palette--;' . $coreLanguage . 'sys_file_reference.imageoverlayPalette;imageoverlayPalette,
						--palette--;;filePalette',
                        ],
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_IMAGE => [
                            'showitem' => '
						--palette--;' . $coreLanguage . 'sys_file_reference.imageoverlayPalette;imageoverlayPalette,
						--palette--;;filePalette',
                        ],
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_AUDIO => [
                            'showitem' => '
						--palette--;' . $coreLanguage . 'sys_file_reference.imageoverlayPalette;imageoverlayPalette,
						--palette--;;filePalette',
                        ],
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_VIDEO => [
                            'showitem' => '
						--palette--;' . $coreLanguage . 'sys_file_reference.imageoverlayPalette;imageoverlayPalette,
						--palette--;;filePalette',
                        ],
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_APPLICATION => [
                            'showitem' => '
                        --palette--;' . $coreLanguage . 'sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                        --palette--;;filePalette',
                        ],
                    ],
                    'overrideChildTca' => [
                        'types' => [
                            \TYPO3\CMS\Core\Resource\File::FILETYPE_IMAGE => [
                                'showitem' => '
                            --palette--;' . $coreLanguage . 'sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                            --palette--;;filePalette',
                            ],
                        ],
                    ],
                ],
                $GLOBALS['TYPO3_CONF_VARS']['SYS']['mediafile_ext']
            ),
        ],
    ],
    'types' => [
        '0' => [
            'columnsOverrides' => [
                'mail_body' => [
                    'defaultExtras' => 'richtext:rte_transform[mode=ts_css]',
                ],
            ],
            'showitem' => 'mail_subject, mail_body, mail_attachment,'
                . '--div--;' . $llDb . 'tab.senderReceiver,'
                . '---palette--;' . $llDb . 'palette.sender;paletteSender,'
                . '---palette--;' . $llDb . 'palette.receiver;paletteReceiver,'
                . '--div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access,'
                . '--palette--;;paletteCore,editlock',
        ],
    ],
    'palettes' => [
        'paletteCore' => [
            'showitem' => 'hidden, sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource,',
        ],
        'paletteReceiver' => [
            'showitem' => 'mail_receiver, --linebreak--, mail_receiver_cc, mail_receiver_bcc, --linebreak--,'
                . 'mail_reply_to, mail_return_path',
        ],
        'paletteSender' => [
            'showitem' => 'mail_sender',
        ],
    ],
];
