<?php

namespace nvbooster\StarterBundle\Sitemap\Voter;

use Symfony\Cmf\Bundle\CoreBundle\PublishWorkflow\PublishWorkflowChecker;
use Symfony\Cmf\Bundle\SeoBundle\Sitemap\VoterInterface;
use Symfony\Component\Security\Core\SecurityContextInterface;

/**
 * @author nvb <nvb@aproxima.ru>
 */
class PublishWorkflowVoter implements VoterInterface
{
    /**
     * @var PublishWorkflowChecker
     */
    private $publishWorkflowChecker;

    /**
     * @param PublishWorkflowChecker $publishWorkflowChecker
     */
    public function __construct(PublishWorkflowChecker $publishWorkflowChecker)
    {
        $this->publishWorkflowChecker = $publishWorkflowChecker;
    }

    /**
     * {@inheritdoc}
     */
    public function exposeOnSitemap($content, $sitemap)
    {
        return $this->publishWorkflowChecker->isGranted(PublishWorkflowChecker::VIEW_ANONYMOUS_ATTRIBUTE, $content);
    }
}
