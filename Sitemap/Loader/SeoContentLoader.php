<?php
namespace nvbooster\StarterBundle\Sitemap\Loader;

use Symfony\Cmf\Bundle\SeoBundle\Sitemap\LoaderInterface;
use nvbooster\StarterBundle\Document\SeoContent;
use Doctrine\ODM\PHPCR\DocumentManager;

/**
 * @author nvb <nvb@aproxima.ru>
 */
class SeoContentLoader implements LoaderInterface
{
    /**
     * @var DocumentManager
     */
    private $manager;

    /**
     * @param DocumentManager $manager
     */
    public function __construct(DocumentManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * {@inheritdoc}
     */
    public function load($sitemap)
    {
        $documentsCollection = $this->manager
            ->getRepository('nvbooster\StarterBundle\Document\SeoContent')
            ->findAll();

        $documents = array();
        foreach ($documentsCollection as $document) {
            /* @var $document SeoContent */
            if (count($document->getRoutes())) {
                $documents[] = $document;
            }
        };

        return $documents;
    }
}