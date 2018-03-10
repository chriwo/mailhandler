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
};

$boot();
unset($boot);
