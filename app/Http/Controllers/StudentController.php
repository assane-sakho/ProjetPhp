<?php

namespace App\Http\Controllers;

use App\Student;
use App\Address;
use Response;

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

        if(!$this->alreadyExist($lastname, $firstname, $carId, $phoneNumber, $email))
        {
            $address =  Address::create([ 
                'street' => request('userStreet'),
                'city' => request('userCity'),
                'zip_code' => request("userZipCode")
                ]);

            Student::create([
                'lastname' => $lastname,
                'firstname' => $firstname,
                'card_id' => $carId,
                'birthdate' => $birthdate,
                'phone_number' => $phoneNumber,
                'email' => $email,
                'password' => $password,
                'address_id' => $address->id
                ]);
            $returnData = array(
                'status' => 'success',
                'nextLocation' => '/Registration',
            );
            $returnCode = 200;
        }
        else{
            $returnData = array(
                'status' => 'error',
                'message' => 'alreadyExist'
            );
            $returnCode = 500;
        }
        return Response::json($returnData, $returnCode);
    }

    public function alreadyExist($lastname, $firstname, $cardId, $phoneNumber, $email)
    {
        $studentCount = 
        Student::where([
            'lastname' => $lastname,
            'firstname' => $firstname])
        ->orwhere('card_id', $cardId)
        ->orwhere('email', $email)
        ->orwhere('phone_number', $phoneNumber)
        ->count();

        return($studentCount >= 1);
    }
}
