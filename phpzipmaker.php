<?php

// require autoloader
require_once __DIR__ . '/vendor/autoload.php';

$xml = simplexml_load_file('phpzipmaker.xml', 'SimpleXMLElement', LIBXML_NOWARNING);

if ($xml) {
    $config = json_decode(json_encode($xml), true);
    $includeFiles = (isset($config['include-file'])) ? $config['include-file'] : [];
    $excludeFiles = (isset($config['exclude-file'])) ? $config['exclude-file'] : [];
    $includeDirectory = (isset($config['include-directory'])) ? $config['include-directory'] : [];
    $excludeDirectory = (isset($config['exclude-directory'])) ? $config['exclude-directory'] : [];

    $archiveFormDirectory = (isset($config['archiveFormDirectory']) && !empty($config['archiveFormDirectory'])) ? $config['archiveFormDirectory'] : getcwd();
    $pathToArray = explode("/", $archiveFormDirectory);
    $generatedName = end($pathToArray);
    $archiveName = (isset($config['archiveName']) && !empty($config['archiveName'])) ? $config['archiveName'] : $generatedName;
    $supportedExtensions = ['.zip', '.rar', '.tar', '.gz', '.bz2', '.7z'];

    $setConfig = [
        'archiveName' => $archiveName,
        'archiveFormDirectory' => $archiveFormDirectory,
        'archiveToDirectory' => (isset($config['archiveToDirectory']) && !empty($config['archiveToDirectory'])) ? $config['archiveToDirectory'] : getcwd(),
        'archiveExtension' => (isset($config['archiveExtension']) && !empty($config['archiveExtension']))  && in_array($config['archiveExtension'], $supportedExtensions) ? $config['archiveExtension'] : '.zip',
        'includedFiles' => (isset($includeFiles['include']) && !empty($includeFiles['include'])) ? (array)$includeFiles['include'] : [],
        'excludedFiles' => (isset($excludeFiles['exclude']) && !empty($excludeFiles['exclude'])) ? (array)$excludeFiles['exclude'] : [],
        'includedDirectory' => (isset($includeDirectory['include']) && !empty($includeDirectory['include'])) ? (array)$includeDirectory['include'] : [],
        'excludedDirectory' => (isset($excludeDirectory['exclude']) && !empty($excludeDirectory['exclude'])) ? (array)$excludeDirectory['exclude'] : [],
    ];

    (new \Csesumonpro\PhpZipMaker\PhpZipMaker())->makeZip($setConfig);
} else {
    echo 'Error: Cannot load xml file';
}


