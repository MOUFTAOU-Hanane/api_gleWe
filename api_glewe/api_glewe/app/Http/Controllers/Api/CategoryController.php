<?php

namespace App\Http\Controllers\Api;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ParamsService;
use Exception;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    //

    protected ParamsService $_paramService;
    public function __construct(ParamsService $paramService)
    {
       $this->_paramService= $paramService;
    }

    ///crezte category*
     /**
 * @OA\Post(
 *     path="/api/params/new-category",
 *     tags={"new category"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="label", type="string", example="hanane"),
 *         )
 *     ),
 *     @OA\Response(response="200", description="category created"),
 *
 * )
 */
    public function createCategory(Request $request){
        try{
            $rData =  $request->only([
                'label'
            ]);
              //data validation
        $validator = [
            'label' => ['required']
        ];

        $validationMessages = [
            'label.required' => " Le label est requis",
        ];
        $validatorResult = Validator::make($rData, $validator , $validationMessages);
        if ($validatorResult->fails()) {
            return response()->json([
                'data' => $validatorResult->errors()->first(),
                'status' => false,
                'message' => "Veuillez fournir des informations valides",
            ], 400);
        }

       //get data as variables
        $label = $rData["label"];

         //do operation
        $result = $this->_paramService->createCategory($label);
        if($result === false){
            return response()->json([
                'status' => false,  'message' => "Une erreur est survenue lors de l'enregistrement d'une catégorie de formation.",
            ], 400);


        }
        return response()->json([
            'data' =>$result,
            'status' => true, 'message' => "succes",
        ], 200);

         }catch(Exception $ex){
            log::error($ex->getMessage());
            return response()->json([

                'status' => false,
                'message' =>"Une erreur est survenue lors de la creation des catégories. ",
            ], 400);
        }
    }

    ///listing category
     /**
    * @OA\Get(
        *     path="/api/params/categories",
        *     tags={"categories"},
        *     @OA\Response(response="200", description=" listing categories"),
        *
        * )
        */
    public function listingCategory(){
        try{
            $result = $this->_paramService->listingCategory();
            return response()->json([
                'data' => $result,
               'status' => true,'message' => "success",
            ], 200);

        }catch(Exception $ex){
            log::error($ex);
            return response()->json([

                'status' => false,
                'message' => "Une erreur est survenue lors du listing des catégories.",
            ], 400);
        }

    }

    ///update category
    public function updateCategory(Request $request){
        try{
            $rData =  $request->only([
                'category_id',
                'label'
            ]);
              //data validation
        $validator = [
            'category_id' => ['required','exists:categories,id'],
            'label' => ['required']
        ];

        $validationMessages = [
            'label.required' => "Le label est requis",
            'category_id.required' => " L'identifiant de la catégorie est requis",
            'category_id.exists' => " L'identifiant de la catégorie n'est pas valide",
        ];
        $validatorResult = Validator::make($rData, $validator , $validationMessages);
        if ($validatorResult->fails()) {
            return response()->json([
                'data' => $validatorResult->errors()->first(),
                'status' => false,
                'message' => "Veuillez fournir des informations valides",
            ], 400);
        }

       //get data as variables
        $label = $rData["label"];
        $categoryId = $rData["category_id"];

         //do operation
        $result = $this->_paramService->updateCategory($categoryId, $label);
        if($result === false){
            return response()->json([
                'status' => false,  'message' => "Une erreur est survenue pendant la modification    d'une catégorie de formation.",
            ], 400);


        }
        return response()->json([
            'data' =>$result,
            'status' => true, 'message' => "succes",
        ], 200);

         }catch(Exception $ex){
            return response()->json([

                'status' => false,
                'message' => $ex->getMessage(),
            ], 400);
        }
    }

    ///delete category
    public function deleteCategory(Request $request){
        try{
            $rData =  $request->only([
                'category_id'
            ]);
              //data validation
        $validator = [
            'category_id' => ['required','exists:categories,id'],];

        $validationMessages = [
            'category_id.required' => " L'identifiant de la catégorie est requis",
            'category_id.exists' => " L'identifiant de la catégorie n'est pas valide",
        ];
        $validatorResult = Validator::make($rData, $validator , $validationMessages);
        if ($validatorResult->fails()) {
            return response()->json([
                'data' => $validatorResult->errors()->first(),
                'status' => false,
                'message' => "Veuillez fournir des informations valides",
            ], 400);
        }

       //get data as variables
        $label = $rData["label"];
        $categoryId = $rData["category_id"];

         //do operation
        $result = $this->_paramService->deleteCategory($categoryId, $label);
        if($result === false){
            return response()->json([
                'status' => false,  'message' => "Une erreur est survenue lors de la suppression d'une catégorie de formation.",
            ], 400);


        }
        return response()->json([
            'data' =>$result,
            'status' => true, 'message' => "succes",
        ], 200);

         }catch(Exception $ex){
            return response()->json([

                'status' => false,
                'message' => $ex->getMessage(),
            ], 400);
        }
    }


}
