<?php
defined('TYPO3_MODE') || die();

$boot = function () {
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addService(
        'mailhandler',
        // Service type
        'submitmail',
        // Service key
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

    if (TYPO3_MODE === 'BE') {
        $icons = [
            'pagetree-folder-contains-mailhandler' => 'ext-news-folder-tree.svg',
        ];
        $iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);
        foreach ($icons as $identifier => $path) {
            $iconRegistry->registerIcon(
                $identifier,
                \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
                ['source' => 'EXT:news/Resources/Public/Icons/' . $path]
            );
        }
    }
};

$boot();
unset($boot);
