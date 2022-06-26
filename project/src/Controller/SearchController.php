<?php

namespace App\Controller;

use App\Repository\ShopItemRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{

    #[Route('/search', name: 'app_search')]
    public function search(Request $request, ShopItemRepository $shopItemRepository): Response
    {
        $items = $shopItemRepository->search($request->query->get('title'));
        return $this->render('search/search.html.twig', ['items' => $items]);
    }

}
