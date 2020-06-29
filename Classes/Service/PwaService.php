<?php
namespace DIU\Neos\PWA\Service;

/*                                                                        *
 * This script belongs to the package "DIU.Neos.PWA".                *
 *                                                                        */

use Exception;
use Neos\Flow\Annotations as Flow;
use Neos\Flow\Cli\CommandController;
use Neos\Flow\Cli\Exception\StopCommandException;
use Neos\Utility\Files;


class PwaService
{
    const WORKBOX_CONFIG_JS_FILENAME = 'workbox-config.js';

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
    public function create()
    {
        try {
            if (!file_exists($this->getFilePathAndName())) {

                file_put_contents($this->getFilePathAndName(), $this->createFileContent());
                echo 'OK - File created';
            } else {
                echo 'File exist already. Use "update" if you want to update the file';
            }
        } catch (Exception $e) {
            echo '<b>' . $e->getMessage() . '</b>';
        }
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
    public function update()
    {
        try {
            if (file_exists($this->getFilePathAndName())) {
                file_put_contents($this->getFilePathAndName(), $this->createFileContent());
                echo'OK - File updated';
            } else {
                echo'File does not exist. Use "create" if you want to create the file';
            }
        } catch (Exception $e) {
            echo'<b>' . $e->getMessage() . '</b>';
        }
    }

    /**
     * Make sure required paths and files are available outside of Package
     *
     * @return string
     */
    private function getFilePathAndName() {
        if (!defined('FLOW_PATH_ROOT')) {
            define('FLOW_PATH_ROOT', Files::getUnixStylePath(getcwd()) . '/');
        }
        return self::WORKBOX_CONFIG_JS_FILENAME;
    }

    /**
     * Create the file content from the Settings.Workbox.yaml configuration as a javascript file
     * @return string
     */
    private function createFileContent(){
        $workboxConfigContent = 'module.exports = ';
        $workboxConfigContent .= $this->json_encode_advanced($this->workbox,false,false,true);
        return $workboxConfigContent;
    }

    private function json_encode_advanced(array $arr, $sequential_keys = false, $quotes = false, $beautiful_json = false) {

        $output = $this->isAssoc($arr) ? "{\n" : "[";
        $count = 0;
        foreach ($arr as $key => $value) {

            if ($this->isAssoc($arr) || (!$this->isAssoc($arr) && $sequential_keys === true )) {
                $output .= ($quotes ? '"' : '') . "    " . $key . ($quotes ? '"' : '') . ': ';
            }

            if (is_array($value)) {
                $output .= $this->json_encode_advanced($value, $sequential_keys, $quotes, $beautiful_json);
            }
            else if (is_bool($value)) {
                $output .= ($value ? 'true' : 'false');
            }
            else if (is_numeric($value)) {
                $output .= $value;
            }
            else {
                $output .= ($quotes || $beautiful_json ? '"' : '') . $value . ($quotes || $beautiful_json ? '"' : '');
            }

            if (++$count < count($arr)) {
                $output .= ", \n";
            }
        }
        $output .= $this->isAssoc($arr) ? "\n}" : "]";

        return $output;
    }

    private function isAssoc(array $arr)
    {
        if (array() === $arr) {
            return false;
        }
        return array_keys($arr) !== range(0, count($arr) - 1);
    }

}
