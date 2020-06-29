<?php
namespace DIU\Neos\PWA\Controller;

use Neos\Eel\FlowQuery\FlowQuery;
use Neos\Flow\Annotations as Flow;
use Neos\Flow\Mvc\Controller\ActionController;
use Neos\Flow\ResourceManagement\ResourceManager;
use Neos\Fusion\Exception;
use Neos\Fusion\FusionObjects\ResourceUriImplementation;

class ManifestController extends ActionController {

    const CACHE_IDENTIFIER = 'diu-neos-pwa-manifest-json';

    /**
     * @Flow\Inject
     * @var ResourceManager
     */
    public $resourceManager;

    /**
     * @var string
     */
    protected $defaultViewObjectName = \Neos\Flow\Mvc\View\JsonView::class;

    /**
     * @Flow\Inject
     * @var VariableFrontend
     */
    protected $cacheFrontend;

    /**
     * @Flow\InjectConfiguration(path="Manifest")
     * @var array
     */
    protected $manifest = array();


    public function indexAction()
    {
        if ($this->cacheFrontend->has(self::CACHE_IDENTIFIER)) {
            $this->manifest = $this->cacheFrontend->get(self::CACHE_IDENTIFIER);
        } else {
            # Create paths to icons form 'resource://Vendor.Site/Public/Icons/icon-72x72.png
            if (isset($this->manifest['icons'])){
                foreach ($this->manifest['icons'] as &$value) {
                    $value['src'] = $this->resourceManager->getPublicPackageResourceUriByPath($value['src']);
                    unset($value);
                }
            }

            $this->cacheFrontend->set(self::CACHE_IDENTIFIER, $this->manifest);
        }

        $this->view->assign('value', $this->manifest);
        $this->view->setOption('jsonEncodingOptions',64);
    }

}
