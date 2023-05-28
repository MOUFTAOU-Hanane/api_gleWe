<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    protected OperationService $_operationService;
    public function __construct(OperationService $operationService)
    {
       $this->_operationService = $operationService;
    }


     //listing marque
     public function createCourse(Request $request){
        try{
            $rData=$request->only(['name', "category_id", 'trainer_name', 'price','description', "course_type", "course_level","estimated_duration","language_id"]);
            $validator=[
                'name' => ['required'],
                'category_id' => ['required','exists:categories,id'],
                'trainer_name' => ['required'],
                'price' => ['required'],
                'description' => ['required'],
                'course_type' => ['required'],
                'course_level' => ['required'],
                'estimated_duration' => ['required'],
                'language_id' => ['required', 'exists:languages,id']
            ];
            $validationMessages = [
                'name.required' => "Le nom de la formation est requis",
                'category_id.required' => "La catégorie de la formation est requise",
                'category_id.exists' => "La catégorie de la formation n'est pas valide",
                'trainer_name.required' => "Le nom du formateur est requis",
                'price.required' => "Le prix de la formation est requis est requis",
                'description.required' => "Une description de la formation est requise",
                'course_type.required' => "Le type de la formation est requise",
                'course_level.required' => "Le niveau de la formation est requis",
                'estimated_duration.required' => "La durée estimée par le cours est requise",
                'language_id.required' => "Le language de la formation est requis",
                'language_id.exists' => "Le language de la formation n'est pas valide",


            ];
            $validatorResult=Validator::make( $rData, $validator, $validationMessages);

            if ($validatorResult->fails()) {
                return response()->json([
                    'data' => $validatorResult->errors()->first(),
                    'status' => "error",
                    'message' => $validatorResult->errors()->first(),
                ], 400);
            }




        }catch(Exception $ex){
            throw new Exception($ex);
        }

    }
}
