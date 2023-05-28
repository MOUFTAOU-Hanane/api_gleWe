<?php

namespace App\Services;

use App\Repositories\OperationRepository;

class OperationService
{
    protected OperationRepository $_operationRepository;
    public function __construct(OperationRepository $operationRepository)
    {
       $this->_operationRepository = $operationRepository;
    }

    //
}
