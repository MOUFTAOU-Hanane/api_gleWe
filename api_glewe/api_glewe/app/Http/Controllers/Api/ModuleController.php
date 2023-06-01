<?php

namespace App\Http\Controllers\Api;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\OperationService;
use App\Services\FileService;
use Exception;
use Illuminate\Support\Facades\Validator;

class ModuleController extends Controller
{
    protected OperationService $_operationService;
    protected FileService $_fileService;
    public function __construct(OperationService $operationService, FileService $fileService)
    {
       $this->_operationService = $operationService;
       $this->_fileService = $fileService;
    }

    public function createModule(Request $request){
        try{
            $rData=$request->only(['user_id','name', "course_id", "duration"]);
            $validator=[
                'user_id' => ['required','exists:users,reference'],
                'name' => ['required'],
                'course_id' => ['required','exists:courses,id'],
                'duration' => ['required'],
            ];
            $validationMessages = [
                'name.required' => "Le nom du module est requis",
                'course_id.required' => "La formation initiale est requise",
                'course_id.exists' => "La formation initiale n'est pas valide",
                'duration.required' => "La durée estimée par le module est requise",
                'user_id.required' => "La reference de l'admin est requis",
                'user_id.exists' => "La reference de l'admin n'est pas valide",


            ];
            $validatorResult=Validator::make( $rData, $validator, $validationMessages);

            if ($validatorResult->fails()) {
                return response()->json([
                    'data' => $validatorResult->errors()->first(),
                    'status' => "error",
                    'message' => $validatorResult->errors()->first(),
                ], 400);
            }
            $user_id=  $rData['user_id'];
            $name=  $rData['name'];
            $course=  $rData['course_id'];
            $duration=  $rData['duration'];

            $result = $this->_operationService->createModule($name, $course, $duration,$user_id);
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

    public function updateModule(Request $request){
        try{
            $rData=$request->only(['module_id','user_id','name', "course_id", "duration"]);
            $validator=[
                'module_id' => ['required','exists:modules,id'],
                'user_id' => ['required','exists:users,reference'],
                'name' => ['required'],
                'course_id' => ['required','exists:courses,id'],
                'duration' => ['required'],
            ];
            $validationMessages = [
                'name.required' => "Le nom du module est requis",
                'course_id.required' => "La formation initiale est requise",
                'course_id.exists' => "La formation initiale n'est pas valide",
                'duration.required' => "La durée estimée par le module est requise",
                'user_id.required' => "La reference de l'admin est requis",
                'user_id.exists' => "La reference de l'admin n'est pas valide",
                'module_id.required' => "La reference du module est requis",
                'module_id.exists' => "La reference du module  n'est pas valide",


            ];
            $validatorResult=Validator::make( $rData, $validator, $validationMessages);

            if ($validatorResult->fails()) {
                return response()->json([
                    'data' => $validatorResult->errors()->first(),
                    'status' => "error",
                    'message' => $validatorResult->errors()->first(),
                ], 400);
            }
            $user_id=  $rData['user_id'];
            $name=  $rData['name'];
            $course=  $rData['course_id'];
            $duration=  $rData['duration'];
            $module_id=  $rData['module_id'];

            //check error
            if ($request->hasFile('video') === false) {
                throw new Exception("Veuillez fournir une video du module");
            }

              //save file
            //todo: mettre dans un service
            $files=$request->file('videos');

             //do operation


            $result = $this->_operationService->updateModule($module_id, $name, $course, $duration, $files, $user_id);
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

    public function getModule(Request $request){
        try{
            $rData=$request->only(["course_id"]);
            $validator=[
                'course_id' => ['required','exists:courses,id'],
            ];
            $validationMessages = [
                'course_id.required' => "La formation initiale est requise",
                'course_id.exists' => "La formation initiale n'est pas valide",
            ];
            $validatorResult=Validator::make( $rData, $validator, $validationMessages);

            if ($validatorResult->fails()) {
                return response()->json([
                    'data' => $validatorResult->errors()->first(),
                    'status' => "error",
                    'message' => $validatorResult->errors()->first(),
                ], 400);
            }

            $course=  $rData['course_id'];
            $result = $this->_operationService->getModule($course);
            return response()->json(
                [
                    "data"=> $result,
                    "status"=> "success",
                    "message"=> "succes",
                ]
                );

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

    public function deleteModule(Request $request){
        try{
            $rData=$request->only(["module_id", "user_id"]);
            $validator=[
                'module_id' => ['required','exists:modules,id'],
                'user_id' => ['required','exists:users,reference'],
            ];
            $validationMessages = [
                'module_id.required' => "La reference du module est requise",
                'module_id.exists' => "La reference du module n'est pas valide",
                'user_id.required' => "La reference de l'admin est requis",
                'user_id.exists' => "La reference de l'admin n'est pas valide",
            ];
            $validatorResult=Validator::make( $rData, $validator, $validationMessages);

            if ($validatorResult->fails()) {
                return response()->json([
                    'data' => $validatorResult->errors()->first(),
                    'status' => "error",
                    'message' => $validatorResult->errors()->first(),
                ], 400);
            }

            $moduleId=  $rData['module_id'];
            $user_id=  $rData['user_id'];
            $result = $this->_operationService->deleteModule($moduleId, $user_id);
            return response()->json([
                    "data"=> $result,
                    "status"=> "success",
                    "message"=> "succes",
                ]
                );

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



    public function createVideoModule(Request $request){
        try{
            $rData=$request->only(["user_id","name", "module_id", "duration"]);
            $validator=[
                'user_id' => ['required','exists:users,reference'],
                'name' => ['required'],
                'module_id' => ['required','exists:courses,id'],
                'duration' => ['required'],
            ];
            $validationMessages = [
                'name.required' => "Le nom du module est requis",
                'module_id.required' => "La reference du module est requise",
                'module_id.exists' => "La reference du module n'est pas valide",
                'duration.required' => "La durée estimée par le module est requise",
                'user_id.required' => "La reference de l'admin est requis",
                'user_id.exists' => "La reference de l'admin n'est pas valide",];
            $validatorResult=Validator::make( $rData, $validator, $validationMessages);

            if ($validatorResult->fails()) {
                return response()->json([
                    'data' => $validatorResult->errors()->first(),
                    'status' => "error",
                    'message' => $validatorResult->errors()->first(),
                ], 400);
            }
            $user_id=  $rData['user_id'];
            $name=  $rData['name'];
            $module=  $rData['module_id'];
            $duration=  $rData['duration'];

            //check error
            if ($request->hasFile('video') === false) {
                throw new Exception("Veuillez fournir une vidéo du module");
            }

              //save file
            //todo: mettre dans un service
            $file=$request->file('video');
            //do operation
            $fileName = $this->_fileService->saveImage( $file);
            //check error
            if (!$fileName) {
              throw new Exception("Veuillez fournir une photo de formation");
            }


            $result = $this->_operationService->createVideoModule($name, $module, $duration,$user_id, $fileName);
            if($result  === false){
                return response()->json(
                    [
                        "status"=> 400,
                        "message"=> "error",
                    ]
                    );
            }else{
                return response()->json(
                    [
                        "data"=> $result,
                        "status"=> 200,
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

    public function finishModule(Request $request){
        try{
            $rData=$request->only(["module_id"]);
            $validator=[
                'module_id' => ['required','exists:modules,id'],
                "user_id"=> ['required','exists:users,reference'],
            ];
            $validationMessages = [
                'module_id.required' => "La reference du module est requise",
                'module_id.exists' => "La reference du module n'est pas valide",
                'user_id.required' => "La reference de l'utilisateur est requise",
                'user_id.exists' => "La reference de l'utilisateur n'est pas valide",
            ];
            $validatorResult=Validator::make( $rData, $validator, $validationMessages);

            if ($validatorResult->fails()) {
                return response()->json([
                    'data' => $validatorResult->errors()->first(),
                    'status' => "error",
                    'message' => $validatorResult->errors()->first(),
                ], 400);
            }

            $module=  $rData['module_id'];
            $idUser = $rData['user_id'];
            $result = $this->_operationService->finishModule($module,  $idUser );
            return response()->json(
                [
                    "data"=> $result,
                    "status"=> "success",
                    "message"=> "succes",
                ]
                );

        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return response()->json(
                [
                    "data"=> "",
                    "status"=> "error",
                    "message"=> "Une erreur est survenue",
                ]
                );
        }

    }



}
