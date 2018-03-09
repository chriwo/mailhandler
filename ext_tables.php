<?php
defined('TYPO3_MODE') || die();

$boot = function () {
    // CSH - context sensitive help
    foreach (['mail'] as $table) {
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages(
            'tx_mailhandler_domain_model_' . $table
        );
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr(
            'tx_mailhandler_domain_model_' . $table,
            'EXT:mailhandler/Resources/Private/Language/locallang_csh_' . $table . '.xlf'
        );
    }
};

$boot();
unset($boot);
