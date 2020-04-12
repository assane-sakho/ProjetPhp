<?php

namespace App\Http\Controllers;

use App\Helpers\StudentHelper;

use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function add(Request $request)
    {
        $lastname = $request->userLastname;
        $firstname = $request->userFirstname;
        $carId = $request->userCardId;
        $birthdate = $request->userBirthdate;
        $phoneNumber = $request->userPhoneNumber;
        $email = $request->userMail;
        $password = $request->userPassword;

        $street = $request->userStreet;
        $city = $request->userCity;
        $zip_code = $request->userZipCode;

        return StudentHelper::tryAddStudent($lastname, $firstname, $birthdate, $carId, $phoneNumber, $email, $password, $street, $city, $zip_code);
    }

    public function update(Request $request)
    {
        $lastname = $request->userLastname;
        $firstname = $request->userFirstname;
        $cardId = $request->userCardId;
        $birthdate = $request->userBirthdate;
        $phoneNumber = $request->userPhoneNumber;
        $email = $request->userMail;
        $password = $request->userPassword;

        $street = $request->userStreet;
        $city = $request->userCity;
        $zip_code = $request->userZipCode;

        return StudentHelper::tryUpdateStudent($lastname, $firstname, $birthdate, $cardId, $phoneNumber, $email, $password, $street, $city, $zip_code);
    }
}
