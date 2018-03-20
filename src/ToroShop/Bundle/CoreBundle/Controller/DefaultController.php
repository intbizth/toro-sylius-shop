<?php

declare(strict_types=1);

namespace ToroShop\Bundle\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DefaultController extends Controller
{
    /**
     * @param string|null $location
     *
     * @return Response
     */
    public function reloadPageAction($location = null)
    {
        return Response::create(
            $location ? "<script>window.location.href = '$location';</script>" : '<script>window.location.reload();</script>'
        );
    }

    /**
     * @param string $tokenValue
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function redirectGuestOrderShowToAccountSectionAction(string $tokenValue)
    {
        $order = $this->get('sylius.repository.order')->findOneByTokenValue($tokenValue);

        if (!$order) {
            throw new NotFoundHttpException('"Order" not found');
        }

        return $this->redirectToRoute('sylius_shop_account_order_show', ['number' => $order->getNumber()], 301);
    }
}
