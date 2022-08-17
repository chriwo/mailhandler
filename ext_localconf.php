<?php
defined('TYPO3_MODE') || die();

(function () {
    if (TYPO3_MODE === 'BE') {
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addService(
            'mailhandler',
            'submitmail',
            'tx_mailhandler_submitmail',
            [
                'title' => 'Mailhandler',
                'description' => 'Mailhandling',
                'subtype' => '',
                'available' => true,
                'priority' => 60,
                'quality' => 80,
                'os' => '',
                'exec' => '',
                'className' => \ChriWo\Mailhandler\Service\MailService::class,
            ]
        );

        $iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);
        $icons = [
            'pagetree-folder-contains-mailhandler' => 'Module/module_mail.png',
            'mailhandler-table-mail' => 'Table/table_mail.png'
        ];

        foreach ($icons as $identifier => $file) {
            $iconRegistry->registerIcon(
                $identifier,
                \TYPO3\CMS\Core\Imaging\IconProvider\BitmapIconProvider::class,
                ['source' => 'EXT:mailhandler/Resources/Public/Backend/Icon/' . $file]
            );
        }
    }
})();
