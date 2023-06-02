<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\OperationService;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;



class CourseEnrolmentController extends Controller
{
    protected OperationService $_operationService;

    public function __construct(OperationService $operationService)
    {
       $this->_operationService = $operationService;
    }


            /**
 * @OA\Post(
 *     path="/api/offer/enrolment",
 *     tags={"enrolment-course"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="course_id", type="integer", example=1),
 *             @OA\Property(property="user_id", type="string", example="99487892-f338-4740-88e7-b3377eafe173"),
 *         )
 *     ),
 *     @OA\Response(response="200", description="I am registering for a course"),
 *
 * )
 */
    public function createCourseEnrolment(Request $request){
        try{
            $rData=$request->only(['user_id',"course_id"]);
            $validator=[
                'user_id' => ['required','exists:users,reference'],
                'course_id' => ['required','exists:courses,id']
            ];
            $validationMessages = [
                'course_id.required' => "La formation initiale est requise",
                'course_id.exists' => "La formation initiale n'est pas valide",
                'user_id.required' => "La reference de l'utilisateur est requis",
                'user_id.exists' => "La reference de l'utilisateur n'est pas valide",


            ];
            $validatorResult=Validator::make( $rData, $validator, $validationMessages);

            if ($validatorResult->fails()) {
                return response()->json([
                    'data' => $validatorResult->errors()->first(),
                   'status' => false,
                    'message' => $validatorResult->errors()->first(),
                ], 400);
            }
            $user_id=$rData['user_id'];
            $course=$rData['course_id'];

            $result = $this->_operationService->createCourseEnrolment($course, $user_id);
            if($result  === false){
                return response()->json(
                    [

                        "status"=> false,
                        "message"=> "error",
                    ]
                    );
            }else{
                return response()->json(

                    [
                        "data"=> $result,
                       'status' => true,
                        "message"=> "succes",
                    ]
                    );

            }

        }catch(Exception $ex){
            log::error($ex->getMessage());
            return response()->json(
                [

                    "status"=> false,
                    "message"=> "Vous êtes déjà inscrit à ce cours",
                ],400
                );
        }

    }


            /**
 * @OA\Post(
 *     path="/api/offer/course",
 *     tags={"user-course"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="user_id", type="string", example="99487892-f338-4740-88e7-b3377eafe173"),
 *         )
 *     ),
 *     @OA\Response(response="200", description="my course"),
 *
 * )
 */
    public function userCourse(Request $request){
        try{
            $rData=$request->only(['user_id']);
            $validator=[
                'user_id' => ['required','exists:users,reference'],
            ];
            $validationMessages = [
                'user_id.required' => "La reference de l'utilisateur est requis",
                'user_id.exists' => "La reference de l'utilisateur n'est pas valide",
            ];
            $validatorResult=Validator::make( $rData, $validator, $validationMessages);

            if ($validatorResult->fails()) {
                return response()->json([
                    'data' => $validatorResult->errors()->first(),
                   'status' => false,
                    'message' => $validatorResult->errors()->first(),
                ], 400);
            }
            $userId=  $rData['user_id'];

            $result = $this->_operationService->userCourse($userId);

                return response()->json(
                    [
                        "data"=> $result,
                       'status' => true,
                        "message"=> "succes",
                    ]
                    );



        }catch(Exception $ex){
            log::error($ex->getMessage());
            return response()->json(
                [

                    "status"=> false,
                    "message"=> "Une erreur est survenue. Veuillez réessayer",
                ],400
                );
        }

    }

                /**
 * @OA\Post(
 *     path="/api/offer/rating-course-by-user",
 *     tags={"rating-course"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="course_id", type="integer", example=1),
 *             @OA\Property(property="user_id", type="string", example="99487892-f338-4740-88e7-b3377eafe173"),
 *             @OA\Property(property="note", type="integer", example=12),
 *         )
 *     ),
 *     @OA\Response(response="200", description="I note the trainer"),
 *
 * )
 */
    public function ratingCourse(Request $request){
        try{
            $rData=$request->only(['user_id',"course_id","note"]);
            $validator=[
                'user_id' => ['required','exists:users,reference'],
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
                   'status' => false,
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

                        "status"=> false,
                        "message"=> "error",
                    ]
                    );
            }else{
                return response()->json(
                    [
                        "data"=> $result,
                       'status' => true,
                        "message"=> "succes",
                    ]
                    );

            }

        }catch(Exception $ex){
            log::error($ex->getMessage());
            return response()->json(
                [

                    "status"=> false,
                    "message"=> "Une erreur est survenue. Veuillez réessayer",
                ],400
                );
        }

    }



}
