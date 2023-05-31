<?php

namespace App\Repositories;
use App\Interfaces\OperationRepositoryInterface;
use Exception;
use App\Models\Course;
use App\Models\CoursesEnrolment;
use App\Models\Module;
use App\Models\User;
use App\Models\Rating;
use Carbon\Carbon;
use App\Services\FileService;
use App\Models\VideoModule;

class OperationRepository implements OperationRepositoryInterface
{

    protected FileService $_fileService;
    public function __construct(FileService $fileService)
    {
       $this->_fileService = $fileService;
    }

    public function createCourse($name, $category, $name_trainer, $price, $meaning, $duration, $lang, $fileName){
        try{
            $course = new Course();
            $course->name = $name;
            $course->category_id = $category;
            $course->trainer_name = $name_trainer;
            $course->price = $price;
            $course->description = $meaning;
            $course->estimated_duration = $duration;
            $course->language_id = $lang;
            $course->cover = $fileName;
            $course->enrolled_student = 0;
            $course->save();
            return $course;


        }catch(Exception $ex){
            throw new Exception($ex);

        }
    }

    public function getCourse(){
        try{
            $courses =  Course::with( "category","language","modules",'quizzes')->get();
            return $courses;

        }catch(Exception $ex){
            throw new Exception($ex);

        }
    }

    public function deleteCourse($courseId){
        try{
            $courseFound =  Course::where('id',$courseId)->first();
            $courseFound->delete();
            return true;


        }catch(Exception $ex){
            throw new Exception($ex);

        }
    }


    public function createModule($name, $course, $duration){
        try{
            $module = new Module();
            $module->name = $name;
            $module->course_id = $course;
            $module->duration = $duration;
            $module->save();
            return true;





        }catch(Exception $ex){
            throw new Exception($ex);

        }
    }


    public function updateModule($moduleId, $name, $course, $duration, $fileName){
        try{
            $moduleFound =  Module::where('id',$moduleId)->first();
            $moduleFound->name = $name;
            $moduleFound->course_id = $course;
            $moduleFound->duration = $duration;
            $moduleFound->video = $fileName;
            $moduleFound->save();
            return true;


        }catch(Exception $ex){
            throw new Exception($ex);

        }
    }

    public function deleteModule($moduleId){
        try{
            $moduleFound =  Module::where('id',$moduleId)->first();
            $moduleFound->delete();
            return true;


        }catch(Exception $ex){
            throw new Exception($ex);

        }
    }

    public function getModule($courseId){
        try{
            $modules =  Module::where('course_id',$courseId)->with('course')->get();
            return $modules;

        }catch(Exception $ex){
            throw new Exception($ex);

        }
    }

    public function searchCourseByCategory($categoryId){
        try{
            $courses = Course::where('category_id', $categoryId)->with( "category","language", "modules",'quizzes')->get();
            return $courses;

        }catch(Exception $ex){
            throw new Exception($ex);

        }

    }

    public function searchCourse($name){
        try{
            $courses = Course::where('name','like',"%". $name. "%")->with( "category","language","modules",'quizzes')->get();
            return $courses;

        }catch(Exception $ex){
            throw new Exception($ex);

        }

    }


    public function detailCourse($courseId){
        try{
            $courseFound =  Course::where('id',$courseId)->with( "category","language", "modules",'quizzes')->get();
            return $courseFound;

        }catch(Exception $ex){
            throw new Exception($ex);

        }
    }

    public function createCourseEnrolment($course, $userId){
        try{
           $userFound =User::where('reference','like',$userId)->first();
           $courseEnrolment = new CoursesEnrolment();
           $courseEnrolment ->course_id = $course;
           $courseEnrolment ->user_id = $userFound->id;
           $courseEnrolment ->enrolment_date = Carbon::now();
           $courseEnrolment ->save();

           $courseFound = Course::where('id', $course)->first();
           $courseFound->enrolled_student = $courseFound->enrolled_student+1;
           $courseFound->save();
           return true;

        }catch(Exception $ex){
            throw new Exception($ex);

        }
    }

    public function ratingCourse($course, $userId, $note){
        try{
           $userFound = User::where('reference','like',$userId)->first();
           $rating = new Rating();
           $rating ->course_id = $course;
           $rating ->user_id = $userFound->id;
           $rating ->note = $note;
           $rating ->save();
           return true;

        }catch(Exception $ex){
            throw new Exception($ex);

        }
    }

    /*public function userCourse($userId){
        try{
            $data = [];
            $userFound =User::where('reference','like',$userId)->first();
            $userFoundId =  $userFound->id;

           $courses = CoursesEnrolment::where('user_id','=', $userFoundId)->with( "course")->get();
           foreach ($courses as $course){
            $courseId = $course->course_id;
            $course = Course::where('id',$courseId)->with( "category","language", "courses_enrolments","modules",'quizzes', 'ratings')->get();
           }
           $coursesUser = array_push($data, $course );
           return $coursesUser;


        }catch(Exception $ex){
            throw new Exception($ex);

        }
    }*/

    public function userCourse($userId) {
        try {
            $userFound = User::where('reference', 'like', $userId)->first();
            $courseIds = CoursesEnrolment::where('user_id', $userFound->id)->pluck('course_id');

            $courses = Course::whereIn('id', $courseIds)->with("category", "language", "modules")->get();

            return $courses;
        } catch (Exception $ex) {
            throw new Exception($ex);
        }
    }


    public function createVideoModule($name, $module, $duration,$file){
        try{
            $videoModule = new VideoModule();
            $videoModule->name = $name;
            $videoModule->module_id = $module;
            $videoModule->duration = $duration;
            $videoModule->video = $file;
            return $videoModule;


        }catch(Exception $ex){
            throw new Exception($ex);

        }

    }


    public function getPopularCourse(){
        try{
            $courses =  Course::with( "category","language","modules")->limit(4)->orderBy('id','DESC')->get();
            return $courses;

        }catch(Exception $ex){
            throw new Exception($ex);

        }
    }

    public function validatedCourse($id){
        try{
            $courses =  Course::where("id",$id)->first();
            return $courses;

        }catch(Exception $ex){
            throw new Exception($ex);

        }
    }

}
