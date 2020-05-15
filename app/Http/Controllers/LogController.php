<?php

namespace App\Http\Controllers;

use App\Helpers\LogHelper;

use Illuminate\Http\Request;

class LogController extends Controller
{
    /**
     * Connect a user
     */
    public function logIn(Request $request)
    {
        $email = $request->userLoginMail;
        $password = $request->userLoginPassword;

        return LogHelper::tryConnectUser($email, $password);
    }

    /**
     * Disconnect a user
     */
    public function logOut()
    {
        return LogHelper::disconnectUser();
    }
}
