<?php

namespace App\Controller;

use App\Entity\ShopItems;
use App\Repository\ShopItemsRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ItemController extends AbstractController
{
    private $requestStack;

    public function __construct(RequestStack $requestStack) {
        $this->requestStack = $requestStack;
        $this->requestStack->getSession()->getFlashBag()->add('notice', 'Profile updated');
    }


    #[Route('/shop/list', name: 'shop_list')]
    public function shopList(ShopItemsRepository $shopItemRepository): Response
    {
        $items = $shopItemRepository->findAll();

        return $this->render('index/shopList.html.twig', [
            'items' => $items,
        ]);
    }

    #[Route('/shop/list/fruit', name: 'shop_list_fruit')]
    public function shopFruit(ShopItemsRepository $shopItemRepository): Response
    {
        $items = $shopItemRepository->findAll();
        return $this->render('index/shopFruit.html.twig', [
            'items' => $items,
        ]);
    }
    #[Route('/shop/list/vegetables', name: 'shop_list_vegetables')]
    public function shopVegetables(ShopItemsRepository $shopItemRepository): Response
    {
        $items = $shopItemRepository->findAll();
        return $this->render('index/shopVegetables.html.twig', [
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
}
