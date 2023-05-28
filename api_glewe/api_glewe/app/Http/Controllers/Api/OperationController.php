<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\OperationService;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Validator;

class OperationController extends Controller
{
    protected OperationService $_operationService;
    public function __construct(OperationService $operationService)
    {
       $this->_operationService = $operationService;
    }



    //
}
