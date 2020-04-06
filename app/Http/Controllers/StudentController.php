<?php

namespace App\Http\Controllers;

use App\Student;
use App\Address;
use App\Registration;
use App\Folder;

use Response;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function alreadyExist($lastname, $firstname, $cardId, $phoneNumber, $email)
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

        if ($email == 'admin@parisnanterre.fr') {
            $returnData = array(
                'status' => 'error',
                'message' => 'emailNotPossible'
            );
            $returnCode = 500;
        } else if (!$this->alreadyExist($lastname, $firstname, $carId, $phoneNumber, $email)) {

            $address =  Address::create([
                'street' => $street,
                'city' => $city,
                'zip_code' => $zip_code
            ]);

            $student = Student::create([
                'lastname' => $lastname,
                'firstname' => $firstname,
                'card_id' => $carId,
                'birthdate' => $birthdate,
                'phone_number' => $phoneNumber,
                'email' => $email,
                'password' => $password,
                'address_id' => $address->id
            ]);

            $folder = Folder::create();

            Registration::create([
                'student_id' => $student->id,
                'folder_id' => $folder->id
            ]);

            $request->session()->put('student', $student);

            $returnData = array(
                'status' => 'success',
                'nextLocation' => '/Registration',
            );
            $returnCode = 200;
        } else {
            $returnData = array(
                'status' => 'error',
                'message' => 'alreadyExist'
            );
            $returnCode = 500;
        }
        return Response::json($returnData, $returnCode);
    }

    public function update(Request $request)
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

        if ($email == 'admin@parisnanterre.fr') {
            $returnData = array(
                'status' => 'error',
                'message' => 'emailNotPossible'
            );
            $returnCode = 500;
        } else if (!$this->alreadyExist($lastname, $firstname, $carId, $phoneNumber, $email)) {
            $student = session('student');

            $student->lastname = $lastname;
            $student->firstname = $firstname;
            $student->card_id = $carId;
            $student->birthdate = $birthdate;
            $student->phone_number = $phoneNumber;
            $student->email = $email;
            $student->email = $email;

            if ($password) {
                $student->password = $password;
            }

            $student->address->street = $street;
            $student->address->city = $city;
            $student->address->zip_code = $zip_code;

            $student->save();
            session()->put('student', $student);

            $returnData = array(
                'status' => 'success',
            );
            $returnCode = 200;
        } else {
            $returnData = array(
                'status' => 'error',
                'message' => 'alreadyExist'
            );
            $returnCode = 500;
        }
        return Response::json($returnData, $returnCode);
    }
}
