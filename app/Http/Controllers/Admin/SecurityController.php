<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SecurityController extends Controller
{
    public function index(Request $request)
    {
        $user = [
            'name'  => Auth::user()->name,
            'email' => Auth::user()->email
        ];

        return $user;
    }

    public function saveName(Request $request)
    {
        $name       = $request->input('name');
        $name       = preg_replace('/[^A-Za-z0-9]|[\s]+/', ' ', $name);
        $name       = preg_replace('/ +/', ' ', $name);
        $name       = trim($name);
        $user       = Auth::user();
        $user->name = $name;

        $user->save();

        return $name;
    }

    public function saveEmail(Request $request)
    {
        $mail         = $request->input('mail');
        $emailConfirm = $request->input('mailConfirm');

        if ($mail == $emailConfirm) {
            $mail = trim($mail);

            $user        = Auth::user();
            $user->email = $mail;

            $user->save();

            return $mail;
        } else {
            return response('Email confirmation does not match', 400);
        }

    }

    public function savePassword(Request $request)
    {
        $pwd        = $request->input('pwd');
        $oldPwd     = $request->input('oldPwd');
        $pwdConfirm = $request->input('pwdConfirm');
        $user           = Auth::user();

        if ($oldPwd == '') {
            return response('Old password cannot be empty', 400);
        }

        if ($pwd == '') {
            return response('Password cannot be empty', 400);
        }

        if ($pwdConfirm == '') {
            return response('Password confirmation cannot be empty', 400);
        }

        if ($pwd == $pwdConfirm && Hash::check($oldPwd, $user->password)) {
            $pwd = trim($pwd);


            $user->password = bcrypt($pwd);

            $user->save();

            return response(200);
        } else {
            if ($pwd != $pwdConfirm){
                return response('Password confirmation does not match', 400);
            } else if (Hash::check($oldPwd, $user->password)) {
                return response('Old password does not match', 400);
            }
        }
    }
}
