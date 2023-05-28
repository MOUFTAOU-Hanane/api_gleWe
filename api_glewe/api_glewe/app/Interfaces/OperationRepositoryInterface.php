<?php
 namespace App\Interfaces;
interface OperationRepositoryInterface
{
    public function createCourse($name, $category, $name_trainer, $price, $meaning, $type, $level, $duration, $lang, $fileName);

    public function getCourse();

    public function deleteCourse($courseId);

    public function createModule($name, $course, $duration, $fileName);

    public function  updateModule($moduleId, $name, $course, $duration, $fileName);

    public function deleteModule($moduleId);

    public function getModule($courseId);

    public function searchCourseByCategory($categoryId);

    public function searchCourse($name);

    public function detailCourse($courseId);

    public function createCourseEnrolment($course, $user_id);

    public function userCourse($userId);

    public function ratingCourse($course, $userId, $note);


}
