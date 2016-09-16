<?php
namespace nvbooster\StarterBundle\Sitemap\Guesser;

use Symfony\Cmf\Bundle\SeoBundle\Sitemap\GuesserInterface;
use Symfony\Cmf\Bundle\SeoBundle\Model\UrlInformation;
use nvbooster\StarterBundle\Document\OnePageContent;
use nvbooster\StarterBundle\Document\OnePageSection;

/**
 * @author nvb <nvb@aproxima.ru>
 */
class OnePageItemLastModifiedGuesser implements GuesserInterface
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
        if ($urlInformation->getLastModification()) {
            return;
        }

        if ($object instanceof OnePageContent) {
            /* @var $object OnePageContent */
            $updated = $object->getUpdatedAt();

            foreach ($object->getChildren(true) as $section) {
                /* @var $section OnePageSection */
                $updated = max($updated, $this->sectionUpdateDate($section));
            }

            $urlInformation->setLastModification($updated);

        } elseif ($object instanceof OnePageSection) {
            /* @var $object OnePageSection */
            $urlInformation->setLastModification(
                $this->sectionUpdateDate($object)
            );
        }
    }

    /**
     * @param object $section
     *
     * @return \DateTime
     */
    public function sectionUpdateDate($section)
    {
        if (!($section instanceof OnePageSection)) {
            return null;
        }

        $modified = $section->getUpdatedAt();

        $modified = max($modified,
            SeoContentLastModifiedGuesser::recursiveBlockUpdateDate($section->getContent())
        );
        $modified = max($modified,
            SeoContentLastModifiedGuesser::recursiveBlockUpdateDate($section->getBlock())
        );

        return $modified;
    }
}