<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\OperationService;
use App\Services\FileService;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class CourseController extends Controller
{
    protected OperationService $_operationService;
    protected FileService $_fileService;

    public function __construct(OperationService $operationService, FileService $fileService)
    {
       $this->_operationService = $operationService;
       $this->_fileService = $fileService;
    }


     //
     public function createCourse(Request $request){
        try{
            $rData=$request->only(['user_id','name', "category_id", 'trainer_name', 'price','description',"estimated_duration","language_id"]);
            $validator=[
                'user_id' => ['required','exists:users,reference'],
                'name' => ['required'],
                'category_id' => ['required','exists:categories,id'],
                'trainer_name' => ['required'],
                'price' => ['required'],
                'description' => ['required'],
                'estimated_duration' => ['required'],
                'language_id' => ['required', 'exists:languages,id'],
            ];
            $validationMessages = [
                'name.required' => "Le nom de la formation est requis",
                'category_id.required' => "La catégorie de la formation est requise",
                'category_id.exists' => "La catégorie de la formation n'est pas valide",
                'trainer_name.required' => "Le nom du formateur est requis",
                'price.required' => "Le prix de la formation est requis est requis",
                'description.required' => "Une description de la formation est requise",
                'estimated_duration.required' => "La durée estimée par le cours est requise",
                'language_id.required' => "Le language de la formation est requis",
                'language_id.exists' => "Le language de la formation n'est pas valide",
                'user_id.required' => "La reference de l'admin est requis",
                'user_id.exists' => "La reference de l'admin n'est pas valide",


            ];
            $validatorResult=Validator::make( $rData, $validator, $validationMessages);

            if ($validatorResult->fails()) {
                return response()->json([
                    'data' => $validatorResult->errors()->first(),
                   'status' => false,
                    'message' => $validatorResult->errors()->first(),
                ], 400);
            }
            $user_id=  $rData['user_id'];
            $name=  $rData['name'];
            $category=  $rData['category_id'];
            $name_trainer=  $rData['trainer_name'];
            $price=  $rData['price'];
            $meaning=  $rData['description'];
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

            $result = $this->_operationService->createCourse($name, $category, $name_trainer, $price, $meaning, $duration, $lang, $fileName, $user_id);
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
                       "status"=> true,
                        "message"=> "succes",
                    ]
                    );

            }

        }catch(Exception $ex){
            log::error($ex->getMessage());
            return response()->json(
                [

                   "status"=> false,
                    "message"=> "Une erreur est survenue pendant la création de la formation. Veuillez réessayer",
                ]
                );
        }

    }

    public function deleteCourse(Request $request){
        try{
            $rData=$request->only(['user_id', "course_id"]);
            $validator=[
                'user_id' => ['required','exists:users,id'],
                'course_id' => ['required','exists:courses,id'],
            ];
            $validationMessages = [
                'course_id.required' => "L'identifiant de la formation est requis",
                'course_id.exists' => "L'identifiant de la formation n'est pas valide",
                'user_id.required' => "La reference de l'admin est requis",
                'user_id.exists' => "La reference de l'admin n'est pas valide",
            ];
            $validatorResult=Validator::make( $rData, $validator, $validationMessages);

            if ($validatorResult->fails()) {
                return response()->json([
                    'data' => $validatorResult->errors()->first(),
                   'status' => false,
                    'message' => $validatorResult->errors()->first(),
                ], 400);
            }
            $user_id=  $rData['user_id'];
            $courseId=  $rData['course_id'];

            $result = $this->_operationService->deleteCourse($courseId, $user_id);
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
                       "status"=> true,
                        "message"=> "succes",
                    ]
                    );

            }

        }catch(Exception $ex){
            return response()->json(
                [

                   "status"=> false,
                    "message"=> $ex->getMessage(),
                ]
                );
        }

    }

    public function getCourse(){
        try{
            $result = $this->_operationService->getCourse();
            return response()->json([
                'data' => $result,
               'status' => true,  'message' => "success",
            ], 200);

        }catch(Exception $ex){
            log::error( $ex);
            return response()->json([

               'status' => false,
                'message' => "Une erreur est survenue pour voir la liste des formations.Veuillez réessayer",
            ], 400);
        }

    }


 /**
 * @OA\Post(
 *     path="/api/offer/search-course-by-category",
 *     tags={"search-course-by-category"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="category_id", type="integer", example=1),
 *
 *         )
 *     ),
 *     @OA\Response(response="200", description="listing course in terms of category"),
 *
 * )
 */

    public function searchCourseByCategory(Request $request){
        try{
            $rData=$request->only(['category_id']);
            $validator=[
                'category_id' => ['required','exists:categories,id'],
            ];
            $validationMessages = [
                'category_id.required' => "La reference de la catégorie est requise",
                'category_id.exists' => "La reference de la catégorie n'est pas valide",
            ];
            $validatorResult=Validator::make( $rData, $validator, $validationMessages);

            if ($validatorResult->fails()) {
                return response()->json([
                    'data' => $validatorResult->errors()->first(),
                   'status' => false,
                    'message' => $validatorResult->errors()->first(),
                ], 400);
            }
            $categoryId=  $rData['category_id'];

            $result = $this->_operationService->searchCourseByCategory($categoryId);

                return response()->json(
                    [
                        "data"=> $result,
                       "status"=> true,
                        "message"=> "succes",
                    ]
                    );



        }catch(Exception $ex){
            return response()->json(
                [

                   "status"=> false,
                    "message"=> $ex->getMessage(),
                ],400);
        }

    }

     /**
 * @OA\Post(
 *     path="/api/offer/search-course",
 *     tags={"search-course-by-name"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="name", type="string", example="salade"),
 *
 *         )
 *     ),
 *     @OA\Response(response="200", description="listing course in terms of name"),
 *
 * )
 */
    public function searchCourse(Request $request){
        try{
            $rData=$request->only(['name']);
            $validator=[
                'name' => ['required']
            ];
            $validationMessages = [
                'name.required' => "Le nom de la formation est requis",
            ];
            $validatorResult=Validator::make( $rData, $validator, $validationMessages);

            if ($validatorResult->fails()) {
                return response()->json([
                    'data' => $validatorResult->errors()->first(),
                   'status' => false,
                    'message' => $validatorResult->errors()->first(),
                ], 400);
            }
            $name=  $rData['name'];

            $result = $this->_operationService->searchCourse($name);

                return response()->json([
                        "data"=> $result,
                       "status"=> true,
                        "message"=> "succes",
                    ]
                    );
        }catch(Exception $ex){
            log::error($ex->getMessage());
            return response()->json(
                [

                   "status"=> false,
                    "message"=>"Une erreur est survenue.Veuillez réessayer",
                ],400
                );
        }

    }



     /**
 * @OA\Post(
 *     path="/api/offer/course-detail",
 *     tags={"detail-course"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="course_id", type="integer", example="1"),
 *
 *         )
 *     ),
 *     @OA\Response(response="200", description="detail course"),
 *
 * )
 */

    public function detailCourse(Request $request){
        try{
            $rData=$request->only(["course_id"]);
            $validator=[
                'course_id' => ['required','exists:courses,id'],
            ];
            $validationMessages = [
                'course_id.required' => "L'identifiant de la formation est requis",
                'course_id.exists' => "L'identifiant de la formation n'est pas valide"
            ];
            $validatorResult=Validator::make( $rData, $validator, $validationMessages);

            if ($validatorResult->fails()) {
                return response()->json([
                    'data' => $validatorResult->errors()->first(),
                   'status' => false,
                    'message' => $validatorResult->errors()->first(),
                ], 400);
            }
            $courseId=  $rData['course_id'];

            $result = $this->_operationService->detailCourse($courseId);

                return response()->json(
                    [
                        "data"=> $result,
                       "status"=> true,
                        "message"=> "succes",
                    ]
                    );
        }catch(Exception $ex){
            log::error( $ex->getMessage());
            return response()->json(
                [

                   "status"=> false,
                    "message"=> "Une erreur est survenue pour voir le detail de la formation.Veuillez réessayer",
                ],400
                );
        }

    }

            /**
 * @OA\Get(
 *     path="/api/offer/popular-course",
 *     tags={"popular-course"},
 *     @OA\Response(response="200", description="popular course"),
 *
 * )
 */

    public function getPopularCourse(){
        try{
            $result = $this->_operationService->getPopularCourse();
            return response()->json([
                'data' => $result,
               'status' => true,  'message' => "success",
            ], 200);

        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return response()->json(
                [

                   "status"=> false,
                    "message"=> "Une erreur est survenue lors du chargement des cours.Veuillez réessayer",
                ],400
                );
        }

    }

         /**
 * @OA\Post(
 *     path="/api/offer/user-validated-course",
 *     tags={"finish-course"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="course_id", type="integer", example=1),
 *             @OA\Property(property="user_id", type="string", example="99487892-f338-4740-88e7-b3377eafe173"),
 *         )
 *     ),
 *     @OA\Response(response="200", description="I finished this course"),
 *
 * )
 */

    public function finishCourse(Request $request){
        try{
            $rData=$request->only(["course_id","user_id"]);
            $validator=[
                'course_id' => ['required','exists:courses,id'],
                "user_id"=> ['required','exists:users,reference'],
            ];
            $validationMessages = [
                'course_id.required' => "La reference du cours est requise",
                'course_id.exists' => "La reference du cours n'est pas valide",
                'user_id.required' => "La reference de l'utilisateur est requise",
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

            $idCourse=  $rData['course_id'];
            $idUser = $rData['user_id'];
            $result = $this->_operationService->finishCourse($idUser, $idCourse);
            return response()->json(
                [
                    "data"=> $result,
                   "status"=> true,
                    "message"=> "succes",
                ]
                );

        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return response()->json(
                [

                   "status"=> false,
                    "message"=> "Vous n'avez pas finir les modules.",
                ]
                );
        }

    }






}
