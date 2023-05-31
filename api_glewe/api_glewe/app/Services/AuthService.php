<?php

namespace App\Services;
use Exception;
use App\Repositories\AuthRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class AuthService
{
    protected AuthRepository $_authRepository;
    public function __construct(AuthRepository $authRepository)
    {
       $this->_authRepository = $authRepository;
    }

     //register user
     public function registerUser($lastName, $firstName, $gender, $profession, $schoolDegree, $email, $phoneNumber,$password,$role, $countryId){

         try {
         //check on gender
         $gender = strtoupper(trim($gender));

         // si le champs genre existe verifier si cest soit M m F ou f
             if ($gender !== '' && $gender !== 'M' && $gender !== 'F') {
                     throw new Exception("Veuillez entrer un genre valide.");
             }

         //check on phone number
         //TODO: integrer le + au debut de chaque numero
         if(isset($phoneNumber) ){
            $phoneNumber = strtoupper(trim($phoneNumber));

            if (!preg_match('/[0-9]{2}/', $phoneNumber)) {
                throw new Exception("Veuillez entrer un numéro de téléphone valide.");
            }
         }

         //la longueur minimum du password doit etre 5 caracteres
         if (strlen($password) < 5) {
             throw new Exception("Veuillez entrer un mot de passe valide comportant un minimum de cinq caractères.");
         }

         //hash password
         $password = Hash::make($password);
         $userUid =  (string) Str::orderedUuid();

         //register user
         $creationResult = $this->_authRepository->registerUser($userUid, $lastName, $firstName, $gender, $profession, $schoolDegree, $email, $phoneNumber,$password,$role, $countryId);

         return $creationResult;

         } catch (\Exception $th) {
             throw $th;
         }

 }

 public function authenticateUser($login, $password){
    try{
        return $this->_authRepository->authenticateUser($login, $password);

    } catch (Exception $th) {
        throw $th;
    }

}//end authenticateUser
    //
}
