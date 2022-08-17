<?php

defined('TYPO3') || die();

$GLOBALS['TCA']['pages']['columns']['module']['config']['items'][] = [
    0 => 'LLL:EXT:mailhandler/Resources/Private/Language/locallang_be.xlf:mailhandler-folder',
    1 => 'mailhandler',
    2 => 'pagetree-folder-contains-mailhandler'
];

$GLOBALS['TCA']['pages']['ctrl']['typeicon_classes']['contains-mailhandler'] = 'pagetree-folder-contains-mailhandler';
