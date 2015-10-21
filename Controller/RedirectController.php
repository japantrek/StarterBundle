<?php

namespace nvbooster\StarterBundle\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * RedirectController
 *
 * @author nvb <nvb@aproxima.ru>
 */
class RedirectController extends Controller
{
    /**
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function redirectAction(Request $request)
    {
        $seoPage = $this->container->get('sonata.seo.page');
        $seoPage->addMeta('name', 'robots', 'noindex, nofollow');

        $url = $request->query->get('go', false);

        if (filter_var($url, FILTER_VALIDATE_URL) !== false) {
            $urlParts = parse_url($url);
            if ($urlParts !== false) {

                if (key_exists('host', $urlParts) && key_exists('scheme', $urlParts) &&
                    in_array($urlParts['scheme'], array('http', 'https'))) {

                    foreach ($this->container->getParameter('host_whitelist') as $whiteHost) {
                        if (preg_match("@^(.*\.)?" . preg_quote($whiteHost) . "$@u", $urlParts['host'])) {
                            return new RedirectResponse($url, 302);
                        }
                    }

                    return $this->render($this->getParameter('nvbooster_starter.template.external_link'), array('url' => $url, 'host' => $urlParts['host']));
                }
            }
        }

        return $this->render($this->getParameter('nvbooster_starter.template.external_link'), array('raw' => $url));
    }
}
