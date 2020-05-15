<?php

namespace App\Http\Controllers\Student;

use App\Helpers\StudentHelper;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class StudentController extends Controller
{
    /**
     * Add a student
     */
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

    public function profile()
    {
        return View::make('student.profile');
    }

    /**
     * Update the connected student informations
     */
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

    /**
     * Get the connected student informations
     */
    public function getInfo(Request $request)
    {
        $studentId = $request->studentId;
        return StudentHelper::getStudentInfo($studentId);
    }
}
