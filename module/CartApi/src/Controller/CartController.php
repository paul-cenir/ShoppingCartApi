<?php

namespace CartApi\Controller;

use CartApi\Model\CartTable;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

class CartController extends AbstractRestfulController
{
    //protected $eventIdentifier = 'SecuredController';

    private $CartTable;

    public function __construct(CartTable $CartTable)
    {
      
        $this->CartTable = $CartTable;
    }

    public function get($id)
    {
        return new JsonModel([$this->CartTable->getCartById($id)]);
    }

    public function getList()
    {
        return new JsonModel([$this->CartTable->getCartList()]);
    }

    public function update($id, $data)
    {

        \Zend\Debug\Debug::dump('update');
        exit;
    }

    public function delete($id)
    {
        \Zend\Debug\Debug::dump('delete');
        exit;
    }

}
