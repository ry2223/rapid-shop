<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\AddToCartType;
use App\Manager\CartManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    #[Route('/product/{id}', name: 'product_details')]
    public function detail(Product $product, Request $request, CartManager $cartManager)
    {
        $form = $this->createForm(AddToCartType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $item = $form->getData();
            $item->setProduct($product);

            $cart = $cartManager->getCurrentCart();
            $cart
                ->addItem($item)
                ->setUpdatedAt(new \DateTime());

            $cartManager->save($cart);

            return $this->redirectToRoute('product_details', ['id' => $product->getId()]);
        }

        return $this->render('product/details.html.twig', [
            'product' => $product,
            'form' => $form->createView()
        ]);
    }
}
