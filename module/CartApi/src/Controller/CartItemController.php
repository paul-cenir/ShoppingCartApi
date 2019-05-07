<?php

namespace CartApi\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use CartApi\Service\CartItemService;
use Zend\View\Model\JsonModel;

class CartItemController extends AbstractRestfulController
{
    private $CartItemService;
    public function __construct(
        CartItemService $CartItemService
    ) {
        $this->CartItemService = $CartItemService;
    }

    public function delete($id)
    {
        $cartItem = $this->CartItemService->deleteCartItem($id);
        if (!$cartItem['isValid']) {
            $this->getResponse()->setStatusCode(400);
            return new JsonModel(["validation_error_messages" => $cartItem['data']]);
        } else {
            return new JsonModel($cartItem);
        }
    }
}
