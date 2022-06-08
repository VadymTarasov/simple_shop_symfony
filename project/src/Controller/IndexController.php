<?php

namespace App\Controller;

use App\Entity\ShopCart;
use App\Entity\ShopItems;
use App\Repository\ShopCartRepository;
use App\Repository\ShopItemsRepository;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    public Session $session;

    public function __construct()
    {
        $this->session = new Session();
        $this->session->getFlashBag('1');
    }


    #[Route('/index', name: 'app_index')]
    public function index(): Response
    {
        return $this->render('index/index.html.twig', [
            'controller_name' => 'IndexController',
        ]);
    }

    #[Route('/shop/list', name: 'shop_list')]
    public function shopList(ShopItemsRepository $shopItemRepository): Response
    {
        $items = $shopItemRepository->findAll();

        return $this->render('index/shopList.html.twig', [
            'controller_name' => 'SHOP LIST',
            'items' => $items,
        ]);
    }

    #[Route('/shop/item/{id<\d+>}', name: 'shop_item')]
    public function shopItem(ShopItems $shopItem): Response
    {
        return $this->render('index/shopItem.html.twig', [
            'title' => $shopItem->getTitle(),
            'description' => $shopItem->getDescription(),
            'price' => $shopItem->getPrice(),
            'id' => $shopItem->getId(),
        ]);
    }


    #[Route('/shop/item/add/{id<\d+>}', name: 'shop_cart_add')]
    public function shopCartAdd(ShopItems $shopItems, EntityManagerInterface $em): Response
    {
        $sessionId = $this->session->getId();
        $shopCart = new ShopCart();
        $shopCart->setShopItem($shopItems);
        $shopCart->setSessionId($sessionId);
        $em->persist($shopCart);
        $em->flush();
        return $this->redirectToRoute('shop_cart', ['id' => $shopItems->getId()]);
    }

    #[Route('/shop/cart', name: 'shop_cart')]
    public function shopCart(ShopCartRepository $shopCartRepository): Response
    {
        $this->session = new Session();
        $session = $this->session->getId();
        $items = $shopCartRepository->findBy(['session_id' => $session]);


        return $this->render(
            'index/shopCart.html.twig',
            [
                'title' => 'Корзина',
                'items' => $items,
            ]
        );
    }
}
