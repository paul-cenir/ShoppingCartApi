<?php

namespace CartApi\Controller;

use CartApi\Model\CartItemsTable;
use CartApi\Model\CartTable;
use CartApi\Service\CartService;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

class CartController extends AbstractRestfulController
{
    private $CartTable;
    private $CartItemsTable;
    private $CartService;
    public function __construct(
        CartTable $CartTable,
        CartItemsTable $CartItemsTable,
        CartService $CartService
    ) {

        $this->CartTable = $CartTable;
        $this->CartItemsTable = $CartItemsTable;
        $this->CartService = $CartService;
    }

    public function create($data)
    {
        $accessToken = $this->getRequest()->getHeader('Authorization');
        $cart = $this->CartService->addToCart($data, $accessToken);
        if (!$cart['isValid']) {
            $this->getResponse()->setStatusCode(400);
            return new JsonModel(["validation_error_messages" => $cart['data']]);
        } else {
            return new JsonModel($cart['data']);
        }
    }

    public function get($id)
    {
        $cart = $this->CartService->getCart($id);
        if (!$cart['isValid']) {
            $this->getResponse()->setStatusCode(400);
            return new JsonModel(["validation_error_messages" => $cart['data']]);
        } else {
            return new JsonModel($cart);
        }
    }
}
