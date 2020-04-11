<?php

namespace App\Http\Controllers;

use App\Helpers\LogHelper;

use Illuminate\Http\Request;

class LogController extends Controller
{
    public function logIn(Request $request)
    {
        $email = $request->userLoginMail;
        $password = $request->userLoginPassword;

        return LogHelper::connectTryConnectUser($email, $password);
    }

    public function logOut()
    {
        LogHelper::disconnectUser();
        return view('index');
    }
}
