<?php

namespace App\Services;

use App\Repositories\OperationRepository;
use Exception;

class OperationService
{
    protected OperationRepository $_operationRepository;
    public function __construct(OperationRepository $operationRepository)
    {
       $this->_operationRepository = $operationRepository;
    }

    public function createCourse($name, $category, $name_trainer, $price, $meaning, $type, $level, $duration, $lang, $fileName){
        try{
            return $this->_operationRepository->createCourse($name, $category, $name_trainer, $price, $meaning, $type, $level, $duration, $lang, $fileName);

        }catch(Exception $ex){

        }
    }

    //
}
