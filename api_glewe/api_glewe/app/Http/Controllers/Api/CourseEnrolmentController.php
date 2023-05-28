<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\OperationService;
use Exception;
use Illuminate\Support\Facades\Validator;


class CourseEnrolmentController extends Controller
{
    protected OperationService $_operationService;

    public function __construct(OperationService $operationService)
    {
       $this->_operationService = $operationService;
    }

    public function createCourseEnrolment(Request $request){
        try{
            $rData=$request->only(['user_id',"course_id"]);
            $validator=[
                'user_id' => ['required','exists:users,id'],
                'course_id' => ['required','exists:courses,id']
            ];
            $validationMessages = [
                'course_id.required' => "La formation initiale est requise",
                'course_id.exists' => "La formation initiale n'est pas valide",
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
            $user_id=$rData['user_id'];
            $course=$rData['course_id'];

            $result = $this->_operationService->createCourseEnrolment($course, $user_id);
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


    public function userCourse(Request $request){
        try{
            $rData=$request->only(['user_id']);
            $validator=[
                'user_id' => ['required','exists:categories,id'],
            ];
            $validationMessages = [
                'user_id.required' => "La reference de l'utilisateur est requis",
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
            $userId=  $rData['user_id'];

            $result = $this->_operationService->userCourse($userId);

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

    public function ratingCourse(Request $request){
        try{
            $rData=$request->only(['user_id',"course_id","note"]);
            $validator=[
                'user_id' => ['required','exists:users,id'],
                'course_id' => ['required','exists:courses,id'],
                'note' => ['required']
            ];
            $validationMessages = [
                'course_id.required' => "La formation initiale est requise",
                'course_id.exists' => "La formation initiale n'est pas valide",
                'user_id.required' => "La reference de l'admin est requis",
                'user_id.exists' => "La reference de l'admin n'est pas valide",
                'note.required' => "La note de la formation est requise",
            ];
            $validatorResult=Validator::make( $rData, $validator, $validationMessages);

            if ($validatorResult->fails()) {
                return response()->json([
                    'data' => $validatorResult->errors()->first(),
                    'status' => "error",
                    'message' => $validatorResult->errors()->first(),
                ], 400);
            }
            $user_id=$rData['user_id'];
            $course=$rData['course_id'];
            $note=$rData['note'];

            $result = $this->_operationService->ratingCourse($course, $user_id, $note);
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
