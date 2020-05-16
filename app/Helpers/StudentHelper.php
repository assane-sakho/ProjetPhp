<?php

namespace App\Helpers;

use App\Student;
use App\Address;
use App\Folder;
use App\Registration;

use Illuminate\Support\Facades\Auth;

class StudentHelper
{
    /**
     * Return true if an existing student corresponding to the informations exist.
     *
     * @var email
     * @var lastname
     * @var firstname
     * @var cardId
     * @var phoneNumber
     * @return boolean
     */
    public static function alreadyExist($email, $lastname = null, $firstname = null, $cardId = null, $phoneNumber = null)
    {
        $userId = StudentHelper::getConnectedStudent()->id ?? '';

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

    /**
     * Try to add a student in database if no one exist with the same informations.
     *
     * @var email
     * @var lastname
     * @var firstname
     * @var cardId
     * @var phoneNumber
     * @var email
     * @var password
     * @var street
     * @var city
     * @var zip_code
     * @return jsonResponse
     */
    public static function tryAddStudent($lastname, $firstname, $birthdate, $cardId, $phoneNumber, $email, $password, $street, $city, $zip_code)
    {
        if (!self::emailValid($email)) {
            return ResponseHelper::returnResponseError('emailNotPossible');
        } else if (!self::alreadyExist($email, $lastname, $firstname, $cardId, $phoneNumber)) {

            $student = self::createStudent($lastname, $firstname, $birthdate, $cardId, $phoneNumber, $email, $password, $street, $city, $zip_code);

            Auth::loginUsingId($student->id);

            return ResponseHelper::returnResponseSuccess(['nextLocation' => '/Registration']);
        } else {

            return ResponseHelper::returnResponseError('alreadyExist');
        }
    }

    /**
     * Create a student.
     *
     * @var email
     * @var lastname
     * @var firstname
     * @var cardId
     * @var phoneNumber
     * @return student
     */
    private static function createStudent($lastname, $firstname, $birthdate, $cardId, $phoneNumber, $email, $password, $street, $city, $zip_code)
    {
        $address = self::addStudentAddress($street, $city, $zip_code);

        $folder = self::addStudentFolder();

        $registration = self::addStudentRegistration($folder->id);

        $student = self::addStudent($lastname, $firstname, $birthdate, $cardId, $phoneNumber, $email, $password, $address->id, $registration->id);

        return $student;
    }

    /**
     * Add a student address in database.
     *
     * @var street
     * @var city
     * @var zip_code
     * @return address
     */
    private static function addStudentAddress($street, $city, $zip_code)
    {
        return Address::create([
            'street' => $street,
            'city' => $city,
            'zip_code' => $zip_code
        ]);
    }

    /**
     * Add a student in database.
     *
     * @var lastname
     * @var firstname
     * @var birthdate
     * @var cardId
     * @var birthdate
     * @var phoneNumber
     * @var email
     * @var password
     * @var address_id
     * @var registration_id
     * @return student
     */
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

    /**
     * Add a student folder in database.
     *
     * @return folder
     */
    private static function addStudentFolder()
    {
        return Folder::create();
    }

    /**
     * Add a student registration in database.
     * 
     * @var folder_id
     * @return registration
     */
    private static function addStudentRegistration($folder_id)
    {
        return Registration::create([
            'folder_id' => $folder_id
        ]);
    }

    /**
     * Try to update a student in database if no one exist with the same informations.
     *
     * @var email
     * @var lastname
     * @var firstname
     * @var cardId
     * @var phoneNumber
     * @var email
     * @var password
     * @var street
     * @var city
     * @var zip_code
     * @return jsonResponse
     */
    public static function tryUpdateStudent($lastname, $firstname, $birthdate, $cardId, $phoneNumber, $email, $password, $street, $city, $zip_code)
    {
        if (!self::emailValid($email)) {
            return ResponseHelper::returnResponseError('emailNotPossible');
        } else if (!self::alreadyExist($email, $lastname, $firstname, $cardId, $phoneNumber)) {

            self::updateStudent($lastname, $firstname, $birthdate, $cardId, $phoneNumber, $email, $password, $street, $city, $zip_code);

            return ResponseHelper::returnResponseSuccess();
        } else {

            return ResponseHelper::returnResponseError('alreadyExist');
        }
    }

    /**
     * Update a student.
     *
     * @var lastname
     * @var firstname
     * @var birthdate
     * @var cardId
     * @var birthdate
     * @var phoneNumber
     * @var email
     * @var password
     * @var address_id
     * @var registration_id
     * @return student
     */
    private static function updateStudent($lastname, $firstname, $birthdate, $cardId, $phoneNumber, $email, $password, $street, $city, $zip_code)
    {
        self::updateStudentAddress($street, $city, $zip_code);

        self::updateStudentInfo($lastname, $firstname, $birthdate, $cardId, $phoneNumber, $email, $password);
    }

    /**
     * Update a student info in database.
     *
     * @var lastname
     * @var firstname
     * @var birthdate
     * @var cardId
     * @var birthdate
     * @var phoneNumber
     * @var email
     * @var password
     * @var address_id
     * @var registration_id
     * @return student
     */
    private static function updateStudentInfo($lastname, $firstname, $birthdate, $cardId, $phoneNumber, $email, $password)
    {
        $student = StudentHelper::getConnectedStudent();
        $student->update([
            "lastname" => $lastname, 
            "firstname" => $firstname, 
            "card_id" => $cardId, 
            "birthdate" => $birthdate, 
            "phone_number" => $phoneNumber, 
            "password" => $password ?? $student->password,
        ]);

        return $student;
    }

    /**
     * Update a student address in database.
     *
     * @var street
     * @var city
     * @var zip_code
     * @return address
     */
    private static function updateStudentAddress($street, $city, $zip_code)
    {
        $address = StudentHelper::getConnectedStudent()->address;
        $address->street = $street;
        $address->city = $city;
        $address->zip_code = $zip_code;
        $address->save();
        return $address;
    }

    /**
     * Return true if the email is valid.
     *
     * @var email
     * @return boolean
     */
    private static function emailValid($email)
    {
        $result = true;

        if ($email == config('const.admin') || TeacherHelper::alreadyExist($email)) {
            $result = false;
        }

        return $result;
    }

    /**
     * Return the student corresponding to the id
     *
     * @var id
     * @return student
     */
    public static function getStudent($id)
    {
        return Student::find($id);
    }

    /**
     * Return the informations of the student corresponding to the id
     *
     * @var id
     * @return jsonResponse
     */
    public static function getStudentInfo($id)
    {
        $student = Student::find($id);
        $address = $student->address;
        $registration = $student->registration;
        $registration_status = $registration->registration_status;
        $training = $registration->training;
        $folder = $registration->folder;
        $report_cards = $folder->report_cards;
        $messages = $student->messages;

        return ResponseHelper::returnResponseSuccess([
            'student' => $student,
            'address' => $address,
            'registration' => $registration,
            'registration_status' => $registration_status,
            'training' => $training,
            'folder' => $folder,
            'report_cards' => $report_cards,
            'messages' => $messages
        ]);
    }

    public static function isStudentConnected()
    {
        return auth()->guard('student')->check();
    }

    public static function getConnectedStudent()
    {
        return auth()->guard('student')->user();
    }
}
