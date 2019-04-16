<?php
namespace nvbooster\StarterBundle\Sitemap\Guesser;

use Symfony\Cmf\Bundle\SeoBundle\Sitemap\GuesserInterface;
use Symfony\Cmf\Bundle\SeoBundle\Model\UrlInformation;
use nvbooster\StarterBundle\Document\SeoContent;
use Symfony\Cmf\Bundle\BlockBundle\Doctrine\Phpcr\ContainerBlock;
use Sonata\BlockBundle\Model\BlockInterface;
use Symfony\Cmf\Bundle\BlockBundle\Doctrine\Phpcr\ReferenceBlock;

/**
 * @author nvb <nvb@aproxima.ru>
 */
class SeoContentLastModifiedGuesser implements GuesserInterface
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

        if ($object instanceof SeoContent) {
            /* @var $object SeoContent */
            $urlInformation->setLastModification(
                max(
                    $object->getUpdatedAt(),
                    $this->recursiveBlockUpdateDate($object->getAdditionalInfoBlock())
                )
            );
        }
    }

    /**
     * @param object $block
     *
     * @return \DateTime
     */
    public static function recursiveBlockUpdateDate($block)
    {
        if (!($block instanceof BlockInterface)) {
            return null;
        }

        $modified = $block->getUpdatedAt();

        if ($block instanceof ContainerBlock) {
            /* @var $block ContainerBlock */
            foreach ($block->getChildren() as $childBlock) {
                $modified = max($modified, self::recursiveBlockUpdateDate($childBlock));
            }
        } elseif ($block instanceof ReferenceBlock) {
            /* @var $block ReferenceBlock */
            $modified = max($modified, self::recursiveBlockUpdateDate($block->getReferencedBlock()));
        }

        return $modified;
    }
}