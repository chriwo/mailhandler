<?php
defined('TYPO3_MODE') || die();

$model = 'tx_mailhandler_domain_model_mail';
$translationFile = 'LLL:EXT:mailhandler/Resources/Private/Language/locallang_db.xlf';
$translationFileKey = $translationFile . ':' . $model;
$coreLanguage = 'LLL:EXT:lang/Resources/Private/Language/locallang_tca.xlf';

return [
    'ctrl' => [
        'title' => $translationFile,
        'label' => 'mail_subject',
        'hideAtCopy' => true,
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'versioningWS' => true,
        'origUid' => 't3_origuid',
        'editlock' => 'editlock',
        'languageField' => 'sys_language_uid',
        'transOrigPointerField' => 'l10n_parent',
        'transOrigDiffSourceField' => 'l10n_diffsource',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
            'starttime' => 'starttime',
            'endtime' => 'endtime',
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
                'special' => 'languages',
                'items' => [
                    [
                        'LLL:EXT:lang/Resources/Private/Language/locallang_general.xlf:LGL.allLanguages',
                        -1,
                        'flags-multiple'
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
                'foreign_table_where' => 'AND ' . $model . '.pid=###CURRENT_PID### AND '
                    . $model . '.sys_language_uid IN (-1,0)',
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
        'starttime' => [
            'exclude' => true,
            'label' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:starttime_formlabel',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'size' => 16,
                'eval' => 'datetime,int',
                'default' => 0,
                'behaviour' => [
                    'allowLanguageSynchronization' => true,
                ],
            ]
        ],
        'endtime' => [
            'exclude' => true,
            'label' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:endtime_formlabel',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'size' => 16,
                'eval' => 'datetime,int',
                'default' => 0,
                'behaviour' => [
                    'allowLanguageSynchronization' => true,
                ],
            ]
        ],
        'editlock' => [
            'exclude' => true,
            'label' => $coreLanguage . ':editlock',
            'config' => [
                'type' => 'check',
                'default' => 0,
                'behaviour' => [
                    'allowLanguageSynchronization' => true,
                ],
            ],
        ],
        'mail_subject' => [
            'exclude' => false,
            'l10n_mode' => 'prefixLangTitle',
            'label' => $translationFileKey . '.mail_subject',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,required',
            ],
        ],
        'mail_body' => [
            'exclude' => false,
            'label' => $translationFileKey . '.mail_body',
            'config' => [
                'type' => 'text',
                'cols' => 30,
                'rows' => 5,
                'softref' => 'rtehtmlarea_images,typolink_tag,images,email[subst],url',
                'wizards' => [
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
            'label' => $translationFileKey . '.mail_receiver',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'placeholder' => $translationFileKey . '.mail_receiver.placeholder',
                'eval' => 'trim',
                'behaviour' => [
                    'allowLanguageSynchronization' => true,
                ],
            ],
        ],
        'mail_sender' => [
            'exclude' => true,
            'label' => $translationFileKey . '.mail_sender',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'placeholder' => $translationFileKey . '.mail_sender.placeholder',
                'eval' => 'trim',
                'behaviour' => [
                    'allowLanguageSynchronization' => true,
                ],
            ],
        ],
        'mail_receiver_cc' => [
            'exclude' => false,
            'label' => $translationFileKey . '.mail_receiver_cc',
            'config' => [
                'type' => 'text',
                'cols' => 30,
                'rows' => 3,
                'wrap' => 'off',
                'placeholder' => $translationFileKey . '.mail_receiver_cc.placeholder',
                'eval' => 'trim',
                'behaviour' => [
                    'allowLanguageSynchronization' => true,
                ],
            ],
        ],
        'mail_receiver_bcc' => [
            'exclude' => false,
            'label' => $translationFileKey . '.mail_receiver_bcc',
            'config' => [
                'type' => 'text',
                'cols' => 30,
                'rows' => 3,
                'wrap' => 'off',
                'placeholder' => $translationFileKey . '.mail_receiver_bcc.placeholder',
                'eval' => 'trim',
                'behaviour' => [
                    'allowLanguageSynchronization' => true,
                ],
            ],
        ],
        'mail_return_path' => [
            'exclude' => false,
            'label' => $translationFileKey . '.mail_return_path',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'placeholder' => $translationFileKey . '.mail_return_path.placeholder',
                'eval' => 'trim,email',
                'behaviour' => [
                    'allowLanguageSynchronization' => true,
                ],
            ],
        ],
        'mail_reply_to' => [
            'exclude' => false,
            'label' => $translationFileKey . '.mail_reply_to',
            'config' => [
                'type' => 'text',
                'cols' => 30,
                'rows' => 3,
                'wrap' => 'off',
                'placeholder' => $translationFileKey . '.mail_reply_to.placeholder',
                'eval' => 'trim',
                'behaviour' => [
                    'allowLanguageSynchronization' => true,
                ],
            ],
        ],
        'mail_attachment' => [
            'exclude' => true,
            'l10n_mode' => 'mergeIfNotBlank',
            'label' => $translationFileKey . '.mail_attachment',
            'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
                'mail_attachment',
                [
                    'appearance' => [
                        'createNewRelationLinkTitle' => $translationFileKey . '.mail_attachment.add',
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
						--palette--;' . $coreLanguage . ':sys_file_reference.imageoverlayPalette;imageoverlayPalette,
						--palette--;;filePalette',
                        ],
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_TEXT => [
                            'showitem' => '
						--palette--;' . $coreLanguage . ':sys_file_reference.imageoverlayPalette;imageoverlayPalette,
						--palette--;;filePalette',
                        ],
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_IMAGE => [
                            'showitem' => '
						--palette--;' . $coreLanguage . ':sys_file_reference.imageoverlayPalette;imageoverlayPalette,
						--palette--;;filePalette',
                        ],
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_APPLICATION => [
                            'showitem' => '
                        --palette--;' . $coreLanguage . ':sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                        --palette--;;filePalette',
                        ],
                    ],
                ],
                'jpg,jpeg,png,pdf'
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
                . '--div--;' . $translationFile . ':tab.senderReceiver,'
                . '---palette--;;paletteSender,'
                . '---palette--;;paletteReceiver,'
                . '--div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access,'
                . '--palette--;;paletteCore,'
                . '--palette--;;paletteAccess',
        ],
    ],
    'palettes' => [
        'paletteCore' => [
            'showitem' => 'hidden, sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource,',
        ],
        'paletteAccess' => [
            'label' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.access',
            'showitem' => '
                starttime;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:starttime_formlabel,
                endtime;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:endtime_formlabel,
                --linebreak--,
                fe_group;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:fe_group_formlabel,
                --linebreak--,editlock
            ',
        ],
        'paletteReceiver' => [
            'label' => $translationFile . ':palette.receiver',
            'showitem' => 'mail_receiver, --linebreak--, mail_receiver_cc, mail_receiver_bcc, --linebreak--,'
                . 'mail_reply_to, mail_return_path',
        ],
        'paletteSender' => [
            'label' => $translationFile . ':palette.sender',
            'showitem' => 'mail_sender',
        ],
    ],
];
