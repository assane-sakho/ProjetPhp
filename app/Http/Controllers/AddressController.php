<?php

namespace App\Http\Controllers;

use App\Address;
use Illuminate\Http\Request;

class AddressController extends Controller
{
   function  add(Request $request)
   {
        return Address::create([ 
            'street' => $request->input("addName"),
            'city' => $request->input("addName"),
            'zip_code' => $request->input("addName")
            ]);
   }
}
