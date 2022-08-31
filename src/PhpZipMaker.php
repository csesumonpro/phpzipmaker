<?php

namespace Csesumonpro\PhpZipMaker;

class PhpZipMaker extends \ZipArchive
{
    public $config;

    public function makeZip()
    {
        $this->config = require_once 'config.php';
        $config = $this->config;

        $source = (isset($config['archiveDirectory']) && !empty($config['archiveDirectory'])) ? $config['archiveDirectory'] : getcwd();
        $archiveName = (isset($config['archiveName']) && !empty($config['archiveName'])) ? $config['archiveName'] : 'Archive';
        $archiveExtension = (isset($config['archiveExtension']) && !empty($config['archiveExtension'])) ? $config['archiveExtension'] : '.zip';
        $archive = $archiveName . $archiveExtension;

        if (!extension_loaded('zip') || !file_exists($source)) {
            return false;
        }

        if (file_exists($archive)) {
            exit('File already exists!');
        }

        if (!$this->open($archive, static::CREATE)) {
            return false;
        }

        if (is_dir($source) === true) {
            $this->isDirectory($source, $source);
        } elseif (is_file($source) === true) {
            $this->isFile($source, $source);
        }

        $this->close();
    }

    public function isFile($filePath, $fileName)
    {
        $config = $this->config;
        $source = (isset($config['archiveDirectory']) && !empty($config['archiveDirectory'])) ? $config['archiveDirectory'] : getcwd();

        $this->addFromString(str_replace($source . '/', '', $filePath), file_get_contents($filePath));
    }

    public function isDirectory($directoryPath, $directoryName)
    {
        $files = scandir($directoryPath);

        foreach ($files as $fileName) {
            if ($fileName === '.' || $fileName === '..') {
                continue;
            }

            $filePath = realpath($directoryPath . '/' . $fileName);
            if (is_file($filePath) === true) {
                if ($this->fileIsAllowed($fileName) || $this->directoryIsAllowed($directoryName)) {
                    $this->isFile($filePath, $fileName);
                }
            } else if (is_dir($fileName) === true) {
                if ($this->directoryIsAllowed($fileName)) {
                    $this->isDirectory($filePath, $fileName);
                }
            }
        }
    }

    public function fileIsAllowed($fileName)
    {
        $config = $this->config;
        $includedFiles = (isset($config['includedFiles']) && !empty($config['includedFiles'])) ? $config['includedFiles'] : [];
        $excludedFiles = (isset($config['excludedFiles']) && !empty($config['excludedFiles'])) ? $config['excludedFiles'] : [];

        if (in_array($fileName, $includedFiles) && !in_array($fileName, $excludedFiles)) {
            return true;
        }
    }

    public function directoryIsAllowed($directoryName)
    {
        $config = $this->config;
        $includedDirectory = (isset($config['includedDirectory']) && !empty($config['includedDirectory'])) ? $config['includedDirectory'] : [];
        $excludedDirectory = (isset($config['excludedDirectory']) && !empty($config['excludedDirectory'])) ? $config['excludedDirectory'] : [];

        if (in_array($directoryName, $includedDirectory) && !in_array($directoryName, $excludedDirectory)) {
            return true;
        }
    }
}

