<?php

namespace JobApi\Service;

use CartApi\Model\CartTable;
use CustomerApi\Model\CustomersTable;
use JobApi\Filter\JobFilter;
use JobApi\Model\Job;
use JobApi\Model\JobItems;
use JobApi\Model\JobItemsTable;
use JobApi\Model\JobTable;
use ProductApi\Model\ProductsTable;

class JobService
{
    private $JobTable;
    private $JobFilter;
    private $ProductTable;
    private $CustomersTable;
    private $Job;
    private $JobItems;
    private $JobItemsTable;
    private $CartTable;
    public function __construct(
        JobTable $JobTable,
        JobFilter $JobFilter,
        ProductsTable $ProductTable,
        CustomersTable $CustomersTable,
        Job $Job,
        JobItems $JobItems,
        JobItemsTable $JobItemsTable,
        CartTable $CartTable
    ) {
        $this->JobTable = $JobTable;
        $this->JobFilter = $JobFilter;
        $this->ProductTable = $ProductTable;
        $this->CustomersTable = $CustomersTable;
        $this->Job = $Job;
        $this->JobItems = $JobItems;
        $this->JobItemsTable = $JobItemsTable;
        $this->CartTable = $CartTable;
    }

    public function updateStockQty($jobId)
    {
        $jobItems = $this->JobItemsTable->getJobItemList($jobId);
        foreach ($jobItems as $jobItem) {
            $jobItem['qty'];
            $product = $this->ProductTable->getProductById($jobItem['product_id']);
            $product['stock_qty'];
            $data = [
                "product_id" => $product['product_id'],
                "stock_qty" => $product['stock_qty'] - $jobItem['qty'],
            ];
            $this->ProductTable->updateProductById($data);
        }
    }

    public function addJob($params)
    {
        $jobData = array("cart_id" => $params);
        $this->JobFilter->setData($jobData);
        if (!$this->JobFilter->isValid()) {
            return array("isValid" => false, "data" => $this->JobFilter->getMessages());
        }

        $filteredParamData = $this->JobFilter->getValues();
        $cart = $this->CartTable->getCartByCartId($filteredParamData['cart_id']);
        if (!$cart) {
            return array("isValid" => false, "data" => 'Invalid cart id');
        } else {
            $jobId = $this->JobTable->copyCartToJob($filteredParamData['cart_id']);
            if (!$jobId) {
                return array("isValid" => false, "data" => 'Invalid job id');
            } else {
                $this->JobItemsTable->copyCartItemsToJobItems($filteredParamData['cart_id'], $jobId);
                return array("isValid" => true, "data" => $jobId);

            }
        }

    }

    public function addJobAndUpdateStockQty($params)
    {
        $job = $this->addJob($params);
        $this->updateStockQty($job['data']);
        return array("isValid" => true, "data" => $job['data']);
    }

    public function getJob($params)
    {

        $jobData = array("job_order_id" => $params);
        $validation = $this->JobFilter->getJobFilter()->setData($jobData);

        if (!$validation->isValid()) {
            return array("isValid" => false, "data" => $validation->getMessages());
        } else {
            $filteredParamData = $validation->getValues();
            $existingJob = $this->JobTable->getJobByJobId($filteredParamData['job_order_id']);
            if (!$existingJob) {
                return array("isValid" => false, "data" => "Invalid job id");
            }
            $job = $this->JobTable->getJobByJobId($filteredParamData['job_order_id']);
            $job->job_order_id = "0000" . $job->job_order_id;
            return array("isValid" => true, "data" => array(
                "jobItemData" => $this->JobItemsTable->getJobItemById($filteredParamData['job_order_id']),
                "jobData" => $job,
            ));
        }
    }
}
