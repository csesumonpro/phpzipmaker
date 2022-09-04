
[![Total Downloads](https://poser.pugx.org/csesumonpro/phpzipmaker/downloads)](https://packagist.org/packages/csesumonpro/phpzipmaker)
[![License](https://poser.pugx.org/csesumonpro/phpzipmaker/license)](https://packagist.org/packages/csesumonpro/phpzipmaker)
[![Latest Stable Version](https://poser.pugx.org/csesumonpro/phpzipmaker/v/stable)](https://packagist.org/packages/csesumonpro/phpzipmaker)

>### PHP Zip Maker
Php zip maker is a simple library to create archive for your project with the selected file or folder.
>### Installation

Install the package through [Composer](http://getcomposer.org/).

For PHP 5.6 or 5.6~:
<code> composer require "csesumonpro/phpzipmaker </code>

**Note: If your project doesn't have any composer.json file, you can use it by downloading the zip file from the github repository.**

>### Configuration
Just need to set an .xml file in your project root with the following code:
and the name must be **phpzipmaker.xml**

```xml
<?xml version="1.0"?>
<ruleset name="Php Zip Maker">
    <archiveName>phpzipmaker</archiveName>
    <archiveExtension>.zip</archiveExtension>
    <archiveFormDirectory>/Volumes/Projects/plugins/phpzipmaker</archiveFormDirectory>
    <archiveToDirectory>/Users/csesumonpro/desktop</archiveToDirectory>

    <include-file>
        <include>index.php</include>
        <include>config.php</include>
    </include-file>

    <exclude-file>
        <exclude>app/Controllers/HomeController.php</exclude>
    </exclude-file>

    <include-directory>
        <include>app</include>
        <include>vendor</include>
    </include-directory>

    <exclude-directory>
        <exclude>app/Models</exclude>
        <exclude>vendor/phpzipmaker</exclude>
    </exclude-directory>

</ruleset>
```
>### XML Description
**archiveName** - The name of the archive file. **(optional)** It will automatically get the name of your project when you do not provide any name.<br/><br/>
**archiveExtension** - The extension of the archive file. **(optional)** It will automatically set .zip extension when you do not provide any extension. <br/>
***Supported Extensions:***
```
['.zip', '.rar', '.tar', '.gz', '.bz2', '.7z']
```
**archiveFormDirectory** - The directory of the archive file. **(optional)** It will automatically get the directory path of your project when you do not provide any directory path.<br/><br/>
**archiveToDirectory** - The directory where the archive file will be saved. **(optional)** It will automatically get the directory path of your project when you do not provide any directory path.<br/><br/>
**include-file** - The file that you want to include in the archive file. **(required)**<br/><br/>
**exclude-file** - The file that you want to exclude in the archive file. **(optional)**<br/><br/>
**include-directory** - The directory that you want to include in the archive file. **(optional)**<br/><br/>
**exclude-directory** - The directory that you want to exclude in the archive file. **(optional)**<br/>

>### Usage
It's very easy to make an archive through the above XML config just run the below command from your project root. <br/><br/>
<code>php ./vendor/phpzipmaker/phpzipmaker.php</code>

>### UseCase
Suppose you have a project with the following structure:
```
project
├── app
│   ├── Controllers
│   │   └── HomeController.php
│   ├── Models
│   │   └── User.php
│   └── Views
│       └── home.php
├── vendor
│   ├── autoload.php
│   ├── composer
│   │   ├── autoload_classmap.php
│   │   ├── autoload_files.php
│   │   ├── autoload_namespaces.php
│   │   ├── autoload_psr4.php
│   │   ├── autoload_real.php
│   │   ├── autoload_static.php
│   │   ├── ClassLoader.php
│   │   └── installed.json
│   └── phpzipmaker
│       ├── LICENSE
│       ├── README.md
│       ├── composer.json
│       ├── phpzipmaker.php
│       └── src
│           ├── PhpZipMaker.php
|index.php
|config.php

```
If you want to include a file just use it like this:
```xml
<include-file>
    <include>index.php</include>
</include-file>
```
If you want to include a file from a directory that directory already excluded you can do it
```xml
<include-file>
    <include>vendor/phpzipmaker/phpzipmaker.php</include>
</include-file>
```
if you want to include a directory which directory have many other files and directory
```xml
<include-directory>
    <include>app</include>
</include-directory>
```
if you want to exclude a file from an included directory you can do it

```xml 
<exclude-file>
    <exclude>app/Controllers/HomeController.php</exclude>
</exclude-file>
```
If you want to exclude a directory that directory already included you can do it
```xml
<exclude-directory>
    <exclude>app/Models</exclude>
</exclude-directory>
```



>### Reference

[Packagist](https://packagist.org/packages/csesumonpro/phpzipmaker) || 
[Github](https://packagist.org/packages/csesumonpro/phpzipmaker)

>### License

The **php zip maker** is an open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
