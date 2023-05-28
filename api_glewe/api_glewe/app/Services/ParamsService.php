<?php

namespace App\Services;

use App\Repositories\ParamsRepository;
use Exception;

class ParamsService
{
    protected ParamsRepository $_paramsRepository;
    public function __construct(ParamsRepository $paramsRepository)
    {
       $this->_paramsRepository = $paramsRepository;
    }

    //
    public function createCategory($label){
        try{
            return $this->_paramsRepository->createCategory($label);
        }catch(Exception $ex){
            throw new Exception($ex);
        }
    }

    public function listingCategory(){
        try{
            return $this->_paramsRepository->listingCategory();
        }catch(Exception $ex){
            throw new Exception($ex);
        }
    }

    public function updateCategory($categoryId, $label){
        try{
            return $this->_paramsRepository->updateCategory($categoryId, $label);
        }catch(Exception $ex){
            throw new Exception($ex);

        }
    }

    public function deleteCategory($categoryId){
        try{
            return $this->_paramsRepository->deleteCategory($categoryId);
        }catch(Exception $ex){
            throw new Exception($ex);

        }
    }


    public function listingRole(){
        try{
            return $this->_paramsRepository->listingRole();
        }catch(Exception $ex){
            throw new Exception($ex);
        }
    }


    public function listingLanguage(){
        try{
            return $this->_paramsRepository->listingLanguage();
        }catch(Exception $ex){
            throw new Exception($ex);
        }
    }

    public function listingCountry(){
        try{
            return $this->_paramsRepository->listingCountry();
        }catch(Exception $ex){
            throw new Exception($ex);
        }
    }
}
