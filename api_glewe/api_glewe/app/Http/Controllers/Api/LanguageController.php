<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ParamsService;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;


class LanguageController extends Controller
{
    protected ParamsService $_paramService;
    public function __construct(ParamsService $paramService)
    {
       $this->_paramService= $paramService;
    }

      ///listing languages
                 /**
 * @OA\Get(
 *     path="/api/params/languages",
 *     tags={"languages"},
 *     @OA\Response(response="200", description="languages"),
 *
 * )
 */
      public function listingLanguage(){
        try{
            $result = $this->_paramService->listingLanguage();
            return response()->json([
                'data' => $result,
               'status' => true,'message' => "success",
            ], 200);

        }catch(Exception $ex){
            log::error($ex->getMessage());
            return response()->json([
                'status' => false,
                'message' => "Une erreur est survenue pendant le chargement.Veuillez réessayer.",
            ], 400);
        }

    }
}
