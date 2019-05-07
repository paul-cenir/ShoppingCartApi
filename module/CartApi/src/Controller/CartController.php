<?php

namespace CartApi\Controller;

use CartApi\Service\CartService;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

class CartController extends AbstractRestfulController
{
    private $CartService;
    public function __construct(
        CartService $CartService
    ) {
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
