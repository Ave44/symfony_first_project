<?php

namespace App\Controller;

use App\Entity\ShopItem;
use App\Repository\ShopItemRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ProductsController extends AbstractController
{
    #[Route('/products', name: 'app_products')]
    public function index(ShopItemRepository $shopItemRepository): Response
    {
        $shopItems = $shopItemRepository->findAll();

        return $this->render('products/index.html.twig', [
            'controller_name' => 'ProductsController',
            'shopItems' => $shopItems,
        ]);
    }

    #[Route('/products/{productId}', name: 'product_details')]
    public function productDetails(string $productId, ShopItemRepository $shopItemRepository): Response
    {
        $shopItem = $shopItemRepository->find($productId);
        return $this->render('products/productDetails.html.twig', [
            'shopItem' => $shopItem,
        ]);
    }
}
