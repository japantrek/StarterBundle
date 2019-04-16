<?php
namespace nvbooster\StarterBundle\Document;

use Symfony\Cmf\Bundle\RoutingBundle\Doctrine\Phpcr\RedirectRoute;
use Symfony\Cmf\Component\Routing\RouteObjectInterface;

/**
 * @author nvb <nvb@aproxima.ru>
 */
class RouteContainer extends RedirectRoute
{
    /**
     * {@inheritdoc}
     * @see \Symfony\Cmf\Component\Routing\RedirectRouteInterface::getRouteName()
     */
    public function getRouteName()
    {
        return null;
    }

    /**
     * {@inheritdoc}
     * @see \Symfony\Cmf\Component\Routing\RedirectRouteInterface::getRouteTarget()
     */
    public function getRouteTarget()
    {
        return $this->recursiveRouteSearch();
    }

    /**
     * {@inheritdoc}
     * @see \Symfony\Cmf\Component\Routing\RedirectRouteInterface::getUri()
     */
    public function getUri()
    {
        return null;
    }

    /**
     * {@inheritdoc}
     * @see \Symfony\Cmf\Component\Routing\RedirectRouteInterface::isPermanent()
     */
    public function isPermanent()
    {
        return false;
    }

    /**
     * @return \Symfony\Cmf\Component\Routing\RouteObjectInterface
     */
    public function recursiveRouteSearch()
    {
        foreach ($this->children as $child) {
            if ($child instanceof RouteContainer) {
                return $child->getRouteTarget();
            } elseif ($child instanceof RouteObjectInterface) {
                return $child;
            }
        }

        return null;
    }

    /**
     * Get all children of this route including non-routes.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getChildren()
    {
        return $this->children;
    }
}