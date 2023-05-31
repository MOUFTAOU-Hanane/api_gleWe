<?php

namespace App\Services;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Exception;

class FileService
{
    public function saveImage( $file)
    {
        try {

            $baseUrl = env('IMAGE_BASE_URL'); //
            $baseUrlCover = env('COVERS_PATH'); //
            $extension  = "";
            $fileName = "";


                $extension = $file->getClientOriginalExtension();
                $fileName = date('Ymd') . '_' . time() . '_' . mt_rand(1000, 1000000) . '.' . $extension;
                $pathName =   $baseUrlCover . $fileName;
                Storage::disk('local')->put($pathName,  File::get($file));
                $fileName =  $baseUrl . $fileName;


            return $fileName;
        } catch (\Exception $th) {
         throw $th;


        }
    }//end saveImage


    //get image url or send a default image
   public function getImageUrl($name) {
    try {
        $baseUrl = env('COVERS_PATH'); //
        $fileName = storage_path('app/uploads/' . $name);


        if (Storage::disk('local')->exists($baseUrl .  $name))  {

             return response()->file($fileName);
        }

        throw new Exception('Image non trouvée');
    } catch (\Exception $th) {
        throw $th;
    }
} //end getImageUrl
}
