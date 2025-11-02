<?php

namespace App\Controller;

use App\Entity\ShopItem;
use App\Form\ShopItemFormType;
use App\Repository\ShopItemRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

    #[Route('products/add', name: 'product_add')]
    public function addProduct(Request $request, EntityManagerInterface $manager): Response
    {
        $shopItem = new ShopItem();
        $shopItemForm = $this->createForm(ShopItemFormType::class, $shopItem);

        $shopItemForm->handleRequest($request);

        if ($shopItemForm->isSubmitted()) {
            $manager->persist($shopItem);
            $manager->flush();

            return $this->redirectToRoute('product_details', ['productId' => $shopItem->getId()]);
        }

        return $this->render('products/productAdd.html.twig', [
            'shopItemForm' => $shopItemForm,
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

    #[Route('products/{productId<\d+>}/edit', name: 'product_edit')]
    public function editProduct(string $productId, Request $request, EntityManagerInterface $manager, ShopItemRepository $shopItemRepository): Response
    {
        $shopItem = $shopItemRepository->find($productId);
        $shopItemForm = $this->createForm(ShopItemFormType::class, $shopItem);

        $shopItemForm->handleRequest($request);

        if ($shopItemForm->isSubmitted()) {
            $manager->flush();

            return $this->redirectToRoute('product_details', ['productId' => $shopItem->getId()]);
        }

        return $this->render('products/productEdit.html.twig', [
            'shopItemForm' => $shopItemForm,
            'shopItem' => $shopItem,
        ]);
    }

    #[Route('products/{productId<\d+>}/delete', name: 'product_delete')]
    public function deleteProduct(string $productId, Request $request, EntityManagerInterface $manager, ShopItemRepository $shopItemRepository) {
        if ($request->isMethod('POST')) {
            $shopItem = $shopItemRepository->find($productId);
            if ($shopItem) {
                $manager->remove($shopItem);
                $manager->flush();
            }
            return $this->redirectToRoute('app_products');
        }
    }
}
