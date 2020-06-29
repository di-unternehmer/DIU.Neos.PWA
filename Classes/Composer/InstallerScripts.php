<?php
namespace DIU\Neos\PWA\Composer;

use Composer\DependencyResolver\Operation\InstallOperation;
use Composer\DependencyResolver\Operation\UpdateOperation;
use Composer\Script\Event;
use Composer\Installer\PackageEvent;
use DIU\Neos\PWA\Service\PwaService;
use Neos\Flow\Package\PackageManager;
use Neos\Utility\Files;

/**
 * Class for Composer install scripts
 */
class InstallerScripts
{

    /**
     * Make sure required paths and files are available outside of Package
     * Run on every Composer install or update - must be configured in root manifest
     *
     * @param Event $event
     * @return void
     */
    public static function postInstallCreateFile(Event $event){
        if (!defined('FLOW_PATH_ROOT')) {
            define('FLOW_PATH_ROOT', Files::getUnixStylePath(getcwd()) . '/');
        }

        echo "hello world";

        \Neos\Flow\var_dump($event);

        $pwaService = new PwaService();
        $pwaService->create();
    }
}
