<?php
namespace App\Interfaces;
interface AuthRepositoryInterface
{
    public function registerUser($userUid, $lastName, $firstName, $gender, $profession, $schoolDegree, $email, $phoneNumber, $password, $countryId);
    public function registerAdmin($userUid, $lastName, $firstName, $gender, $profession, $schoolDegree, $email, $phoneNumber, $password, $countryId);
    public function authenticateUser($login, $password);
}
