<?php

namespace App\Http\Controllers\Api;
use Illuminate\Support\Facades\Log;
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


                     /**
         *  * @OA\Info(
 *      version="1.0.0",
 *      title=" OpenApi Documentation",
 *      description=" Swagger OpenApi description",
 * )
 * @OA\Get(
 *     path="/api/params/countries",
 *     tags={"countries"},
 *     @OA\Response(response="200", description=" listing country"),
 *
 * )
 */
      ///listing languages
      public function listingCountry(){
        try{
            $result = $this->_paramService->listingCountry();
            return response()->json([
                'data' => $result,
               'status' => true,  'message' => "success",
            ], 200);

        }catch(Exception $ex){
            log::error($ex->getMessage());
            return response()->json([

                'status' => false,
                'message' =>"Une erreur est survenue lors du chargement de la liste des pays. ",
            ], 400);
        }

    }
}
