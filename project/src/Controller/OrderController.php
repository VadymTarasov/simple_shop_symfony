<?php

namespace App\Controller;

use App\Entity\ShopOrder;
use App\Form\OrderFormType;
use App\Repository\ShopCartRepository;
use App\Repository\ShopItemRepository;
use App\Repository\ShopOrderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends AbstractController
{
    private $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
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
                $session = $this->requestStack->getSession();

                if ($this->getUser()) {
                    $shopOrder->setUserId($this->getUser()->getId());

                }
                $sessionId = $session->getId();
                $shopOrder->setStatus(ShopOrder::STATUS_NEW_ORDER);
                $shopOrder->setSessionId($sessionId);
                $em->persist($shopOrder);
                $em->flush();
                $session->migrate();
            }

            return $this->redirectToRoute('shop_cart');
        }

        if ($this->getUser()) {
            $name = $this->getUser()->getName();
            $mail = $this->getUser()->getUserIdentifier();
            $phone = $this->getUser()->getUserPhone();
        } else {
            $name = null;
            $mail = null;
            $phone = null;
        }


        return $this->render(
            'index/shopOrder.html.twig',
            [
                'form' => $form->createView(),
                'name' => $name,
                'mail' => $mail,
                'phone' => $phone,
            ]
        );
    }

    #[Route('/shop/order/show', name: 'show_order')]
    public function default(ShopOrderRepository $orderRepository, ShopCartRepository $shopCartRepository,
                            ShopItemRepository  $shopItemsRepository): Response
    {
        $orders = $orderRepository->findAll();
        $cart = $shopCartRepository->findAll();
        $items = $shopItemsRepository->findAll();
        return $this->render('order/orderList.html.twig',
            ['orders' => $orders,
                'cart' => $cart,
                'items' => $items,
            ]
        );
    }

    #[Route('/shop/order/delete/{id}', methods: ['GET'], requirements: ['id' => '\d+'])]
    public function deleteOrder(ManagerRegistry $doctrine, int $id): Response
    {
        $entityManager = $doctrine->getManager();
        $order = $entityManager->getRepository(ShopOrder::class)->find($id);

        if (!$order) {
            throw $this->createNotFoundException(
                'No order found for id ' . $id
            );
        }
        $entityManager->remove($order);
        $entityManager->flush();

        return $this->redirectToRoute('show_order');
    }


}
