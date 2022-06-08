<?php

namespace App\Controller;

use App\Entity\ShopOrder;
use App\Form\OrderFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends AbstractController
{
    public Session $session;


    #[Route('/main', name: 'app_main')]
    public function index(): Response
    {
        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }

    #[Route('/shop/order', name: 'shop_order')]
    public function shopOrder(Request $request, EntityManagerInterface $em): Response
    {

        $shopOrder = new ShopOrder();

        $form = $this->createForm(OrderFormType::class, $shopOrder);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $shopOrder = $form->getData();

            if ($shopOrder instanceof ShopOrder) {
                $this->session = new Session();
                $sessionId = $this->session->getId();
                $shopOrder->setStatus(ShopOrder::STATUS_NEW_ORDER);
                $shopOrder->setSessionId($sessionId);
                $em->persist($shopOrder);
                $em->flush();
                $this->session->migrate();
            }

            return $this->redirectToRoute('shop_cart');
        }


        return $this->render(
            'index/shopOrder.html.twig',
            [
                'title' => 'Оформление заказа',
                'form' => $form->createView(),
            ]
        );
    }
}
