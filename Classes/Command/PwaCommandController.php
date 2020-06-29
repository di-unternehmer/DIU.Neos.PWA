<?php
namespace DIU\Neos\PWA\Command;

/*                                                                        *
 * This script belongs to the package "DIU.Neos.PWA".                *
 *                                                                        */

use DIU\Neos\PWA\Service\PwaService;
use Neos\Flow\Annotations as Flow;
use Neos\Flow\Cli\CommandController;
use Neos\Flow\Cli\Exception\StopCommandException;
use Neos\Utility\Files;

/**
 * PWA command controller for the DIU.Neos.PWA package
 *
 * @Flow\Scope("singleton")
 */
class PwaCommandController extends CommandController
{
    const WORKBOX_CONFIG_JS_FILENAME = 'workbox-config.js';

    /**
     * @Flow\Inject
     * @var PwaService
     */
    protected $pwaService;

    /**
     * @Flow\InjectConfiguration(path="Workbox")
     * @var array
     */
    protected $workbox = array();

    /**
     * Creates a workbox-config.json
     *
     * This command will create a workbox-config.js to allow execution of workbox-clid generateSW
     *
     * It checks if the file exist and creates a new file only if the workbox file doesn't exist yet.
     * The configuration is stored in Settings.Workbox.yaml
     *
     * @return void
     */
    public function createCommand()
    {
        $this->pwaService->create();
    }

    /**
     * Creates a workbox-config.json
     *
     * This command will update an existing workbox-config.js
     *
     * It checks if the file exist and updates an existing file.
     * The configuration is stored in Settings.Workbox.yaml
     *
     * @return void
     */
    public function updateCommand()
    {
        $this->pwaService->update();
    }

}
