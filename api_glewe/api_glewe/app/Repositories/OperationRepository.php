<?php

namespace App\Repositories;
use App\Interfaces\OperationRepositoryInterface;
use Exception;
use App\Models\Course;


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
            $course->save();
            return true;


        }catch(Exception $ex){
            throw new Exception($ex);

        }
    }
    //
}
