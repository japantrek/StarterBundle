<?php
namespace nvbooster\StarterBundle\Sitemap\Loader;

use Symfony\Cmf\Bundle\SeoBundle\Sitemap\LoaderInterface;
use nvbooster\StarterBundle\Document\SeoContent;
use Doctrine\ODM\PHPCR\DocumentManager;

/**
 * @author nvb <nvb@aproxima.ru>
 */
class OnePageItemLoader implements LoaderInterface
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
     * {@inheritdoc}.
     */
    public function load($sitemap)
    {
        return array_merge(
            $this->loadContent($sitemap),
            $this->loadStandaloneSection($sitemap)
        );
    }

    /**
     * {@inheritdoc}.
     */
    public function loadContent($sitemap)
    {
        $documentsCollection = $this->manager
            ->getRepository('nvbooster\StarterBundle\Document\OnePageContent')
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

    /**
     * {@inheritdoc}.
     */
    public function loadStandaloneSection($sitemap)
    {
        $documentsCollection = $this->manager
            ->getRepository('nvbooster\StarterBundle\Document\OnePageSection')
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