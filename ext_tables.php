<?php
defined('TYPO3_MODE') || die();

(function () {
   if (TYPO3_MODE === 'BE') {
        foreach (['mail'] as $table) {
            \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr(
                'tx_mailhandler_domain_model_' . $table,
                'EXT:mailhandler/Resources/Private/Language/locallang_csh_' . $table . '.xlf'
            );
        }
   }
})();
