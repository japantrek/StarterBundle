<?php
namespace nvbooster\StarterBundle\Sitemap;

/**
 * @author nvb <nvb@aproxima.ru>
 */
interface SitemapPropertiesInterface extends SitemapPropertiesReadInterface
{
    /**
     * Get page weight, values from 0.0 to 1.0
     * @see http://www.sitemaps.org/ru/protocol.html
     *
     * @param double $weight
     */
    public function setPageWeight($weight);

    /**
     * Get page update period, values: always, hourly, daily, weekly, monthly, yearly, never
     * @see http://www.sitemaps.org/ru/protocol.html
     *
     * @param string $period
     */
    public function setUpdatePeriod($period);

    /**
     * @param boolean $visible
     */
    public function setVisibleInSitemap($visible);
}