<?php

namespace Csesumonpro\PhpZipMaker;

class PhpZipMaker extends \ZipArchive
{
    public $config;

    public function makeZip($getConfig = null)
    {
        $this->config = $getConfig;
        $source = $this->config['archiveFormDirectory'];
        $archive = $this->config['archiveToDirectory'] . "/" . $this->config['archiveName'] . $this->config['archiveExtension'];

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
        $source = $this->config['archiveFormDirectory'];
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
                if ($this->fileIsAllowed($filePath, $fileName) || $this->directoryIsAllowed($filePath, $directoryName)) {
                    $this->isFile($filePath, $fileName);
                }
            } else if (is_dir($filePath) === true) {
                $this->isDirectory($filePath, $fileName);
            }
        }
    }

    public function fileIsAllowed($filePath, $fileName)
    {
        $includedFiles = $this->config['includedFiles'];
        $excludedFiles = $this->config['excludedFiles'];
        $fileNameWithPath = str_replace($this->config['archiveFormDirectory'] . "/", "", $filePath);

        if (in_array($fileNameWithPath, $includedFiles) && !in_array($fileNameWithPath, $excludedFiles)) {
            return true;
        }
    }

    public function directoryIsAllowed($directoryPath, $directoryName)
    {
        $includedDirectory = $this->config['includedDirectory'];
        $excludedDirectory = $this->config['excludedDirectory'];
        $excludedFiles = $this->config['excludedFiles'];
        $fileNameWithPath = str_replace($this->config['archiveFormDirectory'] . "/", "", $directoryPath);

        $directoryArray = explode("/", $fileNameWithPath);
        // Remove last item from it's a file not directory
        array_pop($directoryArray);
        $directoryNameWithPath = implode('/', $directoryArray);

        $modifyDirectoryArray = [];
        $newPath = '';

        foreach ($directoryArray as $path) {
            $newPath .= $path . "/";
            $modifyDirectoryArray[] = $newPath;
        }

        // Removed slash from last
        $modifyDirectoryPath = array_map(function ($item) {
            return rtrim($item, '/');
        }, $modifyDirectoryArray);

        $isChildDirectory = (isset($modifyDirectoryPath[0]) && in_array($modifyDirectoryPath[0], $includedDirectory));
        $isDirectoryIncluded = in_array($directoryNameWithPath, $includedDirectory);
        $isFileExcluded = in_array($fileNameWithPath, $excludedFiles);
        $isDirectoryExcluded = $this->arrayInArray($excludedDirectory, $modifyDirectoryPath);

        if (($isChildDirectory || $isDirectoryIncluded) && !$isFileExcluded && !$isDirectoryExcluded) {
            return true;
        }
    }

    public function arrayInArray($needles, $haystack)
    {
        return !empty(array_intersect($needles, $haystack));
    }
}

