<?php
 namespace App\Interfaces;
interface ParamsRepositoryInterface
{

    //CRUD CATEGORY
    public function createCategory($label);
    public function listingCategory();
    public function updateCategory($categoryId, $label);
    public function deleteCategory($categoryId);

    public function listingRole();
    public function listingLanguage();
    public function listingCountry();
}
