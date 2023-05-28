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

class OperationRepository implements OperationRepositoryInterface
{

    public function createCourse($name, $category, $name_trainer, $price, $meaning, $type, $level, $duration, $lang, $fileName){
        try{
            $course = new Course();
            $course->name = $name;
            $course->category_id = $category;
            $course->trainer_name = $name_trainer;
            $course->price = $price;
            $course->description = $meaning;
            $course->course_type = $type;
            $course->course_level = $level;
            $course->duration = $duration;
            $course->language_id = $lang;
            $course->cover = $fileName;
            $course->enrolled_student = 0;
            $course->save();
            return true;


        }catch(Exception $ex){
            throw new Exception($ex);

        }
    }

    public function getCourse(){
        try{
            $modules =  Course::with( "category","language", "courses_enrolments","modules")->get();
            return $modules;

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


    public function createModule($name, $course, $duration, $fileName){
        try{
            $module = new Module();
            $module->name = $name;
            $module->course_id = $course;
            $module->duration = $duration;
            $module->video = $fileName;
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
            $courses = Course::where('category_id', $categoryId)->with( "category","language", "courses_enrolments","modules")->get();
            return $courses;

        }catch(Exception $ex){
            throw new Exception($ex);

        }

    }

    public function searchCourse($name){
        try{
            $courses = Course::where('name','like',"%". $name. "%")->with( "category","language", "courses_enrolments","modules")->get();
            return $courses;

        }catch(Exception $ex){
            throw new Exception($ex);

        }

    }


    public function detailCourse($courseId){
        try{
            $courseFound =  Course::where('id',$courseId)->with( "category","language", "courses_enrolments","modules")->get();
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
            $course = Course::where('id',$courseId)->with( "category","language", "courses_enrolments","modules")->get();
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

            $courses = Course::whereIn('id', $courseIds)->with("category", "language", "courses_enrolments", "modules")->get();

            return $courses;
        } catch (Exception $ex) {
            throw new Exception($ex);
        }
    }

}
