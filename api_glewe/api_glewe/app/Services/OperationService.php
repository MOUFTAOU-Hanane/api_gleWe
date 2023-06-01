<?php

namespace App\Services;

use App\Repositories\OperationRepository;
use Exception;
use App\Models\User;
use App\Models\Role;
use App\Models\Module;


class OperationService
{
    protected OperationRepository $_operationRepository;
    public function __construct(OperationRepository $operationRepository)
    {
       $this->_operationRepository = $operationRepository;
    }

    public function createCourse($name, $category, $name_trainer, $price, $meaning, $duration, $lang, $fileName, $user_id){
        try{
            $userFound = User::where('reference', $user_id)->first();
            $userRole=  $userFound->role_id;
            $roleAdmin = Role::where("label","admin")->first();
            if ($roleAdmin->id !==  $userRole ){
                throw new Exception("Vous ne disposer pas des droits pour créer une formation");
            }
            else{
                return $this->_operationRepository->createCourse($name, $category, $name_trainer, $price, $meaning, $duration, $lang, $fileName);

            }

        }catch(Exception $ex){
             throw new Exception($ex);
        }
    }

    public function deleteCourse($courseId, $user_id){
        try{
            $userFound = User::where('reference', $user_id)->first();
            $userRole=  $userFound->role_id;
            $roleAdmin = Role::where("label","admin")->first();
            if ($roleAdmin->id !==  $userRole ){
                throw new Exception("Vous ne disposer pas des droits pour supprimer un module");
            }
            else{
                return $this->_operationRepository->deleteCourse($courseId);

            }

        }catch(Exception $ex){
            throw new Exception($ex);
        }
    }

    public function getCourse(){
    try{
         return $this->_operationRepository->getCourse();

    }catch(Exception $ex){
        throw new Exception($ex);
    }
    }

    public function createModule($name, $course, $duration,$user_id){
        try{
            $userFound = User::where('reference', $user_id)->first();
            $userRole=  $userFound->role_id;
            $roleAdmin = Role::where("label","admin")->first();
            if ($roleAdmin->id !==  $userRole ){
                throw new Exception("Vous ne disposer pas des droits pour créer un module");
            }
            else{
            $module = new Module();
            $module->name = $name;
            $module->course_id = $course;
            $module->duration = $duration;
            $module->save();
                return $this->_operationRepository->createModule($name, $course, $duration);

            }

        }catch(Exception $ex){
            throw new Exception($ex);
        }
    }

    public function createVideoModule($name, $module, $duration,$user_id, $fileName){
        try{
            $userFound = User::where('reference', $user_id)->first();
            $userRole=  $userFound->role_id;
            $roleAdmin = Role::where("label","admin")->first();
            if ($roleAdmin->id !==  $userRole ){
                throw new Exception("Vous ne disposer pas des droits pour créer un module");
            }
            else{

                return $this->_operationRepository->createVideoModule($name, $module, $duration,$fileName);

            }

        }catch(Exception $ex){
            throw new Exception($ex);
        }
    }


    public function updateModule($moduleId, $name, $course, $duration, $fileName, $user_id){
        try{
            $userFound = User::where('reference', $user_id)->first();
            $userRole=  $userFound->role_id;
            $roleAdmin = Role::where("label","admin")->first();
            if ($roleAdmin->id !==  $userRole ){
                throw new Exception("Vous ne disposer pas des droits pour modifier un module");
            }
            else{
                return $this->_operationRepository->updateModule($moduleId, $name, $course, $duration, $fileName,);

            }

        }catch(Exception $ex){
            throw new Exception($ex);
        }
    }

    public function deleteModule($moduleId, $user_id){
        try{
            $userFound = User::where('reference', $user_id)->first();
            $userRole=  $userFound->role_id;
            $roleAdmin = Role::where("label","admin")->first();
            if ($roleAdmin->id !==  $userRole ){
                throw new Exception("Vous ne disposer pas des droits pour supprimer un module");
            }
            else{
                return $this->_operationRepository->deleteModule($moduleId);

            }

        }catch(Exception $ex){
            throw new Exception($ex);
        }
    }

    public function getModule($courseId){
        try{

                return $this->_operationRepository->getModule($courseId);

        }catch(Exception $ex){
            throw new Exception($ex);
        }
    }

    public function searchCourseByCategory($categoryId)
    {
        try{
                return $this->_operationRepository->searchCourseByCategory($categoryId);

        }catch(Exception $ex){
            throw new Exception($ex);
        }
    }

    public function searchCourse($name){
        try{
                return $this->_operationRepository->searchCourse($name);

        }catch(Exception $ex){
            throw new Exception($ex);
        }
    }

    public function detailCourse($courseId) {
        try{
                return $this->_operationRepository->detailCourse($courseId);

        }catch(Exception $ex){
            throw new Exception($ex);
        }
    }

    public function createCourseEnrolment($course, $user_id){
        try{
                return $this->_operationRepository->createCourseEnrolment($course, $user_id);

        }catch(Exception $ex){
            throw new Exception($ex);
        }
    }

    public function userCourse($userId){
        try{
                return $this->_operationRepository->userCourse($userId);

        }catch(Exception $ex){
            throw new Exception($ex);
        }
    }

    public function ratingCourse($course, $user_id, $note){
        try{
                return $this->_operationRepository->ratingCourse($course, $user_id, $note);

        }catch(Exception $ex){
            throw new Exception($ex);
        }
    }

    public function getPopularCourse(){
        try{
             return $this->_operationRepository->getPopularCourse();

        }catch(Exception $ex){
            throw new Exception($ex);
        }
        }

        public function finishModule($idModule, $idUser){
            try{
                 return $this->_operationRepository-> finishModule($idModule, $idUser);

            }catch(Exception $ex){
                throw new Exception($ex);
            }
            }

            public function finishCourse($idUser, $idCourse){
                try{
                     return $this->_operationRepository-> finishCourse($idUser, $idCourse);

                }catch(Exception $ex){
                    throw new Exception($ex);
                }
                }





    //
}
