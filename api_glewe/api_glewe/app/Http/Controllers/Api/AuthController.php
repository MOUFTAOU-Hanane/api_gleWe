<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;
use App\Services\AuthService;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    //
    protected AuthService $_authService;
    public function __construct(AuthService $authService)
    {
       $this->_authService = $authService;
    }

    public function registerUser(Request $request){
        try {

            $gender = (null === $request->get("gender"))? ""  : $request->get("gender") ;
            $profession = (null === $request->get("profession"))? null  : $request->get("profession") ;
            $schoolDegree = (null === $request->get("school_degree"))? null  : $request->get("school_degree") ;
            $phoneNumber = (null === $request->get("adresse"))? null  : $request->get("adresse") ;

           $rData = array(
            "last_name" => $request->get("last_name"),
            "first_name" => $request->get("first_name"),
            "password" => $request->get("password"),
            "email" => $request->get("email"),
            "role_id" => $request->get("role_id"),
            "country_id" => $request->get("country_id"),
            );

            $validator = [
                'last_name' => ['required'],
                'first_name' => ['required'],
                'email' => ['required','email','unique:users,email'],
                'country_id' => ['required','exists:countries,id'],
                'adresse' => ['nullable', 'unique:users,adresse' ],
                'password' => ['required'],
                'role_id' => ['required','exists:roles,id'],

            ];
            $validationMessages = ['last_name.required' => 'Le prénom est requis', 'first_name.required' => 'Le nom de famille est requis',
            'adresse.unique' => 'Cet numéro de téléphone est déja utilisé','email.required' => "L'adresse email est requis",
             'password.required' => 'Le mot de passe est requis','email.email' => 'Veuillez fournir une adresse email valide',
             'email.unique' => 'Cette adresse email est déja utilisée','country_id.required' => "L'identifiant du pays est requis" ,
            ];

            $validatorResult = Validator::make($rData, $validator, $validationMessages); //
            if ($validatorResult->fails()) {
                return response()->json([
                    'success' => false,
                    'status' => 400,
                    'message' => $validatorResult->errors()->first(), //
                ], 400);
            }

            //get data as variables
            $lastName = $rData["last_name"];
            $firstName = $rData["first_name"];
            $email = $rData["email"];
            $password= $rData["password"];
            $role= $rData["role_id"];
            $countryId= $rData["country_id"];

            //do operation
            $resultRegister = $this->_authService->registerUser($lastName, $firstName, $gender, $profession, $schoolDegree, $email, $phoneNumber,$password,$role,$countryId );

            //check on data

            return response()->json([
                'data' =>  $resultRegister,
                'status' =>200,  'message' => "Le compte a été créé avec succès",
            ], Response::HTTP_CREATED);

        } catch (Exception $ex) {
            log::error($ex->getMessage());
            //error result
            return response()->json([
                'data' => "",
                'status' => "error",
                'message' =>"Une erreur est survenue pendant l'inscription. Veuillez réessayer",
            ], 500);
        }

    }

      //authentication method
      public function authenticateUser(Request $request)
      {
          try {

              //request data
              $rData =  $request->only(["email", "password"]);

            //validator
            $validatorRules  = [
              'email' => ['required',"exists:users,email"],
              'password' => 'required'
            ];

              $validationMessages = [
                  'email.required' => "L'adresse email est requise",
                  'email.exists' => "L'adresse email n'est pas valide",
                  'password.required' => 'Le mot de passe est requis'
              ];

              $validatorResult = Validator::make($rData, $validatorRules, $validationMessages);
              if ($validatorResult->fails()) {
                  return response()->json([
                    'success' => false,
                    'status' => 400,
                    'message' => $validatorResult->errors()->first(), //
                  ], 400);
              }

              //get data
              $email = $rData ["email"] ;
              $password = $rData ["password"];

              //call service
                $resultRegisterOperation = $this->_authService->authenticateUser($email,$password);

              return response()->json([
                  'success' =>true,
                  'data' =>$resultRegisterOperation,
                  'status' => 200,
                  'message' => "Vous etes bien connecté",
              ], 200);
          }catch (Exception $ex) {
              //error result
              log::error($ex);
              return response()->json([
                  'data' => "",
                  'status' => "error",
                  'message' =>$ex->getMessage(),
              ], 400);
          }
      } //end login


}
