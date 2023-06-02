<?php

namespace App\Repositories;
use  App\Interfaces\AuthRepositoryInterface;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;


class AuthRepository implements AuthRepositoryInterface
{
    public function registerUser($userUid, $lastName, $firstName, $gender, $profession, $schoolDegree, $email, $phoneNumber, $password,  $countryId){
        try{
            $user = new User();
            $user->first_name = $firstName;
            $user->last_name = $lastName;
            $user->gender = $gender;
            $user->profession = $profession;
            $user->school_degree = $schoolDegree;
            $user->email = $email;
            $user->password = $password;
            $user->user_type = "user";
            $user->country_id = $countryId;
            $user->reference = $userUid;
            $user->adresse = $phoneNumber;
            $user->save();


            return true;

        }catch(Exception $ex){
            throw  new Exception($ex);
        }

    }
    //

    public function authenticateUser($login, $password){
        try{

            $foundUser = User::where("email",$login)->first();
            $password = Hash::check($password, $foundUser->password);
             if (!$password) {
                throw new Exception("Votre email ou votre mot de passe est incorrect");
              }

            return array(
                "first_name" => $foundUser->first_name,
                "last_name" => $foundUser->last_name,
                "email" => $foundUser->email,
                "reference" => $foundUser->reference ,
            );

        }catch(Exception $ex){
            throw  new Exception($ex);
        }

    }


    public function registerAdmin($userUid, $lastName, $firstName, $gender, $profession, $schoolDegree, $email, $phoneNumber, $password, $countryId){
        try{
            $user = new User();
            $user->first_name = $firstName;
            $user->last_name = $lastName;
            $user->gender = $gender;
            $user->profession = $profession;
            $user->school_degree = $schoolDegree;
            $user->email = $email;
            $user->password = $password;
            $user->user_type = "admin";
            $user->country_id = $countryId;
            $user->reference = $userUid;
            $user->adresse = $phoneNumber;
            $user->save();


            return true;

        }catch(Exception $ex){
            throw  new Exception($ex);
        }

    }
    //

}
