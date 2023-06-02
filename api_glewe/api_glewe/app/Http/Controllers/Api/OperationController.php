<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\OperationService;
use App\Services\FileService;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class OperationController extends Controller
{
    protected OperationService $_operationService;
    protected FileService $_fileService;

    public function __construct(OperationService $operationService, FileService $fileService)
    {
       $this->_operationService = $operationService;
       $this->_fileService = $fileService;
    }


    //get image url or send a default image
    public function  getImageUrl($name)
    {
        try {
            //todo
              //do operation
              $getImage = $this->_fileService->getImageUrl($name);
              return  $getImage;

        } catch (Exception $ex) {
            //log exception
            log::error($ex->getMessage());

            //error result
            return response()->json([
                'data' => "",
               'status' => false,
                'message' => "Une erreur est survenue . Veuillez réessayer",
            ], 400);
        }
    } //end getImageUrl




    //
}
