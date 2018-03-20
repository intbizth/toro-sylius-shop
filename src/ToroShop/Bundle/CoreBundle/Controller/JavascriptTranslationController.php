<?php

declare(strict_types=1);

namespace ToroShop\Bundle\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class JavascriptTranslationController extends Controller
{
    /**
     * @return Response
     */
    public function jsAction()
    {
        $trans = $this->container->get('translator')->getCatalogue()->all('javascript');

        $response = new Response('var _trans = ' . json_encode($trans, JSON_UNESCAPED_UNICODE));
        $response->headers->set('Content-Type', 'text/javascript');
        $response->setPublic();
        $response->setExpires(new \DateTime('+30 days'));
        $response->setMaxAge(86400 * 30);

        return $response;
    }
}
