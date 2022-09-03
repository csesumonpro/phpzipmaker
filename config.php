<?php

return [
    'archiveName' => '',
    'archiveDirectory' => '',
    'archiveExtension' => '',
    'includedFiles' => [
        'config.php',
        'style.css',
        'index.php',
        'src/testing/hello.js'
    ],
    'excludedFiles' => [
        'config.php',
    ],
    'includedDirectory' => [
        'src',
    ],
    'excludedDirectory' => [
        'vendor',
        'src/testing'
    ],
];
