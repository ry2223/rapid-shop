<?php

namespace App\Checkout;

use App\Storage\CartSessionStorage;
use Stripe\Checkout\Session;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Stripe\Stripe;
use Symfony\Component\HttpFoundation\RequestStack;

class CheckoutSession extends AbstractController
{
    public function __construct(
        private RequestStack $requestStack
    ) {}
    
    public function createSession($key): Session
    {
        $request = $this->requestStack->getSession();

        Stripe::setApiKey($key);

        $session = Session::create([
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => $request->get(CartSessionStorage::CART_KEY_NAME)
                    ],
                    'unit_amount' => 2000,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => $this->generateUrl('success_url', [], UrlGeneratorInterface::ABSOLUTE_URL),
            'cancel_url' => $this->generateUrl('cancel_url', [], UrlGeneratorInterface::ABSOLUTE_URL),
        ]);

        return $session;
    }
}
