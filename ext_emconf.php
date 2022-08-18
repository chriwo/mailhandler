<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'Mail handler',
    'description' => 'Easy way to create email templates and use in other TYPO3 extensions',
    'category' => 'module',
    'author' => 'Christian Wolfram',
    'author_email' => 'c.wolfram@chriwo.de',
    'author_company' => '',
    'state' => 'beta',
    'uploadfolder' => false,
    'modify_tables' => '',
    'clearCacheOnLoad' => true,
    'version' => '2.1.1',
    'constraints' => [
        'depends' => [
            'typo3' => '10.4.0-10.4.99'
        ],
        'conflicts' => [
        ],
        'suggests' => [
        ],
    ],
];
