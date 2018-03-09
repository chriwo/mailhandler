<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'Mail handler',
    'description' => '',
    'category' => 'module',
    'author' => 'Christian Wolfram',
    'author_email' => 'c.wolfram@chriwo.de',
    'author_company' => '',
    'state' => 'beta',
    'uploadfolder' => false,
    'modify_tables' => '',
    'clearCacheOnLoad' => true,
    'version' => '1.0.0',
    'constraints' => [
        'depends' => [
            'typo3' => '8.7.0-8.7.99',
        ],
        'conflicts' => [
        ],
        'suggests' => [
        ],
    ],
    'autoload' => [
        'psr-4' => [
            'ChriWo\\Mailhandler\\' => 'Classes'
        ]
    ]
];
