<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\OperationService;
use App\Services\FileService;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Validator;

class CourseController extends Controller
{
    protected OperationService $_operationService;
    protected FileService $_fileService;

    public function __construct(OperationService $operationService, FileService $fileService)
    {
       $this->_operationService = $operationService;
       $this->_fileService = $fileService;
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
            $name=  $rData['name'];
            $category=  $rData['category_id'];
            $name_trainer=  $rData['trainer_name'];
            $price=  $rData['price'];
            $meaning=  $rData['description'];
            $type=  $rData['course_type'];
            $level=  $rData['course_level'];
            $duration=  $rData['estimated_duration'];
            $lang=  $rData['language_id'];

            if ($request->file('cover')->getSize() > 5000000) {
                throw new Exception("Veuillez fournir une photo de formation de moins de 5Mo");
            }

            //check error
            if ($request->hasFile('cover') === false) {
                throw new Exception("Veuillez fournir une photo de formation");
            }

              //save file
            //todo: mettre dans un service
            $file=$request->file('cover');

             //do operation
             $fileName = $this->_fileService->saveImage( $file);
            //check error
            if (!$fileName) {
              throw new Exception("Veuillez fournir une photo de formation");
            }

            $result = $this->_operationService->createCourse($name, $category, $name_trainer, $price, $meaning, $type, $level, $duration, $lang, $fileName);
            if($result  === false){
                return response()->json(
                    [
                        "data"=> "",
                        "status"=> "error",
                        "message"=> "error",
                    ]
                    );
            }else{
                return response()->json(
                    [
                        "data"=> $result,
                        "status"=> "success",
                        "message"=> "succes",
                    ]
                    );

            }

        }catch(Exception $ex){
            return response()->json(
                [
                    "data"=> "",
                    "status"=> "error",
                    "message"=> $ex->getMessage(),
                ]
                );
        }

    }
}
