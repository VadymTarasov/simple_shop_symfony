<?php

namespace App\Controller;

use App\Entity\ShopCart;
use App\Entity\ShopItem;
use App\Repository\ShopCartRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    private $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;

    }


    #[Route('/shop/cart/drop', name: 'shop_cart_drop')]
    public function cartDrop(Request $request, EntityManagerInterface $em): Response
    {

        $session = $this->requestStack->getSession();
        $session->getFlashBag()->add('notice', 'Profile updated');;
        $session->migrate();
        return $this->redirectToRoute('shop_cart');

    }


    #[Route('/shop/item/add/{id<\d+>}', name: 'shop_cart_add')]
    public function shopCartAdd(ShopItem $shopItems, EntityManagerInterface $em): Response
    {
        $session = $this->requestStack->getSession();
        $sessionId = $session->getId();
        $shopCart = new ShopCart();
        $shopCart->setShopItem($shopItems);
        $shopCart->setAmount(1);
        $shopCart->setSessionId($sessionId);
        if ($this->getUser()) {
            $shopCart->setUserIdentifier($this->getUser()->getId());
        } else {
            $shopCart->setUserIdentifier(0);
        }

        $em->persist($shopCart);
        $em->flush();
        return $this->redirectToRoute('shop_cart', ['id' => $shopItems->getId()]);
    }

    #[Route('/shop/cart', name: 'shop_cart')]
    public function shopCart(ShopCartRepository $shopCartRepository): Response
    {
        $session = $this->requestStack->getSession();
        $session = $session->getId();
        $items = $shopCartRepository->findBy(['session_id' => $session]);

        return $this->render(
            'index/shopCart.html.twig',
            [
                'items' => $items,
            ]
        );
    }

    #[Route('/cart/item/delete/{id}', name: 'shop_cart_delete', methods: ['GET'], requirements: ['id' => '\d+'])]
    public function delete(ManagerRegistry $doctrine, int $id): Response
    {
        $entityManager = $doctrine->getManager();
        $product = $entityManager->getRepository(ShopCart::class)->find($id);

        if (!$product) {
            throw $this->createNotFoundException(
                'No cat found for id ' . $id
            );
        }
        $entityManager->remove($product);
        $entityManager->flush();

        return $this->redirectToRoute('shop_cart');
    }

    #[Route('/shop/item/count/add/{id}', name: 'shop_cart_amount_add', methods: ['GET'], requirements: ['id' => '\d+'])]
    public function shopCartAmountAdd(Request $request, ManagerRegistry $doctrine, int $id): Response
    {
        $entityManager = $doctrine->getManager();
        $product = $entityManager->getRepository(ShopCart::class)->find($id);
        $count = $product->getAmount();
        $product->setAmount($count + 1);
        $entityManager = $doctrine->getManager();
        $entityManager->persist($product);
        $entityManager->flush();

        return $this->redirectToRoute('shop_cart');
    }

    #[Route('/shop/item/count/subtract/{id}', name: 'shop_cart_amount_subtract', methods: ['GET'], requirements: ['id' => '\d+'])]
    public function shopCartAmount(Request $request, ManagerRegistry $doctrine, int $id): Response
    {
        $entityManager = $doctrine->getManager();
        $product = $entityManager->getRepository(ShopCart::class)->find($id);
        $count = $product->getAmount();
        if ($count == 1){
            $product->setAmount($count);
        } else {
            $product->setAmount($count - 1);
        }
        $entityManager = $doctrine->getManager();
        $entityManager->persist($product);
        $entityManager->flush();

        return $this->redirectToRoute('shop_cart');
    }


}
