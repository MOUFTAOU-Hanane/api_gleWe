<?php
 namespace App\Interfaces;
interface OperationRepositoryInterface
{
    public function createCourse($name, $category, $name_trainer, $price, $meaning, $type, $level, $duration, $lang, $fileName);


}
