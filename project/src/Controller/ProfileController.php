<?php

namespace App\Controller;

use App\Repository\ShopCartRepository;
use App\Repository\ShopItemRepository;
use App\Repository\ShopOrderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'app_profile')]
    public function default(ShopOrderRepository $orderRepository, ShopCartRepository $shopCartRepository,
                            ShopItemRepository  $shopItemsRepository): Response
    {
        $orders = $orderRepository->findAll();
        $cart = $shopCartRepository->findAll();
        $items = $shopItemsRepository->findAll();
        return $this->render('profile/index.html.twig',
            [
                'controller_name' => 'ProfileController',
                'orders' => $orders,
                'cart' => $cart,
                'items' => $items,
                'user' => $this->getUser(),
            ]
        );
    }


}
