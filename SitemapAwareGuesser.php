<?php
namespace nvbooster\StarterBundle\Sitemap\Guesser;

use Symfony\Cmf\Bundle\SeoBundle\Sitemap\GuesserInterface;
use Symfony\Cmf\Bundle\SeoBundle\Model\UrlInformation;
use nvbooster\StarterBundle\Document\SeoContent;
use Symfony\Cmf\Bundle\BlockBundle\Doctrine\Phpcr\ContainerBlock;
use Sonata\BlockBundle\Model\BlockInterface;
use Symfony\Cmf\Bundle\BlockBundle\Doctrine\Phpcr\ReferenceBlock;
use nvbooster\StarterBundle\Sitemap\SitemapPropertiesReadInterface;

/**
 * @author nvb <nvb@aproxima.ru>
 */
class SitemapAwareGuesser implements GuesserInterface
{

    /**
     * Updates UrlInformation with new values if they are not already set.
     *
     * @param UrlInformation $urlInformation The value object to update.
     * @param object         $object         The sitemap element to get values from.
     * @param string         $sitemap        Name of the sitemap being built.
     */
    public function guessValues(UrlInformation $urlInformation, $object, $sitemap)
    {
        if ($object instanceof SitemapPropertiesReadInterface) {
            if (
                !$urlInformation->getChangeFrequency() &&
                ($period = $object->getUpdatePeriod())
            ) {
                $urlInformation->setChangeFrequency($period);
            }

            if ($urlInformation->getPriority() === null) {
                $weight = $object->getPageWeight();
                if ($weight !== null) {
                    $urlInformation->setPriority($weight);
                }
            }
        }
    }
}