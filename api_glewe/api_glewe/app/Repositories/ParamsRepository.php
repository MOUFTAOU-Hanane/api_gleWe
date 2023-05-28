<?php

namespace App\Repositories;
use App\Interfaces\ParamsRepositoryInterface;
use Exception;
use App\Models\Category;
use App\Models\Language;
use App\Models\Role;
use App\Models\Country;



class ParamsRepository implements ParamsRepositoryInterface
{

    //CRUD CATEGORY
    public function createCategory($label){
        try{
            $category = new Category();
            $category ->label =$label;
            $category ->save();
            return true;

        }catch(Exception $ex){
            throw new Exception($ex);
        }

    }

    public function listingCategory(){
        try{
            $categories = Category::all();
            return $categories;

        }catch(Exception $ex){
            throw new Exception($ex);
        }

    }

    public function updateCategory($categoryId, $label){
        try{
            $categoryFound =  Category::where('id',$categoryId)->first();
            $categoryFound ->label =$label;
            $categoryFound ->save();
            return true;

        }catch(Exception $ex){
            throw new Exception($ex);
        }

    }
    public function deleteCategory($categoryId){
        try{
            $categoryFound =  Category::where('id',$categoryId)->first();
            $categoryFound->delete();
            return true;

        }catch(Exception $ex){
            throw new Exception($ex);
        }

    }
    //END CRUD



    //CRUD LANGAGES
    public function createLanguage($label){
        try{
            $language = new Language();
            $language ->label =$label;
            $language ->save();
            return true;

        }catch(Exception $ex){
            throw new Exception($ex);
        }

    }

    public function listingLanguage(){
        try{
            $language = Language::all();
            return $language;

        }catch(Exception $ex){
            throw new Exception($ex);
        }

    }

    public function updateLanguage($languageId, $label){
        try{
            $languageFound =  Language::where('id',$languageId)->first();
            $languageFound ->label =$label;
            $languageFound ->save();
            return true;

        }catch(Exception $ex){
            throw new Exception($ex);
        }

    }
    public function deleteLanguage($languageId){
        try{
            $languageFound =  Language::where('id',$languageId)->first();
            $languageFound->delete();
            return true;

        }catch(Exception $ex){
            throw new Exception($ex);
        }

    }
    //END CRUD

    public function listingRole(){
        try{
            $roles = Role::all();
            return $roles;

        }catch(Exception $ex){
            throw new Exception($ex);
        }

    }

    public function listingCountry(){
        try{
            $countries = Country::all();
            return $countries;

        }catch(Exception $ex){
            throw new Exception($ex);
        }

    }




}
