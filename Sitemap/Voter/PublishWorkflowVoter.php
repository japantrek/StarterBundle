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
     * @var SecurityContextInterface
     */
    private $publishWorkflowChecker;

    /**
     * @param SecurityContextInterface $publishWorkflowChecker
     */
    public function __construct(SecurityContextInterface $publishWorkflowChecker)
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
