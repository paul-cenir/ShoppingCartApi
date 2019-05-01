<?php

namespace JobApi\Service;

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
    public function __construct(
        JobTable $JobTable,
        JobFilter $JobFilter,
        ProductsTable $ProductTable,
        CustomersTable $CustomersTable,
        Job $Job,
        JobItems $JobItems,
        JobItemsTable $JobItemsTable
    ) {
        $this->JobTable = $JobTable;
        $this->JobFilter = $JobFilter;
        $this->ProductTable = $ProductTable;
        $this->CustomersTable = $CustomersTable;
        $this->Job = $Job;
        $this->JobItems = $JobItems;
        $this->JobItemsTable = $JobItemsTable;
    }

    public function addJob($params)
    {
        $this->JobFilter->setData($params);
        if (!$this->JobFilter->isValid()) {
            return array("isValid" => false, "data" => $this->JobFilter->getMessages());
        }
        $filteredParamData = $this->JobFilter->getValues();
        $jobId = $this->JobTable->copyCartToJob($filteredParamData['cart_id']);
        if (!$jobId) {
            return array("isValid" => false, "data" => 'Invalid job id');
        } else {
            $this->JobItemsTable->copyCartItemsToJobItems($filteredParamData['cart_id'], $jobId);
            return array("isValid" => true, "data" => $jobId);
        }
    }

}
