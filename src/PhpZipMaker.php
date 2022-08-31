<?php

namespace Csesumonpro\PhpZipMaker;

class PhpZipMaker extends \ZipArchive
{
    public function makeZip()
    {
        $config = $this->getConfig();
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
            $files = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($source), \RecursiveIteratorIterator::SELF_FIRST);
            foreach ($files as $file) {
                $file = str_replace('\\', '/', $file);
                $fileName = substr($file, strrpos($file, '/') + 1);

                // Ignore "." and ".." folders
                if (in_array($fileName, array('.', '..')))
                    continue;

                $file = realpath($file);
                $this->addFileToArchive($source, $file, $fileName, $config);
            }

        } else if (is_file($source) === true) {
            $this->addFromString(basename($source), file_get_contents($source));
        }

        $this->close();
    }

    public function addFileToArchive($source, $file, $fileName, $config)
    {
        $includedFiles = isset($config['includedFiles']) ? $config['includedFiles'] : [];
        $excludedFiles = isset($config['excludedFiles']) ? $config['excludedFiles'] : [];
        $checkIncluded = in_array($fileName, $includedFiles);
        $checkExcluded = in_array($fileName, $excludedFiles);

        if ($checkIncluded && !$checkExcluded && is_file($file) === true) {
            $this->addFromString(str_replace($source . '/', '', $file), file_get_contents($file));
        }
    }

    public function getConfig()
    {
        $config = require_once 'config.php';
        return $config;
    }
}

