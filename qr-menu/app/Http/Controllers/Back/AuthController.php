<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * @return Application|Factory|View
     */
    public function register()
    {
        return view('back.auth.register');
    }

    /**
     * @return Application|Factory|View
     */
    public function login()
    {
        return view('back.auth.login');
    }

    /**
     * @param Request $request
     * @return array
     */
    public function registerStore(Request $request)
    {
        try {
            $request->validate(
                [
                    'fullname' => 'required',
                    'email' => 'required|email',
                    'password' => 'required'
                ],
                [
                    'fullname.required' => 'İsim alanı zorunludur!',
                    'email.required' => 'E-Posta alanı zorunludur!',
                    'email.email' => 'E-Posta gerçek bir e-posta olmalıdır!',
                    'password.required' => 'Şifre zorunludur!',
                ]
            );
        } catch (ValidationException $exception) {
            return [
                'status' => false,
                'msg' => $exception->getMessage()
            ];
        }

        $user = User::whereEmail($request->input('email'))->first();
        if ($user) {
            return [
                'status' => false,
                'msg' => 'Bu e-posta adresi kullanılıyor!'
            ];
        }

        try {
            $user = User::create([
                'name' => $request->input('fullname'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password'))
            ]);

            Auth::loginUsingId($user->id);

            [$userId, $token] = explode('|', $user->createToken('bearer')->plainTextToken);
        } catch (\Throwable $exception) {
            return [
                'status' => false,
                'msg' => 'Kayıt olma işleminde kritik bir sorun oluştu!'
            ];
        }

        return [
            'status' => true,
            'msg' => 'Kayıt işlemi başarıyla gerçekleşti',
            'user' => $user,
            'token' => $token
        ];
    }

    /**
     * @param Request $request
     * @return array
     */
    public function loginStore(Request $request)
    {
        try {
            $request->validate(
                [
                    'email' => 'required|email',
                    'password' => 'required'
                ],
                [
                    'email.required' => 'E-Posta alanı zorunludur!',
                    'email.email' => 'E-Posta gerçek bir e-posta olmalıdır!',
                    'password.required' => 'Şifre zorunludur!',
                ]
            );
        } catch (ValidationException $exception) {
            return [
                'status' => false,
                'msg' => $exception->getMessage()
            ];
        }

        $user = User::whereEmail($request->input('email'))->first();
        if (!$user) {
            return [
                'status' => false,
                'msg' => 'Bu e-posta adresine ait bir kullanıcı bulunamadı!'
            ];
        }

        try {
            if (!Hash::check($request->input('password'), $user->password)) {
                return [
                    'status' => false,
                    'msg' => 'Şifreniz hatalı.'
                ];
            }

            Auth::loginUsingId($user->id);
            [$userId, $token] = explode('|', $user->createToken('bearer')->plainTextToken);
        } catch (\Throwable $exception) {
            return [
                'status' => false,
                'msg' => 'Giriş işleminde bir sorun oluştu!'
            ];
        }

        return [
            'status' => true,
            'msg' => 'Giriş işlemi başarıyla gerçekleşti',
            'user' => $user,
            'token' => $token
        ];
    }

    /**
     * @return RedirectResponse
     */
    public function logout()
    {
        Auth::logout();
        return redirect()->route('panel.auth.login');
    }
}
