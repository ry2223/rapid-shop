<?php

namespace App\Manager;

use App\Entity\Order;
use App\Factory\OrderFactory;
use App\Storage\CartSessionStorage;
use Doctrine\ORM\EntityManagerInterface;

class CartManager
{
    public function __construct(
        private CartSessionStorage $cartSessionStorage,
        private OrderFactory $orderFactory,
        private EntityManagerInterface $entityManager
    ) {}

    public function getCurrentCart(): Order
    {
        $cart = $this->cartSessionStorage->getCart();

        if (!$cart) {
            $cart = $this->orderFactory->create();
        }

        return $cart;
    }

    public function save(Order $cart): void
    {
        // Persist in database
        $this->entityManager->persist($cart);
        $this->entityManager->flush();
        // Persist in session
        $this->cartSessionStorage->setCart($cart);
    }
}
