<?php

namespace nvbooster\StarterBundle\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Sonata\SeoBundle\Seo\SeoPage;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;

/**
 * RedirectController
 *
 * @author nvb <nvb@aproxima.ru>
 */
class RedirectController
{
    private $whitelist;
    private $seoPage;
    private $template;
    private $templating;

    /**
     * @param tring   $template
     * @param array   $whitelist
     * @param SeoPage $seoPage
     */
    public function __construct($template, EngineInterface $templating, $whitelist = array(), SeoPage $seoPage = null)
    {
        $this->templating = $templating;
        $this->template = $template;
        $this->whitelist = $whitelist;
        $this->seoPage = $seoPage;
    }

    /**
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function redirect(Request $request)
    {
        if ($this->seoPage) {
            $this->seoPage->addMeta('name', 'robots', 'noindex, nofollow');
        }

        $url = $request->query->get('go', false);

        if (filter_var($url, FILTER_VALIDATE_URL) !== false) {
            $urlParts = parse_url($url);
            if ($urlParts !== false) {

                if (key_exists('host', $urlParts) && key_exists('scheme', $urlParts) &&
                    in_array($urlParts['scheme'], array('http', 'https'))) {

                    if (is_array($this->whitelist) && count($this->whitelist)) {
                        foreach ($this->whitelist as $whiteHost) {
                            if (preg_match("@^(.*\.)?" . preg_quote($whiteHost) . "$@u", $urlParts['host'])) {
                                return new RedirectResponse($url, 302);
                            }
                        }
                    }

                    return $this->templating->renderResponse($this->template, array('url' => $url, 'host' => $urlParts['host']));
                }
            }
        }

        return $this->templating->renderResponse($this->template, array('raw' => $url));
    }
}
