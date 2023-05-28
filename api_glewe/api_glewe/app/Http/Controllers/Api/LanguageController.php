<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ParamsService;
use Exception;
use Illuminate\Support\Facades\Validator;

class LanguageController extends Controller
{
    protected ParamsService $_paramService;
    public function __construct(ParamsService $paramService)
    {
       $this->_paramService= $paramService;
    }

      ///listing languages
      public function listingLanguage(){
        try{
            $result = $this->_paramService->listingLanguage();
            return response()->json([
                'data' => $result,
                'status' => "success",  'message' => "success",
            ], 200);

        }catch(Exception $ex){
            return response()->json([
                'data' => "",
                'status' => "error",
                'message' => $ex->getMessage(),
            ], 400);
        }

    }
}
