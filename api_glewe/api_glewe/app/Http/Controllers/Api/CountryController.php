<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ParamsService;
use Exception;

class CountryController extends Controller
{
    protected ParamsService $_paramService;
    public function __construct(ParamsService $paramService)
    {
       $this->_paramService= $paramService;
    }

      ///listing languages
      public function listingCountry(){
        try{
            $result = $this->_paramService->listingCountry();
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
