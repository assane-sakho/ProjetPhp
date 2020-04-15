<?php

namespace App\Helpers;

use App\Student;
use App\Address;
use App\Folder;
use App\Registration;

class StudentHelper
{
    public static function checkIfStudentExist($email, $password)
    {
        $result = true;

        $student = Student::where([
            'email' => $email,
            'password' => $password
        ])->first();

        if ($student == null) {
            $result = false;
        }
        return array($result, $student);
    }

    public static function updateSessionVar()
    {
        $id = session('student')->id;
        $student = Student::find($id);
        session()->put('student', $student);
    }

    private static function alreadyExist($lastname, $firstname, $cardId, $phoneNumber, $email)
    {
        $userId =  session('student')->id ?? '';

        $studentsExceptCurrent = Student::where('id', '!=', $userId)->get();

        $allStudents = Student::where([
            'lastname' => $lastname,
            'firstname' => $firstname
        ])->orwhere('card_id', $cardId)
            ->orwhere('email', $email)
            ->orwhere('phone_number', $phoneNumber)->get();

        $intersect = $allStudents->intersect($studentsExceptCurrent);

        return ($intersect->count() >= 1);
    }

    public static function tryAddStudent($lastname, $firstname, $birthdate, $cardId, $phoneNumber, $email, $password, $street, $city, $zip_code)
    {
        if ($email == 'admin@parisnanterre.fr') {
            return ResponseHelper::returnResponseError('emailNotPossible');
        } else if (!StudentHelper::alreadyExist($lastname, $firstname, $cardId, $phoneNumber, $email)) {

            $student = StudentHelper::createStudent($lastname, $firstname, $birthdate, $cardId, $phoneNumber, $email, $password, $street, $city, $zip_code);

            session()->put('student', $student);

            return ResponseHelper::returnResponseSuccess(['nextLocation' => '/Registration']);
        } else {

            return ResponseHelper::returnResponseError('alreadyExist');
        }
    }

    private static function createStudent($lastname, $firstname, $birthdate, $cardId, $phoneNumber, $email, $password, $street, $city, $zip_code)
    {
        $address = StudentHelper::addStudentAddress($street, $city, $zip_code);

        $folder = StudentHelper::addStudentFolder();

        $registration = StudentHelper::addStudentRegistration($folder->id);

        $student = StudentHelper::addStudent($lastname, $firstname, $birthdate, $cardId, $phoneNumber, $email, $password, $address->id, $registration->id);

     

        return $student;
    }

    private static function addStudentAddress($street, $city, $zip_code)
    {
        return Address::create([
            'street' => $street,
            'city' => $city,
            'zip_code' => $zip_code
        ]);
    }

    private static function addStudent($lastname, $firstname, $birthdate, $cardId, $phoneNumber, $email, $password, $address_id, $registration_id)
    {
        return Student::create([
            'lastname' => $lastname,
            'firstname' => $firstname,
            'card_id' => $cardId,
            'birthdate' => $birthdate,
            'phone_number' => $phoneNumber,
            'email' => $email,
            'password' => $password,
            'address_id' => $address_id,
            'registration_id' => $registration_id
        ]);
    }

    private static function addStudentFolder()
    {
        return Folder::create();
    }

    private static function addStudentRegistration($folder_id)
    {
        return Registration::create([
            'folder_id' => $folder_id
        ]);
    }

    public static function tryUpdateStudent($lastname, $firstname, $birthdate, $cardId, $phoneNumber, $email, $password, $street, $city, $zip_code)
    {
        if ($email == 'admin@parisnanterre.fr') {
            return ResponseHelper::returnResponseError('emailNotPossible');
        } else if (!StudentHelper::alreadyExist($lastname, $firstname, $cardId, $phoneNumber, $email)) {

            StudentHelper::updateStudent($lastname, $firstname, $birthdate, $cardId, $phoneNumber, $email, $password, $street, $city, $zip_code);
            StudentHelper::updateSessionVar();

            return ResponseHelper::returnResponseSuccess();
        } else {

            return ResponseHelper::returnResponseError('alreadyExist');
        }
    }

    private static function updateStudent($lastname, $firstname, $birthdate, $cardId, $phoneNumber, $email, $password, $street, $city, $zip_code)
    {
        StudentHelper::updateStudentAddress($street, $city, $zip_code);

        StudentHelper::updateStudentInfo($lastname, $firstname, $birthdate, $cardId, $phoneNumber, $email, $password);
    }

    private static function updateStudentInfo($lastname, $firstname, $birthdate, $cardId, $phoneNumber, $email, $password)
    {
        $student = session('student');

        $student->lastname = $lastname;
        $student->firstname = $firstname;
        $student->card_id = $cardId;
        $student->birthdate = $birthdate;
        $student->phone_number = $phoneNumber;
        $student->email = $email;
        $student->email = $email;

        if ($password) {
            $student->password = $password;
        }
        $student->save();
        return $student;
    }

    private static function updateStudentAddress($street, $city, $zip_code)
    {
        $address = session('student')->address;
        $address->street = $street;
        $address->city = $city;
        $address->zip_code = $zip_code;
        $address->save();
        return $address;
    }
}
