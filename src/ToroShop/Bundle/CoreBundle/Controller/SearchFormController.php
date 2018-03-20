<?php

declare(strict_types=1);

namespace ToroShop\Bundle\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class SearchFormController extends Controller
{
    /**
     * @param $search
     * @param $formType
     * @param $template
     *
     * @return Response
     */
    public function searchFormAction($search, $formType, $template)
    {
        $form = $this->get('form.factory')
            ->createNamed('search', $formType, $search)
        ;

        return $this->render($template, ['form' => $form->createView()]);
    }
}
