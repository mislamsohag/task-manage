<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Mail\OTPMail;
use App\Helper\JWTToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class UsersController extends Controller
{
    function RegistrationPage()
    {
        return view('pages.auth.registration-page');
    }

    function LoginPage()
    {
        return view('pages.auth.login-page');
    }

    function SendOTPPage()
    {
        return view('pages.auth.send-otp-page');
    }

    function VerifyOTPPage()
    {
        return view('pages.auth.verify-otp-page');
    }

    function PasswordResetPage()
    {
        return view('pages.auth.reset-pass-page');
    }

    function ProfilePage()
    {
        return view('pages.dashboard.profile-page');
    }
    function UserCreate(Request $request)
    {
        $name = $request->input('name');
        $email = $request->input('email');
        $password = $request->input('password');

        try {
            User::create([
                'name' => $name,
                'email' => $email,
                'password' => $password,
            ]);

            return response()->json([
                'status' => 'success',
                'msg' => 'User Create Successfully',
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'failed',
                'msg' => $e->getMessage(),
            ], 401);
        }
    }

    function UserLogin(Request $request)
    {
        // dd($email, $password);

        $count = User::where('email', '=', $request->input('email'))
            ->where('password', '=', $request->input('password'))
            ->select('id')->first();
        // dd($count);
        if ($count == null) {
            return response()->json([
                'status' => 'failed',
                'message' => "Unauthorized"
            ], 200);
        } else {
            // Jwt token issue
            $token = JWTToken::CreateToken($request->email, $count->id);
            return response()->json([
                'status' => 'success',
                'message' => 'Login success'
            ], 200)->cookie('token', $token, 60 * 24 * 30);
        }
    }

    function SendOTPCode(Request $request)
    {

        $email = $request->input('email');
        $otp = rand(1000, 9999);
        $count = User::where('email', '=', $email)->count();

        if ($count == 1) {
            // OTP Email Address
            Mail::to($email)->send(new OTPMail($otp));

            // OTO Code Table Update
            User::where('email', '=', $email)->update(['otp' => $otp]);

            return response()->json([
                'status' => 'success',
                'message' => '4 Digit OTP Code has been send to your email !'
            ], 200);
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => 'unauthorized'
            ]);
        }
    }



    function VerifyOTP(Request $request)
    {

        $email = $request->input('email');
        $otp = $request->input('otp');

        $count = User::where('email', '=', $email)
            ->where('otp', '=', $otp)
            ->count();

        if ($count != 1) {
            return response()->json([
                'status' => 'failed',
                'message' => 'unauthorized'
            ]);
        } else {
            // OTP Update
            User::where('email', '=', $email)->update(['otp' => '0']);
            // Password Issue and Token Issue
            $token = JWTToken::CreateTokenForSetPassword($request->input('email'));
            return response()->json([
                'status' => 'success',
                'message' => 'OTP verification successfully'
            ], 200)->cookie('token', $token, 60 * 24 * 30);
        }
    }



    function ResetPassword(Request $request)
    {

        try {
            $email = $request->header('email');
            $password = $request->input('password');
            User::where('email', '=', $email)->update(['password' => $password]);
            return response()->json([
                'status' => 'success',
                'message' => 'Request Successful',
            ], 200);

        } catch (Exception $exception) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Something Went Wrong',
            ], 200);
        }
    }

    function UserLogout()
    {
        // return redirect('/login-page')->cookie('token','',-1);
        return redirect('/')->cookie('token', 'success', -1);
    }

}
