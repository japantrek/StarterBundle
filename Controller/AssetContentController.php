<?php

namespace nvbooster\StarterBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Assetic\Asset\StringAsset;

/**
 * AssetContentController
 *
 * @author nvb <nvb@aproxima.ru>
 */
class AssetContentController extends Controller
{
    /**
     * @param Request $request
     * @param object  $contentDocument
     * @param array   $filters
     *
     * @return Response
     */
    public function directAction(Request $request, $contentDocument, $filters = array())
    {

        $response = new Response($contentDocument->getBody(), 200);
        $response->setLastModified($contentDocument->getUpdatedAt());
        $response->setPublic();

        if (!$this->get('kernel')->isDebug()) {

            if ($response->isNotModified($request)) {
                return $response;
            }


            $asset = new StringAsset($response->getContent());
            $asset->load();

            $filterManager = $this->get('assetic.filter_manager');

            if ($filterManager) {
                foreach ($filters as $filter) {
                    if ($processor = $filterManager->get($filter)) {
                        $processor->filterDump($asset);
                    }
                }
            }

            $response->setContent($asset->getContent());
        }

        $response->prepare($request);

        return $response;
    }

    /**
     * Helper action
     *
     * @param Request $request
     * @param object  $contentDocument
     *
     * @return Response
     */
    public function directJsAction(Request $request, $contentDocument)
    {
        return $this->directAction($request, $contentDocument, array('uglifyjs2'));
    }

    /**
     * Helper action
     *
     * @param Request $request
     * @param object  $contentDocument
     *
     * @return Response
     */
    public function directCssAction(Request $request, $contentDocument)
    {
        return $this->directAction($request, $contentDocument, array('uglifycss'));
    }
}
