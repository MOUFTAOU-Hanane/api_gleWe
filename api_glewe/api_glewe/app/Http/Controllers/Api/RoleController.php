<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ParamsService;
use Exception;

class RoleController extends Controller
{
    //

    protected ParamsService $_paramService;
    public function __construct(ParamsService $paramService)
    {
       $this->_paramService= $paramService;
    }

    public function listingRole(){
        try{
            $result = $this->_paramService->listingRole();
            return response()->json([
                'data' => $result,
                'status' => true, 'message' => "success",
            ], 200);

        }catch(Exception $ex){
            throw new Exception($ex);
        }

    }

}
