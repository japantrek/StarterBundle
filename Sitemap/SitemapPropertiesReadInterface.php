<?php

namespace nvbooster\StarterBundle\Sitemap;

use Symfony\Cmf\Bundle\SeoBundle\SitemapAwareInterface;

/**
 * @author nvb <nvb@aproxima.ru>
 */
interface SitemapPropertiesReadInterface extends SitemapAwareInterface
{
    /**
     * Get page weight, values from 0.0 to 1.0
     * @see http://www.sitemaps.org/ru/protocol.html
     *
     * @return null | string
     */
    public function getPageWeight();

    /**
     * Get page update period, values: always, hourly, daily, weekly, monthly, yearly, never
     * @see http://www.sitemaps.org/ru/protocol.html
     *
     * @return string
     */
    public function getUpdatePeriod();
}