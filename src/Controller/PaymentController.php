<?php

namespace App\Controller;

use App\Checkout\CheckoutSession;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PaymentController extends AbstractController
{
    #[Route('/checkout', name: 'checkout')]
    public function checkout(CheckoutSession $checkoutSession, $stripeSK): Response
    {
        $session = $checkoutSession->createSession($stripeSK);

        return $this->redirect($session->url, 303);
    }

    #[Route('/success-url', name: 'success_url')]
    public function successUrl(): Response
    {
        // TODO: add clearing the cart

        return $this->render('payment/success.html.twig', []);
    }

    #[Route('/cancel-url', name: 'cancel_url')]
    public function cancelUrl(): Response
    {
        return $this->render('payment/cancel.html.twig', []);
    }
}
